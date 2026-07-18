Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/acp/main_info.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/acp/main_info.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/acp/main_info.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/acp/main_info.php"
@@ -1,40 +1,29 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package Gallery - ACP CleanUp Extension
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\acpcleanup\acp;
 
-/**
- * ACP Module Info class
- */
 class main_info
 {
-	/**
-	 * Returns module information
-	 *
-	 * @return array Module information
-	 */
-	public function module(): array
+	function module()
 	{
-		return [
-				'filename' => '\phpbbgallery\acpcleanup\acp\main_module',
+		return array(
+			'filename'	=> 'main_module',
 			'title'		=> 'PHPBB_GALLERY',
 			'version'	=> '1.0.0',
-				'modes'    => [
-					'cleanup' => [
+			'modes'		=> array(
+				'cleanup'			=> array(
 					'title' => 'ACP_GALLERY_CLEANUP',
 					'auth' => 'acl_a_gallery_cleanup && ext_phpbbgallery/acpcleanup',
-						'cat'   => ['PHPBB_GALLERY'],
-					],
-				],
-		];
+					'cat' => array('PHPBB_GALLERY')
+				),
+			),
+		);
 	}
 }
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/acp/main_module.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/acp/main_module.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/acp/main_module.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/acp/main_module.php"
@@ -1,55 +1,38 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery - ACP CleanUp Extension
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\acpcleanup\acp;
 
 class main_module
 {
-	public string $u_action;
+	var $u_action;
 
-	public function main(string $id, string $mode): void
+	function main($id, $mode)
 	{
-		global $auth, $cache, $config, $db, $template, $request, $user, $phpEx, $phpbb_root_path, $phpbb_ext_gallery;
+		global $auth, $cache, $config, $db, $template, $user, $phpEx, $phpbb_root_path, $phpbb_ext_gallery;
 
 		$user->add_lang_ext('phpbbgallery/core', array('gallery_acp', 'gallery'));
+		//$user->add_lang_ext('phpbbgallery/acpcleanup', 'cleanup');
 		$this->tpl_name = 'gallery_cleanup';
-
 		add_form_key('acp_gallery');
 
-		$submit = $request->is_set_post('submit');
-
-		if ($submit && !check_form_key('acp_gallery'))
-		{
-			trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
-		}
-
 		$this->page_title = $user->lang['ACP_GALLERY_CLEANUP'];
-		$this->cleanup($submit);
+		$this->cleanup();
 	}
 
-	/**
-	 * Cleanup gallery files and database entries
-	 *
-	 * @param array $missing_entries Files to clean
-	 * @param bool $move_to_import Whether to move files to import dir
-	 * @return array Messages about cleanup results
-	 * @throws \RuntimeException On file operation errors
-	 */
-	public function cleanup(bool $submit = false): void
+	function cleanup()
 	{
 		global $auth, $cache, $db, $template, $user, $phpbb_ext_gallery, $table_prefix, $phpbb_container, $request;
 
-		$delete = $request->is_set_post('delete');
-		$prune = $request->is_set_post('prune');
+		$delete = (isset($_POST['delete'])) ? true : false;
+		$prune = (isset($_POST['prune'])) ? true : false;
+		$submit = (isset($_POST['submit'])) ? true : false;
 
 		$missing_sources = $request->variable('source', array(0));
 		$missing_entries = $request->variable('entry', array(''), true);
@@ -178,9 +161,9 @@ class main_module
 			{
 				if ($acp_import_installed && $move_to_import)
 				{
-					foreach ($missing_entries as $entry)
+					foreach ($missing_entries as $entrie)
 					{
-						copy($gallery_url->path('upload') . '/' . $entry, $gallery_url->path('import') . '/' . $entry);
+						copy($gallery_url->path('upload') . '/' . $entrie, $gallery_url->path('import') . '/' . $entrie);
 					}
 				}
 				$message[] = $core_cleanup->delete_files($missing_entries);
@@ -218,7 +201,7 @@ class main_module
 			// Make sure the overall image & comment count is correct...
 			$sql = 'SELECT COUNT(image_id) AS num_images, SUM(image_comments) AS num_comments
 				FROM ' . $table_prefix . 'gallery_images
-				WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED;
+				WHERE image_status <> ' . \phpbbgallery\core\block::STATUS_UNAPPROVED;
 			$result = $db->sql_query($sql);
 			$row = $db->sql_fetchrow($result);
 			$db->sql_freeresult($result);
@@ -433,7 +416,7 @@ class main_module
 				),
 			),
 
-			'WHERE'			=> 'a.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . ' AND a.parent_id = 0',
+			'WHERE'			=> 'a.album_user_id <> ' . \phpbbgallery\core\block::PUBLIC_ALBUM . ' AND a.parent_id = 0',
 		);
 		$sql = $db->sql_build_query('SELECT', $sql_array);
 		$result = $db->sql_query($sql);
@@ -456,7 +439,7 @@ class main_module
 
 		$sql = 'SELECT ga.album_user_id, ga.album_images_real
 			FROM ' . $table_prefix . 'gallery_albums ga
