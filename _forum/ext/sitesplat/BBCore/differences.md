Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\BBCore/acp/bbcore_module.php" "[FORUM_EXT]/sitesplat\\BBCore/acp/bbcore_module.php"
--- "[ORIGINAL]/sitesplat\\BBCore/acp/bbcore_module.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/acp/bbcore_module.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -9,356 +8,4 @@
 */
 
 namespace sitesplat\BBCore\acp;
-
-class bbcore_module
-{
-	var $u_action, $id;
-	protected $fs, $writable, $host, $path;
-	function main($id, $mode)
-	{
-		global $phpbb_container, $user, $template;
-		$this->id = $id;
-		$this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host');
-		$this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path');
-		$this->tpl_name = 'bbcore';
-		$this->page_title = 'BBCore';
-		$this->fs = \sitesplat\fs_instance();
-		$this->writable = $this->fs->init();
-		$user->add_lang_ext('sitesplat/BBCore', 'filesystem');
-		if ($mode == 'update') {
-			$this->update();
-		} else if ($mode == 'settings') {
-			$this->settings($this->fs_check());
-		} else {
-			$this->fs_check(true);
-		}
-		add_form_key('sitesplat/BBCore');
-		$template->assign_vars(['U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true,]);
-	}
-	function update()
-	{
-		global $request, $db, $template, $user;
-		$BBOOTS = '3.3.0';
-		$FLATBOOTS = '3.3.0';
-		$action = $request->variable('action', '');
-		if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) {
-			$this->autoupdate($action);
-		}
-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
-		$result = $db->sql_query($sql);
-		while ($row = $db->sql_fetchrow($result)) {
-			$ustyle_name = strtoupper($row['style_name']);
-			$cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . "/styles/$ustyle_name/style.cfg");
-			$data = $this->get_data($row['style_name']);
-			if (isset($data['version'])) {
-				$update = version_compare($cfg_ary['style_version'], $data['version'], '<');
-				$auto_update = version_compare($cfg_ary['style_version'], ${$ustyle_name}, '>=');
-				$template->assign_block_vars('sitesplat_themes', array('NAME' => $ustyle_name, 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false,));
-			}
-		}
-		$db->sql_freeresult($result);
-	}
-	function settings($ftpuser)
-	{
-		global $auth, $cache, $user, $request, $config, $template, $db;
-		$ftpport = $ftperror = $msg = $addon_msg = '';
-		if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) {
-			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
-		}
-		if ($request->is_set_post('addonsave')) {
-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']);
-			if (!$addon_error) {
-				trigger_error($addon_msg . adm_back_link($this->u_action));
-			}
-		} else if ($request->is_set_post('optsave')) {
-			$config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0));
-			$config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0));
-			trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action));
-		} else if ($request->is_set_post('ftpsave')) {
-			$ftpdata = $request->variable('ftpdata', array('' => ''), true);
-			$ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host'];
-			$ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port'];
-			$ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user'];
-			$ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass'];
-			$ftpssl = empty($ftpdata['ssl']) ? 0 : 1;
-			if ($ftpssl) {
-				$conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60);
-			} else {
-				$conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60);
-			}
-			if (!$conn) {
-				$ftperror = $user->lang['FTP_BAD_HOST'];
-			} else {
-				if (!@ftp_login($conn, $ftpuser, $ftppass)) {
-					$ftperror = $user->lang['FTP_BAD_USER'];
-				} else if (!$ftproot = $this->find_ftproot($conn)) {
-					$ftperror = $user->lang['FTP_NO_PATH'];
-				} else if (!@ftp_chdir($conn, $ftproot)) {
-					$ftperror = $user->lang['FTP_BAD_PATH'];
-				} else {
-					$config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost, $ftpport, $ftproot, $ftpuser, $ftppass, $ftpssl], 320))));
-					trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action));
-				}
-				@ftp_quit($conn);
-			}
-			$msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS'];
-		}
-		if (!$ftpport && !empty($config['dd_fs'])) {
-			$ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true);
-			$ftphost = $ftpdata[0];
-			$ftpport = $ftpdata[1];
-			$ftpuser = $ftpdata[3];
-			$ftppass = $ftpdata[4];
-			$ftpssl = $ftpdata[5];
-		} else if (!$ftpport) {
-			$ftphost = '';
-			$ftpport = 21;
-			$ftppass = '';
-			$ftpssl = 0;
-		}
-		$okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct';
-		list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]);
-		$template->assign_vars(['S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg,]);
-	}
-	private function find_ftproot($conn)
-	{
-		@ftp_pasv($conn, true);
-		@ftp_delete($conn, 'ftptest.dd');
-		if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) {
-			return false;
-		}
-		$s = DIRECTORY_SEPARATOR;
-		$phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true);
-		$rpath = $this->find_ftptest($phpbb, $s);
-		@ftp_delete($conn, 'ftptest.dd');
-		if (!$rpath) {
-			return false;
-		}
-		return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath)));
-	}
-	private function find_ftptest($fdir, $s)
-	{
-		if (file_exists("{$fdir}{$s}ftptest.dd")) {
-			return $fdir;
-		}
-		$newdir = dirname($fdir);
-		if ($fdir == $newdir) {
-			return false;
-		}
-		return $this->find_ftptest($newdir, $s);
-	}
-	public function fs_check($tpl = false)
-	{
-		global $db, $user, $template, $request;
-		$userowner = $baduserowner = $sysinfo = $ownermsg = '';
-		if ($request->is_set_post('dash_submit')) {
-			if (!check_form_key('sitesplat/BBCore')) {
-				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
-			}
-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']);
-			if (!$addon_error) {
-				trigger_error($addon_msg . adm_back_link($this->u_action));
-			}
-			$template->assign_var('BBCORE_DASH_ERROR', $addon_msg);
-		}
-		$opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux';
-		$sapi = php_sapi_name();
-		$cgi = strpos(strtolower($sapi), 'cgi') !== false;
-		if ($tpl) {
-			if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) {
-				$cpuinfo = (string) @file_get_contents('/proc/cpuinfo');
-				preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match);
-				if (!empty($match[1])) {
-					$numcores = count($match[1]);
-					$numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)";
-					$sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />";
-				}
-			}
-			$request->enable_super_globals();
-			$web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}";
-			$sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)";
-		}
-		$find_ary = [];
-		$dis = trim(ini_get('disable_functions'));
-		if ($dis) {
-			$dis = array_map('trim', explode(',', $dis));
-			if ($opsys == 'Windows' || $cgi) {
-				$find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']);
-			}
-		}
-		$okexec = function_exists('shell_exec');
-		$okshell = !count($find_ary) && $okexec;
-		if ($opsys == 'Linux') {
-			if (!extension_loaded('posix')) {
-				$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
-			} else if (is_array($dis)) {
-				$find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']);
-				if (count($find_ary2)) {
-					$ownermsg = "\t";
-					$find_ary = array_merge($find_ary, $find_ary2);
-				}
-			}
-		} else {
-			$ownermsg = "\t";
-		}
-		if (!$ownermsg) {
-			$owner = @fileowner(__DIR__);
-			if ($owner !== false) {
-				$userowner = posix_getpwuid($owner);
-				if (!empty($userowner['name'])) {
-					$userowner = $userowner['name'];
-					$baduserowner = ($owner < 500 || in_array($userowner, ['apache', 'www-data', 'nginx', 'nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : '';
-					$owner = posix_getuid();
-					$userphp = posix_getpwuid($owner);
-					$userphp = $userphp['name'];
-					$ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp);
-				} else {
-					$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
-				}
-			}
-		}
-		if ($tpl) {
-			if ($opsys == 'Linux' && $okshell) {
-				$mem = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`));
-				if (count($mem) == 2) {
-					list($mem_avail, $mem_used) = $mem;
-					$mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail / 1000 . 'GB';
-					$mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used / 1000 . 'GB';
-					$sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used);
-				}
-			}
-			$basedir = @ini_get('open_basedir');
-			if ($basedir) {
-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir);
-			}
-			if (!in_array('shell_exec', $find_ary) && !$okexec) {
-				$sysinfo .= '<br /><br />' . $user->lang['BBCORE_BAD_PHP'];
-			}
-			$not_installed = $user->lang['PHP_EXT_MISSING'];
-			$messages = [];
-			if (!extension_loaded('curl')) {
-				$messages[] = sprintf($not_installed, 'curl');
-			}
-			if (!extension_loaded('mbstring')) {
-				$messages[] = sprintf($not_installed, 'mbstring');
-			}
-			if (!extension_loaded('zip')) {
-				$messages[] = sprintf($not_installed, 'zip');
-			}
-			if (!extension_loaded('exif')) {
-				$messages[] = sprintf($not_installed, 'exif');
-			}
-			if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) {
-				$messages[] = sprintf($not_installed, 'sodium');
-			}
-			if (count($messages)) {
-				$sysinfo .= '<br /><br />' . implode('<br />', $messages);
-			}
-			if (count($find_ary)) {
-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary));
-			}
-			$badmsg = '';
-			if (!$this->writable) {
-				if ($opsys == 'Windows') {
-					$badmsg = $user->lang['FS_BAD_WINDOWS'];
-				} else if ($cgi) {
-					$badmsg = $user->lang['FS_BAD_CGI'];
-				} else if (!extension_loaded('zlib')) {
-					$badmsg = sprintf($not_installed, 'zlib');
-				} else if (!extension_loaded('ftp')) {
-					$badmsg = sprintf($not_installed, 'ftp');
-				} else {
-					$badmsg = $user->lang['FS_BAD_CREDS'];
-				}
-				$badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}";
-			}
-			$founders = [];
-			if ($user->data['user_type'] == USER_FOUNDER) {
-				$result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER);
-				while ($row = $db->sql_fetchrow($result)) {
-					$founders[] = $row['username'];
-				}
-				$db->sql_freeresult($result);
-			}
-			$template->assign_vars(['BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''),]);
-		} else {
-			return ($userowner && !$baduserowner) ? $userowner : '';
-		}
-	}
-	protected function check_dat($dis, $fn_ary)
-	{
-		$find_ary = [];
-		foreach ($dis as $dat) {
-			if (in_array($dat, $fn_ary)) {
-				$find_ary[] = $dat;
-			}
-		}
-		return $find_ary;
-	}
-	protected function get_data($what = '')
-	{
-		global $cache, $phpbb_container;
-		$file_downloader = $phpbb_container->get('file_downloader');
-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
-		if (($info = $cache->get($cache_file)) === false) {
-			try {
-				$info = $file_downloader->get($this->host, $this->path, $what, 443);
-			} catch (\phpbb\exception\runtime_exception $exception) {
-				$info = '';
-			}
-			$info = json_decode($info, true);
-			if (!empty($info)) {
-				$json_sanitizer = function (&$value, $key) {
-					$type_cast_helper = new \phpbb\request\type_cast_helper();
-					$type_cast_helper->set_var($value, $value, gettype($value), true);
-				};
-				array_walk_recursive($info, $json_sanitizer);
-				$cache->put($cache_file, $info, 86400);
-			}
-		}
-		return $info;
-	}
-	public function autoupdate($action)
-	{
-		global $config, $request, $user, $cache, $auth, $db, $phpbb_container;
-		$config_text = $phpbb_container->get('config_text');
-		if ($action === 'autoupdate_confirm') {
-			$config_text->set('sitesplat_bbcore_updater', '');
-			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields(['id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate',]));
-		}
-		if ($action !== 'autoupdate') {
-			return;
-		}
-		if ($request->is_set('cancel')) {
-			redirect($this->u_action);
-		}
-		$style_name = $request->variable('style', '');
-		if (empty($style_name)) {
-			trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING);
-		}
-		$config->set('board_disable', true);
-		$finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name);
-		if ($finished === true) {
-			$config->increment('assets_version', 1);
-			$cache->purge();
-			$phpbb_container->get('text_formatter.s9e.factory')->tidy();
-			$auth->acl_clear_prefetch();
-			phpbb_cache_moderators($db, $cache, $auth);
-			$config->set('board_disable', false);
-			trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action));
-		} else {
-			if ($finished === false) {
-				if ($request->is_ajax()) {
-					$sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true);
-					$response = new \phpbb\json_response;
-					$response->send(['continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'],]);
-				} else {
-					meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name);
-					trigger_error('UPDATE_IN_PROGRESS');
-				}
-			} else {
-				trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING);
-			}
-		}
-	}
-}
+class bbcore_module { var $u_action, $id; protected $fs, $writable, $host, $path; function main($id, $mode) { global $phpbb_container, $user, $template; $this->id = $id; $this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host'); $this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path'); $this->tpl_name = 'bbcore'; $this->page_title = 'BBCore'; $this->fs = \sitesplat\fs_instance(); $this->writable = $this->fs->init(); $user->add_lang_ext('sitesplat/BBCore', 'filesystem'); if ($mode == 'update') { $this->update(); } else if ($mode == 'settings') { $this->settings($this->fs_check()); } else { $this->fs_check(true); } add_form_key('sitesplat/BBCore'); $template->assign_vars([ 'U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true, ]); } function update() { global $request, $db, $template, $user; $action = $request->variable('action', ''); if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) { $this->autoupdate($action); } $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . '/styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version'])) { $update = version_compare($cfg_ary['style_version'], $data['version'] , '<'); $template->assign_block_vars('sitesplat_themes', array( 'NAME' => strtoupper($row['style_name']), 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false, )); } } $db->sql_freeresult($result); } function settings($ftpuser) { global $auth, $cache, $user, $request, $config, $template, $db; $ftpport = $ftperror = $msg = $addon_msg = ''; if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } if ($request->is_set_post('addonsave')) { list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } } else if ($request->is_set_post('optsave')) { $config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0)); $config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0)); trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action)); } else if ($request->is_set_post('ftpsave')) { $ftpdata = $request->variable('ftpdata', array('' => ''), true); $ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host']; $ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port']; $ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user']; $ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass']; $ftpssl = empty($ftpdata['ssl']) ? 0 : 1; if ($ftpssl) { $conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60); } else { $conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60); } if (!$conn) { $ftperror = $user->lang['FTP_BAD_HOST']; } else { if (!@ftp_login($conn, $ftpuser, $ftppass)) { $ftperror = $user->lang['FTP_BAD_USER']; } else if (!$ftproot = $this->find_ftproot($conn)) { $ftperror = $user->lang['FTP_NO_PATH']; } else if (!@ftp_chdir($conn, $ftproot)) { $ftperror = $user->lang['FTP_BAD_PATH']; } else { $config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost,$ftpport,$ftproot,$ftpuser,$ftppass,$ftpssl], 320)))); trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action)); } @ftp_quit($conn); } $msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS']; } if (!$ftpport && !empty($config['dd_fs'])) { $ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true); $ftphost = $ftpdata[0]; $ftpport = $ftpdata[1]; $ftpuser = $ftpdata[3]; $ftppass = $ftpdata[4]; $ftpssl = $ftpdata[5]; } else if (!$ftpport) { $ftphost = ''; $ftpport = 21; $ftppass = ''; $ftpssl = 0; } $okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct'; list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]); $template->assign_vars([ 'S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg, ]); } private function find_ftproot($conn) { @ftp_pasv($conn, true); @ftp_delete($conn, 'ftptest.dd'); if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) { return false; } $s = DIRECTORY_SEPARATOR; $phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true); $rpath = $this->find_ftptest($phpbb, $s); @ftp_delete($conn, 'ftptest.dd'); if (!$rpath) { return false; } return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath))); } private function find_ftptest($fdir, $s) { if (file_exists("{$fdir}{$s}ftptest.dd")) { return $fdir; } $newdir = dirname($fdir); if ($fdir == $newdir) { return false; } return $this->find_ftptest($newdir, $s); } public function fs_check($tpl = false) { global $db, $user, $template, $request; $userowner = $baduserowner = $sysinfo = $ownermsg = ''; if ($request->is_set_post('dash_submit')) { if (!check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } $template->assign_var('BBCORE_DASH_ERROR', $addon_msg); } $opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux'; $sapi = php_sapi_name(); $cgi = strpos(strtolower($sapi), 'cgi') !== false; if ($tpl) { if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) { $cpuinfo = (string) @file_get_contents('/proc/cpuinfo'); preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match); if (!empty($match[1])) { $numcores = count($match[1]); $numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)"; $sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />"; } } $request->enable_super_globals(); $web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}"; $sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)"; } $find_ary = []; $dis = trim(ini_get('disable_functions')); if ($dis) { $dis = array_map('trim', explode(',', $dis)); if ($opsys == 'Windows' || $cgi) { $find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']); } } $okshell = !count($find_ary); if ($opsys == 'Linux') { if (!extension_loaded('posix')) { $ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}"; } else if (is_array($dis)) { $find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']); if (count($find_ary2)) { $ownermsg = "\t"; $find_ary = array_merge($find_ary, $find_ary2); } } } else { $ownermsg = "\t"; } if (!$ownermsg) { $owner = @fileowner(__DIR__); if ($owner !== false) { $userowner = posix_getpwuid($owner)['name']; $baduserowner = ($owner < 500 || in_array($userowner, ['apache','www-data','nginx','nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : ''; $owner = posix_getuid(); $userphp = posix_getpwuid($owner)['name']; $ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp); } } if ($tpl) { if ($opsys == 'Linux' && $okshell) { list($mem_avail, $mem_used) = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`)); $mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail/1000 . 'GB'; $mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used/1000 . 'GB'; $sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used); } $basedir = @ini_get('open_basedir'); if ($basedir) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir); } $not_installed = $user->lang['PHP_EXT_MISSING']; $messages = []; if (!extension_loaded('curl')) { $messages[] = sprintf($not_installed, 'curl'); } if (!extension_loaded('mbstring')) { $messages[] = sprintf($not_installed, 'mbstring'); } if (!extension_loaded('zip')) { $messages[] = sprintf($not_installed, 'zip'); } if (!extension_loaded('exif')) { $messages[] = sprintf($not_installed, 'exif'); } if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) { $messages[] = sprintf($not_installed, 'sodium'); } if (count($messages)) { $sysinfo .= '<br /><br />' . implode('<br />', $messages); } if (count($find_ary)) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary)); } $badmsg = ''; if (!$this->writable) { if ($opsys == 'Windows') { $badmsg = $user->lang['FS_BAD_WINDOWS']; } else if ($cgi) { $badmsg = $user->lang['FS_BAD_CGI']; } else if (!extension_loaded('zlib')) { $badmsg = sprintf($not_installed, 'zlib'); } else if (!extension_loaded('ftp')) { $badmsg = sprintf($not_installed, 'ftp'); } else { $badmsg = $user->lang['FS_BAD_CREDS']; } $badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}"; } $founders = []; if ($user->data['user_type'] == USER_FOUNDER) { $result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER); while ($row = $db->sql_fetchrow($result)) { $founders[] = $row['username']; } $db->sql_freeresult($result); } $template->assign_vars([ 'BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''), ]); } else { return ($userowner && !$baduserowner) ? $userowner : ''; } } protected function check_dat($dis, $fn_ary) { $find_ary = []; foreach ($dis as $dat) { if (in_array($dat, $fn_ary)) { $find_ary[] = $dat; } } return $find_ary; } protected function get_data($what = '') { global $cache, $phpbb_container; $file_downloader = $phpbb_container->get('file_downloader'); $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $cache->get($cache_file)) === false) { try { $info = $file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $cache->put($cache_file, $info, 86400); } } return $info; } public function autoupdate($action) { global $config, $request, $user, $cache, $auth, $db, $phpbb_container; $config_text = $phpbb_container->get('config_text'); if ($action === 'autoupdate_confirm') { $config_text->set('sitesplat_bbcore_updater', ''); confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields([ 'id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate', ])); } if ($action !== 'autoupdate') { return; } if ($request->is_set('cancel')) { redirect($this->u_action); } $style_name = $request->variable('style', ''); if (empty($style_name)) { trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING); } $config->set('board_disable', true); $finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name); if ($finished === true) { $config->increment('assets_version', 1); $cache->purge(); $phpbb_container->get('text_formatter.s9e.factory')->tidy(); $auth->acl_clear_prefetch(); phpbb_cache_moderators($db, $cache, $auth); $config->set('board_disable', false); trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action)); } else { if ($finished === false) { if ($request->is_ajax()) { $sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true); $response = new \phpbb\json_response; $response->send([ 'continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'], ]); } else { meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name); trigger_error('UPDATE_IN_PROGRESS'); } } else { trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING); } } } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/composer.json" "[FORUM_EXT]/sitesplat\\BBCore/composer.json"
--- "[ORIGINAL]/sitesplat\\BBCore/composer.json"
+++ "[FORUM_EXT]/sitesplat\\BBCore/composer.json"
@@ -3,7 +3,7 @@
 	"type": "phpbb-extension",
 	"description": "The BBcore™© Adds Needed and Essential Functions into your phpBB® Instance in order to run SiteSplat Themes and also greatelay enhance the general forum experience",
 	"homepage": "https://sitesplat.com",
-	"version": "4.2.5",
+	"version": "4.2.2",
 	"keywords": ["phpbb", "extension", "bbcore", "bboots", "flatboots", "sitesplat", "envato", "themeforest", "cosmetic", "core"],
 	"license": "Proprietary/All rights reserved",
 	"authors": [
@@ -26,7 +26,7 @@
 		"version-check": {
             "host": "sitesplat.com",
             "directory": "/updatecheck/phpbb32/ext",
-            "filename": "bbcore-autoupdate.json",
+            "filename": "bbcore.json",
 			"ssl": true
 		}
 
diff --git "[FORUM_EXT]/sitesplat\\BBCore/diff_full.tmp" "[FORUM_EXT]/sitesplat\\BBCore/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\BBCore/diff_full.tmp"
@@ -0,0 +1,5049 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+index ab4a9ba9d..bb6ecbbfb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+@@ -1,364 +1,11 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2020 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
++*
++* @package sitesplat BBcore
++* @copyright (c) 2020 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ 
+ namespace sitesplat\BBCore\acp;
+-
+-class bbcore_module
+-{
+-	var $u_action, $id;
+-	protected $fs, $writable, $host, $path;
+-	function main($id, $mode)
+-	{
+-		global $phpbb_container, $user, $template;
+-		$this->id = $id;
+-		$this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host');
+-		$this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path');
+-		$this->tpl_name = 'bbcore';
+-		$this->page_title = 'BBCore';
+-		$this->fs = \sitesplat\fs_instance();
+-		$this->writable = $this->fs->init();
+-		$user->add_lang_ext('sitesplat/BBCore', 'filesystem');
+-		if ($mode == 'update') {
+-			$this->update();
+-		} else if ($mode == 'settings') {
+-			$this->settings($this->fs_check());
+-		} else {
+-			$this->fs_check(true);
+-		}
+-		add_form_key('sitesplat/BBCore');
+-		$template->assign_vars(['U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true,]);
+-	}
+-	function update()
+-	{
+-		global $request, $db, $template, $user;
+-		$BBOOTS = '3.3.0';
+-		$FLATBOOTS = '3.3.0';
+-		$action = $request->variable('action', '');
+-		if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) {
+-			$this->autoupdate($action);
+-		}
+-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
+-		$result = $db->sql_query($sql);
+-		while ($row = $db->sql_fetchrow($result)) {
+-			$ustyle_name = strtoupper($row['style_name']);
+-			$cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . "/styles/$ustyle_name/style.cfg");
+-			$data = $this->get_data($row['style_name']);
+-			if (isset($data['version'])) {
+-				$update = version_compare($cfg_ary['style_version'], $data['version'], '<');
+-				$auto_update = version_compare($cfg_ary['style_version'], ${$ustyle_name}, '>=');
+-				$template->assign_block_vars('sitesplat_themes', array('NAME' => $ustyle_name, 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false,));
+-			}
+-		}
+-		$db->sql_freeresult($result);
+-	}
+-	function settings($ftpuser)
+-	{
+-		global $auth, $cache, $user, $request, $config, $template, $db;
+-		$ftpport = $ftperror = $msg = $addon_msg = '';
+-		if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) {
+-			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-		if ($request->is_set_post('addonsave')) {
+-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']);
+-			if (!$addon_error) {
+-				trigger_error($addon_msg . adm_back_link($this->u_action));
+-			}
+-		} else if ($request->is_set_post('optsave')) {
+-			$config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0));
+-			$config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0));
+-			trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action));
+-		} else if ($request->is_set_post('ftpsave')) {
+-			$ftpdata = $request->variable('ftpdata', array('' => ''), true);
+-			$ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host'];
+-			$ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port'];
+-			$ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user'];
+-			$ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass'];
+-			$ftpssl = empty($ftpdata['ssl']) ? 0 : 1;
+-			if ($ftpssl) {
+-				$conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60);
+-			} else {
+-				$conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60);
+-			}
+-			if (!$conn) {
+-				$ftperror = $user->lang['FTP_BAD_HOST'];
+-			} else {
+-				if (!@ftp_login($conn, $ftpuser, $ftppass)) {
+-					$ftperror = $user->lang['FTP_BAD_USER'];
+-				} else if (!$ftproot = $this->find_ftproot($conn)) {
+-					$ftperror = $user->lang['FTP_NO_PATH'];
+-				} else if (!@ftp_chdir($conn, $ftproot)) {
+-					$ftperror = $user->lang['FTP_BAD_PATH'];
+-				} else {
+-					$config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost, $ftpport, $ftproot, $ftpuser, $ftppass, $ftpssl], 320))));
+-					trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action));
+-				}
+-				@ftp_quit($conn);
+-			}
+-			$msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS'];
+-		}
+-		if (!$ftpport && !empty($config['dd_fs'])) {
+-			$ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true);
+-			$ftphost = $ftpdata[0];
+-			$ftpport = $ftpdata[1];
+-			$ftpuser = $ftpdata[3];
+-			$ftppass = $ftpdata[4];
+-			$ftpssl = $ftpdata[5];
+-		} else if (!$ftpport) {
+-			$ftphost = '';
+-			$ftpport = 21;
+-			$ftppass = '';
+-			$ftpssl = 0;
+-		}
+-		$okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct';
+-		list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]);
+-		$template->assign_vars(['S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg,]);
+-	}
+-	private function find_ftproot($conn)
+-	{
+-		@ftp_pasv($conn, true);
+-		@ftp_delete($conn, 'ftptest.dd');
+-		if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) {
+-			return false;
+-		}
+-		$s = DIRECTORY_SEPARATOR;
+-		$phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true);
+-		$rpath = $this->find_ftptest($phpbb, $s);
+-		@ftp_delete($conn, 'ftptest.dd');
+-		if (!$rpath) {
+-			return false;
+-		}
+-		return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath)));
+-	}
+-	private function find_ftptest($fdir, $s)
+-	{
+-		if (file_exists("{$fdir}{$s}ftptest.dd")) {
+-			return $fdir;
+-		}
+-		$newdir = dirname($fdir);
+-		if ($fdir == $newdir) {
+-			return false;
+-		}
+-		return $this->find_ftptest($newdir, $s);
+-	}
+-	public function fs_check($tpl = false)
+-	{
+-		global $db, $user, $template, $request;
+-		$userowner = $baduserowner = $sysinfo = $ownermsg = '';
+-		if ($request->is_set_post('dash_submit')) {
+-			if (!check_form_key('sitesplat/BBCore')) {
+-				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
+-			}
+-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']);
+-			if (!$addon_error) {
+-				trigger_error($addon_msg . adm_back_link($this->u_action));
+-			}
+-			$template->assign_var('BBCORE_DASH_ERROR', $addon_msg);
+-		}
+-		$opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux';
+-		$sapi = php_sapi_name();
+-		$cgi = strpos(strtolower($sapi), 'cgi') !== false;
+-		if ($tpl) {
+-			if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) {
+-				$cpuinfo = (string) @file_get_contents('/proc/cpuinfo');
+-				preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match);
+-				if (!empty($match[1])) {
+-					$numcores = count($match[1]);
+-					$numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)";
+-					$sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />";
+-				}
+-			}
+-			$request->enable_super_globals();
+-			$web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}";
+-			$sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)";
+-		}
+-		$find_ary = [];
+-		$dis = trim(ini_get('disable_functions'));
+-		if ($dis) {
+-			$dis = array_map('trim', explode(',', $dis));
+-			if ($opsys == 'Windows' || $cgi) {
+-				$find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']);
+-			}
+-		}
+-		$okexec = function_exists('shell_exec');
+-		$okshell = !count($find_ary) && $okexec;
+-		if ($opsys == 'Linux') {
+-			if (!extension_loaded('posix')) {
+-				$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
+-			} else if (is_array($dis)) {
+-				$find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']);
+-				if (count($find_ary2)) {
+-					$ownermsg = "\t";
+-					$find_ary = array_merge($find_ary, $find_ary2);
+-				}
+-			}
+-		} else {
+-			$ownermsg = "\t";
+-		}
+-		if (!$ownermsg) {
+-			$owner = @fileowner(__DIR__);
+-			if ($owner !== false) {
+-				$userowner = posix_getpwuid($owner);
+-				if (!empty($userowner['name'])) {
+-					$userowner = $userowner['name'];
+-					$baduserowner = ($owner < 500 || in_array($userowner, ['apache', 'www-data', 'nginx', 'nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : '';
+-					$owner = posix_getuid();
+-					$userphp = posix_getpwuid($owner);
+-					$userphp = $userphp['name'];
+-					$ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp);
+-				} else {
+-					$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
+-				}
+-			}
+-		}
+-		if ($tpl) {
+-			if ($opsys == 'Linux' && $okshell) {
+-				$mem = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`));
+-				if (count($mem) == 2) {
+-					list($mem_avail, $mem_used) = $mem;
+-					$mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail / 1000 . 'GB';
+-					$mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used / 1000 . 'GB';
+-					$sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used);
+-				}
+-			}
+-			$basedir = @ini_get('open_basedir');
+-			if ($basedir) {
+-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir);
+-			}
+-			if (!in_array('shell_exec', $find_ary) && !$okexec) {
+-				$sysinfo .= '<br /><br />' . $user->lang['BBCORE_BAD_PHP'];
+-			}
+-			$not_installed = $user->lang['PHP_EXT_MISSING'];
+-			$messages = [];
+-			if (!extension_loaded('curl')) {
+-				$messages[] = sprintf($not_installed, 'curl');
+-			}
+-			if (!extension_loaded('mbstring')) {
+-				$messages[] = sprintf($not_installed, 'mbstring');
+-			}
+-			if (!extension_loaded('zip')) {
+-				$messages[] = sprintf($not_installed, 'zip');
+-			}
+-			if (!extension_loaded('exif')) {
+-				$messages[] = sprintf($not_installed, 'exif');
+-			}
+-			if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) {
+-				$messages[] = sprintf($not_installed, 'sodium');
+-			}
+-			if (count($messages)) {
+-				$sysinfo .= '<br /><br />' . implode('<br />', $messages);
+-			}
+-			if (count($find_ary)) {
+-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary));
+-			}
+-			$badmsg = '';
+-			if (!$this->writable) {
+-				if ($opsys == 'Windows') {
+-					$badmsg = $user->lang['FS_BAD_WINDOWS'];
+-				} else if ($cgi) {
+-					$badmsg = $user->lang['FS_BAD_CGI'];
+-				} else if (!extension_loaded('zlib')) {
+-					$badmsg = sprintf($not_installed, 'zlib');
+-				} else if (!extension_loaded('ftp')) {
+-					$badmsg = sprintf($not_installed, 'ftp');
+-				} else {
+-					$badmsg = $user->lang['FS_BAD_CREDS'];
+-				}
+-				$badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}";
+-			}
+-			$founders = [];
+-			if ($user->data['user_type'] == USER_FOUNDER) {
+-				$result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER);
+-				while ($row = $db->sql_fetchrow($result)) {
+-					$founders[] = $row['username'];
+-				}
+-				$db->sql_freeresult($result);
+-			}
+-			$template->assign_vars(['BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''),]);
+-		} else {
+-			return ($userowner && !$baduserowner) ? $userowner : '';
+-		}
+-	}
+-	protected function check_dat($dis, $fn_ary)
+-	{
+-		$find_ary = [];
+-		foreach ($dis as $dat) {
+-			if (in_array($dat, $fn_ary)) {
+-				$find_ary[] = $dat;
+-			}
+-		}
+-		return $find_ary;
+-	}
+-	protected function get_data($what = '')
+-	{
+-		global $cache, $phpbb_container;
+-		$file_downloader = $phpbb_container->get('file_downloader');
+-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
+-		if (($info = $cache->get($cache_file)) === false) {
+-			try {
+-				$info = $file_downloader->get($this->host, $this->path, $what, 443);
+-			} catch (\phpbb\exception\runtime_exception $exception) {
+-				$info = '';
+-			}
+-			$info = json_decode($info, true);
+-			if (!empty($info)) {
+-				$json_sanitizer = function (&$value, $key) {
+-					$type_cast_helper = new \phpbb\request\type_cast_helper();
+-					$type_cast_helper->set_var($value, $value, gettype($value), true);
+-				};
+-				array_walk_recursive($info, $json_sanitizer);
+-				$cache->put($cache_file, $info, 86400);
+-			}
+-		}
+-		return $info;
+-	}
+-	public function autoupdate($action)
+-	{
+-		global $config, $request, $user, $cache, $auth, $db, $phpbb_container;
+-		$config_text = $phpbb_container->get('config_text');
+-		if ($action === 'autoupdate_confirm') {
+-			$config_text->set('sitesplat_bbcore_updater', '');
+-			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields(['id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate',]));
+-		}
+-		if ($action !== 'autoupdate') {
+-			return;
+-		}
+-		if ($request->is_set('cancel')) {
+-			redirect($this->u_action);
+-		}
+-		$style_name = $request->variable('style', '');
+-		if (empty($style_name)) {
+-			trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-		$config->set('board_disable', true);
+-		$finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name);
+-		if ($finished === true) {
+-			$config->increment('assets_version', 1);
+-			$cache->purge();
+-			$phpbb_container->get('text_formatter.s9e.factory')->tidy();
+-			$auth->acl_clear_prefetch();
+-			phpbb_cache_moderators($db, $cache, $auth);
+-			$config->set('board_disable', false);
+-			trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action));
+-		} else {
+-			if ($finished === false) {
+-				if ($request->is_ajax()) {
+-					$sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true);
+-					$response = new \phpbb\json_response;
+-					$response->send(['continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'],]);
+-				} else {
+-					meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name);
+-					trigger_error('UPDATE_IN_PROGRESS');
+-				}
+-			} else {
+-				trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING);
+-			}
+-		}
+-	}
+-}
++class bbcore_module { var $u_action, $id; protected $fs, $writable, $host, $path; function main($id, $mode) { global $phpbb_container, $user, $template; $this->id = $id; $this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host'); $this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path'); $this->tpl_name = 'bbcore'; $this->page_title = 'BBCore'; $this->fs = \sitesplat\fs_instance(); $this->writable = $this->fs->init(); $user->add_lang_ext('sitesplat/BBCore', 'filesystem'); if ($mode == 'update') { $this->update(); } else if ($mode == 'settings') { $this->settings($this->fs_check()); } else { $this->fs_check(true); } add_form_key('sitesplat/BBCore'); $template->assign_vars([ 'U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true, ]); } function update() { global $request, $db, $template, $user; $action = $request->variable('action', ''); if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) { $this->autoupdate($action); } $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . '/styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version'])) { $update = version_compare($cfg_ary['style_version'], $data['version'] , '<'); $template->assign_block_vars('sitesplat_themes', array( 'NAME' => strtoupper($row['style_name']), 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false, )); } } $db->sql_freeresult($result); } function settings($ftpuser) { global $auth, $cache, $user, $request, $config, $template, $db; $ftpport = $ftperror = $msg = $addon_msg = ''; if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } if ($request->is_set_post('addonsave')) { list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } } else if ($request->is_set_post('optsave')) { $config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0)); $config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0)); trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action)); } else if ($request->is_set_post('ftpsave')) { $ftpdata = $request->variable('ftpdata', array('' => ''), true); $ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host']; $ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port']; $ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user']; $ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass']; $ftpssl = empty($ftpdata['ssl']) ? 0 : 1; if ($ftpssl) { $conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60); } else { $conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60); } if (!$conn) { $ftperror = $user->lang['FTP_BAD_HOST']; } else { if (!@ftp_login($conn, $ftpuser, $ftppass)) { $ftperror = $user->lang['FTP_BAD_USER']; } else if (!$ftproot = $this->find_ftproot($conn)) { $ftperror = $user->lang['FTP_NO_PATH']; } else if (!@ftp_chdir($conn, $ftproot)) { $ftperror = $user->lang['FTP_BAD_PATH']; } else { $config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost,$ftpport,$ftproot,$ftpuser,$ftppass,$ftpssl], 320)))); trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action)); } @ftp_quit($conn); } $msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS']; } if (!$ftpport && !empty($config['dd_fs'])) { $ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true); $ftphost = $ftpdata[0]; $ftpport = $ftpdata[1]; $ftpuser = $ftpdata[3]; $ftppass = $ftpdata[4]; $ftpssl = $ftpdata[5]; } else if (!$ftpport) { $ftphost = ''; $ftpport = 21; $ftppass = ''; $ftpssl = 0; } $okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct'; list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]); $template->assign_vars([ 'S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg, ]); } private function find_ftproot($conn) { @ftp_pasv($conn, true); @ftp_delete($conn, 'ftptest.dd'); if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) { return false; } $s = DIRECTORY_SEPARATOR; $phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true); $rpath = $this->find_ftptest($phpbb, $s); @ftp_delete($conn, 'ftptest.dd'); if (!$rpath) { return false; } return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath))); } private function find_ftptest($fdir, $s) { if (file_exists("{$fdir}{$s}ftptest.dd")) { return $fdir; } $newdir = dirname($fdir); if ($fdir == $newdir) { return false; } return $this->find_ftptest($newdir, $s); } public function fs_check($tpl = false) { global $db, $user, $template, $request; $userowner = $baduserowner = $sysinfo = $ownermsg = ''; if ($request->is_set_post('dash_submit')) { if (!check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } $template->assign_var('BBCORE_DASH_ERROR', $addon_msg); } $opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux'; $sapi = php_sapi_name(); $cgi = strpos(strtolower($sapi), 'cgi') !== false; if ($tpl) { if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) { $cpuinfo = (string) @file_get_contents('/proc/cpuinfo'); preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match); if (!empty($match[1])) { $numcores = count($match[1]); $numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)"; $sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />"; } } $request->enable_super_globals(); $web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}"; $sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)"; } $find_ary = []; $dis = trim(ini_get('disable_functions')); if ($dis) { $dis = array_map('trim', explode(',', $dis)); if ($opsys == 'Windows' || $cgi) { $find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']); } } $okshell = !count($find_ary); if ($opsys == 'Linux') { if (!extension_loaded('posix')) { $ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}"; } else if (is_array($dis)) { $find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']); if (count($find_ary2)) { $ownermsg = "\t"; $find_ary = array_merge($find_ary, $find_ary2); } } } else { $ownermsg = "\t"; } if (!$ownermsg) { $owner = @fileowner(__DIR__); if ($owner !== false) { $userowner = posix_getpwuid($owner)['name']; $baduserowner = ($owner < 500 || in_array($userowner, ['apache','www-data','nginx','nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : ''; $owner = posix_getuid(); $userphp = posix_getpwuid($owner)['name']; $ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp); } } if ($tpl) { if ($opsys == 'Linux' && $okshell) { list($mem_avail, $mem_used) = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`)); $mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail/1000 . 'GB'; $mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used/1000 . 'GB'; $sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used); } $basedir = @ini_get('open_basedir'); if ($basedir) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir); } $not_installed = $user->lang['PHP_EXT_MISSING']; $messages = []; if (!extension_loaded('curl')) { $messages[] = sprintf($not_installed, 'curl'); } if (!extension_loaded('mbstring')) { $messages[] = sprintf($not_installed, 'mbstring'); } if (!extension_loaded('zip')) { $messages[] = sprintf($not_installed, 'zip'); } if (!extension_loaded('exif')) { $messages[] = sprintf($not_installed, 'exif'); } if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) { $messages[] = sprintf($not_installed, 'sodium'); } if (count($messages)) { $sysinfo .= '<br /><br />' . implode('<br />', $messages); } if (count($find_ary)) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary)); } $badmsg = ''; if (!$this->writable) { if ($opsys == 'Windows') { $badmsg = $user->lang['FS_BAD_WINDOWS']; } else if ($cgi) { $badmsg = $user->lang['FS_BAD_CGI']; } else if (!extension_loaded('zlib')) { $badmsg = sprintf($not_installed, 'zlib'); } else if (!extension_loaded('ftp')) { $badmsg = sprintf($not_installed, 'ftp'); } else { $badmsg = $user->lang['FS_BAD_CREDS']; } $badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}"; } $founders = []; if ($user->data['user_type'] == USER_FOUNDER) { $result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER); while ($row = $db->sql_fetchrow($result)) { $founders[] = $row['username']; } $db->sql_freeresult($result); } $template->assign_vars([ 'BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''), ]); } else { return ($userowner && !$baduserowner) ? $userowner : ''; } } protected function check_dat($dis, $fn_ary) { $find_ary = []; foreach ($dis as $dat) { if (in_array($dat, $fn_ary)) { $find_ary[] = $dat; } } return $find_ary; } protected function get_data($what = '') { global $cache, $phpbb_container; $file_downloader = $phpbb_container->get('file_downloader'); $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $cache->get($cache_file)) === false) { try { $info = $file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $cache->put($cache_file, $info, 86400); } } return $info; } public function autoupdate($action) { global $config, $request, $user, $cache, $auth, $db, $phpbb_container; $config_text = $phpbb_container->get('config_text'); if ($action === 'autoupdate_confirm') { $config_text->set('sitesplat_bbcore_updater', ''); confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields([ 'id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate', ])); } if ($action !== 'autoupdate') { return; } if ($request->is_set('cancel')) { redirect($this->u_action); } $style_name = $request->variable('style', ''); if (empty($style_name)) { trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING); } $config->set('board_disable', true); $finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name); if ($finished === true) { $config->increment('assets_version', 1); $cache->purge(); $phpbb_container->get('text_formatter.s9e.factory')->tidy(); $auth->acl_clear_prefetch(); phpbb_cache_moderators($db, $cache, $auth); $config->set('board_disable', false); trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action)); } else { if ($finished === false) { if ($request->is_ajax()) { $sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true); $response = new \phpbb\json_response; $response->send([ 'continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'], ]); } else { meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name); trigger_error('UPDATE_IN_PROGRESS'); } } else { trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING); } } } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/composer.json"
+index 69e96c912..60f3391fb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "The BBcore™© Adds Needed and Essential Functions into your phpBB® Instance in order to run SiteSplat Themes and also greatelay enhance the general forum experience",
+ 	"homepage": "https://sitesplat.com",
+-	"version": "4.2.5",
++	"version": "4.2.2",
+ 	"keywords": ["phpbb", "extension", "bbcore", "bboots", "flatboots", "sitesplat", "envato", "themeforest", "cosmetic", "core"],
+ 	"license": "Proprietary/All rights reserved",
+ 	"authors": [
+@@ -26,7 +26,7 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbcore-autoupdate.json",
++            "filename": "bbcore.json",
+ 			"ssl": true
+ 		}
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp"
+new file mode 100644
+index 000000000..7191917df
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp"
+@@ -0,0 +1,376 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++index ab4a9ba9d..bb6ecbbfb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++@@ -1,364 +1,11 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2020 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2020 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ 
++ namespace sitesplat\BBCore\acp;
++-
++-class bbcore_module
++-{
++-	var $u_action, $id;
++-	protected $fs, $writable, $host, $path;
++-	function main($id, $mode)
++-	{
++-		global $phpbb_container, $user, $template;
++-		$this->id = $id;
++-		$this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host');
++-		$this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path');
++-		$this->tpl_name = 'bbcore';
++-		$this->page_title = 'BBCore';
++-		$this->fs = \sitesplat\fs_instance();
++-		$this->writable = $this->fs->init();
++-		$user->add_lang_ext('sitesplat/BBCore', 'filesystem');
++-		if ($mode == 'update') {
++-			$this->update();
++-		} else if ($mode == 'settings') {
++-			$this->settings($this->fs_check());
++-		} else {
++-			$this->fs_check(true);
++-		}
++-		add_form_key('sitesplat/BBCore');
++-		$template->assign_vars(['U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true,]);
++-	}
++-	function update()
++-	{
++-		global $request, $db, $template, $user;
++-		$BBOOTS = '3.3.0';
++-		$FLATBOOTS = '3.3.0';
++-		$action = $request->variable('action', '');
++-		if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) {
++-			$this->autoupdate($action);
++-		}
++-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
++-		$result = $db->sql_query($sql);
++-		while ($row = $db->sql_fetchrow($result)) {
++-			$ustyle_name = strtoupper($row['style_name']);
++-			$cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . "/styles/$ustyle_name/style.cfg");
++-			$data = $this->get_data($row['style_name']);
++-			if (isset($data['version'])) {
++-				$update = version_compare($cfg_ary['style_version'], $data['version'], '<');
++-				$auto_update = version_compare($cfg_ary['style_version'], ${$ustyle_name}, '>=');
++-				$template->assign_block_vars('sitesplat_themes', array('NAME' => $ustyle_name, 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false,));
++-			}
++-		}
++-		$db->sql_freeresult($result);
++-	}
++-	function settings($ftpuser)
++-	{
++-		global $auth, $cache, $user, $request, $config, $template, $db;
++-		$ftpport = $ftperror = $msg = $addon_msg = '';
++-		if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) {
++-			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
++-		}
++-		if ($request->is_set_post('addonsave')) {
++-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']);
++-			if (!$addon_error) {
++-				trigger_error($addon_msg . adm_back_link($this->u_action));
++-			}
++-		} else if ($request->is_set_post('optsave')) {
++-			$config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0));
++-			$config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0));
++-			trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action));
++-		} else if ($request->is_set_post('ftpsave')) {
++-			$ftpdata = $request->variable('ftpdata', array('' => ''), true);
++-			$ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host'];
++-			$ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port'];
++-			$ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user'];
++-			$ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass'];
++-			$ftpssl = empty($ftpdata['ssl']) ? 0 : 1;
++-			if ($ftpssl) {
++-				$conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60);
++-			} else {
++-				$conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60);
++-			}
++-			if (!$conn) {
++-				$ftperror = $user->lang['FTP_BAD_HOST'];
++-			} else {
++-				if (!@ftp_login($conn, $ftpuser, $ftppass)) {
++-					$ftperror = $user->lang['FTP_BAD_USER'];
++-				} else if (!$ftproot = $this->find_ftproot($conn)) {
++-					$ftperror = $user->lang['FTP_NO_PATH'];
++-				} else if (!@ftp_chdir($conn, $ftproot)) {
++-					$ftperror = $user->lang['FTP_BAD_PATH'];
++-				} else {
++-					$config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost, $ftpport, $ftproot, $ftpuser, $ftppass, $ftpssl], 320))));
++-					trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action));
++-				}
++-				@ftp_quit($conn);
++-			}
++-			$msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS'];
++-		}
++-		if (!$ftpport && !empty($config['dd_fs'])) {
++-			$ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true);
++-			$ftphost = $ftpdata[0];
++-			$ftpport = $ftpdata[1];
++-			$ftpuser = $ftpdata[3];
++-			$ftppass = $ftpdata[4];
++-			$ftpssl = $ftpdata[5];
++-		} else if (!$ftpport) {
++-			$ftphost = '';
++-			$ftpport = 21;
++-			$ftppass = '';
++-			$ftpssl = 0;
++-		}
++-		$okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct';
++-		list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]);
++-		$template->assign_vars(['S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg,]);
++-	}
++-	private function find_ftproot($conn)
++-	{
++-		@ftp_pasv($conn, true);
++-		@ftp_delete($conn, 'ftptest.dd');
++-		if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) {
++-			return false;
++-		}
++-		$s = DIRECTORY_SEPARATOR;
++-		$phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true);
++-		$rpath = $this->find_ftptest($phpbb, $s);
++-		@ftp_delete($conn, 'ftptest.dd');
++-		if (!$rpath) {
++-			return false;
++-		}
++-		return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath)));
++-	}
++-	private function find_ftptest($fdir, $s)
++-	{
++-		if (file_exists("{$fdir}{$s}ftptest.dd")) {
++-			return $fdir;
++-		}
++-		$newdir = dirname($fdir);
++-		if ($fdir == $newdir) {
++-			return false;
++-		}
++-		return $this->find_ftptest($newdir, $s);
++-	}
++-	public function fs_check($tpl = false)
++-	{
++-		global $db, $user, $template, $request;
++-		$userowner = $baduserowner = $sysinfo = $ownermsg = '';
++-		if ($request->is_set_post('dash_submit')) {
++-			if (!check_form_key('sitesplat/BBCore')) {
++-				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
++-			}
++-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']);
++-			if (!$addon_error) {
++-				trigger_error($addon_msg . adm_back_link($this->u_action));
++-			}
++-			$template->assign_var('BBCORE_DASH_ERROR', $addon_msg);
++-		}
++-		$opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux';
++-		$sapi = php_sapi_name();
++-		$cgi = strpos(strtolower($sapi), 'cgi') !== false;
++-		if ($tpl) {
++-			if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) {
++-				$cpuinfo = (string) @file_get_contents('/proc/cpuinfo');
++-				preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match);
++-				if (!empty($match[1])) {
++-					$numcores = count($match[1]);
++-					$numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)";
++-					$sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />";
++-				}
++-			}
++-			$request->enable_super_globals();
++-			$web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}";
++-			$sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)";
++-		}
++-		$find_ary = [];
++-		$dis = trim(ini_get('disable_functions'));
++-		if ($dis) {
++-			$dis = array_map('trim', explode(',', $dis));
++-			if ($opsys == 'Windows' || $cgi) {
++-				$find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']);
++-			}
++-		}
++-		$okexec = function_exists('shell_exec');
++-		$okshell = !count($find_ary) && $okexec;
++-		if ($opsys == 'Linux') {
++-			if (!extension_loaded('posix')) {
++-				$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
++-			} else if (is_array($dis)) {
++-				$find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']);
++-				if (count($find_ary2)) {
++-					$ownermsg = "\t";
++-					$find_ary = array_merge($find_ary, $find_ary2);
++-				}
++-			}
++-		} else {
++-			$ownermsg = "\t";
++-		}
++-		if (!$ownermsg) {
++-			$owner = @fileowner(__DIR__);
++-			if ($owner !== false) {
++-				$userowner = posix_getpwuid($owner);
++-				if (!empty($userowner['name'])) {
++-					$userowner = $userowner['name'];
++-					$baduserowner = ($owner < 500 || in_array($userowner, ['apache', 'www-data', 'nginx', 'nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : '';
++-					$owner = posix_getuid();
++-					$userphp = posix_getpwuid($owner);
++-					$userphp = $userphp['name'];
++-					$ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp);
++-				} else {
++-					$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
++-				}
++-			}
++-		}
++-		if ($tpl) {
++-			if ($opsys == 'Linux' && $okshell) {
++-				$mem = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`));
++-				if (count($mem) == 2) {
++-					list($mem_avail, $mem_used) = $mem;
++-					$mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail / 1000 . 'GB';
++-					$mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used / 1000 . 'GB';
++-					$sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used);
++-				}
++-			}
++-			$basedir = @ini_get('open_basedir');
++-			if ($basedir) {
++-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir);
++-			}
++-			if (!in_array('shell_exec', $find_ary) && !$okexec) {
++-				$sysinfo .= '<br /><br />' . $user->lang['BBCORE_BAD_PHP'];
++-			}
++-			$not_installed = $user->lang['PHP_EXT_MISSING'];
++-			$messages = [];
++-			if (!extension_loaded('curl')) {
++-				$messages[] = sprintf($not_installed, 'curl');
++-			}
++-			if (!extension_loaded('mbstring')) {
++-				$messages[] = sprintf($not_installed, 'mbstring');
++-			}
++-			if (!extension_loaded('zip')) {
++-				$messages[] = sprintf($not_installed, 'zip');
++-			}
++-			if (!extension_loaded('exif')) {
++-				$messages[] = sprintf($not_installed, 'exif');
++-			}
++-			if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) {
++-				$messages[] = sprintf($not_installed, 'sodium');
++-			}
++-			if (count($messages)) {
++-				$sysinfo .= '<br /><br />' . implode('<br />', $messages);
++-			}
++-			if (count($find_ary)) {
++-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary));
++-			}
++-			$badmsg = '';
++-			if (!$this->writable) {
++-				if ($opsys == 'Windows') {
++-					$badmsg = $user->lang['FS_BAD_WINDOWS'];
++-				} else if ($cgi) {
++-					$badmsg = $user->lang['FS_BAD_CGI'];
++-				} else if (!extension_loaded('zlib')) {
++-					$badmsg = sprintf($not_installed, 'zlib');
++-				} else if (!extension_loaded('ftp')) {
++-					$badmsg = sprintf($not_installed, 'ftp');
++-				} else {
++-					$badmsg = $user->lang['FS_BAD_CREDS'];
++-				}
++-				$badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}";
++-			}
++-			$founders = [];
++-			if ($user->data['user_type'] == USER_FOUNDER) {
++-				$result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER);
++-				while ($row = $db->sql_fetchrow($result)) {
++-					$founders[] = $row['username'];
++-				}
++-				$db->sql_freeresult($result);
++-			}
++-			$template->assign_vars(['BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''),]);
++-		} else {
++-			return ($userowner && !$baduserowner) ? $userowner : '';
++-		}
++-	}
++-	protected function check_dat($dis, $fn_ary)
++-	{
++-		$find_ary = [];
++-		foreach ($dis as $dat) {
++-			if (in_array($dat, $fn_ary)) {
++-				$find_ary[] = $dat;
++-			}
++-		}
++-		return $find_ary;
++-	}
++-	protected function get_data($what = '')
++-	{
++-		global $cache, $phpbb_container;
++-		$file_downloader = $phpbb_container->get('file_downloader');
++-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
++-		if (($info = $cache->get($cache_file)) === false) {
++-			try {
++-				$info = $file_downloader->get($this->host, $this->path, $what, 443);
++-			} catch (\phpbb\exception\runtime_exception $exception) {
++-				$info = '';
++-			}
++-			$info = json_decode($info, true);
++-			if (!empty($info)) {
++-				$json_sanitizer = function (&$value, $key) {
++-					$type_cast_helper = new \phpbb\request\type_cast_helper();
++-					$type_cast_helper->set_var($value, $value, gettype($value), true);
++-				};
++-				array_walk_recursive($info, $json_sanitizer);
++-				$cache->put($cache_file, $info, 86400);
++-			}
++-		}
++-		return $info;
++-	}
++-	public function autoupdate($action)
++-	{
++-		global $config, $request, $user, $cache, $auth, $db, $phpbb_container;
++-		$config_text = $phpbb_container->get('config_text');
++-		if ($action === 'autoupdate_confirm') {
++-			$config_text->set('sitesplat_bbcore_updater', '');
++-			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields(['id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate',]));
++-		}
++-		if ($action !== 'autoupdate') {
++-			return;
++-		}
++-		if ($request->is_set('cancel')) {
++-			redirect($this->u_action);
++-		}
++-		$style_name = $request->variable('style', '');
++-		if (empty($style_name)) {
++-			trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING);
++-		}
++-		$config->set('board_disable', true);
++-		$finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name);
++-		if ($finished === true) {
++-			$config->increment('assets_version', 1);
++-			$cache->purge();
++-			$phpbb_container->get('text_formatter.s9e.factory')->tidy();
++-			$auth->acl_clear_prefetch();
++-			phpbb_cache_moderators($db, $cache, $auth);
++-			$config->set('board_disable', false);
++-			trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action));
++-		} else {
++-			if ($finished === false) {
++-				if ($request->is_ajax()) {
++-					$sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true);
++-					$response = new \phpbb\json_response;
++-					$response->send(['continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'],]);
++-				} else {
++-					meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name);
++-					trigger_error('UPDATE_IN_PROGRESS');
++-				}
++-			} else {
++-				trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING);
++-			}
++-		}
++-	}
++-}
+++class bbcore_module { var $u_action, $id; protected $fs, $writable, $host, $path; function main($id, $mode) { global $phpbb_container, $user, $template; $this->id = $id; $this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host'); $this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path'); $this->tpl_name = 'bbcore'; $this->page_title = 'BBCore'; $this->fs = \sitesplat\fs_instance(); $this->writable = $this->fs->init(); $user->add_lang_ext('sitesplat/BBCore', 'filesystem'); if ($mode == 'update') { $this->update(); } else if ($mode == 'settings') { $this->settings($this->fs_check()); } else { $this->fs_check(true); } add_form_key('sitesplat/BBCore'); $template->assign_vars([ 'U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true, ]); } function update() { global $request, $db, $template, $user; $action = $request->variable('action', ''); if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) { $this->autoupdate($action); } $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . '/styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version'])) { $update = version_compare($cfg_ary['style_version'], $data['version'] , '<'); $template->assign_block_vars('sitesplat_themes', array( 'NAME' => strtoupper($row['style_name']), 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false, )); } } $db->sql_freeresult($result); } function settings($ftpuser) { global $auth, $cache, $user, $request, $config, $template, $db; $ftpport = $ftperror = $msg = $addon_msg = ''; if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } if ($request->is_set_post('addonsave')) { list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } } else if ($request->is_set_post('optsave')) { $config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0)); $config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0)); trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action)); } else if ($request->is_set_post('ftpsave')) { $ftpdata = $request->variable('ftpdata', array('' => ''), true); $ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host']; $ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port']; $ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user']; $ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass']; $ftpssl = empty($ftpdata['ssl']) ? 0 : 1; if ($ftpssl) { $conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60); } else { $conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60); } if (!$conn) { $ftperror = $user->lang['FTP_BAD_HOST']; } else { if (!@ftp_login($conn, $ftpuser, $ftppass)) { $ftperror = $user->lang['FTP_BAD_USER']; } else if (!$ftproot = $this->find_ftproot($conn)) { $ftperror = $user->lang['FTP_NO_PATH']; } else if (!@ftp_chdir($conn, $ftproot)) { $ftperror = $user->lang['FTP_BAD_PATH']; } else { $config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost,$ftpport,$ftproot,$ftpuser,$ftppass,$ftpssl], 320)))); trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action)); } @ftp_quit($conn); } $msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS']; } if (!$ftpport && !empty($config['dd_fs'])) { $ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true); $ftphost = $ftpdata[0]; $ftpport = $ftpdata[1]; $ftpuser = $ftpdata[3]; $ftppass = $ftpdata[4]; $ftpssl = $ftpdata[5]; } else if (!$ftpport) { $ftphost = ''; $ftpport = 21; $ftppass = ''; $ftpssl = 0; } $okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct'; list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]); $template->assign_vars([ 'S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg, ]); } private function find_ftproot($conn) { @ftp_pasv($conn, true); @ftp_delete($conn, 'ftptest.dd'); if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) { return false; } $s = DIRECTORY_SEPARATOR; $phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true); $rpath = $this->find_ftptest($phpbb, $s); @ftp_delete($conn, 'ftptest.dd'); if (!$rpath) { return false; } return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath))); } private function find_ftptest($fdir, $s) { if (file_exists("{$fdir}{$s}ftptest.dd")) { return $fdir; } $newdir = dirname($fdir); if ($fdir == $newdir) { return false; } return $this->find_ftptest($newdir, $s); } public function fs_check($tpl = false) { global $db, $user, $template, $request; $userowner = $baduserowner = $sysinfo = $ownermsg = ''; if ($request->is_set_post('dash_submit')) { if (!check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } $template->assign_var('BBCORE_DASH_ERROR', $addon_msg); } $opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux'; $sapi = php_sapi_name(); $cgi = strpos(strtolower($sapi), 'cgi') !== false; if ($tpl) { if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) { $cpuinfo = (string) @file_get_contents('/proc/cpuinfo'); preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match); if (!empty($match[1])) { $numcores = count($match[1]); $numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)"; $sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />"; } } $request->enable_super_globals(); $web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}"; $sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)"; } $find_ary = []; $dis = trim(ini_get('disable_functions')); if ($dis) { $dis = array_map('trim', explode(',', $dis)); if ($opsys == 'Windows' || $cgi) { $find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']); } } $okshell = !count($find_ary); if ($opsys == 'Linux') { if (!extension_loaded('posix')) { $ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}"; } else if (is_array($dis)) { $find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']); if (count($find_ary2)) { $ownermsg = "\t"; $find_ary = array_merge($find_ary, $find_ary2); } } } else { $ownermsg = "\t"; } if (!$ownermsg) { $owner = @fileowner(__DIR__); if ($owner !== false) { $userowner = posix_getpwuid($owner)['name']; $baduserowner = ($owner < 500 || in_array($userowner, ['apache','www-data','nginx','nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : ''; $owner = posix_getuid(); $userphp = posix_getpwuid($owner)['name']; $ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp); } } if ($tpl) { if ($opsys == 'Linux' && $okshell) { list($mem_avail, $mem_used) = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`)); $mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail/1000 . 'GB'; $mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used/1000 . 'GB'; $sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used); } $basedir = @ini_get('open_basedir'); if ($basedir) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir); } $not_installed = $user->lang['PHP_EXT_MISSING']; $messages = []; if (!extension_loaded('curl')) { $messages[] = sprintf($not_installed, 'curl'); } if (!extension_loaded('mbstring')) { $messages[] = sprintf($not_installed, 'mbstring'); } if (!extension_loaded('zip')) { $messages[] = sprintf($not_installed, 'zip'); } if (!extension_loaded('exif')) { $messages[] = sprintf($not_installed, 'exif'); } if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) { $messages[] = sprintf($not_installed, 'sodium'); } if (count($messages)) { $sysinfo .= '<br /><br />' . implode('<br />', $messages); } if (count($find_ary)) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary)); } $badmsg = ''; if (!$this->writable) { if ($opsys == 'Windows') { $badmsg = $user->lang['FS_BAD_WINDOWS']; } else if ($cgi) { $badmsg = $user->lang['FS_BAD_CGI']; } else if (!extension_loaded('zlib')) { $badmsg = sprintf($not_installed, 'zlib'); } else if (!extension_loaded('ftp')) { $badmsg = sprintf($not_installed, 'ftp'); } else { $badmsg = $user->lang['FS_BAD_CREDS']; } $badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}"; } $founders = []; if ($user->data['user_type'] == USER_FOUNDER) { $result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER); while ($row = $db->sql_fetchrow($result)) { $founders[] = $row['username']; } $db->sql_freeresult($result); } $template->assign_vars([ 'BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''), ]); } else { return ($userowner && !$baduserowner) ? $userowner : ''; } } protected function check_dat($dis, $fn_ary) { $find_ary = []; foreach ($dis as $dat) { if (in_array($dat, $fn_ary)) { $find_ary[] = $dat; } } return $find_ary; } protected function get_data($what = '') { global $cache, $phpbb_container; $file_downloader = $phpbb_container->get('file_downloader'); $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $cache->get($cache_file)) === false) { try { $info = $file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $cache->put($cache_file, $info, 86400); } } return $info; } public function autoupdate($action) { global $config, $request, $user, $cache, $auth, $db, $phpbb_container; $config_text = $phpbb_container->get('config_text'); if ($action === 'autoupdate_confirm') { $config_text->set('sitesplat_bbcore_updater', ''); confirm_b
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/admin_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/admin_listener.php"
+index 344675424..69010cf37 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/admin_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/admin_listener.php"
+@@ -1,114 +1,14 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2020 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
++*
++* @package sitesplat BBcore
++* @copyright (c) 2020 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ 
+ namespace sitesplat\BBCore\event;
+ 
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ use Symfony\Component\Finder\Finder;
+-
+-class admin_listener implements EventSubscriberInterface
+-{
+-	protected $db;
+-	protected $user;
+-	protected $template;
+-	protected $phpbb_extension_manager;
+-	protected $cache;
+-	protected $file_downloader;
+-	protected $request;
+-	protected $config;
+-	protected $config_text;
+-	protected $auth;
+-	protected $fs;
+-	protected $next_step_resolver;
+-	protected $text_formatter_cache;
+-	protected $phpbb_root_path;
+-	protected $php_ext;
+-	protected $host;
+-	protected $path;
+-	protected $writable = true;
+-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path)
+-	{
+-		$this->db = $db;
+-		$this->user = $user;
+-		$this->template = $template;
+-		$this->extension_manager = $phpbb_extension_manager;
+-		$this->cache = $cache;
+-		$this->file_downloader = $file_downloader;
+-		$this->request = $request;
+-		$this->config = $config;
+-		$this->config_text = $config_text;
+-		$this->auth = $auth;
+-		$this->fs = \sitesplat\fs_instance();
+-		$this->next_step_resolver = $next_step_resolver;
+-		$this->text_formatter_cache = $text_formatter_cache;
+-		$this->root_path = $phpbb_root_path;
+-		$this->php_ext = $php_ext;
+-		$this->host = $host;
+-		$this->path = $path;
+-	}
+-	static public function getSubscribedEvents()
+-	{
+-		$events = ['core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action',];
+-		return $events;
+-	}
+-	public function version_check($event, $eventName)
+-	{
+-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
+-		$result = $this->db->sql_query($sql);
+-		while ($row = $this->db->sql_fetchrow($result)) {
+-			$cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg');
+-			$data = $this->get_data($row['style_name']);
+-			if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'], '<')) {
+-				$this->template->assign_block_vars('sitesplat_themes', array('NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'],));
+-			}
+-		}
+-	}
+-	protected function get_data($what = '')
+-	{
+-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
+-		if (($info = $this->cache->get($cache_file)) === false) {
+-			try {
+-				$info = $this->file_downloader->get($this->host, $this->path, $what, 443);
+-			} catch (\phpbb\exception\runtime_exception $exception) {
+-				$info = '';
+-			}
+-			$info = json_decode($info, true);
+-			if (!empty($info)) {
+-				$json_sanitizer = function (&$value, $key) {
+-					$type_cast_helper = new \phpbb\request\type_cast_helper();
+-					$type_cast_helper->set_var($value, $value, gettype($value), true);
+-				};
+-				array_walk_recursive($info, $json_sanitizer);
+-				$this->cache->put($cache_file, $info, 86400);
+-			}
+-		}
+-		return $info;
+-	}
+-	public function run_action($event)
+-	{
+-		global $phpbb_dispatcher;
+-		$this->template->assign_vars(array('DISABLE_ALL' => $event['u_action'] . '&action=disable-all',));
+-		if ($event['action'] == 'disable-all') {
+-			$safe_time_limit = (ini_get('max_execution_time') / 2);
+-			$start_time = time();
+-			$enabled_extensions = $this->extension_manager->all_enabled();
+-			unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']);
+-			extract($phpbb_dispatcher->trigger_event('sitesplat.bbcore_ext_list', compact('enabled_extensions')));
+-			foreach ($enabled_extensions as $ext_name => $value) {
+-				while ($this->extension_manager->disable_step($ext_name)) {
+-					if ((time() - $start_time) >= $safe_time_limit) {
+-						meta_refresh(0, $event['u_action'] . '&amp;action=disable-all');
+-					}
+-				}
+-			}
+-			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($event['u_action']));
+-		}
+-	}
+-}
++class admin_listener implements EventSubscriberInterface { protected $db; protected $user; protected $template; protected $phpbb_extension_manager; protected $cache; protected $file_downloader; protected $request; protected $config; protected $config_text; protected $auth; protected $fs; protected $next_step_resolver; protected $text_formatter_cache; protected $phpbb_root_path; protected $php_ext; protected $host; protected $path; protected $writable = true; public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path) { $this->db = $db; $this->user = $user; $this->template = $template; $this->extension_manager = $phpbb_extension_manager; $this->cache = $cache; $this->file_downloader = $file_downloader; $this->request = $request; $this->config = $config; $this->config_text = $config_text; $this->auth = $auth; $this->fs = \sitesplat\fs_instance(); $this->next_step_resolver = $next_step_resolver; $this->text_formatter_cache = $text_formatter_cache; $this->root_path = $phpbb_root_path; $this->php_ext = $php_ext; $this->host = $host; $this->path = $path; } static public function getSubscribedEvents() { $events = [ 'core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action', ]; return $events; } public function version_check($event, $eventName) { $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $this->db->sql_query($sql); while ($row = $this->db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'] , '<')) { $this->template->assign_block_vars('sitesplat_themes', array( 'NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'], )); } } } protected function get_data($what = '') { $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $this->cache->get($cache_file)) === false) { try { $info = $this->file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $this->cache->put($cache_file, $info, 86400); } } return $info; } public function run_action($event) { $this->template->assign_vars(array( 'DISABLE_ALL' => $event['u_action'] . '&action=disable-all', )); if ($event['action'] == 'disable-all') { $safe_time_limit = (ini_get('max_execution_time') / 2); $start_time = time(); $enabled_extensions = $this->extension_manager->all_enabled(); unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']); foreach ($enabled_extensions as $ext_name => $value) { while ($this->extension_manager->disable_step($ext_name)) { if ((time() - $start_time) >= $safe_time_limit) { meta_refresh(0, $this->u_action . '&amp;action=disable-all'); } } } } } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/listener.php"
+index 714ef8e74..bb9d66904 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/listener.php"
+@@ -1,12 +1,11 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2020 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
++*
++* @package sitesplat BBcore
++* @copyright (c) 2020 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ 
+ namespace sitesplat\BBCore\event;
+ 
+@@ -14,187 +13,4 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ use Symfony\Component\HttpFoundation\Response;
+ use Symfony\Component\DependencyInjection\Container;
+ use phpbb\path_helper;
+-
+-class listener implements EventSubscriberInterface
+-{
+-	protected $cache;
+-	protected $config;
+-	protected $db;
+-	protected $user;
+-	protected $auth;
+-	protected $helper;
+-	protected $template;
+-	protected $phpbb_container;
+-	protected $phpbb_root_path;
+-	protected $php_ext;
+-	protected $fs;
+-	public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext, path_helper $path_helper)
+-	{
+-		$this->cache = $cache;
+-		$this->config = $config;
+-		$this->db = $db;
+-		$this->user = $user;
+-		$this->auth = $auth;
+-		$this->helper = $helper;
+-		$this->template = $template;
+-		$this->phpbb_container = $phpbb_container;
+-		$this->root_path = $phpbb_root_path;
+-		$this->path_helper = $path_helper;
+-		$this->php_ext = $php_ext;
+-		if (!defined('PHPBB_USE_BOARD_URL_PATH')) {
+-			define('PHPBB_USE_BOARD_URL_PATH', true);
+-		}
+-		require(dirname(__DIR__) . '/sitesplat.php');
+-		require(dirname(__DIR__) . '/filesystem.php');
+-		$this->fs = \sitesplat\fs_instance();
+-	}
+-	static public function getSubscribedEvents()
+-	{
+-		$listeners = array('core.common' => ['load_addon_data', 999], 'core.user_setup' => 'load_language_on_setup', 'core.page_header_after' => 'add_template_variables', 'core.page_footer_after' => 'disabled_board', 'core.index_modify_page_title' => 'statistics', 'core.ucp_display_module_before' => 'rewrite_zebra', 'core.viewtopic_assign_template_vars_before' => 'add_viewtopic_template_variables', 'core.memberlist_memberrow_before' => 'toggle_use_contact_fields', 'core.gen_sort_selects_after' => 'enhance_sort_selects', 'core.ucp_prefs_view_after' => 'enhance_ucp_prefs_selects', 'core.adm_page_header' => 'maybe_fix_ext',);
+-		if (version_compare(PHPBB_VERSION, '3.2.8', '>')) {
+-			$listeners += array('core.posting_modify_submission_errors' => 'revert_emojis',);
+-		}
+-		return $listeners;
+-	}
+-	public function revert_emojis($event)
+-	{
+-		if ($this->config['sitesplat_bbcore_emoji_revert']) {
+-			$post_data = $event['post_data'];
+-			$error = $event['error'];
+-			$post_data['post_subject'] = utf8_decode_ncr($post_data['post_subject']);
+-			if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $post_data['post_subject'], $matches)) {
+-				$character_list = implode('<br />', $matches[0]);
+-				$error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_SUBJECT', $character_list);
+-				$event['post_data'] = $post_data;
+-				$event['error'] = $error;
+-			}
+-		}
+-	}
+-	public function load_addon_data()
+-	{
+-		static $called;
+-		if (empty($called)) {
+-			if (($ss_addons = $this->cache->get('_sitesplat_addons')) === false) {
+-				$sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'sitesplat_addons'";
+-				$result = $this->db->sql_query($sql);
+-				$row = $this->db->sql_fetchrow($result);
+-				$this->db->sql_freeresult($result);
+-				if ($row) {
+-					$ss_addons = $row['config_value'];
+-					$this->cache->put('_sitesplat_addons', $ss_addons);
+-					unset($row);
+-				}
+-			}
+-			if (!empty($ss_addons)) {
+-				\sitesplat\addon::$addons = json_decode($ss_addons, true);
+-				unset($ss_addons);
+-			}
+-			\sitesplat\load_ext_addons('bbcore');
+-			$called = true;
+-		}
+-	}
+-	public function load_language_on_setup($event)
+-	{
+-		static $called;
+-		if (empty($called)) {
+-			$lang_set_ext = $event['lang_set_ext'];
+-			$lang_set_ext[] = array('ext_name' => 'sitesplat/BBCore', 'lang_set' => 'BBCore',);
+-			$event['lang_set_ext'] = $lang_set_ext;
+-			$called = true;
+-		}
+-	}
+-	public function maybe_fix_ext($event)
+-	{
+-		if (empty($this->config['bbcore_ext_fix'])) {
+-			$extfile = "{$this->fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
+-			$this->fs->init();
+-			if ($this->fs->fs_type && file_exists($extfile)) {
+-				$this->fs->put($extfile, str_replace('data-ajax', 'xdata-xajax', file_get_contents($extfile)));
+-				$this->config->set('bbcore_ext_fix', 'dd_fs');
+-			}
+-		}
+-	}
+-	public function disabled_board($event)
+-	{
+-		$style_id = ((!$this->config['override_user_style']) ? (int) $this->user->data['user_style'] : (int) $this->config['default_style']);
+-		$style_ary = [];
+-		$sql = 'SELECT style_id, style_path FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
+-		$result = $this->db->sql_query($sql);
+-		while ($row = $this->db->sql_fetchrow($result)) {
+-			$style_ary[intval($row['style_id'])] = $row['style_path'];
+-		}
+-		if ($this->config['board_disable'] && !defined('IN_LOGIN') && !empty($style_ary[$style_id]) && !$this->auth->acl_get('a_')) {
+-			$web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path();
+-			$user_lang = $this->user->lang['USER_LANG'];
+-			if (strpos($user_lang, '-x-') !== false) {
+-				$user_lang = substr($user_lang, 0, strpos($user_lang, '-x-'));
+-			}
+-			$file = $this->root_path . 'ext/sitesplat/BBCore/styles/' . $style_ary[$style_id] . '/template/offline_board_body.html';
+-			$fp = fopen($file, 'r');
+-			$content = fread($fp, filesize($file));
+-			fclose($fp);
+-			$match = array('#\{S_CONTENT_DIRECTION\}#', '#\{BODY_CLASS\}#', '#\{S_USER_LANG\}#', '#\{S_CONTENT_ENCODING\}#', '#\{SITENAME\}#', '#\{PAGE_TITLE\}#', '#\{T_STYLESHEET_LINK\}#', '#\{T_STYLESHEET_OFFLINE\}#', '#\{T_STYLESHEET_ANIMATE\}#', '#\{T_THEME_PATH\}#', '#\{SCRIPT_NAME\}#', '#\{L_BOARD_DISABLED\}#', '#\{ACP_DISABLE_MESSAGE\}#', '#\{L_LOGIN_LOGOUT\}#', '#\{U_LOGIN_LOGOUT\}#');
+-			$replace = array($this->user->lang['DIRECTION'], '', $user_lang, 'UTF-8', $this->config['sitename'], $this->user->lang['WEBSITE'] . ' &#187; ' . $this->user->lang['OFFLINE'], "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'], "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/offline.css', "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/animate.css', "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme', str_replace('.' . $this->php_ext, '', $this->user->page['page_name']), $this->user->lang['BOARD_UNAVAILABLE'], $this->config['board_disable_msg'], $this->user->lang['LOGIN'], append_sid("{$this->phpbb_root_path}ucp.php", 'mode=login'));
+-			$content = preg_replace($match, $replace, $content);
+-			$response = new Response('Content', 200, array('content-type' => 'text/html'));
+-			$response->setContent($content);
+-			$response->send();
+-			garbage_collection();
+-			exit_handler();
+-		}
+-	}
+-	public function add_template_variables()
+-	{
+-		$this->template->assign_vars(array('USER_EMAIL_MENU' => $this->user->data['user_email'], 'BOARD_EMAIL' => $this->config['board_contact'], 'SITESPLAT_SEARCH_WEEK' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=7&amp;st=7'), 'SITESPLAT_SEARCH_LAST_DAY' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=1&amp;st=1'), 'U_UCP_PREFERENCE' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs'), 'U_UCP_PREFERENCE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs&amp;mode=personal'), 'U_UCP_PROFILE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=reg_details'), 'U_UCP_PROFILE_AVATAR' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=avatar'), 'U_UCP_ZEBRA_FRIENDS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=zebra&amp;mode=friends'), 'U_UCP_PM_INBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=inbox'), 'U_UCP_PM_OUTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=outbox'), 'U_UCP_PM_SENTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=sentbox'), 'PM_NEW_COUNT_BADGE' => $this->user->lang('PM_NEW_MSG_BUBBLE', (int) $this->user->data['user_new_privmsg']), 'PM_NEW_COUNT' => $this->user->lang('PM_NEW_MSG', (int) $this->user->data['user_new_privmsg']), 'PM_UNREAD_COUNT' => $this->user->lang('PM_UNREAD_MSG', (int) $this->user->data['user_unread_privmsg']),));
+-	}
+-	public function statistics($event)
+-	{
+-		$online_users = obtain_users_online(0, 'forum');
+-		$total_online_users = $online_users['total_online'];
+-		$this->template->assign_vars(array('SITESPLAT_RECORD_ONLINE' => ($this->config['record_online_users']) ? $this->config['record_online_users'] : '0', 'SITESPLAT_CURRENTLY_ONLINE' => (isset($total_online_users) && $total_online_users) ? $total_online_users : '0', 'SITESPLAT_TOTAL_POSTS' => ($this->config['num_posts']) ? $this->config['num_posts'] : '0', 'SITESPLAT_TOTAL_TOPICS' => ($this->config['num_topics']) ? $this->config['num_topics'] : '0', 'SITESPLAT_TOTAL_USERS' => ($this->config['num_users']) ? $this->config['num_users'] : '0', 'SITESPLAT_NEWEST_USER' => ($this->config['newest_user_id']) ? get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']) : '',));
+-	}
+-	public function rewrite_zebra($event)
+-	{
+-		$context = $this->phpbb_container->get('template_context');
+-		$tpldata = &$context->get_data_ref();
+-		if (isset($tpldata['friends_offline'])) {
+-			foreach ($tpldata['friends_offline'] as $index => &$postrow) {
+-				$user_id = $postrow['USER_ID'];
+-				$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
+-				$result = $this->db->sql_query($sql);
+-				$row = $this->db->sql_fetchrow($result);
+-				$postrow['AVATAR'] = phpbb_get_user_avatar($row);
+-			}
+-		}
+-		if (isset($tpldata['friends_online'])) {
+-			foreach ($tpldata['friends_online'] as $index => &$postrow) {
+-				$user_id = $postrow['USER_ID'];
+-				$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
+-				$result = $this->db->sql_query($sql);
+-				$row = $this->db->sql_fetchrow($result);
+-				$postrow['AVATAR'] = phpbb_get_user_avatar($row);
+-			}
+-		}
+-	}
+-	public function add_viewtopic_template_variables($event)
+-	{
+-		$this->template->assign_vars(array('BOOKMARK_CLASS' => ($this->user->data['is_registered'] && $this->config['allow_bookmarks'] && $event['topic_data']['bookmarked']) ? 'fa fa-star' : 'fa fa-star-o',));
+-	}
+-	public function toggle_use_contact_fields($event)
+-	{
+-		$event['use_contact_fields'] = true;
+-	}
+-	public function enhance_sort_selects($event)
+-	{
+-		$event['s_limit_days'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_limit_days']);
+-		$event['s_sort_key'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_key']);
+-		$event['s_sort_dir'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_dir']);
+-	}
+-	public function enhance_ucp_prefs_selects($event)
+-	{
+-		$_options = array('s_limit_topic_days', 's_sort_topic_key', 's_sort_topic_dir', 's_limit_post_days', 's_sort_post_key', 's_sort_post_dir');
+-		foreach ($_options as $sort_option) {
+-			$event[$sort_option] = str_replace('<select', '<select class="selectpicker" data-container="body"', $event[$sort_option]);
+-		}
+-	}
+-}
++define('PHPBB_USE_BOARD_URL_PATH', true); class listener implements EventSubscriberInterface { protected $cache; protected $config; protected $db; protected $user; protected $auth; protected $helper; protected $template; protected $phpbb_container; protected $phpbb_root_path; protected $php_ext; protected $fs; public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext, path_helper $path_helper) { $this->cache = $cache; $this->config = $config; $this->db = $db; $this->user = $user; $this->auth = $auth; $this->helper = $helper; $this->template = $template; $this->phpbb_container = $phpbb_container; $this->root_path = $phpbb_root_path; $this->path_helper = $path_helper; $this->php_ext = $php_ext; require(dirname(__DIR__) . '/sitesplat.php'); require(dirname(__DIR__) . '/filesystem.php'); $this->fs = \sitesplat\fs_instance(); } static public function getSubscribedEvents() { $listeners = array( 'core.common' => ['load_addon_data', 999], 'core.user_setup' => 'load_language_on_setup', 'core.page_header_after' => 'add_template_variables', 'core.page_footer_after' => 'disabled_board', 'core.index_modify_page_title' => 'statistics', 'core.ucp_display_module_before' => 'rewrite_zebra', 'core.viewtopic_assign_template_vars_before' => 'add_viewtopic_template_variables', 'core.memberlist_memberrow_before' => 'toggle_use_contact_fields', 'core.gen_sort_selects_after' => 'enhance_sort_selects', 'core.ucp_prefs_view_after' => 'enhance_ucp_prefs_selects', 'core.adm_page_header' => 'maybe_fix_ext', ); if (version_compare(PHPBB_VERSION, '3.2.8', '>')) { $listeners += array( 'core.posting_modify_submission_errors' => 'revert_emojis', ); } return $listeners; } public function revert_emojis($event) { if ($this->config['sitesplat_bbcore_emoji_revert']) { $post_data = $event['post_data']; $error = $event['error']; $post_data['post_subject'] = utf8_decode_ncr($post_data['post_subject']); if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $post_data['post_subject'], $matches)) { $character_list = implode('<br />', $matches[0]); $error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_SUBJECT', $character_list); $event['post_data'] = $post_data; $event['error'] = $error; } } } public function load_addon_data() { static $called; if (empty($called)) { if (($ss_addons = $this->cache->get('_sitesplat_addons')) === false) { $sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'sitesplat_addons'"; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $this->db->sql_freeresult($result); if ($row) { $ss_addons = $row['config_value']; $this->cache->put('_sitesplat_addons', $ss_addons); unset($row); } } if (!empty($ss_addons)) { \sitesplat\addon::$addons = json_decode($ss_addons, true); unset($ss_addons); } \sitesplat\load_ext_addons('bbcore'); $called = true; } } public function load_language_on_setup($event) { static $called; if (empty($called)) { $lang_set_ext = $event['lang_set_ext']; $lang_set_ext[] = array( 'ext_name' => 'sitesplat/BBCore', 'lang_set' => 'BBCore', ); $event['lang_set_ext'] = $lang_set_ext; $called = true; } } public function maybe_fix_ext($event) { if (empty($this->config['bbcore_ext_fix'])) { $extfile = "{$this->fs->phpbb_root_dir}/adm/style/acp_ext_actions.html"; $this->fs->init(); if ($this->fs->fs_type && file_exists($extfile)) { $this->fs->put($extfile, str_replace('data-ajax', 'xdata-xajax', file_get_contents($extfile))); $this->config->set('bbcore_ext_fix', 'dd_fs'); } } } public function disabled_board($event) { $style_id = ((!$this->config['override_user_style']) ? (int) $this->user->data['user_style'] : (int) $this->config['default_style']); $style_ary = []; $sql = 'SELECT style_id, style_path FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $this->db->sql_query($sql); while ($row = $this->db->sql_fetchrow($result)) { $style_ary[intval($row['style_id'])] = $row['style_path']; } if ($this->config['board_disable'] && !defined('IN_LOGIN') && !empty($style_ary[$style_id]) && !$this->auth->acl_get('a_')) { $web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path(); $user_lang = $this->user->lang['USER_LANG']; if (strpos($user_lang, '-x-') !== false) { $user_lang = substr($user_lang, 0, strpos($user_lang, '-x-')); } $file = $this->root_path . 'ext/sitesplat/BBCore/styles/' . $style_ary[$style_id] . '/template/offline_board_body.html'; $fp = fopen( $file , 'r' ); $content = fread( $fp , filesize($file) ); fclose( $fp ); $match = array('#\{S_CONTENT_DIRECTION\}#', '#\{BODY_CLASS\}#', '#\{S_USER_LANG\}#', '#\{S_CONTENT_ENCODING\}#', '#\{SITENAME\}#', '#\{PAGE_TITLE\}#', '#\{T_STYLESHEET_LINK\}#', '#\{T_STYLESHEET_OFFLINE\}#', '#\{T_STYLESHEET_ANIMATE\}#', '#\{T_THEME_PATH\}#', '#\{SCRIPT_NAME\}#', '#\{L_BOARD_DISABLED\}#', '#\{ACP_DISABLE_MESSAGE\}#', '#\{L_LOGIN_LOGOUT\}#', '#\{U_LOGIN_LOGOUT\}#'); $replace = array( $this->user->lang['DIRECTION'], '', $user_lang, 'UTF-8', $this->config['sitename'], $this->user->lang['WEBSITE']. ' &#187; ' . $this->user->lang['OFFLINE'], "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'], "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/offline.css', "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/animate.css', "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme', str_replace('.' . $this->php_ext, '', $this->user->page['page_name']), $this->user->lang['BOARD_UNAVAILABLE'], $this->config['board_disable_msg'], $this->user->lang['LOGIN'], append_sid("{$this->phpbb_root_path}ucp.php", 'mode=login') ); $content = preg_replace($match, $replace, $content); $response = new Response( 'Content', 200, array('content-type' => 'text/html') ); $response->setContent($content); $response->send(); garbage_collection(); exit_handler(); } } public function add_template_variables() { $this->template->assign_vars(array( 'USER_EMAIL_MENU' => $this->user->data['user_email'], 'BOARD_EMAIL' => $this->config['board_contact'], 'SITESPLAT_SEARCH_WEEK' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=7&amp;st=7'), 'SITESPLAT_SEARCH_LAST_DAY' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=1&amp;st=1'), 'U_UCP_PREFERENCE' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs'), 'U_UCP_PREFERENCE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs&amp;mode=personal'), 'U_UCP_PROFILE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=reg_details'), 'U_UCP_PROFILE_AVATAR' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=avatar'), 'U_UCP_ZEBRA_FRIENDS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=zebra&amp;mode=friends'), 'U_UCP_PM_INBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=inbox'), 'U_UCP_PM_OUTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=outbox'), 'U_UCP_PM_SENTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=sentbox'), 'PM_NEW_COUNT_BADGE'=> $this->user->lang('PM_NEW_MSG_BUBBLE', (int) $this->user->data['user_new_privmsg']), 'PM_NEW_COUNT' => $this->user->lang('PM_NEW_MSG', (int) $this->user->data['user_new_privmsg']), 'PM_UNREAD_COUNT' => $this->user->lang('PM_UNREAD_MSG', (int) $this->user->data['user_unread_privmsg']), )); } public function statistics($event) { $online_users = obtain_users_online(0, 'forum'); $total_online_users = $online_users['total_online']; $this->template->assign_vars(array( 'SITESPLAT_RECORD_ONLINE' => ($this->config['record_online_users']) ? $this->config['record_online_users'] : '0', 'SITESPLAT_CURRENTLY_ONLINE' => (isset($total_online_users) && $total_online_users) ? $total_online_users : '0', 'SITESPLAT_TOTAL_POSTS' => ($this->config['num_posts']) ? $this->config['num_posts'] : '0', 'SITESPLAT_TOTAL_TOPICS' => ($this->config['num_topics']) ? $this->config['num_topics'] : '0', 'SITESPLAT_TOTAL_USERS' => ($this->config['num_users']) ? $this->config['num_users'] : '0', 'SITESPLAT_NEWEST_USER' => ($this->config['newest_user_id']) ? get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']) : '', )); } public function rewrite_zebra($event) { $context = $this->phpbb_container->get('template_context'); $tpldata = &$context->get_data_ref(); if (isset($tpldata['friends_offline'])) { foreach ($tpldata['friends_offline'] as $index => &$postrow) { $user_id = $postrow['USER_ID']; $sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $postrow['AVATAR'] = phpbb_get_user_avatar($row); } } if (isset($tpldata['friends_online'])) { foreach ($tpldata['friends_online'] as $index => &$postrow) { $user_id = $postrow['USER_ID']; $sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $postrow['AVATAR'] = phpbb_get_user_avatar($row); } } } public function add_viewtopic_template_variables($event) { $this->template->assign_vars(array( 'BOOKMARK_CLASS' => ($this->user->data['is_registered'] && $this->config['allow_bookmarks'] && $event['topic_data']['bookmarked']) ? 'fa fa-star' : 'fa fa-star-o', )); } public function toggle_use_contact_fields($event) { $event['use_contact_fields'] = true; } public function enhance_sort_selects($event) { $event['s_limit_days'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_limit_days']); $event['s_sort_key'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_key']); $event['s_sort_dir'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_dir']); } public function enhance_ucp_prefs_selects($event) { $_options = array('s_limit_topic_days', 's_sort_topic_key', 's_sort_topic_dir', 's_limit_post_days', 's_sort_post_key', 's_sort_post_dir'); foreach ($_options as $sort_option) { $event[$sort_option] = str_replace('<select', '<select class="selectpicker" data-container="body"' , $event[$sort_option]); } } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/ext.php"
+index d945ebca3..63ecff30d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/ext.php"
+@@ -1,106 +1,11 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2020 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
++*
++* @package sitesplat BBcore
++* @copyright (c) 2020 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ 
+ namespace sitesplat\BBCore;
+-
+-class ext extends \phpbb\extension\base
+-{
+-	public function enable_step($whocares)
+-	{
+-		$db = $this->container->get('dbal.conn');
+-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'";
+-		$result = $db->sql_query($sql);
+-		$parent_id = (int) $db->sql_fetchfield('module_id');
+-		$db->sql_freeresult($result);
+-		if ($parent_id) {
+-			return false;
+-		}
+-		$module = $this->container->get('module.manager');
+-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat',];
+-		$module->update_module_data($data);
+-		$ss_id = $data['module_id'];
+-		$sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC";
+-		$result = $db->sql_query($sql);
+-		$tabs = [];
+-		while ($row = $db->sql_fetchrow($result)) {
+-			$tabs[] = $row['module_langname'];
+-		}
+-		$db->sql_freeresult($result);
+-		for ($move = 0; $move < count($tabs); $move++) {
+-			if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') {
+-				break;
+-			}
+-			$move++;
+-		}
+-		$module->move_module_by($data, 'acp', 'move_up', $move);
+-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore',];
+-		$module->update_module_data($data);
+-		$bb_id = $data['module_id'];
+-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT',];
+-		$module->update_module_data($data);
+-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
+-		$module->update_module_data($data);
+-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
+-		$module->update_module_data($data);
+-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
+-		$module->update_module_data($data);
+-		while (parent::enable_step($whocares));
+-		return false;
+-	}
+-	public function disable_step($whocares)
+-	{
+-		$extensions = $this->container->get('ext.manager')->all_enabled();
+-		foreach ($extensions as $key => $value) {
+-			if (strpos($value, 'sitesplat') === false) {
+-				unset($extensions[$key]);
+-			}
+-		}
+-		unset($extensions['sitesplat/BBCore']);
+-		if (sizeof($extensions)) {
+-			$user = $this->container->get('user');
+-			trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING);
+-		}
+-		$config = $this->container->get('config');
+-		if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) {
+-			$fs = $this->container->get('sitesplat.filesystem');
+-			$extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
+-			$fs->init();
+-			if ($fs->fs_type && file_exists($extfile)) {
+-				$fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile)));
+-				$config->delete('bbcore_ext_fix');
+-			}
+-		}
+-		$ids = [];
+-		$db = $this->container->get('dbal.conn');
+-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC";
+-		$result = $db->sql_query($sql);
+-		while ($row = $db->sql_fetchrow($result)) {
+-			$ids[] = (int) $row['module_id'];
+-		}
+-		$db->sql_freeresult($result);
+-		if (!count($ids)) {
+-			return false;
+-		}
+-		$module = $this->container->get('module.manager');
+-		foreach ($ids as $module_id) {
+-			try {
+-				$module->delete_module($module_id, 'acp');
+-			} catch (\phpbb\module\exception\module_exception $exception) {
+-			}
+-		}
+-		return false;
+-	}
+-	public function purge_step($whocares)
+-	{
+-		$this->container->get('config')->delete('dd_fs');
+-		while (parent::purge_step($whocares));
+-		return false;
+-	}
+-}
++class ext extends \phpbb\extension\base { public function enable_step($whocares) { $db = $this->container->get('dbal.conn'); $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'"; $result = $db->sql_query($sql); $parent_id = (int) $db->sql_fetchfield('module_id'); $db->sql_freeresult($result); if ($parent_id) { return false; } $module = $this->container->get('module.manager'); $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat', ]; $module->update_module_data($data); $ss_id = $data['module_id']; $sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC"; $result = $db->sql_query($sql); $tabs = []; while ($row = $db->sql_fetchrow($result)) { $tabs[] = $row['module_langname']; } $db->sql_freeresult($result); for ($move = 0; $move < count($tabs); $move++) { if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') { break; } $move++; } $module->move_module_by($data, 'acp', 'move_up', $move); $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore', ]; $module->update_module_data($data); $bb_id = $data['module_id']; $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); while (parent::enable_step($whocares)); return false; } public function disable_step($whocares) { $extensions = $this->container->get('ext.manager')->all_enabled(); foreach ($extensions as $key => $value) { if (strpos($value, 'sitesplat') === false) { unset($extensions[$key]); } } unset($extensions['sitesplat/BBCore']); if (sizeof($extensions)) { $user = $this->container->get('user'); trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING); } $config = $this->container->get('config'); if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) { $fs = $this->container->get('sitesplat.filesystem'); $extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html"; $fs->init(); if ($fs->fs_type && file_exists($extfile)) { $fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile))); $config->delete('bbcore_ext_fix'); } } $ids = []; $db = $this->container->get('dbal.conn'); $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $ids[] = (int) $row['module_id']; } $db->sql_freeresult($result); if (!count($ids)) { return false; } $module = $this->container->get('module.manager'); foreach ($ids as $module_id) { try { $module->delete_module($module_id, 'acp'); } catch (\phpbb\module\exception\module_exception $exception) { } } return false; } public function purge_step($whocares) { $this->container->get('config')->delete('dd_fs'); while (parent::purge_step($whocares)); return false; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/filesystem.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/filesystem.php"
+index b217b3d1b..5953f2b0d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/filesystem.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/filesystem.php"
+@@ -1,384 +1,8 @@
+ <?php
+-
+ /**
+  * SiteSplat Filesystem
+- * @copyright (c) 2023 Dion Designs. All rights reserved.
++ * @copyright (c) 2020 Dion Designs. All rights reserved.
+  * @license Proprietary
+  */
+-
+ namespace sitesplat;
+-
+-function fs_instance()
+-{
+-	static $fs;
+-	if (empty($fs)) {
+-		$fs = new \sitesplat\filesystem;
+-	}
+-	return $fs;
+-}
+-class filesystem
+-{
+-	public $phpbb_root_dir;
+-	public $fs_type = false;
+-	public $direct = false;
+-	public $ftp_error = '';
+-	protected $config, $root_ptr, $conn, $fs_root_dir, $oldhandler;
+-	function __construct()
+-	{
+-		global $phpbb_container;
+-		$this->oldhandler = set_error_handler([$this, 'ss_msghandler']);
+-		$s = DIRECTORY_SEPARATOR;
+-		$ss = "{$s}ext{$s}sitesplat";
+-		$this->phpbb_root_dir = strstr(__DIR__, $ss, true);
+-		$this->config = $phpbb_container->get('config');
+-		$this->root_ptr = strlen($this->phpbb_root_dir) + 1;
+-		$filesystem = $phpbb_container->get('filesystem');
+-		if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) {
+-			$this->direct = true;
+-			$this->fs_type = 'direct';
+-		}
+-	}
+-	function __destruct()
+-	{
+-		if ($this->fs_type == 'ftp') {
+-			$this->fs_type = false;
+-			@ftp_quit($this->conn);
+-		}
+-	}
+-	function ss_msghandler($errno, $msg_text, $errfile, $errline)
+-	{
+-		if (!(error_reporting() & $errno) && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE) {
+-			return true;
+-		}
+-		return empty($this->oldhandler) ? false : call_user_func($this->oldhandler, $errno, $msg_text, $errfile, $errline);
+-	}
+-	function init()
+-	{
+-		static $already_called;
+-		if (!isset($already_called)) {
+-			$already_called = true;
+-			if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) {
+-				$this->fs_type = 'ftp';
+-			}
+-		}
+-		return $this->fs_type;
+-	}
+-	function connect()
+-	{
+-		if (empty($this->config['dd_fs'])) {
+-			$this->ftp_error = 'FTP_NO_CONFIG_DATA';
+-			return false;
+-		}
+-		$fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true);
+-		if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) {
+-			$this->ftp_error = 'FTP_BAD_CONFIG_DATA';
+-			return false;
+-		}
+-		$this->fs_root_dir = $fs_data[2];
+-		if ($fs_data[5]) {
+-			$this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
+-		} else {
+-			$this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
+-		}
+-		if (!$this->conn) {
+-			$this->ftp_error = 'FTP_CANNOT_CONNECT';
+-			return false;
+-		}
+-		if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) {
+-			@ftp_quit($this->conn);
+-			$this->ftp_error = 'FTP_BAD_USERPASS';
+-			return false;
+-		}
+-		@ftp_pasv($this->conn, true);
+-		if (!@ftp_chdir($this->conn, $this->fs_root_dir)) {
+-			@ftp_quit($this->conn);
+-			$this->ftp_error = 'FTP_BAD_ROOTDIR';
+-			return false;
+-		}
+-		return true;
+-	}
+-	function mkdir($dir, $perms = 0755)
+-	{
+-		if (!$dir || $dir == '/') {
+-			return false;
+-		}
+-		if (substr($dir, -1, 1) == '/') {
+-			$dir = substr($dir, 0, -1);
+-		}
+-		if (strpos($dir, '/') === false) {
+-			return false;
+-		}
+-		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
+-		$reldir = substr(strrchr($dir, '/'), 1);
+-		if (file_exists($dir)) {
+-			return true;
+-		}
+-		if ($this->fs_type != 'ftp') {
+-			return @mkdir($dir, $perms);
+-		}
+-		if (!file_exists($parent)) {
+-			return false;
+-		}
+-		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
+-		@ftp_chdir($this->conn, $parent);
+-		if ($result = @ftp_mkdir($this->conn, $reldir)) {
+-			@ftp_chmod($this->conn, $perms, $reldir);
+-		}
+-		@ftp_chdir($this->conn, $this->fs_root_dir);
+-		return $result;
+-	}
+-	function rmdir($dir)
+-	{
+-		if (!$dir || $dir == '/') {
+-			return false;
+-		}
+-		if (substr($dir, -1, 1) == '/') {
+-			$dir = substr($dir, 0, -1);
+-		}
+-		if (strpos($dir, '/') === false) {
+-			return false;
+-		}
+-		if (!file_exists($dir)) {
+-			return true;
+-		}
+-		if ($this->fs_type != 'ftp') {
+-			return @rmdir($dir);
+-		}
+-		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
+-		$reldir = substr(strrchr($dir, '/'), 1);
+-		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
+-		@ftp_chdir($this->conn, $parent);
+-		$result = @ftp_rmdir($this->conn, $reldir);
+-		@ftp_chdir($this->conn, $this->fs_root_dir);
+-		return $result;
+-	}
+-	function rename($old_handle, $new_handle)
+-	{
+-		if (!file_exists($old_handle) || file_exists($new_handle)) {
+-			return false;
+-		}
+-		if ($this->fs_type != 'ftp') {
+-			return @rename($old_handle, $new_handle);
+-		}
+-		if (@is_dir($old_handle)) {
+-			if (substr($old_handle, -1, 1) == '/') {
+-				$old_handle = substr($old_handle, 0, -1);
+-			}
+-			if (substr($new_handle, -1, 1) == '/') {
+-				$new_handle = substr($new_handle, 0, -1);
+-			}
+-		}
+-		$old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/');
+-		$old_handle = substr($old_handle, $this->root_ptr);
+-		$new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/');
+-		$new_handle = substr($new_handle, $this->root_ptr);
+-		return @ftp_rename($this->conn, $old_handle, $new_handle);
+-	}
+-	function chdir($dir = '')
+-	{
+-		if ($this->fs_type != 'ftp') {
+-			return @chdir($dir);
+-		}
+-		if (!$dir || $dir == '.') {
+-			return true;
+-		}
+-		if ($dir != '/') {
+-			if (substr($dir, -1, 1) == '/') {
+-				$dir = substr($dir, 0, -1);
+-			}
+-			$dir = substr(realpath($dir), $this->root_ptr);
+-		}
+-		return @ftp_chdir($this->conn, $dir);
+-	}
+-	function chmod($file, $perms, $override = false)
+-	{
+-		if (!file_exists($file)) {
+-			return false;
+-		}
+-		if ($override || $this->fs_type != 'ftp') {
+-			return @chmod($file, $perms);
+-		}
+-		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
+-		$file = substr(realpath($file), $this->root_ptr);
+-		return @ftp_chmod($this->conn, $perms, $file);
+-	}
+-	function copy($from_file, $to_file, $delete_first = false)
+-	{
+-		if (!$this->fs_type || !file_exists($from_file)) {
+-			return false;
+-		}
+-		if ($delete_first) {
+-			$this->delete($to_file);
+-			clearstatcache();
+-		}
+-		if ($this->fs_type != 'ftp') {
+-			return @copy($from_file, $to_file);
+-		}
+-		$to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/');
+-		$to_file = substr($to_file, $this->root_ptr);
+-		$result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY);
+-		return $result;
+-	}
+-	function put($file, $string, $delete_first = false)
+-	{
+-		if (!$this->fs_type) {
+-			return false;
+-		}
+-		if ($delete_first) {
+-			$this->delete($file);
+-			clearstatcache();
+-		}
+-		if ($this->fs_type != 'ftp') {
+-			return @file_put_contents($file, $string);
+-		}
+-		$fullfile = $file;
+-		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
+-		$file = substr($file, $this->root_ptr);
+-		$handle = fopen('php://memory', 'r+');
+-		if ($string) {
+-			fwrite($handle, $string);
+-			rewind($handle);
+-		}
+-		$result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY);
+-		fclose($handle);
+-		clearstatcache();
+-		if ($result) {
+-			$result = @filesize(realpath($fullfile));
+-		} else if (!$string) {
+-			return 0;
+-		}
+-		return $result;
+-	}
+-	function delete($file)
+-	{
+-		if ($this->fs_type != 'ftp') {
+-			return @unlink($file);
+-		}
+-		$file = substr(realpath($file), $this->root_ptr);
+-		return @ftp_delete($this->conn, $file);
+-	}
+-	function cwd()
+-	{
+-		if ($this->fs_type != 'ftp') {
+-			return getcwd();
+-		}
+-		return @ftp_pwd($this->conn);
+-	}
+-	function rmrf($target, $delete_top_dir = true)
+-	{
+-		if (is_dir($target)) {
+-			$files = glob($target . DIRECTORY_SEPARATOR . "*");
+-			if (!empty($files)) {
+-				foreach ($files as $file) {
+-					$this->rmrf($file);
+-				}
+-			}
+-			if ($delete_top_dir) {
+-				$this->rmdir($target);
+-			}
+-		} else {
+-			$this->delete($target);
+-		}
+-	}
+-	function zip_extract($archive, $destdir)
+-	{
+-		global $user;
+-		if (!is_dir($destdir)) {
+-			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir);
+-			return false;
+-		}
+-		if (!defined('IN_ADMIN') || !$this->fs_type) {
+-			$this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE'];
+-			return false;
+-		}
+-		$fp = @fopen($archive, 'rb');
+-		if (!$fp) {
+-			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive);
+-			return false;
+-		}
+-		$dd_try = $topdir = false;
+-		rewind($fp);
+-		while (!feof($fp)) {
+-			$signature = fread($fp, 4);
+-			if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") {
+-				break;
+-			} else if ($signature == 'PK00') {
+-				continue;
+-			} else if ($signature == "\x50\x4b\x03\x04") {
+-				$data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26));
+-				$file_name = fread($fp, $data['name_len']);
+-				if ($data['extra_field']) {
+-					fread($fp, $data['extra_field']);
+-				}
+-				$target_filename = "{$destdir}/{$file_name}";
+-				if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) {
+-					$dirpath = $destdir;
+-					$folders = explode('/', $file_name);
+-					foreach ($folders as $folder) {
+-						$folder = trim($folder);
+-						if (empty($folder)) {
+-							continue;
+-						}
+-						$dirpath .= "/{$folder}";
+-						if (!is_dir($dirpath)) {
+-							if (!$this->mkdir($dirpath, 0777)) {
+-								$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
+-								return false;
+-							}
+-							$this->chmod($dirpath, 0755);
+-							if (!$topdir) {
+-								$topdir = $dirpath;
+-							}
+-						}
+-					}
+-					continue;
+-				} else if (strpos($file_name, '/')) {
+-					if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) {
+-						$dirpath = $destdir;
+-						$folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME));
+-						foreach ($folders as $folder) {
+-							$folder = trim($folder);
+-							if (empty($folder)) {
+-								continue;
+-							}
+-							$dirpath .= "/{$folder}";
+-							if (!is_dir($dirpath)) {
+-								if (!$this->mkdir($dirpath, 0777)) {
+-									$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
+-									return false;
+-								}
+-								$this->chmod($dirpath, 0755);
+-								if (!$topdir) {
+-									$topdir = $dirpath;
+-								}
+-							}
+-						}
+-					}
+-				}
+-				if (!$data['uc_size']) {
+-					$content = '';
+-				} else {
+-					$content = fread($fp, $data['c_size']);
+-				}
+-				if ($data['c_method'] == 0) {
+-					$this->put($target_filename, $content, true);
+-				} else if ($data['c_method'] == 8) {
+-					$this->put($target_filename, gzinflate($content, $data['uc_size']), true);
+-				} else {
+-					$this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD'];
+-					return false;
+-				}
+-			} else {
+-				if (!$dd_try) {
+-					$dd_try = true;
+-					fseek($fp, 8, SEEK_CUR);
+-					continue;
+-				}
+-				$this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER'];
+-				return false;
+-			}
+-			$dd_try = false;
+-		}
+-		return $topdir;
+-	}
+-}
++function fs_instance() { static $fs; if (empty($fs)) { $fs = new \sitesplat\filesystem; } return $fs; } class filesystem { public $phpbb_root_dir; public $fs_type = false; public $direct = false; public $ftp_error = ''; protected $config, $root_ptr, $conn, $fs_root_dir; function __construct() { global $phpbb_container; $s = DIRECTORY_SEPARATOR; $ss = "{$s}ext{$s}sitesplat"; $this->phpbb_root_dir = strstr(__DIR__, $ss, true); $this->config = $phpbb_container->get('config'); $this->root_ptr = strlen($this->phpbb_root_dir) + 1; $filesystem = $phpbb_container->get('filesystem'); if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) { $this->direct = true; $this->fs_type = 'direct'; } } function __destruct() { if ($this->fs_type == 'ftp') { $this->fs_type = false; @ftp_quit($this->conn); } } function init() { static $already_called; if (!isset($already_called)) { $already_called = true; if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) { $this->fs_type = 'ftp'; } } return $this->fs_type; } function connect() { if (empty($this->config['dd_fs'])) { $this->ftp_error = 'FTP_NO_CONFIG_DATA'; return false; } $fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true); if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) { $this->ftp_error = 'FTP_BAD_CONFIG_DATA'; return false; } $this->fs_root_dir = $fs_data[2]; if ($fs_data[5]) { $this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60); } else { $this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60); } if (!$this->conn) { $this->ftp_error = 'FTP_CANNOT_CONNECT'; return false; } if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) { @ftp_quit($this->conn); $this->ftp_error = 'FTP_BAD_USERPASS'; return false; } @ftp_pasv($this->conn, true); if (!@ftp_chdir($this->conn, $this->fs_root_dir)) { @ftp_quit($this->conn); $this->ftp_error = 'FTP_BAD_ROOTDIR'; return false; } return true; } function mkdir($dir, $perms = 0755) { if (!$dir || $dir == '/') { return false; } if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } if (strpos($dir, '/') === false) { return false; } $parent = substr($dir, 0, strrpos($dir, '/') + 1); $reldir = substr(strrchr($dir, '/'), 1); if (file_exists($dir)) { return true; } if ($this->fs_type != 'ftp') { return @mkdir($dir, $perms); } if (!file_exists($parent)) { return false; } $parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1); @ftp_chdir($this->conn, $parent); if ($result = @ftp_mkdir($this->conn, $reldir)) { @ftp_chmod($this->conn, $perms, $reldir); } @ftp_chdir($this->conn, $this->fs_root_dir); return $result; } function rmdir($dir) { if (!$dir || $dir == '/') { return false; } if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } if (strpos($dir, '/') === false) { return false; } if (!file_exists($dir)) { return true; } if ($this->fs_type != 'ftp') { return @rmdir($dir); } $parent = substr($dir, 0, strrpos($dir, '/') + 1); $reldir = substr(strrchr($dir, '/'), 1); $parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1); @ftp_chdir($this->conn, $parent); $result = @ftp_rmdir($this->conn, $reldir); @ftp_chdir($this->conn, $this->fs_root_dir); return $result; } function rename($old_handle, $new_handle) { if (!file_exists($old_handle) || file_exists($new_handle)) { return false; } if ($this->fs_type != 'ftp') { return @rename($old_handle, $new_handle); } if (@is_dir($old_handle)) { if (substr($old_handle, -1, 1) == '/') { $old_handle = substr($old_handle, 0, -1); } if (substr($new_handle, -1, 1) == '/') { $new_handle = substr($new_handle, 0, -1); } } $old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/'); $old_handle = substr($old_handle, $this->root_ptr); $new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/'); $new_handle = substr($new_handle, $this->root_ptr); return @ftp_rename($this->conn, $old_handle, $new_handle); } function chdir($dir = '') { if ($this->fs_type != 'ftp') { return @chdir($dir); } if (!$dir || $dir == '.') { return true; } if ($dir != '/') { if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } $dir = substr(realpath($dir), $this->root_ptr); } return @ftp_chdir($this->conn, $dir); } function chmod($file, $perms, $override = false) { if (!file_exists($file)) { return false; } if ($override || $this->fs_type != 'ftp') { return @chmod($file, $perms); } $file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/'); $file = substr(realpath($file), $this->root_ptr); return @ftp_chmod($this->conn, $perms, $file); } function copy($from_file, $to_file, $delete_first = false) { if (!$this->fs_type || !file_exists($from_file)) { return false; } if ($delete_first) { $this->delete($to_file); clearstatcache(); } if ($this->fs_type != 'ftp') { return @copy($from_file, $to_file); } $to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/'); $to_file = substr($to_file, $this->root_ptr); $result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY); return $result; } function put($file, $string, $delete_first = false) { if (!$this->fs_type) { return false; } if ($delete_first) { $this->delete($file); clearstatcache(); } if ($this->fs_type != 'ftp') { return @file_put_contents($file, $string); } $fullfile = $file; $file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/'); $file = substr($file, $this->root_ptr); $handle = fopen('php://memory', 'r+'); if ($string) { fwrite($handle, $string); rewind($handle); } $result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY); fclose($handle); clearstatcache(); if ($result) { $result = @filesize(realpath($fullfile)); } else if (!$string) { return 0; } return $result; } function delete($file) { if ($this->fs_type != 'ftp') { return @unlink($file); } $file = substr(realpath($file), $this->root_ptr); return @ftp_delete($this->conn, $file); } function cwd() { if ($this->fs_type != 'ftp') { return getcwd(); } return @ftp_pwd($this->conn); } function rmrf($target, $delete_top_dir = true) { if (is_dir($target)) { $files = glob($target . DIRECTORY_SEPARATOR . "*"); if (!empty($files)) { foreach($files as $file) { $this->rmrf($file); } } if ($delete_top_dir) { $this->rmdir($target); } } else { $this->delete($target); } } function zip_extract($archive, $destdir) { global $user; if (!is_dir($destdir)) { $this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir); return false; } if (!defined('IN_ADMIN') || !$this->fs_type) { $this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE']; return false; } $fp = @fopen($archive, 'rb'); if (!$fp) { $this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive); return false; } $dd_try = $topdir = false; rewind($fp); while (!feof($fp)) { $signature = fread($fp, 4); if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") { break; } else if ($signature == 'PK00') { continue; } else if ($signature == "\x50\x4b\x03\x04") { $data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26)); $file_name = fread($fp, $data['name_len']); if ($data['extra_field']) { fread($fp, $data['extra_field']); } $target_filename = "{$destdir}/{$file_name}"; if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) { $dirpath = $destdir; $folders = explode('/', $file_name); foreach ($folders as $folder) { $folder = trim($folder); if (empty($folder)) { continue; } $dirpath .= "/{$folder}"; if (!is_dir($dirpath)) { if (!$this->mkdir($dirpath, 0777)) { $this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath); return false; } $this->chmod($dirpath, 0755); if (!$topdir) { $topdir = $dirpath; } } } continue; } else if (strpos($file_name, '/')) { if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) { $dirpath = $destdir; $folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME)); foreach ($folders as $folder) { $folder = trim($folder); if (empty($folder)) { continue; } $dirpath .= "/{$folder}"; if (!is_dir($dirpath)) { if (!$this->mkdir($dirpath, 0777)) { $this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath); return false; } $this->chmod($dirpath, 0755); if (!$topdir) { $topdir = $dirpath; } } } } } if (!$data['uc_size']) { $content = ''; } else { $content = fread($fp, $data['c_size']); } if ($data['c_method'] == 0) { $this->put($target_filename, $content, true); } else if ($data['c_method'] == 8) { $this->put($target_filename, gzinflate($content, $data['uc_size']), true); } else { $this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD']; return false; } } else { if (!$dd_try) { $dd_try = true; fseek($fp, 8, SEEK_CUR); continue; } $this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER']; return false; } $dd_try = false; } return $topdir; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/BBCore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/BBCore.php"
+deleted file mode 100644
+index d2a8ac736..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/BBCore.php"
++++ /dev/null
+@@ -1,484 +0,0 @@
+-<?php
+-/**
+-*
+-* BBCore [German]
+-*
+-* @package sitesplat BBcore
+-* @copyright (c) 2015 SiteSplat All rights reserved
+-* @license Proprietary
+-*
+-*/
+-
+-// TRANSLATORS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB')) {
+-	exit;
+-}
+-if (empty($lang) || !is_array($lang)) {
+-	$lang = array();
+-}
+-
+-// load addon lang files first...allow BBCore to overwrite if needed
+-if (function_exists('\sitesplat\load_ext_lang')) {
+-    $addon_lang = [];
+-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
+-    $lang = array_merge($lang, $addon_lang);
+-}
+-
+-
+-// BBCore
+-$lang = array_merge($lang, array(
+-	'PM_NEW_MSG' => [
+-  
+-  
+-    1 => 'Du hast %d neue private Nachricht',
+-    2 => 'Du hast %d neue private Nachrichten',
+-  ],
+-  'PM_UNREAD_MSG' => [
+-  
+-  
+-    1 => 'Du hast %d ungelesene private Nachricht',
+-    2 => 'Du hast %d ungelesene private Nachrichten',
+-  ],
+-  'PM_NEW_MSG_BUBBLE' => [
+-    1 => '%d',
+-    2 => '%d',
+-  ],
+-  
+-
+-	'SITESPLAT_EXT'				=> 'Other Extensions',
+-	'BBCORE_DASHBOARD'			=> 'Dashboard',
+-	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
+-	'BBCORE_SETTINGS'			=> 'Settings',
+-	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
+-	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
+-	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
+-	'SS_CHATBOX'				=> 'Chat',
+-	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+-	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
+-
+-	'SS_ADDONS'				=> 'Addons',
+-	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+-	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
+-  
+-  'UCP_MAIN'                   => 'Übersicht',
+-  'UCP_MAIN_FRONT'             => 'Startseite',
+-  'UCP_MAIN_SUBSCRIPTION'      => 'Abonnements verwalten',
+-  'UCP_MAIN_BOOKMARKS'         => 'Lesezeichen verwalten',
+-  'UCP_MAIN_DRAFTS'            => 'Entwürfe verwalten',
+-  'UCP_MAIN_ATTACHMENTS'       => 'Anhänge verwalten',
+-  
+-  
+-  'USER_PANEL'                 => 'Verwaltungsbereich', 
+-  'UCP_PROFILE'                => 'Profil',   
+-  'UCP_PROFILE_PROFILE'        => 'Profil bearbeiten',   
+-  'UCP_PROFILE_SIGNITURE'      => 'Signatur bearbeiten',   
+-  'UCP_PROFILE_AVATAR'         => 'Avatar bearbeiten',   
+-  'UCP_PROFILE_SETTINGS'       => 'Kontoeinstellungen', 
+-  'UCP_AVATAR_SELECT_OPTIONS'    => 'Avatar Optionen', 
+-  'UCP_AVATAR_SELECT_UPLOAD'     => 'Avatar vom Computer hochladen',
+-  'UCP_SUBMIT_TO_UPLOAD'         => 'Hier unten bestätigen zum Hochladen',
+-  
+-  'UCP_PREFERENCE'             => 'Board Einstellungen',
+-  'UCP_PREFERENCE_SETTINGS'    => 'Globale Einstellungen bearbeiten',
+-  'UCP_PREFERENCE_DEFAULTS'    => 'Standard Beiträge bearbeiten',
+-  'UCP_PREFERENCE_OPTIONS'     => 'Anzeigeoptionen bearbeiten',
+-  
+-  'UCP_MESSAGES'               => 'Nachrichten',   
+-  'UCP_PM_COMPOSE'             => 'Nachricht erstellen',   
+-  
+-  'UCP_PM_DRAFTS'              => 'Entwürfe verwalten',   
+-  'UCP_PM_INBOX'               => 'Posteingang',   
+-  'UCP_PM_OUTBOX'              => 'Postausgang',   
+-  'UCP_PM_SENTBOX'             => 'Senden',   
+-  'UCP_PM_OPTIONS'             => 'Regeln, Ordner &amp; Einstellungen', 
+-  'UCP_NO_USER_CHANGE_ALLOWED'   => '**Wechsel des Nutzernamens ist nicht erlaubt**',
+-  'UCP_REGISTER_EMAIL_EXPLAIN'   => 'Bitte verwenden Sie keine Wegwerf-E-Mails',
+-  
+-  'WIDTH_SIZE'                 => 'Breite',   
+-  'PIXEL_SIZE'                 => 'px',   
+-  'HEIGHT_SIZE'                => 'Höhe', 
+-  
+-  
+-  'UCP_GROUPS'                 => 'Nutzergruppen',   
+-  'UCP_GROUPS_MEMBERSHIP'      => 'Mitgliedschaft bearbeiten',   
+-  'UCP_GROUPS_MANAGE'          => 'Manage groups',   
+-  
+-  
+-  'UCP_ZEBRA'                  => 'Freunde und ignorierte Mitglieder',   
+-  'UCP_ZEBRA_FRIENDS'          => 'Freunde bearbeiten',   
+-  
+-  
+-  'UCP_ZEBRA_FOES'             => 'Ignorierte Mitglieder bearbeiten', 
+-  'UCP_APPLY'                    => 'Anwenden', 
+-  'UCP_PM_DEFAULT_RULE_TAG'      => 'Standardaktion',
+-  'UCP_PM_DEFAULT_RULE'          => 'Akzeptiere keine neuen Nachrichten',
+-  
+-  'UCP_PM_DEFAULT_RULE_EXPLAIN'  => 'Diese Aktion wird nur dann ausgeführt, wenn keine der oben genannten Optionen anwendbar ist. Neue Nachrichten werden so lange zurückgehalten, bis genügend Speicherplatz vorhanden ist.',
+-  'UCP_PM_NEW_MESSAGE'           => 'Neue Nachricht',
+-  
+-  
+-  
+-  'BIO'                          => 'Persönliche Informationen Biographie',
+-  'MANAGE'                       => 'VERWALTEN',
+-  'JOINED_BOARD'                 => 'Im Forum beigetreten',
+-  'VISITED_BOARD'                => 'Letzter Besuch',
+-  'SEE_MORE'                     => 'Mehr',
+-  'ATTACH_SIGNATURE'             => 'Signatur anhängen',
+-  'BBCODES'                      => 'BBcodes',
+-
+-  'DELETE_POST_SOFT'             => 'Soft Delete post',
+-  'DELETE_POST_PERMANENT'        => 'Perma Delete post',
+-  'DELETE_POST_SOFT_WARN'        => 'It can be recovered',
+-  'DELETE_POST_PERMANENT_WARN'   => 'It can NOT be recovered',
+-  
+-  
+-  'POLL_MAX_OPTIONS_EXPLAIN_ALT' => 'Gib die maximale Anzahl an Möglichkeiten an, die ein Nutzer erhält',
+-  'POLL_VOTE_CHANGE_LABEL'       => 'Wiederwahl erlauben',
+-  'NO_VOTES_NA'                  => 'N/A',
+-  'NOT_AVAILABLE'                => 'Nicht verfügbar',
+-  'POST_TOPIC_NEW'               => 'Neues Thema',
+-  'QUICK_REPLY_SHOW_HIDE'        => 'Anzeigen/Verstecken der Schnellanwort',
+-  'CHARACTERS_COUNT'             => 'Buchstaben',
+-  'CHARACTERS_COUNT_REM'         => 'übrig',
+-  'BOOKMARKED_TOPICS_UCP'        => 'Gespeicherte Themen',
+-  'ATTACH_EXPLANATION_SORTABLE'  => 'Klicken zum Sortieren',
+-  
+-  'ATTACH_FORUM'                 => 'Anhänge',
+-  'MCP_DETAILS_LOG'              => 'Details',
+-  'MCP_DETAIL_U_IP'              => 'Nutzer &amp; IP',
+-  'MCP_MANAG_BAN'                => 'Bann-Verwalltung',
+-  'MCP_UNAPPROVED_POSTS_ZERO'    => 'Keine Einträge die auf Freischaltung warten',
+-  
+-  'MCP_REPORTS_ZERO'             => 'Keine Berichte zum Kontrollieren',
+-  'MCP_PM_REPORTS_ZERO'          => 'Keine PM Berichte zum Kontrollieren',
+-  
+-  
+-  	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
+-  'FORUMLIST_UNAPPROVED'         => 'Mindestens ein Thema in diesem Forum wurde nicht genehmigt', 
+-  'FORUMLIST_UNAPPROVED_POST'    => 'Mindestens ein Beitrag in diesem Forum wurde nicht genemigt', 
+-  'FORUMLIST_LASTPOST'           => 'Letzten Beitrag anzeigen', 
+-  'TOPICS_POSTS_STATISTICS'      => 'Statistiken',
+-  'TOPICS_ROW_REPORTED'          => 'Dieses Thema wurde gemeldet',
+-  'TOPICS_ROW_NOT_APPROVED'      => 'Dieses Thema wurde nicht freigeschalten',
+-  'TOPICS_ROW_DELETED'           => 'Dieses Thema wurde gelöscht',
+-  'MODERATOR_PANEL_GENERAL'      => 'Moderationsbereich',
+-  'ADMIN_PANEL_GENERAL'          => 'Administrationsbereich',
+-  'RANK_IMAGE'                   => 'Rang Bild',
+-  
+-  'WELCOME_INDEX'                => 'Willkommen',
+-  'FAQ'                          => 'FAQ',
+-  'CAPTION_FAQ'                  => 'F.A.Q',
+-  'CAPTION_SEARCH'               => 'Starte eine Suche!',
+-  'CAPTION_MEMBERS'              => 'Suchst Du jemanden?',
+-  'MEMBERS_CAP'                  => 'Mitgleider',
+-  'CAPTION_UCP'                  => 'Einstellungen',
+-  
+-  
+-  'UCP_CAP'                      => 'Nutzerverwaltungsbereich',
+-  'INDEX_CAPTION'                => 'Dies ist die Forum-Startseite',
+-  'VIEWTOPIC_CAP'                => 'Thementitel',
+-  'CAPTION_VIEWTOPIC'            => 'Themenbeschreibung',
+-  'CAPTION_VIEWFORUM'            => 'Durchsuche alle Forenkategorien',
+-  
+-  'POSTINGS_CAP'                 => 'Beitragsbearbeitung',
+-  'CAPTION_POSTINGS'             => 'Starte einen Beitrag!',
+-  
+-  
+-  'MCP_CAPTION'                  => 'Hier bekommst Du beigebracht deine Superkraft zu nutzen ;-)',
+-  'BOOTSTRAP_ELEMENT'            => 'Bootstrap Elemente',
+-  'BOOTSTRAP_ELEMENT_CAPTION'    => 'Forum Anfänger-Dokumentation',
+-  'MAIN_FORUM'                   => 'Forum',
+-  'MAIN_MAIN_STUFF'              => 'Das wichtige Zeug',
+-  
+-  'MAIN_TRENDS'                  => 'Schaue Dir die Trends an',
+-  'MAIN_SEARCH_IT_UP'            => 'Suche starten',
+-  
+-  'SUB_NO_ICON'                  => 'Kein Bild vorhanden',
+-  'EXAMPLE_WITH_ICON'            => 'Beispiel mit Bild',
+-  'EXAMPLE_LINK'                 => 'Beispiel Link',
+-  'MAIN_SOCIAL'                  => 'Sozial',
+-  'SOCIAL_P'                     => 'Chat away ;-)',
+-  
+-  'MORE'          				   => 'Mehr',
+-  
+-  'EXPAND_CLOSE'          	 => 'Fenster schließen',
+-  'MARK_TOPICS_READ'         => 'Als gelesen markieren',
+-  
+-  'CONTACT'                  => 'Kontakt',
+-  'GET_IN_TOUCH'             => 'In Kontakt kommen',
+-  'HANG_AROUND'              => 'Rumhängen',
+-  'JOIN_THE_CLUB'            => 'Melde Dich an',
+-  
+-  'MENU'                     => 'MENÜ',
+-  'YOU_ARE_HERE'             => 'Du bist hier',
+-  'IN_FOOTER'                => 'In:',
+-  
+-  'REPLY'                    => 'Antwort',
+-
+-  'LOGIN_REMEMBER'             => 'Angemeldet bleiben',
+-  'LOGIN_HIDE_ME'              => 'Unsichtbar',
+-  'LOGIN_ME_IN'                => 'Anmelden',
+-  'SIGN_IN_ACCOUNT'            => 'Anmeldung',
+-  'CREATE_ACCOUNT'             => 'Konto erstellen',
+-  
+-  'GO_TO_SEARCH_ADV'           => 'Zurück zur erweiterten Suche',
+-  
+-  'CREATE_ACCOUNT_DISABLED'    => 'Anmeldungen nicht erlaubt',
+-  
+-  'REGISTRATION_DISABLED'      => 'Es sieht so aus, als wäre die Anmeldung zur Zeit geschlossen. Es kann sich aber auch um eine kurzfristige Abschaltung handeln. Wenn Du denkst, es könnte sich um einen Fehler handeln, kontaktiere bitte den Foren-Administrator. Wir entschuldigen uns für die verursachtenUmstände. In unsere Nutzungsbedingungen und Datenschutzrichtlinien kannst Du mit einem Klick auf die jeweiligen Links weiter unten, einsehen.',
+-  'CONTACT_WEBMASTER'          => 'Forenadministrator kontaktieren',
+-  
+-  'CONFIRM_QA_EXPLAIN_ALT'     => 'Beweise, dass Du ein Mensch bist und beantworte die Frage',
+-  'PLUPLOAD_PLACE_INLINE'        => 'Linear',
+-  'PLUPLOAD_DELETE_FILE'         => 'Löschen',
+-  
+-  
+-  'REG_CREATING'             => 'Profil erstellen...',
+-  'LOADING'                  => 'Läd...',
+-  'SAVING'                   => 'Speichert...',
+-  'CANCELLING'               => 'Abbrechen...',
+-  'SENDING'                  => 'Senden...',
+-  'SEARCHING'                => 'Suchen...',
+-  'LOADING_LOG_IN'           => 'Anmeldung...',
+-  'FILE_UPLOADING'           => 'Hochladen...',
+-  'CASTING_VOTE'             => 'Stimme wird eingetragen...',
+-  'LOADING_FORM'             => 'Lade Formular',
+-
+-  
+-  'MEMBERLIST_P_JOINED'          => 'ist dem Forum beigetreten',
+-  
+-  
+-  'MEMBERLIST_P_EXPL'            => 'Zu diesem Zeitpunkt habe ich mich registriert. ;)',
+-  'MEMBERLIST_P_DATE_EXPL'       => 'Dies war der Zeitpunkt als ich das letzte mal hier war.',
+-  'SPAMMER_PLACEHOLDER'          => 'Du kannst nicht einfach unser Board zuspammen und dann abhauen!',
+-  'MARK_PLACEHOLDER'             => 'Deine Wahl markieren',
+-  'INFO_BOX'                     => 'Information:',
+-  'USER_REMOVE_PLACEHOLDER'      => 'Klicken um Nutzer zu entfernen',
+-  'GROUP_REMOVE_PLACEHOLDER'     => 'Klicken um Gruppe zu entfernen',
+-  
+-  'EDIT_LINK_PLACEHOLDER'        => 'Ich habe vergessen meine Links richtig zu erstellen',
+-  'POST_IT_UP_PLACEHOLDER'       => 'Beitrag jetzt ersetellen!',
+-  
+-  'UCP_REG_USR_PLACEHOLDER'      => 'Bsp. John Doe',
+-  'UCP_REG_EMAIL_PLACEHOLDER'    => 'Bsp. john@mail.com',
+-  'UCP_REG_PSWD_PLACEHOLDER'     => 'Bsp. ASDFasdf123',
+-  'UCP_REG_CAPCTHA_PLACEHOLDER'  => 'Bsp. blauer Himmel',
+-  'SEARCH_USR_PLACEHOLDER'       => 'Bsp. SiteSplat',
+-   'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E.g. 2018-12-22',
+-	'IP_PLACEHOLDER'			=> 'E.g. 216.161.111.33',
+-	'POSTS_PLACEHOLDER'			=> 'E.g. 12',
+-	'SEARCH_KWDS_PLACEHOLDER'	=> 'E.g. cats, or cats+, or cats-, or cats|dogs, or cat*', 
+-	
+-	
+-	
+-	
+-	
+-	
+-	
+-	
+-	
+-	
+-  'MESSAGE_ENTER_PLACEHOLDER'    => 'Nachricht eintragen...',
+-  'FILE_COMMENT_PLACEHOLDER'     => 'Datei kommentieren',
+-  'HEIGTH_PLACEHOLDER'           => 'Höhe',
+-  'WIDTH_PLACEHOLDER'            => 'Weite',
+-  'UCP_OCCUPATION_PLACEHOLDER'   => 'Bescheibe was Du arbeitest...',
+-  'UCP_INTERESTS_PLACEHOLDER'    => 'Beschreibe Deine Interessen...',
+-  'SOFT_DELETE_PLACEHOLDER'      => 'Gib an, warum Du hier bis, wenn Du magst...',
+-  'ADD_DESCRIPTION'              => 'Beschreibung hinzufügen',
+-  
+-  'FILE_SELECT'                  => 'Datei auswählen',
+-  'FILE_CHANGE'                  => 'wechseln',
+-  
+-  
+-  
+-  'SELECT_IMAGE'                 => 'Bild auswählen',
+-  'NOTE'                         => 'merken',
+-  'EDIT_DRAFT'                   => 'Entwurf bearbeiten',
+-  'PM_BALOON_NOTIFICATION'       => 'Balonartige Ansicht für PM (Private Message) einstellen',
+-  
+-  'DAYS_AGO'                     => 'Tage zuvor',
+-  'WORK_IN_PROGRESS'             => 'Wartung',
+-  'DISABLE_MESSAGE'              => 'Forum ist nicht erreichbar',
+-  
+-  
+-  'DISABLE_RETURN'               => 'Zurück zur Startseite',
+-  'BOARD_DISABLED_SHUFFLE'       => 'Hab Spass und vergnüge Dich mit ein paar Buchstaben :-)',
+-  'DISABLE_TEXT_TRY'             => 'Probier es doch aus!',
+-  
+-  
+-  'DISABLE_TEXT_TYPE'            => 'tippe was ein und speichere es mit der Return-Taste...',
+- 
+-  'GRAVATAR_EXPLAIN'          	 => 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
+-  'GRAVATAR_EXPLAIN_CONFIRM'     => 'Please confirm your email address here',
+-  
+-  
+-  
+-  'DELETE_POLL'              => 'Umfrage löschen',
+-  'POLL_DELETE_HELPER'       => '(Dies löscht nur die Umfrage) markieren und absenden',
+-  'JUMP_TO_POST'             => 'springe zum Beitrag',
+-  'JUMP_SELECT_FORUM'            => 'Wähle Forum zum Wecheln aus',
+-  'JUMP_TO_PAGE_NUMBER'          => 'Springe zu Seite #',
+-  'VIEW_FIRST_UNREAD'        => 'Zeige ersten ungelesenen Beitrag',
+-  'BOOKMARK_TOPIC_REMOVE'        => 'Lesezeichen entfernen',
+-  
+-  'NEW_MESSAGES'             => 'Neue Nachrichten',
+-  'YOU_HAVE'                 => 'Du hast',
+-  
+-  
+-  'AND'                      => 'und',
+-  'HELLO'                    => 'Hallo',
+-  'DISMISS_PM'               => 'Defer 5 min',
+-  
+-  'READ_NOW'                 => 'Jetzt lesen',
+-  'PRIVATE_MESSAGE_NEW'	         => 'Neue private Nachricht',
+-  'PRIVATE_MESSAGE_UNREAD'	     => 'Ungelesene private Nachricht',
+-  
+-  'NO_PMS_INFO'	                 => 'Alle gelesen! Erstelle neue PM?',
+-  
+-  'DATES'                    => 'DATUM',
+-  
+-  
+-  
+-  'POWERED'                  => 'Gesponsort von',
+-  'HANDCRAFTED'              => 'in Handarbeit hergestellt mit',
+-  'BY'                       => 'von',
+-  'RECENT_TOPICS'            => 'Letzte Einträge',
+-  'TWITTER'                  => 'Twitter',
+-  'FAVORITES'                => 'Favoriten',
+-
+-  
+-  'GALLERY'                  => 'Gallerie',
+-  'CHAT'                     => 'Chat',
+-  
+-  
+-  
+-  
+-  
+-  'ABOUT'                    => 'Über uns',
+-  'ABOUT_PART_ONE'           => 'BBOOTS&#8482; Ist das erste und einzige voll responsive inoffizielle  PhpBB&reg; HTML5/CSS3 Design. Das saubere und knagige aussehen macht sich echt gut auf allen Browsern und sonstigen Anzeigen.',
+-  'ABOUT_PART_TWO'           => 'Es wartet mit einem Bootstrap basierten Grundgerüst auf, wurde lange Zeit hoffnungsvoll erwartet und wird sicherlich den phpBB Fan-Club total begeistern.',
+-  'ABOUT_PART_THREE'         => 'Das inoffizielle responsive Design',
+-  'BB'                       => 'B',
+-  'BOOTS'                    => 'BOOTS',
+-  'BBOOTS'                   => 'BBOOTS',
+-  
+-  'BBOOTS_VERSION'           => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
+-  'U_LOGOUT'                 => 'Abmelden',
+-
+-  'SITESPLAT_STATISTICS'     => 'Statistiken',
+-  'SITESPLAT_SEE_DETAILS'    => 'Siehe Details',
+-  'SITESPLAT_SEARCH_LAST_DAY'    => 'Einträge der letzten 24 Stunden',
+-  'SITESPLAT_SEARCH_WEEK'		 => 'Einträge der letzten 7 Tage',
+-  
+-  'SITESPLAT_TOTAL_POSTS'        => 'Beiträge insgesamt',
+-  'SITESPLAT_TOTAL_TOPICS'       => 'Themen insgesamt',
+-  'SITESPLAT_TOTAL_USERS'        => 'Mitglieder insgesamt',
+-  'SITESPLAT_NEWEST_MEMBER'      => 'Unser neuestes Mitglied',
+-  'SITESPLAT_USERS_ONLINE'       => 'Nutzer anwesend',
+-  'SITESPLAT_MOST_USERS_ONLINE'  => 'Höchstanzahl zeitgleicher Besucher',
+-  
+-  'BOOTSTRAP_VERSION'	         => '3.3.5',
+-  'FLATBOOTS'	                 => 'FLATBOOTS',
+-  'CHANGE_AVATAR'              => 'Avatar ändern',
+-  'CHANGE_PASSWORD'            => 'Passwort ändern',
+-  
+-  'ADMIN_TIPS'                 => 'Admin Tips &amp; Tricks',
+-  
+-  
+-  
+-  
+-  'ADMIN_TIP_INTRO'            => 'Wusstest Du, dass Du Dein phpBB-Forum mit ein paar einfachen Handgriffen noch sicherer machen kannst?',
+-  'ADMIN_TIP_ONE'              => 'Halte Deine Software immer auf dem aktuellsten Stand',
+-  'ADMIN_TIP_TWO'              => 'Verwende immer sichere Passwörter mit abwechselnde unterschiedlichen Buchstaben, Nummern und Sonderzeichen.',
+-  'ADMIN_TIP_THREE'            => 'Sperre den direkten Zugriff auf den Administrations-Ordner...',
+-  'ADMIN_CHECK_IT_BTN'         => 'Besuche SiteSplat.com für mehr Information',
+-  
+-  'USER_MINI_PROFILE'            => 'Minimales Nutzerprofil',
+-  'USER_MINI_PROFILE_VIEW_FULL'  => 'Zeige volles Profil',
+-  'OFF_LINE'                     => 'Off-line',
+-  'USER_STATUS'                  => 'Status',
+-  
+-  
+-  
+-  
+-  
+-  
+-  'USER'                         => 'Nutzer',
+-  'TITLE'                        => 'Titel',
+-  'END_TIMELINE'                 => 'Ende der Zeitlinie',
+-  'MEMBERS'                      => 'Mitglieder',
+-  'DRAFTS'                       => 'Entwürfe',
+-  'REPORTS'                      => 'Meldungen',
+-  'MODERATOR_LOGS'               => 'Moderator Anmeldungen',
+-  
+-  'QUEUE'                        => 'Warteschlange',
+-  'LINKS'                        => 'Links',
+-  'TOPIC_PERMISSIONS'            => 'Themenberechtigungen',
+-  'MODERATOR_OPTIONS'            => 'Moderationen',
+-  'PASSWORD_EXPLAIN_CONFIRM'     => 'Sei Dir sicher, dass es passt',
+-  'FORUM_REDIRECTS'              => 'Weiterleitungen:',
+-  
+-  'FANCY_TOPICS_TITLE'           => 'Letzte Themen dieses Forums',
+- 
+-
+-
+-
+-
+-
+-  
+-  'POST_BY'                      => 'Geschrieben von',
+-  'REPLY_BY'                     => 'Antwort von',
+-  'NO_REPLIES'                   => 'Keine Antworten',
+-  'READ_MORE'                    => 'Weiter lesen...',
+-  'RT_READ_MORE'                 => 'WEITER LESEN...',
+-  'VIEW_MORE_TOPICS'             => 'weitere neue Einträge anzeigen',
+-  'BACK_TO_START'                => 'ZURÜCK ZUM ANFANG',
+-  
+-  'TOGGLE_NAV'                   => 'Navigation verstecken',
+-  
+-  'DEMO_LINK'                  => 'Demonstraton, keine Bilder verlinkt',
+-  'DEMO_HEADER_MENU'           => 'Webseiteneinleitungsbeispiel',
+-  
+-  'FLATBOOTS_INTRO'              => 'Bootstrap Framework',
+-  
+-  
+-  'FLATBOOTS_EXPLAIN'            => 'Über ein Dutzend wiederverwendbare Erweiterungen vorhanden, z.B. Icons, Dropdown Listen, Navigation, Warnmeldungen und vieles mehr... ',
+-  'CALL_TO_ACTION_FOOTER'        => 'Ein-/Auschalten von Erweiterungen. Nutze nur was Du wirklich benötigst!',
+-  'PURCHASE_NOW_BTN'             => 'Jetzt kaufen',
+-  
+-  'FLATBOOTS_ABOUT_PART_ONE'     => 'Hier gibt es bald ein paar kurze Zeilen über das Board...',
+-  'FLATBOOTS_ABOUT_TITLE'        => 'Gebaut für die Ewigkeit',
+-  'DMCA'                         => 'DMCA',
+-  
+-  'TERMS'                        => 'Nutzungsbedingungen',
+-  'ADVERTISE'                    => 'Werbung',
+-  'SITESPLAT'                    => 'SiteSplat',
+-  'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
+-    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
+-    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
+-    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
+-  'JOIN_US_TWITTER'              => 'Triff uns auf Twitter',
+-  
+-  'TWEET_EXAMPLE'                => 'BBOOTS erreichte 500 verkäufe! Vielen Dank Euch allen für die Unterstützung zu diesem erstaunlichen Projekt und zum Aufbau der SiteSplat Gemeinschaft. Was kommt als nächstes? Bleib am Ball und folge mir auf Twitter: <a href="#">http://bit.ly/000fefs</a>',
+- 
+-));
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_acp_bbcore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_acp_bbcore.php"
+deleted file mode 100644
+index 6cb7131a6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_acp_bbcore.php"
++++ /dev/null
+@@ -1,103 +0,0 @@
+-<?php
+-/**
+-*
+-* common [English]
+-*
+-* @package language
+-* @package sitesplat BBcore
+-* @version $Id$
+-* @copyright (c) 2015 SiteSplat All rights reserved
+-* @license Proprietary
+-*
+-*/
+-
+-// TRANSLATORS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
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
+-	$lang = array();
+-}
+-
+-$lang = array_merge($lang, array(
+-	'SS_AUTOUPDATE_DISABLED'		=>'<strong style="font-size:1.4em">BBCore auto-update is disabled!</strong>',
+-	'SS_BAD_FILESYSTEM'				=> 'You are using an obsolete PHP handler that makes your filesystem unwritable by phpBB.<br>Please consider installing a modern FastCGI PHP handler such as PHP-FPM.',
+-	'SS_SYSINFO'					=> 'System Information',
+-	'SS_FOUNDERS'					=> 'Founders',
+-	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
+-	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a> or go to the <a href="%s">SiteSplat Update Manager</a>.',
+-
+-    'VERSION_INSTALLED'  			=> 'Installed Version',
+-	'NEW_BOOTS_VERSION'				=> '🌟 New %s version available 🌟',
+-	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
+-	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
+-	
+-	'DOWNLOAD_MSG'					=> 'New Latest Current version: <span class="label label-success">%s</span>',
+-	'DOWNLOAD_BTN_ENVATO'		    => ' <a class="btn btn-default sitesplat-bbcore-autoupdate" href="%s" title="Download from envato" target="_blank">View Envato item</a>',
+-	'DOWNLOAD_MSG_NO_UPD'			=> 'All good! looks like you are up to date! 👍💯',
+-	'START_AUTO'				    => 'Start Auto-update 🚀',
+-	
+-	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s - Changelog</a>',
+-	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
+-	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
+-	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',
+-
+-    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
+-    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
+-    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
+-    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
+-  
+-    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
+-    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
+-	
+-	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
+-	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',
+-
+-	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
+-	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
+-    
+-	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin log under the MAINTENANCE tab.',
+-	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
+-	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',
+-
+-	// autoupdate
+-	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
+-	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP!!!',
+-    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
+-	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
+-	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
+-	'NO_DIRECT_DOWNLOAD'			=> 'Unable to automatically update your style because the style author did not provide the necessary files.',
+-	'PROBLEM_DOWNLOADING_UPDATE'	=> 'Unable to download the update files at the moment. Please try again later.',
+-	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
+-	'MERGE_CONFLICTS'				=> 'Oh No! 😱 ¯\_(ツ)_/¯ The system was unable to automatically update your premium theme. The possbile reasons could be due to your theme files being corrupted or containing custom changes that the auto-update is unable to automatically solve. In order to help you with this situation, see the generated conflicting files and/or conflicts they contain, saved in:<br /><br /><strong>%s</strong>.',
+-	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
+-	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
+-	'UPDATE_SUCCESS'				=> 'Yeehaw! Your Premium Theme has Been Updated Successfully 💯. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="https://themeforest.net/downloads?ref=ThemeSplat" target="_blank">https://themeforest.net/downloads</a>',
+-    'CURRENT_FILE'					=> 'Current file',
+-	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
+-	'NEW_FILE'						=> 'New file',
+-
+-	// log
+-	'LOG_STYLE_UPDATED'	=> '<strong>BBcore auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/en/BBCore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/en/BBCore.php"
+index ff6479956..6056f431e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/en/BBCore.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/en/BBCore.php"
+@@ -36,11 +36,9 @@ if (empty($lang) || !is_array($lang)) {
+ }
+ 
+ // load addon lang files first...allow BBCore to overwrite if needed
+-if (function_exists('\sitesplat\load_ext_lang')) {
+-    $addon_lang = [];
+-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
+-    $lang = array_merge($lang, $addon_lang);
+-}
++$addon_lang = [];
++\sitesplat\load_ext_lang(__DIR__, $addon_lang);
++$lang = array_merge($lang, $addon_lang);
+ 
+ // BBCore
+ $lang = array_merge($lang, array(
+@@ -67,7 +65,6 @@ $lang = array_merge($lang, array(
+ 	'SS_CHATBOX'				=> 'Chat',
+ 	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+ 	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
+ 
+ 	'SS_ADDONS'				=> 'Addons',
+ 	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+@@ -270,6 +267,7 @@ $lang = array_merge($lang, array(
+ 	'NOTE'						=> 'Note',
+ 	'EDIT_DRAFT'				=> 'Edit Draft',
+ 	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
++	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Mark all read',
+ 	'DAYS_AGO'					=> 'Days ago',
+ 	'WORK_IN_PROGRESS'			=> 'Maintenance',
+ 	'DISABLE_MESSAGE'			=> 'Board unavailable',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/BBCore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/BBCore.php"
+deleted file mode 100644
+index 261ba1fbc..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/BBCore.php"
++++ /dev/null
+@@ -1,398 +0,0 @@
+-<?php
+-/**
+-*
+-* BBCore [English]
+-*
+-* @package sitesplat BBcore
+-* @copyright (c) 2015 SiteSplat All rights reserved
+-* @license Proprietary
+-*
+-*/
+-
+-// TRANSLATORS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, Par exemple: instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, Par exemple: 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order Par exemple:, 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB')) {
+-	exit;
+-}
+-if (empty($lang) || !is_array($lang)) {
+-	$lang = array();
+-}
+-
+-// load addon lang files first...allow BBCore to overwrite if needed
+-if (function_exists('\sitesplat\load_ext_lang')) {
+-    $addon_lang = [];
+-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
+-    $lang = array_merge($lang, $addon_lang);
+-}
+-
+-// BBCore
+-$lang = array_merge($lang, array(
+-	'PM_NEW_MSG' => [
+-		1 => 'You have %d New Private Message',
+-		2 => 'You have %d New Private Messages',
+-	],
+-	'PM_UNREAD_MSG' => [
+-		1 => 'You have %d Unread Private Message',
+-		2 => 'You have %d Unread Private Messages',
+-	],
+-	'PM_NEW_MSG_BUBBLE' => [
+-		1 => '%d',
+-		2 => '%d',
+-	],
+-
+-	'SITESPLAT_EXT'				=> 'Other Extensions',
+-	'BBCORE_DASHBOARD'			=> 'Dashboard',
+-	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
+-	'BBCORE_SETTINGS'			=> 'Settings',
+-	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
+-	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
+-	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
+-	'SS_CHATBOX'				=> 'Chat',
+-	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+-	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
+-
+-	'SS_ADDONS'				=> 'Addons',
+-	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+-	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
+-
+-	'UCP_MAIN'				=> 'Vue Générale',
+-	'UCP_MAIN_FRONT'		=> 'Tableau de bord',
+-	'UCP_MAIN_SUBSCRIPTION'	=> 'Gérer les abonnements',
+-	'UCP_MAIN_BOOKMARKS'	=> 'Gérer les favoris',
+-	'UCP_MAIN_DRAFTS'		=> 'Gérer les brouillons',
+-	'UCP_MAIN_ATTACHMENTS'	=> 'Gérer les pièces jointes',
+-
+-	'USER_PANEL'				=> 'Panneau de contrôle',
+-	'UCP_PROFILE'				=> 'Profil',
+-	'UCP_PROFILE_PROFILE'		=> 'Editer profil',
+-	'UCP_PROFILE_SIGNITURE'		=> 'Editer signature',
+-	'UCP_PROFILE_AVATAR'		=> 'Editer avatar',
+-	'UCP_PROFILE_SETTINGS'		=> 'Paramètres compte',
+-	'UCP_AVATAR_SELECT_OPTIONS'	=> 'Avatar options',
+-	'UCP_AVATAR_SELECT_UPLOAD'	=> 'Télécharger un avatar',
+-	'UCP_SUBMIT_TO_UPLOAD'		=> 'Submit below to upload',
+-
+-	'UCP_PREFERENCE'			=> 'Préférences Forum',
+-	'UCP_PREFERENCE_SETTINGS'	=> 'Editer paramètres',
+-	'UCP_PREFERENCE_DEFAULTS'	=> 'Edit posting defaults',
+-	'UCP_PREFERENCE_OPTIONS'	=> 'Editer options affichage',
+-
+-	'UCP_MESSAGES'				=> 'Messages',
+-	'UCP_PM_COMPOSE'			=> 'Ecrire message',
+-	'UCP_PM_DRAFTS'				=> 'Gérer brouillons',
+-	'UCP_PM_INBOX'				=> 'Reçus',
+-	'UCP_PM_OUTBOX'				=> 'Outbox',
+-	'UCP_PM_SENTBOX'			=> 'Envoyé',
+-	'UCP_PM_OPTIONS'			=> 'Règles, dossiers &amp; paramètres',
+-	'UCP_NO_USER_CHANGE_ALLOWED'	=> '**Username change is not allowed**',
+-	'UCP_REGISTER_EMAIL_EXPLAIN'	=> 'Please do not use disposable emails',
+-
+-	'WIDTH_SIZE'			=> 'largeur',
+-	'PIXEL_SIZE'			=> 'px',
+-	'HEIGHT_SIZE'			=> 'hauteur',
+-
+-	'UCP_GROUPS'			=> 'Groupe Utilisateurs',
+-	'UCP_GROUPS_MEMBERSHIP'	=> 'Edit membership',
+-	'UCP_GROUPS_MANAGE'		=> 'Gérer groupes',
+-
+-	'UCP_ZEBRA'					=> 'Amis &amp; Ignorés',
+-	'UCP_ZEBRA_FRIENDS'			=> 'Gérer Amis',
+-	'UCP_ZEBRA_FOES'			=> 'Gérer Ignorés',
+-	'UCP_APPLY'					=> 'Appliquer',
+-	'UCP_PM_DEFAULT_RULE_TAG'	=> 'Default action',
+-	'UCP_PM_DEFAULT_RULE'		=> 'Ne pas accepter nouveaux messages',
+-	'UCP_PM_DEFAULT_RULE_EXPLAIN'	=> 'This action will be triggered only if none of the above options is applicable. New messages will be held back until enough space is available.',
+-	'UCP_PM_NEW_MESSAGE'		=> 'Nouveau Message',
+-	'BIO'						=> 'Bio Informations Perso',
+-	'MANAGE'					=> 'Gérer',
+-	'JOINED_BOARD'				=> 'a rejoint le forum',
+-	'VISITED_BOARD'				=> 'Dernière visite',
+-	'SEE_MORE'					=> 'Plus',
+-	'ATTACH_SIGNATURE'			=> 'Joindre signature',
+-	'BBCODES'					=> 'BBcodes',
+-
+-	'DELETE_POST_SOFT'			=> 'Soft Delete post',
+-	'DELETE_POST_PERMANENT'		=> 'Perma Delete post',
+-	'DELETE_POST_SOFT_WARN'		=> 'It can be recovered',
+-	'DELETE_POST_PERMANENT_WARN'	=> 'It can NOT be recovered',
+-
+-	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	=> 'Enter the max number of options the user can select',
+-	'POLL_VOTE_CHANGE_LABEL'	=> 'Allow Re-vote',
+-	'NO_VOTES_NA'				=> 'Non Dispo',
+-	'NOT_AVAILABLE'				=> 'Non disponible',
+-	'POST_TOPIC_NEW'			=> 'Nouveau Sujet',
+-	'QUICK_REPLY_SHOW_HIDE'		=> 'Show/Hide Quick Reply',
+-	'CHARACTERS_COUNT'			=> 'Caractères',
+-	'CHARACTERS_COUNT_REM'		=> 'Remaining',
+-	'BOOKMARKED_TOPICS_UCP'		=> 'Bookmarked Topics',
+-	'ATTACH_EXPLANATION_SORTABLE'	=> 'Click to sort',
+-	'ATTACH_FORUM'				=> 'Attachment(s)',
+-	'MCP_DETAILS_LOG'			=> 'Details',
+-	'MCP_DETAIL_U_IP'			=> 'User &amp; IP',
+-	'MCP_MANAG_BAN'				=> 'Ban Management',
+-	'MCP_UNAPPROVED_POSTS_ZERO'	=> 'There are no posts waiting for approval',
+-	'MCP_REPORTS_ZERO'			=> 'There are no reports to review',
+-	'MCP_PM_REPORTS_ZERO'		=> 'There are no PM reports to review',
+-
+-
+-	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
+-	'FORUMLIST_UNAPPROVED'		=> 'At least one topic in this forum has not been approved',
+-	'FORUMLIST_UNAPPROVED_POST'	=> 'At least one post in this forum has not been approved',
+-	'FORUMLIST_LASTPOST'		=> 'View the latest post',
+-	'TOPICS_POSTS_STATISTICS'	=> 'Statistics',
+-	'TOPICS_ROW_REPORTED'		=> 'This Topic has been reported',
+-	'TOPICS_ROW_NOT_APPROVED'	=> 'This Topic has not been approved',
+-	'TOPICS_ROW_DELETED'		=> 'This Topic has been deleted',
+-	'MODERATOR_PANEL_GENERAL'	=> 'Moderator Panel',
+-	'ADMIN_PANEL_GENERAL'		=> 'Administrator Panel',
+-	'RANK_IMAGE'				=> 'Rank image',
+-
+-	'WELCOME_INDEX'			=> 'Bienvenue',
+-	'FAQ'					=> 'FAQ',
+-	'CAPTION_FAQ'			=> 'Foire Aux Questions',
+-	'CAPTION_SEARCH'		=> 'Search it up!',
+-	'CAPTION_MEMBERS'		=> 'Vous cherchez une personne?',
+-	'MEMBERS_CAP'			=> 'Membres',
+-	'CAPTION_UCP'			=> 'Choisir vos préférences',
+-	'UCP_CAP'				=> 'Panneau Utilisateur',
+-	'INDEX_CAPTION'			=> 'Page principale du forum',
+-	'VIEWTOPIC_CAP'			=> 'Titre Sujet',
+-	'CAPTION_VIEWTOPIC'		=> 'Description sujet',
+-	'CAPTION_VIEWFORUM'		=> 'Visualiser toutes les catégories du forum',
+-	'POSTINGS_CAP'			=> 'Editeur',
+-	'CAPTION_POSTINGS'		=> 'Posting things up!',
+-
+-	'MCP_CAPTION'				=> 'This is where you get to use the Super Powers ;-)',
+-	'BOOTSTRAP_ELEMENT'			=> 'Bootstrap Elements',
+-	'BOOTSTRAP_ELEMENT_CAPTION'	=> 'Forum KickStart Documentation',
+-	'MAIN_FORUM'				=> 'Forum',
+-	'MAIN_MAIN_STUFF'			=> 'The Main stuff',
+-	'MAIN_TRENDS'				=> 'See the trends',
+-
+-	'MAIN_SEARCH_IT_UP'		=> 'Search it up',
+-	'SUB_NO_ICON'			=> 'No Icon here at all',
+-	'EXAMPLE_WITH_ICON'		=> 'Example With Icon',
+-	'EXAMPLE_LINK'			=> 'Example Link',
+-	'MAIN_SOCIAL'			=> 'Social',
+-	'SOCIAL_P'				=> 'Chat away ;-)',
+-
+-	'MORE'					=> 'Plus',
+-	'EXPAND_CLOSE'			=> 'Fermer la Vue',
+-	'MARK_TOPICS_READ'		=> 'Mark Topics Read',
+-	'CONTACT'				=> 'Contact',
+-	'GET_IN_TOUCH'			=> 'Get in touch',
+-	'HANG_AROUND'			=> 'Bienvenue chez vous',
+-	'JOIN_THE_CLUB'			=> 'Rejoignez la communauté',
+-	'MENU'					=> 'MENU',
+-	'YOU_ARE_HERE'			=> 'Vous êtes ici',
+-	'IN_FOOTER'				=> 'Dans:',
+-	'REPLY'					=> 'Répondre',
+-
+-	'LOGIN_REMEMBER'		=> 'Me garder connecté',
+-	'LOGIN_HIDE_ME'			=> 'Cacher ma session',
+-	'LOGIN_ME_IN'			=> 'Me connecter',
+-	'SIGN_IN_ACCOUNT'		=> 'Sign in onto your account',
+-	'CREATE_ACCOUNT'		=> 'Créer un Compte',
+-	'GO_TO_SEARCH_ADV'		=> 'Retourner à la recherche avancée',
+-
+-	'CREATE_ACCOUNT_DISABLED'	=> 'Registrations closed',
+-	'REGISTRATION_DISABLED'		=> 'It looks like the registrations are closed at the moment. It could also be a temporary measure. If you believe this is a possible error, please contact the webmaster and let him know. We apologize for any inconvenience this might have caused. Our Privacy Policy and Terms of Use are available below.',
+-	'CONTACT_WEBMASTER'			=> 'Contacter le Webmaster',
+-	'CONFIRM_QA_EXPLAIN_ALT'	=> 'Pour être sûr que vous êtes un humain, répondez à cette question',
+-
+-	'PLUPLOAD_PLACE_INLINE'	=> 'Inline',
+-	'PLUPLOAD_DELETE_FILE'	=> 'Effacer',
+-
+-
+-	'REG_CREATING'			=> 'Création Profil...',
+-	'LOADING'				=> 'Chargement...',
+-	'SAVING'				=> 'Sauvegarde...',
+-	'CANCELLING'			=> 'Annulation...',
+-	'SENDING'				=> 'Envoi...',
+-	'SEARCHING'				=> 'Recherche...',
+-	'LOADING_LOG_IN'		=> 'Connexion...',
+-	'FILE_UPLOADING'		=> 'Téléchargement...',
+-	'CASTING_VOTE'			=> 'Casting vote...',
+-	'LOADING_FORM'			=> 'Loading form...',
+-
+-	'MEMBERLIST_P_JOINED'		=> 'Joined the board',
+-	'MEMBERLIST_P_EXPL'			=> 'This is when I joined the board',
+-	'MEMBERLIST_P_DATE_EXPL'	=> 'This was last time I visited the board',
+-	'SPAMMER'					=> 'Spammer',
+-	'SPAMMER_PLACEHOLDER'		=> 'You cannot just spam our board and get away with it!',
+-	'MARK_PLACEHOLDER'			=> 'Checkmark your choice',
+-	'INFO_BOX'					=> 'Information:',
+-	'USER_REMOVE_PLACEHOLDER'	=> 'Click to remove user',
+-	'GROUP_REMOVE_PLACEHOLDER'	=> 'Click to remove group',
+-	'EDIT_LINK_PLACEHOLDER'		=> 'Par exemple: I forgot to code my links',
+-	'POST_IT_UP_PLACEHOLDER'	=> 'Post it up!',
+-
+-	'UCP_REG_USR_PLACEHOLDER'	=> 'Par exemple: John Doe',
+-	'UCP_REG_EMAIL_PLACEHOLDER'	=> 'Par exemple: john@mail.com',
+-	'UCP_REG_PSWD_PLACEHOLDER'	=> 'Par exemple: ASDFasdf123',
+-	'UCP_REG_CTCHA_PLACEHOLDER'	=> 'Par exemple: blue sky',
+-	'SEARCH_USR_PLACEHOLDER'	=> 'Par exemple: SiteSplat',
+-	'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E. 2018-12-22',
+-	'IP_PLACEHOLDER'			=> 'Par exemple: 216.161.111.33',
+-	'POSTS_PLACEHOLDER'			=> 'Par exemple: 12',
+-	'SEARCH_KWDS_PLACEHOLDER'	=> 'Par exemple: cats, or cats+, or cats-, or cats|dogs, or cat*',
+-
+-	'MESSAGE_ENTER_PLACEHOLDER'	=> 'Ecrivez votre message...',
+-	'FILE_COMMENT_PLACEHOLDER'	=> 'Commentez votre fichier',
+-	'HEIGTH_PLACEHOLDER'		=> 'hauteur',
+-	'WIDTH_PLACEHOLDER'			=> 'largeur',
+-	'UCP_OCCUPATION_PLACEHOLDER'	=> 'Décrivez brièvement votre job...',
+-	'UCP_INTERESTS_PLACEHOLDER'	=> 'Décrivez vos intérêts...',
+-	'SOFT_DELETE_PLACEHOLDER'	=> 'Enter your reason if you wish to...',
+-	'ADD_DESCRIPTION'			=> 'Ajouter description',
+-
+-	'FILE_SELECT'				=> 'Choisir fichier',
+-	'FILE_CHANGE'				=> 'Changer',
+-	'SELECT_IMAGE'				=> 'Choisir image',
+-	'NOTE'						=> 'Note',
+-	'EDIT_DRAFT'				=> 'Edit Draft',
+-	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
+-	'DAYS_AGO'					=> 'Jours',
+-	'WORK_IN_PROGRESS'			=> 'Maintenance',
+-	'DISABLE_MESSAGE'			=> 'Forum indisponible',
+-	'DISABLE_RETURN'			=> 'Retourner à la page Accueil',
+-	'BOARD_DISABLED_SHUFFLE'	=> 'Have fun and shuffle some letters :-)',
+-	'DISABLE_TEXT_TRY'			=> 'Test it for yourself!',
+-	'DISABLE_TEXT_TYPE'			=> 'type anything and hit return...',
+-
+-	'GRAVATAR_EXPLAIN'			=> 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
+-	'GRAVATAR_EXPLAIN_CONFIRM'	=> 'Merci de confirmer votre email ici',
+-
+-	'DELETE_POLL'			=> 'Delete poll',
+-	'POLL_DELETE_HELPER'	=> '(This deletes the poll only) check and submit',
+-	'JUMP_TO_POST'			=> 'Aller au message',
+-	'JUMP_SELECT_FORUM'		=> 'Choisir le forum où aller',
+-	'JUMP_TO_PAGE_NUMBER'	=> 'Aller à la page #',
+-	'VIEW_FIRST_UNREAD'		=> 'Lire message non lu en premier',
+-	'BOOKMARK_TOPIC_REMOVE'	=> 'Enlever favori',
+-
+-	'NEW_MESSAGES'				=> 'Nouveaux messages',
+-	'YOU_HAVE'					=> 'Vous avez',
+-	'AND'						=> 'et',
+-	'HELLO'						=> 'Bonjour',
+-	'DISMISS_PM'				=> 'Defer 5 min',
+-	'READ_NOW'					=> 'Lire maintenant',
+-	'PRIVATE_MESSAGE_NEW'		=> 'nouveau message privé',
+-	'PRIVATE_MESSAGE_UNREAD'	=> 'message privé non lu',
+-	'NO_PMS_INFO'				=> 'Ok! Ecrire un nouveau MP?',
+-
+-	'DATES'					=> 'DATE',
+-	'POWERED'				=> 'Propulsé par',
+-	'HANDCRAFTED'			=> 'Fait par',
+-	'BY'					=> 'Par',
+-
+-	'RECENT_TOPICS'			=> 'Sujets Récents',
+-	'TWITTER'				=> 'Twitter',
+-	'FAVORITES'				=> 'Favoris',
+-
+-	'GALLERY'				=> 'Gallerie',
+-	'CHAT'					=> 'Chat',
+-	'ABOUT'					=> 'A Propos',
+-	'ABOUT_PART_ONE'		=> 'BBOOTS&#8482; Is The First And Only Fully Responsive PhpBB&reg; Unofficial HTML5/CSS3 Theme. It’s Clean And Crisp Design Looks AWESOME Across All Browsers And Devices.',
+-	'ABOUT_PART_TWO'		=> 'It Utilizes A Bootstrap Based Layout Which Has Been Long Waited For And That Is Sure To AMAZE The phpBB Fan Club.',
+-	'ABOUT_PART_THREE'		=> 'The Unofficial Responsive Theme',
+-	'BB'					=> 'B',
+-	'BOOTS'					=> 'BOOTS',
+-	'BBOOTS'				=> 'BBOOTS',
+-
+-	'BBOOTS_VERSION'		=> '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
+-	'U_LOGOUT'				=> 'Se déconnecter',
+-
+-	'SITESPLAT_STATISTICS'		=> 'Statistiques',
+-	'SITESPLAT_SEE_DETAILS'		=> 'Voir Details',
+-	'SITESPLAT_SEARCH_LAST_DAY'	=> 'Derniers messages sur 24H',
+-	'SITESPLAT_SEARCH_WEEK'		=> 'Derniers messages sur 7 jours',
+-
+-	'SITESPLAT_TOTAL_POSTS'		=> 'Total messages',
+-	'SITESPLAT_TOTAL_TOPICS'	=> 'Total sujets',
+-	'SITESPLAT_TOTAL_USERS'		=> 'Total membres',
+-	'SITESPLAT_NEWEST_MEMBER'	=> 'Newest Member',
+-	'SITESPLAT_USERS_ONLINE'	=> 'Utilisateurs en ligne',
+-	'SITESPLAT_MOST_USERS_ONLINE'	=> 'Most Users Online',
+-	'SITESPLAT_BIRTHDAYS'		=> 'Today\'s birthdays',
+-
+-	'BOOTSTRAP_VERSION'		=> '3.3.6',
+-	'FLATBOOTS'				=> 'FLATBOOTS',
+-	'CHANGE_AVATAR'			=> 'Change Avatar',
+-	'CHANGE_PASSWORD'		=> 'Change Password',
+-
+-	'ADMIN_TIPS'			=> 'Admin Tips &amp; Tricks',
+-	'ADMIN_TIP_INTRO'		=> 'Did you know you can make your phpBB forum even more secure with some simple steps?',
+-	'ADMIN_TIP_ONE'			=> 'Keep your software up to-date.',
+-	'ADMIN_TIP_TWO'			=> 'Always use strong passwords that contain random sequence of letters, numbers and special characters.',
+-	'ADMIN_TIP_THREE'		=> 'Restrict the admin folder access...',
+-	'ADMIN_CHECK_IT_BTN'	=> 'Visit SiteSplat.com for more',
+-
+-	'USER_MINI_PROFILE'			=> 'User mini profile',
+-	'USER_MINI_PROFILE_VIEW_FULL'	=> 'View full profile',
+-	'OFF_LINE'					=> 'Off-line',
+-	'USER_STATUS'				=> 'Status',
+-	'USER'						=> 'User',
+-	'TITLE'						=> 'Title',
+-	'END_TIMELINE'				=> 'End timeline',
+-	'MEMBERS'					=> 'Members',
+-	'DRAFTS'					=> 'Drafts',
+-	'REPORTS'					=> 'Reports',
+-	'MODERATOR_LOGS'			=> 'Moderator logs',
+-	'QUEUE'						=> 'Queue',
+-	'LINKS'						=> 'Links',
+-	'TOPIC_PERMISSIONS'			=> 'Topic permissions',
+-	'MODERATOR_OPTIONS'			=> 'Moderate',
+-	'PASSWORD_EXPLAIN_CONFIRM'	=> 'Make sure it matches',
+-	'FORUM_REDIRECTS'			=> 'Redirects:',
+-
+-	'FANCY_TOPICS_TITLE'	=> 'Recent topics from the forum',
+-	'POST_BY'				=> 'Post by',
+-	'REPLY_BY'				=> 'Reply by',
+-	'NO_REPLIES'			=> 'No replies',
+-	'READ_MORE'				=> 'Read more',
+-	'RT_READ_MORE'			=> 'READ MORE',
+-	'VIEW_MORE_TOPICS'		=> 'VIEW MORE TOPICS',
+-	'BACK_TO_START'			=> 'BACK TO START',
+-
+-	'TOGGLE_NAV'			=> 'Toggle Navigation',
+-	'NAVIGATION'			=> 'Navigation',
+-
+-	'DEMO_LINK'				=> 'Demo link no icons',
+-	'DEMO_HEADER_MENU'		=> 'Header intro example',
+-
+-	'FLATBOOTS_INTRO'			=> 'Bootstrap Framework',
+-	'FLATBOOTS_EXPLAIN'			=> 'Over a dozen reusable components built to provide iconography, dropdowns, input groups, navigation, alerts, and much more...',
+-	'CALL_TO_ACTION_FOOTER'		=> 'Swap-in out addons, use only what you really need!',
+-	'PURCHASE_NOW_BTN'			=> 'Purchase now',
+-	'FLATBOOTS_ABOUT_PART_ONE'	=> 'Why Would you Settle for Less when you can have More? Do not let other Authors Fool you with Empty Marketing Keywords. FLATBOOTS is what you Deserve. Built to last, Built from Scratch, Nothing Less.',
+-	'FLATBOOTS_ABOUT_TITLE'		=> 'Built to last',
+-	'DMCA'						=> 'DMCA',
+-	'TERMS'						=> 'Terms',
+-	'ADVERTISE'					=> 'Advertise',
+-	'SITESPLAT'					=> 'SiteSplat',
+-    'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
+-    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
+-    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
+-    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
+-	'JOIN_US_TWITTER'			=> 'Join us on Twitter',
+-	'TWEET_EXAMPLE'				=> 'BBOOTS reaches 2000 sales! Thank-you all for supporting this amazing project and contributing to built the SiteSplat Community. What\'s next? stay tuned and Follow Me on Twitter: <a href="#">http://bit.ly/000fefs</a>',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_acp_bbcore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_acp_bbcore.php"
+deleted file mode 100644
+index 6cb7131a6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_acp_bbcore.php"
++++ /dev/null
+@@ -1,103 +0,0 @@
+-<?php
+-/**
+-*
+-* common [English]
+-*
+-* @package language
+-* @package sitesplat BBcore
+-* @version $Id$
+-* @copyright (c) 2015 SiteSplat All rights reserved
+-* @license Proprietary
+-*
+-*/
+-
+-// TRANSLATORS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
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
+-	$lang = array();
+-}
+-
+-$lang = array_merge($lang, array(
+-	'SS_AUTOUPDATE_DISABLED'		=>'<strong style="font-size:1.4em">BBCore auto-update is disabled!</strong>',
+-	'SS_BAD_FILESYSTEM'				=> 'You are using an obsolete PHP handler that makes your filesystem unwritable by phpBB.<br>Please consider installing a modern FastCGI PHP handler such as PHP-FPM.',
+-	'SS_SYSINFO'					=> 'System Information',
+-	'SS_FOUNDERS'					=> 'Founders',
+-	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
+-	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a> or go to the <a href="%s">SiteSplat Update Manager</a>.',
+-
+-    'VERSION_INSTALLED'  			=> 'Installed Version',
+-	'NEW_BOOTS_VERSION'				=> '🌟 New %s version available 🌟',
+-	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
+-	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
+-	
+-	'DOWNLOAD_MSG'					=> 'New Latest Current version: <span class="label label-success">%s</span>',
+-	'DOWNLOAD_BTN_ENVATO'		    => ' <a class="btn btn-default sitesplat-bbcore-autoupdate" href="%s" title="Download from envato" target="_blank">View Envato item</a>',
+-	'DOWNLOAD_MSG_NO_UPD'			=> 'All good! looks like you are up to date! 👍💯',
+-	'START_AUTO'				    => 'Start Auto-update 🚀',
+-	
+-	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s - Changelog</a>',
+-	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
+-	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
+-	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',
+-
+-    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
+-    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
+-    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
+-    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
+-  
+-    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
+-    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
+-	
+-	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
+-	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',
+-
+-	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
+-	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
+-    
+-	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin log under the MAINTENANCE tab.',
+-	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
+-	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',
+-
+-	// autoupdate
+-	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
+-	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP!!!',
+-    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
+-	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
+-	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
+-	'NO_DIRECT_DOWNLOAD'			=> 'Unable to automatically update your style because the style author did not provide the necessary files.',
+-	'PROBLEM_DOWNLOADING_UPDATE'	=> 'Unable to download the update files at the moment. Please try again later.',
+-	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
+-	'MERGE_CONFLICTS'				=> 'Oh No! 😱 ¯\_(ツ)_/¯ The system was unable to automatically update your premium theme. The possbile reasons could be due to your theme files being corrupted or containing custom changes that the auto-update is unable to automatically solve. In order to help you with this situation, see the generated conflicting files and/or conflicts they contain, saved in:<br /><br /><strong>%s</strong>.',
+-	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
+-	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
+-	'UPDATE_SUCCESS'				=> 'Yeehaw! Your Premium Theme has Been Updated Successfully 💯. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="https://themeforest.net/downloads?ref=ThemeSplat" target="_blank">https://themeforest.net/downloads</a>',
+-    'CURRENT_FILE'					=> 'Current file',
+-	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
+-	'NEW_FILE'						=> 'New file',
+-
+-	// log
+-	'LOG_STYLE_UPDATED'	=> '<strong>BBcore auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
+-));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/BBCore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/BBCore.php"
+new file mode 100644
+index 000000000..c4c3ea3d0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/BBCore.php"
+@@ -0,0 +1,399 @@
++<?php
++/**
++*
++* BBCore [Portuguese]
++*
++* @package language
++* @package sitesplat BBcore
++* @version $Id$
++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
++* @copyright (c) 2015 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++// TRANSLATORS PLEASE NOTE	
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
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB')) {
++	exit;
++}
++if (empty($lang) || !is_array($lang)) {
++	$lang = array();
++}
++
++// load addon lang files first...allow BBCore to overwrite if needed
++$addon_lang = [];
++\sitesplat\load_ext_lang(__DIR__, $addon_lang);
++$lang = array_merge($lang, $addon_lang);
++
++// BBCore
++$lang = array_merge($lang, array(
++
++	'PM_NEW_MSG' => [
++		1 => 'Tem %d Nova Mensagem Privada',
++		2 => 'Tem %d Novas Mensagens Privadas',
++	],
++	'PM_UNREAD_MSG' => [
++		1 => 'Tem %d Mensagem Privada Por Ler',
++		2 => 'Tem %d Mensagens Privadas Por Ler',
++	],
++	'PM_NEW_MSG_BUBBLE' => [
++		1 => '%d',
++		2 => '%d',
++	],
++
++	'SITESPLAT_EXT'				=> 'Other Extensions',
++	'BBCORE_DASHBOARD'			=> 'Dashboard',
++	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
++	'BBCORE_SETTINGS'			=> 'Settings',
++	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
++	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
++	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
++	'SS_CHATBOX'				=> 'Chat',
++	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
++	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
++	'SS_ADDONS'				=> 'Addons',
++	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
++	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
++
++	'UCP_MAIN'						 => 'Geral',
++	'UCP_MAIN_FRONT'				 => 'Página Principal',
++	'UCP_MAIN_SUBSCRIPTION'			 => 'Administrar Observações',
++	'UCP_MAIN_BOOKMARKS'			 => 'Administrar Favoritos',
++	'UCP_MAIN_DRAFTS'				 => 'Administrar Rascunhos',
++	'UCP_MAIN_ATTACHMENTS'			 => 'Administrar Anexos',
++
++	'USER_PANEL'					 => 'Painel de Controlo',
++	'UCP_PROFILE'					 => 'Perfil',
++	'UCP_PROFILE_PROFILE'			 => 'Editar Perfil',
++	'UCP_PROFILE_SIGNITURE'			 => 'Editar Assinatura',
++	'UCP_PROFILE_AVATAR'			 => 'Editar Avatar',
++	'UCP_PROFILE_SETTINGS'			 => 'Detalhes da Conta',
++	'UCP_AVATAR_SELECT_OPTIONS'		 => 'Opções do Avatar', 
++	'UCP_AVATAR_SELECT_UPLOAD'		 => 'Envie o avatar a partir do seu dispositivo',
++	'UCP_SUBMIT_TO_UPLOAD'			 => 'Clique em baixo para enviar',
++
++	'UCP_PREFERENCE'				 => 'Preferências',
++	'UCP_PREFERENCE_SETTINGS' 		 => 'Editar configurações pessoais',
++	'UCP_PREFERENCE_DEFAULTS' 		 => 'Editar mensagens enviadas',
++	'UCP_PREFERENCE_OPTIONS'		 => 'Editar exibição de mensagens',
++
++	'UCP_MESSAGES'					 => 'Mensagens Privadas',
++	'UCP_PM_COMPOSE'				 => 'Criar mensagem privada',
++	'UCP_PM_DRAFTS'					 => 'Administrar rascunhos',
++	'UCP_PM_INBOX'					 => 'Caixa de Entrada',
++	'UCP_PM_OUTBOX'					 => 'Caixa de Saída',
++	'UCP_PM_SENTBOX'				 => 'Mensagens Enviadas',
++	'UCP_PM_OPTIONS'				 => 'Opções (Regras e Pastas)',
++	'UCP_NO_USER_CHANGE_ALLOWED'	 => '**Não é permitido alterar o Nome de Utilizador**',
++	'UCP_REGISTER_EMAIL_EXPLAIN'	 => 'Por favor, não utilize emails descartáveis',
++	'UCP_USERGROUPS_EXPLAIN'		 => '(Escolha um grupo e depois clique em Adicionar)',
++
++	'WIDTH_SIZE'					 => 'largura',
++	'PIXEL_SIZE'					 => 'px',
++	'HEIGHT_SIZE'					 => 'altura',
++
++	'UCP_GROUPS'					 => 'Grupos de Utilizadores',
++	'UCP_GROUPS_MEMBERSHIP'			 => 'Editar Inscrições em Grupos',
++	'UCP_GROUPS_MANAGE'				 => 'Administrar grupos',
++
++	'UCP_ZEBRA'						 => 'Amigos e Inimigos',
++	'UCP_ZEBRA_FRIENDS'				 => 'Administrar Amigos',
++	'UCP_ZEBRA_FOES'				 => 'Administrar Inimigos',
++	'UCP_APPLY'						 => 'Alterar',
++	'UCP_PM_DEFAULT_RULE_TAG'		 => 'Acção Padrão',
++	'UCP_PM_DEFAULT_RULE'			 => 'Não serão aceitas novas Mensagens',
++	'UCP_PM_DEFAULT_RULE_EXPLAIN'	 => 'Esta acção será despoletada se se verificar a regra mencionada. As Mensagens novas serão mantidas até haver espaço disponível',
++	'UCP_PM_NEW_MESSAGE'			 => 'Nova Mensagem',
++	'BIO'							 => 'Informações Pessoais',
++	'MANAGE'						 => 'Gerir',
++	'JOINED_BOARD'					 => 'Entrou no Fórum', //Registou-se?
++	'VISITED_BOARD'					 => 'Última visita',
++	'SEE_MORE'						 => 'Mais',
++	'ATTACH_SIGNATURE'				 => 'Anexar assinatura',
++	'BBCODES'						 => 'BBcodes',
++
++	'DELETE_POST_SOFT'				 => 'Enviar Mensagem para a Reciclagem',
++	'DELETE_POST_PERMANENT'			 => 'Apagar Mensagem Permanentemente ',
++	'DELETE_POST_SOFT_WARN'			 => 'Poderá ser recuperada',
++	'DELETE_POST_PERMANENT_WARN'	 => 'NÃO poderá ser recuperada',
++
++	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	 => 'Introduza o número máx. de opções que o utilizador poderá seleccionar',
++	'POLL_VOTE_CHANGE_LABEL'		 => 'Permitir Alterar Voto',
++	'NO_VOTES_NA'					 => 'N/A',
++	'NOT_AVAILABLE'					 => 'Indisponível',
++	'POST_TOPIC_NEW'				 => 'Novo Tópico',
++	'QUICK_REPLY_SHOW_HIDE'			 => 'Mostrar/Ocultar Resposta Rápida',
++	'CHARACTERS_COUNT'				 => 'Carácter',
++	'CHARACTERS_COUNT_REM'			 => 'Restantes',
++	'BOOKMARKED_TOPICS_UCP'			 => 'Tópicos favoritos',
++	'ATTACH_EXPLANATION_SORTABLE'	 => 'Clique para ordenar',
++	'ATTACH_FORUM'					 => 'Anexo(s)',
++	'MCP_DETAILS_LOG'				 => 'Detalhes',
++	'MCP_DETAIL_U_IP'				 => 'Utilizador &amp; IP',
++	'MCP_MANAG_BAN'					 => 'Administrar Expulsões',
++	'MCP_UNAPPROVED_POSTS_ZERO'		 => 'Não existem mensagens por aprovar',
++	'MCP_REPORTS_ZERO'				 => 'Não existem denúncias de Mensagens para rever',
++	'MCP_PM_REPORTS_ZERO'			 => 'Não existem denúncias de Mensagens Privadas para rever',
++
++
++	'SUBFORUM_LINK'					 => 'Endereço abre numa nova aba',
++	'FORUMLIST_UNAPPROVED'			 => 'Falta pelo menos um tópico neste fórum por aprovar',
++	'FORUMLIST_UNAPPROVED_POST'		 => 'Falta pelo menos uma mensagem neste fórum por aprovar', 
++	'FORUMLIST_LASTPOST'			 => 'Ver a última mensagem',
++	'TOPICS_POSTS_STATISTICS'		 => 'Estatísticas',
++	'TOPICS_ROW_REPORTED'			 => 'Este tópico foi reportado',
++	'TOPICS_ROW_NOT_APPROVED'		 => 'Este tópico não foi aprovado',
++	'TOPICS_ROW_DELETED'			 => 'Este tópico foi apagado',
++	'MODERATOR_PANEL_GENERAL'		 => 'Painel de Moderação',
++	'ADMIN_PANEL_GENERAL'			 => 'Painel de Administração',
++	'RANK_IMAGE'					 => 'Imagem de Rank',
++
++	'WELCOME_INDEX'					 => 'Bem-vindo',
++	'FAQ'							 => 'FAQ',
++	'CAPTION_FAQ'					 => 'Questões Mais Frequentes',
++	'CAPTION_SEARCH'				 => 'Procura primeiro!',
++	'CAPTION_MEMBERS'				 => 'À procura de alguém?',
++	'MEMBERS_CAP'					 => 'Membros',
++	'CAPTION_UCP'					 => 'Defina as suas preferências',
++	'UCP_CAP'						 => 'Painel de Controlo do Utilizador',
++	'INDEX_CAPTION'					 => 'Esta é a página índice do fórum',
++	'VIEWTOPIC_CAP'					 => 'Título do Tópico',
++	'CAPTION_VIEWTOPIC'				 => 'Descrição do Tópico',
++	'CAPTION_VIEWFORUM'				 => 'Navegar por todas as categorias do fórum',
++	'POSTINGS_CAP'					 => 'Editor de Mensagens',
++	'CAPTION_POSTINGS'				 => 'A colocar conteúdo!',
++
++	'MCP_CAPTION'					 => 'É aqui que podes usar os teus Super-Poderes ;-)',
++	'BOOTSTRAP_ELEMENT'				 => 'Elementos Bootstrap',
++	'BOOTSTRAP_ELEMENT_CAPTION'		 => 'Documentação do Fórum KickStart',
++	'MAIN_FORUM'					 => 'Fórum',
++	'MAIN_MAIN_STUFF'				 => 'As principais coisas',
++	'MAIN_TRENDS'					 => 'Veja as tendências',
++
++	'MAIN_SEARCH_IT_UP'				 => 'Procura primeiro',
++	'SUB_NO_ICON'					 => 'Não foram encontrados ícones',
++	'EXAMPLE_WITH_ICON'				 => 'Exemplo com Ícone',
++	'EXAMPLE_LINK'					 => 'Exemplo com Endereço',
++	'MAIN_SOCIAL'					 => 'Social',
++	'SOCIAL_P'						 => 'Conversar à pala ;-)',
++
++	'MORE'							 => 'Mais',
++	'EXPAND_CLOSE'					 => 'Fechar Vista',
++	'MARK_TOPICS_READ'				 => 'Marcar tópicos como lidos',
++	'CONTACT'						 => 'Contacto',
++	'GET_IN_TOUCH'					 => 'Entra em contacto',
++	'HANG_AROUND'					 => 'Participa',
++	'JOIN_THE_CLUB'					 => 'Junta-te ao clube',
++	'MENU'							 => 'MENU',
++	'YOU_ARE_HERE'					 => 'Estás aqui',
++	'IN_FOOTER'						 => 'Em:',
++	'REPLY'							 => 'Resposta',
++
++	'LOGIN_REMEMBER'				 => 'Continuar conectado',
++	'LOGIN_HIDE_ME'					 => 'Ocultar sessão',
++	'LOGIN_ME_IN'					 => 'Entrar',
++	'SIGN_IN_ACCOUNT'				 => 'Entrar na conta',
++	'CREATE_ACCOUNT'				 => 'Criar Conta',
++	'GO_TO_SEARCH_ADV'				 => 'Regressar à pesquisa avançada',
++
++	'CREATE_ACCOUNT_DISABLED'		 => 'Os registos estão encerrados',
++	'REGISTRATION_DISABLED'			 => 'Os registos estão de momento encerrados, apenas poderá criar conta por convite. Pedimos desculpa pelo inconveniente. A nossa Política de Privacidade e Termos de Uso estão disponíveis em baixo. Vê a Ajuda para mais informações sobre os convites.',
++	'CONTACT_WEBMASTER'				 => 'Contacta o Administrador',
++	'CONFIRM_QA_EXPLAIN_ALT'		 => 'Prova que és humano e responde à seguinte questão',
++
++	'PLUPLOAD_PLACE_INLINE'			 => 'Adicionar',
++	'PLUPLOAD_DELETE_FILE'			 => 'Apagar',
++
++
++	'REG_CREATING'					 => 'A Criar perfil...',
++	'LOADING'						 => 'A Carregar...',
++	'SAVING'						 => 'A Guardar...',
++	'CANCELLING'					 => 'A Cancelar...',
++	'SENDING'						 => 'A Enviar...',
++	'SEARCHING'						 => 'A Pesquisar...',
++	'LOADING_LOG_IN'				 => 'A Conectar-se...',
++	'FILE_UPLOADING'				 => 'A Enviar Ficheiro...',
++	'CASTING_VOTE'					 => 'A Enviar Voto...',
++	'LOADING_FORM'					 => 'A Carregar Formulário...',
++
++	'MEMBERLIST_P_JOINED'			 => 'Registou-se no fórum',
++	'MEMBERLIST_P_EXPL'				 => 'Quando me registei no fórum',
++	'MEMBERLIST_P_DATE_EXPL'		 => 'Última vez que visitei o fórum',
++	'SPAMMER'						 => 'Spammer',
++	'SPAMMER_PLACEHOLDER'			 => 'Não podes simplesmente fazer Spam e sair impune!',
++	'MARK_PLACEHOLDER'				 => 'Coloque visto na sua escolha',
++	'INFO_BOX'						 => 'Informações:',
++	'USER_REMOVE_PLACEHOLDER'		 => 'Clique para remover o utilizador',
++	'GROUP_REMOVE_PLACEHOLDER'		 => 'Clique para remover o grupo',
++	'EDIT_LINK_PLACEHOLDER'			 => 'Esqueci-me de colocar código nos meus endereços',
++	'POST_IT_UP_PLACEHOLDER'		 => 'Enviar!',
++
++	'UCP_REG_USR_PLACEHOLDER'		 => 'E.g. John Doe',
++	'UCP_REG_EMAIL_PLACEHOLDER'		 => 'E.g. john@mail.com',
++	'UCP_REG_PSWD_PLACEHOLDER'		 => 'E.g. ASDFasdf123',
++	'UCP_REG_CTCHA_PLACEHOLDER'		 => 'E.g. golden sky',
++	'SEARCH_USR_PLACEHOLDER'		 => 'E.g. GoldTugAnime',
++	'YEAR_MONTH_DAY_PLACEHOLDER'	 => 'E.g. 2018-12-22',
++	'IP_PLACEHOLDER'				 => 'E.g. 216.161.111.33',
++	'POSTS_PLACEHOLDER'				 => 'E.g. 12',
++	'SEARCH_KWDS_PLACEHOLDER'		 => 'E.g. gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',
++
++	'MESSAGE_ENTER_PLACEHOLDER'		 => 'Introduza a sua mensagem...',
++	'FILE_COMMENT_PLACEHOLDER'		 => 'Espaço reservado para comentários',
++	'HEIGTH_PLACEHOLDER'			 => 'altura',
++	'WIDTH_PLACEHOLDER'				 => 'largura',
++	'UCP_OCCUPATION_PLACEHOLDER'	 => 'Descreve de forma breve a tua profissão...',
++	'UCP_INTERESTS_PLACEHOLDER'		 => 'Descreve os teus interesses...',
++	'SOFT_DELETE_PLACEHOLDER'		 => 'Adiciona os teus motivos, caso desejes...',
++	'ADD_DESCRIPTION'				 => 'Adicionar descrição',
++
++	'FILE_SELECT'					 => 'Seleccione o ficheiro',
++	'FILE_CHANGE'					 => 'Alterar',
++	'SELECT_IMAGE'					 => 'Seleccione a imagem',
++	'NOTE'							 => 'Observação',
++	'EDIT_DRAFT'					 => 'Editar Rascunho',
++	'PM_BALOON_NOTIFICATION'		 => 'Activar notificação de MP (Mensagem Privada) via Pop-Up',
++	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Marcar todas como lidas',
++	'DAYS_AGO'						 => 'Dias atrás',
++	'WORK_IN_PROGRESS'				 => 'Manutenção',
++	'DISABLE_MESSAGE'				 => 'Fórum indisponível',
++	'DISABLE_RETURN'				 => 'Voltar à página de índice',
++	'BOARD_DISABLED_SHUFFLE'		 => 'Diverte-te e embaralha algumas letras :-)',
++	'DISABLE_TEXT_TRY'				 => 'Testa tu mesmo!',
++	'DISABLE_TEXT_TYPE'				 => 'Digite algo, e pressione retroceder...',
++
++	'GRAVATAR_EXPLAIN'				 => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, será usado por defeito.',
++	'GRAVATAR_EXPLAIN_CONFIRM'		 => 'Por favor, confirme o seu endereço de e-mail aqui',
++
++	'DELETE_POLL'					 => 'Apagar Votação',
++	'POLL_DELETE_HELPER'			 => '(Isto apenas apaga a votação) verificar e submeter',
++	'JUMP_TO_POST'					 => 'Ir para a mensagem',
++	'JUMP_SELECT_FORUM'				 => 'Selecciona o Fórum para onde ir',
++	'JUMP_TO_PAGE_NUMBER'			 => 'Ir para #',
++	'VIEW_FIRST_UNREAD'				 => 'Ver primeira mensagem não lida.',
++	'BOOKMARK_TOPIC_REMOVE'			 => 'Remover tópico dos favoritos',
++
++	'NEW_MESSAGES'					 => 'Novas mensagens',
++	'YOU_HAVE'						 => 'Você tem',
++	'AND'							 => 'e',
++	'HELLO'							 => 'Olá',
++	'DISMISS_PM'					 => 'Adiar 5 minutos',
++	'READ_NOW'						 => 'Leia agora',
++	'PRIVATE_MESSAGE_NEW'			 => 'nova mensagem privada',
++	'PRIVATE_MESSAGE_UNREAD'		 => 'mensagem privada por ler',
++	'NO_PMS_INFO'					 => 'Tudo em dia! Escrever nova MP?',
++
++	'DATES'							 => 'DATA',
++	'POWERED'						 => 'Baseado em',
++	'HANDCRAFTED'					 => 'Desenvolvido Com',
++	'BY'							 => 'Por',
++
++	'RECENT_TOPICS'					 => 'Tópicos recentes',
++	'TWITTER'						 => 'Twitter',
++	'FAVORITES'						 => 'Favoritos',
++
++	'GALLERY'						 => 'Galeria',
++	'CHAT'							 => 'Chat',
++	'ABOUT'							 => 'Sobre Nós',
++	'ABOUT_PART_ONE'				 => 'BBOOTS&#8482; É o primeiro e único Tema, HTML5/CSS3 não-oficial, totalmente Ágil de PhpBB&reg;. É limpo e nítido. Com um Design INCRÍVEL e compatível com todos os navegadores e dispositivos.',
++	'ABOUT_PART_TWO'				 => 'Utiliza um layout com base no Bootstrap, há muito esperado, e que irá surpreender os fãs da plataforma phpBB.',
++	'ABOUT_PART_THREE'				 => 'O Tema Ágil Não-Oficial',
++	'BB'							 => 'B',
++	'BOOTS'							 => 'BOOTS',
++	'BBOOTS'						 => 'BBOOTS',
++
++	'BBOOTS_VERSION'				 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
++	'U_LOGOUT'						 => 'Sair',
++
++	'SITESPLAT_STATISTICS'			 => 'Estatísticas',
++	'SITESPLAT_SEE_DETAILS'			 => 'Ver detalhes',
++	'SITESPLAT_SEARCH_LAST_DAY'		 => 'Mensagens das últimas 24h',
++	'SITESPLAT_SEARCH_WEEK'			 => 'Mensagens dos últimos 7 dias',
++
++	'SITESPLAT_TOTAL_POSTS'			 => 'Total de mensagens',
++	'SITESPLAT_TOTAL_TOPICS'		 => 'Total de tópicos',
++	'SITESPLAT_TOTAL_USERS'			 => 'Total de utilizadores',
++	'SITESPLAT_NEWEST_MEMBER'		 => 'Novo utilizador',
++	'SITESPLAT_USERS_ONLINE'		 => 'Utilizadores Online',
++	'SITESPLAT_MOST_USERS_ONLINE'	 => 'Recorde de Utilizadores Online',
++	'SITESPLAT_BIRTHDAYS'			 => 'Aniversariantes',
++
++	'BOOTSTRAP_VERSION'				 => '3.3.6',
++	'FLATBOOTS'						 => 'FLATBOOTS',
++	'CHANGE_AVATAR'					 => 'Alterar Avatar',
++	'CHANGE_PASSWORD'				 => 'Alterar Senha',
++
++	'ADMIN_TIPS'					 => 'Truques e Dicas dos Administradores',
++	'ADMIN_TIP_INTRO'				 => 'Sabias que podes tornar o teu fórum phpBB ainda mais seguro com apenas alguns passos simples?',
++	'ADMIN_TIP_ONE'					 => 'Mantém o teu software actualizado.',
++	'ADMIN_TIP_TWO'					 => 'Usa sempre boas senhas que contenham sequências aleatórias de números, letras e caracteres especiais.',
++	'ADMIN_TIP_THREE'				 => 'Restrinja o acesso à zona de administração...',
++	'ADMIN_CHECK_IT_BTN'			 => 'Visita SiteSplat.com para mais informação',
++
++	'USER_MINI_PROFILE'				 => 'Mini-perfil do utilizador',
++	'USER_MINI_PROFILE_VIEW_FULL'	 => 'Ver o perfil completo',
++	'OFF_LINE'						 => 'Desconectado',
++	'USER_STATUS'					 => 'Estado',
++	'USER'							 => 'Utilizador',
++	'TITLE'							 => 'Título',
++	'END_TIMELINE'					 => 'Cronograma final',
++	'MEMBERS'						 => 'Utilizadores',
++	'DRAFTS'						 => 'Rascunhos',
++	'REPORTS'						 => 'Denúncias',
++	'MODERATOR_LOGS'				 => 'Registos de Moderador',
++	'QUEUE'							 => 'Moderação',
++	'LINKS'							 => 'Endereços',
++	'TOPIC_PERMISSIONS'				 => 'Permissões do tópico',
++	'MODERATOR_OPTIONS'				 => 'Moderar',
++	'PASSWORD_EXPLAIN_CONFIRM'		 => 'Certifique-se que corresponde',
++	'FORUM_REDIRECTS'				 => 'Redireccionamentos:',
++
++	'FANCY_TOPICS_TITLE'			 => 'Tópicos recentes do fórum',
++	'POST_BY'						 => 'Criado por',
++	'REPLY_BY'						 => 'Respondido por',
++	'NO_REPLIES'					 => 'Sem resposta',
++	'READ_MORE'						 => 'Ler mais',
++	'RT_READ_MORE'					 => 'LER MAIS',
++	'VIEW_MORE_TOPICS'				 => 'VER MAIS TÓPICOS',
++	'BACK_TO_START'					 => 'VOLTAR AO INÍCIO',
++
++	'TOGGLE_NAV'					 => 'Alterar Navegação',
++	'NAVIGATION'					 => 'Navegação',
++
++	'DEMO_LINK'						 => 'Apenas demonstração, não existe ícones',
++	'DEMO_HEADER_MENU'				 => 'Exemplo de cabeçalho da introdução',
++
++	'FLATBOOTS_INTRO'				 => 'Bootstrap Framework',
++	'FLATBOOTS_EXPLAIN'				 => 'Mais de uma dúzia de componentes reutilizáveis, criado para fornecer iconografia, menus suspensos, grupos de entrada, sistema de navegação, notificações e muito mais...',
++	'CALL_TO_ACTION_FOOTER'			 => 'Active e desactive addons, use apenas o que realmente precisa!',
++	'PURCHASE_NOW_BTN'				 => 'Compre agora',
++	'FLATBOOTS_ABOUT_PART_ONE'		 => 'Porque é que iria contentar-se com menos, quando pode ter mais? Não deixe que outros autores o enganem com jogadas de Marketing. O FLATBOOTS é aquilo que merece. Construído para durar, construído a partir do zero, nada mais, nada menos.',
++	'FLATBOOTS_ABOUT_TITLE'			 => 'Construído para durar',
++	'DMCA'							 => 'DMCA',
++	'TERMS'							 => 'Termos e Condições',
++	'ADVERTISE'						 => 'Divulgue',
++	'DEVELOPER'						 => 'Desenvolvido por',
++	'LEINAD4MIND'					 => 'Leinad4Mind',
++	'SITESPLAT_URL'					 => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
++	'JOIN_US_TWITTER'				 => 'Segue-nos!',
++	'TWEET_EXAMPLE'					 => 'O BBOOTS atingiu as 500 vendas! Obrigado a todos os que apoiam este projecto e que contribuem com o SiteSplat para construir a comunidade. O que o futuro reserva? Mantém-te a par e segue-me no Twitter. <a href="#">http://bit.ly/000fefs</a>',
++
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/filesystem.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/filesystem.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/filesystem.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/filesystem.php"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_acp_bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_acp_bbcore.php"
+new file mode 100644
+index 000000000..29468e2a0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_acp_bbcore.php"
+@@ -0,0 +1,60 @@
++<?php
++/**
++*
++* common [Portuguese]
++*
++* @package language
++* @package sitesplat BBcore
++* @version $Id$
++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
++* @copyright (c) 2015 SiteSplat All rights reserved
++* @license Proprietary
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
++$lang = array_merge($lang, array(
++
++	'ACP_SITESPLAT_UPDATE_MANAGER'	 => 'Administrar Actualizações de SiteSplat',
++	'VERSION_INSTALLED'				 => 'Versão Instalada',
++	'NEW_BOOTS_VERSION'				 => 'Nova versão disponível: %s',
++	'VERSIONNUMBERS'				 => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
++	'SS_RAPID_DISABLE'				 => 'Desactivar Rápido SS',
++	'SS_RAPID_DISABLE_TLT'			 => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',
++
++	'DOWNLOAD_MSG'					 => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
++	'CHANGE_LOG_MSG'				 => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
++	'SUPPORT_FORUM_MSG'				 => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
++	'COLORIZE_MSG'					 => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
++	'NO_VERSIONINFO'				 => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',
++
++	'LOG_FILES_CHANGED'				 => '<strong>O BBcore alterou o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
++	'LOG_THEME_INSTALLED'			 => '<strong>O BBcore foi instalado com sucesso</strong>',
++	'LOG_FILES_CHANGED_FAILED'		 => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
++	'LOG_THEME_UNINSTALLED'			 => '<strong>O BBcore foi desinstalado com sucesso</strong>',
++
++	'LOG_FILE_NOT_REPLACED'			 => '<strong>O BBcore não conseguiu substituir o ficheiro original por ti:</strong><br />» %s',
++	'LOG_FILE_NOT_UPDATED'			 => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
++
++	'LOG_BBCORE_INSTALLED'			 => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
++	'LOG_BBCORE_DEINSTALLED'		 => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',
++
++	'LOG_BBCORE_NOT_REPLACED'		 => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) ficheiro(s)<br />» %s',
++	'LOG_BBCORE_NOT_UPDATED'		 => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) ficheiro(s)<br />» %s',
++
++	'ACP_BBCORE_MSG_FILES_FAIL'		 => 'Nem TODOS os ficheiros foram editados! Por favor, substitui manualmente o(s) ficheiro(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
++	'ACP_BBCORE_MSG_SETTINGS'		 => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de ficheiros no servidor ou à falta de ficheiros nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os ficheiros manualmente para desfrutar de todas as funcionalidades.',
++	'BBCORE_ERROR_DISABLE'			 => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
+similarity index 78%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
+index a8de9ceef..e0c4569f2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
+@@ -3,6 +3,7 @@
+ *
+ * @package language
+ * @package sitesplat BBcore addon
++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+ * @copyright (c) 2015 SiteSplat All rights reserved
+ * @license Proprietary
+ *
+@@ -55,14 +56,14 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge(
+ 	$lang, array(
+-		'UCP_IR'				    => 'Image Resizer',
+-		'IMAGE_RESIZE'			    => 'Image Resize',
+-		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
++		'UCP_IR'				    => 'Redimensionar Imagem',
++		'IMAGE_RESIZE'			    => 'Redimensionamento de Imagem',
++		'IMAGE_RESIZE_EXPLAIN'	    => 'Corte %1$s da imagem e confirme.',
+ 		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',
+ 
+-		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
++		'IMAGE_RESIZE_ERROR'	    => 'Nenhuma app ou ficheiro para enviar!',
+ 		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
+-		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
+-	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable AvatarResize because of other active premium extensions<br /><div>» %s</div>',
++	    'SS_HELPER_NOTY'	    	=> 'Core does not exist!<br />Download and copy the Core folder into your sitesplat extension folder.',
+ 	)
+ );
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/BBCore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/BBCore.php"
+new file mode 100644
+index 000000000..1d560bb4e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/BBCore.php"
+@@ -0,0 +1,399 @@
++<?php
++/**
++*
++* BBCore [Portuguese]
++*
++* @package language
++* @package sitesplat BBcore
++* @version $Id$
++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
++* @copyright (c) 2015 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++// TRANSLATORS PLEASE NOTE	
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
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB')) {
++	exit;
++}
++if (empty($lang) || !is_array($lang)) {
++	$lang = array();
++}
++
++// load addon lang files first...allow BBCore to overwrite if needed
++$addon_lang = [];
++\sitesplat\load_ext_lang(__DIR__, $addon_lang);
++$lang = array_merge($lang, $addon_lang);
++
++// BBCore
++$lang = array_merge($lang, array(
++
++	'PM_NEW_MSG' => [
++		1 => 'Tem %d Nova Mensagem Privada',
++		2 => 'Tem %d Novas Mensagens Privadas',
++	],
++	'PM_UNREAD_MSG' => [
++		1 => 'Tem %d Mensagem Privada Por Ler',
++		2 => 'Tem %d Mensagens Privadas Por Ler',
++	],
++	'PM_NEW_MSG_BUBBLE' => [
++		1 => '%d',
++		2 => '%d',
++	],
++
++	'SITESPLAT_EXT'				=> 'Other Extensions',
++	'BBCORE_DASHBOARD'			=> 'Dashboard',
++	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
++	'BBCORE_SETTINGS'			=> 'Settings',
++	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
++	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
++	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
++	'SS_CHATBOX'				=> 'Chat',
++	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
++	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
++	'SS_ADDONS'				=> 'Addons',
++	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
++	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
++
++	'UCP_MAIN'						 => 'Geral',
++	'UCP_MAIN_FRONT'				 => 'Página Principal',
++	'UCP_MAIN_SUBSCRIPTION'			 => 'Administrar Observações',
++	'UCP_MAIN_BOOKMARKS'			 => 'Administrar Favoritos',
++	'UCP_MAIN_DRAFTS'				 => 'Administrar Rascunhos',
++	'UCP_MAIN_ATTACHMENTS'			 => 'Administrar Anexos',
++
++	'USER_PANEL'					 => 'Painel de Controlo',
++	'UCP_PROFILE'					 => 'Perfil',
++	'UCP_PROFILE_PROFILE'			 => 'Editar Perfil',
++	'UCP_PROFILE_SIGNITURE'			 => 'Editar Assinatura',
++	'UCP_PROFILE_AVATAR'			 => 'Editar Avatar',
++	'UCP_PROFILE_SETTINGS'			 => 'Detalhes da Conta',
++	'UCP_AVATAR_SELECT_OPTIONS'		 => 'Opções do Avatar', 
++	'UCP_AVATAR_SELECT_UPLOAD'		 => 'Envie o avatar a partir do seu dispositivo',
++	'UCP_SUBMIT_TO_UPLOAD'			 => 'Clique em baixo para enviar',
++
++	'UCP_PREFERENCE'				 => 'Preferências',
++	'UCP_PREFERENCE_SETTINGS' 		 => 'Editar configurações pessoais',
++	'UCP_PREFERENCE_DEFAULTS' 		 => 'Editar mensagens enviadas',
++	'UCP_PREFERENCE_OPTIONS'		 => 'Editar exibição de mensagens',
++
++	'UCP_MESSAGES'					 => 'Mensagens Privadas',
++	'UCP_PM_COMPOSE'				 => 'Criar mensagem privada',
++	'UCP_PM_DRAFTS'					 => 'Administrar rascunhos',
++	'UCP_PM_INBOX'					 => 'Caixa de Entrada',
++	'UCP_PM_OUTBOX'					 => 'Caixa de Saída',
++	'UCP_PM_SENTBOX'				 => 'Mensagens Enviadas',
++	'UCP_PM_OPTIONS'				 => 'Opções (Regras e Pastas)',
++	'UCP_NO_USER_CHANGE_ALLOWED'	 => '**Não é permitido alterar o Nome de Utilizador**',
++	'UCP_REGISTER_EMAIL_EXPLAIN'	 => 'Por favor, não utilize emails descartáveis',
++	'UCP_USERGROUPS_EXPLAIN'		 => '(Escolha um grupo e depois clique em Adicionar)',
++
++	'WIDTH_SIZE'					 => 'largura',
++	'PIXEL_SIZE'					 => 'px',
++	'HEIGHT_SIZE'					 => 'altura',
++
++	'UCP_GROUPS'					 => 'Grupos de Utilizadores',
++	'UCP_GROUPS_MEMBERSHIP'			 => 'Editar Inscrições em Grupos',
++	'UCP_GROUPS_MANAGE'				 => 'Administrar grupos',
++
++	'UCP_ZEBRA'						 => 'Amigos e Inimigos',
++	'UCP_ZEBRA_FRIENDS'				 => 'Administrar Amigos',
++	'UCP_ZEBRA_FOES'				 => 'Administrar Inimigos',
++	'UCP_APPLY'						 => 'Alterar',
++	'UCP_PM_DEFAULT_RULE_TAG'		 => 'Acção Padrão',
++	'UCP_PM_DEFAULT_RULE'			 => 'Não serão aceitas novas Mensagens',
++	'UCP_PM_DEFAULT_RULE_EXPLAIN'	 => 'Esta acção será despoletada se se verificar a regra mencionada. As Mensagens novas serão mantidas até haver espaço disponível',
++	'UCP_PM_NEW_MESSAGE'			 => 'Nova Mensagem',
++	'BIO'							 => 'Informações Pessoais',
++	'MANAGE'						 => 'Gerir',
++	'JOINED_BOARD'					 => 'Entrou no Fórum', //Registou-se?
++	'VISITED_BOARD'					 => 'Última visita',
++	'SEE_MORE'						 => 'Mais',
++	'ATTACH_SIGNATURE'				 => 'Anexar assinatura',
++	'BBCODES'						 => 'BBcodes',
++
++	'DELETE_POST_SOFT'				 => 'Enviar Mensagem para a Reciclagem',
++	'DELETE_POST_PERMANENT'			 => 'Apagar Mensagem Permanentemente ',
++	'DELETE_POST_SOFT_WARN'			 => 'Poderá ser recuperada',
++	'DELETE_POST_PERMANENT_WARN'	 => 'NÃO poderá ser recuperada',
++
++	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	 => 'Introduza o número máx. de opções que o utilizador poderá seleccionar',
++	'POLL_VOTE_CHANGE_LABEL'		 => 'Permitir Alterar Voto',
++	'NO_VOTES_NA'					 => 'N/A',
++	'NOT_AVAILABLE'					 => 'Indisponível',
++	'POST_TOPIC_NEW'				 => 'Novo Tópico',
++	'QUICK_REPLY_SHOW_HIDE'			 => 'Mostrar/Ocultar Resposta Rápida',
++	'CHARACTERS_COUNT'				 => 'Carácter',
++	'CHARACTERS_COUNT_REM'			 => 'Restantes',
++	'BOOKMARKED_TOPICS_UCP'			 => 'Tópicos favoritos',
++	'ATTACH_EXPLANATION_SORTABLE'	 => 'Clique para ordenar',
++	'ATTACH_FORUM'					 => 'Anexo(s)',
++	'MCP_DETAILS_LOG'				 => 'Detalhes',
++	'MCP_DETAIL_U_IP'				 => 'Utilizador &amp; IP',
++	'MCP_MANAG_BAN'					 => 'Administrar Expulsões',
++	'MCP_UNAPPROVED_POSTS_ZERO'		 => 'Não existem mensagens por aprovar',
++	'MCP_REPORTS_ZERO'				 => 'Não existem denúncias de Mensagens para rever',
++	'MCP_PM_REPORTS_ZERO'			 => 'Não existem denúncias de Mensagens Privadas para rever',
++
++
++	'SUBFORUM_LINK'					 => 'Endereço abre numa nova aba',
++	'FORUMLIST_UNAPPROVED'			 => 'Falta pelo menos um tópico neste fórum por aprovar',
++	'FORUMLIST_UNAPPROVED_POST'		 => 'Falta pelo menos uma mensagem neste fórum por aprovar', 
++	'FORUMLIST_LASTPOST'			 => 'Ver a última mensagem',
++	'TOPICS_POSTS_STATISTICS'		 => 'Estatísticas',
++	'TOPICS_ROW_REPORTED'			 => 'Este tópico foi reportado',
++	'TOPICS_ROW_NOT_APPROVED'		 => 'Este tópico não foi aprovado',
++	'TOPICS_ROW_DELETED'			 => 'Este tópico foi apagado',
++	'MODERATOR_PANEL_GENERAL'		 => 'Painel de Moderação',
++	'ADMIN_PANEL_GENERAL'			 => 'Painel de Administração',
++	'RANK_IMAGE'					 => 'Imagem de Rank',
++
++	'WELCOME_INDEX'					 => 'Bem-vindo',
++	'FAQ'							 => 'FAQ',
++	'CAPTION_FAQ'					 => 'Questões Mais Frequentes',
++	'CAPTION_SEARCH'				 => 'Procura primeiro!',
++	'CAPTION_MEMBERS'				 => 'À procura de alguém?',
++	'MEMBERS_CAP'					 => 'Membros',
++	'CAPTION_UCP'					 => 'Defina as suas preferências',
++	'UCP_CAP'						 => 'Painel de Controlo do Utilizador',
++	'INDEX_CAPTION'					 => 'Esta é a página índice do fórum',
++	'VIEWTOPIC_CAP'					 => 'Título do Tópico',
++	'CAPTION_VIEWTOPIC'				 => 'Descrição do Tópico',
++	'CAPTION_VIEWFORUM'				 => 'Navegar por todas as categorias do fórum',
++	'POSTINGS_CAP'					 => 'Editor de Mensagens',
++	'CAPTION_POSTINGS'				 => 'A colocar conteúdo!',
++
++	'MCP_CAPTION'					 => 'É aqui que podes usar os teus Super-Poderes ;-)',
++	'BOOTSTRAP_ELEMENT'				 => 'Elementos Bootstrap',
++	'BOOTSTRAP_ELEMENT_CAPTION'		 => 'Documentação do Fórum KickStart',
++	'MAIN_FORUM'					 => 'Fórum',
++	'MAIN_MAIN_STUFF'				 => 'As principais coisas',
++	'MAIN_TRENDS'					 => 'Veja as tendências',
++
++	'MAIN_SEARCH_IT_UP'				 => 'Procura primeiro',
++	'SUB_NO_ICON'					 => 'Não foram encontrados ícones',
++	'EXAMPLE_WITH_ICON'				 => 'Exemplo com Ícone',
++	'EXAMPLE_LINK'					 => 'Exemplo com Endereço',
++	'MAIN_SOCIAL'					 => 'Social',
++	'SOCIAL_P'						 => 'Conversar à pala ;-)',
++
++	'MORE'							 => 'Mais',
++	'EXPAND_CLOSE'					 => 'Fechar Vista',
++	'MARK_TOPICS_READ'				 => 'Marcar tópicos como lidos',
++	'CONTACT'						 => 'Contacto',
++	'GET_IN_TOUCH'					 => 'Entra em contacto',
++	'HANG_AROUND'					 => 'Participa',
++	'JOIN_THE_CLUB'					 => 'Junta-te ao clube',
++	'MENU'							 => 'MENU',
++	'YOU_ARE_HERE'					 => 'Estás aqui',
++	'IN_FOOTER'						 => 'Em:',
++	'REPLY'							 => 'Resposta',
++
++	'LOGIN_REMEMBER'				 => 'Continuar conectado',
++	'LOGIN_HIDE_ME'					 => 'Ocultar sessão',
++	'LOGIN_ME_IN'					 => 'Entrar',
++	'SIGN_IN_ACCOUNT'				 => 'Entrar na conta',
++	'CREATE_ACCOUNT'				 => 'Criar Conta',
++	'GO_TO_SEARCH_ADV'				 => 'Regressar à pesquisa avançada',
++
++	'CREATE_ACCOUNT_DISABLED'		 => 'Os registos estão encerrados',
++	'REGISTRATION_DISABLED'			 => 'Parece que os registos estão de momento encerrados, pode ser temporário. Se acha que é um erro, entre em contacto com o Administrador e informe sobre a situação. Pedimos desculpa pelo inconveniente. A nossa Política de Privacidade e Termos de Uso estão disponíveis em baixo.',
++	'CONTACT_WEBMASTER'				 => 'Contacta o Administrador',
++	'CONFIRM_QA_EXPLAIN_ALT'		 => 'Prova que és humano e responde à seguinte questão',
++
++	'PLUPLOAD_PLACE_INLINE'			 => 'Adicionar',
++	'PLUPLOAD_DELETE_FILE'			 => 'Apagar',
++
++
++	'REG_CREATING'					 => 'A Criar perfil...',
++	'LOADING'						 => 'A Carregar...',
++	'SAVING'						 => 'A Guardar...',
++	'CANCELLING'					 => 'A Cancelar...',
++	'SENDING'						 => 'A Enviar...',
++	'SEARCHING'						 => 'A Pesquisar...',
++	'LOADING_LOG_IN'				 => 'A Conectar-se...',
++	'FILE_UPLOADING'				 => 'A Enviar Ficheiro...',
++	'CASTING_VOTE'					 => 'A Enviar Voto...',
++	'LOADING_FORM'					 => 'A Carregar Formulário...',
++
++	'MEMBERLIST_P_JOINED'			 => 'Registou-se no fórum',
++	'MEMBERLIST_P_EXPL'				 => 'Quando me registei no fórum',
++	'MEMBERLIST_P_DATE_EXPL'		 => 'Última vez que visitei o fórum',
++	'SPAMMER'						 => 'Spammer',
++	'SPAMMER_PLACEHOLDER'			 => 'Não podes simplesmente fazer Spam e sair impune!',
++	'MARK_PLACEHOLDER'				 => 'Coloque visto na sua escolha',
++	'INFO_BOX'						 => 'Informações:',
++	'USER_REMOVE_PLACEHOLDER'		 => 'Clique para remover o utilizador',
++	'GROUP_REMOVE_PLACEHOLDER'		 => 'Clique para remover o grupo',
++	'EDIT_LINK_PLACEHOLDER'			 => 'Esqueci-me de colocar código nos meus endereços',
++	'POST_IT_UP_PLACEHOLDER'		 => 'Enviar!',
++
++	'UCP_REG_USR_PLACEHOLDER'		 => 'E.g. John Doe',
++	'UCP_REG_EMAIL_PLACEHOLDER'		 => 'E.g. john@mail.com',
++	'UCP_REG_PSWD_PLACEHOLDER'		 => 'E.g. ASDFasdf123',
++	'UCP_REG_CTCHA_PLACEHOLDER'		 => 'E.g. golden sky',
++	'SEARCH_USR_PLACEHOLDER'		 => 'E.g. GoldTugAnime',
++	'YEAR_MONTH_DAY_PLACEHOLDER'	 => 'E.g. 2018-12-22',
++	'IP_PLACEHOLDER'				 => 'E.g. 216.161.111.33',
++	'POSTS_PLACEHOLDER'				 => 'E.g. 12',
++	'SEARCH_KWDS_PLACEHOLDER'		 => 'E.g. gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',
++
++	'MESSAGE_ENTER_PLACEHOLDER'		 => 'Introduza a sua mensagem...',
++	'FILE_COMMENT_PLACEHOLDER'		 => 'Espaço reservado para comentários',
++	'HEIGTH_PLACEHOLDER'			 => 'altura',
++	'WIDTH_PLACEHOLDER'				 => 'largura',
++	'UCP_OCCUPATION_PLACEHOLDER'	 => 'Descreve de forma breve a tua profissão...',
++	'UCP_INTERESTS_PLACEHOLDER'		 => 'Descreve os teus interesses...',
++	'SOFT_DELETE_PLACEHOLDER'		 => 'Adiciona os teus motivos, caso desejes...',
++	'ADD_DESCRIPTION'				 => 'Adicionar descrição',
++
++	'FILE_SELECT'					 => 'Seleccione o ficheiro',
++	'FILE_CHANGE'					 => 'Alterar',
++	'SELECT_IMAGE'					 => 'Seleccione a imagem',
++	'NOTE'							 => 'Observação',
++	'EDIT_DRAFT'					 => 'Editar Rascunho',
++	'PM_BALOON_NOTIFICATION'		 => 'Activar notificação de MP (Mensagem Privada) via Pop-Up',
++	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Marcar todas como lidas',
++	'DAYS_AGO'						 => 'Dias atrás',
++	'WORK_IN_PROGRESS'				 => 'Manutenção',
++	'DISABLE_MESSAGE'				 => 'Fórum indisponível',
++	'DISABLE_RETURN'				 => 'Voltar à página de índice',
++	'BOARD_DISABLED_SHUFFLE'		 => 'Diverte-te e embaralha algumas letras :-)',
++	'DISABLE_TEXT_TRY'				 => 'Testa tu mesmo!',
++	'DISABLE_TEXT_TYPE'				 => 'Digite algo, e pressione retroceder...',
++
++	'GRAVATAR_EXPLAIN'				 => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, será usado por defeito.',
++	'GRAVATAR_EXPLAIN_CONFIRM'		 => 'Por favor, confirme o seu endereço de e-mail aqui',
++
++	'DELETE_POLL'					 => 'Apagar Votação',
++	'POLL_DELETE_HELPER'			 => '(Isto apenas apaga a votação) verificar e submeter',
++	'JUMP_TO_POST'					 => 'Ir para a mensagem',
++	'JUMP_SELECT_FORUM'				 => 'Selecciona o Fórum para onde ir',
++	'JUMP_TO_PAGE_NUMBER'			 => 'Ir para #',
++	'VIEW_FIRST_UNREAD'				 => 'Ver primeira mensagem não lida.',
++	'BOOKMARK_TOPIC_REMOVE'			 => 'Remover tópico dos favoritos',
++
++	'NEW_MESSAGES'					 => 'Novas mensagens',
++	'YOU_HAVE'						 => 'Você tem',
++	'AND'							 => 'e',
++	'HELLO'							 => 'Olá',
++	'DISMISS_PM'					 => 'Adiar 5 minutos',
++	'READ_NOW'						 => 'Leia agora',
++	'PRIVATE_MESSAGE_NEW'			 => 'nova mensagem privada',
++	'PRIVATE_MESSAGE_UNREAD'		 => 'mensagem privada por ler',
++	'NO_PMS_INFO'					 => 'Tudo em dia! Escrever nova MP?',
++
++	'DATES'							 => 'DATA',
++	'POWERED'						 => 'Baseado em',
++	'HANDCRAFTED'					 => 'Desenvolvido Com',
++	'BY'							 => 'Por',
++
++	'RECENT_TOPICS'					 => 'Tópicos recentes',
++	'TWITTER'						 => 'Twitter',
++	'FAVORITES'						 => 'Favoritos',
++
++	'GALLERY'						 => 'Galeria',
++	'CHAT'							 => 'Chat',
++	'ABOUT'							 => 'Sobre Nós',
++	'ABOUT_PART_ONE'				 => 'BBOOTS&#8482; É o primeiro e único Tema, HTML5/CSS3 não-oficial, totalmente Ágil de PhpBB&reg;. É limpo e nítido. Com um Design INCRÍVEL e compatível com todos os navegadores e dispositivos.',
++	'ABOUT_PART_TWO'				 => 'Utiliza um layout com base no Bootstrap, há muito esperado, e que irá surpreender os fãs da plataforma phpBB.',
++	'ABOUT_PART_THREE'				 => 'O Tema Ágil Não-Oficial',
++	'BB'							 => 'B',
++	'BOOTS'							 => 'BOOTS',
++	'BBOOTS'						 => 'BBOOTS',
++
++	'BBOOTS_VERSION'				 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
++	'U_LOGOUT'						 => 'Sair',
++
++	'SITESPLAT_STATISTICS'			 => 'Estatísticas',
++	'SITESPLAT_SEE_DETAILS'			 => 'Ver detalhes',
++	'SITESPLAT_SEARCH_LAST_DAY'		 => 'Mensagens das últimas 24h',
++	'SITESPLAT_SEARCH_WEEK'			 => 'Mensagens dos últimos 7 dias',
++
++	'SITESPLAT_TOTAL_POSTS'			 => 'Total de mensagens',
++	'SITESPLAT_TOTAL_TOPICS'		 => 'Total de tópicos',
++	'SITESPLAT_TOTAL_USERS'			 => 'Total de utilizadores',
++	'SITESPLAT_NEWEST_MEMBER'		 => 'Novo utilizador',
++	'SITESPLAT_USERS_ONLINE'		 => 'Utilizadores Online',
++	'SITESPLAT_MOST_USERS_ONLINE'	 => 'Recorde de Utilizadores Online',
++	'SITESPLAT_BIRTHDAYS'			 => 'Aniversariantes',
++
++	'BOOTSTRAP_VERSION'				 => '3.3.6',
++	'FLATBOOTS'						 => 'FLATBOOTS',
++	'CHANGE_AVATAR'					 => 'Alterar Avatar',
++	'CHANGE_PASSWORD'				 => 'Alterar Senha',
++
++	'ADMIN_TIPS'					 => 'Truques e Dicas dos Administradores',
++	'ADMIN_TIP_INTRO'				 => 'Sabias que podes tornar o teu fórum phpBB ainda mais seguro com apenas alguns passos simples?',
++	'ADMIN_TIP_ONE'					 => 'Mantém o teu software actualizado.',
++	'ADMIN_TIP_TWO'					 => 'Usa sempre boas senhas que contenham sequências aleatórias de números, letras e caracteres especiais.',
++	'ADMIN_TIP_THREE'				 => 'Restrinja o acesso à zona de administração...',
++	'ADMIN_CHECK_IT_BTN'			 => 'Visita SiteSplat.com para mais informação',
++
++	'USER_MINI_PROFILE'				 => 'Mini-perfil do utilizador',
++	'USER_MINI_PROFILE_VIEW_FULL'	 => 'Ver o perfil completo',
++	'OFF_LINE'						 => 'Desconectado',
++	'USER_STATUS'					 => 'Estado',
++	'USER'							 => 'Utilizador',
++	'TITLE'							 => 'Título',
++	'END_TIMELINE'					 => 'Cronograma final',
++	'MEMBERS'						 => 'Utilizadores',
++	'DRAFTS'						 => 'Rascunhos',
++	'REPORTS'						 => 'Denúncias',
++	'MODERATOR_LOGS'				 => 'Registos de Moderador',
++	'QUEUE'							 => 'Moderação',
++	'LINKS'							 => 'Endereços',
++	'TOPIC_PERMISSIONS'				 => 'Permissões do tópico',
++	'MODERATOR_OPTIONS'				 => 'Moderar',
++	'PASSWORD_EXPLAIN_CONFIRM'		 => 'Certifique-se que corresponde',
++	'FORUM_REDIRECTS'				 => 'Redireccionamentos:',
++
++	'FANCY_TOPICS_TITLE'			 => 'Tópicos recentes do fórum',
++	'POST_BY'						 => 'Criado por',
++	'REPLY_BY'						 => 'Respondido por',
++	'NO_REPLIES'					 => 'Sem resposta',
++	'READ_MORE'						 => 'Ler mais',
++	'RT_READ_MORE'					 => 'LER MAIS',
++	'VIEW_MORE_TOPICS'				 => 'VER MAIS TÓPICOS',
++	'BACK_TO_START'					 => 'VOLTAR AO INÍCIO',
++
++	'TOGGLE_NAV'					 => 'Alterar Navegação',
++	'NAVIGATION'					 => 'Navegação',
++
++	'DEMO_LINK'						 => 'Apenas demonstração, não existe ícones',
++	'DEMO_HEADER_MENU'				 => 'Exemplo de cabeçalho da introdução',
++
++	'FLATBOOTS_INTRO'				 => 'Bootstrap Framework',
++	'FLATBOOTS_EXPLAIN'				 => 'Mais de uma dúzia de componentes reutilizáveis, criado para fornecer iconografia, menus suspensos, grupos de entrada, sistema de navegação, notificações e muito mais...',
++	'CALL_TO_ACTION_FOOTER'			 => 'Active e desactive addons, use apenas o que realmente precisa!',
++	'PURCHASE_NOW_BTN'				 => 'Compre agora',
++	'FLATBOOTS_ABOUT_PART_ONE'		 => 'Porque é que iria contentar-se com menos, quando pode ter mais? Não deixe que outros autores o enganem com jogadas de Marketing. O FLATBOOTS é aquilo que merece. Construído para durar, construído a partir do zero, nada mais, nada menos.',
++	'FLATBOOTS_ABOUT_TITLE'			 => 'Construído para durar',
++	'DMCA'							 => 'DMCA',
++	'TERMS'							 => 'Termos e Condições',
++	'ADVERTISE'						 => 'Divulgue',
++	'DEVELOPER'						 => 'Desenvolvido por',
++	'LEINAD4MIND'					 => 'Leinad4Mind',
++	'SITESPLAT_URL'				 => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
++	'JOIN_US_TWITTER'				 => 'Segue-nos!',
++	'TWEET_EXAMPLE'				 => 'O BBOOTS atingiu as 500 vendas! Obrigado a todos os que apoiam este projecto e que contribuem com o SiteSplat para construir a comunidade. O que o futuro reserva? Mantém-te a par e segue-me no Twitter. <a href="#">http://bit.ly/000fefs</a>',
++
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
+similarity index 97%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
+index ce0463cd5..076aeb8f7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
+@@ -46,8 +46,8 @@ $lang = array_merge($lang, array(
+ 	'FTP_BAD_PATH'			=> 'Unable to select phpBB directory',
+ 	'FTP_FS_SUCCESS'		=> 'FTP access to filesystem was successful',
+ 
+-	'BBCORE_SETTINGS'		=> 'BBCore Einstellungen',
+-	'BBCORE_OPT_SAVED'		=> 'BBCore Einstellungen wurden gespeichert.',
++	'BBCORE_SETTINGS'		=> 'BBCore Settings',
++	'BBCORE_OPT_SAVED'		=> 'BBCore Settings have been saved.',
+ 
+ 	// minification
+ 	'SITESPLAT_BBCORE_MINIFY_HTML'			=> 'Minify HTML',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php"
+new file mode 100644
+index 000000000..29468e2a0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php"
+@@ -0,0 +1,60 @@
++<?php
++/**
++*
++* common [Portuguese]
++*
++* @package language
++* @package sitesplat BBcore
++* @version $Id$
++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
++* @copyright (c) 2015 SiteSplat All rights reserved
++* @license Proprietary
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
++$lang = array_merge($lang, array(
++
++	'ACP_SITESPLAT_UPDATE_MANAGER'	 => 'Administrar Actualizações de SiteSplat',
++	'VERSION_INSTALLED'				 => 'Versão Instalada',
++	'NEW_BOOTS_VERSION'				 => 'Nova versão disponível: %s',
++	'VERSIONNUMBERS'				 => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
++	'SS_RAPID_DISABLE'				 => 'Desactivar Rápido SS',
++	'SS_RAPID_DISABLE_TLT'			 => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',
++
++	'DOWNLOAD_MSG'					 => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
++	'CHANGE_LOG_MSG'				 => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
++	'SUPPORT_FORUM_MSG'				 => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
++	'COLORIZE_MSG'					 => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
++	'NO_VERSIONINFO'				 => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',
++
++	'LOG_FILES_CHANGED'				 => '<strong>O BBcore alterou o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
++	'LOG_THEME_INSTALLED'			 => '<strong>O BBcore foi instalado com sucesso</strong>',
++	'LOG_FILES_CHANGED_FAILED'		 => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
++	'LOG_THEME_UNINSTALLED'			 => '<strong>O BBcore foi desinstalado com sucesso</strong>',
++
++	'LOG_FILE_NOT_REPLACED'			 => '<strong>O BBcore não conseguiu substituir o ficheiro original por ti:</strong><br />» %s',
++	'LOG_FILE_NOT_UPDATED'			 => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
++
++	'LOG_BBCORE_INSTALLED'			 => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
++	'LOG_BBCORE_DEINSTALLED'		 => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',
++
++	'LOG_BBCORE_NOT_REPLACED'		 => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) ficheiro(s)<br />» %s',
++	'LOG_BBCORE_NOT_UPDATED'		 => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) ficheiro(s)<br />» %s',
++
++	'ACP_BBCORE_MSG_FILES_FAIL'		 => 'Nem TODOS os ficheiros foram editados! Por favor, substitui manualmente o(s) ficheiro(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
++	'ACP_BBCORE_MSG_SETTINGS'		 => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de ficheiros no servidor ou à falta de ficheiros nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os ficheiros manualmente para desfrutar de todas as funcionalidades.',
++	'BBCORE_ERROR_DISABLE'			 => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
+similarity index 78%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
+index a8de9ceef..e0c4569f2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
+@@ -3,6 +3,7 @@
+ *
+ * @package language
+ * @package sitesplat BBcore addon
++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+ * @copyright (c) 2015 SiteSplat All rights reserved
+ * @license Proprietary
+ *
+@@ -55,14 +56,14 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge(
+ 	$lang, array(
+-		'UCP_IR'				    => 'Image Resizer',
+-		'IMAGE_RESIZE'			    => 'Image Resize',
+-		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
++		'UCP_IR'				    => 'Redimensionar Imagem',
++		'IMAGE_RESIZE'			    => 'Redimensionamento de Imagem',
++		'IMAGE_RESIZE_EXPLAIN'	    => 'Corte %1$s da imagem e confirme.',
+ 		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',
+ 
+-		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
++		'IMAGE_RESIZE_ERROR'	    => 'Nenhuma app ou ficheiro para enviar!',
+ 		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
+-		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
+-	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable AvatarResize because of other active premium extensions<br /><div>» %s</div>',
++	    'SS_HELPER_NOTY'	    	=> 'Core does not exist!<br />Download and copy the Core folder into your sitesplat extension folder.',
+ 	)
+ );
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/sitesplat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/sitesplat.php"
+index 6512c4cee..0f20ce516 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/sitesplat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/sitesplat.php"
+@@ -1,98 +1,8 @@
+ <?php
+-
+ /**
+  * Code available to all SiteSplat extensions
+- * @copyright (c) 2023 SiteSplat All rights reserved
++ * @copyright (c) 2021 SiteSplat All rights reserved
+  * @license Proprietary
+  */
+-
+ namespace sitesplat;
+-
+-function dl_params($dlfile, $url)
+-{
+-	return [CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_HEADER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => 'SiteSplatBot', CURLOPT_POST => true, CURLOPT_POSTFIELDS => "bbfile={$dlfile}", CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false,];
+-}
+-function emoji_convert($text)
+-{
+-	return empty($text) ? '' : mb_encode_numericentity($text, [0x10000, 0x1ffff, 0, 0xfffff], 'UTF-8', true);
+-}
+-function add_filter($event, $hook, $priority = 20)
+-{
+-	$is_ss = false;
+-	$priority = (int) $priority;
+-	if (empty($hook)) {
+-		return false;
+-	}
+-	if (is_array($hook)) {
+-		$is_ss = strpos(get_class($hook[0]), 'sitesplat\\') === 0;
+-	}
+-	if ($priority < 1 || (!$is_ss && $priority < 10)) {
+-		$priority = 10;
+-	} else if ($priority > 100 || (!$is_ss && $priority > 90)) {
+-		$priority = 90;
+-	}
+-	addon::$events[$event][$priority][] = $hook;
+-	return true;
+-}
+-function apply_filters($event, $args)
+-{
+-	if (!isset(addon::$events[$event])) {
+-		return $args;
+-	}
+-	$hooks = addon::$events[$event];
+-	krsort($hooks);
+-	foreach ($hooks as $priority) {
+-		foreach ($priority as $hook) {
+-			$args = call_user_func($hook, $args);
+-		}
+-	}
+-	unset(addon::$events[$event]);
+-	return $args;
+-}
+-function load_ext_addons($ext)
+-{
+-	$s = DIRECTORY_SEPARATOR;
+-	if (!defined('PHPBB_ROOT_DIR')) {
+-		define('PHPBB_ROOT_DIR', strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}", true));
+-	}
+-	if (!empty(addon::$addons[$ext])) {
+-		foreach (addon::$addons[$ext] as $name => $vendor) {
+-			if ($name != 'ajax') {
+-				$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}{$ext}.php";
+-				if (file_exists($filename)) {
+-					include($filename);
+-					$cname = $vendor . '\\' . $name . '\\' . $ext;
+-					new $cname;
+-				}
+-			}
+-		}
+-	}
+-}
+-function load_ext_lang($path, &$addon_lang)
+-{
+-	if (empty(addon::$addons)) {
+-		return;
+-	}
+-	$s = DIRECTORY_SEPARATOR;
+-	$lang = substr(strrchr($path, $s), 1);
+-	foreach (addon::$addons as $data) {
+-		foreach ($data as $name => $vendor) {
+-			if ($name != 'ajax') {
+-				$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}{$lang}{$s}{$name}.php";
+-				if (!file_exists($filename)) {
+-					$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}en{$s}{$name}.php";
+-				}
+-				if (file_exists($filename)) {
+-					include($filename);
+-				}
+-			}
+-		}
+-	}
+-}
+-final class addon
+-{
+-	private function __construct() {}
+-	public static $data = [];
+-	public static $addons = [];
+-	public static $events = [];
+-}
++function dl_params($dlfile, $url) { return [ CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_HEADER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => 'SiteSplatBot', CURLOPT_POST => true, CURLOPT_POSTFIELDS => "bbfile={$dlfile}", CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, ]; } function emoji_convert($text) { return (!$text) ? '' : preg_replace_callback('/([\x{1f000}-\x{1ffff}])/u', function($matches) { return strtolower('&#x' . dechex(substr(mb_convert_encoding($matches[1], 'HTML-ENTITIES', 'UTF-8'), 2, -1)) . ';'); }, $text); } function add_filter($event, $hook, $priority = 20) { $is_ss = false; $priority = (int) $priority; if (empty($hook)) { return false; } if (is_array($hook)) { $is_ss = strpos(get_class($hook[0]), 'sitesplat\\') === 0; } if ($priority < 1 || (!$is_ss && $priority < 10)) { $priority = 10; } else if ($priority > 100 || (!$is_ss && $priority > 90)) { $priority = 90; } addon::$events[$event][$priority][] = $hook; return true; } function apply_filters($event, $args) { if (!isset(addon::$events[$event])) { return $args; } $hooks = addon::$events[$event]; krsort($hooks); foreach ($hooks as $priority) { foreach ($priority as $hook) { $args = call_user_func($hook, $args); } } unset(addon::$events[$event]); return $args; } function load_ext_addons($ext) { $s = DIRECTORY_SEPARATOR; if (!defined('PHPBB_ROOT_DIR')) { define('PHPBB_ROOT_DIR', strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}", true)); } if (!empty(addon::$addons[$ext])) { foreach (addon::$addons[$ext] as $name => $vendor) { if ($name != 'ajax') { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}{$ext}.php"; if (file_exists($filename)) { include($filename); $cname = $vendor . '\\' . $name . '\\' . $ext; new $cname; } } } } } function load_ext_lang($path, &$addon_lang) { if (empty(addon::$addons)) { return; } $s = DIRECTORY_SEPARATOR; $lang = substr(strrchr($path, $s), 1); foreach(addon::$addons as $data) { foreach ($data as $name => $vendor) { if ($name != 'ajax') { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}{$lang}{$s}{$name}.php"; if (!file_exists($filename)) { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}en{$s}{$name}.php"; } if (file_exists($filename)) { include($filename); } } } } } class addon { public static $data = []; public static $addons = []; public static $events = []; }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
+index 62d834f56..8e6650361 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
+@@ -3,23 +3,17 @@
+ <head>
+ <meta charset="utf-8">
+ <meta name="viewport" content="width=device-width, initial-scale=1.0">
+-<meta name="designer" content="SiteSplat https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat">
++<meta name="designer" content="Leinad4Mind & Sitesplat">
+ <meta content="{SITENAME}" property="og:site_name">
+-<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
+-
+ <title>{SITENAME} {PAGE_TITLE}</title>
+-
+-<!-- phpBB Premium style name: FLATBOOTS @SiteSplat.com -->
+-
+ <!-- Google free font here -->
+ <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet'>
+ <link href='//fonts.googleapis.com/css?family=Asap+Condensed:600' rel='stylesheet'>
+ 
+ <!-- CSS files start here-->
+-
+-<link href="{T_STYLESHEET_LINK}" rel="stylesheet">
+-<link href="{T_STYLESHEET_OFFLINE}" rel="stylesheet">
+-<link href="{T_STYLESHEET_ANIMATE}" rel="stylesheet">
++<link href="{T_STYLESHEET_LINK}?assets_version=3.3" rel="stylesheet">
++<link href="{T_STYLESHEET_OFFLINE}?assets_version=3.3" rel="stylesheet">
++<link href="{T_STYLESHEET_ANIMATE}?assets_version=3.3" rel="stylesheet">
+ <!-- CSS files -->
+ </head>
+ 
+@@ -30,15 +24,14 @@
+ 	 <div class="container">
+ 		<div class="content-a">
+             <div class="content-b">
+-              <h1 class="wow fadeInDown">{L_BOARD_DISABLED}</h1>
+-              <h2 class="wow fadeInUp" data-wow-delay="0.5s">{ACP_DISABLE_MESSAGE}</h2>
++              <!-- <h1 class="wow fadeInDown">{L_BOARD_DISABLED}</h1> -->
++              <h2 class="wow fadeInUp goldenstar" data-wow-delay="0.5s">{ACP_DISABLE_MESSAGE}</h2>
+                 <div class="wow bounceIn clearfix socialbar" data-wow-delay="1.2s">
+ 					<div class="social-network">
+-						<a class="github-color" title="Github" href="#2"><i class="fa fa-github"></i></a>
+-						<a class="pinterest-color" title="Pinterest" href="#5"><i class="fa fa-pinterest"></i></a> 
+-						<a class="facebook-color" title="Facebook" href="#6"><i class="fa fa-facebook"></i></a>
+-						<a class="twitter-color" title="Twitter" href="https://twitter.com/SiteSplat"><i class="fa fa-twitter"></i></a>
+-						<a class="google-plus-color" title="YouTube" href="#8"><i class="fa fa-youtube"></i></a>
++						<a class="youtube-color" title="YouTube" href="https://www.youtube.com/user/GoldTugAnimeOFICIAL"><i class="fa fa-youtube"></i></a>
++						<a class="facebook-color" title="Facebook" href="https://www.facebook.com/goldtuganimeoficial"><i class="fa fa-facebook"></i></a>
++						<a class="twitter-color" title="Twitter" href="https://twitter.com/GoldTugAnime"><i class="fa fa-twitter"></i></a>
++						<a class="instagram-color" title="Instagram" href="https://www.instagram.com/goldtuganime"><i class="fa fa-instagram"></i></a>
+ 						<a class="github-color" title="{L_LOGIN_LOGOUT}" href="{U_LOGIN_LOGOUT}"><i class="fa fa-gear"></i></a>
+ 					</div>
+ 				</div>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png"
+new file mode 100644
+index 000000000..f99153c3f
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png" differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
+index b45ab4084..94d67f300 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
+@@ -1,225 +1 @@
+-.flat-header {
+-    color: #fafafa;
+-    font-size: 20px;
+-    height: 172px;
+-    margin-bottom: 20px;
+-    overflow: hidden;
+-    position: relative;
+-    text-align: left;
+-    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
+-    width: 100%;
+-}
+-.masthead:before {
+-  position: absolute;
+-  z-index: 1;
+-  top: 0;
+-  left: 0;
+-  width: 200%;
+-  height: 400%;
+-  content: "";
+-  background: url("./images/tile-bg-head.png") 0 0 #26bcb5;
+-  background-repeat: repeat;
+-}
+-.masthead {
+-  position: relative;
+-  height: 100%;
+-  width: 100%;
+-  -webkit-animation-name: sideupscroll;
+-          animation-name: sideupscroll;
+-  -webkit-animation-duration: 70s;
+-          animation-duration: 70s;
+-  -webkit-animation-timing-function: linear;
+-          animation-timing-function: linear;
+-  -webkit-animation-iteration-count: infinite;
+-          animation-iteration-count: infinite;
+-  -webkit-animation-fill-mode: both;
+-          animation-fill-mode: both;
+-}
+-@-webkit-keyframes sideupscroll {
+-  0% {
+-    -webkit-transform: translateX(0%) translateY(0%);
+-            transform: translateX(0%) translateY(0%);
+-  }
+-  50% {
+-    -webkit-transform: translateX(-50%) translateY(-100%);
+-            transform: translateX(-50%) translateY(-100%);
+-  }
+-  100% {
+-    -webkit-transform: translateX(-100%) translateY(-200%);
+-            transform: translateX(-100%) translateY(-200%);
+-  }
+-}
+-@keyframes sideupscroll {
+-  0% {
+-    -webkit-transform: translateX(0%) translateY(0%);
+-            transform: translateX(0%) translateY(0%);
+-  }
+-  50% {
+-    -webkit-transform: translateX(-50%) translateY(-100%);
+-            transform: translateX(-50%) translateY(-100%);
+-  }
+-  100% {
+-    -webkit-transform: translateX(-100%) translateY(-200%);
+-            transform: translateX(-100%) translateY(-200%);
+-  }
+-}
+-
+-.wrapper-head {
+-    margin-top: -35%;
+-    position: relative;
+-    z-index: 2;
+-}
+-
+-
+-@media (min-width: 769px) and (max-width: 1100px) {
+-
+-	.wrapper-head {
+-    margin-top: -50%;
+-    }
+-	
+-	.wrapper-head h1, .wrapper-head h2 {
+-    font-size: 22px;
+-    }
+-}	
+-
+-
+-@media (min-width: 469px) and (max-width: 768px) {
+-
+-	.wrapper-head {
+-    top: -30%;
+-    }
+-	
+-	.wrapper-head h1, .wrapper-head h2 {
+-    font-size: 22px;
+-    }
+-}	
+-
+-@media (max-width: 468px) {
+-    body {
+-        font-size: 15px;
+-    }
+-
+-	.wrapper-head {
+-    margin-top: -120%;
+-    }
+-	
+-	.wrapper-head h1, .wrapper-head h2 {
+-    font-size: 22px;
+-    }
+-
+-    .flat-header {
+-    font-size: 14px;
+-    }
+-}	
+-
+-
+-/* background setup */
+-.background {
+-    background-repeat:no-repeat;
+-    /* custom background-position */
+-    background-position:50% 50%;
+-    /* ie8- graceful degradation */
+-    background-position:50% 50%\9 !important;
+-}
+-
+-/* fullscreen setup */
+-html, body {
+-    /* give this to all tags from html to .fullscreen */
+-    height:100%;
+-}
+-.fullscreen,
+-.content-a {
+-    width:100%;
+-    min-height:100%;
+-}
+-.not-fullscreen,
+-.not-fullscreen .content-a,
+-.fullscreen.not-overflow,
+-.fullscreen.not-overflow .content-a {
+-    height:100%;
+-    overflow:hidden;
+-}
+-
+-/* content centering styles */
+-.content-a {
+-	display:table;
+-}
+-.content-b {
+-	display:table-cell;
+-    position:relative;
+-	vertical-align:middle;
+-	text-align:center;
+-	z-index: 1;
+-}
+-
+-/* visual styles */
+-body{
+-    margin:0;
+-    font-size:28px;
+-    line-height:100px;
+-	color:#ffffff;
+-    text-align:center;
+-}
+-section {
+-	background:#9ed100;
+-}
+-.not-fullscreen {
+-    height:50%;
+-}
+-
+-h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
+-    color: #fff !important;
+-    font-family: "Asap","Arial","Helvetica",sans-serif;
+-    font-weight: 700;
+-    line-height: normal;
+-    margin: 0 0 10px;
+-    text-rendering: optimizelegibility;
+-}
+-.social-network {
+-    text-align: center;
+-}
+-.social-network a {
+-    border-radius: 2px;
+-    color: #fff !important;
+-    display: inline-block;
+-    font-size: 20px;
+-    height: 30px;
+-    margin: 0 3px;
+-    transition: all 0.2s linear 0s;
+-    width: 30px;
+-	line-height: 30px;
+-}
+-
+-
+-.google-plus-color {
+-    background-color: #d34836;
+-}
+-.github-color {
+-    background-color: #333;
+-}
+-.facebook-color {
+-    background-color: #3b5998;
+-}
+-.twitter-color {
+-    background-color: #00aced;
+-}
+-.pinterest-color {
+-    background-color: #cb2027;
+-}
+-.github-color {
+-    background-color: #333;
+-}
+-
+-.social-network a:hover {
+-    transition: all .1s linear 0s;
+-    color: #2d2d2d!important;
+-    border-bottom: none;
+-    background-color: #fff;
+-	outline: none;
+-    text-decoration: none;
+-}
+-
+-.social-network a:focus {
+-    outline: none;
+-    text-decoration: none;
+-}
++.flat-header{color:#fafafa;font-size:20px;height:172px;margin-bottom:20px;overflow:hidden;position:relative;text-align:left;text-shadow:0 1px 0 rgba(0,0,0,0.1);width:100%}.masthead:before{position:absolute;z-index:1;top:0;left:0;width:200%;height:400%;content:"";background:url(./images/gta_back.png) 0 0 #26bcb5;background-repeat:repeat}.masthead{position:relative;height:100%;width:100%;-webkit-animation-name:sideupscroll;animation-name:sideupscroll;-webkit-animation-duration:70s;animation-duration:70s;-webkit-animation-timing-function:linear;animation-timing-function:linear;-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes sideupscroll{0%{-webkit-transform:translateX(0%) translateY(0%);transform:translateX(0%) translateY(0%)}50%{-webkit-transform:translateX(-50%) translateY(-100%);transform:translateX(-50%) translateY(-100%)}100%{-webkit-transform:translateX(-100%) translateY(-200%);transform:translateX(-100%) translateY(-200%)}}@keyframes sideupscroll{0%{-webkit-transform:translateX(0%) translateY(0%);transform:translateX(0%) translateY(0%)}50%{-webkit-transform:translateX(-50%) translateY(-100%);transform:translateX(-50%) translateY(-100%)}100%{-webkit-transform:translateX(-100%) translateY(-200%);transform:translateX(-100%) translateY(-200%)}}.wrapper-head{margin-top:-35%;position:relative;z-index:2}@media (min-width: 769px) and (max-width: 1100px){.wrapper-head{margin-top:-50%}.wrapper-head h1,.wrapper-head h2{font-size:22px}}@media (min-width: 469px) and (max-width: 768px){.wrapper-head{top:-30%}.wrapper-head h1,.wrapper-head h2{font-size:22px}}@media (max-width: 468px){body{font-size:15px}.wrapper-head{margin-top:-120%}.wrapper-head h1,.wrapper-head h2{font-size:22px}.flat-header{font-size:14px}}.background{background-repeat:no-repeat;background-position:50% 50%;background-position:50% 50%\9!important}html,body{height:100%}.fullscreen,.content-a{width:100%;min-height:100%}.not-fullscreen,.not-fullscreen .content-a,.fullscreen.not-overflow,.fullscreen.not-overflow .content-a{height:100%;overflow:hidden}.content-a{display:table}.content-b{display:table-cell;position:relative;vertical-align:middle;text-align:center;z-index:1}body{margin:0;font-size:28px;line-height:100px;color:#fff;text-align:center}section{background:#9ed100}.not-fullscreen{height:50%}h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#fff!important;font-family:"Asap","Arial","Helvetica",sans-serif;font-weight:700;line-height:normal;margin:0 0 10px;text-rendering:optimizelegibility}.social-network{text-align:center}.social-network a{border-radius:2px;color:#fff!important;display:inline-block;font-size:20px;height:30px;margin:0 3px;transition:all .2s linear 0;width:30px;line-height:30px}.google-plus-color{background-color:#d34836}.github-color{background-color:#333}.facebook-color{background-color:#3b5998}.twitter-color{background-color:#00aced}.pinterest-color{background-color:#cb2027}.github-color{background-color:#333}.social-network a:hover{transition:all .1s linear 0;color:#2d2d2d!important;border-bottom:none;background-color:#fff;outline:none;text-decoration:none}.social-network a:focus{outline:none;text-decoration:none}.instagram-color{background-color:#5851db}.youtube-color{background-color:red}.goldenstar{width:50vw;margin:auto}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/next_step_resolver.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/next_step_resolver.php"
+index f691bb5d2..d2966ec49 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/next_step_resolver.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/next_step_resolver.php"
+@@ -1,141 +1,11 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2015 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
++*
++* @package sitesplat BBcore
++* @copyright (c) 2015 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ 
+ namespace sitesplat\BBCore\updater;
+-
+-class next_step_resolver
+-{
+-	protected $config_text;
+-	protected $filesystem;
+-	protected $container;
+-	protected $root_path;
+-	protected $real_root_path;
+-	protected $old_handler;
+-	protected $phperror = '';
+-	protected $start_time;
+-	protected $max_execution_time;
+-	protected $memory_limit;
+-	public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path)
+-	{
+-		$this->config_text = $config_text;
+-		$this->filesystem = $filesystem;
+-		$this->container = $container;
+-		$this->root_path = $root_path;
+-		$this->real_root_path = realpath($root_path) . '/';
+-		$this->start_time = microtime(true);
+-		$execution_time = $php_ini->getNumeric('max_execution_time');
+-		$this->max_execution_time = min(15, $execution_time / 2);
+-		$this->memory_limit = $php_ini->getBytes('memory_limit');
+-	}
+-	public function msg_handler($errno, $msg_text, $errfile, $errline)
+-	{
+-		if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) {
+-			$errfile = phpbb_filter_root_path($errfile);
+-			$msg_text = phpbb_filter_root_path($msg_text);
+-			$error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice';
+-			$this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n";
+-			return true;
+-		} else if (!empty($this->old_handler)) {
+-			return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]);
+-		}
+-		return false;
+-	}
+-	public function run_task($fs, $style_name)
+-	{
+-		$this->old_handler = set_error_handler([$this, 'msg_handler']);
+-		$updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true);
+-		if (empty($updater_config['last_step'])) {
+-			$updater_config['last_step'] = '';
+-			$updater_config['merge_conflicts'] = false;
+-			$this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name);
+-		}
+-		try {
+-			while ($this->has_enought_time() && $this->has_enough_memory()) {
+-				switch ($updater_config['last_step']) {
+-					case '':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't0_backup':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't1_get_current_style_cfg':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't2_get_newest_style_cfg':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't3_check_problems':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't4_download_newest_version':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't5_unzip_new_version':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't6_load_list_of_changes':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't7_merge_edits':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't8_check_additions':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't9_update_edits':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't10_update_added':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't11_update_deleted':
+-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config);
+-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
+-						break;
+-					case 't12_log_changes':
+-						$this->config_text->set('sitesplat_bbcore_updater', '');
+-						return true;
+-						break;
+-				}
+-				return $this->phperror ?: false;
+-			}
+-		} catch (\Exception $e) {
+-			$this->config_text->set('sitesplat_bbcore_updater', '');
+-			return $e->getMessage();
+-		}
+-		return false;
+-	}
+-	protected function has_enought_time()
+-	{
+-		return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0;
+-	}
+-	protected function has_enough_memory()
+-	{
+-		if ($this->memory_limit <= 0) {
+-			return true;
+-		}
+-		if (function_exists('memory_get_usage')) {
+-			return ($this->memory_limit - memory_get_usage()) > 0;
+-		}
+-		return true;
+-	}
+-}
++class next_step_resolver { protected $config_text; protected $filesystem; protected $container; protected $root_path; protected $real_root_path; protected $old_handler; protected $phperror = ''; protected $start_time; protected $max_execution_time; protected $memory_limit; public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path) { $this->config_text = $config_text; $this->filesystem = $filesystem; $this->container = $container; $this->root_path = $root_path; $this->real_root_path = realpath($root_path) . '/'; $this->start_time = microtime(true); $execution_time = $php_ini->getNumeric('max_execution_time'); $this->max_execution_time = min(15, $execution_time / 2); $this->memory_limit = $php_ini->getBytes('memory_limit'); } public function msg_handler($errno, $msg_text, $errfile, $errline) { if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) { $errfile = phpbb_filter_root_path($errfile); $msg_text = phpbb_filter_root_path($msg_text); $error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice'; $this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n"; return true; } else if (!empty($this->old_handler)) { return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]); } return false; } public function run_task($fs, $style_name) { $this->old_handler = set_error_handler([$this, 'msg_handler']); $updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true); if (empty($updater_config['last_step'])) { $updater_config['last_step'] = ''; $updater_config['merge_conflicts'] = false; $this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name); } try { while($this->has_enought_time() && $this->has_enough_memory()) { switch ($updater_config['last_step']) { case '': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't0_backup': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't1_get_current_style_cfg': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't2_get_newest_style_cfg': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't3_check_problems': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't4_download_newest_version': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't5_unzip_new_version': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't6_load_list_of_changes': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't7_merge_edits': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't8_check_additions': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't9_update_edits': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't10_update_added': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't11_update_deleted': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't12_log_changes': $this->config_text->set('sitesplat_bbcore_updater', ''); return true; break; } return $this->phperror ?: false; } } catch (\Exception $e) { $this->config_text->set('sitesplat_bbcore_updater', ''); return $e->getMessage(); } return false; } protected function has_enought_time() { return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0; } protected function has_enough_memory() { if ($this->memory_limit <= 0) { return true; } if (function_exists('memory_get_usage')) { return ($this->memory_limit - memory_get_usage()) > 0; } return true; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t0_backup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t0_backup.php"
+index 3faf5747e..aaf2ec672 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t0_backup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t0_backup.php"
+@@ -1,31 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t0_backup
+-{
+-	protected $filesystem;
+-	protected $root_path;
+-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
+-	{
+-		$this->filesystem = $filesystem;
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path)
+-	{
+-		$this->root_path = $root_path;
+-		$backup_dir = $this->root_path . 'store/' . $style_name . '_' . time();
+-		$this->filesystem->mkdir($backup_dir);
+-		$this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir);
+-		$updater_config['last_step'] = 't0_backup';
+-		return $updater_config;
+-	}
+-}
++class t0_backup { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $backup_dir = $this->root_path . 'store/' . $style_name . '_' . time(); $this->filesystem->mkdir($backup_dir); $this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir); $updater_config['last_step'] = 't0_backup'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t10_update_added.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t10_update_added.php"
+index bed0aa7a3..6ae56fa28 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t10_update_added.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t10_update_added.php"
+@@ -1,39 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t10_update_added
+-{
+-	protected $root_path;
+-	public function __construct($root_path)
+-	{
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path, $fs)
+-	{
+-		$this->root_path = $root_path;
+-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
+-		if (!empty($updater_config['update_info']['added_dirs'])) {
+-			foreach ($updater_config['update_info']['added_dirs'] as $file_path) {
+-				$fs->mkdir($current_files_path . $file_path);
+-			}
+-			unset($updater_config['update_info']['added_dirs']);
+-		}
+-		if (!empty($updater_config['update_info']['added'])) {
+-			foreach ($updater_config['update_info']['added'] as $file_path) {
+-				$fs->put($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path), true);
+-			}
+-			unset($updater_config['update_info']['added']);
+-		}
+-		$updater_config['last_step'] = 't10_update_added';
+-		return $updater_config;
+-	}
+-}
++class t10_update_added { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['added_dirs'])) { foreach ($updater_config['update_info']['added_dirs'] as $file_path) { $fs->mkdir($current_files_path . $file_path); } unset($updater_config['update_info']['added_dirs']); } if (!empty($updater_config['update_info']['added'])) { foreach ($updater_config['update_info']['added'] as $file_path) { $fs->put($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path), true); } unset($updater_config['update_info']['added']); } $updater_config['last_step'] = 't10_update_added'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php"
+index 434fae143..28d1b1ae2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php"
+@@ -1,41 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t11_update_deleted
+-{
+-	protected $filesystem;
+-	protected $root_path;
+-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
+-	{
+-		$this->filesystem = $filesystem;
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path, $fs)
+-	{
+-		$this->root_path = $root_path;
+-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
+-		if (!empty($updater_config['update_info']['deleted'])) {
+-			foreach ($updater_config['update_info']['deleted'] as $file_path) {
+-				$fs->delete($current_files_path . $file_path);
+-			}
+-			unset($updater_config['update_info']['deleted']);
+-		}
+-		if (!empty($updater_config['update_info']['deleted_dirs'])) {
+-			foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) {
+-				$fs->rmdir($current_files_path . $file_path);
+-			}
+-			unset($updater_config['update_info']['deleted_dirs']);
+-		}
+-		$updater_config['last_step'] = 't11_update_deleted';
+-		return $updater_config;
+-	}
+-}
++class t11_update_deleted { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['deleted'])) { foreach ($updater_config['update_info']['deleted'] as $file_path) { $fs->delete($current_files_path . $file_path); } unset($updater_config['update_info']['deleted']); } if (!empty($updater_config['update_info']['deleted_dirs'])) { foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) { $fs->rmdir($current_files_path . $file_path); } unset($updater_config['update_info']['deleted_dirs']); } $updater_config['last_step'] = 't11_update_deleted'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php"
+index cdba04783..753424d59 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php"
+@@ -1,28 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t12_log_changes
+-{
+-	protected $log;
+-	protected $user;
+-	public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user)
+-	{
+-		$this->log = $log;
+-		$this->user = $user;
+-	}
+-	public function run($style_name, $updater_config)
+-	{
+-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [$style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-',]);
+-		$updater_config['last_step'] = 't12_log_changes';
+-		return $updater_config;
+-	}
+-}
++class t12_log_changes { protected $log; protected $user; public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user) { $this->log = $log; $this->user = $user; } public function run($style_name, $updater_config) { $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [ $style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-', ]); $updater_config['last_step'] = 't12_log_changes'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
+index 609752f70..9b3f8636b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
+@@ -1,27 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t1_get_current_style_cfg
+-{
+-	protected $root_path;
+-	public function __construct($root_path)
+-	{
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path)
+-	{
+-		$this->root_path = $root_path;
+-		$updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg');
+-		$updater_config['last_step'] = 't1_get_current_style_cfg';
+-		return $updater_config;
+-	}
+-}
++class t1_get_current_style_cfg { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg'); $updater_config['last_step'] = 't1_get_current_style_cfg'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
+index b6be1a7ae..73bb1b57b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
+@@ -1,31 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t2_get_newest_style_cfg
+-{
+-	protected $file_downloader;
+-	protected $host;
+-	protected $versioncheck_path;
+-	public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path)
+-	{
+-		$this->file_downloader = $file_downloader;
+-		$this->host = $host;
+-		$this->versioncheck_path = $versioncheck_path;
+-	}
+-	public function run($style_name, $updater_config)
+-	{
+-		$info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name, 443);
+-		$updater_config['style_data'] = json_decode($info, true);
+-		$updater_config['last_step'] = 't2_get_newest_style_cfg';
+-		return $updater_config;
+-	}
+-}
++class t2_get_newest_style_cfg { protected $file_downloader; protected $host; protected $versioncheck_path; public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path) { $this->file_downloader = $file_downloader; $this->host = $host; $this->versioncheck_path = $versioncheck_path; } public function run($style_name, $updater_config) { $info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name, 443); $updater_config['style_data'] = json_decode($info, true); $updater_config['last_step'] = 't2_get_newest_style_cfg'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php"
+index 8dd5da47e..46065129f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php"
+@@ -1,26 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t3_check_problems
+-{
+-	public function run($style_name, $updater_config)
+-	{
+-		if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>=')) {
+-			throw new \Exception('ALREADY_UP_TO_DATE');
+-		}
+-		if (empty($updater_config['style_data']['direct_download_dir'])) {
+-			throw new \Exception('NO_DIRECT_DOWNLOAD');
+-		}
+-		$updater_config['last_step'] = 't3_check_problems';
+-		return $updater_config;
+-	}
+-}
++class t3_check_problems { public function run($style_name, $updater_config) { if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>=')) { throw new \Exception('ALREADY_UP_TO_DATE'); } if (empty($updater_config['style_data']['direct_download_dir'])) { throw new \Exception('NO_DIRECT_DOWNLOAD'); } $updater_config['last_step'] = 't3_check_problems'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
+index 08c0a63d5..446188ba0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
+@@ -1,57 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t4_download_newest_version
+-{
+-	protected $file_downloader;
+-	protected $filesystem;
+-	protected $host;
+-	protected $download_path;
+-	protected $root_path;
+-	public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path)
+-	{
+-		$this->file_downloader = $file_downloader;
+-		$this->filesystem = $filesystem;
+-		$this->host = $host;
+-		$this->download_path = $download_path;
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path)
+-	{
+-		$this->root_path = $root_path;
+-		$ch = curl_init();
+-		curl_setopt($ch, CURLOPT_URL, "https://{$this->host}/{$this->download_path}{$updater_config['style_data']['direct_download_dir']}/{$updater_config['cfg_data']['style_version']}_to_{$updater_config['style_data']['version']}.zip");
+-		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
+-		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
+-		curl_setopt($ch, CURLOPT_USERAGENT, 'sitesplat_updater');
+-		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
+-		curl_setopt($ch, CURLOPT_POST, true);
+-		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
+-		$zip = curl_exec($ch);
+-		if (curl_errno($ch)) {
+-			throw new \Exception(curl_error($ch));
+-		}
+-		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
+-		curl_close($ch);
+-		if ($http != 200 || empty($zip)) {
+-			throw new \Exception('PROBLEM_DOWNLOADING_UPDATE');
+-		}
+-		$tmp_path = $this->root_path . 'store/';
+-		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
+-		if (file_exists($tmp_file)) {
+-			$this->filesystem->remove($tmp_file);
+-		}
+-		file_put_contents($tmp_file, $zip);
+-		$updater_config['last_step'] = 't4_download_newest_version';
+-		return $updater_config;
+-	}
+-}
++class t4_download_newest_version { protected $file_downloader; protected $filesystem; protected $host; protected $download_path; protected $root_path; public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path) { $this->file_downloader = $file_downloader; $this->filesystem = $filesystem; $this->host = $host; $this->download_path = $download_path; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, "https://{$this->host}/{$this->download_path}{$updater_config['style_data']['direct_download_dir']}/{$updater_config['cfg_data']['style_version']}_to_{$updater_config['style_data']['version']}.zip"); curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($ch, CURLOPT_USERAGENT, 'sitesplat_updater'); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_POSTFIELDS, ""); $zip = curl_exec($ch); if (curl_errno($ch)) { throw new \Exception(curl_error($ch)); } $http = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch); if ($http != 200 || empty($zip)) { throw new \Exception('PROBLEM_DOWNLOADING_UPDATE'); } $tmp_path = $this->root_path . 'store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; if (file_exists($tmp_file)) { $this->filesystem->remove($tmp_file); } file_put_contents($tmp_file, $zip); $updater_config['last_step'] = 't4_download_newest_version'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
+index 0fc537cf7..d49aaf9d8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
+@@ -1,42 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t5_unzip_new_version
+-{
+-	protected $filesystem;
+-	protected $root_path;
+-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
+-	{
+-		$this->filesystem = $filesystem;
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path, $fs)
+-	{
+-		$tmp_path = $fs->phpbb_root_dir . '/store/';
+-		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
+-		$updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/';
+-		$fs_type = $fs->fs_type;
+-		$fs->fs_type = 'direct';
+-		if (file_exists($updater_config['tmp_dir'])) {
+-			$this->filesystem->remove($updater_config['tmp_dir']);
+-		}
+-		$this->filesystem->mkdir($updater_config['tmp_dir']);
+-		$result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']);
+-		if ($result === false) {
+-			throw new \Exception($fs->ftp_error);
+-		}
+-		$this->filesystem->remove($tmp_file);
+-		$fs->fs_type = $fs_type;
+-		$updater_config['last_step'] = 't5_unzip_new_version';
+-		return $updater_config;
+-	}
+-}
++class t5_unzip_new_version { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $tmp_path = $fs->phpbb_root_dir . '/store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; $updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/'; $fs_type = $fs->fs_type; $fs->fs_type = 'direct'; if (file_exists($updater_config['tmp_dir'])) { $this->filesystem->remove($updater_config['tmp_dir']); } $this->filesystem->mkdir($updater_config['tmp_dir']); $result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']); if ($result === false) { throw new \Exception($fs->ftp_error); } $this->filesystem->remove($tmp_file); $fs->fs_type = $fs_type; $updater_config['last_step'] = 't5_unzip_new_version'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
+index a07f005bf..83e6e814d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
+@@ -1,29 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t6_load_list_of_changes
+-{
+-	protected $root_path;
+-	protected $php_ext;
+-	public function __construct($root_path, $php_ext)
+-	{
+-		$this->root_path = $root_path;
+-		$this->php_ext = $php_ext;
+-	}
+-	public function run($style_name, $updater_config)
+-	{
+-		include($updater_config['tmp_dir'] . 'index.' . $this->php_ext);
+-		$updater_config['update_info'] = $updater_config['log_data'] = $update_info;
+-		$updater_config['last_step'] = 't6_load_list_of_changes';
+-		return $updater_config;
+-	}
+-}
++class t6_load_list_of_changes { protected $root_path; protected $php_ext; public function __construct($root_path, $php_ext) { $this->root_path = $root_path; $this->php_ext = $php_ext; } public function run($style_name, $updater_config) { include($updater_config['tmp_dir'] . 'index.' . $this->php_ext); $updater_config['update_info'] = $updater_config['log_data'] = $update_info; $updater_config['last_step'] = 't6_load_list_of_changes'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php"
+index c9e6107f2..0361e9dd7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php"
+@@ -1,80 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t7_merge_edits
+-{
+-	protected $filesystem;
+-	protected $cache;
+-	protected $language;
+-	protected $root_path;
+-	protected $php_ext;
+-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, \phpbb\cache\driver\driver_interface $cache, \phpbb\language\language $language, $root_path, $php_ext)
+-	{
+-		$this->filesystem = $filesystem;
+-		$this->cache = $cache;
+-		$this->language = $language;
+-		$this->root_path = $root_path;
+-		$this->php_ext = $php_ext;
+-	}
+-	public function run($style_name, $updater_config, $root_path)
+-	{
+-		$this->root_path = $root_path;
+-		if (empty($updater_config['update_info']['edited'])) {
+-			if ($updater_config['merge_conflicts']) {
+-				throw new \Exception($this->language->lang('MERGE_CONFLICTS', 'store/merge_conflicts_' . $style_name));
+-			}
+-			$updater_config['last_step'] = 't7_merge_edits';
+-			return $updater_config;
+-		}
+-		if (empty($updater_config['merge_calculated'])) {
+-			$updater_config['merge_calculated'] = [];
+-		}
+-		if (!class_exists('diff3')) {
+-			include($this->root_path . 'includes/diff/diff.' . $this->php_ext);
+-		}
+-		if (!class_exists('diff_engine')) {
+-			include($this->root_path . 'includes/diff/engine.' . $this->php_ext);
+-		}
+-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
+-		$file_diffed = false;
+-		foreach ($updater_config['update_info']['edited'] as $key => $file_path) {
+-			if (in_array($file_path, $updater_config['merge_calculated'])) {
+-				continue;
+-			}
+-			$new_file_contents = @file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path);
+-			if (file_exists($current_files_path . $file_path)) {
+-				$file_contents[0] = @file_get_contents($updater_config['tmp_dir'] . 'old/' . $file_path);
+-				$file_contents[1] = @file_get_contents($current_files_path . $file_path);
+-				$file_contents[2] = $new_file_contents;
+-				$diff = new \diff3($file_contents[0], $file_contents[1], $file_contents[2]);
+-				if ($diff->get_num_conflicts() !== 0) {
+-					$updater_config['merge_conflicts'] = true;
+-					$merge_conflicts_path = $this->root_path . 'store/merge_conflicts_' . $style_name . '/';
+-					$this->filesystem->mkdir($merge_conflicts_path . dirname($file_path));
+-					file_put_contents($merge_conflicts_path . $file_path, implode("\n", $diff->merged_output()));
+-				}
+-				if ($diff->merged_output() !== $file_contents[1]) {
+-					$this->cache->put('_bbcore_updater_' . md5($file_path), implode("\n", $diff->merged_output()));
+-					$updater_config['merge_calculated'][] = $file_path;
+-				}
+-				unset($file_contents);
+-				unset($diff);
+-			} else {
+-				$this->cache->put('_bbcore_updater_' . md5($file_path), $new_file_contents);
+-				$updater_config['merge_calculated'][] = $file_path;
+-			}
+-			unset($updater_config['update_info']['edited'][$key]);
+-			break;
+-		}
+-		return $updater_config;
+-	}
+-}
++class t7_merge_edits { protected $filesystem; protected $cache; protected $language; protected $root_path; protected $php_ext; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, \phpbb\cache\driver\driver_interface $cache, \phpbb\language\language $language, $root_path, $php_ext) { $this->filesystem = $filesystem; $this->cache = $cache; $this->language = $language; $this->root_path = $root_path; $this->php_ext = $php_ext; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; if (empty($updater_config['update_info']['edited'])) { if ($updater_config['merge_conflicts']) { throw new \Exception($this->language->lang('MERGE_CONFLICTS', 'store/merge_conflicts_' . $style_name)); } $updater_config['last_step'] = 't7_merge_edits'; return $updater_config; } if (empty($updater_config['merge_calculated'])) { $updater_config['merge_calculated'] = []; } if (!class_exists('diff3')) { include($this->root_path . 'includes/diff/diff.' . $this->php_ext); } if (!class_exists('diff_engine')) { include($this->root_path . 'includes/diff/engine.' . $this->php_ext); } $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; $file_diffed = false; foreach ($updater_config['update_info']['edited'] as $key => $file_path) { if (in_array($file_path, $updater_config['merge_calculated'])) { continue; } $new_file_contents = @file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path); if (file_exists($current_files_path . $file_path)) { $file_contents[0] = @file_get_contents($updater_config['tmp_dir'] . 'old/' . $file_path); $file_contents[1] = @file_get_contents($current_files_path . $file_path); $file_contents[2] = $new_file_contents; $diff = new \diff3($file_contents[0], $file_contents[1], $file_contents[2]); if ($diff->get_num_conflicts() !== 0) { $updater_config['merge_conflicts'] = true; $merge_conflicts_path = $this->root_path . 'store/merge_conflicts_' . $style_name . '/'; $this->filesystem->mkdir($merge_conflicts_path . dirname($file_path)); file_put_contents($merge_conflicts_path . $file_path, implode("\n", $diff->merged_output())); } if ($diff->merged_output() !== $file_contents[1]) { $this->cache->put('_bbcore_updater_' . md5($file_path), implode("\n", $diff->merged_output())); $updater_config['merge_calculated'][] = $file_path; } unset($file_contents); unset($diff); } else { $this->cache->put('_bbcore_updater_' . md5($file_path), $new_file_contents); $updater_config['merge_calculated'][] = $file_path; } unset($updater_config['update_info']['edited'][$key]); break; } return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php"
+index 1bdf59226..66b407bd6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php"
+@@ -1,27 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t8_check_additions
+-{
+-	protected $language;
+-	protected $root_path;
+-	public function __construct(\phpbb\language\language $language, $root_path)
+-	{
+-		$this->language = $language;
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path)
+-	{
+-		$updater_config['last_step'] = 't8_check_additions';
+-		return $updater_config;
+-	}
+-}
++class t8_check_additions { protected $language; protected $root_path; public function __construct(\phpbb\language\language $language, $root_path) { $this->language = $language; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $updater_config['last_step'] = 't8_check_additions'; return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php"
+index 60cf5f9d2..0a800b8c5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php"
+@@ -1,39 +1,10 @@
+ <?php
+-
+ /**
+- *
+- * @package sitesplat BBcore
+- * @copyright (c) 2021 SiteSplat All rights reserved
+- * @license Proprietary
+- *
+- */
+-
++*
++* @package sitesplat BBcore
++* @copyright (c) 2021 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
+ namespace sitesplat\BBCore\updater\task;
+-
+-class t9_update_edits
+-{
+-	protected $cache;
+-	protected $root_path;
+-	public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path)
+-	{
+-		$this->cache = $cache;
+-		$this->root_path = $root_path;
+-	}
+-	public function run($style_name, $updater_config, $root_path, $fs)
+-	{
+-		$this->root_path = $root_path;
+-		if (empty($updater_config['merge_calculated'])) {
+-			$updater_config['last_step'] = 't9_update_edits';
+-			return $updater_config;
+-		}
+-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
+-		foreach ($updater_config['merge_calculated'] as $key => $file_path) {
+-			$cache_name = '_bbcore_updater_' . md5($file_path);
+-			$fs->put($current_files_path . $file_path, $this->cache->get($cache_name), true);
+-			$this->cache->destroy($cache_name);
+-			unset($updater_config['merge_calculated'][$key]);
+-			break;
+-		}
+-		return $updater_config;
+-	}
+-}
++class t9_update_edits { protected $cache; protected $root_path; public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path) { $this->cache = $cache; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; if (empty($updater_config['merge_calculated'])) { $updater_config['last_step'] = 't9_update_edits'; return $updater_config; } $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; foreach ($updater_config['merge_calculated'] as $key => $file_path) { $cache_name = '_bbcore_updater_' . md5($file_path); $fs->put($current_files_path . $file_path, $this->cache->get($cache_name), true); $this->cache->destroy($cache_name); unset($updater_config['merge_calculated'][$key]); break; } return $updater_config; } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/fonts/Thumbs.db" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/fonts/Thumbs.db"
+deleted file mode 100644
+index 95ac42e65..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/fonts/Thumbs.db" and /dev/null differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/Thumbs.db" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/Thumbs.db"
+deleted file mode 100644
+index fb33f9680..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/Thumbs.db" and /dev/null differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/colorpicker/Thumbs.db" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/colorpicker/Thumbs.db"
+deleted file mode 100644
+index 1699e2b8e..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/colorpicker/Thumbs.db" and /dev/null differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/jquery-file-tree/images/Thumbs.db" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/jquery-file-tree/images/Thumbs.db"
+deleted file mode 100644
+index 52fe27f99..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/jquery-file-tree/images/Thumbs.db" and /dev/null differ
diff --git "[FORUM_EXT]/sitesplat\\BBCore/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\BBCore/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\BBCore/diff_nospace.tmp"
@@ -0,0 +1,5429 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+index ab4a9ba9d..bb6ecbbfb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+@@ -1,5 +1,4 @@
+ <?php
+-
+ /**
+ *
+ * @package sitesplat BBcore
+@@ -9,356 +8,4 @@
+ */
+ 
+ namespace sitesplat\BBCore\acp;
+-
+-class bbcore_module
+-{
+-	var $u_action, $id;
+-	protected $fs, $writable, $host, $path;
+-	function main($id, $mode)
+-	{
+-		global $phpbb_container, $user, $template;
+-		$this->id = $id;
+-		$this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host');
+-		$this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path');
+-		$this->tpl_name = 'bbcore';
+-		$this->page_title = 'BBCore';
+-		$this->fs = \sitesplat\fs_instance();
+-		$this->writable = $this->fs->init();
+-		$user->add_lang_ext('sitesplat/BBCore', 'filesystem');
+-		if ($mode == 'update') {
+-			$this->update();
+-		} else if ($mode == 'settings') {
+-			$this->settings($this->fs_check());
+-		} else {
+-			$this->fs_check(true);
+-		}
+-		add_form_key('sitesplat/BBCore');
+-		$template->assign_vars(['U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true,]);
+-	}
+-	function update()
+-	{
+-		global $request, $db, $template, $user;
+-		$BBOOTS = '3.3.0';
+-		$FLATBOOTS = '3.3.0';
+-		$action = $request->variable('action', '');
+-		if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) {
+-			$this->autoupdate($action);
+-		}
+-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
+-		$result = $db->sql_query($sql);
+-		while ($row = $db->sql_fetchrow($result)) {
+-			$ustyle_name = strtoupper($row['style_name']);
+-			$cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . "/styles/$ustyle_name/style.cfg");
+-			$data = $this->get_data($row['style_name']);
+-			if (isset($data['version'])) {
+-				$update = version_compare($cfg_ary['style_version'], $data['version'], '<');
+-				$auto_update = version_compare($cfg_ary['style_version'], ${$ustyle_name}, '>=');
+-				$template->assign_block_vars('sitesplat_themes', array('NAME' => $ustyle_name, 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false,));
+-			}
+-		}
+-		$db->sql_freeresult($result);
+-	}
+-	function settings($ftpuser)
+-	{
+-		global $auth, $cache, $user, $request, $config, $template, $db;
+-		$ftpport = $ftperror = $msg = $addon_msg = '';
+-		if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) {
+-			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-		if ($request->is_set_post('addonsave')) {
+-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']);
+-			if (!$addon_error) {
+-				trigger_error($addon_msg . adm_back_link($this->u_action));
+-			}
+-		} else if ($request->is_set_post('optsave')) {
+-			$config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0));
+-			$config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0));
+-			trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action));
+-		} else if ($request->is_set_post('ftpsave')) {
+-			$ftpdata = $request->variable('ftpdata', array('' => ''), true);
+-			$ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host'];
+-			$ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port'];
+-			$ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user'];
+-			$ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass'];
+-			$ftpssl = empty($ftpdata['ssl']) ? 0 : 1;
+-			if ($ftpssl) {
+-				$conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60);
+-			} else {
+-				$conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60);
+-			}
+-			if (!$conn) {
+-				$ftperror = $user->lang['FTP_BAD_HOST'];
+-			} else {
+-				if (!@ftp_login($conn, $ftpuser, $ftppass)) {
+-					$ftperror = $user->lang['FTP_BAD_USER'];
+-				} else if (!$ftproot = $this->find_ftproot($conn)) {
+-					$ftperror = $user->lang['FTP_NO_PATH'];
+-				} else if (!@ftp_chdir($conn, $ftproot)) {
+-					$ftperror = $user->lang['FTP_BAD_PATH'];
+-				} else {
+-					$config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost, $ftpport, $ftproot, $ftpuser, $ftppass, $ftpssl], 320))));
+-					trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action));
+-				}
+-				@ftp_quit($conn);
+-			}
+-			$msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS'];
+-		}
+-		if (!$ftpport && !empty($config['dd_fs'])) {
+-			$ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true);
+-			$ftphost = $ftpdata[0];
+-			$ftpport = $ftpdata[1];
+-			$ftpuser = $ftpdata[3];
+-			$ftppass = $ftpdata[4];
+-			$ftpssl = $ftpdata[5];
+-		} else if (!$ftpport) {
+-			$ftphost = '';
+-			$ftpport = 21;
+-			$ftppass = '';
+-			$ftpssl = 0;
+-		}
+-		$okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct';
+-		list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]);
+-		$template->assign_vars(['S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg,]);
+-	}
+-	private function find_ftproot($conn)
+-	{
+-		@ftp_pasv($conn, true);
+-		@ftp_delete($conn, 'ftptest.dd');
+-		if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) {
+-			return false;
+-		}
+-		$s = DIRECTORY_SEPARATOR;
+-		$phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true);
+-		$rpath = $this->find_ftptest($phpbb, $s);
+-		@ftp_delete($conn, 'ftptest.dd');
+-		if (!$rpath) {
+-			return false;
+-		}
+-		return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath)));
+-	}
+-	private function find_ftptest($fdir, $s)
+-	{
+-		if (file_exists("{$fdir}{$s}ftptest.dd")) {
+-			return $fdir;
+-		}
+-		$newdir = dirname($fdir);
+-		if ($fdir == $newdir) {
+-			return false;
+-		}
+-		return $this->find_ftptest($newdir, $s);
+-	}
+-	public function fs_check($tpl = false)
+-	{
+-		global $db, $user, $template, $request;
+-		$userowner = $baduserowner = $sysinfo = $ownermsg = '';
+-		if ($request->is_set_post('dash_submit')) {
+-			if (!check_form_key('sitesplat/BBCore')) {
+-				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
+-			}
+-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']);
+-			if (!$addon_error) {
+-				trigger_error($addon_msg . adm_back_link($this->u_action));
+-			}
+-			$template->assign_var('BBCORE_DASH_ERROR', $addon_msg);
+-		}
+-		$opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux';
+-		$sapi = php_sapi_name();
+-		$cgi = strpos(strtolower($sapi), 'cgi') !== false;
+-		if ($tpl) {
+-			if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) {
+-				$cpuinfo = (string) @file_get_contents('/proc/cpuinfo');
+-				preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match);
+-				if (!empty($match[1])) {
+-					$numcores = count($match[1]);
+-					$numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)";
+-					$sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />";
+-				}
+-			}
+-			$request->enable_super_globals();
+-			$web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}";
+-			$sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)";
+-		}
+-		$find_ary = [];
+-		$dis = trim(ini_get('disable_functions'));
+-		if ($dis) {
+-			$dis = array_map('trim', explode(',', $dis));
+-			if ($opsys == 'Windows' || $cgi) {
+-				$find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']);
+-			}
+-		}
+-		$okexec = function_exists('shell_exec');
+-		$okshell = !count($find_ary) && $okexec;
+-		if ($opsys == 'Linux') {
+-			if (!extension_loaded('posix')) {
+-				$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
+-			} else if (is_array($dis)) {
+-				$find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']);
+-				if (count($find_ary2)) {
+-					$ownermsg = "\t";
+-					$find_ary = array_merge($find_ary, $find_ary2);
+-				}
+-			}
+-		} else {
+-			$ownermsg = "\t";
+-		}
+-		if (!$ownermsg) {
+-			$owner = @fileowner(__DIR__);
+-			if ($owner !== false) {
+-				$userowner = posix_getpwuid($owner);
+-				if (!empty($userowner['name'])) {
+-					$userowner = $userowner['name'];
+-					$baduserowner = ($owner < 500 || in_array($userowner, ['apache', 'www-data', 'nginx', 'nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : '';
+-					$owner = posix_getuid();
+-					$userphp = posix_getpwuid($owner);
+-					$userphp = $userphp['name'];
+-					$ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp);
+-				} else {
+-					$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
+-				}
+-			}
+-		}
+-		if ($tpl) {
+-			if ($opsys == 'Linux' && $okshell) {
+-				$mem = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`));
+-				if (count($mem) == 2) {
+-					list($mem_avail, $mem_used) = $mem;
+-					$mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail / 1000 . 'GB';
+-					$mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used / 1000 . 'GB';
+-					$sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used);
+-				}
+-			}
+-			$basedir = @ini_get('open_basedir');
+-			if ($basedir) {
+-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir);
+-			}
+-			if (!in_array('shell_exec', $find_ary) && !$okexec) {
+-				$sysinfo .= '<br /><br />' . $user->lang['BBCORE_BAD_PHP'];
+-			}
+-			$not_installed = $user->lang['PHP_EXT_MISSING'];
+-			$messages = [];
+-			if (!extension_loaded('curl')) {
+-				$messages[] = sprintf($not_installed, 'curl');
+-			}
+-			if (!extension_loaded('mbstring')) {
+-				$messages[] = sprintf($not_installed, 'mbstring');
+-			}
+-			if (!extension_loaded('zip')) {
+-				$messages[] = sprintf($not_installed, 'zip');
+-			}
+-			if (!extension_loaded('exif')) {
+-				$messages[] = sprintf($not_installed, 'exif');
+-			}
+-			if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) {
+-				$messages[] = sprintf($not_installed, 'sodium');
+-			}
+-			if (count($messages)) {
+-				$sysinfo .= '<br /><br />' . implode('<br />', $messages);
+-			}
+-			if (count($find_ary)) {
+-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary));
+-			}
+-			$badmsg = '';
+-			if (!$this->writable) {
+-				if ($opsys == 'Windows') {
+-					$badmsg = $user->lang['FS_BAD_WINDOWS'];
+-				} else if ($cgi) {
+-					$badmsg = $user->lang['FS_BAD_CGI'];
+-				} else if (!extension_loaded('zlib')) {
+-					$badmsg = sprintf($not_installed, 'zlib');
+-				} else if (!extension_loaded('ftp')) {
+-					$badmsg = sprintf($not_installed, 'ftp');
+-				} else {
+-					$badmsg = $user->lang['FS_BAD_CREDS'];
+-				}
+-				$badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}";
+-			}
+-			$founders = [];
+-			if ($user->data['user_type'] == USER_FOUNDER) {
+-				$result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER);
+-				while ($row = $db->sql_fetchrow($result)) {
+-					$founders[] = $row['username'];
+-				}
+-				$db->sql_freeresult($result);
+-			}
+-			$template->assign_vars(['BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''),]);
+-		} else {
+-			return ($userowner && !$baduserowner) ? $userowner : '';
+-		}
+-	}
+-	protected function check_dat($dis, $fn_ary)
+-	{
+-		$find_ary = [];
+-		foreach ($dis as $dat) {
+-			if (in_array($dat, $fn_ary)) {
+-				$find_ary[] = $dat;
+-			}
+-		}
+-		return $find_ary;
+-	}
+-	protected function get_data($what = '')
+-	{
+-		global $cache, $phpbb_container;
+-		$file_downloader = $phpbb_container->get('file_downloader');
+-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
+-		if (($info = $cache->get($cache_file)) === false) {
+-			try {
+-				$info = $file_downloader->get($this->host, $this->path, $what, 443);
+-			} catch (\phpbb\exception\runtime_exception $exception) {
+-				$info = '';
+-			}
+-			$info = json_decode($info, true);
+-			if (!empty($info)) {
+-				$json_sanitizer = function (&$value, $key) {
+-					$type_cast_helper = new \phpbb\request\type_cast_helper();
+-					$type_cast_helper->set_var($value, $value, gettype($value), true);
+-				};
+-				array_walk_recursive($info, $json_sanitizer);
+-				$cache->put($cache_file, $info, 86400);
+-			}
+-		}
+-		return $info;
+-	}
+-	public function autoupdate($action)
+-	{
+-		global $config, $request, $user, $cache, $auth, $db, $phpbb_container;
+-		$config_text = $phpbb_container->get('config_text');
+-		if ($action === 'autoupdate_confirm') {
+-			$config_text->set('sitesplat_bbcore_updater', '');
+-			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields(['id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate',]));
+-		}
+-		if ($action !== 'autoupdate') {
+-			return;
+-		}
+-		if ($request->is_set('cancel')) {
+-			redirect($this->u_action);
+-		}
+-		$style_name = $request->variable('style', '');
+-		if (empty($style_name)) {
+-			trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-		$config->set('board_disable', true);
+-		$finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name);
+-		if ($finished === true) {
+-			$config->increment('assets_version', 1);
+-			$cache->purge();
+-			$phpbb_container->get('text_formatter.s9e.factory')->tidy();
+-			$auth->acl_clear_prefetch();
+-			phpbb_cache_moderators($db, $cache, $auth);
+-			$config->set('board_disable', false);
+-			trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action));
+-		} else {
+-			if ($finished === false) {
+-				if ($request->is_ajax()) {
+-					$sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true);
+-					$response = new \phpbb\json_response;
+-					$response->send(['continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'],]);
+-				} else {
+-					meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name);
+-					trigger_error('UPDATE_IN_PROGRESS');
+-				}
+-			} else {
+-				trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING);
+-			}
+-		}
+-	}
+-}
++class bbcore_module { var $u_action, $id; protected $fs, $writable, $host, $path; function main($id, $mode) { global $phpbb_container, $user, $template; $this->id = $id; $this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host'); $this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path'); $this->tpl_name = 'bbcore'; $this->page_title = 'BBCore'; $this->fs = \sitesplat\fs_instance(); $this->writable = $this->fs->init(); $user->add_lang_ext('sitesplat/BBCore', 'filesystem'); if ($mode == 'update') { $this->update(); } else if ($mode == 'settings') { $this->settings($this->fs_check()); } else { $this->fs_check(true); } add_form_key('sitesplat/BBCore'); $template->assign_vars([ 'U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true, ]); } function update() { global $request, $db, $template, $user; $action = $request->variable('action', ''); if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) { $this->autoupdate($action); } $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . '/styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version'])) { $update = version_compare($cfg_ary['style_version'], $data['version'] , '<'); $template->assign_block_vars('sitesplat_themes', array( 'NAME' => strtoupper($row['style_name']), 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false, )); } } $db->sql_freeresult($result); } function settings($ftpuser) { global $auth, $cache, $user, $request, $config, $template, $db; $ftpport = $ftperror = $msg = $addon_msg = ''; if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } if ($request->is_set_post('addonsave')) { list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } } else if ($request->is_set_post('optsave')) { $config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0)); $config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0)); trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action)); } else if ($request->is_set_post('ftpsave')) { $ftpdata = $request->variable('ftpdata', array('' => ''), true); $ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host']; $ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port']; $ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user']; $ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass']; $ftpssl = empty($ftpdata['ssl']) ? 0 : 1; if ($ftpssl) { $conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60); } else { $conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60); } if (!$conn) { $ftperror = $user->lang['FTP_BAD_HOST']; } else { if (!@ftp_login($conn, $ftpuser, $ftppass)) { $ftperror = $user->lang['FTP_BAD_USER']; } else if (!$ftproot = $this->find_ftproot($conn)) { $ftperror = $user->lang['FTP_NO_PATH']; } else if (!@ftp_chdir($conn, $ftproot)) { $ftperror = $user->lang['FTP_BAD_PATH']; } else { $config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost,$ftpport,$ftproot,$ftpuser,$ftppass,$ftpssl], 320)))); trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action)); } @ftp_quit($conn); } $msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS']; } if (!$ftpport && !empty($config['dd_fs'])) { $ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true); $ftphost = $ftpdata[0]; $ftpport = $ftpdata[1]; $ftpuser = $ftpdata[3]; $ftppass = $ftpdata[4]; $ftpssl = $ftpdata[5]; } else if (!$ftpport) { $ftphost = ''; $ftpport = 21; $ftppass = ''; $ftpssl = 0; } $okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct'; list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]); $template->assign_vars([ 'S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg, ]); } private function find_ftproot($conn) { @ftp_pasv($conn, true); @ftp_delete($conn, 'ftptest.dd'); if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) { return false; } $s = DIRECTORY_SEPARATOR; $phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true); $rpath = $this->find_ftptest($phpbb, $s); @ftp_delete($conn, 'ftptest.dd'); if (!$rpath) { return false; } return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath))); } private function find_ftptest($fdir, $s) { if (file_exists("{$fdir}{$s}ftptest.dd")) { return $fdir; } $newdir = dirname($fdir); if ($fdir == $newdir) { return false; } return $this->find_ftptest($newdir, $s); } public function fs_check($tpl = false) { global $db, $user, $template, $request; $userowner = $baduserowner = $sysinfo = $ownermsg = ''; if ($request->is_set_post('dash_submit')) { if (!check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } $template->assign_var('BBCORE_DASH_ERROR', $addon_msg); } $opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux'; $sapi = php_sapi_name(); $cgi = strpos(strtolower($sapi), 'cgi') !== false; if ($tpl) { if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) { $cpuinfo = (string) @file_get_contents('/proc/cpuinfo'); preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match); if (!empty($match[1])) { $numcores = count($match[1]); $numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)"; $sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />"; } } $request->enable_super_globals(); $web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}"; $sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)"; } $find_ary = []; $dis = trim(ini_get('disable_functions')); if ($dis) { $dis = array_map('trim', explode(',', $dis)); if ($opsys == 'Windows' || $cgi) { $find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']); } } $okshell = !count($find_ary); if ($opsys == 'Linux') { if (!extension_loaded('posix')) { $ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}"; } else if (is_array($dis)) { $find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']); if (count($find_ary2)) { $ownermsg = "\t"; $find_ary = array_merge($find_ary, $find_ary2); } } } else { $ownermsg = "\t"; } if (!$ownermsg) { $owner = @fileowner(__DIR__); if ($owner !== false) { $userowner = posix_getpwuid($owner)['name']; $baduserowner = ($owner < 500 || in_array($userowner, ['apache','www-data','nginx','nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : ''; $owner = posix_getuid(); $userphp = posix_getpwuid($owner)['name']; $ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp); } } if ($tpl) { if ($opsys == 'Linux' && $okshell) { list($mem_avail, $mem_used) = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`)); $mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail/1000 . 'GB'; $mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used/1000 . 'GB'; $sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used); } $basedir = @ini_get('open_basedir'); if ($basedir) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir); } $not_installed = $user->lang['PHP_EXT_MISSING']; $messages = []; if (!extension_loaded('curl')) { $messages[] = sprintf($not_installed, 'curl'); } if (!extension_loaded('mbstring')) { $messages[] = sprintf($not_installed, 'mbstring'); } if (!extension_loaded('zip')) { $messages[] = sprintf($not_installed, 'zip'); } if (!extension_loaded('exif')) { $messages[] = sprintf($not_installed, 'exif'); } if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) { $messages[] = sprintf($not_installed, 'sodium'); } if (count($messages)) { $sysinfo .= '<br /><br />' . implode('<br />', $messages); } if (count($find_ary)) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary)); } $badmsg = ''; if (!$this->writable) { if ($opsys == 'Windows') { $badmsg = $user->lang['FS_BAD_WINDOWS']; } else if ($cgi) { $badmsg = $user->lang['FS_BAD_CGI']; } else if (!extension_loaded('zlib')) { $badmsg = sprintf($not_installed, 'zlib'); } else if (!extension_loaded('ftp')) { $badmsg = sprintf($not_installed, 'ftp'); } else { $badmsg = $user->lang['FS_BAD_CREDS']; } $badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}"; } $founders = []; if ($user->data['user_type'] == USER_FOUNDER) { $result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER); while ($row = $db->sql_fetchrow($result)) { $founders[] = $row['username']; } $db->sql_freeresult($result); } $template->assign_vars([ 'BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''), ]); } else { return ($userowner && !$baduserowner) ? $userowner : ''; } } protected function check_dat($dis, $fn_ary) { $find_ary = []; foreach ($dis as $dat) { if (in_array($dat, $fn_ary)) { $find_ary[] = $dat; } } return $find_ary; } protected function get_data($what = '') { global $cache, $phpbb_container; $file_downloader = $phpbb_container->get('file_downloader'); $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $cache->get($cache_file)) === false) { try { $info = $file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $cache->put($cache_file, $info, 86400); } } return $info; } public function autoupdate($action) { global $config, $request, $user, $cache, $auth, $db, $phpbb_container; $config_text = $phpbb_container->get('config_text'); if ($action === 'autoupdate_confirm') { $config_text->set('sitesplat_bbcore_updater', ''); confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields([ 'id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate', ])); } if ($action !== 'autoupdate') { return; } if ($request->is_set('cancel')) { redirect($this->u_action); } $style_name = $request->variable('style', ''); if (empty($style_name)) { trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING); } $config->set('board_disable', true); $finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name); if ($finished === true) { $config->increment('assets_version', 1); $cache->purge(); $phpbb_container->get('text_formatter.s9e.factory')->tidy(); $auth->acl_clear_prefetch(); phpbb_cache_moderators($db, $cache, $auth); $config->set('board_disable', false); trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action)); } else { if ($finished === false) { if ($request->is_ajax()) { $sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true); $response = new \phpbb\json_response; $response->send([ 'continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'], ]); } else { meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name); trigger_error('UPDATE_IN_PROGRESS'); } } else { trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING); } } } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/composer.json"
+index 69e96c912..60f3391fb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "The BBcore™© Adds Needed and Essential Functions into your phpBB® Instance in order to run SiteSplat Themes and also greatelay enhance the general forum experience",
+ 	"homepage": "https://sitesplat.com",
+-	"version": "4.2.5",
++	"version": "4.2.2",
+ 	"keywords": ["phpbb", "extension", "bbcore", "bboots", "flatboots", "sitesplat", "envato", "themeforest", "cosmetic", "core"],
+ 	"license": "Proprietary/All rights reserved",
+ 	"authors": [
+@@ -26,7 +26,7 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbcore-autoupdate.json",
++            "filename": "bbcore.json",
+ 			"ssl": true
+ 		}
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp"
+new file mode 100644
+index 000000000..ef8c7d1e0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp"
+@@ -0,0 +1,5049 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++index ab4a9ba9d..bb6ecbbfb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++@@ -1,364 +1,11 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2020 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2020 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ 
++ namespace sitesplat\BBCore\acp;
++-
++-class bbcore_module
++-{
++-	var $u_action, $id;
++-	protected $fs, $writable, $host, $path;
++-	function main($id, $mode)
++-	{
++-		global $phpbb_container, $user, $template;
++-		$this->id = $id;
++-		$this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host');
++-		$this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path');
++-		$this->tpl_name = 'bbcore';
++-		$this->page_title = 'BBCore';
++-		$this->fs = \sitesplat\fs_instance();
++-		$this->writable = $this->fs->init();
++-		$user->add_lang_ext('sitesplat/BBCore', 'filesystem');
++-		if ($mode == 'update') {
++-			$this->update();
++-		} else if ($mode == 'settings') {
++-			$this->settings($this->fs_check());
++-		} else {
++-			$this->fs_check(true);
++-		}
++-		add_form_key('sitesplat/BBCore');
++-		$template->assign_vars(['U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true,]);
++-	}
++-	function update()
++-	{
++-		global $request, $db, $template, $user;
++-		$BBOOTS = '3.3.0';
++-		$FLATBOOTS = '3.3.0';
++-		$action = $request->variable('action', '');
++-		if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) {
++-			$this->autoupdate($action);
++-		}
++-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
++-		$result = $db->sql_query($sql);
++-		while ($row = $db->sql_fetchrow($result)) {
++-			$ustyle_name = strtoupper($row['style_name']);
++-			$cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . "/styles/$ustyle_name/style.cfg");
++-			$data = $this->get_data($row['style_name']);
++-			if (isset($data['version'])) {
++-				$update = version_compare($cfg_ary['style_version'], $data['version'], '<');
++-				$auto_update = version_compare($cfg_ary['style_version'], ${$ustyle_name}, '>=');
++-				$template->assign_block_vars('sitesplat_themes', array('NAME' => $ustyle_name, 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false,));
++-			}
++-		}
++-		$db->sql_freeresult($result);
++-	}
++-	function settings($ftpuser)
++-	{
++-		global $auth, $cache, $user, $request, $config, $template, $db;
++-		$ftpport = $ftperror = $msg = $addon_msg = '';
++-		if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) {
++-			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
++-		}
++-		if ($request->is_set_post('addonsave')) {
++-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']);
++-			if (!$addon_error) {
++-				trigger_error($addon_msg . adm_back_link($this->u_action));
++-			}
++-		} else if ($request->is_set_post('optsave')) {
++-			$config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0));
++-			$config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0));
++-			trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action));
++-		} else if ($request->is_set_post('ftpsave')) {
++-			$ftpdata = $request->variable('ftpdata', array('' => ''), true);
++-			$ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host'];
++-			$ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port'];
++-			$ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user'];
++-			$ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass'];
++-			$ftpssl = empty($ftpdata['ssl']) ? 0 : 1;
++-			if ($ftpssl) {
++-				$conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60);
++-			} else {
++-				$conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60);
++-			}
++-			if (!$conn) {
++-				$ftperror = $user->lang['FTP_BAD_HOST'];
++-			} else {
++-				if (!@ftp_login($conn, $ftpuser, $ftppass)) {
++-					$ftperror = $user->lang['FTP_BAD_USER'];
++-				} else if (!$ftproot = $this->find_ftproot($conn)) {
++-					$ftperror = $user->lang['FTP_NO_PATH'];
++-				} else if (!@ftp_chdir($conn, $ftproot)) {
++-					$ftperror = $user->lang['FTP_BAD_PATH'];
++-				} else {
++-					$config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost, $ftpport, $ftproot, $ftpuser, $ftppass, $ftpssl], 320))));
++-					trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action));
++-				}
++-				@ftp_quit($conn);
++-			}
++-			$msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS'];
++-		}
++-		if (!$ftpport && !empty($config['dd_fs'])) {
++-			$ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true);
++-			$ftphost = $ftpdata[0];
++-			$ftpport = $ftpdata[1];
++-			$ftpuser = $ftpdata[3];
++-			$ftppass = $ftpdata[4];
++-			$ftpssl = $ftpdata[5];
++-		} else if (!$ftpport) {
++-			$ftphost = '';
++-			$ftpport = 21;
++-			$ftppass = '';
++-			$ftpssl = 0;
++-		}
++-		$okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct';
++-		list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]);
++-		$template->assign_vars(['S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg,]);
++-	}
++-	private function find_ftproot($conn)
++-	{
++-		@ftp_pasv($conn, true);
++-		@ftp_delete($conn, 'ftptest.dd');
++-		if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) {
++-			return false;
++-		}
++-		$s = DIRECTORY_SEPARATOR;
++-		$phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true);
++-		$rpath = $this->find_ftptest($phpbb, $s);
++-		@ftp_delete($conn, 'ftptest.dd');
++-		if (!$rpath) {
++-			return false;
++-		}
++-		return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath)));
++-	}
++-	private function find_ftptest($fdir, $s)
++-	{
++-		if (file_exists("{$fdir}{$s}ftptest.dd")) {
++-			return $fdir;
++-		}
++-		$newdir = dirname($fdir);
++-		if ($fdir == $newdir) {
++-			return false;
++-		}
++-		return $this->find_ftptest($newdir, $s);
++-	}
++-	public function fs_check($tpl = false)
++-	{
++-		global $db, $user, $template, $request;
++-		$userowner = $baduserowner = $sysinfo = $ownermsg = '';
++-		if ($request->is_set_post('dash_submit')) {
++-			if (!check_form_key('sitesplat/BBCore')) {
++-				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
++-			}
++-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']);
++-			if (!$addon_error) {
++-				trigger_error($addon_msg . adm_back_link($this->u_action));
++-			}
++-			$template->assign_var('BBCORE_DASH_ERROR', $addon_msg);
++-		}
++-		$opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux';
++-		$sapi = php_sapi_name();
++-		$cgi = strpos(strtolower($sapi), 'cgi') !== false;
++-		if ($tpl) {
++-			if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) {
++-				$cpuinfo = (string) @file_get_contents('/proc/cpuinfo');
++-				preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match);
++-				if (!empty($match[1])) {
++-					$numcores = count($match[1]);
++-					$numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)";
++-					$sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />";
++-				}
++-			}
++-			$request->enable_super_globals();
++-			$web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}";
++-			$sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)";
++-		}
++-		$find_ary = [];
++-		$dis = trim(ini_get('disable_functions'));
++-		if ($dis) {
++-			$dis = array_map('trim', explode(',', $dis));
++-			if ($opsys == 'Windows' || $cgi) {
++-				$find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']);
++-			}
++-		}
++-		$okexec = function_exists('shell_exec');
++-		$okshell = !count($find_ary) && $okexec;
++-		if ($opsys == 'Linux') {
++-			if (!extension_loaded('posix')) {
++-				$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
++-			} else if (is_array($dis)) {
++-				$find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']);
++-				if (count($find_ary2)) {
++-					$ownermsg = "\t";
++-					$find_ary = array_merge($find_ary, $find_ary2);
++-				}
++-			}
++-		} else {
++-			$ownermsg = "\t";
++-		}
++-		if (!$ownermsg) {
++-			$owner = @fileowner(__DIR__);
++-			if ($owner !== false) {
++-				$userowner = posix_getpwuid($owner);
++-				if (!empty($userowner['name'])) {
++-					$userowner = $userowner['name'];
++-					$baduserowner = ($owner < 500 || in_array($userowner, ['apache', 'www-data', 'nginx', 'nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : '';
++-					$owner = posix_getuid();
++-					$userphp = posix_getpwuid($owner);
++-					$userphp = $userphp['name'];
++-					$ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp);
++-				} else {
++-					$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
++-				}
++-			}
++-		}
++-		if ($tpl) {
++-			if ($opsys == 'Linux' && $okshell) {
++-				$mem = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`));
++-				if (count($mem) == 2) {
++-					list($mem_avail, $mem_used) = $mem;
++-					$mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail / 1000 . 'GB';
++-					$mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used / 1000 . 'GB';
++-					$sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used);
++-				}
++-			}
++-			$basedir = @ini_get('open_basedir');
++-			if ($basedir) {
++-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir);
++-			}
++-			if (!in_array('shell_exec', $find_ary) && !$okexec) {
++-				$sysinfo .= '<br /><br />' . $user->lang['BBCORE_BAD_PHP'];
++-			}
++-			$not_installed = $user->lang['PHP_EXT_MISSING'];
++-			$messages = [];
++-			if (!extension_loaded('curl')) {
++-				$messages[] = sprintf($not_installed, 'curl');
++-			}
++-			if (!extension_loaded('mbstring')) {
++-				$messages[] = sprintf($not_installed, 'mbstring');
++-			}
++-			if (!extension_loaded('zip')) {
++-				$messages[] = sprintf($not_installed, 'zip');
++-			}
++-			if (!extension_loaded('exif')) {
++-				$messages[] = sprintf($not_installed, 'exif');
++-			}
++-			if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) {
++-				$messages[] = sprintf($not_installed, 'sodium');
++-			}
++-			if (count($messages)) {
++-				$sysinfo .= '<br /><br />' . implode('<br />', $messages);
++-			}
++-			if (count($find_ary)) {
++-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary));
++-			}
++-			$badmsg = '';
++-			if (!$this->writable) {
++-				if ($opsys == 'Windows') {
++-					$badmsg = $user->lang['FS_BAD_WINDOWS'];
++-				} else if ($cgi) {
++-					$badmsg = $user->lang['FS_BAD_CGI'];
++-				} else if (!extension_loaded('zlib')) {
++-					$badmsg = sprintf($not_installed, 'zlib');
++-				} else if (!extension_loaded('ftp')) {
++-					$badmsg = sprintf($not_installed, 'ftp');
++-				} else {
++-					$badmsg = $user->lang['FS_BAD_CREDS'];
++-				}
++-				$badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}";
++-			}
++-			$founders = [];
++-			if ($user->data['user_type'] == USER_FOUNDER) {
++-				$result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER);
++-				while ($row = $db->sql_fetchrow($result)) {
++-					$founders[] = $row['username'];
++-				}
++-				$db->sql_freeresult($result);
++-			}
++-			$template->assign_vars(['BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''),]);
++-		} else {
++-			return ($userowner && !$baduserowner) ? $userowner : '';
++-		}
++-	}
++-	protected function check_dat($dis, $fn_ary)
++-	{
++-		$find_ary = [];
++-		foreach ($dis as $dat) {
++-			if (in_array($dat, $fn_ary)) {
++-				$find_ary[] = $dat;
++-			}
++-		}
++-		return $find_ary;
++-	}
++-	protected function get_data($what = '')
++-	{
++-		global $cache, $phpbb_container;
++-		$file_downloader = $phpbb_container->get('file_downloader');
++-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
++-		if (($info = $cache->get($cache_file)) === false) {
++-			try {
++-				$info = $file_downloader->get($this->host, $this->path, $what, 443);
++-			} catch (\phpbb\exception\runtime_exception $exception) {
++-				$info = '';
++-			}
++-			$info = json_decode($info, true);
++-			if (!empty($info)) {
++-				$json_sanitizer = function (&$value, $key) {
++-					$type_cast_helper = new \phpbb\request\type_cast_helper();
++-					$type_cast_helper->set_var($value, $value, gettype($value), true);
++-				};
++-				array_walk_recursive($info, $json_sanitizer);
++-				$cache->put($cache_file, $info, 86400);
++-			}
++-		}
++-		return $info;
++-	}
++-	public function autoupdate($action)
++-	{
++-		global $config, $request, $user, $cache, $auth, $db, $phpbb_container;
++-		$config_text = $phpbb_container->get('config_text');
++-		if ($action === 'autoupdate_confirm') {
++-			$config_text->set('sitesplat_bbcore_updater', '');
++-			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields(['id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate',]));
++-		}
++-		if ($action !== 'autoupdate') {
++-			return;
++-		}
++-		if ($request->is_set('cancel')) {
++-			redirect($this->u_action);
++-		}
++-		$style_name = $request->variable('style', '');
++-		if (empty($style_name)) {
++-			trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING);
++-		}
++-		$config->set('board_disable', true);
++-		$finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name);
++-		if ($finished === true) {
++-			$config->increment('assets_version', 1);
++-			$cache->purge();
++-			$phpbb_container->get('text_formatter.s9e.factory')->tidy();
++-			$auth->acl_clear_prefetch();
++-			phpbb_cache_moderators($db, $cache, $auth);
++-			$config->set('board_disable', false);
++-			trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action));
++-		} else {
++-			if ($finished === false) {
++-				if ($request->is_ajax()) {
++-					$sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true);
++-					$response = new \phpbb\json_response;
++-					$response->send(['continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'],]);
++-				} else {
++-					meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name);
++-					trigger_error('UPDATE_IN_PROGRESS');
++-				}
++-			} else {
++-				trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING);
++-			}
++-		}
++-	}
++-}
+++class bbcore_module { var $u_action, $id; protected $fs, $writable, $host, $path; function main($id, $mode) { global $phpbb_container, $user, $template; $this->id = $id; $this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host'); $this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path'); $this->tpl_name = 'bbcore'; $this->page_title = 'BBCore'; $this->fs = \sitesplat\fs_instance(); $this->writable = $this->fs->init(); $user->add_lang_ext('sitesplat/BBCore', 'filesystem'); if ($mode == 'update') { $this->update(); } else if ($mode == 'settings') { $this->settings($this->fs_check()); } else { $this->fs_check(true); } add_form_key('sitesplat/BBCore'); $template->assign_vars([ 'U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true, ]); } function update() { global $request, $db, $template, $user; $action = $request->variable('action', ''); if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) { $this->autoupdate($action); } $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . '/styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version'])) { $update = version_compare($cfg_ary['style_version'], $data['version'] , '<'); $template->assign_block_vars('sitesplat_themes', array( 'NAME' => strtoupper($row['style_name']), 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false, )); } } $db->sql_freeresult($result); } function settings($ftpuser) { global $auth, $cache, $user, $request, $config, $template, $db; $ftpport = $ftperror = $msg = $addon_msg = ''; if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } if ($request->is_set_post('addonsave')) { list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } } else if ($request->is_set_post('optsave')) { $config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0)); $config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0)); trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action)); } else if ($request->is_set_post('ftpsave')) { $ftpdata = $request->variable('ftpdata', array('' => ''), true); $ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host']; $ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port']; $ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user']; $ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass']; $ftpssl = empty($ftpdata['ssl']) ? 0 : 1; if ($ftpssl) { $conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60); } else { $conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60); } if (!$conn) { $ftperror = $user->lang['FTP_BAD_HOST']; } else { if (!@ftp_login($conn, $ftpuser, $ftppass)) { $ftperror = $user->lang['FTP_BAD_USER']; } else if (!$ftproot = $this->find_ftproot($conn)) { $ftperror = $user->lang['FTP_NO_PATH']; } else if (!@ftp_chdir($conn, $ftproot)) { $ftperror = $user->lang['FTP_BAD_PATH']; } else { $config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost,$ftpport,$ftproot,$ftpuser,$ftppass,$ftpssl], 320)))); trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action)); } @ftp_quit($conn); } $msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS']; } if (!$ftpport && !empty($config['dd_fs'])) { $ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true); $ftphost = $ftpdata[0]; $ftpport = $ftpdata[1]; $ftpuser = $ftpdata[3]; $ftppass = $ftpdata[4]; $ftpssl = $ftpdata[5]; } else if (!$ftpport) { $ftphost = ''; $ftpport = 21; $ftppass = ''; $ftpssl = 0; } $okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct'; list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]); $template->assign_vars([ 'S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg, ]); } private function find_ftproot($conn) { @ftp_pasv($conn, true); @ftp_delete($conn, 'ftptest.dd'); if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) { return false; } $s = DIRECTORY_SEPARATOR; $phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true); $rpath = $this->find_ftptest($phpbb, $s); @ftp_delete($conn, 'ftptest.dd'); if (!$rpath) { return false; } return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath))); } private function find_ftptest($fdir, $s) { if (file_exists("{$fdir}{$s}ftptest.dd")) { return $fdir; } $newdir = dirname($fdir); if ($fdir == $newdir) { return false; } return $this->find_ftptest($newdir, $s); } public function fs_check($tpl = false) { global $db, $user, $template, $request; $userowner = $baduserowner = $sysinfo = $ownermsg = ''; if ($request->is_set_post('dash_submit')) { if (!check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } $template->assign_var('BBCORE_DASH_ERROR', $addon_msg); } $opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux'; $sapi = php_sapi_name(); $cgi = strpos(strtolower($sapi), 'cgi') !== false; if ($tpl) { if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) { $cpuinfo = (string) @file_get_contents('/proc/cpuinfo'); preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match); if (!empty($match[1])) { $numcores = count($match[1]); $numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)"; $sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />"; } } $request->enable_super_globals(); $web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}"; $sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)"; } $find_ary = []; $dis = trim(ini_get('disable_functions')); if ($dis) { $dis = array_map('trim', explode(',', $dis)); if ($opsys == 'Windows' || $cgi) { $find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']); } } $okshell = !count($find_ary); if ($opsys == 'Linux') { if (!extension_loaded('posix')) { $ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}"; } else if (is_array($dis)) { $find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']); if (count($find_ary2)) { $ownermsg = "\t"; $find_ary = array_merge($find_ary, $find_ary2); } } } else { $ownermsg = "\t"; } if (!$ownermsg) { $owner = @fileowner(__DIR__); if ($owner !== false) { $userowner = posix_getpwuid($owner)['name']; $baduserowner = ($owner < 500 || in_array($userowner, ['apache','www-data','nginx','nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : ''; $owner = posix_getuid(); $userphp = posix_getpwuid($owner)['name']; $ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp); } } if ($tpl) { if ($opsys == 'Linux' && $okshell) { list($mem_avail, $mem_used) = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`)); $mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail/1000 . 'GB'; $mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used/1000 . 'GB'; $sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used); } $basedir = @ini_get('open_basedir'); if ($basedir) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir); } $not_installed = $user->lang['PHP_EXT_MISSING']; $messages = []; if (!extension_loaded('curl')) { $messages[] = sprintf($not_installed, 'curl'); } if (!extension_loaded('mbstring')) { $messages[] = sprintf($not_installed, 'mbstring'); } if (!extension_loaded('zip')) { $messages[] = sprintf($not_installed, 'zip'); } if (!extension_loaded('exif')) { $messages[] = sprintf($not_installed, 'exif'); } if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) { $messages[] = sprintf($not_installed, 'sodium'); } if (count($messages)) { $sysinfo .= '<br /><br />' . implode('<br />', $messages); } if (count($find_ary)) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary)); } $badmsg = ''; if (!$this->writable) { if ($opsys == 'Windows') { $badmsg = $user->lang['FS_BAD_WINDOWS']; } else if ($cgi) { $badmsg = $user->lang['FS_BAD_CGI']; } else if (!extension_loaded('zlib')) { $badmsg = sprintf($not_installed, 'zlib'); } else if (!extension_loaded('ftp')) { $badmsg = sprintf($not_installed, 'ftp'); } else { $badmsg = $user->lang['FS_BAD_CREDS']; } $badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}"; } $founders = []; if ($user->data['user_type'] == USER_FOUNDER) { $result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER); while ($row = $db->sql_fetchrow($result)) { $founders[] = $row['username']; } $db->sql_freeresult($result); } $template->assign_vars([ 'BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''), ]); } else { return ($userowner && !$baduserowner) ? $userowner : ''; } } protected function check_dat($dis, $fn_ary) { $find_ary = []; foreach ($dis as $dat) { if (in_array($dat, $fn_ary)) { $find_ary[] = $dat; } } return $find_ary; } protected function get_data($what = '') { global $cache, $phpbb_container; $file_downloader = $phpbb_container->get('file_downloader'); $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $cache->get($cache_file)) === false) { try { $info = $file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $cache->put($cache_file, $info, 86400); } } return $info; } public function autoupdate($action) { global $config, $request, $user, $cache, $auth, $db, $phpbb_container; $config_text = $phpbb_container->get('config_text'); if ($action === 'autoupdate_confirm') { $config_text->set('sitesplat_bbcore_updater', ''); confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields([ 'id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate', ])); } if ($action !== 'autoupdate') { return; } if ($request->is_set('cancel')) { redirect($this->u_action); } $style_name = $request->variable('style', ''); if (empty($style_name)) { trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING); } $config->set('board_disable', true); $finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name); if ($finished === true) { $config->increment('assets_version', 1); $cache->purge(); $phpbb_container->get('text_formatter.s9e.factory')->tidy(); $auth->acl_clear_prefetch(); phpbb_cache_moderators($db, $cache, $auth); $config->set('board_disable', false); trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action)); } else { if ($finished === false) { if ($request->is_ajax()) { $sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true); $response = new \phpbb\json_response; $response->send([ 'continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'], ]); } else { meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name); trigger_error('UPDATE_IN_PROGRESS'); } } else { trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING); } } } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/composer.json"
++index 69e96c912..60f3391fb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/composer.json"
++@@ -3,7 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "The BBcore™© Adds Needed and Essential Functions into your phpBB® Instance in order to run SiteSplat Themes and also greatelay enhance the general forum experience",
++ 	"homepage": "https://sitesplat.com",
++-	"version": "4.2.5",
+++	"version": "4.2.2",
++ 	"keywords": ["phpbb", "extension", "bbcore", "bboots", "flatboots", "sitesplat", "envato", "themeforest", "cosmetic", "core"],
++ 	"license": "Proprietary/All rights reserved",
++ 	"authors": [
++@@ -26,7 +26,7 @@
++ 		"version-check": {
++             "host": "sitesplat.com",
++             "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "bbcore-autoupdate.json",
+++            "filename": "bbcore.json",
++ 			"ssl": true
++ 		}
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp"
++new file mode 100644
++index 000000000..7191917df
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/diff_full.tmp"
++@@ -0,0 +1,376 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+++index ab4a9ba9d..bb6ecbbfb 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/acp/bbcore_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/acp/bbcore_module.php"
+++@@ -1,364 +1,11 @@
+++ <?php
+++-
+++ /**
+++- *
+++- * @package sitesplat BBcore
+++- * @copyright (c) 2020 SiteSplat All rights reserved
+++- * @license Proprietary
+++- *
+++- */
++++*
++++* @package sitesplat BBcore
++++* @copyright (c) 2020 SiteSplat All rights reserved
++++* @license Proprietary
++++*
++++*/
+++ 
+++ namespace sitesplat\BBCore\acp;
+++-
+++-class bbcore_module
+++-{
+++-	var $u_action, $id;
+++-	protected $fs, $writable, $host, $path;
+++-	function main($id, $mode)
+++-	{
+++-		global $phpbb_container, $user, $template;
+++-		$this->id = $id;
+++-		$this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host');
+++-		$this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path');
+++-		$this->tpl_name = 'bbcore';
+++-		$this->page_title = 'BBCore';
+++-		$this->fs = \sitesplat\fs_instance();
+++-		$this->writable = $this->fs->init();
+++-		$user->add_lang_ext('sitesplat/BBCore', 'filesystem');
+++-		if ($mode == 'update') {
+++-			$this->update();
+++-		} else if ($mode == 'settings') {
+++-			$this->settings($this->fs_check());
+++-		} else {
+++-			$this->fs_check(true);
+++-		}
+++-		add_form_key('sitesplat/BBCore');
+++-		$template->assign_vars(['U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true,]);
+++-	}
+++-	function update()
+++-	{
+++-		global $request, $db, $template, $user;
+++-		$BBOOTS = '3.3.0';
+++-		$FLATBOOTS = '3.3.0';
+++-		$action = $request->variable('action', '');
+++-		if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) {
+++-			$this->autoupdate($action);
+++-		}
+++-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
+++-		$result = $db->sql_query($sql);
+++-		while ($row = $db->sql_fetchrow($result)) {
+++-			$ustyle_name = strtoupper($row['style_name']);
+++-			$cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . "/styles/$ustyle_name/style.cfg");
+++-			$data = $this->get_data($row['style_name']);
+++-			if (isset($data['version'])) {
+++-				$update = version_compare($cfg_ary['style_version'], $data['version'], '<');
+++-				$auto_update = version_compare($cfg_ary['style_version'], ${$ustyle_name}, '>=');
+++-				$template->assign_block_vars('sitesplat_themes', array('NAME' => $ustyle_name, 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $auto_update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false,));
+++-			}
+++-		}
+++-		$db->sql_freeresult($result);
+++-	}
+++-	function settings($ftpuser)
+++-	{
+++-		global $auth, $cache, $user, $request, $config, $template, $db;
+++-		$ftpport = $ftperror = $msg = $addon_msg = '';
+++-		if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) {
+++-			trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
+++-		}
+++-		if ($request->is_set_post('addonsave')) {
+++-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']);
+++-			if (!$addon_error) {
+++-				trigger_error($addon_msg . adm_back_link($this->u_action));
+++-			}
+++-		} else if ($request->is_set_post('optsave')) {
+++-			$config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0));
+++-			$config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0));
+++-			trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action));
+++-		} else if ($request->is_set_post('ftpsave')) {
+++-			$ftpdata = $request->variable('ftpdata', array('' => ''), true);
+++-			$ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host'];
+++-			$ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port'];
+++-			$ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user'];
+++-			$ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass'];
+++-			$ftpssl = empty($ftpdata['ssl']) ? 0 : 1;
+++-			if ($ftpssl) {
+++-				$conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60);
+++-			} else {
+++-				$conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60);
+++-			}
+++-			if (!$conn) {
+++-				$ftperror = $user->lang['FTP_BAD_HOST'];
+++-			} else {
+++-				if (!@ftp_login($conn, $ftpuser, $ftppass)) {
+++-					$ftperror = $user->lang['FTP_BAD_USER'];
+++-				} else if (!$ftproot = $this->find_ftproot($conn)) {
+++-					$ftperror = $user->lang['FTP_NO_PATH'];
+++-				} else if (!@ftp_chdir($conn, $ftproot)) {
+++-					$ftperror = $user->lang['FTP_BAD_PATH'];
+++-				} else {
+++-					$config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost, $ftpport, $ftproot, $ftpuser, $ftppass, $ftpssl], 320))));
+++-					trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action));
+++-				}
+++-				@ftp_quit($conn);
+++-			}
+++-			$msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS'];
+++-		}
+++-		if (!$ftpport && !empty($config['dd_fs'])) {
+++-			$ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true);
+++-			$ftphost = $ftpdata[0];
+++-			$ftpport = $ftpdata[1];
+++-			$ftpuser = $ftpdata[3];
+++-			$ftppass = $ftpdata[4];
+++-			$ftpssl = $ftpdata[5];
+++-		} else if (!$ftpport) {
+++-			$ftphost = '';
+++-			$ftpport = 21;
+++-			$ftppass = '';
+++-			$ftpssl = 0;
+++-		}
+++-		$okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct';
+++-		list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]);
+++-		$template->assign_vars(['S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg,]);
+++-	}
+++-	private function find_ftproot($conn)
+++-	{
+++-		@ftp_pasv($conn, true);
+++-		@ftp_delete($conn, 'ftptest.dd');
+++-		if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) {
+++-			return false;
+++-		}
+++-		$s = DIRECTORY_SEPARATOR;
+++-		$phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true);
+++-		$rpath = $this->find_ftptest($phpbb, $s);
+++-		@ftp_delete($conn, 'ftptest.dd');
+++-		if (!$rpath) {
+++-			return false;
+++-		}
+++-		return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath)));
+++-	}
+++-	private function find_ftptest($fdir, $s)
+++-	{
+++-		if (file_exists("{$fdir}{$s}ftptest.dd")) {
+++-			return $fdir;
+++-		}
+++-		$newdir = dirname($fdir);
+++-		if ($fdir == $newdir) {
+++-			return false;
+++-		}
+++-		return $this->find_ftptest($newdir, $s);
+++-	}
+++-	public function fs_check($tpl = false)
+++-	{
+++-		global $db, $user, $template, $request;
+++-		$userowner = $baduserowner = $sysinfo = $ownermsg = '';
+++-		if ($request->is_set_post('dash_submit')) {
+++-			if (!check_form_key('sitesplat/BBCore')) {
+++-				trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING);
+++-			}
+++-			list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']);
+++-			if (!$addon_error) {
+++-				trigger_error($addon_msg . adm_back_link($this->u_action));
+++-			}
+++-			$template->assign_var('BBCORE_DASH_ERROR', $addon_msg);
+++-		}
+++-		$opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux';
+++-		$sapi = php_sapi_name();
+++-		$cgi = strpos(strtolower($sapi), 'cgi') !== false;
+++-		if ($tpl) {
+++-			if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) {
+++-				$cpuinfo = (string) @file_get_contents('/proc/cpuinfo');
+++-				preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match);
+++-				if (!empty($match[1])) {
+++-					$numcores = count($match[1]);
+++-					$numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)";
+++-					$sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />";
+++-				}
+++-			}
+++-			$request->enable_super_globals();
+++-			$web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}";
+++-			$sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)";
+++-		}
+++-		$find_ary = [];
+++-		$dis = trim(ini_get('disable_functions'));
+++-		if ($dis) {
+++-			$dis = array_map('trim', explode(',', $dis));
+++-			if ($opsys == 'Windows' || $cgi) {
+++-				$find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']);
+++-			}
+++-		}
+++-		$okexec = function_exists('shell_exec');
+++-		$okshell = !count($find_ary) && $okexec;
+++-		if ($opsys == 'Linux') {
+++-			if (!extension_loaded('posix')) {
+++-				$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
+++-			} else if (is_array($dis)) {
+++-				$find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']);
+++-				if (count($find_ary2)) {
+++-					$ownermsg = "\t";
+++-					$find_ary = array_merge($find_ary, $find_ary2);
+++-				}
+++-			}
+++-		} else {
+++-			$ownermsg = "\t";
+++-		}
+++-		if (!$ownermsg) {
+++-			$owner = @fileowner(__DIR__);
+++-			if ($owner !== false) {
+++-				$userowner = posix_getpwuid($owner);
+++-				if (!empty($userowner['name'])) {
+++-					$userowner = $userowner['name'];
+++-					$baduserowner = ($owner < 500 || in_array($userowner, ['apache', 'www-data', 'nginx', 'nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : '';
+++-					$owner = posix_getuid();
+++-					$userphp = posix_getpwuid($owner);
+++-					$userphp = $userphp['name'];
+++-					$ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp);
+++-				} else {
+++-					$ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}";
+++-				}
+++-			}
+++-		}
+++-		if ($tpl) {
+++-			if ($opsys == 'Linux' && $okshell) {
+++-				$mem = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`));
+++-				if (count($mem) == 2) {
+++-					list($mem_avail, $mem_used) = $mem;
+++-					$mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail / 1000 . 'GB';
+++-					$mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used / 1000 . 'GB';
+++-					$sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used);
+++-				}
+++-			}
+++-			$basedir = @ini_get('open_basedir');
+++-			if ($basedir) {
+++-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir);
+++-			}
+++-			if (!in_array('shell_exec', $find_ary) && !$okexec) {
+++-				$sysinfo .= '<br /><br />' . $user->lang['BBCORE_BAD_PHP'];
+++-			}
+++-			$not_installed = $user->lang['PHP_EXT_MISSING'];
+++-			$messages = [];
+++-			if (!extension_loaded('curl')) {
+++-				$messages[] = sprintf($not_installed, 'curl');
+++-			}
+++-			if (!extension_loaded('mbstring')) {
+++-				$messages[] = sprintf($not_installed, 'mbstring');
+++-			}
+++-			if (!extension_loaded('zip')) {
+++-				$messages[] = sprintf($not_installed, 'zip');
+++-			}
+++-			if (!extension_loaded('exif')) {
+++-				$messages[] = sprintf($not_installed, 'exif');
+++-			}
+++-			if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) {
+++-				$messages[] = sprintf($not_installed, 'sodium');
+++-			}
+++-			if (count($messages)) {
+++-				$sysinfo .= '<br /><br />' . implode('<br />', $messages);
+++-			}
+++-			if (count($find_ary)) {
+++-				$sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary));
+++-			}
+++-			$badmsg = '';
+++-			if (!$this->writable) {
+++-				if ($opsys == 'Windows') {
+++-					$badmsg = $user->lang['FS_BAD_WINDOWS'];
+++-				} else if ($cgi) {
+++-					$badmsg = $user->lang['FS_BAD_CGI'];
+++-				} else if (!extension_loaded('zlib')) {
+++-					$badmsg = sprintf($not_installed, 'zlib');
+++-				} else if (!extension_loaded('ftp')) {
+++-					$badmsg = sprintf($not_installed, 'ftp');
+++-				} else {
+++-					$badmsg = $user->lang['FS_BAD_CREDS'];
+++-				}
+++-				$badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}";
+++-			}
+++-			$founders = [];
+++-			if ($user->data['user_type'] == USER_FOUNDER) {
+++-				$result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER);
+++-				while ($row = $db->sql_fetchrow($result)) {
+++-					$founders[] = $row['username'];
+++-				}
+++-				$db->sql_freeresult($result);
+++-			}
+++-			$template->assign_vars(['BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''),]);
+++-		} else {
+++-			return ($userowner && !$baduserowner) ? $userowner : '';
+++-		}
+++-	}
+++-	protected function check_dat($dis, $fn_ary)
+++-	{
+++-		$find_ary = [];
+++-		foreach ($dis as $dat) {
+++-			if (in_array($dat, $fn_ary)) {
+++-				$find_ary[] = $dat;
+++-			}
+++-		}
+++-		return $find_ary;
+++-	}
+++-	protected function get_data($what = '')
+++-	{
+++-		global $cache, $phpbb_container;
+++-		$file_downloader = $phpbb_container->get('file_downloader');
+++-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
+++-		if (($info = $cache->get($cache_file)) === false) {
+++-			try {
+++-				$info = $file_downloader->get($this->host, $this->path, $what, 443);
+++-			} catch (\phpbb\exception\runtime_exception $exception) {
+++-				$info = '';
+++-			}
+++-			$info = json_decode($info, true);
+++-			if (!empty($info)) {
+++-				$json_sanitizer = function (&$value, $key) {
+++-					$type_cast_helper = new \phpbb\request\type_cast_helper();
+++-					$type_cast_helper->set_var($value, $value, gettype($value), true);
+++-				};
+++-				array_walk_recursive($info, $json_sanitizer);
+++-				$cache->put($cache_file, $info, 86400);
+++-			}
+++-		}
+++-		return $info;
+++-	}
+++-	public function autoupdate($action)
+++-	{
+++-		global $config, $request, $user, $cache, $auth, $db, $phpbb_container;
+++-		$config_text = $phpbb_container->get('config_text');
+++-		if ($action === 'autoupdate_confirm') {
+++-			$config_text->set('sitesplat_bbcore_updater', '');
+++-			confirm_box(false, 'AUTOUPDATE_CONFIRM', build_hidden_fields(['id' => $this->id, 'mode' => 'bbcore', 'action' => 'autoupdate',]));
+++-		}
+++-		if ($action !== 'autoupdate') {
+++-			return;
+++-		}
+++-		if ($request->is_set('cancel')) {
+++-			redirect($this->u_action);
+++-		}
+++-		$style_name = $request->variable('style', '');
+++-		if (empty($style_name)) {
+++-			trigger_error($user->lang('STYLE_NOT_DEFINED') . adm_back_link($this->u_action), E_USER_WARNING);
+++-		}
+++-		$config->set('board_disable', true);
+++-		$finished = $phpbb_container->get('sitesplat.bbcore.updater.next_step_resolver')->run_task($this->fs, $style_name);
+++-		if ($finished === true) {
+++-			$config->increment('assets_version', 1);
+++-			$cache->purge();
+++-			$phpbb_container->get('text_formatter.s9e.factory')->tidy();
+++-			$auth->acl_clear_prefetch();
+++-			phpbb_cache_moderators($db, $cache, $auth);
+++-			$config->set('board_disable', false);
+++-			trigger_error($user->lang('UPDATE_SUCCESS') . adm_back_link($this->u_action));
+++-		} else {
+++-			if ($finished === false) {
+++-				if ($request->is_ajax()) {
+++-					$sitesplat_bbcore_updater = json_decode($config_text->get('sitesplat_bbcore_updater'), true);
+++-					$response = new \phpbb\json_response;
+++-					$response->send(['continue' => true, 'href' => $this->u_action . '&action=autoupdate&style=' . $style_name, 'last_step' => $sitesplat_bbcore_updater['last_step'],]);
+++-				} else {
+++-					meta_refresh(0, $this->u_action . '&action=autoupdate&style=' . $style_name);
+++-					trigger_error('UPDATE_IN_PROGRESS');
+++-				}
+++-			} else {
+++-				trigger_error($user->lang($finished) . adm_back_link($this->u_action), E_USER_WARNING);
+++-			}
+++-		}
+++-	}
+++-}
++++class bbcore_module { var $u_action, $id; protected $fs, $writable, $host, $path; function main($id, $mode) { global $phpbb_container, $user, $template; $this->id = $id; $this->host = $phpbb_container->getParameter('sitesplat.bbcore.updater.host'); $this->path = $phpbb_container->getParameter('sitesplat.bbcore.updater.versioncheck_path'); $this->tpl_name = 'bbcore'; $this->page_title = 'BBCore'; $this->fs = \sitesplat\fs_instance(); $this->writable = $this->fs->init(); $user->add_lang_ext('sitesplat/BBCore', 'filesystem'); if ($mode == 'update') { $this->update(); } else if ($mode == 'settings') { $this->settings($this->fs_check()); } else { $this->fs_check(true); } add_form_key('sitesplat/BBCore'); $template->assign_vars([ 'U_ACTION' => $this->u_action, 'BBCORE_TITLE' => $this->page_title, 'BBCORE_MODE' => $mode, 'SITESPLAT_TAB' => true, ]); } function update() { global $request, $db, $template, $user; $action = $request->variable('action', ''); if ($this->writable && ($action == 'autoupdate' || $action == 'autoupdate_confirm')) { $this->autoupdate($action); } $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->fs->phpbb_root_dir . '/styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version'])) { $update = version_compare($cfg_ary['style_version'], $data['version'] , '<'); $template->assign_block_vars('sitesplat_themes', array( 'NAME' => strtoupper($row['style_name']), 'VERSION' => $cfg_ary['style_version'], 'DOWNLOAD_MSG' => sprintf($user->lang['DOWNLOAD_MSG'], $data['version'], $data['download_url'], $data['title']), 'DOWNLOAD_BTN_ENVATO' => sprintf($user->lang['DOWNLOAD_BTN_ENVATO'], $data['download_url']), 'CHANGE_LOG' => addslashes($data['changelog']), 'CHANGE_LOG_MSG' => sprintf($user->lang['CHANGE_LOG_MSG'], $data['changelog_url'], $data['title']), 'SUPPORT_FORUM_MSG' => sprintf($user->lang['SUPPORT_FORUM_MSG'], $data['support_forum']), 'S_UPDATE' => $update, 'U_AUTOUPDATE' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate_confirm&style=' . $row['style_name'] : false, 'U_AUTOUPDATE_STEP' => $update && $this->writable && !empty($data['direct_download_dir']) ? $this->u_action . '&action=autoupdate&style=' . $row['style_name'] : false, )); } } $db->sql_freeresult($result); } function settings($ftpuser) { global $auth, $cache, $user, $request, $config, $template, $db; $ftpport = $ftperror = $msg = $addon_msg = ''; if ($request->is_set_post('submit') && !check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } if ($request->is_set_post('addonsave')) { list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_addon_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } } else if ($request->is_set_post('optsave')) { $config->set('sitesplat_bbcore_emoji_revert', $request->variable('emoji', 0)); $config->set('sitesplat_bbcore_minify_html', $request->variable('minify', 0)); trigger_error($user->lang['BBCORE_OPT_SAVED'] . adm_back_link($this->u_action)); } else if ($request->is_set_post('ftpsave')) { $ftpdata = $request->variable('ftpdata', array('' => ''), true); $ftphost = empty($ftpdata['host']) ? '' : $ftpdata['host']; $ftpport = empty($ftpdata['port']) ? 21 : $ftpdata['port']; $ftpuser = empty($ftpdata['user']) ? '' : $ftpdata['user']; $ftppass = empty($ftpdata['pass']) ? '' : $ftpdata['pass']; $ftpssl = empty($ftpdata['ssl']) ? 0 : 1; if ($ftpssl) { $conn = @ftp_ssl_connect(($ftphost) ?: 'localhost', $ftpport, 60); } else { $conn = @ftp_connect(($ftphost) ?: 'localhost', $ftpport, 60); } if (!$conn) { $ftperror = $user->lang['FTP_BAD_HOST']; } else { if (!@ftp_login($conn, $ftpuser, $ftppass)) { $ftperror = $user->lang['FTP_BAD_USER']; } else if (!$ftproot = $this->find_ftproot($conn)) { $ftperror = $user->lang['FTP_NO_PATH']; } else if (!@ftp_chdir($conn, $ftproot)) { $ftperror = $user->lang['FTP_BAD_PATH']; } else { $config->set('dd_fs', base64_encode(gzdeflate(json_encode([$ftphost,$ftpport,$ftproot,$ftpuser,$ftppass,$ftpssl], 320)))); trigger_error($user->lang['FTP_FS_SUCCESS'] . adm_back_link($this->u_action)); } @ftp_quit($conn); } $msg = $ftperror ?: $user->lang['FTP_FS_SUCCESS']; } if (!$ftpport && !empty($config['dd_fs'])) { $ftpdata = json_decode(gzinflate(base64_decode($config['dd_fs'])), true); $ftphost = $ftpdata[0]; $ftpport = $ftpdata[1]; $ftpuser = $ftpdata[3]; $ftppass = $ftpdata[4]; $ftpssl = $ftpdata[5]; } else if (!$ftpport) { $ftphost = ''; $ftpport = 21; $ftppass = ''; $ftpssl = 0; } $okftp = function_exists('ftp_connect') && function_exists('gzdeflate') && $this->fs->fs_type != 'direct'; list($addon_form, $junk) = \sitesplat\apply_filters('bbcore_form_addons', ['', $this->u_action]); $template->assign_vars([ 'S_FS_FTP' => $okftp && $user->data['user_type'] == USER_FOUNDER, 'S_FS_FTP_ERROR' => $ftperror, 'FS_FTP_MESSAGE' => $msg, 'FS_FTPHOST' => $ftphost, 'FS_FTPPORT' => $ftpport, 'FS_FTPUSER' => $ftpuser, 'FS_FTPPASS' => $ftppass, 'FS_FTPSSL' => $ftpssl, 'S_FTPSSL' => function_exists('ftp_ssl_connect'), 'S_SS_EMOJI' => (int) $config['sitesplat_bbcore_emoji_revert'], 'S_SS_MINIFY' => (int) $config['sitesplat_bbcore_minify_html'], 'BBCORE_ADDONS' => \sitesplat\apply_filters('bbcore_addon_display', ''), 'BBC_FORM_ADDONS' => $addon_form, 'BBC_ADDON_ERROR' => $addon_msg, ]); } private function find_ftproot($conn) { @ftp_pasv($conn, true); @ftp_delete($conn, 'ftptest.dd'); if (!@ftp_put($conn, 'ftptest.dd', __DIR__ . '/ftptest.dd', FTP_BINARY)) { return false; } $s = DIRECTORY_SEPARATOR; $phpbb = strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}BBCore", true); $rpath = $this->find_ftptest($phpbb, $s); @ftp_delete($conn, 'ftptest.dd'); if (!$rpath) { return false; } return ($rpath == $phpbb) ? '/' : str_replace('\\', '/', substr($phpbb, strlen($rpath))); } private function find_ftptest($fdir, $s) { if (file_exists("{$fdir}{$s}ftptest.dd")) { return $fdir; } $newdir = dirname($fdir); if ($fdir == $newdir) { return false; } return $this->find_ftptest($newdir, $s); } public function fs_check($tpl = false) { global $db, $user, $template, $request; $userowner = $baduserowner = $sysinfo = $ownermsg = ''; if ($request->is_set_post('dash_submit')) { if (!check_form_key('sitesplat/BBCore')) { trigger_error($user->lang['FORM_INVALID'] . adm_back_link($this->u_action), E_USER_WARNING); } list($addon_error, $addon_msg) = \sitesplat\apply_filters('bbcore_dash_handle', [false, '']); if (!$addon_error) { trigger_error($addon_msg . adm_back_link($this->u_action)); } $template->assign_var('BBCORE_DASH_ERROR', $addon_msg); } $opsys = (PHP_SHLIB_SUFFIX == 'dll') ? 'Windows' : 'Linux'; $sapi = php_sapi_name(); $cgi = strpos(strtolower($sapi), 'cgi') !== false; if ($tpl) { if ($opsys == 'Linux' && @is_readable('/proc/cpuinfo')) { $cpuinfo = (string) @file_get_contents('/proc/cpuinfo'); preg_match_all('`model name.*?\:(.*?)\n`m', $cpuinfo, $match); if (!empty($match[1])) { $numcores = count($match[1]); $numcores = ($numcores == 1) ? '(1 Core)' : "($numcores Cores)"; $sysinfo .= '<strong>CPU:</strong> ' . trim($match[1][0]) . " $numcores<br />"; } } $request->enable_super_globals(); $web = empty($_SERVER['SERVER_SOFTWARE']) ? '' : "/{$_SERVER['SERVER_SOFTWARE']}"; $sysinfo .= "<strong>OS:</strong> $opsys$web<br /><strong>PHP:</strong> " . PHP_VERSION . " ($sapi)"; } $find_ary = []; $dis = trim(ini_get('disable_functions')); if ($dis) { $dis = array_map('trim', explode(',', $dis)); if ($opsys == 'Windows' || $cgi) { $find_ary = $this->check_dat($dis, ['shell_exec', 'passthru', 'escapeshellarg', 'escapeshellcmd']); } } $okshell = !count($find_ary); if ($opsys == 'Linux') { if (!extension_loaded('posix')) { $ownermsg = "<br /><br />{$user->lang['PHP_POSIX_MISSING']}"; } else if (is_array($dis)) { $find_ary2 = $this->check_dat($dis, ['fileowner', 'posix_getpwuid', 'posix_getuid']); if (count($find_ary2)) { $ownermsg = "\t"; $find_ary = array_merge($find_ary, $find_ary2); } } } else { $ownermsg = "\t"; } if (!$ownermsg) { $owner = @fileowner(__DIR__); if ($owner !== false) { $userowner = posix_getpwuid($owner)['name']; $baduserowner = ($owner < 500 || in_array($userowner, ['apache','www-data','nginx','nobody'])) ? " ({$user->lang['BBCORE_BIG_INCORRECT']})" : ''; $owner = posix_getuid(); $userphp = posix_getpwuid($owner)['name']; $ownermsg = '<br /><br />' . sprintf($user->lang['BBCORE_USEROWNER'], $userowner) . "{$baduserowner}<br />" . sprintf($user->lang['BBCORE_PHPOWNER'], $userphp); } } if ($tpl) { if ($opsys == 'Linux' && $okshell) { list($mem_avail, $mem_used) = explode(',', trim(`free -m | grep Mem | awk '{print $2","$3}'`)); $mem_avail = ($mem_avail < 1000) ? "{$mem_avail}MB" : $mem_avail/1000 . 'GB'; $mem_used = ($mem_used < 1000) ? "{$mem_used}MB" : $mem_used/1000 . 'GB'; $sysinfo .= '<br /><strong>MEM:</strong> ' . sprintf($user->lang['BBCORE_MEM'], $mem_avail, $mem_used); } $basedir = @ini_get('open_basedir'); if ($basedir) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_OPEN_BASEDIR'], $basedir); } $not_installed = $user->lang['PHP_EXT_MISSING']; $messages = []; if (!extension_loaded('curl')) { $messages[] = sprintf($not_installed, 'curl'); } if (!extension_loaded('mbstring')) { $messages[] = sprintf($not_installed, 'mbstring'); } if (!extension_loaded('zip')) { $messages[] = sprintf($not_installed, 'zip'); } if (!extension_loaded('exif')) { $messages[] = sprintf($not_installed, 'exif'); } if (version_compare(PHP_VERSION, '7.1.99', '>') && !extension_loaded('sodium')) { $messages[] = sprintf($not_installed, 'sodium'); } if (count($messages)) { $sysinfo .= '<br /><br />' . implode('<br />', $messages); } if (count($find_ary)) { $sysinfo .= '<br /><br />' . sprintf($user->lang['PHP_FN_DISABLED'], implode(', ', $find_ary)); } $badmsg = ''; if (!$this->writable) { if ($opsys == 'Windows') { $badmsg = $user->lang['FS_BAD_WINDOWS']; } else if ($cgi) { $badmsg = $user->lang['FS_BAD_CGI']; } else if (!extension_loaded('zlib')) { $badmsg = sprintf($not_installed, 'zlib'); } else if (!extension_loaded('ftp')) { $badmsg = sprintf($not_installed, 'ftp'); } else { $badmsg = $user->lang['FS_BAD_CREDS']; } $badmsg = "<strong>$badmsg</strong>{$user->lang['FS_INCOMPATIBLE']}"; } $founders = []; if ($user->data['user_type'] == USER_FOUNDER) { $result = $db->sql_query('SELECT username FROM ' . USERS_TABLE . ' WHERE user_type = ' . USER_FOUNDER); while ($row = $db->sql_fetchrow($result)) { $founders[] = $row['username']; } $db->sql_freeresult($result); } $template->assign_vars([ 'BBCORE_NOT_WRITABLE' => $badmsg, 'BBCORE_SYSTEM_INFO' => $sysinfo . $ownermsg, 'BBC_FOUNDERS' => count($founders) ? implode(', ', $founders) : '', 'BBCORE_DASH_ADDONS' => \sitesplat\apply_filters('bbcore_dash_display', ''), ]); } else { return ($userowner && !$baduserowner) ? $userowner : ''; } } protected function check_dat($dis, $fn_ary) { $find_ary = []; foreach ($dis as $dat) { if (in_array($dat, $fn_ary)) { $find_ary[] = $dat; } } return $find_ary; } protected function get_data($what = '') { global $cache, $phpbb_container; $file_downloader = $phpbb_container->get('file_downloader'); $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $cache->get($cache_file)) === false) { try { $info = $file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $cache->put($cache_file, $info, 86400); } } return $info; } public function autoupdate($action) { global $config, $request, $user, $cache, $auth, $db, $phpbb_container; $config_text = $phpbb_container->get('config_text'); if ($action === 'autoupdate_confirm') { $config_text->set('sitesplat_bbcore_updater', ''); confirm_b
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/admin_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/admin_listener.php"
++index 344675424..69010cf37 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/admin_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/admin_listener.php"
++@@ -1,114 +1,14 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2020 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2020 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ 
++ namespace sitesplat\BBCore\event;
++ 
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ use Symfony\Component\Finder\Finder;
++-
++-class admin_listener implements EventSubscriberInterface
++-{
++-	protected $db;
++-	protected $user;
++-	protected $template;
++-	protected $phpbb_extension_manager;
++-	protected $cache;
++-	protected $file_downloader;
++-	protected $request;
++-	protected $config;
++-	protected $config_text;
++-	protected $auth;
++-	protected $fs;
++-	protected $next_step_resolver;
++-	protected $text_formatter_cache;
++-	protected $phpbb_root_path;
++-	protected $php_ext;
++-	protected $host;
++-	protected $path;
++-	protected $writable = true;
++-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path)
++-	{
++-		$this->db = $db;
++-		$this->user = $user;
++-		$this->template = $template;
++-		$this->extension_manager = $phpbb_extension_manager;
++-		$this->cache = $cache;
++-		$this->file_downloader = $file_downloader;
++-		$this->request = $request;
++-		$this->config = $config;
++-		$this->config_text = $config_text;
++-		$this->auth = $auth;
++-		$this->fs = \sitesplat\fs_instance();
++-		$this->next_step_resolver = $next_step_resolver;
++-		$this->text_formatter_cache = $text_formatter_cache;
++-		$this->root_path = $phpbb_root_path;
++-		$this->php_ext = $php_ext;
++-		$this->host = $host;
++-		$this->path = $path;
++-	}
++-	static public function getSubscribedEvents()
++-	{
++-		$events = ['core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action',];
++-		return $events;
++-	}
++-	public function version_check($event, $eventName)
++-	{
++-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
++-		$result = $this->db->sql_query($sql);
++-		while ($row = $this->db->sql_fetchrow($result)) {
++-			$cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg');
++-			$data = $this->get_data($row['style_name']);
++-			if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'], '<')) {
++-				$this->template->assign_block_vars('sitesplat_themes', array('NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'],));
++-			}
++-		}
++-	}
++-	protected function get_data($what = '')
++-	{
++-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
++-		if (($info = $this->cache->get($cache_file)) === false) {
++-			try {
++-				$info = $this->file_downloader->get($this->host, $this->path, $what, 443);
++-			} catch (\phpbb\exception\runtime_exception $exception) {
++-				$info = '';
++-			}
++-			$info = json_decode($info, true);
++-			if (!empty($info)) {
++-				$json_sanitizer = function (&$value, $key) {
++-					$type_cast_helper = new \phpbb\request\type_cast_helper();
++-					$type_cast_helper->set_var($value, $value, gettype($value), true);
++-				};
++-				array_walk_recursive($info, $json_sanitizer);
++-				$this->cache->put($cache_file, $info, 86400);
++-			}
++-		}
++-		return $info;
++-	}
++-	public function run_action($event)
++-	{
++-		global $phpbb_dispatcher;
++-		$this->template->assign_vars(array('DISABLE_ALL' => $event['u_action'] . '&action=disable-all',));
++-		if ($event['action'] == 'disable-all') {
++-			$safe_time_limit = (ini_get('max_execution_time') / 2);
++-			$start_time = time();
++-			$enabled_extensions = $this->extension_manager->all_enabled();
++-			unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']);
++-			extract($phpbb_dispatcher->trigger_event('sitesplat.bbcore_ext_list', compact('enabled_extensions')));
++-			foreach ($enabled_extensions as $ext_name => $value) {
++-				while ($this->extension_manager->disable_step($ext_name)) {
++-					if ((time() - $start_time) >= $safe_time_limit) {
++-						meta_refresh(0, $event['u_action'] . '&amp;action=disable-all');
++-					}
++-				}
++-			}
++-			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($event['u_action']));
++-		}
++-	}
++-}
+++class admin_listener implements EventSubscriberInterface { protected $db; protected $user; protected $template; protected $phpbb_extension_manager; protected $cache; protected $file_downloader; protected $request; protected $config; protected $config_text; protected $auth; protected $fs; protected $next_step_resolver; protected $text_formatter_cache; protected $phpbb_root_path; protected $php_ext; protected $host; protected $path; protected $writable = true; public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path) { $this->db = $db; $this->user = $user; $this->template = $template; $this->extension_manager = $phpbb_extension_manager; $this->cache = $cache; $this->file_downloader = $file_downloader; $this->request = $request; $this->config = $config; $this->config_text = $config_text; $this->auth = $auth; $this->fs = \sitesplat\fs_instance(); $this->next_step_resolver = $next_step_resolver; $this->text_formatter_cache = $text_formatter_cache; $this->root_path = $phpbb_root_path; $this->php_ext = $php_ext; $this->host = $host; $this->path = $path; } static public function getSubscribedEvents() { $events = [ 'core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action', ]; return $events; } public function version_check($event, $eventName) { $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $this->db->sql_query($sql); while ($row = $this->db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'] , '<')) { $this->template->assign_block_vars('sitesplat_themes', array( 'NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'], )); } } } protected function get_data($what = '') { $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $this->cache->get($cache_file)) === false) { try { $info = $this->file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $this->cache->put($cache_file, $info, 86400); } } return $info; } public function run_action($event) { $this->template->assign_vars(array( 'DISABLE_ALL' => $event['u_action'] . '&action=disable-all', )); if ($event['action'] == 'disable-all') { $safe_time_limit = (ini_get('max_execution_time') / 2); $start_time = time(); $enabled_extensions = $this->extension_manager->all_enabled(); unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']); foreach ($enabled_extensions as $ext_name => $value) { while ($this->extension_manager->disable_step($ext_name)) { if ((time() - $start_time) >= $safe_time_limit) { meta_refresh(0, $this->u_action . '&amp;action=disable-all'); } } } } } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/listener.php"
++index 714ef8e74..bb9d66904 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/event/listener.php"
++@@ -1,12 +1,11 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2020 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2020 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ 
++ namespace sitesplat\BBCore\event;
++ 
++@@ -14,187 +13,4 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ use Symfony\Component\HttpFoundation\Response;
++ use Symfony\Component\DependencyInjection\Container;
++ use phpbb\path_helper;
++-
++-class listener implements EventSubscriberInterface
++-{
++-	protected $cache;
++-	protected $config;
++-	protected $db;
++-	protected $user;
++-	protected $auth;
++-	protected $helper;
++-	protected $template;
++-	protected $phpbb_container;
++-	protected $phpbb_root_path;
++-	protected $php_ext;
++-	protected $fs;
++-	public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext, path_helper $path_helper)
++-	{
++-		$this->cache = $cache;
++-		$this->config = $config;
++-		$this->db = $db;
++-		$this->user = $user;
++-		$this->auth = $auth;
++-		$this->helper = $helper;
++-		$this->template = $template;
++-		$this->phpbb_container = $phpbb_container;
++-		$this->root_path = $phpbb_root_path;
++-		$this->path_helper = $path_helper;
++-		$this->php_ext = $php_ext;
++-		if (!defined('PHPBB_USE_BOARD_URL_PATH')) {
++-			define('PHPBB_USE_BOARD_URL_PATH', true);
++-		}
++-		require(dirname(__DIR__) . '/sitesplat.php');
++-		require(dirname(__DIR__) . '/filesystem.php');
++-		$this->fs = \sitesplat\fs_instance();
++-	}
++-	static public function getSubscribedEvents()
++-	{
++-		$listeners = array('core.common' => ['load_addon_data', 999], 'core.user_setup' => 'load_language_on_setup', 'core.page_header_after' => 'add_template_variables', 'core.page_footer_after' => 'disabled_board', 'core.index_modify_page_title' => 'statistics', 'core.ucp_display_module_before' => 'rewrite_zebra', 'core.viewtopic_assign_template_vars_before' => 'add_viewtopic_template_variables', 'core.memberlist_memberrow_before' => 'toggle_use_contact_fields', 'core.gen_sort_selects_after' => 'enhance_sort_selects', 'core.ucp_prefs_view_after' => 'enhance_ucp_prefs_selects', 'core.adm_page_header' => 'maybe_fix_ext',);
++-		if (version_compare(PHPBB_VERSION, '3.2.8', '>')) {
++-			$listeners += array('core.posting_modify_submission_errors' => 'revert_emojis',);
++-		}
++-		return $listeners;
++-	}
++-	public function revert_emojis($event)
++-	{
++-		if ($this->config['sitesplat_bbcore_emoji_revert']) {
++-			$post_data = $event['post_data'];
++-			$error = $event['error'];
++-			$post_data['post_subject'] = utf8_decode_ncr($post_data['post_subject']);
++-			if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $post_data['post_subject'], $matches)) {
++-				$character_list = implode('<br />', $matches[0]);
++-				$error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_SUBJECT', $character_list);
++-				$event['post_data'] = $post_data;
++-				$event['error'] = $error;
++-			}
++-		}
++-	}
++-	public function load_addon_data()
++-	{
++-		static $called;
++-		if (empty($called)) {
++-			if (($ss_addons = $this->cache->get('_sitesplat_addons')) === false) {
++-				$sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'sitesplat_addons'";
++-				$result = $this->db->sql_query($sql);
++-				$row = $this->db->sql_fetchrow($result);
++-				$this->db->sql_freeresult($result);
++-				if ($row) {
++-					$ss_addons = $row['config_value'];
++-					$this->cache->put('_sitesplat_addons', $ss_addons);
++-					unset($row);
++-				}
++-			}
++-			if (!empty($ss_addons)) {
++-				\sitesplat\addon::$addons = json_decode($ss_addons, true);
++-				unset($ss_addons);
++-			}
++-			\sitesplat\load_ext_addons('bbcore');
++-			$called = true;
++-		}
++-	}
++-	public function load_language_on_setup($event)
++-	{
++-		static $called;
++-		if (empty($called)) {
++-			$lang_set_ext = $event['lang_set_ext'];
++-			$lang_set_ext[] = array('ext_name' => 'sitesplat/BBCore', 'lang_set' => 'BBCore',);
++-			$event['lang_set_ext'] = $lang_set_ext;
++-			$called = true;
++-		}
++-	}
++-	public function maybe_fix_ext($event)
++-	{
++-		if (empty($this->config['bbcore_ext_fix'])) {
++-			$extfile = "{$this->fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
++-			$this->fs->init();
++-			if ($this->fs->fs_type && file_exists($extfile)) {
++-				$this->fs->put($extfile, str_replace('data-ajax', 'xdata-xajax', file_get_contents($extfile)));
++-				$this->config->set('bbcore_ext_fix', 'dd_fs');
++-			}
++-		}
++-	}
++-	public function disabled_board($event)
++-	{
++-		$style_id = ((!$this->config['override_user_style']) ? (int) $this->user->data['user_style'] : (int) $this->config['default_style']);
++-		$style_ary = [];
++-		$sql = 'SELECT style_id, style_path FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
++-		$result = $this->db->sql_query($sql);
++-		while ($row = $this->db->sql_fetchrow($result)) {
++-			$style_ary[intval($row['style_id'])] = $row['style_path'];
++-		}
++-		if ($this->config['board_disable'] && !defined('IN_LOGIN') && !empty($style_ary[$style_id]) && !$this->auth->acl_get('a_')) {
++-			$web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path();
++-			$user_lang = $this->user->lang['USER_LANG'];
++-			if (strpos($user_lang, '-x-') !== false) {
++-				$user_lang = substr($user_lang, 0, strpos($user_lang, '-x-'));
++-			}
++-			$file = $this->root_path . 'ext/sitesplat/BBCore/styles/' . $style_ary[$style_id] . '/template/offline_board_body.html';
++-			$fp = fopen($file, 'r');
++-			$content = fread($fp, filesize($file));
++-			fclose($fp);
++-			$match = array('#\{S_CONTENT_DIRECTION\}#', '#\{BODY_CLASS\}#', '#\{S_USER_LANG\}#', '#\{S_CONTENT_ENCODING\}#', '#\{SITENAME\}#', '#\{PAGE_TITLE\}#', '#\{T_STYLESHEET_LINK\}#', '#\{T_STYLESHEET_OFFLINE\}#', '#\{T_STYLESHEET_ANIMATE\}#', '#\{T_THEME_PATH\}#', '#\{SCRIPT_NAME\}#', '#\{L_BOARD_DISABLED\}#', '#\{ACP_DISABLE_MESSAGE\}#', '#\{L_LOGIN_LOGOUT\}#', '#\{U_LOGIN_LOGOUT\}#');
++-			$replace = array($this->user->lang['DIRECTION'], '', $user_lang, 'UTF-8', $this->config['sitename'], $this->user->lang['WEBSITE'] . ' &#187; ' . $this->user->lang['OFFLINE'], "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'], "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/offline.css', "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/animate.css', "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme', str_replace('.' . $this->php_ext, '', $this->user->page['page_name']), $this->user->lang['BOARD_UNAVAILABLE'], $this->config['board_disable_msg'], $this->user->lang['LOGIN'], append_sid("{$this->phpbb_root_path}ucp.php", 'mode=login'));
++-			$content = preg_replace($match, $replace, $content);
++-			$response = new Response('Content', 200, array('content-type' => 'text/html'));
++-			$response->setContent($content);
++-			$response->send();
++-			garbage_collection();
++-			exit_handler();
++-		}
++-	}
++-	public function add_template_variables()
++-	{
++-		$this->template->assign_vars(array('USER_EMAIL_MENU' => $this->user->data['user_email'], 'BOARD_EMAIL' => $this->config['board_contact'], 'SITESPLAT_SEARCH_WEEK' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=7&amp;st=7'), 'SITESPLAT_SEARCH_LAST_DAY' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=1&amp;st=1'), 'U_UCP_PREFERENCE' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs'), 'U_UCP_PREFERENCE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs&amp;mode=personal'), 'U_UCP_PROFILE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=reg_details'), 'U_UCP_PROFILE_AVATAR' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=avatar'), 'U_UCP_ZEBRA_FRIENDS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=zebra&amp;mode=friends'), 'U_UCP_PM_INBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=inbox'), 'U_UCP_PM_OUTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=outbox'), 'U_UCP_PM_SENTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=sentbox'), 'PM_NEW_COUNT_BADGE' => $this->user->lang('PM_NEW_MSG_BUBBLE', (int) $this->user->data['user_new_privmsg']), 'PM_NEW_COUNT' => $this->user->lang('PM_NEW_MSG', (int) $this->user->data['user_new_privmsg']), 'PM_UNREAD_COUNT' => $this->user->lang('PM_UNREAD_MSG', (int) $this->user->data['user_unread_privmsg']),));
++-	}
++-	public function statistics($event)
++-	{
++-		$online_users = obtain_users_online(0, 'forum');
++-		$total_online_users = $online_users['total_online'];
++-		$this->template->assign_vars(array('SITESPLAT_RECORD_ONLINE' => ($this->config['record_online_users']) ? $this->config['record_online_users'] : '0', 'SITESPLAT_CURRENTLY_ONLINE' => (isset($total_online_users) && $total_online_users) ? $total_online_users : '0', 'SITESPLAT_TOTAL_POSTS' => ($this->config['num_posts']) ? $this->config['num_posts'] : '0', 'SITESPLAT_TOTAL_TOPICS' => ($this->config['num_topics']) ? $this->config['num_topics'] : '0', 'SITESPLAT_TOTAL_USERS' => ($this->config['num_users']) ? $this->config['num_users'] : '0', 'SITESPLAT_NEWEST_USER' => ($this->config['newest_user_id']) ? get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']) : '',));
++-	}
++-	public function rewrite_zebra($event)
++-	{
++-		$context = $this->phpbb_container->get('template_context');
++-		$tpldata = &$context->get_data_ref();
++-		if (isset($tpldata['friends_offline'])) {
++-			foreach ($tpldata['friends_offline'] as $index => &$postrow) {
++-				$user_id = $postrow['USER_ID'];
++-				$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
++-				$result = $this->db->sql_query($sql);
++-				$row = $this->db->sql_fetchrow($result);
++-				$postrow['AVATAR'] = phpbb_get_user_avatar($row);
++-			}
++-		}
++-		if (isset($tpldata['friends_online'])) {
++-			foreach ($tpldata['friends_online'] as $index => &$postrow) {
++-				$user_id = $postrow['USER_ID'];
++-				$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
++-				$result = $this->db->sql_query($sql);
++-				$row = $this->db->sql_fetchrow($result);
++-				$postrow['AVATAR'] = phpbb_get_user_avatar($row);
++-			}
++-		}
++-	}
++-	public function add_viewtopic_template_variables($event)
++-	{
++-		$this->template->assign_vars(array('BOOKMARK_CLASS' => ($this->user->data['is_registered'] && $this->config['allow_bookmarks'] && $event['topic_data']['bookmarked']) ? 'fa fa-star' : 'fa fa-star-o',));
++-	}
++-	public function toggle_use_contact_fields($event)
++-	{
++-		$event['use_contact_fields'] = true;
++-	}
++-	public function enhance_sort_selects($event)
++-	{
++-		$event['s_limit_days'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_limit_days']);
++-		$event['s_sort_key'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_key']);
++-		$event['s_sort_dir'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_dir']);
++-	}
++-	public function enhance_ucp_prefs_selects($event)
++-	{
++-		$_options = array('s_limit_topic_days', 's_sort_topic_key', 's_sort_topic_dir', 's_limit_post_days', 's_sort_post_key', 's_sort_post_dir');
++-		foreach ($_options as $sort_option) {
++-			$event[$sort_option] = str_replace('<select', '<select class="selectpicker" data-container="body"', $event[$sort_option]);
++-		}
++-	}
++-}
+++define('PHPBB_USE_BOARD_URL_PATH', true); class listener implements EventSubscriberInterface { protected $cache; protected $config; protected $db; protected $user; protected $auth; protected $helper; protected $template; protected $phpbb_container; protected $phpbb_root_path; protected $php_ext; protected $fs; public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext, path_helper $path_helper) { $this->cache = $cache; $this->config = $config; $this->db = $db; $this->user = $user; $this->auth = $auth; $this->helper = $helper; $this->template = $template; $this->phpbb_container = $phpbb_container; $this->root_path = $phpbb_root_path; $this->path_helper = $path_helper; $this->php_ext = $php_ext; require(dirname(__DIR__) . '/sitesplat.php'); require(dirname(__DIR__) . '/filesystem.php'); $this->fs = \sitesplat\fs_instance(); } static public function getSubscribedEvents() { $listeners = array( 'core.common' => ['load_addon_data', 999], 'core.user_setup' => 'load_language_on_setup', 'core.page_header_after' => 'add_template_variables', 'core.page_footer_after' => 'disabled_board', 'core.index_modify_page_title' => 'statistics', 'core.ucp_display_module_before' => 'rewrite_zebra', 'core.viewtopic_assign_template_vars_before' => 'add_viewtopic_template_variables', 'core.memberlist_memberrow_before' => 'toggle_use_contact_fields', 'core.gen_sort_selects_after' => 'enhance_sort_selects', 'core.ucp_prefs_view_after' => 'enhance_ucp_prefs_selects', 'core.adm_page_header' => 'maybe_fix_ext', ); if (version_compare(PHPBB_VERSION, '3.2.8', '>')) { $listeners += array( 'core.posting_modify_submission_errors' => 'revert_emojis', ); } return $listeners; } public function revert_emojis($event) { if ($this->config['sitesplat_bbcore_emoji_revert']) { $post_data = $event['post_data']; $error = $event['error']; $post_data['post_subject'] = utf8_decode_ncr($post_data['post_subject']); if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $post_data['post_subject'], $matches)) { $character_list = implode('<br />', $matches[0]); $error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_SUBJECT', $character_list); $event['post_data'] = $post_data; $event['error'] = $error; } } } public function load_addon_data() { static $called; if (empty($called)) { if (($ss_addons = $this->cache->get('_sitesplat_addons')) === false) { $sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'sitesplat_addons'"; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $this->db->sql_freeresult($result); if ($row) { $ss_addons = $row['config_value']; $this->cache->put('_sitesplat_addons', $ss_addons); unset($row); } } if (!empty($ss_addons)) { \sitesplat\addon::$addons = json_decode($ss_addons, true); unset($ss_addons); } \sitesplat\load_ext_addons('bbcore'); $called = true; } } public function load_language_on_setup($event) { static $called; if (empty($called)) { $lang_set_ext = $event['lang_set_ext']; $lang_set_ext[] = array( 'ext_name' => 'sitesplat/BBCore', 'lang_set' => 'BBCore', ); $event['lang_set_ext'] = $lang_set_ext; $called = true; } } public function maybe_fix_ext($event) { if (empty($this->config['bbcore_ext_fix'])) { $extfile = "{$this->fs->phpbb_root_dir}/adm/style/acp_ext_actions.html"; $this->fs->init(); if ($this->fs->fs_type && file_exists($extfile)) { $this->fs->put($extfile, str_replace('data-ajax', 'xdata-xajax', file_get_contents($extfile))); $this->config->set('bbcore_ext_fix', 'dd_fs'); } } } public function disabled_board($event) { $style_id = ((!$this->config['override_user_style']) ? (int) $this->user->data['user_style'] : (int) $this->config['default_style']); $style_ary = []; $sql = 'SELECT style_id, style_path FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $this->db->sql_query($sql); while ($row = $this->db->sql_fetchrow($result)) { $style_ary[intval($row['style_id'])] = $row['style_path']; } if ($this->config['board_disable'] && !defined('IN_LOGIN') && !empty($style_ary[$style_id]) && !$this->auth->acl_get('a_')) { $web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path(); $user_lang = $this->user->lang['USER_LANG']; if (strpos($user_lang, '-x-') !== false) { $user_lang = substr($user_lang, 0, strpos($user_lang, '-x-')); } $file = $this->root_path . 'ext/sitesplat/BBCore/styles/' . $style_ary[$style_id] . '/template/offline_board_body.html'; $fp = fopen( $file , 'r' ); $content = fread( $fp , filesize($file) ); fclose( $fp ); $match = array('#\{S_CONTENT_DIRECTION\}#', '#\{BODY_CLASS\}#', '#\{S_USER_LANG\}#', '#\{S_CONTENT_ENCODING\}#', '#\{SITENAME\}#', '#\{PAGE_TITLE\}#', '#\{T_STYLESHEET_LINK\}#', '#\{T_STYLESHEET_OFFLINE\}#', '#\{T_STYLESHEET_ANIMATE\}#', '#\{T_THEME_PATH\}#', '#\{SCRIPT_NAME\}#', '#\{L_BOARD_DISABLED\}#', '#\{ACP_DISABLE_MESSAGE\}#', '#\{L_LOGIN_LOGOUT\}#', '#\{U_LOGIN_LOGOUT\}#'); $replace = array( $this->user->lang['DIRECTION'], '', $user_lang, 'UTF-8', $this->config['sitename'], $this->user->lang['WEBSITE']. ' &#187; ' . $this->user->lang['OFFLINE'], "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'], "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/offline.css', "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/animate.css', "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme', str_replace('.' . $this->php_ext, '', $this->user->page['page_name']), $this->user->lang['BOARD_UNAVAILABLE'], $this->config['board_disable_msg'], $this->user->lang['LOGIN'], append_sid("{$this->phpbb_root_path}ucp.php", 'mode=login') ); $content = preg_replace($match, $replace, $content); $response = new Response( 'Content', 200, array('content-type' => 'text/html') ); $response->setContent($content); $response->send(); garbage_collection(); exit_handler(); } } public function add_template_variables() { $this->template->assign_vars(array( 'USER_EMAIL_MENU' => $this->user->data['user_email'], 'BOARD_EMAIL' => $this->config['board_contact'], 'SITESPLAT_SEARCH_WEEK' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=7&amp;st=7'), 'SITESPLAT_SEARCH_LAST_DAY' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=1&amp;st=1'), 'U_UCP_PREFERENCE' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs'), 'U_UCP_PREFERENCE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs&amp;mode=personal'), 'U_UCP_PROFILE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=reg_details'), 'U_UCP_PROFILE_AVATAR' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=avatar'), 'U_UCP_ZEBRA_FRIENDS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=zebra&amp;mode=friends'), 'U_UCP_PM_INBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=inbox'), 'U_UCP_PM_OUTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=outbox'), 'U_UCP_PM_SENTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=sentbox'), 'PM_NEW_COUNT_BADGE'=> $this->user->lang('PM_NEW_MSG_BUBBLE', (int) $this->user->data['user_new_privmsg']), 'PM_NEW_COUNT' => $this->user->lang('PM_NEW_MSG', (int) $this->user->data['user_new_privmsg']), 'PM_UNREAD_COUNT' => $this->user->lang('PM_UNREAD_MSG', (int) $this->user->data['user_unread_privmsg']), )); } public function statistics($event) { $online_users = obtain_users_online(0, 'forum'); $total_online_users = $online_users['total_online']; $this->template->assign_vars(array( 'SITESPLAT_RECORD_ONLINE' => ($this->config['record_online_users']) ? $this->config['record_online_users'] : '0', 'SITESPLAT_CURRENTLY_ONLINE' => (isset($total_online_users) && $total_online_users) ? $total_online_users : '0', 'SITESPLAT_TOTAL_POSTS' => ($this->config['num_posts']) ? $this->config['num_posts'] : '0', 'SITESPLAT_TOTAL_TOPICS' => ($this->config['num_topics']) ? $this->config['num_topics'] : '0', 'SITESPLAT_TOTAL_USERS' => ($this->config['num_users']) ? $this->config['num_users'] : '0', 'SITESPLAT_NEWEST_USER' => ($this->config['newest_user_id']) ? get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']) : '', )); } public function rewrite_zebra($event) { $context = $this->phpbb_container->get('template_context'); $tpldata = &$context->get_data_ref(); if (isset($tpldata['friends_offline'])) { foreach ($tpldata['friends_offline'] as $index => &$postrow) { $user_id = $postrow['USER_ID']; $sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $postrow['AVATAR'] = phpbb_get_user_avatar($row); } } if (isset($tpldata['friends_online'])) { foreach ($tpldata['friends_online'] as $index => &$postrow) { $user_id = $postrow['USER_ID']; $sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $postrow['AVATAR'] = phpbb_get_user_avatar($row); } } } public function add_viewtopic_template_variables($event) { $this->template->assign_vars(array( 'BOOKMARK_CLASS' => ($this->user->data['is_registered'] && $this->config['allow_bookmarks'] && $event['topic_data']['bookmarked']) ? 'fa fa-star' : 'fa fa-star-o', )); } public function toggle_use_contact_fields($event) { $event['use_contact_fields'] = true; } public function enhance_sort_selects($event) { $event['s_limit_days'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_limit_days']); $event['s_sort_key'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_key']); $event['s_sort_dir'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_dir']); } public function enhance_ucp_prefs_selects($event) { $_options = array('s_limit_topic_days', 's_sort_topic_key', 's_sort_topic_dir', 's_limit_post_days', 's_sort_post_key', 's_sort_post_dir'); foreach ($_options as $sort_option) { $event[$sort_option] = str_replace('<select', '<select class="selectpicker" data-container="body"' , $event[$sort_option]); } } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/ext.php"
++index d945ebca3..63ecff30d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/ext.php"
++@@ -1,106 +1,11 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2020 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2020 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ 
++ namespace sitesplat\BBCore;
++-
++-class ext extends \phpbb\extension\base
++-{
++-	public function enable_step($whocares)
++-	{
++-		$db = $this->container->get('dbal.conn');
++-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'";
++-		$result = $db->sql_query($sql);
++-		$parent_id = (int) $db->sql_fetchfield('module_id');
++-		$db->sql_freeresult($result);
++-		if ($parent_id) {
++-			return false;
++-		}
++-		$module = $this->container->get('module.manager');
++-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat',];
++-		$module->update_module_data($data);
++-		$ss_id = $data['module_id'];
++-		$sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC";
++-		$result = $db->sql_query($sql);
++-		$tabs = [];
++-		while ($row = $db->sql_fetchrow($result)) {
++-			$tabs[] = $row['module_langname'];
++-		}
++-		$db->sql_freeresult($result);
++-		for ($move = 0; $move < count($tabs); $move++) {
++-			if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') {
++-				break;
++-			}
++-			$move++;
++-		}
++-		$module->move_module_by($data, 'acp', 'move_up', $move);
++-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore',];
++-		$module->update_module_data($data);
++-		$bb_id = $data['module_id'];
++-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT',];
++-		$module->update_module_data($data);
++-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
++-		$module->update_module_data($data);
++-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
++-		$module->update_module_data($data);
++-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
++-		$module->update_module_data($data);
++-		while (parent::enable_step($whocares));
++-		return false;
++-	}
++-	public function disable_step($whocares)
++-	{
++-		$extensions = $this->container->get('ext.manager')->all_enabled();
++-		foreach ($extensions as $key => $value) {
++-			if (strpos($value, 'sitesplat') === false) {
++-				unset($extensions[$key]);
++-			}
++-		}
++-		unset($extensions['sitesplat/BBCore']);
++-		if (sizeof($extensions)) {
++-			$user = $this->container->get('user');
++-			trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING);
++-		}
++-		$config = $this->container->get('config');
++-		if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) {
++-			$fs = $this->container->get('sitesplat.filesystem');
++-			$extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
++-			$fs->init();
++-			if ($fs->fs_type && file_exists($extfile)) {
++-				$fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile)));
++-				$config->delete('bbcore_ext_fix');
++-			}
++-		}
++-		$ids = [];
++-		$db = $this->container->get('dbal.conn');
++-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC";
++-		$result = $db->sql_query($sql);
++-		while ($row = $db->sql_fetchrow($result)) {
++-			$ids[] = (int) $row['module_id'];
++-		}
++-		$db->sql_freeresult($result);
++-		if (!count($ids)) {
++-			return false;
++-		}
++-		$module = $this->container->get('module.manager');
++-		foreach ($ids as $module_id) {
++-			try {
++-				$module->delete_module($module_id, 'acp');
++-			} catch (\phpbb\module\exception\module_exception $exception) {
++-			}
++-		}
++-		return false;
++-	}
++-	public function purge_step($whocares)
++-	{
++-		$this->container->get('config')->delete('dd_fs');
++-		while (parent::purge_step($whocares));
++-		return false;
++-	}
++-}
+++class ext extends \phpbb\extension\base { public function enable_step($whocares) { $db = $this->container->get('dbal.conn'); $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'"; $result = $db->sql_query($sql); $parent_id = (int) $db->sql_fetchfield('module_id'); $db->sql_freeresult($result); if ($parent_id) { return false; } $module = $this->container->get('module.manager'); $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat', ]; $module->update_module_data($data); $ss_id = $data['module_id']; $sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC"; $result = $db->sql_query($sql); $tabs = []; while ($row = $db->sql_fetchrow($result)) { $tabs[] = $row['module_langname']; } $db->sql_freeresult($result); for ($move = 0; $move < count($tabs); $move++) { if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') { break; } $move++; } $module->move_module_by($data, 'acp', 'move_up', $move); $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore', ]; $module->update_module_data($data); $bb_id = $data['module_id']; $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); while (parent::enable_step($whocares)); return false; } public function disable_step($whocares) { $extensions = $this->container->get('ext.manager')->all_enabled(); foreach ($extensions as $key => $value) { if (strpos($value, 'sitesplat') === false) { unset($extensions[$key]); } } unset($extensions['sitesplat/BBCore']); if (sizeof($extensions)) { $user = $this->container->get('user'); trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING); } $config = $this->container->get('config'); if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) { $fs = $this->container->get('sitesplat.filesystem'); $extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html"; $fs->init(); if ($fs->fs_type && file_exists($extfile)) { $fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile))); $config->delete('bbcore_ext_fix'); } } $ids = []; $db = $this->container->get('dbal.conn'); $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $ids[] = (int) $row['module_id']; } $db->sql_freeresult($result); if (!count($ids)) { return false; } $module = $this->container->get('module.manager'); foreach ($ids as $module_id) { try { $module->delete_module($module_id, 'acp'); } catch (\phpbb\module\exception\module_exception $exception) { } } return false; } public function purge_step($whocares) { $this->container->get('config')->delete('dd_fs'); while (parent::purge_step($whocares)); return false; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/filesystem.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/filesystem.php"
++index b217b3d1b..5953f2b0d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/filesystem.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/filesystem.php"
++@@ -1,384 +1,8 @@
++ <?php
++-
++ /**
++  * SiteSplat Filesystem
++- * @copyright (c) 2023 Dion Designs. All rights reserved.
+++ * @copyright (c) 2020 Dion Designs. All rights reserved.
++  * @license Proprietary
++  */
++-
++ namespace sitesplat;
++-
++-function fs_instance()
++-{
++-	static $fs;
++-	if (empty($fs)) {
++-		$fs = new \sitesplat\filesystem;
++-	}
++-	return $fs;
++-}
++-class filesystem
++-{
++-	public $phpbb_root_dir;
++-	public $fs_type = false;
++-	public $direct = false;
++-	public $ftp_error = '';
++-	protected $config, $root_ptr, $conn, $fs_root_dir, $oldhandler;
++-	function __construct()
++-	{
++-		global $phpbb_container;
++-		$this->oldhandler = set_error_handler([$this, 'ss_msghandler']);
++-		$s = DIRECTORY_SEPARATOR;
++-		$ss = "{$s}ext{$s}sitesplat";
++-		$this->phpbb_root_dir = strstr(__DIR__, $ss, true);
++-		$this->config = $phpbb_container->get('config');
++-		$this->root_ptr = strlen($this->phpbb_root_dir) + 1;
++-		$filesystem = $phpbb_container->get('filesystem');
++-		if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) {
++-			$this->direct = true;
++-			$this->fs_type = 'direct';
++-		}
++-	}
++-	function __destruct()
++-	{
++-		if ($this->fs_type == 'ftp') {
++-			$this->fs_type = false;
++-			@ftp_quit($this->conn);
++-		}
++-	}
++-	function ss_msghandler($errno, $msg_text, $errfile, $errline)
++-	{
++-		if (!(error_reporting() & $errno) && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE) {
++-			return true;
++-		}
++-		return empty($this->oldhandler) ? false : call_user_func($this->oldhandler, $errno, $msg_text, $errfile, $errline);
++-	}
++-	function init()
++-	{
++-		static $already_called;
++-		if (!isset($already_called)) {
++-			$already_called = true;
++-			if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) {
++-				$this->fs_type = 'ftp';
++-			}
++-		}
++-		return $this->fs_type;
++-	}
++-	function connect()
++-	{
++-		if (empty($this->config['dd_fs'])) {
++-			$this->ftp_error = 'FTP_NO_CONFIG_DATA';
++-			return false;
++-		}
++-		$fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true);
++-		if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) {
++-			$this->ftp_error = 'FTP_BAD_CONFIG_DATA';
++-			return false;
++-		}
++-		$this->fs_root_dir = $fs_data[2];
++-		if ($fs_data[5]) {
++-			$this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
++-		} else {
++-			$this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
++-		}
++-		if (!$this->conn) {
++-			$this->ftp_error = 'FTP_CANNOT_CONNECT';
++-			return false;
++-		}
++-		if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) {
++-			@ftp_quit($this->conn);
++-			$this->ftp_error = 'FTP_BAD_USERPASS';
++-			return false;
++-		}
++-		@ftp_pasv($this->conn, true);
++-		if (!@ftp_chdir($this->conn, $this->fs_root_dir)) {
++-			@ftp_quit($this->conn);
++-			$this->ftp_error = 'FTP_BAD_ROOTDIR';
++-			return false;
++-		}
++-		return true;
++-	}
++-	function mkdir($dir, $perms = 0755)
++-	{
++-		if (!$dir || $dir == '/') {
++-			return false;
++-		}
++-		if (substr($dir, -1, 1) == '/') {
++-			$dir = substr($dir, 0, -1);
++-		}
++-		if (strpos($dir, '/') === false) {
++-			return false;
++-		}
++-		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
++-		$reldir = substr(strrchr($dir, '/'), 1);
++-		if (file_exists($dir)) {
++-			return true;
++-		}
++-		if ($this->fs_type != 'ftp') {
++-			return @mkdir($dir, $perms);
++-		}
++-		if (!file_exists($parent)) {
++-			return false;
++-		}
++-		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
++-		@ftp_chdir($this->conn, $parent);
++-		if ($result = @ftp_mkdir($this->conn, $reldir)) {
++-			@ftp_chmod($this->conn, $perms, $reldir);
++-		}
++-		@ftp_chdir($this->conn, $this->fs_root_dir);
++-		return $result;
++-	}
++-	function rmdir($dir)
++-	{
++-		if (!$dir || $dir == '/') {
++-			return false;
++-		}
++-		if (substr($dir, -1, 1) == '/') {
++-			$dir = substr($dir, 0, -1);
++-		}
++-		if (strpos($dir, '/') === false) {
++-			return false;
++-		}
++-		if (!file_exists($dir)) {
++-			return true;
++-		}
++-		if ($this->fs_type != 'ftp') {
++-			return @rmdir($dir);
++-		}
++-		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
++-		$reldir = substr(strrchr($dir, '/'), 1);
++-		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
++-		@ftp_chdir($this->conn, $parent);
++-		$result = @ftp_rmdir($this->conn, $reldir);
++-		@ftp_chdir($this->conn, $this->fs_root_dir);
++-		return $result;
++-	}
++-	function rename($old_handle, $new_handle)
++-	{
++-		if (!file_exists($old_handle) || file_exists($new_handle)) {
++-			return false;
++-		}
++-		if ($this->fs_type != 'ftp') {
++-			return @rename($old_handle, $new_handle);
++-		}
++-		if (@is_dir($old_handle)) {
++-			if (substr($old_handle, -1, 1) == '/') {
++-				$old_handle = substr($old_handle, 0, -1);
++-			}
++-			if (substr($new_handle, -1, 1) == '/') {
++-				$new_handle = substr($new_handle, 0, -1);
++-			}
++-		}
++-		$old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/');
++-		$old_handle = substr($old_handle, $this->root_ptr);
++-		$new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/');
++-		$new_handle = substr($new_handle, $this->root_ptr);
++-		return @ftp_rename($this->conn, $old_handle, $new_handle);
++-	}
++-	function chdir($dir = '')
++-	{
++-		if ($this->fs_type != 'ftp') {
++-			return @chdir($dir);
++-		}
++-		if (!$dir || $dir == '.') {
++-			return true;
++-		}
++-		if ($dir != '/') {
++-			if (substr($dir, -1, 1) == '/') {
++-				$dir = substr($dir, 0, -1);
++-			}
++-			$dir = substr(realpath($dir), $this->root_ptr);
++-		}
++-		return @ftp_chdir($this->conn, $dir);
++-	}
++-	function chmod($file, $perms, $override = false)
++-	{
++-		if (!file_exists($file)) {
++-			return false;
++-		}
++-		if ($override || $this->fs_type != 'ftp') {
++-			return @chmod($file, $perms);
++-		}
++-		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
++-		$file = substr(realpath($file), $this->root_ptr);
++-		return @ftp_chmod($this->conn, $perms, $file);
++-	}
++-	function copy($from_file, $to_file, $delete_first = false)
++-	{
++-		if (!$this->fs_type || !file_exists($from_file)) {
++-			return false;
++-		}
++-		if ($delete_first) {
++-			$this->delete($to_file);
++-			clearstatcache();
++-		}
++-		if ($this->fs_type != 'ftp') {
++-			return @copy($from_file, $to_file);
++-		}
++-		$to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/');
++-		$to_file = substr($to_file, $this->root_ptr);
++-		$result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY);
++-		return $result;
++-	}
++-	function put($file, $string, $delete_first = false)
++-	{
++-		if (!$this->fs_type) {
++-			return false;
++-		}
++-		if ($delete_first) {
++-			$this->delete($file);
++-			clearstatcache();
++-		}
++-		if ($this->fs_type != 'ftp') {
++-			return @file_put_contents($file, $string);
++-		}
++-		$fullfile = $file;
++-		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
++-		$file = substr($file, $this->root_ptr);
++-		$handle = fopen('php://memory', 'r+');
++-		if ($string) {
++-			fwrite($handle, $string);
++-			rewind($handle);
++-		}
++-		$result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY);
++-		fclose($handle);
++-		clearstatcache();
++-		if ($result) {
++-			$result = @filesize(realpath($fullfile));
++-		} else if (!$string) {
++-			return 0;
++-		}
++-		return $result;
++-	}
++-	function delete($file)
++-	{
++-		if ($this->fs_type != 'ftp') {
++-			return @unlink($file);
++-		}
++-		$file = substr(realpath($file), $this->root_ptr);
++-		return @ftp_delete($this->conn, $file);
++-	}
++-	function cwd()
++-	{
++-		if ($this->fs_type != 'ftp') {
++-			return getcwd();
++-		}
++-		return @ftp_pwd($this->conn);
++-	}
++-	function rmrf($target, $delete_top_dir = true)
++-	{
++-		if (is_dir($target)) {
++-			$files = glob($target . DIRECTORY_SEPARATOR . "*");
++-			if (!empty($files)) {
++-				foreach ($files as $file) {
++-					$this->rmrf($file);
++-				}
++-			}
++-			if ($delete_top_dir) {
++-				$this->rmdir($target);
++-			}
++-		} else {
++-			$this->delete($target);
++-		}
++-	}
++-	function zip_extract($archive, $destdir)
++-	{
++-		global $user;
++-		if (!is_dir($destdir)) {
++-			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir);
++-			return false;
++-		}
++-		if (!defined('IN_ADMIN') || !$this->fs_type) {
++-			$this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE'];
++-			return false;
++-		}
++-		$fp = @fopen($archive, 'rb');
++-		if (!$fp) {
++-			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive);
++-			return false;
++-		}
++-		$dd_try = $topdir = false;
++-		rewind($fp);
++-		while (!feof($fp)) {
++-			$signature = fread($fp, 4);
++-			if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") {
++-				break;
++-			} else if ($signature == 'PK00') {
++-				continue;
++-			} else if ($signature == "\x50\x4b\x03\x04") {
++-				$data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26));
++-				$file_name = fread($fp, $data['name_len']);
++-				if ($data['extra_field']) {
++-					fread($fp, $data['extra_field']);
++-				}
++-				$target_filename = "{$destdir}/{$file_name}";
++-				if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) {
++-					$dirpath = $destdir;
++-					$folders = explode('/', $file_name);
++-					foreach ($folders as $folder) {
++-						$folder = trim($folder);
++-						if (empty($folder)) {
++-							continue;
++-						}
++-						$dirpath .= "/{$folder}";
++-						if (!is_dir($dirpath)) {
++-							if (!$this->mkdir($dirpath, 0777)) {
++-								$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
++-								return false;
++-							}
++-							$this->chmod($dirpath, 0755);
++-							if (!$topdir) {
++-								$topdir = $dirpath;
++-							}
++-						}
++-					}
++-					continue;
++-				} else if (strpos($file_name, '/')) {
++-					if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) {
++-						$dirpath = $destdir;
++-						$folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME));
++-						foreach ($folders as $folder) {
++-							$folder = trim($folder);
++-							if (empty($folder)) {
++-								continue;
++-							}
++-							$dirpath .= "/{$folder}";
++-							if (!is_dir($dirpath)) {
++-								if (!$this->mkdir($dirpath, 0777)) {
++-									$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
++-									return false;
++-								}
++-								$this->chmod($dirpath, 0755);
++-								if (!$topdir) {
++-									$topdir = $dirpath;
++-								}
++-							}
++-						}
++-					}
++-				}
++-				if (!$data['uc_size']) {
++-					$content = '';
++-				} else {
++-					$content = fread($fp, $data['c_size']);
++-				}
++-				if ($data['c_method'] == 0) {
++-					$this->put($target_filename, $content, true);
++-				} else if ($data['c_method'] == 8) {
++-					$this->put($target_filename, gzinflate($content, $data['uc_size']), true);
++-				} else {
++-					$this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD'];
++-					return false;
++-				}
++-			} else {
++-				if (!$dd_try) {
++-					$dd_try = true;
++-					fseek($fp, 8, SEEK_CUR);
++-					continue;
++-				}
++-				$this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER'];
++-				return false;
++-			}
++-			$dd_try = false;
++-		}
++-		return $topdir;
++-	}
++-}
+++function fs_instance() { static $fs; if (empty($fs)) { $fs = new \sitesplat\filesystem; } return $fs; } class filesystem { public $phpbb_root_dir; public $fs_type = false; public $direct = false; public $ftp_error = ''; protected $config, $root_ptr, $conn, $fs_root_dir; function __construct() { global $phpbb_container; $s = DIRECTORY_SEPARATOR; $ss = "{$s}ext{$s}sitesplat"; $this->phpbb_root_dir = strstr(__DIR__, $ss, true); $this->config = $phpbb_container->get('config'); $this->root_ptr = strlen($this->phpbb_root_dir) + 1; $filesystem = $phpbb_container->get('filesystem'); if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) { $this->direct = true; $this->fs_type = 'direct'; } } function __destruct() { if ($this->fs_type == 'ftp') { $this->fs_type = false; @ftp_quit($this->conn); } } function init() { static $already_called; if (!isset($already_called)) { $already_called = true; if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) { $this->fs_type = 'ftp'; } } return $this->fs_type; } function connect() { if (empty($this->config['dd_fs'])) { $this->ftp_error = 'FTP_NO_CONFIG_DATA'; return false; } $fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true); if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) { $this->ftp_error = 'FTP_BAD_CONFIG_DATA'; return false; } $this->fs_root_dir = $fs_data[2]; if ($fs_data[5]) { $this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60); } else { $this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60); } if (!$this->conn) { $this->ftp_error = 'FTP_CANNOT_CONNECT'; return false; } if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) { @ftp_quit($this->conn); $this->ftp_error = 'FTP_BAD_USERPASS'; return false; } @ftp_pasv($this->conn, true); if (!@ftp_chdir($this->conn, $this->fs_root_dir)) { @ftp_quit($this->conn); $this->ftp_error = 'FTP_BAD_ROOTDIR'; return false; } return true; } function mkdir($dir, $perms = 0755) { if (!$dir || $dir == '/') { return false; } if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } if (strpos($dir, '/') === false) { return false; } $parent = substr($dir, 0, strrpos($dir, '/') + 1); $reldir = substr(strrchr($dir, '/'), 1); if (file_exists($dir)) { return true; } if ($this->fs_type != 'ftp') { return @mkdir($dir, $perms); } if (!file_exists($parent)) { return false; } $parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1); @ftp_chdir($this->conn, $parent); if ($result = @ftp_mkdir($this->conn, $reldir)) { @ftp_chmod($this->conn, $perms, $reldir); } @ftp_chdir($this->conn, $this->fs_root_dir); return $result; } function rmdir($dir) { if (!$dir || $dir == '/') { return false; } if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } if (strpos($dir, '/') === false) { return false; } if (!file_exists($dir)) { return true; } if ($this->fs_type != 'ftp') { return @rmdir($dir); } $parent = substr($dir, 0, strrpos($dir, '/') + 1); $reldir = substr(strrchr($dir, '/'), 1); $parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1); @ftp_chdir($this->conn, $parent); $result = @ftp_rmdir($this->conn, $reldir); @ftp_chdir($this->conn, $this->fs_root_dir); return $result; } function rename($old_handle, $new_handle) { if (!file_exists($old_handle) || file_exists($new_handle)) { return false; } if ($this->fs_type != 'ftp') { return @rename($old_handle, $new_handle); } if (@is_dir($old_handle)) { if (substr($old_handle, -1, 1) == '/') { $old_handle = substr($old_handle, 0, -1); } if (substr($new_handle, -1, 1) == '/') { $new_handle = substr($new_handle, 0, -1); } } $old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/'); $old_handle = substr($old_handle, $this->root_ptr); $new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/'); $new_handle = substr($new_handle, $this->root_ptr); return @ftp_rename($this->conn, $old_handle, $new_handle); } function chdir($dir = '') { if ($this->fs_type != 'ftp') { return @chdir($dir); } if (!$dir || $dir == '.') { return true; } if ($dir != '/') { if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } $dir = substr(realpath($dir), $this->root_ptr); } return @ftp_chdir($this->conn, $dir); } function chmod($file, $perms, $override = false) { if (!file_exists($file)) { return false; } if ($override || $this->fs_type != 'ftp') { return @chmod($file, $perms); } $file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/'); $file = substr(realpath($file), $this->root_ptr); return @ftp_chmod($this->conn, $perms, $file); } function copy($from_file, $to_file, $delete_first = false) { if (!$this->fs_type || !file_exists($from_file)) { return false; } if ($delete_first) { $this->delete($to_file); clearstatcache(); } if ($this->fs_type != 'ftp') { return @copy($from_file, $to_file); } $to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/'); $to_file = substr($to_file, $this->root_ptr); $result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY); return $result; } function put($file, $string, $delete_first = false) { if (!$this->fs_type) { return false; } if ($delete_first) { $this->delete($file); clearstatcache(); } if ($this->fs_type != 'ftp') { return @file_put_contents($file, $string); } $fullfile = $file; $file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/'); $file = substr($file, $this->root_ptr); $handle = fopen('php://memory', 'r+'); if ($string) { fwrite($handle, $string); rewind($handle); } $result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY); fclose($handle); clearstatcache(); if ($result) { $result = @filesize(realpath($fullfile)); } else if (!$string) { return 0; } return $result; } function delete($file) { if ($this->fs_type != 'ftp') { return @unlink($file); } $file = substr(realpath($file), $this->root_ptr); return @ftp_delete($this->conn, $file); } function cwd() { if ($this->fs_type != 'ftp') { return getcwd(); } return @ftp_pwd($this->conn); } function rmrf($target, $delete_top_dir = true) { if (is_dir($target)) { $files = glob($target . DIRECTORY_SEPARATOR . "*"); if (!empty($files)) { foreach($files as $file) { $this->rmrf($file); } } if ($delete_top_dir) { $this->rmdir($target); } } else { $this->delete($target); } } function zip_extract($archive, $destdir) { global $user; if (!is_dir($destdir)) { $this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir); return false; } if (!defined('IN_ADMIN') || !$this->fs_type) { $this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE']; return false; } $fp = @fopen($archive, 'rb'); if (!$fp) { $this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive); return false; } $dd_try = $topdir = false; rewind($fp); while (!feof($fp)) { $signature = fread($fp, 4); if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") { break; } else if ($signature == 'PK00') { continue; } else if ($signature == "\x50\x4b\x03\x04") { $data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26)); $file_name = fread($fp, $data['name_len']); if ($data['extra_field']) { fread($fp, $data['extra_field']); } $target_filename = "{$destdir}/{$file_name}"; if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) { $dirpath = $destdir; $folders = explode('/', $file_name); foreach ($folders as $folder) { $folder = trim($folder); if (empty($folder)) { continue; } $dirpath .= "/{$folder}"; if (!is_dir($dirpath)) { if (!$this->mkdir($dirpath, 0777)) { $this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath); return false; } $this->chmod($dirpath, 0755); if (!$topdir) { $topdir = $dirpath; } } } continue; } else if (strpos($file_name, '/')) { if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) { $dirpath = $destdir; $folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME)); foreach ($folders as $folder) { $folder = trim($folder); if (empty($folder)) { continue; } $dirpath .= "/{$folder}"; if (!is_dir($dirpath)) { if (!$this->mkdir($dirpath, 0777)) { $this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath); return false; } $this->chmod($dirpath, 0755); if (!$topdir) { $topdir = $dirpath; } } } } } if (!$data['uc_size']) { $content = ''; } else { $content = fread($fp, $data['c_size']); } if ($data['c_method'] == 0) { $this->put($target_filename, $content, true); } else if ($data['c_method'] == 8) { $this->put($target_filename, gzinflate($content, $data['uc_size']), true); } else { $this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD']; return false; } } else { if (!$dd_try) { $dd_try = true; fseek($fp, 8, SEEK_CUR); continue; } $this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER']; return false; } $dd_try = false; } return $topdir; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/BBCore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/BBCore.php"
++deleted file mode 100644
++index d2a8ac736..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/BBCore.php"
+++++ /dev/null
++@@ -1,484 +0,0 @@
++-<?php
++-/**
++-*
++-* BBCore [German]
++-*
++-* @package sitesplat BBcore
++-* @copyright (c) 2015 SiteSplat All rights reserved
++-* @license Proprietary
++-*
++-*/
++-
++-// TRANSLATORS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB')) {
++-	exit;
++-}
++-if (empty($lang) || !is_array($lang)) {
++-	$lang = array();
++-}
++-
++-// load addon lang files first...allow BBCore to overwrite if needed
++-if (function_exists('\sitesplat\load_ext_lang')) {
++-    $addon_lang = [];
++-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
++-    $lang = array_merge($lang, $addon_lang);
++-}
++-
++-
++-// BBCore
++-$lang = array_merge($lang, array(
++-	'PM_NEW_MSG' => [
++-  
++-  
++-    1 => 'Du hast %d neue private Nachricht',
++-    2 => 'Du hast %d neue private Nachrichten',
++-  ],
++-  'PM_UNREAD_MSG' => [
++-  
++-  
++-    1 => 'Du hast %d ungelesene private Nachricht',
++-    2 => 'Du hast %d ungelesene private Nachrichten',
++-  ],
++-  'PM_NEW_MSG_BUBBLE' => [
++-    1 => '%d',
++-    2 => '%d',
++-  ],
++-  
++-
++-	'SITESPLAT_EXT'				=> 'Other Extensions',
++-	'BBCORE_DASHBOARD'			=> 'Dashboard',
++-	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
++-	'BBCORE_SETTINGS'			=> 'Settings',
++-	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
++-	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
++-	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
++-	'SS_CHATBOX'				=> 'Chat',
++-	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
++-	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
++-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
++-
++-	'SS_ADDONS'				=> 'Addons',
++-	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
++-	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
++-  
++-  'UCP_MAIN'                   => 'Übersicht',
++-  'UCP_MAIN_FRONT'             => 'Startseite',
++-  'UCP_MAIN_SUBSCRIPTION'      => 'Abonnements verwalten',
++-  'UCP_MAIN_BOOKMARKS'         => 'Lesezeichen verwalten',
++-  'UCP_MAIN_DRAFTS'            => 'Entwürfe verwalten',
++-  'UCP_MAIN_ATTACHMENTS'       => 'Anhänge verwalten',
++-  
++-  
++-  'USER_PANEL'                 => 'Verwaltungsbereich', 
++-  'UCP_PROFILE'                => 'Profil',   
++-  'UCP_PROFILE_PROFILE'        => 'Profil bearbeiten',   
++-  'UCP_PROFILE_SIGNITURE'      => 'Signatur bearbeiten',   
++-  'UCP_PROFILE_AVATAR'         => 'Avatar bearbeiten',   
++-  'UCP_PROFILE_SETTINGS'       => 'Kontoeinstellungen', 
++-  'UCP_AVATAR_SELECT_OPTIONS'    => 'Avatar Optionen', 
++-  'UCP_AVATAR_SELECT_UPLOAD'     => 'Avatar vom Computer hochladen',
++-  'UCP_SUBMIT_TO_UPLOAD'         => 'Hier unten bestätigen zum Hochladen',
++-  
++-  'UCP_PREFERENCE'             => 'Board Einstellungen',
++-  'UCP_PREFERENCE_SETTINGS'    => 'Globale Einstellungen bearbeiten',
++-  'UCP_PREFERENCE_DEFAULTS'    => 'Standard Beiträge bearbeiten',
++-  'UCP_PREFERENCE_OPTIONS'     => 'Anzeigeoptionen bearbeiten',
++-  
++-  'UCP_MESSAGES'               => 'Nachrichten',   
++-  'UCP_PM_COMPOSE'             => 'Nachricht erstellen',   
++-  
++-  'UCP_PM_DRAFTS'              => 'Entwürfe verwalten',   
++-  'UCP_PM_INBOX'               => 'Posteingang',   
++-  'UCP_PM_OUTBOX'              => 'Postausgang',   
++-  'UCP_PM_SENTBOX'             => 'Senden',   
++-  'UCP_PM_OPTIONS'             => 'Regeln, Ordner &amp; Einstellungen', 
++-  'UCP_NO_USER_CHANGE_ALLOWED'   => '**Wechsel des Nutzernamens ist nicht erlaubt**',
++-  'UCP_REGISTER_EMAIL_EXPLAIN'   => 'Bitte verwenden Sie keine Wegwerf-E-Mails',
++-  
++-  'WIDTH_SIZE'                 => 'Breite',   
++-  'PIXEL_SIZE'                 => 'px',   
++-  'HEIGHT_SIZE'                => 'Höhe', 
++-  
++-  
++-  'UCP_GROUPS'                 => 'Nutzergruppen',   
++-  'UCP_GROUPS_MEMBERSHIP'      => 'Mitgliedschaft bearbeiten',   
++-  'UCP_GROUPS_MANAGE'          => 'Manage groups',   
++-  
++-  
++-  'UCP_ZEBRA'                  => 'Freunde und ignorierte Mitglieder',   
++-  'UCP_ZEBRA_FRIENDS'          => 'Freunde bearbeiten',   
++-  
++-  
++-  'UCP_ZEBRA_FOES'             => 'Ignorierte Mitglieder bearbeiten', 
++-  'UCP_APPLY'                    => 'Anwenden', 
++-  'UCP_PM_DEFAULT_RULE_TAG'      => 'Standardaktion',
++-  'UCP_PM_DEFAULT_RULE'          => 'Akzeptiere keine neuen Nachrichten',
++-  
++-  'UCP_PM_DEFAULT_RULE_EXPLAIN'  => 'Diese Aktion wird nur dann ausgeführt, wenn keine der oben genannten Optionen anwendbar ist. Neue Nachrichten werden so lange zurückgehalten, bis genügend Speicherplatz vorhanden ist.',
++-  'UCP_PM_NEW_MESSAGE'           => 'Neue Nachricht',
++-  
++-  
++-  
++-  'BIO'                          => 'Persönliche Informationen Biographie',
++-  'MANAGE'                       => 'VERWALTEN',
++-  'JOINED_BOARD'                 => 'Im Forum beigetreten',
++-  'VISITED_BOARD'                => 'Letzter Besuch',
++-  'SEE_MORE'                     => 'Mehr',
++-  'ATTACH_SIGNATURE'             => 'Signatur anhängen',
++-  'BBCODES'                      => 'BBcodes',
++-
++-  'DELETE_POST_SOFT'             => 'Soft Delete post',
++-  'DELETE_POST_PERMANENT'        => 'Perma Delete post',
++-  'DELETE_POST_SOFT_WARN'        => 'It can be recovered',
++-  'DELETE_POST_PERMANENT_WARN'   => 'It can NOT be recovered',
++-  
++-  
++-  'POLL_MAX_OPTIONS_EXPLAIN_ALT' => 'Gib die maximale Anzahl an Möglichkeiten an, die ein Nutzer erhält',
++-  'POLL_VOTE_CHANGE_LABEL'       => 'Wiederwahl erlauben',
++-  'NO_VOTES_NA'                  => 'N/A',
++-  'NOT_AVAILABLE'                => 'Nicht verfügbar',
++-  'POST_TOPIC_NEW'               => 'Neues Thema',
++-  'QUICK_REPLY_SHOW_HIDE'        => 'Anzeigen/Verstecken der Schnellanwort',
++-  'CHARACTERS_COUNT'             => 'Buchstaben',
++-  'CHARACTERS_COUNT_REM'         => 'übrig',
++-  'BOOKMARKED_TOPICS_UCP'        => 'Gespeicherte Themen',
++-  'ATTACH_EXPLANATION_SORTABLE'  => 'Klicken zum Sortieren',
++-  
++-  'ATTACH_FORUM'                 => 'Anhänge',
++-  'MCP_DETAILS_LOG'              => 'Details',
++-  'MCP_DETAIL_U_IP'              => 'Nutzer &amp; IP',
++-  'MCP_MANAG_BAN'                => 'Bann-Verwalltung',
++-  'MCP_UNAPPROVED_POSTS_ZERO'    => 'Keine Einträge die auf Freischaltung warten',
++-  
++-  'MCP_REPORTS_ZERO'             => 'Keine Berichte zum Kontrollieren',
++-  'MCP_PM_REPORTS_ZERO'          => 'Keine PM Berichte zum Kontrollieren',
++-  
++-  
++-  	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
++-  'FORUMLIST_UNAPPROVED'         => 'Mindestens ein Thema in diesem Forum wurde nicht genehmigt', 
++-  'FORUMLIST_UNAPPROVED_POST'    => 'Mindestens ein Beitrag in diesem Forum wurde nicht genemigt', 
++-  'FORUMLIST_LASTPOST'           => 'Letzten Beitrag anzeigen', 
++-  'TOPICS_POSTS_STATISTICS'      => 'Statistiken',
++-  'TOPICS_ROW_REPORTED'          => 'Dieses Thema wurde gemeldet',
++-  'TOPICS_ROW_NOT_APPROVED'      => 'Dieses Thema wurde nicht freigeschalten',
++-  'TOPICS_ROW_DELETED'           => 'Dieses Thema wurde gelöscht',
++-  'MODERATOR_PANEL_GENERAL'      => 'Moderationsbereich',
++-  'ADMIN_PANEL_GENERAL'          => 'Administrationsbereich',
++-  'RANK_IMAGE'                   => 'Rang Bild',
++-  
++-  'WELCOME_INDEX'                => 'Willkommen',
++-  'FAQ'                          => 'FAQ',
++-  'CAPTION_FAQ'                  => 'F.A.Q',
++-  'CAPTION_SEARCH'               => 'Starte eine Suche!',
++-  'CAPTION_MEMBERS'              => 'Suchst Du jemanden?',
++-  'MEMBERS_CAP'                  => 'Mitgleider',
++-  'CAPTION_UCP'                  => 'Einstellungen',
++-  
++-  
++-  'UCP_CAP'                      => 'Nutzerverwaltungsbereich',
++-  'INDEX_CAPTION'                => 'Dies ist die Forum-Startseite',
++-  'VIEWTOPIC_CAP'                => 'Thementitel',
++-  'CAPTION_VIEWTOPIC'            => 'Themenbeschreibung',
++-  'CAPTION_VIEWFORUM'            => 'Durchsuche alle Forenkategorien',
++-  
++-  'POSTINGS_CAP'                 => 'Beitragsbearbeitung',
++-  'CAPTION_POSTINGS'             => 'Starte einen Beitrag!',
++-  
++-  
++-  'MCP_CAPTION'                  => 'Hier bekommst Du beigebracht deine Superkraft zu nutzen ;-)',
++-  'BOOTSTRAP_ELEMENT'            => 'Bootstrap Elemente',
++-  'BOOTSTRAP_ELEMENT_CAPTION'    => 'Forum Anfänger-Dokumentation',
++-  'MAIN_FORUM'                   => 'Forum',
++-  'MAIN_MAIN_STUFF'              => 'Das wichtige Zeug',
++-  
++-  'MAIN_TRENDS'                  => 'Schaue Dir die Trends an',
++-  'MAIN_SEARCH_IT_UP'            => 'Suche starten',
++-  
++-  'SUB_NO_ICON'                  => 'Kein Bild vorhanden',
++-  'EXAMPLE_WITH_ICON'            => 'Beispiel mit Bild',
++-  'EXAMPLE_LINK'                 => 'Beispiel Link',
++-  'MAIN_SOCIAL'                  => 'Sozial',
++-  'SOCIAL_P'                     => 'Chat away ;-)',
++-  
++-  'MORE'          				   => 'Mehr',
++-  
++-  'EXPAND_CLOSE'          	 => 'Fenster schließen',
++-  'MARK_TOPICS_READ'         => 'Als gelesen markieren',
++-  
++-  'CONTACT'                  => 'Kontakt',
++-  'GET_IN_TOUCH'             => 'In Kontakt kommen',
++-  'HANG_AROUND'              => 'Rumhängen',
++-  'JOIN_THE_CLUB'            => 'Melde Dich an',
++-  
++-  'MENU'                     => 'MENÜ',
++-  'YOU_ARE_HERE'             => 'Du bist hier',
++-  'IN_FOOTER'                => 'In:',
++-  
++-  'REPLY'                    => 'Antwort',
++-
++-  'LOGIN_REMEMBER'             => 'Angemeldet bleiben',
++-  'LOGIN_HIDE_ME'              => 'Unsichtbar',
++-  'LOGIN_ME_IN'                => 'Anmelden',
++-  'SIGN_IN_ACCOUNT'            => 'Anmeldung',
++-  'CREATE_ACCOUNT'             => 'Konto erstellen',
++-  
++-  'GO_TO_SEARCH_ADV'           => 'Zurück zur erweiterten Suche',
++-  
++-  'CREATE_ACCOUNT_DISABLED'    => 'Anmeldungen nicht erlaubt',
++-  
++-  'REGISTRATION_DISABLED'      => 'Es sieht so aus, als wäre die Anmeldung zur Zeit geschlossen. Es kann sich aber auch um eine kurzfristige Abschaltung handeln. Wenn Du denkst, es könnte sich um einen Fehler handeln, kontaktiere bitte den Foren-Administrator. Wir entschuldigen uns für die verursachtenUmstände. In unsere Nutzungsbedingungen und Datenschutzrichtlinien kannst Du mit einem Klick auf die jeweiligen Links weiter unten, einsehen.',
++-  'CONTACT_WEBMASTER'          => 'Forenadministrator kontaktieren',
++-  
++-  'CONFIRM_QA_EXPLAIN_ALT'     => 'Beweise, dass Du ein Mensch bist und beantworte die Frage',
++-  'PLUPLOAD_PLACE_INLINE'        => 'Linear',
++-  'PLUPLOAD_DELETE_FILE'         => 'Löschen',
++-  
++-  
++-  'REG_CREATING'             => 'Profil erstellen...',
++-  'LOADING'                  => 'Läd...',
++-  'SAVING'                   => 'Speichert...',
++-  'CANCELLING'               => 'Abbrechen...',
++-  'SENDING'                  => 'Senden...',
++-  'SEARCHING'                => 'Suchen...',
++-  'LOADING_LOG_IN'           => 'Anmeldung...',
++-  'FILE_UPLOADING'           => 'Hochladen...',
++-  'CASTING_VOTE'             => 'Stimme wird eingetragen...',
++-  'LOADING_FORM'             => 'Lade Formular',
++-
++-  
++-  'MEMBERLIST_P_JOINED'          => 'ist dem Forum beigetreten',
++-  
++-  
++-  'MEMBERLIST_P_EXPL'            => 'Zu diesem Zeitpunkt habe ich mich registriert. ;)',
++-  'MEMBERLIST_P_DATE_EXPL'       => 'Dies war der Zeitpunkt als ich das letzte mal hier war.',
++-  'SPAMMER_PLACEHOLDER'          => 'Du kannst nicht einfach unser Board zuspammen und dann abhauen!',
++-  'MARK_PLACEHOLDER'             => 'Deine Wahl markieren',
++-  'INFO_BOX'                     => 'Information:',
++-  'USER_REMOVE_PLACEHOLDER'      => 'Klicken um Nutzer zu entfernen',
++-  'GROUP_REMOVE_PLACEHOLDER'     => 'Klicken um Gruppe zu entfernen',
++-  
++-  'EDIT_LINK_PLACEHOLDER'        => 'Ich habe vergessen meine Links richtig zu erstellen',
++-  'POST_IT_UP_PLACEHOLDER'       => 'Beitrag jetzt ersetellen!',
++-  
++-  'UCP_REG_USR_PLACEHOLDER'      => 'Bsp. John Doe',
++-  'UCP_REG_EMAIL_PLACEHOLDER'    => 'Bsp. john@mail.com',
++-  'UCP_REG_PSWD_PLACEHOLDER'     => 'Bsp. ASDFasdf123',
++-  'UCP_REG_CAPCTHA_PLACEHOLDER'  => 'Bsp. blauer Himmel',
++-  'SEARCH_USR_PLACEHOLDER'       => 'Bsp. SiteSplat',
++-   'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E.g. 2018-12-22',
++-	'IP_PLACEHOLDER'			=> 'E.g. 216.161.111.33',
++-	'POSTS_PLACEHOLDER'			=> 'E.g. 12',
++-	'SEARCH_KWDS_PLACEHOLDER'	=> 'E.g. cats, or cats+, or cats-, or cats|dogs, or cat*', 
++-	
++-	
++-	
++-	
++-	
++-	
++-	
++-	
++-	
++-	
++-  'MESSAGE_ENTER_PLACEHOLDER'    => 'Nachricht eintragen...',
++-  'FILE_COMMENT_PLACEHOLDER'     => 'Datei kommentieren',
++-  'HEIGTH_PLACEHOLDER'           => 'Höhe',
++-  'WIDTH_PLACEHOLDER'            => 'Weite',
++-  'UCP_OCCUPATION_PLACEHOLDER'   => 'Bescheibe was Du arbeitest...',
++-  'UCP_INTERESTS_PLACEHOLDER'    => 'Beschreibe Deine Interessen...',
++-  'SOFT_DELETE_PLACEHOLDER'      => 'Gib an, warum Du hier bis, wenn Du magst...',
++-  'ADD_DESCRIPTION'              => 'Beschreibung hinzufügen',
++-  
++-  'FILE_SELECT'                  => 'Datei auswählen',
++-  'FILE_CHANGE'                  => 'wechseln',
++-  
++-  
++-  
++-  'SELECT_IMAGE'                 => 'Bild auswählen',
++-  'NOTE'                         => 'merken',
++-  'EDIT_DRAFT'                   => 'Entwurf bearbeiten',
++-  'PM_BALOON_NOTIFICATION'       => 'Balonartige Ansicht für PM (Private Message) einstellen',
++-  
++-  'DAYS_AGO'                     => 'Tage zuvor',
++-  'WORK_IN_PROGRESS'             => 'Wartung',
++-  'DISABLE_MESSAGE'              => 'Forum ist nicht erreichbar',
++-  
++-  
++-  'DISABLE_RETURN'               => 'Zurück zur Startseite',
++-  'BOARD_DISABLED_SHUFFLE'       => 'Hab Spass und vergnüge Dich mit ein paar Buchstaben :-)',
++-  'DISABLE_TEXT_TRY'             => 'Probier es doch aus!',
++-  
++-  
++-  'DISABLE_TEXT_TYPE'            => 'tippe was ein und speichere es mit der Return-Taste...',
++- 
++-  'GRAVATAR_EXPLAIN'          	 => 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
++-  'GRAVATAR_EXPLAIN_CONFIRM'     => 'Please confirm your email address here',
++-  
++-  
++-  
++-  'DELETE_POLL'              => 'Umfrage löschen',
++-  'POLL_DELETE_HELPER'       => '(Dies löscht nur die Umfrage) markieren und absenden',
++-  'JUMP_TO_POST'             => 'springe zum Beitrag',
++-  'JUMP_SELECT_FORUM'            => 'Wähle Forum zum Wecheln aus',
++-  'JUMP_TO_PAGE_NUMBER'          => 'Springe zu Seite #',
++-  'VIEW_FIRST_UNREAD'        => 'Zeige ersten ungelesenen Beitrag',
++-  'BOOKMARK_TOPIC_REMOVE'        => 'Lesezeichen entfernen',
++-  
++-  'NEW_MESSAGES'             => 'Neue Nachrichten',
++-  'YOU_HAVE'                 => 'Du hast',
++-  
++-  
++-  'AND'                      => 'und',
++-  'HELLO'                    => 'Hallo',
++-  'DISMISS_PM'               => 'Defer 5 min',
++-  
++-  'READ_NOW'                 => 'Jetzt lesen',
++-  'PRIVATE_MESSAGE_NEW'	         => 'Neue private Nachricht',
++-  'PRIVATE_MESSAGE_UNREAD'	     => 'Ungelesene private Nachricht',
++-  
++-  'NO_PMS_INFO'	                 => 'Alle gelesen! Erstelle neue PM?',
++-  
++-  'DATES'                    => 'DATUM',
++-  
++-  
++-  
++-  'POWERED'                  => 'Gesponsort von',
++-  'HANDCRAFTED'              => 'in Handarbeit hergestellt mit',
++-  'BY'                       => 'von',
++-  'RECENT_TOPICS'            => 'Letzte Einträge',
++-  'TWITTER'                  => 'Twitter',
++-  'FAVORITES'                => 'Favoriten',
++-
++-  
++-  'GALLERY'                  => 'Gallerie',
++-  'CHAT'                     => 'Chat',
++-  
++-  
++-  
++-  
++-  
++-  'ABOUT'                    => 'Über uns',
++-  'ABOUT_PART_ONE'           => 'BBOOTS&#8482; Ist das erste und einzige voll responsive inoffizielle  PhpBB&reg; HTML5/CSS3 Design. Das saubere und knagige aussehen macht sich echt gut auf allen Browsern und sonstigen Anzeigen.',
++-  'ABOUT_PART_TWO'           => 'Es wartet mit einem Bootstrap basierten Grundgerüst auf, wurde lange Zeit hoffnungsvoll erwartet und wird sicherlich den phpBB Fan-Club total begeistern.',
++-  'ABOUT_PART_THREE'         => 'Das inoffizielle responsive Design',
++-  'BB'                       => 'B',
++-  'BOOTS'                    => 'BOOTS',
++-  'BBOOTS'                   => 'BBOOTS',
++-  
++-  'BBOOTS_VERSION'           => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
++-  'U_LOGOUT'                 => 'Abmelden',
++-
++-  'SITESPLAT_STATISTICS'     => 'Statistiken',
++-  'SITESPLAT_SEE_DETAILS'    => 'Siehe Details',
++-  'SITESPLAT_SEARCH_LAST_DAY'    => 'Einträge der letzten 24 Stunden',
++-  'SITESPLAT_SEARCH_WEEK'		 => 'Einträge der letzten 7 Tage',
++-  
++-  'SITESPLAT_TOTAL_POSTS'        => 'Beiträge insgesamt',
++-  'SITESPLAT_TOTAL_TOPICS'       => 'Themen insgesamt',
++-  'SITESPLAT_TOTAL_USERS'        => 'Mitglieder insgesamt',
++-  'SITESPLAT_NEWEST_MEMBER'      => 'Unser neuestes Mitglied',
++-  'SITESPLAT_USERS_ONLINE'       => 'Nutzer anwesend',
++-  'SITESPLAT_MOST_USERS_ONLINE'  => 'Höchstanzahl zeitgleicher Besucher',
++-  
++-  'BOOTSTRAP_VERSION'	         => '3.3.5',
++-  'FLATBOOTS'	                 => 'FLATBOOTS',
++-  'CHANGE_AVATAR'              => 'Avatar ändern',
++-  'CHANGE_PASSWORD'            => 'Passwort ändern',
++-  
++-  'ADMIN_TIPS'                 => 'Admin Tips &amp; Tricks',
++-  
++-  
++-  
++-  
++-  'ADMIN_TIP_INTRO'            => 'Wusstest Du, dass Du Dein phpBB-Forum mit ein paar einfachen Handgriffen noch sicherer machen kannst?',
++-  'ADMIN_TIP_ONE'              => 'Halte Deine Software immer auf dem aktuellsten Stand',
++-  'ADMIN_TIP_TWO'              => 'Verwende immer sichere Passwörter mit abwechselnde unterschiedlichen Buchstaben, Nummern und Sonderzeichen.',
++-  'ADMIN_TIP_THREE'            => 'Sperre den direkten Zugriff auf den Administrations-Ordner...',
++-  'ADMIN_CHECK_IT_BTN'         => 'Besuche SiteSplat.com für mehr Information',
++-  
++-  'USER_MINI_PROFILE'            => 'Minimales Nutzerprofil',
++-  'USER_MINI_PROFILE_VIEW_FULL'  => 'Zeige volles Profil',
++-  'OFF_LINE'                     => 'Off-line',
++-  'USER_STATUS'                  => 'Status',
++-  
++-  
++-  
++-  
++-  
++-  
++-  'USER'                         => 'Nutzer',
++-  'TITLE'                        => 'Titel',
++-  'END_TIMELINE'                 => 'Ende der Zeitlinie',
++-  'MEMBERS'                      => 'Mitglieder',
++-  'DRAFTS'                       => 'Entwürfe',
++-  'REPORTS'                      => 'Meldungen',
++-  'MODERATOR_LOGS'               => 'Moderator Anmeldungen',
++-  
++-  'QUEUE'                        => 'Warteschlange',
++-  'LINKS'                        => 'Links',
++-  'TOPIC_PERMISSIONS'            => 'Themenberechtigungen',
++-  'MODERATOR_OPTIONS'            => 'Moderationen',
++-  'PASSWORD_EXPLAIN_CONFIRM'     => 'Sei Dir sicher, dass es passt',
++-  'FORUM_REDIRECTS'              => 'Weiterleitungen:',
++-  
++-  'FANCY_TOPICS_TITLE'           => 'Letzte Themen dieses Forums',
++- 
++-
++-
++-
++-
++-
++-  
++-  'POST_BY'                      => 'Geschrieben von',
++-  'REPLY_BY'                     => 'Antwort von',
++-  'NO_REPLIES'                   => 'Keine Antworten',
++-  'READ_MORE'                    => 'Weiter lesen...',
++-  'RT_READ_MORE'                 => 'WEITER LESEN...',
++-  'VIEW_MORE_TOPICS'             => 'weitere neue Einträge anzeigen',
++-  'BACK_TO_START'                => 'ZURÜCK ZUM ANFANG',
++-  
++-  'TOGGLE_NAV'                   => 'Navigation verstecken',
++-  
++-  'DEMO_LINK'                  => 'Demonstraton, keine Bilder verlinkt',
++-  'DEMO_HEADER_MENU'           => 'Webseiteneinleitungsbeispiel',
++-  
++-  'FLATBOOTS_INTRO'              => 'Bootstrap Framework',
++-  
++-  
++-  'FLATBOOTS_EXPLAIN'            => 'Über ein Dutzend wiederverwendbare Erweiterungen vorhanden, z.B. Icons, Dropdown Listen, Navigation, Warnmeldungen und vieles mehr... ',
++-  'CALL_TO_ACTION_FOOTER'        => 'Ein-/Auschalten von Erweiterungen. Nutze nur was Du wirklich benötigst!',
++-  'PURCHASE_NOW_BTN'             => 'Jetzt kaufen',
++-  
++-  'FLATBOOTS_ABOUT_PART_ONE'     => 'Hier gibt es bald ein paar kurze Zeilen über das Board...',
++-  'FLATBOOTS_ABOUT_TITLE'        => 'Gebaut für die Ewigkeit',
++-  'DMCA'                         => 'DMCA',
++-  
++-  'TERMS'                        => 'Nutzungsbedingungen',
++-  'ADVERTISE'                    => 'Werbung',
++-  'SITESPLAT'                    => 'SiteSplat',
++-  'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
++-    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
++-    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
++-    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
++-  'JOIN_US_TWITTER'              => 'Triff uns auf Twitter',
++-  
++-  'TWEET_EXAMPLE'                => 'BBOOTS erreichte 500 verkäufe! Vielen Dank Euch allen für die Unterstützung zu diesem erstaunlichen Projekt und zum Aufbau der SiteSplat Gemeinschaft. Was kommt als nächstes? Bleib am Ball und folge mir auf Twitter: <a href="#">http://bit.ly/000fefs</a>',
++- 
++-));
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_acp_bbcore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_acp_bbcore.php"
++deleted file mode 100644
++index 6cb7131a6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_acp_bbcore.php"
+++++ /dev/null
++@@ -1,103 +0,0 @@
++-<?php
++-/**
++-*
++-* common [English]
++-*
++-* @package language
++-* @package sitesplat BBcore
++-* @version $Id$
++-* @copyright (c) 2015 SiteSplat All rights reserved
++-* @license Proprietary
++-*
++-*/
++-
++-// TRANSLATORS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
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
++-	$lang = array();
++-}
++-
++-$lang = array_merge($lang, array(
++-	'SS_AUTOUPDATE_DISABLED'		=>'<strong style="font-size:1.4em">BBCore auto-update is disabled!</strong>',
++-	'SS_BAD_FILESYSTEM'				=> 'You are using an obsolete PHP handler that makes your filesystem unwritable by phpBB.<br>Please consider installing a modern FastCGI PHP handler such as PHP-FPM.',
++-	'SS_SYSINFO'					=> 'System Information',
++-	'SS_FOUNDERS'					=> 'Founders',
++-	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
++-	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a> or go to the <a href="%s">SiteSplat Update Manager</a>.',
++-
++-    'VERSION_INSTALLED'  			=> 'Installed Version',
++-	'NEW_BOOTS_VERSION'				=> '🌟 New %s version available 🌟',
++-	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
++-	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
++-	
++-	'DOWNLOAD_MSG'					=> 'New Latest Current version: <span class="label label-success">%s</span>',
++-	'DOWNLOAD_BTN_ENVATO'		    => ' <a class="btn btn-default sitesplat-bbcore-autoupdate" href="%s" title="Download from envato" target="_blank">View Envato item</a>',
++-	'DOWNLOAD_MSG_NO_UPD'			=> 'All good! looks like you are up to date! 👍💯',
++-	'START_AUTO'				    => 'Start Auto-update 🚀',
++-	
++-	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s - Changelog</a>',
++-	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
++-	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
++-	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',
++-
++-    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
++-    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
++-    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
++-    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
++-  
++-    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
++-    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
++-	
++-	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
++-	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',
++-
++-	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
++-	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
++-    
++-	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin log under the MAINTENANCE tab.',
++-	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
++-	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',
++-
++-	// autoupdate
++-	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
++-	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP!!!',
++-    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
++-	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
++-	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
++-	'NO_DIRECT_DOWNLOAD'			=> 'Unable to automatically update your style because the style author did not provide the necessary files.',
++-	'PROBLEM_DOWNLOADING_UPDATE'	=> 'Unable to download the update files at the moment. Please try again later.',
++-	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
++-	'MERGE_CONFLICTS'				=> 'Oh No! 😱 ¯\_(ツ)_/¯ The system was unable to automatically update your premium theme. The possbile reasons could be due to your theme files being corrupted or containing custom changes that the auto-update is unable to automatically solve. In order to help you with this situation, see the generated conflicting files and/or conflicts they contain, saved in:<br /><br /><strong>%s</strong>.',
++-	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
++-	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
++-	'UPDATE_SUCCESS'				=> 'Yeehaw! Your Premium Theme has Been Updated Successfully 💯. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="https://themeforest.net/downloads?ref=ThemeSplat" target="_blank">https://themeforest.net/downloads</a>',
++-    'CURRENT_FILE'					=> 'Current file',
++-	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
++-	'NEW_FILE'						=> 'New file',
++-
++-	// log
++-	'LOG_STYLE_UPDATED'	=> '<strong>BBcore auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/en/BBCore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/en/BBCore.php"
++index ff6479956..6056f431e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/en/BBCore.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/en/BBCore.php"
++@@ -36,11 +36,9 @@ if (empty($lang) || !is_array($lang)) {
++ }
++ 
++ // load addon lang files first...allow BBCore to overwrite if needed
++-if (function_exists('\sitesplat\load_ext_lang')) {
++-    $addon_lang = [];
++-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
++-    $lang = array_merge($lang, $addon_lang);
++-}
+++$addon_lang = [];
+++\sitesplat\load_ext_lang(__DIR__, $addon_lang);
+++$lang = array_merge($lang, $addon_lang);
++ 
++ // BBCore
++ $lang = array_merge($lang, array(
++@@ -67,7 +65,6 @@ $lang = array_merge($lang, array(
++ 	'SS_CHATBOX'				=> 'Chat',
++ 	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
++ 	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
++-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
++ 
++ 	'SS_ADDONS'				=> 'Addons',
++ 	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
++@@ -270,6 +267,7 @@ $lang = array_merge($lang, array(
++ 	'NOTE'						=> 'Note',
++ 	'EDIT_DRAFT'				=> 'Edit Draft',
++ 	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
+++	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Mark all read',
++ 	'DAYS_AGO'					=> 'Days ago',
++ 	'WORK_IN_PROGRESS'			=> 'Maintenance',
++ 	'DISABLE_MESSAGE'			=> 'Board unavailable',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/BBCore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/BBCore.php"
++deleted file mode 100644
++index 261ba1fbc..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/BBCore.php"
+++++ /dev/null
++@@ -1,398 +0,0 @@
++-<?php
++-/**
++-*
++-* BBCore [English]
++-*
++-* @package sitesplat BBcore
++-* @copyright (c) 2015 SiteSplat All rights reserved
++-* @license Proprietary
++-*
++-*/
++-
++-// TRANSLATORS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, Par exemple: instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, Par exemple: 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order Par exemple:, 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB')) {
++-	exit;
++-}
++-if (empty($lang) || !is_array($lang)) {
++-	$lang = array();
++-}
++-
++-// load addon lang files first...allow BBCore to overwrite if needed
++-if (function_exists('\sitesplat\load_ext_lang')) {
++-    $addon_lang = [];
++-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
++-    $lang = array_merge($lang, $addon_lang);
++-}
++-
++-// BBCore
++-$lang = array_merge($lang, array(
++-	'PM_NEW_MSG' => [
++-		1 => 'You have %d New Private Message',
++-		2 => 'You have %d New Private Messages',
++-	],
++-	'PM_UNREAD_MSG' => [
++-		1 => 'You have %d Unread Private Message',
++-		2 => 'You have %d Unread Private Messages',
++-	],
++-	'PM_NEW_MSG_BUBBLE' => [
++-		1 => '%d',
++-		2 => '%d',
++-	],
++-
++-	'SITESPLAT_EXT'				=> 'Other Extensions',
++-	'BBCORE_DASHBOARD'			=> 'Dashboard',
++-	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
++-	'BBCORE_SETTINGS'			=> 'Settings',
++-	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
++-	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
++-	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
++-	'SS_CHATBOX'				=> 'Chat',
++-	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
++-	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
++-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
++-
++-	'SS_ADDONS'				=> 'Addons',
++-	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
++-	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
++-
++-	'UCP_MAIN'				=> 'Vue Générale',
++-	'UCP_MAIN_FRONT'		=> 'Tableau de bord',
++-	'UCP_MAIN_SUBSCRIPTION'	=> 'Gérer les abonnements',
++-	'UCP_MAIN_BOOKMARKS'	=> 'Gérer les favoris',
++-	'UCP_MAIN_DRAFTS'		=> 'Gérer les brouillons',
++-	'UCP_MAIN_ATTACHMENTS'	=> 'Gérer les pièces jointes',
++-
++-	'USER_PANEL'				=> 'Panneau de contrôle',
++-	'UCP_PROFILE'				=> 'Profil',
++-	'UCP_PROFILE_PROFILE'		=> 'Editer profil',
++-	'UCP_PROFILE_SIGNITURE'		=> 'Editer signature',
++-	'UCP_PROFILE_AVATAR'		=> 'Editer avatar',
++-	'UCP_PROFILE_SETTINGS'		=> 'Paramètres compte',
++-	'UCP_AVATAR_SELECT_OPTIONS'	=> 'Avatar options',
++-	'UCP_AVATAR_SELECT_UPLOAD'	=> 'Télécharger un avatar',
++-	'UCP_SUBMIT_TO_UPLOAD'		=> 'Submit below to upload',
++-
++-	'UCP_PREFERENCE'			=> 'Préférences Forum',
++-	'UCP_PREFERENCE_SETTINGS'	=> 'Editer paramètres',
++-	'UCP_PREFERENCE_DEFAULTS'	=> 'Edit posting defaults',
++-	'UCP_PREFERENCE_OPTIONS'	=> 'Editer options affichage',
++-
++-	'UCP_MESSAGES'				=> 'Messages',
++-	'UCP_PM_COMPOSE'			=> 'Ecrire message',
++-	'UCP_PM_DRAFTS'				=> 'Gérer brouillons',
++-	'UCP_PM_INBOX'				=> 'Reçus',
++-	'UCP_PM_OUTBOX'				=> 'Outbox',
++-	'UCP_PM_SENTBOX'			=> 'Envoyé',
++-	'UCP_PM_OPTIONS'			=> 'Règles, dossiers &amp; paramètres',
++-	'UCP_NO_USER_CHANGE_ALLOWED'	=> '**Username change is not allowed**',
++-	'UCP_REGISTER_EMAIL_EXPLAIN'	=> 'Please do not use disposable emails',
++-
++-	'WIDTH_SIZE'			=> 'largeur',
++-	'PIXEL_SIZE'			=> 'px',
++-	'HEIGHT_SIZE'			=> 'hauteur',
++-
++-	'UCP_GROUPS'			=> 'Groupe Utilisateurs',
++-	'UCP_GROUPS_MEMBERSHIP'	=> 'Edit membership',
++-	'UCP_GROUPS_MANAGE'		=> 'Gérer groupes',
++-
++-	'UCP_ZEBRA'					=> 'Amis &amp; Ignorés',
++-	'UCP_ZEBRA_FRIENDS'			=> 'Gérer Amis',
++-	'UCP_ZEBRA_FOES'			=> 'Gérer Ignorés',
++-	'UCP_APPLY'					=> 'Appliquer',
++-	'UCP_PM_DEFAULT_RULE_TAG'	=> 'Default action',
++-	'UCP_PM_DEFAULT_RULE'		=> 'Ne pas accepter nouveaux messages',
++-	'UCP_PM_DEFAULT_RULE_EXPLAIN'	=> 'This action will be triggered only if none of the above options is applicable. New messages will be held back until enough space is available.',
++-	'UCP_PM_NEW_MESSAGE'		=> 'Nouveau Message',
++-	'BIO'						=> 'Bio Informations Perso',
++-	'MANAGE'					=> 'Gérer',
++-	'JOINED_BOARD'				=> 'a rejoint le forum',
++-	'VISITED_BOARD'				=> 'Dernière visite',
++-	'SEE_MORE'					=> 'Plus',
++-	'ATTACH_SIGNATURE'			=> 'Joindre signature',
++-	'BBCODES'					=> 'BBcodes',
++-
++-	'DELETE_POST_SOFT'			=> 'Soft Delete post',
++-	'DELETE_POST_PERMANENT'		=> 'Perma Delete post',
++-	'DELETE_POST_SOFT_WARN'		=> 'It can be recovered',
++-	'DELETE_POST_PERMANENT_WARN'	=> 'It can NOT be recovered',
++-
++-	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	=> 'Enter the max number of options the user can select',
++-	'POLL_VOTE_CHANGE_LABEL'	=> 'Allow Re-vote',
++-	'NO_VOTES_NA'				=> 'Non Dispo',
++-	'NOT_AVAILABLE'				=> 'Non disponible',
++-	'POST_TOPIC_NEW'			=> 'Nouveau Sujet',
++-	'QUICK_REPLY_SHOW_HIDE'		=> 'Show/Hide Quick Reply',
++-	'CHARACTERS_COUNT'			=> 'Caractères',
++-	'CHARACTERS_COUNT_REM'		=> 'Remaining',
++-	'BOOKMARKED_TOPICS_UCP'		=> 'Bookmarked Topics',
++-	'ATTACH_EXPLANATION_SORTABLE'	=> 'Click to sort',
++-	'ATTACH_FORUM'				=> 'Attachment(s)',
++-	'MCP_DETAILS_LOG'			=> 'Details',
++-	'MCP_DETAIL_U_IP'			=> 'User &amp; IP',
++-	'MCP_MANAG_BAN'				=> 'Ban Management',
++-	'MCP_UNAPPROVED_POSTS_ZERO'	=> 'There are no posts waiting for approval',
++-	'MCP_REPORTS_ZERO'			=> 'There are no reports to review',
++-	'MCP_PM_REPORTS_ZERO'		=> 'There are no PM reports to review',
++-
++-
++-	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
++-	'FORUMLIST_UNAPPROVED'		=> 'At least one topic in this forum has not been approved',
++-	'FORUMLIST_UNAPPROVED_POST'	=> 'At least one post in this forum has not been approved',
++-	'FORUMLIST_LASTPOST'		=> 'View the latest post',
++-	'TOPICS_POSTS_STATISTICS'	=> 'Statistics',
++-	'TOPICS_ROW_REPORTED'		=> 'This Topic has been reported',
++-	'TOPICS_ROW_NOT_APPROVED'	=> 'This Topic has not been approved',
++-	'TOPICS_ROW_DELETED'		=> 'This Topic has been deleted',
++-	'MODERATOR_PANEL_GENERAL'	=> 'Moderator Panel',
++-	'ADMIN_PANEL_GENERAL'		=> 'Administrator Panel',
++-	'RANK_IMAGE'				=> 'Rank image',
++-
++-	'WELCOME_INDEX'			=> 'Bienvenue',
++-	'FAQ'					=> 'FAQ',
++-	'CAPTION_FAQ'			=> 'Foire Aux Questions',
++-	'CAPTION_SEARCH'		=> 'Search it up!',
++-	'CAPTION_MEMBERS'		=> 'Vous cherchez une personne?',
++-	'MEMBERS_CAP'			=> 'Membres',
++-	'CAPTION_UCP'			=> 'Choisir vos préférences',
++-	'UCP_CAP'				=> 'Panneau Utilisateur',
++-	'INDEX_CAPTION'			=> 'Page principale du forum',
++-	'VIEWTOPIC_CAP'			=> 'Titre Sujet',
++-	'CAPTION_VIEWTOPIC'		=> 'Description sujet',
++-	'CAPTION_VIEWFORUM'		=> 'Visualiser toutes les catégories du forum',
++-	'POSTINGS_CAP'			=> 'Editeur',
++-	'CAPTION_POSTINGS'		=> 'Posting things up!',
++-
++-	'MCP_CAPTION'				=> 'This is where you get to use the Super Powers ;-)',
++-	'BOOTSTRAP_ELEMENT'			=> 'Bootstrap Elements',
++-	'BOOTSTRAP_ELEMENT_CAPTION'	=> 'Forum KickStart Documentation',
++-	'MAIN_FORUM'				=> 'Forum',
++-	'MAIN_MAIN_STUFF'			=> 'The Main stuff',
++-	'MAIN_TRENDS'				=> 'See the trends',
++-
++-	'MAIN_SEARCH_IT_UP'		=> 'Search it up',
++-	'SUB_NO_ICON'			=> 'No Icon here at all',
++-	'EXAMPLE_WITH_ICON'		=> 'Example With Icon',
++-	'EXAMPLE_LINK'			=> 'Example Link',
++-	'MAIN_SOCIAL'			=> 'Social',
++-	'SOCIAL_P'				=> 'Chat away ;-)',
++-
++-	'MORE'					=> 'Plus',
++-	'EXPAND_CLOSE'			=> 'Fermer la Vue',
++-	'MARK_TOPICS_READ'		=> 'Mark Topics Read',
++-	'CONTACT'				=> 'Contact',
++-	'GET_IN_TOUCH'			=> 'Get in touch',
++-	'HANG_AROUND'			=> 'Bienvenue chez vous',
++-	'JOIN_THE_CLUB'			=> 'Rejoignez la communauté',
++-	'MENU'					=> 'MENU',
++-	'YOU_ARE_HERE'			=> 'Vous êtes ici',
++-	'IN_FOOTER'				=> 'Dans:',
++-	'REPLY'					=> 'Répondre',
++-
++-	'LOGIN_REMEMBER'		=> 'Me garder connecté',
++-	'LOGIN_HIDE_ME'			=> 'Cacher ma session',
++-	'LOGIN_ME_IN'			=> 'Me connecter',
++-	'SIGN_IN_ACCOUNT'		=> 'Sign in onto your account',
++-	'CREATE_ACCOUNT'		=> 'Créer un Compte',
++-	'GO_TO_SEARCH_ADV'		=> 'Retourner à la recherche avancée',
++-
++-	'CREATE_ACCOUNT_DISABLED'	=> 'Registrations closed',
++-	'REGISTRATION_DISABLED'		=> 'It looks like the registrations are closed at the moment. It could also be a temporary measure. If you believe this is a possible error, please contact the webmaster and let him know. We apologize for any inconvenience this might have caused. Our Privacy Policy and Terms of Use are available below.',
++-	'CONTACT_WEBMASTER'			=> 'Contacter le Webmaster',
++-	'CONFIRM_QA_EXPLAIN_ALT'	=> 'Pour être sûr que vous êtes un humain, répondez à cette question',
++-
++-	'PLUPLOAD_PLACE_INLINE'	=> 'Inline',
++-	'PLUPLOAD_DELETE_FILE'	=> 'Effacer',
++-
++-
++-	'REG_CREATING'			=> 'Création Profil...',
++-	'LOADING'				=> 'Chargement...',
++-	'SAVING'				=> 'Sauvegarde...',
++-	'CANCELLING'			=> 'Annulation...',
++-	'SENDING'				=> 'Envoi...',
++-	'SEARCHING'				=> 'Recherche...',
++-	'LOADING_LOG_IN'		=> 'Connexion...',
++-	'FILE_UPLOADING'		=> 'Téléchargement...',
++-	'CASTING_VOTE'			=> 'Casting vote...',
++-	'LOADING_FORM'			=> 'Loading form...',
++-
++-	'MEMBERLIST_P_JOINED'		=> 'Joined the board',
++-	'MEMBERLIST_P_EXPL'			=> 'This is when I joined the board',
++-	'MEMBERLIST_P_DATE_EXPL'	=> 'This was last time I visited the board',
++-	'SPAMMER'					=> 'Spammer',
++-	'SPAMMER_PLACEHOLDER'		=> 'You cannot just spam our board and get away with it!',
++-	'MARK_PLACEHOLDER'			=> 'Checkmark your choice',
++-	'INFO_BOX'					=> 'Information:',
++-	'USER_REMOVE_PLACEHOLDER'	=> 'Click to remove user',
++-	'GROUP_REMOVE_PLACEHOLDER'	=> 'Click to remove group',
++-	'EDIT_LINK_PLACEHOLDER'		=> 'Par exemple: I forgot to code my links',
++-	'POST_IT_UP_PLACEHOLDER'	=> 'Post it up!',
++-
++-	'UCP_REG_USR_PLACEHOLDER'	=> 'Par exemple: John Doe',
++-	'UCP_REG_EMAIL_PLACEHOLDER'	=> 'Par exemple: john@mail.com',
++-	'UCP_REG_PSWD_PLACEHOLDER'	=> 'Par exemple: ASDFasdf123',
++-	'UCP_REG_CTCHA_PLACEHOLDER'	=> 'Par exemple: blue sky',
++-	'SEARCH_USR_PLACEHOLDER'	=> 'Par exemple: SiteSplat',
++-	'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E. 2018-12-22',
++-	'IP_PLACEHOLDER'			=> 'Par exemple: 216.161.111.33',
++-	'POSTS_PLACEHOLDER'			=> 'Par exemple: 12',
++-	'SEARCH_KWDS_PLACEHOLDER'	=> 'Par exemple: cats, or cats+, or cats-, or cats|dogs, or cat*',
++-
++-	'MESSAGE_ENTER_PLACEHOLDER'	=> 'Ecrivez votre message...',
++-	'FILE_COMMENT_PLACEHOLDER'	=> 'Commentez votre fichier',
++-	'HEIGTH_PLACEHOLDER'		=> 'hauteur',
++-	'WIDTH_PLACEHOLDER'			=> 'largeur',
++-	'UCP_OCCUPATION_PLACEHOLDER'	=> 'Décrivez brièvement votre job...',
++-	'UCP_INTERESTS_PLACEHOLDER'	=> 'Décrivez vos intérêts...',
++-	'SOFT_DELETE_PLACEHOLDER'	=> 'Enter your reason if you wish to...',
++-	'ADD_DESCRIPTION'			=> 'Ajouter description',
++-
++-	'FILE_SELECT'				=> 'Choisir fichier',
++-	'FILE_CHANGE'				=> 'Changer',
++-	'SELECT_IMAGE'				=> 'Choisir image',
++-	'NOTE'						=> 'Note',
++-	'EDIT_DRAFT'				=> 'Edit Draft',
++-	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
++-	'DAYS_AGO'					=> 'Jours',
++-	'WORK_IN_PROGRESS'			=> 'Maintenance',
++-	'DISABLE_MESSAGE'			=> 'Forum indisponible',
++-	'DISABLE_RETURN'			=> 'Retourner à la page Accueil',
++-	'BOARD_DISABLED_SHUFFLE'	=> 'Have fun and shuffle some letters :-)',
++-	'DISABLE_TEXT_TRY'			=> 'Test it for yourself!',
++-	'DISABLE_TEXT_TYPE'			=> 'type anything and hit return...',
++-
++-	'GRAVATAR_EXPLAIN'			=> 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
++-	'GRAVATAR_EXPLAIN_CONFIRM'	=> 'Merci de confirmer votre email ici',
++-
++-	'DELETE_POLL'			=> 'Delete poll',
++-	'POLL_DELETE_HELPER'	=> '(This deletes the poll only) check and submit',
++-	'JUMP_TO_POST'			=> 'Aller au message',
++-	'JUMP_SELECT_FORUM'		=> 'Choisir le forum où aller',
++-	'JUMP_TO_PAGE_NUMBER'	=> 'Aller à la page #',
++-	'VIEW_FIRST_UNREAD'		=> 'Lire message non lu en premier',
++-	'BOOKMARK_TOPIC_REMOVE'	=> 'Enlever favori',
++-
++-	'NEW_MESSAGES'				=> 'Nouveaux messages',
++-	'YOU_HAVE'					=> 'Vous avez',
++-	'AND'						=> 'et',
++-	'HELLO'						=> 'Bonjour',
++-	'DISMISS_PM'				=> 'Defer 5 min',
++-	'READ_NOW'					=> 'Lire maintenant',
++-	'PRIVATE_MESSAGE_NEW'		=> 'nouveau message privé',
++-	'PRIVATE_MESSAGE_UNREAD'	=> 'message privé non lu',
++-	'NO_PMS_INFO'				=> 'Ok! Ecrire un nouveau MP?',
++-
++-	'DATES'					=> 'DATE',
++-	'POWERED'				=> 'Propulsé par',
++-	'HANDCRAFTED'			=> 'Fait par',
++-	'BY'					=> 'Par',
++-
++-	'RECENT_TOPICS'			=> 'Sujets Récents',
++-	'TWITTER'				=> 'Twitter',
++-	'FAVORITES'				=> 'Favoris',
++-
++-	'GALLERY'				=> 'Gallerie',
++-	'CHAT'					=> 'Chat',
++-	'ABOUT'					=> 'A Propos',
++-	'ABOUT_PART_ONE'		=> 'BBOOTS&#8482; Is The First And Only Fully Responsive PhpBB&reg; Unofficial HTML5/CSS3 Theme. It’s Clean And Crisp Design Looks AWESOME Across All Browsers And Devices.',
++-	'ABOUT_PART_TWO'		=> 'It Utilizes A Bootstrap Based Layout Which Has Been Long Waited For And That Is Sure To AMAZE The phpBB Fan Club.',
++-	'ABOUT_PART_THREE'		=> 'The Unofficial Responsive Theme',
++-	'BB'					=> 'B',
++-	'BOOTS'					=> 'BOOTS',
++-	'BBOOTS'				=> 'BBOOTS',
++-
++-	'BBOOTS_VERSION'		=> '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
++-	'U_LOGOUT'				=> 'Se déconnecter',
++-
++-	'SITESPLAT_STATISTICS'		=> 'Statistiques',
++-	'SITESPLAT_SEE_DETAILS'		=> 'Voir Details',
++-	'SITESPLAT_SEARCH_LAST_DAY'	=> 'Derniers messages sur 24H',
++-	'SITESPLAT_SEARCH_WEEK'		=> 'Derniers messages sur 7 jours',
++-
++-	'SITESPLAT_TOTAL_POSTS'		=> 'Total messages',
++-	'SITESPLAT_TOTAL_TOPICS'	=> 'Total sujets',
++-	'SITESPLAT_TOTAL_USERS'		=> 'Total membres',
++-	'SITESPLAT_NEWEST_MEMBER'	=> 'Newest Member',
++-	'SITESPLAT_USERS_ONLINE'	=> 'Utilisateurs en ligne',
++-	'SITESPLAT_MOST_USERS_ONLINE'	=> 'Most Users Online',
++-	'SITESPLAT_BIRTHDAYS'		=> 'Today\'s birthdays',
++-
++-	'BOOTSTRAP_VERSION'		=> '3.3.6',
++-	'FLATBOOTS'				=> 'FLATBOOTS',
++-	'CHANGE_AVATAR'			=> 'Change Avatar',
++-	'CHANGE_PASSWORD'		=> 'Change Password',
++-
++-	'ADMIN_TIPS'			=> 'Admin Tips &amp; Tricks',
++-	'ADMIN_TIP_INTRO'		=> 'Did you know you can make your phpBB forum even more secure with some simple steps?',
++-	'ADMIN_TIP_ONE'			=> 'Keep your software up to-date.',
++-	'ADMIN_TIP_TWO'			=> 'Always use strong passwords that contain random sequence of letters, numbers and special characters.',
++-	'ADMIN_TIP_THREE'		=> 'Restrict the admin folder access...',
++-	'ADMIN_CHECK_IT_BTN'	=> 'Visit SiteSplat.com for more',
++-
++-	'USER_MINI_PROFILE'			=> 'User mini profile',
++-	'USER_MINI_PROFILE_VIEW_FULL'	=> 'View full profile',
++-	'OFF_LINE'					=> 'Off-line',
++-	'USER_STATUS'				=> 'Status',
++-	'USER'						=> 'User',
++-	'TITLE'						=> 'Title',
++-	'END_TIMELINE'				=> 'End timeline',
++-	'MEMBERS'					=> 'Members',
++-	'DRAFTS'					=> 'Drafts',
++-	'REPORTS'					=> 'Reports',
++-	'MODERATOR_LOGS'			=> 'Moderator logs',
++-	'QUEUE'						=> 'Queue',
++-	'LINKS'						=> 'Links',
++-	'TOPIC_PERMISSIONS'			=> 'Topic permissions',
++-	'MODERATOR_OPTIONS'			=> 'Moderate',
++-	'PASSWORD_EXPLAIN_CONFIRM'	=> 'Make sure it matches',
++-	'FORUM_REDIRECTS'			=> 'Redirects:',
++-
++-	'FANCY_TOPICS_TITLE'	=> 'Recent topics from the forum',
++-	'POST_BY'				=> 'Post by',
++-	'REPLY_BY'				=> 'Reply by',
++-	'NO_REPLIES'			=> 'No replies',
++-	'READ_MORE'				=> 'Read more',
++-	'RT_READ_MORE'			=> 'READ MORE',
++-	'VIEW_MORE_TOPICS'		=> 'VIEW MORE TOPICS',
++-	'BACK_TO_START'			=> 'BACK TO START',
++-
++-	'TOGGLE_NAV'			=> 'Toggle Navigation',
++-	'NAVIGATION'			=> 'Navigation',
++-
++-	'DEMO_LINK'				=> 'Demo link no icons',
++-	'DEMO_HEADER_MENU'		=> 'Header intro example',
++-
++-	'FLATBOOTS_INTRO'			=> 'Bootstrap Framework',
++-	'FLATBOOTS_EXPLAIN'			=> 'Over a dozen reusable components built to provide iconography, dropdowns, input groups, navigation, alerts, and much more...',
++-	'CALL_TO_ACTION_FOOTER'		=> 'Swap-in out addons, use only what you really need!',
++-	'PURCHASE_NOW_BTN'			=> 'Purchase now',
++-	'FLATBOOTS_ABOUT_PART_ONE'	=> 'Why Would you Settle for Less when you can have More? Do not let other Authors Fool you with Empty Marketing Keywords. FLATBOOTS is what you Deserve. Built to last, Built from Scratch, Nothing Less.',
++-	'FLATBOOTS_ABOUT_TITLE'		=> 'Built to last',
++-	'DMCA'						=> 'DMCA',
++-	'TERMS'						=> 'Terms',
++-	'ADVERTISE'					=> 'Advertise',
++-	'SITESPLAT'					=> 'SiteSplat',
++-    'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
++-    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
++-    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
++-    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
++-	'JOIN_US_TWITTER'			=> 'Join us on Twitter',
++-	'TWEET_EXAMPLE'				=> 'BBOOTS reaches 2000 sales! Thank-you all for supporting this amazing project and contributing to built the SiteSplat Community. What\'s next? stay tuned and Follow Me on Twitter: <a href="#">http://bit.ly/000fefs</a>',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_acp_bbcore.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_acp_bbcore.php"
++deleted file mode 100644
++index 6cb7131a6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_acp_bbcore.php"
+++++ /dev/null
++@@ -1,103 +0,0 @@
++-<?php
++-/**
++-*
++-* common [English]
++-*
++-* @package language
++-* @package sitesplat BBcore
++-* @version $Id$
++-* @copyright (c) 2015 SiteSplat All rights reserved
++-* @license Proprietary
++-*
++-*/
++-
++-// TRANSLATORS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
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
++-	$lang = array();
++-}
++-
++-$lang = array_merge($lang, array(
++-	'SS_AUTOUPDATE_DISABLED'		=>'<strong style="font-size:1.4em">BBCore auto-update is disabled!</strong>',
++-	'SS_BAD_FILESYSTEM'				=> 'You are using an obsolete PHP handler that makes your filesystem unwritable by phpBB.<br>Please consider installing a modern FastCGI PHP handler such as PHP-FPM.',
++-	'SS_SYSINFO'					=> 'System Information',
++-	'SS_FOUNDERS'					=> 'Founders',
++-	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
++-	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a> or go to the <a href="%s">SiteSplat Update Manager</a>.',
++-
++-    'VERSION_INSTALLED'  			=> 'Installed Version',
++-	'NEW_BOOTS_VERSION'				=> '🌟 New %s version available 🌟',
++-	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
++-	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
++-	
++-	'DOWNLOAD_MSG'					=> 'New Latest Current version: <span class="label label-success">%s</span>',
++-	'DOWNLOAD_BTN_ENVATO'		    => ' <a class="btn btn-default sitesplat-bbcore-autoupdate" href="%s" title="Download from envato" target="_blank">View Envato item</a>',
++-	'DOWNLOAD_MSG_NO_UPD'			=> 'All good! looks like you are up to date! 👍💯',
++-	'START_AUTO'				    => 'Start Auto-update 🚀',
++-	
++-	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s - Changelog</a>',
++-	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
++-	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
++-	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',
++-
++-    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
++-    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
++-    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
++-    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
++-  
++-    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
++-    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
++-	
++-	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
++-	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',
++-
++-	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
++-	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
++-    
++-	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin log under the MAINTENANCE tab.',
++-	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
++-	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',
++-
++-	// autoupdate
++-	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
++-	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP!!!',
++-    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
++-	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
++-	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
++-	'NO_DIRECT_DOWNLOAD'			=> 'Unable to automatically update your style because the style author did not provide the necessary files.',
++-	'PROBLEM_DOWNLOADING_UPDATE'	=> 'Unable to download the update files at the moment. Please try again later.',
++-	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
++-	'MERGE_CONFLICTS'				=> 'Oh No! 😱 ¯\_(ツ)_/¯ The system was unable to automatically update your premium theme. The possbile reasons could be due to your theme files being corrupted or containing custom changes that the auto-update is unable to automatically solve. In order to help you with this situation, see the generated conflicting files and/or conflicts they contain, saved in:<br /><br /><strong>%s</strong>.',
++-	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
++-	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
++-	'UPDATE_SUCCESS'				=> 'Yeehaw! Your Premium Theme has Been Updated Successfully 💯. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="https://themeforest.net/downloads?ref=ThemeSplat" target="_blank">https://themeforest.net/downloads</a>',
++-    'CURRENT_FILE'					=> 'Current file',
++-	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
++-	'NEW_FILE'						=> 'New file',
++-
++-	// log
++-	'LOG_STYLE_UPDATED'	=> '<strong>BBcore auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
++-));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/BBCore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/BBCore.php"
++new file mode 100644
++index 000000000..c4c3ea3d0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/BBCore.php"
++@@ -0,0 +1,399 @@
+++<?php
+++/**
+++*
+++* BBCore [Portuguese]
+++*
+++* @package language
+++* @package sitesplat BBcore
+++* @version $Id$
+++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+++* @copyright (c) 2015 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++// TRANSLATORS PLEASE NOTE	
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
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB')) {
+++	exit;
+++}
+++if (empty($lang) || !is_array($lang)) {
+++	$lang = array();
+++}
+++
+++// load addon lang files first...allow BBCore to overwrite if needed
+++$addon_lang = [];
+++\sitesplat\load_ext_lang(__DIR__, $addon_lang);
+++$lang = array_merge($lang, $addon_lang);
+++
+++// BBCore
+++$lang = array_merge($lang, array(
+++
+++	'PM_NEW_MSG' => [
+++		1 => 'Tem %d Nova Mensagem Privada',
+++		2 => 'Tem %d Novas Mensagens Privadas',
+++	],
+++	'PM_UNREAD_MSG' => [
+++		1 => 'Tem %d Mensagem Privada Por Ler',
+++		2 => 'Tem %d Mensagens Privadas Por Ler',
+++	],
+++	'PM_NEW_MSG_BUBBLE' => [
+++		1 => '%d',
+++		2 => '%d',
+++	],
+++
+++	'SITESPLAT_EXT'				=> 'Other Extensions',
+++	'BBCORE_DASHBOARD'			=> 'Dashboard',
+++	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
+++	'BBCORE_SETTINGS'			=> 'Settings',
+++	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
+++	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
+++	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
+++	'SS_CHATBOX'				=> 'Chat',
+++	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+++	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+++	'SS_ADDONS'				=> 'Addons',
+++	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+++	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
+++
+++	'UCP_MAIN'						 => 'Geral',
+++	'UCP_MAIN_FRONT'				 => 'Página Principal',
+++	'UCP_MAIN_SUBSCRIPTION'			 => 'Administrar Observações',
+++	'UCP_MAIN_BOOKMARKS'			 => 'Administrar Favoritos',
+++	'UCP_MAIN_DRAFTS'				 => 'Administrar Rascunhos',
+++	'UCP_MAIN_ATTACHMENTS'			 => 'Administrar Anexos',
+++
+++	'USER_PANEL'					 => 'Painel de Controlo',
+++	'UCP_PROFILE'					 => 'Perfil',
+++	'UCP_PROFILE_PROFILE'			 => 'Editar Perfil',
+++	'UCP_PROFILE_SIGNITURE'			 => 'Editar Assinatura',
+++	'UCP_PROFILE_AVATAR'			 => 'Editar Avatar',
+++	'UCP_PROFILE_SETTINGS'			 => 'Detalhes da Conta',
+++	'UCP_AVATAR_SELECT_OPTIONS'		 => 'Opções do Avatar', 
+++	'UCP_AVATAR_SELECT_UPLOAD'		 => 'Envie o avatar a partir do seu dispositivo',
+++	'UCP_SUBMIT_TO_UPLOAD'			 => 'Clique em baixo para enviar',
+++
+++	'UCP_PREFERENCE'				 => 'Preferências',
+++	'UCP_PREFERENCE_SETTINGS' 		 => 'Editar configurações pessoais',
+++	'UCP_PREFERENCE_DEFAULTS' 		 => 'Editar mensagens enviadas',
+++	'UCP_PREFERENCE_OPTIONS'		 => 'Editar exibição de mensagens',
+++
+++	'UCP_MESSAGES'					 => 'Mensagens Privadas',
+++	'UCP_PM_COMPOSE'				 => 'Criar mensagem privada',
+++	'UCP_PM_DRAFTS'					 => 'Administrar rascunhos',
+++	'UCP_PM_INBOX'					 => 'Caixa de Entrada',
+++	'UCP_PM_OUTBOX'					 => 'Caixa de Saída',
+++	'UCP_PM_SENTBOX'				 => 'Mensagens Enviadas',
+++	'UCP_PM_OPTIONS'				 => 'Opções (Regras e Pastas)',
+++	'UCP_NO_USER_CHANGE_ALLOWED'	 => '**Não é permitido alterar o Nome de Utilizador**',
+++	'UCP_REGISTER_EMAIL_EXPLAIN'	 => 'Por favor, não utilize emails descartáveis',
+++	'UCP_USERGROUPS_EXPLAIN'		 => '(Escolha um grupo e depois clique em Adicionar)',
+++
+++	'WIDTH_SIZE'					 => 'largura',
+++	'PIXEL_SIZE'					 => 'px',
+++	'HEIGHT_SIZE'					 => 'altura',
+++
+++	'UCP_GROUPS'					 => 'Grupos de Utilizadores',
+++	'UCP_GROUPS_MEMBERSHIP'			 => 'Editar Inscrições em Grupos',
+++	'UCP_GROUPS_MANAGE'				 => 'Administrar grupos',
+++
+++	'UCP_ZEBRA'						 => 'Amigos e Inimigos',
+++	'UCP_ZEBRA_FRIENDS'				 => 'Administrar Amigos',
+++	'UCP_ZEBRA_FOES'				 => 'Administrar Inimigos',
+++	'UCP_APPLY'						 => 'Alterar',
+++	'UCP_PM_DEFAULT_RULE_TAG'		 => 'Acção Padrão',
+++	'UCP_PM_DEFAULT_RULE'			 => 'Não serão aceitas novas Mensagens',
+++	'UCP_PM_DEFAULT_RULE_EXPLAIN'	 => 'Esta acção será despoletada se se verificar a regra mencionada. As Mensagens novas serão mantidas até haver espaço disponível',
+++	'UCP_PM_NEW_MESSAGE'			 => 'Nova Mensagem',
+++	'BIO'							 => 'Informações Pessoais',
+++	'MANAGE'						 => 'Gerir',
+++	'JOINED_BOARD'					 => 'Entrou no Fórum', //Registou-se?
+++	'VISITED_BOARD'					 => 'Última visita',
+++	'SEE_MORE'						 => 'Mais',
+++	'ATTACH_SIGNATURE'				 => 'Anexar assinatura',
+++	'BBCODES'						 => 'BBcodes',
+++
+++	'DELETE_POST_SOFT'				 => 'Enviar Mensagem para a Reciclagem',
+++	'DELETE_POST_PERMANENT'			 => 'Apagar Mensagem Permanentemente ',
+++	'DELETE_POST_SOFT_WARN'			 => 'Poderá ser recuperada',
+++	'DELETE_POST_PERMANENT_WARN'	 => 'NÃO poderá ser recuperada',
+++
+++	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	 => 'Introduza o número máx. de opções que o utilizador poderá seleccionar',
+++	'POLL_VOTE_CHANGE_LABEL'		 => 'Permitir Alterar Voto',
+++	'NO_VOTES_NA'					 => 'N/A',
+++	'NOT_AVAILABLE'					 => 'Indisponível',
+++	'POST_TOPIC_NEW'				 => 'Novo Tópico',
+++	'QUICK_REPLY_SHOW_HIDE'			 => 'Mostrar/Ocultar Resposta Rápida',
+++	'CHARACTERS_COUNT'				 => 'Carácter',
+++	'CHARACTERS_COUNT_REM'			 => 'Restantes',
+++	'BOOKMARKED_TOPICS_UCP'			 => 'Tópicos favoritos',
+++	'ATTACH_EXPLANATION_SORTABLE'	 => 'Clique para ordenar',
+++	'ATTACH_FORUM'					 => 'Anexo(s)',
+++	'MCP_DETAILS_LOG'				 => 'Detalhes',
+++	'MCP_DETAIL_U_IP'				 => 'Utilizador &amp; IP',
+++	'MCP_MANAG_BAN'					 => 'Administrar Expulsões',
+++	'MCP_UNAPPROVED_POSTS_ZERO'		 => 'Não existem mensagens por aprovar',
+++	'MCP_REPORTS_ZERO'				 => 'Não existem denúncias de Mensagens para rever',
+++	'MCP_PM_REPORTS_ZERO'			 => 'Não existem denúncias de Mensagens Privadas para rever',
+++
+++
+++	'SUBFORUM_LINK'					 => 'Endereço abre numa nova aba',
+++	'FORUMLIST_UNAPPROVED'			 => 'Falta pelo menos um tópico neste fórum por aprovar',
+++	'FORUMLIST_UNAPPROVED_POST'		 => 'Falta pelo menos uma mensagem neste fórum por aprovar', 
+++	'FORUMLIST_LASTPOST'			 => 'Ver a última mensagem',
+++	'TOPICS_POSTS_STATISTICS'		 => 'Estatísticas',
+++	'TOPICS_ROW_REPORTED'			 => 'Este tópico foi reportado',
+++	'TOPICS_ROW_NOT_APPROVED'		 => 'Este tópico não foi aprovado',
+++	'TOPICS_ROW_DELETED'			 => 'Este tópico foi apagado',
+++	'MODERATOR_PANEL_GENERAL'		 => 'Painel de Moderação',
+++	'ADMIN_PANEL_GENERAL'			 => 'Painel de Administração',
+++	'RANK_IMAGE'					 => 'Imagem de Rank',
+++
+++	'WELCOME_INDEX'					 => 'Bem-vindo',
+++	'FAQ'							 => 'FAQ',
+++	'CAPTION_FAQ'					 => 'Questões Mais Frequentes',
+++	'CAPTION_SEARCH'				 => 'Procura primeiro!',
+++	'CAPTION_MEMBERS'				 => 'À procura de alguém?',
+++	'MEMBERS_CAP'					 => 'Membros',
+++	'CAPTION_UCP'					 => 'Defina as suas preferências',
+++	'UCP_CAP'						 => 'Painel de Controlo do Utilizador',
+++	'INDEX_CAPTION'					 => 'Esta é a página índice do fórum',
+++	'VIEWTOPIC_CAP'					 => 'Título do Tópico',
+++	'CAPTION_VIEWTOPIC'				 => 'Descrição do Tópico',
+++	'CAPTION_VIEWFORUM'				 => 'Navegar por todas as categorias do fórum',
+++	'POSTINGS_CAP'					 => 'Editor de Mensagens',
+++	'CAPTION_POSTINGS'				 => 'A colocar conteúdo!',
+++
+++	'MCP_CAPTION'					 => 'É aqui que podes usar os teus Super-Poderes ;-)',
+++	'BOOTSTRAP_ELEMENT'				 => 'Elementos Bootstrap',
+++	'BOOTSTRAP_ELEMENT_CAPTION'		 => 'Documentação do Fórum KickStart',
+++	'MAIN_FORUM'					 => 'Fórum',
+++	'MAIN_MAIN_STUFF'				 => 'As principais coisas',
+++	'MAIN_TRENDS'					 => 'Veja as tendências',
+++
+++	'MAIN_SEARCH_IT_UP'				 => 'Procura primeiro',
+++	'SUB_NO_ICON'					 => 'Não foram encontrados ícones',
+++	'EXAMPLE_WITH_ICON'				 => 'Exemplo com Ícone',
+++	'EXAMPLE_LINK'					 => 'Exemplo com Endereço',
+++	'MAIN_SOCIAL'					 => 'Social',
+++	'SOCIAL_P'						 => 'Conversar à pala ;-)',
+++
+++	'MORE'							 => 'Mais',
+++	'EXPAND_CLOSE'					 => 'Fechar Vista',
+++	'MARK_TOPICS_READ'				 => 'Marcar tópicos como lidos',
+++	'CONTACT'						 => 'Contacto',
+++	'GET_IN_TOUCH'					 => 'Entra em contacto',
+++	'HANG_AROUND'					 => 'Participa',
+++	'JOIN_THE_CLUB'					 => 'Junta-te ao clube',
+++	'MENU'							 => 'MENU',
+++	'YOU_ARE_HERE'					 => 'Estás aqui',
+++	'IN_FOOTER'						 => 'Em:',
+++	'REPLY'							 => 'Resposta',
+++
+++	'LOGIN_REMEMBER'				 => 'Continuar conectado',
+++	'LOGIN_HIDE_ME'					 => 'Ocultar sessão',
+++	'LOGIN_ME_IN'					 => 'Entrar',
+++	'SIGN_IN_ACCOUNT'				 => 'Entrar na conta',
+++	'CREATE_ACCOUNT'				 => 'Criar Conta',
+++	'GO_TO_SEARCH_ADV'				 => 'Regressar à pesquisa avançada',
+++
+++	'CREATE_ACCOUNT_DISABLED'		 => 'Os registos estão encerrados',
+++	'REGISTRATION_DISABLED'			 => 'Os registos estão de momento encerrados, apenas poderá criar conta por convite. Pedimos desculpa pelo inconveniente. A nossa Política de Privacidade e Termos de Uso estão disponíveis em baixo. Vê a Ajuda para mais informações sobre os convites.',
+++	'CONTACT_WEBMASTER'				 => 'Contacta o Administrador',
+++	'CONFIRM_QA_EXPLAIN_ALT'		 => 'Prova que és humano e responde à seguinte questão',
+++
+++	'PLUPLOAD_PLACE_INLINE'			 => 'Adicionar',
+++	'PLUPLOAD_DELETE_FILE'			 => 'Apagar',
+++
+++
+++	'REG_CREATING'					 => 'A Criar perfil...',
+++	'LOADING'						 => 'A Carregar...',
+++	'SAVING'						 => 'A Guardar...',
+++	'CANCELLING'					 => 'A Cancelar...',
+++	'SENDING'						 => 'A Enviar...',
+++	'SEARCHING'						 => 'A Pesquisar...',
+++	'LOADING_LOG_IN'				 => 'A Conectar-se...',
+++	'FILE_UPLOADING'				 => 'A Enviar Ficheiro...',
+++	'CASTING_VOTE'					 => 'A Enviar Voto...',
+++	'LOADING_FORM'					 => 'A Carregar Formulário...',
+++
+++	'MEMBERLIST_P_JOINED'			 => 'Registou-se no fórum',
+++	'MEMBERLIST_P_EXPL'				 => 'Quando me registei no fórum',
+++	'MEMBERLIST_P_DATE_EXPL'		 => 'Última vez que visitei o fórum',
+++	'SPAMMER'						 => 'Spammer',
+++	'SPAMMER_PLACEHOLDER'			 => 'Não podes simplesmente fazer Spam e sair impune!',
+++	'MARK_PLACEHOLDER'				 => 'Coloque visto na sua escolha',
+++	'INFO_BOX'						 => 'Informações:',
+++	'USER_REMOVE_PLACEHOLDER'		 => 'Clique para remover o utilizador',
+++	'GROUP_REMOVE_PLACEHOLDER'		 => 'Clique para remover o grupo',
+++	'EDIT_LINK_PLACEHOLDER'			 => 'Esqueci-me de colocar código nos meus endereços',
+++	'POST_IT_UP_PLACEHOLDER'		 => 'Enviar!',
+++
+++	'UCP_REG_USR_PLACEHOLDER'		 => 'E.g. John Doe',
+++	'UCP_REG_EMAIL_PLACEHOLDER'		 => 'E.g. john@mail.com',
+++	'UCP_REG_PSWD_PLACEHOLDER'		 => 'E.g. ASDFasdf123',
+++	'UCP_REG_CTCHA_PLACEHOLDER'		 => 'E.g. golden sky',
+++	'SEARCH_USR_PLACEHOLDER'		 => 'E.g. GoldTugAnime',
+++	'YEAR_MONTH_DAY_PLACEHOLDER'	 => 'E.g. 2018-12-22',
+++	'IP_PLACEHOLDER'				 => 'E.g. 216.161.111.33',
+++	'POSTS_PLACEHOLDER'				 => 'E.g. 12',
+++	'SEARCH_KWDS_PLACEHOLDER'		 => 'E.g. gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',
+++
+++	'MESSAGE_ENTER_PLACEHOLDER'		 => 'Introduza a sua mensagem...',
+++	'FILE_COMMENT_PLACEHOLDER'		 => 'Espaço reservado para comentários',
+++	'HEIGTH_PLACEHOLDER'			 => 'altura',
+++	'WIDTH_PLACEHOLDER'				 => 'largura',
+++	'UCP_OCCUPATION_PLACEHOLDER'	 => 'Descreve de forma breve a tua profissão...',
+++	'UCP_INTERESTS_PLACEHOLDER'		 => 'Descreve os teus interesses...',
+++	'SOFT_DELETE_PLACEHOLDER'		 => 'Adiciona os teus motivos, caso desejes...',
+++	'ADD_DESCRIPTION'				 => 'Adicionar descrição',
+++
+++	'FILE_SELECT'					 => 'Seleccione o ficheiro',
+++	'FILE_CHANGE'					 => 'Alterar',
+++	'SELECT_IMAGE'					 => 'Seleccione a imagem',
+++	'NOTE'							 => 'Observação',
+++	'EDIT_DRAFT'					 => 'Editar Rascunho',
+++	'PM_BALOON_NOTIFICATION'		 => 'Activar notificação de MP (Mensagem Privada) via Pop-Up',
+++	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Marcar todas como lidas',
+++	'DAYS_AGO'						 => 'Dias atrás',
+++	'WORK_IN_PROGRESS'				 => 'Manutenção',
+++	'DISABLE_MESSAGE'				 => 'Fórum indisponível',
+++	'DISABLE_RETURN'				 => 'Voltar à página de índice',
+++	'BOARD_DISABLED_SHUFFLE'		 => 'Diverte-te e embaralha algumas letras :-)',
+++	'DISABLE_TEXT_TRY'				 => 'Testa tu mesmo!',
+++	'DISABLE_TEXT_TYPE'				 => 'Digite algo, e pressione retroceder...',
+++
+++	'GRAVATAR_EXPLAIN'				 => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, será usado por defeito.',
+++	'GRAVATAR_EXPLAIN_CONFIRM'		 => 'Por favor, confirme o seu endereço de e-mail aqui',
+++
+++	'DELETE_POLL'					 => 'Apagar Votação',
+++	'POLL_DELETE_HELPER'			 => '(Isto apenas apaga a votação) verificar e submeter',
+++	'JUMP_TO_POST'					 => 'Ir para a mensagem',
+++	'JUMP_SELECT_FORUM'				 => 'Selecciona o Fórum para onde ir',
+++	'JUMP_TO_PAGE_NUMBER'			 => 'Ir para #',
+++	'VIEW_FIRST_UNREAD'				 => 'Ver primeira mensagem não lida.',
+++	'BOOKMARK_TOPIC_REMOVE'			 => 'Remover tópico dos favoritos',
+++
+++	'NEW_MESSAGES'					 => 'Novas mensagens',
+++	'YOU_HAVE'						 => 'Você tem',
+++	'AND'							 => 'e',
+++	'HELLO'							 => 'Olá',
+++	'DISMISS_PM'					 => 'Adiar 5 minutos',
+++	'READ_NOW'						 => 'Leia agora',
+++	'PRIVATE_MESSAGE_NEW'			 => 'nova mensagem privada',
+++	'PRIVATE_MESSAGE_UNREAD'		 => 'mensagem privada por ler',
+++	'NO_PMS_INFO'					 => 'Tudo em dia! Escrever nova MP?',
+++
+++	'DATES'							 => 'DATA',
+++	'POWERED'						 => 'Baseado em',
+++	'HANDCRAFTED'					 => 'Desenvolvido Com',
+++	'BY'							 => 'Por',
+++
+++	'RECENT_TOPICS'					 => 'Tópicos recentes',
+++	'TWITTER'						 => 'Twitter',
+++	'FAVORITES'						 => 'Favoritos',
+++
+++	'GALLERY'						 => 'Galeria',
+++	'CHAT'							 => 'Chat',
+++	'ABOUT'							 => 'Sobre Nós',
+++	'ABOUT_PART_ONE'				 => 'BBOOTS&#8482; É o primeiro e único Tema, HTML5/CSS3 não-oficial, totalmente Ágil de PhpBB&reg;. É limpo e nítido. Com um Design INCRÍVEL e compatível com todos os navegadores e dispositivos.',
+++	'ABOUT_PART_TWO'				 => 'Utiliza um layout com base no Bootstrap, há muito esperado, e que irá surpreender os fãs da plataforma phpBB.',
+++	'ABOUT_PART_THREE'				 => 'O Tema Ágil Não-Oficial',
+++	'BB'							 => 'B',
+++	'BOOTS'							 => 'BOOTS',
+++	'BBOOTS'						 => 'BBOOTS',
+++
+++	'BBOOTS_VERSION'				 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
+++	'U_LOGOUT'						 => 'Sair',
+++
+++	'SITESPLAT_STATISTICS'			 => 'Estatísticas',
+++	'SITESPLAT_SEE_DETAILS'			 => 'Ver detalhes',
+++	'SITESPLAT_SEARCH_LAST_DAY'		 => 'Mensagens das últimas 24h',
+++	'SITESPLAT_SEARCH_WEEK'			 => 'Mensagens dos últimos 7 dias',
+++
+++	'SITESPLAT_TOTAL_POSTS'			 => 'Total de mensagens',
+++	'SITESPLAT_TOTAL_TOPICS'		 => 'Total de tópicos',
+++	'SITESPLAT_TOTAL_USERS'			 => 'Total de utilizadores',
+++	'SITESPLAT_NEWEST_MEMBER'		 => 'Novo utilizador',
+++	'SITESPLAT_USERS_ONLINE'		 => 'Utilizadores Online',
+++	'SITESPLAT_MOST_USERS_ONLINE'	 => 'Recorde de Utilizadores Online',
+++	'SITESPLAT_BIRTHDAYS'			 => 'Aniversariantes',
+++
+++	'BOOTSTRAP_VERSION'				 => '3.3.6',
+++	'FLATBOOTS'						 => 'FLATBOOTS',
+++	'CHANGE_AVATAR'					 => 'Alterar Avatar',
+++	'CHANGE_PASSWORD'				 => 'Alterar Senha',
+++
+++	'ADMIN_TIPS'					 => 'Truques e Dicas dos Administradores',
+++	'ADMIN_TIP_INTRO'				 => 'Sabias que podes tornar o teu fórum phpBB ainda mais seguro com apenas alguns passos simples?',
+++	'ADMIN_TIP_ONE'					 => 'Mantém o teu software actualizado.',
+++	'ADMIN_TIP_TWO'					 => 'Usa sempre boas senhas que contenham sequências aleatórias de números, letras e caracteres especiais.',
+++	'ADMIN_TIP_THREE'				 => 'Restrinja o acesso à zona de administração...',
+++	'ADMIN_CHECK_IT_BTN'			 => 'Visita SiteSplat.com para mais informação',
+++
+++	'USER_MINI_PROFILE'				 => 'Mini-perfil do utilizador',
+++	'USER_MINI_PROFILE_VIEW_FULL'	 => 'Ver o perfil completo',
+++	'OFF_LINE'						 => 'Desconectado',
+++	'USER_STATUS'					 => 'Estado',
+++	'USER'							 => 'Utilizador',
+++	'TITLE'							 => 'Título',
+++	'END_TIMELINE'					 => 'Cronograma final',
+++	'MEMBERS'						 => 'Utilizadores',
+++	'DRAFTS'						 => 'Rascunhos',
+++	'REPORTS'						 => 'Denúncias',
+++	'MODERATOR_LOGS'				 => 'Registos de Moderador',
+++	'QUEUE'							 => 'Moderação',
+++	'LINKS'							 => 'Endereços',
+++	'TOPIC_PERMISSIONS'				 => 'Permissões do tópico',
+++	'MODERATOR_OPTIONS'				 => 'Moderar',
+++	'PASSWORD_EXPLAIN_CONFIRM'		 => 'Certifique-se que corresponde',
+++	'FORUM_REDIRECTS'				 => 'Redireccionamentos:',
+++
+++	'FANCY_TOPICS_TITLE'			 => 'Tópicos recentes do fórum',
+++	'POST_BY'						 => 'Criado por',
+++	'REPLY_BY'						 => 'Respondido por',
+++	'NO_REPLIES'					 => 'Sem resposta',
+++	'READ_MORE'						 => 'Ler mais',
+++	'RT_READ_MORE'					 => 'LER MAIS',
+++	'VIEW_MORE_TOPICS'				 => 'VER MAIS TÓPICOS',
+++	'BACK_TO_START'					 => 'VOLTAR AO INÍCIO',
+++
+++	'TOGGLE_NAV'					 => 'Alterar Navegação',
+++	'NAVIGATION'					 => 'Navegação',
+++
+++	'DEMO_LINK'						 => 'Apenas demonstração, não existe ícones',
+++	'DEMO_HEADER_MENU'				 => 'Exemplo de cabeçalho da introdução',
+++
+++	'FLATBOOTS_INTRO'				 => 'Bootstrap Framework',
+++	'FLATBOOTS_EXPLAIN'				 => 'Mais de uma dúzia de componentes reutilizáveis, criado para fornecer iconografia, menus suspensos, grupos de entrada, sistema de navegação, notificações e muito mais...',
+++	'CALL_TO_ACTION_FOOTER'			 => 'Active e desactive addons, use apenas o que realmente precisa!',
+++	'PURCHASE_NOW_BTN'				 => 'Compre agora',
+++	'FLATBOOTS_ABOUT_PART_ONE'		 => 'Porque é que iria contentar-se com menos, quando pode ter mais? Não deixe que outros autores o enganem com jogadas de Marketing. O FLATBOOTS é aquilo que merece. Construído para durar, construído a partir do zero, nada mais, nada menos.',
+++	'FLATBOOTS_ABOUT_TITLE'			 => 'Construído para durar',
+++	'DMCA'							 => 'DMCA',
+++	'TERMS'							 => 'Termos e Condições',
+++	'ADVERTISE'						 => 'Divulgue',
+++	'DEVELOPER'						 => 'Desenvolvido por',
+++	'LEINAD4MIND'					 => 'Leinad4Mind',
+++	'SITESPLAT_URL'					 => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
+++	'JOIN_US_TWITTER'				 => 'Segue-nos!',
+++	'TWEET_EXAMPLE'					 => 'O BBOOTS atingiu as 500 vendas! Obrigado a todos os que apoiam este projecto e que contribuem com o SiteSplat para construir a comunidade. O que o futuro reserva? Mantém-te a par e segue-me no Twitter. <a href="#">http://bit.ly/000fefs</a>',
+++
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/filesystem.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/filesystem.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/filesystem.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/filesystem.php"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_acp_bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_acp_bbcore.php"
++new file mode 100644
++index 000000000..29468e2a0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_acp_bbcore.php"
++@@ -0,0 +1,60 @@
+++<?php
+++/**
+++*
+++* common [Portuguese]
+++*
+++* @package language
+++* @package sitesplat BBcore
+++* @version $Id$
+++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+++* @copyright (c) 2015 SiteSplat All rights reserved
+++* @license Proprietary
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
+++$lang = array_merge($lang, array(
+++
+++	'ACP_SITESPLAT_UPDATE_MANAGER'	 => 'Administrar Actualizações de SiteSplat',
+++	'VERSION_INSTALLED'				 => 'Versão Instalada',
+++	'NEW_BOOTS_VERSION'				 => 'Nova versão disponível: %s',
+++	'VERSIONNUMBERS'				 => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
+++	'SS_RAPID_DISABLE'				 => 'Desactivar Rápido SS',
+++	'SS_RAPID_DISABLE_TLT'			 => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',
+++
+++	'DOWNLOAD_MSG'					 => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
+++	'CHANGE_LOG_MSG'				 => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
+++	'SUPPORT_FORUM_MSG'				 => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
+++	'COLORIZE_MSG'					 => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
+++	'NO_VERSIONINFO'				 => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',
+++
+++	'LOG_FILES_CHANGED'				 => '<strong>O BBcore alterou o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+++	'LOG_THEME_INSTALLED'			 => '<strong>O BBcore foi instalado com sucesso</strong>',
+++	'LOG_FILES_CHANGED_FAILED'		 => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
+++	'LOG_THEME_UNINSTALLED'			 => '<strong>O BBcore foi desinstalado com sucesso</strong>',
+++
+++	'LOG_FILE_NOT_REPLACED'			 => '<strong>O BBcore não conseguiu substituir o ficheiro original por ti:</strong><br />» %s',
+++	'LOG_FILE_NOT_UPDATED'			 => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+++
+++	'LOG_BBCORE_INSTALLED'			 => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
+++	'LOG_BBCORE_DEINSTALLED'		 => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',
+++
+++	'LOG_BBCORE_NOT_REPLACED'		 => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) ficheiro(s)<br />» %s',
+++	'LOG_BBCORE_NOT_UPDATED'		 => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) ficheiro(s)<br />» %s',
+++
+++	'ACP_BBCORE_MSG_FILES_FAIL'		 => 'Nem TODOS os ficheiros foram editados! Por favor, substitui manualmente o(s) ficheiro(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
+++	'ACP_BBCORE_MSG_SETTINGS'		 => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de ficheiros no servidor ou à falta de ficheiros nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os ficheiros manualmente para desfrutar de todas as funcionalidades.',
+++	'BBCORE_ERROR_DISABLE'			 => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
++similarity index 78%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
++index a8de9ceef..e0c4569f2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
++@@ -3,6 +3,7 @@
++ *
++ * @package language
++ * @package sitesplat BBcore addon
+++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
++ * @copyright (c) 2015 SiteSplat All rights reserved
++ * @license Proprietary
++ *
++@@ -55,14 +56,14 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge(
++ 	$lang, array(
++-		'UCP_IR'				    => 'Image Resizer',
++-		'IMAGE_RESIZE'			    => 'Image Resize',
++-		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
+++		'UCP_IR'				    => 'Redimensionar Imagem',
+++		'IMAGE_RESIZE'			    => 'Redimensionamento de Imagem',
+++		'IMAGE_RESIZE_EXPLAIN'	    => 'Corte %1$s da imagem e confirme.',
++ 		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',
++ 
++-		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
+++		'IMAGE_RESIZE_ERROR'	    => 'Nenhuma app ou ficheiro para enviar!',
++ 		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
++-		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
++-	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable AvatarResize because of other active premium extensions<br /><div>» %s</div>',
+++	    'SS_HELPER_NOTY'	    	=> 'Core does not exist!<br />Download and copy the Core folder into your sitesplat extension folder.',
++ 	)
++ );
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/BBCore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/BBCore.php"
++new file mode 100644
++index 000000000..1d560bb4e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/BBCore.php"
++@@ -0,0 +1,399 @@
+++<?php
+++/**
+++*
+++* BBCore [Portuguese]
+++*
+++* @package language
+++* @package sitesplat BBcore
+++* @version $Id$
+++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+++* @copyright (c) 2015 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++// TRANSLATORS PLEASE NOTE	
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
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB')) {
+++	exit;
+++}
+++if (empty($lang) || !is_array($lang)) {
+++	$lang = array();
+++}
+++
+++// load addon lang files first...allow BBCore to overwrite if needed
+++$addon_lang = [];
+++\sitesplat\load_ext_lang(__DIR__, $addon_lang);
+++$lang = array_merge($lang, $addon_lang);
+++
+++// BBCore
+++$lang = array_merge($lang, array(
+++
+++	'PM_NEW_MSG' => [
+++		1 => 'Tem %d Nova Mensagem Privada',
+++		2 => 'Tem %d Novas Mensagens Privadas',
+++	],
+++	'PM_UNREAD_MSG' => [
+++		1 => 'Tem %d Mensagem Privada Por Ler',
+++		2 => 'Tem %d Mensagens Privadas Por Ler',
+++	],
+++	'PM_NEW_MSG_BUBBLE' => [
+++		1 => '%d',
+++		2 => '%d',
+++	],
+++
+++	'SITESPLAT_EXT'				=> 'Other Extensions',
+++	'BBCORE_DASHBOARD'			=> 'Dashboard',
+++	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
+++	'BBCORE_SETTINGS'			=> 'Settings',
+++	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
+++	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
+++	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
+++	'SS_CHATBOX'				=> 'Chat',
+++	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+++	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+++	'SS_ADDONS'				=> 'Addons',
+++	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+++	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
+++
+++	'UCP_MAIN'						 => 'Geral',
+++	'UCP_MAIN_FRONT'				 => 'Página Principal',
+++	'UCP_MAIN_SUBSCRIPTION'			 => 'Administrar Observações',
+++	'UCP_MAIN_BOOKMARKS'			 => 'Administrar Favoritos',
+++	'UCP_MAIN_DRAFTS'				 => 'Administrar Rascunhos',
+++	'UCP_MAIN_ATTACHMENTS'			 => 'Administrar Anexos',
+++
+++	'USER_PANEL'					 => 'Painel de Controlo',
+++	'UCP_PROFILE'					 => 'Perfil',
+++	'UCP_PROFILE_PROFILE'			 => 'Editar Perfil',
+++	'UCP_PROFILE_SIGNITURE'			 => 'Editar Assinatura',
+++	'UCP_PROFILE_AVATAR'			 => 'Editar Avatar',
+++	'UCP_PROFILE_SETTINGS'			 => 'Detalhes da Conta',
+++	'UCP_AVATAR_SELECT_OPTIONS'		 => 'Opções do Avatar', 
+++	'UCP_AVATAR_SELECT_UPLOAD'		 => 'Envie o avatar a partir do seu dispositivo',
+++	'UCP_SUBMIT_TO_UPLOAD'			 => 'Clique em baixo para enviar',
+++
+++	'UCP_PREFERENCE'				 => 'Preferências',
+++	'UCP_PREFERENCE_SETTINGS' 		 => 'Editar configurações pessoais',
+++	'UCP_PREFERENCE_DEFAULTS' 		 => 'Editar mensagens enviadas',
+++	'UCP_PREFERENCE_OPTIONS'		 => 'Editar exibição de mensagens',
+++
+++	'UCP_MESSAGES'					 => 'Mensagens Privadas',
+++	'UCP_PM_COMPOSE'				 => 'Criar mensagem privada',
+++	'UCP_PM_DRAFTS'					 => 'Administrar rascunhos',
+++	'UCP_PM_INBOX'					 => 'Caixa de Entrada',
+++	'UCP_PM_OUTBOX'					 => 'Caixa de Saída',
+++	'UCP_PM_SENTBOX'				 => 'Mensagens Enviadas',
+++	'UCP_PM_OPTIONS'				 => 'Opções (Regras e Pastas)',
+++	'UCP_NO_USER_CHANGE_ALLOWED'	 => '**Não é permitido alterar o Nome de Utilizador**',
+++	'UCP_REGISTER_EMAIL_EXPLAIN'	 => 'Por favor, não utilize emails descartáveis',
+++	'UCP_USERGROUPS_EXPLAIN'		 => '(Escolha um grupo e depois clique em Adicionar)',
+++
+++	'WIDTH_SIZE'					 => 'largura',
+++	'PIXEL_SIZE'					 => 'px',
+++	'HEIGHT_SIZE'					 => 'altura',
+++
+++	'UCP_GROUPS'					 => 'Grupos de Utilizadores',
+++	'UCP_GROUPS_MEMBERSHIP'			 => 'Editar Inscrições em Grupos',
+++	'UCP_GROUPS_MANAGE'				 => 'Administrar grupos',
+++
+++	'UCP_ZEBRA'						 => 'Amigos e Inimigos',
+++	'UCP_ZEBRA_FRIENDS'				 => 'Administrar Amigos',
+++	'UCP_ZEBRA_FOES'				 => 'Administrar Inimigos',
+++	'UCP_APPLY'						 => 'Alterar',
+++	'UCP_PM_DEFAULT_RULE_TAG'		 => 'Acção Padrão',
+++	'UCP_PM_DEFAULT_RULE'			 => 'Não serão aceitas novas Mensagens',
+++	'UCP_PM_DEFAULT_RULE_EXPLAIN'	 => 'Esta acção será despoletada se se verificar a regra mencionada. As Mensagens novas serão mantidas até haver espaço disponível',
+++	'UCP_PM_NEW_MESSAGE'			 => 'Nova Mensagem',
+++	'BIO'							 => 'Informações Pessoais',
+++	'MANAGE'						 => 'Gerir',
+++	'JOINED_BOARD'					 => 'Entrou no Fórum', //Registou-se?
+++	'VISITED_BOARD'					 => 'Última visita',
+++	'SEE_MORE'						 => 'Mais',
+++	'ATTACH_SIGNATURE'				 => 'Anexar assinatura',
+++	'BBCODES'						 => 'BBcodes',
+++
+++	'DELETE_POST_SOFT'				 => 'Enviar Mensagem para a Reciclagem',
+++	'DELETE_POST_PERMANENT'			 => 'Apagar Mensagem Permanentemente ',
+++	'DELETE_POST_SOFT_WARN'			 => 'Poderá ser recuperada',
+++	'DELETE_POST_PERMANENT_WARN'	 => 'NÃO poderá ser recuperada',
+++
+++	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	 => 'Introduza o número máx. de opções que o utilizador poderá seleccionar',
+++	'POLL_VOTE_CHANGE_LABEL'		 => 'Permitir Alterar Voto',
+++	'NO_VOTES_NA'					 => 'N/A',
+++	'NOT_AVAILABLE'					 => 'Indisponível',
+++	'POST_TOPIC_NEW'				 => 'Novo Tópico',
+++	'QUICK_REPLY_SHOW_HIDE'			 => 'Mostrar/Ocultar Resposta Rápida',
+++	'CHARACTERS_COUNT'				 => 'Carácter',
+++	'CHARACTERS_COUNT_REM'			 => 'Restantes',
+++	'BOOKMARKED_TOPICS_UCP'			 => 'Tópicos favoritos',
+++	'ATTACH_EXPLANATION_SORTABLE'	 => 'Clique para ordenar',
+++	'ATTACH_FORUM'					 => 'Anexo(s)',
+++	'MCP_DETAILS_LOG'				 => 'Detalhes',
+++	'MCP_DETAIL_U_IP'				 => 'Utilizador &amp; IP',
+++	'MCP_MANAG_BAN'					 => 'Administrar Expulsões',
+++	'MCP_UNAPPROVED_POSTS_ZERO'		 => 'Não existem mensagens por aprovar',
+++	'MCP_REPORTS_ZERO'				 => 'Não existem denúncias de Mensagens para rever',
+++	'MCP_PM_REPORTS_ZERO'			 => 'Não existem denúncias de Mensagens Privadas para rever',
+++
+++
+++	'SUBFORUM_LINK'					 => 'Endereço abre numa nova aba',
+++	'FORUMLIST_UNAPPROVED'			 => 'Falta pelo menos um tópico neste fórum por aprovar',
+++	'FORUMLIST_UNAPPROVED_POST'		 => 'Falta pelo menos uma mensagem neste fórum por aprovar', 
+++	'FORUMLIST_LASTPOST'			 => 'Ver a última mensagem',
+++	'TOPICS_POSTS_STATISTICS'		 => 'Estatísticas',
+++	'TOPICS_ROW_REPORTED'			 => 'Este tópico foi reportado',
+++	'TOPICS_ROW_NOT_APPROVED'		 => 'Este tópico não foi aprovado',
+++	'TOPICS_ROW_DELETED'			 => 'Este tópico foi apagado',
+++	'MODERATOR_PANEL_GENERAL'		 => 'Painel de Moderação',
+++	'ADMIN_PANEL_GENERAL'			 => 'Painel de Administração',
+++	'RANK_IMAGE'					 => 'Imagem de Rank',
+++
+++	'WELCOME_INDEX'					 => 'Bem-vindo',
+++	'FAQ'							 => 'FAQ',
+++	'CAPTION_FAQ'					 => 'Questões Mais Frequentes',
+++	'CAPTION_SEARCH'				 => 'Procura primeiro!',
+++	'CAPTION_MEMBERS'				 => 'À procura de alguém?',
+++	'MEMBERS_CAP'					 => 'Membros',
+++	'CAPTION_UCP'					 => 'Defina as suas preferências',
+++	'UCP_CAP'						 => 'Painel de Controlo do Utilizador',
+++	'INDEX_CAPTION'					 => 'Esta é a página índice do fórum',
+++	'VIEWTOPIC_CAP'					 => 'Título do Tópico',
+++	'CAPTION_VIEWTOPIC'				 => 'Descrição do Tópico',
+++	'CAPTION_VIEWFORUM'				 => 'Navegar por todas as categorias do fórum',
+++	'POSTINGS_CAP'					 => 'Editor de Mensagens',
+++	'CAPTION_POSTINGS'				 => 'A colocar conteúdo!',
+++
+++	'MCP_CAPTION'					 => 'É aqui que podes usar os teus Super-Poderes ;-)',
+++	'BOOTSTRAP_ELEMENT'				 => 'Elementos Bootstrap',
+++	'BOOTSTRAP_ELEMENT_CAPTION'		 => 'Documentação do Fórum KickStart',
+++	'MAIN_FORUM'					 => 'Fórum',
+++	'MAIN_MAIN_STUFF'				 => 'As principais coisas',
+++	'MAIN_TRENDS'					 => 'Veja as tendências',
+++
+++	'MAIN_SEARCH_IT_UP'				 => 'Procura primeiro',
+++	'SUB_NO_ICON'					 => 'Não foram encontrados ícones',
+++	'EXAMPLE_WITH_ICON'				 => 'Exemplo com Ícone',
+++	'EXAMPLE_LINK'					 => 'Exemplo com Endereço',
+++	'MAIN_SOCIAL'					 => 'Social',
+++	'SOCIAL_P'						 => 'Conversar à pala ;-)',
+++
+++	'MORE'							 => 'Mais',
+++	'EXPAND_CLOSE'					 => 'Fechar Vista',
+++	'MARK_TOPICS_READ'				 => 'Marcar tópicos como lidos',
+++	'CONTACT'						 => 'Contacto',
+++	'GET_IN_TOUCH'					 => 'Entra em contacto',
+++	'HANG_AROUND'					 => 'Participa',
+++	'JOIN_THE_CLUB'					 => 'Junta-te ao clube',
+++	'MENU'							 => 'MENU',
+++	'YOU_ARE_HERE'					 => 'Estás aqui',
+++	'IN_FOOTER'						 => 'Em:',
+++	'REPLY'							 => 'Resposta',
+++
+++	'LOGIN_REMEMBER'				 => 'Continuar conectado',
+++	'LOGIN_HIDE_ME'					 => 'Ocultar sessão',
+++	'LOGIN_ME_IN'					 => 'Entrar',
+++	'SIGN_IN_ACCOUNT'				 => 'Entrar na conta',
+++	'CREATE_ACCOUNT'				 => 'Criar Conta',
+++	'GO_TO_SEARCH_ADV'				 => 'Regressar à pesquisa avançada',
+++
+++	'CREATE_ACCOUNT_DISABLED'		 => 'Os registos estão encerrados',
+++	'REGISTRATION_DISABLED'			 => 'Parece que os registos estão de momento encerrados, pode ser temporário. Se acha que é um erro, entre em contacto com o Administrador e informe sobre a situação. Pedimos desculpa pelo inconveniente. A nossa Política de Privacidade e Termos de Uso estão disponíveis em baixo.',
+++	'CONTACT_WEBMASTER'				 => 'Contacta o Administrador',
+++	'CONFIRM_QA_EXPLAIN_ALT'		 => 'Prova que és humano e responde à seguinte questão',
+++
+++	'PLUPLOAD_PLACE_INLINE'			 => 'Adicionar',
+++	'PLUPLOAD_DELETE_FILE'			 => 'Apagar',
+++
+++
+++	'REG_CREATING'					 => 'A Criar perfil...',
+++	'LOADING'						 => 'A Carregar...',
+++	'SAVING'						 => 'A Guardar...',
+++	'CANCELLING'					 => 'A Cancelar...',
+++	'SENDING'						 => 'A Enviar...',
+++	'SEARCHING'						 => 'A Pesquisar...',
+++	'LOADING_LOG_IN'				 => 'A Conectar-se...',
+++	'FILE_UPLOADING'				 => 'A Enviar Ficheiro...',
+++	'CASTING_VOTE'					 => 'A Enviar Voto...',
+++	'LOADING_FORM'					 => 'A Carregar Formulário...',
+++
+++	'MEMBERLIST_P_JOINED'			 => 'Registou-se no fórum',
+++	'MEMBERLIST_P_EXPL'				 => 'Quando me registei no fórum',
+++	'MEMBERLIST_P_DATE_EXPL'		 => 'Última vez que visitei o fórum',
+++	'SPAMMER'						 => 'Spammer',
+++	'SPAMMER_PLACEHOLDER'			 => 'Não podes simplesmente fazer Spam e sair impune!',
+++	'MARK_PLACEHOLDER'				 => 'Coloque visto na sua escolha',
+++	'INFO_BOX'						 => 'Informações:',
+++	'USER_REMOVE_PLACEHOLDER'		 => 'Clique para remover o utilizador',
+++	'GROUP_REMOVE_PLACEHOLDER'		 => 'Clique para remover o grupo',
+++	'EDIT_LINK_PLACEHOLDER'			 => 'Esqueci-me de colocar código nos meus endereços',
+++	'POST_IT_UP_PLACEHOLDER'		 => 'Enviar!',
+++
+++	'UCP_REG_USR_PLACEHOLDER'		 => 'E.g. John Doe',
+++	'UCP_REG_EMAIL_PLACEHOLDER'		 => 'E.g. john@mail.com',
+++	'UCP_REG_PSWD_PLACEHOLDER'		 => 'E.g. ASDFasdf123',
+++	'UCP_REG_CTCHA_PLACEHOLDER'		 => 'E.g. golden sky',
+++	'SEARCH_USR_PLACEHOLDER'		 => 'E.g. GoldTugAnime',
+++	'YEAR_MONTH_DAY_PLACEHOLDER'	 => 'E.g. 2018-12-22',
+++	'IP_PLACEHOLDER'				 => 'E.g. 216.161.111.33',
+++	'POSTS_PLACEHOLDER'				 => 'E.g. 12',
+++	'SEARCH_KWDS_PLACEHOLDER'		 => 'E.g. gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',
+++
+++	'MESSAGE_ENTER_PLACEHOLDER'		 => 'Introduza a sua mensagem...',
+++	'FILE_COMMENT_PLACEHOLDER'		 => 'Espaço reservado para comentários',
+++	'HEIGTH_PLACEHOLDER'			 => 'altura',
+++	'WIDTH_PLACEHOLDER'				 => 'largura',
+++	'UCP_OCCUPATION_PLACEHOLDER'	 => 'Descreve de forma breve a tua profissão...',
+++	'UCP_INTERESTS_PLACEHOLDER'		 => 'Descreve os teus interesses...',
+++	'SOFT_DELETE_PLACEHOLDER'		 => 'Adiciona os teus motivos, caso desejes...',
+++	'ADD_DESCRIPTION'				 => 'Adicionar descrição',
+++
+++	'FILE_SELECT'					 => 'Seleccione o ficheiro',
+++	'FILE_CHANGE'					 => 'Alterar',
+++	'SELECT_IMAGE'					 => 'Seleccione a imagem',
+++	'NOTE'							 => 'Observação',
+++	'EDIT_DRAFT'					 => 'Editar Rascunho',
+++	'PM_BALOON_NOTIFICATION'		 => 'Activar notificação de MP (Mensagem Privada) via Pop-Up',
+++	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Marcar todas como lidas',
+++	'DAYS_AGO'						 => 'Dias atrás',
+++	'WORK_IN_PROGRESS'				 => 'Manutenção',
+++	'DISABLE_MESSAGE'				 => 'Fórum indisponível',
+++	'DISABLE_RETURN'				 => 'Voltar à página de índice',
+++	'BOARD_DISABLED_SHUFFLE'		 => 'Diverte-te e embaralha algumas letras :-)',
+++	'DISABLE_TEXT_TRY'				 => 'Testa tu mesmo!',
+++	'DISABLE_TEXT_TYPE'				 => 'Digite algo, e pressione retroceder...',
+++
+++	'GRAVATAR_EXPLAIN'				 => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, será usado por defeito.',
+++	'GRAVATAR_EXPLAIN_CONFIRM'		 => 'Por favor, confirme o seu endereço de e-mail aqui',
+++
+++	'DELETE_POLL'					 => 'Apagar Votação',
+++	'POLL_DELETE_HELPER'			 => '(Isto apenas apaga a votação) verificar e submeter',
+++	'JUMP_TO_POST'					 => 'Ir para a mensagem',
+++	'JUMP_SELECT_FORUM'				 => 'Selecciona o Fórum para onde ir',
+++	'JUMP_TO_PAGE_NUMBER'			 => 'Ir para #',
+++	'VIEW_FIRST_UNREAD'				 => 'Ver primeira mensagem não lida.',
+++	'BOOKMARK_TOPIC_REMOVE'			 => 'Remover tópico dos favoritos',
+++
+++	'NEW_MESSAGES'					 => 'Novas mensagens',
+++	'YOU_HAVE'						 => 'Você tem',
+++	'AND'							 => 'e',
+++	'HELLO'							 => 'Olá',
+++	'DISMISS_PM'					 => 'Adiar 5 minutos',
+++	'READ_NOW'						 => 'Leia agora',
+++	'PRIVATE_MESSAGE_NEW'			 => 'nova mensagem privada',
+++	'PRIVATE_MESSAGE_UNREAD'		 => 'mensagem privada por ler',
+++	'NO_PMS_INFO'					 => 'Tudo em dia! Escrever nova MP?',
+++
+++	'DATES'							 => 'DATA',
+++	'POWERED'						 => 'Baseado em',
+++	'HANDCRAFTED'					 => 'Desenvolvido Com',
+++	'BY'							 => 'Por',
+++
+++	'RECENT_TOPICS'					 => 'Tópicos recentes',
+++	'TWITTER'						 => 'Twitter',
+++	'FAVORITES'						 => 'Favoritos',
+++
+++	'GALLERY'						 => 'Galeria',
+++	'CHAT'							 => 'Chat',
+++	'ABOUT'							 => 'Sobre Nós',
+++	'ABOUT_PART_ONE'				 => 'BBOOTS&#8482; É o primeiro e único Tema, HTML5/CSS3 não-oficial, totalmente Ágil de PhpBB&reg;. É limpo e nítido. Com um Design INCRÍVEL e compatível com todos os navegadores e dispositivos.',
+++	'ABOUT_PART_TWO'				 => 'Utiliza um layout com base no Bootstrap, há muito esperado, e que irá surpreender os fãs da plataforma phpBB.',
+++	'ABOUT_PART_THREE'				 => 'O Tema Ágil Não-Oficial',
+++	'BB'							 => 'B',
+++	'BOOTS'							 => 'BOOTS',
+++	'BBOOTS'						 => 'BBOOTS',
+++
+++	'BBOOTS_VERSION'				 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
+++	'U_LOGOUT'						 => 'Sair',
+++
+++	'SITESPLAT_STATISTICS'			 => 'Estatísticas',
+++	'SITESPLAT_SEE_DETAILS'			 => 'Ver detalhes',
+++	'SITESPLAT_SEARCH_LAST_DAY'		 => 'Mensagens das últimas 24h',
+++	'SITESPLAT_SEARCH_WEEK'			 => 'Mensagens dos últimos 7 dias',
+++
+++	'SITESPLAT_TOTAL_POSTS'			 => 'Total de mensagens',
+++	'SITESPLAT_TOTAL_TOPICS'		 => 'Total de tópicos',
+++	'SITESPLAT_TOTAL_USERS'			 => 'Total de utilizadores',
+++	'SITESPLAT_NEWEST_MEMBER'		 => 'Novo utilizador',
+++	'SITESPLAT_USERS_ONLINE'		 => 'Utilizadores Online',
+++	'SITESPLAT_MOST_USERS_ONLINE'	 => 'Recorde de Utilizadores Online',
+++	'SITESPLAT_BIRTHDAYS'			 => 'Aniversariantes',
+++
+++	'BOOTSTRAP_VERSION'				 => '3.3.6',
+++	'FLATBOOTS'						 => 'FLATBOOTS',
+++	'CHANGE_AVATAR'					 => 'Alterar Avatar',
+++	'CHANGE_PASSWORD'				 => 'Alterar Senha',
+++
+++	'ADMIN_TIPS'					 => 'Truques e Dicas dos Administradores',
+++	'ADMIN_TIP_INTRO'				 => 'Sabias que podes tornar o teu fórum phpBB ainda mais seguro com apenas alguns passos simples?',
+++	'ADMIN_TIP_ONE'					 => 'Mantém o teu software actualizado.',
+++	'ADMIN_TIP_TWO'					 => 'Usa sempre boas senhas que contenham sequências aleatórias de números, letras e caracteres especiais.',
+++	'ADMIN_TIP_THREE'				 => 'Restrinja o acesso à zona de administração...',
+++	'ADMIN_CHECK_IT_BTN'			 => 'Visita SiteSplat.com para mais informação',
+++
+++	'USER_MINI_PROFILE'				 => 'Mini-perfil do utilizador',
+++	'USER_MINI_PROFILE_VIEW_FULL'	 => 'Ver o perfil completo',
+++	'OFF_LINE'						 => 'Desconectado',
+++	'USER_STATUS'					 => 'Estado',
+++	'USER'							 => 'Utilizador',
+++	'TITLE'							 => 'Título',
+++	'END_TIMELINE'					 => 'Cronograma final',
+++	'MEMBERS'						 => 'Utilizadores',
+++	'DRAFTS'						 => 'Rascunhos',
+++	'REPORTS'						 => 'Denúncias',
+++	'MODERATOR_LOGS'				 => 'Registos de Moderador',
+++	'QUEUE'							 => 'Moderação',
+++	'LINKS'							 => 'Endereços',
+++	'TOPIC_PERMISSIONS'				 => 'Permissões do tópico',
+++	'MODERATOR_OPTIONS'				 => 'Moderar',
+++	'PASSWORD_EXPLAIN_CONFIRM'		 => 'Certifique-se que corresponde',
+++	'FORUM_REDIRECTS'				 => 'Redireccionamentos:',
+++
+++	'FANCY_TOPICS_TITLE'			 => 'Tópicos recentes do fórum',
+++	'POST_BY'						 => 'Criado por',
+++	'REPLY_BY'						 => 'Respondido por',
+++	'NO_REPLIES'					 => 'Sem resposta',
+++	'READ_MORE'						 => 'Ler mais',
+++	'RT_READ_MORE'					 => 'LER MAIS',
+++	'VIEW_MORE_TOPICS'				 => 'VER MAIS TÓPICOS',
+++	'BACK_TO_START'					 => 'VOLTAR AO INÍCIO',
+++
+++	'TOGGLE_NAV'					 => 'Alterar Navegação',
+++	'NAVIGATION'					 => 'Navegação',
+++
+++	'DEMO_LINK'						 => 'Apenas demonstração, não existe ícones',
+++	'DEMO_HEADER_MENU'				 => 'Exemplo de cabeçalho da introdução',
+++
+++	'FLATBOOTS_INTRO'				 => 'Bootstrap Framework',
+++	'FLATBOOTS_EXPLAIN'				 => 'Mais de uma dúzia de componentes reutilizáveis, criado para fornecer iconografia, menus suspensos, grupos de entrada, sistema de navegação, notificações e muito mais...',
+++	'CALL_TO_ACTION_FOOTER'			 => 'Active e desactive addons, use apenas o que realmente precisa!',
+++	'PURCHASE_NOW_BTN'				 => 'Compre agora',
+++	'FLATBOOTS_ABOUT_PART_ONE'		 => 'Porque é que iria contentar-se com menos, quando pode ter mais? Não deixe que outros autores o enganem com jogadas de Marketing. O FLATBOOTS é aquilo que merece. Construído para durar, construído a partir do zero, nada mais, nada menos.',
+++	'FLATBOOTS_ABOUT_TITLE'			 => 'Construído para durar',
+++	'DMCA'							 => 'DMCA',
+++	'TERMS'							 => 'Termos e Condições',
+++	'ADVERTISE'						 => 'Divulgue',
+++	'DEVELOPER'						 => 'Desenvolvido por',
+++	'LEINAD4MIND'					 => 'Leinad4Mind',
+++	'SITESPLAT_URL'				 => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
+++	'JOIN_US_TWITTER'				 => 'Segue-nos!',
+++	'TWEET_EXAMPLE'				 => 'O BBOOTS atingiu as 500 vendas! Obrigado a todos os que apoiam este projecto e que contribuem com o SiteSplat para construir a comunidade. O que o futuro reserva? Mantém-te a par e segue-me no Twitter. <a href="#">http://bit.ly/000fefs</a>',
+++
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
++similarity index 97%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
++index ce0463cd5..076aeb8f7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
++@@ -46,8 +46,8 @@ $lang = array_merge($lang, array(
++ 	'FTP_BAD_PATH'			=> 'Unable to select phpBB directory',
++ 	'FTP_FS_SUCCESS'		=> 'FTP access to filesystem was successful',
++ 
++-	'BBCORE_SETTINGS'		=> 'BBCore Einstellungen',
++-	'BBCORE_OPT_SAVED'		=> 'BBCore Einstellungen wurden gespeichert.',
+++	'BBCORE_SETTINGS'		=> 'BBCore Settings',
+++	'BBCORE_OPT_SAVED'		=> 'BBCore Settings have been saved.',
++ 
++ 	// minification
++ 	'SITESPLAT_BBCORE_MINIFY_HTML'			=> 'Minify HTML',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php"
++new file mode 100644
++index 000000000..29468e2a0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php"
++@@ -0,0 +1,60 @@
+++<?php
+++/**
+++*
+++* common [Portuguese]
+++*
+++* @package language
+++* @package sitesplat BBcore
+++* @version $Id$
+++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+++* @copyright (c) 2015 SiteSplat All rights reserved
+++* @license Proprietary
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
+++$lang = array_merge($lang, array(
+++
+++	'ACP_SITESPLAT_UPDATE_MANAGER'	 => 'Administrar Actualizações de SiteSplat',
+++	'VERSION_INSTALLED'				 => 'Versão Instalada',
+++	'NEW_BOOTS_VERSION'				 => 'Nova versão disponível: %s',
+++	'VERSIONNUMBERS'				 => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
+++	'SS_RAPID_DISABLE'				 => 'Desactivar Rápido SS',
+++	'SS_RAPID_DISABLE_TLT'			 => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',
+++
+++	'DOWNLOAD_MSG'					 => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
+++	'CHANGE_LOG_MSG'				 => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
+++	'SUPPORT_FORUM_MSG'				 => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
+++	'COLORIZE_MSG'					 => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
+++	'NO_VERSIONINFO'				 => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',
+++
+++	'LOG_FILES_CHANGED'				 => '<strong>O BBcore alterou o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+++	'LOG_THEME_INSTALLED'			 => '<strong>O BBcore foi instalado com sucesso</strong>',
+++	'LOG_FILES_CHANGED_FAILED'		 => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
+++	'LOG_THEME_UNINSTALLED'			 => '<strong>O BBcore foi desinstalado com sucesso</strong>',
+++
+++	'LOG_FILE_NOT_REPLACED'			 => '<strong>O BBcore não conseguiu substituir o ficheiro original por ti:</strong><br />» %s',
+++	'LOG_FILE_NOT_UPDATED'			 => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+++
+++	'LOG_BBCORE_INSTALLED'			 => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
+++	'LOG_BBCORE_DEINSTALLED'		 => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',
+++
+++	'LOG_BBCORE_NOT_REPLACED'		 => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) ficheiro(s)<br />» %s',
+++	'LOG_BBCORE_NOT_UPDATED'		 => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) ficheiro(s)<br />» %s',
+++
+++	'ACP_BBCORE_MSG_FILES_FAIL'		 => 'Nem TODOS os ficheiros foram editados! Por favor, substitui manualmente o(s) ficheiro(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
+++	'ACP_BBCORE_MSG_SETTINGS'		 => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de ficheiros no servidor ou à falta de ficheiros nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os ficheiros manualmente para desfrutar de todas as funcionalidades.',
+++	'BBCORE_ERROR_DISABLE'			 => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
++similarity index 78%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
++index a8de9ceef..e0c4569f2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
++@@ -3,6 +3,7 @@
++ *
++ * @package language
++ * @package sitesplat BBcore addon
+++* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
++ * @copyright (c) 2015 SiteSplat All rights reserved
++ * @license Proprietary
++ *
++@@ -55,14 +56,14 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge(
++ 	$lang, array(
++-		'UCP_IR'				    => 'Image Resizer',
++-		'IMAGE_RESIZE'			    => 'Image Resize',
++-		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
+++		'UCP_IR'				    => 'Redimensionar Imagem',
+++		'IMAGE_RESIZE'			    => 'Redimensionamento de Imagem',
+++		'IMAGE_RESIZE_EXPLAIN'	    => 'Corte %1$s da imagem e confirme.',
++ 		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',
++ 
++-		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
+++		'IMAGE_RESIZE_ERROR'	    => 'Nenhuma app ou ficheiro para enviar!',
++ 		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
++-		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
++-	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable AvatarResize because of other active premium extensions<br /><div>» %s</div>',
+++	    'SS_HELPER_NOTY'	    	=> 'Core does not exist!<br />Download and copy the Core folder into your sitesplat extension folder.',
++ 	)
++ );
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/sitesplat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/sitesplat.php"
++index 6512c4cee..0f20ce516 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/sitesplat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/sitesplat.php"
++@@ -1,98 +1,8 @@
++ <?php
++-
++ /**
++  * Code available to all SiteSplat extensions
++- * @copyright (c) 2023 SiteSplat All rights reserved
+++ * @copyright (c) 2021 SiteSplat All rights reserved
++  * @license Proprietary
++  */
++-
++ namespace sitesplat;
++-
++-function dl_params($dlfile, $url)
++-{
++-	return [CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_HEADER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => 'SiteSplatBot', CURLOPT_POST => true, CURLOPT_POSTFIELDS => "bbfile={$dlfile}", CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false,];
++-}
++-function emoji_convert($text)
++-{
++-	return empty($text) ? '' : mb_encode_numericentity($text, [0x10000, 0x1ffff, 0, 0xfffff], 'UTF-8', true);
++-}
++-function add_filter($event, $hook, $priority = 20)
++-{
++-	$is_ss = false;
++-	$priority = (int) $priority;
++-	if (empty($hook)) {
++-		return false;
++-	}
++-	if (is_array($hook)) {
++-		$is_ss = strpos(get_class($hook[0]), 'sitesplat\\') === 0;
++-	}
++-	if ($priority < 1 || (!$is_ss && $priority < 10)) {
++-		$priority = 10;
++-	} else if ($priority > 100 || (!$is_ss && $priority > 90)) {
++-		$priority = 90;
++-	}
++-	addon::$events[$event][$priority][] = $hook;
++-	return true;
++-}
++-function apply_filters($event, $args)
++-{
++-	if (!isset(addon::$events[$event])) {
++-		return $args;
++-	}
++-	$hooks = addon::$events[$event];
++-	krsort($hooks);
++-	foreach ($hooks as $priority) {
++-		foreach ($priority as $hook) {
++-			$args = call_user_func($hook, $args);
++-		}
++-	}
++-	unset(addon::$events[$event]);
++-	return $args;
++-}
++-function load_ext_addons($ext)
++-{
++-	$s = DIRECTORY_SEPARATOR;
++-	if (!defined('PHPBB_ROOT_DIR')) {
++-		define('PHPBB_ROOT_DIR', strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}", true));
++-	}
++-	if (!empty(addon::$addons[$ext])) {
++-		foreach (addon::$addons[$ext] as $name => $vendor) {
++-			if ($name != 'ajax') {
++-				$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}{$ext}.php";
++-				if (file_exists($filename)) {
++-					include($filename);
++-					$cname = $vendor . '\\' . $name . '\\' . $ext;
++-					new $cname;
++-				}
++-			}
++-		}
++-	}
++-}
++-function load_ext_lang($path, &$addon_lang)
++-{
++-	if (empty(addon::$addons)) {
++-		return;
++-	}
++-	$s = DIRECTORY_SEPARATOR;
++-	$lang = substr(strrchr($path, $s), 1);
++-	foreach (addon::$addons as $data) {
++-		foreach ($data as $name => $vendor) {
++-			if ($name != 'ajax') {
++-				$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}{$lang}{$s}{$name}.php";
++-				if (!file_exists($filename)) {
++-					$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}en{$s}{$name}.php";
++-				}
++-				if (file_exists($filename)) {
++-					include($filename);
++-				}
++-			}
++-		}
++-	}
++-}
++-final class addon
++-{
++-	private function __construct() {}
++-	public static $data = [];
++-	public static $addons = [];
++-	public static $events = [];
++-}
+++function dl_params($dlfile, $url) { return [ CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_HEADER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => 'SiteSplatBot', CURLOPT_POST => true, CURLOPT_POSTFIELDS => "bbfile={$dlfile}", CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, ]; } function emoji_convert($text) { return (!$text) ? '' : preg_replace_callback('/([\x{1f000}-\x{1ffff}])/u', function($matches) { return strtolower('&#x' . dechex(substr(mb_convert_encoding($matches[1], 'HTML-ENTITIES', 'UTF-8'), 2, -1)) . ';'); }, $text); } function add_filter($event, $hook, $priority = 20) { $is_ss = false; $priority = (int) $priority; if (empty($hook)) { return false; } if (is_array($hook)) { $is_ss = strpos(get_class($hook[0]), 'sitesplat\\') === 0; } if ($priority < 1 || (!$is_ss && $priority < 10)) { $priority = 10; } else if ($priority > 100 || (!$is_ss && $priority > 90)) { $priority = 90; } addon::$events[$event][$priority][] = $hook; return true; } function apply_filters($event, $args) { if (!isset(addon::$events[$event])) { return $args; } $hooks = addon::$events[$event]; krsort($hooks); foreach ($hooks as $priority) { foreach ($priority as $hook) { $args = call_user_func($hook, $args); } } unset(addon::$events[$event]); return $args; } function load_ext_addons($ext) { $s = DIRECTORY_SEPARATOR; if (!defined('PHPBB_ROOT_DIR')) { define('PHPBB_ROOT_DIR', strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}", true)); } if (!empty(addon::$addons[$ext])) { foreach (addon::$addons[$ext] as $name => $vendor) { if ($name != 'ajax') { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}{$ext}.php"; if (file_exists($filename)) { include($filename); $cname = $vendor . '\\' . $name . '\\' . $ext; new $cname; } } } } } function load_ext_lang($path, &$addon_lang) { if (empty(addon::$addons)) { return; } $s = DIRECTORY_SEPARATOR; $lang = substr(strrchr($path, $s), 1); foreach(addon::$addons as $data) { foreach ($data as $name => $vendor) { if ($name != 'ajax') { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}{$lang}{$s}{$name}.php"; if (!file_exists($filename)) { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}en{$s}{$name}.php"; } if (file_exists($filename)) { include($filename); } } } } } class addon { public static $data = []; public static $addons = []; public static $events = []; }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
++index 62d834f56..8e6650361 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
++@@ -3,23 +3,17 @@
++ <head>
++ <meta charset="utf-8">
++ <meta name="viewport" content="width=device-width, initial-scale=1.0">
++-<meta name="designer" content="SiteSplat https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat">
+++<meta name="designer" content="Leinad4Mind & Sitesplat">
++ <meta content="{SITENAME}" property="og:site_name">
++-<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
++-
++ <title>{SITENAME} {PAGE_TITLE}</title>
++-
++-<!-- phpBB Premium style name: FLATBOOTS @SiteSplat.com -->
++-
++ <!-- Google free font here -->
++ <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet'>
++ <link href='//fonts.googleapis.com/css?family=Asap+Condensed:600' rel='stylesheet'>
++ 
++ <!-- CSS files start here-->
++-
++-<link href="{T_STYLESHEET_LINK}" rel="stylesheet">
++-<link href="{T_STYLESHEET_OFFLINE}" rel="stylesheet">
++-<link href="{T_STYLESHEET_ANIMATE}" rel="stylesheet">
+++<link href="{T_STYLESHEET_LINK}?assets_version=3.3" rel="stylesheet">
+++<link href="{T_STYLESHEET_OFFLINE}?assets_version=3.3" rel="stylesheet">
+++<link href="{T_STYLESHEET_ANIMATE}?assets_version=3.3" rel="stylesheet">
++ <!-- CSS files -->
++ </head>
++ 
++@@ -30,15 +24,14 @@
++ 	 <div class="container">
++ 		<div class="content-a">
++             <div class="content-b">
++-              <h1 class="wow fadeInDown">{L_BOARD_DISABLED}</h1>
++-              <h2 class="wow fadeInUp" data-wow-delay="0.5s">{ACP_DISABLE_MESSAGE}</h2>
+++              <!-- <h1 class="wow fadeInDown">{L_BOARD_DISABLED}</h1> -->
+++              <h2 class="wow fadeInUp goldenstar" data-wow-delay="0.5s">{ACP_DISABLE_MESSAGE}</h2>
++                 <div class="wow bounceIn clearfix socialbar" data-wow-delay="1.2s">
++ 					<div class="social-network">
++-						<a class="github-color" title="Github" href="#2"><i class="fa fa-github"></i></a>
++-						<a class="pinterest-color" title="Pinterest" href="#5"><i class="fa fa-pinterest"></i></a> 
++-						<a class="facebook-color" title="Facebook" href="#6"><i class="fa fa-facebook"></i></a>
++-						<a class="twitter-color" title="Twitter" href="https://twitter.com/SiteSplat"><i class="fa fa-twitter"></i></a>
++-						<a class="google-plus-color" title="YouTube" href="#8"><i class="fa fa-youtube"></i></a>
+++						<a class="youtube-color" title="YouTube" href="https://www.youtube.com/user/GoldTugAnimeOFICIAL"><i class="fa fa-youtube"></i></a>
+++						<a class="facebook-color" title="Facebook" href="https://www.facebook.com/goldtuganimeoficial"><i class="fa fa-facebook"></i></a>
+++						<a class="twitter-color" title="Twitter" href="https://twitter.com/GoldTugAnime"><i class="fa fa-twitter"></i></a>
+++						<a class="instagram-color" title="Instagram" href="https://www.instagram.com/goldtuganime"><i class="fa fa-instagram"></i></a>
++ 						<a class="github-color" title="{L_LOGIN_LOGOUT}" href="{U_LOGIN_LOGOUT}"><i class="fa fa-gear"></i></a>
++ 					</div>
++ 				</div>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png"
++new file mode 100644
++index 000000000..f99153c3f
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png" differ
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
++index b45ab4084..94d67f300 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
++@@ -1,225 +1 @@
++-.flat-header {
++-    color: #fafafa;
++-    font-size: 20px;
++-    height: 172px;
++-    margin-bottom: 20px;
++-    overflow: hidden;
++-    position: relative;
++-    text-align: left;
++-    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
++-    width: 100%;
++-}
++-.masthead:before {
++-  position: absolute;
++-  z-index: 1;
++-  top: 0;
++-  left: 0;
++-  width: 200%;
++-  height: 400%;
++-  content: "";
++-  background: url("./images/tile-bg-head.png") 0 0 #26bcb5;
++-  background-repeat: repeat;
++-}
++-.masthead {
++-  position: relative;
++-  height: 100%;
++-  width: 100%;
++-  -webkit-animation-name: sideupscroll;
++-          animation-name: sideupscroll;
++-  -webkit-animation-duration: 70s;
++-          animation-duration: 70s;
++-  -webkit-animation-timing-function: linear;
++-          animation-timing-function: linear;
++-  -webkit-animation-iteration-count: infinite;
++-          animation-iteration-count: infinite;
++-  -webkit-animation-fill-mode: both;
++-          animation-fill-mode: both;
++-}
++-@-webkit-keyframes sideupscroll {
++-  0% {
++-    -webkit-transform: translateX(0%) translateY(0%);
++-            transform: translateX(0%) translateY(0%);
++-  }
++-  50% {
++-    -webkit-transform: translateX(-50%) translateY(-100%);
++-            transform: translateX(-50%) translateY(-100%);
++-  }
++-  100% {
++-    -webkit-transform: translateX(-100%) translateY(-200%);
++-            transform: translateX(-100%) translateY(-200%);
++-  }
++-}
++-@keyframes sideupscroll {
++-  0% {
++-    -webkit-transform: translateX(0%) translateY(0%);
++-            transform: translateX(0%) translateY(0%);
++-  }
++-  50% {
++-    -webkit-transform: translateX(-50%) translateY(-100%);
++-            transform: translateX(-50%) translateY(-100%);
++-  }
++-  100% {
++-    -webkit-transform: translateX(-100%) translateY(-200%);
++-            transform: translateX(-100%) translateY(-200%);
++-  }
++-}
++-
++-.wrapper-head {
++-    margin-top: -35%;
++-    position: relative;
++-    z-index: 2;
++-}
++-
++-
++-@media (min-width: 769px) and (max-width: 1100px) {
++-
++-	.wrapper-head {
++-    margin-top: -50%;
++-    }
++-	
++-	.wrapper-head h1, .wrapper-head h2 {
++-    font-size: 22px;
++-    }
++-}	
++-
++-
++-@media (min-width: 469px) and (max-width: 768px) {
++-
++-	.wrapper-head {
++-    top: -30%;
++-    }
++-	
++-	.wrapper-head h1, .wrapper-head h2 {
++-    font-size: 22px;
++-    }
++-}	
++-
++-@media (max-width: 468px) {
++-    body {
++-        font-size: 15px;
++-    }
++-
++-	.wrapper-head {
++-    margin-top: -120%;
++-    }
++-	
++-	.wrapper-head h1, .wrapper-head h2 {
++-    font-size: 22px;
++-    }
++-
++-    .flat-header {
++-    font-size: 14px;
++-    }
++-}	
++-
++-
++-/* background setup */
++-.background {
++-    background-repeat:no-repeat;
++-    /* custom background-position */
++-    background-position:50% 50%;
++-    /* ie8- graceful degradation */
++-    background-position:50% 50%\9 !important;
++-}
++-
++-/* fullscreen setup */
++-html, body {
++-    /* give this to all tags from html to .fullscreen */
++-    height:100%;
++-}
++-.fullscreen,
++-.content-a {
++-    width:100%;
++-    min-height:100%;
++-}
++-.not-fullscreen,
++-.not-fullscreen .content-a,
++-.fullscreen.not-overflow,
++-.fullscreen.not-overflow .content-a {
++-    height:100%;
++-    overflow:hidden;
++-}
++-
++-/* content centering styles */
++-.content-a {
++-	display:table;
++-}
++-.content-b {
++-	display:table-cell;
++-    position:relative;
++-	vertical-align:middle;
++-	text-align:center;
++-	z-index: 1;
++-}
++-
++-/* visual styles */
++-body{
++-    margin:0;
++-    font-size:28px;
++-    line-height:100px;
++-	color:#ffffff;
++-    text-align:center;
++-}
++-section {
++-	background:#9ed100;
++-}
++-.not-fullscreen {
++-    height:50%;
++-}
++-
++-h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
++-    color: #fff !important;
++-    font-family: "Asap","Arial","Helvetica",sans-serif;
++-    font-weight: 700;
++-    line-height: normal;
++-    margin: 0 0 10px;
++-    text-rendering: optimizelegibility;
++-}
++-.social-network {
++-    text-align: center;
++-}
++-.social-network a {
++-    border-radius: 2px;
++-    color: #fff !important;
++-    display: inline-block;
++-    font-size: 20px;
++-    height: 30px;
++-    margin: 0 3px;
++-    transition: all 0.2s linear 0s;
++-    width: 30px;
++-	line-height: 30px;
++-}
++-
++-
++-.google-plus-color {
++-    background-color: #d34836;
++-}
++-.github-color {
++-    background-color: #333;
++-}
++-.facebook-color {
++-    background-color: #3b5998;
++-}
++-.twitter-color {
++-    background-color: #00aced;
++-}
++-.pinterest-color {
++-    background-color: #cb2027;
++-}
++-.github-color {
++-    background-color: #333;
++-}
++-
++-.social-network a:hover {
++-    transition: all .1s linear 0s;
++-    color: #2d2d2d!important;
++-    border-bottom: none;
++-    background-color: #fff;
++-	outline: none;
++-    text-decoration: none;
++-}
++-
++-.social-network a:focus {
++-    outline: none;
++-    text-decoration: none;
++-}
+++.flat-header{color:#fafafa;font-size:20px;height:172px;margin-bottom:20px;overflow:hidden;position:relative;text-align:left;text-shadow:0 1px 0 rgba(0,0,0,0.1);width:100%}.masthead:before{position:absolute;z-index:1;top:0;left:0;width:200%;height:400%;content:"";background:url(./images/gta_back.png) 0 0 #26bcb5;background-repeat:repeat}.masthead{position:relative;height:100%;width:100%;-webkit-animation-name:sideupscroll;animation-name:sideupscroll;-webkit-animation-duration:70s;animation-duration:70s;-webkit-animation-timing-function:linear;animation-timing-function:linear;-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes sideupscroll{0%{-webkit-transform:translateX(0%) translateY(0%);transform:translateX(0%) translateY(0%)}50%{-webkit-transform:translateX(-50%) translateY(-100%);transform:translateX(-50%) translateY(-100%)}100%{-webkit-transform:translateX(-100%) translateY(-200%);transform:translateX(-100%) translateY(-200%)}}@keyframes sideupscroll{0%{-webkit-transform:translateX(0%) translateY(0%);transform:translateX(0%) translateY(0%)}50%{-webkit-transform:translateX(-50%) translateY(-100%);transform:translateX(-50%) translateY(-100%)}100%{-webkit-transform:translateX(-100%) translateY(-200%);transform:translateX(-100%) translateY(-200%)}}.wrapper-head{margin-top:-35%;position:relative;z-index:2}@media (min-width: 769px) and (max-width: 1100px){.wrapper-head{margin-top:-50%}.wrapper-head h1,.wrapper-head h2{font-size:22px}}@media (min-width: 469px) and (max-width: 768px){.wrapper-head{top:-30%}.wrapper-head h1,.wrapper-head h2{font-size:22px}}@media (max-width: 468px){body{font-size:15px}.wrapper-head{margin-top:-120%}.wrapper-head h1,.wrapper-head h2{font-size:22px}.flat-header{font-size:14px}}.background{background-repeat:no-repeat;background-position:50% 50%;background-position:50% 50%\9!important}html,body{height:100%}.fullscreen,.content-a{width:100%;min-height:100%}.not-fullscreen,.not-fullscreen .content-a,.fullscreen.not-overflow,.fullscreen.not-overflow .content-a{height:100%;overflow:hidden}.content-a{display:table}.content-b{display:table-cell;position:relative;vertical-align:middle;text-align:center;z-index:1}body{margin:0;font-size:28px;line-height:100px;color:#fff;text-align:center}section{background:#9ed100}.not-fullscreen{height:50%}h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#fff!important;font-family:"Asap","Arial","Helvetica",sans-serif;font-weight:700;line-height:normal;margin:0 0 10px;text-rendering:optimizelegibility}.social-network{text-align:center}.social-network a{border-radius:2px;color:#fff!important;display:inline-block;font-size:20px;height:30px;margin:0 3px;transition:all .2s linear 0;width:30px;line-height:30px}.google-plus-color{background-color:#d34836}.github-color{background-color:#333}.facebook-color{background-color:#3b5998}.twitter-color{background-color:#00aced}.pinterest-color{background-color:#cb2027}.github-color{background-color:#333}.social-network a:hover{transition:all .1s linear 0;color:#2d2d2d!important;border-bottom:none;background-color:#fff;outline:none;text-decoration:none}.social-network a:focus{outline:none;text-decoration:none}.instagram-color{background-color:#5851db}.youtube-color{background-color:red}.goldenstar{width:50vw;margin:auto}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/next_step_resolver.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/next_step_resolver.php"
++index f691bb5d2..d2966ec49 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/next_step_resolver.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/next_step_resolver.php"
++@@ -1,141 +1,11 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2015 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2015 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ 
++ namespace sitesplat\BBCore\updater;
++-
++-class next_step_resolver
++-{
++-	protected $config_text;
++-	protected $filesystem;
++-	protected $container;
++-	protected $root_path;
++-	protected $real_root_path;
++-	protected $old_handler;
++-	protected $phperror = '';
++-	protected $start_time;
++-	protected $max_execution_time;
++-	protected $memory_limit;
++-	public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path)
++-	{
++-		$this->config_text = $config_text;
++-		$this->filesystem = $filesystem;
++-		$this->container = $container;
++-		$this->root_path = $root_path;
++-		$this->real_root_path = realpath($root_path) . '/';
++-		$this->start_time = microtime(true);
++-		$execution_time = $php_ini->getNumeric('max_execution_time');
++-		$this->max_execution_time = min(15, $execution_time / 2);
++-		$this->memory_limit = $php_ini->getBytes('memory_limit');
++-	}
++-	public function msg_handler($errno, $msg_text, $errfile, $errline)
++-	{
++-		if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) {
++-			$errfile = phpbb_filter_root_path($errfile);
++-			$msg_text = phpbb_filter_root_path($msg_text);
++-			$error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice';
++-			$this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n";
++-			return true;
++-		} else if (!empty($this->old_handler)) {
++-			return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]);
++-		}
++-		return false;
++-	}
++-	public function run_task($fs, $style_name)
++-	{
++-		$this->old_handler = set_error_handler([$this, 'msg_handler']);
++-		$updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true);
++-		if (empty($updater_config['last_step'])) {
++-			$updater_config['last_step'] = '';
++-			$updater_config['merge_conflicts'] = false;
++-			$this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name);
++-		}
++-		try {
++-			while ($this->has_enought_time() && $this->has_enough_memory()) {
++-				switch ($updater_config['last_step']) {
++-					case '':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't0_backup':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't1_get_current_style_cfg':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't2_get_newest_style_cfg':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't3_check_problems':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't4_download_newest_version':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't5_unzip_new_version':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't6_load_list_of_changes':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't7_merge_edits':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't8_check_additions':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't9_update_edits':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't10_update_added':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't11_update_deleted':
++-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config);
++-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
++-						break;
++-					case 't12_log_changes':
++-						$this->config_text->set('sitesplat_bbcore_updater', '');
++-						return true;
++-						break;
++-				}
++-				return $this->phperror ?: false;
++-			}
++-		} catch (\Exception $e) {
++-			$this->config_text->set('sitesplat_bbcore_updater', '');
++-			return $e->getMessage();
++-		}
++-		return false;
++-	}
++-	protected function has_enought_time()
++-	{
++-		return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0;
++-	}
++-	protected function has_enough_memory()
++-	{
++-		if ($this->memory_limit <= 0) {
++-			return true;
++-		}
++-		if (function_exists('memory_get_usage')) {
++-			return ($this->memory_limit - memory_get_usage()) > 0;
++-		}
++-		return true;
++-	}
++-}
+++class next_step_resolver { protected $config_text; protected $filesystem; protected $container; protected $root_path; protected $real_root_path; protected $old_handler; protected $phperror = ''; protected $start_time; protected $max_execution_time; protected $memory_limit; public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path) { $this->config_text = $config_text; $this->filesystem = $filesystem; $this->container = $container; $this->root_path = $root_path; $this->real_root_path = realpath($root_path) . '/'; $this->start_time = microtime(true); $execution_time = $php_ini->getNumeric('max_execution_time'); $this->max_execution_time = min(15, $execution_time / 2); $this->memory_limit = $php_ini->getBytes('memory_limit'); } public function msg_handler($errno, $msg_text, $errfile, $errline) { if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) { $errfile = phpbb_filter_root_path($errfile); $msg_text = phpbb_filter_root_path($msg_text); $error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice'; $this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n"; return true; } else if (!empty($this->old_handler)) { return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]); } return false; } public function run_task($fs, $style_name) { $this->old_handler = set_error_handler([$this, 'msg_handler']); $updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true); if (empty($updater_config['last_step'])) { $updater_config['last_step'] = ''; $updater_config['merge_conflicts'] = false; $this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name); } try { while($this->has_enought_time() && $this->has_enough_memory()) { switch ($updater_config['last_step']) { case '': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't0_backup': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't1_get_current_style_cfg': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't2_get_newest_style_cfg': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't3_check_problems': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't4_download_newest_version': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't5_unzip_new_version': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't6_load_list_of_changes': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't7_merge_edits': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't8_check_additions': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't9_update_edits': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't10_update_added': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't11_update_deleted': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't12_log_changes': $this->config_text->set('sitesplat_bbcore_updater', ''); return true; break; } return $this->phperror ?: false; } } catch (\Exception $e) { $this->config_text->set('sitesplat_bbcore_updater', ''); return $e->getMessage(); } return false; } protected function has_enought_time() { return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0; } protected function has_enough_memory() { if ($this->memory_limit <= 0) { return true; } if (function_exists('memory_get_usage')) { return ($this->memory_limit - memory_get_usage()) > 0; } return true; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t0_backup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t0_backup.php"
++index 3faf5747e..aaf2ec672 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t0_backup.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t0_backup.php"
++@@ -1,31 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t0_backup
++-{
++-	protected $filesystem;
++-	protected $root_path;
++-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
++-	{
++-		$this->filesystem = $filesystem;
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path)
++-	{
++-		$this->root_path = $root_path;
++-		$backup_dir = $this->root_path . 'store/' . $style_name . '_' . time();
++-		$this->filesystem->mkdir($backup_dir);
++-		$this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir);
++-		$updater_config['last_step'] = 't0_backup';
++-		return $updater_config;
++-	}
++-}
+++class t0_backup { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $backup_dir = $this->root_path . 'store/' . $style_name . '_' . time(); $this->filesystem->mkdir($backup_dir); $this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir); $updater_config['last_step'] = 't0_backup'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t10_update_added.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t10_update_added.php"
++index bed0aa7a3..6ae56fa28 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t10_update_added.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t10_update_added.php"
++@@ -1,39 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t10_update_added
++-{
++-	protected $root_path;
++-	public function __construct($root_path)
++-	{
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path, $fs)
++-	{
++-		$this->root_path = $root_path;
++-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
++-		if (!empty($updater_config['update_info']['added_dirs'])) {
++-			foreach ($updater_config['update_info']['added_dirs'] as $file_path) {
++-				$fs->mkdir($current_files_path . $file_path);
++-			}
++-			unset($updater_config['update_info']['added_dirs']);
++-		}
++-		if (!empty($updater_config['update_info']['added'])) {
++-			foreach ($updater_config['update_info']['added'] as $file_path) {
++-				$fs->put($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path), true);
++-			}
++-			unset($updater_config['update_info']['added']);
++-		}
++-		$updater_config['last_step'] = 't10_update_added';
++-		return $updater_config;
++-	}
++-}
+++class t10_update_added { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['added_dirs'])) { foreach ($updater_config['update_info']['added_dirs'] as $file_path) { $fs->mkdir($current_files_path . $file_path); } unset($updater_config['update_info']['added_dirs']); } if (!empty($updater_config['update_info']['added'])) { foreach ($updater_config['update_info']['added'] as $file_path) { $fs->put($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path), true); } unset($updater_config['update_info']['added']); } $updater_config['last_step'] = 't10_update_added'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php"
++index 434fae143..28d1b1ae2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t11_update_deleted.php"
++@@ -1,41 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t11_update_deleted
++-{
++-	protected $filesystem;
++-	protected $root_path;
++-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
++-	{
++-		$this->filesystem = $filesystem;
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path, $fs)
++-	{
++-		$this->root_path = $root_path;
++-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
++-		if (!empty($updater_config['update_info']['deleted'])) {
++-			foreach ($updater_config['update_info']['deleted'] as $file_path) {
++-				$fs->delete($current_files_path . $file_path);
++-			}
++-			unset($updater_config['update_info']['deleted']);
++-		}
++-		if (!empty($updater_config['update_info']['deleted_dirs'])) {
++-			foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) {
++-				$fs->rmdir($current_files_path . $file_path);
++-			}
++-			unset($updater_config['update_info']['deleted_dirs']);
++-		}
++-		$updater_config['last_step'] = 't11_update_deleted';
++-		return $updater_config;
++-	}
++-}
+++class t11_update_deleted { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['deleted'])) { foreach ($updater_config['update_info']['deleted'] as $file_path) { $fs->delete($current_files_path . $file_path); } unset($updater_config['update_info']['deleted']); } if (!empty($updater_config['update_info']['deleted_dirs'])) { foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) { $fs->rmdir($current_files_path . $file_path); } unset($updater_config['update_info']['deleted_dirs']); } $updater_config['last_step'] = 't11_update_deleted'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php"
++index cdba04783..753424d59 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t12_log_changes.php"
++@@ -1,28 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t12_log_changes
++-{
++-	protected $log;
++-	protected $user;
++-	public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user)
++-	{
++-		$this->log = $log;
++-		$this->user = $user;
++-	}
++-	public function run($style_name, $updater_config)
++-	{
++-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [$style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-',]);
++-		$updater_config['last_step'] = 't12_log_changes';
++-		return $updater_config;
++-	}
++-}
+++class t12_log_changes { protected $log; protected $user; public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user) { $this->log = $log; $this->user = $user; } public function run($style_name, $updater_config) { $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [ $style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-', ]); $updater_config['last_step'] = 't12_log_changes'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
++index 609752f70..9b3f8636b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
++@@ -1,27 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t1_get_current_style_cfg
++-{
++-	protected $root_path;
++-	public function __construct($root_path)
++-	{
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path)
++-	{
++-		$this->root_path = $root_path;
++-		$updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg');
++-		$updater_config['last_step'] = 't1_get_current_style_cfg';
++-		return $updater_config;
++-	}
++-}
+++class t1_get_current_style_cfg { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg'); $updater_config['last_step'] = 't1_get_current_style_cfg'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
++index b6be1a7ae..73bb1b57b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
++@@ -1,31 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t2_get_newest_style_cfg
++-{
++-	protected $file_downloader;
++-	protected $host;
++-	protected $versioncheck_path;
++-	public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path)
++-	{
++-		$this->file_downloader = $file_downloader;
++-		$this->host = $host;
++-		$this->versioncheck_path = $versioncheck_path;
++-	}
++-	public function run($style_name, $updater_config)
++-	{
++-		$info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name, 443);
++-		$updater_config['style_data'] = json_decode($info, true);
++-		$updater_config['last_step'] = 't2_get_newest_style_cfg';
++-		return $updater_config;
++-	}
++-}
+++class t2_get_newest_style_cfg { protected $file_downloader; protected $host; protected $versioncheck_path; public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path) { $this->file_downloader = $file_downloader; $this->host = $host; $this->versioncheck_path = $versioncheck_path; } public function run($style_name, $updater_config) { $info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name, 443); $updater_config['style_data'] = json_decode($info, true); $updater_config['last_step'] = 't2_get_newest_style_cfg'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php"
++index 8dd5da47e..46065129f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t3_check_problems.php"
++@@ -1,26 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t3_check_problems
++-{
++-	public function run($style_name, $updater_config)
++-	{
++-		if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>=')) {
++-			throw new \Exception('ALREADY_UP_TO_DATE');
++-		}
++-		if (empty($updater_config['style_data']['direct_download_dir'])) {
++-			throw new \Exception('NO_DIRECT_DOWNLOAD');
++-		}
++-		$updater_config['last_step'] = 't3_check_problems';
++-		return $updater_config;
++-	}
++-}
+++class t3_check_problems { public function run($style_name, $updater_config) { if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>=')) { throw new \Exception('ALREADY_UP_TO_DATE'); } if (empty($updater_config['style_data']['direct_download_dir'])) { throw new \Exception('NO_DIRECT_DOWNLOAD'); } $updater_config['last_step'] = 't3_check_problems'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
++index 08c0a63d5..446188ba0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
++@@ -1,57 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t4_download_newest_version
++-{
++-	protected $file_downloader;
++-	protected $filesystem;
++-	protected $host;
++-	protected $download_path;
++-	protected $root_path;
++-	public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path)
++-	{
++-		$this->file_downloader = $file_downloader;
++-		$this->filesystem = $filesystem;
++-		$this->host = $host;
++-		$this->download_path = $download_path;
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path)
++-	{
++-		$this->root_path = $root_path;
++-		$ch = curl_init();
++-		curl_setopt($ch, CURLOPT_URL, "https://{$this->host}/{$this->download_path}{$updater_config['style_data']['direct_download_dir']}/{$updater_config['cfg_data']['style_version']}_to_{$updater_config['style_data']['version']}.zip");
++-		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
++-		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
++-		curl_setopt($ch, CURLOPT_USERAGENT, 'sitesplat_updater');
++-		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
++-		curl_setopt($ch, CURLOPT_POST, true);
++-		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
++-		$zip = curl_exec($ch);
++-		if (curl_errno($ch)) {
++-			throw new \Exception(curl_error($ch));
++-		}
++-		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
++-		curl_close($ch);
++-		if ($http != 200 || empty($zip)) {
++-			throw new \Exception('PROBLEM_DOWNLOADING_UPDATE');
++-		}
++-		$tmp_path = $this->root_path . 'store/';
++-		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
++-		if (file_exists($tmp_file)) {
++-			$this->filesystem->remove($tmp_file);
++-		}
++-		file_put_contents($tmp_file, $zip);
++-		$updater_config['last_step'] = 't4_download_newest_version';
++-		return $updater_config;
++-	}
++-}
+++class t4_download_newest_version { protected $file_downloader; protected $filesystem; protected $host; protected $download_path; protected $root_path; public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path) { $this->file_downloader = $file_downloader; $this->filesystem = $filesystem; $this->host = $host; $this->download_path = $download_path; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, "https://{$this->host}/{$this->download_path}{$updater_config['style_data']['direct_download_dir']}/{$updater_config['cfg_data']['style_version']}_to_{$updater_config['style_data']['version']}.zip"); curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($ch, CURLOPT_USERAGENT, 'sitesplat_updater'); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_POSTFIELDS, ""); $zip = curl_exec($ch); if (curl_errno($ch)) { throw new \Exception(curl_error($ch)); } $http = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch); if ($http != 200 || empty($zip)) { throw new \Exception('PROBLEM_DOWNLOADING_UPDATE'); } $tmp_path = $this->root_path . 'store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; if (file_exists($tmp_file)) { $this->filesystem->remove($tmp_file); } file_put_contents($tmp_file, $zip); $updater_config['last_step'] = 't4_download_newest_version'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
++index 0fc537cf7..d49aaf9d8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
++@@ -1,42 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t5_unzip_new_version
++-{
++-	protected $filesystem;
++-	protected $root_path;
++-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
++-	{
++-		$this->filesystem = $filesystem;
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path, $fs)
++-	{
++-		$tmp_path = $fs->phpbb_root_dir . '/store/';
++-		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
++-		$updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/';
++-		$fs_type = $fs->fs_type;
++-		$fs->fs_type = 'direct';
++-		if (file_exists($updater_config['tmp_dir'])) {
++-			$this->filesystem->remove($updater_config['tmp_dir']);
++-		}
++-		$this->filesystem->mkdir($updater_config['tmp_dir']);
++-		$result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']);
++-		if ($result === false) {
++-			throw new \Exception($fs->ftp_error);
++-		}
++-		$this->filesystem->remove($tmp_file);
++-		$fs->fs_type = $fs_type;
++-		$updater_config['last_step'] = 't5_unzip_new_version';
++-		return $updater_config;
++-	}
++-}
+++class t5_unzip_new_version { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $tmp_path = $fs->phpbb_root_dir . '/store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; $updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/'; $fs_type = $fs->fs_type; $fs->fs_type = 'direct'; if (file_exists($updater_config['tmp_dir'])) { $this->filesystem->remove($updater_config['tmp_dir']); } $this->filesystem->mkdir($updater_config['tmp_dir']); $result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']); if ($result === false) { throw new \Exception($fs->ftp_error); } $this->filesystem->remove($tmp_file); $fs->fs_type = $fs_type; $updater_config['last_step'] = 't5_unzip_new_version'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
++index a07f005bf..83e6e814d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
++@@ -1,29 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t6_load_list_of_changes
++-{
++-	protected $root_path;
++-	protected $php_ext;
++-	public function __construct($root_path, $php_ext)
++-	{
++-		$this->root_path = $root_path;
++-		$this->php_ext = $php_ext;
++-	}
++-	public function run($style_name, $updater_config)
++-	{
++-		include($updater_config['tmp_dir'] . 'index.' . $this->php_ext);
++-		$updater_config['update_info'] = $updater_config['log_data'] = $update_info;
++-		$updater_config['last_step'] = 't6_load_list_of_changes';
++-		return $updater_config;
++-	}
++-}
+++class t6_load_list_of_changes { protected $root_path; protected $php_ext; public function __construct($root_path, $php_ext) { $this->root_path = $root_path; $this->php_ext = $php_ext; } public function run($style_name, $updater_config) { include($updater_config['tmp_dir'] . 'index.' . $this->php_ext); $updater_config['update_info'] = $updater_config['log_data'] = $update_info; $updater_config['last_step'] = 't6_load_list_of_changes'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php"
++index c9e6107f2..0361e9dd7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t7_merge_edits.php"
++@@ -1,80 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t7_merge_edits
++-{
++-	protected $filesystem;
++-	protected $cache;
++-	protected $language;
++-	protected $root_path;
++-	protected $php_ext;
++-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, \phpbb\cache\driver\driver_interface $cache, \phpbb\language\language $language, $root_path, $php_ext)
++-	{
++-		$this->filesystem = $filesystem;
++-		$this->cache = $cache;
++-		$this->language = $language;
++-		$this->root_path = $root_path;
++-		$this->php_ext = $php_ext;
++-	}
++-	public function run($style_name, $updater_config, $root_path)
++-	{
++-		$this->root_path = $root_path;
++-		if (empty($updater_config['update_info']['edited'])) {
++-			if ($updater_config['merge_conflicts']) {
++-				throw new \Exception($this->language->lang('MERGE_CONFLICTS', 'store/merge_conflicts_' . $style_name));
++-			}
++-			$updater_config['last_step'] = 't7_merge_edits';
++-			return $updater_config;
++-		}
++-		if (empty($updater_config['merge_calculated'])) {
++-			$updater_config['merge_calculated'] = [];
++-		}
++-		if (!class_exists('diff3')) {
++-			include($this->root_path . 'includes/diff/diff.' . $this->php_ext);
++-		}
++-		if (!class_exists('diff_engine')) {
++-			include($this->root_path . 'includes/diff/engine.' . $this->php_ext);
++-		}
++-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
++-		$file_diffed = false;
++-		foreach ($updater_config['update_info']['edited'] as $key => $file_path) {
++-			if (in_array($file_path, $updater_config['merge_calculated'])) {
++-				continue;
++-			}
++-			$new_file_contents = @file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path);
++-			if (file_exists($current_files_path . $file_path)) {
++-				$file_contents[0] = @file_get_contents($updater_config['tmp_dir'] . 'old/' . $file_path);
++-				$file_contents[1] = @file_get_contents($current_files_path . $file_path);
++-				$file_contents[2] = $new_file_contents;
++-				$diff = new \diff3($file_contents[0], $file_contents[1], $file_contents[2]);
++-				if ($diff->get_num_conflicts() !== 0) {
++-					$updater_config['merge_conflicts'] = true;
++-					$merge_conflicts_path = $this->root_path . 'store/merge_conflicts_' . $style_name . '/';
++-					$this->filesystem->mkdir($merge_conflicts_path . dirname($file_path));
++-					file_put_contents($merge_conflicts_path . $file_path, implode("\n", $diff->merged_output()));
++-				}
++-				if ($diff->merged_output() !== $file_contents[1]) {
++-					$this->cache->put('_bbcore_updater_' . md5($file_path), implode("\n", $diff->merged_output()));
++-					$updater_config['merge_calculated'][] = $file_path;
++-				}
++-				unset($file_contents);
++-				unset($diff);
++-			} else {
++-				$this->cache->put('_bbcore_updater_' . md5($file_path), $new_file_contents);
++-				$updater_config['merge_calculated'][] = $file_path;
++-			}
++-			unset($updater_config['update_info']['edited'][$key]);
++-			break;
++-		}
++-		return $updater_config;
++-	}
++-}
+++class t7_merge_edits { protected $filesystem; protected $cache; protected $language; protected $root_path; protected $php_ext; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, \phpbb\cache\driver\driver_interface $cache, \phpbb\language\language $language, $root_path, $php_ext) { $this->filesystem = $filesystem; $this->cache = $cache; $this->language = $language; $this->root_path = $root_path; $this->php_ext = $php_ext; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; if (empty($updater_config['update_info']['edited'])) { if ($updater_config['merge_conflicts']) { throw new \Exception($this->language->lang('MERGE_CONFLICTS', 'store/merge_conflicts_' . $style_name)); } $updater_config['last_step'] = 't7_merge_edits'; return $updater_config; } if (empty($updater_config['merge_calculated'])) { $updater_config['merge_calculated'] = []; } if (!class_exists('diff3')) { include($this->root_path . 'includes/diff/diff.' . $this->php_ext); } if (!class_exists('diff_engine')) { include($this->root_path . 'includes/diff/engine.' . $this->php_ext); } $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; $file_diffed = false; foreach ($updater_config['update_info']['edited'] as $key => $file_path) { if (in_array($file_path, $updater_config['merge_calculated'])) { continue; } $new_file_contents = @file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path); if (file_exists($current_files_path . $file_path)) { $file_contents[0] = @file_get_contents($updater_config['tmp_dir'] . 'old/' . $file_path); $file_contents[1] = @file_get_contents($current_files_path . $file_path); $file_contents[2] = $new_file_contents; $diff = new \diff3($file_contents[0], $file_contents[1], $file_contents[2]); if ($diff->get_num_conflicts() !== 0) { $updater_config['merge_conflicts'] = true; $merge_conflicts_path = $this->root_path . 'store/merge_conflicts_' . $style_name . '/'; $this->filesystem->mkdir($merge_conflicts_path . dirname($file_path)); file_put_contents($merge_conflicts_path . $file_path, implode("\n", $diff->merged_output())); } if ($diff->merged_output() !== $file_contents[1]) { $this->cache->put('_bbcore_updater_' . md5($file_path), implode("\n", $diff->merged_output())); $updater_config['merge_calculated'][] = $file_path; } unset($file_contents); unset($diff); } else { $this->cache->put('_bbcore_updater_' . md5($file_path), $new_file_contents); $updater_config['merge_calculated'][] = $file_path; } unset($updater_config['update_info']['edited'][$key]); break; } return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php"
++index 1bdf59226..66b407bd6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t8_check_additions.php"
++@@ -1,27 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t8_check_additions
++-{
++-	protected $language;
++-	protected $root_path;
++-	public function __construct(\phpbb\language\language $language, $root_path)
++-	{
++-		$this->language = $language;
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path)
++-	{
++-		$updater_config['last_step'] = 't8_check_additions';
++-		return $updater_config;
++-	}
++-}
+++class t8_check_additions { protected $language; protected $root_path; public function __construct(\phpbb\language\language $language, $root_path) { $this->language = $language; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $updater_config['last_step'] = 't8_check_additions'; return $updater_config; } }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php"
++index 60cf5f9d2..0a800b8c5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/updater/task/t9_update_edits.php"
++@@ -1,39 +1,10 @@
++ <?php
++-
++ /**
++- *
++- * @package sitesplat BBcore
++- * @copyright (c) 2021 SiteSplat All rights reserved
++- * @license Proprietary
++- *
++- */
++-
+++*
+++* @package sitesplat BBcore
+++* @copyright (c) 2021 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
++ namespace sitesplat\BBCore\updater\task;
++-
++-class t9_update_edits
++-{
++-	protected $cache;
++-	protected $root_path;
++-	public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path)
++-	{
++-		$this->cache = $cache;
++-		$this->root_path = $root_path;
++-	}
++-	public function run($style_name, $updater_config, $root_path, $fs)
++-	{
++-		$this->root_path = $root_path;
++-		if (empty($updater_config['merge_calculated'])) {
++-			$updater_config['last_step'] = 't9_update_edits';
++-			return $updater_config;
++-		}
++-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
++-		foreach ($updater_config['merge_calculated'] as $key => $file_path) {
++-			$cache_name = '_bbcore_updater_' . md5($file_path);
++-			$fs->put($current_files_path . $file_path, $this->cache->get($cache_name), true);
++-			$this->cache->destroy($cache_name);
++-			unset($updater_config['merge_calculated'][$key]);
++-			break;
++-		}
++-		return $updater_config;
++-	}
++-}
+++class t9_update_edits { protected $cache; protected $root_path; public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path) { $this->cache = $cache; $this
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/event/admin_listener.php" "[FORUM_EXT]/sitesplat\\BBCore/event/admin_listener.php"
--- "[ORIGINAL]/sitesplat\\BBCore/event/admin_listener.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/event/admin_listener.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -12,103 +11,4 @@ namespace sitesplat\BBCore\event;
 
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 use Symfony\Component\Finder\Finder;
-
-class admin_listener implements EventSubscriberInterface
-{
-	protected $db;
-	protected $user;
-	protected $template;
-	protected $phpbb_extension_manager;
-	protected $cache;
-	protected $file_downloader;
-	protected $request;
-	protected $config;
-	protected $config_text;
-	protected $auth;
-	protected $fs;
-	protected $next_step_resolver;
-	protected $text_formatter_cache;
-	protected $phpbb_root_path;
-	protected $php_ext;
-	protected $host;
-	protected $path;
-	protected $writable = true;
-	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path)
-	{
-		$this->db = $db;
-		$this->user = $user;
-		$this->template = $template;
-		$this->extension_manager = $phpbb_extension_manager;
-		$this->cache = $cache;
-		$this->file_downloader = $file_downloader;
-		$this->request = $request;
-		$this->config = $config;
-		$this->config_text = $config_text;
-		$this->auth = $auth;
-		$this->fs = \sitesplat\fs_instance();
-		$this->next_step_resolver = $next_step_resolver;
-		$this->text_formatter_cache = $text_formatter_cache;
-		$this->root_path = $phpbb_root_path;
-		$this->php_ext = $php_ext;
-		$this->host = $host;
-		$this->path = $path;
-	}
-	static public function getSubscribedEvents()
-	{
-		$events = ['core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action',];
-		return $events;
-	}
-	public function version_check($event, $eventName)
-	{
-		$sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
-		$result = $this->db->sql_query($sql);
-		while ($row = $this->db->sql_fetchrow($result)) {
-			$cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg');
-			$data = $this->get_data($row['style_name']);
-			if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'], '<')) {
-				$this->template->assign_block_vars('sitesplat_themes', array('NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'],));
-			}
-		}
-	}
-	protected function get_data($what = '')
-	{
-		$cache_file = '_versioncheck_' . $this->host . $this->path . $what;
-		if (($info = $this->cache->get($cache_file)) === false) {
-			try {
-				$info = $this->file_downloader->get($this->host, $this->path, $what, 443);
-			} catch (\phpbb\exception\runtime_exception $exception) {
-				$info = '';
-			}
-			$info = json_decode($info, true);
-			if (!empty($info)) {
-				$json_sanitizer = function (&$value, $key) {
-					$type_cast_helper = new \phpbb\request\type_cast_helper();
-					$type_cast_helper->set_var($value, $value, gettype($value), true);
-				};
-				array_walk_recursive($info, $json_sanitizer);
-				$this->cache->put($cache_file, $info, 86400);
-			}
-		}
-		return $info;
-	}
-	public function run_action($event)
-	{
-		global $phpbb_dispatcher;
-		$this->template->assign_vars(array('DISABLE_ALL' => $event['u_action'] . '&action=disable-all',));
-		if ($event['action'] == 'disable-all') {
-			$safe_time_limit = (ini_get('max_execution_time') / 2);
-			$start_time = time();
-			$enabled_extensions = $this->extension_manager->all_enabled();
-			unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']);
-			extract($phpbb_dispatcher->trigger_event('sitesplat.bbcore_ext_list', compact('enabled_extensions')));
-			foreach ($enabled_extensions as $ext_name => $value) {
-				while ($this->extension_manager->disable_step($ext_name)) {
-					if ((time() - $start_time) >= $safe_time_limit) {
-						meta_refresh(0, $event['u_action'] . '&amp;action=disable-all');
-					}
-				}
-			}
-			trigger_error($this->user->lang('CONFIG_UPDATED') . adm_back_link($event['u_action']));
-		}
-	}
-}
+class admin_listener implements EventSubscriberInterface { protected $db; protected $user; protected $template; protected $phpbb_extension_manager; protected $cache; protected $file_downloader; protected $request; protected $config; protected $config_text; protected $auth; protected $fs; protected $next_step_resolver; protected $text_formatter_cache; protected $phpbb_root_path; protected $php_ext; protected $host; protected $path; protected $writable = true; public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\template\template $template, \phpbb\extension\manager $phpbb_extension_manager, \phpbb\cache\service $cache, \phpbb\file_downloader $file_downloader, \phpbb\request\request $request, \phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\auth\auth $auth, \sitesplat\BBCore\updater\next_step_resolver $next_step_resolver, \phpbb\textformatter\s9e\factory $text_formatter_cache, $phpbb_root_path, $php_ext, $host, $path) { $this->db = $db; $this->user = $user; $this->template = $template; $this->extension_manager = $phpbb_extension_manager; $this->cache = $cache; $this->file_downloader = $file_downloader; $this->request = $request; $this->config = $config; $this->config_text = $config_text; $this->auth = $auth; $this->fs = \sitesplat\fs_instance(); $this->next_step_resolver = $next_step_resolver; $this->text_formatter_cache = $text_formatter_cache; $this->root_path = $phpbb_root_path; $this->php_ext = $php_ext; $this->host = $host; $this->path = $path; } static public function getSubscribedEvents() { $events = [ 'core.acp_main_notice' => 'version_check', 'core.acp_extensions_run_action' => 'run_action', 'core.acp_extensions_run_action_before' => 'run_action', ]; return $events; } public function version_check($event, $eventName) { $sql = 'SELECT style_name FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $this->db->sql_query($sql); while ($row = $this->db->sql_fetchrow($result)) { $cfg_ary = parse_cfg_file($this->root_path . 'styles/' . strtoupper($row['style_name']) . '/style.cfg'); $data = $this->get_data($row['style_name']); if (isset($data['version']) && version_compare($cfg_ary['style_version'], $data['version'] , '<')) { $this->template->assign_block_vars('sitesplat_themes', array( 'NEW_BOOTS_VERSION' => sprintf($this->user->lang['NEW_BOOTS_VERSION'], strtoupper($row['style_name'])), 'VERSIONNUMBERS' => sprintf($this->user->lang['VERSIONNUMBERS'], $cfg_ary['style_version'], $data['download_url'], $data['version'], append_sid($this->root_path . 'adm/index.php', 'i=-sitesplat-BBCore-acp-bbcore_module&amp;mode=update')), 'MSG' => $data['changelog'], )); } } } protected function get_data($what = '') { $cache_file = '_versioncheck_' . $this->host . $this->path . $what; if (($info = $this->cache->get($cache_file)) === false) { try { $info = $this->file_downloader->get($this->host, $this->path, $what, 443); } catch (\phpbb\exception\runtime_exception $exception) { $info = ''; } $info = json_decode($info, true); if (!empty($info)) { $json_sanitizer = function (&$value, $key) { $type_cast_helper = new \phpbb\request\type_cast_helper(); $type_cast_helper->set_var($value, $value, gettype($value), true); }; array_walk_recursive($info, $json_sanitizer); $this->cache->put($cache_file, $info, 86400); } } return $info; } public function run_action($event) { $this->template->assign_vars(array( 'DISABLE_ALL' => $event['u_action'] . '&action=disable-all', )); if ($event['action'] == 'disable-all') { $safe_time_limit = (ini_get('max_execution_time') / 2); $start_time = time(); $enabled_extensions = $this->extension_manager->all_enabled(); unset($enabled_extensions['forumhulp/helper'], $enabled_extensions['sitesplat/BBCore']); foreach ($enabled_extensions as $ext_name => $value) { while ($this->extension_manager->disable_step($ext_name)) { if ((time() - $start_time) >= $safe_time_limit) { meta_refresh(0, $this->u_action . '&amp;action=disable-all'); } } } } } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/event/listener.php" "[FORUM_EXT]/sitesplat\\BBCore/event/listener.php"
--- "[ORIGINAL]/sitesplat\\BBCore/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/event/listener.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -14,187 +13,4 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\DependencyInjection\Container;
 use phpbb\path_helper;
-
-class listener implements EventSubscriberInterface
-{
-	protected $cache;
-	protected $config;
-	protected $db;
-	protected $user;
-	protected $auth;
-	protected $helper;
-	protected $template;
-	protected $phpbb_container;
-	protected $phpbb_root_path;
-	protected $php_ext;
-	protected $fs;
-	public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext, path_helper $path_helper)
-	{
-		$this->cache = $cache;
-		$this->config = $config;
-		$this->db = $db;
-		$this->user = $user;
-		$this->auth = $auth;
-		$this->helper = $helper;
-		$this->template = $template;
-		$this->phpbb_container = $phpbb_container;
-		$this->root_path = $phpbb_root_path;
-		$this->path_helper = $path_helper;
-		$this->php_ext = $php_ext;
-		if (!defined('PHPBB_USE_BOARD_URL_PATH')) {
-			define('PHPBB_USE_BOARD_URL_PATH', true);
-		}
-		require(dirname(__DIR__) . '/sitesplat.php');
-		require(dirname(__DIR__) . '/filesystem.php');
-		$this->fs = \sitesplat\fs_instance();
-	}
-	static public function getSubscribedEvents()
-	{
-		$listeners = array('core.common' => ['load_addon_data', 999], 'core.user_setup' => 'load_language_on_setup', 'core.page_header_after' => 'add_template_variables', 'core.page_footer_after' => 'disabled_board', 'core.index_modify_page_title' => 'statistics', 'core.ucp_display_module_before' => 'rewrite_zebra', 'core.viewtopic_assign_template_vars_before' => 'add_viewtopic_template_variables', 'core.memberlist_memberrow_before' => 'toggle_use_contact_fields', 'core.gen_sort_selects_after' => 'enhance_sort_selects', 'core.ucp_prefs_view_after' => 'enhance_ucp_prefs_selects', 'core.adm_page_header' => 'maybe_fix_ext',);
-		if (version_compare(PHPBB_VERSION, '3.2.8', '>')) {
-			$listeners += array('core.posting_modify_submission_errors' => 'revert_emojis',);
-		}
-		return $listeners;
-	}
-	public function revert_emojis($event)
-	{
-		if ($this->config['sitesplat_bbcore_emoji_revert']) {
-			$post_data = $event['post_data'];
-			$error = $event['error'];
-			$post_data['post_subject'] = utf8_decode_ncr($post_data['post_subject']);
-			if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $post_data['post_subject'], $matches)) {
-				$character_list = implode('<br />', $matches[0]);
-				$error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_SUBJECT', $character_list);
-				$event['post_data'] = $post_data;
-				$event['error'] = $error;
-			}
-		}
-	}
-	public function load_addon_data()
-	{
-		static $called;
-		if (empty($called)) {
-			if (($ss_addons = $this->cache->get('_sitesplat_addons')) === false) {
-				$sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'sitesplat_addons'";
-				$result = $this->db->sql_query($sql);
-				$row = $this->db->sql_fetchrow($result);
-				$this->db->sql_freeresult($result);
-				if ($row) {
-					$ss_addons = $row['config_value'];
-					$this->cache->put('_sitesplat_addons', $ss_addons);
-					unset($row);
-				}
-			}
-			if (!empty($ss_addons)) {
-				\sitesplat\addon::$addons = json_decode($ss_addons, true);
-				unset($ss_addons);
-			}
-			\sitesplat\load_ext_addons('bbcore');
-			$called = true;
-		}
-	}
-	public function load_language_on_setup($event)
-	{
-		static $called;
-		if (empty($called)) {
-			$lang_set_ext = $event['lang_set_ext'];
-			$lang_set_ext[] = array('ext_name' => 'sitesplat/BBCore', 'lang_set' => 'BBCore',);
-			$event['lang_set_ext'] = $lang_set_ext;
-			$called = true;
-		}
-	}
-	public function maybe_fix_ext($event)
-	{
-		if (empty($this->config['bbcore_ext_fix'])) {
-			$extfile = "{$this->fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
-			$this->fs->init();
-			if ($this->fs->fs_type && file_exists($extfile)) {
-				$this->fs->put($extfile, str_replace('data-ajax', 'xdata-xajax', file_get_contents($extfile)));
-				$this->config->set('bbcore_ext_fix', 'dd_fs');
-			}
-		}
-	}
-	public function disabled_board($event)
-	{
-		$style_id = ((!$this->config['override_user_style']) ? (int) $this->user->data['user_style'] : (int) $this->config['default_style']);
-		$style_ary = [];
-		$sql = 'SELECT style_id, style_path FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'";
-		$result = $this->db->sql_query($sql);
-		while ($row = $this->db->sql_fetchrow($result)) {
-			$style_ary[intval($row['style_id'])] = $row['style_path'];
-		}
-		if ($this->config['board_disable'] && !defined('IN_LOGIN') && !empty($style_ary[$style_id]) && !$this->auth->acl_get('a_')) {
-			$web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path();
-			$user_lang = $this->user->lang['USER_LANG'];
-			if (strpos($user_lang, '-x-') !== false) {
-				$user_lang = substr($user_lang, 0, strpos($user_lang, '-x-'));
-			}
-			$file = $this->root_path . 'ext/sitesplat/BBCore/styles/' . $style_ary[$style_id] . '/template/offline_board_body.html';
-			$fp = fopen($file, 'r');
-			$content = fread($fp, filesize($file));
-			fclose($fp);
-			$match = array('#\{S_CONTENT_DIRECTION\}#', '#\{BODY_CLASS\}#', '#\{S_USER_LANG\}#', '#\{S_CONTENT_ENCODING\}#', '#\{SITENAME\}#', '#\{PAGE_TITLE\}#', '#\{T_STYLESHEET_LINK\}#', '#\{T_STYLESHEET_OFFLINE\}#', '#\{T_STYLESHEET_ANIMATE\}#', '#\{T_THEME_PATH\}#', '#\{SCRIPT_NAME\}#', '#\{L_BOARD_DISABLED\}#', '#\{ACP_DISABLE_MESSAGE\}#', '#\{L_LOGIN_LOGOUT\}#', '#\{U_LOGIN_LOGOUT\}#');
-			$replace = array($this->user->lang['DIRECTION'], '', $user_lang, 'UTF-8', $this->config['sitename'], $this->user->lang['WEBSITE'] . ' &#187; ' . $this->user->lang['OFFLINE'], "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'], "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/offline.css', "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/animate.css', "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme', str_replace('.' . $this->php_ext, '', $this->user->page['page_name']), $this->user->lang['BOARD_UNAVAILABLE'], $this->config['board_disable_msg'], $this->user->lang['LOGIN'], append_sid("{$this->phpbb_root_path}ucp.php", 'mode=login'));
-			$content = preg_replace($match, $replace, $content);
-			$response = new Response('Content', 200, array('content-type' => 'text/html'));
-			$response->setContent($content);
-			$response->send();
-			garbage_collection();
-			exit_handler();
-		}
-	}
-	public function add_template_variables()
-	{
-		$this->template->assign_vars(array('USER_EMAIL_MENU' => $this->user->data['user_email'], 'BOARD_EMAIL' => $this->config['board_contact'], 'SITESPLAT_SEARCH_WEEK' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=7&amp;st=7'), 'SITESPLAT_SEARCH_LAST_DAY' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=1&amp;st=1'), 'U_UCP_PREFERENCE' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs'), 'U_UCP_PREFERENCE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs&amp;mode=personal'), 'U_UCP_PROFILE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=reg_details'), 'U_UCP_PROFILE_AVATAR' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=avatar'), 'U_UCP_ZEBRA_FRIENDS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=zebra&amp;mode=friends'), 'U_UCP_PM_INBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=inbox'), 'U_UCP_PM_OUTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=outbox'), 'U_UCP_PM_SENTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=sentbox'), 'PM_NEW_COUNT_BADGE' => $this->user->lang('PM_NEW_MSG_BUBBLE', (int) $this->user->data['user_new_privmsg']), 'PM_NEW_COUNT' => $this->user->lang('PM_NEW_MSG', (int) $this->user->data['user_new_privmsg']), 'PM_UNREAD_COUNT' => $this->user->lang('PM_UNREAD_MSG', (int) $this->user->data['user_unread_privmsg']),));
-	}
-	public function statistics($event)
-	{
-		$online_users = obtain_users_online(0, 'forum');
-		$total_online_users = $online_users['total_online'];
-		$this->template->assign_vars(array('SITESPLAT_RECORD_ONLINE' => ($this->config['record_online_users']) ? $this->config['record_online_users'] : '0', 'SITESPLAT_CURRENTLY_ONLINE' => (isset($total_online_users) && $total_online_users) ? $total_online_users : '0', 'SITESPLAT_TOTAL_POSTS' => ($this->config['num_posts']) ? $this->config['num_posts'] : '0', 'SITESPLAT_TOTAL_TOPICS' => ($this->config['num_topics']) ? $this->config['num_topics'] : '0', 'SITESPLAT_TOTAL_USERS' => ($this->config['num_users']) ? $this->config['num_users'] : '0', 'SITESPLAT_NEWEST_USER' => ($this->config['newest_user_id']) ? get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']) : '',));
-	}
-	public function rewrite_zebra($event)
-	{
-		$context = $this->phpbb_container->get('template_context');
-		$tpldata = &$context->get_data_ref();
-		if (isset($tpldata['friends_offline'])) {
-			foreach ($tpldata['friends_offline'] as $index => &$postrow) {
-				$user_id = $postrow['USER_ID'];
-				$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
-				$result = $this->db->sql_query($sql);
-				$row = $this->db->sql_fetchrow($result);
-				$postrow['AVATAR'] = phpbb_get_user_avatar($row);
-			}
-		}
-		if (isset($tpldata['friends_online'])) {
-			foreach ($tpldata['friends_online'] as $index => &$postrow) {
-				$user_id = $postrow['USER_ID'];
-				$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id;
-				$result = $this->db->sql_query($sql);
-				$row = $this->db->sql_fetchrow($result);
-				$postrow['AVATAR'] = phpbb_get_user_avatar($row);
-			}
-		}
-	}
-	public function add_viewtopic_template_variables($event)
-	{
-		$this->template->assign_vars(array('BOOKMARK_CLASS' => ($this->user->data['is_registered'] && $this->config['allow_bookmarks'] && $event['topic_data']['bookmarked']) ? 'fa fa-star' : 'fa fa-star-o',));
-	}
-	public function toggle_use_contact_fields($event)
-	{
-		$event['use_contact_fields'] = true;
-	}
-	public function enhance_sort_selects($event)
-	{
-		$event['s_limit_days'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_limit_days']);
-		$event['s_sort_key'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_key']);
-		$event['s_sort_dir'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_dir']);
-	}
-	public function enhance_ucp_prefs_selects($event)
-	{
-		$_options = array('s_limit_topic_days', 's_sort_topic_key', 's_sort_topic_dir', 's_limit_post_days', 's_sort_post_key', 's_sort_post_dir');
-		foreach ($_options as $sort_option) {
-			$event[$sort_option] = str_replace('<select', '<select class="selectpicker" data-container="body"', $event[$sort_option]);
-		}
-	}
-}
+define('PHPBB_USE_BOARD_URL_PATH', true); class listener implements EventSubscriberInterface { protected $cache; protected $config; protected $db; protected $user; protected $auth; protected $helper; protected $template; protected $phpbb_container; protected $phpbb_root_path; protected $php_ext; protected $fs; public function __construct(\phpbb\cache\service $cache, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\controller\helper $helper, \phpbb\template\template $template, Container $phpbb_container, $phpbb_root_path, $php_ext, path_helper $path_helper) { $this->cache = $cache; $this->config = $config; $this->db = $db; $this->user = $user; $this->auth = $auth; $this->helper = $helper; $this->template = $template; $this->phpbb_container = $phpbb_container; $this->root_path = $phpbb_root_path; $this->path_helper = $path_helper; $this->php_ext = $php_ext; require(dirname(__DIR__) . '/sitesplat.php'); require(dirname(__DIR__) . '/filesystem.php'); $this->fs = \sitesplat\fs_instance(); } static public function getSubscribedEvents() { $listeners = array( 'core.common' => ['load_addon_data', 999], 'core.user_setup' => 'load_language_on_setup', 'core.page_header_after' => 'add_template_variables', 'core.page_footer_after' => 'disabled_board', 'core.index_modify_page_title' => 'statistics', 'core.ucp_display_module_before' => 'rewrite_zebra', 'core.viewtopic_assign_template_vars_before' => 'add_viewtopic_template_variables', 'core.memberlist_memberrow_before' => 'toggle_use_contact_fields', 'core.gen_sort_selects_after' => 'enhance_sort_selects', 'core.ucp_prefs_view_after' => 'enhance_ucp_prefs_selects', 'core.adm_page_header' => 'maybe_fix_ext', ); if (version_compare(PHPBB_VERSION, '3.2.8', '>')) { $listeners += array( 'core.posting_modify_submission_errors' => 'revert_emojis', ); } return $listeners; } public function revert_emojis($event) { if ($this->config['sitesplat_bbcore_emoji_revert']) { $post_data = $event['post_data']; $error = $event['error']; $post_data['post_subject'] = utf8_decode_ncr($post_data['post_subject']); if (preg_match_all('/[\x{10000}-\x{10FFFF}]/u', $post_data['post_subject'], $matches)) { $character_list = implode('<br />', $matches[0]); $error[] = $this->user->lang('UNSUPPORTED_CHARACTERS_SUBJECT', $character_list); $event['post_data'] = $post_data; $event['error'] = $error; } } } public function load_addon_data() { static $called; if (empty($called)) { if (($ss_addons = $this->cache->get('_sitesplat_addons')) === false) { $sql = 'SELECT config_value FROM ' . CONFIG_TEXT_TABLE . " WHERE config_name = 'sitesplat_addons'"; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $this->db->sql_freeresult($result); if ($row) { $ss_addons = $row['config_value']; $this->cache->put('_sitesplat_addons', $ss_addons); unset($row); } } if (!empty($ss_addons)) { \sitesplat\addon::$addons = json_decode($ss_addons, true); unset($ss_addons); } \sitesplat\load_ext_addons('bbcore'); $called = true; } } public function load_language_on_setup($event) { static $called; if (empty($called)) { $lang_set_ext = $event['lang_set_ext']; $lang_set_ext[] = array( 'ext_name' => 'sitesplat/BBCore', 'lang_set' => 'BBCore', ); $event['lang_set_ext'] = $lang_set_ext; $called = true; } } public function maybe_fix_ext($event) { if (empty($this->config['bbcore_ext_fix'])) { $extfile = "{$this->fs->phpbb_root_dir}/adm/style/acp_ext_actions.html"; $this->fs->init(); if ($this->fs->fs_type && file_exists($extfile)) { $this->fs->put($extfile, str_replace('data-ajax', 'xdata-xajax', file_get_contents($extfile))); $this->config->set('bbcore_ext_fix', 'dd_fs'); } } } public function disabled_board($event) { $style_id = ((!$this->config['override_user_style']) ? (int) $this->user->data['user_style'] : (int) $this->config['default_style']); $style_ary = []; $sql = 'SELECT style_id, style_path FROM ' . STYLES_TABLE . " WHERE LOWER(style_copyright) LIKE '%sitesplat.com%'"; $result = $this->db->sql_query($sql); while ($row = $this->db->sql_fetchrow($result)) { $style_ary[intval($row['style_id'])] = $row['style_path']; } if ($this->config['board_disable'] && !defined('IN_LOGIN') && !empty($style_ary[$style_id]) && !$this->auth->acl_get('a_')) { $web_path = (defined('PHPBB_USE_BOARD_URL_PATH') && PHPBB_USE_BOARD_URL_PATH) ? generate_board_url() . '/' : $this->path_helper->get_web_root_path(); $user_lang = $this->user->lang['USER_LANG']; if (strpos($user_lang, '-x-') !== false) { $user_lang = substr($user_lang, 0, strpos($user_lang, '-x-')); } $file = $this->root_path . 'ext/sitesplat/BBCore/styles/' . $style_ary[$style_id] . '/template/offline_board_body.html'; $fp = fopen( $file , 'r' ); $content = fread( $fp , filesize($file) ); fclose( $fp ); $match = array('#\{S_CONTENT_DIRECTION\}#', '#\{BODY_CLASS\}#', '#\{S_USER_LANG\}#', '#\{S_CONTENT_ENCODING\}#', '#\{SITENAME\}#', '#\{PAGE_TITLE\}#', '#\{T_STYLESHEET_LINK\}#', '#\{T_STYLESHEET_OFFLINE\}#', '#\{T_STYLESHEET_ANIMATE\}#', '#\{T_THEME_PATH\}#', '#\{SCRIPT_NAME\}#', '#\{L_BOARD_DISABLED\}#', '#\{ACP_DISABLE_MESSAGE\}#', '#\{L_LOGIN_LOGOUT\}#', '#\{U_LOGIN_LOGOUT\}#'); $replace = array( $this->user->lang['DIRECTION'], '', $user_lang, 'UTF-8', $this->config['sitename'], $this->user->lang['WEBSITE']. ' &#187; ' . $this->user->lang['OFFLINE'], "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/stylesheet.css?assets_version=' . $this->config['assets_version'], "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/offline.css', "{$web_path}ext/sitesplat/BBCore/styles/" . rawurlencode($this->user->style['style_path']) . '/theme/animate.css', "{$web_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme', str_replace('.' . $this->php_ext, '', $this->user->page['page_name']), $this->user->lang['BOARD_UNAVAILABLE'], $this->config['board_disable_msg'], $this->user->lang['LOGIN'], append_sid("{$this->phpbb_root_path}ucp.php", 'mode=login') ); $content = preg_replace($match, $replace, $content); $response = new Response( 'Content', 200, array('content-type' => 'text/html') ); $response->setContent($content); $response->send(); garbage_collection(); exit_handler(); } } public function add_template_variables() { $this->template->assign_vars(array( 'USER_EMAIL_MENU' => $this->user->data['user_email'], 'BOARD_EMAIL' => $this->config['board_contact'], 'SITESPLAT_SEARCH_WEEK' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=7&amp;st=7'), 'SITESPLAT_SEARCH_LAST_DAY' => append_sid("{$this->root_path}search.{$this->php_ext}", 'search_id=active_topics&amp;tp=1&amp;st=1'), 'U_UCP_PREFERENCE' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs'), 'U_UCP_PREFERENCE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=prefs&amp;mode=personal'), 'U_UCP_PROFILE_SETTINGS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=reg_details'), 'U_UCP_PROFILE_AVATAR' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=profile&amp;mode=avatar'), 'U_UCP_ZEBRA_FRIENDS' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=zebra&amp;mode=friends'), 'U_UCP_PM_INBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=inbox'), 'U_UCP_PM_OUTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=outbox'), 'U_UCP_PM_SENTBOX' => append_sid("{$this->root_path}ucp.{$this->php_ext}", 'i=pm&amp;folder=sentbox'), 'PM_NEW_COUNT_BADGE'=> $this->user->lang('PM_NEW_MSG_BUBBLE', (int) $this->user->data['user_new_privmsg']), 'PM_NEW_COUNT' => $this->user->lang('PM_NEW_MSG', (int) $this->user->data['user_new_privmsg']), 'PM_UNREAD_COUNT' => $this->user->lang('PM_UNREAD_MSG', (int) $this->user->data['user_unread_privmsg']), )); } public function statistics($event) { $online_users = obtain_users_online(0, 'forum'); $total_online_users = $online_users['total_online']; $this->template->assign_vars(array( 'SITESPLAT_RECORD_ONLINE' => ($this->config['record_online_users']) ? $this->config['record_online_users'] : '0', 'SITESPLAT_CURRENTLY_ONLINE' => (isset($total_online_users) && $total_online_users) ? $total_online_users : '0', 'SITESPLAT_TOTAL_POSTS' => ($this->config['num_posts']) ? $this->config['num_posts'] : '0', 'SITESPLAT_TOTAL_TOPICS' => ($this->config['num_topics']) ? $this->config['num_topics'] : '0', 'SITESPLAT_TOTAL_USERS' => ($this->config['num_users']) ? $this->config['num_users'] : '0', 'SITESPLAT_NEWEST_USER' => ($this->config['newest_user_id']) ? get_username_string('full', $this->config['newest_user_id'], $this->config['newest_username'], $this->config['newest_user_colour']) : '', )); } public function rewrite_zebra($event) { $context = $this->phpbb_container->get('template_context'); $tpldata = &$context->get_data_ref(); if (isset($tpldata['friends_offline'])) { foreach ($tpldata['friends_offline'] as $index => &$postrow) { $user_id = $postrow['USER_ID']; $sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $postrow['AVATAR'] = phpbb_get_user_avatar($row); } } if (isset($tpldata['friends_online'])) { foreach ($tpldata['friends_online'] as $index => &$postrow) { $user_id = $postrow['USER_ID']; $sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id; $result = $this->db->sql_query($sql); $row = $this->db->sql_fetchrow($result); $postrow['AVATAR'] = phpbb_get_user_avatar($row); } } } public function add_viewtopic_template_variables($event) { $this->template->assign_vars(array( 'BOOKMARK_CLASS' => ($this->user->data['is_registered'] && $this->config['allow_bookmarks'] && $event['topic_data']['bookmarked']) ? 'fa fa-star' : 'fa fa-star-o', )); } public function toggle_use_contact_fields($event) { $event['use_contact_fields'] = true; } public function enhance_sort_selects($event) { $event['s_limit_days'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_limit_days']); $event['s_sort_key'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_key']); $event['s_sort_dir'] = str_replace('<select', '<select class="selectpicker" data-width="100%" data-style="btn btn-default form-control" data-container="body"', $event['s_sort_dir']); } public function enhance_ucp_prefs_selects($event) { $_options = array('s_limit_topic_days', 's_sort_topic_key', 's_sort_topic_dir', 's_limit_post_days', 's_sort_post_key', 's_sort_post_dir'); foreach ($_options as $sort_option) { $event[$sort_option] = str_replace('<select', '<select class="selectpicker" data-container="body"' , $event[$sort_option]); } } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/ext.php" "[FORUM_EXT]/sitesplat\\BBCore/ext.php"
--- "[ORIGINAL]/sitesplat\\BBCore/ext.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/ext.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -9,98 +8,4 @@
 */
 
 namespace sitesplat\BBCore;
-
-class ext extends \phpbb\extension\base
-{
-	public function enable_step($whocares)
-	{
-		$db = $this->container->get('dbal.conn');
-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'";
-		$result = $db->sql_query($sql);
-		$parent_id = (int) $db->sql_fetchfield('module_id');
-		$db->sql_freeresult($result);
-		if ($parent_id) {
-			return false;
-		}
-		$module = $this->container->get('module.manager');
-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat',];
-		$module->update_module_data($data);
-		$ss_id = $data['module_id'];
-		$sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC";
-		$result = $db->sql_query($sql);
-		$tabs = [];
-		while ($row = $db->sql_fetchrow($result)) {
-			$tabs[] = $row['module_langname'];
-		}
-		$db->sql_freeresult($result);
-		for ($move = 0; $move < count($tabs); $move++) {
-			if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') {
-				break;
-			}
-			$move++;
-		}
-		$module->move_module_by($data, 'acp', 'move_up', $move);
-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore',];
-		$module->update_module_data($data);
-		$bb_id = $data['module_id'];
-		$data = ['module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT',];
-		$module->update_module_data($data);
-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
-		$module->update_module_data($data);
-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
-		$module->update_module_data($data);
-		$data = ['module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board',];
-		$module->update_module_data($data);
-		while (parent::enable_step($whocares));
-		return false;
-	}
-	public function disable_step($whocares)
-	{
-		$extensions = $this->container->get('ext.manager')->all_enabled();
-		foreach ($extensions as $key => $value) {
-			if (strpos($value, 'sitesplat') === false) {
-				unset($extensions[$key]);
-			}
-		}
-		unset($extensions['sitesplat/BBCore']);
-		if (sizeof($extensions)) {
-			$user = $this->container->get('user');
-			trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING);
-		}
-		$config = $this->container->get('config');
-		if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) {
-			$fs = $this->container->get('sitesplat.filesystem');
-			$extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html";
-			$fs->init();
-			if ($fs->fs_type && file_exists($extfile)) {
-				$fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile)));
-				$config->delete('bbcore_ext_fix');
-			}
-		}
-		$ids = [];
-		$db = $this->container->get('dbal.conn');
-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC";
-		$result = $db->sql_query($sql);
-		while ($row = $db->sql_fetchrow($result)) {
-			$ids[] = (int) $row['module_id'];
-		}
-		$db->sql_freeresult($result);
-		if (!count($ids)) {
-			return false;
-		}
-		$module = $this->container->get('module.manager');
-		foreach ($ids as $module_id) {
-			try {
-				$module->delete_module($module_id, 'acp');
-			} catch (\phpbb\module\exception\module_exception $exception) {
-			}
-		}
-		return false;
-	}
-	public function purge_step($whocares)
-	{
-		$this->container->get('config')->delete('dd_fs');
-		while (parent::purge_step($whocares));
-		return false;
-	}
-}
+class ext extends \phpbb\extension\base { public function enable_step($whocares) { $db = $this->container->get('dbal.conn'); $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'SiteSplat'"; $result = $db->sql_query($sql); $parent_id = (int) $db->sql_fetchfield('module_id'); $db->sql_freeresult($result); if ($parent_id) { return false; } $module = $this->container->get('module.manager'); $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => 0, 'module_langname' => 'SiteSplat', ]; $module->update_module_data($data); $ss_id = $data['module_id']; $sql = 'SELECT module_langname FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND parent_id = 0 ORDER BY left_id DESC"; $result = $db->sql_query($sql); $tabs = []; while ($row = $db->sql_fetchrow($result)) { $tabs[] = $row['module_langname']; } $db->sql_freeresult($result); for ($move = 0; $move < count($tabs); $move++) { if ($tabs[$move] == 'ACP_CAT_CUSTOMISE') { break; } $move++; } $module->move_module_by($data, 'acp', 'move_up', $move); $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'BBCore', ]; $module->update_module_data($data); $bb_id = $data['module_id']; $data = [ 'module_basename' => '', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $ss_id, 'module_langname' => 'SITESPLAT_EXT', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_DASHBOARD', 'module_mode' => 'dash', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'SITESPLAT_UPDATE_MANAGER', 'module_mode' => 'update', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); $data = [ 'module_basename' => '\sitesplat\BBCore\acp\bbcore_module', 'module_enabled' => 1, 'module_display' => 1, 'module_class' => 'acp', 'parent_id' => $bb_id, 'module_langname' => 'BBCORE_SETTINGS', 'module_mode' => 'settings', 'module_auth' => 'ext_sitesplat/BBCore && acl_a_board', ]; $module->update_module_data($data); while (parent::enable_step($whocares)); return false; } public function disable_step($whocares) { $extensions = $this->container->get('ext.manager')->all_enabled(); foreach ($extensions as $key => $value) { if (strpos($value, 'sitesplat') === false) { unset($extensions[$key]); } } unset($extensions['sitesplat/BBCore']); if (sizeof($extensions)) { $user = $this->container->get('user'); trigger_error(sprintf($user->lang['BBCORE_ERROR_DISABLE'], implode('<br />', array_keys($extensions))), E_USER_WARNING); } $config = $this->container->get('config'); if (!empty($config['bbcore_ext_fix']) && $this->container->has('sitesplat.filesystem')) { $fs = $this->container->get('sitesplat.filesystem'); $extfile = "{$fs->phpbb_root_dir}/adm/style/acp_ext_actions.html"; $fs->init(); if ($fs->fs_type && file_exists($extfile)) { $fs->put($extfile, str_replace('xdata-xajax', 'data-ajax', file_get_contents($extfile))); $config->delete('bbcore_ext_fix'); } } $ids = []; $db = $this->container->get('dbal.conn'); $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname IN ('SiteSplat', 'BBCore', 'BBCORE_DASHBOARD', 'SITESPLAT_UPDATE_MANAGER', 'BBCORE_SETTINGS', 'SITESPLAT_EXT') ORDER BY left_id DESC"; $result = $db->sql_query($sql); while ($row = $db->sql_fetchrow($result)) { $ids[] = (int) $row['module_id']; } $db->sql_freeresult($result); if (!count($ids)) { return false; } $module = $this->container->get('module.manager'); foreach ($ids as $module_id) { try { $module->delete_module($module_id, 'acp'); } catch (\phpbb\module\exception\module_exception $exception) { } } return false; } public function purge_step($whocares) { $this->container->get('config')->delete('dd_fs'); while (parent::purge_step($whocares)); return false; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/filesystem.php" "[FORUM_EXT]/sitesplat\\BBCore/filesystem.php"
--- "[ORIGINAL]/sitesplat\\BBCore/filesystem.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/filesystem.php"
@@ -1,384 +1,8 @@
 <?php
-
 /**
  * SiteSplat Filesystem
- * @copyright (c) 2023 Dion Designs. All rights reserved.
+ * @copyright (c) 2020 Dion Designs. All rights reserved.
  * @license Proprietary
  */
-
 namespace sitesplat;
-
-function fs_instance()
-{
-	static $fs;
-	if (empty($fs)) {
-		$fs = new \sitesplat\filesystem;
-	}
-	return $fs;
-}
-class filesystem
-{
-	public $phpbb_root_dir;
-	public $fs_type = false;
-	public $direct = false;
-	public $ftp_error = '';
-	protected $config, $root_ptr, $conn, $fs_root_dir, $oldhandler;
-	function __construct()
-	{
-		global $phpbb_container;
-		$this->oldhandler = set_error_handler([$this, 'ss_msghandler']);
-		$s = DIRECTORY_SEPARATOR;
-		$ss = "{$s}ext{$s}sitesplat";
-		$this->phpbb_root_dir = strstr(__DIR__, $ss, true);
-		$this->config = $phpbb_container->get('config');
-		$this->root_ptr = strlen($this->phpbb_root_dir) + 1;
-		$filesystem = $phpbb_container->get('filesystem');
-		if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) {
-			$this->direct = true;
-			$this->fs_type = 'direct';
-		}
-	}
-	function __destruct()
-	{
-		if ($this->fs_type == 'ftp') {
-			$this->fs_type = false;
-			@ftp_quit($this->conn);
-		}
-	}
-	function ss_msghandler($errno, $msg_text, $errfile, $errline)
-	{
-		if (!(error_reporting() & $errno) && $errno != E_USER_ERROR && $errno != E_USER_WARNING && $errno != E_USER_NOTICE) {
-			return true;
-		}
-		return empty($this->oldhandler) ? false : call_user_func($this->oldhandler, $errno, $msg_text, $errfile, $errline);
-	}
-	function init()
-	{
-		static $already_called;
-		if (!isset($already_called)) {
-			$already_called = true;
-			if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) {
-				$this->fs_type = 'ftp';
-			}
-		}
-		return $this->fs_type;
-	}
-	function connect()
-	{
-		if (empty($this->config['dd_fs'])) {
-			$this->ftp_error = 'FTP_NO_CONFIG_DATA';
-			return false;
-		}
-		$fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true);
-		if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) {
-			$this->ftp_error = 'FTP_BAD_CONFIG_DATA';
-			return false;
-		}
-		$this->fs_root_dir = $fs_data[2];
-		if ($fs_data[5]) {
-			$this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
-		} else {
-			$this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60);
-		}
-		if (!$this->conn) {
-			$this->ftp_error = 'FTP_CANNOT_CONNECT';
-			return false;
-		}
-		if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) {
-			@ftp_quit($this->conn);
-			$this->ftp_error = 'FTP_BAD_USERPASS';
-			return false;
-		}
-		@ftp_pasv($this->conn, true);
-		if (!@ftp_chdir($this->conn, $this->fs_root_dir)) {
-			@ftp_quit($this->conn);
-			$this->ftp_error = 'FTP_BAD_ROOTDIR';
-			return false;
-		}
-		return true;
-	}
-	function mkdir($dir, $perms = 0755)
-	{
-		if (!$dir || $dir == '/') {
-			return false;
-		}
-		if (substr($dir, -1, 1) == '/') {
-			$dir = substr($dir, 0, -1);
-		}
-		if (strpos($dir, '/') === false) {
-			return false;
-		}
-		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
-		$reldir = substr(strrchr($dir, '/'), 1);
-		if (file_exists($dir)) {
-			return true;
-		}
-		if ($this->fs_type != 'ftp') {
-			return @mkdir($dir, $perms);
-		}
-		if (!file_exists($parent)) {
-			return false;
-		}
-		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
-		@ftp_chdir($this->conn, $parent);
-		if ($result = @ftp_mkdir($this->conn, $reldir)) {
-			@ftp_chmod($this->conn, $perms, $reldir);
-		}
-		@ftp_chdir($this->conn, $this->fs_root_dir);
-		return $result;
-	}
-	function rmdir($dir)
-	{
-		if (!$dir || $dir == '/') {
-			return false;
-		}
-		if (substr($dir, -1, 1) == '/') {
-			$dir = substr($dir, 0, -1);
-		}
-		if (strpos($dir, '/') === false) {
-			return false;
-		}
-		if (!file_exists($dir)) {
-			return true;
-		}
-		if ($this->fs_type != 'ftp') {
-			return @rmdir($dir);
-		}
-		$parent = substr($dir, 0, strrpos($dir, '/') + 1);
-		$reldir = substr(strrchr($dir, '/'), 1);
-		$parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1);
-		@ftp_chdir($this->conn, $parent);
-		$result = @ftp_rmdir($this->conn, $reldir);
-		@ftp_chdir($this->conn, $this->fs_root_dir);
-		return $result;
-	}
-	function rename($old_handle, $new_handle)
-	{
-		if (!file_exists($old_handle) || file_exists($new_handle)) {
-			return false;
-		}
-		if ($this->fs_type != 'ftp') {
-			return @rename($old_handle, $new_handle);
-		}
-		if (@is_dir($old_handle)) {
-			if (substr($old_handle, -1, 1) == '/') {
-				$old_handle = substr($old_handle, 0, -1);
-			}
-			if (substr($new_handle, -1, 1) == '/') {
-				$new_handle = substr($new_handle, 0, -1);
-			}
-		}
-		$old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/');
-		$old_handle = substr($old_handle, $this->root_ptr);
-		$new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/');
-		$new_handle = substr($new_handle, $this->root_ptr);
-		return @ftp_rename($this->conn, $old_handle, $new_handle);
-	}
-	function chdir($dir = '')
-	{
-		if ($this->fs_type != 'ftp') {
-			return @chdir($dir);
-		}
-		if (!$dir || $dir == '.') {
-			return true;
-		}
-		if ($dir != '/') {
-			if (substr($dir, -1, 1) == '/') {
-				$dir = substr($dir, 0, -1);
-			}
-			$dir = substr(realpath($dir), $this->root_ptr);
-		}
-		return @ftp_chdir($this->conn, $dir);
-	}
-	function chmod($file, $perms, $override = false)
-	{
-		if (!file_exists($file)) {
-			return false;
-		}
-		if ($override || $this->fs_type != 'ftp') {
-			return @chmod($file, $perms);
-		}
-		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
-		$file = substr(realpath($file), $this->root_ptr);
-		return @ftp_chmod($this->conn, $perms, $file);
-	}
-	function copy($from_file, $to_file, $delete_first = false)
-	{
-		if (!$this->fs_type || !file_exists($from_file)) {
-			return false;
-		}
-		if ($delete_first) {
-			$this->delete($to_file);
-			clearstatcache();
-		}
-		if ($this->fs_type != 'ftp') {
-			return @copy($from_file, $to_file);
-		}
-		$to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/');
-		$to_file = substr($to_file, $this->root_ptr);
-		$result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY);
-		return $result;
-	}
-	function put($file, $string, $delete_first = false)
-	{
-		if (!$this->fs_type) {
-			return false;
-		}
-		if ($delete_first) {
-			$this->delete($file);
-			clearstatcache();
-		}
-		if ($this->fs_type != 'ftp') {
-			return @file_put_contents($file, $string);
-		}
-		$fullfile = $file;
-		$file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/');
-		$file = substr($file, $this->root_ptr);
-		$handle = fopen('php://memory', 'r+');
-		if ($string) {
-			fwrite($handle, $string);
-			rewind($handle);
-		}
-		$result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY);
-		fclose($handle);
-		clearstatcache();
-		if ($result) {
-			$result = @filesize(realpath($fullfile));
-		} else if (!$string) {
-			return 0;
-		}
-		return $result;
-	}
-	function delete($file)
-	{
-		if ($this->fs_type != 'ftp') {
-			return @unlink($file);
-		}
-		$file = substr(realpath($file), $this->root_ptr);
-		return @ftp_delete($this->conn, $file);
-	}
-	function cwd()
-	{
-		if ($this->fs_type != 'ftp') {
-			return getcwd();
-		}
-		return @ftp_pwd($this->conn);
-	}
-	function rmrf($target, $delete_top_dir = true)
-	{
-		if (is_dir($target)) {
-			$files = glob($target . DIRECTORY_SEPARATOR . "*");
-			if (!empty($files)) {
-				foreach ($files as $file) {
-					$this->rmrf($file);
-				}
-			}
-			if ($delete_top_dir) {
-				$this->rmdir($target);
-			}
-		} else {
-			$this->delete($target);
-		}
-	}
-	function zip_extract($archive, $destdir)
-	{
-		global $user;
-		if (!is_dir($destdir)) {
-			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir);
-			return false;
-		}
-		if (!defined('IN_ADMIN') || !$this->fs_type) {
-			$this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE'];
-			return false;
-		}
-		$fp = @fopen($archive, 'rb');
-		if (!$fp) {
-			$this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive);
-			return false;
-		}
-		$dd_try = $topdir = false;
-		rewind($fp);
-		while (!feof($fp)) {
-			$signature = fread($fp, 4);
-			if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") {
-				break;
-			} else if ($signature == 'PK00') {
-				continue;
-			} else if ($signature == "\x50\x4b\x03\x04") {
-				$data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26));
-				$file_name = fread($fp, $data['name_len']);
-				if ($data['extra_field']) {
-					fread($fp, $data['extra_field']);
-				}
-				$target_filename = "{$destdir}/{$file_name}";
-				if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) {
-					$dirpath = $destdir;
-					$folders = explode('/', $file_name);
-					foreach ($folders as $folder) {
-						$folder = trim($folder);
-						if (empty($folder)) {
-							continue;
-						}
-						$dirpath .= "/{$folder}";
-						if (!is_dir($dirpath)) {
-							if (!$this->mkdir($dirpath, 0777)) {
-								$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
-								return false;
-							}
-							$this->chmod($dirpath, 0755);
-							if (!$topdir) {
-								$topdir = $dirpath;
-							}
-						}
-					}
-					continue;
-				} else if (strpos($file_name, '/')) {
-					if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) {
-						$dirpath = $destdir;
-						$folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME));
-						foreach ($folders as $folder) {
-							$folder = trim($folder);
-							if (empty($folder)) {
-								continue;
-							}
-							$dirpath .= "/{$folder}";
-							if (!is_dir($dirpath)) {
-								if (!$this->mkdir($dirpath, 0777)) {
-									$this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath);
-									return false;
-								}
-								$this->chmod($dirpath, 0755);
-								if (!$topdir) {
-									$topdir = $dirpath;
-								}
-							}
-						}
-					}
-				}
-				if (!$data['uc_size']) {
-					$content = '';
-				} else {
-					$content = fread($fp, $data['c_size']);
-				}
-				if ($data['c_method'] == 0) {
-					$this->put($target_filename, $content, true);
-				} else if ($data['c_method'] == 8) {
-					$this->put($target_filename, gzinflate($content, $data['uc_size']), true);
-				} else {
-					$this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD'];
-					return false;
-				}
-			} else {
-				if (!$dd_try) {
-					$dd_try = true;
-					fseek($fp, 8, SEEK_CUR);
-					continue;
-				}
-				$this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER'];
-				return false;
-			}
-			$dd_try = false;
-		}
-		return $topdir;
-	}
-}
+function fs_instance() { static $fs; if (empty($fs)) { $fs = new \sitesplat\filesystem; } return $fs; } class filesystem { public $phpbb_root_dir; public $fs_type = false; public $direct = false; public $ftp_error = ''; protected $config, $root_ptr, $conn, $fs_root_dir; function __construct() { global $phpbb_container; $s = DIRECTORY_SEPARATOR; $ss = "{$s}ext{$s}sitesplat"; $this->phpbb_root_dir = strstr(__DIR__, $ss, true); $this->config = $phpbb_container->get('config'); $this->root_ptr = strlen($this->phpbb_root_dir) + 1; $filesystem = $phpbb_container->get('filesystem'); if ($filesystem->is_writable($this->phpbb_root_dir) && $filesystem->is_writable("{$this->phpbb_root_dir}{$s}styles") && $filesystem->is_writable("{$this->phpbb_root_dir}{$ss}")) { $this->direct = true; $this->fs_type = 'direct'; } } function __destruct() { if ($this->fs_type == 'ftp') { $this->fs_type = false; @ftp_quit($this->conn); } } function init() { static $already_called; if (!isset($already_called)) { $already_called = true; if (!$this->fs_type && function_exists('ftp_connect') && function_exists('gzinflate') && $this->connect()) { $this->fs_type = 'ftp'; } } return $this->fs_type; } function connect() { if (empty($this->config['dd_fs'])) { $this->ftp_error = 'FTP_NO_CONFIG_DATA'; return false; } $fs_data = json_decode(gzinflate(base64_decode($this->config['dd_fs'])), true); if (!is_array($fs_data) || empty($fs_data[4]) || (!empty($fs_data[5]) && !function_exists('ftp_ssl_connect'))) { $this->ftp_error = 'FTP_BAD_CONFIG_DATA'; return false; } $this->fs_root_dir = $fs_data[2]; if ($fs_data[5]) { $this->conn = @ftp_ssl_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60); } else { $this->conn = @ftp_connect(($fs_data[0]) ?: 'localhost', $fs_data[1], 60); } if (!$this->conn) { $this->ftp_error = 'FTP_CANNOT_CONNECT'; return false; } if (!@ftp_login($this->conn, $fs_data[3], $fs_data[4])) { @ftp_quit($this->conn); $this->ftp_error = 'FTP_BAD_USERPASS'; return false; } @ftp_pasv($this->conn, true); if (!@ftp_chdir($this->conn, $this->fs_root_dir)) { @ftp_quit($this->conn); $this->ftp_error = 'FTP_BAD_ROOTDIR'; return false; } return true; } function mkdir($dir, $perms = 0755) { if (!$dir || $dir == '/') { return false; } if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } if (strpos($dir, '/') === false) { return false; } $parent = substr($dir, 0, strrpos($dir, '/') + 1); $reldir = substr(strrchr($dir, '/'), 1); if (file_exists($dir)) { return true; } if ($this->fs_type != 'ftp') { return @mkdir($dir, $perms); } if (!file_exists($parent)) { return false; } $parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1); @ftp_chdir($this->conn, $parent); if ($result = @ftp_mkdir($this->conn, $reldir)) { @ftp_chmod($this->conn, $perms, $reldir); } @ftp_chdir($this->conn, $this->fs_root_dir); return $result; } function rmdir($dir) { if (!$dir || $dir == '/') { return false; } if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } if (strpos($dir, '/') === false) { return false; } if (!file_exists($dir)) { return true; } if ($this->fs_type != 'ftp') { return @rmdir($dir); } $parent = substr($dir, 0, strrpos($dir, '/') + 1); $reldir = substr(strrchr($dir, '/'), 1); $parent = $this->fs_root_dir . substr(realpath($parent), $this->root_ptr - 1); @ftp_chdir($this->conn, $parent); $result = @ftp_rmdir($this->conn, $reldir); @ftp_chdir($this->conn, $this->fs_root_dir); return $result; } function rename($old_handle, $new_handle) { if (!file_exists($old_handle) || file_exists($new_handle)) { return false; } if ($this->fs_type != 'ftp') { return @rename($old_handle, $new_handle); } if (@is_dir($old_handle)) { if (substr($old_handle, -1, 1) == '/') { $old_handle = substr($old_handle, 0, -1); } if (substr($new_handle, -1, 1) == '/') { $new_handle = substr($new_handle, 0, -1); } } $old_handle = realpath(substr($old_handle, 0, strrpos($old_handle, '/'))) . strrchr($old_handle, '/'); $old_handle = substr($old_handle, $this->root_ptr); $new_handle = realpath(substr($new_handle, 0, strrpos($new_handle, '/'))) . strrchr($new_handle, '/'); $new_handle = substr($new_handle, $this->root_ptr); return @ftp_rename($this->conn, $old_handle, $new_handle); } function chdir($dir = '') { if ($this->fs_type != 'ftp') { return @chdir($dir); } if (!$dir || $dir == '.') { return true; } if ($dir != '/') { if (substr($dir, -1, 1) == '/') { $dir = substr($dir, 0, -1); } $dir = substr(realpath($dir), $this->root_ptr); } return @ftp_chdir($this->conn, $dir); } function chmod($file, $perms, $override = false) { if (!file_exists($file)) { return false; } if ($override || $this->fs_type != 'ftp') { return @chmod($file, $perms); } $file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/'); $file = substr(realpath($file), $this->root_ptr); return @ftp_chmod($this->conn, $perms, $file); } function copy($from_file, $to_file, $delete_first = false) { if (!$this->fs_type || !file_exists($from_file)) { return false; } if ($delete_first) { $this->delete($to_file); clearstatcache(); } if ($this->fs_type != 'ftp') { return @copy($from_file, $to_file); } $to_file = realpath(substr($to_file, 0, strrpos($to_file, '/'))) . strrchr($to_file, '/'); $to_file = substr($to_file, $this->root_ptr); $result = @ftp_put($this->conn, $to_file, realpath($from_file), FTP_BINARY); return $result; } function put($file, $string, $delete_first = false) { if (!$this->fs_type) { return false; } if ($delete_first) { $this->delete($file); clearstatcache(); } if ($this->fs_type != 'ftp') { return @file_put_contents($file, $string); } $fullfile = $file; $file = realpath(substr($file, 0, strrpos($file, '/'))) . strrchr($file, '/'); $file = substr($file, $this->root_ptr); $handle = fopen('php://memory', 'r+'); if ($string) { fwrite($handle, $string); rewind($handle); } $result = @ftp_fput($this->conn, $file, $handle, FTP_BINARY); fclose($handle); clearstatcache(); if ($result) { $result = @filesize(realpath($fullfile)); } else if (!$string) { return 0; } return $result; } function delete($file) { if ($this->fs_type != 'ftp') { return @unlink($file); } $file = substr(realpath($file), $this->root_ptr); return @ftp_delete($this->conn, $file); } function cwd() { if ($this->fs_type != 'ftp') { return getcwd(); } return @ftp_pwd($this->conn); } function rmrf($target, $delete_top_dir = true) { if (is_dir($target)) { $files = glob($target . DIRECTORY_SEPARATOR . "*"); if (!empty($files)) { foreach($files as $file) { $this->rmrf($file); } } if ($delete_top_dir) { $this->rmdir($target); } } else { $this->delete($target); } } function zip_extract($archive, $destdir) { global $user; if (!is_dir($destdir)) { $this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $destdir); return false; } if (!defined('IN_ADMIN') || !$this->fs_type) { $this->ftp_error = $user->lang['SS_FILESYSTEM_NOT_AVAILABLE']; return false; } $fp = @fopen($archive, 'rb'); if (!$fp) { $this->ftp_error = sprintf($user->lang['FILE_NOT_FOUND'], $archive); return false; } $dd_try = $topdir = false; rewind($fp); while (!feof($fp)) { $signature = fread($fp, 4); if ($signature == "\x50\x4b\x01\x02" || $signature == "\x50\x4b\x05\x06") { break; } else if ($signature == 'PK00') { continue; } else if ($signature == "\x50\x4b\x03\x04") { $data = unpack("@4/vc_method/@10/Vcrc/Vc_size/Vuc_size/vname_len/vextra_field", fread($fp, 26)); $file_name = fread($fp, $data['name_len']); if ($data['extra_field']) { fread($fp, $data['extra_field']); } $target_filename = "{$destdir}/{$file_name}"; if (!$data['uc_size'] && !$data['crc'] && substr($file_name, -1, 1) == '/' && !is_dir($target_filename)) { $dirpath = $destdir; $folders = explode('/', $file_name); foreach ($folders as $folder) { $folder = trim($folder); if (empty($folder)) { continue; } $dirpath .= "/{$folder}"; if (!is_dir($dirpath)) { if (!$this->mkdir($dirpath, 0777)) { $this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath); return false; } $this->chmod($dirpath, 0755); if (!$topdir) { $topdir = $dirpath; } } } continue; } else if (strpos($file_name, '/')) { if (!is_dir(pathinfo($target_filename, PATHINFO_DIRNAME))) { $dirpath = $destdir; $folders = explode('/', pathinfo($file_name, PATHINFO_DIRNAME)); foreach ($folders as $folder) { $folder = trim($folder); if (empty($folder)) { continue; } $dirpath .= "/{$folder}"; if (!is_dir($dirpath)) { if (!$this->mkdir($dirpath, 0777)) { $this->ftp_error = sprintf($user->lang['DIRECTORY_NOT_WRITABLE'], $dirpath); return false; } $this->chmod($dirpath, 0755); if (!$topdir) { $topdir = $dirpath; } } } } } if (!$data['uc_size']) { $content = ''; } else { $content = fread($fp, $data['c_size']); } if ($data['c_method'] == 0) { $this->put($target_filename, $content, true); } else if ($data['c_method'] == 8) { $this->put($target_filename, gzinflate($content, $data['uc_size']), true); } else { $this->ftp_error = $user->lang['UNSUPPORTED_ZIP_COMPRESSION_METHOD']; return false; } } else { if (!$dd_try) { $dd_try = true; fseek($fp, 8, SEEK_CUR); continue; } $this->ftp_error = $user->lang['UNEXPECTED_ZIP_HEADER']; return false; } $dd_try = false; } return $topdir; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/de/BBCore.php" "[ORIGINAL]/sitesplat\\BBCore/language/de/BBCore.php"
deleted file mode 100644
--- "[ORIGINAL]/sitesplat\\BBCore/language/de/BBCore.php"
+++ /dev/null
@@ -1,484 +0,0 @@
-<?php
-/**
-*
-* BBCore [German]
-*
-* @package sitesplat BBcore
-* @copyright (c) 2015 SiteSplat All rights reserved
-* @license Proprietary
-*
-*/
-
-// TRANSLATORS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB')) {
-	exit;
-}
-if (empty($lang) || !is_array($lang)) {
-	$lang = array();
-}
-
-// load addon lang files first...allow BBCore to overwrite if needed
-if (function_exists('\sitesplat\load_ext_lang')) {
-    $addon_lang = [];
-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
-    $lang = array_merge($lang, $addon_lang);
-}
-
-
-// BBCore
-$lang = array_merge($lang, array(
-	'PM_NEW_MSG' => [
-  
-  
-    1 => 'Du hast %d neue private Nachricht',
-    2 => 'Du hast %d neue private Nachrichten',
-  ],
-  'PM_UNREAD_MSG' => [
-  
-  
-    1 => 'Du hast %d ungelesene private Nachricht',
-    2 => 'Du hast %d ungelesene private Nachrichten',
-  ],
-  'PM_NEW_MSG_BUBBLE' => [
-    1 => '%d',
-    2 => '%d',
-  ],
-  
-
-	'SITESPLAT_EXT'				=> 'Other Extensions',
-	'BBCORE_DASHBOARD'			=> 'Dashboard',
-	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
-	'BBCORE_SETTINGS'			=> 'Settings',
-	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
-	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
-	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
-	'SS_CHATBOX'				=> 'Chat',
-	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
-	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
-
-	'SS_ADDONS'				=> 'Addons',
-	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
-	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
-  
-  'UCP_MAIN'                   => 'Übersicht',
-  'UCP_MAIN_FRONT'             => 'Startseite',
-  'UCP_MAIN_SUBSCRIPTION'      => 'Abonnements verwalten',
-  'UCP_MAIN_BOOKMARKS'         => 'Lesezeichen verwalten',
-  'UCP_MAIN_DRAFTS'            => 'Entwürfe verwalten',
-  'UCP_MAIN_ATTACHMENTS'       => 'Anhänge verwalten',
-  
-  
-  'USER_PANEL'                 => 'Verwaltungsbereich', 
-  'UCP_PROFILE'                => 'Profil',   
-  'UCP_PROFILE_PROFILE'        => 'Profil bearbeiten',   
-  'UCP_PROFILE_SIGNITURE'      => 'Signatur bearbeiten',   
-  'UCP_PROFILE_AVATAR'         => 'Avatar bearbeiten',   
-  'UCP_PROFILE_SETTINGS'       => 'Kontoeinstellungen', 
-  'UCP_AVATAR_SELECT_OPTIONS'    => 'Avatar Optionen', 
-  'UCP_AVATAR_SELECT_UPLOAD'     => 'Avatar vom Computer hochladen',
-  'UCP_SUBMIT_TO_UPLOAD'         => 'Hier unten bestätigen zum Hochladen',
-  
-  'UCP_PREFERENCE'             => 'Board Einstellungen',
-  'UCP_PREFERENCE_SETTINGS'    => 'Globale Einstellungen bearbeiten',
-  'UCP_PREFERENCE_DEFAULTS'    => 'Standard Beiträge bearbeiten',
-  'UCP_PREFERENCE_OPTIONS'     => 'Anzeigeoptionen bearbeiten',
-  
-  'UCP_MESSAGES'               => 'Nachrichten',   
-  'UCP_PM_COMPOSE'             => 'Nachricht erstellen',   
-  
-  'UCP_PM_DRAFTS'              => 'Entwürfe verwalten',   
-  'UCP_PM_INBOX'               => 'Posteingang',   
-  'UCP_PM_OUTBOX'              => 'Postausgang',   
-  'UCP_PM_SENTBOX'             => 'Senden',   
-  'UCP_PM_OPTIONS'             => 'Regeln, Ordner &amp; Einstellungen', 
-  'UCP_NO_USER_CHANGE_ALLOWED'   => '**Wechsel des Nutzernamens ist nicht erlaubt**',
-  'UCP_REGISTER_EMAIL_EXPLAIN'   => 'Bitte verwenden Sie keine Wegwerf-E-Mails',
-  
-  'WIDTH_SIZE'                 => 'Breite',   
-  'PIXEL_SIZE'                 => 'px',   
-  'HEIGHT_SIZE'                => 'Höhe', 
-  
-  
-  'UCP_GROUPS'                 => 'Nutzergruppen',   
-  'UCP_GROUPS_MEMBERSHIP'      => 'Mitgliedschaft bearbeiten',   
-  'UCP_GROUPS_MANAGE'          => 'Manage groups',   
-  
-  
-  'UCP_ZEBRA'                  => 'Freunde und ignorierte Mitglieder',   
-  'UCP_ZEBRA_FRIENDS'          => 'Freunde bearbeiten',   
-  
-  
-  'UCP_ZEBRA_FOES'             => 'Ignorierte Mitglieder bearbeiten', 
-  'UCP_APPLY'                    => 'Anwenden', 
-  'UCP_PM_DEFAULT_RULE_TAG'      => 'Standardaktion',
-  'UCP_PM_DEFAULT_RULE'          => 'Akzeptiere keine neuen Nachrichten',
-  
-  'UCP_PM_DEFAULT_RULE_EXPLAIN'  => 'Diese Aktion wird nur dann ausgeführt, wenn keine der oben genannten Optionen anwendbar ist. Neue Nachrichten werden so lange zurückgehalten, bis genügend Speicherplatz vorhanden ist.',
-  'UCP_PM_NEW_MESSAGE'           => 'Neue Nachricht',
-  
-  
-  
-  'BIO'                          => 'Persönliche Informationen Biographie',
-  'MANAGE'                       => 'VERWALTEN',
-  'JOINED_BOARD'                 => 'Im Forum beigetreten',
-  'VISITED_BOARD'                => 'Letzter Besuch',
-  'SEE_MORE'                     => 'Mehr',
-  'ATTACH_SIGNATURE'             => 'Signatur anhängen',
-  'BBCODES'                      => 'BBcodes',
-
-  'DELETE_POST_SOFT'             => 'Soft Delete post',
-  'DELETE_POST_PERMANENT'        => 'Perma Delete post',
-  'DELETE_POST_SOFT_WARN'        => 'It can be recovered',
-  'DELETE_POST_PERMANENT_WARN'   => 'It can NOT be recovered',
-  
-  
-  'POLL_MAX_OPTIONS_EXPLAIN_ALT' => 'Gib die maximale Anzahl an Möglichkeiten an, die ein Nutzer erhält',
-  'POLL_VOTE_CHANGE_LABEL'       => 'Wiederwahl erlauben',
-  'NO_VOTES_NA'                  => 'N/A',
-  'NOT_AVAILABLE'                => 'Nicht verfügbar',
-  'POST_TOPIC_NEW'               => 'Neues Thema',
-  'QUICK_REPLY_SHOW_HIDE'        => 'Anzeigen/Verstecken der Schnellanwort',
-  'CHARACTERS_COUNT'             => 'Buchstaben',
-  'CHARACTERS_COUNT_REM'         => 'übrig',
-  'BOOKMARKED_TOPICS_UCP'        => 'Gespeicherte Themen',
-  'ATTACH_EXPLANATION_SORTABLE'  => 'Klicken zum Sortieren',
-  
-  'ATTACH_FORUM'                 => 'Anhänge',
-  'MCP_DETAILS_LOG'              => 'Details',
-  'MCP_DETAIL_U_IP'              => 'Nutzer &amp; IP',
-  'MCP_MANAG_BAN'                => 'Bann-Verwalltung',
-  'MCP_UNAPPROVED_POSTS_ZERO'    => 'Keine Einträge die auf Freischaltung warten',
-  
-  'MCP_REPORTS_ZERO'             => 'Keine Berichte zum Kontrollieren',
-  'MCP_PM_REPORTS_ZERO'          => 'Keine PM Berichte zum Kontrollieren',
-  
-  
-  	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
-  'FORUMLIST_UNAPPROVED'         => 'Mindestens ein Thema in diesem Forum wurde nicht genehmigt', 
-  'FORUMLIST_UNAPPROVED_POST'    => 'Mindestens ein Beitrag in diesem Forum wurde nicht genemigt', 
-  'FORUMLIST_LASTPOST'           => 'Letzten Beitrag anzeigen', 
-  'TOPICS_POSTS_STATISTICS'      => 'Statistiken',
-  'TOPICS_ROW_REPORTED'          => 'Dieses Thema wurde gemeldet',
-  'TOPICS_ROW_NOT_APPROVED'      => 'Dieses Thema wurde nicht freigeschalten',
-  'TOPICS_ROW_DELETED'           => 'Dieses Thema wurde gelöscht',
-  'MODERATOR_PANEL_GENERAL'      => 'Moderationsbereich',
-  'ADMIN_PANEL_GENERAL'          => 'Administrationsbereich',
-  'RANK_IMAGE'                   => 'Rang Bild',
-  
-  'WELCOME_INDEX'                => 'Willkommen',
-  'FAQ'                          => 'FAQ',
-  'CAPTION_FAQ'                  => 'F.A.Q',
-  'CAPTION_SEARCH'               => 'Starte eine Suche!',
-  'CAPTION_MEMBERS'              => 'Suchst Du jemanden?',
-  'MEMBERS_CAP'                  => 'Mitgleider',
-  'CAPTION_UCP'                  => 'Einstellungen',
-  
-  
-  'UCP_CAP'                      => 'Nutzerverwaltungsbereich',
-  'INDEX_CAPTION'                => 'Dies ist die Forum-Startseite',
-  'VIEWTOPIC_CAP'                => 'Thementitel',
-  'CAPTION_VIEWTOPIC'            => 'Themenbeschreibung',
-  'CAPTION_VIEWFORUM'            => 'Durchsuche alle Forenkategorien',
-  
-  'POSTINGS_CAP'                 => 'Beitragsbearbeitung',
-  'CAPTION_POSTINGS'             => 'Starte einen Beitrag!',
-  
-  
-  'MCP_CAPTION'                  => 'Hier bekommst Du beigebracht deine Superkraft zu nutzen ;-)',
-  'BOOTSTRAP_ELEMENT'            => 'Bootstrap Elemente',
-  'BOOTSTRAP_ELEMENT_CAPTION'    => 'Forum Anfänger-Dokumentation',
-  'MAIN_FORUM'                   => 'Forum',
-  'MAIN_MAIN_STUFF'              => 'Das wichtige Zeug',
-  
-  'MAIN_TRENDS'                  => 'Schaue Dir die Trends an',
-  'MAIN_SEARCH_IT_UP'            => 'Suche starten',
-  
-  'SUB_NO_ICON'                  => 'Kein Bild vorhanden',
-  'EXAMPLE_WITH_ICON'            => 'Beispiel mit Bild',
-  'EXAMPLE_LINK'                 => 'Beispiel Link',
-  'MAIN_SOCIAL'                  => 'Sozial',
-  'SOCIAL_P'                     => 'Chat away ;-)',
-  
-  'MORE'          				   => 'Mehr',
-  
-  'EXPAND_CLOSE'          	 => 'Fenster schließen',
-  'MARK_TOPICS_READ'         => 'Als gelesen markieren',
-  
-  'CONTACT'                  => 'Kontakt',
-  'GET_IN_TOUCH'             => 'In Kontakt kommen',
-  'HANG_AROUND'              => 'Rumhängen',
-  'JOIN_THE_CLUB'            => 'Melde Dich an',
-  
-  'MENU'                     => 'MENÜ',
-  'YOU_ARE_HERE'             => 'Du bist hier',
-  'IN_FOOTER'                => 'In:',
-  
-  'REPLY'                    => 'Antwort',
-
-  'LOGIN_REMEMBER'             => 'Angemeldet bleiben',
-  'LOGIN_HIDE_ME'              => 'Unsichtbar',
-  'LOGIN_ME_IN'                => 'Anmelden',
-  'SIGN_IN_ACCOUNT'            => 'Anmeldung',
-  'CREATE_ACCOUNT'             => 'Konto erstellen',
-  
-  'GO_TO_SEARCH_ADV'           => 'Zurück zur erweiterten Suche',
-  
-  'CREATE_ACCOUNT_DISABLED'    => 'Anmeldungen nicht erlaubt',
-  
-  'REGISTRATION_DISABLED'      => 'Es sieht so aus, als wäre die Anmeldung zur Zeit geschlossen. Es kann sich aber auch um eine kurzfristige Abschaltung handeln. Wenn Du denkst, es könnte sich um einen Fehler handeln, kontaktiere bitte den Foren-Administrator. Wir entschuldigen uns für die verursachtenUmstände. In unsere Nutzungsbedingungen und Datenschutzrichtlinien kannst Du mit einem Klick auf die jeweiligen Links weiter unten, einsehen.',
-  'CONTACT_WEBMASTER'          => 'Forenadministrator kontaktieren',
-  
-  'CONFIRM_QA_EXPLAIN_ALT'     => 'Beweise, dass Du ein Mensch bist und beantworte die Frage',
-  'PLUPLOAD_PLACE_INLINE'        => 'Linear',
-  'PLUPLOAD_DELETE_FILE'         => 'Löschen',
-  
-  
-  'REG_CREATING'             => 'Profil erstellen...',
-  'LOADING'                  => 'Läd...',
-  'SAVING'                   => 'Speichert...',
-  'CANCELLING'               => 'Abbrechen...',
-  'SENDING'                  => 'Senden...',
-  'SEARCHING'                => 'Suchen...',
-  'LOADING_LOG_IN'           => 'Anmeldung...',
-  'FILE_UPLOADING'           => 'Hochladen...',
-  'CASTING_VOTE'             => 'Stimme wird eingetragen...',
-  'LOADING_FORM'             => 'Lade Formular',
-
-  
-  'MEMBERLIST_P_JOINED'          => 'ist dem Forum beigetreten',
-  
-  
-  'MEMBERLIST_P_EXPL'            => 'Zu diesem Zeitpunkt habe ich mich registriert. ;)',
-  'MEMBERLIST_P_DATE_EXPL'       => 'Dies war der Zeitpunkt als ich das letzte mal hier war.',
-  'SPAMMER_PLACEHOLDER'          => 'Du kannst nicht einfach unser Board zuspammen und dann abhauen!',
-  'MARK_PLACEHOLDER'             => 'Deine Wahl markieren',
-  'INFO_BOX'                     => 'Information:',
-  'USER_REMOVE_PLACEHOLDER'      => 'Klicken um Nutzer zu entfernen',
-  'GROUP_REMOVE_PLACEHOLDER'     => 'Klicken um Gruppe zu entfernen',
-  
-  'EDIT_LINK_PLACEHOLDER'        => 'Ich habe vergessen meine Links richtig zu erstellen',
-  'POST_IT_UP_PLACEHOLDER'       => 'Beitrag jetzt ersetellen!',
-  
-  'UCP_REG_USR_PLACEHOLDER'      => 'Bsp. John Doe',
-  'UCP_REG_EMAIL_PLACEHOLDER'    => 'Bsp. john@mail.com',
-  'UCP_REG_PSWD_PLACEHOLDER'     => 'Bsp. ASDFasdf123',
-  'UCP_REG_CAPCTHA_PLACEHOLDER'  => 'Bsp. blauer Himmel',
-  'SEARCH_USR_PLACEHOLDER'       => 'Bsp. SiteSplat',
-   'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E.g. 2018-12-22',
-	'IP_PLACEHOLDER'			=> 'E.g. 216.161.111.33',
-	'POSTS_PLACEHOLDER'			=> 'E.g. 12',
-	'SEARCH_KWDS_PLACEHOLDER'	=> 'E.g. cats, or cats+, or cats-, or cats|dogs, or cat*', 
-	
-	
-	
-	
-	
-	
-	
-	
-	
-	
-  'MESSAGE_ENTER_PLACEHOLDER'    => 'Nachricht eintragen...',
-  'FILE_COMMENT_PLACEHOLDER'     => 'Datei kommentieren',
-  'HEIGTH_PLACEHOLDER'           => 'Höhe',
-  'WIDTH_PLACEHOLDER'            => 'Weite',
-  'UCP_OCCUPATION_PLACEHOLDER'   => 'Bescheibe was Du arbeitest...',
-  'UCP_INTERESTS_PLACEHOLDER'    => 'Beschreibe Deine Interessen...',
-  'SOFT_DELETE_PLACEHOLDER'      => 'Gib an, warum Du hier bis, wenn Du magst...',
-  'ADD_DESCRIPTION'              => 'Beschreibung hinzufügen',
-  
-  'FILE_SELECT'                  => 'Datei auswählen',
-  'FILE_CHANGE'                  => 'wechseln',
-  
-  
-  
-  'SELECT_IMAGE'                 => 'Bild auswählen',
-  'NOTE'                         => 'merken',
-  'EDIT_DRAFT'                   => 'Entwurf bearbeiten',
-  'PM_BALOON_NOTIFICATION'       => 'Balonartige Ansicht für PM (Private Message) einstellen',
-  
-  'DAYS_AGO'                     => 'Tage zuvor',
-  'WORK_IN_PROGRESS'             => 'Wartung',
-  'DISABLE_MESSAGE'              => 'Forum ist nicht erreichbar',
-  
-  
-  'DISABLE_RETURN'               => 'Zurück zur Startseite',
-  'BOARD_DISABLED_SHUFFLE'       => 'Hab Spass und vergnüge Dich mit ein paar Buchstaben :-)',
-  'DISABLE_TEXT_TRY'             => 'Probier es doch aus!',
-  
-  
-  'DISABLE_TEXT_TYPE'            => 'tippe was ein und speichere es mit der Return-Taste...',
- 
-  'GRAVATAR_EXPLAIN'          	 => 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
-  'GRAVATAR_EXPLAIN_CONFIRM'     => 'Please confirm your email address here',
-  
-  
-  
-  'DELETE_POLL'              => 'Umfrage löschen',
-  'POLL_DELETE_HELPER'       => '(Dies löscht nur die Umfrage) markieren und absenden',
-  'JUMP_TO_POST'             => 'springe zum Beitrag',
-  'JUMP_SELECT_FORUM'            => 'Wähle Forum zum Wecheln aus',
-  'JUMP_TO_PAGE_NUMBER'          => 'Springe zu Seite #',
-  'VIEW_FIRST_UNREAD'        => 'Zeige ersten ungelesenen Beitrag',
-  'BOOKMARK_TOPIC_REMOVE'        => 'Lesezeichen entfernen',
-  
-  'NEW_MESSAGES'             => 'Neue Nachrichten',
-  'YOU_HAVE'                 => 'Du hast',
-  
-  
-  'AND'                      => 'und',
-  'HELLO'                    => 'Hallo',
-  'DISMISS_PM'               => 'Defer 5 min',
-  
-  'READ_NOW'                 => 'Jetzt lesen',
-  'PRIVATE_MESSAGE_NEW'	         => 'Neue private Nachricht',
-  'PRIVATE_MESSAGE_UNREAD'	     => 'Ungelesene private Nachricht',
-  
-  'NO_PMS_INFO'	                 => 'Alle gelesen! Erstelle neue PM?',
-  
-  'DATES'                    => 'DATUM',
-  
-  
-  
-  'POWERED'                  => 'Gesponsort von',
-  'HANDCRAFTED'              => 'in Handarbeit hergestellt mit',
-  'BY'                       => 'von',
-  'RECENT_TOPICS'            => 'Letzte Einträge',
-  'TWITTER'                  => 'Twitter',
-  'FAVORITES'                => 'Favoriten',
-
-  
-  'GALLERY'                  => 'Gallerie',
-  'CHAT'                     => 'Chat',
-  
-  
-  
-  
-  
-  'ABOUT'                    => 'Über uns',
-  'ABOUT_PART_ONE'           => 'BBOOTS&#8482; Ist das erste und einzige voll responsive inoffizielle  PhpBB&reg; HTML5/CSS3 Design. Das saubere und knagige aussehen macht sich echt gut auf allen Browsern und sonstigen Anzeigen.',
-  'ABOUT_PART_TWO'           => 'Es wartet mit einem Bootstrap basierten Grundgerüst auf, wurde lange Zeit hoffnungsvoll erwartet und wird sicherlich den phpBB Fan-Club total begeistern.',
-  'ABOUT_PART_THREE'         => 'Das inoffizielle responsive Design',
-  'BB'                       => 'B',
-  'BOOTS'                    => 'BOOTS',
-  'BBOOTS'                   => 'BBOOTS',
-  
-  'BBOOTS_VERSION'           => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
-  'U_LOGOUT'                 => 'Abmelden',
-
-  'SITESPLAT_STATISTICS'     => 'Statistiken',
-  'SITESPLAT_SEE_DETAILS'    => 'Siehe Details',
-  'SITESPLAT_SEARCH_LAST_DAY'    => 'Einträge der letzten 24 Stunden',
-  'SITESPLAT_SEARCH_WEEK'		 => 'Einträge der letzten 7 Tage',
-  
-  'SITESPLAT_TOTAL_POSTS'        => 'Beiträge insgesamt',
-  'SITESPLAT_TOTAL_TOPICS'       => 'Themen insgesamt',
-  'SITESPLAT_TOTAL_USERS'        => 'Mitglieder insgesamt',
-  'SITESPLAT_NEWEST_MEMBER'      => 'Unser neuestes Mitglied',
-  'SITESPLAT_USERS_ONLINE'       => 'Nutzer anwesend',
-  'SITESPLAT_MOST_USERS_ONLINE'  => 'Höchstanzahl zeitgleicher Besucher',
-  
-  'BOOTSTRAP_VERSION'	         => '3.3.5',
-  'FLATBOOTS'	                 => 'FLATBOOTS',
-  'CHANGE_AVATAR'              => 'Avatar ändern',
-  'CHANGE_PASSWORD'            => 'Passwort ändern',
-  
-  'ADMIN_TIPS'                 => 'Admin Tips &amp; Tricks',
-  
-  
-  
-  
-  'ADMIN_TIP_INTRO'            => 'Wusstest Du, dass Du Dein phpBB-Forum mit ein paar einfachen Handgriffen noch sicherer machen kannst?',
-  'ADMIN_TIP_ONE'              => 'Halte Deine Software immer auf dem aktuellsten Stand',
-  'ADMIN_TIP_TWO'              => 'Verwende immer sichere Passwörter mit abwechselnde unterschiedlichen Buchstaben, Nummern und Sonderzeichen.',
-  'ADMIN_TIP_THREE'            => 'Sperre den direkten Zugriff auf den Administrations-Ordner...',
-  'ADMIN_CHECK_IT_BTN'         => 'Besuche SiteSplat.com für mehr Information',
-  
-  'USER_MINI_PROFILE'            => 'Minimales Nutzerprofil',
-  'USER_MINI_PROFILE_VIEW_FULL'  => 'Zeige volles Profil',
-  'OFF_LINE'                     => 'Off-line',
-  'USER_STATUS'                  => 'Status',
-  
-  
-  
-  
-  
-  
-  'USER'                         => 'Nutzer',
-  'TITLE'                        => 'Titel',
-  'END_TIMELINE'                 => 'Ende der Zeitlinie',
-  'MEMBERS'                      => 'Mitglieder',
-  'DRAFTS'                       => 'Entwürfe',
-  'REPORTS'                      => 'Meldungen',
-  'MODERATOR_LOGS'               => 'Moderator Anmeldungen',
-  
-  'QUEUE'                        => 'Warteschlange',
-  'LINKS'                        => 'Links',
-  'TOPIC_PERMISSIONS'            => 'Themenberechtigungen',
-  'MODERATOR_OPTIONS'            => 'Moderationen',
-  'PASSWORD_EXPLAIN_CONFIRM'     => 'Sei Dir sicher, dass es passt',
-  'FORUM_REDIRECTS'              => 'Weiterleitungen:',
-  
-  'FANCY_TOPICS_TITLE'           => 'Letzte Themen dieses Forums',
- 
-
-
-
-
-
-  
-  'POST_BY'                      => 'Geschrieben von',
-  'REPLY_BY'                     => 'Antwort von',
-  'NO_REPLIES'                   => 'Keine Antworten',
-  'READ_MORE'                    => 'Weiter lesen...',
-  'RT_READ_MORE'                 => 'WEITER LESEN...',
-  'VIEW_MORE_TOPICS'             => 'weitere neue Einträge anzeigen',
-  'BACK_TO_START'                => 'ZURÜCK ZUM ANFANG',
-  
-  'TOGGLE_NAV'                   => 'Navigation verstecken',
-  
-  'DEMO_LINK'                  => 'Demonstraton, keine Bilder verlinkt',
-  'DEMO_HEADER_MENU'           => 'Webseiteneinleitungsbeispiel',
-  
-  'FLATBOOTS_INTRO'              => 'Bootstrap Framework',
-  
-  
-  'FLATBOOTS_EXPLAIN'            => 'Über ein Dutzend wiederverwendbare Erweiterungen vorhanden, z.B. Icons, Dropdown Listen, Navigation, Warnmeldungen und vieles mehr... ',
-  'CALL_TO_ACTION_FOOTER'        => 'Ein-/Auschalten von Erweiterungen. Nutze nur was Du wirklich benötigst!',
-  'PURCHASE_NOW_BTN'             => 'Jetzt kaufen',
-  
-  'FLATBOOTS_ABOUT_PART_ONE'     => 'Hier gibt es bald ein paar kurze Zeilen über das Board...',
-  'FLATBOOTS_ABOUT_TITLE'        => 'Gebaut für die Ewigkeit',
-  'DMCA'                         => 'DMCA',
-  
-  'TERMS'                        => 'Nutzungsbedingungen',
-  'ADVERTISE'                    => 'Werbung',
-  'SITESPLAT'                    => 'SiteSplat',
-  'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
-    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
-    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
-    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
-  'JOIN_US_TWITTER'              => 'Triff uns auf Twitter',
-  
-  'TWEET_EXAMPLE'                => 'BBOOTS erreichte 500 verkäufe! Vielen Dank Euch allen für die Unterstützung zu diesem erstaunlichen Projekt und zum Aufbau der SiteSplat Gemeinschaft. Was kommt als nächstes? Bleib am Ball und folge mir auf Twitter: <a href="#">http://bit.ly/000fefs</a>',
- 
-));
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/de/info_acp_bbcore.php" "[ORIGINAL]/sitesplat\\BBCore/language/de/info_acp_bbcore.php"
deleted file mode 100644
--- "[ORIGINAL]/sitesplat\\BBCore/language/de/info_acp_bbcore.php"
+++ /dev/null
@@ -1,103 +0,0 @@
-<?php
-/**
-*
-* common [English]
-*
-* @package language
-* @package sitesplat BBcore
-* @version $Id$
-* @copyright (c) 2015 SiteSplat All rights reserved
-* @license Proprietary
-*
-*/
-
-// TRANSLATORS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
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
-	$lang = array();
-}
-
-$lang = array_merge($lang, array(
-	'SS_AUTOUPDATE_DISABLED'		=>'<strong style="font-size:1.4em">BBCore auto-update is disabled!</strong>',
-	'SS_BAD_FILESYSTEM'				=> 'You are using an obsolete PHP handler that makes your filesystem unwritable by phpBB.<br>Please consider installing a modern FastCGI PHP handler such as PHP-FPM.',
-	'SS_SYSINFO'					=> 'System Information',
-	'SS_FOUNDERS'					=> 'Founders',
-	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
-	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a> or go to the <a href="%s">SiteSplat Update Manager</a>.',
-
-    'VERSION_INSTALLED'  			=> 'Installed Version',
-	'NEW_BOOTS_VERSION'				=> '🌟 New %s version available 🌟',
-	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
-	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
-	
-	'DOWNLOAD_MSG'					=> 'New Latest Current version: <span class="label label-success">%s</span>',
-	'DOWNLOAD_BTN_ENVATO'		    => ' <a class="btn btn-default sitesplat-bbcore-autoupdate" href="%s" title="Download from envato" target="_blank">View Envato item</a>',
-	'DOWNLOAD_MSG_NO_UPD'			=> 'All good! looks like you are up to date! 👍💯',
-	'START_AUTO'				    => 'Start Auto-update 🚀',
-	
-	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s - Changelog</a>',
-	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
-	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
-	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',
-
-    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
-    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
-    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
-    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
-  
-    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
-    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
-	
-	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
-	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',
-
-	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
-	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
-    
-	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin log under the MAINTENANCE tab.',
-	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
-	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',
-
-	// autoupdate
-	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
-	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP!!!',
-    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
-	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
-	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
-	'NO_DIRECT_DOWNLOAD'			=> 'Unable to automatically update your style because the style author did not provide the necessary files.',
-	'PROBLEM_DOWNLOADING_UPDATE'	=> 'Unable to download the update files at the moment. Please try again later.',
-	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
-	'MERGE_CONFLICTS'				=> 'Oh No! 😱 ¯\_(ツ)_/¯ The system was unable to automatically update your premium theme. The possbile reasons could be due to your theme files being corrupted or containing custom changes that the auto-update is unable to automatically solve. In order to help you with this situation, see the generated conflicting files and/or conflicts they contain, saved in:<br /><br /><strong>%s</strong>.',
-	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
-	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
-	'UPDATE_SUCCESS'				=> 'Yeehaw! Your Premium Theme has Been Updated Successfully 💯. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="https://themeforest.net/downloads?ref=ThemeSplat" target="_blank">https://themeforest.net/downloads</a>',
-    'CURRENT_FILE'					=> 'Current file',
-	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
-	'NEW_FILE'						=> 'New file',
-
-	// log
-	'LOG_STYLE_UPDATED'	=> '<strong>BBcore auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
-));
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/en/BBCore.php" "[FORUM_EXT]/sitesplat\\BBCore/language/en/BBCore.php"
--- "[ORIGINAL]/sitesplat\\BBCore/language/en/BBCore.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/en/BBCore.php"
@@ -36,11 +36,9 @@ if (empty($lang) || !is_array($lang)) {
 }
 
 // load addon lang files first...allow BBCore to overwrite if needed
-if (function_exists('\sitesplat\load_ext_lang')) {
 $addon_lang = [];
 \sitesplat\load_ext_lang(__DIR__, $addon_lang);
 $lang = array_merge($lang, $addon_lang);
-}
 
 // BBCore
 $lang = array_merge($lang, array(
@@ -67,7 +65,6 @@ $lang = array_merge($lang, array(
 	'SS_CHATBOX'				=> 'Chat',
 	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
 	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
 
 	'SS_ADDONS'				=> 'Addons',
 	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
@@ -270,6 +267,7 @@ $lang = array_merge($lang, array(
 	'NOTE'						=> 'Note',
 	'EDIT_DRAFT'				=> 'Edit Draft',
 	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
+	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Mark all read',
 	'DAYS_AGO'					=> 'Days ago',
 	'WORK_IN_PROGRESS'			=> 'Maintenance',
 	'DISABLE_MESSAGE'			=> 'Board unavailable',
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/fr/BBCore.php" "[ORIGINAL]/sitesplat\\BBCore/language/fr/BBCore.php"
deleted file mode 100644
--- "[ORIGINAL]/sitesplat\\BBCore/language/fr/BBCore.php"
+++ /dev/null
@@ -1,398 +0,0 @@
-<?php
-/**
-*
-* BBCore [English]
-*
-* @package sitesplat BBcore
-* @copyright (c) 2015 SiteSplat All rights reserved
-* @license Proprietary
-*
-*/
-
-// TRANSLATORS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, Par exemple: instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, Par exemple: 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order Par exemple:, 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB')) {
-	exit;
-}
-if (empty($lang) || !is_array($lang)) {
-	$lang = array();
-}
-
-// load addon lang files first...allow BBCore to overwrite if needed
-if (function_exists('\sitesplat\load_ext_lang')) {
-    $addon_lang = [];
-    \sitesplat\load_ext_lang(__DIR__, $addon_lang);
-    $lang = array_merge($lang, $addon_lang);
-}
-
-// BBCore
-$lang = array_merge($lang, array(
-	'PM_NEW_MSG' => [
-		1 => 'You have %d New Private Message',
-		2 => 'You have %d New Private Messages',
-	],
-	'PM_UNREAD_MSG' => [
-		1 => 'You have %d Unread Private Message',
-		2 => 'You have %d Unread Private Messages',
-	],
-	'PM_NEW_MSG_BUBBLE' => [
-		1 => '%d',
-		2 => '%d',
-	],
-
-	'SITESPLAT_EXT'				=> 'Other Extensions',
-	'BBCORE_DASHBOARD'			=> 'Dashboard',
-	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
-	'BBCORE_SETTINGS'			=> 'Settings',
-	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
-	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
-	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
-	'SS_CHATBOX'				=> 'Chat',
-	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
-	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
-	'BBCORE_BAD_PHP'			=> 'You are using a non-standard build of PHP!',
-
-	'SS_ADDONS'				=> 'Addons',
-	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
-	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
-
-	'UCP_MAIN'				=> 'Vue Générale',
-	'UCP_MAIN_FRONT'		=> 'Tableau de bord',
-	'UCP_MAIN_SUBSCRIPTION'	=> 'Gérer les abonnements',
-	'UCP_MAIN_BOOKMARKS'	=> 'Gérer les favoris',
-	'UCP_MAIN_DRAFTS'		=> 'Gérer les brouillons',
-	'UCP_MAIN_ATTACHMENTS'	=> 'Gérer les pièces jointes',
-
-	'USER_PANEL'				=> 'Panneau de contrôle',
-	'UCP_PROFILE'				=> 'Profil',
-	'UCP_PROFILE_PROFILE'		=> 'Editer profil',
-	'UCP_PROFILE_SIGNITURE'		=> 'Editer signature',
-	'UCP_PROFILE_AVATAR'		=> 'Editer avatar',
-	'UCP_PROFILE_SETTINGS'		=> 'Paramètres compte',
-	'UCP_AVATAR_SELECT_OPTIONS'	=> 'Avatar options',
-	'UCP_AVATAR_SELECT_UPLOAD'	=> 'Télécharger un avatar',
-	'UCP_SUBMIT_TO_UPLOAD'		=> 'Submit below to upload',
-
-	'UCP_PREFERENCE'			=> 'Préférences Forum',
-	'UCP_PREFERENCE_SETTINGS'	=> 'Editer paramètres',
-	'UCP_PREFERENCE_DEFAULTS'	=> 'Edit posting defaults',
-	'UCP_PREFERENCE_OPTIONS'	=> 'Editer options affichage',
-
-	'UCP_MESSAGES'				=> 'Messages',
-	'UCP_PM_COMPOSE'			=> 'Ecrire message',
-	'UCP_PM_DRAFTS'				=> 'Gérer brouillons',
-	'UCP_PM_INBOX'				=> 'Reçus',
-	'UCP_PM_OUTBOX'				=> 'Outbox',
-	'UCP_PM_SENTBOX'			=> 'Envoyé',
-	'UCP_PM_OPTIONS'			=> 'Règles, dossiers &amp; paramètres',
-	'UCP_NO_USER_CHANGE_ALLOWED'	=> '**Username change is not allowed**',
-	'UCP_REGISTER_EMAIL_EXPLAIN'	=> 'Please do not use disposable emails',
-
-	'WIDTH_SIZE'			=> 'largeur',
-	'PIXEL_SIZE'			=> 'px',
-	'HEIGHT_SIZE'			=> 'hauteur',
-
-	'UCP_GROUPS'			=> 'Groupe Utilisateurs',
-	'UCP_GROUPS_MEMBERSHIP'	=> 'Edit membership',
-	'UCP_GROUPS_MANAGE'		=> 'Gérer groupes',
-
-	'UCP_ZEBRA'					=> 'Amis &amp; Ignorés',
-	'UCP_ZEBRA_FRIENDS'			=> 'Gérer Amis',
-	'UCP_ZEBRA_FOES'			=> 'Gérer Ignorés',
-	'UCP_APPLY'					=> 'Appliquer',
-	'UCP_PM_DEFAULT_RULE_TAG'	=> 'Default action',
-	'UCP_PM_DEFAULT_RULE'		=> 'Ne pas accepter nouveaux messages',
-	'UCP_PM_DEFAULT_RULE_EXPLAIN'	=> 'This action will be triggered only if none of the above options is applicable. New messages will be held back until enough space is available.',
-	'UCP_PM_NEW_MESSAGE'		=> 'Nouveau Message',
-	'BIO'						=> 'Bio Informations Perso',
-	'MANAGE'					=> 'Gérer',
-	'JOINED_BOARD'				=> 'a rejoint le forum',
-	'VISITED_BOARD'				=> 'Dernière visite',
-	'SEE_MORE'					=> 'Plus',
-	'ATTACH_SIGNATURE'			=> 'Joindre signature',
-	'BBCODES'					=> 'BBcodes',
-
-	'DELETE_POST_SOFT'			=> 'Soft Delete post',
-	'DELETE_POST_PERMANENT'		=> 'Perma Delete post',
-	'DELETE_POST_SOFT_WARN'		=> 'It can be recovered',
-	'DELETE_POST_PERMANENT_WARN'	=> 'It can NOT be recovered',
-
-	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	=> 'Enter the max number of options the user can select',
-	'POLL_VOTE_CHANGE_LABEL'	=> 'Allow Re-vote',
-	'NO_VOTES_NA'				=> 'Non Dispo',
-	'NOT_AVAILABLE'				=> 'Non disponible',
-	'POST_TOPIC_NEW'			=> 'Nouveau Sujet',
-	'QUICK_REPLY_SHOW_HIDE'		=> 'Show/Hide Quick Reply',
-	'CHARACTERS_COUNT'			=> 'Caractères',
-	'CHARACTERS_COUNT_REM'		=> 'Remaining',
-	'BOOKMARKED_TOPICS_UCP'		=> 'Bookmarked Topics',
-	'ATTACH_EXPLANATION_SORTABLE'	=> 'Click to sort',
-	'ATTACH_FORUM'				=> 'Attachment(s)',
-	'MCP_DETAILS_LOG'			=> 'Details',
-	'MCP_DETAIL_U_IP'			=> 'User &amp; IP',
-	'MCP_MANAG_BAN'				=> 'Ban Management',
-	'MCP_UNAPPROVED_POSTS_ZERO'	=> 'There are no posts waiting for approval',
-	'MCP_REPORTS_ZERO'			=> 'There are no reports to review',
-	'MCP_PM_REPORTS_ZERO'		=> 'There are no PM reports to review',
-
-
-	'SUBFORUM_LINK'				=> 'Link opens in a new tab',
-	'FORUMLIST_UNAPPROVED'		=> 'At least one topic in this forum has not been approved',
-	'FORUMLIST_UNAPPROVED_POST'	=> 'At least one post in this forum has not been approved',
-	'FORUMLIST_LASTPOST'		=> 'View the latest post',
-	'TOPICS_POSTS_STATISTICS'	=> 'Statistics',
-	'TOPICS_ROW_REPORTED'		=> 'This Topic has been reported',
-	'TOPICS_ROW_NOT_APPROVED'	=> 'This Topic has not been approved',
-	'TOPICS_ROW_DELETED'		=> 'This Topic has been deleted',
-	'MODERATOR_PANEL_GENERAL'	=> 'Moderator Panel',
-	'ADMIN_PANEL_GENERAL'		=> 'Administrator Panel',
-	'RANK_IMAGE'				=> 'Rank image',
-
-	'WELCOME_INDEX'			=> 'Bienvenue',
-	'FAQ'					=> 'FAQ',
-	'CAPTION_FAQ'			=> 'Foire Aux Questions',
-	'CAPTION_SEARCH'		=> 'Search it up!',
-	'CAPTION_MEMBERS'		=> 'Vous cherchez une personne?',
-	'MEMBERS_CAP'			=> 'Membres',
-	'CAPTION_UCP'			=> 'Choisir vos préférences',
-	'UCP_CAP'				=> 'Panneau Utilisateur',
-	'INDEX_CAPTION'			=> 'Page principale du forum',
-	'VIEWTOPIC_CAP'			=> 'Titre Sujet',
-	'CAPTION_VIEWTOPIC'		=> 'Description sujet',
-	'CAPTION_VIEWFORUM'		=> 'Visualiser toutes les catégories du forum',
-	'POSTINGS_CAP'			=> 'Editeur',
-	'CAPTION_POSTINGS'		=> 'Posting things up!',
-
-	'MCP_CAPTION'				=> 'This is where you get to use the Super Powers ;-)',
-	'BOOTSTRAP_ELEMENT'			=> 'Bootstrap Elements',
-	'BOOTSTRAP_ELEMENT_CAPTION'	=> 'Forum KickStart Documentation',
-	'MAIN_FORUM'				=> 'Forum',
-	'MAIN_MAIN_STUFF'			=> 'The Main stuff',
-	'MAIN_TRENDS'				=> 'See the trends',
-
-	'MAIN_SEARCH_IT_UP'		=> 'Search it up',
-	'SUB_NO_ICON'			=> 'No Icon here at all',
-	'EXAMPLE_WITH_ICON'		=> 'Example With Icon',
-	'EXAMPLE_LINK'			=> 'Example Link',
-	'MAIN_SOCIAL'			=> 'Social',
-	'SOCIAL_P'				=> 'Chat away ;-)',
-
-	'MORE'					=> 'Plus',
-	'EXPAND_CLOSE'			=> 'Fermer la Vue',
-	'MARK_TOPICS_READ'		=> 'Mark Topics Read',
-	'CONTACT'				=> 'Contact',
-	'GET_IN_TOUCH'			=> 'Get in touch',
-	'HANG_AROUND'			=> 'Bienvenue chez vous',
-	'JOIN_THE_CLUB'			=> 'Rejoignez la communauté',
-	'MENU'					=> 'MENU',
-	'YOU_ARE_HERE'			=> 'Vous êtes ici',
-	'IN_FOOTER'				=> 'Dans:',
-	'REPLY'					=> 'Répondre',
-
-	'LOGIN_REMEMBER'		=> 'Me garder connecté',
-	'LOGIN_HIDE_ME'			=> 'Cacher ma session',
-	'LOGIN_ME_IN'			=> 'Me connecter',
-	'SIGN_IN_ACCOUNT'		=> 'Sign in onto your account',
-	'CREATE_ACCOUNT'		=> 'Créer un Compte',
-	'GO_TO_SEARCH_ADV'		=> 'Retourner à la recherche avancée',
-
-	'CREATE_ACCOUNT_DISABLED'	=> 'Registrations closed',
-	'REGISTRATION_DISABLED'		=> 'It looks like the registrations are closed at the moment. It could also be a temporary measure. If you believe this is a possible error, please contact the webmaster and let him know. We apologize for any inconvenience this might have caused. Our Privacy Policy and Terms of Use are available below.',
-	'CONTACT_WEBMASTER'			=> 'Contacter le Webmaster',
-	'CONFIRM_QA_EXPLAIN_ALT'	=> 'Pour être sûr que vous êtes un humain, répondez à cette question',
-
-	'PLUPLOAD_PLACE_INLINE'	=> 'Inline',
-	'PLUPLOAD_DELETE_FILE'	=> 'Effacer',
-
-
-	'REG_CREATING'			=> 'Création Profil...',
-	'LOADING'				=> 'Chargement...',
-	'SAVING'				=> 'Sauvegarde...',
-	'CANCELLING'			=> 'Annulation...',
-	'SENDING'				=> 'Envoi...',
-	'SEARCHING'				=> 'Recherche...',
-	'LOADING_LOG_IN'		=> 'Connexion...',
-	'FILE_UPLOADING'		=> 'Téléchargement...',
-	'CASTING_VOTE'			=> 'Casting vote...',
-	'LOADING_FORM'			=> 'Loading form...',
-
-	'MEMBERLIST_P_JOINED'		=> 'Joined the board',
-	'MEMBERLIST_P_EXPL'			=> 'This is when I joined the board',
-	'MEMBERLIST_P_DATE_EXPL'	=> 'This was last time I visited the board',
-	'SPAMMER'					=> 'Spammer',
-	'SPAMMER_PLACEHOLDER'		=> 'You cannot just spam our board and get away with it!',
-	'MARK_PLACEHOLDER'			=> 'Checkmark your choice',
-	'INFO_BOX'					=> 'Information:',
-	'USER_REMOVE_PLACEHOLDER'	=> 'Click to remove user',
-	'GROUP_REMOVE_PLACEHOLDER'	=> 'Click to remove group',
-	'EDIT_LINK_PLACEHOLDER'		=> 'Par exemple: I forgot to code my links',
-	'POST_IT_UP_PLACEHOLDER'	=> 'Post it up!',
-
-	'UCP_REG_USR_PLACEHOLDER'	=> 'Par exemple: John Doe',
-	'UCP_REG_EMAIL_PLACEHOLDER'	=> 'Par exemple: john@mail.com',
-	'UCP_REG_PSWD_PLACEHOLDER'	=> 'Par exemple: ASDFasdf123',
-	'UCP_REG_CTCHA_PLACEHOLDER'	=> 'Par exemple: blue sky',
-	'SEARCH_USR_PLACEHOLDER'	=> 'Par exemple: SiteSplat',
-	'YEAR_MONTH_DAY_PLACEHOLDER'	=> 'E. 2018-12-22',
-	'IP_PLACEHOLDER'			=> 'Par exemple: 216.161.111.33',
-	'POSTS_PLACEHOLDER'			=> 'Par exemple: 12',
-	'SEARCH_KWDS_PLACEHOLDER'	=> 'Par exemple: cats, or cats+, or cats-, or cats|dogs, or cat*',
-
-	'MESSAGE_ENTER_PLACEHOLDER'	=> 'Ecrivez votre message...',
-	'FILE_COMMENT_PLACEHOLDER'	=> 'Commentez votre fichier',
-	'HEIGTH_PLACEHOLDER'		=> 'hauteur',
-	'WIDTH_PLACEHOLDER'			=> 'largeur',
-	'UCP_OCCUPATION_PLACEHOLDER'	=> 'Décrivez brièvement votre job...',
-	'UCP_INTERESTS_PLACEHOLDER'	=> 'Décrivez vos intérêts...',
-	'SOFT_DELETE_PLACEHOLDER'	=> 'Enter your reason if you wish to...',
-	'ADD_DESCRIPTION'			=> 'Ajouter description',
-
-	'FILE_SELECT'				=> 'Choisir fichier',
-	'FILE_CHANGE'				=> 'Changer',
-	'SELECT_IMAGE'				=> 'Choisir image',
-	'NOTE'						=> 'Note',
-	'EDIT_DRAFT'				=> 'Edit Draft',
-	'PM_BALOON_NOTIFICATION'	=> 'Enable floating style notification for new PM (Private Message)',
-	'DAYS_AGO'					=> 'Jours',
-	'WORK_IN_PROGRESS'			=> 'Maintenance',
-	'DISABLE_MESSAGE'			=> 'Forum indisponible',
-	'DISABLE_RETURN'			=> 'Retourner à la page Accueil',
-	'BOARD_DISABLED_SHUFFLE'	=> 'Have fun and shuffle some letters :-)',
-	'DISABLE_TEXT_TRY'			=> 'Test it for yourself!',
-	'DISABLE_TEXT_TYPE'			=> 'type anything and hit return...',
-
-	'GRAVATAR_EXPLAIN'			=> 'If a <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> is associated to your email address, it will be set as default.',
-	'GRAVATAR_EXPLAIN_CONFIRM'	=> 'Merci de confirmer votre email ici',
-
-	'DELETE_POLL'			=> 'Delete poll',
-	'POLL_DELETE_HELPER'	=> '(This deletes the poll only) check and submit',
-	'JUMP_TO_POST'			=> 'Aller au message',
-	'JUMP_SELECT_FORUM'		=> 'Choisir le forum où aller',
-	'JUMP_TO_PAGE_NUMBER'	=> 'Aller à la page #',
-	'VIEW_FIRST_UNREAD'		=> 'Lire message non lu en premier',
-	'BOOKMARK_TOPIC_REMOVE'	=> 'Enlever favori',
-
-	'NEW_MESSAGES'				=> 'Nouveaux messages',
-	'YOU_HAVE'					=> 'Vous avez',
-	'AND'						=> 'et',
-	'HELLO'						=> 'Bonjour',
-	'DISMISS_PM'				=> 'Defer 5 min',
-	'READ_NOW'					=> 'Lire maintenant',
-	'PRIVATE_MESSAGE_NEW'		=> 'nouveau message privé',
-	'PRIVATE_MESSAGE_UNREAD'	=> 'message privé non lu',
-	'NO_PMS_INFO'				=> 'Ok! Ecrire un nouveau MP?',
-
-	'DATES'					=> 'DATE',
-	'POWERED'				=> 'Propulsé par',
-	'HANDCRAFTED'			=> 'Fait par',
-	'BY'					=> 'Par',
-
-	'RECENT_TOPICS'			=> 'Sujets Récents',
-	'TWITTER'				=> 'Twitter',
-	'FAVORITES'				=> 'Favoris',
-
-	'GALLERY'				=> 'Gallerie',
-	'CHAT'					=> 'Chat',
-	'ABOUT'					=> 'A Propos',
-	'ABOUT_PART_ONE'		=> 'BBOOTS&#8482; Is The First And Only Fully Responsive PhpBB&reg; Unofficial HTML5/CSS3 Theme. It’s Clean And Crisp Design Looks AWESOME Across All Browsers And Devices.',
-	'ABOUT_PART_TWO'		=> 'It Utilizes A Bootstrap Based Layout Which Has Been Long Waited For And That Is Sure To AMAZE The phpBB Fan Club.',
-	'ABOUT_PART_THREE'		=> 'The Unofficial Responsive Theme',
-	'BB'					=> 'B',
-	'BOOTS'					=> 'BOOTS',
-	'BBOOTS'				=> 'BBOOTS',
-
-	'BBOOTS_VERSION'		=> '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
-	'U_LOGOUT'				=> 'Se déconnecter',
-
-	'SITESPLAT_STATISTICS'		=> 'Statistiques',
-	'SITESPLAT_SEE_DETAILS'		=> 'Voir Details',
-	'SITESPLAT_SEARCH_LAST_DAY'	=> 'Derniers messages sur 24H',
-	'SITESPLAT_SEARCH_WEEK'		=> 'Derniers messages sur 7 jours',
-
-	'SITESPLAT_TOTAL_POSTS'		=> 'Total messages',
-	'SITESPLAT_TOTAL_TOPICS'	=> 'Total sujets',
-	'SITESPLAT_TOTAL_USERS'		=> 'Total membres',
-	'SITESPLAT_NEWEST_MEMBER'	=> 'Newest Member',
-	'SITESPLAT_USERS_ONLINE'	=> 'Utilisateurs en ligne',
-	'SITESPLAT_MOST_USERS_ONLINE'	=> 'Most Users Online',
-	'SITESPLAT_BIRTHDAYS'		=> 'Today\'s birthdays',
-
-	'BOOTSTRAP_VERSION'		=> '3.3.6',
-	'FLATBOOTS'				=> 'FLATBOOTS',
-	'CHANGE_AVATAR'			=> 'Change Avatar',
-	'CHANGE_PASSWORD'		=> 'Change Password',
-
-	'ADMIN_TIPS'			=> 'Admin Tips &amp; Tricks',
-	'ADMIN_TIP_INTRO'		=> 'Did you know you can make your phpBB forum even more secure with some simple steps?',
-	'ADMIN_TIP_ONE'			=> 'Keep your software up to-date.',
-	'ADMIN_TIP_TWO'			=> 'Always use strong passwords that contain random sequence of letters, numbers and special characters.',
-	'ADMIN_TIP_THREE'		=> 'Restrict the admin folder access...',
-	'ADMIN_CHECK_IT_BTN'	=> 'Visit SiteSplat.com for more',
-
-	'USER_MINI_PROFILE'			=> 'User mini profile',
-	'USER_MINI_PROFILE_VIEW_FULL'	=> 'View full profile',
-	'OFF_LINE'					=> 'Off-line',
-	'USER_STATUS'				=> 'Status',
-	'USER'						=> 'User',
-	'TITLE'						=> 'Title',
-	'END_TIMELINE'				=> 'End timeline',
-	'MEMBERS'					=> 'Members',
-	'DRAFTS'					=> 'Drafts',
-	'REPORTS'					=> 'Reports',
-	'MODERATOR_LOGS'			=> 'Moderator logs',
-	'QUEUE'						=> 'Queue',
-	'LINKS'						=> 'Links',
-	'TOPIC_PERMISSIONS'			=> 'Topic permissions',
-	'MODERATOR_OPTIONS'			=> 'Moderate',
-	'PASSWORD_EXPLAIN_CONFIRM'	=> 'Make sure it matches',
-	'FORUM_REDIRECTS'			=> 'Redirects:',
-
-	'FANCY_TOPICS_TITLE'	=> 'Recent topics from the forum',
-	'POST_BY'				=> 'Post by',
-	'REPLY_BY'				=> 'Reply by',
-	'NO_REPLIES'			=> 'No replies',
-	'READ_MORE'				=> 'Read more',
-	'RT_READ_MORE'			=> 'READ MORE',
-	'VIEW_MORE_TOPICS'		=> 'VIEW MORE TOPICS',
-	'BACK_TO_START'			=> 'BACK TO START',
-
-	'TOGGLE_NAV'			=> 'Toggle Navigation',
-	'NAVIGATION'			=> 'Navigation',
-
-	'DEMO_LINK'				=> 'Demo link no icons',
-	'DEMO_HEADER_MENU'		=> 'Header intro example',
-
-	'FLATBOOTS_INTRO'			=> 'Bootstrap Framework',
-	'FLATBOOTS_EXPLAIN'			=> 'Over a dozen reusable components built to provide iconography, dropdowns, input groups, navigation, alerts, and much more...',
-	'CALL_TO_ACTION_FOOTER'		=> 'Swap-in out addons, use only what you really need!',
-	'PURCHASE_NOW_BTN'			=> 'Purchase now',
-	'FLATBOOTS_ABOUT_PART_ONE'	=> 'Why Would you Settle for Less when you can have More? Do not let other Authors Fool you with Empty Marketing Keywords. FLATBOOTS is what you Deserve. Built to last, Built from Scratch, Nothing Less.',
-	'FLATBOOTS_ABOUT_TITLE'		=> 'Built to last',
-	'DMCA'						=> 'DMCA',
-	'TERMS'						=> 'Terms',
-	'ADVERTISE'					=> 'Advertise',
-	'SITESPLAT'					=> 'SiteSplat',
-    'SITESPLAT_URL'	            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
-    'SS_URL'	                => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
-    'PHPBB_CREDIT'	            => 'Powered By <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> and ',
-    'SS_HANDCRAFTED'	        => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, handcrafted with <i class="fa fa-heart text-flatboots-red"></i> and <i class="fa fa-coffee"></i>',
-	'JOIN_US_TWITTER'			=> 'Join us on Twitter',
-	'TWEET_EXAMPLE'				=> 'BBOOTS reaches 2000 sales! Thank-you all for supporting this amazing project and contributing to built the SiteSplat Community. What\'s next? stay tuned and Follow Me on Twitter: <a href="#">http://bit.ly/000fefs</a>',
-));
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/fr/info_acp_bbcore.php" "[ORIGINAL]/sitesplat\\BBCore/language/fr/info_acp_bbcore.php"
deleted file mode 100644
--- "[ORIGINAL]/sitesplat\\BBCore/language/fr/info_acp_bbcore.php"
+++ /dev/null
@@ -1,103 +0,0 @@
-<?php
-/**
-*
-* common [English]
-*
-* @package language
-* @package sitesplat BBcore
-* @version $Id$
-* @copyright (c) 2015 SiteSplat All rights reserved
-* @license Proprietary
-*
-*/
-
-// TRANSLATORS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
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
-	$lang = array();
-}
-
-$lang = array_merge($lang, array(
-	'SS_AUTOUPDATE_DISABLED'		=>'<strong style="font-size:1.4em">BBCore auto-update is disabled!</strong>',
-	'SS_BAD_FILESYSTEM'				=> 'You are using an obsolete PHP handler that makes your filesystem unwritable by phpBB.<br>Please consider installing a modern FastCGI PHP handler such as PHP-FPM.',
-	'SS_SYSINFO'					=> 'System Information',
-	'SS_FOUNDERS'					=> 'Founders',
-	'ACP_SITESPLAT_UPDATE_MANAGER'  => 'SiteSplat Update Manager',
-	'VERSIONNUMBERS'				=> 'Installed Version: %s, download the new version from the server: <a style="color:#fff;" href="%s" title="Download" target="_blank">%s</a> or go to the <a href="%s">SiteSplat Update Manager</a>.',
-
-    'VERSION_INSTALLED'  			=> 'Installed Version',
-	'NEW_BOOTS_VERSION'				=> '🌟 New %s version available 🌟',
-	'SS_RAPID_DISABLE'				=> 'SS Rapid Disable',
-	'SS_RAPID_DISABLE_TLT'		    => 'Disables (all) extensions at once. Make a backup first!!!',
-	
-	'DOWNLOAD_MSG'					=> 'New Latest Current version: <span class="label label-success">%s</span>',
-	'DOWNLOAD_BTN_ENVATO'		    => ' <a class="btn btn-default sitesplat-bbcore-autoupdate" href="%s" title="Download from envato" target="_blank">View Envato item</a>',
-	'DOWNLOAD_MSG_NO_UPD'			=> 'All good! looks like you are up to date! 👍💯',
-	'START_AUTO'				    => 'Start Auto-update 🚀',
-	
-	'CHANGE_LOG_MSG'				=> 'The Changelog is located here: <a href="%s" target="_blank">%s - Changelog</a>',
-	'SUPPORT_FORUM_MSG'				=> 'The support forum is on the official Community Page: <a href="%s" title="Download" target="_blank">https://sitesplat.com</a>',
-	'COLORIZE_MSG'					=> 'The Colorize service is located here: <a href="https://sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Make sure you are logged in)',
-	'NO_VERSIONINFO'				=> 'No version info available at the moment, try again in a few minutes!',
-
-    'LOG_FILES_CHANGED'			    => '<strong>BBcore changed the following %s files for you:</strong><br />» %s',
-    'LOG_THEME_INSTALLED'			=> '<strong>BBcore installed successfully</strong>',
-    'LOG_FILES_CHANGED_FAILED'	    => '<strong>BBcore was not installed successfully</strong><br />» Some functions may not work!',
-    'LOG_THEME_UNINSTALLED'		    => '<strong>BBcore uninstalled successfully</strong>',
-  
-    'LOG_FILE_NOT_REPLACED'		    => '<strong>BBcore could not replace original file for you:</strong><br />» %s',
-    'LOG_FILE_NOT_UPDATED'		    => '<strong>BBcore could not update the following %s file for you:</strong><br />» %s',
-	
-	'LOG_BBCORE_INSTALLED'			=> '<strong>Sitesplat BBCore installed successfully</strong>',
-	'LOG_BBCORE_DEINSTALLED'		=> '<strong>Sitesplat BBCore uninstalled successfully</strong>',
-
-	'LOG_BBCORE_NOT_REPLACED'		=> '<strong>Sitesplat BBCore did not uninstall correctly</strong><br />Could NOT replace the following file(s)<br />» %s',
-	'LOG_BBCORE_NOT_UPDATED'		=> '<strong>Sitesplat BBCore did not install correctly</strong><br />Could NOT update the following file(s)<br />» %s',
-    
-	'ACP_BBCORE_MSG_FILES_FAIL'		=> 'NOT all files were edited! Please replace manually the file(s) mentioned in the admin log under the MAINTENANCE tab.',
-	'ACP_BBCORE_MSG_SETTINGS'		=> 'There No Configuration setting for this extension.<br />However not all updates were implemented properly due to the server file permissions or missing files. <br />See the admin log for more details.<br /><br />Please update the files permission manually.',
-	'BBCORE_ERROR_DISABLE'		    => 'You cannot disable SiteSplat BBCore due to other active SiteSplat\'s extensions.<br />Disable SiteSplat\'s extensions first. (You can use the rapid disable to disable all the SiteSplat\'s extensions at once.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>',
-
-	// autoupdate
-	'AUTOUPDATE_CONFIRM'			=> 'Confirm',
-	'AUTOUPDATE_CONFIRM_CONFIRM'	=> 'Are you sure you wish to update the theme with the auto-update?<br /><br /><strong>NOTE:</strong> The board will be disabled and the board cache will be automatically cleared for you after the update.<br /> A log of the changes is also saved under the ACP Admin log. <br /> A backup of your style (time stamped) will be stored for your convenience under the phpBB root/store/ folder on your server. <br />Make sure to clear your browser cache after the update and if you use CloudFlare make sure to clear the cache there as well plus clear again the forum cache via ACP!!!',
-    'UPDATE_IN_PROGRESS'			=> 'Update in progress. Do not close this tab.',
-	'STYLE_NOT_DEFINED'				=> 'You did not define a style to update.',
-	'ALREADY_UP_TO_DATE'			=> 'Your style is already up to date.',
-	'NO_DIRECT_DOWNLOAD'			=> 'Unable to automatically update your style because the style author did not provide the necessary files.',
-	'PROBLEM_DOWNLOADING_UPDATE'	=> 'Unable to download the update files at the moment. Please try again later.',
-	'DOWNLOADED_FILE_CORRUPTED'		=> 'The update file is corrupted.',
-	'MERGE_CONFLICTS'				=> 'Oh No! 😱 ¯\_(ツ)_/¯ The system was unable to automatically update your premium theme. The possbile reasons could be due to your theme files being corrupted or containing custom changes that the auto-update is unable to automatically solve. In order to help you with this situation, see the generated conflicting files and/or conflicts they contain, saved in:<br /><br /><strong>%s</strong>.',
-	'REQUIRED_FILE_MISSING'			=> 'A required file is missing from your style: %s',
-	'NEW_FILE_ALREADY_EXISTS'		=> 'A file to be added already exists: %s',
-	'UPDATE_SUCCESS'				=> 'Yeehaw! Your Premium Theme has Been Updated Successfully 💯. Enjoy!<br />Also, don\'t forget to check for any updates of your SiteSplat Premium Extensions.<br /><br /> Oh, if you are really in a fantastic mood now that I made your life easier and faster 😜 how about a digital high 5? like for example a 5 stars ⭐⭐⭐⭐⭐ rating on Themeforest about this Premium Theme with super PRO functions? <br /><br />Pretty Please? 😚 Here is the link for ya: <a href="https://themeforest.net/downloads?ref=ThemeSplat" target="_blank">https://themeforest.net/downloads</a>',
-    'CURRENT_FILE'					=> 'Current file',
-	'DIFF_SEP_EXPLAIN'				=> 'Conflict',
-	'NEW_FILE'						=> 'New file',
-
-	// log
-	'LOG_STYLE_UPDATED'	=> '<strong>BBcore auto-updated %s style</strong><br />Edited:<br />&emsp;%s<br /><br />Added:<br />&emsp;%s<br /><br />Deleted:<br />&emsp;%s',
-));
diff --git "[FORUM_EXT]/sitesplat\\BBCore/language/pt/BBCore.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt/BBCore.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt/BBCore.php"
@@ -0,0 +1,399 @@
+<?php
+/**
+*
+* BBCore [Portuguese]
+*
+* @package language
+* @package sitesplat BBcore
+* @version $Id$
+* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+* @copyright (c) 2015 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+// TRANSLATORS PLEASE NOTE	
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
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB')) {
+	exit;
+}
+if (empty($lang) || !is_array($lang)) {
+	$lang = array();
+}
+
+// load addon lang files first...allow BBCore to overwrite if needed
+$addon_lang = [];
+\sitesplat\load_ext_lang(__DIR__, $addon_lang);
+$lang = array_merge($lang, $addon_lang);
+
+// BBCore
+$lang = array_merge($lang, array(
+
+	'PM_NEW_MSG' => [
+		1 => 'Tem %d Nova Mensagem Privada',
+		2 => 'Tem %d Novas Mensagens Privadas',
+	],
+	'PM_UNREAD_MSG' => [
+		1 => 'Tem %d Mensagem Privada Por Ler',
+		2 => 'Tem %d Mensagens Privadas Por Ler',
+	],
+	'PM_NEW_MSG_BUBBLE' => [
+		1 => '%d',
+		2 => '%d',
+	],
+
+	'SITESPLAT_EXT'				=> 'Other Extensions',
+	'BBCORE_DASHBOARD'			=> 'Dashboard',
+	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
+	'BBCORE_SETTINGS'			=> 'Settings',
+	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
+	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
+	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
+	'SS_CHATBOX'				=> 'Chat',
+	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+	'SS_ADDONS'				=> 'Addons',
+	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
+
+	'UCP_MAIN'						 => 'Geral',
+	'UCP_MAIN_FRONT'				 => 'Página Principal',
+	'UCP_MAIN_SUBSCRIPTION'			 => 'Administrar Observações',
+	'UCP_MAIN_BOOKMARKS'			 => 'Administrar Favoritos',
+	'UCP_MAIN_DRAFTS'				 => 'Administrar Rascunhos',
+	'UCP_MAIN_ATTACHMENTS'			 => 'Administrar Anexos',
+
+	'USER_PANEL'					 => 'Painel de Controlo',
+	'UCP_PROFILE'					 => 'Perfil',
+	'UCP_PROFILE_PROFILE'			 => 'Editar Perfil',
+	'UCP_PROFILE_SIGNITURE'			 => 'Editar Assinatura',
+	'UCP_PROFILE_AVATAR'			 => 'Editar Avatar',
+	'UCP_PROFILE_SETTINGS'			 => 'Detalhes da Conta',
+	'UCP_AVATAR_SELECT_OPTIONS'		 => 'Opções do Avatar', 
+	'UCP_AVATAR_SELECT_UPLOAD'		 => 'Envie o avatar a partir do seu dispositivo',
+	'UCP_SUBMIT_TO_UPLOAD'			 => 'Clique em baixo para enviar',
+
+	'UCP_PREFERENCE'				 => 'Preferências',
+	'UCP_PREFERENCE_SETTINGS' 		 => 'Editar configurações pessoais',
+	'UCP_PREFERENCE_DEFAULTS' 		 => 'Editar mensagens enviadas',
+	'UCP_PREFERENCE_OPTIONS'		 => 'Editar exibição de mensagens',
+
+	'UCP_MESSAGES'					 => 'Mensagens Privadas',
+	'UCP_PM_COMPOSE'				 => 'Criar mensagem privada',
+	'UCP_PM_DRAFTS'					 => 'Administrar rascunhos',
+	'UCP_PM_INBOX'					 => 'Caixa de Entrada',
+	'UCP_PM_OUTBOX'					 => 'Caixa de Saída',
+	'UCP_PM_SENTBOX'				 => 'Mensagens Enviadas',
+	'UCP_PM_OPTIONS'				 => 'Opções (Regras e Pastas)',
+	'UCP_NO_USER_CHANGE_ALLOWED'	 => '**Não é permitido alterar o Nome de Utilizador**',
+	'UCP_REGISTER_EMAIL_EXPLAIN'	 => 'Por favor, não utilize emails descartáveis',
+	'UCP_USERGROUPS_EXPLAIN'		 => '(Escolha um grupo e depois clique em Adicionar)',
+
+	'WIDTH_SIZE'					 => 'largura',
+	'PIXEL_SIZE'					 => 'px',
+	'HEIGHT_SIZE'					 => 'altura',
+
+	'UCP_GROUPS'					 => 'Grupos de Utilizadores',
+	'UCP_GROUPS_MEMBERSHIP'			 => 'Editar Inscrições em Grupos',
+	'UCP_GROUPS_MANAGE'				 => 'Administrar grupos',
+
+	'UCP_ZEBRA'						 => 'Amigos e Inimigos',
+	'UCP_ZEBRA_FRIENDS'				 => 'Administrar Amigos',
+	'UCP_ZEBRA_FOES'				 => 'Administrar Inimigos',
+	'UCP_APPLY'						 => 'Alterar',
+	'UCP_PM_DEFAULT_RULE_TAG'		 => 'Acção Padrão',
+	'UCP_PM_DEFAULT_RULE'			 => 'Não serão aceitas novas Mensagens',
+	'UCP_PM_DEFAULT_RULE_EXPLAIN'	 => 'Esta acção será despoletada se se verificar a regra mencionada. As Mensagens novas serão mantidas até haver espaço disponível',
+	'UCP_PM_NEW_MESSAGE'			 => 'Nova Mensagem',
+	'BIO'							 => 'Informações Pessoais',
+	'MANAGE'						 => 'Gerir',
+	'JOINED_BOARD'					 => 'Entrou no Fórum', //Registou-se?
+	'VISITED_BOARD'					 => 'Última visita',
+	'SEE_MORE'						 => 'Mais',
+	'ATTACH_SIGNATURE'				 => 'Anexar assinatura',
+	'BBCODES'						 => 'BBcodes',
+
+	'DELETE_POST_SOFT'				 => 'Enviar Mensagem para a Reciclagem',
+	'DELETE_POST_PERMANENT'			 => 'Apagar Mensagem Permanentemente ',
+	'DELETE_POST_SOFT_WARN'			 => 'Poderá ser recuperada',
+	'DELETE_POST_PERMANENT_WARN'	 => 'NÃO poderá ser recuperada',
+
+	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	 => 'Introduza o número máx. de opções que o utilizador poderá seleccionar',
+	'POLL_VOTE_CHANGE_LABEL'		 => 'Permitir Alterar Voto',
+	'NO_VOTES_NA'					 => 'N/A',
+	'NOT_AVAILABLE'					 => 'Indisponível',
+	'POST_TOPIC_NEW'				 => 'Novo Tópico',
+	'QUICK_REPLY_SHOW_HIDE'			 => 'Mostrar/Ocultar Resposta Rápida',
+	'CHARACTERS_COUNT'				 => 'Carácter',
+	'CHARACTERS_COUNT_REM'			 => 'Restantes',
+	'BOOKMARKED_TOPICS_UCP'			 => 'Tópicos favoritos',
+	'ATTACH_EXPLANATION_SORTABLE'	 => 'Clique para ordenar',
+	'ATTACH_FORUM'					 => 'Anexo(s)',
+	'MCP_DETAILS_LOG'				 => 'Detalhes',
+	'MCP_DETAIL_U_IP'				 => 'Utilizador &amp; IP',
+	'MCP_MANAG_BAN'					 => 'Administrar Expulsões',
+	'MCP_UNAPPROVED_POSTS_ZERO'		 => 'Não existem mensagens por aprovar',
+	'MCP_REPORTS_ZERO'				 => 'Não existem denúncias de Mensagens para rever',
+	'MCP_PM_REPORTS_ZERO'			 => 'Não existem denúncias de Mensagens Privadas para rever',
+
+
+	'SUBFORUM_LINK'					 => 'Endereço abre numa nova aba',
+	'FORUMLIST_UNAPPROVED'			 => 'Falta pelo menos um tópico neste fórum por aprovar',
+	'FORUMLIST_UNAPPROVED_POST'		 => 'Falta pelo menos uma mensagem neste fórum por aprovar', 
+	'FORUMLIST_LASTPOST'			 => 'Ver a última mensagem',
+	'TOPICS_POSTS_STATISTICS'		 => 'Estatísticas',
+	'TOPICS_ROW_REPORTED'			 => 'Este tópico foi reportado',
+	'TOPICS_ROW_NOT_APPROVED'		 => 'Este tópico não foi aprovado',
+	'TOPICS_ROW_DELETED'			 => 'Este tópico foi apagado',
+	'MODERATOR_PANEL_GENERAL'		 => 'Painel de Moderação',
+	'ADMIN_PANEL_GENERAL'			 => 'Painel de Administração',
+	'RANK_IMAGE'					 => 'Imagem de Rank',
+
+	'WELCOME_INDEX'					 => 'Bem-vindo',
+	'FAQ'							 => 'FAQ',
+	'CAPTION_FAQ'					 => 'Questões Mais Frequentes',
+	'CAPTION_SEARCH'				 => 'Procura primeiro!',
+	'CAPTION_MEMBERS'				 => 'À procura de alguém?',
+	'MEMBERS_CAP'					 => 'Membros',
+	'CAPTION_UCP'					 => 'Defina as suas preferências',
+	'UCP_CAP'						 => 'Painel de Controlo do Utilizador',
+	'INDEX_CAPTION'					 => 'Esta é a página índice do fórum',
+	'VIEWTOPIC_CAP'					 => 'Título do Tópico',
+	'CAPTION_VIEWTOPIC'				 => 'Descrição do Tópico',
+	'CAPTION_VIEWFORUM'				 => 'Navegar por todas as categorias do fórum',
+	'POSTINGS_CAP'					 => 'Editor de Mensagens',
+	'CAPTION_POSTINGS'				 => 'A colocar conteúdo!',
+
+	'MCP_CAPTION'					 => 'É aqui que podes usar os teus Super-Poderes ;-)',
+	'BOOTSTRAP_ELEMENT'				 => 'Elementos Bootstrap',
+	'BOOTSTRAP_ELEMENT_CAPTION'		 => 'Documentação do Fórum KickStart',
+	'MAIN_FORUM'					 => 'Fórum',
+	'MAIN_MAIN_STUFF'				 => 'As principais coisas',
+	'MAIN_TRENDS'					 => 'Veja as tendências',
+
+	'MAIN_SEARCH_IT_UP'				 => 'Procura primeiro',
+	'SUB_NO_ICON'					 => 'Não foram encontrados ícones',
+	'EXAMPLE_WITH_ICON'				 => 'Exemplo com Ícone',
+	'EXAMPLE_LINK'					 => 'Exemplo com Endereço',
+	'MAIN_SOCIAL'					 => 'Social',
+	'SOCIAL_P'						 => 'Conversar à pala ;-)',
+
+	'MORE'							 => 'Mais',
+	'EXPAND_CLOSE'					 => 'Fechar Vista',
+	'MARK_TOPICS_READ'				 => 'Marcar tópicos como lidos',
+	'CONTACT'						 => 'Contacto',
+	'GET_IN_TOUCH'					 => 'Entra em contacto',
+	'HANG_AROUND'					 => 'Participa',
+	'JOIN_THE_CLUB'					 => 'Junta-te ao clube',
+	'MENU'							 => 'MENU',
+	'YOU_ARE_HERE'					 => 'Estás aqui',
+	'IN_FOOTER'						 => 'Em:',
+	'REPLY'							 => 'Resposta',
+
+	'LOGIN_REMEMBER'				 => 'Continuar conectado',
+	'LOGIN_HIDE_ME'					 => 'Ocultar sessão',
+	'LOGIN_ME_IN'					 => 'Entrar',
+	'SIGN_IN_ACCOUNT'				 => 'Entrar na conta',
+	'CREATE_ACCOUNT'				 => 'Criar Conta',
+	'GO_TO_SEARCH_ADV'				 => 'Regressar à pesquisa avançada',
+
+	'CREATE_ACCOUNT_DISABLED'		 => 'Os registos estão encerrados',
+	'REGISTRATION_DISABLED'			 => 'Os registos estão de momento encerrados, apenas poderá criar conta por convite. Pedimos desculpa pelo inconveniente. A nossa Política de Privacidade e Termos de Uso estão disponíveis em baixo. Vê a Ajuda para mais informações sobre os convites.',
+	'CONTACT_WEBMASTER'				 => 'Contacta o Administrador',
+	'CONFIRM_QA_EXPLAIN_ALT'		 => 'Prova que és humano e responde à seguinte questão',
+
+	'PLUPLOAD_PLACE_INLINE'			 => 'Adicionar',
+	'PLUPLOAD_DELETE_FILE'			 => 'Apagar',
+
+
+	'REG_CREATING'					 => 'A Criar perfil...',
+	'LOADING'						 => 'A Carregar...',
+	'SAVING'						 => 'A Guardar...',
+	'CANCELLING'					 => 'A Cancelar...',
+	'SENDING'						 => 'A Enviar...',
+	'SEARCHING'						 => 'A Pesquisar...',
+	'LOADING_LOG_IN'				 => 'A Conectar-se...',
+	'FILE_UPLOADING'				 => 'A Enviar Ficheiro...',
+	'CASTING_VOTE'					 => 'A Enviar Voto...',
+	'LOADING_FORM'					 => 'A Carregar Formulário...',
+
+	'MEMBERLIST_P_JOINED'			 => 'Registou-se no fórum',
+	'MEMBERLIST_P_EXPL'				 => 'Quando me registei no fórum',
+	'MEMBERLIST_P_DATE_EXPL'		 => 'Última vez que visitei o fórum',
+	'SPAMMER'						 => 'Spammer',
+	'SPAMMER_PLACEHOLDER'			 => 'Não podes simplesmente fazer Spam e sair impune!',
+	'MARK_PLACEHOLDER'				 => 'Coloque visto na sua escolha',
+	'INFO_BOX'						 => 'Informações:',
+	'USER_REMOVE_PLACEHOLDER'		 => 'Clique para remover o utilizador',
+	'GROUP_REMOVE_PLACEHOLDER'		 => 'Clique para remover o grupo',
+	'EDIT_LINK_PLACEHOLDER'			 => 'Esqueci-me de colocar código nos meus endereços',
+	'POST_IT_UP_PLACEHOLDER'		 => 'Enviar!',
+
+	'UCP_REG_USR_PLACEHOLDER'		 => 'E.g. John Doe',
+	'UCP_REG_EMAIL_PLACEHOLDER'		 => 'E.g. john@mail.com',
+	'UCP_REG_PSWD_PLACEHOLDER'		 => 'E.g. ASDFasdf123',
+	'UCP_REG_CTCHA_PLACEHOLDER'		 => 'E.g. golden sky',
+	'SEARCH_USR_PLACEHOLDER'		 => 'E.g. GoldTugAnime',
+	'YEAR_MONTH_DAY_PLACEHOLDER'	 => 'E.g. 2018-12-22',
+	'IP_PLACEHOLDER'				 => 'E.g. 216.161.111.33',
+	'POSTS_PLACEHOLDER'				 => 'E.g. 12',
+	'SEARCH_KWDS_PLACEHOLDER'		 => 'E.g. gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',
+
+	'MESSAGE_ENTER_PLACEHOLDER'		 => 'Introduza a sua mensagem...',
+	'FILE_COMMENT_PLACEHOLDER'		 => 'Espaço reservado para comentários',
+	'HEIGTH_PLACEHOLDER'			 => 'altura',
+	'WIDTH_PLACEHOLDER'				 => 'largura',
+	'UCP_OCCUPATION_PLACEHOLDER'	 => 'Descreve de forma breve a tua profissão...',
+	'UCP_INTERESTS_PLACEHOLDER'		 => 'Descreve os teus interesses...',
+	'SOFT_DELETE_PLACEHOLDER'		 => 'Adiciona os teus motivos, caso desejes...',
+	'ADD_DESCRIPTION'				 => 'Adicionar descrição',
+
+	'FILE_SELECT'					 => 'Seleccione o ficheiro',
+	'FILE_CHANGE'					 => 'Alterar',
+	'SELECT_IMAGE'					 => 'Seleccione a imagem',
+	'NOTE'							 => 'Observação',
+	'EDIT_DRAFT'					 => 'Editar Rascunho',
+	'PM_BALOON_NOTIFICATION'		 => 'Activar notificação de MP (Mensagem Privada) via Pop-Up',
+	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Marcar todas como lidas',
+	'DAYS_AGO'						 => 'Dias atrás',
+	'WORK_IN_PROGRESS'				 => 'Manutenção',
+	'DISABLE_MESSAGE'				 => 'Fórum indisponível',
+	'DISABLE_RETURN'				 => 'Voltar à página de índice',
+	'BOARD_DISABLED_SHUFFLE'		 => 'Diverte-te e embaralha algumas letras :-)',
+	'DISABLE_TEXT_TRY'				 => 'Testa tu mesmo!',
+	'DISABLE_TEXT_TYPE'				 => 'Digite algo, e pressione retroceder...',
+
+	'GRAVATAR_EXPLAIN'				 => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, será usado por defeito.',
+	'GRAVATAR_EXPLAIN_CONFIRM'		 => 'Por favor, confirme o seu endereço de e-mail aqui',
+
+	'DELETE_POLL'					 => 'Apagar Votação',
+	'POLL_DELETE_HELPER'			 => '(Isto apenas apaga a votação) verificar e submeter',
+	'JUMP_TO_POST'					 => 'Ir para a mensagem',
+	'JUMP_SELECT_FORUM'				 => 'Selecciona o Fórum para onde ir',
+	'JUMP_TO_PAGE_NUMBER'			 => 'Ir para #',
+	'VIEW_FIRST_UNREAD'				 => 'Ver primeira mensagem não lida.',
+	'BOOKMARK_TOPIC_REMOVE'			 => 'Remover tópico dos favoritos',
+
+	'NEW_MESSAGES'					 => 'Novas mensagens',
+	'YOU_HAVE'						 => 'Você tem',
+	'AND'							 => 'e',
+	'HELLO'							 => 'Olá',
+	'DISMISS_PM'					 => 'Adiar 5 minutos',
+	'READ_NOW'						 => 'Leia agora',
+	'PRIVATE_MESSAGE_NEW'			 => 'nova mensagem privada',
+	'PRIVATE_MESSAGE_UNREAD'		 => 'mensagem privada por ler',
+	'NO_PMS_INFO'					 => 'Tudo em dia! Escrever nova MP?',
+
+	'DATES'							 => 'DATA',
+	'POWERED'						 => 'Baseado em',
+	'HANDCRAFTED'					 => 'Desenvolvido Com',
+	'BY'							 => 'Por',
+
+	'RECENT_TOPICS'					 => 'Tópicos recentes',
+	'TWITTER'						 => 'Twitter',
+	'FAVORITES'						 => 'Favoritos',
+
+	'GALLERY'						 => 'Galeria',
+	'CHAT'							 => 'Chat',
+	'ABOUT'							 => 'Sobre Nós',
+	'ABOUT_PART_ONE'				 => 'BBOOTS&#8482; É o primeiro e único Tema, HTML5/CSS3 não-oficial, totalmente Ágil de PhpBB&reg;. É limpo e nítido. Com um Design INCRÍVEL e compatível com todos os navegadores e dispositivos.',
+	'ABOUT_PART_TWO'				 => 'Utiliza um layout com base no Bootstrap, há muito esperado, e que irá surpreender os fãs da plataforma phpBB.',
+	'ABOUT_PART_THREE'				 => 'O Tema Ágil Não-Oficial',
+	'BB'							 => 'B',
+	'BOOTS'							 => 'BOOTS',
+	'BBOOTS'						 => 'BBOOTS',
+
+	'BBOOTS_VERSION'				 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
+	'U_LOGOUT'						 => 'Sair',
+
+	'SITESPLAT_STATISTICS'			 => 'Estatísticas',
+	'SITESPLAT_SEE_DETAILS'			 => 'Ver detalhes',
+	'SITESPLAT_SEARCH_LAST_DAY'		 => 'Mensagens das últimas 24h',
+	'SITESPLAT_SEARCH_WEEK'			 => 'Mensagens dos últimos 7 dias',
+
+	'SITESPLAT_TOTAL_POSTS'			 => 'Total de mensagens',
+	'SITESPLAT_TOTAL_TOPICS'		 => 'Total de tópicos',
+	'SITESPLAT_TOTAL_USERS'			 => 'Total de utilizadores',
+	'SITESPLAT_NEWEST_MEMBER'		 => 'Novo utilizador',
+	'SITESPLAT_USERS_ONLINE'		 => 'Utilizadores Online',
+	'SITESPLAT_MOST_USERS_ONLINE'	 => 'Recorde de Utilizadores Online',
+	'SITESPLAT_BIRTHDAYS'			 => 'Aniversariantes',
+
+	'BOOTSTRAP_VERSION'				 => '3.3.6',
+	'FLATBOOTS'						 => 'FLATBOOTS',
+	'CHANGE_AVATAR'					 => 'Alterar Avatar',
+	'CHANGE_PASSWORD'				 => 'Alterar Senha',
+
+	'ADMIN_TIPS'					 => 'Truques e Dicas dos Administradores',
+	'ADMIN_TIP_INTRO'				 => 'Sabias que podes tornar o teu fórum phpBB ainda mais seguro com apenas alguns passos simples?',
+	'ADMIN_TIP_ONE'					 => 'Mantém o teu software actualizado.',
+	'ADMIN_TIP_TWO'					 => 'Usa sempre boas senhas que contenham sequências aleatórias de números, letras e caracteres especiais.',
+	'ADMIN_TIP_THREE'				 => 'Restrinja o acesso à zona de administração...',
+	'ADMIN_CHECK_IT_BTN'			 => 'Visita SiteSplat.com para mais informação',
+
+	'USER_MINI_PROFILE'				 => 'Mini-perfil do utilizador',
+	'USER_MINI_PROFILE_VIEW_FULL'	 => 'Ver o perfil completo',
+	'OFF_LINE'						 => 'Desconectado',
+	'USER_STATUS'					 => 'Estado',
+	'USER'							 => 'Utilizador',
+	'TITLE'							 => 'Título',
+	'END_TIMELINE'					 => 'Cronograma final',
+	'MEMBERS'						 => 'Utilizadores',
+	'DRAFTS'						 => 'Rascunhos',
+	'REPORTS'						 => 'Denúncias',
+	'MODERATOR_LOGS'				 => 'Registos de Moderador',
+	'QUEUE'							 => 'Moderação',
+	'LINKS'							 => 'Endereços',
+	'TOPIC_PERMISSIONS'				 => 'Permissões do tópico',
+	'MODERATOR_OPTIONS'				 => 'Moderar',
+	'PASSWORD_EXPLAIN_CONFIRM'		 => 'Certifique-se que corresponde',
+	'FORUM_REDIRECTS'				 => 'Redireccionamentos:',
+
+	'FANCY_TOPICS_TITLE'			 => 'Tópicos recentes do fórum',
+	'POST_BY'						 => 'Criado por',
+	'REPLY_BY'						 => 'Respondido por',
+	'NO_REPLIES'					 => 'Sem resposta',
+	'READ_MORE'						 => 'Ler mais',
+	'RT_READ_MORE'					 => 'LER MAIS',
+	'VIEW_MORE_TOPICS'				 => 'VER MAIS TÓPICOS',
+	'BACK_TO_START'					 => 'VOLTAR AO INÍCIO',
+
+	'TOGGLE_NAV'					 => 'Alterar Navegação',
+	'NAVIGATION'					 => 'Navegação',
+
+	'DEMO_LINK'						 => 'Apenas demonstração, não existe ícones',
+	'DEMO_HEADER_MENU'				 => 'Exemplo de cabeçalho da introdução',
+
+	'FLATBOOTS_INTRO'				 => 'Bootstrap Framework',
+	'FLATBOOTS_EXPLAIN'				 => 'Mais de uma dúzia de componentes reutilizáveis, criado para fornecer iconografia, menus suspensos, grupos de entrada, sistema de navegação, notificações e muito mais...',
+	'CALL_TO_ACTION_FOOTER'			 => 'Active e desactive addons, use apenas o que realmente precisa!',
+	'PURCHASE_NOW_BTN'				 => 'Compre agora',
+	'FLATBOOTS_ABOUT_PART_ONE'		 => 'Porque é que iria contentar-se com menos, quando pode ter mais? Não deixe que outros autores o enganem com jogadas de Marketing. O FLATBOOTS é aquilo que merece. Construído para durar, construído a partir do zero, nada mais, nada menos.',
+	'FLATBOOTS_ABOUT_TITLE'			 => 'Construído para durar',
+	'DMCA'							 => 'DMCA',
+	'TERMS'							 => 'Termos e Condições',
+	'ADVERTISE'						 => 'Divulgue',
+	'DEVELOPER'						 => 'Desenvolvido por',
+	'LEINAD4MIND'					 => 'Leinad4Mind',
+	'SITESPLAT_URL'					 => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
+	'JOIN_US_TWITTER'				 => 'Segue-nos!',
+	'TWEET_EXAMPLE'					 => 'O BBOOTS atingiu as 500 vendas! Obrigado a todos os que apoiam este projecto e que contribuem com o SiteSplat para construir a comunidade. O que o futuro reserva? Mantém-te a par e segue-me no Twitter. <a href="#">http://bit.ly/000fefs</a>',
+
+));
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/fr/filesystem.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt/filesystem.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/filesystem.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/filesystem.php"
diff --git "[FORUM_EXT]/sitesplat\\BBCore/language/pt/info_acp_bbcore.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt/info_acp_bbcore.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt/info_acp_bbcore.php"
@@ -0,0 +1,60 @@
+<?php
+/**
+*
+* common [Portuguese]
+*
+* @package language
+* @package sitesplat BBcore
+* @version $Id$
+* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+* @copyright (c) 2015 SiteSplat All rights reserved
+* @license Proprietary
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
+$lang = array_merge($lang, array(
+
+	'ACP_SITESPLAT_UPDATE_MANAGER'	 => 'Administrar Actualizações de SiteSplat',
+	'VERSION_INSTALLED'				 => 'Versão Instalada',
+	'NEW_BOOTS_VERSION'				 => 'Nova versão disponível: %s',
+	'VERSIONNUMBERS'				 => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
+	'SS_RAPID_DISABLE'				 => 'Desactivar Rápido SS',
+	'SS_RAPID_DISABLE_TLT'			 => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',
+
+	'DOWNLOAD_MSG'					 => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
+	'CHANGE_LOG_MSG'				 => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
+	'SUPPORT_FORUM_MSG'				 => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
+	'COLORIZE_MSG'					 => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
+	'NO_VERSIONINFO'				 => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',
+
+	'LOG_FILES_CHANGED'				 => '<strong>O BBcore alterou o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+	'LOG_THEME_INSTALLED'			 => '<strong>O BBcore foi instalado com sucesso</strong>',
+	'LOG_FILES_CHANGED_FAILED'		 => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
+	'LOG_THEME_UNINSTALLED'			 => '<strong>O BBcore foi desinstalado com sucesso</strong>',
+
+	'LOG_FILE_NOT_REPLACED'			 => '<strong>O BBcore não conseguiu substituir o ficheiro original por ti:</strong><br />» %s',
+	'LOG_FILE_NOT_UPDATED'			 => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+
+	'LOG_BBCORE_INSTALLED'			 => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
+	'LOG_BBCORE_DEINSTALLED'		 => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',
+
+	'LOG_BBCORE_NOT_REPLACED'		 => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) ficheiro(s)<br />» %s',
+	'LOG_BBCORE_NOT_UPDATED'		 => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) ficheiro(s)<br />» %s',
+
+	'ACP_BBCORE_MSG_FILES_FAIL'		 => 'Nem TODOS os ficheiros foram editados! Por favor, substitui manualmente o(s) ficheiro(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
+	'ACP_BBCORE_MSG_SETTINGS'		 => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de ficheiros no servidor ou à falta de ficheiros nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os ficheiros manualmente para desfrutar de todas as funcionalidades.',
+	'BBCORE_ERROR_DISABLE'			 => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
+));
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/fr/info_ucp_helper.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt/info_ucp_helper.php"
similarity index 78%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/fr/info_ucp_helper.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt/info_ucp_helper.php"
--- "[ORIGINAL]/sitesplat\\BBCore/language/fr/info_ucp_helper.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt/info_ucp_helper.php"
@@ -3,6 +3,7 @@
 *
 * @package language
 * @package sitesplat BBcore addon
+* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 *
@@ -55,14 +56,14 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge(
 	$lang, array(
-		'UCP_IR'				    => 'Image Resizer',
-		'IMAGE_RESIZE'			    => 'Image Resize',
-		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
+		'UCP_IR'				    => 'Redimensionar Imagem',
+		'IMAGE_RESIZE'			    => 'Redimensionamento de Imagem',
+		'IMAGE_RESIZE_EXPLAIN'	    => 'Corte %1$s da imagem e confirme.',
 		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',
 
-		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
+		'IMAGE_RESIZE_ERROR'	    => 'Nenhuma app ou ficheiro para enviar!',
 		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
-		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
-	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable AvatarResize because of other active premium extensions<br /><div>» %s</div>',
+	    'SS_HELPER_NOTY'	    	=> 'Core does not exist!<br />Download and copy the Core folder into your sitesplat extension folder.',
 	)
 );
diff --git "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/BBCore.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/BBCore.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/BBCore.php"
@@ -0,0 +1,399 @@
+<?php
+/**
+*
+* BBCore [Portuguese]
+*
+* @package language
+* @package sitesplat BBcore
+* @version $Id$
+* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+* @copyright (c) 2015 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+// TRANSLATORS PLEASE NOTE	
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
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB')) {
+	exit;
+}
+if (empty($lang) || !is_array($lang)) {
+	$lang = array();
+}
+
+// load addon lang files first...allow BBCore to overwrite if needed
+$addon_lang = [];
+\sitesplat\load_ext_lang(__DIR__, $addon_lang);
+$lang = array_merge($lang, $addon_lang);
+
+// BBCore
+$lang = array_merge($lang, array(
+
+	'PM_NEW_MSG' => [
+		1 => 'Tem %d Nova Mensagem Privada',
+		2 => 'Tem %d Novas Mensagens Privadas',
+	],
+	'PM_UNREAD_MSG' => [
+		1 => 'Tem %d Mensagem Privada Por Ler',
+		2 => 'Tem %d Mensagens Privadas Por Ler',
+	],
+	'PM_NEW_MSG_BUBBLE' => [
+		1 => '%d',
+		2 => '%d',
+	],
+
+	'SITESPLAT_EXT'				=> 'Other Extensions',
+	'BBCORE_DASHBOARD'			=> 'Dashboard',
+	'SITESPLAT_UPDATE_MANAGER'	=> 'Update Manager',
+	'BBCORE_SETTINGS'			=> 'Settings',
+	'BBCORE_FS_REQUIRE'			=> '%s requires the SiteSplat Filesystem',
+	'BBCORE_MYSQL_REQUIRE'		=> '%s requires MySQL',
+	'BBCORE_BAD_SERVER'			=> 'Your server settings are incompatible with %s',
+	'SS_CHATBOX'				=> 'Chat',
+	'CHATBOX_MODERATORS'		=> 'Chatbox Moderators',
+	'BBCORE_MEM'				=> '%1$s total, %2$s in use',
+	'SS_ADDONS'				=> 'Addons',
+	'SS_ADDON_SETTINGS'		=> 'Addon Settings',
+	'SS_LID_INFO'			=> 'This is your SiteSplat License Key. You will be required to enter this key after you install or update BBCore.',
+
+	'UCP_MAIN'						 => 'Geral',
+	'UCP_MAIN_FRONT'				 => 'Página Principal',
+	'UCP_MAIN_SUBSCRIPTION'			 => 'Administrar Observações',
+	'UCP_MAIN_BOOKMARKS'			 => 'Administrar Favoritos',
+	'UCP_MAIN_DRAFTS'				 => 'Administrar Rascunhos',
+	'UCP_MAIN_ATTACHMENTS'			 => 'Administrar Anexos',
+
+	'USER_PANEL'					 => 'Painel de Controlo',
+	'UCP_PROFILE'					 => 'Perfil',
+	'UCP_PROFILE_PROFILE'			 => 'Editar Perfil',
+	'UCP_PROFILE_SIGNITURE'			 => 'Editar Assinatura',
+	'UCP_PROFILE_AVATAR'			 => 'Editar Avatar',
+	'UCP_PROFILE_SETTINGS'			 => 'Detalhes da Conta',
+	'UCP_AVATAR_SELECT_OPTIONS'		 => 'Opções do Avatar', 
+	'UCP_AVATAR_SELECT_UPLOAD'		 => 'Envie o avatar a partir do seu dispositivo',
+	'UCP_SUBMIT_TO_UPLOAD'			 => 'Clique em baixo para enviar',
+
+	'UCP_PREFERENCE'				 => 'Preferências',
+	'UCP_PREFERENCE_SETTINGS' 		 => 'Editar configurações pessoais',
+	'UCP_PREFERENCE_DEFAULTS' 		 => 'Editar mensagens enviadas',
+	'UCP_PREFERENCE_OPTIONS'		 => 'Editar exibição de mensagens',
+
+	'UCP_MESSAGES'					 => 'Mensagens Privadas',
+	'UCP_PM_COMPOSE'				 => 'Criar mensagem privada',
+	'UCP_PM_DRAFTS'					 => 'Administrar rascunhos',
+	'UCP_PM_INBOX'					 => 'Caixa de Entrada',
+	'UCP_PM_OUTBOX'					 => 'Caixa de Saída',
+	'UCP_PM_SENTBOX'				 => 'Mensagens Enviadas',
+	'UCP_PM_OPTIONS'				 => 'Opções (Regras e Pastas)',
+	'UCP_NO_USER_CHANGE_ALLOWED'	 => '**Não é permitido alterar o Nome de Utilizador**',
+	'UCP_REGISTER_EMAIL_EXPLAIN'	 => 'Por favor, não utilize emails descartáveis',
+	'UCP_USERGROUPS_EXPLAIN'		 => '(Escolha um grupo e depois clique em Adicionar)',
+
+	'WIDTH_SIZE'					 => 'largura',
+	'PIXEL_SIZE'					 => 'px',
+	'HEIGHT_SIZE'					 => 'altura',
+
+	'UCP_GROUPS'					 => 'Grupos de Utilizadores',
+	'UCP_GROUPS_MEMBERSHIP'			 => 'Editar Inscrições em Grupos',
+	'UCP_GROUPS_MANAGE'				 => 'Administrar grupos',
+
+	'UCP_ZEBRA'						 => 'Amigos e Inimigos',
+	'UCP_ZEBRA_FRIENDS'				 => 'Administrar Amigos',
+	'UCP_ZEBRA_FOES'				 => 'Administrar Inimigos',
+	'UCP_APPLY'						 => 'Alterar',
+	'UCP_PM_DEFAULT_RULE_TAG'		 => 'Acção Padrão',
+	'UCP_PM_DEFAULT_RULE'			 => 'Não serão aceitas novas Mensagens',
+	'UCP_PM_DEFAULT_RULE_EXPLAIN'	 => 'Esta acção será despoletada se se verificar a regra mencionada. As Mensagens novas serão mantidas até haver espaço disponível',
+	'UCP_PM_NEW_MESSAGE'			 => 'Nova Mensagem',
+	'BIO'							 => 'Informações Pessoais',
+	'MANAGE'						 => 'Gerir',
+	'JOINED_BOARD'					 => 'Entrou no Fórum', //Registou-se?
+	'VISITED_BOARD'					 => 'Última visita',
+	'SEE_MORE'						 => 'Mais',
+	'ATTACH_SIGNATURE'				 => 'Anexar assinatura',
+	'BBCODES'						 => 'BBcodes',
+
+	'DELETE_POST_SOFT'				 => 'Enviar Mensagem para a Reciclagem',
+	'DELETE_POST_PERMANENT'			 => 'Apagar Mensagem Permanentemente ',
+	'DELETE_POST_SOFT_WARN'			 => 'Poderá ser recuperada',
+	'DELETE_POST_PERMANENT_WARN'	 => 'NÃO poderá ser recuperada',
+
+	'POLL_MAX_OPTIONS_EXPLAIN_ALT'	 => 'Introduza o número máx. de opções que o utilizador poderá seleccionar',
+	'POLL_VOTE_CHANGE_LABEL'		 => 'Permitir Alterar Voto',
+	'NO_VOTES_NA'					 => 'N/A',
+	'NOT_AVAILABLE'					 => 'Indisponível',
+	'POST_TOPIC_NEW'				 => 'Novo Tópico',
+	'QUICK_REPLY_SHOW_HIDE'			 => 'Mostrar/Ocultar Resposta Rápida',
+	'CHARACTERS_COUNT'				 => 'Carácter',
+	'CHARACTERS_COUNT_REM'			 => 'Restantes',
+	'BOOKMARKED_TOPICS_UCP'			 => 'Tópicos favoritos',
+	'ATTACH_EXPLANATION_SORTABLE'	 => 'Clique para ordenar',
+	'ATTACH_FORUM'					 => 'Anexo(s)',
+	'MCP_DETAILS_LOG'				 => 'Detalhes',
+	'MCP_DETAIL_U_IP'				 => 'Utilizador &amp; IP',
+	'MCP_MANAG_BAN'					 => 'Administrar Expulsões',
+	'MCP_UNAPPROVED_POSTS_ZERO'		 => 'Não existem mensagens por aprovar',
+	'MCP_REPORTS_ZERO'				 => 'Não existem denúncias de Mensagens para rever',
+	'MCP_PM_REPORTS_ZERO'			 => 'Não existem denúncias de Mensagens Privadas para rever',
+
+
+	'SUBFORUM_LINK'					 => 'Endereço abre numa nova aba',
+	'FORUMLIST_UNAPPROVED'			 => 'Falta pelo menos um tópico neste fórum por aprovar',
+	'FORUMLIST_UNAPPROVED_POST'		 => 'Falta pelo menos uma mensagem neste fórum por aprovar', 
+	'FORUMLIST_LASTPOST'			 => 'Ver a última mensagem',
+	'TOPICS_POSTS_STATISTICS'		 => 'Estatísticas',
+	'TOPICS_ROW_REPORTED'			 => 'Este tópico foi reportado',
+	'TOPICS_ROW_NOT_APPROVED'		 => 'Este tópico não foi aprovado',
+	'TOPICS_ROW_DELETED'			 => 'Este tópico foi apagado',
+	'MODERATOR_PANEL_GENERAL'		 => 'Painel de Moderação',
+	'ADMIN_PANEL_GENERAL'			 => 'Painel de Administração',
+	'RANK_IMAGE'					 => 'Imagem de Rank',
+
+	'WELCOME_INDEX'					 => 'Bem-vindo',
+	'FAQ'							 => 'FAQ',
+	'CAPTION_FAQ'					 => 'Questões Mais Frequentes',
+	'CAPTION_SEARCH'				 => 'Procura primeiro!',
+	'CAPTION_MEMBERS'				 => 'À procura de alguém?',
+	'MEMBERS_CAP'					 => 'Membros',
+	'CAPTION_UCP'					 => 'Defina as suas preferências',
+	'UCP_CAP'						 => 'Painel de Controlo do Utilizador',
+	'INDEX_CAPTION'					 => 'Esta é a página índice do fórum',
+	'VIEWTOPIC_CAP'					 => 'Título do Tópico',
+	'CAPTION_VIEWTOPIC'				 => 'Descrição do Tópico',
+	'CAPTION_VIEWFORUM'				 => 'Navegar por todas as categorias do fórum',
+	'POSTINGS_CAP'					 => 'Editor de Mensagens',
+	'CAPTION_POSTINGS'				 => 'A colocar conteúdo!',
+
+	'MCP_CAPTION'					 => 'É aqui que podes usar os teus Super-Poderes ;-)',
+	'BOOTSTRAP_ELEMENT'				 => 'Elementos Bootstrap',
+	'BOOTSTRAP_ELEMENT_CAPTION'		 => 'Documentação do Fórum KickStart',
+	'MAIN_FORUM'					 => 'Fórum',
+	'MAIN_MAIN_STUFF'				 => 'As principais coisas',
+	'MAIN_TRENDS'					 => 'Veja as tendências',
+
+	'MAIN_SEARCH_IT_UP'				 => 'Procura primeiro',
+	'SUB_NO_ICON'					 => 'Não foram encontrados ícones',
+	'EXAMPLE_WITH_ICON'				 => 'Exemplo com Ícone',
+	'EXAMPLE_LINK'					 => 'Exemplo com Endereço',
+	'MAIN_SOCIAL'					 => 'Social',
+	'SOCIAL_P'						 => 'Conversar à pala ;-)',
+
+	'MORE'							 => 'Mais',
+	'EXPAND_CLOSE'					 => 'Fechar Vista',
+	'MARK_TOPICS_READ'				 => 'Marcar tópicos como lidos',
+	'CONTACT'						 => 'Contacto',
+	'GET_IN_TOUCH'					 => 'Entra em contacto',
+	'HANG_AROUND'					 => 'Participa',
+	'JOIN_THE_CLUB'					 => 'Junta-te ao clube',
+	'MENU'							 => 'MENU',
+	'YOU_ARE_HERE'					 => 'Estás aqui',
+	'IN_FOOTER'						 => 'Em:',
+	'REPLY'							 => 'Resposta',
+
+	'LOGIN_REMEMBER'				 => 'Continuar conectado',
+	'LOGIN_HIDE_ME'					 => 'Ocultar sessão',
+	'LOGIN_ME_IN'					 => 'Entrar',
+	'SIGN_IN_ACCOUNT'				 => 'Entrar na conta',
+	'CREATE_ACCOUNT'				 => 'Criar Conta',
+	'GO_TO_SEARCH_ADV'				 => 'Regressar à pesquisa avançada',
+
+	'CREATE_ACCOUNT_DISABLED'		 => 'Os registos estão encerrados',
+	'REGISTRATION_DISABLED'			 => 'Parece que os registos estão de momento encerrados, pode ser temporário. Se acha que é um erro, entre em contacto com o Administrador e informe sobre a situação. Pedimos desculpa pelo inconveniente. A nossa Política de Privacidade e Termos de Uso estão disponíveis em baixo.',
+	'CONTACT_WEBMASTER'				 => 'Contacta o Administrador',
+	'CONFIRM_QA_EXPLAIN_ALT'		 => 'Prova que és humano e responde à seguinte questão',
+
+	'PLUPLOAD_PLACE_INLINE'			 => 'Adicionar',
+	'PLUPLOAD_DELETE_FILE'			 => 'Apagar',
+
+
+	'REG_CREATING'					 => 'A Criar perfil...',
+	'LOADING'						 => 'A Carregar...',
+	'SAVING'						 => 'A Guardar...',
+	'CANCELLING'					 => 'A Cancelar...',
+	'SENDING'						 => 'A Enviar...',
+	'SEARCHING'						 => 'A Pesquisar...',
+	'LOADING_LOG_IN'				 => 'A Conectar-se...',
+	'FILE_UPLOADING'				 => 'A Enviar Ficheiro...',
+	'CASTING_VOTE'					 => 'A Enviar Voto...',
+	'LOADING_FORM'					 => 'A Carregar Formulário...',
+
+	'MEMBERLIST_P_JOINED'			 => 'Registou-se no fórum',
+	'MEMBERLIST_P_EXPL'				 => 'Quando me registei no fórum',
+	'MEMBERLIST_P_DATE_EXPL'		 => 'Última vez que visitei o fórum',
+	'SPAMMER'						 => 'Spammer',
+	'SPAMMER_PLACEHOLDER'			 => 'Não podes simplesmente fazer Spam e sair impune!',
+	'MARK_PLACEHOLDER'				 => 'Coloque visto na sua escolha',
+	'INFO_BOX'						 => 'Informações:',
+	'USER_REMOVE_PLACEHOLDER'		 => 'Clique para remover o utilizador',
+	'GROUP_REMOVE_PLACEHOLDER'		 => 'Clique para remover o grupo',
+	'EDIT_LINK_PLACEHOLDER'			 => 'Esqueci-me de colocar código nos meus endereços',
+	'POST_IT_UP_PLACEHOLDER'		 => 'Enviar!',
+
+	'UCP_REG_USR_PLACEHOLDER'		 => 'E.g. John Doe',
+	'UCP_REG_EMAIL_PLACEHOLDER'		 => 'E.g. john@mail.com',
+	'UCP_REG_PSWD_PLACEHOLDER'		 => 'E.g. ASDFasdf123',
+	'UCP_REG_CTCHA_PLACEHOLDER'		 => 'E.g. golden sky',
+	'SEARCH_USR_PLACEHOLDER'		 => 'E.g. GoldTugAnime',
+	'YEAR_MONTH_DAY_PLACEHOLDER'	 => 'E.g. 2018-12-22',
+	'IP_PLACEHOLDER'				 => 'E.g. 216.161.111.33',
+	'POSTS_PLACEHOLDER'				 => 'E.g. 12',
+	'SEARCH_KWDS_PLACEHOLDER'		 => 'E.g. gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',
+
+	'MESSAGE_ENTER_PLACEHOLDER'		 => 'Introduza a sua mensagem...',
+	'FILE_COMMENT_PLACEHOLDER'		 => 'Espaço reservado para comentários',
+	'HEIGTH_PLACEHOLDER'			 => 'altura',
+	'WIDTH_PLACEHOLDER'				 => 'largura',
+	'UCP_OCCUPATION_PLACEHOLDER'	 => 'Descreve de forma breve a tua profissão...',
+	'UCP_INTERESTS_PLACEHOLDER'		 => 'Descreve os teus interesses...',
+	'SOFT_DELETE_PLACEHOLDER'		 => 'Adiciona os teus motivos, caso desejes...',
+	'ADD_DESCRIPTION'				 => 'Adicionar descrição',
+
+	'FILE_SELECT'					 => 'Seleccione o ficheiro',
+	'FILE_CHANGE'					 => 'Alterar',
+	'SELECT_IMAGE'					 => 'Seleccione a imagem',
+	'NOTE'							 => 'Observação',
+	'EDIT_DRAFT'					 => 'Editar Rascunho',
+	'PM_BALOON_NOTIFICATION'		 => 'Activar notificação de MP (Mensagem Privada) via Pop-Up',
+	'MARK_ALL_NOTIFICATIONS_READ'	 => 'Marcar todas como lidas',
+	'DAYS_AGO'						 => 'Dias atrás',
+	'WORK_IN_PROGRESS'				 => 'Manutenção',
+	'DISABLE_MESSAGE'				 => 'Fórum indisponível',
+	'DISABLE_RETURN'				 => 'Voltar à página de índice',
+	'BOARD_DISABLED_SHUFFLE'		 => 'Diverte-te e embaralha algumas letras :-)',
+	'DISABLE_TEXT_TRY'				 => 'Testa tu mesmo!',
+	'DISABLE_TEXT_TYPE'				 => 'Digite algo, e pressione retroceder...',
+
+	'GRAVATAR_EXPLAIN'				 => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, será usado por defeito.',
+	'GRAVATAR_EXPLAIN_CONFIRM'		 => 'Por favor, confirme o seu endereço de e-mail aqui',
+
+	'DELETE_POLL'					 => 'Apagar Votação',
+	'POLL_DELETE_HELPER'			 => '(Isto apenas apaga a votação) verificar e submeter',
+	'JUMP_TO_POST'					 => 'Ir para a mensagem',
+	'JUMP_SELECT_FORUM'				 => 'Selecciona o Fórum para onde ir',
+	'JUMP_TO_PAGE_NUMBER'			 => 'Ir para #',
+	'VIEW_FIRST_UNREAD'				 => 'Ver primeira mensagem não lida.',
+	'BOOKMARK_TOPIC_REMOVE'			 => 'Remover tópico dos favoritos',
+
+	'NEW_MESSAGES'					 => 'Novas mensagens',
+	'YOU_HAVE'						 => 'Você tem',
+	'AND'							 => 'e',
+	'HELLO'							 => 'Olá',
+	'DISMISS_PM'					 => 'Adiar 5 minutos',
+	'READ_NOW'						 => 'Leia agora',
+	'PRIVATE_MESSAGE_NEW'			 => 'nova mensagem privada',
+	'PRIVATE_MESSAGE_UNREAD'		 => 'mensagem privada por ler',
+	'NO_PMS_INFO'					 => 'Tudo em dia! Escrever nova MP?',
+
+	'DATES'							 => 'DATA',
+	'POWERED'						 => 'Baseado em',
+	'HANDCRAFTED'					 => 'Desenvolvido Com',
+	'BY'							 => 'Por',
+
+	'RECENT_TOPICS'					 => 'Tópicos recentes',
+	'TWITTER'						 => 'Twitter',
+	'FAVORITES'						 => 'Favoritos',
+
+	'GALLERY'						 => 'Galeria',
+	'CHAT'							 => 'Chat',
+	'ABOUT'							 => 'Sobre Nós',
+	'ABOUT_PART_ONE'				 => 'BBOOTS&#8482; É o primeiro e único Tema, HTML5/CSS3 não-oficial, totalmente Ágil de PhpBB&reg;. É limpo e nítido. Com um Design INCRÍVEL e compatível com todos os navegadores e dispositivos.',
+	'ABOUT_PART_TWO'				 => 'Utiliza um layout com base no Bootstrap, há muito esperado, e que irá surpreender os fãs da plataforma phpBB.',
+	'ABOUT_PART_THREE'				 => 'O Tema Ágil Não-Oficial',
+	'BB'							 => 'B',
+	'BOOTS'							 => 'BOOTS',
+	'BBOOTS'						 => 'BBOOTS',
+
+	'BBOOTS_VERSION'				 => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
+	'U_LOGOUT'						 => 'Sair',
+
+	'SITESPLAT_STATISTICS'			 => 'Estatísticas',
+	'SITESPLAT_SEE_DETAILS'			 => 'Ver detalhes',
+	'SITESPLAT_SEARCH_LAST_DAY'		 => 'Mensagens das últimas 24h',
+	'SITESPLAT_SEARCH_WEEK'			 => 'Mensagens dos últimos 7 dias',
+
+	'SITESPLAT_TOTAL_POSTS'			 => 'Total de mensagens',
+	'SITESPLAT_TOTAL_TOPICS'		 => 'Total de tópicos',
+	'SITESPLAT_TOTAL_USERS'			 => 'Total de utilizadores',
+	'SITESPLAT_NEWEST_MEMBER'		 => 'Novo utilizador',
+	'SITESPLAT_USERS_ONLINE'		 => 'Utilizadores Online',
+	'SITESPLAT_MOST_USERS_ONLINE'	 => 'Recorde de Utilizadores Online',
+	'SITESPLAT_BIRTHDAYS'			 => 'Aniversariantes',
+
+	'BOOTSTRAP_VERSION'				 => '3.3.6',
+	'FLATBOOTS'						 => 'FLATBOOTS',
+	'CHANGE_AVATAR'					 => 'Alterar Avatar',
+	'CHANGE_PASSWORD'				 => 'Alterar Senha',
+
+	'ADMIN_TIPS'					 => 'Truques e Dicas dos Administradores',
+	'ADMIN_TIP_INTRO'				 => 'Sabias que podes tornar o teu fórum phpBB ainda mais seguro com apenas alguns passos simples?',
+	'ADMIN_TIP_ONE'					 => 'Mantém o teu software actualizado.',
+	'ADMIN_TIP_TWO'					 => 'Usa sempre boas senhas que contenham sequências aleatórias de números, letras e caracteres especiais.',
+	'ADMIN_TIP_THREE'				 => 'Restrinja o acesso à zona de administração...',
+	'ADMIN_CHECK_IT_BTN'			 => 'Visita SiteSplat.com para mais informação',
+
+	'USER_MINI_PROFILE'				 => 'Mini-perfil do utilizador',
+	'USER_MINI_PROFILE_VIEW_FULL'	 => 'Ver o perfil completo',
+	'OFF_LINE'						 => 'Desconectado',
+	'USER_STATUS'					 => 'Estado',
+	'USER'							 => 'Utilizador',
+	'TITLE'							 => 'Título',
+	'END_TIMELINE'					 => 'Cronograma final',
+	'MEMBERS'						 => 'Utilizadores',
+	'DRAFTS'						 => 'Rascunhos',
+	'REPORTS'						 => 'Denúncias',
+	'MODERATOR_LOGS'				 => 'Registos de Moderador',
+	'QUEUE'							 => 'Moderação',
+	'LINKS'							 => 'Endereços',
+	'TOPIC_PERMISSIONS'				 => 'Permissões do tópico',
+	'MODERATOR_OPTIONS'				 => 'Moderar',
+	'PASSWORD_EXPLAIN_CONFIRM'		 => 'Certifique-se que corresponde',
+	'FORUM_REDIRECTS'				 => 'Redireccionamentos:',
+
+	'FANCY_TOPICS_TITLE'			 => 'Tópicos recentes do fórum',
+	'POST_BY'						 => 'Criado por',
+	'REPLY_BY'						 => 'Respondido por',
+	'NO_REPLIES'					 => 'Sem resposta',
+	'READ_MORE'						 => 'Ler mais',
+	'RT_READ_MORE'					 => 'LER MAIS',
+	'VIEW_MORE_TOPICS'				 => 'VER MAIS TÓPICOS',
+	'BACK_TO_START'					 => 'VOLTAR AO INÍCIO',
+
+	'TOGGLE_NAV'					 => 'Alterar Navegação',
+	'NAVIGATION'					 => 'Navegação',
+
+	'DEMO_LINK'						 => 'Apenas demonstração, não existe ícones',
+	'DEMO_HEADER_MENU'				 => 'Exemplo de cabeçalho da introdução',
+
+	'FLATBOOTS_INTRO'				 => 'Bootstrap Framework',
+	'FLATBOOTS_EXPLAIN'				 => 'Mais de uma dúzia de componentes reutilizáveis, criado para fornecer iconografia, menus suspensos, grupos de entrada, sistema de navegação, notificações e muito mais...',
+	'CALL_TO_ACTION_FOOTER'			 => 'Active e desactive addons, use apenas o que realmente precisa!',
+	'PURCHASE_NOW_BTN'				 => 'Compre agora',
+	'FLATBOOTS_ABOUT_PART_ONE'		 => 'Porque é que iria contentar-se com menos, quando pode ter mais? Não deixe que outros autores o enganem com jogadas de Marketing. O FLATBOOTS é aquilo que merece. Construído para durar, construído a partir do zero, nada mais, nada menos.',
+	'FLATBOOTS_ABOUT_TITLE'			 => 'Construído para durar',
+	'DMCA'							 => 'DMCA',
+	'TERMS'							 => 'Termos e Condições',
+	'ADVERTISE'						 => 'Divulgue',
+	'DEVELOPER'						 => 'Desenvolvido por',
+	'LEINAD4MIND'					 => 'Leinad4Mind',
+	'SITESPLAT_URL'				 => '<a href="http://sitesplat.com" class="btn btn-default" target="blank">SiteSplat.com</a>',
+	'JOIN_US_TWITTER'				 => 'Segue-nos!',
+	'TWEET_EXAMPLE'				 => 'O BBOOTS atingiu as 500 vendas! Obrigado a todos os que apoiam este projecto e que contribuem com o SiteSplat para construir a comunidade. O que o futuro reserva? Mantém-te a par e segue-me no Twitter. <a href="#">http://bit.ly/000fefs</a>',
+
+));
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/de/filesystem.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/filesystem.php"
similarity index 97%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/filesystem.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/filesystem.php"
--- "[ORIGINAL]/sitesplat\\BBCore/language/de/filesystem.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/filesystem.php"
@@ -46,8 +46,8 @@ $lang = array_merge($lang, array(
 	'FTP_BAD_PATH'			=> 'Unable to select phpBB directory',
 	'FTP_FS_SUCCESS'		=> 'FTP access to filesystem was successful',
 
-	'BBCORE_SETTINGS'		=> 'BBCore Einstellungen',
-	'BBCORE_OPT_SAVED'		=> 'BBCore Einstellungen wurden gespeichert.',
+	'BBCORE_SETTINGS'		=> 'BBCore Settings',
+	'BBCORE_OPT_SAVED'		=> 'BBCore Settings have been saved.',
 
 	// minification
 	'SITESPLAT_BBCORE_MINIFY_HTML'			=> 'Minify HTML',
diff --git "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/info_acp_bbcore.php"
@@ -0,0 +1,60 @@
+<?php
+/**
+*
+* common [Portuguese]
+*
+* @package language
+* @package sitesplat BBcore
+* @version $Id$
+* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
+* @copyright (c) 2015 SiteSplat All rights reserved
+* @license Proprietary
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
+$lang = array_merge($lang, array(
+
+	'ACP_SITESPLAT_UPDATE_MANAGER'	 => 'Administrar Actualizações de SiteSplat',
+	'VERSION_INSTALLED'				 => 'Versão Instalada',
+	'NEW_BOOTS_VERSION'				 => 'Nova versão disponível: %s',
+	'VERSIONNUMBERS'				 => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
+	'SS_RAPID_DISABLE'				 => 'Desactivar Rápido SS',
+	'SS_RAPID_DISABLE_TLT'			 => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',
+
+	'DOWNLOAD_MSG'					 => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
+	'CHANGE_LOG_MSG'				 => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
+	'SUPPORT_FORUM_MSG'				 => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
+	'COLORIZE_MSG'					 => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
+	'NO_VERSIONINFO'				 => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',
+
+	'LOG_FILES_CHANGED'				 => '<strong>O BBcore alterou o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+	'LOG_THEME_INSTALLED'			 => '<strong>O BBcore foi instalado com sucesso</strong>',
+	'LOG_FILES_CHANGED_FAILED'		 => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
+	'LOG_THEME_UNINSTALLED'			 => '<strong>O BBcore foi desinstalado com sucesso</strong>',
+
+	'LOG_FILE_NOT_REPLACED'			 => '<strong>O BBcore não conseguiu substituir o ficheiro original por ti:</strong><br />» %s',
+	'LOG_FILE_NOT_UPDATED'			 => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s ficheiro(s) por ti:</strong><br />» %s',
+
+	'LOG_BBCORE_INSTALLED'			 => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
+	'LOG_BBCORE_DEINSTALLED'		 => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',
+
+	'LOG_BBCORE_NOT_REPLACED'		 => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) ficheiro(s)<br />» %s',
+	'LOG_BBCORE_NOT_UPDATED'		 => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) ficheiro(s)<br />» %s',
+
+	'ACP_BBCORE_MSG_FILES_FAIL'		 => 'Nem TODOS os ficheiros foram editados! Por favor, substitui manualmente o(s) ficheiro(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
+	'ACP_BBCORE_MSG_SETTINGS'		 => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de ficheiros no servidor ou à falta de ficheiros nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os ficheiros manualmente para desfrutar de todas as funcionalidades.',
+	'BBCORE_ERROR_DISABLE'			 => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
+));
diff --git "[ORIGINAL]/sitesplat\\BBCore/language/de/info_ucp_helper.php" "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
similarity index 78%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/language/de/info_ucp_helper.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
--- "[ORIGINAL]/sitesplat\\BBCore/language/de/info_ucp_helper.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/language/pt_preao/info_ucp_helper.php"
@@ -3,6 +3,7 @@
 *
 * @package language
 * @package sitesplat BBcore addon
+* @Traduzido por Leinad4Mind (c) 2016~2017 https://www.patreon.com/leinad4mind
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 *
@@ -55,14 +56,14 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge(
 	$lang, array(
-		'UCP_IR'				    => 'Image Resizer',
-		'IMAGE_RESIZE'			    => 'Image Resize',
-		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
+		'UCP_IR'				    => 'Redimensionar Imagem',
+		'IMAGE_RESIZE'			    => 'Redimensionamento de Imagem',
+		'IMAGE_RESIZE_EXPLAIN'	    => 'Corte %1$s da imagem e confirme.',
 		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',
 
-		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
+		'IMAGE_RESIZE_ERROR'	    => 'Nenhuma app ou ficheiro para enviar!',
 		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
-		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
-	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable AvatarResize because of other active premium extensions<br /><div>» %s</div>',
+	    'SS_HELPER_NOTY'	    	=> 'Core does not exist!<br />Download and copy the Core folder into your sitesplat extension folder.',
 	)
 );
diff --git "[ORIGINAL]/sitesplat\\BBCore/sitesplat.php" "[FORUM_EXT]/sitesplat\\BBCore/sitesplat.php"
--- "[ORIGINAL]/sitesplat\\BBCore/sitesplat.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/sitesplat.php"
@@ -1,98 +1,8 @@
 <?php
-
 /**
  * Code available to all SiteSplat extensions
- * @copyright (c) 2023 SiteSplat All rights reserved
+ * @copyright (c) 2021 SiteSplat All rights reserved
  * @license Proprietary
  */
-
 namespace sitesplat;
-
-function dl_params($dlfile, $url)
-{
-	return [CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_HEADER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => 'SiteSplatBot', CURLOPT_POST => true, CURLOPT_POSTFIELDS => "bbfile={$dlfile}", CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false,];
-}
-function emoji_convert($text)
-{
-	return empty($text) ? '' : mb_encode_numericentity($text, [0x10000, 0x1ffff, 0, 0xfffff], 'UTF-8', true);
-}
-function add_filter($event, $hook, $priority = 20)
-{
-	$is_ss = false;
-	$priority = (int) $priority;
-	if (empty($hook)) {
-		return false;
-	}
-	if (is_array($hook)) {
-		$is_ss = strpos(get_class($hook[0]), 'sitesplat\\') === 0;
-	}
-	if ($priority < 1 || (!$is_ss && $priority < 10)) {
-		$priority = 10;
-	} else if ($priority > 100 || (!$is_ss && $priority > 90)) {
-		$priority = 90;
-	}
-	addon::$events[$event][$priority][] = $hook;
-	return true;
-}
-function apply_filters($event, $args)
-{
-	if (!isset(addon::$events[$event])) {
-		return $args;
-	}
-	$hooks = addon::$events[$event];
-	krsort($hooks);
-	foreach ($hooks as $priority) {
-		foreach ($priority as $hook) {
-			$args = call_user_func($hook, $args);
-		}
-	}
-	unset(addon::$events[$event]);
-	return $args;
-}
-function load_ext_addons($ext)
-{
-	$s = DIRECTORY_SEPARATOR;
-	if (!defined('PHPBB_ROOT_DIR')) {
-		define('PHPBB_ROOT_DIR', strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}", true));
-	}
-	if (!empty(addon::$addons[$ext])) {
-		foreach (addon::$addons[$ext] as $name => $vendor) {
-			if ($name != 'ajax') {
-				$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}{$ext}.php";
-				if (file_exists($filename)) {
-					include($filename);
-					$cname = $vendor . '\\' . $name . '\\' . $ext;
-					new $cname;
-				}
-			}
-		}
-	}
-}
-function load_ext_lang($path, &$addon_lang)
-{
-	if (empty(addon::$addons)) {
-		return;
-	}
-	$s = DIRECTORY_SEPARATOR;
-	$lang = substr(strrchr($path, $s), 1);
-	foreach (addon::$addons as $data) {
-		foreach ($data as $name => $vendor) {
-			if ($name != 'ajax') {
-				$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}{$lang}{$s}{$name}.php";
-				if (!file_exists($filename)) {
-					$filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}en{$s}{$name}.php";
-				}
-				if (file_exists($filename)) {
-					include($filename);
-				}
-			}
-		}
-	}
-}
-final class addon
-{
-	private function __construct() {}
-	public static $data = [];
-	public static $addons = [];
-	public static $events = [];
-}
+function dl_params($dlfile, $url) { return [ CURLOPT_URL => $url, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_HEADER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_USERAGENT => 'SiteSplatBot', CURLOPT_POST => true, CURLOPT_POSTFIELDS => "bbfile={$dlfile}", CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false, ]; } function emoji_convert($text) { return (!$text) ? '' : preg_replace_callback('/([\x{1f000}-\x{1ffff}])/u', function($matches) { return strtolower('&#x' . dechex(substr(mb_convert_encoding($matches[1], 'HTML-ENTITIES', 'UTF-8'), 2, -1)) . ';'); }, $text); } function add_filter($event, $hook, $priority = 20) { $is_ss = false; $priority = (int) $priority; if (empty($hook)) { return false; } if (is_array($hook)) { $is_ss = strpos(get_class($hook[0]), 'sitesplat\\') === 0; } if ($priority < 1 || (!$is_ss && $priority < 10)) { $priority = 10; } else if ($priority > 100 || (!$is_ss && $priority > 90)) { $priority = 90; } addon::$events[$event][$priority][] = $hook; return true; } function apply_filters($event, $args) { if (!isset(addon::$events[$event])) { return $args; } $hooks = addon::$events[$event]; krsort($hooks); foreach ($hooks as $priority) { foreach ($priority as $hook) { $args = call_user_func($hook, $args); } } unset(addon::$events[$event]); return $args; } function load_ext_addons($ext) { $s = DIRECTORY_SEPARATOR; if (!defined('PHPBB_ROOT_DIR')) { define('PHPBB_ROOT_DIR', strstr(__DIR__, "{$s}ext{$s}sitesplat{$s}", true)); } if (!empty(addon::$addons[$ext])) { foreach (addon::$addons[$ext] as $name => $vendor) { if ($name != 'ajax') { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}{$ext}.php"; if (file_exists($filename)) { include($filename); $cname = $vendor . '\\' . $name . '\\' . $ext; new $cname; } } } } } function load_ext_lang($path, &$addon_lang) { if (empty(addon::$addons)) { return; } $s = DIRECTORY_SEPARATOR; $lang = substr(strrchr($path, $s), 1); foreach(addon::$addons as $data) { foreach ($data as $name => $vendor) { if ($name != 'ajax') { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}{$lang}{$s}{$name}.php"; if (!file_exists($filename)) { $filename = PHPBB_ROOT_DIR . "{$s}ext{$s}{$vendor}{$s}{$name}{$s}language{$s}en{$s}{$name}.php"; } if (file_exists($filename)) { include($filename); } } } } } class addon { public static $data = []; public static $addons = []; public static $events = []; }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html" "[FORUM_EXT]/sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
--- "[ORIGINAL]/sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
+++ "[FORUM_EXT]/sitesplat\\BBCore/styles/FLATBOOTS/template/offline_board_body.html"
@@ -3,23 +3,17 @@
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
-<meta name="designer" content="SiteSplat https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat">
+<meta name="designer" content="Leinad4Mind & Sitesplat">
 <meta content="{SITENAME}" property="og:site_name">
-<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
-
 <title>{SITENAME} {PAGE_TITLE}</title>
-
-<!-- phpBB Premium style name: FLATBOOTS @SiteSplat.com -->
-
 <!-- Google free font here -->
 <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600' rel='stylesheet'>
 <link href='//fonts.googleapis.com/css?family=Asap+Condensed:600' rel='stylesheet'>
 
 <!-- CSS files start here-->
-
-<link href="{T_STYLESHEET_LINK}" rel="stylesheet">
-<link href="{T_STYLESHEET_OFFLINE}" rel="stylesheet">
-<link href="{T_STYLESHEET_ANIMATE}" rel="stylesheet">
+<link href="{T_STYLESHEET_LINK}?assets_version=3.3" rel="stylesheet">
+<link href="{T_STYLESHEET_OFFLINE}?assets_version=3.3" rel="stylesheet">
+<link href="{T_STYLESHEET_ANIMATE}?assets_version=3.3" rel="stylesheet">
 <!-- CSS files -->
 </head>
 
@@ -30,15 +24,14 @@
 	 <div class="container">
 		<div class="content-a">
             <div class="content-b">
-              <h1 class="wow fadeInDown">{L_BOARD_DISABLED}</h1>
-              <h2 class="wow fadeInUp" data-wow-delay="0.5s">{ACP_DISABLE_MESSAGE}</h2>
+              <!-- <h1 class="wow fadeInDown">{L_BOARD_DISABLED}</h1> -->
+              <h2 class="wow fadeInUp goldenstar" data-wow-delay="0.5s">{ACP_DISABLE_MESSAGE}</h2>
                 <div class="wow bounceIn clearfix socialbar" data-wow-delay="1.2s">
 					<div class="social-network">
-						<a class="github-color" title="Github" href="#2"><i class="fa fa-github"></i></a>
-						<a class="pinterest-color" title="Pinterest" href="#5"><i class="fa fa-pinterest"></i></a> 
-						<a class="facebook-color" title="Facebook" href="#6"><i class="fa fa-facebook"></i></a>
-						<a class="twitter-color" title="Twitter" href="https://twitter.com/SiteSplat"><i class="fa fa-twitter"></i></a>
-						<a class="google-plus-color" title="YouTube" href="#8"><i class="fa fa-youtube"></i></a>
+						<a class="youtube-color" title="YouTube" href="https://www.youtube.com/user/GoldTugAnimeOFICIAL"><i class="fa fa-youtube"></i></a>
+						<a class="facebook-color" title="Facebook" href="https://www.facebook.com/goldtuganimeoficial"><i class="fa fa-facebook"></i></a>
+						<a class="twitter-color" title="Twitter" href="https://twitter.com/GoldTugAnime"><i class="fa fa-twitter"></i></a>
+						<a class="instagram-color" title="Instagram" href="https://www.instagram.com/goldtuganime"><i class="fa fa-instagram"></i></a>
 						<a class="github-color" title="{L_LOGIN_LOGOUT}" href="{U_LOGIN_LOGOUT}"><i class="fa fa-gear"></i></a>
 					</div>
 				</div>
diff --git "[FORUM_EXT]/sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png" "[FORUM_EXT]/sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\BBCore/styles/FLATBOOTS/theme/images/gta_back.png" differ
diff --git "[ORIGINAL]/sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css" "[FORUM_EXT]/sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
--- "[ORIGINAL]/sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
+++ "[FORUM_EXT]/sitesplat\\BBCore/styles/FLATBOOTS/theme/offline.css"
@@ -1,225 +1 @@
-.flat-header {
-    color: #fafafa;
-    font-size: 20px;
-    height: 172px;
-    margin-bottom: 20px;
-    overflow: hidden;
-    position: relative;
-    text-align: left;
-    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.1);
-    width: 100%;
-}
-.masthead:before {
-  position: absolute;
-  z-index: 1;
-  top: 0;
-  left: 0;
-  width: 200%;
-  height: 400%;
-  content: "";
-  background: url("./images/tile-bg-head.png") 0 0 #26bcb5;
-  background-repeat: repeat;
-}
-.masthead {
-  position: relative;
-  height: 100%;
-  width: 100%;
-  -webkit-animation-name: sideupscroll;
-          animation-name: sideupscroll;
-  -webkit-animation-duration: 70s;
-          animation-duration: 70s;
-  -webkit-animation-timing-function: linear;
-          animation-timing-function: linear;
-  -webkit-animation-iteration-count: infinite;
-          animation-iteration-count: infinite;
-  -webkit-animation-fill-mode: both;
-          animation-fill-mode: both;
-}
-@-webkit-keyframes sideupscroll {
-  0% {
-    -webkit-transform: translateX(0%) translateY(0%);
-            transform: translateX(0%) translateY(0%);
-  }
-  50% {
-    -webkit-transform: translateX(-50%) translateY(-100%);
-            transform: translateX(-50%) translateY(-100%);
-  }
-  100% {
-    -webkit-transform: translateX(-100%) translateY(-200%);
-            transform: translateX(-100%) translateY(-200%);
-  }
-}
-@keyframes sideupscroll {
-  0% {
-    -webkit-transform: translateX(0%) translateY(0%);
-            transform: translateX(0%) translateY(0%);
-  }
-  50% {
-    -webkit-transform: translateX(-50%) translateY(-100%);
-            transform: translateX(-50%) translateY(-100%);
-  }
-  100% {
-    -webkit-transform: translateX(-100%) translateY(-200%);
-            transform: translateX(-100%) translateY(-200%);
-  }
-}
-
-.wrapper-head {
-    margin-top: -35%;
-    position: relative;
-    z-index: 2;
-}
-
-
-@media (min-width: 769px) and (max-width: 1100px) {
-
-	.wrapper-head {
-    margin-top: -50%;
-    }
-	
-	.wrapper-head h1, .wrapper-head h2 {
-    font-size: 22px;
-    }
-}	
-
-
-@media (min-width: 469px) and (max-width: 768px) {
-
-	.wrapper-head {
-    top: -30%;
-    }
-	
-	.wrapper-head h1, .wrapper-head h2 {
-    font-size: 22px;
-    }
-}	
-
-@media (max-width: 468px) {
-    body {
-        font-size: 15px;
-    }
-
-	.wrapper-head {
-    margin-top: -120%;
-    }
-	
-	.wrapper-head h1, .wrapper-head h2 {
-    font-size: 22px;
-    }
-
-    .flat-header {
-    font-size: 14px;
-    }
-}	
-
-
-/* background setup */
-.background {
-    background-repeat:no-repeat;
-    /* custom background-position */
-    background-position:50% 50%;
-    /* ie8- graceful degradation */
-    background-position:50% 50%\9 !important;
-}
-
-/* fullscreen setup */
-html, body {
-    /* give this to all tags from html to .fullscreen */
-    height:100%;
-}
-.fullscreen,
-.content-a {
-    width:100%;
-    min-height:100%;
-}
-.not-fullscreen,
-.not-fullscreen .content-a,
-.fullscreen.not-overflow,
-.fullscreen.not-overflow .content-a {
-    height:100%;
-    overflow:hidden;
-}
-
-/* content centering styles */
-.content-a {
-	display:table;
-}
-.content-b {
-	display:table-cell;
-    position:relative;
-	vertical-align:middle;
-	text-align:center;
-	z-index: 1;
-}
-
-/* visual styles */
-body{
-    margin:0;
-    font-size:28px;
-    line-height:100px;
-	color:#ffffff;
-    text-align:center;
-}
-section {
-	background:#9ed100;
-}
-.not-fullscreen {
-    height:50%;
-}
-
-h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a {
-    color: #fff !important;
-    font-family: "Asap","Arial","Helvetica",sans-serif;
-    font-weight: 700;
-    line-height: normal;
-    margin: 0 0 10px;
-    text-rendering: optimizelegibility;
-}
-.social-network {
-    text-align: center;
-}
-.social-network a {
-    border-radius: 2px;
-    color: #fff !important;
-    display: inline-block;
-    font-size: 20px;
-    height: 30px;
-    margin: 0 3px;
-    transition: all 0.2s linear 0s;
-    width: 30px;
-	line-height: 30px;
-}
-
-
-.google-plus-color {
-    background-color: #d34836;
-}
-.github-color {
-    background-color: #333;
-}
-.facebook-color {
-    background-color: #3b5998;
-}
-.twitter-color {
-    background-color: #00aced;
-}
-.pinterest-color {
-    background-color: #cb2027;
-}
-.github-color {
-    background-color: #333;
-}
-
-.social-network a:hover {
-    transition: all .1s linear 0s;
-    color: #2d2d2d!important;
-    border-bottom: none;
-    background-color: #fff;
-	outline: none;
-    text-decoration: none;
-}
-
-.social-network a:focus {
-    outline: none;
-    text-decoration: none;
-}
+.flat-header{color:#fafafa;font-size:20px;height:172px;margin-bottom:20px;overflow:hidden;position:relative;text-align:left;text-shadow:0 1px 0 rgba(0,0,0,0.1);width:100%}.masthead:before{position:absolute;z-index:1;top:0;left:0;width:200%;height:400%;content:"";background:url(./images/gta_back.png) 0 0 #26bcb5;background-repeat:repeat}.masthead{position:relative;height:100%;width:100%;-webkit-animation-name:sideupscroll;animation-name:sideupscroll;-webkit-animation-duration:70s;animation-duration:70s;-webkit-animation-timing-function:linear;animation-timing-function:linear;-webkit-animation-iteration-count:infinite;animation-iteration-count:infinite;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes sideupscroll{0%{-webkit-transform:translateX(0%) translateY(0%);transform:translateX(0%) translateY(0%)}50%{-webkit-transform:translateX(-50%) translateY(-100%);transform:translateX(-50%) translateY(-100%)}100%{-webkit-transform:translateX(-100%) translateY(-200%);transform:translateX(-100%) translateY(-200%)}}@keyframes sideupscroll{0%{-webkit-transform:translateX(0%) translateY(0%);transform:translateX(0%) translateY(0%)}50%{-webkit-transform:translateX(-50%) translateY(-100%);transform:translateX(-50%) translateY(-100%)}100%{-webkit-transform:translateX(-100%) translateY(-200%);transform:translateX(-100%) translateY(-200%)}}.wrapper-head{margin-top:-35%;position:relative;z-index:2}@media (min-width: 769px) and (max-width: 1100px){.wrapper-head{margin-top:-50%}.wrapper-head h1,.wrapper-head h2{font-size:22px}}@media (min-width: 469px) and (max-width: 768px){.wrapper-head{top:-30%}.wrapper-head h1,.wrapper-head h2{font-size:22px}}@media (max-width: 468px){body{font-size:15px}.wrapper-head{margin-top:-120%}.wrapper-head h1,.wrapper-head h2{font-size:22px}.flat-header{font-size:14px}}.background{background-repeat:no-repeat;background-position:50% 50%;background-position:50% 50%\9!important}html,body{height:100%}.fullscreen,.content-a{width:100%;min-height:100%}.not-fullscreen,.not-fullscreen .content-a,.fullscreen.not-overflow,.fullscreen.not-overflow .content-a{height:100%;overflow:hidden}.content-a{display:table}.content-b{display:table-cell;position:relative;vertical-align:middle;text-align:center;z-index:1}body{margin:0;font-size:28px;line-height:100px;color:#fff;text-align:center}section{background:#9ed100}.not-fullscreen{height:50%}h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#fff!important;font-family:"Asap","Arial","Helvetica",sans-serif;font-weight:700;line-height:normal;margin:0 0 10px;text-rendering:optimizelegibility}.social-network{text-align:center}.social-network a{border-radius:2px;color:#fff!important;display:inline-block;font-size:20px;height:30px;margin:0 3px;transition:all .2s linear 0;width:30px;line-height:30px}.google-plus-color{background-color:#d34836}.github-color{background-color:#333}.facebook-color{background-color:#3b5998}.twitter-color{background-color:#00aced}.pinterest-color{background-color:#cb2027}.github-color{background-color:#333}.social-network a:hover{transition:all .1s linear 0;color:#2d2d2d!important;border-bottom:none;background-color:#fff;outline:none;text-decoration:none}.social-network a:focus{outline:none;text-decoration:none}.instagram-color{background-color:#5851db}.youtube-color{background-color:red}.goldenstar{width:50vw;margin:auto}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/next_step_resolver.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/next_step_resolver.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/next_step_resolver.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/next_step_resolver.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -9,133 +8,4 @@
 */
 
 namespace sitesplat\BBCore\updater;
-
-class next_step_resolver
-{
-	protected $config_text;
-	protected $filesystem;
-	protected $container;
-	protected $root_path;
-	protected $real_root_path;
-	protected $old_handler;
-	protected $phperror = '';
-	protected $start_time;
-	protected $max_execution_time;
-	protected $memory_limit;
-	public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path)
-	{
-		$this->config_text = $config_text;
-		$this->filesystem = $filesystem;
-		$this->container = $container;
-		$this->root_path = $root_path;
-		$this->real_root_path = realpath($root_path) . '/';
-		$this->start_time = microtime(true);
-		$execution_time = $php_ini->getNumeric('max_execution_time');
-		$this->max_execution_time = min(15, $execution_time / 2);
-		$this->memory_limit = $php_ini->getBytes('memory_limit');
-	}
-	public function msg_handler($errno, $msg_text, $errfile, $errline)
-	{
-		if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) {
-			$errfile = phpbb_filter_root_path($errfile);
-			$msg_text = phpbb_filter_root_path($msg_text);
-			$error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice';
-			$this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n";
-			return true;
-		} else if (!empty($this->old_handler)) {
-			return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]);
-		}
-		return false;
-	}
-	public function run_task($fs, $style_name)
-	{
-		$this->old_handler = set_error_handler([$this, 'msg_handler']);
-		$updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true);
-		if (empty($updater_config['last_step'])) {
-			$updater_config['last_step'] = '';
-			$updater_config['merge_conflicts'] = false;
-			$this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name);
-		}
-		try {
-			while ($this->has_enought_time() && $this->has_enough_memory()) {
-				switch ($updater_config['last_step']) {
-					case '':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't0_backup':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't1_get_current_style_cfg':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't2_get_newest_style_cfg':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't3_check_problems':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't4_download_newest_version':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't5_unzip_new_version':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't6_load_list_of_changes':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't7_merge_edits':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't8_check_additions':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't9_update_edits':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't10_update_added':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't11_update_deleted':
-						$updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config);
-						$this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config));
-						break;
-					case 't12_log_changes':
-						$this->config_text->set('sitesplat_bbcore_updater', '');
-						return true;
-						break;
-				}
-				return $this->phperror ?: false;
-			}
-		} catch (\Exception $e) {
-			$this->config_text->set('sitesplat_bbcore_updater', '');
-			return $e->getMessage();
-		}
-		return false;
-	}
-	protected function has_enought_time()
-	{
-		return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0;
-	}
-	protected function has_enough_memory()
-	{
-		if ($this->memory_limit <= 0) {
-			return true;
-		}
-		if (function_exists('memory_get_usage')) {
-			return ($this->memory_limit - memory_get_usage()) > 0;
-		}
-		return true;
-	}
-}
+class next_step_resolver { protected $config_text; protected $filesystem; protected $container; protected $root_path; protected $real_root_path; protected $old_handler; protected $phperror = ''; protected $start_time; protected $max_execution_time; protected $memory_limit; public function __construct(\phpbb\config\db_text $config_text, \phpbb\filesystem\filesystem_interface $filesystem, \Symfony\Component\DependencyInjection\ContainerInterface $container, \bantu\IniGetWrapper\IniGetWrapper $php_ini, $root_path) { $this->config_text = $config_text; $this->filesystem = $filesystem; $this->container = $container; $this->root_path = $root_path; $this->real_root_path = realpath($root_path) . '/'; $this->start_time = microtime(true); $execution_time = $php_ini->getNumeric('max_execution_time'); $this->max_execution_time = min(15, $execution_time / 2); $this->memory_limit = $php_ini->getBytes('memory_limit'); } public function msg_handler($errno, $msg_text, $errfile, $errline) { if (error_reporting() != 0 && ($errno == E_NOTICE || $errno == E_WARNING)) { $errfile = phpbb_filter_root_path($errfile); $msg_text = phpbb_filter_root_path($msg_text); $error_name = ($errno === E_WARNING) ? 'PHP Warning' : 'PHP Notice'; $this->phperror .= "<b>$error_name</b> in file <b>$errfile</b> on line <b>$errline</b>: <b>$msg_text</b><br />\n"; return true; } else if (!empty($this->old_handler)) { return call_user_func_array($this->old_handler, [$errno, $msg_text, $errfile, $errline]); } return false; } public function run_task($fs, $style_name) { $this->old_handler = set_error_handler([$this, 'msg_handler']); $updater_config = json_decode($this->config_text->get('sitesplat_bbcore_updater'), true); if (empty($updater_config['last_step'])) { $updater_config['last_step'] = ''; $updater_config['merge_conflicts'] = false; $this->filesystem->remove($this->real_root_path . 'store/merge_conflicts_' . $style_name); } try { while($this->has_enought_time() && $this->has_enough_memory()) { switch ($updater_config['last_step']) { case '': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t0_backup')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't0_backup': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t1_get_current_style_cfg')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't1_get_current_style_cfg': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t2_get_newest_style_cfg')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't2_get_newest_style_cfg': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t3_check_problems')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't3_check_problems': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t4_download_newest_version')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't4_download_newest_version': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t5_unzip_new_version')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't5_unzip_new_version': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t6_load_list_of_changes')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't6_load_list_of_changes': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t7_merge_edits')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't7_merge_edits': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t8_check_additions')->run($style_name, $updater_config, $this->real_root_path); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't8_check_additions': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t9_update_edits')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't9_update_edits': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t10_update_added')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't10_update_added': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t11_update_deleted')->run($style_name, $updater_config, $this->real_root_path, $fs); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't11_update_deleted': $updater_config = $this->container->get('sitesplat.bbcore.updater.task.t12_log_changes')->run($style_name, $updater_config); $this->config_text->set('sitesplat_bbcore_updater', json_encode($updater_config)); break; case 't12_log_changes': $this->config_text->set('sitesplat_bbcore_updater', ''); return true; break; } return $this->phperror ?: false; } } catch (\Exception $e) { $this->config_text->set('sitesplat_bbcore_updater', ''); return $e->getMessage(); } return false; } protected function has_enought_time() { return (($this->start_time + $this->max_execution_time) - microtime(true)) > 0; } protected function has_enough_memory() { if ($this->memory_limit <= 0) { return true; } if (function_exists('memory_get_usage')) { return ($this->memory_limit - memory_get_usage()) > 0; } return true; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t0_backup.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t0_backup.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t0_backup.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t0_backup.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,25 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t0_backup
-{
-	protected $filesystem;
-	protected $root_path;
-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
-	{
-		$this->filesystem = $filesystem;
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path)
-	{
-		$this->root_path = $root_path;
-		$backup_dir = $this->root_path . 'store/' . $style_name . '_' . time();
-		$this->filesystem->mkdir($backup_dir);
-		$this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir);
-		$updater_config['last_step'] = 't0_backup';
-		return $updater_config;
-	}
-}
+class t0_backup { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $backup_dir = $this->root_path . 'store/' . $style_name . '_' . time(); $this->filesystem->mkdir($backup_dir); $this->filesystem->mirror($this->root_path . 'styles/' . $style_name, $backup_dir); $updater_config['last_step'] = 't0_backup'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t10_update_added.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t10_update_added.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t10_update_added.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t10_update_added.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,33 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t10_update_added
-{
-	protected $root_path;
-	public function __construct($root_path)
-	{
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path, $fs)
-	{
-		$this->root_path = $root_path;
-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
-		if (!empty($updater_config['update_info']['added_dirs'])) {
-			foreach ($updater_config['update_info']['added_dirs'] as $file_path) {
-				$fs->mkdir($current_files_path . $file_path);
-			}
-			unset($updater_config['update_info']['added_dirs']);
-		}
-		if (!empty($updater_config['update_info']['added'])) {
-			foreach ($updater_config['update_info']['added'] as $file_path) {
-				$fs->put($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path), true);
-			}
-			unset($updater_config['update_info']['added']);
-		}
-		$updater_config['last_step'] = 't10_update_added';
-		return $updater_config;
-	}
-}
+class t10_update_added { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['added_dirs'])) { foreach ($updater_config['update_info']['added_dirs'] as $file_path) { $fs->mkdir($current_files_path . $file_path); } unset($updater_config['update_info']['added_dirs']); } if (!empty($updater_config['update_info']['added'])) { foreach ($updater_config['update_info']['added'] as $file_path) { $fs->put($current_files_path . $file_path, file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path), true); } unset($updater_config['update_info']['added']); } $updater_config['last_step'] = 't10_update_added'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t11_update_deleted.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t11_update_deleted.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t11_update_deleted.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t11_update_deleted.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,35 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t11_update_deleted
-{
-	protected $filesystem;
-	protected $root_path;
-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
-	{
-		$this->filesystem = $filesystem;
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path, $fs)
-	{
-		$this->root_path = $root_path;
-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
-		if (!empty($updater_config['update_info']['deleted'])) {
-			foreach ($updater_config['update_info']['deleted'] as $file_path) {
-				$fs->delete($current_files_path . $file_path);
-			}
-			unset($updater_config['update_info']['deleted']);
-		}
-		if (!empty($updater_config['update_info']['deleted_dirs'])) {
-			foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) {
-				$fs->rmdir($current_files_path . $file_path);
-			}
-			unset($updater_config['update_info']['deleted_dirs']);
-		}
-		$updater_config['last_step'] = 't11_update_deleted';
-		return $updater_config;
-	}
-}
+class t11_update_deleted { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; if (!empty($updater_config['update_info']['deleted'])) { foreach ($updater_config['update_info']['deleted'] as $file_path) { $fs->delete($current_files_path . $file_path); } unset($updater_config['update_info']['deleted']); } if (!empty($updater_config['update_info']['deleted_dirs'])) { foreach ($updater_config['update_info']['deleted_dirs'] as $file_path) { $fs->rmdir($current_files_path . $file_path); } unset($updater_config['update_info']['deleted_dirs']); } $updater_config['last_step'] = 't11_update_deleted'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t12_log_changes.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t12_log_changes.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t12_log_changes.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t12_log_changes.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,22 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t12_log_changes
-{
-	protected $log;
-	protected $user;
-	public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user)
-	{
-		$this->log = $log;
-		$this->user = $user;
-	}
-	public function run($style_name, $updater_config)
-	{
-		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [$style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-',]);
-		$updater_config['last_step'] = 't12_log_changes';
-		return $updater_config;
-	}
-}
+class t12_log_changes { protected $log; protected $user; public function __construct(\phpbb\log\log_interface $log, \phpbb\user $user) { $this->log = $log; $this->user = $user; } public function run($style_name, $updater_config) { $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_STYLE_UPDATED', false, [ $style_name, !empty($updater_config['log_data']['edited']) ? implode('<br />&emsp;', $updater_config['log_data']['edited']) : '-', !empty($updater_config['log_data']['added']) ? implode('<br />&emsp;', $updater_config['log_data']['added']) : '-', !empty($updater_config['log_data']['deleted']) ? implode('<br />&emsp;', $updater_config['log_data']['deleted']) : '-', ]); $updater_config['last_step'] = 't12_log_changes'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t1_get_current_style_cfg.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,21 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t1_get_current_style_cfg
-{
-	protected $root_path;
-	public function __construct($root_path)
-	{
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path)
-	{
-		$this->root_path = $root_path;
-		$updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg');
-		$updater_config['last_step'] = 't1_get_current_style_cfg';
-		return $updater_config;
-	}
-}
+class t1_get_current_style_cfg { protected $root_path; public function __construct($root_path) { $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $updater_config['cfg_data'] = parse_cfg_file($this->root_path . 'styles/' . strtoupper($style_name) . '/style.cfg'); $updater_config['last_step'] = 't1_get_current_style_cfg'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t2_get_newest_style_cfg.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,25 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t2_get_newest_style_cfg
-{
-	protected $file_downloader;
-	protected $host;
-	protected $versioncheck_path;
-	public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path)
-	{
-		$this->file_downloader = $file_downloader;
-		$this->host = $host;
-		$this->versioncheck_path = $versioncheck_path;
-	}
-	public function run($style_name, $updater_config)
-	{
-		$info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name, 443);
-		$updater_config['style_data'] = json_decode($info, true);
-		$updater_config['last_step'] = 't2_get_newest_style_cfg';
-		return $updater_config;
-	}
-}
+class t2_get_newest_style_cfg { protected $file_downloader; protected $host; protected $versioncheck_path; public function __construct(\phpbb\file_downloader $file_downloader, $host, $versioncheck_path) { $this->file_downloader = $file_downloader; $this->host = $host; $this->versioncheck_path = $versioncheck_path; } public function run($style_name, $updater_config) { $info = $this->file_downloader->get($this->host, $this->versioncheck_path, $style_name, 443); $updater_config['style_data'] = json_decode($info, true); $updater_config['last_step'] = 't2_get_newest_style_cfg'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t3_check_problems.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t3_check_problems.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t3_check_problems.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t3_check_problems.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,20 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t3_check_problems
-{
-	public function run($style_name, $updater_config)
-	{
-		if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>=')) {
-			throw new \Exception('ALREADY_UP_TO_DATE');
-		}
-		if (empty($updater_config['style_data']['direct_download_dir'])) {
-			throw new \Exception('NO_DIRECT_DOWNLOAD');
-		}
-		$updater_config['last_step'] = 't3_check_problems';
-		return $updater_config;
-	}
-}
+class t3_check_problems { public function run($style_name, $updater_config) { if (version_compare($updater_config['cfg_data']['style_version'], $updater_config['style_data']['version'], '>=')) { throw new \Exception('ALREADY_UP_TO_DATE'); } if (empty($updater_config['style_data']['direct_download_dir'])) { throw new \Exception('NO_DIRECT_DOWNLOAD'); } $updater_config['last_step'] = 't3_check_problems'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t4_download_newest_version.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t4_download_newest_version.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,51 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t4_download_newest_version
-{
-	protected $file_downloader;
-	protected $filesystem;
-	protected $host;
-	protected $download_path;
-	protected $root_path;
-	public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path)
-	{
-		$this->file_downloader = $file_downloader;
-		$this->filesystem = $filesystem;
-		$this->host = $host;
-		$this->download_path = $download_path;
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path)
-	{
-		$this->root_path = $root_path;
-		$ch = curl_init();
-		curl_setopt($ch, CURLOPT_URL, "https://{$this->host}/{$this->download_path}{$updater_config['style_data']['direct_download_dir']}/{$updater_config['cfg_data']['style_version']}_to_{$updater_config['style_data']['version']}.zip");
-		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
-		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
-		curl_setopt($ch, CURLOPT_USERAGENT, 'sitesplat_updater');
-		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
-		curl_setopt($ch, CURLOPT_POST, true);
-		curl_setopt($ch, CURLOPT_POSTFIELDS, "");
-		$zip = curl_exec($ch);
-		if (curl_errno($ch)) {
-			throw new \Exception(curl_error($ch));
-		}
-		$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
-		curl_close($ch);
-		if ($http != 200 || empty($zip)) {
-			throw new \Exception('PROBLEM_DOWNLOADING_UPDATE');
-		}
-		$tmp_path = $this->root_path . 'store/';
-		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
-		if (file_exists($tmp_file)) {
-			$this->filesystem->remove($tmp_file);
-		}
-		file_put_contents($tmp_file, $zip);
-		$updater_config['last_step'] = 't4_download_newest_version';
-		return $updater_config;
-	}
-}
+class t4_download_newest_version { protected $file_downloader; protected $filesystem; protected $host; protected $download_path; protected $root_path; public function __construct(\phpbb\file_downloader $file_downloader, \phpbb\filesystem\filesystem_interface $filesystem, $host, $download_path, $root_path) { $this->file_downloader = $file_downloader; $this->filesystem = $filesystem; $this->host = $host; $this->download_path = $download_path; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; $ch = curl_init(); curl_setopt($ch, CURLOPT_URL, "https://{$this->host}/{$this->download_path}{$updater_config['style_data']['direct_download_dir']}/{$updater_config['cfg_data']['style_version']}_to_{$updater_config['style_data']['version']}.zip"); curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); curl_setopt($ch, CURLOPT_USERAGENT, 'sitesplat_updater'); curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_POSTFIELDS, ""); $zip = curl_exec($ch); if (curl_errno($ch)) { throw new \Exception(curl_error($ch)); } $http = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch); if ($http != 200 || empty($zip)) { throw new \Exception('PROBLEM_DOWNLOADING_UPDATE'); } $tmp_path = $this->root_path . 'store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; if (file_exists($tmp_file)) { $this->filesystem->remove($tmp_file); } file_put_contents($tmp_file, $zip); $updater_config['last_step'] = 't4_download_newest_version'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t5_unzip_new_version.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t5_unzip_new_version.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,36 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t5_unzip_new_version
-{
-	protected $filesystem;
-	protected $root_path;
-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path)
-	{
-		$this->filesystem = $filesystem;
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path, $fs)
-	{
-		$tmp_path = $fs->phpbb_root_dir . '/store/';
-		$tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip';
-		$updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/';
-		$fs_type = $fs->fs_type;
-		$fs->fs_type = 'direct';
-		if (file_exists($updater_config['tmp_dir'])) {
-			$this->filesystem->remove($updater_config['tmp_dir']);
-		}
-		$this->filesystem->mkdir($updater_config['tmp_dir']);
-		$result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']);
-		if ($result === false) {
-			throw new \Exception($fs->ftp_error);
-		}
-		$this->filesystem->remove($tmp_file);
-		$fs->fs_type = $fs_type;
-		$updater_config['last_step'] = 't5_unzip_new_version';
-		return $updater_config;
-	}
-}
+class t5_unzip_new_version { protected $filesystem; protected $root_path; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, $root_path) { $this->filesystem = $filesystem; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $tmp_path = $fs->phpbb_root_dir . '/store/'; $tmp_file = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '.zip'; $updater_config['tmp_dir'] = $tmp_path . 'bbcore_autoupdate_' . $updater_config['style_data']['direct_download_dir'] . '/'; $fs_type = $fs->fs_type; $fs->fs_type = 'direct'; if (file_exists($updater_config['tmp_dir'])) { $this->filesystem->remove($updater_config['tmp_dir']); } $this->filesystem->mkdir($updater_config['tmp_dir']); $result = $fs->zip_extract($tmp_file, $updater_config['tmp_dir']); if ($result === false) { throw new \Exception($fs->ftp_error); } $this->filesystem->remove($tmp_file); $fs->fs_type = $fs_type; $updater_config['last_step'] = 't5_unzip_new_version'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t6_load_list_of_changes.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,23 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t6_load_list_of_changes
-{
-	protected $root_path;
-	protected $php_ext;
-	public function __construct($root_path, $php_ext)
-	{
-		$this->root_path = $root_path;
-		$this->php_ext = $php_ext;
-	}
-	public function run($style_name, $updater_config)
-	{
-		include($updater_config['tmp_dir'] . 'index.' . $this->php_ext);
-		$updater_config['update_info'] = $updater_config['log_data'] = $update_info;
-		$updater_config['last_step'] = 't6_load_list_of_changes';
-		return $updater_config;
-	}
-}
+class t6_load_list_of_changes { protected $root_path; protected $php_ext; public function __construct($root_path, $php_ext) { $this->root_path = $root_path; $this->php_ext = $php_ext; } public function run($style_name, $updater_config) { include($updater_config['tmp_dir'] . 'index.' . $this->php_ext); $updater_config['update_info'] = $updater_config['log_data'] = $update_info; $updater_config['last_step'] = 't6_load_list_of_changes'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t7_merge_edits.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t7_merge_edits.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t7_merge_edits.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t7_merge_edits.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,74 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t7_merge_edits
-{
-	protected $filesystem;
-	protected $cache;
-	protected $language;
-	protected $root_path;
-	protected $php_ext;
-	public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, \phpbb\cache\driver\driver_interface $cache, \phpbb\language\language $language, $root_path, $php_ext)
-	{
-		$this->filesystem = $filesystem;
-		$this->cache = $cache;
-		$this->language = $language;
-		$this->root_path = $root_path;
-		$this->php_ext = $php_ext;
-	}
-	public function run($style_name, $updater_config, $root_path)
-	{
-		$this->root_path = $root_path;
-		if (empty($updater_config['update_info']['edited'])) {
-			if ($updater_config['merge_conflicts']) {
-				throw new \Exception($this->language->lang('MERGE_CONFLICTS', 'store/merge_conflicts_' . $style_name));
-			}
-			$updater_config['last_step'] = 't7_merge_edits';
-			return $updater_config;
-		}
-		if (empty($updater_config['merge_calculated'])) {
-			$updater_config['merge_calculated'] = [];
-		}
-		if (!class_exists('diff3')) {
-			include($this->root_path . 'includes/diff/diff.' . $this->php_ext);
-		}
-		if (!class_exists('diff_engine')) {
-			include($this->root_path . 'includes/diff/engine.' . $this->php_ext);
-		}
-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
-		$file_diffed = false;
-		foreach ($updater_config['update_info']['edited'] as $key => $file_path) {
-			if (in_array($file_path, $updater_config['merge_calculated'])) {
-				continue;
-			}
-			$new_file_contents = @file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path);
-			if (file_exists($current_files_path . $file_path)) {
-				$file_contents[0] = @file_get_contents($updater_config['tmp_dir'] . 'old/' . $file_path);
-				$file_contents[1] = @file_get_contents($current_files_path . $file_path);
-				$file_contents[2] = $new_file_contents;
-				$diff = new \diff3($file_contents[0], $file_contents[1], $file_contents[2]);
-				if ($diff->get_num_conflicts() !== 0) {
-					$updater_config['merge_conflicts'] = true;
-					$merge_conflicts_path = $this->root_path . 'store/merge_conflicts_' . $style_name . '/';
-					$this->filesystem->mkdir($merge_conflicts_path . dirname($file_path));
-					file_put_contents($merge_conflicts_path . $file_path, implode("\n", $diff->merged_output()));
-				}
-				if ($diff->merged_output() !== $file_contents[1]) {
-					$this->cache->put('_bbcore_updater_' . md5($file_path), implode("\n", $diff->merged_output()));
-					$updater_config['merge_calculated'][] = $file_path;
-				}
-				unset($file_contents);
-				unset($diff);
-			} else {
-				$this->cache->put('_bbcore_updater_' . md5($file_path), $new_file_contents);
-				$updater_config['merge_calculated'][] = $file_path;
-			}
-			unset($updater_config['update_info']['edited'][$key]);
-			break;
-		}
-		return $updater_config;
-	}
-}
+class t7_merge_edits { protected $filesystem; protected $cache; protected $language; protected $root_path; protected $php_ext; public function __construct(\phpbb\filesystem\filesystem_interface $filesystem, \phpbb\cache\driver\driver_interface $cache, \phpbb\language\language $language, $root_path, $php_ext) { $this->filesystem = $filesystem; $this->cache = $cache; $this->language = $language; $this->root_path = $root_path; $this->php_ext = $php_ext; } public function run($style_name, $updater_config, $root_path) { $this->root_path = $root_path; if (empty($updater_config['update_info']['edited'])) { if ($updater_config['merge_conflicts']) { throw new \Exception($this->language->lang('MERGE_CONFLICTS', 'store/merge_conflicts_' . $style_name)); } $updater_config['last_step'] = 't7_merge_edits'; return $updater_config; } if (empty($updater_config['merge_calculated'])) { $updater_config['merge_calculated'] = []; } if (!class_exists('diff3')) { include($this->root_path . 'includes/diff/diff.' . $this->php_ext); } if (!class_exists('diff_engine')) { include($this->root_path . 'includes/diff/engine.' . $this->php_ext); } $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; $file_diffed = false; foreach ($updater_config['update_info']['edited'] as $key => $file_path) { if (in_array($file_path, $updater_config['merge_calculated'])) { continue; } $new_file_contents = @file_get_contents($updater_config['tmp_dir'] . 'new/' . $file_path); if (file_exists($current_files_path . $file_path)) { $file_contents[0] = @file_get_contents($updater_config['tmp_dir'] . 'old/' . $file_path); $file_contents[1] = @file_get_contents($current_files_path . $file_path); $file_contents[2] = $new_file_contents; $diff = new \diff3($file_contents[0], $file_contents[1], $file_contents[2]); if ($diff->get_num_conflicts() !== 0) { $updater_config['merge_conflicts'] = true; $merge_conflicts_path = $this->root_path . 'store/merge_conflicts_' . $style_name . '/'; $this->filesystem->mkdir($merge_conflicts_path . dirname($file_path)); file_put_contents($merge_conflicts_path . $file_path, implode("\n", $diff->merged_output())); } if ($diff->merged_output() !== $file_contents[1]) { $this->cache->put('_bbcore_updater_' . md5($file_path), implode("\n", $diff->merged_output())); $updater_config['merge_calculated'][] = $file_path; } unset($file_contents); unset($diff); } else { $this->cache->put('_bbcore_updater_' . md5($file_path), $new_file_contents); $updater_config['merge_calculated'][] = $file_path; } unset($updater_config['update_info']['edited'][$key]); break; } return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t8_check_additions.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t8_check_additions.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t8_check_additions.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t8_check_additions.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,21 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t8_check_additions
-{
-	protected $language;
-	protected $root_path;
-	public function __construct(\phpbb\language\language $language, $root_path)
-	{
-		$this->language = $language;
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path)
-	{
-		$updater_config['last_step'] = 't8_check_additions';
-		return $updater_config;
-	}
-}
+class t8_check_additions { protected $language; protected $root_path; public function __construct(\phpbb\language\language $language, $root_path) { $this->language = $language; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path) { $updater_config['last_step'] = 't8_check_additions'; return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/updater/task/t9_update_edits.php" "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t9_update_edits.php"
--- "[ORIGINAL]/sitesplat\\BBCore/updater/task/t9_update_edits.php"
+++ "[FORUM_EXT]/sitesplat\\BBCore/updater/task/t9_update_edits.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package sitesplat BBcore
@@ -7,33 +6,5 @@
 * @license Proprietary
 *
 */
-
 namespace sitesplat\BBCore\updater\task;
-
-class t9_update_edits
-{
-	protected $cache;
-	protected $root_path;
-	public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path)
-	{
-		$this->cache = $cache;
-		$this->root_path = $root_path;
-	}
-	public function run($style_name, $updater_config, $root_path, $fs)
-	{
-		$this->root_path = $root_path;
-		if (empty($updater_config['merge_calculated'])) {
-			$updater_config['last_step'] = 't9_update_edits';
-			return $updater_config;
-		}
-		$current_files_path = $this->root_path . 'styles/' . $style_name . '/';
-		foreach ($updater_config['merge_calculated'] as $key => $file_path) {
-			$cache_name = '_bbcore_updater_' . md5($file_path);
-			$fs->put($current_files_path . $file_path, $this->cache->get($cache_name), true);
-			$this->cache->destroy($cache_name);
-			unset($updater_config['merge_calculated'][$key]);
-			break;
-		}
-		return $updater_config;
-	}
-}
+class t9_update_edits { protected $cache; protected $root_path; public function __construct(\phpbb\cache\driver\driver_interface $cache, $root_path) { $this->cache = $cache; $this->root_path = $root_path; } public function run($style_name, $updater_config, $root_path, $fs) { $this->root_path = $root_path; if (empty($updater_config['merge_calculated'])) { $updater_config['last_step'] = 't9_update_edits'; return $updater_config; } $current_files_path = $this->root_path . 'styles/' . $style_name . '/'; foreach ($updater_config['merge_calculated'] as $key => $file_path) { $cache_name = '_bbcore_updater_' . md5($file_path); $fs->put($current_files_path . $file_path, $this->cache->get($cache_name), true); $this->cache->destroy($cache_name); unset($updater_config['merge_calculated'][$key]); break; } return $updater_config; } }
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/fonts/Thumbs.db" "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/fonts/Thumbs.db"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/fonts/Thumbs.db" and /dev/null differ
diff --git "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/Thumbs.db" "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/Thumbs.db"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/Thumbs.db" and /dev/null differ
diff --git "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/colorpicker/Thumbs.db" "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/colorpicker/Thumbs.db"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/img/colorpicker/Thumbs.db" and /dev/null differ
diff --git "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/jquery-file-tree/images/Thumbs.db" "[ORIGINAL]/sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/jquery-file-tree/images/Thumbs.db"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\BBCore/vendors/tinymce/plugins/bootstrap/jquery-file-tree/images/Thumbs.db" and /dev/null differ
```
