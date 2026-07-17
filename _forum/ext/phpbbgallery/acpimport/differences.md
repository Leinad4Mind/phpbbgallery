Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/acp/main_info.php" "[FORUM_EXT]/phpbbgallery\\acpimport/acp/main_info.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/acp/main_info.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/acp/main_info.php"
@@ -1,40 +1,29 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package Gallery - ACP Import Extension
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\acpimport\acp;
 
-/**
- * ACP Module Info class for Gallery Import
- */
 class main_info
 {
-	/**
-	 * Returns module information
-	 *
-	 * @return array Module configuration
-	 */
-	public function module(): array
+	function module()
 	{
-		return [
-				'filename' => '\phpbbgallery\acpimport\acp\main_module',
+		return array(
+			'filename'	=> 'main_module',
 			'title'		=> 'PHPBB_GALLERY',
 			'version'	=> '1.0.0',
-				'modes'    => [
-					'import_images' => [
+			'modes'		=> array(
+				'import_images'		=> array(
 					'title' => 'ACP_IMPORT_ALBUMS',
-						'auth'  => 'ext_phpbbgallery/acpimport && acl_a_gallery_import',
-						'cat'   => ['PHPBB_GALLERY'],
-					],
-				],
-		];
+					'auth' => 'acl_a_gallery_import && ext_phpbbgallery/acpimport',
+					'cat' => array('PHPBB_GALLERY')
+				),
+			),
+		);
 	}
 }
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/acp/main_module.php" "[FORUM_EXT]/phpbbgallery\\acpimport/acp/main_module.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/acp/main_module.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/acp/main_module.php"
@@ -1,13 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery - ACP Import Extension
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\acpimport\acp;
@@ -71,7 +68,7 @@ class main_module
 					$filetype = getimagesize($image_src_full);
 					$filetype_ext = '';
 
-					$error_occurred = false;
+					$error_occured = false;
 					switch ($filetype['mime'])
 					{
 						case 'image/jpeg':
@@ -82,7 +79,7 @@ class main_module
 							if ((substr(strtolower($image_src), -4) != '.jpg') && (substr(strtolower($image_src), -5) != '.jpeg'))
 							{
 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
-								$error_occurred = true;
+								$error_occured = true;
 							}
 						break;
 
@@ -93,7 +90,7 @@ class main_module
 							if (substr(strtolower($image_src), -4) != '.png')
 							{
 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
-								$error_occurred = true;
+								$error_occured = true;
 							}
 						break;
 
@@ -104,7 +101,7 @@ class main_module
 							if (substr(strtolower($image_src), -4) != '.gif')
 							{
 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
-								$error_occurred = true;
+								$error_occured = true;
 							}
 						break;
 
@@ -114,29 +111,29 @@ class main_module
 							if (substr(strtolower($image_src), -5) != '.webp')
 							{
 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
-								$error_occurred = true;
+								$error_occured = true;
 							}
 						break;
 
 						default:
 							$this->log_import_error($import_schema, $user->lang['NOT_ALLOWED_FILE_TYPE']);
-							$error_occurred = true;
+							$error_occured = true;
 						break;
 					}
 					$image_filename = md5(unique_id()) . $filetype_ext;
 					$file_link = $gallery_url->path('upload') . $image_filename;
 
-					if (!$error_occurred || !@move_uploaded_file($image_src_full, $file_link))
+					if (!$error_occured || !@move_uploaded_file($image_src_full, $file_link))
 					{
 						if (!@copy($image_src_full, $file_link))
 						{
 							$user->add_lang('posting');
 							$this->log_import_error($import_schema, sprintf($user->lang['GENERAL_UPLOAD_ERROR'], $file_link));
-							$error_occurred = true;
+							$error_occured = true;
 						}
 					}
 
-					if (!$error_occurred)
+					if (!$error_occured)
 					{
 						@chmod($file_link, 0777);
 
@@ -152,7 +149,7 @@ class main_module
 							'image_user_ip'			=> $user->ip,
 							'image_time'			=> $start_time + $done_images,
 							'image_album_id'		=> $album_id,
-							'image_status'			=> (int) \phpbbgallery\core\block::STATUS_APPROVED,
+							'image_status'			=> \phpbbgallery\core\block::STATUS_APPROVED,
 							//'image_exif_data'		=> '',
 						);
 
@@ -160,7 +157,7 @@ class main_module
 						$image_tools->set_image_options($gallery_config->get('max_filesize'), $gallery_config->get('max_height'), $gallery_config->get('max_width'));
 						$image_tools->set_image_data($file_link);
 