-			WHERE ga.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . '
+			WHERE ga.album_user_id <> ' . \phpbbgallery\core\block::PUBLIC_ALBUM . '
 				AND ga.parent_id <> 0';
 		$result = $db->sql_query($sql);
 		while ($row = $db->sql_fetchrow($result))
@@ -496,7 +479,7 @@ class main_module
 			'CHECK_ENTRY'			=> $this->u_action . '&amp;check_mode=entry',
 
 			'U_FIND_USERNAME'		=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=prune_usernames'),
-			'S_SELECT_ALBUM'		=> $gallery_album->get_albumbox(false, '', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
+			'S_SELECT_ALBUM'		=> $gallery_album->get_albumbox(false, '', false, false, false, \phpbbgallery\core\block::PUBLIC_ALBUM, \phpbbgallery\core\block::TYPE_UPLOAD),
 
 			'S_FOUNDER'				=> ($user->data['user_type'] == USER_FOUNDER) ? true : false,
 		));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html" "[FORUM_EXT]/phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html"
@@ -147,10 +147,11 @@
 
 		<p class="submit-buttons">
 			<input class="button1" type="submit" name="prune" value="{L_PRUNE}" />
-			{S_FORM_TOKEN}
 		</p>
 	</fieldset>
 	<!-- ENDIF -->
+	<p>{S_FORM_TOKEN}</p>
 </form>
 
 <!-- INCLUDE overall_footer.html -->
+ 
\ No newline at end of file
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/cleanup.php"
@@ -1,13 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007 nickvergessen, 2014 satanasov, 2025 Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery
+* @version $Id$
+* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
+* @license http://opensource.org/licenses/gpl-license.php GNU Public License
+*
 */
 
 namespace phpbbgallery\acpcleanup;
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/composer.json" "[FORUM_EXT]/phpbbgallery\\acpcleanup/composer.json"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/composer.json"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/composer.json"
@@ -26,17 +26,17 @@
 		}
 	],
 	"require": {
-		"php": ">=7.1"
+		"php": ">=5.3"
 	},
 	"extra": {
 		"display-name": "phpBB Gallery Add-on: ACP Cleanup",
 		"soft-require": {
-			"phpbb/phpbb": ">=3.2.0,<4.0.0@dev"
+			"phpbb/phpbb": ">=3.1.0-RC2,<3.3.0@dev"
 		}
 	},
 	"version-check": {
 		"host": "raw.githubusercontent.com",
-		"directory": "/satanasov/phpbbgallery/master/",
+		"directory": "/satanasov/phpbbgallery/master",
 		"filename": "gallery-cleanup.json",
 		"ssl": true
 	}
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/config/services.yml" "[FORUM_EXT]/phpbbgallery\\acpcleanup/config/services.yml"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/config/services.yml"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/config/services.yml"
@@ -1,6 +1,6 @@
 parameters:
-    phpbbgallery.tables.gallery_albums: '%core.table_prefix%gallery_albums'
-    phpbbgallery.tables.gallery_images: '%core.table_prefix%gallery_images'
+    tables.phpbbgallery.albums: '%core.table_prefix%gallery_albums'
+    tables.phpbbgallery.images: '%core.table_prefix%gallery_images'
 
 services:
     phpbbgallery.acpcleanup.cleanup:
@@ -16,5 +16,5 @@ services:
             - '@phpbbgallery.core.config'
             - '@phpbbgallery.core.log'
             - '@phpbbgallery.core.moderate'
