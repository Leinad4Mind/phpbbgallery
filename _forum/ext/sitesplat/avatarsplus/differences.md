Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html" "[FORUM_EXT]/sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
--- "[ORIGINAL]/sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
@@ -9,6 +9,6 @@
 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
-	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
 	{% INCLUDEJS '@sitesplat_avatarsplus/js/sitesplat_avatarsplus_onsubmit.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
 {% endif %}
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/avatar/driver/material.php" "[FORUM_EXT]/sitesplat\\avatarsplus/avatar/driver/material.php"
--- "[ORIGINAL]/sitesplat\\avatarsplus/avatar/driver/material.php"
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/avatar/driver/material.php"
@@ -33,20 +33,7 @@ class material extends \phpbb\avatar\driver\driver
 
 		if ($row['avatar'] == 'circle')
 		{
-			// original line, which is WRONG!!!!! It will always display avatar of logged-in user!
-			// I'll bet the original author knew full well this line wouldn't work, but added it
-			// anyway because they figured they would be paid before the issue would be caught!
-//			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
-
-			// fixed line...but other extensions don't always pass a username to this function, so
-			// it will return warnings when a username isn't passed
-//			return '<img data-name="' . $row['username'] . '" class="material_profile"/>';
-
-			// fixes warnings, but will leave blank avatars when a username isn't passed to function
-//			return empty($row['username']) ? '' : '<img data-name="' . $row['username'] . '" class="material_profile"/>';
-
-			// and the final solution...return nothing!
-			return '';
+			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
 		}
 		else
 		{
@@ -81,10 +68,9 @@ class material extends \phpbb\avatar\driver\driver
 		// resolve avatar size
 		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
 
-		// JS-based avatars BREAK PHPBB!!!!!!!!
-//		$filename = '';
-//		if ($shape != 'circle')
-//		{
+		$filename = '';
+		if ($shape != 'circle')
+		{
 			// initialize avatar, make it as big as possible
 			$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
 			// load Arial font
@@ -92,14 +78,14 @@ class material extends \phpbb\avatar\driver\driver
 			// delete old material avatar
 			$this->delete(array('id' => $row['avatar']));
 			// generate new material avatar filename
-			$filename = $row['id'] . '_' . time();
+			$filename = $user->data['user_id'] . '_' . time();
 			// save new material avatar
-			$avatar->makeAvatar(mb_substr($row['username'],0,1))->save($this->get_material_url($filename), 100);
-//		}
-//		else
-//		{
-//			$filename = 'circle';
-//		}
+			$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);
+		}
+		else
+		{
+			$filename = 'circle';
+		}
 		
 
 		// nothing much to store, but we obey interface
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/composer.json" "[FORUM_EXT]/sitesplat\\avatarsplus/composer.json"
--- "[ORIGINAL]/sitesplat\\avatarsplus/composer.json"
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/composer.json"
@@ -2,8 +2,8 @@
     "name": "sitesplat/avatarsplus",
     "type": "phpbb-extension",
     "description": "Adds new super cool avatar drivers to your board.",
-    "homepage": "https://sitesplat.com",
-    "version": "2.0.3",
+    "homepage": "https://www.sitesplat.com",
+    "version": "2.0.1",
     "license": "@license Proprietary",
     "authors": [
         {
@@ -20,7 +20,7 @@
     "extra": {
         "display-name": "Avatars+",
         "soft-require": {
-            "phpbb/phpbb": ">=3.2.4,<3.4.0@dev"
+            "phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
         },
 		"version-check": {
 			"host": "sitesplat.com",
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/diff_full.tmp" "[FORUM_EXT]/sitesplat\\avatarsplus/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/diff_full.tmp"
@@ -0,0 +1,357 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+index 9673444a4..98f4dc864 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+@@ -9,6 +9,6 @@
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
+-	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/sitesplat_avatarsplus_onsubmit.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+index 9123601cb..ae6f7268d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+@@ -33,20 +33,7 @@ class material extends \phpbb\avatar\driver\driver
+ 
+ 		if ($row['avatar'] == 'circle')
+ 		{
+-			// original line, which is WRONG!!!!! It will always display avatar of logged-in user!
+-			// I'll bet the original author knew full well this line wouldn't work, but added it
+-			// anyway because they figured they would be paid before the issue would be caught!
+-//			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
+-
+-			// fixed line...but other extensions don't always pass a username to this function, so
+-			// it will return warnings when a username isn't passed
+-//			return '<img data-name="' . $row['username'] . '" class="material_profile"/>';
+-
+-			// fixes warnings, but will leave blank avatars when a username isn't passed to function
+-//			return empty($row['username']) ? '' : '<img data-name="' . $row['username'] . '" class="material_profile"/>';
+-
+-			// and the final solution...return nothing!
+-			return '';
++			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
+ 		}
+ 		else
+ 		{
+@@ -81,10 +68,9 @@ class material extends \phpbb\avatar\driver\driver
+ 		// resolve avatar size
+ 		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
+ 
+-		// JS-based avatars BREAK PHPBB!!!!!!!!
+-//		$filename = '';
+-//		if ($shape != 'circle')
+-//		{
++		$filename = '';
++		if ($shape != 'circle')
++		{
+ 			// initialize avatar, make it as big as possible
+ 			$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
+ 			// load Arial font
+@@ -92,14 +78,14 @@ class material extends \phpbb\avatar\driver\driver
+ 			// delete old material avatar
+ 			$this->delete(array('id' => $row['avatar']));
+ 			// generate new material avatar filename
+-			$filename = $row['id'] . '_' . time();
++			$filename = $user->data['user_id'] . '_' . time();
+ 			// save new material avatar
+-			$avatar->makeAvatar(mb_substr($row['username'],0,1))->save($this->get_material_url($filename), 100);
+-//		}
+-//		else
+-//		{
+-//			$filename = 'circle';
+-//		}
++			$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);
++		}
++		else
++		{
++			$filename = 'circle';
++		}
+ 		
+ 
+ 		// nothing much to store, but we obey interface
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/composer.json"
+index 738c974e3..8613db271 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/composer.json"
+@@ -2,8 +2,8 @@
+     "name": "sitesplat/avatarsplus",
+     "type": "phpbb-extension",
+     "description": "Adds new super cool avatar drivers to your board.",
+-    "homepage": "https://sitesplat.com",
+-    "version": "2.0.3",
++    "homepage": "https://www.sitesplat.com",
++    "version": "2.0.1",
+     "license": "@license Proprietary",
+     "authors": [
+         {
+@@ -20,7 +20,7 @@
+     "extra": {
+         "display-name": "Avatars+",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.2.4,<3.4.0@dev"
++            "phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
+         },
+ 		"version-check": {
+ 			"host": "sitesplat.com",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp"
+new file mode 100644
+index 000000000..118fa902c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp"
+@@ -0,0 +1,75 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++index 9673444a4..98f4dc864 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++@@ -9,6 +9,6 @@
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
++-	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/sitesplat_avatarsplus_onsubmit.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++index 9123601cb..ae6f7268d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++@@ -33,20 +33,7 @@ class material extends \phpbb\avatar\driver\driver
++ 
++ 		if ($row['avatar'] == 'circle')
++ 		{
++-			// original line, which is WRONG!!!!! It will always display avatar of logged-in user!
++-			// I'll bet the original author knew full well this line wouldn't work, but added it
++-			// anyway because they figured they would be paid before the issue would be caught!
++-//			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
++-
++-			// fixed line...but other extensions don't always pass a username to this function, so
++-			// it will return warnings when a username isn't passed
++-//			return '<img data-name="' . $row['username'] . '" class="material_profile"/>';
++-
++-			// fixes warnings, but will leave blank avatars when a username isn't passed to function
++-//			return empty($row['username']) ? '' : '<img data-name="' . $row['username'] . '" class="material_profile"/>';
++-
++-			// and the final solution...return nothing!
++-			return '';
+++			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
++ 		}
++ 		else
++ 		{
++@@ -81,10 +68,9 @@ class material extends \phpbb\avatar\driver\driver
++ 		// resolve avatar size
++ 		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
++ 
++-		// JS-based avatars BREAK PHPBB!!!!!!!!
++-//		$filename = '';
++-//		if ($shape != 'circle')
++-//		{
+++		$filename = '';
+++		if ($shape != 'circle')
+++		{
++ 			// initialize avatar, make it as big as possible
++ 			$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
++ 			// load Arial font
++@@ -92,14 +78,14 @@ class material extends \phpbb\avatar\driver\driver
++ 			// delete old material avatar
++ 			$this->delete(array('id' => $row['avatar']));
++ 			// generate new material avatar filename
++-			$filename = $row['id'] . '_' . time();
+++			$filename = $user->data['user_id'] . '_' . time();
++ 			// save new material avatar
++-			$avatar->makeAvatar(mb_substr($row['username'],0,1))->save($this->get_material_url($filename), 100);
++-//		}
++-//		else
++-//		{
++-//			$filename = 'circle';
++-//		}
+++			$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);
+++		}
+++		else
+++		{
+++			$filename = 'circle';
+++		}
++ 		
++ 
++ 		// nothing much to store, but we obey interface
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\si
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/ext.php"
+index 5f52cef85..ec8d4d2d8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/ext.php"
+@@ -14,21 +14,18 @@ class ext extends \phpbb\extension\base
+ 	
+ 	public function is_enableable()
+ 	{
+-		if (!class_exists('Imagick', false) && !function_exists('imagefttext')) {
+-			$error = 'PHP Imagick] or [PHP GD Freetype';
+-		}
+-		else if (!function_exists('finfo_open')) {
+-			$error = 'PHP FileInfo';
+-		}
+-		else if (!class_exists('sitesplat\BBCore\event\listener', false)) {
+-			$error = 'BBCore';
++		if (!class_exists('sitesplat\BBCore\helper'))
++		{
++			$this->container->get('user')->add_lang_ext('sitesplat/avatarsplus', 'info_acp_avatarplus');
++			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
+ 		}
+-		else {
+-			return true;
++		
++		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
++		{
++			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
+ 		}
+ 
+-		global $module;
+-		trigger_error($this->container->get('language')->lang('EXTENSION_NOT_INSTALLED', "<strong>[{$error}]</strong>") . adm_back_link($module->module->u_action), E_USER_WARNING);
++		return class_exists('sitesplat\BBCore\helper');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
+index 22bbae781..be3e67557 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
+@@ -20,7 +20,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	'ACP_BBAVATARPLUS'				=> 'BBavatar+',
+ 	'UCP_UCP'				        => 'User Control Panel',
+-	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+ 	'BBAVATARPLUS_NOTICE'	        => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong> then select the driver <strong>"Material Avatar"</strong> or <strong>"Avatar Generator"</strong>.<br />For best result it is strongly recommended to increase the avatar max size to 400x400 in <strong>ACP > Avatar settings > Maximum avatar dimensions</strong>. </p></div>',
+ ));
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+similarity index 91%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+index c4a9409e2..7b564f9a0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -12,4 +12,4 @@
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+ {% endif %}
+ 
+-{#% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %#}
++{% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
+new file mode 100644
+index 000000000..2d407144d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
+@@ -0,0 +1,5 @@
++<script>
++head.ready(function(){
++	$('.material_profile').initial();
++})
++</script>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..7b564f9a0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -0,0 +1,15 @@
++{% if S_IN_AVATAR_GENERATOR %}
++	{% INCLUDECSS '@sitesplat_avatarsplus/spectrum.css' %}
++	{% INCLUDECSS '@sitesplat_avatarsplus/svgavatars.css' %}
++
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svg.min.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/spectrum.min.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/jquery.scrollbar.min.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/rgbcolor.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
++{% endif %}
++
++{% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png"
+new file mode 100644
+index 000000000..5572736ad
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png"
+new file mode 100644
+index 000000000..5572736ad
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png"
+new file mode 100644
+index 000000000..b27c5aae0
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png"
+new file mode 100644
+index 000000000..69b75ae1f
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png"
+new file mode 100644
+index 000000000..b27c5aae0
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png"
+new file mode 100644
+index 000000000..fb40de724
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png"
+new file mode 100644
+index 000000000..909f43a4c
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png"
+new file mode 100644
+index 000000000..16a84a0be
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png"
+new file mode 100644
+index 000000000..5bfa58350
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png"
+new file mode 100644
+index 000000000..35e5afc09
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png"
+new file mode 100644
+index 000000000..5572736ad
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png"
+new file mode 100644
+index 000000000..b5bb837c8
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png"
+new file mode 100644
+index 000000000..7df84b7c2
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png"
+new file mode 100644
+index 000000000..69b75ae1f
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4459908608943346.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4459908608943346.png"
+new file mode 100644
+index 000000000..bd2bea644
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4459908608943346.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4705548881004533.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4705548881004533.png"
+new file mode 100644
+index 000000000..edb93fc40
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4705548881004533.png" differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/temp-avatars/svgA5886633746650238.png" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/temp-avatars/svgA5886633746650238.png"
+deleted file mode 100644
+index ee4c61bcf..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/temp-avatars/svgA5886633746650238.png" and /dev/null differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA7603019130672131.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA7603019130672131.png"
+new file mode 100644
+index 000000000..16a84a0be
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA7603019130672131.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA8233381431797904.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA8233381431797904.png"
+new file mode 100644
+index 000000000..fb40de724
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA8233381431797904.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9115831150597877.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9115831150597877.png"
+new file mode 100644
+index 000000000..1316f94f1
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9115831150597877.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9358714383769526.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9358714383769526.png"
+new file mode 100644
+index 000000000..b27c5aae0
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9358714383769526.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\avatarsplus/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/diff_nospace.tmp"
@@ -0,0 +1,433 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+index 9673444a4..98f4dc864 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+@@ -9,6 +9,6 @@
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
+-	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/sitesplat_avatarsplus_onsubmit.js' %}
++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+index 9123601cb..ae6f7268d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+@@ -33,20 +33,7 @@ class material extends \phpbb\avatar\driver\driver
+ 
+ 		if ($row['avatar'] == 'circle')
+ 		{
+-			// original line, which is WRONG!!!!! It will always display avatar of logged-in user!
+-			// I'll bet the original author knew full well this line wouldn't work, but added it
+-			// anyway because they figured they would be paid before the issue would be caught!
+-//			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
+-
+-			// fixed line...but other extensions don't always pass a username to this function, so
+-			// it will return warnings when a username isn't passed
+-//			return '<img data-name="' . $row['username'] . '" class="material_profile"/>';
+-
+-			// fixes warnings, but will leave blank avatars when a username isn't passed to function
+-//			return empty($row['username']) ? '' : '<img data-name="' . $row['username'] . '" class="material_profile"/>';
+-
+-			// and the final solution...return nothing!
+-			return '';
++			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
+ 		}
+ 		else
+ 		{
+@@ -81,10 +68,9 @@ class material extends \phpbb\avatar\driver\driver
+ 		// resolve avatar size
+ 		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
+ 
+-		// JS-based avatars BREAK PHPBB!!!!!!!!
+-//		$filename = '';
+-//		if ($shape != 'circle')
+-//		{
++		$filename = '';
++		if ($shape != 'circle')
++		{
+ 			// initialize avatar, make it as big as possible
+ 			$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
+ 			// load Arial font
+@@ -92,14 +78,14 @@ class material extends \phpbb\avatar\driver\driver
+ 			// delete old material avatar
+ 			$this->delete(array('id' => $row['avatar']));
+ 			// generate new material avatar filename
+-			$filename = $row['id'] . '_' . time();
++			$filename = $user->data['user_id'] . '_' . time();
+ 			// save new material avatar
+-			$avatar->makeAvatar(mb_substr($row['username'],0,1))->save($this->get_material_url($filename), 100);
+-//		}
+-//		else
+-//		{
+-//			$filename = 'circle';
+-//		}
++			$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);
++		}
++		else
++		{
++			$filename = 'circle';
++		}
+ 		
+ 
+ 		// nothing much to store, but we obey interface
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/composer.json"
+index 738c974e3..8613db271 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/composer.json"
+@@ -2,8 +2,8 @@
+     "name": "sitesplat/avatarsplus",
+     "type": "phpbb-extension",
+     "description": "Adds new super cool avatar drivers to your board.",
+-    "homepage": "https://sitesplat.com",
+-    "version": "2.0.3",
++    "homepage": "https://www.sitesplat.com",
++    "version": "2.0.1",
+     "license": "@license Proprietary",
+     "authors": [
+         {
+@@ -20,7 +20,7 @@
+     "extra": {
+         "display-name": "Avatars+",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.2.4,<3.4.0@dev"
++            "phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
+         },
+ 		"version-check": {
+ 			"host": "sitesplat.com",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp"
+new file mode 100644
+index 000000000..32b788348
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp"
+@@ -0,0 +1,357 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++index 9673444a4..98f4dc864 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++@@ -9,6 +9,6 @@
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
++-	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/sitesplat_avatarsplus_onsubmit.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++index 9123601cb..ae6f7268d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++@@ -33,20 +33,7 @@ class material extends \phpbb\avatar\driver\driver
++ 
++ 		if ($row['avatar'] == 'circle')
++ 		{
++-			// original line, which is WRONG!!!!! It will always display avatar of logged-in user!
++-			// I'll bet the original author knew full well this line wouldn't work, but added it
++-			// anyway because they figured they would be paid before the issue would be caught!
++-//			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
++-
++-			// fixed line...but other extensions don't always pass a username to this function, so
++-			// it will return warnings when a username isn't passed
++-//			return '<img data-name="' . $row['username'] . '" class="material_profile"/>';
++-
++-			// fixes warnings, but will leave blank avatars when a username isn't passed to function
++-//			return empty($row['username']) ? '' : '<img data-name="' . $row['username'] . '" class="material_profile"/>';
++-
++-			// and the final solution...return nothing!
++-			return '';
+++			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
++ 		}
++ 		else
++ 		{
++@@ -81,10 +68,9 @@ class material extends \phpbb\avatar\driver\driver
++ 		// resolve avatar size
++ 		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
++ 
++-		// JS-based avatars BREAK PHPBB!!!!!!!!
++-//		$filename = '';
++-//		if ($shape != 'circle')
++-//		{
+++		$filename = '';
+++		if ($shape != 'circle')
+++		{
++ 			// initialize avatar, make it as big as possible
++ 			$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
++ 			// load Arial font
++@@ -92,14 +78,14 @@ class material extends \phpbb\avatar\driver\driver
++ 			// delete old material avatar
++ 			$this->delete(array('id' => $row['avatar']));
++ 			// generate new material avatar filename
++-			$filename = $row['id'] . '_' . time();
+++			$filename = $user->data['user_id'] . '_' . time();
++ 			// save new material avatar
++-			$avatar->makeAvatar(mb_substr($row['username'],0,1))->save($this->get_material_url($filename), 100);
++-//		}
++-//		else
++-//		{
++-//			$filename = 'circle';
++-//		}
+++			$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);
+++		}
+++		else
+++		{
+++			$filename = 'circle';
+++		}
++ 		
++ 
++ 		// nothing much to store, but we obey interface
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/composer.json"
++index 738c974e3..8613db271 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/composer.json"
++@@ -2,8 +2,8 @@
++     "name": "sitesplat/avatarsplus",
++     "type": "phpbb-extension",
++     "description": "Adds new super cool avatar drivers to your board.",
++-    "homepage": "https://sitesplat.com",
++-    "version": "2.0.3",
+++    "homepage": "https://www.sitesplat.com",
+++    "version": "2.0.1",
++     "license": "@license Proprietary",
++     "authors": [
++         {
++@@ -20,7 +20,7 @@
++     "extra": {
++         "display-name": "Avatars+",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.2.4,<3.4.0@dev"
+++            "phpbb/phpbb": ">=3.1.0,<3.3.0@dev"
++         },
++ 		"version-check": {
++ 			"host": "sitesplat.com",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp"
++new file mode 100644
++index 000000000..118fa902c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/diff_full.tmp"
++@@ -0,0 +1,75 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+++index 9673444a4..98f4dc864 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/adm/style/event/acp_overall_header_head_append.html"
+++@@ -9,6 +9,6 @@
+++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
+++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
+++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
+++-	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/sitesplat_avatarsplus_onsubmit.js' %}
++++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+++ {% endif %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+++index 9123601cb..ae6f7268d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/avatar/driver/material.php"
+++@@ -33,20 +33,7 @@ class material extends \phpbb\avatar\driver\driver
+++ 
+++ 		if ($row['avatar'] == 'circle')
+++ 		{
+++-			// original line, which is WRONG!!!!! It will always display avatar of logged-in user!
+++-			// I'll bet the original author knew full well this line wouldn't work, but added it
+++-			// anyway because they figured they would be paid before the issue would be caught!
+++-//			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
+++-
+++-			// fixed line...but other extensions don't always pass a username to this function, so
+++-			// it will return warnings when a username isn't passed
+++-//			return '<img data-name="' . $row['username'] . '" class="material_profile"/>';
+++-
+++-			// fixes warnings, but will leave blank avatars when a username isn't passed to function
+++-//			return empty($row['username']) ? '' : '<img data-name="' . $row['username'] . '" class="material_profile"/>';
+++-
+++-			// and the final solution...return nothing!
+++-			return '';
++++			return '<img data-name="' . $user->data['username'] . '" class="material_profile"/>';
+++ 		}
+++ 		else
+++ 		{
+++@@ -81,10 +68,9 @@ class material extends \phpbb\avatar\driver\driver
+++ 		// resolve avatar size
+++ 		$size = min($this->config['avatar_max_width'], $this->config['avatar_max_height']);
+++ 
+++-		// JS-based avatars BREAK PHPBB!!!!!!!!
+++-//		$filename = '';
+++-//		if ($shape != 'circle')
+++-//		{
++++		$filename = '';
++++		if ($shape != 'circle')
++++		{
+++ 			// initialize avatar, make it as big as possible
+++ 			$avatar = AvatarFactory::createAvatarMaker($shape, $size, class_exists('Imagick') ? 'imagick' : 'gd');
+++ 			// load Arial font
+++@@ -92,14 +78,14 @@ class material extends \phpbb\avatar\driver\driver
+++ 			// delete old material avatar
+++ 			$this->delete(array('id' => $row['avatar']));
+++ 			// generate new material avatar filename
+++-			$filename = $row['id'] . '_' . time();
++++			$filename = $user->data['user_id'] . '_' . time();
+++ 			// save new material avatar
+++-			$avatar->makeAvatar(mb_substr($row['username'],0,1))->save($this->get_material_url($filename), 100);
+++-//		}
+++-//		else
+++-//		{
+++-//			$filename = 'circle';
+++-//		}
++++			$avatar->makeAvatar($user->data['username'])->save($this->get_material_url($filename), 100);
++++		}
++++		else
++++		{
++++			$filename = 'circle';
++++		}
+++ 		
+++ 
+++ 		// nothing much to store, but we obey interface
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\si
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/ext.php"
++index 5f52cef85..ec8d4d2d8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/ext.php"
++@@ -14,21 +14,18 @@ class ext extends \phpbb\extension\base
++ 	
++ 	public function is_enableable()
++ 	{
++-		if (!class_exists('Imagick', false) && !function_exists('imagefttext')) {
++-			$error = 'PHP Imagick] or [PHP GD Freetype';
++-		}
++-		else if (!function_exists('finfo_open')) {
++-			$error = 'PHP FileInfo';
++-		}
++-		else if (!class_exists('sitesplat\BBCore\event\listener', false)) {
++-			$error = 'BBCore';
+++		if (!class_exists('sitesplat\BBCore\helper'))
+++		{
+++			$this->container->get('user')->add_lang_ext('sitesplat/avatarsplus', 'info_acp_avatarplus');
+++			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
++ 		}
++-		else {
++-			return true;
+++		
+++		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
+++		{
+++			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
++ 		}
++ 
++-		global $module;
++-		trigger_error($this->container->get('language')->lang('EXTENSION_NOT_INSTALLED', "<strong>[{$error}]</strong>") . adm_back_link($module->module->u_action), E_USER_WARNING);
+++		return class_exists('sitesplat\BBCore\helper');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
++index 22bbae781..be3e67557 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
++@@ -20,7 +20,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	'ACP_BBAVATARPLUS'				=> 'BBavatar+',
++ 	'UCP_UCP'				        => 'User Control Panel',
++-	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++ 	'BBAVATARPLUS_NOTICE'	        => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong> then select the driver <strong>"Material Avatar"</strong> or <strong>"Avatar Generator"</strong>.<br />For best result it is strongly recommended to increase the avatar max size to 400x400 in <strong>ACP > Avatar settings > Maximum avatar dimensions</strong>. </p></div>',
++ ));
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++similarity index 91%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++index c4a9409e2..7b564f9a0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -12,4 +12,4 @@
++ 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
++ {% endif %}
++ 
++-{#% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %#}
+++{% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
++new file mode 100644
++index 000000000..2d407144d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
++@@ -0,0 +1,5 @@
+++<script>
+++head.ready(function(){
+++	$('.material_profile').initial();
+++})
+++</script>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..7b564f9a0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -0,0 +1,15 @@
+++{% if S_IN_AVATAR_GENERATOR %}
+++	{% INCLUDECSS '@sitesplat_avatarsplus/spectrum.css' %}
+++	{% INCLUDECSS '@sitesplat_avatarsplus/svgavatars.css' %}
+++
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svg.min.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/spectrum.min.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/jquery.scrollbar.min.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/rgbcolor.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
+++	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+++{% endif %}
+++
+++{% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png"
++new file mode 100644
++index 000000000..5572736ad
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png"
++new file mode 100644
++index 000000000..5572736ad
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png"
++new file mode 100644
++index 000000000..b27c5aae0
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png"
++new file mode 100644
++index 000000000..69b75ae1f
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png"
++new file mode 100644
++index 000000000..b27c5aae0
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png"
++new file mode 100644
++index 000000000..fb40de724
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png"
++new file mode 100644
++index 000000000..909f43a4c
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png"
++new file mode 100644
++index 000000000..16a84a0be
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png"
++new file mode 100644
++index 000000000..5bfa58350
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png"
++new file mode 100644
++index 000000000..35e5afc09
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png"
++new file mode 100644
++index 000000000..5572736ad
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png"
++new file mode 100644
++index 000000000..b5bb837c8
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png"
++new file mode 100644
++index 000000000..7df84b7c2
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png"
++new file mode 100644
++index 000000000..69b75ae1f
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_foru
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/ext.php" "[FORUM_EXT]/sitesplat\\avatarsplus/ext.php"
--- "[ORIGINAL]/sitesplat\\avatarsplus/ext.php"
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/ext.php"
@@ -14,21 +14,18 @@ class ext extends \phpbb\extension\base
 	
 	public function is_enableable()
 	{
-		if (!class_exists('Imagick', false) && !function_exists('imagefttext')) {
-			$error = 'PHP Imagick] or [PHP GD Freetype';
-		}
-		else if (!function_exists('finfo_open')) {
-			$error = 'PHP FileInfo';
-		}
-		else if (!class_exists('sitesplat\BBCore\event\listener', false)) {
-			$error = 'BBCore';
+		if (!class_exists('sitesplat\BBCore\helper'))
+		{
+			$this->container->get('user')->add_lang_ext('sitesplat/avatarsplus', 'info_acp_avatarplus');
+			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
 		}
-		else {
-			return true;
+		
+		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
+		{
+			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
 		}
 
-		global $module;
-		trigger_error($this->container->get('language')->lang('EXTENSION_NOT_INSTALLED', "<strong>[{$error}]</strong>") . adm_back_link($module->module->u_action), E_USER_WARNING);
+		return class_exists('sitesplat\BBCore\helper');
 	}
 
 	/**
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php" "[FORUM_EXT]/sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
--- "[ORIGINAL]/sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/language/en/info_acp_avatarplus.php"
@@ -20,7 +20,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	'ACP_BBAVATARPLUS'				=> 'BBavatar+',
 	'UCP_UCP'				        => 'User Control Panel',
-	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
 	'BBAVATARPLUS_NOTICE'	        => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong> then select the driver <strong>"Material Avatar"</strong> or <strong>"Avatar Generator"</strong>.<br />For best result it is strongly recommended to increase the avatar max size to 400x400 in <strong>ACP > Avatar settings > Maximum avatar dimensions</strong>. </p></div>',
 ));
 
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
similarity index 91%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
--- "[ORIGINAL]/sitesplat\\avatarsplus/styles/all/template/event/overall_header_stylesheets_after.html"
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -12,4 +12,4 @@
 	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
 {% endif %}
 
-{#% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %#}
+{% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %}
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "[FORUM_EXT]/sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
@@ -0,0 +1,5 @@
+<script>
+head.ready(function(){
+	$('.material_profile').initial();
+})
+</script>
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\avatarsplus/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -0,0 +1,15 @@
+{% if S_IN_AVATAR_GENERATOR %}
+	{% INCLUDECSS '@sitesplat_avatarsplus/spectrum.css' %}
+	{% INCLUDECSS '@sitesplat_avatarsplus/svgavatars.css' %}
+
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/svg.min.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/spectrum.min.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/jquery.scrollbar.min.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/rgbcolor.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/StackBlur.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/canvg/canvg.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.en.js' %}
+	{% INCLUDEJS '@sitesplat_avatarsplus/js/svgavatars.core.min.js' %}
+{% endif %}
+
+{% INCLUDEJS '@sitesplat_avatarsplus/js/initial.min.js' %}
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/1a5556c6cb54.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/533535fdda73.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/533535fdda73.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/533535fdda73.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/645b52e58c91.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/76489d4f5673.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/c6781f4b9ea9.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/cf060cdfe3c6.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA05960651202098699.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA18900645655107207.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2572056560187277.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA27275585690002146.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA2953721071814308.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA3797974796914769.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4233692293879825.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4329974830412646.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4459908608943346.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4459908608943346.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4459908608943346.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4705548881004533.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA4705548881004533.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA4705548881004533.png" differ
diff --git "[ORIGINAL]/sitesplat\\avatarsplus/temp-avatars/svgA5886633746650238.png" "[ORIGINAL]/sitesplat\\avatarsplus/temp-avatars/svgA5886633746650238.png"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\avatarsplus/temp-avatars/svgA5886633746650238.png" and /dev/null differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA7603019130672131.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA7603019130672131.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA7603019130672131.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA8233381431797904.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA8233381431797904.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA8233381431797904.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA9115831150597877.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA9115831150597877.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9115831150597877.png" differ
diff --git "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA9358714383769526.png" "[FORUM_EXT]/sitesplat\\avatarsplus/temp-avatars/svgA9358714383769526.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\avatarsplus/temp-avatars/svgA9358714383769526.png" differ
```
