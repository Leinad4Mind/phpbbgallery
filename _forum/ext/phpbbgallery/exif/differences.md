Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/phpbbgallery\\exif/composer.json" "[FORUM_EXT]/phpbbgallery\\exif/composer.json"
--- "[ORIGINAL]/phpbbgallery\\exif/composer.json"
+++ "[FORUM_EXT]/phpbbgallery\\exif/composer.json"
@@ -26,17 +26,17 @@
 		}
 	],
 	"require": {
-		"php": ">=7.1"
+		"php": ">=5.3"
 	},
 	"extra": {
 		"display-name": "phpBB Gallery Add-on: Exif",
 		"soft-require": {
-			"phpbb/phpbb": ">=3.2.0,<4.0.0@dev"
+			"phpbb/phpbb": ">=3.1.0-RC2,<3.3.0@dev"
 		}
 	},
 	"version-check": {
 		"host": "raw.githubusercontent.com",
-		"directory": "/satanasov/phpbbgallery/master/",
+		"directory": "/satanasov/phpbbgallery/master",
 		"filename": "gallery-exif.json",
 		"ssl": true
 	}
diff --git "[FORUM_EXT]/phpbbgallery\\exif/diff_full.tmp" "[FORUM_EXT]/phpbbgallery\\exif/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbgallery\\exif/diff_full.tmp"
@@ -0,0 +1,716 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/composer.json"
+index 56ccf185b..5a0884c4c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/composer.json"
+@@ -26,17 +26,17 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=7.1"
++		"php": ">=5.3"
+ 	},
+ 	"extra": {
+ 		"display-name": "phpBB Gallery Add-on: Exif",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.2.0,<4.0.0@dev"
++			"phpbb/phpbb": ">=3.1.0-RC2,<3.3.0@dev"
+ 		}
+ 	},
+ 	"version-check": {
+ 		"host": "raw.githubusercontent.com",
+-		"directory": "/satanasov/phpbbgallery/master/",
++		"directory": "/satanasov/phpbbgallery/master",
+ 		"filename": "gallery-exif.json",
+ 		"ssl": true
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/diff_full.tmp"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/index.htm"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/diff_full.tmp"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/event/exif_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/event/exif_listener.php"
+index 531626550..2f177bf2a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/event/exif_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/event/exif_listener.php"
+@@ -1,14 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery - Exif Extension
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\exif\event;
+ 
+@@ -62,7 +59,7 @@ class exif_listener implements EventSubscriberInterface
+ 	* @param \phpbbgallery\core\config		$gallery_config	Core gallery config object
+ 	* @param \phpbbgallery\core\auth\auth	$gallery_auth	Core gallery auth object
+ 	* @param \phpbbgallery\core\url			$gallery_url	Core gallery url object
+-	* @param \phpbbgallery\core\user		$gallery_user	Core gallery user wrapper
++	* @param \phpbbgallery\core\user		$gallery_user	Core gallery user wraper
+ 	*/
+ 
+ 	public function __construct(\phpbb\user $user, \phpbbgallery\core\config $gallery_config, \phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\url $gallery_url, \phpbbgallery\core\user $gallery_user)
+@@ -81,7 +78,7 @@ class exif_listener implements EventSubscriberInterface
+ 			$return_ary = $event['return_ary'];
+ 			if (isset($return_ary['vars']['IMAGE_SETTINGS']))
+ 			{
+-				$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
++				$this->user->add_lang_ext('phpbbgallery/exif', 'exif');
+ 
+ 				$return_ary['vars']['IMAGE_SETTINGS']['disp_exifdata'] = array('lang' => 'DISP_EXIF_DATA',		'validate' => 'bool',	'type' => 'radio:yes_no');
+ 				$event['return_ary'] = $return_ary;
+@@ -144,7 +141,7 @@ class exif_listener implements EventSubscriberInterface
+ 	public function ucp_set_settings_nosubmit()
+ 	{
+ 		global $template, $phpbb_ext_gallery;
+-		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
++		$this->user->add_lang_ext('phpbbgallery/exif', 'exif');
+ 
+ 		$template->assign_vars(array(
+ 			'S_VIEWEXIFS'		=> $this->gallery_user->get_data('user_viewexif'),
+@@ -236,7 +233,7 @@ class exif_listener implements EventSubscriberInterface
+ 
+ 	public function viewimage($event)
+ 	{
+-		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
++		$this->user->add_lang_ext('phpbbgallery/exif', 'exif');
+ 
+ 		// To do (test contests)
+ 		if ($this->gallery_config->get('disp_exifdata') && ($event['image_data']['image_has_exif'] != \phpbbgallery\exif\exif::UNAVAILABLE) && (substr($event['image_data']['image_filename'], -4) == '.jpg') && function_exists('exif_read_data') /*&& ($this->gallery_auth->acl_check('m_status', $event['image_data']['image_album_id'], $event['album_data']['album_user_id']) || ($event['image_data']['image_contest'] != phpbb_ext_gallery_core_image::IN_CONTEST))*/)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/exif.php"
+index 0b624a940..b057f1f11 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/exif.php"
+@@ -1,14 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery - Exif Extension
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\exif;
+ 
+@@ -174,7 +171,7 @@ class exif
+ 	{
+ 		global $user;
+ 
+-		$user->add_lang_ext('phpbbgallery/exif', 'info_exif');
++		$user->add_lang_ext('phpbbgallery/exif', 'exif');
+ 
+ 		$this->prepared_data = array();
+ 		if (isset($this->data["EXIF"]["DateTimeOriginal"]))
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/ext.php"
+index 2f26475b2..623ece215 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/ext.php"
+@@ -1,66 +1,11 @@
+ <?php
+-/**
+- * phpBB Gallery - ACP Exif Extension
+- *
+- * @package   phpbbgallery/exif
+- * @author    Leinad4Mind
+- * @copyright 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++
++// this file is not really needed, when empty it can be ommitted
++// however you can override the default methods and add custom
++// installation logic
+ 
+ namespace phpbbgallery\exif;
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
+-			$user->add_lang_ext('phpbbgallery/exif', 'info_exif');
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
+-			$this->container->get('user')->add_lang_ext('phpbbgallery/exif', 'info_exif');
+-			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
+-		}
+-
+-		return parent::enable_step($old_state);
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/en/info_exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/bg/exif.php"
+similarity index 89%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/en/info_exif.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/bg/exif.php"
+index 6a371a7e1..c86dae92e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/en/info_exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/bg/exif.php"
+@@ -1,14 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+-  */
++*
++* @package Gallery - Exif Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ /**
+ * @ignore
+@@ -21,13 +18,13 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ /**
+ * Language for Exif data
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXIF_DATA'					=> 'Exif Data',
+ 	'EXIF_APERTURE'				=> 'F-number',
+ 	'EXIF_CAM_MODEL'			=> 'Camera-model',
+@@ -95,7 +92,4 @@ $lang = array_merge($lang, [
+ 	'DISP_EXIF_DATA_EXP'		=> 'This feature can not be used at the moment, as the need function “exif_read_data“ is not included in your PHP Installation.',
+ 	'SHOW_EXIF'					=> 'show/hide',
+ 	'VIEWEXIFS_DEFAULT'			=> 'View Exif-Data by default',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/info_exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/de/exif.php"
+similarity index 88%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/info_exif.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/de/exif.php"
+index 3963fad2e..bae375e85 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/info_exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/de/exif.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension [German Translation]
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator franki <https://motorradforum-niederrhein.de/downloads>
+- */
++*
++* @package Gallery - Exif Extension [Deutsch]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++* Übersetzt von franki (http://motorradforum-niederrhein.de/downloads/)
++*/
+ 
+ /**
+ * @ignore
+@@ -22,13 +19,13 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ /**
+ * Language for Exif data
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXIF_DATA'					=> 'EXIF-Daten',
+ 	'EXIF_APERTURE'				=> 'Blende',
+ 	'EXIF_CAM_MODEL'			=> 'Kamera-Modell',
+@@ -96,7 +93,4 @@ $lang = array_merge($lang, [
+ 	'DISP_EXIF_DATA_EXP'		=> 'Diese Funktion kann im Moment nicht verwendet werden, da die Funktion “exif_read_data“ nicht in Deiner PHP-Installation enthalten ist.',
+ 	'SHOW_EXIF'					=> 'ein-/ausblenden',
+ 	'VIEWEXIFS_DEFAULT'			=> 'Ansicht Exif-Daten standardmäßig',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/bg/info_exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/en/exif.php"
+similarity index 86%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/bg/info_exif.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/en/exif.php"
+index 0513c11ba..c86dae92e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/bg/info_exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/en/exif.php"
+@@ -1,15 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension [Bulgarian Translation]
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator Lucifer <https://www.anavaro.com>
+- */
++*
++* @package Gallery - Exif Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ /**
+ * @ignore
+@@ -22,13 +18,13 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ /**
+ * Language for Exif data
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXIF_DATA'					=> 'Exif Data',
+ 	'EXIF_APERTURE'				=> 'F-number',
+ 	'EXIF_CAM_MODEL'			=> 'Camera-model',
+@@ -96,7 +92,4 @@ $lang = array_merge($lang, [
+ 	'DISP_EXIF_DATA_EXP'		=> 'This feature can not be used at the moment, as the need function “exif_read_data“ is not included in your PHP Installation.',
+ 	'SHOW_EXIF'					=> 'show/hide',
+ 	'VIEWEXIFS_DEFAULT'			=> 'View Exif-Data by default',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/fr/info_exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/fr/exif.php"
+similarity index 87%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/fr/info_exif.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/fr/exif.php"
+index 32773855a..dc8131e97 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/fr/info_exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/fr/exif.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension [French Translation]
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
+- */
++*
++* @package Gallery - Exif Extension [French]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++* @translator fr (c) pokyto aka le.poke http://www.lestontonsfraggers.com inspired by darky - http://www.foruminfopc.fr/ and Team http://www.phpbb-fr.com/
++*
++*/
+ 
+ /**
+ * @ignore
+@@ -22,13 +19,13 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ /**
+ * Language for Exif data
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXIF_DATA'					=> 'Informations des images',
+ 	'EXIF_APERTURE'				=> 'Nombre-F',
+ 	'EXIF_CAM_MODEL'			=> 'Modèle d’appareil photo',
+@@ -96,7 +93,4 @@ $lang = array_merge($lang, [
+ 	'DISP_EXIF_DATA_EXP'		=> 'Cette fonctionnalité ne peut pas être utilisée pour le moment, car la fonction « exif_read_data » n’est pas incluse dans l’installation de votre PHP.',
+ 	'SHOW_EXIF'					=> 'Afficher/Cacher',
+ 	'VIEWEXIFS_DEFAULT'			=> 'Voir les informations des images par défaut',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/fr/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/fr/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/it/info_exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/it/exif.php"
+similarity index 89%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/it/info_exif.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/it/exif.php"
+index 7c12ddaf9..430f56ee2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/it/info_exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/it/exif.php"
+@@ -1,15 +1,11 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension [Italian Translation]
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator
+- */
++*
++* @package phpBB Gallery - Exif Extension [English]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ /**
+ * @ignore
+@@ -22,13 +18,13 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ /**
+ * Language for Exif data
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXIF_DATA'					=> 'Dati Exif',
+ 	'EXIF_APERTURE'				=> 'F-number',
+ 	'EXIF_CAM_MODEL'			=> 'Modello Camera',
+@@ -96,7 +92,4 @@ $lang = array_merge($lang, [
+ 	'DISP_EXIF_DATA_EXP'		=> 'Questa caratteristica non puo\' essere utilizzatal momento, dato che la funzione “exif_read_data“ non e\' inclusa nella tua installazione di PHP.',
+ 	'SHOW_EXIF'					=> 'mostra/nascondi',
+ 	'VIEWEXIFS_DEFAULT'			=> 'Visualizza Dati-Exif in modo predefinito',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'L\'estensione è stata abilitata con successo.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/ru/info_exif.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/ru/exif.php"
+similarity index 90%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/ru/info_exif.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/ru/exif.php"
+index 137ff2d9a..9d4c21fbc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/ru/info_exif.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/ru/exif.php"
+@@ -1,15 +1,12 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension [Russian Translation]
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- * @translator Eduard Schlak <https://translations.schlak.info/>
+- */
++*
++* @package Gallery - Exif Extension [Russian]
++* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++* Translation from Eduard Schlak (http://translations.schlak.info/)
++*/
+ 
+ /**
+ * @ignore
+@@ -22,13 +19,13 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ /**
+ * Language for Exif data
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXIF_DATA'					=> 'EXIF-Данные',
+ 	'EXIF_APERTURE'				=> 'Диафрагма',
+ 	'EXIF_CAM_MODEL'			=> 'Модель камеры',
+@@ -96,7 +93,4 @@ $lang = array_merge($lang, [
+ 	'DISP_EXIF_DATA_EXP'		=> 'Эта функция не может использоваться на данный момент, т.к. функция "exif_read_data" не входит в установке PHP',
+ 	'SHOW_EXIF'					=> 'Показать / Скрыть',
+ 	'VIEWEXIFS_DEFAULT'			=> 'Просмотр EXIF-Данных по умолчанию',
+-
+-	'GALLERY_CORE_NOT_FOUND'		=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
+-	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/ru/index.htm" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/ru/index.htm"
+deleted file mode 100644
+index e69de29bb..000000000
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/migrations/m1_init.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/migrations/m1_init.php"
+index e8636af2f..83ddf5bc9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/migrations/m1_init.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/migrations/m1_init.php"
+@@ -1,61 +1,55 @@
+ <?php
+ /**
+- * phpBB Gallery - ACP Exif Extension
+- *
+- * @package   phpbbgallery/exif
+- * @author    nickvergessen
+- * @author    satanasov
+- * @author    Leinad4Mind
+- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
++*
++* @package phpBB Gallery EXIF
++* @copyright (c) 2014 satanasov
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace phpbbgallery\exif\migrations;
+ 
+-use phpbb\db\migration\migration;
+-
+-class m1_init extends migration
++class m1_init extends \phpbb\db\migration\migration
+ {
+-	public static function depends_on(): array
++	static public function depends_on()
+ 	{
+-		return ['\phpbbgallery\core\migrations\release_1_2_0'];
++		return array('\phpbbgallery\core\migrations\release_1_2_0');
+ 	}
+ 
+-	public function update_data(): array
++	public function update_data()
+ 	{
+-		return [
+-			['config.add', ['phpbb_gallery_disp_exifdata', 1]],
+-		];
++		return array(
++			// add config
++			array('config.add', array('phpbb_gallery_disp_exifdata', 1))
++		);
+ 	}
+-
+-	// Let's create the needed table
+-	public function update_schema(): array
++	//lets create the needed table
++	public function update_schema()
+ 	{
+-		return [
+-			'add_columns' => [
+-				$this->table_prefix . 'gallery_images' => [
+-					'image_has_exif'   => ['UINT:3', 2],
+-					'image_exif_data'  => ['TEXT', ''],
+-				],
+-				$this->table_prefix . 'gallery_users' => [
+-					'user_viewexif'    => ['UINT:1', 0],
+-				],
+-			],
+-		];
++		return array(
++			'add_columns'	=> array(
++				$this->table_prefix . 'gallery_images'	=> array(
++					'image_has_exif'		=> array('UINT:3', 2),
++					'image_exif_data'		=> array('TEXT', ''),
++				),
++				$this->table_prefix . 'gallery_users'	=> array(
++					'user_viewexif'		=> array('UINT:1', 0),
++				),
++			),
++		);
+ 	}
+-
+-	public function revert_schema(): array
++	public function revert_schema()
+ 	{
+-		return [
+-			'drop_columns' => [
+-				$this->table_prefix . 'gallery_images' => [
++		return array(
++			'drop_columns'	=> array(
++				$this->table_prefix . 'gallery_images'	=> array(
+ 					'image_has_exif',
+-					'image_exif_data',
+-				],
+-				$this->table_prefix . 'gallery_users' => [
++					'image_exif_data'
++				),
++				$this->table_prefix . 'gallery_users'	=> array(
+ 					'user_viewexif',
+-				],
+-			],
+-		];
++				),
++			),
++		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/migrations/m2_fix_exif_field.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/migrations/m2_fix_exif_field.php"
+deleted file mode 100644
+index 168d068c4..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/migrations/m2_fix_exif_field.php"
++++ /dev/null
+@@ -1,45 +0,0 @@
+-<?php
+-/**
+- * phpBB Gallery - Exif Extension
+- *
+- * @package   phpbbgallery/exif
+- * @author    Leinad4Mind
+- * @copyright 2018- Leinad4Mind
+- * @license   GPL-2.0-only
+- */
+-
+-namespace phpbbgallery\exif\migrations;
+-
+-use phpbb\db\migration\migration;
+-
+-class m2_fix_exif_field extends migration
+-{
+-	public static function depends_on(): array
+-	{
+-		return [
+-				'\phpbbgallery\exif\migrations\m1_init',
+-		];
+-	}
+-
+-	public function update_schema(): array
+-	{
+-		return [
+-				'change_columns' => [
+-					$this->table_prefix . 'gallery_images' => [
+-						'image_exif_data' => ['TEXT', null],
+-					],
+-				],
+-		];
+-	}
+-
+-	public function revert_schema(): array
+-	{
+-		return [
+-				'change_columns' => [
+-					$this->table_prefix . 'gallery_images' => [
+-						'image_exif_data' => ['TEXT', ''],
+-					],
+-				],
+-		];
+-	}
+-}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_ucp_settings_fieldset.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_ucp_settings_fieldset.html"
+new file mode 100644
+index 000000000..5fbaf2b0d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_ucp_settings_fieldset.html"
+@@ -0,0 +1,7 @@
++<dl>
++	<dt><label for="viewexifs1">{L_VIEWEXIFS_DEFAULT}{L_COLON}</label></dt>
++	<dd>
++		<label for="viewexifs1"><input type="radio" name="viewexifs" id="viewexifs1" value="1"<!-- IF S_VIEWEXIFS --> checked="checked"<!-- ENDIF --> /> {L_YES}</label> 
++		<label for="viewexifs0"><input type="radio" name="viewexifs" id="viewexifs0" value="0"<!-- IF not S_VIEWEXIFS --> checked="checked"<!-- ENDIF --> /> {L_NO}</label>
++	</dd>
++</dl>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html"
+new file mode 100644
+index 000000000..8445ac721
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html"
+@@ -0,0 +1,12 @@
++<!-- IF .exif_value -->
++	<h3 class="anti-postbody">{L_EXIF_DATA}</h3>
++	<br /> <hr />
++	<fieldset class="fields1 anti-postbody" id="exif_data_fieldset">
++	<!-- BEGIN exif_value -->
++		<dl class="<!-- IF exif_value.S_ROW_COUNT is even -->column1<!-- ELSE -->column2<!-- ENDIF -->">
++			<dt><label>{exif_value.EXIF_NAME}{L_COLON}</label></dt>
++			<dd>{exif_value.EXIF_VALUE}</dd>
++		</dl>
++	<!-- END exif_value -->
++	</fieldset>
++<!-- ENDIF -->
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/de/index.htm" "[FORUM_EXT]/phpbbgallery\\exif/diff_nospace.tmp"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/index.htm"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/diff_nospace.tmp"
diff --git "[ORIGINAL]/phpbbgallery\\exif/event/exif_listener.php" "[FORUM_EXT]/phpbbgallery\\exif/event/exif_listener.php"
--- "[ORIGINAL]/phpbbgallery\\exif/event/exif_listener.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/event/exif_listener.php"
@@ -1,13 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery - Exif Extension
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\exif\event;
@@ -62,7 +59,7 @@ class exif_listener implements EventSubscriberInterface
 	* @param \phpbbgallery\core\config		$gallery_config	Core gallery config object
 	* @param \phpbbgallery\core\auth\auth	$gallery_auth	Core gallery auth object
 	* @param \phpbbgallery\core\url			$gallery_url	Core gallery url object
-	* @param \phpbbgallery\core\user		$gallery_user	Core gallery user wrapper
+	* @param \phpbbgallery\core\user		$gallery_user	Core gallery user wraper
 	*/
 
 	public function __construct(\phpbb\user $user, \phpbbgallery\core\config $gallery_config, \phpbbgallery\core\auth\auth $gallery_auth, \phpbbgallery\core\url $gallery_url, \phpbbgallery\core\user $gallery_user)
@@ -81,7 +78,7 @@ class exif_listener implements EventSubscriberInterface
 			$return_ary = $event['return_ary'];
 			if (isset($return_ary['vars']['IMAGE_SETTINGS']))
 			{
-				$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
+				$this->user->add_lang_ext('phpbbgallery/exif', 'exif');
 
 				$return_ary['vars']['IMAGE_SETTINGS']['disp_exifdata'] = array('lang' => 'DISP_EXIF_DATA',		'validate' => 'bool',	'type' => 'radio:yes_no');
 				$event['return_ary'] = $return_ary;
@@ -144,7 +141,7 @@ class exif_listener implements EventSubscriberInterface
 	public function ucp_set_settings_nosubmit()
 	{
 		global $template, $phpbb_ext_gallery;
-		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
+		$this->user->add_lang_ext('phpbbgallery/exif', 'exif');
 
 		$template->assign_vars(array(
 			'S_VIEWEXIFS'		=> $this->gallery_user->get_data('user_viewexif'),
@@ -236,7 +233,7 @@ class exif_listener implements EventSubscriberInterface
 
 	public function viewimage($event)
 	{
-		$this->user->add_lang_ext('phpbbgallery/exif', 'info_exif');
+		$this->user->add_lang_ext('phpbbgallery/exif', 'exif');
 
 		// To do (test contests)
 		if ($this->gallery_config->get('disp_exifdata') && ($event['image_data']['image_has_exif'] != \phpbbgallery\exif\exif::UNAVAILABLE) && (substr($event['image_data']['image_filename'], -4) == '.jpg') && function_exists('exif_read_data') /*&& ($this->gallery_auth->acl_check('m_status', $event['image_data']['image_album_id'], $event['album_data']['album_user_id']) || ($event['image_data']['image_contest'] != phpbb_ext_gallery_core_image::IN_CONTEST))*/)
diff --git "[ORIGINAL]/phpbbgallery\\exif/exif.php" "[FORUM_EXT]/phpbbgallery\\exif/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/exif.php"
@@ -1,13 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery - Exif Extension
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\exif;
@@ -174,7 +171,7 @@ class exif
 	{
 		global $user;
 
-		$user->add_lang_ext('phpbbgallery/exif', 'info_exif');
+		$user->add_lang_ext('phpbbgallery/exif', 'exif');
 
 		$this->prepared_data = array();
 		if (isset($this->data["EXIF"]["DateTimeOriginal"]))
diff --git "[ORIGINAL]/phpbbgallery\\exif/ext.php" "[FORUM_EXT]/phpbbgallery\\exif/ext.php"
--- "[ORIGINAL]/phpbbgallery\\exif/ext.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/ext.php"
@@ -1,66 +1,11 @@
 <?php
-/**
- * phpBB Gallery - ACP Exif Extension
- *
- * @package   phpbbgallery/exif
- * @author    Leinad4Mind
- * @copyright 2018- Leinad4Mind
- * @license   GPL-2.0-only
- */
+
+// this file is not really needed, when empty it can be ommitted
+// however you can override the default methods and add custom
+// installation logic
 
 namespace phpbbgallery\exif;
 
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
-			$user->add_lang_ext('phpbbgallery/exif', 'info_exif');
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
-			$this->container->get('user')->add_lang_ext('phpbbgallery/exif', 'info_exif');
-			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS']);
-		}
-
-		return parent::enable_step($old_state);
-	}
 }
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/en/info_exif.php" "[FORUM_EXT]/phpbbgallery\\exif/language/bg/exif.php"
similarity index 89%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/en/info_exif.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/bg/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/language/en/info_exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/language/bg/exif.php"
@@ -1,13 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package Gallery - Exif Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 /**
@@ -21,13 +18,13 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 /**
 * Language for Exif data
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXIF_DATA'					=> 'Exif Data',
 	'EXIF_APERTURE'				=> 'F-number',
 	'EXIF_CAM_MODEL'			=> 'Camera-model',
@@ -95,7 +92,4 @@ $lang = array_merge($lang, [
 	'DISP_EXIF_DATA_EXP'		=> 'This feature can not be used at the moment, as the need function “exif_read_data“ is not included in your PHP Installation.',
 	'SHOW_EXIF'					=> 'show/hide',
 	'VIEWEXIFS_DEFAULT'			=> 'View Exif-Data by default',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'phpBB Gallery Core extension must be installed and enabled first.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'The extension has been enabled successfully.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/de/info_exif.php" "[FORUM_EXT]/phpbbgallery\\exif/language/de/exif.php"
similarity index 88%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/de/info_exif.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/de/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/language/de/info_exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/language/de/exif.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension [German Translation]
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator franki <https://motorradforum-niederrhein.de/downloads>
+* @package Gallery - Exif Extension [Deutsch]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+* Übersetzt von franki (http://motorradforum-niederrhein.de/downloads/)
 */
 
 /**
@@ -22,13 +19,13 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 /**
 * Language for Exif data
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXIF_DATA'					=> 'EXIF-Daten',
 	'EXIF_APERTURE'				=> 'Blende',
 	'EXIF_CAM_MODEL'			=> 'Kamera-Modell',
@@ -96,7 +93,4 @@ $lang = array_merge($lang, [
 	'DISP_EXIF_DATA_EXP'		=> 'Diese Funktion kann im Moment nicht verwendet werden, da die Funktion “exif_read_data“ nicht in Deiner PHP-Installation enthalten ist.',
 	'SHOW_EXIF'					=> 'ein-/ausblenden',
 	'VIEWEXIFS_DEFAULT'			=> 'Ansicht Exif-Daten standardmäßig',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Die phpBB Gallery Core-Erweiterung muss zuerst installiert und aktiviert werden.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Die Erweiterung wurde erfolgreich aktiviert.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/bg/info_exif.php" "[FORUM_EXT]/phpbbgallery\\exif/language/en/exif.php"
similarity index 86%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/bg/info_exif.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/en/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/language/bg/info_exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/language/en/exif.php"
@@ -1,14 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension [Bulgarian Translation]
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator Lucifer <https://www.anavaro.com>
+* @package Gallery - Exif Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 /**
@@ -22,13 +18,13 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 /**
 * Language for Exif data
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXIF_DATA'					=> 'Exif Data',
 	'EXIF_APERTURE'				=> 'F-number',
 	'EXIF_CAM_MODEL'			=> 'Camera-model',
@@ -96,7 +92,4 @@ $lang = array_merge($lang, [
 	'DISP_EXIF_DATA_EXP'		=> 'This feature can not be used at the moment, as the need function “exif_read_data“ is not included in your PHP Installation.',
 	'SHOW_EXIF'					=> 'show/hide',
 	'VIEWEXIFS_DEFAULT'			=> 'View Exif-Data by default',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Първо трябва да бъде инсталирано и активирано разширението phpBB Gallery Core.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Разширението е активирано успешно.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/fr/info_exif.php" "[FORUM_EXT]/phpbbgallery\\exif/language/fr/exif.php"
similarity index 87%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/fr/info_exif.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/fr/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/language/fr/info_exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/language/fr/exif.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension [French Translation]
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator pokyto (aka le.poke) <https://www.lestontonsfraggers.com>, inspired by darky <https://www.foruminfopc.fr/> and the phpBB-fr.com Team
+* @package Gallery - Exif Extension [French]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+* @translator fr (c) pokyto aka le.poke http://www.lestontonsfraggers.com inspired by darky - http://www.foruminfopc.fr/ and Team http://www.phpbb-fr.com/
+*
 */
 
 /**
@@ -22,13 +19,13 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 /**
 * Language for Exif data
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXIF_DATA'					=> 'Informations des images',
 	'EXIF_APERTURE'				=> 'Nombre-F',
 	'EXIF_CAM_MODEL'			=> 'Modèle d’appareil photo',
@@ -96,7 +93,4 @@ $lang = array_merge($lang, [
 	'DISP_EXIF_DATA_EXP'		=> 'Cette fonctionnalité ne peut pas être utilisée pour le moment, car la fonction « exif_read_data » n’est pas incluse dans l’installation de votre PHP.',
 	'SHOW_EXIF'					=> 'Afficher/Cacher',
 	'VIEWEXIFS_DEFAULT'			=> 'Voir les informations des images par défaut',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'L’extension phpBB Gallery Core doit d’abord être installée et activée.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'L’extension a été activée avec succès.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/fr/index.htm" "[ORIGINAL]/phpbbgallery\\exif/language/fr/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/it/info_exif.php" "[FORUM_EXT]/phpbbgallery\\exif/language/it/exif.php"
similarity index 89%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/it/info_exif.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/it/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/language/it/info_exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/language/it/exif.php"
@@ -1,14 +1,10 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension [Italian Translation]
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator
+* @package phpBB Gallery - Exif Extension [English]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 /**
@@ -22,13 +18,13 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 /**
 * Language for Exif data
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXIF_DATA'					=> 'Dati Exif',
 	'EXIF_APERTURE'				=> 'F-number',
 	'EXIF_CAM_MODEL'			=> 'Modello Camera',
@@ -96,7 +92,4 @@ $lang = array_merge($lang, [
 	'DISP_EXIF_DATA_EXP'		=> 'Questa caratteristica non puo\' essere utilizzatal momento, dato che la funzione “exif_read_data“ non e\' inclusa nella tua installazione di PHP.',
 	'SHOW_EXIF'					=> 'mostra/nascondi',
 	'VIEWEXIFS_DEFAULT'			=> 'Visualizza Dati-Exif in modo predefinito',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'L\'estensione è stata abilitata con successo.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/ru/info_exif.php" "[FORUM_EXT]/phpbbgallery\\exif/language/ru/exif.php"
similarity index 90%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbbgallery\\exif/language/ru/info_exif.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbbgallery\\exif/language/ru/exif.php"
--- "[ORIGINAL]/phpbbgallery\\exif/language/ru/info_exif.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/language/ru/exif.php"
@@ -1,14 +1,11 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension [Russian Translation]
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
- * @translator Eduard Schlak <https://translations.schlak.info/>
+* @package Gallery - Exif Extension [Russian]
+* @copyright (c) 2012 nickvergessen - http://www.flying-bits.org/
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+* Translation from Eduard Schlak (http://translations.schlak.info/)
 */
 
 /**
@@ -22,13 +19,13 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 /**
 * Language for Exif data
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXIF_DATA'					=> 'EXIF-Данные',
 	'EXIF_APERTURE'				=> 'Диафрагма',
 	'EXIF_CAM_MODEL'			=> 'Модель камеры',
@@ -96,7 +93,4 @@ $lang = array_merge($lang, [
 	'DISP_EXIF_DATA_EXP'		=> 'Эта функция не может использоваться на данный момент, т.к. функция "exif_read_data" не входит в установке PHP',
 	'SHOW_EXIF'					=> 'Показать / Скрыть',
 	'VIEWEXIFS_DEFAULT'			=> 'Просмотр EXIF-Данных по умолчанию',
-
-	'GALLERY_CORE_NOT_FOUND'		=> 'Сначала необходимо установить и включить расширение phpBB Gallery Core.',
-	'EXTENSION_ENABLE_SUCCESS'		=> 'Расширение успешно включено.',
-]);
+));
diff --git "[ORIGINAL]/phpbbgallery\\exif/language/ru/index.htm" "[ORIGINAL]/phpbbgallery\\exif/language/ru/index.htm"
deleted file mode 100644
diff --git "[ORIGINAL]/phpbbgallery\\exif/migrations/m1_init.php" "[FORUM_EXT]/phpbbgallery\\exif/migrations/m1_init.php"
--- "[ORIGINAL]/phpbbgallery\\exif/migrations/m1_init.php"
+++ "[FORUM_EXT]/phpbbgallery\\exif/migrations/m1_init.php"
@@ -1,61 +1,55 @@
 <?php
 /**
- * phpBB Gallery - ACP Exif Extension
 *
- * @package   phpbbgallery/exif
- * @author    nickvergessen
- * @author    satanasov
- * @author    Leinad4Mind
- * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
- * @license   GPL-2.0-only
+* @package phpBB Gallery EXIF
+* @copyright (c) 2014 satanasov
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
 */
 
 namespace phpbbgallery\exif\migrations;
 
-use phpbb\db\migration\migration;
-
-class m1_init extends migration
+class m1_init extends \phpbb\db\migration\migration
 {
-	public static function depends_on(): array
+	static public function depends_on()
 	{
-		return ['\phpbbgallery\core\migrations\release_1_2_0'];
+		return array('\phpbbgallery\core\migrations\release_1_2_0');
 	}
 
-	public function update_data(): array
+	public function update_data()
 	{
-		return [
-			['config.add', ['phpbb_gallery_disp_exifdata', 1]],
-		];
+		return array(
+			// add config
+			array('config.add', array('phpbb_gallery_disp_exifdata', 1))
+		);
 	}
-
-	// Let's create the needed table
-	public function update_schema(): array
+	//lets create the needed table
+	public function update_schema()
 	{
-		return [
-			'add_columns' => [
-				$this->table_prefix . 'gallery_images' => [
-					'image_has_exif'   => ['UINT:3', 2],
-					'image_exif_data'  => ['TEXT', ''],
-				],
-				$this->table_prefix . 'gallery_users' => [
-					'user_viewexif'    => ['UINT:1', 0],
-				],
-			],
-		];
+		return array(
+			'add_columns'	=> array(
+				$this->table_prefix . 'gallery_images'	=> array(
+					'image_has_exif'		=> array('UINT:3', 2),
+					'image_exif_data'		=> array('TEXT', ''),
+				),
+				$this->table_prefix . 'gallery_users'	=> array(
+					'user_viewexif'		=> array('UINT:1', 0),
+				),
+			),
+		);
 	}
-
-	public function revert_schema(): array
+	public function revert_schema()
 	{
-		return [
-			'drop_columns' => [
-				$this->table_prefix . 'gallery_images' => [
+		return array(
+			'drop_columns'	=> array(
+				$this->table_prefix . 'gallery_images'	=> array(
 					'image_has_exif',
-					'image_exif_data',
-				],
-				$this->table_prefix . 'gallery_users' => [
+					'image_exif_data'
+				),
+				$this->table_prefix . 'gallery_users'	=> array(
 					'user_viewexif',
-				],
-			],
-		];
+				),
+			),
+		);
 	}
 }
diff --git "[ORIGINAL]/phpbbgallery\\exif/migrations/m2_fix_exif_field.php" "[ORIGINAL]/phpbbgallery\\exif/migrations/m2_fix_exif_field.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbbgallery\\exif/migrations/m2_fix_exif_field.php"
+++ /dev/null
@@ -1,45 +0,0 @@
-<?php
-/**
- * phpBB Gallery - Exif Extension
- *
- * @package   phpbbgallery/exif
- * @author    Leinad4Mind
- * @copyright 2018- Leinad4Mind
- * @license   GPL-2.0-only
- */
-
-namespace phpbbgallery\exif\migrations;
-
-use phpbb\db\migration\migration;
-
-class m2_fix_exif_field extends migration
-{
-	public static function depends_on(): array
-	{
-		return [
-				'\phpbbgallery\exif\migrations\m1_init',
-		];
-	}
-
-	public function update_schema(): array
-	{
-		return [
-				'change_columns' => [
-					$this->table_prefix . 'gallery_images' => [
-						'image_exif_data' => ['TEXT', null],
-					],
-				],
-		];
-	}
-
-	public function revert_schema(): array
-	{
-		return [
-				'change_columns' => [
-					$this->table_prefix . 'gallery_images' => [
-						'image_exif_data' => ['TEXT', ''],
-					],
-				],
-		];
-	}
-}
diff --git "[FORUM_EXT]/phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_ucp_settings_fieldset.html" "[FORUM_EXT]/phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_ucp_settings_fieldset.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_ucp_settings_fieldset.html"
@@ -0,0 +1,7 @@
+<dl>
+	<dt><label for="viewexifs1">{L_VIEWEXIFS_DEFAULT}{L_COLON}</label></dt>
+	<dd>
+		<label for="viewexifs1"><input type="radio" name="viewexifs" id="viewexifs1" value="1"<!-- IF S_VIEWEXIFS --> checked="checked"<!-- ENDIF --> /> {L_YES}</label> 
+		<label for="viewexifs0"><input type="radio" name="viewexifs" id="viewexifs0" value="0"<!-- IF not S_VIEWEXIFS --> checked="checked"<!-- ENDIF --> /> {L_NO}</label>
+	</dd>
+</dl>
diff --git "[FORUM_EXT]/phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html" "[FORUM_EXT]/phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbbgallery\\exif/styles/FLATBOOTS/template/event/gallery_viewimage_details.html"
@@ -0,0 +1,12 @@
+<!-- IF .exif_value -->
+	<h3 class="anti-postbody">{L_EXIF_DATA}</h3>
+	<br /> <hr />
+	<fieldset class="fields1 anti-postbody" id="exif_data_fieldset">
+	<!-- BEGIN exif_value -->
+		<dl class="<!-- IF exif_value.S_ROW_COUNT is even -->column1<!-- ELSE -->column2<!-- ENDIF -->">
+			<dt><label>{exif_value.EXIF_NAME}{L_COLON}</label></dt>
+			<dd>{exif_value.EXIF_VALUE}</dd>
+		</dl>
+	<!-- END exif_value -->
+	</fieldset>
+<!-- ENDIF -->
```