-            - '%phpbbgallery.tables.gallery_albums%'
-            - '%phpbbgallery.tables.gallery_images%'
\ No newline at end of file
+            - '%tables.phpbbgallery.albums%'
+            - '%tables.phpbbgallery.images%'
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbbgallery\\acpcleanup/diff_full.tmp" "[FORUM_EXT]/phpbbgallery\\acpcleanup/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/diff_full.tmp"
@@ -0,0 +1,739 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/acp/main_info.php"
+index 54427c17a..8a9a7f24d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/acp/main_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/acp/main_info.php"
+@@ -1,40 +1,29 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package Gallery - ACP CleanUp Extension
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\acpcleanup\acp;
+ 
+-/**
+- * ACP Module Info class
+- */
+ class main_info
+ {
+-	/**
+-	 * Returns module information
+-	 *
+-	 * @return array Module information
+-	 */
+-	public function module(): array
++	function module()
+ 	{
+-		return [
+-				'filename' => '\phpbbgallery\acpcleanup\acp\main_module',
+-				'title'    => 'PHPBB_GALLERY',
+-				'version' => '1.0.0',
+-				'modes'    => [
+-					'cleanup' => [
+-						'title' => 'ACP_GALLERY_CLEANUP',
+-						'auth'  => 'acl_a_gallery_cleanup && ext_phpbbgallery/acpcleanup',
+-						'cat'   => ['PHPBB_GALLERY'],
+-					],
+-				],
+-		];
++		return array(
++			'filename'	=> 'main_module',
++			'title'		=> 'PHPBB_GALLERY',
++			'version'	=> '1.0.0',
++			'modes'		=> array(
++				'cleanup'			=> array(
++					'title' => 'ACP_GALLERY_CLEANUP',
++					'auth' => 'acl_a_gallery_cleanup && ext_phpbbgallery/acpcleanup',
++					'cat' => array('PHPBB_GALLERY')
++				),
++			),
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/acp/main_module.php"
+index c60f95ecb..816463765 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/acp/main_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/acp/main_module.php"
+@@ -1,55 +1,38 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery - ACP CleanUp Extension
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\acpcleanup\acp;
+ 
+ class main_module
+ {
+-	public string $u_action;
++	var $u_action;
+ 
+-	public function main(string $id, string $mode): void
++	function main($id, $mode)
+ 	{
+-		global $auth, $cache, $config, $db, $template, $request, $user, $phpEx, $phpbb_root_path, $phpbb_ext_gallery;
++		global $auth, $cache, $config, $db, $template, $user, $phpEx, $phpbb_root_path, $phpbb_ext_gallery;
+ 
+ 		$user->add_lang_ext('phpbbgallery/core', array('gallery_acp', 'gallery'));
++		//$user->add_lang_ext('phpbbgallery/acpcleanup', 'cleanup');
+ 		$this->tpl_name = 'gallery_cleanup';
+-
+ 		add_form_key('acp_gallery');
+ 
+-		$submit = $request->is_set_post('submit');
+-
+-		if ($submit && !check_form_key('acp_gallery'))
+-		{
+-			trigger_error($user->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+-		}
+-
+ 		$this->page_title = $user->lang['ACP_GALLERY_CLEANUP'];
+-		$this->cleanup($submit);
++		$this->cleanup();
+ 	}
+ 
+-	/**
+-	 * Cleanup gallery files and database entries
+-	 *
+-	 * @param array $missing_entries Files to clean
+-	 * @param bool $move_to_import Whether to move files to import dir
+-	 * @return array Messages about cleanup results
+-	 * @throws \RuntimeException On file operation errors
+-	 */
+-	public function cleanup(bool $submit = false): void
++	function cleanup()
+ 	{
+ 		global $auth, $cache, $db, $template, $user, $phpbb_ext_gallery, $table_prefix, $phpbb_container, $request;
+ 
+-		$delete = $request->is_set_post('delete');
+-		$prune = $request->is_set_post('prune');
++		$delete = (isset($_POST['delete'])) ? true : false;
++		$prune = (isset($_POST['prune'])) ? true : false;
++		$submit = (isset($_POST['submit'])) ? true : false;
+ 
+ 		$missing_sources = $request->variable('source', array(0));
+ 		$missing_entries = $request->variable('entry', array(''), true);
+@@ -178,9 +161,9 @@ class main_module
+ 			{
+ 				if ($acp_import_installed && $move_to_import)
+ 				{
+-					foreach ($missing_entries as $entry)
++					foreach ($missing_entries as $entrie)
+ 					{
+-						copy($gallery_url->path('upload') . '/' . $entry, $gallery_url->path('import') . '/' . $entry);
++						copy($gallery_url->path('upload') . '/' . $entrie, $gallery_url->path('import') . '/' . $entrie);
+ 					}
+ 				}
+ 				$message[] = $core_cleanup->delete_files($missing_entries);
+@@ -218,7 +201,7 @@ class main_module
+ 			// Make sure the overall image & comment count is correct...
+ 			$sql = 'SELECT COUNT(image_id) AS num_images, SUM(image_comments) AS num_comments
+ 				FROM ' . $table_prefix . 'gallery_images
+-				WHERE image_status <> ' . (int) \phpbbgallery\core\block::STATUS_UNAPPROVED;
++				WHERE image_status <> ' . \phpbbgallery\core\block::STATUS_UNAPPROVED;
+ 			$result = $db->sql_query($sql);
+ 			$row = $db->sql_fetchrow($result);
+ 			$db->sql_freeresult($result);
+@@ -433,7 +416,7 @@ class main_module
+ 				),
+ 			),
+ 
+-			'WHERE'			=> 'a.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . ' AND a.parent_id = 0',
++			'WHERE'			=> 'a.album_user_id <> ' . \phpbbgallery\core\block::PUBLIC_ALBUM . ' AND a.parent_id = 0',
+ 		);
+ 		$sql = $db->sql_build_query('SELECT', $sql_array);
+ 		$result = $db->sql_query($sql);
+@@ -456,7 +439,7 @@ class main_module
+ 
+ 		$sql = 'SELECT ga.album_user_id, ga.album_images_real
+ 			FROM ' . $table_prefix . 'gallery_albums ga
+-			WHERE ga.album_user_id <> ' . (int) \phpbbgallery\core\block::PUBLIC_ALBUM . '
++			WHERE ga.album_user_id <> ' . \phpbbgallery\core\block::PUBLIC_ALBUM . '
+ 				AND ga.parent_id <> 0';
+ 		$result = $db->sql_query($sql);
+ 		while ($row = $db->sql_fetchrow($result))
+@@ -496,7 +479,7 @@ class main_module
+ 			'CHECK_ENTRY'			=> $this->u_action . '&amp;check_mode=entry',
+ 
+ 			'U_FIND_USERNAME'		=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=prune_usernames'),
+-			'S_SELECT_ALBUM'		=> $gallery_album->get_albumbox(false, '', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
++			'S_SELECT_ALBUM'		=> $gallery_album->get_albumbox(false, '', false, false, false, \phpbbgallery\core\block::PUBLIC_ALBUM, \phpbbgallery\core\block::TYPE_UPLOAD),
+ 
+ 			'S_FOUNDER'				=> ($user->data['user_type'] == USER_FOUNDER) ? true : false,
+ 		));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html"
+index a9f43f608..0f3a52507 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/adm/style/gallery_cleanup.html"
+@@ -147,10 +147,11 @@
+ 
+ 		<p class="submit-buttons">
+ 			<input class="button1" type="submit" name="prune" value="{L_PRUNE}" />
+-			{S_FORM_TOKEN}
+ 		</p>
+ 	</fieldset>
+ 	<!-- ENDIF -->
++	<p>{S_FORM_TOKEN}</p>
+ </form>
+ 
+ <!-- INCLUDE overall_footer.html -->
++ 
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/cleanup.php"
+index e87934cef..9f062d702 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/cleanup.php"
+@@ -1,14 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007 nickvergessen, 2014 satanasov, 2025 Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery
++* @version $Id$
++* @copyright (c) 2007 nickvergessen nickvergessen@gmx.de http://www.flying-bits.org
++* @license http://opensource.org/licenses/gpl-license.php GNU Public License
++*
++*/
+ 
+ namespace phpbbgallery\acpcleanup;
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/composer.json"
+index 70589f649..1681fd05b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/composer.json"
+@@ -26,17 +26,17 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=7.1"
++		"php": ">=5.3"
+ 	},
+ 	"extra": {
+ 		"display-name": "phpBB Gallery Add-on: ACP Cleanup",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.2.0,<4.0.0@dev"
++			"phpbb/phpbb": ">=3.1.0-RC2,<3.3.0@dev"
+ 		}
+ 	},
+ 	"version-check": {
+ 		"host": "raw.githubusercontent.com",
+-		"directory": "/satanasov/phpbbgallery/master/",
++		"directory": "/satanasov/phpbbgallery/master",
+ 		"filename": "gallery-cleanup.json",
+ 		"ssl": true
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/config/services.yml"
+index f2c0d6f82..0ef56a9a1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/config/services.yml"
+@@ -1,6 +1,6 @@
+ parameters:
+-    phpbbgallery.tables.gallery_albums: '%core.table_prefix%gallery_albums'
+-    phpbbgallery.tables.gallery_images: '%core.table_prefix%gallery_images'
++    tables.phpbbgallery.albums: '%core.table_prefix%gallery_albums'
++    tables.phpbbgallery.images: '%core.table_prefix%gallery_images'
+ 
+ services:
+     phpbbgallery.acpcleanup.cleanup:
+@@ -16,5 +16,5 @@ services:
+             - '@phpbbgallery.core.config'
+             - '@phpbbgallery.core.log'
+             - '@phpbbgallery.core.moderate'
+-            - '%phpbbgallery.tables.gallery_albums%'
+-            - '%phpbbgallery.tables.gallery_images%'
+\ No newline at end of file
++            - '%tables.phpbbgallery.albums%'
++            - '%tables.phpbbgallery.images%'
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/bg/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/diff_full.tmp"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/bg/index.htm"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/diff_full.tmp"
+index e69de29bb..6c06fe49f 100644
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/ext.php"
+index ade3dfa8f..e655f4dac 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/ext.php"
+@@ -1,66 +1,11 @@
+ <?php
+-/**
+- * phpBB Gallery - ACP CleanUp Extension
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    Leinad4Mind
+- * @copyright 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++
++// this file is not really needed, when empty it can be ommitted
++// however you can override the default methods and add custom
++// installation logic
+ 
+ namespace phpbbgallery\acpcleanup;
+ 
+ class ext extends \phpbb\extension\base
+ {
+-	/**
+-	 * Check whether or not the extension can be enabled.
+-	 * Checks dependencies and requirements.
+-	 *
+-	 * @return bool
+-	 */
+-	public function is_enableable()
+-	{
+-		$manager = $this->container->get('ext.manager');
+-		$user = $this->container->get('user');
+-
+-		$core_ext = 'phpbbgallery/core';
+-
+-		// Check if core is installed (enabled or disabled)
+-		$is_enabled = $manager->is_enabled($core_ext);
+-		$is_disabled = $manager->is_disabled($core_ext);
+-
+-		if (!$is_enabled && !$is_disabled)
+-		{
+-			// Core not installed at all
+-			$user->add_lang_ext('phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup');
+-			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
+-			return false;
+-		}
+-
+-		if ($is_disabled)
+-		{
+-			// Core installed but disabled — enable it automatically
+-			$manager->enable($core_ext);
+-		}
+-
+-		// If here, core is either enabled or just enabled now
+-		return true;
+-	}
+-
+-	/**
+-	 * Perform additional tasks on extension enable
+-	 *
+-	 * @param mixed $old_state State returned by previous call of this method
+-	 * @return mixed Returns false after last step, otherwise temporary state
+-	 */
+-	public function enable_step($old_state)
+-	{
+-		if (empty($old_state))
+-		{
+-			$this->container->get('user')->add_lang_ext('phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup');
+-			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
+-		}
+-
+-		return parent::enable_step($old_state);
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php"
+index 2618cc0c3..b14dc8848 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php"
+@@ -1,15 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension [Bulgarian Translation]
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator Lucifer <https://www.anavaro.com>
+- */
++*
++* @package Gallery - ACP CleanUp Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ /**
+ * DO NOT CHANGE
+@@ -21,10 +17,10 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACP_GALLERY_CLEANUP'			=> 'Почистване на галерия',
+ 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Тук можете да изтриете малко останки.',
+ 
+@@ -78,7 +74,4 @@ $lang = array_merge($lang, [
+ 	'MOVE_TO_USER'		=> 'Премести при потребител',
+ 	'MOVE_TO_USER_EXP'	=> 'Изображенията и коментарите ще бъдат преместеи като такива на посочения потребител. Ако не посочите потребител - Гост е зададен по-подразбиране',
+ 	'CLEAN_USER_NOT_FOUND'	=> 'Желаният от вас потребител не е открит!',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/de/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/de/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php"
+index 09524687d..db903f2ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension [German Translation]
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator franki <https://dieahnen.de/ahnenforum>
+- */
++*
++* @package phpBB Gallery - ACP CleanUp Extension [German]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++* German translation by franki (http://dieahnen.de/ahnenforum/)
++*/
+ 
+ /**
+ * DO NOT CHANGE
+@@ -21,10 +18,10 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACP_GALLERY_CLEANUP'			=> 'Galerie bereinigen',
+ 
+ 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Hier kannst Du einige Reste löschen.',
+@@ -79,7 +76,4 @@ $lang = array_merge($lang, [
+ 	'MOVE_TO_USER'				=> 'Wechseln zu Benutzer',
+ 	'MOVE_TO_USER_EXP'			=> 'Bilder und Kommentare werden als diejenigen des Benutzers verschoben werden, die Du definiert hast. Wenn Keine ausgewählt wird - wird Gast verwendet.',
+ 	'CLEAN_USER_NOT_FOUND'		=> 'Der von Ihnen ausgewählte Benutzer existiert nicht!',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/en/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/en/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php"
+index 0c0867089..6492fa3bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php"
+@@ -1,14 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension [German Translation]
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package Gallery - ACP CleanUp Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ /**
+ * DO NOT CHANGE
+@@ -20,10 +17,10 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACP_GALLERY_CLEANUP'				=> 'Cleanup gallery',
+ 
+ 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Here you can delete some remains.',
+@@ -78,7 +75,4 @@ $lang = array_merge($lang, [
+ 	'MOVE_TO_USER'		=> 'Move to user',
+ 	'MOVE_TO_USER_EXP'	=> 'Images and comments will be moved as those of user you have defined. If none is selected - Anonymous will be used.',
+ 	'CLEAN_USER_NOT_FOUND'	=> 'The user you selected does not exists!',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/fr/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/fr/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php"
+index 4573f30b5..43d1e1db4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension [French Translation]
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
+- */
++*
++* @package Gallery - ACP CleanUp Extension [French]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++* @translator fr (c) pokyto aka le.poke http://www.lestontonsfraggers.com inspired by darky - http://www.foruminfopc.fr/ and Team http://www.phpbb-fr.com/
++*
++*/
+ 
+ /**
+ * DO NOT CHANGE
+@@ -21,10 +18,10 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACP_GALLERY_CLEANUP'				=> 'Nettoyage de la galerie',
+ 
+ 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Ici vous pouvez nettoyer la Galerie.',
+@@ -37,7 +34,7 @@ $lang = array_merge($lang, [
+ 	'CLEAN_GALLERY_ABORT'			=> 'Nettoyage interrompu!',
+ 	'CLEAN_NO_ACTION'				=> 'Aucune action terminée. Quelque chose a échoué!',
+ 	'CLEAN_PERSONALS_DONE'			=> 'Albums personnels sans propriétaire valide supprimés.',
+-	'CLEAN_PERSONALS_BAD_DONE'		=> 'Albums personnels des utilisateurs sélectionnés effacés.',
++	'CLEAN_PERSONALS_BAD_DONE'		=> 'Albums personnels des utilisateurs séléctionnés effacés.',
+ 	'CLEAN_PRUNE_DONE'				=> 'Images délestées avec succès.',
+ 	'CLEAN_PRUNE_NO_PATTERN'		=> 'Aucun critère de recherche.',
+ 	'CLEAN_SOURCES_DONE'			=> 'Images sans fichier supprimées.',
+@@ -79,7 +76,4 @@ $lang = array_merge($lang, [
+ 	'MOVE_TO_USER'		=> 'Attribuer à l’utilisateur',
+ 	'MOVE_TO_USER_EXP'	=> 'Les images et les commentaires seront attribués à l’utilisateur que vous avez défini. Si aucun n’est sélectionné - “Anonyme“ sera utilisé.',
+ 	'CLEAN_USER_NOT_FOUND'	=> 'L’utilisateur sélectionné n’existe pas!',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/it/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/it/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php"
+index a392dad2f..3ad5024d6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php"
+@@ -1,15 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension [Italian Translation]
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator
+- */
++*
++* @package phpBB Gallery - ACP CleanUp Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ /**
+ * DO NOT CHANGE
+@@ -21,10 +17,10 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACP_GALLERY_CLEANUP'				=> 'Pulisci galleria',
+ 
+ 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Puoi cancellare alcuni rimasugli, da qui.',
+@@ -79,7 +75,4 @@ $lang = array_merge($lang, [
+ 	'MOVE_TO_USER'		=> 'Sposta all\'utente',
+ 	'MOVE_TO_USER_EXP'	=> 'Immagini e commenti verranno spostati come fossero dell\'utente che hai definito. Se non ne vengono selezionati verra\' usato l\'utente anonimo.',
+ 	'CLEAN_USER_NOT_FOUND'	=> 'L\'utente selezionato non esiste!',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'L\'estensione è stata abilitata con successo.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/ru/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/ru/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php"
+index 4c5800b43..033c16346 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension [Russian Translation]
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator Eduard Schlak <https://translations.schlak.info>
+- */
++*
++* @package Gallery - ACP CleanUp Extension [Russian]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++* Translation from Eduard Schlak (http://translations.schlak.info/)
++*/
+ 
+ /**
+ * DO NOT CHANGE
+@@ -21,10 +18,10 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACP_GALLERY_CLEANUP'			=> 'Очистить галерею',
+ 
+ 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Здесь вы можете удалить некоторые остатки.',
+@@ -79,7 +76,4 @@ $lang = array_merge($lang, [
+ 	'MOVE_TO_USER'		=> 'Move to user',
+ 	'MOVE_TO_USER_EXP'	=> 'Images and comments will be moved as those of user you have defined. If none is selected - Anonymous will be used.',
+ 	'CLEAN_USER_NOT_FOUND'	=> 'The user you selected does not exists!',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',
+-]);
++	));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/migrations/m1_init.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/migrations/m1_init.php"
+index 17b741e76..6910ebfae 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/migrations/m1_init.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/migrations/m1_init.php"
+@@ -1,40 +1,35 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP CleanUp Extension
+- *
+- * @package   phpbbgallery/acpcleanup
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery ACP Cleanup
++* @copyright (c) 2014 satanasov
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\acpcleanup\migrations;
+ 
+-use phpbb\db\migration\migration;
+-
+-class m1_init extends migration
++class m1_init extends \phpbb\db\migration\migration
+ {
+ 	static public function depends_on()
+ 	{
+-		return ['\phpbbgallery\core\migrations\release_1_2_0'];
++		return array('\phpbbgallery\core\migrations\release_1_2_0');
+ 	}
+ 
+ 	public function update_data()
+ 	{
+-		return [
+-				['permission.add', ['a_gallery_cleanup', true, 'a_board']],
+-				['module.add', [
+-					'acp',
+-					'PHPBB_GALLERY',
+-					[
+-						'module_basename' => '\phpbbgallery\acpcleanup\acp\main_module',
+-						'module_langname' => 'ACP_GALLERY_CLEANUP',
+-						'module_mode'     => 'cleanup',
+-						'module_auth'     => 'ext_phpbbgallery/acpcleanup && acl_a_gallery_cleanup',
+-					]
+-				]],
+-		];
++		return array(
++			array('permission.add', array('a_gallery_cleanup', true, 'a_board')),
++			array('module.add', array(
++				'acp',
++				'PHPBB_GALLERY',
++				array(
++					'module_basename'	=> '\phpbbgallery\acpcleanup\acp\main_module',
++					'module_langname'	=> 'ACP_GALLERY_CLEANUP',
++					'module_mode'		=> 'cleanup',
++					'module_auth'		=> 'ext_phpbbgallery/acpcleanup && acl_a_gallery_cleanup',
++				)
++			)),
++		);
+ 	}
+ }
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/bg/index.htm" "[FORUM_EXT]/phpbbgallery\\acpcleanup/diff_nospace.tmp"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpcleanup/language/bg/index.htm"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpcleanup/diff_nospace.tmp"
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/ext.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/ext.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/ext.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/ext.php"
@@ -1,66 +1,11 @@
 <?php
-/**
- * phpBB Gallery - ACP CleanUp Extension
- *
- * @package   phpbbgallery/acpcleanup
- * @author    Leinad4Mind
- * @copyright 2018- Leinad4Mind
- * @license   GPL-2.0-only
- */
+
+// this file is not really needed, when empty it can be ommitted
+// however you can override the default methods and add custom
+// installation logic
 
 namespace phpbbgallery\acpcleanup;
 
 class ext extends \phpbb\extension\base
 {
-	/**
-	 * Check whether or not the extension can be enabled.
-	 * Checks dependencies and requirements.
-	 *
-	 * @return bool
-	 */
-	public function is_enableable()
-	{
-		$manager = $this->container->get('ext.manager');
-		$user = $this->container->get('user');
-
-		$core_ext = 'phpbbgallery/core';
-
-		// Check if core is installed (enabled or disabled)
-		$is_enabled = $manager->is_enabled($core_ext);
-		$is_disabled = $manager->is_disabled($core_ext);
-
-		if (!$is_enabled && !$is_disabled)
-		{
-			// Core not installed at all
-			$user->add_lang_ext('phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup');
-			trigger_error($user->lang('GALLERY_CORE_NOT_FOUND'), E_USER_WARNING);
-			return false;
-		}
-
-		if ($is_disabled)
-		{
-			// Core installed but disabled — enable it automatically
-			$manager->enable($core_ext);
-		}
-
-		// If here, core is either enabled or just enabled now
-		return true;
-	}
-
-	/**
-	 * Perform additional tasks on extension enable
-	 *
-	 * @param mixed $old_state State returned by previous call of this method
-	 * @return mixed Returns false after last step, otherwise temporary state
-	 */
-	public function enable_step($old_state)
-	{
-		if (empty($old_state))
-		{
-			$this->container->get('user')->add_lang_ext('phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup');
-			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
-		}
-
-		return parent::enable_step($old_state);
-	}
 }
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/bg/info_acp_gallery_cleanup.php"
@@ -1,14 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension [Bulgarian Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator Lucifer <https://www.anavaro.com>
+* @package Gallery - ACP CleanUp Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 /**
@@ -21,10 +17,10 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACP_GALLERY_CLEANUP'			=> 'Почистване на галерия',
 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Тук можете да изтриете малко останки.',
 
@@ -78,7 +74,4 @@ $lang = array_merge($lang, [
 	'MOVE_TO_USER'		=> 'Премести при потребител',
 	'MOVE_TO_USER_EXP'	=> 'Изображенията и коментарите ще бъдат преместеи като такива на посочения потребител. Ако не посочите потребител - Гост е зададен по-подразбиране',
 	'CLEAN_USER_NOT_FOUND'	=> 'Желаният от вас потребител не е открит!',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/de/index.htm" "[ORIGINAL]/phpbbgallery\\acpcleanup/language/de/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/de/info_acp_gallery_cleanup.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension [German Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator franki <https://dieahnen.de/ahnenforum>
+* @package phpBB Gallery - ACP CleanUp Extension [German]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+* German translation by franki (http://dieahnen.de/ahnenforum/)
 */
 
 /**
@@ -21,10 +18,10 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACP_GALLERY_CLEANUP'			=> 'Galerie bereinigen',
 
 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Hier kannst Du einige Reste löschen.',
@@ -79,7 +76,4 @@ $lang = array_merge($lang, [
 	'MOVE_TO_USER'				=> 'Wechseln zu Benutzer',
 	'MOVE_TO_USER_EXP'			=> 'Bilder und Kommentare werden als diejenigen des Benutzers verschoben werden, die Du definiert hast. Wenn Keine ausgewählt wird - wird Gast verwendet.',
 	'CLEAN_USER_NOT_FOUND'		=> 'Der von Ihnen ausgewählte Benutzer existiert nicht!',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/en/index.htm" "[ORIGINAL]/phpbbgallery\\acpcleanup/language/en/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/en/info_acp_gallery_cleanup.php"
@@ -1,13 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension [German Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package Gallery - ACP CleanUp Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 /**
@@ -20,10 +17,10 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACP_GALLERY_CLEANUP'				=> 'Cleanup gallery',
 
 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Here you can delete some remains.',
@@ -78,7 +75,4 @@ $lang = array_merge($lang, [
 	'MOVE_TO_USER'		=> 'Move to user',
 	'MOVE_TO_USER_EXP'	=> 'Images and comments will be moved as those of user you have defined. If none is selected - Anonymous will be used.',
 	'CLEAN_USER_NOT_FOUND'	=> 'The user you selected does not exists!',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/fr/index.htm" "[ORIGINAL]/phpbbgallery\\acpcleanup/language/fr/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/fr/info_acp_gallery_cleanup.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension [French Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
+* @package Gallery - ACP CleanUp Extension [French]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+* @translator fr (c) pokyto aka le.poke http://www.lestontonsfraggers.com inspired by darky - http://www.foruminfopc.fr/ and Team http://www.phpbb-fr.com/
+*
 */
 
 /**
@@ -21,10 +18,10 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACP_GALLERY_CLEANUP'				=> 'Nettoyage de la galerie',
 
 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Ici vous pouvez nettoyer la Galerie.',
@@ -37,7 +34,7 @@ $lang = array_merge($lang, [
 	'CLEAN_GALLERY_ABORT'			=> 'Nettoyage interrompu!',
 	'CLEAN_NO_ACTION'				=> 'Aucune action terminée. Quelque chose a échoué!',
 	'CLEAN_PERSONALS_DONE'			=> 'Albums personnels sans propriétaire valide supprimés.',
-	'CLEAN_PERSONALS_BAD_DONE'		=> 'Albums personnels des utilisateurs sélectionnés effacés.',
+	'CLEAN_PERSONALS_BAD_DONE'		=> 'Albums personnels des utilisateurs séléctionnés effacés.',
 	'CLEAN_PRUNE_DONE'				=> 'Images délestées avec succès.',
 	'CLEAN_PRUNE_NO_PATTERN'		=> 'Aucun critère de recherche.',
 	'CLEAN_SOURCES_DONE'			=> 'Images sans fichier supprimées.',
@@ -79,7 +76,4 @@ $lang = array_merge($lang, [
 	'MOVE_TO_USER'		=> 'Attribuer à l’utilisateur',
 	'MOVE_TO_USER_EXP'	=> 'Les images et les commentaires seront attribués à l’utilisateur que vous avez défini. Si aucun n’est sélectionné - “Anonyme“ sera utilisé.',
 	'CLEAN_USER_NOT_FOUND'	=> 'L’utilisateur sélectionné n’existe pas!',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/it/index.htm" "[ORIGINAL]/phpbbgallery\\acpcleanup/language/it/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/it/info_acp_gallery_cleanup.php"
@@ -1,14 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension [Italian Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator
+* @package phpBB Gallery - ACP CleanUp Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 /**
@@ -21,10 +17,10 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACP_GALLERY_CLEANUP'				=> 'Pulisci galleria',
 
 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Puoi cancellare alcuni rimasugli, da qui.',
@@ -79,7 +75,4 @@ $lang = array_merge($lang, [
 	'MOVE_TO_USER'		=> 'Sposta all\'utente',
 	'MOVE_TO_USER_EXP'	=> 'Immagini e commenti verranno spostati come fossero dell\'utente che hai definito. Se non ne vengono selezionati verra\' usato l\'utente anonimo.',
 	'CLEAN_USER_NOT_FOUND'	=> 'L\'utente selezionato non esiste!',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'L\'estensione è stata abilitata con successo.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/ru/index.htm" "[ORIGINAL]/phpbbgallery\\acpcleanup/language/ru/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/language/ru/info_acp_gallery_cleanup.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension [Russian Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator Eduard Schlak <https://translations.schlak.info>
+* @package Gallery - ACP CleanUp Extension [Russian]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+* Translation from Eduard Schlak (http://translations.schlak.info/)
 */
 
 /**
@@ -21,10 +18,10 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACP_GALLERY_CLEANUP'			=> 'Очистить галерею',
 
 	'ACP_GALLERY_CLEANUP_EXPLAIN'	=> 'Здесь вы можете удалить некоторые остатки.',
@@ -79,7 +76,4 @@ $lang = array_merge($lang, [
 	'MOVE_TO_USER'		=> 'Move to user',
 	'MOVE_TO_USER_EXP'	=> 'Images and comments will be moved as those of user you have defined. If none is selected - Anonymous will be used.',
 	'CLEAN_USER_NOT_FOUND'	=> 'The user you selected does not exists!',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',
-]);
+	));
diff --git "[ORIGINAL]/phpbbgallery\\acpcleanup/migrations/m1_init.php" "[FORUM_EXT]/phpbbgallery\\acpcleanup/migrations/m1_init.php"
--- "[ORIGINAL]/phpbbgallery\\acpcleanup/migrations/m1_init.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpcleanup/migrations/m1_init.php"
@@ -1,40 +1,35 @@
 <?php
 /**
- * phpBB Gallery - ACP CleanUp Extension
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery ACP Cleanup
+* @copyright (c) 2014 satanasov
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\acpcleanup\migrations;
 
-use phpbb\db\migration\migration;
-
-class m1_init extends migration
+class m1_init extends \phpbb\db\migration\migration
 {
 	static public function depends_on()
 	{
-		return ['\phpbbgallery\core\migrations\release_1_2_0'];
+		return array('\phpbbgallery\core\migrations\release_1_2_0');
 	}
 
 	public function update_data()
 	{
-		return [
-				['permission.add', ['a_gallery_cleanup', true, 'a_board']],
-				['module.add', [
+		return array(
+			array('permission.add', array('a_gallery_cleanup', true, 'a_board')),
+			array('module.add', array(
 				'acp',
 				'PHPBB_GALLERY',
-					[
+				array(
 					'module_basename'	=> '\phpbbgallery\acpcleanup\acp\main_module',
 					'module_langname'	=> 'ACP_GALLERY_CLEANUP',
 					'module_mode'		=> 'cleanup',
 					'module_auth'		=> 'ext_phpbbgallery/acpcleanup && acl_a_gallery_cleanup',
-					]
-				]],
-		];
+				)
+			)),
+		);
 	}
 }
```
