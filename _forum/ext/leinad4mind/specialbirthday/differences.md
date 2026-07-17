Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_info.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_module.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/adm/style/specialbirthday.html" "[FORUM_EXT]/leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
@@ -21,16 +21,6 @@
 			</dd>
 		</dl>
 
-		<dl>
-			<dt><label for="registration_age_datepicker">{{ lang('REGISTRATION_AGE_DATEPICKER') }}{{ lang('COLON') }}</label></dt>
-			<dd>
-				<input type="radio" id="registration_age_datepicker1" name="registration_age_datepicker" value="1"{% if REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
-				<label class="set" for="registration_age_datepicker1">{{ lang('YES') }}</label>
-				<input type="radio" id="registration_age_datepicker0" name="registration_age_datepicker" value="0"{% if not REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
-				<label class="unset" for="registration_age_datepicker0">{{ lang('NO') }}</label>
-			</dd>
-		</dl>
-
 		<dl>
 			<dt><label for="registration_age_required">{{ lang('REGISTRATION_AGE_REQUIRED') }}{{ lang('COLON') }}</label></dt>
 			<dd>
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/composer.json" "[FORUM_EXT]/leinad4mind\\specialbirthday/composer.json"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/composer.json"
@@ -1,10 +1,10 @@
 {
     "name": "leinad4mind/specialbirthday",
     "type": "phpbb-extension",
-    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birth-date upon registration, checks if the date is equal or greater than a minimum age and much much more...",
-    "version": "1.1.1",
-    "time": "2020-05-07",
-    "keywords": [ "phpbb", "extension", "age", "special", "birthday", "registration"],
+    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birthdate upon registration, checks if the date is equal or greater than a minimum age and much much more...",
+    "version": "1.0.1",
+    "time": "2020-02-29",
+    "keywords": [ "phpbb", "extension", "age", "special", "birthdate", "registration"],
     "license": "GPL-2.0",
     "authors": [
         {
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/controller/admin_controller.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/admin_controller.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/controller/admin_controller.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/admin_controller.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
@@ -137,7 +138,6 @@ class admin_controller implements admin_interface
 			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
 			'REGISTRATION_AGE_REQUIRED'		=> isset($this->config['registration_age_required']) ? $this->config['registration_age_required'] : '',
 			'REGISTRATION_AGE_REG_DISPLAY'	=> isset($this->config['registration_age_reg_display']) ? $this->config['registration_age_reg_display'] : '',
-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
 			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
 			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
 			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
@@ -163,7 +163,6 @@ class admin_controller implements admin_interface
 		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
 		$this->config->set('registration_age_required', $this->request->variable('registration_age_required', 0));
 		$this->config->set('registration_age_reg_display', $this->request->variable('registration_age_reg_display', 0));
-		$this->config->set('registration_age_datepicker', $this->request->variable('registration_age_datepicker', 0));
 		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
 		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
 		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', '', true));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/controller/admin_interface.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/admin_interface.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/controller/admin_interface.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/admin_interface.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/controller/data_controller.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/data_controller.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/controller/data_controller.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/data_controller.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
@@ -85,7 +86,7 @@ class data_controller implements data_interface
 	public function display_output()
 	{
 		// Add the language file
-		$this->language->add_lang('acp_data_registrationage', $this->functions->get_ext_namespace());
+		$this->language->add_lang('acp_data_specialbirthday', $this->functions->get_ext_namespace());
 
 		// Start initial var setup
 		$action			= $this->request->variable('action', '');
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/controller/data_interface.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/data_interface.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/controller/data_interface.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/controller/data_interface.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/core/friends.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/core/friends.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/core/friends.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/core/friends.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/core/functions.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/core/functions.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/core/functions.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/core/functions.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\specialbirthday/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/diff_full.tmp"
@@ -0,0 +1,3351 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+index 5f2a6c69d..e55c0c1c0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+index 3c65b6b71..42eef6cad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+index 86676c1c5..ab33d67f0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+index d19a417d9..2976f7ce1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -25,4 +26,4 @@ class specialbirthday_module
+ 
+ 		$admin_controller->display_options();
+ 	}
+-}
+\ No newline at end of file
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+index 5967d6fd5..8ce2b3d4a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+@@ -21,16 +21,6 @@
+ 			</dd>
+ 		</dl>
+ 
+-		<dl>
+-			<dt><label for="registration_age_datepicker">{{ lang('REGISTRATION_AGE_DATEPICKER') }}{{ lang('COLON') }}</label></dt>
+-			<dd>
+-				<input type="radio" id="registration_age_datepicker1" name="registration_age_datepicker" value="1"{% if REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
+-				<label class="set" for="registration_age_datepicker1">{{ lang('YES') }}</label>
+-				<input type="radio" id="registration_age_datepicker0" name="registration_age_datepicker" value="0"{% if not REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
+-				<label class="unset" for="registration_age_datepicker0">{{ lang('NO') }}</label>
+-			</dd>
+-		</dl>
+-
+ 		<dl>
+ 			<dt><label for="registration_age_required">{{ lang('REGISTRATION_AGE_REQUIRED') }}{{ lang('COLON') }}</label></dt>
+ 			<dd>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
+index 4bb9d2ecb..cabfeefa2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
+@@ -1,10 +1,10 @@
+ {
+     "name": "leinad4mind/specialbirthday",
+     "type": "phpbb-extension",
+-    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birth-date upon registration, checks if the date is equal or greater than a minimum age and much much more...",
+-    "version": "1.1.1",
+-    "time": "2020-05-07",
+-    "keywords": [ "phpbb", "extension", "age", "special", "birthday", "registration"],
++    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birthdate upon registration, checks if the date is equal or greater than a minimum age and much much more...",
++    "version": "1.0.1",
++    "time": "2020-02-29",
++    "keywords": [ "phpbb", "extension", "age", "special", "birthdate", "registration"],
+     "license": "GPL-2.0",
+     "authors": [
+         {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+index f6fe8f236..64ab12411 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -137,7 +138,6 @@ class admin_controller implements admin_interface
+ 			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
+ 			'REGISTRATION_AGE_REQUIRED'		=> isset($this->config['registration_age_required']) ? $this->config['registration_age_required'] : '',
+ 			'REGISTRATION_AGE_REG_DISPLAY'	=> isset($this->config['registration_age_reg_display']) ? $this->config['registration_age_reg_display'] : '',
+-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
+ 			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
+ 			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
+ 			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
+@@ -163,7 +163,6 @@ class admin_controller implements admin_interface
+ 		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
+ 		$this->config->set('registration_age_required', $this->request->variable('registration_age_required', 0));
+ 		$this->config->set('registration_age_reg_display', $this->request->variable('registration_age_reg_display', 0));
+-		$this->config->set('registration_age_datepicker', $this->request->variable('registration_age_datepicker', 0));
+ 		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
+ 		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
+ 		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', '', true));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
+index d3e06e8fe..6ffc325b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
+index 4b180eb0f..12c109907 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -85,7 +86,7 @@ class data_controller implements data_interface
+ 	public function display_output()
+ 	{
+ 		// Add the language file
+-		$this->language->add_lang('acp_data_registrationage', $this->functions->get_ext_namespace());
++		$this->language->add_lang('acp_data_specialbirthday', $this->functions->get_ext_namespace());
+ 
+ 		// Start initial var setup
+ 		$action			= $this->request->variable('action', '');
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
+index 2e8beaa48..b61166cb1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/friends.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/friends.php"
+index 7683909a4..f55f0d1f4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/friends.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/friends.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/functions.php"
+index 2d957b2ec..f1f1f060b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/functions.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/functions.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp"
+new file mode 100644
+index 000000000..11efd0251
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp"
+@@ -0,0 +1,116 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++index 5f2a6c69d..e55c0c1c0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++index 3c65b6b71..42eef6cad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++index 86676c1c5..ab33d67f0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++index d19a417d9..2976f7ce1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -25,4 +26,4 @@ class specialbirthday_module
++ 
++ 		$admin_controller->display_options();
++ 	}
++-}
++\ No newline at end of file
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++index 5967d6fd5..8ce2b3d4a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++@@ -21,16 +21,6 @@
++ 			</dd>
++ 		</dl>
++ 
++-		<dl>
++-			<dt><label for="registration_age_datepicker">{{ lang('REGISTRATION_AGE_DATEPICKER') }}{{ lang('COLON') }}</label></dt>
++-			<dd>
++-				<input type="radio" id="registration_age_datepicker1" name="registration_age_datepicker" value="1"{% if REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
++-				<label class="set" for="registration_age_datepicker1">{{ lang('YES') }}</label>
++-				<input type="radio" id="registration_age_datepicker0" name="registration_age_datepicker" value="0"{% if not REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
++-				<label class="unset" for="registration_age_datepicker0">{{ lang('NO') }}</label>
++-			</dd>
++-		</dl>
++-
++ 		<dl>
++ 			<dt><label for="registration_age_required">{{ lang('REGISTRATION_AGE_REQUIRED') }}{{ lang('COLON') }}</label></dt>
++ 			<dd>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
++index 4bb9d2ecb..cabfeefa2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
++@@ -1,10 +1,10 @@
++ {
++     "name": "leinad4mind/specialbirthday",
++     "type": "phpbb-extension",
++-    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birth-date upon registration, checks if the date is equal or greater than a minimum age and much much more...",
++-    "version": "1.1.1",
++-    "time": "2020-05-07",
++-    "keywords": [ "phpbb", "extension", "age", "special", "birthday", "registration"],
+++    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birthdate upon registration, checks if the date is equal or greater than a minimum age and much much more...",
+++    "version": "1.0.1",
+++    "time": "2020-02-29",
+++    "keywords": [ "phpbb", "extension", "age", "special", "birthdate", "registration"],
++     "license": "GPL-2.0",
++     "authors": [
++         {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++index f6fe8f236..64ab12411 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -137,7 +138,6 @@ class admin_controller implements admin_interface
++ 			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
++ 			'REGISTRATION_AGE_REQUIRED'		=> isset($this->config['registration_age_required']) ? $this->config['registration_age_required'] : '',
++ 			'REGISTRATION_AGE_REG_DISPLAY'	=> isset($this->config['registration_age_reg_display']) ? $this->config['registration_age_reg_display'] : '',
++-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
++ 			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
++ 			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
++ 			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
++@@ -163,7 +163,6 @@ class admin_controller implements admin_interface
++ 		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
++ 		$this->config->set('registration_age_required', $this->request->variable('registration_age_required', 0));
++ 		$this->config->set('registration_age_reg_display', $this->request->variable('registration_age_reg_display', 0));
++-		$this->config->set('registration_age_datepicker', $this->request->variable('registration_age_datepicker', 0));
++ 		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
++ 		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
++ 		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', '', true));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
++index d3e06e8fe..6ffc325b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/event/listener.php"
+index e48014bd7..afa552411 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/event/listener.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -131,7 +132,6 @@ class listener implements EventSubscriberInterface
+ 		$this->template->assign_vars([
+ 			'REGISTRATION_AGE_REQUIRED'		=> $this->config['registration_age_required'],
+ 			'REGISTRATION_AGE_REG_DISPLAY'	=> $this->config['registration_age_reg_display'],
+-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
+ 			'REGISTRATION_AGE_DAY'			=> $today->format('d'),
+ 			'REGISTRATION_AGE_MONTH'		=> $today->format('m'),
+ 			'REGISTRATION_AGE_YEAR'			=> $today->format('Y'),
+@@ -139,45 +139,11 @@ class listener implements EventSubscriberInterface
+ 			'YEAR_END' 						=> $today->format('Y'),
+ 		]);
+ 
+-		$data = [
+-			'registration_age_day'		=> $this->request->variable('registration_age_day', 0),
+-			'registration_age_month'	=> $this->request->variable('registration_age_month', 0),
+-			'registration_age_year'		=> $this->request->variable('registration_age_year', 0),
+-		];
+-
+-		if (!$this->config['registration_age_datepicker'])
+-		{
+-			$s_birthday_day_options = '<option value="0"' . ((!$data['registration_age_day']) ? ' selected="selected"' : '') . '>--</option>';
+-			for ($i = 1; $i < 32; $i++)
+-			{
+-				$selected = ($i == $data['registration_age_day']) ? ' selected="selected"' : '';
+-				$s_birthday_day_options .= "<option value=\"$i\"$selected>$i</option>";
+-			}
+-
+-			$s_birthday_month_options = '<option value="0"' . ((!$data['registration_age_month']) ? ' selected="selected"' : '') . '>--</option>';
+-			for ($i = 1; $i < 13; $i++)
+-			{
+-				$selected = ($i == $data['registration_age_month']) ? ' selected="selected"' : '';
+-				$s_birthday_month_options .= "<option value=\"$i\"$selected>$i</option>";
+-			}
+-
+-			$now = getdate();
+-			$s_birthday_year_options = '<option value="0"' . ((!$data['registration_age_year']) ? ' selected="selected"' : '') . '>--</option>';
+-			for ($i = $now['year'] - 100; $i <= $now['year']; $i++)
+-			{
+-				$selected = ($i == $data['registration_age_year']) ? ' selected="selected"' : '';
+-				$s_birthday_year_options .= "<option value=\"$i\"$selected>$i</option>";
+-			}
+-			unset($now);
+-
+-			$this->template->assign_vars([
+-				'S_BIRTHDAY_DAY_OPTIONS'	=> $s_birthday_day_options,
+-				'S_BIRTHDAY_MONTH_OPTIONS'	=> $s_birthday_month_options,
+-				'S_BIRTHDAY_YEAR_OPTIONS'	=> $s_birthday_year_options,
+-			]);
+-		}
+-
+-		$event['data'] = array_merge($event['data'], $data);
++		$event['data'] = array_merge($event['data'], [
++			'registration_age_day'		=> $this->request->variable('registration_age_day', ''),
++			'registration_age_month'	=> $this->request->variable('registration_age_month', ''),
++			'registration_age_year'		=> $this->request->variable('registration_age_year', ''),
++		]);
+ 	}
+ 
+ 	/**
+@@ -202,11 +168,7 @@ class listener implements EventSubscriberInterface
+ 		if ($this->config['registration_age_reg_display'])
+ 		{
+ 			// Make sure that there is valid birthdate date entered in all fields before going any further
+-			if (
+-				!is_numeric($data['registration_age_day']) || !$data['registration_age_day'] ||
+-				!is_numeric($data['registration_age_month']) || !$data['registration_age_month'] ||
+-				!is_numeric($data['registration_age_year']) || !$data['registration_age_year']
+-			)
++			if (!is_numeric($data['registration_age_day']) || !is_numeric($data['registration_age_month']) || !is_numeric($data['registration_age_year']))
+ 			{
+ 				if ($this->config['registration_age_required'])
+ 				{
+@@ -232,7 +194,7 @@ class listener implements EventSubscriberInterface
+ 						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_LOG_FAIL', time(), array($data['username'], $user_age));
+ 					}
+ 
+-					if ($this->config['registration_age_ip'])
++					if ($this->config['registration_age_ip'] && count($error) === 0)
+ 					{
+ 						user_ban('ip', $this->user->ip, $this->config['registration_age_ban_length'], '', 0, $this->language->lang('BAN_REASON'), $this->config['registration_age_ban_reason']);
+ 						$this->user->check_ban(false, $this->user->ip);
+@@ -336,7 +298,7 @@ class listener implements EventSubscriberInterface
+ 	{
+ 		if ($this->is_valid_birthday($this->user->data['user_birthday']))
+ 		{
+-			if ($this->user->data['user_birthday'] != $event['data']['user_birthday'])
++			if ( strtotime(str_replace(' ', '', $this->user->data['user_birthday'])) != strtotime(str_replace(' ', '', $event['data']['user_birthday'])) )
+ 			{
+ 				if ($this->config['registration_age_change'])
+ 				{
+@@ -488,7 +450,7 @@ class listener implements EventSubscriberInterface
+ 	{
+ 		if (!$birthday)
+ 		{
+-			return true;
++			return false;
+ 		}
+ 
+ 		list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthday));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/ext.php"
+index 23a564bb3..49babfaf0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/ext.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
+index 7a2fecb1d..347c6a37d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
+index 2b343f402..6992518bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -52,12 +53,11 @@ $lang = array_merge($lang, array(
+ 	'REGISTRATION_AGE_EXPLAIN'				=> 'Select the age at which you want to limit access.',
+ 	'REGISTRATION_AGE_REQUIRED'				=> 'Users are required to enter their birthday',
+ 	'REGISTRATION_AGE_REG_DISPLAY'			=> 'Display birthday field on registration',
+-	'REGISTRATION_AGE_DATEPICKER'			=> 'Use datepicker instead of select elements to pick the date when registering',
+ 	'REGISTRATION_AGE_IP'					=> 'Block IP',
+ 	'REGISTRATION_AGE_IP_EXPLAIN'			=> 'Ban the IP address for the user attempting to register under age.',
+ 	'REGISTRATION_AGE_LOG'					=> 'Log failed attempts',
+ 	'REGISTRATION_AGE_LOG_EXPLAIN'			=> 'Create a log entry for any attempted registrations that fail due to an incorrect age being entered.',
+-	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthday options',
++	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthdate options',
+ 
+ 	'BAN_END_TEXT' => array(
+ 		'0' 	=> 'Permanent',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
+index 50b9e1f2c..0478370bd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
+index 83fd11794..325aaeb8b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -39,10 +40,10 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, array(
+ 	'ACP_USER_UTILS'					=> 'User utilities',
+ 
+-	'REGISTRATION_AGE'					=> 'Special Birthday',
+-	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthday Settings Updated</strong>',
+-	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthday',
+-	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthday check failed</strong><br>» %1$s entered an age of %2$s',
++	'REGISTRATION_AGE'					=> 'Special Birthdate',
++	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthdate Settings Updated</strong>',
++	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthdate',
++	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthdate check failed</strong><br>» %1$s entered an age of %2$s',
+ 	'REGISTRATION_AGE_CHANGED'			=> '<strong>Birthday changed</strong><br>» from %1$s to %2$s',
+ 	'REGISTRATION_AGE_CHANGE_ATTEMPT'	=> '<strong>Attempted to change birthday</strong><br>» to %1$s, age: %2$d',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
+index 104cbd4a4..01fe7856c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/change_age.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/change_age.php"
+index c85d6ea1e..ef4af4b28 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/change_age.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/change_age.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/datepicker_option.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/datepicker_option.php"
+deleted file mode 100644
+index 30c593291..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/datepicker_option.php"
++++ /dev/null
+@@ -1,22 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Special Birthday
+-* @copyright (c) 2016 leinad4mind
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-namespace leinad4mind\specialbirthday\migrations;
+-
+-use phpbb\db\migration\migration;
+-
+-class datepicker_option extends migration
+-{
+-	public function update_data()
+-	{
+-		return [
+-			['config.add', ['registration_age_datepicker', 0]],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/display_options.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/display_options.php"
+index 751328584..2583165c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/display_options.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/display_options.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php"
+index 9d2f3761e..1af52b673 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_display.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_display.php"
+index 4d18697a6..e1f74c7f5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_display.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_display.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
+index 5ff77521e..c8ce9d4fb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
+index 11dde139a..a9ed75ff4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
+new file mode 100644
+index 000000000..64b756dfd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
+@@ -0,0 +1,24 @@
++{% if S_REGISTRATION_AGE_PROFILE %}
++	<div class="control-group">
++		<label class="control-label">{{ lang('REGISTRATION_AGE_PROFILE') ~ lang('COLON') }}</label>
++		<div class="controls controls-row">
++			<div class="clearfix">
++				<div class="col-md-2">
++					<label for="user_registration_age_profile_0">
++						<input type="radio" id="user_registration_age_profile_0" name="user_registration_age_profile" value="0"{{ not REGISTRATION_AGE_PROFILE ? ' checked' }}> {{ lang('REGISTRATION_AGE_NOBODY') }}
++					</label>
++				</div>
++				<div class="col-md-2">
++					<label for="user_registration_age_profile_1">
++						<input type="radio" id="user_registration_age_profile_1" name="user_registration_age_profile" value="1"{{ REGISTRATION_AGE_PROFILE == 1 ? ' checked' }}> {{ lang('REGISTRATION_AGE_EVERYBODY') }}
++					</label>
++				</div>
++				<div class="col-md-3">
++					<label for="user_registration_age_profile_2">
++						<input type="radio" id="user_registration_age_profile_2" name="user_registration_age_profile" value="2"{{ REGISTRATION_AGE_PROFILE == 2 ? ' checked' }}> {{ lang('REGISTRATION_AGE_FRIENDS') }}
++					</label>
++				</div>
++			</div>
++		</div>
++	</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
+new file mode 100644
+index 000000000..47f15e268
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
+@@ -0,0 +1,27 @@
++{% if REGISTRATION_AGE_REG_DISPLAY %}
++	{% INCLUDECSS '@leinad4mind_specialbirthday/specialbirthday.css' %}
++	<div class="col-md-6">
++		<div class="form-group"> 
++			<div class="control-group">
++				<label class="control-label" for="birthdate">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label>
++				<div class="controls controls-row">
++					<div class="clearfix">
++						<div class="d-flex col-md-3">
++							<label for="registration_age_day" class="control-label mr-1">{{ lang('DAY') }}</label>
++							<input class="form-control" type="number" name="registration_age_day" id="registration_age_day" size="25" maxlength="2" value="{{ REGISTRATION_AGE_DAY }}" placeholder="{{ lang('DAY') }}" min="1" max="31" />
++						</div>
++						<div class="d-flex col-md-3">
++							<label for="registration_age_month" class="control-label mr-1">{{ lang('MONTH') }}</label>
++							<input class="form-control" type="number" name="registration_age_month" id="registration_age_month" size="25" maxlength="2" value="{{ REGISTRATION_AGE_MONTH }}" placeholder="{{ lang('MONTH') }}" min="1" max="12" />
++							
++						</div>
++						<div class="d-flex col-md-3">
++							<label for="registration_age_year" class="control-label mr-1">{{ lang('YEAR') }}</label>
++							<input class="form-control" type="number" name="registration_age_year" id="registration_age_year" size="25" maxlength="4" value="{{ REGISTRATION_AGE_YEAR }}" placeholder="{{ lang('YEAR') }}" min="{{ YEAR_START }}" max="{{ YEAR_END }}" step="-1" />
++						</div>
++					</div>
++				</div>
++			</div>
++		</div>
++	</div>
++{% endif  %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak"
+new file mode 100644
+index 000000000..8200b9553
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak"
+@@ -0,0 +1,3 @@
++{% if postrow.POSTER_AGE %}
++	<li><strong>{{ lang('AGE') }}{{ lang('COLON') }}</strong> {{ postrow.POSTER_AGE }}</li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css"
+new file mode 100644
+index 000000000..6382c78e6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css"
+@@ -0,0 +1,14 @@
++/**
++* specialbirthday.css
++**/
++
++input[type="number"] {
++	min-width: 70px;
++}
++.d-flex {
++	display: -ms-flexbox!important;
++	display: flex!important;
++}
++.mr-1 {
++	margin-right: 1rem;
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css"
+deleted file mode 100644
+index 30eb43f1b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css"
++++ /dev/null
+@@ -1,206 +0,0 @@
+-/*!
+- * Datepicker v1.0.9
+- * https://fengyuanchen.github.io/datepicker
+- *
+- * Copyright 2014-present Chen Fengyuan
+- * Released under the MIT license
+- *
+- * Date: 2019-09-21T06:57:30.334Z
+- */
+-
+-.datepicker-container {
+-  background-color: #fff;
+-  direction: ltr;
+-  font-size: 12px;
+-  left: 0;
+-  line-height: 30px;
+-  position: fixed;
+-  -webkit-tap-highlight-color: transparent;
+-  top: 0;
+-  -ms-touch-action: none;
+-  touch-action: none;
+-  -webkit-touch-callout: none;
+-  -webkit-user-select: none;
+-  -moz-user-select: none;
+-  -ms-user-select: none;
+-  user-select: none;
+-  width: 210px;
+-  z-index: -1;
+-}
+-
+-.datepicker-container::before,
+-.datepicker-container::after {
+-  border: 5px solid transparent;
+-  content: " ";
+-  display: block;
+-  height: 0;
+-  position: absolute;
+-  width: 0;
+-}
+-
+-.datepicker-dropdown {
+-  border: 1px solid #ccc;
+-  -webkit-box-shadow: 0 3px 6px #ccc;
+-  box-shadow: 0 3px 6px #ccc;
+-  -webkit-box-sizing: content-box;
+-  box-sizing: content-box;
+-  position: absolute;
+-  z-index: 1;
+-}
+-
+-.datepicker-inline {
+-  position: static;
+-}
+-
+-.datepicker-top-left,
+-.datepicker-top-right {
+-  border-top-color: #39f;
+-}
+-
+-.datepicker-top-left::before,
+-.datepicker-top-left::after,
+-.datepicker-top-right::before,
+-.datepicker-top-right::after {
+-  border-top: 0;
+-  left: 10px;
+-  top: -5px;
+-}
+-
+-.datepicker-top-left::before,
+-.datepicker-top-right::before {
+-  border-bottom-color: #39f;
+-}
+-
+-.datepicker-top-left::after,
+-.datepicker-top-right::after {
+-  border-bottom-color: #fff;
+-  top: -4px;
+-}
+-
+-.datepicker-bottom-left,
+-.datepicker-bottom-right {
+-  border-bottom-color: #39f;
+-}
+-
+-.datepicker-bottom-left::before,
+-.datepicker-bottom-left::after,
+-.datepicker-bottom-right::before,
+-.datepicker-bottom-right::after {
+-  border-bottom: 0;
+-  bottom: -5px;
+-  left: 10px;
+-}
+-
+-.datepicker-bottom-left::before,
+-.datepicker-bottom-right::before {
+-  border-top-color: #39f;
+-}
+-
+-.datepicker-bottom-left::after,
+-.datepicker-bottom-right::after {
+-  border-top-color: #fff;
+-  bottom: -4px;
+-}
+-
+-.datepicker-top-right::before,
+-.datepicker-top-right::after,
+-.datepicker-bottom-right::before,
+-.datepicker-bottom-right::after {
+-  left: auto;
+-  right: 10px;
+-}
+-
+-.datepicker-panel > ul {
+-  margin: 0;
+-  padding: 0;
+-  width: 102%;
+-}
+-
+-.datepicker-panel > ul::before,
+-.datepicker-panel > ul::after {
+-  content: " ";
+-  display: table;
+-}
+-
+-.datepicker-panel > ul::after {
+-  clear: both;
+-}
+-
+-.datepicker-panel > ul > li {
+-  background-color: #fff;
+-  cursor: pointer;
+-  float: left;
+-  height: 30px;
+-  list-style: none;
+-  margin: 0;
+-  padding: 0;
+-  text-align: center;
+-  width: 30px;
+-}
+-
+-.datepicker-panel > ul > li:hover {
+-  background-color: rgb(229, 242, 255);
+-}
+-
+-.datepicker-panel > ul > li.muted,
+-.datepicker-panel > ul > li.muted:hover {
+-  color: #999;
+-}
+-
+-.datepicker-panel > ul > li.highlighted {
+-  background-color: rgb(229, 242, 255);
+-}
+-
+-.datepicker-panel > ul > li.highlighted:hover {
+-  background-color: rgb(204, 229, 255);
+-}
+-
+-.datepicker-panel > ul > li.picked,
+-.datepicker-panel > ul > li.picked:hover {
+-  color: #39f;
+-}
+-
+-.datepicker-panel > ul > li.disabled,
+-.datepicker-panel > ul > li.disabled:hover {
+-  background-color: #fff;
+-  color: #ccc;
+-  cursor: default;
+-}
+-
+-.datepicker-panel > ul > li.disabled.highlighted,
+-.datepicker-panel > ul > li.disabled:hover.highlighted {
+-  background-color: rgb(229, 242, 255);
+-}
+-
+-.datepicker-panel > ul > li[data-view="years prev"],
+-.datepicker-panel > ul > li[data-view="year prev"],
+-.datepicker-panel > ul > li[data-view="month prev"],
+-.datepicker-panel > ul > li[data-view="years next"],
+-.datepicker-panel > ul > li[data-view="year next"],
+-.datepicker-panel > ul > li[data-view="month next"],
+-.datepicker-panel > ul > li[data-view="next"] {
+-  font-size: 18px;
+-}
+-
+-.datepicker-panel > ul > li[data-view="years current"],
+-.datepicker-panel > ul > li[data-view="year current"],
+-.datepicker-panel > ul > li[data-view="month current"] {
+-  width: 150px;
+-}
+-
+-.datepicker-panel > ul[data-view="years"] > li,
+-.datepicker-panel > ul[data-view="months"] > li {
+-  height: 52.5px;
+-  line-height: 52.5px;
+-  width: 52.5px;
+-}
+-
+-.datepicker-panel > ul[data-view="week"] > li,
+-.datepicker-panel > ul[data-view="week"] > li:hover {
+-  background-color: #fff;
+-  cursor: default;
+-}
+-
+-.datepicker-hide {
+-  display: none;
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js"
+deleted file mode 100644
+index ab7ec70fa..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js"
++++ /dev/null
+@@ -1,1532 +0,0 @@
+-/*!
+- * Datepicker v1.0.9
+- * https://fengyuanchen.github.io/datepicker
+- *
+- * Copyright 2014-present Chen Fengyuan
+- * Released under the MIT license
+- *
+- * Date: 2019-09-21T06:57:34.100Z
+- */
+-
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (global = global || self, factory(global.jQuery));
+-}(this, function ($) { 'use strict';
+-
+-  $ = $ && $.hasOwnProperty('default') ? $['default'] : $;
+-
+-  function _classCallCheck(instance, Constructor) {
+-    if (!(instance instanceof Constructor)) {
+-      throw new TypeError("Cannot call a class as a function");
+-    }
+-  }
+-
+-  function _defineProperties(target, props) {
+-    for (var i = 0; i < props.length; i++) {
+-      var descriptor = props[i];
+-      descriptor.enumerable = descriptor.enumerable || false;
+-      descriptor.configurable = true;
+-      if ("value" in descriptor) descriptor.writable = true;
+-      Object.defineProperty(target, descriptor.key, descriptor);
+-    }
+-  }
+-
+-  function _createClass(Constructor, protoProps, staticProps) {
+-    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
+-    if (staticProps) _defineProperties(Constructor, staticProps);
+-    return Constructor;
+-  }
+-
+-  var DEFAULTS = {
+-    // Show the datepicker automatically when initialized
+-    autoShow: false,
+-    // Hide the datepicker automatically when picked
+-    autoHide: false,
+-    // Pick the initial date automatically when initialized
+-    autoPick: false,
+-    // Enable inline mode
+-    inline: false,
+-    // A element (or selector) for putting the datepicker
+-    container: null,
+-    // A element (or selector) for triggering the datepicker
+-    trigger: null,
+-    // The ISO language code (built-in: en-US)
+-    language: '',
+-    // The date string format
+-    format: 'mm/dd/yyyy',
+-    // The initial date
+-    date: null,
+-    // The start view date
+-    startDate: null,
+-    // The end view date
+-    endDate: null,
+-    // The start view when initialized
+-    startView: 0,
+-    // 0 for days, 1 for months, 2 for years
+-    // The start day of the week
+-    // 0 for Sunday, 1 for Monday, 2 for Tuesday, 3 for Wednesday,
+-    // 4 for Thursday, 5 for Friday, 6 for Saturday
+-    weekStart: 0,
+-    // Show year before month on the datepicker header
+-    yearFirst: false,
+-    // A string suffix to the year number.
+-    yearSuffix: '',
+-    // Days' name of the week.
+-    days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
+-    // Shorter days' name
+-    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
+-    // Shortest days' name
+-    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
+-    // Months' name
+-    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
+-    // Shorter months' name
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
+-    // A element tag for each item of years, months and days
+-    itemTag: 'li',
+-    // A class (CSS) for muted date item
+-    mutedClass: 'muted',
+-    // A class (CSS) for picked date item
+-    pickedClass: 'picked',
+-    // A class (CSS) for disabled date item
+-    disabledClass: 'disabled',
+-    // A class (CSS) for highlight date item
+-    highlightedClass: 'highlighted',
+-    // The template of the datepicker
+-    template: '<div class="datepicker-container">' + '<div class="datepicker-panel" data-view="years picker">' + '<ul>' + '<li data-view="years prev">&lsaquo;</li>' + '<li data-view="years current"></li>' + '<li data-view="years next">&rsaquo;</li>' + '</ul>' + '<ul data-view="years"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="months picker">' + '<ul>' + '<li data-view="year prev">&lsaquo;</li>' + '<li data-view="year current"></li>' + '<li data-view="year next">&rsaquo;</li>' + '</ul>' + '<ul data-view="months"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="days picker">' + '<ul>' + '<li data-view="month prev">&lsaquo;</li>' + '<li data-view="month current"></li>' + '<li data-view="month next">&rsaquo;</li>' + '</ul>' + '<ul data-view="week"></ul>' + '<ul data-view="days"></ul>' + '</div>' + '</div>',
+-    // The offset top or bottom of the datepicker from the element
+-    offset: 10,
+-    // The `z-index` of the datepicker
+-    zIndex: 1000,
+-    // Filter each date item (return `false` to disable a date item)
+-    filter: null,
+-    // Event shortcuts
+-    show: null,
+-    hide: null,
+-    pick: null
+-  };
+-
+-  var IS_BROWSER = typeof window !== 'undefined';
+-  var WINDOW = IS_BROWSER ? window : {};
+-  var IS_TOUCH_DEVICE = IS_BROWSER ? 'ontouchstart' in WINDOW.document.documentElement : false;
+-  var NAMESPACE = 'datepicker';
+-  var EVENT_CLICK = "click.".concat(NAMESPACE);
+-  var EVENT_FOCUS = "focus.".concat(NAMESPACE);
+-  var EVENT_HIDE = "hide.".concat(NAMESPACE);
+-  var EVENT_KEYUP = "keyup.".concat(NAMESPACE);
+-  var EVENT_PICK = "pick.".concat(NAMESPACE);
+-  var EVENT_RESIZE = "resize.".concat(NAMESPACE);
+-  var EVENT_SCROLL = "scroll.".concat(NAMESPACE);
+-  var EVENT_SHOW = "show.".concat(NAMESPACE);
+-  var EVENT_TOUCH_START = "touchstart.".concat(NAMESPACE);
+-  var CLASS_HIDE = "".concat(NAMESPACE, "-hide");
+-  var LANGUAGES = {};
+-  var VIEWS = {
+-    DAYS: 0,
+-    MONTHS: 1,
+-    YEARS: 2
+-  };
+-
+-  var toString = Object.prototype.toString;
+-  function typeOf(obj) {
+-    return toString.call(obj).slice(8, -1).toLowerCase();
+-  }
+-  function isString(value) {
+-    return typeof value === 'string';
+-  }
+-  var isNaN = Number.isNaN || WINDOW.isNaN;
+-  function isNumber(value) {
+-    return typeof value === 'number' && !isNaN(value);
+-  }
+-  function isUndefined(value) {
+-    return typeof value === 'undefined';
+-  }
+-  function isDate(value) {
+-    return typeOf(value) === 'date' && !isNaN(value.getTime());
+-  }
+-  function proxy(fn, context) {
+-    for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
+-      args[_key - 2] = arguments[_key];
+-    }
+-
+-    return function () {
+-      for (var _len2 = arguments.length, args2 = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
+-        args2[_key2] = arguments[_key2];
+-      }
+-
+-      return fn.apply(context, args.concat(args2));
+-    };
+-  }
+-  function selectorOf(view) {
+-    return "[data-view=\"".concat(view, "\"]");
+-  }
+-  function isLeapYear(year) {
+-    return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
+-  }
+-  function getDaysInMonth(year, month) {
+-    return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
+-  }
+-  function getMinDay(year, month, day) {
+-    return Math.min(day, getDaysInMonth(year, month));
+-  }
+-  var formatParts = /(y|m|d)+/g;
+-  function parseFormat(format) {
+-    var source = String(format).toLowerCase();
+-    var parts = source.match(formatParts);
+-
+-    if (!parts || parts.length === 0) {
+-      throw new Error('Invalid date format.');
+-    }
+-
+-    format = {
+-      source: source,
+-      parts: parts
+-    };
+-    $.each(parts, function (i, part) {
+-      switch (part) {
+-        case 'dd':
+-        case 'd':
+-          format.hasDay = true;
+-          break;
+-
+-        case 'mm':
+-        case 'm':
+-          format.hasMonth = true;
+-          break;
+-
+-        case 'yyyy':
+-        case 'yy':
+-          format.hasYear = true;
+-          break;
+-
+-        default:
+-      }
+-    });
+-    return format;
+-  }
+-  function getScrollParent(element) {
+-    var includeHidden = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
+-    var $element = $(element);
+-    var position = $element.css('position');
+-    var excludeStaticParent = position === 'absolute';
+-    var overflowRegex = includeHidden ? /auto|scroll|hidden/ : /auto|scroll/;
+-    var scrollParent = $element.parents().filter(function (index, parent) {
+-      var $parent = $(parent);
+-
+-      if (excludeStaticParent && $parent.css('position') === 'static') {
+-        return false;
+-      }
+-
+-      return overflowRegex.test($parent.css('overflow') + $parent.css('overflow-y') + $parent.css('overflow-x'));
+-    }).eq(0);
+-    return position === 'fixed' || !scrollParent.length ? $(element.ownerDocument || document) : scrollParent;
+-  }
+-  /**
+-   * Add leading zeroes to the given value
+-   * @param {number} value - The value to add.
+-   * @param {number} [length=1] - The expected value length.
+-   * @returns {string} Returns converted value.
+-   */
+-
+-  function addLeadingZero(value) {
+-    var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
+-    var str = String(Math.abs(value));
+-    var i = str.length;
+-    var result = '';
+-
+-    if (value < 0) {
+-      result += '-';
+-    }
+-
+-    while (i < length) {
+-      i += 1;
+-      result += '0';
+-    }
+-
+-    return result + str;
+-  }
+-
+-  var REGEXP_DIGITS = /\d+/g;
+-  var methods = {
+-    // Show the datepicker
+-    show: function show() {
+-      if (!this.built) {
+-        this.build();
+-      }
+-
+-      if (this.shown) {
+-        return;
+-      }
+-
+-      if (this.trigger(EVENT_SHOW).isDefaultPrevented()) {
+-        return;
+-      }
+-
+-      this.shown = true;
+-      this.$picker.removeClass(CLASS_HIDE).on(EVENT_CLICK, $.proxy(this.click, this));
+-      this.showView(this.options.startView);
+-
+-      if (!this.inline) {
+-        this.$scrollParent.on(EVENT_SCROLL, $.proxy(this.place, this));
+-        $(window).on(EVENT_RESIZE, this.onResize = proxy(this.place, this));
+-        $(document).on(EVENT_CLICK, this.onGlobalClick = proxy(this.globalClick, this));
+-        $(document).on(EVENT_KEYUP, this.onGlobalKeyup = proxy(this.globalKeyup, this));
+-
+-        if (IS_TOUCH_DEVICE) {
+-          $(document).on(EVENT_TOUCH_START, this.onTouchStart = proxy(this.touchstart, this));
+-        }
+-
+-        this.place();
+-      }
+-    },
+-    // Hide the datepicker
+-    hide: function hide() {
+-      if (!this.shown) {
+-        return;
+-      }
+-
+-      if (this.trigger(EVENT_HIDE).isDefaultPrevented()) {
+-        return;
+-      }
+-
+-      this.shown = false;
+-      this.$picker.addClass(CLASS_HIDE).off(EVENT_CLICK, this.click);
+-
+-      if (!this.inline) {
+-        this.$scrollParent.off(EVENT_SCROLL, this.place);
+-        $(window).off(EVENT_RESIZE, this.onResize);
+-        $(document).off(EVENT_CLICK, this.onGlobalClick);
+-        $(document).off(EVENT_KEYUP, this.onGlobalKeyup);
+-
+-        if (IS_TOUCH_DEVICE) {
+-          $(document).off(EVENT_TOUCH_START, this.onTouchStart);
+-        }
+-      }
+-    },
+-    toggle: function toggle() {
+-      if (this.shown) {
+-        this.hide();
+-      } else {
+-        this.show();
+-      }
+-    },
+-    // Update the datepicker with the current input value
+-    update: function update() {
+-      var value = this.getValue();
+-
+-      if (value === this.oldValue) {
+-        return;
+-      }
+-
+-      this.setDate(value, true);
+-      this.oldValue = value;
+-    },
+-
+-    /**
+-     * Pick the current date to the element
+-     *
+-     * @param {String} _view (private)
+-     */
+-    pick: function pick(_view) {
+-      var $this = this.$element;
+-      var date = this.date;
+-
+-      if (this.trigger(EVENT_PICK, {
+-        view: _view || '',
+-        date: date
+-      }).isDefaultPrevented()) {
+-        return;
+-      }
+-
+-      date = this.formatDate(this.date);
+-      this.setValue(date);
+-
+-      if (this.isInput) {
+-        $this.trigger('input');
+-        $this.trigger('change');
+-      }
+-    },
+-    // Reset the datepicker
+-    reset: function reset() {
+-      this.setDate(this.initialDate, true);
+-      this.setValue(this.initialValue);
+-
+-      if (this.shown) {
+-        this.showView(this.options.startView);
+-      }
+-    },
+-
+-    /**
+-     * Get the month name with given argument or the current date
+-     *
+-     * @param {Number} month (optional)
+-     * @param {Boolean} shortForm (optional)
+-     * @return {String} (month name)
+-     */
+-    getMonthName: function getMonthName(month, shortForm) {
+-      var options = this.options;
+-      var monthsShort = options.monthsShort;
+-      var months = options.months;
+-
+-      if ($.isNumeric(month)) {
+-        month = Number(month);
+-      } else if (isUndefined(shortForm)) {
+-        shortForm = month;
+-      }
+-
+-      if (shortForm === true) {
+-        months = monthsShort;
+-      }
+-
+-      return months[isNumber(month) ? month : this.date.getMonth()];
+-    },
+-
+-    /**
+-     * Get the day name with given argument or the current date
+-     *
+-     * @param {Number} day (optional)
+-     * @param {Boolean} shortForm (optional)
+-     * @param {Boolean} min (optional)
+-     * @return {String} (day name)
+-     */
+-    getDayName: function getDayName(day, shortForm, min) {
+-      var options = this.options;
+-      var days = options.days;
+-
+-      if ($.isNumeric(day)) {
+-        day = Number(day);
+-      } else {
+-        if (isUndefined(min)) {
+-          min = shortForm;
+-        }
+-
+-        if (isUndefined(shortForm)) {
+-          shortForm = day;
+-        }
+-      }
+-
+-      if (min) {
+-        days = options.daysMin;
+-      } else if (shortForm) {
+-        days = options.daysShort;
+-      }
+-
+-      return days[isNumber(day) ? day : this.date.getDay()];
+-    },
+-
+-    /**
+-     * Get the current date
+-     *
+-     * @param {Boolean} formatted (optional)
+-     * @return {Date|String} (date)
+-     */
+-    getDate: function getDate(formatted) {
+-      var date = this.date;
+-      return formatted ? this.formatDate(date) : new Date(date);
+-    },
+-
+-    /**
+-     * Set the current date with a new date
+-     *
+-     * @param {Date} date
+-     * @param {Boolean} _updated (private)
+-     */
+-    setDate: function setDate(date, _updated) {
+-      var filter = this.options.filter;
+-
+-      if (isDate(date) || isString(date)) {
+-        date = this.parseDate(date);
+-
+-        if ($.isFunction(filter) && filter.call(this.$element, date, 'day') === false) {
+-          return;
+-        }
+-
+-        this.date = date;
+-        this.viewDate = new Date(date);
+-
+-        if (!_updated) {
+-          this.pick();
+-        }
+-
+-        if (this.built) {
+-          this.render();
+-        }
+-      }
+-    },
+-
+-    /**
+-     * Set the start view date with a new date
+-     *
+-     * @param {Date|string|null} date
+-     */
+-    setStartDate: function setStartDate(date) {
+-      if (isDate(date) || isString(date)) {
+-        this.startDate = this.parseDate(date);
+-      } else {
+-        this.startDate = null;
+-      }
+-
+-      if (this.built) {
+-        this.render();
+-      }
+-    },
+-
+-    /**
+-     * Set the end view date with a new date
+-     *
+-     * @param {Date|string|null} date
+-     */
+-    setEndDate: function setEndDate(date) {
+-      if (isDate(date) || isString(date)) {
+-        this.endDate = this.parseDate(date);
+-      } else {
+-        this.endDate = null;
+-      }
+-
+-      if (this.built) {
+-        this.render();
+-      }
+-    },
+-
+-    /**
+-     * Parse a date string with the set date format
+-     *
+-     * @param {String} date
+-     * @return {Date} (parsed date)
+-     */
+-    parseDate: function parseDate(date) {
+-      var format = this.format;
+-      var parts = [];
+-
+-      if (!isDate(date)) {
+-        if (isString(date)) {
+-          parts = date.match(REGEXP_DIGITS) || [];
+-        }
+-
+-        date = date ? new Date(date) : new Date();
+-
+-        if (!isDate(date)) {
+-          date = new Date();
+-        }
+-
+-        if (parts.length === format.parts.length) {
+-          // Set year and month first
+-          $.each(parts, function (i, part) {
+-            var value = parseInt(part, 10);
+-
+-            switch (format.parts[i]) {
+-              case 'yy':
+-                date.setFullYear(2000 + value);
+-                break;
+-
+-              case 'yyyy':
+-                // Converts 2-digit year to 2000+
+-                date.setFullYear(part.length === 2 ? 2000 + value : value);
+-                break;
+-
+-              case 'mm':
+-              case 'm':
+-                date.setMonth(value - 1);
+-                break;
+-
+-              default:
+-            }
+-          }); // Set day in the last to avoid converting `31/10/2019` to `01/10/2019`
+-
+-          $.each(parts, function (i, part) {
+-            var value = parseInt(part, 10);
+-
+-            switch (format.parts[i]) {
+-              case 'dd':
+-              case 'd':
+-                date.setDate(value);
+-                break;
+-
+-              default:
+-            }
+-          });
+-        }
+-      } // Ignore hours, minutes, seconds and milliseconds to avoid side effect (#192)
+-
+-
+-      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
+-    },
+-
+-    /**
+-     * Format a date object to a string with the set date format
+-     *
+-     * @param {Date} date
+-     * @return {String} (formatted date)
+-     */
+-    formatDate: function formatDate(date) {
+-      var format = this.format;
+-      var formatted = '';
+-
+-      if (isDate(date)) {
+-        var year = date.getFullYear();
+-        var month = date.getMonth();
+-        var day = date.getDate();
+-        var values = {
+-          d: day,
+-          dd: addLeadingZero(day, 2),
+-          m: month + 1,
+-          mm: addLeadingZero(month + 1, 2),
+-          yy: String(year).substring(2),
+-          yyyy: addLeadingZero(year, 4)
+-        };
+-        formatted = format.source;
+-        $.each(format.parts, function (i, part) {
+-          formatted = formatted.replace(part, values[part]);
+-        });
+-      }
+-
+-      return formatted;
+-    },
+-    // Destroy the datepicker and remove the instance from the target element
+-    destroy: function destroy() {
+-      this.unbind();
+-      this.unbuild();
+-      this.$element.removeData(NAMESPACE);
+-    }
+-  };
+-
+-  var handlers = {
+-    click: function click(e) {
+-      var $target = $(e.target);
+-      var options = this.options,
+-          date = this.date,
+-          viewDate = this.viewDate,
+-          format = this.format;
+-      e.stopPropagation();
+-      e.preventDefault();
+-
+-      if ($target.hasClass('disabled')) {
+-        return;
+-      }
+-
+-      var view = $target.data('view');
+-      var viewYear = viewDate.getFullYear();
+-      var viewMonth = viewDate.getMonth();
+-      var viewDay = viewDate.getDate();
+-
+-      switch (view) {
+-        case 'years prev':
+-        case 'years next':
+-          {
+-            viewYear = view === 'years prev' ? viewYear - 10 : viewYear + 10;
+-            viewDate.setFullYear(viewYear);
+-            viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-            this.renderYears();
+-            break;
+-          }
+-
+-        case 'year prev':
+-        case 'year next':
+-          viewYear = view === 'year prev' ? viewYear - 1 : viewYear + 1;
+-          viewDate.setFullYear(viewYear);
+-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-          this.renderMonths();
+-          break;
+-
+-        case 'year current':
+-          if (format.hasYear) {
+-            this.showView(VIEWS.YEARS);
+-          }
+-
+-          break;
+-
+-        case 'year picked':
+-          if (format.hasMonth) {
+-            this.showView(VIEWS.MONTHS);
+-          } else {
+-            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
+-            this.hideView();
+-          }
+-
+-          this.pick('year');
+-          break;
+-
+-        case 'year':
+-          viewYear = parseInt($target.text(), 10); // Set date first to avoid month changing (#195)
+-
+-          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-          date.setFullYear(viewYear);
+-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-          viewDate.setFullYear(viewYear);
+-
+-          if (format.hasMonth) {
+-            this.showView(VIEWS.MONTHS);
+-          } else {
+-            $target.addClass(options.pickedClass).data('view', 'year picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
+-            this.hideView();
+-          }
+-
+-          this.pick('year');
+-          break;
+-
+-        case 'month prev':
+-        case 'month next':
+-          viewMonth = view === 'month prev' ? viewMonth - 1 : viewMonth + 1;
+-
+-          if (viewMonth < 0) {
+-            viewYear -= 1;
+-            viewMonth += 12;
+-          } else if (viewMonth > 11) {
+-            viewYear += 1;
+-            viewMonth -= 12;
+-          }
+-
+-          viewDate.setFullYear(viewYear);
+-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-          viewDate.setMonth(viewMonth);
+-          this.renderDays();
+-          break;
+-
+-        case 'month current':
+-          if (format.hasMonth) {
+-            this.showView(VIEWS.MONTHS);
+-          }
+-
+-          break;
+-
+-        case 'month picked':
+-          if (format.hasDay) {
+-            this.showView(VIEWS.DAYS);
+-          } else {
+-            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
+-            this.hideView();
+-          }
+-
+-          this.pick('month');
+-          break;
+-
+-        case 'month':
+-          viewMonth = $.inArray($target.text(), options.monthsShort);
+-          date.setFullYear(viewYear); // Set date before month to avoid month changing (#195)
+-
+-          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-          date.setMonth(viewMonth);
+-          viewDate.setFullYear(viewYear);
+-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
+-          viewDate.setMonth(viewMonth);
+-
+-          if (format.hasDay) {
+-            this.showView(VIEWS.DAYS);
+-          } else {
+-            $target.addClass(options.pickedClass).data('view', 'month picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
+-            this.hideView();
+-          }
+-
+-          this.pick('month');
+-          break;
+-
+-        case 'day prev':
+-        case 'day next':
+-        case 'day':
+-          if (view === 'day prev') {
+-            viewMonth -= 1;
+-          } else if (view === 'day next') {
+-            viewMonth += 1;
+-          }
+-
+-          viewDay = parseInt($target.text(), 10); // Set date to 1 to avoid month changing (#195)
+-
+-          date.setDate(1);
+-          date.setFullYear(viewYear);
+-          date.setMonth(viewMonth);
+-          date.setDate(viewDay);
+-          viewDate.setDate(1);
+-          viewDate.setFullYear(viewYear);
+-          viewDate.setMonth(viewMonth);
+-          viewDate.setDate(viewDay);
+-          this.renderDays();
+-
+-          if (view === 'day') {
+-            this.hideView();
+-          }
+-
+-          this.pick('day');
+-          break;
+-
+-        case 'day picked':
+-          this.hideView();
+-          this.pick('day');
+-          break;
+-
+-        default:
+-      }
+-    },
+-    globalClick: function globalClick(_ref) {
+-      var target = _ref.target;
+-      var element = this.element,
+-          $trigger = this.$trigger;
+-      var trigger = $trigger[0];
+-      var hidden = true;
+-
+-      while (target !== document) {
+-        if (target === trigger || target === element) {
+-          hidden = false;
+-          break;
+-        }
+-
+-        target = target.parentNode;
+-      }
+-
+-      if (hidden) {
+-        this.hide();
+-      }
+-    },
+-    keyup: function keyup() {
+-      this.update();
+-    },
+-    globalKeyup: function globalKeyup(_ref2) {
+-      var target = _ref2.target,
+-          key = _ref2.key,
+-          keyCode = _ref2.keyCode;
+-
+-      if (this.isInput && target !== this.element && this.shown && (key === 'Tab' || keyCode === 9)) {
+-        this.hide();
+-      }
+-    },
+-    touchstart: function touchstart(_ref3) {
+-      var target = _ref3.target;
+-
+-      // Emulate click in touch devices to support hiding the picker automatically (#197).
+-      if (this.isInput && target !== this.element && !$.contains(this.$picker[0], target)) {
+-        this.hide();
+-        this.element.blur();
+-      }
+-    }
+-  };
+-
+-  var render = {
+-    render: function render() {
+-      this.renderYears();
+-      this.renderMonths();
+-      this.renderDays();
+-    },
+-    renderWeek: function renderWeek() {
+-      var _this = this;
+-
+-      var items = [];
+-      var _this$options = this.options,
+-          weekStart = _this$options.weekStart,
+-          daysMin = _this$options.daysMin;
+-      weekStart = parseInt(weekStart, 10) % 7;
+-      daysMin = daysMin.slice(weekStart).concat(daysMin.slice(0, weekStart));
+-      $.each(daysMin, function (i, day) {
+-        items.push(_this.createItem({
+-          text: day
+-        }));
+-      });
+-      this.$week.html(items.join(''));
+-    },
+-    renderYears: function renderYears() {
+-      var options = this.options,
+-          startDate = this.startDate,
+-          endDate = this.endDate;
+-      var disabledClass = options.disabledClass,
+-          filter = options.filter,
+-          yearSuffix = options.yearSuffix;
+-      var viewYear = this.viewDate.getFullYear();
+-      var now = new Date();
+-      var thisYear = now.getFullYear();
+-      var year = this.date.getFullYear();
+-      var start = -5;
+-      var end = 6;
+-      var items = [];
+-      var prevDisabled = false;
+-      var nextDisabled = false;
+-      var i;
+-
+-      for (i = start; i <= end; i += 1) {
+-        var date = new Date(viewYear + i, 1, 1);
+-        var disabled = false;
+-
+-        if (startDate) {
+-          disabled = date.getFullYear() < startDate.getFullYear();
+-
+-          if (i === start) {
+-            prevDisabled = disabled;
+-          }
+-        }
+-
+-        if (!disabled && endDate) {
+-          disabled = date.getFullYear() > endDate.getFullYear();
+-
+-          if (i === end) {
+-            nextDisabled = disabled;
+-          }
+-        }
+-
+-        if (!disabled && filter) {
+-          disabled = filter.call(this.$element, date, 'year') === false;
+-        }
+-
+-        var picked = viewYear + i === year;
+-        var view = picked ? 'year picked' : 'year';
+-        items.push(this.createItem({
+-          picked: picked,
+-          disabled: disabled,
+-          text: viewYear + i,
+-          view: disabled ? 'year disabled' : view,
+-          highlighted: date.getFullYear() === thisYear
+-        }));
+-      }
+-
+-      this.$yearsPrev.toggleClass(disabledClass, prevDisabled);
+-      this.$yearsNext.toggleClass(disabledClass, nextDisabled);
+-      this.$yearsCurrent.toggleClass(disabledClass, true).html("".concat(viewYear + start + yearSuffix, " - ").concat(viewYear + end).concat(yearSuffix));
+-      this.$years.html(items.join(''));
+-    },
+-    renderMonths: function renderMonths() {
+-      var options = this.options,
+-          startDate = this.startDate,
+-          endDate = this.endDate,
+-          viewDate = this.viewDate;
+-      var disabledClass = options.disabledClass || '';
+-      var months = options.monthsShort;
+-      var filter = $.isFunction(options.filter) && options.filter;
+-      var viewYear = viewDate.getFullYear();
+-      var now = new Date();
+-      var thisYear = now.getFullYear();
+-      var thisMonth = now.getMonth();
+-      var year = this.date.getFullYear();
+-      var month = this.date.getMonth();
+-      var items = [];
+-      var prevDisabled = false;
+-      var nextDisabled = false;
+-      var i;
+-
+-      for (i = 0; i <= 11; i += 1) {
+-        var date = new Date(viewYear, i, 1);
+-        var disabled = false;
+-
+-        if (startDate) {
+-          prevDisabled = date.getFullYear() === startDate.getFullYear();
+-          disabled = prevDisabled && date.getMonth() < startDate.getMonth();
+-        }
+-
+-        if (!disabled && endDate) {
+-          nextDisabled = date.getFullYear() === endDate.getFullYear();
+-          disabled = nextDisabled && date.getMonth() > endDate.getMonth();
+-        }
+-
+-        if (!disabled && filter) {
+-          disabled = filter.call(this.$element, date, 'month') === false;
+-        }
+-
+-        var picked = viewYear === year && i === month;
+-        var view = picked ? 'month picked' : 'month';
+-        items.push(this.createItem({
+-          disabled: disabled,
+-          picked: picked,
+-          highlighted: viewYear === thisYear && date.getMonth() === thisMonth,
+-          index: i,
+-          text: months[i],
+-          view: disabled ? 'month disabled' : view
+-        }));
+-      }
+-
+-      this.$yearPrev.toggleClass(disabledClass, prevDisabled);
+-      this.$yearNext.toggleClass(disabledClass, nextDisabled);
+-      this.$yearCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(viewYear + options.yearSuffix || '');
+-      this.$months.html(items.join(''));
+-    },
+-    renderDays: function renderDays() {
+-      var $element = this.$element,
+-          options = this.options,
+-          startDate = this.startDate,
+-          endDate = this.endDate,
+-          viewDate = this.viewDate,
+-          currentDate = this.date;
+-      var disabledClass = options.disabledClass,
+-          filter = options.filter,
+-          months = options.months,
+-          weekStart = options.weekStart,
+-          yearSuffix = options.yearSuffix;
+-      var viewYear = viewDate.getFullYear();
+-      var viewMonth = viewDate.getMonth();
+-      var now = new Date();
+-      var thisYear = now.getFullYear();
+-      var thisMonth = now.getMonth();
+-      var thisDay = now.getDate();
+-      var year = currentDate.getFullYear();
+-      var month = currentDate.getMonth();
+-      var day = currentDate.getDate();
+-      var length;
+-      var i;
+-      var n; // Days of prev month
+-      // -----------------------------------------------------------------------
+-
+-      var prevItems = [];
+-      var prevViewYear = viewYear;
+-      var prevViewMonth = viewMonth;
+-      var prevDisabled = false;
+-
+-      if (viewMonth === 0) {
+-        prevViewYear -= 1;
+-        prevViewMonth = 11;
+-      } else {
+-        prevViewMonth -= 1;
+-      } // The length of the days of prev month
+-
+-
+-      length = getDaysInMonth(prevViewYear, prevViewMonth); // The first day of current month
+-
+-      var firstDay = new Date(viewYear, viewMonth, 1); // The visible length of the days of prev month
+-      // [0,1,2,3,4,5,6] - [0,1,2,3,4,5,6] => [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6]
+-
+-      n = firstDay.getDay() - parseInt(weekStart, 10) % 7; // [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6] => [1,2,3,4,5,6,7]
+-
+-      if (n <= 0) {
+-        n += 7;
+-      }
+-
+-      if (startDate) {
+-        prevDisabled = firstDay.getTime() <= startDate.getTime();
+-      }
+-
+-      for (i = length - (n - 1); i <= length; i += 1) {
+-        var prevViewDate = new Date(prevViewYear, prevViewMonth, i);
+-        var disabled = false;
+-
+-        if (startDate) {
+-          disabled = prevViewDate.getTime() < startDate.getTime();
+-        }
+-
+-        if (!disabled && filter) {
+-          disabled = filter.call($element, prevViewDate, 'day') === false;
+-        }
+-
+-        prevItems.push(this.createItem({
+-          disabled: disabled,
+-          highlighted: prevViewYear === thisYear && prevViewMonth === thisMonth && prevViewDate.getDate() === thisDay,
+-          muted: true,
+-          picked: prevViewYear === year && prevViewMonth === month && i === day,
+-          text: i,
+-          view: 'day prev'
+-        }));
+-      } // Days of next month
+-      // -----------------------------------------------------------------------
+-
+-
+-      var nextItems = [];
+-      var nextViewYear = viewYear;
+-      var nextViewMonth = viewMonth;
+-      var nextDisabled = false;
+-
+-      if (viewMonth === 11) {
+-        nextViewYear += 1;
+-        nextViewMonth = 0;
+-      } else {
+-        nextViewMonth += 1;
+-      } // The length of the days of current month
+-
+-
+-      length = getDaysInMonth(viewYear, viewMonth); // The visible length of next month (42 means 6 rows and 7 columns)
+-
+-      n = 42 - (prevItems.length + length); // The last day of current month
+-
+-      var lastDate = new Date(viewYear, viewMonth, length);
+-
+-      if (endDate) {
+-        nextDisabled = lastDate.getTime() >= endDate.getTime();
+-      }
+-
+-      for (i = 1; i <= n; i += 1) {
+-        var date = new Date(nextViewYear, nextViewMonth, i);
+-        var picked = nextViewYear === year && nextViewMonth === month && i === day;
+-        var _disabled = false;
+-
+-        if (endDate) {
+-          _disabled = date.getTime() > endDate.getTime();
+-        }
+-
+-        if (!_disabled && filter) {
+-          _disabled = filter.call($element, date, 'day') === false;
+-        }
+-
+-        nextItems.push(this.createItem({
+-          disabled: _disabled,
+-          picked: picked,
+-          highlighted: nextViewYear === thisYear && nextViewMonth === thisMonth && date.getDate() === thisDay,
+-          muted: true,
+-          text: i,
+-          view: 'day next'
+-        }));
+-      } // Days of current month
+-      // -----------------------------------------------------------------------
+-
+-
+-      var items = [];
+-
+-      for (i = 1; i <= length; i += 1) {
+-        var _date = new Date(viewYear, viewMonth, i);
+-
+-        var _disabled2 = false;
+-
+-        if (startDate) {
+-          _disabled2 = _date.getTime() < startDate.getTime();
+-        }
+-
+-        if (!_disabled2 && endDate) {
+-          _disabled2 = _date.getTime() > endDate.getTime();
+-        }
+-
+-        if (!_disabled2 && filter) {
+-          _disabled2 = filter.call($element, _date, 'day') === false;
+-        }
+-
+-        var _picked = viewYear === year && viewMonth === month && i === day;
+-
+-        var view = _picked ? 'day picked' : 'day';
+-        items.push(this.createItem({
+-          disabled: _disabled2,
+-          picked: _picked,
+-          highlighted: viewYear === thisYear && viewMonth === thisMonth && _date.getDate() === thisDay,
+-          text: i,
+-          view: _disabled2 ? 'day disabled' : view
+-        }));
+-      } // Render days picker
+-      // -----------------------------------------------------------------------
+-
+-
+-      this.$monthPrev.toggleClass(disabledClass, prevDisabled);
+-      this.$monthNext.toggleClass(disabledClass, nextDisabled);
+-      this.$monthCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(options.yearFirst ? "".concat(viewYear + yearSuffix, " ").concat(months[viewMonth]) : "".concat(months[viewMonth], " ").concat(viewYear).concat(yearSuffix));
+-      this.$days.html(prevItems.join('') + items.join('') + nextItems.join(''));
+-    }
+-  };
+-
+-  var CLASS_TOP_LEFT = "".concat(NAMESPACE, "-top-left");
+-  var CLASS_TOP_RIGHT = "".concat(NAMESPACE, "-top-right");
+-  var CLASS_BOTTOM_LEFT = "".concat(NAMESPACE, "-bottom-left");
+-  var CLASS_BOTTOM_RIGHT = "".concat(NAMESPACE, "-bottom-right");
+-  var CLASS_PLACEMENTS = [CLASS_TOP_LEFT, CLASS_TOP_RIGHT, CLASS_BOTTOM_LEFT, CLASS_BOTTOM_RIGHT].join(' ');
+-
+-  var Datepicker =
+-  /*#__PURE__*/
+-  function () {
+-    function Datepicker(element) {
+-      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
+-
+-      _classCallCheck(this, Datepicker);
+-
+-      this.$element = $(element);
+-      this.element = element;
+-      this.options = $.extend({}, DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
+-      this.$scrollParent = getScrollParent(element, true);
+-      this.built = false;
+-      this.shown = false;
+-      this.isInput = false;
+-      this.inline = false;
+-      this.initialValue = '';
+-      this.initialDate = null;
+-      this.startDate = null;
+-      this.endDate = null;
+-      this.init();
+-    }
+-
+-    _createClass(Datepicker, [{
+-      key: "init",
+-      value: function init() {
+-        var $this = this.$element,
+-            options = this.options;
+-        var startDate = options.startDate,
+-            endDate = options.endDate,
+-            date = options.date;
+-        this.$trigger = $(options.trigger);
+-        this.isInput = $this.is('input') || $this.is('textarea');
+-        this.inline = options.inline && (options.container || !this.isInput);
+-        this.format = parseFormat(options.format);
+-        var initialValue = this.getValue();
+-        this.initialValue = initialValue;
+-        this.oldValue = initialValue;
+-        date = this.parseDate(date || initialValue);
+-
+-        if (startDate) {
+-          startDate = this.parseDate(startDate);
+-
+-          if (date.getTime() < startDate.getTime()) {
+-            date = new Date(startDate);
+-          }
+-
+-          this.startDate = startDate;
+-        }
+-
+-        if (endDate) {
+-          endDate = this.parseDate(endDate);
+-
+-          if (startDate && endDate.getTime() < startDate.getTime()) {
+-            endDate = new Date(startDate);
+-          }
+-
+-          if (date.getTime() > endDate.getTime()) {
+-            date = new Date(endDate);
+-          }
+-
+-          this.endDate = endDate;
+-        }
+-
+-        this.date = date;
+-        this.viewDate = new Date(date);
+-        this.initialDate = new Date(this.date);
+-        this.bind();
+-
+-        if (options.autoShow || this.inline) {
+-          this.show();
+-        }
+-
+-        if (options.autoPick) {
+-          this.pick();
+-        }
+-      }
+-    }, {
+-      key: "build",
+-      value: function build() {
+-        if (this.built) {
+-          return;
+-        }
+-
+-        this.built = true;
+-        var $this = this.$element,
+-            options = this.options;
+-        var $picker = $(options.template);
+-        this.$picker = $picker;
+-        this.$week = $picker.find(selectorOf('week')); // Years view
+-
+-        this.$yearsPicker = $picker.find(selectorOf('years picker'));
+-        this.$yearsPrev = $picker.find(selectorOf('years prev'));
+-        this.$yearsNext = $picker.find(selectorOf('years next'));
+-        this.$yearsCurrent = $picker.find(selectorOf('years current'));
+-        this.$years = $picker.find(selectorOf('years')); // Months view
+-
+-        this.$monthsPicker = $picker.find(selectorOf('months picker'));
+-        this.$yearPrev = $picker.find(selectorOf('year prev'));
+-        this.$yearNext = $picker.find(selectorOf('year next'));
+-        this.$yearCurrent = $picker.find(selectorOf('year current'));
+-        this.$months = $picker.find(selectorOf('months')); // Days view
+-
+-        this.$daysPicker = $picker.find(selectorOf('days picker'));
+-        this.$monthPrev = $picker.find(selectorOf('month prev'));
+-        this.$monthNext = $picker.find(selectorOf('month next'));
+-        this.$monthCurrent = $picker.find(selectorOf('month current'));
+-        this.$days = $picker.find(selectorOf('days'));
+-
+-        if (this.inline) {
+-          $(options.container || $this).append($picker.addClass("".concat(NAMESPACE, "-inline")));
+-        } else {
+-          $(document.body).append($picker.addClass("".concat(NAMESPACE, "-dropdown")));
+-          $picker.addClass(CLASS_HIDE).css({
+-            zIndex: parseInt(options.zIndex, 10)
+-          });
+-        }
+-
+-        this.renderWeek();
+-      }
+-    }, {
+-      key: "unbuild",
+-      value: function unbuild() {
+-        if (!this.built) {
+-          return;
+-        }
+-
+-        this.built = false;
+-        this.$picker.remove();
+-      }
+-    }, {
+-      key: "bind",
+-      value: function bind() {
+-        var options = this.options,
+-            $this = this.$element;
+-
+-        if ($.isFunction(options.show)) {
+-          $this.on(EVENT_SHOW, options.show);
+-        }
+-
+-        if ($.isFunction(options.hide)) {
+-          $this.on(EVENT_HIDE, options.hide);
+-        }
+-
+-        if ($.isFunction(options.pick)) {
+-          $this.on(EVENT_PICK, options.pick);
+-        }
+-
+-        if (this.isInput) {
+-          $this.on(EVENT_KEYUP, $.proxy(this.keyup, this));
+-        }
+-
+-        if (!this.inline) {
+-          if (options.trigger) {
+-            this.$trigger.on(EVENT_CLICK, $.proxy(this.toggle, this));
+-          } else if (this.isInput) {
+-            $this.on(EVENT_FOCUS, $.proxy(this.show, this));
+-          } else {
+-            $this.on(EVENT_CLICK, $.proxy(this.show, this));
+-          }
+-        }
+-      }
+-    }, {
+-      key: "unbind",
+-      value: function unbind() {
+-        var $this = this.$element,
+-            options = this.options;
+-
+-        if ($.isFunction(options.show)) {
+-          $this.off(EVENT_SHOW, options.show);
+-        }
+-
+-        if ($.isFunction(options.hide)) {
+-          $this.off(EVENT_HIDE, options.hide);
+-        }
+-
+-        if ($.isFunction(options.pick)) {
+-          $this.off(EVENT_PICK, options.pick);
+-        }
+-
+-        if (this.isInput) {
+-          $this.off(EVENT_KEYUP, this.keyup);
+-        }
+-
+-        if (!this.inline) {
+-          if (options.trigger) {
+-            this.$trigger.off(EVENT_CLICK, this.toggle);
+-          } else if (this.isInput) {
+-            $this.off(EVENT_FOCUS, this.show);
+-          } else {
+-            $this.off(EVENT_CLICK, this.show);
+-          }
+-        }
+-      }
+-    }, {
+-      key: "showView",
+-      value: function showView(view) {
+-        var $yearsPicker = this.$yearsPicker,
+-            $monthsPicker = this.$monthsPicker,
+-            $daysPicker = this.$daysPicker,
+-            format = this.format;
+-
+-        if (format.hasYear || format.hasMonth || format.hasDay) {
+-          switch (Number(view)) {
+-            case VIEWS.YEARS:
+-              $monthsPicker.addClass(CLASS_HIDE);
+-              $daysPicker.addClass(CLASS_HIDE);
+-
+-              if (format.hasYear) {
+-                this.renderYears();
+-                $yearsPicker.removeClass(CLASS_HIDE);
+-                this.place();
+-              } else {
+-                this.showView(VIEWS.DAYS);
+-              }
+-
+-              break;
+-
+-            case VIEWS.MONTHS:
+-              $yearsPicker.addClass(CLASS_HIDE);
+-              $daysPicker.addClass(CLASS_HIDE);
+-
+-              if (format.hasMonth) {
+-                this.renderMonths();
+-                $monthsPicker.removeClass(CLASS_HIDE);
+-                this.place();
+-              } else {
+-                this.showView(VIEWS.YEARS);
+-              }
+-
+-              break;
+-            // case VIEWS.DAYS:
+-
+-            default:
+-              $yearsPicker.addClass(CLASS_HIDE);
+-              $monthsPicker.addClass(CLASS_HIDE);
+-
+-              if (format.hasDay) {
+-                this.renderDays();
+-                $daysPicker.removeClass(CLASS_HIDE);
+-                this.place();
+-              } else {
+-                this.showView(VIEWS.MONTHS);
+-              }
+-
+-          }
+-        }
+-      }
+-    }, {
+-      key: "hideView",
+-      value: function hideView() {
+-        if (!this.inline && this.options.autoHide) {
+-          this.hide();
+-        }
+-      }
+-    }, {
+-      key: "place",
+-      value: function place() {
+-        if (this.inline) {
+-          return;
+-        }
+-
+-        var $this = this.$element,
+-            options = this.options,
+-            $picker = this.$picker;
+-        var containerWidth = $(document).outerWidth();
+-        var containerHeight = $(document).outerHeight();
+-        var elementWidth = $this.outerWidth();
+-        var elementHeight = $this.outerHeight();
+-        var width = $picker.width();
+-        var height = $picker.height();
+-
+-        var _$this$offset = $this.offset(),
+-            left = _$this$offset.left,
+-            top = _$this$offset.top;
+-
+-        var offset = parseFloat(options.offset);
+-        var placement = CLASS_TOP_LEFT;
+-
+-        if (isNaN(offset)) {
+-          offset = 10;
+-        }
+-
+-        if (top > height && top + elementHeight + height > containerHeight) {
+-          top -= height + offset;
+-          placement = CLASS_BOTTOM_LEFT;
+-        } else {
+-          top += elementHeight + offset;
+-        }
+-
+-        if (left + width > containerWidth) {
+-          left += elementWidth - width;
+-          placement = placement.replace('left', 'right');
+-        }
+-
+-        $picker.removeClass(CLASS_PLACEMENTS).addClass(placement).css({
+-          top: top,
+-          left: left
+-        });
+-      } // A shortcut for triggering custom events
+-
+-    }, {
+-      key: "trigger",
+-      value: function trigger(type, data) {
+-        var e = $.Event(type, data);
+-        this.$element.trigger(e);
+-        return e;
+-      }
+-    }, {
+-      key: "createItem",
+-      value: function createItem(data) {
+-        var options = this.options;
+-        var itemTag = options.itemTag;
+-        var item = {
+-          text: '',
+-          view: '',
+-          muted: false,
+-          picked: false,
+-          disabled: false,
+-          highlighted: false
+-        };
+-        var classes = [];
+-        $.extend(item, data);
+-
+-        if (item.muted) {
+-          classes.push(options.mutedClass);
+-        }
+-
+-        if (item.highlighted) {
+-          classes.push(options.highlightedClass);
+-        }
+-
+-        if (item.picked) {
+-          classes.push(options.pickedClass);
+-        }
+-
+-        if (item.disabled) {
+-          classes.push(options.disabledClass);
+-        }
+-
+-        return "<".concat(itemTag, " class=\"").concat(classes.join(' '), "\" data-view=\"").concat(item.view, "\">").concat(item.text, "</").concat(itemTag, ">");
+-      }
+-    }, {
+-      key: "getValue",
+-      value: function getValue() {
+-        var $this = this.$element;
+-        return this.isInput ? $this.val() : $this.text();
+-      }
+-    }, {
+-      key: "setValue",
+-      value: function setValue() {
+-        var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
+-        var $this = this.$element;
+-
+-        if (this.isInput) {
+-          $this.val(value);
+-        } else if (!this.inline || this.options.container) {
+-          $this.text(value);
+-        }
+-      }
+-    }], [{
+-      key: "setDefaults",
+-      value: function setDefaults() {
+-        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
+-        $.extend(DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
+-      }
+-    }]);
+-
+-    return Datepicker;
+-  }();
+-
+-  if ($.extend) {
+-    $.extend(Datepicker.prototype, render, handlers, methods);
+-  }
+-
+-  if ($.fn) {
+-    var AnotherDatepicker = $.fn.datepicker;
+-
+-    $.fn.datepicker = function jQueryDatepicker(option) {
+-      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
+-        args[_key - 1] = arguments[_key];
+-      }
+-
+-      var result;
+-      this.each(function (i, element) {
+-        var $element = $(element);
+-        var isDestroy = option === 'destroy';
+-        var datepicker = $element.data(NAMESPACE);
+-
+-        if (!datepicker) {
+-          if (isDestroy) {
+-            return;
+-          }
+-
+-          var options = $.extend({}, $element.data(), $.isPlainObject(option) && option);
+-          datepicker = new Datepicker(element, options);
+-          $element.data(NAMESPACE, datepicker);
+-        }
+-
+-        if (isString(option)) {
+-          var fn = datepicker[option];
+-
+-          if ($.isFunction(fn)) {
+-            result = fn.apply(datepicker, args);
+-
+-            if (isDestroy) {
+-              $element.removeData(NAMESPACE);
+-            }
+-          }
+-        }
+-      });
+-      return !isUndefined(result) ? result : this;
+-    };
+-
+-    $.fn.datepicker.Constructor = Datepicker;
+-    $.fn.datepicker.languages = LANGUAGES;
+-    $.fn.datepicker.setDefaults = Datepicker.setDefaults;
+-
+-    $.fn.datepicker.noConflict = function noConflict() {
+-      $.fn.datepicker = AnotherDatepicker;
+-      return this;
+-    };
+-  }
+-
+-}));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css"
+deleted file mode 100644
+index 73320920f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css"
++++ /dev/null
+@@ -1,9 +0,0 @@
+-/*!
+- * Datepicker v1.0.9
+- * https://fengyuanchen.github.io/datepicker
+- *
+- * Copyright 2014-present Chen Fengyuan
+- * Released under the MIT license
+- *
+- * Date: 2019-09-21T06:57:30.334Z
+- */.datepicker-container{background-color:#fff;direction:ltr;font-size:12px;left:0;line-height:30px;position:fixed;-webkit-tap-highlight-color:transparent;top:0;-ms-touch-action:none;touch-action:none;-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;width:210px;z-index:-1}.datepicker-container:after,.datepicker-container:before{border:5px solid transparent;content:" ";display:block;height:0;position:absolute;width:0}.datepicker-dropdown{border:1px solid #ccc;-webkit-box-shadow:0 3px 6px #ccc;box-shadow:0 3px 6px #ccc;-webkit-box-sizing:content-box;box-sizing:content-box;position:absolute;z-index:1}.datepicker-inline{position:static}.datepicker-top-left,.datepicker-top-right{border-top-color:#39f}.datepicker-top-left:after,.datepicker-top-left:before,.datepicker-top-right:after,.datepicker-top-right:before{border-top:0;left:10px;top:-5px}.datepicker-top-left:before,.datepicker-top-right:before{border-bottom-color:#39f}.datepicker-top-left:after,.datepicker-top-right:after{border-bottom-color:#fff;top:-4px}.datepicker-bottom-left,.datepicker-bottom-right{border-bottom-color:#39f}.datepicker-bottom-left:after,.datepicker-bottom-left:before,.datepicker-bottom-right:after,.datepicker-bottom-right:before{border-bottom:0;bottom:-5px;left:10px}.datepicker-bottom-left:before,.datepicker-bottom-right:before{border-top-color:#39f}.datepicker-bottom-left:after,.datepicker-bottom-right:after{border-top-color:#fff;bottom:-4px}.datepicker-bottom-right:after,.datepicker-bottom-right:before,.datepicker-top-right:after,.datepicker-top-right:before{left:auto;right:10px}.datepicker-panel>ul{margin:0;padding:0;width:102%}.datepicker-panel>ul:after,.datepicker-panel>ul:before{content:" ";display:table}.datepicker-panel>ul:after{clear:both}.datepicker-panel>ul>li{background-color:#fff;cursor:pointer;float:left;height:30px;list-style:none;margin:0;padding:0;text-align:center;width:30px}.datepicker-panel>ul>li:hover{background-color:#e5f2ff}.datepicker-panel>ul>li.muted,.datepicker-panel>ul>li.muted:hover{color:#999}.datepicker-panel>ul>li.highlighted{background-color:#e5f2ff}.datepicker-panel>ul>li.highlighted:hover{background-color:#cce5ff}.datepicker-panel>ul>li.picked,.datepicker-panel>ul>li.picked:hover{color:#39f}.datepicker-panel>ul>li.disabled,.datepicker-panel>ul>li.disabled:hover{background-color:#fff;color:#ccc;cursor:default}.datepicker-panel>ul>li.disabled.highlighted,.datepicker-panel>ul>li.disabled:hover.highlighted{background-color:#e5f2ff}.datepicker-panel>ul>li[data-view="month next"],.datepicker-panel>ul>li[data-view="month prev"],.datepicker-panel>ul>li[data-view="year next"],.datepicker-panel>ul>li[data-view="year prev"],.datepicker-panel>ul>li[data-view="years next"],.datepicker-panel>ul>li[data-view="years prev"],.datepicker-panel>ul>li[data-view=next]{font-size:18px}.datepicker-panel>ul>li[data-view="month current"],.datepicker-panel>ul>li[data-view="year current"],.datepicker-panel>ul>li[data-view="years current"]{width:150px}.datepicker-panel>ul[data-view=months]>li,.datepicker-panel>ul[data-view=years]>li{height:52.5px;line-height:52.5px;width:52.5px}.datepicker-panel>ul[data-view=week]>li,.datepicker-panel>ul[data-view=week]>li:hover{background-color:#fff;cursor:default}.datepicker-hide{display:none}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js"
+deleted file mode 100644
+index 928a19ad2..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js"
++++ /dev/null
+@@ -1,10 +0,0 @@
+-/*!
+- * Datepicker v1.0.9
+- * https://fengyuanchen.github.io/datepicker
+- *
+- * Copyright 2014-present Chen Fengyuan
+- * Released under the MIT license
+- *
+- * Date: 2019-09-21T06:57:34.100Z
+- */
+-!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],e):e((t=t||self).jQuery)}(this,function(D){"use strict";function a(t,e){for(var i=0;i<e.length;i++){var a=e[i];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}D=D&&D.hasOwnProperty("default")?D.default:D;var s={autoShow:!1,autoHide:!1,autoPick:!1,inline:!1,container:null,trigger:null,language:"",format:"mm/dd/yyyy",date:null,startDate:null,endDate:null,startView:0,weekStart:0,yearFirst:!1,yearSuffix:"",days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],itemTag:"li",mutedClass:"muted",pickedClass:"picked",disabledClass:"disabled",highlightedClass:"highlighted",template:'<div class="datepicker-container"><div class="datepicker-panel" data-view="years picker"><ul><li data-view="years prev">&lsaquo;</li><li data-view="years current"></li><li data-view="years next">&rsaquo;</li></ul><ul data-view="years"></ul></div><div class="datepicker-panel" data-view="months picker"><ul><li data-view="year prev">&lsaquo;</li><li data-view="year current"></li><li data-view="year next">&rsaquo;</li></ul><ul data-view="months"></ul></div><div class="datepicker-panel" data-view="days picker"><ul><li data-view="month prev">&lsaquo;</li><li data-view="month current"></li><li data-view="month next">&rsaquo;</li></ul><ul data-view="week"></ul><ul data-view="days"></ul></div></div>',offset:10,zIndex:1e3,filter:null,show:null,hide:null,pick:null},t="undefined"!=typeof window,e=t?window:{},i=t&&"ontouchstart"in e.document.documentElement,c="datepicker",n="click.".concat(c),r="focus.".concat(c),h="hide.".concat(c),o="keyup.".concat(c),l="pick.".concat(c),d="resize.".concat(c),u="scroll.".concat(c),p="show.".concat(c),f="touchstart.".concat(c),g="".concat(c,"-hide"),y={},m=0,v=1,w=2,k=Object.prototype.toString;function b(t){return"string"==typeof t}var C=Number.isNaN||e.isNaN;function $(t){return"number"==typeof t&&!C(t)}function x(t){return void 0===t}function F(t){return"date"===function(t){return k.call(t).slice(8,-1).toLowerCase()}(t)&&!C(t.getTime())}function M(a,s){for(var t=arguments.length,n=new Array(2<t?t-2:0),e=2;e<t;e++)n[e-2]=arguments[e];return function(){for(var t=arguments.length,e=new Array(t),i=0;i<t;i++)e[i]=arguments[i];return a.apply(s,n.concat(e))}}function Y(t){return'[data-view="'.concat(t,'"]')}function G(t,e){return[31,function(t){return t%4==0&&t%100!=0||t%400==0}(t)?29:28,31,30,31,30,31,31,30,31,30,31][e]}function V(t,e,i){return Math.min(i,G(t,e))}var T=/(y|m|d)+/g;function I(t,e){var i=1<arguments.length&&void 0!==e?e:1,a=String(Math.abs(t)),s=a.length,n="";for(t<0&&(n+="-");s<i;)s+=1,n+="0";return n+a}var S=/\d+/g,P={show:function(){this.built||this.build(),this.shown||this.trigger(p).isDefaultPrevented()||(this.shown=!0,this.$picker.removeClass(g).on(n,D.proxy(this.click,this)),this.showView(this.options.startView),this.inline||(this.$scrollParent.on(u,D.proxy(this.place,this)),D(window).on(d,this.onResize=M(this.place,this)),D(document).on(n,this.onGlobalClick=M(this.globalClick,this)),D(document).on(o,this.onGlobalKeyup=M(this.globalKeyup,this)),i&&D(document).on(f,this.onTouchStart=M(this.touchstart,this)),this.place()))},hide:function(){this.shown&&(this.trigger(h).isDefaultPrevented()||(this.shown=!1,this.$picker.addClass(g).off(n,this.click),this.inline||(this.$scrollParent.off(u,this.place),D(window).off(d,this.onResize),D(document).off(n,this.onGlobalClick),D(document).off(o,this.onGlobalKeyup),i&&D(document).off(f,this.onTouchStart))))},toggle:function(){this.shown?this.hide():this.show()},update:function(){var t=this.getValue();t!==this.oldValue&&(this.setDate(t,!0),this.oldValue=t)},pick:function(t){var e=this.$element,i=this.date;this.trigger(l,{view:t||"",date:i}).isDefaultPrevented()||(i=this.formatDate(this.date),this.setValue(i),this.isInput&&(e.trigger("input"),e.trigger("change")))},reset:function(){this.setDate(this.initialDate,!0),this.setValue(this.initialValue),this.shown&&this.showView(this.options.startView)},getMonthName:function(t,e){var i=this.options,a=i.monthsShort,s=i.months;return D.isNumeric(t)?t=Number(t):x(e)&&(e=t),!0===e&&(s=a),s[$(t)?t:this.date.getMonth()]},getDayName:function(t,e,i){var a=this.options,s=a.days;return D.isNumeric(t)?t=Number(t):(x(i)&&(i=e),x(e)&&(e=t)),i?s=a.daysMin:e&&(s=a.daysShort),s[$(t)?t:this.date.getDay()]},getDate:function(t){var e=this.date;return t?this.formatDate(e):new Date(e)},setDate:function(t,e){var i=this.options.filter;if(F(t)||b(t)){if(t=this.parseDate(t),D.isFunction(i)&&!1===i.call(this.$element,t,"day"))return;this.date=t,this.viewDate=new Date(t),e||this.pick(),this.built&&this.render()}},setStartDate:function(t){F(t)||b(t)?this.startDate=this.parseDate(t):this.startDate=null,this.built&&this.render()},setEndDate:function(t){F(t)||b(t)?this.endDate=this.parseDate(t):this.endDate=null,this.built&&this.render()},parseDate:function(a){var s=this.format,t=[];return F(a)||(b(a)&&(t=a.match(S)||[]),F(a=a?new Date(a):new Date)||(a=new Date),t.length===s.parts.length&&(D.each(t,function(t,e){var i=parseInt(e,10);switch(s.parts[t]){case"yy":a.setFullYear(2e3+i);break;case"yyyy":a.setFullYear(2===e.length?2e3+i:i);break;case"mm":case"m":a.setMonth(i-1)}}),D.each(t,function(t,e){var i=parseInt(e,10);switch(s.parts[t]){case"dd":case"d":a.setDate(i)}}))),new Date(a.getFullYear(),a.getMonth(),a.getDate())},formatDate:function(t){var e=this.format,i="";if(F(t)){var a=t.getFullYear(),s=t.getMonth(),n=t.getDate(),r={d:n,dd:I(n,2),m:s+1,mm:I(s+1,2),yy:String(a).substring(2),yyyy:I(a,4)};i=e.source,D.each(e.parts,function(t,e){i=i.replace(e,r[e])})}return i},destroy:function(){this.unbind(),this.unbuild(),this.$element.removeData(c)}},N={click:function(t){var e=D(t.target),i=this.options,a=this.date,s=this.viewDate,n=this.format;if(t.stopPropagation(),t.preventDefault(),!e.hasClass("disabled")){var r=e.data("view"),h=s.getFullYear(),o=s.getMonth(),l=s.getDate();switch(r){case"years prev":case"years next":h="years prev"===r?h-10:h+10,s.setFullYear(h),s.setDate(V(h,o,l)),this.renderYears();break;case"year prev":case"year next":h="year prev"===r?h-1:h+1,s.setFullYear(h),s.setDate(V(h,o,l)),this.renderMonths();break;case"year current":n.hasYear&&this.showView(w);break;case"year picked":n.hasMonth?this.showView(v):(e.siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","year"),this.hideView()),this.pick("year");break;case"year":h=parseInt(e.text(),10),a.setDate(V(h,o,l)),a.setFullYear(h),s.setDate(V(h,o,l)),s.setFullYear(h),n.hasMonth?this.showView(v):(e.addClass(i.pickedClass).data("view","year picked").siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","year"),this.hideView()),this.pick("year");break;case"month prev":case"month next":(o="month prev"===r?o-1:o+1)<0?(h-=1,o+=12):11<o&&(h+=1,o-=12),s.setFullYear(h),s.setDate(V(h,o,l)),s.setMonth(o),this.renderDays();break;case"month current":n.hasMonth&&this.showView(v);break;case"month picked":n.hasDay?this.showView(m):(e.siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","month"),this.hideView()),this.pick("month");break;case"month":o=D.inArray(e.text(),i.monthsShort),a.setFullYear(h),a.setDate(V(h,o,l)),a.setMonth(o),s.setFullYear(h),s.setDate(V(h,o,l)),s.setMonth(o),n.hasDay?this.showView(m):(e.addClass(i.pickedClass).data("view","month picked").siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","month"),this.hideView()),this.pick("month");break;case"day prev":case"day next":case"day":"day prev"===r?o-=1:"day next"===r&&(o+=1),l=parseInt(e.text(),10),a.setDate(1),a.setFullYear(h),a.setMonth(o),a.setDate(l),s.setDate(1),s.setFullYear(h),s.setMonth(o),s.setDate(l),this.renderDays(),"day"===r&&this.hideView(),this.pick("day");break;case"day picked":this.hideView(),this.pick("day")}}},globalClick:function(t){for(var e=t.target,i=this.element,a=this.$trigger[0],s=!0;e!==document;){if(e===a||e===i){s=!1;break}e=e.parentNode}s&&this.hide()},keyup:function(){this.update()},globalKeyup:function(t){var e=t.target,i=t.key,a=t.keyCode;this.isInput&&e!==this.element&&this.shown&&("Tab"===i||9===a)&&this.hide()},touchstart:function(t){var e=t.target;this.isInput&&e!==this.element&&!D.contains(this.$picker[0],e)&&(this.hide(),this.element.blur())}},j={render:function(){this.renderYears(),this.renderMonths(),this.renderDays()},renderWeek:function(){var i=this,a=[],t=this.options,e=t.weekStart,s=t.daysMin;e=parseInt(e,10)%7,s=s.slice(e).concat(s.slice(0,e)),D.each(s,function(t,e){a.push(i.createItem({text:e}))}),this.$week.html(a.join(""))},renderYears:function(){var t,e=this.options,i=this.startDate,a=this.endDate,s=e.disabledClass,n=e.filter,r=e.yearSuffix,h=this.viewDate.getFullYear(),o=(new Date).getFullYear(),l=this.date.getFullYear(),c=[],d=!1,u=!1;for(t=-5;t<=6;t+=1){var p=new Date(h+t,1,1),f=!1;i&&(f=p.getFullYear()<i.getFullYear(),-5===t&&(d=f)),!f&&a&&(f=p.getFullYear()>a.getFullYear(),6===t&&(u=f)),!f&&n&&(f=!1===n.call(this.$element,p,"year"));var g=h+t===l,y=g?"year picked":"year";c.push(this.createItem({picked:g,disabled:f,text:h+t,view:f?"year disabled":y,highlighted:p.getFullYear()===o}))}this.$yearsPrev.toggleClass(s,d),this.$yearsNext.toggleClass(s,u),this.$yearsCurrent.toggleClass(s,!0).html("".concat(h+-5+r," - ").concat(h+6).concat(r)),this.$years.html(c.join(""))},renderMonths:function(){var t,e=this.options,i=this.startDate,a=this.endDate,s=this.viewDate,n=e.disabledClass||"",r=e.monthsShort,h=D.isFunction(e.filter)&&e.filter,o=s.getFullYear(),l=new Date,c=l.getFullYear(),d=l.getMonth(),u=this.date.getFullYear(),p=this.date.getMonth(),f=[],g=!1,y=!1;for(t=0;t<=11;t+=1){var m=new Date(o,t,1),v=!1;i&&(v=(g=m.getFullYear()===i.getFullYear())&&m.getMonth()<i.getMonth()),!v&&a&&(v=(y=m.getFullYear()===a.getFullYear())&&m.getMonth()>a.getMonth()),!v&&h&&(v=!1===h.call(this.$element,m,"month"));var w=o===u&&t===p,k=w?"month picked":"month";f.push(this.createItem({disabled:v,picked:w,highlighted:o===c&&m.getMonth()===d,index:t,text:r[t],view:v?"month disabled":k}))}this.$yearPrev.toggleClass(n,g),this.$yearNext.toggleClass(n,y),this.$yearCurrent.toggleClass(n,g&&y).html(o+e.yearSuffix||""),this.$months.html(f.join(""))},renderDays:function(){var t,e,i,a=this.$element,s=this.options,n=this.startDate,r=this.endDate,h=this.viewDate,o=this.date,l=s.disabledClass,c=s.filter,d=s.months,u=s.weekStart,p=s.yearSuffix,f=h.getFullYear(),g=h.getMonth(),y=new Date,m=y.getFullYear(),v=y.getMonth(),w=y.getDate(),k=o.getFullYear(),D=o.getMonth(),b=o.getDate(),C=[],$=f,x=g,F=!1;0===g?($-=1,x=11):x-=1,t=G($,x);var M=new Date(f,g,1);for((i=M.getDay()-parseInt(u,10)%7)<=0&&(i+=7),n&&(F=M.getTime()<=n.getTime()),e=t-(i-1);e<=t;e+=1){var Y=new Date($,x,e),V=!1;n&&(V=Y.getTime()<n.getTime()),!V&&c&&(V=!1===c.call(a,Y,"day")),C.push(this.createItem({disabled:V,highlighted:$===m&&x===v&&Y.getDate()===w,muted:!0,picked:$===k&&x===D&&e===b,text:e,view:"day prev"}))}var T=[],I=f,S=g,P=!1;11===g?(I+=1,S=0):S+=1,t=G(f,g),i=42-(C.length+t);var N=new Date(f,g,t);for(r&&(P=N.getTime()>=r.getTime()),e=1;e<=i;e+=1){var j=new Date(I,S,e),q=I===k&&S===D&&e===b,A=!1;r&&(A=j.getTime()>r.getTime()),!A&&c&&(A=!1===c.call(a,j,"day")),T.push(this.createItem({disabled:A,picked:q,highlighted:I===m&&S===v&&j.getDate()===w,muted:!0,text:e,view:"day next"}))}var O=[];for(e=1;e<=t;e+=1){var W=new Date(f,g,e),z=!1;n&&(z=W.getTime()<n.getTime()),!z&&r&&(z=W.getTime()>r.getTime()),!z&&c&&(z=!1===c.call(a,W,"day"));var J=f===k&&g===D&&e===b,E=J?"day picked":"day";O.push(this.createItem({disabled:z,picked:J,highlighted:f===m&&g===v&&W.getDate()===w,text:e,view:z?"day disabled":E}))}this.$monthPrev.toggleClass(l,F),this.$monthNext.toggleClass(l,P),this.$monthCurrent.toggleClass(l,F&&P).html(s.yearFirst?"".concat(f+p," ").concat(d[g]):"".concat(d[g]," ").concat(f).concat(p)),this.$days.html(C.join("")+O.join("")+T.join(""))}},q="".concat(c,"-top-left"),A="".concat(c,"-top-right"),O="".concat(c,"-bottom-left"),W="".concat(c,"-bottom-right"),z=[q,A,O,W].join(" "),J=function(){function i(t){var e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,i),this.$element=D(t),this.element=t,this.options=D.extend({},s,y[e.language],D.isPlainObject(e)&&e),this.$scrollParent=function(t,e){var i=1<arguments.length&&void 0!==e&&e,a=D(t),s=a.css("position"),n="absolute"===s,r=i?/auto|scroll|hidden/:/auto|scroll/,h=a.parents().filter(function(t,e){var i=D(e);return(!n||"static"!==i.css("position"))&&r.test(i.css("overflow")+i.css("overflow-y")+i.css("overflow-x"))}).eq(0);return"fixed"!==s&&h.length?h:D(t.ownerDocument||document)}(t,!0),this.built=!1,this.shown=!1,this.isInput=!1,this.inline=!1,this.initialValue="",this.initialDate=null,this.startDate=null,this.endDate=null,this.init()}return function(t,e,i){e&&a(t.prototype,e),i&&a(t,i)}(i,[{key:"init",value:function(){var t=this.$element,e=this.options,i=e.startDate,a=e.endDate,s=e.date;this.$trigger=D(e.trigger),this.isInput=t.is("input")||t.is("textarea"),this.inline=e.inline&&(e.container||!this.isInput),this.format=function(i){var t=String(i).toLowerCase(),e=t.match(T);if(!e||0===e.length)throw new Error("Invalid date format.");return i={source:t,parts:e},D.each(e,function(t,e){switch(e){case"dd":case"d":i.hasDay=!0;break;case"mm":case"m":i.hasMonth=!0;break;case"yyyy":case"yy":i.hasYear=!0}}),i}(e.format);var n=this.getValue();this.initialValue=n,this.oldValue=n,s=this.parseDate(s||n),i&&(i=this.parseDate(i),s.getTime()<i.getTime()&&(s=new Date(i)),this.startDate=i),a&&(a=this.parseDate(a),i&&a.getTime()<i.getTime()&&(a=new Date(i)),s.getTime()>a.getTime()&&(s=new Date(a)),this.endDate=a),this.date=s,this.viewDate=new Date(s),this.initialDate=new Date(this.date),this.bind(),(e.autoShow||this.inline)&&this.show(),e.autoPick&&this.pick()}},{key:"build",value:function(){if(!this.built){this.built=!0;var t=this.$element,e=this.options,i=D(e.template);this.$picker=i,this.$week=i.find(Y("week")),this.$yearsPicker=i.find(Y("years picker")),this.$yearsPrev=i.find(Y("years prev")),this.$yearsNext=i.find(Y("years next")),this.$yearsCurrent=i.find(Y("years current")),this.$years=i.find(Y("years")),this.$monthsPicker=i.find(Y("months picker")),this.$yearPrev=i.find(Y("year prev")),this.$yearNext=i.find(Y("year next")),this.$yearCurrent=i.find(Y("year current")),this.$months=i.find(Y("months")),this.$daysPicker=i.find(Y("days picker")),this.$monthPrev=i.find(Y("month prev")),this.$monthNext=i.find(Y("month next")),this.$monthCurrent=i.find(Y("month current")),this.$days=i.find(Y("days")),this.inline?D(e.container||t).append(i.addClass("".concat(c,"-inline"))):(D(document.body).append(i.addClass("".concat(c,"-dropdown"))),i.addClass(g).css({zIndex:parseInt(e.zIndex,10)})),this.renderWeek()}}},{key:"unbuild",value:function(){this.built&&(this.built=!1,this.$picker.remove())}},{key:"bind",value:function(){var t=this.options,e=this.$element;D.isFunction(t.show)&&e.on(p,t.show),D.isFunction(t.hide)&&e.on(h,t.hide),D.isFunction(t.pick)&&e.on(l,t.pick),this.isInput&&e.on(o,D.proxy(this.keyup,this)),this.inline||(t.trigger?this.$trigger.on(n,D.proxy(this.toggle,this)):this.isInput?e.on(r,D.proxy(this.show,this)):e.on(n,D.proxy(this.show,this)))}},{key:"unbind",value:function(){var t=this.$element,e=this.options;D.isFunction(e.show)&&t.off(p,e.show),D.isFunction(e.hide)&&t.off(h,e.hide),D.isFunction(e.pick)&&t.off(l,e.pick),this.isInput&&t.off(o,this.keyup),this.inline||(e.trigger?this.$trigger.off(n,this.toggle):this.isInput?t.off(r,this.show):t.off(n,this.show))}},{key:"showView",value:function(t){var e=this.$yearsPicker,i=this.$monthsPicker,a=this.$daysPicker,s=this.format;if(s.hasYear||s.hasMonth||s.hasDay)switch(Number(t)){case w:i.addClass(g),a.addClass(g),s.hasYear?(this.renderYears(),e.removeClass(g),this.place()):this.showView(m);break;case v:e.addClass(g),a.addClass(g),s.hasMonth?(this.renderMonths(),i.removeClass(g),this.place()):this.showView(w);break;default:e.addClass(g),i.addClass(g),s.hasDay?(this.renderDays(),a.removeClass(g),this.place()):this.showView(v)}}},{key:"hideView",value:function(){!this.inline&&this.options.autoHide&&this.hide()}},{key:"place",value:function(){if(!this.inline){var t=this.$element,e=this.options,i=this.$picker,a=D(document).outerWidth(),s=D(document).outerHeight(),n=t.outerWidth(),r=t.outerHeight(),h=i.width(),o=i.height(),l=t.offset(),c=l.left,d=l.top,u=parseFloat(e.offset),p=q;C(u)&&(u=10),o<d&&s<d+r+o?(d-=o+u,p=O):d+=r+u,a<c+h&&(c+=n-h,p=p.replace("left","right")),i.removeClass(z).addClass(p).css({top:d,left:c})}}},{key:"trigger",value:function(t,e){var i=D.Event(t,e);return this.$element.trigger(i),i}},{key:"createItem",value:function(t){var e=this.options,i=e.itemTag,a={text:"",view:"",muted:!1,picked:!1,disabled:!1,highlighted:!1},s=[];return D.extend(a,t),a.muted&&s.push(e.mutedClass),a.highlighted&&s.push(e.highlightedClass),a.picked&&s.push(e.pickedClass),a.disabled&&s.push(e.disabledClass),"<".concat(i,' class="').concat(s.join(" "),'" data-view="').concat(a.view,'">').concat(a.text,"</").concat(i,">")}},{key:"getValue",value:function(){var t=this.$element;return this.isInput?t.val():t.text()}},{key:"setValue",value:function(t){var e=0<arguments.length&&void 0!==t?t:"",i=this.$element;this.isInput?i.val(e):this.inline&&!this.options.container||i.text(e)}}],[{key:"setDefaults",value:function(t){var e=0<arguments.length&&void 0!==t?t:{};D.extend(s,y[e.language],D.isPlainObject(e)&&e)}}]),i}();if(D.extend&&D.extend(J.prototype,j,N,P),D.fn){var E=D.fn.datepicker;D.fn.datepicker=function(h){for(var t=arguments.length,o=new Array(1<t?t-1:0),e=1;e<t;e++)o[e-1]=arguments[e];var l;return this.each(function(t,e){var i=D(e),a="destroy"===h,s=i.data(c);if(!s){if(a)return;var n=D.extend({},i.data(),D.isPlainObject(h)&&h);s=new J(e,n),i.data(c,s)}if(b(h)){var r=s[h];D.isFunction(r)&&(l=r.apply(s,o),a&&i.removeData(c))}}),x(l)?this:l},D.fn.datepicker.Constructor=J,D.fn.datepicker.languages=y,D.fn.datepicker.setDefaults=J.setDefaults,D.fn.datepicker.noConflict=function(){return D.fn.datepicker=E,this}}});
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js"
+deleted file mode 100644
+index c9c5acddb..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ar-IQ'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['الأحد', 'الأثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
+-    daysShort: ['أحد', 'أثنين', 'ثلاثاء', 'اربعاء', 'خميس', 'جمعة', 'سبت'],
+-    daysMin: ['أ', 'ث', 'ث', 'أ', 'خ', 'ج', 'س'],
+-    weekStart: 1,
+-    months: ['كانون الثاني', 'شباط', 'اذار', 'نيسان', 'ايار', 'حزيران', 'تموز', 'آب', 'ايلول', 'تشرين الاول', 'تشرين الثاني', 'كانون الاول'],
+-    monthsShort: ['كانون ٢', 'شباط', 'اذار', 'نيسان', 'ايار', 'حزيران', 'تموز', 'آب', 'ايلول', 'تشرين ١', 'تشرين ٢', 'كانون ١']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js"
+deleted file mode 100644
+index c84ca88d3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ca-ES'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['diumenge', 'dilluns', 'dimarts', 'dimecres', 'dijous', 'divendres', 'dissabte'],
+-    daysShort: ['dg.', 'dl.', 'dt.', 'dc.', 'dj.', 'dv.', 'ds.'],
+-    daysMin: ['dg', 'dl', 'dt', 'dc', 'dj', 'dv', 'ds'],
+-    weekStart: 1,
+-    months: ['gener', 'febrer', 'març', 'abril', 'maig', 'juny', 'juliol', 'agost', 'setembre', 'octubre', 'novembre', 'desembre'],
+-    monthsShort: ['gen.', 'febr.', 'març', 'abr.', 'maig', 'juny', 'jul.', 'ag.', 'set.', 'oct.', 'nov.', 'des.']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js"
+deleted file mode 100644
+index 4b6e4ee9a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js"
++++ /dev/null
+@@ -1,18 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['cs-CZ'] = {
+-    format: 'dd.mm.YYYY',
+-    days: ['Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota'],
+-    daysShort: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'],
+-    daysMin: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'],
+-    weekStart: 1,
+-    months: ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'],
+-    // Used everywhere, but probably not grammar correct
+-    monthsShort: ['Led', 'Úno', 'Bře', 'Dub', 'Květ', 'Čvn', 'Čvc', 'Srp', 'Zář', 'Říj', 'Lis', 'Pro']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js"
+deleted file mode 100644
+index 8eb442c2f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['da-DK'] = {
+-    format: 'dd-mm-yyyy',
+-    days: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
+-    daysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
+-    daysMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
+-    weekStart: 1,
+-    months: ['Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'December'],
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js"
+deleted file mode 100644
+index f0309485a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['de-DE'] = {
+-    format: 'dd.mm.yyyy',
+-    days: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
+-    daysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
+-    daysMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
+-    weekStart: 1,
+-    months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
+-    monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js"
+deleted file mode 100644
+index f3116a50c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js"
++++ /dev/null
+@@ -1,20 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['el-GR'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο'],
+-    daysShort: ['Κυρ', 'Δευ', 'Τρι', 'Τετ', 'Πεμ', 'Παρ', 'Σαβ'],
+-    daysMin: ['Κ', 'Δ', 'Τ', 'Τ', 'Π', 'Π', 'Σ'],
+-    months: ['Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβρης', 'Οκτώβρης', 'Νοέμβρης', 'Δεκέμβρης'],
+-    monthsShort: ['Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μάι', 'Ιούν', 'Ιούλ', 'Άυγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ'],
+-    weekStart: 1,
+-    startView: 0,
+-    yearFirst: false,
+-    yearSuffix: ''
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js"
+deleted file mode 100644
+index 2e1e7f54c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js"
++++ /dev/null
+@@ -1,11 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['en-GB'] = {
+-    format: 'dd/mm/yyyy'
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js"
+deleted file mode 100644
+index 7fb3bb41b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js"
++++ /dev/null
+@@ -1,11 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['en-US'] = {
+-    format: 'mm/dd/yyyy'
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js"
+deleted file mode 100644
+index c45f84809..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['es-ES'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
+-    daysShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
+-    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
+-    weekStart: 1,
+-    months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
+-    monthsShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js"
+deleted file mode 100644
+index f512504d9..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['fi-FI'] = {
+-    format: 'dd.mm.yyyy',
+-    days: ['Sunnuntai', 'Maanantai', 'Tiistai', 'Keskiviikko', 'Torstai', 'Perjantai', 'Lauantai'],
+-    daysShort: ['Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La'],
+-    daysMin: ['Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La'],
+-    weekStart: 1,
+-    months: ['Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu'],
+-    monthsShort: ['Tammi', 'Helmi', 'Maalis', 'Huhti', 'Touko', 'Kesä', 'Heinä', 'Elo', 'Syys', 'Loka', 'Marras', 'Joulu']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js"
+deleted file mode 100644
+index 04024699d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['fr-FR'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
+-    daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
+-    daysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
+-    weekStart: 1,
+-    months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
+-    monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js"
+deleted file mode 100644
+index a39c706f3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['hu-HU'] = {
+-    format: 'yyyy. mm. dd.',
+-    days: ['vasárnap', 'hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat'],
+-    daysShort: ['vas', 'hé', 'ke', 'sze', 'csüt', 'pé', 'szo'],
+-    daysMin: ['V', 'H', 'K', 'Sz', 'Cs', 'P', 'Sz'],
+-    weekStart: 1,
+-    months: ['január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december'],
+-    monthsShort: ['jan', 'feb', 'már', 'ápr', 'máj', 'jún', 'júl', 'aug', 'szep', 'okt', 'nov', 'dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js"
+deleted file mode 100644
+index 0d5556bd0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js"
++++ /dev/null
+@@ -1,18 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['is-IS'] = {
+-    format: 'dd.mm.YYYY',
+-    // Capital letters are not used in day/month names
+-    days: ['sunnudagur', 'mánudagur', 'þriðjudagur', 'miðvikudagur', 'fimmtudagur', 'föstudagur', 'laugardagur'],
+-    daysShort: ['sun', 'mán', 'þri', 'mið', 'fim', 'fös', 'lau'],
+-    daysMin: ['Su', 'Má', 'Þr', 'Mi', 'Fi', 'Fö', 'La'],
+-    weekStart: 1,
+-    months: ['janúar', 'febrúar', 'mars', 'apríl', 'maí', 'júní', 'júlí', 'ágúst', 'september', 'október', 'nóvember', 'desember'],
+-    monthsShort: ['jan', 'feb', 'mar', 'apr', 'maí', 'jún', 'júl', 'ágú', 'sep', 'okt', 'nóv', 'des']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js"
+deleted file mode 100644
+index be56ec65b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['it-IT'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
+-    daysShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
+-    daysMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
+-    weekStart: 1,
+-    months: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
+-    monthsShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js"
+deleted file mode 100644
+index 1dce1741c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js"
++++ /dev/null
+@@ -1,19 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ja-JP'] = {
+-    format: 'yyyy年mm月dd日',
+-    days: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
+-    daysShort: ['日曜', '月曜', '火曜', '水曜', '木曜', '金曜', '土曜'],
+-    daysMin: ['日', '月', '火', '水', '木', '金', '土'],
+-    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
+-    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
+-    weekStart: 1,
+-    yearFirst: true,
+-    yearSuffix: '年'
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js"
+deleted file mode 100644
+index 4dffea780..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['km-KH'] = {
+-    format: 'dd-mm-yyyy',
+-    days: ['អាទិត្យ', 'ច័ន្ទ', ' អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'],
+-    daysShort: ['អទ', 'ចន', 'អង', 'ពធ', 'ពហ', 'សក', 'សរ'],
+-    daysMin: ['អ', 'ច', 'អ', 'ព', 'ព្', 'ស', 'ស'],
+-    weekStart: 1,
+-    months: ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'],
+-    monthsShort: ['មរ', 'កម', 'មន', 'មស', 'ឧស', 'មថ', 'កដ', 'សហ', 'កញ', 'តល', 'វឆ', 'ធ្ន']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js"
+deleted file mode 100644
+index 4ac1c497d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js"
++++ /dev/null
+@@ -1,19 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ko-KR'] = {
+-    format: 'yyyy. mm. dd',
+-    days: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
+-    daysShort: ['일', '월', '화', '수', '목', '금', '토'],
+-    daysMin: ['일', '월', '화', '수', '목', '금', '토'],
+-    months: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
+-    monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
+-    weekStart: 1,
+-    yearFirst: true,
+-    yearSuffix: '년'
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js"
+deleted file mode 100644
+index a886df432..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['lt-LT'] = {
+-    format: 'yyyy-mm-dd',
+-    days: ['Sekmadienis', 'Pirmadienis', 'Antradienis', 'Trečiadienis', 'Ketvirtadienis', 'Penktadienis', 'Šeštadienis'],
+-    daysShort: ['Sekm', 'Pirm', 'Antr', 'Treč', 'Ketv', 'Penkt', 'Šešt'],
+-    daysMin: ['Sk', 'Pr', 'An', 'Tr', 'Kt', 'Pn', 'Št'],
+-    weekStart: 1,
+-    months: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis', 'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'],
+-    monthsShort: ['Sau', 'Vas', 'Kov', 'Bal', 'Geg', 'Bir', 'Lie', 'Rgp', 'Rgs', 'Spa', 'Lap', 'Gru']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js"
+deleted file mode 100644
+index 856080b81..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js"
++++ /dev/null
+@@ -1,20 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['lv-LV'] = {
+-    format: 'YYYY-mm-dd',
+-    days: ['Svētdiena', 'Pirmdiena', 'Otrdiena', 'Trešdiena', 'Ceturtdiena', 'Piektdiena', 'Sestdiena'],
+-    daysShort: ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'],
+-    daysMin: ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'],
+-    months: ['Janvāris', 'Februāris', 'Marts', 'Aprīlis', 'Maijs', 'Jūnijs', 'Jūlijs', 'Augusts', 'Septembris', 'Oktobris', 'Novembris', 'Decembris'],
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jūn', 'Jūl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
+-    weekStart: 1,
+-    startView: 0,
+-    yearFirst: false,
+-    yearSuffix: ''
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js"
+deleted file mode 100644
+index b7a9d5d5d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['nb-NO'] = {
+-    format: 'dd-mm-yyyy',
+-    days: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
+-    daysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
+-    daysMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
+-    weekStart: 1,
+-    months: ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember'],
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js"
+deleted file mode 100644
+index c76a8d97f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['nl-NL'] = {
+-    format: 'dd-mm-yyyy',
+-    days: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
+-    daysShort: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
+-    daysMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
+-    weekStart: 1,
+-    months: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js"
+deleted file mode 100644
+index 7b5501c1e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['oc-FR'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['Dimenge', 'Diluns', 'Dimars', 'Dimècres', 'Dijòus', 'Divendres', 'Dissabte'],
+-    daysShort: ['Dg', 'Dl', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds'],
+-    daysMin: ['dg', 'dl', 'dm', 'dc', 'dj', 'dv', 'ds'],
+-    weekStart: 1,
+-    months: ['Genièr', 'Febrièr', 'Març', 'Abrial', 'Mai', 'Junh', 'Julhet', 'Agost', 'Setembre', 'Octòbre', 'Novembre', 'Decembre'],
+-    monthsShort: ['Gen', 'Feb', 'Març', 'Abr', 'Mai', 'Junh', 'Julh', 'Ago', 'Set', 'Oct', 'Nov', 'Dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js"
+deleted file mode 100644
+index 271d58001..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js"
++++ /dev/null
+@@ -1,18 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['pl-PL'] = {
+-    format: 'dd.mm.YYYY',
+-    days: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
+-    daysShort: ['Niedz', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],
+-    // Used and correct are only daysShort, daysMin are just shorted to fit UI
+-    daysMin: ['Nie', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],
+-    weekStart: 1,
+-    months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
+-    monthsShort: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js"
+deleted file mode 100644
+index e8f86e0c5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js"
++++ /dev/null
+@@ -1,16 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['pt-BR'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
+-    daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
+-    daysMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
+-    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
+-    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js"
+deleted file mode 100644
+index 0380e813d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js"
++++ /dev/null
+@@ -1,20 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ru-RU'] = {
+-    format: 'dd.mm.YYYY',
+-    days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
+-    daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
+-    daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
+-    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
+-    monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
+-    weekStart: 1,
+-    startView: 0,
+-    yearFirst: false,
+-    yearSuffix: ''
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js"
+deleted file mode 100644
+index 6bc0832c5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['si-LK'] = {
+-    format: 'yyyy/mm/dd',
+-    days: ['ඉරිදා', 'සදුදා', 'අගහරුවදා', 'බදාදා', 'බ්‍රහස්පතින්දා', 'සිකුරාදා', 'සෙනසුරාදා'],
+-    daysShort: ['ඉරිදා', 'සදුදා', 'අග', 'බදාදා', 'බ්‍රහස්', 'සිකු', 'සෙන'],
+-    daysMin: ['ඉරිදා', 'සදුදා', 'අග', 'බදාදා', 'බ්‍රහස්', 'සිකු', 'සෙන'],
+-    weekStart: 1,
+-    months: ['ජනවාරි', 'පෙබරවාරි', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජුනි', 'ජූලි', 'අගෝස්තු', 'සැප්තැම්බර්', 'ඔක්තෝබර්', 'නොවැම්බර්', 'දෙසැම්බර්'],
+-    monthsShort: ['ජන', 'පෙබ', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජුනි', 'ජූලි', 'අගෝ', 'සැප්', 'ඔක්', 'නොවැ', 'දෙසැ']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js"
+deleted file mode 100644
+index 65a9f03a2..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['sk-SK'] = {
+-    format: 'dd.mm.YYYY',
+-    days: ['Nedeľa', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota'],
+-    daysShort: ['Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So'],
+-    daysMin: ['Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So'],
+-    weekStart: 1,
+-    months: ['Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl', 'August', 'September', 'Október', 'November', 'December'],
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js"
+deleted file mode 100644
+index 268e78aec..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['sv-SE'] = {
+-    format: 'yyyy-mm-dd',
+-    days: ['Söndag', 'Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag'],
+-    daysShort: ['Sön', 'Mån', 'Tis', 'Ons', 'Tor', 'Fre', 'Lör'],
+-    daysMin: ['Sö', 'Må', 'Ti', 'On', 'To', 'Fr', 'Lö'],
+-    weekStart: 1,
+-    months: ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'],
+-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js"
+deleted file mode 100644
+index f1e999617..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ta-TA'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['ஞாயிற்றுக்கிழமை','திங்கட்கிழமை','செவ்வாய்கிழமை','புதன்கிழமை','வியாழக்கிழமை','வெள்ளிக்கிழமை','சனிக்கிழமை'],
+-    daysShort: ['ஞாயிறு','திங்கள்','செவ்வாய்','புதன்','வியாழன்','வெள்ளி','சனி'],
+-    daysMin: ['ஞா','தி','செ','பு','வி','வெ','ச'],
+-    weekStart: 1,
+-    months: ['ஜனவரி','பிப்ரவரி','மார்ச்','ஏப்ரல்','மே','ஜூன்','ஜூலை','ஆகஸ்ட்','செப்டெம்பர்','அக்டோபர்','நவம்பர்','டிசம்பர்'],
+-    monthsShort: ['ஜன', 'பிப்', 'மார்', 'ஏப்', 'மே', 'ஜூன்', 'ஜூலை', 'ஆக', 'செப்', 'அக்', 'நவ', 'டிச']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js"
+deleted file mode 100644
+index 582ccc8ac..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['th-TH'] = {
+-    format: 'dd/mm/yyyy',
+-    days: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
+-    daysShort: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
+-    daysMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
+-    weekStart: 1,
+-    months: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
+-    monthsShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js"
+deleted file mode 100644
+index 1b60f662a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js"
++++ /dev/null
+@@ -1,17 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['tr-TR'] = {
+-    format: 'dd.mm.yyyy',
+-    days: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
+-    daysShort: ['Paz', 'Pts', 'Sal', 'Çrş', 'Prş', 'Cum', 'Cts'],
+-    daysMin: ['P', 'P', 'S', 'Ç', 'P', 'C', 'C'],
+-    weekStart: 1,
+-    months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
+-    monthsShort: ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara']
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js"
+deleted file mode 100644
+index dae512001..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js"
++++ /dev/null
+@@ -1,18 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['ug-CN'] = {
+-    format: 'yyyy-mm-dd',
+-    days: ['يەكشەنبە', 'دۈشەنبە', 'سەيشەنبە', 'چارشەنبە', 'پەيشەنبە', 'جۈمە', 'شەنبە'],
+-    daysShort: ['ي', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
+-    daysMin:  ['ي', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
+-    months: ['يانۋار', 'فېۋىرال', 'مارت', 'ئاپرىل', 'ماي', 'ئىيۇن', 'ئىيۇل', 'ئاۋغۇست', 'سىنتەبىر', 'ئۆكتەبىر', 'نويابىر', 'دىكابىر'],
+-    monthsShort: ['يانۋار', 'فېۋىرال', 'مارت', 'ئاپرىل', 'ماي', 'ئىيۇن', 'ئىيۇل', 'ئاۋغۇست', 'سىنتەبىر', 'ئۆكتەبىر', 'نويابىر', 'دىكابىر'],
+-    weekStart: 1,
+-    yearFirst: true,
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js"
+deleted file mode 100644
+index 1803b3b7b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js"
++++ /dev/null
+@@ -1,18 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['vi-VN'] = {
+-    days: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
+-    daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
+-    daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
+-    months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
+-    monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
+-    today: "Hôm nay",
+-    clear: "Xóa",
+-    format: "dd/mm/yyyy"
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js"
+deleted file mode 100644
+index 0fd1da6e3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js"
++++ /dev/null
+@@ -1,19 +0,0 @@
+-(function (global, factory) {
+-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
+-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
+-  (factory(global.jQuery));
+-}(this, (function ($) {
+-  'use strict';
+-
+-  $.fn.datepicker.languages['zh-CN'] = {
+-    format: 'yyyy年mm月dd日',
+-    days: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
+-    daysShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
+-    daysMin: ['日', '一', '二', '三', '四', '五', '六'],
+-    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
+-    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
+-    weekStart: 1,
+-    yearFirst: true,
+-    yearSuffix: '年'
+-  };
+-})));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html"
+deleted file mode 100644
+index eb7a4292b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html"
++++ /dev/null
+@@ -1,35 +0,0 @@
+-{% if REGISTRATION_AGE_REG_DISPLAY %}
+-	<dl>
+-		<dt><label for="registration_age_datepicker">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label></dt>
+-		<dd>
+-		{% if REGISTRATION_AGE_DATEPICKER %}
+-			{#
+-				left side: phpBB USER_LANG language variable, see common.php of respective language
+-				right side: language-country code in i18n filenames, see ext/leinad4mind/specialbirthday/styles/all/template/datepicker/i18n
+-			#}
+-			{% set datepicker_lang_map = {
+-				'en-gb'		: 'en-GB',
+-				'en-us' 	: 'en-US',
+-				'pt'		: 'pt-PT',
+-				'pt_preao'	: 'pt-PT',
+-				'pt_br'		: 'pt-BR',
+-				'es'		: 'es-ES',
+-				'es-x-tu'	: 'es-ES',
+-			} %}
+-			{% set datepicker_lang = datepicker_lang_map[lang('USER_LANG')] | default('en-GB') %}
+-			{% INCLUDECSS '@leinad4mind_specialbirthday/datepicker/datepicker.min.css' %}
+-			{% INCLUDEJS '@leinad4mind_specialbirthday/datepicker/datepicker.min.js' %}
+-			{% INCLUDEJS '@leinad4mind_specialbirthday/datepicker/i18n/datepicker.' ~ datepicker_lang ~ '.js' %}
+-			{% INCLUDEJS '@leinad4mind_specialbirthday/js/common.js' %}
+-			<input type="text" name="registration_age_datepicker" id="registration_age_datepicker" class="inputbox autowidth" size="25" tabindex="6" readonly data-lang="{{ datepicker_lang }}">
+-			<input type="hidden" name="registration_age_day" id="registration_age_day" value="">
+-			<input type="hidden" name="registration_age_month" id="registration_age_month" value="">
+-			<input type="hidden" name="registration_age_year" id="registration_age_year" value="">
+-		{% else  %}
+-			{{ lang('DAY') ~ lang('COLON') }} <select id="registration_age_datepicker" name="registration_age_day">{{ S_BIRTHDAY_DAY_OPTIONS }}</select>
+-			{{ lang('MONTH') ~ lang('COLON') }} <select name="registration_age_month">{{ S_BIRTHDAY_MONTH_OPTIONS }}</select>
+-			{{ lang('YEAR') ~ lang('COLON') }} <select name="registration_age_year">{{ S_BIRTHDAY_YEAR_OPTIONS }}</select>
+-		{% endif  %}
+-		</dd>
+-	</dl>
+-{% endif  %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html"
+new file mode 100644
+index 000000000..710e40187
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html"
+@@ -0,0 +1,11 @@
++{% if REGISTRATION_AGE_REG_DISPLAY %}
++	{% INCLUDECSS '@leinad4mind_specialbirthday/specialbirthday.css' %}
++	<dl>
++		<dt><label for="birthdate">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label></dt>
++		<dd>
++			{{ lang('DAY') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_day" type="number" maxlength="2" name="registration_age_day" value="{{ REGISTRATION_AGE_DAY }}" min="1" max="31" />
++			{{ lang('MONTH') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_month" type="number" maxlength="2" name="registration_age_month" value="{{ REGISTRATION_AGE_MONTH }}" min="1" max="12" />
++			{{ lang('YEAR') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_year" type="number" maxlength="4" name="registration_age_year" value="{{ REGISTRATION_AGE_YEAR }}" min="{{ YEAR_START }}" max="{{ YEAR_END }}" step="-1"/>
++		</dd>
++	</dl>
++{% endif  %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html"
+deleted file mode 100644
+index 0b490bbe3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if postrow.POSTER_AGE %}
+-	<dd class="profile-joined"><strong>{{ lang('AGE') }}{{ lang('COLON') }} {{ postrow.POSTER_AGE }}</strong></dd>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/js/common.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/js/common.js"
+deleted file mode 100644
+index b7b6632b7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/js/common.js"
++++ /dev/null
+@@ -1,18 +0,0 @@
+-jQuery(function($) {
+-    let $element = $('#registration_age_datepicker');
+-    $element.datepicker({
+-        autoShow: false,
+-        autoHide: true,
+-        autoPick: false,
+-        inline: false,
+-        language: $element.data('lang'),
+-        date: new Date(),
+-        startDate: new Date(1900, 0, 1),
+-        endDate: new Date(),
+-        startView: 2
+-    }).on('pick.datepicker', function(e) {
+-        $('#registration_age_day').val(e.date.getUTCDate());
+-        $('#registration_age_month').val(e.date.getUTCMonth() + 1);
+-        $('#registration_age_year').val(e.date.getUTCFullYear());
+-    });
+-});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/theme/specialbirthday.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/theme/specialbirthday.css"
+new file mode 100644
+index 000000000..cedf5f896
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/theme/specialbirthday.css"
+@@ -0,0 +1,7 @@
++/**
++* specialbirthday.css
++**/
++
++input[type="number"] {
++	max-width: 60px;
++}
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\specialbirthday/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/diff_nospace.tmp"
@@ -0,0 +1,3510 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+index 5f2a6c69d..e55c0c1c0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+index 3c65b6b71..42eef6cad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+index 86676c1c5..ab33d67f0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+index d19a417d9..2976f7ce1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+index 5967d6fd5..8ce2b3d4a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+@@ -21,16 +21,6 @@
+ 			</dd>
+ 		</dl>
+ 
+-		<dl>
+-			<dt><label for="registration_age_datepicker">{{ lang('REGISTRATION_AGE_DATEPICKER') }}{{ lang('COLON') }}</label></dt>
+-			<dd>
+-				<input type="radio" id="registration_age_datepicker1" name="registration_age_datepicker" value="1"{% if REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
+-				<label class="set" for="registration_age_datepicker1">{{ lang('YES') }}</label>
+-				<input type="radio" id="registration_age_datepicker0" name="registration_age_datepicker" value="0"{% if not REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
+-				<label class="unset" for="registration_age_datepicker0">{{ lang('NO') }}</label>
+-			</dd>
+-		</dl>
+-
+ 		<dl>
+ 			<dt><label for="registration_age_required">{{ lang('REGISTRATION_AGE_REQUIRED') }}{{ lang('COLON') }}</label></dt>
+ 			<dd>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
+index 4bb9d2ecb..cabfeefa2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
+@@ -1,10 +1,10 @@
+ {
+     "name": "leinad4mind/specialbirthday",
+     "type": "phpbb-extension",
+-    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birth-date upon registration, checks if the date is equal or greater than a minimum age and much much more...",
+-    "version": "1.1.1",
+-    "time": "2020-05-07",
+-    "keywords": [ "phpbb", "extension", "age", "special", "birthday", "registration"],
++    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birthdate upon registration, checks if the date is equal or greater than a minimum age and much much more...",
++    "version": "1.0.1",
++    "time": "2020-02-29",
++    "keywords": [ "phpbb", "extension", "age", "special", "birthdate", "registration"],
+     "license": "GPL-2.0",
+     "authors": [
+         {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+index f6fe8f236..64ab12411 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -137,7 +138,6 @@ class admin_controller implements admin_interface
+ 			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
+ 			'REGISTRATION_AGE_REQUIRED'		=> isset($this->config['registration_age_required']) ? $this->config['registration_age_required'] : '',
+ 			'REGISTRATION_AGE_REG_DISPLAY'	=> isset($this->config['registration_age_reg_display']) ? $this->config['registration_age_reg_display'] : '',
+-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
+ 			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
+ 			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
+ 			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
+@@ -163,7 +163,6 @@ class admin_controller implements admin_interface
+ 		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
+ 		$this->config->set('registration_age_required', $this->request->variable('registration_age_required', 0));
+ 		$this->config->set('registration_age_reg_display', $this->request->variable('registration_age_reg_display', 0));
+-		$this->config->set('registration_age_datepicker', $this->request->variable('registration_age_datepicker', 0));
+ 		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
+ 		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
+ 		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', '', true));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
+index d3e06e8fe..6ffc325b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
+index 4b180eb0f..12c109907 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+@@ -85,7 +86,7 @@ class data_controller implements data_interface
+ 	public function display_output()
+ 	{
+ 		// Add the language file
+-		$this->language->add_lang('acp_data_registrationage', $this->functions->get_ext_namespace());
++		$this->language->add_lang('acp_data_specialbirthday', $this->functions->get_ext_namespace());
+ 
+ 		// Start initial var setup
+ 		$action			= $this->request->variable('action', '');
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
+index 2e8beaa48..b61166cb1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/friends.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/friends.php"
+index 7683909a4..f55f0d1f4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/friends.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/friends.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/functions.php"
+index 2d957b2ec..f1f1f060b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/functions.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/functions.php"
+@@ -1,4 +1,5 @@
+ <?php
++
+ /**
+ *
+ * @package Special Birthday
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp"
+new file mode 100644
+index 000000000..ff67e2c98
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp"
+@@ -0,0 +1,3351 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++index 5f2a6c69d..e55c0c1c0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++index 3c65b6b71..42eef6cad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++index 86676c1c5..ab33d67f0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++index d19a417d9..2976f7ce1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -25,4 +26,4 @@ class specialbirthday_module
++ 
++ 		$admin_controller->display_options();
++ 	}
++-}
++\ No newline at end of file
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++index 5967d6fd5..8ce2b3d4a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++@@ -21,16 +21,6 @@
++ 			</dd>
++ 		</dl>
++ 
++-		<dl>
++-			<dt><label for="registration_age_datepicker">{{ lang('REGISTRATION_AGE_DATEPICKER') }}{{ lang('COLON') }}</label></dt>
++-			<dd>
++-				<input type="radio" id="registration_age_datepicker1" name="registration_age_datepicker" value="1"{% if REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
++-				<label class="set" for="registration_age_datepicker1">{{ lang('YES') }}</label>
++-				<input type="radio" id="registration_age_datepicker0" name="registration_age_datepicker" value="0"{% if not REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
++-				<label class="unset" for="registration_age_datepicker0">{{ lang('NO') }}</label>
++-			</dd>
++-		</dl>
++-
++ 		<dl>
++ 			<dt><label for="registration_age_required">{{ lang('REGISTRATION_AGE_REQUIRED') }}{{ lang('COLON') }}</label></dt>
++ 			<dd>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
++index 4bb9d2ecb..cabfeefa2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
++@@ -1,10 +1,10 @@
++ {
++     "name": "leinad4mind/specialbirthday",
++     "type": "phpbb-extension",
++-    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birth-date upon registration, checks if the date is equal or greater than a minimum age and much much more...",
++-    "version": "1.1.1",
++-    "time": "2020-05-07",
++-    "keywords": [ "phpbb", "extension", "age", "special", "birthday", "registration"],
+++    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birthdate upon registration, checks if the date is equal or greater than a minimum age and much much more...",
+++    "version": "1.0.1",
+++    "time": "2020-02-29",
+++    "keywords": [ "phpbb", "extension", "age", "special", "birthdate", "registration"],
++     "license": "GPL-2.0",
++     "authors": [
++         {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++index f6fe8f236..64ab12411 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -137,7 +138,6 @@ class admin_controller implements admin_interface
++ 			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
++ 			'REGISTRATION_AGE_REQUIRED'		=> isset($this->config['registration_age_required']) ? $this->config['registration_age_required'] : '',
++ 			'REGISTRATION_AGE_REG_DISPLAY'	=> isset($this->config['registration_age_reg_display']) ? $this->config['registration_age_reg_display'] : '',
++-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
++ 			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
++ 			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
++ 			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
++@@ -163,7 +163,6 @@ class admin_controller implements admin_interface
++ 		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
++ 		$this->config->set('registration_age_required', $this->request->variable('registration_age_required', 0));
++ 		$this->config->set('registration_age_reg_display', $this->request->variable('registration_age_reg_display', 0));
++-		$this->config->set('registration_age_datepicker', $this->request->variable('registration_age_datepicker', 0));
++ 		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
++ 		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
++ 		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', '', true));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
++index d3e06e8fe..6ffc325b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
++index 4b180eb0f..12c109907 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_controller.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -85,7 +86,7 @@ class data_controller implements data_interface
++ 	public function display_output()
++ 	{
++ 		// Add the language file
++-		$this->language->add_lang('acp_data_registrationage', $this->functions->get_ext_namespace());
+++		$this->language->add_lang('acp_data_specialbirthday', $this->functions->get_ext_namespace());
++ 
++ 		// Start initial var setup
++ 		$action			= $this->request->variable('action', '');
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
++index 2e8beaa48..b61166cb1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/data_interface.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/friends.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/friends.php"
++index 7683909a4..f55f0d1f4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/friends.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/friends.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/functions.php"
++index 2d957b2ec..f1f1f060b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/core/functions.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/core/functions.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp"
++new file mode 100644
++index 000000000..11efd0251
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/diff_full.tmp"
++@@ -0,0 +1,116 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+++index 5f2a6c69d..e55c0c1c0 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_info.php"
+++@@ -1,4 +1,5 @@
+++ <?php
++++
+++ /**
+++ *
+++ * @package Special Birthday
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+++index 3c65b6b71..42eef6cad 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_data_module.php"
+++@@ -1,4 +1,5 @@
+++ <?php
++++
+++ /**
+++ *
+++ * @package Special Birthday
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+++index 86676c1c5..ab33d67f0 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_info.php"
+++@@ -1,4 +1,5 @@
+++ <?php
++++
+++ /**
+++ *
+++ * @package Special Birthday
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+++index d19a417d9..2976f7ce1 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/acp/specialbirthday_module.php"
+++@@ -1,4 +1,5 @@
+++ <?php
++++
+++ /**
+++ *
+++ * @package Special Birthday
+++@@ -25,4 +26,4 @@ class specialbirthday_module
+++ 
+++ 		$admin_controller->display_options();
+++ 	}
+++-}
+++\ No newline at end of file
++++}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+++index 5967d6fd5..8ce2b3d4a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/adm/style/specialbirthday.html"
+++@@ -21,16 +21,6 @@
+++ 			</dd>
+++ 		</dl>
+++ 
+++-		<dl>
+++-			<dt><label for="registration_age_datepicker">{{ lang('REGISTRATION_AGE_DATEPICKER') }}{{ lang('COLON') }}</label></dt>
+++-			<dd>
+++-				<input type="radio" id="registration_age_datepicker1" name="registration_age_datepicker" value="1"{% if REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
+++-				<label class="set" for="registration_age_datepicker1">{{ lang('YES') }}</label>
+++-				<input type="radio" id="registration_age_datepicker0" name="registration_age_datepicker" value="0"{% if not REGISTRATION_AGE_DATEPICKER %} checked="checked"{% endif %} />
+++-				<label class="unset" for="registration_age_datepicker0">{{ lang('NO') }}</label>
+++-			</dd>
+++-		</dl>
+++-
+++ 		<dl>
+++ 			<dt><label for="registration_age_required">{{ lang('REGISTRATION_AGE_REQUIRED') }}{{ lang('COLON') }}</label></dt>
+++ 			<dd>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
+++index 4bb9d2ecb..cabfeefa2 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/composer.json"
+++@@ -1,10 +1,10 @@
+++ {
+++     "name": "leinad4mind/specialbirthday",
+++     "type": "phpbb-extension",
+++-    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birth-date upon registration, checks if the date is equal or greater than a minimum age and much much more...",
+++-    "version": "1.1.1",
+++-    "time": "2020-05-07",
+++-    "keywords": [ "phpbb", "extension", "age", "special", "birthday", "registration"],
++++    "description": "Give you the ability to make the birth date a required field, adds an option to enter a birthdate upon registration, checks if the date is equal or greater than a minimum age and much much more...",
++++    "version": "1.0.1",
++++    "time": "2020-02-29",
++++    "keywords": [ "phpbb", "extension", "age", "special", "birthdate", "registration"],
+++     "license": "GPL-2.0",
+++     "authors": [
+++         {
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+++index f6fe8f236..64ab12411 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_controller.php"
+++@@ -1,4 +1,5 @@
+++ <?php
++++
+++ /**
+++ *
+++ * @package Special Birthday
+++@@ -137,7 +138,6 @@ class admin_controller implements admin_interface
+++ 			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
+++ 			'REGISTRATION_AGE_REQUIRED'		=> isset($this->config['registration_age_required']) ? $this->config['registration_age_required'] : '',
+++ 			'REGISTRATION_AGE_REG_DISPLAY'	=> isset($this->config['registration_age_reg_display']) ? $this->config['registration_age_reg_display'] : '',
+++-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
+++ 			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
+++ 			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
+++ 			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
+++@@ -163,7 +163,6 @@ class admin_controller implements admin_interface
+++ 		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
+++ 		$this->config->set('registration_age_required', $this->request->variable('registration_age_required', 0));
+++ 		$this->config->set('registration_age_reg_display', $this->request->variable('registration_age_reg_display', 0));
+++-		$this->config->set('registration_age_datepicker', $this->request->variable('registration_age_datepicker', 0));
+++ 		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
+++ 		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
+++ 		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', '', true));
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/controller/admin_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/controller/admin_interface.php"
+++index d3e06e8fe..6ffc325b1 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/event/listener.php"
++index e48014bd7..afa552411 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/event/listener.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -131,7 +132,6 @@ class listener implements EventSubscriberInterface
++ 		$this->template->assign_vars([
++ 			'REGISTRATION_AGE_REQUIRED'		=> $this->config['registration_age_required'],
++ 			'REGISTRATION_AGE_REG_DISPLAY'	=> $this->config['registration_age_reg_display'],
++-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
++ 			'REGISTRATION_AGE_DAY'			=> $today->format('d'),
++ 			'REGISTRATION_AGE_MONTH'		=> $today->format('m'),
++ 			'REGISTRATION_AGE_YEAR'			=> $today->format('Y'),
++@@ -139,45 +139,11 @@ class listener implements EventSubscriberInterface
++ 			'YEAR_END' 						=> $today->format('Y'),
++ 		]);
++ 
++-		$data = [
++-			'registration_age_day'		=> $this->request->variable('registration_age_day', 0),
++-			'registration_age_month'	=> $this->request->variable('registration_age_month', 0),
++-			'registration_age_year'		=> $this->request->variable('registration_age_year', 0),
++-		];
++-
++-		if (!$this->config['registration_age_datepicker'])
++-		{
++-			$s_birthday_day_options = '<option value="0"' . ((!$data['registration_age_day']) ? ' selected="selected"' : '') . '>--</option>';
++-			for ($i = 1; $i < 32; $i++)
++-			{
++-				$selected = ($i == $data['registration_age_day']) ? ' selected="selected"' : '';
++-				$s_birthday_day_options .= "<option value=\"$i\"$selected>$i</option>";
++-			}
++-
++-			$s_birthday_month_options = '<option value="0"' . ((!$data['registration_age_month']) ? ' selected="selected"' : '') . '>--</option>';
++-			for ($i = 1; $i < 13; $i++)
++-			{
++-				$selected = ($i == $data['registration_age_month']) ? ' selected="selected"' : '';
++-				$s_birthday_month_options .= "<option value=\"$i\"$selected>$i</option>";
++-			}
++-
++-			$now = getdate();
++-			$s_birthday_year_options = '<option value="0"' . ((!$data['registration_age_year']) ? ' selected="selected"' : '') . '>--</option>';
++-			for ($i = $now['year'] - 100; $i <= $now['year']; $i++)
++-			{
++-				$selected = ($i == $data['registration_age_year']) ? ' selected="selected"' : '';
++-				$s_birthday_year_options .= "<option value=\"$i\"$selected>$i</option>";
++-			}
++-			unset($now);
++-
++-			$this->template->assign_vars([
++-				'S_BIRTHDAY_DAY_OPTIONS'	=> $s_birthday_day_options,
++-				'S_BIRTHDAY_MONTH_OPTIONS'	=> $s_birthday_month_options,
++-				'S_BIRTHDAY_YEAR_OPTIONS'	=> $s_birthday_year_options,
++-			]);
++-		}
++-
++-		$event['data'] = array_merge($event['data'], $data);
+++		$event['data'] = array_merge($event['data'], [
+++			'registration_age_day'		=> $this->request->variable('registration_age_day', ''),
+++			'registration_age_month'	=> $this->request->variable('registration_age_month', ''),
+++			'registration_age_year'		=> $this->request->variable('registration_age_year', ''),
+++		]);
++ 	}
++ 
++ 	/**
++@@ -202,11 +168,7 @@ class listener implements EventSubscriberInterface
++ 		if ($this->config['registration_age_reg_display'])
++ 		{
++ 			// Make sure that there is valid birthdate date entered in all fields before going any further
++-			if (
++-				!is_numeric($data['registration_age_day']) || !$data['registration_age_day'] ||
++-				!is_numeric($data['registration_age_month']) || !$data['registration_age_month'] ||
++-				!is_numeric($data['registration_age_year']) || !$data['registration_age_year']
++-			)
+++			if (!is_numeric($data['registration_age_day']) || !is_numeric($data['registration_age_month']) || !is_numeric($data['registration_age_year']))
++ 			{
++ 				if ($this->config['registration_age_required'])
++ 				{
++@@ -232,7 +194,7 @@ class listener implements EventSubscriberInterface
++ 						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_LOG_FAIL', time(), array($data['username'], $user_age));
++ 					}
++ 
++-					if ($this->config['registration_age_ip'])
+++					if ($this->config['registration_age_ip'] && count($error) === 0)
++ 					{
++ 						user_ban('ip', $this->user->ip, $this->config['registration_age_ban_length'], '', 0, $this->language->lang('BAN_REASON'), $this->config['registration_age_ban_reason']);
++ 						$this->user->check_ban(false, $this->user->ip);
++@@ -336,7 +298,7 @@ class listener implements EventSubscriberInterface
++ 	{
++ 		if ($this->is_valid_birthday($this->user->data['user_birthday']))
++ 		{
++-			if ($this->user->data['user_birthday'] != $event['data']['user_birthday'])
+++			if ( strtotime(str_replace(' ', '', $this->user->data['user_birthday'])) != strtotime(str_replace(' ', '', $event['data']['user_birthday'])) )
++ 			{
++ 				if ($this->config['registration_age_change'])
++ 				{
++@@ -488,7 +450,7 @@ class listener implements EventSubscriberInterface
++ 	{
++ 		if (!$birthday)
++ 		{
++-			return true;
+++			return false;
++ 		}
++ 
++ 		list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthday));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/ext.php"
++index 23a564bb3..49babfaf0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/ext.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
++index 7a2fecb1d..347c6a37d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
++index 2b343f402..6992518bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -52,12 +53,11 @@ $lang = array_merge($lang, array(
++ 	'REGISTRATION_AGE_EXPLAIN'				=> 'Select the age at which you want to limit access.',
++ 	'REGISTRATION_AGE_REQUIRED'				=> 'Users are required to enter their birthday',
++ 	'REGISTRATION_AGE_REG_DISPLAY'			=> 'Display birthday field on registration',
++-	'REGISTRATION_AGE_DATEPICKER'			=> 'Use datepicker instead of select elements to pick the date when registering',
++ 	'REGISTRATION_AGE_IP'					=> 'Block IP',
++ 	'REGISTRATION_AGE_IP_EXPLAIN'			=> 'Ban the IP address for the user attempting to register under age.',
++ 	'REGISTRATION_AGE_LOG'					=> 'Log failed attempts',
++ 	'REGISTRATION_AGE_LOG_EXPLAIN'			=> 'Create a log entry for any attempted registrations that fail due to an incorrect age being entered.',
++-	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthday options',
+++	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthdate options',
++ 
++ 	'BAN_END_TEXT' => array(
++ 		'0' 	=> 'Permanent',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
++index 50b9e1f2c..0478370bd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
++index 83fd11794..325aaeb8b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++@@ -39,10 +40,10 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, array(
++ 	'ACP_USER_UTILS'					=> 'User utilities',
++ 
++-	'REGISTRATION_AGE'					=> 'Special Birthday',
++-	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthday Settings Updated</strong>',
++-	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthday',
++-	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthday check failed</strong><br>» %1$s entered an age of %2$s',
+++	'REGISTRATION_AGE'					=> 'Special Birthdate',
+++	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthdate Settings Updated</strong>',
+++	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthdate',
+++	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthdate check failed</strong><br>» %1$s entered an age of %2$s',
++ 	'REGISTRATION_AGE_CHANGED'			=> '<strong>Birthday changed</strong><br>» from %1$s to %2$s',
++ 	'REGISTRATION_AGE_CHANGE_ATTEMPT'	=> '<strong>Attempted to change birthday</strong><br>» to %1$s, age: %2$d',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
++index 104cbd4a4..01fe7856c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/change_age.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/change_age.php"
++index c85d6ea1e..ef4af4b28 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/change_age.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/change_age.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/datepicker_option.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/datepicker_option.php"
++deleted file mode 100644
++index 30c593291..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/datepicker_option.php"
+++++ /dev/null
++@@ -1,22 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Special Birthday
++-* @copyright (c) 2016 leinad4mind
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-namespace leinad4mind\specialbirthday\migrations;
++-
++-use phpbb\db\migration\migration;
++-
++-class datepicker_option extends migration
++-{
++-	public function update_data()
++-	{
++-		return [
++-			['config.add', ['registration_age_datepicker', 0]],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/display_options.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/display_options.php"
++index 751328584..2583165c7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/display_options.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/display_options.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php"
++index 9d2f3761e..1af52b673 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_age_required.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_display.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_display.php"
++index 4d18697a6..e1f74c7f5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/registration_display.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/registration_display.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
++index 5ff77521e..c8ce9d4fb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
++index 11dde139a..a9ed75ff4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
++@@ -1,4 +1,5 @@
++ <?php
+++
++ /**
++ *
++ * @package Special Birthday
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
++new file mode 100644
++index 000000000..64b756dfd
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
++@@ -0,0 +1,24 @@
+++{% if S_REGISTRATION_AGE_PROFILE %}
+++	<div class="control-group">
+++		<label class="control-label">{{ lang('REGISTRATION_AGE_PROFILE') ~ lang('COLON') }}</label>
+++		<div class="controls controls-row">
+++			<div class="clearfix">
+++				<div class="col-md-2">
+++					<label for="user_registration_age_profile_0">
+++						<input type="radio" id="user_registration_age_profile_0" name="user_registration_age_profile" value="0"{{ not REGISTRATION_AGE_PROFILE ? ' checked' }}> {{ lang('REGISTRATION_AGE_NOBODY') }}
+++					</label>
+++				</div>
+++				<div class="col-md-2">
+++					<label for="user_registration_age_profile_1">
+++						<input type="radio" id="user_registration_age_profile_1" name="user_registration_age_profile" value="1"{{ REGISTRATION_AGE_PROFILE == 1 ? ' checked' }}> {{ lang('REGISTRATION_AGE_EVERYBODY') }}
+++					</label>
+++				</div>
+++				<div class="col-md-3">
+++					<label for="user_registration_age_profile_2">
+++						<input type="radio" id="user_registration_age_profile_2" name="user_registration_age_profile" value="2"{{ REGISTRATION_AGE_PROFILE == 2 ? ' checked' }}> {{ lang('REGISTRATION_AGE_FRIENDS') }}
+++					</label>
+++				</div>
+++			</div>
+++		</div>
+++	</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
++new file mode 100644
++index 000000000..47f15e268
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
++@@ -0,0 +1,27 @@
+++{% if REGISTRATION_AGE_REG_DISPLAY %}
+++	{% INCLUDECSS '@leinad4mind_specialbirthday/specialbirthday.css' %}
+++	<div class="col-md-6">
+++		<div class="form-group"> 
+++			<div class="control-group">
+++				<label class="control-label" for="birthdate">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label>
+++				<div class="controls controls-row">
+++					<div class="clearfix">
+++						<div class="d-flex col-md-3">
+++							<label for="registration_age_day" class="control-label mr-1">{{ lang('DAY') }}</label>
+++							<input class="form-control" type="number" name="registration_age_day" id="registration_age_day" size="25" maxlength="2" value="{{ REGISTRATION_AGE_DAY }}" placeholder="{{ lang('DAY') }}" min="1" max="31" />
+++						</div>
+++						<div class="d-flex col-md-3">
+++							<label for="registration_age_month" class="control-label mr-1">{{ lang('MONTH') }}</label>
+++							<input class="form-control" type="number" name="registration_age_month" id="registration_age_month" size="25" maxlength="2" value="{{ REGISTRATION_AGE_MONTH }}" placeholder="{{ lang('MONTH') }}" min="1" max="12" />
+++							
+++						</div>
+++						<div class="d-flex col-md-3">
+++							<label for="registration_age_year" class="control-label mr-1">{{ lang('YEAR') }}</label>
+++							<input class="form-control" type="number" name="registration_age_year" id="registration_age_year" size="25" maxlength="4" value="{{ REGISTRATION_AGE_YEAR }}" placeholder="{{ lang('YEAR') }}" min="{{ YEAR_START }}" max="{{ YEAR_END }}" step="-1" />
+++						</div>
+++					</div>
+++				</div>
+++			</div>
+++		</div>
+++	</div>
+++{% endif  %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak"
++new file mode 100644
++index 000000000..8200b9553
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak"
++@@ -0,0 +1,3 @@
+++{% if postrow.POSTER_AGE %}
+++	<li><strong>{{ lang('AGE') }}{{ lang('COLON') }}</strong> {{ postrow.POSTER_AGE }}</li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css"
++new file mode 100644
++index 000000000..6382c78e6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css"
++@@ -0,0 +1,14 @@
+++/**
+++* specialbirthday.css
+++**/
+++
+++input[type="number"] {
+++	min-width: 70px;
+++}
+++.d-flex {
+++	display: -ms-flexbox!important;
+++	display: flex!important;
+++}
+++.mr-1 {
+++	margin-right: 1rem;
+++}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css"
++deleted file mode 100644
++index 30eb43f1b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css"
+++++ /dev/null
++@@ -1,206 +0,0 @@
++-/*!
++- * Datepicker v1.0.9
++- * https://fengyuanchen.github.io/datepicker
++- *
++- * Copyright 2014-present Chen Fengyuan
++- * Released under the MIT license
++- *
++- * Date: 2019-09-21T06:57:30.334Z
++- */
++-
++-.datepicker-container {
++-  background-color: #fff;
++-  direction: ltr;
++-  font-size: 12px;
++-  left: 0;
++-  line-height: 30px;
++-  position: fixed;
++-  -webkit-tap-highlight-color: transparent;
++-  top: 0;
++-  -ms-touch-action: none;
++-  touch-action: none;
++-  -webkit-touch-callout: none;
++-  -webkit-user-select: none;
++-  -moz-user-select: none;
++-  -ms-user-select: none;
++-  user-select: none;
++-  width: 210px;
++-  z-index: -1;
++-}
++-
++-.datepicker-container::before,
++-.datepicker-container::after {
++-  border: 5px solid transparent;
++-  content: " ";
++-  display: block;
++-  height: 0;
++-  position: absolute;
++-  width: 0;
++-}
++-
++-.datepicker-dropdown {
++-  border: 1px solid #ccc;
++-  -webkit-box-shadow: 0 3px 6px #ccc;
++-  box-shadow: 0 3px 6px #ccc;
++-  -webkit-box-sizing: content-box;
++-  box-sizing: content-box;
++-  position: absolute;
++-  z-index: 1;
++-}
++-
++-.datepicker-inline {
++-  position: static;
++-}
++-
++-.datepicker-top-left,
++-.datepicker-top-right {
++-  border-top-color: #39f;
++-}
++-
++-.datepicker-top-left::before,
++-.datepicker-top-left::after,
++-.datepicker-top-right::before,
++-.datepicker-top-right::after {
++-  border-top: 0;
++-  left: 10px;
++-  top: -5px;
++-}
++-
++-.datepicker-top-left::before,
++-.datepicker-top-right::before {
++-  border-bottom-color: #39f;
++-}
++-
++-.datepicker-top-left::after,
++-.datepicker-top-right::after {
++-  border-bottom-color: #fff;
++-  top: -4px;
++-}
++-
++-.datepicker-bottom-left,
++-.datepicker-bottom-right {
++-  border-bottom-color: #39f;
++-}
++-
++-.datepicker-bottom-left::before,
++-.datepicker-bottom-left::after,
++-.datepicker-bottom-right::before,
++-.datepicker-bottom-right::after {
++-  border-bottom: 0;
++-  bottom: -5px;
++-  left: 10px;
++-}
++-
++-.datepicker-bottom-left::before,
++-.datepicker-bottom-right::before {
++-  border-top-color: #39f;
++-}
++-
++-.datepicker-bottom-left::after,
++-.datepicker-bottom-right::after {
++-  border-top-color: #fff;
++-  bottom: -4px;
++-}
++-
++-.datepicker-top-right::before,
++-.datepicker-top-right::after,
++-.datepicker-bottom-right::before,
++-.datepicker-bottom-right::after {
++-  left: auto;
++-  right: 10px;
++-}
++-
++-.datepicker-panel > ul {
++-  margin: 0;
++-  padding: 0;
++-  width: 102%;
++-}
++-
++-.datepicker-panel > ul::before,
++-.datepicker-panel > ul::after {
++-  content: " ";
++-  display: table;
++-}
++-
++-.datepicker-panel > ul::after {
++-  clear: both;
++-}
++-
++-.datepicker-panel > ul > li {
++-  background-color: #fff;
++-  cursor: pointer;
++-  float: left;
++-  height: 30px;
++-  list-style: none;
++-  margin: 0;
++-  padding: 0;
++-  text-align: center;
++-  width: 30px;
++-}
++-
++-.datepicker-panel > ul > li:hover {
++-  background-color: rgb(229, 242, 255);
++-}
++-
++-.datepicker-panel > ul > li.muted,
++-.datepicker-panel > ul > li.muted:hover {
++-  color: #999;
++-}
++-
++-.datepicker-panel > ul > li.highlighted {
++-  background-color: rgb(229, 242, 255);
++-}
++-
++-.datepicker-panel > ul > li.highlighted:hover {
++-  background-color: rgb(204, 229, 255);
++-}
++-
++-.datepicker-panel > ul > li.picked,
++-.datepicker-panel > ul > li.picked:hover {
++-  color: #39f;
++-}
++-
++-.datepicker-panel > ul > li.disabled,
++-.datepicker-panel > ul > li.disabled:hover {
++-  background-color: #fff;
++-  color: #ccc;
++-  cursor: default;
++-}
++-
++-.datepicker-panel > ul > li.disabled.highlighted,
++-.datepicker-panel > ul > li.disabled:hover.highlighted {
++-  background-color: rgb(229, 242, 255);
++-}
++-
++-.datepicker-panel > ul > li[data-view="years prev"],
++-.datepicker-panel > ul > li[data-view="year prev"],
++-.datepicker-panel > ul > li[data-view="month prev"],
++-.datepicker-panel > ul > li[data-view="years next"],
++-.datepicker-panel > ul > li[data-view="year next"],
++-.datepicker-panel > ul > li[data-view="month next"],
++-.datepicker-panel > ul > li[data-view="next"] {
++-  font-size: 18px;
++-}
++-
++-.datepicker-panel > ul > li[data-view="years current"],
++-.datepicker-panel > ul > li[data-view="year current"],
++-.datepicker-panel > ul > li[data-view="month current"] {
++-  width: 150px;
++-}
++-
++-.datepicker-panel > ul[data-view="years"] > li,
++-.datepicker-panel > ul[data-view="months"] > li {
++-  height: 52.5px;
++-  line-height: 52.5px;
++-  width: 52.5px;
++-}
++-
++-.datepicker-panel > ul[data-view="week"] > li,
++-.datepicker-panel > ul[data-view="week"] > li:hover {
++-  background-color: #fff;
++-  cursor: default;
++-}
++-
++-.datepicker-hide {
++-  display: none;
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js"
++deleted file mode 100644
++index ab7ec70fa..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js"
+++++ /dev/null
++@@ -1,1532 +0,0 @@
++-/*!
++- * Datepicker v1.0.9
++- * https://fengyuanchen.github.io/datepicker
++- *
++- * Copyright 2014-present Chen Fengyuan
++- * Released under the MIT license
++- *
++- * Date: 2019-09-21T06:57:34.100Z
++- */
++-
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (global = global || self, factory(global.jQuery));
++-}(this, function ($) { 'use strict';
++-
++-  $ = $ && $.hasOwnProperty('default') ? $['default'] : $;
++-
++-  function _classCallCheck(instance, Constructor) {
++-    if (!(instance instanceof Constructor)) {
++-      throw new TypeError("Cannot call a class as a function");
++-    }
++-  }
++-
++-  function _defineProperties(target, props) {
++-    for (var i = 0; i < props.length; i++) {
++-      var descriptor = props[i];
++-      descriptor.enumerable = descriptor.enumerable || false;
++-      descriptor.configurable = true;
++-      if ("value" in descriptor) descriptor.writable = true;
++-      Object.defineProperty(target, descriptor.key, descriptor);
++-    }
++-  }
++-
++-  function _createClass(Constructor, protoProps, staticProps) {
++-    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
++-    if (staticProps) _defineProperties(Constructor, staticProps);
++-    return Constructor;
++-  }
++-
++-  var DEFAULTS = {
++-    // Show the datepicker automatically when initialized
++-    autoShow: false,
++-    // Hide the datepicker automatically when picked
++-    autoHide: false,
++-    // Pick the initial date automatically when initialized
++-    autoPick: false,
++-    // Enable inline mode
++-    inline: false,
++-    // A element (or selector) for putting the datepicker
++-    container: null,
++-    // A element (or selector) for triggering the datepicker
++-    trigger: null,
++-    // The ISO language code (built-in: en-US)
++-    language: '',
++-    // The date string format
++-    format: 'mm/dd/yyyy',
++-    // The initial date
++-    date: null,
++-    // The start view date
++-    startDate: null,
++-    // The end view date
++-    endDate: null,
++-    // The start view when initialized
++-    startView: 0,
++-    // 0 for days, 1 for months, 2 for years
++-    // The start day of the week
++-    // 0 for Sunday, 1 for Monday, 2 for Tuesday, 3 for Wednesday,
++-    // 4 for Thursday, 5 for Friday, 6 for Saturday
++-    weekStart: 0,
++-    // Show year before month on the datepicker header
++-    yearFirst: false,
++-    // A string suffix to the year number.
++-    yearSuffix: '',
++-    // Days' name of the week.
++-    days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
++-    // Shorter days' name
++-    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
++-    // Shortest days' name
++-    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
++-    // Months' name
++-    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
++-    // Shorter months' name
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
++-    // A element tag for each item of years, months and days
++-    itemTag: 'li',
++-    // A class (CSS) for muted date item
++-    mutedClass: 'muted',
++-    // A class (CSS) for picked date item
++-    pickedClass: 'picked',
++-    // A class (CSS) for disabled date item
++-    disabledClass: 'disabled',
++-    // A class (CSS) for highlight date item
++-    highlightedClass: 'highlighted',
++-    // The template of the datepicker
++-    template: '<div class="datepicker-container">' + '<div class="datepicker-panel" data-view="years picker">' + '<ul>' + '<li data-view="years prev">&lsaquo;</li>' + '<li data-view="years current"></li>' + '<li data-view="years next">&rsaquo;</li>' + '</ul>' + '<ul data-view="years"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="months picker">' + '<ul>' + '<li data-view="year prev">&lsaquo;</li>' + '<li data-view="year current"></li>' + '<li data-view="year next">&rsaquo;</li>' + '</ul>' + '<ul data-view="months"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="days picker">' + '<ul>' + '<li data-view="month prev">&lsaquo;</li>' + '<li data-view="month current"></li>' + '<li data-view="month next">&rsaquo;</li>' + '</ul>' + '<ul data-view="week"></ul>' + '<ul data-view="days"></ul>' + '</div>' + '</div>',
++-    // The offset top or bottom of the datepicker from the element
++-    offset: 10,
++-    // The `z-index` of the datepicker
++-    zIndex: 1000,
++-    // Filter each date item (return `false` to disable a date item)
++-    filter: null,
++-    // Event shortcuts
++-    show: null,
++-    hide: null,
++-    pick: null
++-  };
++-
++-  var IS_BROWSER = typeof window !== 'undefined';
++-  var WINDOW = IS_BROWSER ? window : {};
++-  var IS_TOUCH_DEVICE = IS_BROWSER ? 'ontouchstart' in WINDOW.document.documentElement : false;
++-  var NAMESPACE = 'datepicker';
++-  var EVENT_CLICK = "click.".concat(NAMESPACE);
++-  var EVENT_FOCUS = "focus.".concat(NAMESPACE);
++-  var EVENT_HIDE = "hide.".concat(NAMESPACE);
++-  var EVENT_KEYUP = "keyup.".concat(NAMESPACE);
++-  var EVENT_PICK = "pick.".concat(NAMESPACE);
++-  var EVENT_RESIZE = "resize.".concat(NAMESPACE);
++-  var EVENT_SCROLL = "scroll.".concat(NAMESPACE);
++-  var EVENT_SHOW = "show.".concat(NAMESPACE);
++-  var EVENT_TOUCH_START = "touchstart.".concat(NAMESPACE);
++-  var CLASS_HIDE = "".concat(NAMESPACE, "-hide");
++-  var LANGUAGES = {};
++-  var VIEWS = {
++-    DAYS: 0,
++-    MONTHS: 1,
++-    YEARS: 2
++-  };
++-
++-  var toString = Object.prototype.toString;
++-  function typeOf(obj) {
++-    return toString.call(obj).slice(8, -1).toLowerCase();
++-  }
++-  function isString(value) {
++-    return typeof value === 'string';
++-  }
++-  var isNaN = Number.isNaN || WINDOW.isNaN;
++-  function isNumber(value) {
++-    return typeof value === 'number' && !isNaN(value);
++-  }
++-  function isUndefined(value) {
++-    return typeof value === 'undefined';
++-  }
++-  function isDate(value) {
++-    return typeOf(value) === 'date' && !isNaN(value.getTime());
++-  }
++-  function proxy(fn, context) {
++-    for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
++-      args[_key - 2] = arguments[_key];
++-    }
++-
++-    return function () {
++-      for (var _len2 = arguments.length, args2 = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
++-        args2[_key2] = arguments[_key2];
++-      }
++-
++-      return fn.apply(context, args.concat(args2));
++-    };
++-  }
++-  function selectorOf(view) {
++-    return "[data-view=\"".concat(view, "\"]");
++-  }
++-  function isLeapYear(year) {
++-    return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
++-  }
++-  function getDaysInMonth(year, month) {
++-    return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
++-  }
++-  function getMinDay(year, month, day) {
++-    return Math.min(day, getDaysInMonth(year, month));
++-  }
++-  var formatParts = /(y|m|d)+/g;
++-  function parseFormat(format) {
++-    var source = String(format).toLowerCase();
++-    var parts = source.match(formatParts);
++-
++-    if (!parts || parts.length === 0) {
++-      throw new Error('Invalid date format.');
++-    }
++-
++-    format = {
++-      source: source,
++-      parts: parts
++-    };
++-    $.each(parts, function (i, part) {
++-      switch (part) {
++-        case 'dd':
++-        case 'd':
++-          format.hasDay = true;
++-          break;
++-
++-        case 'mm':
++-        case 'm':
++-          format.hasMonth = true;
++-          break;
++-
++-        case 'yyyy':
++-        case 'yy':
++-          format.hasYear = true;
++-          break;
++-
++-        default:
++-      }
++-    });
++-    return format;
++-  }
++-  function getScrollParent(element) {
++-    var includeHidden = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
++-    var $element = $(element);
++-    var position = $element.css('position');
++-    var excludeStaticParent = position === 'absolute';
++-    var overflowRegex = includeHidden ? /auto|scroll|hidden/ : /auto|scroll/;
++-    var scrollParent = $element.parents().filter(function (index, parent) {
++-      var $parent = $(parent);
++-
++-      if (excludeStaticParent && $parent.css('position') === 'static') {
++-        return false;
++-      }
++-
++-      return overflowRegex.test($parent.css('overflow') + $parent.css('overflow-y') + $parent.css('overflow-x'));
++-    }).eq(0);
++-    return position === 'fixed' || !scrollParent.length ? $(element.ownerDocument || document) : scrollParent;
++-  }
++-  /**
++-   * Add leading zeroes to the given value
++-   * @param {number} value - The value to add.
++-   * @param {number} [length=1] - The expected value length.
++-   * @returns {string} Returns converted value.
++-   */
++-
++-  function addLeadingZero(value) {
++-    var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
++-    var str = String(Math.abs(value));
++-    var i = str.length;
++-    var result = '';
++-
++-    if (value < 0) {
++-      result += '-';
++-    }
++-
++-    while (i < length) {
++-      i += 1;
++-      result += '0';
++-    }
++-
++-    return result + str;
++-  }
++-
++-  var REGEXP_DIGITS = /\d+/g;
++-  var methods = {
++-    // Show the datepicker
++-    show: function show() {
++-      if (!this.built) {
++-        this.build();
++-      }
++-
++-      if (this.shown) {
++-        return;
++-      }
++-
++-      if (this.trigger(EVENT_SHOW).isDefaultPrevented()) {
++-        return;
++-      }
++-
++-      this.shown = true;
++-      this.$picker.removeClass(CLASS_HIDE).on(EVENT_CLICK, $.proxy(this.click, this));
++-      this.showView(this.options.startView);
++-
++-      if (!this.inline) {
++-        this.$scrollParent.on(EVENT_SCROLL, $.proxy(this.place, this));
++-        $(window).on(EVENT_RESIZE, this.onResize = proxy(this.place, this));
++-        $(document).on(EVENT_CLICK, this.onGlobalClick = proxy(this.globalClick, this));
++-        $(document).on(EVENT_KEYUP, this.onGlobalKeyup = proxy(this.globalKeyup, this));
++-
++-        if (IS_TOUCH_DEVICE) {
++-          $(document).on(EVENT_TOUCH_START, this.onTouchStart = proxy(this.touchstart, this));
++-        }
++-
++-        this.place();
++-      }
++-    },
++-    // Hide the datepicker
++-    hide: function hide() {
++-      if (!this.shown) {
++-        return;
++-      }
++-
++-      if (this.trigger(EVENT_HIDE).isDefaultPrevented()) {
++-        return;
++-      }
++-
++-      this.shown = false;
++-      this.$picker.addClass(CLASS_HIDE).off(EVENT_CLICK, this.click);
++-
++-      if (!this.inline) {
++-        this.$scrollParent.off(EVENT_SCROLL, this.place);
++-        $(window).off(EVENT_RESIZE, this.onResize);
++-        $(document).off(EVENT_CLICK, this.onGlobalClick);
++-        $(document).off(EVENT_KEYUP, this.onGlobalKeyup);
++-
++-        if (IS_TOUCH_DEVICE) {
++-          $(document).off(EVENT_TOUCH_START, this.onTouchStart);
++-        }
++-      }
++-    },
++-    toggle: function toggle() {
++-      if (this.shown) {
++-        this.hide();
++-      } else {
++-        this.show();
++-      }
++-    },
++-    // Update the datepicker with the current input value
++-    update: function update() {
++-      var value = this.getValue();
++-
++-      if (value === this.oldValue) {
++-        return;
++-      }
++-
++-      this.setDate(value, true);
++-      this.oldValue = value;
++-    },
++-
++-    /**
++-     * Pick the current date to the element
++-     *
++-     * @param {String} _view (private)
++-     */
++-    pick: function pick(_view) {
++-      var $this = this.$element;
++-      var date = this.date;
++-
++-      if (this.trigger(EVENT_PICK, {
++-        view: _view || '',
++-        date: date
++-      }).isDefaultPrevented()) {
++-        return;
++-      }
++-
++-      date = this.formatDate(this.date);
++-      this.setValue(date);
++-
++-      if (this.isInput) {
++-        $this.trigger('input');
++-        $this.trigger('change');
++-      }
++-    },
++-    // Reset the datepicker
++-    reset: function reset() {
++-      this.setDate(this.initialDate, true);
++-      this.setValue(this.initialValue);
++-
++-      if (this.shown) {
++-        this.showView(this.options.startView);
++-      }
++-    },
++-
++-    /**
++-     * Get the month name with given argument or the current date
++-     *
++-     * @param {Number} month (optional)
++-     * @param {Boolean} shortForm (optional)
++-     * @return {String} (month name)
++-     */
++-    getMonthName: function getMonthName(month, shortForm) {
++-      var options = this.options;
++-      var monthsShort = options.monthsShort;
++-      var months = options.months;
++-
++-      if ($.isNumeric(month)) {
++-        month = Number(month);
++-      } else if (isUndefined(shortForm)) {
++-        shortForm = month;
++-      }
++-
++-      if (shortForm === true) {
++-        months = monthsShort;
++-      }
++-
++-      return months[isNumber(month) ? month : this.date.getMonth()];
++-    },
++-
++-    /**
++-     * Get the day name with given argument or the current date
++-     *
++-     * @param {Number} day (optional)
++-     * @param {Boolean} shortForm (optional)
++-     * @param {Boolean} min (optional)
++-     * @return {String} (day name)
++-     */
++-    getDayName: function getDayName(day, shortForm, min) {
++-      var options = this.options;
++-      var days = options.days;
++-
++-      if ($.isNumeric(day)) {
++-        day = Number(day);
++-      } else {
++-        if (isUndefined(min)) {
++-          min = shortForm;
++-        }
++-
++-        if (isUndefined(shortForm)) {
++-          shortForm = day;
++-        }
++-      }
++-
++-      if (min) {
++-        days = options.daysMin;
++-      } else if (shortForm) {
++-        days = options.daysShort;
++-      }
++-
++-      return days[isNumber(day) ? day : this.date.getDay()];
++-    },
++-
++-    /**
++-     * Get the current date
++-     *
++-     * @param {Boolean} formatted (optional)
++-     * @return {Date|String} (date)
++-     */
++-    getDate: function getDate(formatted) {
++-      var date = this.date;
++-      return formatted ? this.formatDate(date) : new Date(date);
++-    },
++-
++-    /**
++-     * Set the current date with a new date
++-     *
++-     * @param {Date} date
++-     * @param {Boolean} _updated (private)
++-     */
++-    setDate: function setDate(date, _updated) {
++-      var filter = this.options.filter;
++-
++-      if (isDate(date) || isString(date)) {
++-        date = this.parseDate(date);
++-
++-        if ($.isFunction(filter) && filter.call(this.$element, date, 'day') === false) {
++-          return;
++-        }
++-
++-        this.date = date;
++-        this.viewDate = new Date(date);
++-
++-        if (!_updated) {
++-          this.pick();
++-        }
++-
++-        if (this.built) {
++-          this.render();
++-        }
++-      }
++-    },
++-
++-    /**
++-     * Set the start view date with a new date
++-     *
++-     * @param {Date|string|null} date
++-     */
++-    setStartDate: function setStartDate(date) {
++-      if (isDate(date) || isString(date)) {
++-        this.startDate = this.parseDate(date);
++-      } else {
++-        this.startDate = null;
++-      }
++-
++-      if (this.built) {
++-        this.render();
++-      }
++-    },
++-
++-    /**
++-     * Set the end view date with a new date
++-     *
++-     * @param {Date|string|null} date
++-     */
++-    setEndDate: function setEndDate(date) {
++-      if (isDate(date) || isString(date)) {
++-        this.endDate = this.parseDate(date);
++-      } else {
++-        this.endDate = null;
++-      }
++-
++-      if (this.built) {
++-        this.render();
++-      }
++-    },
++-
++-    /**
++-     * Parse a date string with the set date format
++-     *
++-     * @param {String} date
++-     * @return {Date} (parsed date)
++-     */
++-    parseDate: function parseDate(date) {
++-      var format = this.format;
++-      var parts = [];
++-
++-      if (!isDate(date)) {
++-        if (isString(date)) {
++-          parts = date.match(REGEXP_DIGITS) || [];
++-        }
++-
++-        date = date ? new Date(date) : new Date();
++-
++-        if (!isDate(date)) {
++-          date = new Date();
++-        }
++-
++-        if (parts.length === format.parts.length) {
++-          // Set year and month first
++-          $.each(parts, function (i, part) {
++-            var value = parseInt(part, 10);
++-
++-            switch (format.parts[i]) {
++-              case 'yy':
++-                date.setFullYear(2000 + value);
++-                break;
++-
++-              case 'yyyy':
++-                // Converts 2-digit year to 2000+
++-                date.setFullYear(part.length === 2 ? 2000 + value : value);
++-                break;
++-
++-              case 'mm':
++-              case 'm':
++-                date.setMonth(value - 1);
++-                break;
++-
++-              default:
++-            }
++-          }); // Set day in the last to avoid converting `31/10/2019` to `01/10/2019`
++-
++-          $.each(parts, function (i, part) {
++-            var value = parseInt(part, 10);
++-
++-            switch (format.parts[i]) {
++-              case 'dd':
++-              case 'd':
++-                date.setDate(value);
++-                break;
++-
++-              default:
++-            }
++-          });
++-        }
++-      } // Ignore hours, minutes, seconds and milliseconds to avoid side effect (#192)
++-
++-
++-      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
++-    },
++-
++-    /**
++-     * Format a date object to a string with the set date format
++-     *
++-     * @param {Date} date
++-     * @return {String} (formatted date)
++-     */
++-    formatDate: function formatDate(date) {
++-      var format = this.format;
++-      var formatted = '';
++-
++-      if (isDate(date)) {
++-        var year = date.getFullYear();
++-        var month = date.getMonth();
++-        var day = date.getDate();
++-        var values = {
++-          d: day,
++-          dd: addLeadingZero(day, 2),
++-          m: month + 1,
++-          mm: addLeadingZero(month + 1, 2),
++-          yy: String(year).substring(2),
++-          yyyy: addLeadingZero(year, 4)
++-        };
++-        formatted = format.source;
++-        $.each(format.parts, function (i, part) {
++-          formatted = formatted.replace(part, values[part]);
++-        });
++-      }
++-
++-      return formatted;
++-    },
++-    // Destroy the datepicker and remove the instance from the target element
++-    destroy: function destroy() {
++-      this.unbind();
++-      this.unbuild();
++-      this.$element.removeData(NAMESPACE);
++-    }
++-  };
++-
++-  var handlers = {
++-    click: function click(e) {
++-      var $target = $(e.target);
++-      var options = this.options,
++-          date = this.date,
++-          viewDate = this.viewDate,
++-          format = this.format;
++-      e.stopPropagation();
++-      e.preventDefault();
++-
++-      if ($target.hasClass('disabled')) {
++-        return;
++-      }
++-
++-      var view = $target.data('view');
++-      var viewYear = viewDate.getFullYear();
++-      var viewMonth = viewDate.getMonth();
++-      var viewDay = viewDate.getDate();
++-
++-      switch (view) {
++-        case 'years prev':
++-        case 'years next':
++-          {
++-            viewYear = view === 'years prev' ? viewYear - 10 : viewYear + 10;
++-            viewDate.setFullYear(viewYear);
++-            viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-            this.renderYears();
++-            break;
++-          }
++-
++-        case 'year prev':
++-        case 'year next':
++-          viewYear = view === 'year prev' ? viewYear - 1 : viewYear + 1;
++-          viewDate.setFullYear(viewYear);
++-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-          this.renderMonths();
++-          break;
++-
++-        case 'year current':
++-          if (format.hasYear) {
++-            this.showView(VIEWS.YEARS);
++-          }
++-
++-          break;
++-
++-        case 'year picked':
++-          if (format.hasMonth) {
++-            this.showView(VIEWS.MONTHS);
++-          } else {
++-            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
++-            this.hideView();
++-          }
++-
++-          this.pick('year');
++-          break;
++-
++-        case 'year':
++-          viewYear = parseInt($target.text(), 10); // Set date first to avoid month changing (#195)
++-
++-          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-          date.setFullYear(viewYear);
++-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-          viewDate.setFullYear(viewYear);
++-
++-          if (format.hasMonth) {
++-            this.showView(VIEWS.MONTHS);
++-          } else {
++-            $target.addClass(options.pickedClass).data('view', 'year picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
++-            this.hideView();
++-          }
++-
++-          this.pick('year');
++-          break;
++-
++-        case 'month prev':
++-        case 'month next':
++-          viewMonth = view === 'month prev' ? viewMonth - 1 : viewMonth + 1;
++-
++-          if (viewMonth < 0) {
++-            viewYear -= 1;
++-            viewMonth += 12;
++-          } else if (viewMonth > 11) {
++-            viewYear += 1;
++-            viewMonth -= 12;
++-          }
++-
++-          viewDate.setFullYear(viewYear);
++-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-          viewDate.setMonth(viewMonth);
++-          this.renderDays();
++-          break;
++-
++-        case 'month current':
++-          if (format.hasMonth) {
++-            this.showView(VIEWS.MONTHS);
++-          }
++-
++-          break;
++-
++-        case 'month picked':
++-          if (format.hasDay) {
++-            this.showView(VIEWS.DAYS);
++-          } else {
++-            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
++-            this.hideView();
++-          }
++-
++-          this.pick('month');
++-          break;
++-
++-        case 'month':
++-          viewMonth = $.inArray($target.text(), options.monthsShort);
++-          date.setFullYear(viewYear); // Set date before month to avoid month changing (#195)
++-
++-          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-          date.setMonth(viewMonth);
++-          viewDate.setFullYear(viewYear);
++-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
++-          viewDate.setMonth(viewMonth);
++-
++-          if (format.hasDay) {
++-            this.showView(VIEWS.DAYS);
++-          } else {
++-            $target.addClass(options.pickedClass).data('view', 'month picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
++-            this.hideView();
++-          }
++-
++-          this.pick('month');
++-          break;
++-
++-        case 'day prev':
++-        case 'day next':
++-        case 'day':
++-          if (view === 'day prev') {
++-            viewMonth -= 1;
++-          } else if (view === 'day next') {
++-            viewMonth += 1;
++-          }
++-
++-          viewDay = parseInt($target.text(), 10); // Set date to 1 to avoid month changing (#195)
++-
++-          date.setDate(1);
++-          date.setFullYear(viewYear);
++-          date.setMonth(viewMonth);
++-          date.setDate(viewDay);
++-          viewDate.setDate(1);
++-          viewDate.setFullYear(viewYear);
++-          viewDate.setMonth(viewMonth);
++-          viewDate.setDate(viewDay);
++-          this.renderDays();
++-
++-          if (view === 'day') {
++-            this.hideView();
++-          }
++-
++-          this.pick('day');
++-          break;
++-
++-        case 'day picked':
++-          this.hideView();
++-          this.pick('day');
++-          break;
++-
++-        default:
++-      }
++-    },
++-    globalClick: function globalClick(_ref) {
++-      var target = _ref.target;
++-      var element = this.element,
++-          $trigger = this.$trigger;
++-      var trigger = $trigger[0];
++-      var hidden = true;
++-
++-      while (target !== document) {
++-        if (target === trigger || target === element) {
++-          hidden = false;
++-          break;
++-        }
++-
++-        target = target.parentNode;
++-      }
++-
++-      if (hidden) {
++-        this.hide();
++-      }
++-    },
++-    keyup: function keyup() {
++-      this.update();
++-    },
++-    globalKeyup: function globalKeyup(_ref2) {
++-      var target = _ref2.target,
++-          key = _ref2.key,
++-          keyCode = _ref2.keyCode;
++-
++-      if (this.isInput && target !== this.element && this.shown && (key === 'Tab' || keyCode === 9)) {
++-        this.hide();
++-      }
++-    },
++-    touchstart: function touchstart(_ref3) {
++-      var target = _ref3.target;
++-
++-      // Emulate click in touch devices to support hiding the picker automatically (#197).
++-      if (this.isInput && target !== this.element && !$.contains(this.$picker[0], target)) {
++-        this.hide();
++-        this.element.blur();
++-      }
++-    }
++-  };
++-
++-  var render = {
++-    render: function render() {
++-      this.renderYears();
++-      this.renderMonths();
++-      this.renderDays();
++-    },
++-    renderWeek: function renderWeek() {
++-      var _this = this;
++-
++-      var items = [];
++-      var _this$options = this.options,
++-          weekStart = _this$options.weekStart,
++-          daysMin = _this$options.daysMin;
++-      weekStart = parseInt(weekStart, 10) % 7;
++-      daysMin = daysMin.slice(weekStart).concat(daysMin.slice(0, weekStart));
++-      $.each(daysMin, function (i, day) {
++-        items.push(_this.createItem({
++-          text: day
++-        }));
++-      });
++-      this.$week.html(items.join(''));
++-    },
++-    renderYears: function renderYears() {
++-      var options = this.options,
++-          startDate = this.startDate,
++-          endDate = this.endDate;
++-      var disabledClass = options.disabledClass,
++-          filter = options.filter,
++-          yearSuffix = options.yearSuffix;
++-      var viewYear = this.viewDate.getFullYear();
++-      var now = new Date();
++-      var thisYear = now.getFullYear();
++-      var year = this.date.getFullYear();
++-      var start = -5;
++-      var end = 6;
++-      var items = [];
++-      var prevDisabled = false;
++-      var nextDisabled = false;
++-      var i;
++-
++-      for (i = start; i <= end; i += 1) {
++-        var date = new Date(viewYear + i, 1, 1);
++-        var disabled = false;
++-
++-        if (startDate) {
++-          disabled = date.getFullYear() < startDate.getFullYear();
++-
++-          if (i === start) {
++-            prevDisabled = disabled;
++-          }
++-        }
++-
++-        if (!disabled && endDate) {
++-          disabled = date.getFullYear() > endDate.getFullYear();
++-
++-          if (i === end) {
++-            nextDisabled = disabled;
++-          }
++-        }
++-
++-        if (!disabled && filter) {
++-          disabled = filter.call(this.$element, date, 'year') === false;
++-        }
++-
++-        var picked = viewYear + i === year;
++-        var view = picked ? 'year picked' : 'year';
++-        items.push(this.createItem({
++-          picked: picked,
++-          disabled: disabled,
++-          text: viewYear + i,
++-          view: disabled ? 'year disabled' : view,
++-          highlighted: date.getFullYear() === thisYear
++-        }));
++-      }
++-
++-      this.$yearsPrev.toggleClass(disabledClass, prevDisabled);
++-      this.$yearsNext.toggleClass(disabledClass, nextDisabled);
++-      this.$yearsCurrent.toggleClass(disabledClass, true).html("".concat(viewYear + start + yearSuffix, " - ").concat(viewYear + end).concat(yearSuffix));
++-      this.$years.html(items.join(''));
++-    },
++-    renderMonths: function renderMonths() {
++-      var options = this.options,
++-          startDate = this.startDate,
++-          endDate = this.endDate,
++-          viewDate = this.viewDate;
++-      var disabledClass = options.disabledClass || '';
++-      var months = options.monthsShort;
++-      var filter = $.isFunction(options.filter) && options.filter;
++-      var viewYear = viewDate.getFullYear();
++-      var now = new Date();
++-      var thisYear = now.getFullYear();
++-      var thisMonth = now.getMonth();
++-      var year = this.date.getFullYear();
++-      var month = this.date.getMonth();
++-      var items = [];
++-      var prevDisabled = false;
++-      var nextDisabled = false;
++-      var i;
++-
++-      for (i = 0; i <= 11; i += 1) {
++-        var date = new Date(viewYear, i, 1);
++-        var disabled = false;
++-
++-        if (startDate) {
++-          prevDisabled = date.getFullYear() === startDate.getFullYear();
++-          disabled = prevDisabled && date.getMonth() < startDate.getMonth();
++-        }
++-
++-        if (!disabled && endDate) {
++-          nextDisabled = date.getFullYear() === endDate.getFullYear();
++-          disabled = nextDisabled && date.getMonth() > endDate.getMonth();
++-        }
++-
++-        if (!disabled && filter) {
++-          disabled = filter.call(this.$element, date, 'month') === false;
++-        }
++-
++-        var picked = viewYear === year && i === month;
++-        var view = picked ? 'month picked' : 'month';
++-        items.push(this.createItem({
++-          disabled: disabled,
++-          picked: picked,
++-          highlighted: viewYear === thisYear && date.getMonth() === thisMonth,
++-          index: i,
++-          text: months[i],
++-          view: disabled ? 'month disabled' : view
++-        }));
++-      }
++-
++-      this.$yearPrev.toggleClass(disabledClass, prevDisabled);
++-      this.$yearNext.toggleClass(disabledClass, nextDisabled);
++-      this.$yearCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(viewYear + options.yearSuffix || '');
++-      this.$months.html(items.join(''));
++-    },
++-    renderDays: function renderDays() {
++-      var $element = this.$element,
++-          options = this.options,
++-          startDate = this.startDate,
++-          endDate = this.endDate,
++-          viewDate = this.viewDate,
++-          currentDate = this.date;
++-      var disabledClass = options.disabledClass,
++-          filter = options.filter,
++-          months = options.months,
++-          weekStart = options.weekStart,
++-          yearSuffix = options.yearSuffix;
++-      var viewYear = viewDate.getFullYear();
++-      var viewMonth = viewDate.getMonth();
++-      var now = new Date();
++-      var thisYear = now.getFullYear();
++-      var thisMonth = now.getMonth();
++-      var thisDay = now.getDate();
++-      var year = currentDate.getFullYear();
++-      var month = currentDate.getMonth();
++-      var day = currentDate.getDate();
++-      var length;
++-      var i;
++-      var n; // Days of prev month
++-      // -----------------------------------------------------------------------
++-
++-      var prevItems = [];
++-      var prevViewYear = viewYear;
++-      var prevViewMonth = viewMonth;
++-      var prevDisabled = false;
++-
++-      if (viewMonth === 0) {
++-        prevViewYear -= 1;
++-        prevViewMonth = 11;
++-      } else {
++-        prevViewMonth -= 1;
++-      } // The length of the days of prev month
++-
++-
++-      length = getDaysInMonth(prevViewYear, prevViewMonth); // The first day of current month
++-
++-      var firstDay = new Date(viewYear, viewMonth, 1); // The visible length of the days of prev month
++-      // [0,1,2,3,4,5,6] - [0,1,2,3,4,5,6] => [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6]
++-
++-      n = firstDay.getDay() - parseInt(weekStart, 10) % 7; // [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6] => [1,2,3,4,5,6,7]
++-
++-      if (n <= 0) {
++-        n += 7;
++-      }
++-
++-      if (startDate) {
++-        prevDisabled = firstDay.getTime() <= startDate.getTime();
++-      }
++-
++-      for (i = length - (n - 1); i <= length; i += 1) {
++-        var prevViewDate = new Date(prevViewYear, prevViewMonth, i);
++-        var disabled = false;
++-
++-        if (startDate) {
++-          disabled = prevViewDate.getTime() < startDate.getTime();
++-        }
++-
++-        if (!disabled && filter) {
++-          disabled = filter.call($element, prevViewDate, 'day') === false;
++-        }
++-
++-        prevItems.push(this.createItem({
++-          disabled: disabled,
++-          highlighted: prevViewYear === thisYear && prevViewMonth === thisMonth && prevViewDate.getDate() === thisDay,
++-          muted: true,
++-          picked: prevViewYear === year && prevViewMonth === month && i === day,
++-          text: i,
++-          view: 'day prev'
++-        }));
++-      } // Days of next month
++-      // -----------------------------------------------------------------------
++-
++-
++-      var nextItems = [];
++-      var nextViewYear = viewYear;
++-      var nextViewMonth = viewMonth;
++-      var nextDisabled = false;
++-
++-      if (viewMonth === 11) {
++-        nextViewYear += 1;
++-        nextViewMonth = 0;
++-      } else {
++-        nextViewMonth += 1;
++-      } // The length of the days of current month
++-
++-
++-      length = getDaysInMonth(viewYear, viewMonth); // The visible length of next month (42 means 6 rows and 7 columns)
++-
++-      n = 42 - (prevItems.length + length); // The last day of current month
++-
++-      var lastDate = new Date(viewYear, viewMonth, length);
++-
++-      if (endDate) {
++-        nextDisabled = lastDate.getTime() >= endDate.getTime();
++-      }
++-
++-      for (i = 1; i <= n; i += 1) {
++-        var date = new Date(nextViewYear, nextViewMonth, i);
++-        var picked = nextViewYear === year && nextViewMonth === month && i === day;
++-        var _disabled = false;
++-
++-        if (endDate) {
++-          _disabled = date.getTime() > endDate.getTime();
++-        }
++-
++-        if (!_disabled && filter) {
++-          _disabled = filter.call($element, date, 'day') === false;
++-        }
++-
++-        nextItems.push(this.createItem({
++-          disabled: _disabled,
++-          picked: picked,
++-          highlighted: nextViewYear === thisYear && nextViewMonth === thisMonth && date.getDate() === thisDay,
++-          muted: true,
++-          text: i,
++-          view: 'day next'
++-        }));
++-      } // Days of current month
++-      // -----------------------------------------------------------------------
++-
++-
++-      var items = [];
++-
++-      for (i = 1; i <= length; i += 1) {
++-        var _date = new Date(viewYear, viewMonth, i);
++-
++-        var _disabled2 = false;
++-
++-        if (startDate) {
++-          _disabled2 = _date.getTime() < startDate.getTime();
++-        }
++-
++-        if (!_disabled2 && endDate) {
++-          _disabled2 = _date.getTime() > endDate.getTime();
++-        }
++-
++-        if (!_disabled2 && filter) {
++-          _disabled2 = filter.call($element, _date, 'day') === false;
++-        }
++-
++-        var _picked = viewYear === year && viewMonth === month && i === day;
++-
++-        var view = _picked ? 'day picked' : 'day';
++-        items.push(this.createItem({
++-          disabled: _disabled2,
++-          picked: _picked,
++-          highlighted: viewYear === thisYear && viewMonth === thisMonth && _date.getDate() === thisDay,
++-          text: i,
++-          view: _disabled2 ? 'day disabled' : view
++-        }));
++-      } // Render days picker
++-      // -----------------------------------------------------------------------
++-
++-
++-      this.$monthPrev.toggleClass(disabledClass, prevDisabled);
++-      this.$monthNext.toggleClass(disabledClass, nextDisabled);
++-      this.$monthCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(options.yearFirst ? "".concat(viewYear + yearSuffix, " ").concat(months[viewMonth]) : "".concat(months[viewMonth], " ").concat(viewYear).concat(yearSuffix));
++-      this.$days.html(prevItems.join('') + items.join('') + nextItems.join(''));
++-    }
++-  };
++-
++-  var CLASS_TOP_LEFT = "".concat(NAMESPACE, "-top-left");
++-  var CLASS_TOP_RIGHT = "".concat(NAMESPACE, "-top-right");
++-  var CLASS_BOTTOM_LEFT = "".concat(NAMESPACE, "-bottom-left");
++-  var CLASS_BOTTOM_RIGHT = "".concat(NAMESPACE, "-bottom-right");
++-  var CLASS_PLACEMENTS = [CLASS_TOP_LEFT, CLASS_TOP_RIGHT, CLASS_BOTTOM_LEFT, CLASS_BOTTOM_RIGHT].join(' ');
++-
++-  var Datepicker =
++-  /*#__PURE__*/
++-  function () {
++-    function Datepicker(element) {
++-      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
++-
++-      _classCallCheck(this, Datepicker);
++-
++-      this.$element = $(element);
++-      this.element = element;
++-      this.options = $.extend({}, DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
++-      this.$scrollParent = getScrollParent(element, true);
++-      this.built = false;
++-      this.shown = false;
++-      this.isInput = false;
++-      this.inline = false;
++-      this.initialValue = '';
++-      this.initialDate = null;
++-      this.startDate = null;
++-      this.endDate = null;
++-      this.init();
++-    }
++-
++-    _createClass(Datepicker, [{
++-      key: "init",
++-      value: function init() {
++-        var $this = this.$element,
++-            options = this.options;
++-        var startDate = options.startDate,
++-            endDate = options.endDate,
++-            date = options.date;
++-        this.$trigger = $(options.trigger);
++-        this.isInput = $this.is('input') || $this.is('textarea');
++-        this.inline = options.inline && (options.container || !this.isInput);
++-        this.format = parseFormat(options.format);
++-        var initialValue = this.getValue();
++-        this.initialValue = initialValue;
++-        this.oldValue = initialValue;
++-        date = this.parseDate(date || initialValue);
++-
++-        if (startDate) {
++-          startDate = this.parseDate(startDate);
++-
++-          if (date.getTime() < startDate.getTime()) {
++-            date = new Date(startDate);
++-          }
++-
++-          this.startDate = startDate;
++-        }
++-
++-        if (endDate) {
++-          endDate = this.parseDate(endDate);
++-
++-          if (startDate && endDate.getTime() < startDate.getTime()) {
++-            endDate = new Date(startDate);
++-          }
++-
++-          if (date.getTime() > endDate.getTime()) {
++-            date = new Date(endDate);
++-          }
++-
++-          this.endDate = endDate;
++-        }
++-
++-        this.date = date;
++-        this.viewDate = new Date(date);
++-        this.initialDate = new Date(this.date);
++-        this.bind();
++-
++-        if (options.autoShow || this.inline) {
++-          this.show();
++-        }
++-
++-        if (options.autoPick) {
++-          this.pick();
++-        }
++-      }
++-    }, {
++-      key: "build",
++-      value: function build() {
++-        if (this.built) {
++-          return;
++-        }
++-
++-        this.built = true;
++-        var $this = this.$element,
++-            options = this.options;
++-        var $picker = $(options.template);
++-        this.$picker = $picker;
++-        this.$week = $picker.find(selectorOf('week')); // Years view
++-
++-        this.$yearsPicker = $picker.find(selectorOf('years picker'));
++-        this.$yearsPrev = $picker.find(selectorOf('years prev'));
++-        this.$yearsNext = $picker.find(selectorOf('years next'));
++-        this.$yearsCurrent = $picker.find(selectorOf('years current'));
++-        this.$years = $picker.find(selectorOf('years')); // Months view
++-
++-        this.$monthsPicker = $picker.find(selectorOf('months picker'));
++-        this.$yearPrev = $picker.find(selectorOf('year prev'));
++-        this.$yearNext = $picker.find(selectorOf('year next'));
++-        this.$yearCurrent = $picker.find(selectorOf('year current'));
++-        this.$months = $picker.find(selectorOf('months')); // Days view
++-
++-        this.$daysPicker = $picker.find(selectorOf('days picker'));
++-        this.$monthPrev = $picker.find(selectorOf('month prev'));
++-        this.$monthNext = $picker.find(selectorOf('month next'));
++-        this.$monthCurrent = $picker.find(selectorOf('month current'));
++-        this.$days = $picker.find(selectorOf('days'));
++-
++-        if (this.inline) {
++-          $(options.container || $this).append($picker.addClass("".concat(NAMESPACE, "-inline")));
++-        } else {
++-          $(document.body).append($picker.addClass("".concat(NAMESPACE, "-dropdown")));
++-          $picker.addClass(CLASS_HIDE).css({
++-            zIndex: parseInt(options.zIndex, 10)
++-          });
++-        }
++-
++-        this.renderWeek();
++-      }
++-    }, {
++-      key: "unbuild",
++-      value: function unbuild() {
++-        if (!this.built) {
++-          return;
++-        }
++-
++-        this.built = false;
++-        this.$picker.remove();
++-      }
++-    }, {
++-      key: "bind",
++-      value: function bind() {
++-        var options = this.options,
++-            $this = this.$element;
++-
++-        if ($.isFunction(options.show)) {
++-          $this.on(EVENT_SHOW, options.show);
++-        }
++-
++-        if ($.isFunction(options.hide)) {
++-          $this.on(EVENT_HIDE, options.hide);
++-        }
++-
++-        if ($.isFunction(options.pick)) {
++-          $this.on(EVENT_PICK, options.pick);
++-        }
++-
++-        if (this.isInput) {
++-          $this.on(EVENT_KEYUP, $.proxy(this.keyup, this));
++-        }
++-
++-        if (!this.inline) {
++-          if (options.trigger) {
++-            this.$trigger.on(EVENT_CLICK, $.proxy(this.toggle, this));
++-          } else if (this.isInput) {
++-            $this.on(EVENT_FOCUS, $.proxy(this.show, this));
++-          } else {
++-            $this.on(EVENT_CLICK, $.proxy(this.show, this));
++-          }
++-        }
++-      }
++-    }, {
++-      key: "unbind",
++-      value: function unbind() {
++-        var $this = this.$element,
++-            options = this.options;
++-
++-        if ($.isFunction(options.show)) {
++-          $this.off(EVENT_SHOW, options.show);
++-        }
++-
++-        if ($.isFunction(options.hide)) {
++-          $this.off(EVENT_HIDE, options.hide);
++-        }
++-
++-        if ($.isFunction(options.pick)) {
++-          $this.off(EVENT_PICK, options.pick);
++-        }
++-
++-        if (this.isInput) {
++-          $this.off(EVENT_KEYUP, this.keyup);
++-        }
++-
++-        if (!this.inline) {
++-          if (options.trigger) {
++-            this.$trigger.off(EVENT_CLICK, this.toggle);
++-          } else if (this.isInput) {
++-            $this.off(EVENT_FOCUS, this.show);
++-          } else {
++-            $this.off(EVENT_CLICK, this.show);
++-          }
++-        }
++-      }
++-    }, {
++-      key: "showView",
++-      value: function showView(view) {
++-        var $yearsPicker = this.$yearsPicker,
++-            $monthsPicker = this.$monthsPicker,
++-            $daysPicker = this.$daysPicker,
++-            format = this.format;
++-
++-        if (format.hasYear || format.hasMonth || format.hasDay) {
++-          switch (Number(view)) {
++-            case VIEWS.YEARS:
++-              $monthsPicker.addClass(CLASS_HIDE);
++-              $daysPicker.addClass(CLASS_HIDE);
++-
++-              if (format.hasYear) {
++-                this.renderYears();
++-                $yearsPicker.removeClass(CLASS_HIDE);
++-                this.place();
++-              } else {
++-                this.showView(VIEWS.DAYS);
++-              }
++-
++-              break;
++-
++-            case VIEWS.MONTHS:
++-              $yearsPicker.addClass(CLASS_HIDE);
++-              $daysPicker.addClass(CLASS_HIDE);
++-
++-              if (format.hasMonth) {
++-                this.renderMonths();
++-                $monthsPicker.removeClass(CLASS_HIDE);
++-                this.place();
++-              } else {
++-                this.showView(VIEWS.YEARS);
++-              }
++-
++-              break;
++-            // case VIEWS.DAYS:
++-
++-            default:
++-              $yearsPicker.addClass(CLASS_HIDE);
++-              $monthsPicker.addClass(CLASS_HIDE);
++-
++-              if (format.hasDay) {
++-                this.renderDays();
++-                $daysPicker.removeClass(CLASS_HIDE);
++-                this.place();
++-              } else {
++-                this.showView(VIEWS.MONTHS);
++-              }
++-
++-          }
++-        }
++-      }
++-    }, {
++-      key: "hideView",
++-      value: function hideView() {
++-        if (!this.inline && this.options.autoHide) {
++-          this.hide();
++-        }
++-      }
++-    }, {
++-      key: "place",
++-      value: function place() {
++-        if (this.inline) {
++-          return;
++-        }
++-
++-        var $this = this.$element,
++-            options = this.options,
++-            $picker = this.$picker;
++-        var containerWidth = $(document).outerWidth();
++-        var containerHeight = $(document).outerHeight();
++-        var elementWidth = $this.outerWidth();
++-        var elementHeight = $this.outerHeight();
++-        var width = $picker.width();
++-        var height = $picker.height();
++-
++-        var _$this$offset = $this.offset(),
++-            left = _$this$offset.left,
++-            top = _$this$offset.top;
++-
++-        var offset = parseFloat(options.offset);
++-        var placement = CLASS_TOP_LEFT;
++-
++-        if (isNaN(offset)) {
++-          offset = 10;
++-        }
++-
++-        if (top > height && top + elementHeight + height > containerHeight) {
++-          top -= height + offset;
++-          placement = CLASS_BOTTOM_LEFT;
++-        } else {
++-          top += elementHeight + offset;
++-        }
++-
++-        if (left + width > containerWidth) {
++-          left += elementWidth - width;
++-          placement = placement.replace('left', 'right');
++-        }
++-
++-        $picker.removeClass(CLASS_PLACEMENTS).addClass(placement).css({
++-          top: top,
++-          left: left
++-        });
++-      } // A shortcut for triggering custom events
++-
++-    }, {
++-      key: "trigger",
++-      value: function trigger(type, data) {
++-        var e = $.Event(type, data);
++-        this.$element.trigger(e);
++-        return e;
++-      }
++-    }, {
++-      key: "createItem",
++-      value: function createItem(data) {
++-        var options = this.options;
++-        var itemTag = options.itemTag;
++-        var item = {
++-          text: '',
++-          view: '',
++-          muted: false,
++-          picked: false,
++-          disabled: false,
++-          highlighted: false
++-        };
++-        var classes = [];
++-        $.extend(item, data);
++-
++-        if (item.muted) {
++-          classes.push(options.mutedClass);
++-        }
++-
++-        if (item.highlighted) {
++-          classes.push(options.highlightedClass);
++-        }
++-
++-        if (item.picked) {
++-          classes.push(options.pickedClass);
++-        }
++-
++-        if (item.disabled) {
++-          classes.push(options.disabledClass);
++-        }
++-
++-        return "<".concat(itemTag, " class=\"").concat(classes.join(' '), "\" data-view=\"").concat(item.view, "\">").concat(item.text, "</").concat(itemTag, ">");
++-      }
++-    }, {
++-      key: "getValue",
++-      value: function getValue() {
++-        var $this = this.$element;
++-        return this.isInput ? $this.val() : $this.text();
++-      }
++-    }, {
++-      key: "setValue",
++-      value: function setValue() {
++-        var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
++-        var $this = this.$element;
++-
++-        if (this.isInput) {
++-          $this.val(value);
++-        } else if (!this.inline || this.options.container) {
++-          $this.text(value);
++-        }
++-      }
++-    }], [{
++-      key: "setDefaults",
++-      value: function setDefaults() {
++-        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
++-        $.extend(DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
++-      }
++-    }]);
++-
++-    return Datepicker;
++-  }();
++-
++-  if ($.extend) {
++-    $.extend(Datepicker.prototype, render, handlers, methods);
++-  }
++-
++-  if ($.fn) {
++-    var AnotherDatepicker = $.fn.datepicker;
++-
++-    $.fn.datepicker = function jQueryDatepicker(option) {
++-      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
++-        args[_key - 1] = arguments[_key];
++-      }
++-
++-      var result;
++-      this.each(function (i, element) {
++-        var $element = $(element);
++-        var isDestroy = option === 'destroy';
++-        var datepicker = $element.data(NAMESPACE);
++-
++-        if (!datepicker) {
++-          if (isDestroy) {
++-            return;
++-          }
++-
++-          var options = $.extend({}, $element.data(), $.isPlainObject(option) && option);
++-          datepicker = new Datepicker(element, options);
++-          $element.data(NAMESPACE, datepicker);
++-        }
++-
++-        if (isString(option)) {
++-          var fn = datepicker[option];
++-
++-          if ($.isFunction(fn)) {
++-            result = fn.apply(datepicker, args);
++-
++-            if (isDestroy) {
++-              $element.removeData(NAMESPACE);
++-            }
++-          }
++-        }
++-      });
++-      return !isUndefined(result) ? result : this;
++-    };
++-
++-    $.fn.datepicker.Constructor = Datepicker;
++-    $.fn.datepicker.languages = LANGUAGES;
++-    $.fn.datepicker.setDefaults = Datepicker.setDefaults;
++-
++-    $.fn.datepicker.noConflict = function noConflict() {
++-      $.fn.datepicker = AnotherDatepicker;
++-      return this;
++-    };
++-  }
++-
++-}));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css"
++deleted file mode 100644
++index 73320920f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css"
+++++ /dev/null
++@@ -1,9 +0,0 @@
++-/*!
++- * Datepicker v1.0.9
++- * https://fengyuanchen.github.io/datepicker
++- *
++- * Copyright 2014-present Chen Fengyuan
++- * Released under the MIT license
++- *
++- * Date: 2019-09-21T06:57:30.334Z
++- */.datepicker-container{background-color:#fff;direction:ltr;font-size:12px;left:0;line-height:30px;position:fixed;-webkit-tap-highlight-color:transparent;top:0;-ms-touch-action:none;touch-action:none;-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;width:210px;z-index:-1}.datepicker-container:after,.datepicker-container:before{border:5px solid transparent;content:" ";display:block;height:0;position:absolute;width:0}.datepicker-dropdown{border:1px solid #ccc;-webkit-box-shadow:0 3px 6px #ccc;box-shadow:0 3px 6px #ccc;-webkit-box-sizing:content-box;box-sizing:content-box;position:absolute;z-index:1}.datepicker-inline{position:static}.datepicker-top-left,.datepicker-top-right{border-top-color:#39f}.datepicker-top-left:after,.datepicker-top-left:before,.datepicker-top-right:after,.datepicker-top-right:before{border-top:0;left:10px;top:-5px}.datepicker-top-left:before,.datepicker-top-right:before{border-bottom-color:#39f}.datepicker-top-left:after,.datepicker-top-right:after{border-bottom-color:#fff;top:-4px}.datepicker-bottom-left,.datepicker-bottom-right{border-bottom-color:#39f}.datepicker-bottom-left:after,.datepicker-bottom-left:before,.datepicker-bottom-right:after,.datepicker-bottom-right:before{border-bottom:0;bottom:-5px;left:10px}.datepicker-bottom-left:before,.datepicker-bottom-right:before{border-top-color:#39f}.datepicker-bottom-left:after,.datepicker-bottom-right:after{border-top-color:#fff;bottom:-4px}.datepicker-bottom-right:after,.datepicker-bottom-right:before,.datepicker-top-right:after,.datepicker-top-right:before{left:auto;right:10px}.datepicker-panel>ul{margin:0;padding:0;width:102%}.datepicker-panel>ul:after,.datepicker-panel>ul:before{content:" ";display:table}.datepicker-panel>ul:after{clear:both}.datepicker-panel>ul>li{background-color:#fff;cursor:pointer;float:left;height:30px;list-style:none;margin:0;padding:0;text-align:center;width:30px}.datepicker-panel>ul>li:hover{background-color:#e5f2ff}.datepicker-panel>ul>li.muted,.datepicker-panel>ul>li.muted:hover{color:#999}.datepicker-panel>ul>li.highlighted{background-color:#e5f2ff}.datepicker-panel>ul>li.highlighted:hover{background-color:#cce5ff}.datepicker-panel>ul>li.picked,.datepicker-panel>ul>li.picked:hover{color:#39f}.datepicker-panel>ul>li.disabled,.datepicker-panel>ul>li.disabled:hover{background-color:#fff;color:#ccc;cursor:default}.datepicker-panel>ul>li.disabled.highlighted,.datepicker-panel>ul>li.disabled:hover.highlighted{background-color:#e5f2ff}.datepicker-panel>ul>li[data-view="month next"],.datepicker-panel>ul>li[data-view="month prev"],.datepicker-panel>ul>li[data-view="year next"],.datepicker-panel>ul>li[data-view="year prev"],.datepicker-panel>ul>li[data-view="years next"],.datepicker-panel>ul>li[data-view="years prev"],.datepicker-panel>ul>li[data-view=next]{font-size:18px}.datepicker-panel>ul>li[data-view="month current"],.datepicker-panel>ul>li[data-view="year current"],.datepicker-panel>ul>li[data-view="years current"]{width:150px}.datepicker-panel>ul[data-view=months]>li,.datepicker-panel>ul[data-view=years]>li{height:52.5px;line-height:52.5px;width:52.5px}.datepicker-panel>ul[data-view=week]>li,.datepicker-panel>ul[data-view=week]>li:hover{background-color:#fff;cursor:default}.datepicker-hide{display:none}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js"
++deleted file mode 100644
++index 928a19ad2..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js"
+++++ /dev/null
++@@ -1,10 +0,0 @@
++-/*!
++- * Datepicker v1.0.9
++- * https://fengyuanchen.github.io/datepicker
++- *
++- * Copyright 2014-present Chen Fengyuan
++- * Released under the MIT license
++- *
++- * Date: 2019-09-21T06:57:34.100Z
++- */
++-!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],e):e((t=t||self).jQuery)}(this,function(D){"use strict";function a(t,e){for(var i=0;i<e.length;i++){var a=e[i];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}D=D&&D.hasOwnProperty("default")?D.default:D;var s={autoShow:!1,autoHide:!1,autoPick:!1,inline:!1,container:null,trigger:null,language:"",format:"mm/dd/yyyy",date:null,startDate:null,endDate:null,startView:0,weekStart:0,yearFirst:!1,yearSuffix:"",days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],itemTag:"li",mutedClass:"muted",pickedClass:"picked",disabledClass:"disabled",highlightedClass:"highlighted",template:'<div class="datepicker-container"><div class="datepicker-panel" data-view="years picker"><ul><li data-view="years prev">&lsaquo;</li><li data-view="years current"></li><li data-view="years next">&rsaquo;</li></ul><ul data-view="years"></ul></div><div class="datepicker-panel" data-view="months picker"><ul><li data-view="year prev">&lsaquo;</li><li data-view="year current"></li><li data-view="year next">&rsaquo;</li></ul><ul data-view="months"></ul></div><div class="datepicker-panel" data-view="days picker"><ul><li data-view="month prev">&lsaquo;</li><li data-view="month current"></li><li data-view="month next">&rsaquo;</li></ul><ul data-view="week"></ul><ul data-view="days"></ul></div></div>',offset:10,zIndex:1e3,filter:null,show:null,hide:null,pick:null},t="undefined"!=typeof window,e=t?window:{},i=t&&"ontouchstart"in e.document.documentElement,c="datepicker",n="click.".concat(c),r="focus.".concat(c),h="hide.".concat(c),o="keyup.".concat(c),l="pick.".concat(c),d="resize.".concat(c),u="scroll.".concat(c),p="show.".concat(c),f="touchstart.".concat(c),g="".concat(c,"-hide"),y={},m=0,v=1,w=2,k=Object.prototype.toString;function b(t){return"string"==typeof t}var C=Number.isNaN||e.isNaN;function $(t){return"number"==typeof t&&!C(t)}function x(t){return void 0===t}function F(t){return"date"===function(t){return k.call(t).slice(8,-1).toLowerCase()}(t)&&!C(t.getTime())}function M(a,s){for(var t=arguments.length,n=new Array(2<t?t-2:0),e=2;e<t;e++)n[e-2]=arguments[e];return function(){for(var t=arguments.length,e=new Array(t),i=0;i<t;i++)e[i]=arguments[i];return a.apply(s,n.concat(e))}}function Y(t){return'[data-view="'.concat(t,'"]')}function G(t,e){return[31,function(t){return t%4==0&&t%100!=0||t%400==0}(t)?29:28,31,30,31,30,31,31,30,31,30,31][e]}function V(t,e,i){return Math.min(i,G(t,e))}var T=/(y|m|d)+/g;function I(t,e){var i=1<arguments.length&&void 0!==e?e:1,a=String(Math.abs(t)),s=a.length,n="";for(t<0&&(n+="-");s<i;)s+=1,n+="0";return n+a}var S=/\d+/g,P={show:function(){this.built||this.build(),this.shown||this.trigger(p).isDefaultPrevented()||(this.shown=!0,this.$picker.removeClass(g).on(n,D.proxy(this.click,this)),this.showView(this.options.startView),this.inline||(this.$scrollParent.on(u,D.proxy(this.place,this)),D(window).on(d,this.onResize=M(this.place,this)),D(document).on(n,this.onGlobalClick=M(this.globalClick,this)),D(document).on(o,this.onGlobalKeyup=M(this.globalKeyup,this)),i&&D(document).on(f,this.onTouchStart=M(this.touchstart,this)),this.place()))},hide:function(){this.shown&&(this.trigger(h).isDefaultPrevented()||(this.shown=!1,this.$picker.addClass(g).off(n,this.click),this.inline||(this.$scrollParent.off(u,this.place),D(window).off(d,this.onResize),D(document).off(n,this.onGlobalClick),D(document).off(o,this.onGlobalKeyup),i&&D(document).off(f,this.onTouchStart))))},toggle:function(){this.shown?this.hide():this.show()},update:function(){var t=this.getValue();t!==this.oldValue&&(this.setDate(t,!0),this.oldValue=t)},pick:function(t){var e=this.$element,i=this.date;this.trigger(l,{view:t||"",date:i}).isDefaultPrevented()||(i=this.formatDate(this.date),this.setValue(i),this.isInput&&(e.trigger("input"),e.trigger("change")))},reset:function(){this.setDate(this.initialDate,!0),this.setValue(this.initialValue),this.shown&&this.showView(this.options.startView)},getMonthName:function(t,e){var i=this.options,a=i.monthsShort,s=i.months;return D.isNumeric(t)?t=Number(t):x(e)&&(e=t),!0===e&&(s=a),s[$(t)?t:this.date.getMonth()]},getDayName:function(t,e,i){var a=this.options,s=a.days;return D.isNumeric(t)?t=Number(t):(x(i)&&(i=e),x(e)&&(e=t)),i?s=a.daysMin:e&&(s=a.daysShort),s[$(t)?t:this.date.getDay()]},getDate:function(t){var e=this.date;return t?this.formatDate(e):new Date(e)},setDate:function(t,e){var i=this.options.filter;if(F(t)||b(t)){if(t=this.parseDate(t),D.isFunction(i)&&!1===i.call(this.$element,t,"day"))return;this.date=t,this.viewDate=new Date(t),e||this.pick(),this.built&&this.render()}},setStartDate:function(t){F(t)||b(t)?this.startDate=this.parseDate(t):this.startDate=null,this.built&&this.render()},setEndDate:function(t){F(t)||b(t)?this.endDate=this.parseDate(t):this.endDate=null,this.built&&this.render()},parseDate:function(a){var s=this.format,t=[];return F(a)||(b(a)&&(t=a.match(S)||[]),F(a=a?new Date(a):new Date)||(a=new Date),t.length===s.parts.length&&(D.each(t,function(t,e){var i=parseInt(e,10);switch(s.parts[t]){case"yy":a.setFullYear(2e3+i);break;case"yyyy":a.setFullYear(2===e.length?2e3+i:i);break;case"mm":case"m":a.setMonth(i-1)}}),D.each(t,function(t,e){var i=parseInt(e,10);switch(s.parts[t]){case"dd":case"d":a.setDate(i)}}))),new Date(a.getFullYear(),a.getMonth(),a.getDate())},formatDate:function(t){var e=this.format,i="";if(F(t)){var a=t.getFullYear(),s=t.getMonth(),n=t.getDate(),r={d:n,dd:I(n,2),m:s+1,mm:I(s+1,2),yy:String(a).substring(2),yyyy:I(a,4)};i=e.source,D.each(e.parts,function(t,e){i=i.replace(e,r[e])})}return i},destroy:function(){this.unbind(),this.unbuild(),this.$element.removeData(c)}},N={click:function(t){var e=D(t.target),i=this.options,a=this.date,s=this.viewDate,n=this.format;if(t.stopPropagation(),t.preventDefault(),!e.hasClass("disabled")){var r=e.data("view"),h=s.getFullYear(),o=s.getMonth(),l=s.getDate();switch(r){case"years prev":case"years next":h="years prev"===r?h-10:h+10,s.setFullYear(h),s.setDate(V(h,o,l)),this.renderYears();break;case"year prev":case"year next":h="year prev"===r?h-1:h+1,s.setFullYear(h),s.setDate(V(h,o,l)),this.renderMonths();break;case"year current":n.hasYear&&this.showView(w);break;case"year picked":n.hasMonth?this.showView(v):(e.siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","year"),this.hideView()),this.pick("year");break;case"year":h=parseInt(e.text(),10),a.setDate(V(h,o,l)),a.setFullYear(h),s.setDate(V(h,o,l)),s.setFullYear(h),n.hasMonth?this.showView(v):(e.addClass(i.pickedClass).data("view","year picked").siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","year"),this.hideView()),this.pick("year");break;case"month prev":case"month next":(o="month prev"===r?o-1:o+1)<0?(h-=1,o+=12):11<o&&(h+=1,o-=12),s.setFullYear(h),s.setDate(V(h,o,l)),s.setMonth(o),this.renderDays();break;case"month current":n.hasMonth&&this.showView(v);break;case"month picked":n.hasDay?this.showView(m):(e.siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","month"),this.hideView()),this.pick("month");break;case"month":o=D.inArray(e.text(),i.monthsShort),a.setFullYear(h),a.setDate(V(h,o,l)),a.setMonth(o),s.setFullYear(h),s.setDate(V(h,o,l)),s.setMonth(o),n.hasDay?this.showView(m):(e.addClass(i.pickedClass).data("view","month picked").siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","month"),this.hideView()),this.pick("month");break;case"day prev":case"day next":case"day":"day prev"===r?o-=1:"day next"===r&&(o+=1),l=parseInt(e.text(),10),a.setDate(1),a.setFullYear(h),a.setMonth(o),a.setDate(l),s.setDate(1),s.setFullYear(h),s.setMonth(o),s.setDate(l),this.renderDays(),"day"===r&&this.hideView(),this.pick("day");break;case"day picked":this.hideView(),this.pick("day")}}},globalClick:function(t){for(var e=t.target,i=this.element,a=this.$trigger[0],s=!0;e!==document;){if(e===a||e===i){s=!1;break}e=e.parentNode}s&&this.hide()},keyup:function(){this.update()},globalKeyup:function(t){var e=t.target,i=t.key,a=t.keyCode;this.isInput&&e!==this.element&&this.shown&&("Tab"===i||9===a)&&this.hide()},touchstart:function(t){var e=t.target;this.isInput&&e!==this.element&&!D.contains(this.$picker[0],e)&&(this.hide(),this.element.blur())}},j={render:function(){this.renderYears(),this.renderMonths(),this.renderDays()},renderWeek:function(){var i=this,a=[],t=this.options,e=t.weekStart,s=t.daysMin;e=parseInt(e,10)%7,s=s.slice(e).concat(s.slice(0,e)),D.each(s,function(t,e){a.push(i.createItem({text:e}))}),this.$week.html(a.join(""))},renderYears:function(){var t,e=this.options,i=this.startDate,a=this.endDate,s=e.disabledClass,n=e.filter,r=e.yearSuffix,h=this.viewDate.getFullYear(),o=(new Date).getFullYear(),l=this.date.getFullYear(),c=[],d=!1,u=!1;for(t=-5;t<=6;t+=1){var p=new Date(h+t,1,1),f=!1;i&&(f=p.getFullYear()<i.getFullYear(),-5===t&&(d=f)),!f&&a&&(f=p.getFullYear()>a.getFullYear(),6===t&&(u=f)),!f&&n&&(f=!1===n.call(this.$element,p,"year"));var g=h+t===l,y=g?"year picked":"year";c.push(this.createItem({picked:g,disabled:f,text:h+t,view:f?"year disabled":y,highlighted:p.getFullYear()===o}))}this.$yearsPrev.toggleClass(s,d),this.$yearsNext.toggleClass(s,u),this.$yearsCurrent.toggleClass(s,!0).html("".concat(h+-5+r," - ").concat(h+6).concat(r)),this.$years.html(c.join(""))},renderMonths:function(){var t,e=this.options,i=this.startDate,a=this.endDate,s=this.viewDate,n=e.disabledClass||"",r=e.monthsShort,h=D.isFunction(e.filter)&&e.filter,o=s.getFullYear(),l=new Date,c=l.getFullYear(),d=l.getMonth(),u=this.date.getFullYear(),p=this.date.getMonth(),f=[],g=!1,y=!1;for(t=0;t<=11;t+=1){var m=new Date(o,t,1),v=!1;i&&(v=(g=m.getFullYear()===i.getFullYear())&&m.getMonth()<i.getMonth()),!v&&a&&(v=(y=m.getFullYear()===a.getFullYear())&&m.getMonth()>a.getMonth()),!v&&h&&(v=!1===h.call(this.$element,m,"month"));var w=o===u&&t===p,k=w?"month picked":"month";f.push(this.createItem({disabled:v,picked:w,highlighted:o===c&&m.getMonth()===d,index:t,text:r[t],view:v?"month disabled":k}))}this.$yearPrev.toggleClass(n,g),this.$yearNext.toggleClass(n,y),this.$yearCurrent.toggleClass(n,g&&y).html(o+e.yearSuffix||""),this.$months.html(f.join(""))},renderDays:function(){var t,e,i,a=this.$element,s=this.options,n=this.startDate,r=this.endDate,h=this.viewDate,o=this.date,l=s.disabledClass,c=s.filter,d=s.months,u=s.weekStart,p=s.yearSuffix,f=h.getFullYear(),g=h.getMonth(),y=new Date,m=y.getFullYear(),v=y.getMonth(),w=y.getDate(),k=o.getFullYear(),D=o.getMonth(),b=o.getDate(),C=[],$=f,x=g,F=!1;0===g?($-=1,x=11):x-=1,t=G($,x);var M=new Date(f,g,1);for((i=M.getDay()-parseInt(u,10)%7)<=0&&(i+=7),n&&(F=M.getTime()<=n.getTime()),e=t-(i-1);e<=t;e+=1){var Y=new Date($,x,e),V=!1;n&&(V=Y.getTime()<n.getTime()),!V&&c&&(V=!1===c.call(a,Y,"day")),C.push(this.createItem({disabled:V,highlighted:$===m&&x===v&&Y.getDate()===w,muted:!0,picked:$===k&&x===D&&e===b,text:e,view:"day prev"}))}var T=[],I=f,S=g,P=!1;11===g?(I+=1,S=0):S+=1,t=G(f,g),i=42-(C.length+t);var N=new Date(f,g,t);for(r&&(P=N.getTime()>=r.getTime()),e=1;e<=i;e+=1){var j=new Date(I,S,e),q=I===k&&S===D&&e===b,A=!1;r&&(A=j.getTime()>r.getTime()),!A&&c&&(A=!1===c.call(a,j,"day")),T.push(this.createItem({disabled:A,picked:q,highlighted:I===m&&S===v&&j.getDate()===w,muted:!0,text:e,view:"day next"}))}var O=[];for(e=1;e<=t;e+=1){var W=new Date(f,g,e),z=!1;n&&(z=W.getTime()<n.getTime()),!z&&r&&(z=W.getTime()>r.getTime()),!z&&c&&(z=!1===c.call(a,W,"day"));var J=f===k&&g===D&&e===b,E=J?"day picked":"day";O.push(this.createItem({disabled:z,picked:J,highlighted:f===m&&g===v&&W.getDate()===w,text:e,view:z?"day disabled":E}))}this.$monthPrev.toggleClass(l,F),this.$monthNext.toggleClass(l,P),this.$monthCurrent.toggleClass(l,F&&P).html(s.yearFirst?"".concat(f+p," ").concat(d[g]):"".concat(d[g]," ").concat(f).concat(p)),this.$days.html(C.join("")+O.join("")+T.join(""))}},q="".concat(c,"-top-left"),A="".concat(c,"-top-right"),O="".concat(c,"-bottom-left"),W="".concat(c,"-bottom-right"),z=[q,A,O,W].join(" "),J=function(){function i(t){var e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,i),this.$element=D(t),this.element=t,this.options=D.extend({},s,y[e.language],D.isPlainObject(e)&&e),this.$scrollParent=function(t,e){var i=1<arguments.length&&void 0!==e&&e,a=D(t),s=a.css("position"),n="absolute"===s,r=i?/auto|scroll|hidden/:/auto|scroll/,h=a.parents().filter(function(t,e){var i=D(e);return(!n||"static"!==i.css("position"))&&r.test(i.css("overflow")+i.css("overflow-y")+i.css("overflow-x"))}).eq(0);return"fixed"!==s&&h.length?h:D(t.ownerDocument||document)}(t,!0),this.built=!1,this.shown=!1,this.isInput=!1,this.inline=!1,this.initialValue="",this.initialDate=null,this.startDate=null,this.endDate=null,this.init()}return function(t,e,i){e&&a(t.prototype,e),i&&a(t,i)}(i,[{key:"init",value:function(){var t=this.$element,e=this.options,i=e.startDate,a=e.endDate,s=e.date;this.$trigger=D(e.trigger),this.isInput=t.is("input")||t.is("textarea"),this.inline=e.inline&&(e.container||!this.isInput),this.format=function(i){var t=String(i).toLowerCase(),e=t.match(T);if(!e||0===e.length)throw new Error("Invalid date format.");return i={source:t,parts:e},D.each(e,function(t,e){switch(e){case"dd":case"d":i.hasDay=!0;break;case"mm":case"m":i.hasMonth=!0;break;case"yyyy":case"yy":i.hasYear=!0}}),i}(e.format);var n=this.getValue();this.initialValue=n,this.oldValue=n,s=this.parseDate(s||n),i&&(i=this.parseDate(i),s.getTime()<i.getTime()&&(s=new Date(i)),this.startDate=i),a&&(a=this.parseDate(a),i&&a.getTime()<i.getTime()&&(a=new Date(i)),s.getTime()>a.getTime()&&(s=new Date(a)),this.endDate=a),this.date=s,this.viewDate=new Date(s),this.initialDate=new Date(this.date),this.bind(),(e.autoShow||this.inline)&&this.show(),e.autoPick&&this.pick()}},{key:"build",value:function(){if(!this.built){this.built=!0;var t=this.$element,e=this.options,i=D(e.template);this.$picker=i,this.$week=i.find(Y("week")),this.$yearsPicker=i.find(Y("years picker")),this.$yearsPrev=i.find(Y("years prev")),this.$yearsNext=i.find(Y("years next")),this.$yearsCurrent=i.find(Y("years current")),this.$years=i.find(Y("years")),this.$monthsPicker=i.find(Y("months picker")),this.$yearPrev=i.find(Y("year prev")),this.$yearNext=i.find(Y("year next")),this.$yearCurrent=i.find(Y("year current")),this.$months=i.find(Y("months")),this.$daysPicker=i.find(Y("days picker")),this.$monthPrev=i.find(Y("month prev")),this.$monthNext=i.find(Y("month next")),this.$monthCurrent=i.find(Y("month current")),this.$days=i.find(Y("days")),this.inline?D(e.container||t).append(i.addClass("".concat(c,"-inline"))):(D(document.body).append(i.addClass("".concat(c,"-dropdown"))),i.addClass(g).css({zIndex:parseInt(e.zIndex,10)})),this.renderWeek()}}},{key:"unbuild",value:function(){this.built&&(this.built=!1,this.$picker.remove())}},{key:"bind",value:function(){var t=this.options,e=this.$element;D.isFunction(t.show)&&e.on(p,t.show),D.isFunction(t.hide)&&e.on(h,t.hide),D.isFunction(t.pick)&&e.on(l,t.pick),this.isInput&&e.on(o,D.proxy(this.keyup,this)),this.inline||(t.trigger?this.$trigger.on(n,D.proxy(this.toggle,this)):this.isInput?e.on(r,D.proxy(this.show,this)):e.on(n,D.proxy(this.show,this)))}},{key:"unbind",value:function(){var t=this.$element,e=this.options;D.isFunction(e.show)&&t.off(p,e.show),D.isFunction(e.hide)&&t.off(h,e.hide),D.isFunction(e.pick)&&t.off(l,e.pick),this.isInput&&t.off(o,this.keyup),this.inline||(e.trigger?this.$trigger.off(n,this.toggle):this.isInput?t.off(r,this.show):t.off(n,this.show))}},{key:"showView",value:function(t){var e=this.$yearsPicker,i=this.$monthsPicker,a=this.$daysPicker,s=this.format;if(s.hasYear||s.hasMonth||s.hasDay)switch(Number(t)){case w:i.addClass(g),a.addClass(g),s.hasYear?(this.renderYears(),e.removeClass(g),this.place()):this.showView(m);break;case v:e.addClass(g),a.addClass(g),s.hasMonth?(this.renderMonths(),i.removeClass(g),this.place()):this.showView(w);break;default:e.addClass(g),i.addClass(g),s.hasDay?(this.renderDays(),a.removeClass(g),this.place()):this.showView(v)}}},{key:"hideView",value:function(){!this.inline&&this.options.autoHide&&this.hide()}},{key:"place",value:function(){if(!this.inline){var t=this.$element,e=this.options,i=this.$picker,a=D(document).outerWidth(),s=D(document).outerHeight(),n=t.outerWidth(),r=t.outerHeight(),h=i.width(),o=i.height(),l=t.offset(),c=l.left,d=l.top,u=parseFloat(e.offset),p=q;C(u)&&(u=10),o<d&&s<d+r+o?(d-=o+u,p=O):d+=r+u,a<c+h&&(c+=n-h,p=p.replace("left","right")),i.removeClass(z).addClass(p).css({top:d,left:c})}}},{key:"trigger",value:function(t,e){var i=D.Event(t,e);return this.$element.trigger(i),i}},{key:"createItem",value:function(t){var e=this.options,i=e.itemTag,a={text:"",view:"",muted:!1,picked:!1,disabled:!1,highlighted:!1},s=[];return D.extend(a,t),a.muted&&s.push(e.mutedClass),a.highlighted&&s.push(e.highlightedClass),a.picked&&s.push(e.pickedClass),a.disabled&&s.push(e.disabledClass),"<".concat(i,' class="').concat(s.join(" "),'" data-view="').concat(a.view,'">').concat(a.text,"</").concat(i,">")}},{key:"getValue",value:function(){var t=this.$element;return this.isInput?t.val():t.text()}},{key:"setValue",value:function(t){var e=0<arguments.length&&void 0!==t?t:"",i=this.$element;this.isInput?i.val(e):this.inline&&!this.options.container||i.text(e)}}],[{key:"setDefaults",value:function(t){var e=0<arguments.length&&void 0!==t?t:{};D.extend(s,y[e.language],D.isPlainObject(e)&&e)}}]),i}();if(D.extend&&D.extend(J.prototype,j,N,P),D.fn){var E=D.fn.datepicker;D.fn.datepicker=function(h){for(var t=arguments.length,o=new Array(1<t?t-1:0),e=1;e<t;e++)o[e-1]=arguments[e];var l;return this.each(function(t,e){var i=D(e),a="destroy"===h,s=i.data(c);if(!s){if(a)return;var n=D.extend({},i.data(),D.isPlainObject(h)&&h);s=new J(e,n),i.data(c,s)}if(b(h)){var r=s[h];D.isFunction(r)&&(l=r.apply(s,o),a&&i.removeData(c))}}),x(l)?this:l},D.fn.datepicker.Constructor=J,D.fn.datepicker.languages=y,D.fn.datepicker.setDefaults=J.setDefaults,D.fn.datepicker.noConflict=function(){return D.fn.datepicker=E,this}}});
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js"
++deleted file mode 100644
++index c9c5acddb..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ar-IQ'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['الأحد', 'الأثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
++-    daysShort: ['أحد', 'أثنين', 'ثلاثاء', 'اربعاء', 'خميس', 'جمعة', 'سبت'],
++-    daysMin: ['أ', 'ث', 'ث', 'أ', 'خ', 'ج', 'س'],
++-    weekStart: 1,
++-    months: ['كانون الثاني', 'شباط', 'اذار', 'نيسان', 'ايار', 'حزيران', 'تموز', 'آب', 'ايلول', 'تشرين الاول', 'تشرين الثاني', 'كانون الاول'],
++-    monthsShort: ['كانون ٢', 'شباط', 'اذار', 'نيسان', 'ايار', 'حزيران', 'تموز', 'آب', 'ايلول', 'تشرين ١', 'تشرين ٢', 'كانون ١']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js"
++deleted file mode 100644
++index c84ca88d3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ca-ES'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['diumenge', 'dilluns', 'dimarts', 'dimecres', 'dijous', 'divendres', 'dissabte'],
++-    daysShort: ['dg.', 'dl.', 'dt.', 'dc.', 'dj.', 'dv.', 'ds.'],
++-    daysMin: ['dg', 'dl', 'dt', 'dc', 'dj', 'dv', 'ds'],
++-    weekStart: 1,
++-    months: ['gener', 'febrer', 'març', 'abril', 'maig', 'juny', 'juliol', 'agost', 'setembre', 'octubre', 'novembre', 'desembre'],
++-    monthsShort: ['gen.', 'febr.', 'març', 'abr.', 'maig', 'juny', 'jul.', 'ag.', 'set.', 'oct.', 'nov.', 'des.']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js"
++deleted file mode 100644
++index 4b6e4ee9a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js"
+++++ /dev/null
++@@ -1,18 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['cs-CZ'] = {
++-    format: 'dd.mm.YYYY',
++-    days: ['Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota'],
++-    daysShort: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'],
++-    daysMin: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'],
++-    weekStart: 1,
++-    months: ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'],
++-    // Used everywhere, but probably not grammar correct
++-    monthsShort: ['Led', 'Úno', 'Bře', 'Dub', 'Květ', 'Čvn', 'Čvc', 'Srp', 'Zář', 'Říj', 'Lis', 'Pro']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js"
++deleted file mode 100644
++index 8eb442c2f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['da-DK'] = {
++-    format: 'dd-mm-yyyy',
++-    days: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
++-    daysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
++-    daysMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
++-    weekStart: 1,
++-    months: ['Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'December'],
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js"
++deleted file mode 100644
++index f0309485a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['de-DE'] = {
++-    format: 'dd.mm.yyyy',
++-    days: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
++-    daysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
++-    daysMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
++-    weekStart: 1,
++-    months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
++-    monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js"
++deleted file mode 100644
++index f3116a50c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js"
+++++ /dev/null
++@@ -1,20 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['el-GR'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο'],
++-    daysShort: ['Κυρ', 'Δευ', 'Τρι', 'Τετ', 'Πεμ', 'Παρ', 'Σαβ'],
++-    daysMin: ['Κ', 'Δ', 'Τ', 'Τ', 'Π', 'Π', 'Σ'],
++-    months: ['Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβρης', 'Οκτώβρης', 'Νοέμβρης', 'Δεκέμβρης'],
++-    monthsShort: ['Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μάι', 'Ιούν', 'Ιούλ', 'Άυγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ'],
++-    weekStart: 1,
++-    startView: 0,
++-    yearFirst: false,
++-    yearSuffix: ''
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js"
++deleted file mode 100644
++index 2e1e7f54c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js"
+++++ /dev/null
++@@ -1,11 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['en-GB'] = {
++-    format: 'dd/mm/yyyy'
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js"
++deleted file mode 100644
++index 7fb3bb41b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js"
+++++ /dev/null
++@@ -1,11 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['en-US'] = {
++-    format: 'mm/dd/yyyy'
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js"
++deleted file mode 100644
++index c45f84809..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['es-ES'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
++-    daysShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
++-    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
++-    weekStart: 1,
++-    months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
++-    monthsShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js"
++deleted file mode 100644
++index f512504d9..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['fi-FI'] = {
++-    format: 'dd.mm.yyyy',
++-    days: ['Sunnuntai', 'Maanantai', 'Tiistai', 'Keskiviikko', 'Torstai', 'Perjantai', 'Lauantai'],
++-    daysShort: ['Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La'],
++-    daysMin: ['Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La'],
++-    weekStart: 1,
++-    months: ['Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu'],
++-    monthsShort: ['Tammi', 'Helmi', 'Maalis', 'Huhti', 'Touko', 'Kesä', 'Heinä', 'Elo', 'Syys', 'Loka', 'Marras', 'Joulu']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js"
++deleted file mode 100644
++index 04024699d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['fr-FR'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
++-    daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
++-    daysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
++-    weekStart: 1,
++-    months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
++-    monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js"
++deleted file mode 100644
++index a39c706f3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['hu-HU'] = {
++-    format: 'yyyy. mm. dd.',
++-    days: ['vasárnap', 'hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat'],
++-    daysShort: ['vas', 'hé', 'ke', 'sze', 'csüt', 'pé', 'szo'],
++-    daysMin: ['V', 'H', 'K', 'Sz', 'Cs', 'P', 'Sz'],
++-    weekStart: 1,
++-    months: ['január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december'],
++-    monthsShort: ['jan', 'feb', 'már', 'ápr', 'máj', 'jún', 'júl', 'aug', 'szep', 'okt', 'nov', 'dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js"
++deleted file mode 100644
++index 0d5556bd0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js"
+++++ /dev/null
++@@ -1,18 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['is-IS'] = {
++-    format: 'dd.mm.YYYY',
++-    // Capital letters are not used in day/month names
++-    days: ['sunnudagur', 'mánudagur', 'þriðjudagur', 'miðvikudagur', 'fimmtudagur', 'föstudagur', 'laugardagur'],
++-    daysShort: ['sun', 'mán', 'þri', 'mið', 'fim', 'fös', 'lau'],
++-    daysMin: ['Su', 'Má', 'Þr', 'Mi', 'Fi', 'Fö', 'La'],
++-    weekStart: 1,
++-    months: ['janúar', 'febrúar', 'mars', 'apríl', 'maí', 'júní', 'júlí', 'ágúst', 'september', 'október', 'nóvember', 'desember'],
++-    monthsShort: ['jan', 'feb', 'mar', 'apr', 'maí', 'jún', 'júl', 'ágú', 'sep', 'okt', 'nóv', 'des']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js"
++deleted file mode 100644
++index be56ec65b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['it-IT'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
++-    daysShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
++-    daysMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
++-    weekStart: 1,
++-    months: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
++-    monthsShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js"
++deleted file mode 100644
++index 1dce1741c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js"
+++++ /dev/null
++@@ -1,19 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ja-JP'] = {
++-    format: 'yyyy年mm月dd日',
++-    days: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
++-    daysShort: ['日曜', '月曜', '火曜', '水曜', '木曜', '金曜', '土曜'],
++-    daysMin: ['日', '月', '火', '水', '木', '金', '土'],
++-    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
++-    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
++-    weekStart: 1,
++-    yearFirst: true,
++-    yearSuffix: '年'
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js"
++deleted file mode 100644
++index 4dffea780..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['km-KH'] = {
++-    format: 'dd-mm-yyyy',
++-    days: ['អាទិត្យ', 'ច័ន្ទ', ' អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'],
++-    daysShort: ['អទ', 'ចន', 'អង', 'ពធ', 'ពហ', 'សក', 'សរ'],
++-    daysMin: ['អ', 'ច', 'អ', 'ព', 'ព្', 'ស', 'ស'],
++-    weekStart: 1,
++-    months: ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'],
++-    monthsShort: ['មរ', 'កម', 'មន', 'មស', 'ឧស', 'មថ', 'កដ', 'សហ', 'កញ', 'តល', 'វឆ', 'ធ្ន']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js"
++deleted file mode 100644
++index 4ac1c497d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js"
+++++ /dev/null
++@@ -1,19 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ko-KR'] = {
++-    format: 'yyyy. mm. dd',
++-    days: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
++-    daysShort: ['일', '월', '화', '수', '목', '금', '토'],
++-    daysMin: ['일', '월', '화', '수', '목', '금', '토'],
++-    months: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
++-    monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
++-    weekStart: 1,
++-    yearFirst: true,
++-    yearSuffix: '년'
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js"
++deleted file mode 100644
++index a886df432..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['lt-LT'] = {
++-    format: 'yyyy-mm-dd',
++-    days: ['Sekmadienis', 'Pirmadienis', 'Antradienis', 'Trečiadienis', 'Ketvirtadienis', 'Penktadienis', 'Šeštadienis'],
++-    daysShort: ['Sekm', 'Pirm', 'Antr', 'Treč', 'Ketv', 'Penkt', 'Šešt'],
++-    daysMin: ['Sk', 'Pr', 'An', 'Tr', 'Kt', 'Pn', 'Št'],
++-    weekStart: 1,
++-    months: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis', 'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'],
++-    monthsShort: ['Sau', 'Vas', 'Kov', 'Bal', 'Geg', 'Bir', 'Lie', 'Rgp', 'Rgs', 'Spa', 'Lap', 'Gru']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js"
++deleted file mode 100644
++index 856080b81..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js"
+++++ /dev/null
++@@ -1,20 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['lv-LV'] = {
++-    format: 'YYYY-mm-dd',
++-    days: ['Svētdiena', 'Pirmdiena', 'Otrdiena', 'Trešdiena', 'Ceturtdiena', 'Piektdiena', 'Sestdiena'],
++-    daysShort: ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'],
++-    daysMin: ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'],
++-    months: ['Janvāris', 'Februāris', 'Marts', 'Aprīlis', 'Maijs', 'Jūnijs', 'Jūlijs', 'Augusts', 'Septembris', 'Oktobris', 'Novembris', 'Decembris'],
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jūn', 'Jūl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
++-    weekStart: 1,
++-    startView: 0,
++-    yearFirst: false,
++-    yearSuffix: ''
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js"
++deleted file mode 100644
++index b7a9d5d5d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['nb-NO'] = {
++-    format: 'dd-mm-yyyy',
++-    days: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
++-    daysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
++-    daysMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
++-    weekStart: 1,
++-    months: ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember'],
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js"
++deleted file mode 100644
++index c76a8d97f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['nl-NL'] = {
++-    format: 'dd-mm-yyyy',
++-    days: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
++-    daysShort: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
++-    daysMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
++-    weekStart: 1,
++-    months: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js"
++deleted file mode 100644
++index 7b5501c1e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['oc-FR'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['Dimenge', 'Diluns', 'Dimars', 'Dimècres', 'Dijòus', 'Divendres', 'Dissabte'],
++-    daysShort: ['Dg', 'Dl', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds'],
++-    daysMin: ['dg', 'dl', 'dm', 'dc', 'dj', 'dv', 'ds'],
++-    weekStart: 1,
++-    months: ['Genièr', 'Febrièr', 'Març', 'Abrial', 'Mai', 'Junh', 'Julhet', 'Agost', 'Setembre', 'Octòbre', 'Novembre', 'Decembre'],
++-    monthsShort: ['Gen', 'Feb', 'Març', 'Abr', 'Mai', 'Junh', 'Julh', 'Ago', 'Set', 'Oct', 'Nov', 'Dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js"
++deleted file mode 100644
++index 271d58001..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js"
+++++ /dev/null
++@@ -1,18 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['pl-PL'] = {
++-    format: 'dd.mm.YYYY',
++-    days: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
++-    daysShort: ['Niedz', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],
++-    // Used and correct are only daysShort, daysMin are just shorted to fit UI
++-    daysMin: ['Nie', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],
++-    weekStart: 1,
++-    months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
++-    monthsShort: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js"
++deleted file mode 100644
++index e8f86e0c5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js"
+++++ /dev/null
++@@ -1,16 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['pt-BR'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
++-    daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
++-    daysMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
++-    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
++-    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js"
++deleted file mode 100644
++index 0380e813d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js"
+++++ /dev/null
++@@ -1,20 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ru-RU'] = {
++-    format: 'dd.mm.YYYY',
++-    days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
++-    daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
++-    daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
++-    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
++-    monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
++-    weekStart: 1,
++-    startView: 0,
++-    yearFirst: false,
++-    yearSuffix: ''
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js"
++deleted file mode 100644
++index 6bc0832c5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['si-LK'] = {
++-    format: 'yyyy/mm/dd',
++-    days: ['ඉරිදා', 'සදුදා', 'අගහරුවදා', 'බදාදා', 'බ්‍රහස්පතින්දා', 'සිකුරාදා', 'සෙනසුරාදා'],
++-    daysShort: ['ඉරිදා', 'සදුදා', 'අග', 'බදාදා', 'බ්‍රහස්', 'සිකු', 'සෙන'],
++-    daysMin: ['ඉරිදා', 'සදුදා', 'අග', 'බදාදා', 'බ්‍රහස්', 'සිකු', 'සෙන'],
++-    weekStart: 1,
++-    months: ['ජනවාරි', 'පෙබරවාරි', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජුනි', 'ජූලි', 'අගෝස්තු', 'සැප්තැම්බර්', 'ඔක්තෝබර්', 'නොවැම්බර්', 'දෙසැම්බර්'],
++-    monthsShort: ['ජන', 'පෙබ', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජුනි', 'ජූලි', 'අගෝ', 'සැප්', 'ඔක්', 'නොවැ', 'දෙසැ']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js"
++deleted file mode 100644
++index 65a9f03a2..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['sk-SK'] = {
++-    format: 'dd.mm.YYYY',
++-    days: ['Nedeľa', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota'],
++-    daysShort: ['Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So'],
++-    daysMin: ['Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So'],
++-    weekStart: 1,
++-    months: ['Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl', 'August', 'September', 'Október', 'November', 'December'],
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js"
++deleted file mode 100644
++index 268e78aec..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['sv-SE'] = {
++-    format: 'yyyy-mm-dd',
++-    days: ['Söndag', 'Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag'],
++-    daysShort: ['Sön', 'Mån', 'Tis', 'Ons', 'Tor', 'Fre', 'Lör'],
++-    daysMin: ['Sö', 'Må', 'Ti', 'On', 'To', 'Fr', 'Lö'],
++-    weekStart: 1,
++-    months: ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'],
++-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js"
++deleted file mode 100644
++index f1e999617..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ta-TA'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['ஞாயிற்றுக்கிழமை','திங்கட்கிழமை','செவ்வாய்கிழமை','புதன்கிழமை','வியாழக்கிழமை','வெள்ளிக்கிழமை','சனிக்கிழமை'],
++-    daysShort: ['ஞாயிறு','திங்கள்','செவ்வாய்','புதன்','வியாழன்','வெள்ளி','சனி'],
++-    daysMin: ['ஞா','தி','செ','பு','வி','வெ','ச'],
++-    weekStart: 1,
++-    months: ['ஜனவரி','பிப்ரவரி','மார்ச்','ஏப்ரல்','மே','ஜூன்','ஜூலை','ஆகஸ்ட்','செப்டெம்பர்','அக்டோபர்','நவம்பர்','டிசம்பர்'],
++-    monthsShort: ['ஜன', 'பிப்', 'மார்', 'ஏப்', 'மே', 'ஜூன்', 'ஜூலை', 'ஆக', 'செப்', 'அக்', 'நவ', 'டிச']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js"
++deleted file mode 100644
++index 582ccc8ac..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['th-TH'] = {
++-    format: 'dd/mm/yyyy',
++-    days: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
++-    daysShort: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
++-    daysMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
++-    weekStart: 1,
++-    months: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
++-    monthsShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js"
++deleted file mode 100644
++index 1b60f662a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js"
+++++ /dev/null
++@@ -1,17 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['tr-TR'] = {
++-    format: 'dd.mm.yyyy',
++-    days: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
++-    daysShort: ['Paz', 'Pts', 'Sal', 'Çrş', 'Prş', 'Cum', 'Cts'],
++-    daysMin: ['P', 'P', 'S', 'Ç', 'P', 'C', 'C'],
++-    weekStart: 1,
++-    months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
++-    monthsShort: ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara']
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js"
++deleted file mode 100644
++index dae512001..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js"
+++++ /dev/null
++@@ -1,18 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['ug-CN'] = {
++-    format: 'yyyy-mm-dd',
++-    days: ['يەكشەنبە', 'دۈشەنبە', 'سەيشەنبە', 'چارشەنبە', 'پەيشەنبە', 'جۈمە', 'شەنبە'],
++-    daysShort: ['ي', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
++-    daysMin:  ['ي', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
++-    months: ['يانۋار', 'فېۋىرال', 'مارت', 'ئاپرىل', 'ماي', 'ئىيۇن', 'ئىيۇل', 'ئاۋغۇست', 'سىنتەبىر', 'ئۆكتەبىر', 'نويابىر', 'دىكابىر'],
++-    monthsShort: ['يانۋار', 'فېۋىرال', 'مارت', 'ئاپرىل', 'ماي', 'ئىيۇن', 'ئىيۇل', 'ئاۋغۇست', 'سىنتەبىر', 'ئۆكتەبىر', 'نويابىر', 'دىكابىر'],
++-    weekStart: 1,
++-    yearFirst: true,
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js"
++deleted file mode 100644
++index 1803b3b7b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js"
+++++ /dev/null
++@@ -1,18 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['vi-VN'] = {
++-    days: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
++-    daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
++-    daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
++-    months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
++-    monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
++-    today: "Hôm nay",
++-    clear: "Xóa",
++-    format: "dd/mm/yyyy"
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js"
++deleted file mode 100644
++index 0fd1da6e3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js"
+++++ /dev/null
++@@ -1,19 +0,0 @@
++-(function (global, factory) {
++-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
++-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
++-  (factory(global.jQuery));
++-}(this, (function ($) {
++-  'use strict';
++-
++-  $.fn.datepicker.languages['zh-CN'] = {
++-    format: 'yyyy年mm月dd日',
++-    days: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
++-    daysShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
++-    daysMin: ['日', '一', '二', '三', '四', '五', '六'],
++-    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
++-    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
++-    weekStart: 1,
++-    yearFirst: true,
++-    yearSuffix: '年'
++-  };
++-})));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html"
++deleted file mode 100644
++index eb7a4292b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html"
+++++ /dev/null
++@@ -1,35 +0,0 @@
++-{% if REGISTRATION_AGE_REG_DISPLAY %}
++-	<dl>
++-		<dt><label for="registration_age_datepicker">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label></dt>
++-		<dd>
++-		{% if REGISTRATION_AGE_DATEPICKER %}
++-			{#
++-				left side: phpBB USER_LANG language variable, see common.php of respective language
++-				right side: language-country code in i18n filenames, see ext/leinad4mind/specialbirthday/styles/all/template/datepicker/i18n
++-			#}
++-			{% set datepicker_lang_map = {
++-				'en-gb'		: 'en-GB',
++-				'en-us' 	: 'en-US',
++-				'pt'		: 'pt-PT',
++-				'pt_preao'	: 'pt-PT',
++-				'pt_br'		: 'pt-BR',
++-				'es'		: 'es-ES',
++-				'es-x-tu'	: 'es-ES',
++-			} %}
++-			{% set datepicker_lang = datepicker_lang_map[lang('USER_LANG')] | default('en-GB') %}
++-			{% INCLUDECSS '@leinad4mind_specialbirthday/datepicker/datepicker.min.css' %}
++-			{% INCLUDEJS '@leinad4mind_specialbirthday/datepicker/datepicker.min.js' %}
++-			{% INCLUDEJS '@leinad4mind_specialbirthday/datepicker/i18n/datepicker.' ~ datepicker_lang ~ '.js' %}
++-			{% INCLUDEJS '@leinad4mind_specialbirthday/js/common.js' %}
++-			<input type="text" name="registration_age_datepicker" id="registration_age_datepicker" class="inputbox autowidth" size="25" tabindex="6" readonly data-lang="{{ datepicker_lang }}">
++-			<input type="hidden" name="registration_age_day" id="registration_age_day" value="">
++-			<input type="hidden" name="registration_age_month" id="registration_age_month" value="">
++-			<input type="hidden" name="registration_age_year" id="registration_age_year" value="">
++-		{% else  %}
++-			{{ lang('DAY') ~ lang('COLON') }} <select id="registration_age_datepicker" name="registration_age_day">{{ S_BIRTHDAY_DAY_OPTIONS }}</select>
++-			{{ lang('MONTH') ~ lang('COLON') }} <select name="registration_age_month">{{ S_BIRTHDAY_MONTH_OPTIONS }}</select>
++-			{{ lang('YEAR') ~ lang('COLON') }} <select name="registration_age_year">{{ S_BIRTHDAY_YEAR_OPTIONS }}</select>
++-		{% endif  %}
++-		</dd>
++-	</dl>
++-{% endif  %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html"
++new file mode 100644
++index 000000000..710e40187
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html"
++@@ -0,0 +1,11 @@
+++{% if REGISTRATION_AGE_REG_DISPLAY %}
+++	{% INCLUDECSS '@leinad4mind_specialbirthday/specialbirthday.css' %}
+++	<dl>
+++		<dt><label for="birthdate">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label></dt>
+++		<dd>
+++			{{ lang('DAY') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_day" type="number" maxlength="2" name="registration_age_day" value="{{ REGISTRATION_AGE_DAY }}" min="1" max="31" />
+++			{{ lang('MONTH') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_month" type="number" maxlength="2" name="registration_age_month" value="{{ REGISTRATION_AGE_MONTH }}" min="1" max="12" />
+++			{{ lang('YEAR') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_year" type="number" maxlength="4" name="registration_age_year" value="{{ REGISTRATION_AGE_YEAR }}" min="{{ YEAR_START }}" max="{{ YEAR_END }}" step="-1"/>
+++		</dd>
+++	</dl>
+++{% endif  %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html"
++deleted file mode 100644
++index 0b490bbe3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if postrow.POSTER_AGE %}
++-	<dd class="profile-joined"><strong>{{ lang('AGE') }}{{ lang('COLON') }} {{ postrow.POSTER_AGE }}</strong></dd>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/js/common.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/js/common.js"
++deleted file mode 100644
++index b7b6632b7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialbirthday/styles/all/template/js/common.js"
+++++ /dev/null
++@@ -1,18 +0,0 @@
++-jQuery(function($) {
++-    let $element = $('#registration_age_datepicker');
++-    $element.datepicker({
++-        autoShow: false,
++-        autoHide: true,
++-        autoPick: false,
++-        inline: false,
++-        language: $element.data('lang'),
++-        date: new Date(),
++-        startDate: new Date(1900, 0, 1),
++-        endDate: new Date(),
++-        startView: 2
++-    }).on('pick.datepicker', function(e) {
++-        $('#registration_age_day').val(e.date.getUTCDate());
++-        $('#registration_age_month').val(e.date.getUTCMonth() + 1);
++-        $('#registration_age_year').val(e.date.getUTCFullYear());
++-    });
++-});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialbirthd
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/event/listener.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/event/listener.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/event/listener.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/event/listener.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
@@ -131,7 +132,6 @@ class listener implements EventSubscriberInterface
 		$this->template->assign_vars([
 			'REGISTRATION_AGE_REQUIRED'		=> $this->config['registration_age_required'],
 			'REGISTRATION_AGE_REG_DISPLAY'	=> $this->config['registration_age_reg_display'],
-			'REGISTRATION_AGE_DATEPICKER'	=> $this->config['registration_age_datepicker'],
 			'REGISTRATION_AGE_DAY'			=> $today->format('d'),
 			'REGISTRATION_AGE_MONTH'		=> $today->format('m'),
 			'REGISTRATION_AGE_YEAR'			=> $today->format('Y'),
@@ -139,47 +139,13 @@ class listener implements EventSubscriberInterface
 			'YEAR_END' 						=> $today->format('Y'),
 		]);
 
-		$data = [
-			'registration_age_day'		=> $this->request->variable('registration_age_day', 0),
-			'registration_age_month'	=> $this->request->variable('registration_age_month', 0),
-			'registration_age_year'		=> $this->request->variable('registration_age_year', 0),
-		];
-
-		if (!$this->config['registration_age_datepicker'])
-		{
-			$s_birthday_day_options = '<option value="0"' . ((!$data['registration_age_day']) ? ' selected="selected"' : '') . '>--</option>';
-			for ($i = 1; $i < 32; $i++)
-			{
-				$selected = ($i == $data['registration_age_day']) ? ' selected="selected"' : '';
-				$s_birthday_day_options .= "<option value=\"$i\"$selected>$i</option>";
-			}
-
-			$s_birthday_month_options = '<option value="0"' . ((!$data['registration_age_month']) ? ' selected="selected"' : '') . '>--</option>';
-			for ($i = 1; $i < 13; $i++)
-			{
-				$selected = ($i == $data['registration_age_month']) ? ' selected="selected"' : '';
-				$s_birthday_month_options .= "<option value=\"$i\"$selected>$i</option>";
-			}
-
-			$now = getdate();
-			$s_birthday_year_options = '<option value="0"' . ((!$data['registration_age_year']) ? ' selected="selected"' : '') . '>--</option>';
-			for ($i = $now['year'] - 100; $i <= $now['year']; $i++)
-			{
-				$selected = ($i == $data['registration_age_year']) ? ' selected="selected"' : '';
-				$s_birthday_year_options .= "<option value=\"$i\"$selected>$i</option>";
-			}
-			unset($now);
-
-			$this->template->assign_vars([
-				'S_BIRTHDAY_DAY_OPTIONS'	=> $s_birthday_day_options,
-				'S_BIRTHDAY_MONTH_OPTIONS'	=> $s_birthday_month_options,
-				'S_BIRTHDAY_YEAR_OPTIONS'	=> $s_birthday_year_options,
+		$event['data'] = array_merge($event['data'], [
+			'registration_age_day'		=> $this->request->variable('registration_age_day', ''),
+			'registration_age_month'	=> $this->request->variable('registration_age_month', ''),
+			'registration_age_year'		=> $this->request->variable('registration_age_year', ''),
 		]);
 	}
 
-		$event['data'] = array_merge($event['data'], $data);
-	}
-
 	/**
 	* Validate the input data
 	*
@@ -202,11 +168,7 @@ class listener implements EventSubscriberInterface
 		if ($this->config['registration_age_reg_display'])
 		{
 			// Make sure that there is valid birthdate date entered in all fields before going any further
-			if (
-				!is_numeric($data['registration_age_day']) || !$data['registration_age_day'] ||
-				!is_numeric($data['registration_age_month']) || !$data['registration_age_month'] ||
-				!is_numeric($data['registration_age_year']) || !$data['registration_age_year']
-			)
+			if (!is_numeric($data['registration_age_day']) || !is_numeric($data['registration_age_month']) || !is_numeric($data['registration_age_year']))
 			{
 				if ($this->config['registration_age_required'])
 				{
@@ -232,7 +194,7 @@ class listener implements EventSubscriberInterface
 						$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_LOG_FAIL', time(), array($data['username'], $user_age));
 					}
 
-					if ($this->config['registration_age_ip'])
+					if ($this->config['registration_age_ip'] && count($error) === 0)
 					{
 						user_ban('ip', $this->user->ip, $this->config['registration_age_ban_length'], '', 0, $this->language->lang('BAN_REASON'), $this->config['registration_age_ban_reason']);
 						$this->user->check_ban(false, $this->user->ip);
@@ -336,7 +298,7 @@ class listener implements EventSubscriberInterface
 	{
 		if ($this->is_valid_birthday($this->user->data['user_birthday']))
 		{
-			if ($this->user->data['user_birthday'] != $event['data']['user_birthday'])
+			if ( strtotime(str_replace(' ', '', $this->user->data['user_birthday'])) != strtotime(str_replace(' ', '', $event['data']['user_birthday'])) )
 			{
 				if ($this->config['registration_age_change'])
 				{
@@ -488,7 +450,7 @@ class listener implements EventSubscriberInterface
 	{
 		if (!$birthday)
 		{
-			return true;
+			return false;
 		}
 
 		list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthday));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/ext.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/ext.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/ext.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/ext.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/acp_data_specialbirthday.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/acp_specialbirthday.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
@@ -52,12 +53,11 @@ $lang = array_merge($lang, array(
 	'REGISTRATION_AGE_EXPLAIN'				=> 'Select the age at which you want to limit access.',
 	'REGISTRATION_AGE_REQUIRED'				=> 'Users are required to enter their birthday',
 	'REGISTRATION_AGE_REG_DISPLAY'			=> 'Display birthday field on registration',
-	'REGISTRATION_AGE_DATEPICKER'			=> 'Use datepicker instead of select elements to pick the date when registering',
 	'REGISTRATION_AGE_IP'					=> 'Block IP',
 	'REGISTRATION_AGE_IP_EXPLAIN'			=> 'Ban the IP address for the user attempting to register under age.',
 	'REGISTRATION_AGE_LOG'					=> 'Log failed attempts',
 	'REGISTRATION_AGE_LOG_EXPLAIN'			=> 'Create a log entry for any attempted registrations that fail due to an incorrect age being entered.',
-	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthday options',
+	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthdate options',
 
 	'BAN_END_TEXT' => array(
 		'0' 	=> 'Permanent',
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/ext_enable_error.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/ext_enable_error.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/info_acp_specialbirthday.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
@@ -39,10 +40,10 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	'ACP_USER_UTILS'					=> 'User utilities',
 
-	'REGISTRATION_AGE'					=> 'Special Birthday',
-	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthday Settings Updated</strong>',
-	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthday',
-	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthday check failed</strong><br>» %1$s entered an age of %2$s',
+	'REGISTRATION_AGE'					=> 'Special Birthdate',
+	'REGISTRATION_AGE_LOG'				=> '<strong>Special Birthdate Settings Updated</strong>',
+	'REGISTRATION_AGE_MANAGE'			=> 'Manage Special Birthdate',
+	'REGISTRATION_AGE_LOG_FAIL'			=> '<strong>Birthdate check failed</strong><br>» %1$s entered an age of %2$s',
 	'REGISTRATION_AGE_CHANGED'			=> '<strong>Birthday changed</strong><br>» from %1$s to %2$s',
 	'REGISTRATION_AGE_CHANGE_ATTEMPT'	=> '<strong>Attempted to change birthday</strong><br>» to %1$s, age: %2$d',
 ));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/language/en/ucp_specialbirthday.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/change_age.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/change_age.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/change_age.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/change_age.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/datepicker_option.php" "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/datepicker_option.php"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/datepicker_option.php"
+++ /dev/null
@@ -1,22 +0,0 @@
-<?php
-/**
-*
-* @package Special Birthday
-* @copyright (c) 2016 leinad4mind
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-namespace leinad4mind\specialbirthday\migrations;
-
-use phpbb\db\migration\migration;
-
-class datepicker_option extends migration
-{
-	public function update_data()
-	{
-		return [
-			['config.add', ['registration_age_datepicker', 0]],
-		];
-	}
-}
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/display_options.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/display_options.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/display_options.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/display_options.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/registration_age_required.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/registration_age_required.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/registration_age_required.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/registration_age_required.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/registration_display.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/registration_display.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/registration_display.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/registration_display.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/user_registration_age_profile.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/version_1_0_0.php" "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
--- "[ORIGINAL]/leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/migrations/version_1_0_0.php"
@@ -1,4 +1,5 @@
 <?php
+
 /**
 *
 * @package Special Birthday
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html" "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_profile_profile_info_after.html"
@@ -0,0 +1,24 @@
+{% if S_REGISTRATION_AGE_PROFILE %}
+	<div class="control-group">
+		<label class="control-label">{{ lang('REGISTRATION_AGE_PROFILE') ~ lang('COLON') }}</label>
+		<div class="controls controls-row">
+			<div class="clearfix">
+				<div class="col-md-2">
+					<label for="user_registration_age_profile_0">
+						<input type="radio" id="user_registration_age_profile_0" name="user_registration_age_profile" value="0"{{ not REGISTRATION_AGE_PROFILE ? ' checked' }}> {{ lang('REGISTRATION_AGE_NOBODY') }}
+					</label>
+				</div>
+				<div class="col-md-2">
+					<label for="user_registration_age_profile_1">
+						<input type="radio" id="user_registration_age_profile_1" name="user_registration_age_profile" value="1"{{ REGISTRATION_AGE_PROFILE == 1 ? ' checked' }}> {{ lang('REGISTRATION_AGE_EVERYBODY') }}
+					</label>
+				</div>
+				<div class="col-md-3">
+					<label for="user_registration_age_profile_2">
+						<input type="radio" id="user_registration_age_profile_2" name="user_registration_age_profile" value="2"{{ REGISTRATION_AGE_PROFILE == 2 ? ' checked' }}> {{ lang('REGISTRATION_AGE_FRIENDS') }}
+					</label>
+				</div>
+			</div>
+		</div>
+	</div>
+{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html" "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/ucp_register_profile_fields_before.html"
@@ -0,0 +1,27 @@
+{% if REGISTRATION_AGE_REG_DISPLAY %}
+	{% INCLUDECSS '@leinad4mind_specialbirthday/specialbirthday.css' %}
+	<div class="col-md-6">
+		<div class="form-group"> 
+			<div class="control-group">
+				<label class="control-label" for="birthdate">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label>
+				<div class="controls controls-row">
+					<div class="clearfix">
+						<div class="d-flex col-md-3">
+							<label for="registration_age_day" class="control-label mr-1">{{ lang('DAY') }}</label>
+							<input class="form-control" type="number" name="registration_age_day" id="registration_age_day" size="25" maxlength="2" value="{{ REGISTRATION_AGE_DAY }}" placeholder="{{ lang('DAY') }}" min="1" max="31" />
+						</div>
+						<div class="d-flex col-md-3">
+							<label for="registration_age_month" class="control-label mr-1">{{ lang('MONTH') }}</label>
+							<input class="form-control" type="number" name="registration_age_month" id="registration_age_month" size="25" maxlength="2" value="{{ REGISTRATION_AGE_MONTH }}" placeholder="{{ lang('MONTH') }}" min="1" max="12" />
+							
+						</div>
+						<div class="d-flex col-md-3">
+							<label for="registration_age_year" class="control-label mr-1">{{ lang('YEAR') }}</label>
+							<input class="form-control" type="number" name="registration_age_year" id="registration_age_year" size="25" maxlength="4" value="{{ REGISTRATION_AGE_YEAR }}" placeholder="{{ lang('YEAR') }}" min="{{ YEAR_START }}" max="{{ YEAR_END }}" step="-1" />
+						</div>
+					</div>
+				</div>
+			</div>
+		</div>
+	</div>
+{% endif  %}
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak" "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_before.bak"
@@ -0,0 +1,3 @@
+{% if postrow.POSTER_AGE %}
+	<li><strong>{{ lang('AGE') }}{{ lang('COLON') }}</strong> {{ postrow.POSTER_AGE }}</li>
+{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css" "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/FLATBOOTS/theme/specialbirthday.css"
@@ -0,0 +1,14 @@
+/**
+* specialbirthday.css
+**/
+
+input[type="number"] {
+	min-width: 70px;
+}
+.d-flex {
+	display: -ms-flexbox!important;
+	display: flex!important;
+}
+.mr-1 {
+	margin-right: 1rem;
+}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.css"
+++ /dev/null
@@ -1,206 +0,0 @@
-/*!
- * Datepicker v1.0.9
- * https://fengyuanchen.github.io/datepicker
- *
- * Copyright 2014-present Chen Fengyuan
- * Released under the MIT license
- *
- * Date: 2019-09-21T06:57:30.334Z
- */
-
-.datepicker-container {
-  background-color: #fff;
-  direction: ltr;
-  font-size: 12px;
-  left: 0;
-  line-height: 30px;
-  position: fixed;
-  -webkit-tap-highlight-color: transparent;
-  top: 0;
-  -ms-touch-action: none;
-  touch-action: none;
-  -webkit-touch-callout: none;
-  -webkit-user-select: none;
-  -moz-user-select: none;
-  -ms-user-select: none;
-  user-select: none;
-  width: 210px;
-  z-index: -1;
-}
-
-.datepicker-container::before,
-.datepicker-container::after {
-  border: 5px solid transparent;
-  content: " ";
-  display: block;
-  height: 0;
-  position: absolute;
-  width: 0;
-}
-
-.datepicker-dropdown {
-  border: 1px solid #ccc;
-  -webkit-box-shadow: 0 3px 6px #ccc;
-  box-shadow: 0 3px 6px #ccc;
-  -webkit-box-sizing: content-box;
-  box-sizing: content-box;
-  position: absolute;
-  z-index: 1;
-}
-
-.datepicker-inline {
-  position: static;
-}
-
-.datepicker-top-left,
-.datepicker-top-right {
-  border-top-color: #39f;
-}
-
-.datepicker-top-left::before,
-.datepicker-top-left::after,
-.datepicker-top-right::before,
-.datepicker-top-right::after {
-  border-top: 0;
-  left: 10px;
-  top: -5px;
-}
-
-.datepicker-top-left::before,
-.datepicker-top-right::before {
-  border-bottom-color: #39f;
-}
-
-.datepicker-top-left::after,
-.datepicker-top-right::after {
-  border-bottom-color: #fff;
-  top: -4px;
-}
-
-.datepicker-bottom-left,
-.datepicker-bottom-right {
-  border-bottom-color: #39f;
-}
-
-.datepicker-bottom-left::before,
-.datepicker-bottom-left::after,
-.datepicker-bottom-right::before,
-.datepicker-bottom-right::after {
-  border-bottom: 0;
-  bottom: -5px;
-  left: 10px;
-}
-
-.datepicker-bottom-left::before,
-.datepicker-bottom-right::before {
-  border-top-color: #39f;
-}
-
-.datepicker-bottom-left::after,
-.datepicker-bottom-right::after {
-  border-top-color: #fff;
-  bottom: -4px;
-}
-
-.datepicker-top-right::before,
-.datepicker-top-right::after,
-.datepicker-bottom-right::before,
-.datepicker-bottom-right::after {
-  left: auto;
-  right: 10px;
-}
-
-.datepicker-panel > ul {
-  margin: 0;
-  padding: 0;
-  width: 102%;
-}
-
-.datepicker-panel > ul::before,
-.datepicker-panel > ul::after {
-  content: " ";
-  display: table;
-}
-
-.datepicker-panel > ul::after {
-  clear: both;
-}
-
-.datepicker-panel > ul > li {
-  background-color: #fff;
-  cursor: pointer;
-  float: left;
-  height: 30px;
-  list-style: none;
-  margin: 0;
-  padding: 0;
-  text-align: center;
-  width: 30px;
-}
-
-.datepicker-panel > ul > li:hover {
-  background-color: rgb(229, 242, 255);
-}
-
-.datepicker-panel > ul > li.muted,
-.datepicker-panel > ul > li.muted:hover {
-  color: #999;
-}
-
-.datepicker-panel > ul > li.highlighted {
-  background-color: rgb(229, 242, 255);
-}
-
-.datepicker-panel > ul > li.highlighted:hover {
-  background-color: rgb(204, 229, 255);
-}
-
-.datepicker-panel > ul > li.picked,
-.datepicker-panel > ul > li.picked:hover {
-  color: #39f;
-}
-
-.datepicker-panel > ul > li.disabled,
-.datepicker-panel > ul > li.disabled:hover {
-  background-color: #fff;
-  color: #ccc;
-  cursor: default;
-}
-
-.datepicker-panel > ul > li.disabled.highlighted,
-.datepicker-panel > ul > li.disabled:hover.highlighted {
-  background-color: rgb(229, 242, 255);
-}
-
-.datepicker-panel > ul > li[data-view="years prev"],
-.datepicker-panel > ul > li[data-view="year prev"],
-.datepicker-panel > ul > li[data-view="month prev"],
-.datepicker-panel > ul > li[data-view="years next"],
-.datepicker-panel > ul > li[data-view="year next"],
-.datepicker-panel > ul > li[data-view="month next"],
-.datepicker-panel > ul > li[data-view="next"] {
-  font-size: 18px;
-}
-
-.datepicker-panel > ul > li[data-view="years current"],
-.datepicker-panel > ul > li[data-view="year current"],
-.datepicker-panel > ul > li[data-view="month current"] {
-  width: 150px;
-}
-
-.datepicker-panel > ul[data-view="years"] > li,
-.datepicker-panel > ul[data-view="months"] > li {
-  height: 52.5px;
-  line-height: 52.5px;
-  width: 52.5px;
-}
-
-.datepicker-panel > ul[data-view="week"] > li,
-.datepicker-panel > ul[data-view="week"] > li:hover {
-  background-color: #fff;
-  cursor: default;
-}
-
-.datepicker-hide {
-  display: none;
-}
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.js"
+++ /dev/null
@@ -1,1532 +0,0 @@
-/*!
- * Datepicker v1.0.9
- * https://fengyuanchen.github.io/datepicker
- *
- * Copyright 2014-present Chen Fengyuan
- * Released under the MIT license
- *
- * Date: 2019-09-21T06:57:34.100Z
- */
-
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (global = global || self, factory(global.jQuery));
-}(this, function ($) { 'use strict';
-
-  $ = $ && $.hasOwnProperty('default') ? $['default'] : $;
-
-  function _classCallCheck(instance, Constructor) {
-    if (!(instance instanceof Constructor)) {
-      throw new TypeError("Cannot call a class as a function");
-    }
-  }
-
-  function _defineProperties(target, props) {
-    for (var i = 0; i < props.length; i++) {
-      var descriptor = props[i];
-      descriptor.enumerable = descriptor.enumerable || false;
-      descriptor.configurable = true;
-      if ("value" in descriptor) descriptor.writable = true;
-      Object.defineProperty(target, descriptor.key, descriptor);
-    }
-  }
-
-  function _createClass(Constructor, protoProps, staticProps) {
-    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
-    if (staticProps) _defineProperties(Constructor, staticProps);
-    return Constructor;
-  }
-
-  var DEFAULTS = {
-    // Show the datepicker automatically when initialized
-    autoShow: false,
-    // Hide the datepicker automatically when picked
-    autoHide: false,
-    // Pick the initial date automatically when initialized
-    autoPick: false,
-    // Enable inline mode
-    inline: false,
-    // A element (or selector) for putting the datepicker
-    container: null,
-    // A element (or selector) for triggering the datepicker
-    trigger: null,
-    // The ISO language code (built-in: en-US)
-    language: '',
-    // The date string format
-    format: 'mm/dd/yyyy',
-    // The initial date
-    date: null,
-    // The start view date
-    startDate: null,
-    // The end view date
-    endDate: null,
-    // The start view when initialized
-    startView: 0,
-    // 0 for days, 1 for months, 2 for years
-    // The start day of the week
-    // 0 for Sunday, 1 for Monday, 2 for Tuesday, 3 for Wednesday,
-    // 4 for Thursday, 5 for Friday, 6 for Saturday
-    weekStart: 0,
-    // Show year before month on the datepicker header
-    yearFirst: false,
-    // A string suffix to the year number.
-    yearSuffix: '',
-    // Days' name of the week.
-    days: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
-    // Shorter days' name
-    daysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
-    // Shortest days' name
-    daysMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
-    // Months' name
-    months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
-    // Shorter months' name
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
-    // A element tag for each item of years, months and days
-    itemTag: 'li',
-    // A class (CSS) for muted date item
-    mutedClass: 'muted',
-    // A class (CSS) for picked date item
-    pickedClass: 'picked',
-    // A class (CSS) for disabled date item
-    disabledClass: 'disabled',
-    // A class (CSS) for highlight date item
-    highlightedClass: 'highlighted',
-    // The template of the datepicker
-    template: '<div class="datepicker-container">' + '<div class="datepicker-panel" data-view="years picker">' + '<ul>' + '<li data-view="years prev">&lsaquo;</li>' + '<li data-view="years current"></li>' + '<li data-view="years next">&rsaquo;</li>' + '</ul>' + '<ul data-view="years"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="months picker">' + '<ul>' + '<li data-view="year prev">&lsaquo;</li>' + '<li data-view="year current"></li>' + '<li data-view="year next">&rsaquo;</li>' + '</ul>' + '<ul data-view="months"></ul>' + '</div>' + '<div class="datepicker-panel" data-view="days picker">' + '<ul>' + '<li data-view="month prev">&lsaquo;</li>' + '<li data-view="month current"></li>' + '<li data-view="month next">&rsaquo;</li>' + '</ul>' + '<ul data-view="week"></ul>' + '<ul data-view="days"></ul>' + '</div>' + '</div>',
-    // The offset top or bottom of the datepicker from the element
-    offset: 10,
-    // The `z-index` of the datepicker
-    zIndex: 1000,
-    // Filter each date item (return `false` to disable a date item)
-    filter: null,
-    // Event shortcuts
-    show: null,
-    hide: null,
-    pick: null
-  };
-
-  var IS_BROWSER = typeof window !== 'undefined';
-  var WINDOW = IS_BROWSER ? window : {};
-  var IS_TOUCH_DEVICE = IS_BROWSER ? 'ontouchstart' in WINDOW.document.documentElement : false;
-  var NAMESPACE = 'datepicker';
-  var EVENT_CLICK = "click.".concat(NAMESPACE);
-  var EVENT_FOCUS = "focus.".concat(NAMESPACE);
-  var EVENT_HIDE = "hide.".concat(NAMESPACE);
-  var EVENT_KEYUP = "keyup.".concat(NAMESPACE);
-  var EVENT_PICK = "pick.".concat(NAMESPACE);
-  var EVENT_RESIZE = "resize.".concat(NAMESPACE);
-  var EVENT_SCROLL = "scroll.".concat(NAMESPACE);
-  var EVENT_SHOW = "show.".concat(NAMESPACE);
-  var EVENT_TOUCH_START = "touchstart.".concat(NAMESPACE);
-  var CLASS_HIDE = "".concat(NAMESPACE, "-hide");
-  var LANGUAGES = {};
-  var VIEWS = {
-    DAYS: 0,
-    MONTHS: 1,
-    YEARS: 2
-  };
-
-  var toString = Object.prototype.toString;
-  function typeOf(obj) {
-    return toString.call(obj).slice(8, -1).toLowerCase();
-  }
-  function isString(value) {
-    return typeof value === 'string';
-  }
-  var isNaN = Number.isNaN || WINDOW.isNaN;
-  function isNumber(value) {
-    return typeof value === 'number' && !isNaN(value);
-  }
-  function isUndefined(value) {
-    return typeof value === 'undefined';
-  }
-  function isDate(value) {
-    return typeOf(value) === 'date' && !isNaN(value.getTime());
-  }
-  function proxy(fn, context) {
-    for (var _len = arguments.length, args = new Array(_len > 2 ? _len - 2 : 0), _key = 2; _key < _len; _key++) {
-      args[_key - 2] = arguments[_key];
-    }
-
-    return function () {
-      for (var _len2 = arguments.length, args2 = new Array(_len2), _key2 = 0; _key2 < _len2; _key2++) {
-        args2[_key2] = arguments[_key2];
-      }
-
-      return fn.apply(context, args.concat(args2));
-    };
-  }
-  function selectorOf(view) {
-    return "[data-view=\"".concat(view, "\"]");
-  }
-  function isLeapYear(year) {
-    return year % 4 === 0 && year % 100 !== 0 || year % 400 === 0;
-  }
-  function getDaysInMonth(year, month) {
-    return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
-  }
-  function getMinDay(year, month, day) {
-    return Math.min(day, getDaysInMonth(year, month));
-  }
-  var formatParts = /(y|m|d)+/g;
-  function parseFormat(format) {
-    var source = String(format).toLowerCase();
-    var parts = source.match(formatParts);
-
-    if (!parts || parts.length === 0) {
-      throw new Error('Invalid date format.');
-    }
-
-    format = {
-      source: source,
-      parts: parts
-    };
-    $.each(parts, function (i, part) {
-      switch (part) {
-        case 'dd':
-        case 'd':
-          format.hasDay = true;
-          break;
-
-        case 'mm':
-        case 'm':
-          format.hasMonth = true;
-          break;
-
-        case 'yyyy':
-        case 'yy':
-          format.hasYear = true;
-          break;
-
-        default:
-      }
-    });
-    return format;
-  }
-  function getScrollParent(element) {
-    var includeHidden = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
-    var $element = $(element);
-    var position = $element.css('position');
-    var excludeStaticParent = position === 'absolute';
-    var overflowRegex = includeHidden ? /auto|scroll|hidden/ : /auto|scroll/;
-    var scrollParent = $element.parents().filter(function (index, parent) {
-      var $parent = $(parent);
-
-      if (excludeStaticParent && $parent.css('position') === 'static') {
-        return false;
-      }
-
-      return overflowRegex.test($parent.css('overflow') + $parent.css('overflow-y') + $parent.css('overflow-x'));
-    }).eq(0);
-    return position === 'fixed' || !scrollParent.length ? $(element.ownerDocument || document) : scrollParent;
-  }
-  /**
-   * Add leading zeroes to the given value
-   * @param {number} value - The value to add.
-   * @param {number} [length=1] - The expected value length.
-   * @returns {string} Returns converted value.
-   */
-
-  function addLeadingZero(value) {
-    var length = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 1;
-    var str = String(Math.abs(value));
-    var i = str.length;
-    var result = '';
-
-    if (value < 0) {
-      result += '-';
-    }
-
-    while (i < length) {
-      i += 1;
-      result += '0';
-    }
-
-    return result + str;
-  }
-
-  var REGEXP_DIGITS = /\d+/g;
-  var methods = {
-    // Show the datepicker
-    show: function show() {
-      if (!this.built) {
-        this.build();
-      }
-
-      if (this.shown) {
-        return;
-      }
-
-      if (this.trigger(EVENT_SHOW).isDefaultPrevented()) {
-        return;
-      }
-
-      this.shown = true;
-      this.$picker.removeClass(CLASS_HIDE).on(EVENT_CLICK, $.proxy(this.click, this));
-      this.showView(this.options.startView);
-
-      if (!this.inline) {
-        this.$scrollParent.on(EVENT_SCROLL, $.proxy(this.place, this));
-        $(window).on(EVENT_RESIZE, this.onResize = proxy(this.place, this));
-        $(document).on(EVENT_CLICK, this.onGlobalClick = proxy(this.globalClick, this));
-        $(document).on(EVENT_KEYUP, this.onGlobalKeyup = proxy(this.globalKeyup, this));
-
-        if (IS_TOUCH_DEVICE) {
-          $(document).on(EVENT_TOUCH_START, this.onTouchStart = proxy(this.touchstart, this));
-        }
-
-        this.place();
-      }
-    },
-    // Hide the datepicker
-    hide: function hide() {
-      if (!this.shown) {
-        return;
-      }
-
-      if (this.trigger(EVENT_HIDE).isDefaultPrevented()) {
-        return;
-      }
-
-      this.shown = false;
-      this.$picker.addClass(CLASS_HIDE).off(EVENT_CLICK, this.click);
-
-      if (!this.inline) {
-        this.$scrollParent.off(EVENT_SCROLL, this.place);
-        $(window).off(EVENT_RESIZE, this.onResize);
-        $(document).off(EVENT_CLICK, this.onGlobalClick);
-        $(document).off(EVENT_KEYUP, this.onGlobalKeyup);
-
-        if (IS_TOUCH_DEVICE) {
-          $(document).off(EVENT_TOUCH_START, this.onTouchStart);
-        }
-      }
-    },
-    toggle: function toggle() {
-      if (this.shown) {
-        this.hide();
-      } else {
-        this.show();
-      }
-    },
-    // Update the datepicker with the current input value
-    update: function update() {
-      var value = this.getValue();
-
-      if (value === this.oldValue) {
-        return;
-      }
-
-      this.setDate(value, true);
-      this.oldValue = value;
-    },
-
-    /**
-     * Pick the current date to the element
-     *
-     * @param {String} _view (private)
-     */
-    pick: function pick(_view) {
-      var $this = this.$element;
-      var date = this.date;
-
-      if (this.trigger(EVENT_PICK, {
-        view: _view || '',
-        date: date
-      }).isDefaultPrevented()) {
-        return;
-      }
-
-      date = this.formatDate(this.date);
-      this.setValue(date);
-
-      if (this.isInput) {
-        $this.trigger('input');
-        $this.trigger('change');
-      }
-    },
-    // Reset the datepicker
-    reset: function reset() {
-      this.setDate(this.initialDate, true);
-      this.setValue(this.initialValue);
-
-      if (this.shown) {
-        this.showView(this.options.startView);
-      }
-    },
-
-    /**
-     * Get the month name with given argument or the current date
-     *
-     * @param {Number} month (optional)
-     * @param {Boolean} shortForm (optional)
-     * @return {String} (month name)
-     */
-    getMonthName: function getMonthName(month, shortForm) {
-      var options = this.options;
-      var monthsShort = options.monthsShort;
-      var months = options.months;
-
-      if ($.isNumeric(month)) {
-        month = Number(month);
-      } else if (isUndefined(shortForm)) {
-        shortForm = month;
-      }
-
-      if (shortForm === true) {
-        months = monthsShort;
-      }
-
-      return months[isNumber(month) ? month : this.date.getMonth()];
-    },
-
-    /**
-     * Get the day name with given argument or the current date
-     *
-     * @param {Number} day (optional)
-     * @param {Boolean} shortForm (optional)
-     * @param {Boolean} min (optional)
-     * @return {String} (day name)
-     */
-    getDayName: function getDayName(day, shortForm, min) {
-      var options = this.options;
-      var days = options.days;
-
-      if ($.isNumeric(day)) {
-        day = Number(day);
-      } else {
-        if (isUndefined(min)) {
-          min = shortForm;
-        }
-
-        if (isUndefined(shortForm)) {
-          shortForm = day;
-        }
-      }
-
-      if (min) {
-        days = options.daysMin;
-      } else if (shortForm) {
-        days = options.daysShort;
-      }
-
-      return days[isNumber(day) ? day : this.date.getDay()];
-    },
-
-    /**
-     * Get the current date
-     *
-     * @param {Boolean} formatted (optional)
-     * @return {Date|String} (date)
-     */
-    getDate: function getDate(formatted) {
-      var date = this.date;
-      return formatted ? this.formatDate(date) : new Date(date);
-    },
-
-    /**
-     * Set the current date with a new date
-     *
-     * @param {Date} date
-     * @param {Boolean} _updated (private)
-     */
-    setDate: function setDate(date, _updated) {
-      var filter = this.options.filter;
-
-      if (isDate(date) || isString(date)) {
-        date = this.parseDate(date);
-
-        if ($.isFunction(filter) && filter.call(this.$element, date, 'day') === false) {
-          return;
-        }
-
-        this.date = date;
-        this.viewDate = new Date(date);
-
-        if (!_updated) {
-          this.pick();
-        }
-
-        if (this.built) {
-          this.render();
-        }
-      }
-    },
-
-    /**
-     * Set the start view date with a new date
-     *
-     * @param {Date|string|null} date
-     */
-    setStartDate: function setStartDate(date) {
-      if (isDate(date) || isString(date)) {
-        this.startDate = this.parseDate(date);
-      } else {
-        this.startDate = null;
-      }
-
-      if (this.built) {
-        this.render();
-      }
-    },
-
-    /**
-     * Set the end view date with a new date
-     *
-     * @param {Date|string|null} date
-     */
-    setEndDate: function setEndDate(date) {
-      if (isDate(date) || isString(date)) {
-        this.endDate = this.parseDate(date);
-      } else {
-        this.endDate = null;
-      }
-
-      if (this.built) {
-        this.render();
-      }
-    },
-
-    /**
-     * Parse a date string with the set date format
-     *
-     * @param {String} date
-     * @return {Date} (parsed date)
-     */
-    parseDate: function parseDate(date) {
-      var format = this.format;
-      var parts = [];
-
-      if (!isDate(date)) {
-        if (isString(date)) {
-          parts = date.match(REGEXP_DIGITS) || [];
-        }
-
-        date = date ? new Date(date) : new Date();
-
-        if (!isDate(date)) {
-          date = new Date();
-        }
-
-        if (parts.length === format.parts.length) {
-          // Set year and month first
-          $.each(parts, function (i, part) {
-            var value = parseInt(part, 10);
-
-            switch (format.parts[i]) {
-              case 'yy':
-                date.setFullYear(2000 + value);
-                break;
-
-              case 'yyyy':
-                // Converts 2-digit year to 2000+
-                date.setFullYear(part.length === 2 ? 2000 + value : value);
-                break;
-
-              case 'mm':
-              case 'm':
-                date.setMonth(value - 1);
-                break;
-
-              default:
-            }
-          }); // Set day in the last to avoid converting `31/10/2019` to `01/10/2019`
-
-          $.each(parts, function (i, part) {
-            var value = parseInt(part, 10);
-
-            switch (format.parts[i]) {
-              case 'dd':
-              case 'd':
-                date.setDate(value);
-                break;
-
-              default:
-            }
-          });
-        }
-      } // Ignore hours, minutes, seconds and milliseconds to avoid side effect (#192)
-
-
-      return new Date(date.getFullYear(), date.getMonth(), date.getDate());
-    },
-
-    /**
-     * Format a date object to a string with the set date format
-     *
-     * @param {Date} date
-     * @return {String} (formatted date)
-     */
-    formatDate: function formatDate(date) {
-      var format = this.format;
-      var formatted = '';
-
-      if (isDate(date)) {
-        var year = date.getFullYear();
-        var month = date.getMonth();
-        var day = date.getDate();
-        var values = {
-          d: day,
-          dd: addLeadingZero(day, 2),
-          m: month + 1,
-          mm: addLeadingZero(month + 1, 2),
-          yy: String(year).substring(2),
-          yyyy: addLeadingZero(year, 4)
-        };
-        formatted = format.source;
-        $.each(format.parts, function (i, part) {
-          formatted = formatted.replace(part, values[part]);
-        });
-      }
-
-      return formatted;
-    },
-    // Destroy the datepicker and remove the instance from the target element
-    destroy: function destroy() {
-      this.unbind();
-      this.unbuild();
-      this.$element.removeData(NAMESPACE);
-    }
-  };
-
-  var handlers = {
-    click: function click(e) {
-      var $target = $(e.target);
-      var options = this.options,
-          date = this.date,
-          viewDate = this.viewDate,
-          format = this.format;
-      e.stopPropagation();
-      e.preventDefault();
-
-      if ($target.hasClass('disabled')) {
-        return;
-      }
-
-      var view = $target.data('view');
-      var viewYear = viewDate.getFullYear();
-      var viewMonth = viewDate.getMonth();
-      var viewDay = viewDate.getDate();
-
-      switch (view) {
-        case 'years prev':
-        case 'years next':
-          {
-            viewYear = view === 'years prev' ? viewYear - 10 : viewYear + 10;
-            viewDate.setFullYear(viewYear);
-            viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
-            this.renderYears();
-            break;
-          }
-
-        case 'year prev':
-        case 'year next':
-          viewYear = view === 'year prev' ? viewYear - 1 : viewYear + 1;
-          viewDate.setFullYear(viewYear);
-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
-          this.renderMonths();
-          break;
-
-        case 'year current':
-          if (format.hasYear) {
-            this.showView(VIEWS.YEARS);
-          }
-
-          break;
-
-        case 'year picked':
-          if (format.hasMonth) {
-            this.showView(VIEWS.MONTHS);
-          } else {
-            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
-            this.hideView();
-          }
-
-          this.pick('year');
-          break;
-
-        case 'year':
-          viewYear = parseInt($target.text(), 10); // Set date first to avoid month changing (#195)
-
-          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
-          date.setFullYear(viewYear);
-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
-          viewDate.setFullYear(viewYear);
-
-          if (format.hasMonth) {
-            this.showView(VIEWS.MONTHS);
-          } else {
-            $target.addClass(options.pickedClass).data('view', 'year picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'year');
-            this.hideView();
-          }
-
-          this.pick('year');
-          break;
-
-        case 'month prev':
-        case 'month next':
-          viewMonth = view === 'month prev' ? viewMonth - 1 : viewMonth + 1;
-
-          if (viewMonth < 0) {
-            viewYear -= 1;
-            viewMonth += 12;
-          } else if (viewMonth > 11) {
-            viewYear += 1;
-            viewMonth -= 12;
-          }
-
-          viewDate.setFullYear(viewYear);
-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
-          viewDate.setMonth(viewMonth);
-          this.renderDays();
-          break;
-
-        case 'month current':
-          if (format.hasMonth) {
-            this.showView(VIEWS.MONTHS);
-          }
-
-          break;
-
-        case 'month picked':
-          if (format.hasDay) {
-            this.showView(VIEWS.DAYS);
-          } else {
-            $target.siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
-            this.hideView();
-          }
-
-          this.pick('month');
-          break;
-
-        case 'month':
-          viewMonth = $.inArray($target.text(), options.monthsShort);
-          date.setFullYear(viewYear); // Set date before month to avoid month changing (#195)
-
-          date.setDate(getMinDay(viewYear, viewMonth, viewDay));
-          date.setMonth(viewMonth);
-          viewDate.setFullYear(viewYear);
-          viewDate.setDate(getMinDay(viewYear, viewMonth, viewDay));
-          viewDate.setMonth(viewMonth);
-
-          if (format.hasDay) {
-            this.showView(VIEWS.DAYS);
-          } else {
-            $target.addClass(options.pickedClass).data('view', 'month picked').siblings(".".concat(options.pickedClass)).removeClass(options.pickedClass).data('view', 'month');
-            this.hideView();
-          }
-
-          this.pick('month');
-          break;
-
-        case 'day prev':
-        case 'day next':
-        case 'day':
-          if (view === 'day prev') {
-            viewMonth -= 1;
-          } else if (view === 'day next') {
-            viewMonth += 1;
-          }
-
-          viewDay = parseInt($target.text(), 10); // Set date to 1 to avoid month changing (#195)
-
-          date.setDate(1);
-          date.setFullYear(viewYear);
-          date.setMonth(viewMonth);
-          date.setDate(viewDay);
-          viewDate.setDate(1);
-          viewDate.setFullYear(viewYear);
-          viewDate.setMonth(viewMonth);
-          viewDate.setDate(viewDay);
-          this.renderDays();
-
-          if (view === 'day') {
-            this.hideView();
-          }
-
-          this.pick('day');
-          break;
-
-        case 'day picked':
-          this.hideView();
-          this.pick('day');
-          break;
-
-        default:
-      }
-    },
-    globalClick: function globalClick(_ref) {
-      var target = _ref.target;
-      var element = this.element,
-          $trigger = this.$trigger;
-      var trigger = $trigger[0];
-      var hidden = true;
-
-      while (target !== document) {
-        if (target === trigger || target === element) {
-          hidden = false;
-          break;
-        }
-
-        target = target.parentNode;
-      }
-
-      if (hidden) {
-        this.hide();
-      }
-    },
-    keyup: function keyup() {
-      this.update();
-    },
-    globalKeyup: function globalKeyup(_ref2) {
-      var target = _ref2.target,
-          key = _ref2.key,
-          keyCode = _ref2.keyCode;
-
-      if (this.isInput && target !== this.element && this.shown && (key === 'Tab' || keyCode === 9)) {
-        this.hide();
-      }
-    },
-    touchstart: function touchstart(_ref3) {
-      var target = _ref3.target;
-
-      // Emulate click in touch devices to support hiding the picker automatically (#197).
-      if (this.isInput && target !== this.element && !$.contains(this.$picker[0], target)) {
-        this.hide();
-        this.element.blur();
-      }
-    }
-  };
-
-  var render = {
-    render: function render() {
-      this.renderYears();
-      this.renderMonths();
-      this.renderDays();
-    },
-    renderWeek: function renderWeek() {
-      var _this = this;
-
-      var items = [];
-      var _this$options = this.options,
-          weekStart = _this$options.weekStart,
-          daysMin = _this$options.daysMin;
-      weekStart = parseInt(weekStart, 10) % 7;
-      daysMin = daysMin.slice(weekStart).concat(daysMin.slice(0, weekStart));
-      $.each(daysMin, function (i, day) {
-        items.push(_this.createItem({
-          text: day
-        }));
-      });
-      this.$week.html(items.join(''));
-    },
-    renderYears: function renderYears() {
-      var options = this.options,
-          startDate = this.startDate,
-          endDate = this.endDate;
-      var disabledClass = options.disabledClass,
-          filter = options.filter,
-          yearSuffix = options.yearSuffix;
-      var viewYear = this.viewDate.getFullYear();
-      var now = new Date();
-      var thisYear = now.getFullYear();
-      var year = this.date.getFullYear();
-      var start = -5;
-      var end = 6;
-      var items = [];
-      var prevDisabled = false;
-      var nextDisabled = false;
-      var i;
-
-      for (i = start; i <= end; i += 1) {
-        var date = new Date(viewYear + i, 1, 1);
-        var disabled = false;
-
-        if (startDate) {
-          disabled = date.getFullYear() < startDate.getFullYear();
-
-          if (i === start) {
-            prevDisabled = disabled;
-          }
-        }
-
-        if (!disabled && endDate) {
-          disabled = date.getFullYear() > endDate.getFullYear();
-
-          if (i === end) {
-            nextDisabled = disabled;
-          }
-        }
-
-        if (!disabled && filter) {
-          disabled = filter.call(this.$element, date, 'year') === false;
-        }
-
-        var picked = viewYear + i === year;
-        var view = picked ? 'year picked' : 'year';
-        items.push(this.createItem({
-          picked: picked,
-          disabled: disabled,
-          text: viewYear + i,
-          view: disabled ? 'year disabled' : view,
-          highlighted: date.getFullYear() === thisYear
-        }));
-      }
-
-      this.$yearsPrev.toggleClass(disabledClass, prevDisabled);
-      this.$yearsNext.toggleClass(disabledClass, nextDisabled);
-      this.$yearsCurrent.toggleClass(disabledClass, true).html("".concat(viewYear + start + yearSuffix, " - ").concat(viewYear + end).concat(yearSuffix));
-      this.$years.html(items.join(''));
-    },
-    renderMonths: function renderMonths() {
-      var options = this.options,
-          startDate = this.startDate,
-          endDate = this.endDate,
-          viewDate = this.viewDate;
-      var disabledClass = options.disabledClass || '';
-      var months = options.monthsShort;
-      var filter = $.isFunction(options.filter) && options.filter;
-      var viewYear = viewDate.getFullYear();
-      var now = new Date();
-      var thisYear = now.getFullYear();
-      var thisMonth = now.getMonth();
-      var year = this.date.getFullYear();
-      var month = this.date.getMonth();
-      var items = [];
-      var prevDisabled = false;
-      var nextDisabled = false;
-      var i;
-
-      for (i = 0; i <= 11; i += 1) {
-        var date = new Date(viewYear, i, 1);
-        var disabled = false;
-
-        if (startDate) {
-          prevDisabled = date.getFullYear() === startDate.getFullYear();
-          disabled = prevDisabled && date.getMonth() < startDate.getMonth();
-        }
-
-        if (!disabled && endDate) {
-          nextDisabled = date.getFullYear() === endDate.getFullYear();
-          disabled = nextDisabled && date.getMonth() > endDate.getMonth();
-        }
-
-        if (!disabled && filter) {
-          disabled = filter.call(this.$element, date, 'month') === false;
-        }
-
-        var picked = viewYear === year && i === month;
-        var view = picked ? 'month picked' : 'month';
-        items.push(this.createItem({
-          disabled: disabled,
-          picked: picked,
-          highlighted: viewYear === thisYear && date.getMonth() === thisMonth,
-          index: i,
-          text: months[i],
-          view: disabled ? 'month disabled' : view
-        }));
-      }
-
-      this.$yearPrev.toggleClass(disabledClass, prevDisabled);
-      this.$yearNext.toggleClass(disabledClass, nextDisabled);
-      this.$yearCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(viewYear + options.yearSuffix || '');
-      this.$months.html(items.join(''));
-    },
-    renderDays: function renderDays() {
-      var $element = this.$element,
-          options = this.options,
-          startDate = this.startDate,
-          endDate = this.endDate,
-          viewDate = this.viewDate,
-          currentDate = this.date;
-      var disabledClass = options.disabledClass,
-          filter = options.filter,
-          months = options.months,
-          weekStart = options.weekStart,
-          yearSuffix = options.yearSuffix;
-      var viewYear = viewDate.getFullYear();
-      var viewMonth = viewDate.getMonth();
-      var now = new Date();
-      var thisYear = now.getFullYear();
-      var thisMonth = now.getMonth();
-      var thisDay = now.getDate();
-      var year = currentDate.getFullYear();
-      var month = currentDate.getMonth();
-      var day = currentDate.getDate();
-      var length;
-      var i;
-      var n; // Days of prev month
-      // -----------------------------------------------------------------------
-
-      var prevItems = [];
-      var prevViewYear = viewYear;
-      var prevViewMonth = viewMonth;
-      var prevDisabled = false;
-
-      if (viewMonth === 0) {
-        prevViewYear -= 1;
-        prevViewMonth = 11;
-      } else {
-        prevViewMonth -= 1;
-      } // The length of the days of prev month
-
-
-      length = getDaysInMonth(prevViewYear, prevViewMonth); // The first day of current month
-
-      var firstDay = new Date(viewYear, viewMonth, 1); // The visible length of the days of prev month
-      // [0,1,2,3,4,5,6] - [0,1,2,3,4,5,6] => [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6]
-
-      n = firstDay.getDay() - parseInt(weekStart, 10) % 7; // [-6,-5,-4,-3,-2,-1,0,1,2,3,4,5,6] => [1,2,3,4,5,6,7]
-
-      if (n <= 0) {
-        n += 7;
-      }
-
-      if (startDate) {
-        prevDisabled = firstDay.getTime() <= startDate.getTime();
-      }
-
-      for (i = length - (n - 1); i <= length; i += 1) {
-        var prevViewDate = new Date(prevViewYear, prevViewMonth, i);
-        var disabled = false;
-
-        if (startDate) {
-          disabled = prevViewDate.getTime() < startDate.getTime();
-        }
-
-        if (!disabled && filter) {
-          disabled = filter.call($element, prevViewDate, 'day') === false;
-        }
-
-        prevItems.push(this.createItem({
-          disabled: disabled,
-          highlighted: prevViewYear === thisYear && prevViewMonth === thisMonth && prevViewDate.getDate() === thisDay,
-          muted: true,
-          picked: prevViewYear === year && prevViewMonth === month && i === day,
-          text: i,
-          view: 'day prev'
-        }));
-      } // Days of next month
-      // -----------------------------------------------------------------------
-
-
-      var nextItems = [];
-      var nextViewYear = viewYear;
-      var nextViewMonth = viewMonth;
-      var nextDisabled = false;
-
-      if (viewMonth === 11) {
-        nextViewYear += 1;
-        nextViewMonth = 0;
-      } else {
-        nextViewMonth += 1;
-      } // The length of the days of current month
-
-
-      length = getDaysInMonth(viewYear, viewMonth); // The visible length of next month (42 means 6 rows and 7 columns)
-
-      n = 42 - (prevItems.length + length); // The last day of current month
-
-      var lastDate = new Date(viewYear, viewMonth, length);
-
-      if (endDate) {
-        nextDisabled = lastDate.getTime() >= endDate.getTime();
-      }
-
-      for (i = 1; i <= n; i += 1) {
-        var date = new Date(nextViewYear, nextViewMonth, i);
-        var picked = nextViewYear === year && nextViewMonth === month && i === day;
-        var _disabled = false;
-
-        if (endDate) {
-          _disabled = date.getTime() > endDate.getTime();
-        }
-
-        if (!_disabled && filter) {
-          _disabled = filter.call($element, date, 'day') === false;
-        }
-
-        nextItems.push(this.createItem({
-          disabled: _disabled,
-          picked: picked,
-          highlighted: nextViewYear === thisYear && nextViewMonth === thisMonth && date.getDate() === thisDay,
-          muted: true,
-          text: i,
-          view: 'day next'
-        }));
-      } // Days of current month
-      // -----------------------------------------------------------------------
-
-
-      var items = [];
-
-      for (i = 1; i <= length; i += 1) {
-        var _date = new Date(viewYear, viewMonth, i);
-
-        var _disabled2 = false;
-
-        if (startDate) {
-          _disabled2 = _date.getTime() < startDate.getTime();
-        }
-
-        if (!_disabled2 && endDate) {
-          _disabled2 = _date.getTime() > endDate.getTime();
-        }
-
-        if (!_disabled2 && filter) {
-          _disabled2 = filter.call($element, _date, 'day') === false;
-        }
-
-        var _picked = viewYear === year && viewMonth === month && i === day;
-
-        var view = _picked ? 'day picked' : 'day';
-        items.push(this.createItem({
-          disabled: _disabled2,
-          picked: _picked,
-          highlighted: viewYear === thisYear && viewMonth === thisMonth && _date.getDate() === thisDay,
-          text: i,
-          view: _disabled2 ? 'day disabled' : view
-        }));
-      } // Render days picker
-      // -----------------------------------------------------------------------
-
-
-      this.$monthPrev.toggleClass(disabledClass, prevDisabled);
-      this.$monthNext.toggleClass(disabledClass, nextDisabled);
-      this.$monthCurrent.toggleClass(disabledClass, prevDisabled && nextDisabled).html(options.yearFirst ? "".concat(viewYear + yearSuffix, " ").concat(months[viewMonth]) : "".concat(months[viewMonth], " ").concat(viewYear).concat(yearSuffix));
-      this.$days.html(prevItems.join('') + items.join('') + nextItems.join(''));
-    }
-  };
-
-  var CLASS_TOP_LEFT = "".concat(NAMESPACE, "-top-left");
-  var CLASS_TOP_RIGHT = "".concat(NAMESPACE, "-top-right");
-  var CLASS_BOTTOM_LEFT = "".concat(NAMESPACE, "-bottom-left");
-  var CLASS_BOTTOM_RIGHT = "".concat(NAMESPACE, "-bottom-right");
-  var CLASS_PLACEMENTS = [CLASS_TOP_LEFT, CLASS_TOP_RIGHT, CLASS_BOTTOM_LEFT, CLASS_BOTTOM_RIGHT].join(' ');
-
-  var Datepicker =
-  /*#__PURE__*/
-  function () {
-    function Datepicker(element) {
-      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
-
-      _classCallCheck(this, Datepicker);
-
-      this.$element = $(element);
-      this.element = element;
-      this.options = $.extend({}, DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
-      this.$scrollParent = getScrollParent(element, true);
-      this.built = false;
-      this.shown = false;
-      this.isInput = false;
-      this.inline = false;
-      this.initialValue = '';
-      this.initialDate = null;
-      this.startDate = null;
-      this.endDate = null;
-      this.init();
-    }
-
-    _createClass(Datepicker, [{
-      key: "init",
-      value: function init() {
-        var $this = this.$element,
-            options = this.options;
-        var startDate = options.startDate,
-            endDate = options.endDate,
-            date = options.date;
-        this.$trigger = $(options.trigger);
-        this.isInput = $this.is('input') || $this.is('textarea');
-        this.inline = options.inline && (options.container || !this.isInput);
-        this.format = parseFormat(options.format);
-        var initialValue = this.getValue();
-        this.initialValue = initialValue;
-        this.oldValue = initialValue;
-        date = this.parseDate(date || initialValue);
-
-        if (startDate) {
-          startDate = this.parseDate(startDate);
-
-          if (date.getTime() < startDate.getTime()) {
-            date = new Date(startDate);
-          }
-
-          this.startDate = startDate;
-        }
-
-        if (endDate) {
-          endDate = this.parseDate(endDate);
-
-          if (startDate && endDate.getTime() < startDate.getTime()) {
-            endDate = new Date(startDate);
-          }
-
-          if (date.getTime() > endDate.getTime()) {
-            date = new Date(endDate);
-          }
-
-          this.endDate = endDate;
-        }
-
-        this.date = date;
-        this.viewDate = new Date(date);
-        this.initialDate = new Date(this.date);
-        this.bind();
-
-        if (options.autoShow || this.inline) {
-          this.show();
-        }
-
-        if (options.autoPick) {
-          this.pick();
-        }
-      }
-    }, {
-      key: "build",
-      value: function build() {
-        if (this.built) {
-          return;
-        }
-
-        this.built = true;
-        var $this = this.$element,
-            options = this.options;
-        var $picker = $(options.template);
-        this.$picker = $picker;
-        this.$week = $picker.find(selectorOf('week')); // Years view
-
-        this.$yearsPicker = $picker.find(selectorOf('years picker'));
-        this.$yearsPrev = $picker.find(selectorOf('years prev'));
-        this.$yearsNext = $picker.find(selectorOf('years next'));
-        this.$yearsCurrent = $picker.find(selectorOf('years current'));
-        this.$years = $picker.find(selectorOf('years')); // Months view
-
-        this.$monthsPicker = $picker.find(selectorOf('months picker'));
-        this.$yearPrev = $picker.find(selectorOf('year prev'));
-        this.$yearNext = $picker.find(selectorOf('year next'));
-        this.$yearCurrent = $picker.find(selectorOf('year current'));
-        this.$months = $picker.find(selectorOf('months')); // Days view
-
-        this.$daysPicker = $picker.find(selectorOf('days picker'));
-        this.$monthPrev = $picker.find(selectorOf('month prev'));
-        this.$monthNext = $picker.find(selectorOf('month next'));
-        this.$monthCurrent = $picker.find(selectorOf('month current'));
-        this.$days = $picker.find(selectorOf('days'));
-
-        if (this.inline) {
-          $(options.container || $this).append($picker.addClass("".concat(NAMESPACE, "-inline")));
-        } else {
-          $(document.body).append($picker.addClass("".concat(NAMESPACE, "-dropdown")));
-          $picker.addClass(CLASS_HIDE).css({
-            zIndex: parseInt(options.zIndex, 10)
-          });
-        }
-
-        this.renderWeek();
-      }
-    }, {
-      key: "unbuild",
-      value: function unbuild() {
-        if (!this.built) {
-          return;
-        }
-
-        this.built = false;
-        this.$picker.remove();
-      }
-    }, {
-      key: "bind",
-      value: function bind() {
-        var options = this.options,
-            $this = this.$element;
-
-        if ($.isFunction(options.show)) {
-          $this.on(EVENT_SHOW, options.show);
-        }
-
-        if ($.isFunction(options.hide)) {
-          $this.on(EVENT_HIDE, options.hide);
-        }
-
-        if ($.isFunction(options.pick)) {
-          $this.on(EVENT_PICK, options.pick);
-        }
-
-        if (this.isInput) {
-          $this.on(EVENT_KEYUP, $.proxy(this.keyup, this));
-        }
-
-        if (!this.inline) {
-          if (options.trigger) {
-            this.$trigger.on(EVENT_CLICK, $.proxy(this.toggle, this));
-          } else if (this.isInput) {
-            $this.on(EVENT_FOCUS, $.proxy(this.show, this));
-          } else {
-            $this.on(EVENT_CLICK, $.proxy(this.show, this));
-          }
-        }
-      }
-    }, {
-      key: "unbind",
-      value: function unbind() {
-        var $this = this.$element,
-            options = this.options;
-
-        if ($.isFunction(options.show)) {
-          $this.off(EVENT_SHOW, options.show);
-        }
-
-        if ($.isFunction(options.hide)) {
-          $this.off(EVENT_HIDE, options.hide);
-        }
-
-        if ($.isFunction(options.pick)) {
-          $this.off(EVENT_PICK, options.pick);
-        }
-
-        if (this.isInput) {
-          $this.off(EVENT_KEYUP, this.keyup);
-        }
-
-        if (!this.inline) {
-          if (options.trigger) {
-            this.$trigger.off(EVENT_CLICK, this.toggle);
-          } else if (this.isInput) {
-            $this.off(EVENT_FOCUS, this.show);
-          } else {
-            $this.off(EVENT_CLICK, this.show);
-          }
-        }
-      }
-    }, {
-      key: "showView",
-      value: function showView(view) {
-        var $yearsPicker = this.$yearsPicker,
-            $monthsPicker = this.$monthsPicker,
-            $daysPicker = this.$daysPicker,
-            format = this.format;
-
-        if (format.hasYear || format.hasMonth || format.hasDay) {
-          switch (Number(view)) {
-            case VIEWS.YEARS:
-              $monthsPicker.addClass(CLASS_HIDE);
-              $daysPicker.addClass(CLASS_HIDE);
-
-              if (format.hasYear) {
-                this.renderYears();
-                $yearsPicker.removeClass(CLASS_HIDE);
-                this.place();
-              } else {
-                this.showView(VIEWS.DAYS);
-              }
-
-              break;
-
-            case VIEWS.MONTHS:
-              $yearsPicker.addClass(CLASS_HIDE);
-              $daysPicker.addClass(CLASS_HIDE);
-
-              if (format.hasMonth) {
-                this.renderMonths();
-                $monthsPicker.removeClass(CLASS_HIDE);
-                this.place();
-              } else {
-                this.showView(VIEWS.YEARS);
-              }
-
-              break;
-            // case VIEWS.DAYS:
-
-            default:
-              $yearsPicker.addClass(CLASS_HIDE);
-              $monthsPicker.addClass(CLASS_HIDE);
-
-              if (format.hasDay) {
-                this.renderDays();
-                $daysPicker.removeClass(CLASS_HIDE);
-                this.place();
-              } else {
-                this.showView(VIEWS.MONTHS);
-              }
-
-          }
-        }
-      }
-    }, {
-      key: "hideView",
-      value: function hideView() {
-        if (!this.inline && this.options.autoHide) {
-          this.hide();
-        }
-      }
-    }, {
-      key: "place",
-      value: function place() {
-        if (this.inline) {
-          return;
-        }
-
-        var $this = this.$element,
-            options = this.options,
-            $picker = this.$picker;
-        var containerWidth = $(document).outerWidth();
-        var containerHeight = $(document).outerHeight();
-        var elementWidth = $this.outerWidth();
-        var elementHeight = $this.outerHeight();
-        var width = $picker.width();
-        var height = $picker.height();
-
-        var _$this$offset = $this.offset(),
-            left = _$this$offset.left,
-            top = _$this$offset.top;
-
-        var offset = parseFloat(options.offset);
-        var placement = CLASS_TOP_LEFT;
-
-        if (isNaN(offset)) {
-          offset = 10;
-        }
-
-        if (top > height && top + elementHeight + height > containerHeight) {
-          top -= height + offset;
-          placement = CLASS_BOTTOM_LEFT;
-        } else {
-          top += elementHeight + offset;
-        }
-
-        if (left + width > containerWidth) {
-          left += elementWidth - width;
-          placement = placement.replace('left', 'right');
-        }
-
-        $picker.removeClass(CLASS_PLACEMENTS).addClass(placement).css({
-          top: top,
-          left: left
-        });
-      } // A shortcut for triggering custom events
-
-    }, {
-      key: "trigger",
-      value: function trigger(type, data) {
-        var e = $.Event(type, data);
-        this.$element.trigger(e);
-        return e;
-      }
-    }, {
-      key: "createItem",
-      value: function createItem(data) {
-        var options = this.options;
-        var itemTag = options.itemTag;
-        var item = {
-          text: '',
-          view: '',
-          muted: false,
-          picked: false,
-          disabled: false,
-          highlighted: false
-        };
-        var classes = [];
-        $.extend(item, data);
-
-        if (item.muted) {
-          classes.push(options.mutedClass);
-        }
-
-        if (item.highlighted) {
-          classes.push(options.highlightedClass);
-        }
-
-        if (item.picked) {
-          classes.push(options.pickedClass);
-        }
-
-        if (item.disabled) {
-          classes.push(options.disabledClass);
-        }
-
-        return "<".concat(itemTag, " class=\"").concat(classes.join(' '), "\" data-view=\"").concat(item.view, "\">").concat(item.text, "</").concat(itemTag, ">");
-      }
-    }, {
-      key: "getValue",
-      value: function getValue() {
-        var $this = this.$element;
-        return this.isInput ? $this.val() : $this.text();
-      }
-    }, {
-      key: "setValue",
-      value: function setValue() {
-        var value = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
-        var $this = this.$element;
-
-        if (this.isInput) {
-          $this.val(value);
-        } else if (!this.inline || this.options.container) {
-          $this.text(value);
-        }
-      }
-    }], [{
-      key: "setDefaults",
-      value: function setDefaults() {
-        var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
-        $.extend(DEFAULTS, LANGUAGES[options.language], $.isPlainObject(options) && options);
-      }
-    }]);
-
-    return Datepicker;
-  }();
-
-  if ($.extend) {
-    $.extend(Datepicker.prototype, render, handlers, methods);
-  }
-
-  if ($.fn) {
-    var AnotherDatepicker = $.fn.datepicker;
-
-    $.fn.datepicker = function jQueryDatepicker(option) {
-      for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
-        args[_key - 1] = arguments[_key];
-      }
-
-      var result;
-      this.each(function (i, element) {
-        var $element = $(element);
-        var isDestroy = option === 'destroy';
-        var datepicker = $element.data(NAMESPACE);
-
-        if (!datepicker) {
-          if (isDestroy) {
-            return;
-          }
-
-          var options = $.extend({}, $element.data(), $.isPlainObject(option) && option);
-          datepicker = new Datepicker(element, options);
-          $element.data(NAMESPACE, datepicker);
-        }
-
-        if (isString(option)) {
-          var fn = datepicker[option];
-
-          if ($.isFunction(fn)) {
-            result = fn.apply(datepicker, args);
-
-            if (isDestroy) {
-              $element.removeData(NAMESPACE);
-            }
-          }
-        }
-      });
-      return !isUndefined(result) ? result : this;
-    };
-
-    $.fn.datepicker.Constructor = Datepicker;
-    $.fn.datepicker.languages = LANGUAGES;
-    $.fn.datepicker.setDefaults = Datepicker.setDefaults;
-
-    $.fn.datepicker.noConflict = function noConflict() {
-      $.fn.datepicker = AnotherDatepicker;
-      return this;
-    };
-  }
-
-}));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.css"
+++ /dev/null
@@ -1,9 +0,0 @@
-/*!
- * Datepicker v1.0.9
- * https://fengyuanchen.github.io/datepicker
- *
- * Copyright 2014-present Chen Fengyuan
- * Released under the MIT license
- *
- * Date: 2019-09-21T06:57:30.334Z
- */.datepicker-container{background-color:#fff;direction:ltr;font-size:12px;left:0;line-height:30px;position:fixed;-webkit-tap-highlight-color:transparent;top:0;-ms-touch-action:none;touch-action:none;-webkit-touch-callout:none;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;width:210px;z-index:-1}.datepicker-container:after,.datepicker-container:before{border:5px solid transparent;content:" ";display:block;height:0;position:absolute;width:0}.datepicker-dropdown{border:1px solid #ccc;-webkit-box-shadow:0 3px 6px #ccc;box-shadow:0 3px 6px #ccc;-webkit-box-sizing:content-box;box-sizing:content-box;position:absolute;z-index:1}.datepicker-inline{position:static}.datepicker-top-left,.datepicker-top-right{border-top-color:#39f}.datepicker-top-left:after,.datepicker-top-left:before,.datepicker-top-right:after,.datepicker-top-right:before{border-top:0;left:10px;top:-5px}.datepicker-top-left:before,.datepicker-top-right:before{border-bottom-color:#39f}.datepicker-top-left:after,.datepicker-top-right:after{border-bottom-color:#fff;top:-4px}.datepicker-bottom-left,.datepicker-bottom-right{border-bottom-color:#39f}.datepicker-bottom-left:after,.datepicker-bottom-left:before,.datepicker-bottom-right:after,.datepicker-bottom-right:before{border-bottom:0;bottom:-5px;left:10px}.datepicker-bottom-left:before,.datepicker-bottom-right:before{border-top-color:#39f}.datepicker-bottom-left:after,.datepicker-bottom-right:after{border-top-color:#fff;bottom:-4px}.datepicker-bottom-right:after,.datepicker-bottom-right:before,.datepicker-top-right:after,.datepicker-top-right:before{left:auto;right:10px}.datepicker-panel>ul{margin:0;padding:0;width:102%}.datepicker-panel>ul:after,.datepicker-panel>ul:before{content:" ";display:table}.datepicker-panel>ul:after{clear:both}.datepicker-panel>ul>li{background-color:#fff;cursor:pointer;float:left;height:30px;list-style:none;margin:0;padding:0;text-align:center;width:30px}.datepicker-panel>ul>li:hover{background-color:#e5f2ff}.datepicker-panel>ul>li.muted,.datepicker-panel>ul>li.muted:hover{color:#999}.datepicker-panel>ul>li.highlighted{background-color:#e5f2ff}.datepicker-panel>ul>li.highlighted:hover{background-color:#cce5ff}.datepicker-panel>ul>li.picked,.datepicker-panel>ul>li.picked:hover{color:#39f}.datepicker-panel>ul>li.disabled,.datepicker-panel>ul>li.disabled:hover{background-color:#fff;color:#ccc;cursor:default}.datepicker-panel>ul>li.disabled.highlighted,.datepicker-panel>ul>li.disabled:hover.highlighted{background-color:#e5f2ff}.datepicker-panel>ul>li[data-view="month next"],.datepicker-panel>ul>li[data-view="month prev"],.datepicker-panel>ul>li[data-view="year next"],.datepicker-panel>ul>li[data-view="year prev"],.datepicker-panel>ul>li[data-view="years next"],.datepicker-panel>ul>li[data-view="years prev"],.datepicker-panel>ul>li[data-view=next]{font-size:18px}.datepicker-panel>ul>li[data-view="month current"],.datepicker-panel>ul>li[data-view="year current"],.datepicker-panel>ul>li[data-view="years current"]{width:150px}.datepicker-panel>ul[data-view=months]>li,.datepicker-panel>ul[data-view=years]>li{height:52.5px;line-height:52.5px;width:52.5px}.datepicker-panel>ul[data-view=week]>li,.datepicker-panel>ul[data-view=week]>li:hover{background-color:#fff;cursor:default}.datepicker-hide{display:none}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/datepicker.min.js"
+++ /dev/null
@@ -1,10 +0,0 @@
-/*!
- * Datepicker v1.0.9
- * https://fengyuanchen.github.io/datepicker
- *
- * Copyright 2014-present Chen Fengyuan
- * Released under the MIT license
- *
- * Date: 2019-09-21T06:57:34.100Z
- */
-!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?e(require("jquery")):"function"==typeof define&&define.amd?define(["jquery"],e):e((t=t||self).jQuery)}(this,function(D){"use strict";function a(t,e){for(var i=0;i<e.length;i++){var a=e[i];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}D=D&&D.hasOwnProperty("default")?D.default:D;var s={autoShow:!1,autoHide:!1,autoPick:!1,inline:!1,container:null,trigger:null,language:"",format:"mm/dd/yyyy",date:null,startDate:null,endDate:null,startView:0,weekStart:0,yearFirst:!1,yearSuffix:"",days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],daysShort:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],daysMin:["Su","Mo","Tu","We","Th","Fr","Sa"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],monthsShort:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],itemTag:"li",mutedClass:"muted",pickedClass:"picked",disabledClass:"disabled",highlightedClass:"highlighted",template:'<div class="datepicker-container"><div class="datepicker-panel" data-view="years picker"><ul><li data-view="years prev">&lsaquo;</li><li data-view="years current"></li><li data-view="years next">&rsaquo;</li></ul><ul data-view="years"></ul></div><div class="datepicker-panel" data-view="months picker"><ul><li data-view="year prev">&lsaquo;</li><li data-view="year current"></li><li data-view="year next">&rsaquo;</li></ul><ul data-view="months"></ul></div><div class="datepicker-panel" data-view="days picker"><ul><li data-view="month prev">&lsaquo;</li><li data-view="month current"></li><li data-view="month next">&rsaquo;</li></ul><ul data-view="week"></ul><ul data-view="days"></ul></div></div>',offset:10,zIndex:1e3,filter:null,show:null,hide:null,pick:null},t="undefined"!=typeof window,e=t?window:{},i=t&&"ontouchstart"in e.document.documentElement,c="datepicker",n="click.".concat(c),r="focus.".concat(c),h="hide.".concat(c),o="keyup.".concat(c),l="pick.".concat(c),d="resize.".concat(c),u="scroll.".concat(c),p="show.".concat(c),f="touchstart.".concat(c),g="".concat(c,"-hide"),y={},m=0,v=1,w=2,k=Object.prototype.toString;function b(t){return"string"==typeof t}var C=Number.isNaN||e.isNaN;function $(t){return"number"==typeof t&&!C(t)}function x(t){return void 0===t}function F(t){return"date"===function(t){return k.call(t).slice(8,-1).toLowerCase()}(t)&&!C(t.getTime())}function M(a,s){for(var t=arguments.length,n=new Array(2<t?t-2:0),e=2;e<t;e++)n[e-2]=arguments[e];return function(){for(var t=arguments.length,e=new Array(t),i=0;i<t;i++)e[i]=arguments[i];return a.apply(s,n.concat(e))}}function Y(t){return'[data-view="'.concat(t,'"]')}function G(t,e){return[31,function(t){return t%4==0&&t%100!=0||t%400==0}(t)?29:28,31,30,31,30,31,31,30,31,30,31][e]}function V(t,e,i){return Math.min(i,G(t,e))}var T=/(y|m|d)+/g;function I(t,e){var i=1<arguments.length&&void 0!==e?e:1,a=String(Math.abs(t)),s=a.length,n="";for(t<0&&(n+="-");s<i;)s+=1,n+="0";return n+a}var S=/\d+/g,P={show:function(){this.built||this.build(),this.shown||this.trigger(p).isDefaultPrevented()||(this.shown=!0,this.$picker.removeClass(g).on(n,D.proxy(this.click,this)),this.showView(this.options.startView),this.inline||(this.$scrollParent.on(u,D.proxy(this.place,this)),D(window).on(d,this.onResize=M(this.place,this)),D(document).on(n,this.onGlobalClick=M(this.globalClick,this)),D(document).on(o,this.onGlobalKeyup=M(this.globalKeyup,this)),i&&D(document).on(f,this.onTouchStart=M(this.touchstart,this)),this.place()))},hide:function(){this.shown&&(this.trigger(h).isDefaultPrevented()||(this.shown=!1,this.$picker.addClass(g).off(n,this.click),this.inline||(this.$scrollParent.off(u,this.place),D(window).off(d,this.onResize),D(document).off(n,this.onGlobalClick),D(document).off(o,this.onGlobalKeyup),i&&D(document).off(f,this.onTouchStart))))},toggle:function(){this.shown?this.hide():this.show()},update:function(){var t=this.getValue();t!==this.oldValue&&(this.setDate(t,!0),this.oldValue=t)},pick:function(t){var e=this.$element,i=this.date;this.trigger(l,{view:t||"",date:i}).isDefaultPrevented()||(i=this.formatDate(this.date),this.setValue(i),this.isInput&&(e.trigger("input"),e.trigger("change")))},reset:function(){this.setDate(this.initialDate,!0),this.setValue(this.initialValue),this.shown&&this.showView(this.options.startView)},getMonthName:function(t,e){var i=this.options,a=i.monthsShort,s=i.months;return D.isNumeric(t)?t=Number(t):x(e)&&(e=t),!0===e&&(s=a),s[$(t)?t:this.date.getMonth()]},getDayName:function(t,e,i){var a=this.options,s=a.days;return D.isNumeric(t)?t=Number(t):(x(i)&&(i=e),x(e)&&(e=t)),i?s=a.daysMin:e&&(s=a.daysShort),s[$(t)?t:this.date.getDay()]},getDate:function(t){var e=this.date;return t?this.formatDate(e):new Date(e)},setDate:function(t,e){var i=this.options.filter;if(F(t)||b(t)){if(t=this.parseDate(t),D.isFunction(i)&&!1===i.call(this.$element,t,"day"))return;this.date=t,this.viewDate=new Date(t),e||this.pick(),this.built&&this.render()}},setStartDate:function(t){F(t)||b(t)?this.startDate=this.parseDate(t):this.startDate=null,this.built&&this.render()},setEndDate:function(t){F(t)||b(t)?this.endDate=this.parseDate(t):this.endDate=null,this.built&&this.render()},parseDate:function(a){var s=this.format,t=[];return F(a)||(b(a)&&(t=a.match(S)||[]),F(a=a?new Date(a):new Date)||(a=new Date),t.length===s.parts.length&&(D.each(t,function(t,e){var i=parseInt(e,10);switch(s.parts[t]){case"yy":a.setFullYear(2e3+i);break;case"yyyy":a.setFullYear(2===e.length?2e3+i:i);break;case"mm":case"m":a.setMonth(i-1)}}),D.each(t,function(t,e){var i=parseInt(e,10);switch(s.parts[t]){case"dd":case"d":a.setDate(i)}}))),new Date(a.getFullYear(),a.getMonth(),a.getDate())},formatDate:function(t){var e=this.format,i="";if(F(t)){var a=t.getFullYear(),s=t.getMonth(),n=t.getDate(),r={d:n,dd:I(n,2),m:s+1,mm:I(s+1,2),yy:String(a).substring(2),yyyy:I(a,4)};i=e.source,D.each(e.parts,function(t,e){i=i.replace(e,r[e])})}return i},destroy:function(){this.unbind(),this.unbuild(),this.$element.removeData(c)}},N={click:function(t){var e=D(t.target),i=this.options,a=this.date,s=this.viewDate,n=this.format;if(t.stopPropagation(),t.preventDefault(),!e.hasClass("disabled")){var r=e.data("view"),h=s.getFullYear(),o=s.getMonth(),l=s.getDate();switch(r){case"years prev":case"years next":h="years prev"===r?h-10:h+10,s.setFullYear(h),s.setDate(V(h,o,l)),this.renderYears();break;case"year prev":case"year next":h="year prev"===r?h-1:h+1,s.setFullYear(h),s.setDate(V(h,o,l)),this.renderMonths();break;case"year current":n.hasYear&&this.showView(w);break;case"year picked":n.hasMonth?this.showView(v):(e.siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","year"),this.hideView()),this.pick("year");break;case"year":h=parseInt(e.text(),10),a.setDate(V(h,o,l)),a.setFullYear(h),s.setDate(V(h,o,l)),s.setFullYear(h),n.hasMonth?this.showView(v):(e.addClass(i.pickedClass).data("view","year picked").siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","year"),this.hideView()),this.pick("year");break;case"month prev":case"month next":(o="month prev"===r?o-1:o+1)<0?(h-=1,o+=12):11<o&&(h+=1,o-=12),s.setFullYear(h),s.setDate(V(h,o,l)),s.setMonth(o),this.renderDays();break;case"month current":n.hasMonth&&this.showView(v);break;case"month picked":n.hasDay?this.showView(m):(e.siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","month"),this.hideView()),this.pick("month");break;case"month":o=D.inArray(e.text(),i.monthsShort),a.setFullYear(h),a.setDate(V(h,o,l)),a.setMonth(o),s.setFullYear(h),s.setDate(V(h,o,l)),s.setMonth(o),n.hasDay?this.showView(m):(e.addClass(i.pickedClass).data("view","month picked").siblings(".".concat(i.pickedClass)).removeClass(i.pickedClass).data("view","month"),this.hideView()),this.pick("month");break;case"day prev":case"day next":case"day":"day prev"===r?o-=1:"day next"===r&&(o+=1),l=parseInt(e.text(),10),a.setDate(1),a.setFullYear(h),a.setMonth(o),a.setDate(l),s.setDate(1),s.setFullYear(h),s.setMonth(o),s.setDate(l),this.renderDays(),"day"===r&&this.hideView(),this.pick("day");break;case"day picked":this.hideView(),this.pick("day")}}},globalClick:function(t){for(var e=t.target,i=this.element,a=this.$trigger[0],s=!0;e!==document;){if(e===a||e===i){s=!1;break}e=e.parentNode}s&&this.hide()},keyup:function(){this.update()},globalKeyup:function(t){var e=t.target,i=t.key,a=t.keyCode;this.isInput&&e!==this.element&&this.shown&&("Tab"===i||9===a)&&this.hide()},touchstart:function(t){var e=t.target;this.isInput&&e!==this.element&&!D.contains(this.$picker[0],e)&&(this.hide(),this.element.blur())}},j={render:function(){this.renderYears(),this.renderMonths(),this.renderDays()},renderWeek:function(){var i=this,a=[],t=this.options,e=t.weekStart,s=t.daysMin;e=parseInt(e,10)%7,s=s.slice(e).concat(s.slice(0,e)),D.each(s,function(t,e){a.push(i.createItem({text:e}))}),this.$week.html(a.join(""))},renderYears:function(){var t,e=this.options,i=this.startDate,a=this.endDate,s=e.disabledClass,n=e.filter,r=e.yearSuffix,h=this.viewDate.getFullYear(),o=(new Date).getFullYear(),l=this.date.getFullYear(),c=[],d=!1,u=!1;for(t=-5;t<=6;t+=1){var p=new Date(h+t,1,1),f=!1;i&&(f=p.getFullYear()<i.getFullYear(),-5===t&&(d=f)),!f&&a&&(f=p.getFullYear()>a.getFullYear(),6===t&&(u=f)),!f&&n&&(f=!1===n.call(this.$element,p,"year"));var g=h+t===l,y=g?"year picked":"year";c.push(this.createItem({picked:g,disabled:f,text:h+t,view:f?"year disabled":y,highlighted:p.getFullYear()===o}))}this.$yearsPrev.toggleClass(s,d),this.$yearsNext.toggleClass(s,u),this.$yearsCurrent.toggleClass(s,!0).html("".concat(h+-5+r," - ").concat(h+6).concat(r)),this.$years.html(c.join(""))},renderMonths:function(){var t,e=this.options,i=this.startDate,a=this.endDate,s=this.viewDate,n=e.disabledClass||"",r=e.monthsShort,h=D.isFunction(e.filter)&&e.filter,o=s.getFullYear(),l=new Date,c=l.getFullYear(),d=l.getMonth(),u=this.date.getFullYear(),p=this.date.getMonth(),f=[],g=!1,y=!1;for(t=0;t<=11;t+=1){var m=new Date(o,t,1),v=!1;i&&(v=(g=m.getFullYear()===i.getFullYear())&&m.getMonth()<i.getMonth()),!v&&a&&(v=(y=m.getFullYear()===a.getFullYear())&&m.getMonth()>a.getMonth()),!v&&h&&(v=!1===h.call(this.$element,m,"month"));var w=o===u&&t===p,k=w?"month picked":"month";f.push(this.createItem({disabled:v,picked:w,highlighted:o===c&&m.getMonth()===d,index:t,text:r[t],view:v?"month disabled":k}))}this.$yearPrev.toggleClass(n,g),this.$yearNext.toggleClass(n,y),this.$yearCurrent.toggleClass(n,g&&y).html(o+e.yearSuffix||""),this.$months.html(f.join(""))},renderDays:function(){var t,e,i,a=this.$element,s=this.options,n=this.startDate,r=this.endDate,h=this.viewDate,o=this.date,l=s.disabledClass,c=s.filter,d=s.months,u=s.weekStart,p=s.yearSuffix,f=h.getFullYear(),g=h.getMonth(),y=new Date,m=y.getFullYear(),v=y.getMonth(),w=y.getDate(),k=o.getFullYear(),D=o.getMonth(),b=o.getDate(),C=[],$=f,x=g,F=!1;0===g?($-=1,x=11):x-=1,t=G($,x);var M=new Date(f,g,1);for((i=M.getDay()-parseInt(u,10)%7)<=0&&(i+=7),n&&(F=M.getTime()<=n.getTime()),e=t-(i-1);e<=t;e+=1){var Y=new Date($,x,e),V=!1;n&&(V=Y.getTime()<n.getTime()),!V&&c&&(V=!1===c.call(a,Y,"day")),C.push(this.createItem({disabled:V,highlighted:$===m&&x===v&&Y.getDate()===w,muted:!0,picked:$===k&&x===D&&e===b,text:e,view:"day prev"}))}var T=[],I=f,S=g,P=!1;11===g?(I+=1,S=0):S+=1,t=G(f,g),i=42-(C.length+t);var N=new Date(f,g,t);for(r&&(P=N.getTime()>=r.getTime()),e=1;e<=i;e+=1){var j=new Date(I,S,e),q=I===k&&S===D&&e===b,A=!1;r&&(A=j.getTime()>r.getTime()),!A&&c&&(A=!1===c.call(a,j,"day")),T.push(this.createItem({disabled:A,picked:q,highlighted:I===m&&S===v&&j.getDate()===w,muted:!0,text:e,view:"day next"}))}var O=[];for(e=1;e<=t;e+=1){var W=new Date(f,g,e),z=!1;n&&(z=W.getTime()<n.getTime()),!z&&r&&(z=W.getTime()>r.getTime()),!z&&c&&(z=!1===c.call(a,W,"day"));var J=f===k&&g===D&&e===b,E=J?"day picked":"day";O.push(this.createItem({disabled:z,picked:J,highlighted:f===m&&g===v&&W.getDate()===w,text:e,view:z?"day disabled":E}))}this.$monthPrev.toggleClass(l,F),this.$monthNext.toggleClass(l,P),this.$monthCurrent.toggleClass(l,F&&P).html(s.yearFirst?"".concat(f+p," ").concat(d[g]):"".concat(d[g]," ").concat(f).concat(p)),this.$days.html(C.join("")+O.join("")+T.join(""))}},q="".concat(c,"-top-left"),A="".concat(c,"-top-right"),O="".concat(c,"-bottom-left"),W="".concat(c,"-bottom-right"),z=[q,A,O,W].join(" "),J=function(){function i(t){var e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:{};!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,i),this.$element=D(t),this.element=t,this.options=D.extend({},s,y[e.language],D.isPlainObject(e)&&e),this.$scrollParent=function(t,e){var i=1<arguments.length&&void 0!==e&&e,a=D(t),s=a.css("position"),n="absolute"===s,r=i?/auto|scroll|hidden/:/auto|scroll/,h=a.parents().filter(function(t,e){var i=D(e);return(!n||"static"!==i.css("position"))&&r.test(i.css("overflow")+i.css("overflow-y")+i.css("overflow-x"))}).eq(0);return"fixed"!==s&&h.length?h:D(t.ownerDocument||document)}(t,!0),this.built=!1,this.shown=!1,this.isInput=!1,this.inline=!1,this.initialValue="",this.initialDate=null,this.startDate=null,this.endDate=null,this.init()}return function(t,e,i){e&&a(t.prototype,e),i&&a(t,i)}(i,[{key:"init",value:function(){var t=this.$element,e=this.options,i=e.startDate,a=e.endDate,s=e.date;this.$trigger=D(e.trigger),this.isInput=t.is("input")||t.is("textarea"),this.inline=e.inline&&(e.container||!this.isInput),this.format=function(i){var t=String(i).toLowerCase(),e=t.match(T);if(!e||0===e.length)throw new Error("Invalid date format.");return i={source:t,parts:e},D.each(e,function(t,e){switch(e){case"dd":case"d":i.hasDay=!0;break;case"mm":case"m":i.hasMonth=!0;break;case"yyyy":case"yy":i.hasYear=!0}}),i}(e.format);var n=this.getValue();this.initialValue=n,this.oldValue=n,s=this.parseDate(s||n),i&&(i=this.parseDate(i),s.getTime()<i.getTime()&&(s=new Date(i)),this.startDate=i),a&&(a=this.parseDate(a),i&&a.getTime()<i.getTime()&&(a=new Date(i)),s.getTime()>a.getTime()&&(s=new Date(a)),this.endDate=a),this.date=s,this.viewDate=new Date(s),this.initialDate=new Date(this.date),this.bind(),(e.autoShow||this.inline)&&this.show(),e.autoPick&&this.pick()}},{key:"build",value:function(){if(!this.built){this.built=!0;var t=this.$element,e=this.options,i=D(e.template);this.$picker=i,this.$week=i.find(Y("week")),this.$yearsPicker=i.find(Y("years picker")),this.$yearsPrev=i.find(Y("years prev")),this.$yearsNext=i.find(Y("years next")),this.$yearsCurrent=i.find(Y("years current")),this.$years=i.find(Y("years")),this.$monthsPicker=i.find(Y("months picker")),this.$yearPrev=i.find(Y("year prev")),this.$yearNext=i.find(Y("year next")),this.$yearCurrent=i.find(Y("year current")),this.$months=i.find(Y("months")),this.$daysPicker=i.find(Y("days picker")),this.$monthPrev=i.find(Y("month prev")),this.$monthNext=i.find(Y("month next")),this.$monthCurrent=i.find(Y("month current")),this.$days=i.find(Y("days")),this.inline?D(e.container||t).append(i.addClass("".concat(c,"-inline"))):(D(document.body).append(i.addClass("".concat(c,"-dropdown"))),i.addClass(g).css({zIndex:parseInt(e.zIndex,10)})),this.renderWeek()}}},{key:"unbuild",value:function(){this.built&&(this.built=!1,this.$picker.remove())}},{key:"bind",value:function(){var t=this.options,e=this.$element;D.isFunction(t.show)&&e.on(p,t.show),D.isFunction(t.hide)&&e.on(h,t.hide),D.isFunction(t.pick)&&e.on(l,t.pick),this.isInput&&e.on(o,D.proxy(this.keyup,this)),this.inline||(t.trigger?this.$trigger.on(n,D.proxy(this.toggle,this)):this.isInput?e.on(r,D.proxy(this.show,this)):e.on(n,D.proxy(this.show,this)))}},{key:"unbind",value:function(){var t=this.$element,e=this.options;D.isFunction(e.show)&&t.off(p,e.show),D.isFunction(e.hide)&&t.off(h,e.hide),D.isFunction(e.pick)&&t.off(l,e.pick),this.isInput&&t.off(o,this.keyup),this.inline||(e.trigger?this.$trigger.off(n,this.toggle):this.isInput?t.off(r,this.show):t.off(n,this.show))}},{key:"showView",value:function(t){var e=this.$yearsPicker,i=this.$monthsPicker,a=this.$daysPicker,s=this.format;if(s.hasYear||s.hasMonth||s.hasDay)switch(Number(t)){case w:i.addClass(g),a.addClass(g),s.hasYear?(this.renderYears(),e.removeClass(g),this.place()):this.showView(m);break;case v:e.addClass(g),a.addClass(g),s.hasMonth?(this.renderMonths(),i.removeClass(g),this.place()):this.showView(w);break;default:e.addClass(g),i.addClass(g),s.hasDay?(this.renderDays(),a.removeClass(g),this.place()):this.showView(v)}}},{key:"hideView",value:function(){!this.inline&&this.options.autoHide&&this.hide()}},{key:"place",value:function(){if(!this.inline){var t=this.$element,e=this.options,i=this.$picker,a=D(document).outerWidth(),s=D(document).outerHeight(),n=t.outerWidth(),r=t.outerHeight(),h=i.width(),o=i.height(),l=t.offset(),c=l.left,d=l.top,u=parseFloat(e.offset),p=q;C(u)&&(u=10),o<d&&s<d+r+o?(d-=o+u,p=O):d+=r+u,a<c+h&&(c+=n-h,p=p.replace("left","right")),i.removeClass(z).addClass(p).css({top:d,left:c})}}},{key:"trigger",value:function(t,e){var i=D.Event(t,e);return this.$element.trigger(i),i}},{key:"createItem",value:function(t){var e=this.options,i=e.itemTag,a={text:"",view:"",muted:!1,picked:!1,disabled:!1,highlighted:!1},s=[];return D.extend(a,t),a.muted&&s.push(e.mutedClass),a.highlighted&&s.push(e.highlightedClass),a.picked&&s.push(e.pickedClass),a.disabled&&s.push(e.disabledClass),"<".concat(i,' class="').concat(s.join(" "),'" data-view="').concat(a.view,'">').concat(a.text,"</").concat(i,">")}},{key:"getValue",value:function(){var t=this.$element;return this.isInput?t.val():t.text()}},{key:"setValue",value:function(t){var e=0<arguments.length&&void 0!==t?t:"",i=this.$element;this.isInput?i.val(e):this.inline&&!this.options.container||i.text(e)}}],[{key:"setDefaults",value:function(t){var e=0<arguments.length&&void 0!==t?t:{};D.extend(s,y[e.language],D.isPlainObject(e)&&e)}}]),i}();if(D.extend&&D.extend(J.prototype,j,N,P),D.fn){var E=D.fn.datepicker;D.fn.datepicker=function(h){for(var t=arguments.length,o=new Array(1<t?t-1:0),e=1;e<t;e++)o[e-1]=arguments[e];var l;return this.each(function(t,e){var i=D(e),a="destroy"===h,s=i.data(c);if(!s){if(a)return;var n=D.extend({},i.data(),D.isPlainObject(h)&&h);s=new J(e,n),i.data(c,s)}if(b(h)){var r=s[h];D.isFunction(r)&&(l=r.apply(s,o),a&&i.removeData(c))}}),x(l)?this:l},D.fn.datepicker.Constructor=J,D.fn.datepicker.languages=y,D.fn.datepicker.setDefaults=J.setDefaults,D.fn.datepicker.noConflict=function(){return D.fn.datepicker=E,this}}});
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ar-IQ.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ar-IQ'] = {
-    format: 'dd/mm/yyyy',
-    days: ['الأحد', 'الأثنين', 'الثلاثاء', 'الأربعاء', 'الخميس', 'الجمعة', 'السبت'],
-    daysShort: ['أحد', 'أثنين', 'ثلاثاء', 'اربعاء', 'خميس', 'جمعة', 'سبت'],
-    daysMin: ['أ', 'ث', 'ث', 'أ', 'خ', 'ج', 'س'],
-    weekStart: 1,
-    months: ['كانون الثاني', 'شباط', 'اذار', 'نيسان', 'ايار', 'حزيران', 'تموز', 'آب', 'ايلول', 'تشرين الاول', 'تشرين الثاني', 'كانون الاول'],
-    monthsShort: ['كانون ٢', 'شباط', 'اذار', 'نيسان', 'ايار', 'حزيران', 'تموز', 'آب', 'ايلول', 'تشرين ١', 'تشرين ٢', 'كانون ١']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ca-ES.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ca-ES'] = {
-    format: 'dd/mm/yyyy',
-    days: ['diumenge', 'dilluns', 'dimarts', 'dimecres', 'dijous', 'divendres', 'dissabte'],
-    daysShort: ['dg.', 'dl.', 'dt.', 'dc.', 'dj.', 'dv.', 'ds.'],
-    daysMin: ['dg', 'dl', 'dt', 'dc', 'dj', 'dv', 'ds'],
-    weekStart: 1,
-    months: ['gener', 'febrer', 'març', 'abril', 'maig', 'juny', 'juliol', 'agost', 'setembre', 'octubre', 'novembre', 'desembre'],
-    monthsShort: ['gen.', 'febr.', 'març', 'abr.', 'maig', 'juny', 'jul.', 'ag.', 'set.', 'oct.', 'nov.', 'des.']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.cs-CZ.js"
+++ /dev/null
@@ -1,18 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['cs-CZ'] = {
-    format: 'dd.mm.YYYY',
-    days: ['Neděle', 'Pondělí', 'Úterý', 'Středa', 'Čtvrtek', 'Pátek', 'Sobota'],
-    daysShort: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'],
-    daysMin: ['Ne', 'Po', 'Út', 'St', 'Čt', 'Pá', 'So'],
-    weekStart: 1,
-    months: ['Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen', 'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'],
-    // Used everywhere, but probably not grammar correct
-    monthsShort: ['Led', 'Úno', 'Bře', 'Dub', 'Květ', 'Čvn', 'Čvc', 'Srp', 'Zář', 'Říj', 'Lis', 'Pro']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.da-DK.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['da-DK'] = {
-    format: 'dd-mm-yyyy',
-    days: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
-    daysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
-    daysMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
-    weekStart: 1,
-    months: ['Januar', 'Februar', 'Marts', 'April', 'Maj', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'December'],
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.de-DE.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['de-DE'] = {
-    format: 'dd.mm.yyyy',
-    days: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
-    daysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
-    daysMin: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa'],
-    weekStart: 1,
-    months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
-    monthsShort: ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.el-GR.js"
+++ /dev/null
@@ -1,20 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['el-GR'] = {
-    format: 'dd/mm/yyyy',
-    days: ['Κυριακή', 'Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο'],
-    daysShort: ['Κυρ', 'Δευ', 'Τρι', 'Τετ', 'Πεμ', 'Παρ', 'Σαβ'],
-    daysMin: ['Κ', 'Δ', 'Τ', 'Τ', 'Π', 'Π', 'Σ'],
-    months: ['Ιανουάριος', 'Φεβρουάριος', 'Μάρτιος', 'Απρίλιος', 'Μάιος', 'Ιούνιος', 'Ιούλιος', 'Αύγουστος', 'Σεπτέμβρης', 'Οκτώβρης', 'Νοέμβρης', 'Δεκέμβρης'],
-    monthsShort: ['Ιαν', 'Φεβ', 'Μαρ', 'Απρ', 'Μάι', 'Ιούν', 'Ιούλ', 'Άυγ', 'Σεπ', 'Οκτ', 'Νοε', 'Δεκ'],
-    weekStart: 1,
-    startView: 0,
-    yearFirst: false,
-    yearSuffix: ''
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-GB.js"
+++ /dev/null
@@ -1,11 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['en-GB'] = {
-    format: 'dd/mm/yyyy'
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.en-US.js"
+++ /dev/null
@@ -1,11 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['en-US'] = {
-    format: 'mm/dd/yyyy'
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.es-ES.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['es-ES'] = {
-    format: 'dd/mm/yyyy',
-    days: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
-    daysShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],
-    daysMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
-    weekStart: 1,
-    months: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
-    monthsShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fi-FI.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['fi-FI'] = {
-    format: 'dd.mm.yyyy',
-    days: ['Sunnuntai', 'Maanantai', 'Tiistai', 'Keskiviikko', 'Torstai', 'Perjantai', 'Lauantai'],
-    daysShort: ['Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La'],
-    daysMin: ['Su', 'Ma', 'Ti', 'Ke', 'To', 'Pe', 'La'],
-    weekStart: 1,
-    months: ['Tammikuu', 'Helmikuu', 'Maaliskuu', 'Huhtikuu', 'Toukokuu', 'Kesäkuu', 'Heinäkuu', 'Elokuu', 'Syyskuu', 'Lokakuu', 'Marraskuu', 'Joulukuu'],
-    monthsShort: ['Tammi', 'Helmi', 'Maalis', 'Huhti', 'Touko', 'Kesä', 'Heinä', 'Elo', 'Syys', 'Loka', 'Marras', 'Joulu']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.fr-FR.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['fr-FR'] = {
-    format: 'dd/mm/yyyy',
-    days: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
-    daysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
-    daysMin: ['Di', 'Lu', 'Ma', 'Me', 'Je', 'Ve', 'Sa'],
-    weekStart: 1,
-    months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
-    monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Jun', 'Jui', 'Aoû', 'Sep', 'Oct', 'Nov', 'Dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.hu-HU.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['hu-HU'] = {
-    format: 'yyyy. mm. dd.',
-    days: ['vasárnap', 'hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat'],
-    daysShort: ['vas', 'hé', 'ke', 'sze', 'csüt', 'pé', 'szo'],
-    daysMin: ['V', 'H', 'K', 'Sz', 'Cs', 'P', 'Sz'],
-    weekStart: 1,
-    months: ['január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december'],
-    monthsShort: ['jan', 'feb', 'már', 'ápr', 'máj', 'jún', 'júl', 'aug', 'szep', 'okt', 'nov', 'dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.is-IS.js"
+++ /dev/null
@@ -1,18 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['is-IS'] = {
-    format: 'dd.mm.YYYY',
-    // Capital letters are not used in day/month names
-    days: ['sunnudagur', 'mánudagur', 'þriðjudagur', 'miðvikudagur', 'fimmtudagur', 'föstudagur', 'laugardagur'],
-    daysShort: ['sun', 'mán', 'þri', 'mið', 'fim', 'fös', 'lau'],
-    daysMin: ['Su', 'Má', 'Þr', 'Mi', 'Fi', 'Fö', 'La'],
-    weekStart: 1,
-    months: ['janúar', 'febrúar', 'mars', 'apríl', 'maí', 'júní', 'júlí', 'ágúst', 'september', 'október', 'nóvember', 'desember'],
-    monthsShort: ['jan', 'feb', 'mar', 'apr', 'maí', 'jún', 'júl', 'ágú', 'sep', 'okt', 'nóv', 'des']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.it-IT.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['it-IT'] = {
-    format: 'dd/mm/yyyy',
-    days: ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
-    daysShort: ['Dom','Lun','Mar','Mer','Gio','Ven','Sab'],
-    daysMin: ['Do','Lu','Ma','Me','Gi','Ve','Sa'],
-    weekStart: 1,
-    months: ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
-    monthsShort: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ja-JP.js"
+++ /dev/null
@@ -1,19 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ja-JP'] = {
-    format: 'yyyy年mm月dd日',
-    days: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
-    daysShort: ['日曜', '月曜', '火曜', '水曜', '木曜', '金曜', '土曜'],
-    daysMin: ['日', '月', '火', '水', '木', '金', '土'],
-    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
-    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
-    weekStart: 1,
-    yearFirst: true,
-    yearSuffix: '年'
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.km-KH.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['km-KH'] = {
-    format: 'dd-mm-yyyy',
-    days: ['អាទិត្យ', 'ច័ន្ទ', ' អង្គារ', 'ពុធ', 'ព្រហស្បតិ៍', 'សុក្រ', 'សៅរ៍'],
-    daysShort: ['អទ', 'ចន', 'អង', 'ពធ', 'ពហ', 'សក', 'សរ'],
-    daysMin: ['អ', 'ច', 'អ', 'ព', 'ព្', 'ស', 'ស'],
-    weekStart: 1,
-    months: ['មករា', 'កុម្ភៈ', 'មីនា', 'មេសា', 'ឧសភា', 'មិថុនា', 'កក្កដា', 'សីហា', 'កញ្ញា', 'តុលា', 'វិច្ឆិកា', 'ធ្នូ'],
-    monthsShort: ['មរ', 'កម', 'មន', 'មស', 'ឧស', 'មថ', 'កដ', 'សហ', 'កញ', 'តល', 'វឆ', 'ធ្ន']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ko-KR.js"
+++ /dev/null
@@ -1,19 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ko-KR'] = {
-    format: 'yyyy. mm. dd',
-    days: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
-    daysShort: ['일', '월', '화', '수', '목', '금', '토'],
-    daysMin: ['일', '월', '화', '수', '목', '금', '토'],
-    months: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
-    monthsShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
-    weekStart: 1,
-    yearFirst: true,
-    yearSuffix: '년'
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lt-LT.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['lt-LT'] = {
-    format: 'yyyy-mm-dd',
-    days: ['Sekmadienis', 'Pirmadienis', 'Antradienis', 'Trečiadienis', 'Ketvirtadienis', 'Penktadienis', 'Šeštadienis'],
-    daysShort: ['Sekm', 'Pirm', 'Antr', 'Treč', 'Ketv', 'Penkt', 'Šešt'],
-    daysMin: ['Sk', 'Pr', 'An', 'Tr', 'Kt', 'Pn', 'Št'],
-    weekStart: 1,
-    months: ['Sausis', 'Vasaris', 'Kovas', 'Balandis', 'Gegužė', 'Birželis', 'Liepa', 'Rugpjūtis', 'Rugsėjis', 'Spalis', 'Lapkritis', 'Gruodis'],
-    monthsShort: ['Sau', 'Vas', 'Kov', 'Bal', 'Geg', 'Bir', 'Lie', 'Rgp', 'Rgs', 'Spa', 'Lap', 'Gru']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.lv-LV.js"
+++ /dev/null
@@ -1,20 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['lv-LV'] = {
-    format: 'YYYY-mm-dd',
-    days: ['Svētdiena', 'Pirmdiena', 'Otrdiena', 'Trešdiena', 'Ceturtdiena', 'Piektdiena', 'Sestdiena'],
-    daysShort: ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'],
-    daysMin: ['Sv', 'Pr', 'Ot', 'Tr', 'Ce', 'Pk', 'Se'],
-    months: ['Janvāris', 'Februāris', 'Marts', 'Aprīlis', 'Maijs', 'Jūnijs', 'Jūlijs', 'Augusts', 'Septembris', 'Oktobris', 'Novembris', 'Decembris'],
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jūn', 'Jūl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec'],
-    weekStart: 1,
-    startView: 0,
-    yearFirst: false,
-    yearSuffix: ''
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nb-NO.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['nb-NO'] = {
-    format: 'dd-mm-yyyy',
-    days: ['Søndag', 'Mandag', 'Tirsdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lørdag'],
-    daysShort: ['Søn', 'Man', 'Tir', 'Ons', 'Tor', 'Fre', 'Lør'],
-    daysMin: ['Sø', 'Ma', 'Ti', 'On', 'To', 'Fr', 'Lø'],
-    weekStart: 1,
-    months: ['Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember'],
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Des']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.nl-NL.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['nl-NL'] = {
-    format: 'dd-mm-yyyy',
-    days: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
-    daysShort: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
-    daysMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
-    weekStart: 1,
-    months: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.oc-FR.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['oc-FR'] = {
-    format: 'dd/mm/yyyy',
-    days: ['Dimenge', 'Diluns', 'Dimars', 'Dimècres', 'Dijòus', 'Divendres', 'Dissabte'],
-    daysShort: ['Dg', 'Dl', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds'],
-    daysMin: ['dg', 'dl', 'dm', 'dc', 'dj', 'dv', 'ds'],
-    weekStart: 1,
-    months: ['Genièr', 'Febrièr', 'Març', 'Abrial', 'Mai', 'Junh', 'Julhet', 'Agost', 'Setembre', 'Octòbre', 'Novembre', 'Decembre'],
-    monthsShort: ['Gen', 'Feb', 'Març', 'Abr', 'Mai', 'Junh', 'Julh', 'Ago', 'Set', 'Oct', 'Nov', 'Dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pl-PL.js"
+++ /dev/null
@@ -1,18 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['pl-PL'] = {
-    format: 'dd.mm.YYYY',
-    days: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
-    daysShort: ['Niedz', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],
-    // Used and correct are only daysShort, daysMin are just shorted to fit UI
-    daysMin: ['Nie', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],
-    weekStart: 1,
-    months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
-    monthsShort: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.pt-BR.js"
+++ /dev/null
@@ -1,16 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['pt-BR'] = {
-    format: 'dd/mm/yyyy',
-    days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
-    daysShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
-    daysMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
-    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
-    monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ru-RU.js"
+++ /dev/null
@@ -1,20 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ru-RU'] = {
-    format: 'dd.mm.YYYY',
-    days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
-    daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
-    daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
-    months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
-    monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
-    weekStart: 1,
-    startView: 0,
-    yearFirst: false,
-    yearSuffix: ''
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.si-LK.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['si-LK'] = {
-    format: 'yyyy/mm/dd',
-    days: ['ඉරිදා', 'සදුදා', 'අගහරුවදා', 'බදාදා', 'බ්‍රහස්පතින්දා', 'සිකුරාදා', 'සෙනසුරාදා'],
-    daysShort: ['ඉරිදා', 'සදුදා', 'අග', 'බදාදා', 'බ්‍රහස්', 'සිකු', 'සෙන'],
-    daysMin: ['ඉරිදා', 'සදුදා', 'අග', 'බදාදා', 'බ්‍රහස්', 'සිකු', 'සෙන'],
-    weekStart: 1,
-    months: ['ජනවාරි', 'පෙබරවාරි', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජුනි', 'ජූලි', 'අගෝස්තු', 'සැප්තැම්බර්', 'ඔක්තෝබර්', 'නොවැම්බර්', 'දෙසැම්බර්'],
-    monthsShort: ['ජන', 'පෙබ', 'මාර්තු', 'අප්‍රේල්', 'මැයි', 'ජුනි', 'ජූලි', 'අගෝ', 'සැප්', 'ඔක්', 'නොවැ', 'දෙසැ']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sk-SK.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['sk-SK'] = {
-    format: 'dd.mm.YYYY',
-    days: ['Nedeľa', 'Pondelok', 'Utorok', 'Streda', 'Štvrtok', 'Piatok', 'Sobota'],
-    daysShort: ['Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So'],
-    daysMin: ['Ne', 'Po', 'Ut', 'St', 'Št', 'Pi', 'So'],
-    weekStart: 1,
-    months: ['Január', 'Február', 'Marec', 'Apríl', 'Máj', 'Jún', 'Júl', 'August', 'September', 'Október', 'November', 'December'],
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Máj', 'Jún', 'Júl', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.sv-SE.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['sv-SE'] = {
-    format: 'yyyy-mm-dd',
-    days: ['Söndag', 'Måndag', 'Tisdag', 'Onsdag', 'Torsdag', 'Fredag', 'Lördag'],
-    daysShort: ['Sön', 'Mån', 'Tis', 'Ons', 'Tor', 'Fre', 'Lör'],
-    daysMin: ['Sö', 'Må', 'Ti', 'On', 'To', 'Fr', 'Lö'],
-    weekStart: 1,
-    months: ['Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December'],
-    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Maj', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dec']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ta-TA.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ta-TA'] = {
-    format: 'dd/mm/yyyy',
-    days: ['ஞாயிற்றுக்கிழமை','திங்கட்கிழமை','செவ்வாய்கிழமை','புதன்கிழமை','வியாழக்கிழமை','வெள்ளிக்கிழமை','சனிக்கிழமை'],
-    daysShort: ['ஞாயிறு','திங்கள்','செவ்வாய்','புதன்','வியாழன்','வெள்ளி','சனி'],
-    daysMin: ['ஞா','தி','செ','பு','வி','வெ','ச'],
-    weekStart: 1,
-    months: ['ஜனவரி','பிப்ரவரி','மார்ச்','ஏப்ரல்','மே','ஜூன்','ஜூலை','ஆகஸ்ட்','செப்டெம்பர்','அக்டோபர்','நவம்பர்','டிசம்பர்'],
-    monthsShort: ['ஜன', 'பிப்', 'மார்', 'ஏப்', 'மே', 'ஜூன்', 'ஜூலை', 'ஆக', 'செப்', 'அக்', 'நவ', 'டிச']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.th-TH.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['th-TH'] = {
-    format: 'dd/mm/yyyy',
-    days: ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
-    daysShort: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
-    daysMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
-    weekStart: 1,
-    months: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
-    monthsShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.tr-TR.js"
+++ /dev/null
@@ -1,17 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['tr-TR'] = {
-    format: 'dd.mm.yyyy',
-    days: ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'],
-    daysShort: ['Paz', 'Pts', 'Sal', 'Çrş', 'Prş', 'Cum', 'Cts'],
-    daysMin: ['P', 'P', 'S', 'Ç', 'P', 'C', 'C'],
-    weekStart: 1,
-    months: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'],
-    monthsShort: ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz', 'Tem', 'Ağu', 'Eyl', 'Eki', 'Kas', 'Ara']
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.ug-CN.js"
+++ /dev/null
@@ -1,18 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['ug-CN'] = {
-    format: 'yyyy-mm-dd',
-    days: ['يەكشەنبە', 'دۈشەنبە', 'سەيشەنبە', 'چارشەنبە', 'پەيشەنبە', 'جۈمە', 'شەنبە'],
-    daysShort: ['ي', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
-    daysMin:  ['ي', 'د', 'س', 'چ', 'پ', 'ج', 'ش'],
-    months: ['يانۋار', 'فېۋىرال', 'مارت', 'ئاپرىل', 'ماي', 'ئىيۇن', 'ئىيۇل', 'ئاۋغۇست', 'سىنتەبىر', 'ئۆكتەبىر', 'نويابىر', 'دىكابىر'],
-    monthsShort: ['يانۋار', 'فېۋىرال', 'مارت', 'ئاپرىل', 'ماي', 'ئىيۇن', 'ئىيۇل', 'ئاۋغۇست', 'سىنتەبىر', 'ئۆكتەبىر', 'نويابىر', 'دىكابىر'],
-    weekStart: 1,
-    yearFirst: true,
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.vi-VN.js"
+++ /dev/null
@@ -1,18 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['vi-VN'] = {
-    days: ["Chủ nhật", "Thứ hai", "Thứ ba", "Thứ tư", "Thứ năm", "Thứ sáu", "Thứ bảy"],
-    daysShort: ["CN", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7"],
-    daysMin: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
-    months: ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"],
-    monthsShort: ["Th1", "Th2", "Th3", "Th4", "Th5", "Th6", "Th7", "Th8", "Th9", "Th10", "Th11", "Th12"],
-    today: "Hôm nay",
-    clear: "Xóa",
-    format: "dd/mm/yyyy"
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/datepicker/i18n/datepicker.zh-CN.js"
+++ /dev/null
@@ -1,19 +0,0 @@
-(function (global, factory) {
-  typeof exports === 'object' && typeof module !== 'undefined' ? factory(require('jquery')) :
-  typeof define === 'function' && define.amd ? define(['jquery'], factory) :
-  (factory(global.jQuery));
-}(this, (function ($) {
-  'use strict';
-
-  $.fn.datepicker.languages['zh-CN'] = {
-    format: 'yyyy年mm月dd日',
-    days: ['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
-    daysShort: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
-    daysMin: ['日', '一', '二', '三', '四', '五', '六'],
-    months: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
-    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
-    weekStart: 1,
-    yearFirst: true,
-    yearSuffix: '年'
-  };
-})));
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_credentials_after.html"
+++ /dev/null
@@ -1,35 +0,0 @@
-{% if REGISTRATION_AGE_REG_DISPLAY %}
-	<dl>
-		<dt><label for="registration_age_datepicker">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label></dt>
-		<dd>
-		{% if REGISTRATION_AGE_DATEPICKER %}
-			{#
-				left side: phpBB USER_LANG language variable, see common.php of respective language
-				right side: language-country code in i18n filenames, see ext/leinad4mind/specialbirthday/styles/all/template/datepicker/i18n
-			#}
-			{% set datepicker_lang_map = {
-				'en-gb'		: 'en-GB',
-				'en-us' 	: 'en-US',
-				'pt'		: 'pt-PT',
-				'pt_preao'	: 'pt-PT',
-				'pt_br'		: 'pt-BR',
-				'es'		: 'es-ES',
-				'es-x-tu'	: 'es-ES',
-			} %}
-			{% set datepicker_lang = datepicker_lang_map[lang('USER_LANG')] | default('en-GB') %}
-			{% INCLUDECSS '@leinad4mind_specialbirthday/datepicker/datepicker.min.css' %}
-			{% INCLUDEJS '@leinad4mind_specialbirthday/datepicker/datepicker.min.js' %}
-			{% INCLUDEJS '@leinad4mind_specialbirthday/datepicker/i18n/datepicker.' ~ datepicker_lang ~ '.js' %}
-			{% INCLUDEJS '@leinad4mind_specialbirthday/js/common.js' %}
-			<input type="text" name="registration_age_datepicker" id="registration_age_datepicker" class="inputbox autowidth" size="25" tabindex="6" readonly data-lang="{{ datepicker_lang }}">
-			<input type="hidden" name="registration_age_day" id="registration_age_day" value="">
-			<input type="hidden" name="registration_age_month" id="registration_age_month" value="">
-			<input type="hidden" name="registration_age_year" id="registration_age_year" value="">
-		{% else  %}
-			{{ lang('DAY') ~ lang('COLON') }} <select id="registration_age_datepicker" name="registration_age_day">{{ S_BIRTHDAY_DAY_OPTIONS }}</select>
-			{{ lang('MONTH') ~ lang('COLON') }} <select name="registration_age_month">{{ S_BIRTHDAY_MONTH_OPTIONS }}</select>
-			{{ lang('YEAR') ~ lang('COLON') }} <select name="registration_age_year">{{ S_BIRTHDAY_YEAR_OPTIONS }}</select>
-		{% endif  %}
-		</dd>
-	</dl>
-{% endif  %}
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html" "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/all/template/event/ucp_register_profile_fields_before.html"
@@ -0,0 +1,11 @@
+{% if REGISTRATION_AGE_REG_DISPLAY %}
+	{% INCLUDECSS '@leinad4mind_specialbirthday/specialbirthday.css' %}
+	<dl>
+		<dt><label for="birthdate">{{ lang('ENTER_BIRTHDATE') }}{{ lang('COLON') }}{{ REGISTRATION_AGE_REQUIRED ? ' *' }}</label></dt>
+		<dd>
+			{{ lang('DAY') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_day" type="number" maxlength="2" name="registration_age_day" value="{{ REGISTRATION_AGE_DAY }}" min="1" max="31" />
+			{{ lang('MONTH') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_month" type="number" maxlength="2" name="registration_age_month" value="{{ REGISTRATION_AGE_MONTH }}" min="1" max="12" />
+			{{ lang('YEAR') }}{{ lang('COLON') }}&nbsp;<input  id="registration_age_year" type="number" maxlength="4" name="registration_age_year" value="{{ REGISTRATION_AGE_YEAR }}" min="{{ YEAR_START }}" max="{{ YEAR_END }}" step="-1"/>
+		</dd>
+	</dl>
+{% endif  %}
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/event/viewtopic_body_postrow_custom_fields_before.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if postrow.POSTER_AGE %}
-	<dd class="profile-joined"><strong>{{ lang('AGE') }}{{ lang('COLON') }} {{ postrow.POSTER_AGE }}</strong></dd>
-{% endif %}
diff --git "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/js/common.js" "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/js/common.js"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\specialbirthday/styles/all/template/js/common.js"
+++ /dev/null
@@ -1,18 +0,0 @@
-jQuery(function($) {
-    let $element = $('#registration_age_datepicker');
-    $element.datepicker({
-        autoShow: false,
-        autoHide: true,
-        autoPick: false,
-        inline: false,
-        language: $element.data('lang'),
-        date: new Date(),
-        startDate: new Date(1900, 0, 1),
-        endDate: new Date(),
-        startView: 2
-    }).on('pick.datepicker', function(e) {
-        $('#registration_age_day').val(e.date.getUTCDate());
-        $('#registration_age_month').val(e.date.getUTCMonth() + 1);
-        $('#registration_age_year').val(e.date.getUTCFullYear());
-    });
-});
\ No newline at end of file
diff --git "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/all/theme/specialbirthday.css" "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/all/theme/specialbirthday.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialbirthday/styles/all/theme/specialbirthday.css"
@@ -0,0 +1,7 @@
+/**
+* specialbirthday.css
+**/
+
+input[type="number"] {
+	max-width: 60px;
+}
```