-						$additional_sql_data = [];
+						$additional_sql_data = array();
 
 						/**
 						* Event to trigger before mass update
@@ -398,7 +395,7 @@ class main_module
 			'ACP_GALLERY_TITLE_EXPLAIN'		=> $user->lang['ACP_IMPORT_ALBUMS_EXPLAIN'],
 			'L_IMPORT_DIR_EMPTY'			=> sprintf($user->lang['IMPORT_DIR_EMPTY'], $gallery_url->path('import')),
 			'S_ALBUM_IMPORT_ACTION'			=> $this->u_action,
-			'S_SELECT_IMPORT' 				=> $gallery_album->get_albumbox(false, 'album_id', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
+			'S_SELECT_IMPORT' 				=> $gallery_album->get_albumbox(false, 'album_id', false, false, false, \phpbbgallery\core\block::PUBLIC_ALBUM, \phpbbgallery\core\block::TYPE_UPLOAD),
 			'U_FIND_USERNAME'				=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=username&amp;select_single=true'),
 		));
 	}
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/adm/style/gallery_acpimport.html" "[FORUM_EXT]/phpbbgallery\\acpimport/adm/style/gallery_acpimport.html"
--- "[ORIGINAL]/phpbbgallery\\acpimport/adm/style/gallery_acpimport.html"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/adm/style/gallery_acpimport.html"
@@ -47,4 +47,15 @@
 	</fieldset>
 </form>
 
+<!--
+	I request you retain the full copyright notice below including the link to www.flying-bits.org.
+	This not only gives respect to the large amount of time given freely by the developer
+	but also helps build interest, traffic and use of phpBB Gallery. If you (honestly) cannot retain
+	the full copyright I ask you at least leave in place the "Powered by phpBB Gallery" line, with
+	"phpBB Gallery" linked to www.flying-bits.org. If you refuse to include even this then support on my
+	forums may be affected.
+
+	phpBB Gallery, nickvergessen : 2009
+	Powered by phpBB Gallery (http://www.flying-bits.org/) &copy; 2007, 2009 nickvergessen (http://www.flying-bits.org/)
+//-->
 <!-- INCLUDE overall_footer.html -->
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/composer.json" "[FORUM_EXT]/phpbbgallery\\acpimport/composer.json"
--- "[ORIGINAL]/phpbbgallery\\acpimport/composer.json"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/composer.json"
@@ -26,17 +26,17 @@
 		}
 	],
 	"require": {
-		"php": ">=7.1"
+		"php": ">=5.3"
 	},
 	"extra": {
 		"display-name": "phpBB Gallery Add-on: ACP Import",
 		"soft-require": {
-			"phpbb/phpbb": ">=3.2.0,<4.0.0@dev"
+			"phpbb/phpbb": ">=3.1.0-RC2,<3.3.0@dev"
 		}
 	},
 	"version-check": {
 		"host": "raw.githubusercontent.com",
-		"directory": "/satanasov/phpbbgallery/master/",
+		"directory": "/satanasov/phpbbgallery/master",
 		"filename": "gallery-import.json",
 		"ssl": true
 	}
diff --git "[FORUM_EXT]/phpbbgallery\\acpimport/diff_full.tmp" "[FORUM_EXT]/phpbbgallery\\acpimport/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/diff_full.tmp"
@@ -0,0 +1,827 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/acp/main_info.php"
+index 28899f156..d600f7e78 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/acp/main_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/acp/main_info.php"
+@@ -1,40 +1,29 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package Gallery - ACP Import Extension
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\acpimport\acp;
+ 
+-/**
+- * ACP Module Info class for Gallery Import
+- */
+ class main_info
+ {
+-	/**
+-	 * Returns module information
+-	 *
+-	 * @return array Module configuration
+-	 */
+-	public function module(): array
++	function module()
+ 	{
+-		return [
+-				'filename' => '\phpbbgallery\acpimport\acp\main_module',
+-				'title'    => 'PHPBB_GALLERY',
+-				'version' => '1.0.0',
+-				'modes'    => [
+-					'import_images' => [
+-						'title' => 'ACP_IMPORT_ALBUMS',
+-						'auth'  => 'ext_phpbbgallery/acpimport && acl_a_gallery_import',
+-						'cat'   => ['PHPBB_GALLERY'],
+-					],
+-				],
+-		];
++		return array(
++			'filename'	=> 'main_module',
++			'title'		=> 'PHPBB_GALLERY',
++			'version'	=> '1.0.0',
++			'modes'		=> array(
++				'import_images'		=> array(
++					'title' => 'ACP_IMPORT_ALBUMS',
++					'auth' => 'acl_a_gallery_import && ext_phpbbgallery/acpimport',
++					'cat' => array('PHPBB_GALLERY')
++				),
++			),
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/acp/main_module.php"
+index 8f1b89229..f72b4c5cd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/acp/main_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/acp/main_module.php"
+@@ -1,14 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery - ACP Import Extension
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\acpimport\acp;
+ 
+@@ -71,7 +68,7 @@ class main_module
+ 					$filetype = getimagesize($image_src_full);
+ 					$filetype_ext = '';
+ 
+-					$error_occurred = false;
++					$error_occured = false;
+ 					switch ($filetype['mime'])
+ 					{
+ 						case 'image/jpeg':
+@@ -82,7 +79,7 @@ class main_module
+ 							if ((substr(strtolower($image_src), -4) != '.jpg') && (substr(strtolower($image_src), -5) != '.jpeg'))
+ 							{
+ 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
+-								$error_occurred = true;
++								$error_occured = true;
+ 							}
+ 						break;
+ 
+@@ -93,7 +90,7 @@ class main_module
+ 							if (substr(strtolower($image_src), -4) != '.png')
+ 							{
+ 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
+-								$error_occurred = true;
++								$error_occured = true;
+ 							}
+ 						break;
+ 
+@@ -104,7 +101,7 @@ class main_module
+ 							if (substr(strtolower($image_src), -4) != '.gif')
+ 							{
+ 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
+-								$error_occurred = true;
++								$error_occured = true;
+ 							}
+ 						break;
+ 
+@@ -114,29 +111,29 @@ class main_module
+ 							if (substr(strtolower($image_src), -5) != '.webp')
+ 							{
+ 								$this->log_import_error($import_schema, sprintf($user->lang['FILETYPE_MIMETYPE_MISMATCH'], $image_src, $filetype['mime']));
+-								$error_occurred = true;
++								$error_occured = true;
+ 							}
+ 						break;
+ 
+ 						default:
+ 							$this->log_import_error($import_schema, $user->lang['NOT_ALLOWED_FILE_TYPE']);
+-							$error_occurred = true;
++							$error_occured = true;
+ 						break;
+ 					}
+ 					$image_filename = md5(unique_id()) . $filetype_ext;
+ 					$file_link = $gallery_url->path('upload') . $image_filename;
+ 
+-					if (!$error_occurred || !@move_uploaded_file($image_src_full, $file_link))
++					if (!$error_occured || !@move_uploaded_file($image_src_full, $file_link))
+ 					{
+ 						if (!@copy($image_src_full, $file_link))
+ 						{
+ 							$user->add_lang('posting');
+ 							$this->log_import_error($import_schema, sprintf($user->lang['GENERAL_UPLOAD_ERROR'], $file_link));
+-							$error_occurred = true;
++							$error_occured = true;
+ 						}
+ 					}
+ 
+-					if (!$error_occurred)
++					if (!$error_occured)
+ 					{
+ 						@chmod($file_link, 0777);
+ 
+@@ -152,7 +149,7 @@ class main_module
+ 							'image_user_ip'			=> $user->ip,
+ 							'image_time'			=> $start_time + $done_images,
+ 							'image_album_id'		=> $album_id,
+-							'image_status'			=> (int) \phpbbgallery\core\block::STATUS_APPROVED,
++							'image_status'			=> \phpbbgallery\core\block::STATUS_APPROVED,
+ 							//'image_exif_data'		=> '',
+ 						);
+ 
+@@ -160,7 +157,7 @@ class main_module
+ 						$image_tools->set_image_options($gallery_config->get('max_filesize'), $gallery_config->get('max_height'), $gallery_config->get('max_width'));
+ 						$image_tools->set_image_data($file_link);
+ 
+-						$additional_sql_data = [];
++						$additional_sql_data = array();
+ 
+ 						/**
+ 						* Event to trigger before mass update
+@@ -398,7 +395,7 @@ class main_module
+ 			'ACP_GALLERY_TITLE_EXPLAIN'		=> $user->lang['ACP_IMPORT_ALBUMS_EXPLAIN'],
+ 			'L_IMPORT_DIR_EMPTY'			=> sprintf($user->lang['IMPORT_DIR_EMPTY'], $gallery_url->path('import')),
+ 			'S_ALBUM_IMPORT_ACTION'			=> $this->u_action,
+-			'S_SELECT_IMPORT' 				=> $gallery_album->get_albumbox(false, 'album_id', false, false, false, (int) \phpbbgallery\core\block::PUBLIC_ALBUM, (int) \phpbbgallery\core\block::TYPE_UPLOAD),
++			'S_SELECT_IMPORT' 				=> $gallery_album->get_albumbox(false, 'album_id', false, false, false, \phpbbgallery\core\block::PUBLIC_ALBUM, \phpbbgallery\core\block::TYPE_UPLOAD),
+ 			'U_FIND_USERNAME'				=> $gallery_url->append_sid('phpbb', 'memberlist', 'mode=searchuser&amp;form=acp_gallery&amp;field=username&amp;select_single=true'),
+ 		));
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/adm/style/gallery_acpimport.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/adm/style/gallery_acpimport.html"
+index f64596297..8577b566c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/adm/style/gallery_acpimport.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/adm/style/gallery_acpimport.html"
+@@ -47,4 +47,15 @@
+ 	</fieldset>
+ </form>
+ 
++<!--
++	I request you retain the full copyright notice below including the link to www.flying-bits.org.
++	This not only gives respect to the large amount of time given freely by the developer
++	but also helps build interest, traffic and use of phpBB Gallery. If you (honestly) cannot retain
++	the full copyright I ask you at least leave in place the "Powered by phpBB Gallery" line, with
++	"phpBB Gallery" linked to www.flying-bits.org. If you refuse to include even this then support on my
++	forums may be affected.
++
++	phpBB Gallery, nickvergessen : 2009
++	Powered by phpBB Gallery (http://www.flying-bits.org/) &copy; 2007, 2009 nickvergessen (http://www.flying-bits.org/)
++//-->
+ <!-- INCLUDE overall_footer.html -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/composer.json"
+index 5d12efdf6..e4a452a2a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/composer.json"
+@@ -26,17 +26,17 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=7.1"
++		"php": ">=5.3"
+ 	},
+ 	"extra": {
+ 		"display-name": "phpBB Gallery Add-on: ACP Import",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.2.0,<4.0.0@dev"
++			"phpbb/phpbb": ">=3.1.0-RC2,<3.3.0@dev"
+ 		}
+ 	},
+ 	"version-check": {
+ 		"host": "raw.githubusercontent.com",
+-		"directory": "/satanasov/phpbbgallery/master/",
++		"directory": "/satanasov/phpbbgallery/master",
+ 		"filename": "gallery-import.json",
+ 		"ssl": true
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/adm/style/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/diff_full.tmp"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/adm/style/index.htm"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/diff_full.tmp"
+index e69de29bb..2ce5bef16 100644
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/ext.php"
+index 63f00c26c..52a0f4086 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/ext.php"
+@@ -1,66 +1,11 @@
+ <?php
+-/**
+- * phpBB Gallery - ACP Import Extension
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    Leinad4Mind
+- * @copyright 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++
++// this file is not really needed, when empty it can be ommitted
++// however you can override the default methods and add custom
++// installation logic
+ 
+ namespace phpbbgallery\acpimport;
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
+-			$user->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');
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
+-	* Perform additional tasks on extension enable
+-	*
+-	* @param mixed $old_state State returned by previous call of this method
+-	* @return mixed Returns false after last step, otherwise temporary state
+-	*/
+-	public function enable_step($old_state)
+-	{
+-		if (empty($old_state))
+-		{
+-			$this->container->get('user')->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');
+-			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
+-		}
+-
+-		return parent::enable_step($old_state);
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/bg/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/bg/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_import.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_acpimport.php"
+similarity index 77%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_import.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_acpimport.php"
+index 7734722e8..a90fa45fe 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_import.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_acpimport.php"
+@@ -1,15 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension [Bulgarian Translation]
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator Lucifer <https://www.anavaro.com>
+- */
++*
++* @package Gallery - ACP Import Extension [Bulgarian]
++* @copyright (c) 2014 Lucifer - http://www.anavaro.com/
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
+ 	'ACP_IMPORT_ALBUMS'				=> 'Вкарване на изображения',
+ 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Тук можете да вкарате голямо количество изображения от файловата система. Преди да вкарате изображенията, моля оразмерете ги на ръка.',
+ 
+@@ -43,7 +39,4 @@ $lang = array_merge($lang, [
+ 	'MISSING_IMPORT_SCHEMA'			=> 'Избраната таблица за вкарване (%s) не може да бъде открита.',
+ 
+ 	'NO_FILE_SELECTED'				=> 'Трябва да изберете поне един фаил.',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/de/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/de/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_import.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_acpimport.php"
+similarity index 73%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_import.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_acpimport.php"
+index 934b69150..a0d0f090b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_import.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_acpimport.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension [German Translation]
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator franki <https://dieahnen.de/ahnenforum>
+- */
++*
++* @package Gallery - ACP Import Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++* Übersetzt von franki (http://dieahnen.de/ahnenforum/)
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
+ 	'ACP_IMPORT_ALBUMS'				=> 'Neue Bilder importieren',
+ 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Hier kannst Du die Anzahl von Bilder eingeben, die importiert werden sollen. Bevor Du die Bilder importierst, ändere die Größe von Hand mit einer Bildbearbeitungssoftware.',
+ 
+@@ -43,7 +40,4 @@ $lang = array_merge($lang, [
+ 	'MISSING_IMPORT_SCHEMA'			=> 'Das Import-Schema (%s) konnte nicht gefunden werden.',
+ 
+ 	'NO_FILE_SELECTED'				=> 'Du musst mindestens eine Datei auswählen.',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/en/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/en/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_import.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_acpimport.php"
+similarity index 74%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_import.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_acpimport.php"
+index 7ea1b7a58..b8eb48193 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_import.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_acpimport.php"
+@@ -1,14 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+-  */
++*
++* @package Gallery - ACP Import Extension [English]
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
+ 	'ACP_IMPORT_ALBUMS'				=> 'Import Images',
+ 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Here you can bulk import images from the file system. Before importing images, please be sure to resize them by hand.',
+ 
+@@ -42,7 +39,4 @@ $lang = array_merge($lang, [
+ 	'MISSING_IMPORT_SCHEMA'			=> 'The specified import-schema (%s) could not be found.',
+ 
+ 	'NO_FILE_SELECTED'				=> 'You need to select at least one file.',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/fr/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/fr/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_import.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_acpimport.php"
+similarity index 71%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_import.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_acpimport.php"
+index 1e742af47..0449ca1ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_import.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_acpimport.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension [French Translation]
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
+- */
++*
++* @package Gallery - ACP Import Extension [French]
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
+ 	'ACP_IMPORT_ALBUMS'				=> 'Importer des images',
+ 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Vous pouvez importer ici des images à partir du système de fichier. Avant d’importer des images, n’oubliez pas de les redimensionner manuellement.',
+ 
+@@ -43,7 +40,4 @@ $lang = array_merge($lang, [
+ 	'MISSING_IMPORT_SCHEMA'			=> 'Le schéma d’importation spécifié (%s) n’a pas pu être trouvé.',
+ 
+ 	'NO_FILE_SELECTED'				=> 'Vous devez sélectionner au moins un fichier.',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/it/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/it/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_import.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_acpimport.php"
+similarity index 70%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_import.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_acpimport.php"
+index 0bd1e26b0..beca0fdfa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_import.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_acpimport.php"
+@@ -1,15 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension [Italian Translation]
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator
+- */
++*
++* @package phpBB Gallery - ACP Import Extension [English]
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
+ 	'ACP_IMPORT_ALBUMS'				=> 'Importa Immagini',
+ 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Da qui puoi importare in massa immagini dal file system. Prima di importare le immagini assicurati di ridimensionarle manualmente.',
+ 
+@@ -33,7 +29,7 @@ $lang = array_merge($lang, [
+ 	'IMPORT_DIR_EMPTY'				=> 'La cartella %s e\' vuota. Devi caricarci le immagini per importarle.',
+ 	'IMPORT_FINISHED'				=> 'Tutte le %1$s immagini importate con successo.',
+ 	'IMPORT_FINISHED_ERRORS'		=> '%1$s immagini sono state importate con successo, ma sono stati riscontrati i seguenti errori:<br /><br />',
+-	'IMPORT_MISSING_ALBUM'			=> 'Seleziona un album in cui importare le immagini.',
++	'IMPORT_MISSING_ALBUM'			=> 'Seleziona un akbum in cui importare le immagini.',
+ 	'IMPORT_SELECT'					=> 'Scegli le immagini che vuoi importare. Le immagini importate con successo vengono cancellate. Tutte le altri immagini restano disponibili.',
+ 	'IMPORT_SCHEMA_CREATED'			=> 'Lo schema di importazione e\' stato creato con successo, attendi mentre le immagini vengono importate.',
+ 	'IMPORT_USER'					=> 'Caricate da',
+@@ -43,7 +39,4 @@ $lang = array_merge($lang, [
+ 	'MISSING_IMPORT_SCHEMA'			=> 'Lo schema di importazione specificato (%s) non e\' stato trovato.',
+ 
+ 	'NO_FILE_SELECTED'				=> 'Devi selezionare almeno un file.',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'L\'estensione è stata abilitata con successo.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/ru/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/ru/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_import.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_acpimport.php"
+similarity index 80%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_import.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_acpimport.php"
+index d5103360c..a9501fc0d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_import.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_acpimport.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension [Russian Translation]
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
++* @package Gallery - ACP Import Extension [Russian]
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
+ 	'ACP_IMPORT_ALBUMS'				=> 'Импорт новых изображений',
+ 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Здесь вы можете ввести количество изображений, которые будут импортированы. Перед тем, как импортировать изображения, измените размер вручную, используя программное обеспечение для редактирования изображений',
+ 
+@@ -43,7 +40,4 @@ $lang = array_merge($lang, [
+ 	'MISSING_IMPORT_SCHEMA'			=> 'Схема импорта (%s) не могла быть найдена',
+ 
+ 	'NO_FILE_SELECTED'				=> 'Вы должны выбрать минимум один файл',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/migrations/m1_init.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/migrations/m1_init.php"
+index 7a09fa5b8..a83c174cb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/migrations/m1_init.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/migrations/m1_init.php"
+@@ -1,129 +1,80 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Import Extension
+- *
+- * @package   phpbbgallery/acpimport
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery ACP Import
++* @copyright (c) 2014 satanasov
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\acpimport\migrations;
+ 
+-use phpbb\db\migration\migration;
+-
+-class m1_init extends migration
++class m1_init extends \phpbb\db\migration\migration
+ {
+-	/**
+-	 * Migration dependencies
+-	 *
+-	 * @return array Array of migration dependencies
+-	 */
+-	public static function depends_on(): array
++	static public function depends_on()
+ 	{
+-		return ['\phpbbgallery\core\migrations\release_1_2_0'];
++		return array('\phpbbgallery\core\migrations\release_1_2_0');
+ 	}
+ 
+-	/**
+-	 * Revert the changes
+-	 *
+-	 * @return array Array of update data
+-	 */
+-	public function revert_data(): array
++	public function revert_data()
+ 	{
+-		return [
+-				['custom', [[&$this, 'remove_file_system']]],
+-		];
++		return array(
++			array('custom', array(array(&$this, 'remove_file_system'))),
++		);
+ 	}
+ 
+-	/**
+-	 * Update data
+-	 *
+-	 * @return array Array of update data
+-	 */
+-	public function update_data(): array
++	public function update_data()
+ 	{
+-		return [
+-				['permission.add', ['a_gallery_import', true, 'a_board']],
+-				['module.add', [
+-					'acp',
+-					'PHPBB_GALLERY',
+-					[
+-						'module_basename' => '\phpbbgallery\acpimport\acp\main_module',
+-						'module_langname' => 'ACP_IMPORT_ALBUMS',
+-						'module_mode'     => 'import_images',
+-						'module_auth'     => 'ext_phpbbgallery/acpimport && acl_a_gallery_import',
+-					]
+-				]],
+-				['custom', [[&$this, 'create_file_system']]],
+-		];
++		return array(
++			array('permission.add', array('a_gallery_import', true, 'a_board')),
++			array('module.add', array(
++				'acp',
++				'PHPBB_GALLERY',
++				array(
++					'module_basename'	=> '\phpbbgallery\acpimport\acp\main_module',
++					'module_langname'	=> 'ACP_IMPORT_ALBUMS',
++					'module_mode'		=> 'import_images',
++					'module_auth'		=> 'ext_phpbbgallery/acpimport && acl_a_gallery_import',
++				)
++			)),
++			array('custom', array(array(&$this, 'create_file_system'))),
++		);
+ 	}
+ 
+-	/**
+-	 * Create import directory
+-	 *
+-	 * @return void
+-	 */
+-	public function create_file_system(): void
++	public function create_file_system()
+ 	{
+ 		global $phpbb_root_path;
+ 
+-		$phpbbgallery_import_file = $phpbb_root_path . 'files/phpbbgallery/import';
++		$phpbbgallery_core_file_import = $phpbb_root_path . 'files/phpbbgallery/import';
+ 
+-		if (!is_dir($phpbbgallery_import_file))
++		if (is_writable($phpbb_root_path . 'files'))
+ 		{
+-			if (is_writable($phpbb_root_path . 'files'))
+-			{
+-				@mkdir($phpbbgallery_import_file, 0755, true);
+-			}
++			@mkdir($phpbbgallery_core_file_import, 0755, true);
+ 		}
+ 	}
+ 
+-	/**
+-	 * Remove import directory
+-	 *
+-	 * @return void
+-	 */
+-	public function remove_file_system(): void
++	public function remove_file_system()
+ 	{
+ 		global $phpbb_root_path;
+ 
+-		$phpbbgallery_import_file = $phpbb_root_path . 'files/phpbbgallery/import';
++		$phpbbgallery_core_file_import = $phpbb_root_path . 'files/phpbbgallery/import';
+ 
+ 		// Clean dirs
+-		if (is_dir($phpbbgallery_import_file))
+-		{
+-			$this->recursiveRemoveDirectory($phpbbgallery_import_file);
+-		}
++		$this->recursiveRemoveDirectory($phpbbgallery_core_file_import);
+ 	}
+-
+-	/**
+-	 * Recursively remove a directory
+-	 *
+-	 * @param string $directory Directory path
+-	 * @return void
+-	 */
+-	private function recursiveRemoveDirectory(string $directory): void
++	function recursiveRemoveDirectory($directory)
+ 	{
+-		if (!is_dir($directory))
++		foreach (glob("{$directory}/*") as $file)
+ 		{
+-				return;
+-		}
+-
+-		$files = new \FilesystemIterator($directory);
+-		foreach ($files as $file)
+-		{
+-				if ($file->isDir())
+-				{
+-					$this->recursiveRemoveDirectory($file->getPathname());
+-				}
+-				else
+-				{
+-					@unlink($file->getPathname());
+-				}
++			if (is_dir($file))
++			{
++				recursiveRemoveDirectory($file);
++			}
++			else
++			{
++				unlink($file);
++			}
+ 		}
+-		@rmdir($directory);
++		rmdir($directory);
+ 	}
+ }
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/adm/style/index.htm" "[FORUM_EXT]/phpbbgallery\\acpimport/diff_nospace.tmp"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/adm/style/index.htm"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/diff_nospace.tmp"
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/ext.php" "[FORUM_EXT]/phpbbgallery\\acpimport/ext.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/ext.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/ext.php"
@@ -1,66 +1,11 @@
 <?php
-/**
- * phpBB Gallery - ACP Import Extension
- *
- * @package   phpbbgallery/acpimport
- * @author    Leinad4Mind
- * @copyright 2018- Leinad4Mind
- * @license   GPL-2.0-only
- */
+
+// this file is not really needed, when empty it can be ommitted
+// however you can override the default methods and add custom
+// installation logic
 
 namespace phpbbgallery\acpimport;
 
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
-			$user->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');
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
-	* Perform additional tasks on extension enable
-	*
-	* @param mixed $old_state State returned by previous call of this method
-	* @return mixed Returns false after last step, otherwise temporary state
-	*/
-	public function enable_step($old_state)
-	{
-		if (empty($old_state))
-		{
-			$this->container->get('user')->add_lang_ext('phpbbgallery/acpimport', 'info_acp_gallery_import');
-			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
-		}
-
-		return parent::enable_step($old_state);
-	}
 }
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/bg/index.htm" "[ORIGINAL]/phpbbgallery\\acpimport/language/bg/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/bg/info_acp_gallery_import.php" "[FORUM_EXT]/phpbbgallery\\acpimport/language/bg/info_acp_gallery_acpimport.php"
similarity index 77%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_import.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/bg/info_acp_gallery_acpimport.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/language/bg/info_acp_gallery_import.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/language/bg/info_acp_gallery_acpimport.php"
@@ -1,14 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension [Bulgarian Translation]
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator Lucifer <https://www.anavaro.com>
+* @package Gallery - ACP Import Extension [Bulgarian]
+* @copyright (c) 2014 Lucifer - http://www.anavaro.com/
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
 	'ACP_IMPORT_ALBUMS'				=> 'Вкарване на изображения',
 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Тук можете да вкарате голямо количество изображения от файловата система. Преди да вкарате изображенията, моля оразмерете ги на ръка.',
 
@@ -43,7 +39,4 @@ $lang = array_merge($lang, [
 	'MISSING_IMPORT_SCHEMA'			=> 'Избраната таблица за вкарване (%s) не може да бъде открита.',
 
 	'NO_FILE_SELECTED'				=> 'Трябва да изберете поне един фаил.',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/de/index.htm" "[ORIGINAL]/phpbbgallery\\acpimport/language/de/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/de/info_acp_gallery_import.php" "[FORUM_EXT]/phpbbgallery\\acpimport/language/de/info_acp_gallery_acpimport.php"
similarity index 73%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_import.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/de/info_acp_gallery_acpimport.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/language/de/info_acp_gallery_import.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/language/de/info_acp_gallery_acpimport.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension [German Translation]
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator franki <https://dieahnen.de/ahnenforum>
+* @package Gallery - ACP Import Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+* Übersetzt von franki (http://dieahnen.de/ahnenforum/)
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
 	'ACP_IMPORT_ALBUMS'				=> 'Neue Bilder importieren',
 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Hier kannst Du die Anzahl von Bilder eingeben, die importiert werden sollen. Bevor Du die Bilder importierst, ändere die Größe von Hand mit einer Bildbearbeitungssoftware.',
 
@@ -43,7 +40,4 @@ $lang = array_merge($lang, [
 	'MISSING_IMPORT_SCHEMA'			=> 'Das Import-Schema (%s) konnte nicht gefunden werden.',
 
 	'NO_FILE_SELECTED'				=> 'Du musst mindestens eine Datei auswählen.',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/en/index.htm" "[ORIGINAL]/phpbbgallery\\acpimport/language/en/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/en/info_acp_gallery_import.php" "[FORUM_EXT]/phpbbgallery\\acpimport/language/en/info_acp_gallery_acpimport.php"
similarity index 74%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_import.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/en/info_acp_gallery_acpimport.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/language/en/info_acp_gallery_import.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/language/en/info_acp_gallery_acpimport.php"
@@ -1,13 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package Gallery - ACP Import Extension [English]
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
 	'ACP_IMPORT_ALBUMS'				=> 'Import Images',
 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Here you can bulk import images from the file system. Before importing images, please be sure to resize them by hand.',
 
@@ -42,7 +39,4 @@ $lang = array_merge($lang, [
 	'MISSING_IMPORT_SCHEMA'			=> 'The specified import-schema (%s) could not be found.',
 
 	'NO_FILE_SELECTED'				=> 'You need to select at least one file.',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/fr/index.htm" "[ORIGINAL]/phpbbgallery\\acpimport/language/fr/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/fr/info_acp_gallery_import.php" "[FORUM_EXT]/phpbbgallery\\acpimport/language/fr/info_acp_gallery_acpimport.php"
similarity index 71%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_import.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/fr/info_acp_gallery_acpimport.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/language/fr/info_acp_gallery_import.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/language/fr/info_acp_gallery_acpimport.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension [French Translation]
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
+* @package Gallery - ACP Import Extension [French]
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
 	'ACP_IMPORT_ALBUMS'				=> 'Importer des images',
 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Vous pouvez importer ici des images à partir du système de fichier. Avant d’importer des images, n’oubliez pas de les redimensionner manuellement.',
 
@@ -43,7 +40,4 @@ $lang = array_merge($lang, [
 	'MISSING_IMPORT_SCHEMA'			=> 'Le schéma d’importation spécifié (%s) n’a pas pu être trouvé.',
 
 	'NO_FILE_SELECTED'				=> 'Vous devez sélectionner au moins un fichier.',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/it/index.htm" "[ORIGINAL]/phpbbgallery\\acpimport/language/it/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/it/info_acp_gallery_import.php" "[FORUM_EXT]/phpbbgallery\\acpimport/language/it/info_acp_gallery_acpimport.php"
similarity index 70%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_import.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/it/info_acp_gallery_acpimport.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/language/it/info_acp_gallery_import.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/language/it/info_acp_gallery_acpimport.php"
@@ -1,14 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension [Italian Translation]
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator
+* @package phpBB Gallery - ACP Import Extension [English]
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
 	'ACP_IMPORT_ALBUMS'				=> 'Importa Immagini',
 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Da qui puoi importare in massa immagini dal file system. Prima di importare le immagini assicurati di ridimensionarle manualmente.',
 
@@ -33,7 +29,7 @@ $lang = array_merge($lang, [
 	'IMPORT_DIR_EMPTY'				=> 'La cartella %s e\' vuota. Devi caricarci le immagini per importarle.',
 	'IMPORT_FINISHED'				=> 'Tutte le %1$s immagini importate con successo.',
 	'IMPORT_FINISHED_ERRORS'		=> '%1$s immagini sono state importate con successo, ma sono stati riscontrati i seguenti errori:<br /><br />',
-	'IMPORT_MISSING_ALBUM'			=> 'Seleziona un album in cui importare le immagini.',
+	'IMPORT_MISSING_ALBUM'			=> 'Seleziona un akbum in cui importare le immagini.',
 	'IMPORT_SELECT'					=> 'Scegli le immagini che vuoi importare. Le immagini importate con successo vengono cancellate. Tutte le altri immagini restano disponibili.',
 	'IMPORT_SCHEMA_CREATED'			=> 'Lo schema di importazione e\' stato creato con successo, attendi mentre le immagini vengono importate.',
 	'IMPORT_USER'					=> 'Caricate da',
@@ -43,7 +39,4 @@ $lang = array_merge($lang, [
 	'MISSING_IMPORT_SCHEMA'			=> 'Lo schema di importazione specificato (%s) non e\' stato trovato.',
 
 	'NO_FILE_SELECTED'				=> 'Devi selezionare almeno un file.',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'L\'estensione è stata abilitata con successo.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/ru/index.htm" "[ORIGINAL]/phpbbgallery\\acpimport/language/ru/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/language/ru/info_acp_gallery_import.php" "[FORUM_EXT]/phpbbgallery\\acpimport/language/ru/info_acp_gallery_acpimport.php"
similarity index 80%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_import.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\acpimport/language/ru/info_acp_gallery_acpimport.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/language/ru/info_acp_gallery_import.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/language/ru/info_acp_gallery_acpimport.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension [Russian Translation]
 *
- * @package   phpbbgallery/acpcleanup
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator Eduard Schlak <https://translations.schlak.info>
+* @package Gallery - ACP Import Extension [Russian]
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
 	'ACP_IMPORT_ALBUMS'				=> 'Импорт новых изображений',
 	'ACP_IMPORT_ALBUMS_EXPLAIN'		=> 'Здесь вы можете ввести количество изображений, которые будут импортированы. Перед тем, как импортировать изображения, измените размер вручную, используя программное обеспечение для редактирования изображений',
 
@@ -43,7 +40,4 @@ $lang = array_merge($lang, [
 	'MISSING_IMPORT_SCHEMA'			=> 'Схема импорта (%s) не могла быть найдена',
 
 	'NO_FILE_SELECTED'				=> 'Вы должны выбрать минимум один файл',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\acpimport/migrations/m1_init.php" "[FORUM_EXT]/phpbbgallery\\acpimport/migrations/m1_init.php"
--- "[ORIGINAL]/phpbbgallery\\acpimport/migrations/m1_init.php"
+++ "[FORUM_EXT]/phpbbgallery\\acpimport/migrations/m1_init.php"
@@ -1,129 +1,80 @@
 <?php
 /**
- * phpBB Gallery - ACP Import Extension
 *
- * @package   phpbbgallery/acpimport
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery ACP Import
+* @copyright (c) 2014 satanasov
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\acpimport\migrations;
 
-use phpbb\db\migration\migration;
-
-class m1_init extends migration
+class m1_init extends \phpbb\db\migration\migration
 {
-	/**
-	 * Migration dependencies
-	 *
-	 * @return array Array of migration dependencies
-	 */
-	public static function depends_on(): array
+	static public function depends_on()
 	{
-		return ['\phpbbgallery\core\migrations\release_1_2_0'];
+		return array('\phpbbgallery\core\migrations\release_1_2_0');
 	}
 
-	/**
-	 * Revert the changes
-	 *
-	 * @return array Array of update data
-	 */
-	public function revert_data(): array
+	public function revert_data()
 	{
-		return [
-				['custom', [[&$this, 'remove_file_system']]],
-		];
+		return array(
+			array('custom', array(array(&$this, 'remove_file_system'))),
+		);
 	}
 
-	/**
-	 * Update data
-	 *
-	 * @return array Array of update data
-	 */
-	public function update_data(): array
+	public function update_data()
 	{
-		return [
-				['permission.add', ['a_gallery_import', true, 'a_board']],
-				['module.add', [
+		return array(
+			array('permission.add', array('a_gallery_import', true, 'a_board')),
+			array('module.add', array(
 				'acp',
 				'PHPBB_GALLERY',
-					[
+				array(
 					'module_basename'	=> '\phpbbgallery\acpimport\acp\main_module',
 					'module_langname'	=> 'ACP_IMPORT_ALBUMS',
 					'module_mode'		=> 'import_images',
 					'module_auth'		=> 'ext_phpbbgallery/acpimport && acl_a_gallery_import',
-					]
-				]],
-				['custom', [[&$this, 'create_file_system']]],
-		];
+				)
+			)),
+			array('custom', array(array(&$this, 'create_file_system'))),
+		);
 	}
 
-	/**
-	 * Create import directory
-	 *
-	 * @return void
-	 */
-	public function create_file_system(): void
+	public function create_file_system()
 	{
 		global $phpbb_root_path;
 
-		$phpbbgallery_import_file = $phpbb_root_path . 'files/phpbbgallery/import';
+		$phpbbgallery_core_file_import = $phpbb_root_path . 'files/phpbbgallery/import';
 
-		if (!is_dir($phpbbgallery_import_file))
-		{
 		if (is_writable($phpbb_root_path . 'files'))
 		{
-				@mkdir($phpbbgallery_import_file, 0755, true);
-			}
+			@mkdir($phpbbgallery_core_file_import, 0755, true);
 		}
 	}
 
-	/**
-	 * Remove import directory
-	 *
-	 * @return void
-	 */
-	public function remove_file_system(): void
+	public function remove_file_system()
 	{
 		global $phpbb_root_path;
 
-		$phpbbgallery_import_file = $phpbb_root_path . 'files/phpbbgallery/import';
+		$phpbbgallery_core_file_import = $phpbb_root_path . 'files/phpbbgallery/import';
 
 		// Clean dirs
-		if (is_dir($phpbbgallery_import_file))
-		{
-			$this->recursiveRemoveDirectory($phpbbgallery_import_file);
-		}
+		$this->recursiveRemoveDirectory($phpbbgallery_core_file_import);
 	}
-
-	/**
-	 * Recursively remove a directory
-	 *
-	 * @param string $directory Directory path
-	 * @return void
-	 */
-	private function recursiveRemoveDirectory(string $directory): void
+	function recursiveRemoveDirectory($directory)
 	{
-		if (!is_dir($directory))
-		{
-				return;
-		}
-
-		$files = new \FilesystemIterator($directory);
-		foreach ($files as $file)
+		foreach (glob("{$directory}/*") as $file)
 		{
-				if ($file->isDir())
+			if (is_dir($file))
 			{
-					$this->recursiveRemoveDirectory($file->getPathname());
+				recursiveRemoveDirectory($file);
 			}
 			else
 			{
-					@unlink($file->getPathname());
+				unlink($file);
 			}
 		}
-		@rmdir($directory);
+		rmdir($directory);
 	}
 }
```
