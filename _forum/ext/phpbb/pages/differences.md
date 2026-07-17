Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/phpbb\\pages/CHANGELOG.md" "[FORUM_EXT]/phpbb\\pages/CHANGELOG.md"
--- "[ORIGINAL]/phpbb\\pages/CHANGELOG.md"
+++ "[FORUM_EXT]/phpbb\\pages/CHANGELOG.md"
@@ -2,12 +2,6 @@
 
 ## Version 3.x (for phpBB 3.3 and later)
 
-### 3.0.1 - 2025-06-04
-
-- Added pagination to the Pages list in the Admin Control Panel for improved usability.
-- Resolved potential URL path issues on Windows-based web servers.
-- Updated version constraints to prevent installation on phpBB4, while ensuring it doesn’t cause errors if run within phpBB4.
-
 ### 3.0.0 - 2022-06-17
 
 - Dropped support for phpBB 3.2.x (new minimum requirements: phpBB 3.3.2 and PHP 7.1.3).
@@ -24,8 +18,8 @@
 
 ### 2.0.4 - 2020-03-29
 
-- New option to display page titles before the site name in browser windows.
-- Fixed links to the FontAwesome website.
+- New option to display page's titles before the site name in browser windows.
+- Fixed links to FontAwesome website.
 - Removed Subsilver2 style and support.
 
 ### 2.0.3 - 2018-03-14
diff --git "[ORIGINAL]/phpbb\\pages/acp/pages_module.php" "[FORUM_EXT]/phpbb\\pages/acp/pages_module.php"
--- "[ORIGINAL]/phpbb\\pages/acp/pages_module.php"
+++ "[FORUM_EXT]/phpbb\\pages/acp/pages_module.php"
@@ -53,14 +53,14 @@ class pages_module
 		$this->tpl_name = 'manage_pages';
 
 		// Set the page title for our ACP page
-		$this->page_title = 'ACP_PAGES_MANAGE';
+		$this->page_title = $lang->lang('ACP_PAGES_MANAGE');
 
 		// Perform any actions submitted by the user
 		switch ($action)
 		{
 			case 'add':
 				// Set the page title for our ACP page
-				$this->page_title = 'ACP_PAGES_CREATE_PAGE';
+				$this->page_title = $lang->lang('ACP_PAGES_CREATE_PAGE');
 
 				// Load the add page handle in the admin controller
 				$admin_controller->add_page();
@@ -71,7 +71,7 @@ class pages_module
 
 			case 'edit':
 				// Set the page title for our ACP page
-				$this->page_title = 'ACP_PAGES_EDIT_PAGE';
+				$this->page_title = $lang->lang('ACP_PAGES_EDIT_PAGE');
 
 				// Load the edit page handle in the admin controller
 				$admin_controller->edit_page($page_id);
diff --git "[ORIGINAL]/phpbb\\pages/adm/style/manage_pages.html" "[FORUM_EXT]/phpbb\\pages/adm/style/manage_pages.html"
--- "[ORIGINAL]/phpbb\\pages/adm/style/manage_pages.html"
+++ "[FORUM_EXT]/phpbb\\pages/adm/style/manage_pages.html"
@@ -152,12 +152,6 @@
 		</fieldset>
 	</form>
 
-	{% if pagination %}
-	<div class="pagination top-pagination">
-		{% include 'pagination.html' %}
-	</div>
-	{% endif %}
-
 	<table class="table1 zebra-table fixed-width-table">
 		<thead>
 			<tr>
@@ -199,12 +193,6 @@
 		</tbody>
 	</table>
 
-	{% if pagination %}
-	<div class="pagination">
-		{% include 'pagination.html' %}
-	</div>
-	{% endif %}
-
 	<form id="pages_add_page" method="post" action="{{ U_ACTION }}">
 		<fieldset class="quick">
 			<input class="button2" type="submit" name="addpage" value="{{ lang('ACP_PAGES_CREATE_PAGE') }}" />
diff --git "[ORIGINAL]/phpbb\\pages/composer.json" "[FORUM_EXT]/phpbb\\pages/composer.json"
--- "[ORIGINAL]/phpbb\\pages/composer.json"
+++ "[FORUM_EXT]/phpbb\\pages/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "An extension which allows you to add static pages to your phpBB forum",
     "homepage": "https://www.phpbb.com/customise/db/extension/pages/",
-    "version": "3.0.1",
+    "version": "3.0.0",
     "keywords": [
         "phpbb",
         "extension",
@@ -56,15 +56,15 @@
     "require": {
         "php": ">=7.1.3",
         "composer/installers": "~1.0.0",
-        "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
+        "phpbb/phpbb": ">=3.3.2"
     },
     "require-dev": {
-        "phing/phing": "~2.4"
+        "phing/phing": "2.4.*"
     },
     "extra": {
         "display-name": "Pages",
         "soft-require": {
-            "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
+            "phpbb/phpbb": ">=3.3.2"
         },
         "version-check": {
             "host": "www.phpbb.com",
diff --git "[ORIGINAL]/phpbb\\pages/config/services.yml" "[FORUM_EXT]/phpbb\\pages/config/services.yml"
--- "[ORIGINAL]/phpbb\\pages/config/services.yml"
+++ "[FORUM_EXT]/phpbb\\pages/config/services.yml"
@@ -81,13 +81,16 @@ services:
         tags:
             - { name: text_reparser.plugin }
 
-    phpbb.pages.cron.task.text_reparser.factory:
-        class: phpbb\pages\textreparser\cron_text_reparser_factory
-
     phpbb.pages.cron.task.text_reparser:
         class: phpbb\cron\task\text_reparser\reparser
-        factory: ['@phpbb.pages.cron.task.text_reparser.factory', 'create']
         arguments:
-            - '@service_container'
+            - '@config'
+            - '@config_text'
+            - '@text_reparser.lock'
+            - '@text_reparser.manager'
+            - '@text_reparser_collection'
+        calls:
+            - [set_name, [cron.task.text_reparser.phpbb_pages]]
+            - [set_reparser, [phpbb.pages.text_reparser.page_text]]
         tags:
             - { name: cron.task }
diff --git "[ORIGINAL]/phpbb\\pages/controller/admin_controller.php" "[FORUM_EXT]/phpbb\\pages/controller/admin_controller.php"
--- "[ORIGINAL]/phpbb\\pages/controller/admin_controller.php"
+++ "[FORUM_EXT]/phpbb\\pages/controller/admin_controller.php"
@@ -97,14 +97,8 @@ class admin_controller implements admin_interface
 	*/
 	public function display_pages()
 	{
-		/* @var $pagination \phpbb\pagination */
-		$pagination = $this->container->get('pagination');
-		$start		= $this->request->variable('start', 0);
-		$total		= $this->page_operator->get_total_pages();
-		$limit		= 25;
-
 		// Grab all the pages from the db
-		$entities = $this->page_operator->get_pages($limit, $start);
+		$entities = $this->page_operator->get_pages();
 
 		// Process each page entity for display
 		/* @var $entity \phpbb\pages\entity\page */
@@ -127,8 +121,6 @@ class admin_controller implements admin_interface
 			));
 		}
 
-		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, $limit, $start);
-
 		// Set output vars for display in the template
 		$this->template->assign_vars(array(
 			'U_ACTION'		=> $this->u_action,
@@ -336,7 +328,7 @@ class admin_controller implements admin_interface
 		* @event phpbb.pages.acp_add_edit_page
 		* @since 1.0.0-RC1
 		*/
-		$this->dispatcher->trigger_event('phpbb.pages.acp_add_edit_page');
+		$this->dispatcher->dispatch('phpbb.pages.acp_add_edit_page');
 
 		// Set template vars for Page Template select menu
 		$this->create_page_template_options($entity->get_template());
diff --git "[ORIGINAL]/phpbb\\pages/controller/main_controller.php" "[FORUM_EXT]/phpbb\\pages/controller/main_controller.php"
--- "[ORIGINAL]/phpbb\\pages/controller/main_controller.php"
+++ "[FORUM_EXT]/phpbb\\pages/controller/main_controller.php"
@@ -90,7 +90,6 @@ class main_controller implements main_interface
 		));
 
 		// Send all data to the template file
-		// We do not use @phpbb_pages to allow templates from outside the extension
 		return $this->helper->render($page->get_template(), $page_title);
 	}
 
diff --git "[FORUM_EXT]/phpbb\\pages/diff_full.tmp" "[FORUM_EXT]/phpbb\\pages/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/diff_full.tmp"
@@ -0,0 +1,1807 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
+index 1a22e5370..df78069fb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
+@@ -2,12 +2,6 @@
+ 
+ ## Version 3.x (for phpBB 3.3 and later)
+ 
+-### 3.0.1 - 2025-06-04
+-
+-- Added pagination to the Pages list in the Admin Control Panel for improved usability.
+-- Resolved potential URL path issues on Windows-based web servers.
+-- Updated version constraints to prevent installation on phpBB4, while ensuring it doesn’t cause errors if run within phpBB4.
+-
+ ### 3.0.0 - 2022-06-17
+ 
+ - Dropped support for phpBB 3.2.x (new minimum requirements: phpBB 3.3.2 and PHP 7.1.3).
+@@ -24,8 +18,8 @@
+ 
+ ### 2.0.4 - 2020-03-29
+ 
+-- New option to display page titles before the site name in browser windows.
+-- Fixed links to the FontAwesome website.
++- New option to display page's titles before the site name in browser windows.
++- Fixed links to FontAwesome website.
+ - Removed Subsilver2 style and support.
+ 
+ ### 2.0.3 - 2018-03-14
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
+index ebc2e6179..b071fd785 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
+@@ -53,14 +53,14 @@ class pages_module
+ 		$this->tpl_name = 'manage_pages';
+ 
+ 		// Set the page title for our ACP page
+-		$this->page_title = 'ACP_PAGES_MANAGE';
++		$this->page_title = $lang->lang('ACP_PAGES_MANAGE');
+ 
+ 		// Perform any actions submitted by the user
+ 		switch ($action)
+ 		{
+ 			case 'add':
+ 				// Set the page title for our ACP page
+-				$this->page_title = 'ACP_PAGES_CREATE_PAGE';
++				$this->page_title = $lang->lang('ACP_PAGES_CREATE_PAGE');
+ 
+ 				// Load the add page handle in the admin controller
+ 				$admin_controller->add_page();
+@@ -71,7 +71,7 @@ class pages_module
+ 
+ 			case 'edit':
+ 				// Set the page title for our ACP page
+-				$this->page_title = 'ACP_PAGES_EDIT_PAGE';
++				$this->page_title = $lang->lang('ACP_PAGES_EDIT_PAGE');
+ 
+ 				// Load the edit page handle in the admin controller
+ 				$admin_controller->edit_page($page_id);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
+index 33555df30..48a00baa7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
+@@ -152,12 +152,6 @@
+ 		</fieldset>
+ 	</form>
+ 
+-	{% if pagination %}
+-	<div class="pagination top-pagination">
+-		{% include 'pagination.html' %}
+-	</div>
+-	{% endif %}
+-
+ 	<table class="table1 zebra-table fixed-width-table">
+ 		<thead>
+ 			<tr>
+@@ -199,12 +193,6 @@
+ 		</tbody>
+ 	</table>
+ 
+-	{% if pagination %}
+-	<div class="pagination">
+-		{% include 'pagination.html' %}
+-	</div>
+-	{% endif %}
+-
+ 	<form id="pages_add_page" method="post" action="{{ U_ACTION }}">
+ 		<fieldset class="quick">
+ 			<input class="button2" type="submit" name="addpage" value="{{ lang('ACP_PAGES_CREATE_PAGE') }}" />
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
+index 50274d451..bfb000835 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "An extension which allows you to add static pages to your phpBB forum",
+     "homepage": "https://www.phpbb.com/customise/db/extension/pages/",
+-    "version": "3.0.1",
++    "version": "3.0.0",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -56,15 +56,15 @@
+     "require": {
+         "php": ">=7.1.3",
+         "composer/installers": "~1.0.0",
+-        "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
++        "phpbb/phpbb": ">=3.3.2"
+     },
+     "require-dev": {
+-        "phing/phing": "~2.4"
++        "phing/phing": "2.4.*"
+     },
+     "extra": {
+         "display-name": "Pages",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
++            "phpbb/phpbb": ">=3.3.2"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
+index 5dd73e6c5..4f124883b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
+@@ -81,13 +81,16 @@ services:
+         tags:
+             - { name: text_reparser.plugin }
+ 
+-    phpbb.pages.cron.task.text_reparser.factory:
+-        class: phpbb\pages\textreparser\cron_text_reparser_factory
+-
+     phpbb.pages.cron.task.text_reparser:
+         class: phpbb\cron\task\text_reparser\reparser
+-        factory: ['@phpbb.pages.cron.task.text_reparser.factory', 'create']
+         arguments:
+-            - '@service_container'
++            - '@config'
++            - '@config_text'
++            - '@text_reparser.lock'
++            - '@text_reparser.manager'
++            - '@text_reparser_collection'
++        calls:
++            - [set_name, [cron.task.text_reparser.phpbb_pages]]
++            - [set_reparser, [phpbb.pages.text_reparser.page_text]]
+         tags:
+             - { name: cron.task }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
+index 0676e26e0..ef51a2c8d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
+@@ -97,14 +97,8 @@ class admin_controller implements admin_interface
+ 	*/
+ 	public function display_pages()
+ 	{
+-		/* @var $pagination \phpbb\pagination */
+-		$pagination = $this->container->get('pagination');
+-		$start		= $this->request->variable('start', 0);
+-		$total		= $this->page_operator->get_total_pages();
+-		$limit		= 25;
+-
+ 		// Grab all the pages from the db
+-		$entities = $this->page_operator->get_pages($limit, $start);
++		$entities = $this->page_operator->get_pages();
+ 
+ 		// Process each page entity for display
+ 		/* @var $entity \phpbb\pages\entity\page */
+@@ -127,8 +121,6 @@ class admin_controller implements admin_interface
+ 			));
+ 		}
+ 
+-		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, $limit, $start);
+-
+ 		// Set output vars for display in the template
+ 		$this->template->assign_vars(array(
+ 			'U_ACTION'		=> $this->u_action,
+@@ -336,7 +328,7 @@ class admin_controller implements admin_interface
+ 		* @event phpbb.pages.acp_add_edit_page
+ 		* @since 1.0.0-RC1
+ 		*/
+-		$this->dispatcher->trigger_event('phpbb.pages.acp_add_edit_page');
++		$this->dispatcher->dispatch('phpbb.pages.acp_add_edit_page');
+ 
+ 		// Set template vars for Page Template select menu
+ 		$this->create_page_template_options($entity->get_template());
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/main_controller.php"
+index d0638b533..0ea35000d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/main_controller.php"
+@@ -90,7 +90,6 @@ class main_controller implements main_interface
+ 		));
+ 
+ 		// Send all data to the template file
+-		// We do not use @phpbb_pages to allow templates from outside the extension
+ 		return $this->helper->render($page->get_template(), $page_title);
+ 	}
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp"
+new file mode 100644
+index 000000000..9182ceb16
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp"
+@@ -0,0 +1,185 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
++index 1a22e5370..df78069fb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
++@@ -2,12 +2,6 @@
++ 
++ ## Version 3.x (for phpBB 3.3 and later)
++ 
++-### 3.0.1 - 2025-06-04
++-
++-- Added pagination to the Pages list in the Admin Control Panel for improved usability.
++-- Resolved potential URL path issues on Windows-based web servers.
++-- Updated version constraints to prevent installation on phpBB4, while ensuring it doesn’t cause errors if run within phpBB4.
++-
++ ### 3.0.0 - 2022-06-17
++ 
++ - Dropped support for phpBB 3.2.x (new minimum requirements: phpBB 3.3.2 and PHP 7.1.3).
++@@ -24,8 +18,8 @@
++ 
++ ### 2.0.4 - 2020-03-29
++ 
++-- New option to display page titles before the site name in browser windows.
++-- Fixed links to the FontAwesome website.
+++- New option to display page's titles before the site name in browser windows.
+++- Fixed links to FontAwesome website.
++ - Removed Subsilver2 style and support.
++ 
++ ### 2.0.3 - 2018-03-14
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
++index ebc2e6179..b071fd785 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
++@@ -53,14 +53,14 @@ class pages_module
++ 		$this->tpl_name = 'manage_pages';
++ 
++ 		// Set the page title for our ACP page
++-		$this->page_title = 'ACP_PAGES_MANAGE';
+++		$this->page_title = $lang->lang('ACP_PAGES_MANAGE');
++ 
++ 		// Perform any actions submitted by the user
++ 		switch ($action)
++ 		{
++ 			case 'add':
++ 				// Set the page title for our ACP page
++-				$this->page_title = 'ACP_PAGES_CREATE_PAGE';
+++				$this->page_title = $lang->lang('ACP_PAGES_CREATE_PAGE');
++ 
++ 				// Load the add page handle in the admin controller
++ 				$admin_controller->add_page();
++@@ -71,7 +71,7 @@ class pages_module
++ 
++ 			case 'edit':
++ 				// Set the page title for our ACP page
++-				$this->page_title = 'ACP_PAGES_EDIT_PAGE';
+++				$this->page_title = $lang->lang('ACP_PAGES_EDIT_PAGE');
++ 
++ 				// Load the edit page handle in the admin controller
++ 				$admin_controller->edit_page($page_id);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
++index 33555df30..48a00baa7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
++@@ -152,12 +152,6 @@
++ 		</fieldset>
++ 	</form>
++ 
++-	{% if pagination %}
++-	<div class="pagination top-pagination">
++-		{% include 'pagination.html' %}
++-	</div>
++-	{% endif %}
++-
++ 	<table class="table1 zebra-table fixed-width-table">
++ 		<thead>
++ 			<tr>
++@@ -199,12 +193,6 @@
++ 		</tbody>
++ 	</table>
++ 
++-	{% if pagination %}
++-	<div class="pagination">
++-		{% include 'pagination.html' %}
++-	</div>
++-	{% endif %}
++-
++ 	<form id="pages_add_page" method="post" action="{{ U_ACTION }}">
++ 		<fieldset class="quick">
++ 			<input class="button2" type="submit" name="addpage" value="{{ lang('ACP_PAGES_CREATE_PAGE') }}" />
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
++index 50274d451..bfb000835 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "An extension which allows you to add static pages to your phpBB forum",
++     "homepage": "https://www.phpbb.com/customise/db/extension/pages/",
++-    "version": "3.0.1",
+++    "version": "3.0.0",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -56,15 +56,15 @@
++     "require": {
++         "php": ">=7.1.3",
++         "composer/installers": "~1.0.0",
++-        "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
+++        "phpbb/phpbb": ">=3.3.2"
++     },
++     "require-dev": {
++-        "phing/phing": "~2.4"
+++        "phing/phing": "2.4.*"
++     },
++     "extra": {
++         "display-name": "Pages",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
+++            "phpbb/phpbb": ">=3.3.2"
++         },
++         "version-check": {
++             "host": "www.phpbb.com",
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
++index 5dd73e6c5..4f124883b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
++@@ -81,13 +81,16 @@ services:
++         tags:
++             - { name: text_reparser.plugin }
++ 
++-    phpbb.pages.cron.task.text_reparser.factory:
++-        class: phpbb\pages\textreparser\cron_text_reparser_factory
++-
++     phpbb.pages.cron.task.text_reparser:
++         class: phpbb\cron\task\text_reparser\reparser
++-        factory: ['@phpbb.pages.cron.task.text_reparser.factory', 'create']
++         arguments:
++-            - '@service_container'
+++            - '@config'
+++            - '@config_text'
+++            - '@text_reparser.lock'
+++            - '@text_reparser.manager'
+++            - '@text_reparser_collection'
+++        calls:
+++            - [set_name, [cron.task.text_reparser.phpbb_pages]]
+++            - [set_reparser, [phpbb.pages.text_reparser.page_text]]
++         tags:
++             - { name: cron.task }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
++index 0676e26e0..ef51a2c8d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
++@@ -97,14 +97,8 @@ class admin_controller implements admin_interface
++ 	*/
++ 	public function display_pages()
++ 	{
++-		/* @var $pagination \phpbb\pagination */
++-		$pagination = $this->container->get('pagination');
++-		$start		= $this->request->variable('start', 0);
++-		$total		= $this->page_operator->get_total_pages();
++-		$limit		= 25;
++-
++ 		// Grab all the pages from the db
++-		$entities = $this->page_operator->get_pages($limit, $start);
+++		$entities = $this->page_operator->get_pages();
++ 
++ 		// Process each page entity for display
++ 		/* @var $entity \phpbb\pages\entity\page */
++@@ -127,8 +121,6 @@ class admin_controller implements admin_interface
++ 			));
++ 		}
++ 
++-		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, $limit, $start);
++-
++ 		// Set output vars for display in the template
++ 		$this->template->assign_vars(array(
++ 			'U_ACTION'		=> $this->u_action,
++@@ -336,7 +328,7 @@ class admin_controller implements admin_interface
++ 		* @event phpbb.pages.acp_add_edit_page
++ 		* @since 1.0.0-RC1
++ 		*/
++-		$this->dispatcher->trigger_event('phpbb.pages.acp_add_edit_page');
+++		$this->dispatcher->dispatch('phpbb.pages.acp_add_edit_page');
++ 
++ 		// Set template vars for Page Template select menu
++ 		$this->create_page_template_options($entity->get_template());
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/entity/page.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/entity/page.php"
+index 021c99d0c..cd077eafa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/entity/page.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/entity/page.php"
+@@ -481,7 +481,7 @@ class page implements page_interface
+ 	*/
+ 	public function get_template()
+ 	{
+-		return !empty($this->data['page_template']) ? (string) $this->data['page_template'] : 'pages_default.html';
++		return (!empty($this->data['page_template'])) ? (string) $this->data['page_template'] : 'pages_default.html';
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/event/listener.php"
+index a2154eb2a..bc9bc552d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/event/listener.php"
+@@ -146,7 +146,7 @@ class listener implements EventSubscriberInterface
+ 			// If any of our pages are being viewed, update the event vars with our routes and titles
+ 			foreach ($page_routes as $page_id => $page_data)
+ 			{
+-				if ($event['row']['session_page'] === 'app.' . $this->php_ext . '/' . $page_data['route'])
++				if ($event['row']['session_page'] === 'app.' . $this->php_ext . DIRECTORY_SEPARATOR . $page_data['route'])
+ 				{
+ 					$event['location'] = $this->lang->lang('PAGES_VIEWONLINE', $page_data['title']);
+ 					$event['location_url'] = $this->helper->route('phpbb_pages_dynamic_route_' . $page_id);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/ext.php"
+index dfb75448a..f133572d6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/ext.php"
+@@ -26,14 +26,12 @@ class ext extends \phpbb\extension\base
+ 	 * the minimum version required by this extension:
+ 	 *
+ 	 * Requires phpBB 3.3.2 due to using role_exists check in permission migration.
+-	 * Not compatible with phpBB 4.0.0-dev due to using updated classes.
+ 	 *
+ 	 * @return bool
+ 	 * @access public
+ 	 */
+ 	public function is_enableable()
+ 	{
+-		return phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=')
+-			&& phpbb_version_compare(PHPBB_VERSION, '4.0.0-dev', '<');
++		return phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=');
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/es/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/es/pages_acp.php"
+index 62df4451a..b9d7576e8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/es/pages_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/es/pages_acp.php"
+@@ -80,7 +80,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Esto es un campo requerido.',
+ 	'ACP_PAGES_FORM_DESC'				=> 'Descripción de la página',
+ 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Esto solo se mostrará en la lista de páginas del PCA.',
+-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título del enlace',
++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
+ 	'ACP_PAGES_FORM_ROUTE'				=> 'Ruta URL de la página',
+ 	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'La <strong>ruta</strong> es un identificador único utilizado al final de la URL de una página para definir el vínculo a la página, por ejemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Sólo se admiten letras, números, guiones y guiones bajos. Este es un campo obligatorio.',
+ 	'ACP_PAGES_FORM_CONTENT'			=> 'Contenido de la página',
+@@ -99,8 +99,8 @@ $lang = array_merge($lang, array(
+ 	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página a invitados',
+ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Si se establece en no, sólo los usuarios registrados podrán acceder a la página.',
+ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Enlace de la página',
+-	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar el título de la página primero',
+-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'De forma predeterminada, los navegadores mostrarán el título de esta página después del nombre del sitio <samp style="white-space: nowrap">“Nombre del sitio - Titulo de la página”</samp>. Habilitar esta opción mostrará el título de esta página antes del nombre del sitio <samp style="white-space: nowrap">“Título de la página - Nombre del sitio”</samp>.',
++	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+ 	'PARSE_HTML'						=> 'Reconocer HTML',
+ 
+ 	// Page link location names
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/exceptions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/exceptions.php"
+index 829dcd100..92ebc25eb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/exceptions.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/exceptions.php"
+@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -35,7 +35,7 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ’ « » “ ” …
++// ’ » “ ” …
+ //
+ 
+ /*
+@@ -48,7 +48,7 @@ if (empty($lang) || !is_array($lang))
+ *
+ * Translators: Feel free to not translate these language strings
+ */
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'EXCEPTION_FIELD_MISSING'		=> 'Un champ obligatoire est manquant',
+ 	'EXCEPTION_INVALID_ARGUMENT'	=> 'Argument spécifié incorrect pour `%1$s`. Motif : %2$s',
+ 	'EXCEPTION_OUT_OF_BOUNDS'		=> 'Le champ `%1$s` a reçu une donnée incohérente',
+@@ -56,4 +56,4 @@ $lang = array_merge($lang, [
+ 	'EXCEPTION_NOT_UNIQUE'			=> 'La donnée n’était pas unique.',
+ 	'EXCEPTION_UNEXPECTED_VALUE'	=> 'Le champ `%1$s` a reçu une donnée inattendue. Motif : %2$s',
+ 	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'La donnée contenait des caractères interdits.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/info_acp_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/info_acp_pages.php"
+index 68ebdd809..1d4afd1fd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/info_acp_pages.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/info_acp_pages.php"
+@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -35,10 +35,10 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ’ « » “ ” …
++// ’ » “ ” …
+ //
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	// ACP modules
+ 	'ACP_PAGES'				=> 'Pages',
+ 	'ACP_PAGES_MANAGE'		=> 'Gestion de Pages',
+@@ -47,4 +47,4 @@ $lang = array_merge($lang, [
+ 	'ACP_PAGES_ADDED_LOG'	=> '<strong>Page ajoutée</strong><br />» %s',
+ 	'ACP_PAGES_EDITED_LOG'	=> '<strong>Page modifiée</strong><br />» %s',
+ 	'ACP_PAGES_DELETED_LOG'	=> '<strong>Page supprimée</strong><br />» %s',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_acp.php"
+index e52b23f80..e2c847c9d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_acp.php"
+@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -35,23 +35,23 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ’ « » “ ” …
++// ’ » “ ” …
+ //
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	// Manage page
+ 	'ACP_PAGES_MANAGE'					=> 'Gestion des Pages',
+ 	'ACP_PAGES_MANAGE_EXPLAIN'			=> 'Depuis cette page vous pouvez ajouter, modifier et supprimer des pages personnalisées.',
+ 	'ACP_PAGES_CREATE_PAGE'				=> 'Créer une page',
+-	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez ajouter une nouvelle page personnalisée à votre forum.',
++	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez ajouter une nouvelle page personnalisée pour votre forum.',
+ 	'ACP_PAGES_EDIT_PAGE'				=> 'Modifier une page',
+-	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez modifier une page personnalisée existante de votre forum.',
++	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez modifier une page personnalisée existante pour votre forum.',
+ 
+ 	// Display pages list
+ 	'ACP_PAGES_TITLE'					=> 'Titre',
+ 	'ACP_PAGES_DESCRIPTION'				=> 'Description',
+ 	'ACP_PAGES_ROUTE'					=> 'Chemin',
+-	'ACP_PAGES_TEMPLATE'				=> 'Modèle',
++	'ACP_PAGES_TEMPLATE'				=> 'Template',
+ 	'ACP_PAGES_ORDER'					=> 'Ordre',
+ 	'ACP_PAGES_LINK'					=> 'Lien',
+ 	'ACP_PAGES_VIEW'					=> 'Voir la page',
+@@ -80,28 +80,28 @@ $lang = array_merge($lang, [
+ 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Ce champ est obligatoire.',
+ 	'ACP_PAGES_FORM_DESC'				=> 'Description de la page',
+ 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Cette description ne sera affichée que dans la rubrique « Gestion des Pages » du PCA.',
+-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Utiliser comme titre de lien',
+-	'ACP_PAGES_FORM_ROUTE'				=> 'Route de l’URL de la page',
+-	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'Une version simplifiée du nom de la page, utilisée pour construire l’URL de cette dernière. Exemple : <samp>http://www.phpbb.com/<strong>nom-de-la-page</strong></samp>. Seuls sont autorisés les lettres, chiffres, traits d’union et tirets bas. Ce champ est obligatoire.',
++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
++	'ACP_PAGES_FORM_ROUTE'				=> 'Chemin de la page',
++	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'Le <strong>chemin</strong> est un identifiant unique utilisé à la fin de l’adresse URL d’une page pour en définir le lien vers cette dernière. Exemple : <samp>http://www.phpbb.com/<strong>route</strong></samp>. Seuls sont autorisés les lettres, chiffres, traits d’union et tirets bas. Ce champ est obligatoire.',
+ 	'ACP_PAGES_FORM_CONTENT'			=> 'Contenu de la page',
+-	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Le contenu peut être créé en utilisant les BBCodes, les smileys et les urls magiques de phpBB ou vous pouvez activer le mode HTML. En mode HTML, les BBCodes, les smileys et les urls magiques ne fonctionneront pas, mais vous êtes libre d’utiliser n’importe quelle syntaxe HTML valide. Veuillez noter que ce contenu sera ajouté à un modèle HTML existant, vous ne devez donc pas inclure les balises DOCTYPE, HTML, BODY ou HEAD. Cependant, toutes les autres balises de formatage HTML, y compris IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc. peuvent être utilisées.',
+-	'ACP_PAGES_FORM_TEMPLATE'			=> 'Modèle de la page',
+-	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Les modèles des pages personnalisées, sont nommés <samp>pages_*.html</samp> et peuvent être ajoutés dans les répertoires <samp>./styles/*/template</samp> de phpBB.',
+-	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Sélectionner un modèle',
++	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Le contenu peut être créé en faisant usage des BBCodes par défaut de phpBB, les smileys et les adresses URL magiques ou bien en activant le mode HTML. Avec le mode HTML, les BBCodes, smileys et adresses URL magiques ne fonctionneront pas, mais vous pouvez utiliser toute syntaxe HTML valide. Veuillez prendre note que ce contenu sera intégré dans un template HTML existant. Ainsi, nul besoin d’insérer les tags DOCTYPE, HTML, BODY ou HEAD. Néanmoins, tous les autres tags de mise en forme peuvent être utilisés, incluant IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc..',
++	'ACP_PAGES_FORM_TEMPLATE'			=> 'Template de la page',
++	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Les templates des pages personnalisées, sont nommés <samp>pages_*.html</samp> et peuvent être ajoutés dans les répertoires <samp>./styles/*/template</samp> de phpBB.',
++	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Sélectionner un template',
+ 	'ACP_PAGES_FORM_ORDER'				=> 'Ordre de la page',
+ 	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'Les pages seront triées selon ce champ, permettant ainsi d’organiser l’ordre dans lequel vous souhaitez que leurs liens apparaissent. Les plus petits nombres seront affichés avant les plus grands.',
+-	'ACP_PAGES_FORM_LINKS'				=> 'Emplacements du lien de la page',
++	'ACP_PAGES_FORM_LINKS'				=> 'Emplacements pour le lien de la page',
+ 	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Sélectionne un ou plusieurs emplacements où le lien de cette page apparaitra. Utilisez CTRL+CLICK (ou CMD + CLICK sur Mac) pour (dé)sélectionner plus d’un item.',
+ 	'ACP_PAGES_FORM_ICON_FONT'			=> 'Icône du lien de la page',
+-	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Permet de saisir le nom de l’icône provenant de la police de caractères <strong><a href="%s" target="_blank">Font Awesome</a></strong> qui sera utilisée pour le lien de cette page. Laisser ce champ vide pour utiliser l’icône par défaut CSS/GIF.',
++	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Permet de saisir le nom de l’icône provenant de la police de caractères <strong><a href="%s" target="_blank">Font Awesome</a></strong> qui sera utilisée pour le lien de cette page. Laisser ce champ vide pour utiliser l’image icône par défaut CSS/GIF.',
+ 	'ACP_PAGES_FORM_DISPLAY'			=> 'Afficher la page',
+ 	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Si défini sur non, la page ne sera pas accessible aux utilisateurs néanmoins les administrateurs y auront accès, leur permettant d’avoir un aperçu pendant la création.',
+ 	'ACP_PAGES_FORM_GUESTS'				=> 'Afficher la page aux invités',
+ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Si défini sur non, seuls les utilisateurs enregistrés pourront accéder à la page.',
+ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Lien de la page',
+-	'ACP_PAGES_TITLE_SWITCH'			=> 'Afficher le titre de la page en premier',
+-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'Par défaut, les navigateurs affichent le titre de cette page après le nom du site <samp style="white-space : nowrap">« Nom du site - Titre de la page »</samp>. En activant cette option, le titre de cette page sera affiché avant le nom du site <samp style="white-space : nowrap">« Titre de la page - Nom du site »</samp>.',
+-	'PARSE_HTML'						=> 'Analyser le HTML',
++	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
++	'PARSE_HTML'						=> 'Parser le HTML',
+ 
+ 	// Page link location names
+ 	'NAV_BAR_LINKS_BEFORE'				=> 'Barre de navigation avant les liens',
+@@ -114,4 +114,4 @@ $lang = array_merge($lang, [
+ 	'FOOTER_TEAMS_AFTER'				=> 'Pied de page après le lien de l’équipe',
+ 	'QUICK_LINK_MENU_BEFORE'			=> 'En haut du menu « Accès rapide »',
+ 	'QUICK_LINK_MENU_AFTER'				=> 'En bas du menu « Accès rapide »',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_common.php"
+index 9062924ce..2dd4877e3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_common.php"
+@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ’ « » “ ” …
++// ’ » “ ” …
+ //
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'PAGES_VIEWONLINE'		=> 'Consulte la page %s',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_controller.php"
+index ff7b66009..a5ffd7138 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_controller.php"
+@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ’ « » “ ” …
++// ’ » “ ” …
+ //
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'PAGE_NOT_AVAILABLE'		=> 'La page « %s » n’est pas disponible.',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/permissions_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/permissions_pages.php"
+index 22d8b1437..c64a00893 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/permissions_pages.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/permissions_pages.php"
+@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ //
+ // Some characters you may want to copy&paste:
+-// ’ « » “ ” …
++// ’ » “ ” …
+ //
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	'ACL_A_PAGES'		=> 'Peut gérer l’extension Pages',
+-]);
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/it/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/it/pages_acp.php"
+index e074c1b1f..b881f78c2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/it/pages_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/it/pages_acp.php"
+@@ -92,15 +92,15 @@ $lang = array_merge($lang, array(
+ 	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'Le pagine verranno ordinate in base a questo campo, che può aiutare ad organizzare l´ordine in cui appaiono loro collegamenti. I numeri più bassi hanno la precedenza su numeri più alti.',
+ 	'ACP_PAGES_FORM_LINKS'				=> 'Posizione link alla pagina',
+ 	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Selezionare uno o più luoghi in cui il link a questa pagina putrà apparire. Utilizzare Ctrl + clic (o CMD + clic su Mac) per selezionare/deselezionare più di una voce.',
+-	'ACP_PAGES_FORM_ICON_FONT'			=> 'Icona del link della pagina',
+-	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Inserisci il nome di un’icona <strong><a href="%s" target="_blank">Font Awesome</a></strong> per usarla con il link della pagina. Lascia vuoto questo campo per usare le icone tradizionali CSS/GIF delle Pagine.',
++	'ACP_PAGES_FORM_ICON_FONT'			=> 'Page link icon',
++	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use with the page link. Leave this field blank to use Pages’ traditional CSS/GIF image icons.',
+ 	'ACP_PAGES_FORM_DISPLAY'			=> 'Visualizza pagina',
+ 	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Se impostato su no, la pagina non sarà accessibile. (Nota: Gli amministratori saranno ancora in grado di accedere alla pagina, permettendo loro di visualizzare in anteprima privatamente la pagina mentre lo sviluppo è ancora in essere.)',
+ 	'ACP_PAGES_FORM_GUESTS'				=> 'Permetti visualizzazione pagina agli ospiti',
+ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se impostato su no, solo gli utenti registrati saranno in grado di accedere alla pagina.',
+ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link alla pagina',
+-	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostra prima il titolo della pagina',
+-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'Per impostazione predefinita i browser mostreranno il titolo di questa pagina dopo il nome del sito <samp style="white-space: nowrap">“Nome del Sito - Titolo della Pagina”</samp>. Abilitare quest’opzione mostrera’ il titolo di questa pagina prima del nome del sito <samp style="white-space: nowrap">“Titolo della Pagina - Nome del Sito”</samp>.',
++	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+ 	'PARSE_HTML'						=> 'Analizza HTML',
+ 
+ 	// Page link location names
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/pt/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt/pages_acp.php"
+index de3e33f87..d57145a71 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/pt/pages_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt/pages_acp.php"
+@@ -80,7 +80,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Este Campo é obrigatório.',
+ 	'ACP_PAGES_FORM_DESC'				=> 'Descrição da página',
+ 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Apenas será exibido na lista de páginas no ACP.',
+-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título do endereço',
+ 	'ACP_PAGES_FORM_ROUTE'				=> 'Caminho do URL da página',
+ 	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> '<strong>route</strong> é um identificador exclusivo, usado no final da URL de uma página, para definir o link para a página, por exemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Apenas letras, números, hífens e sublinhados são permitidos. Este campo é obrigatório.',
+ 	'ACP_PAGES_FORM_CONTENT'			=> 'Conteúdo da página',
+@@ -99,7 +99,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página aos visitantes',
+ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se definido como Não, apenas utilizadores registados poderão aceder à página.',
+ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link da página',
+-	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
++	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar primeiro o título da página',
+ 	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+ 	'PARSE_HTML'						=> 'Parse HTML',
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/exceptions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/exceptions.php"
+new file mode 100644
+index 000000000..468ce6770
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/exceptions.php"
+@@ -0,0 +1,59 @@
++<?php
++/**
++*
++* Pages extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++// DEVELOPERS PLEASE NOTE
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
++/*
++* These are errors which can be triggered by sending invalid data to the
++* pages extension API.
++*
++* These errors will never show to a user unless they are either modifying
++* the core pages extension code OR unless they are writing an extension
++* which makes calls to this extension.
++*
++* Translators: Feel free to not translate these language strings
++*/
++$lang = array_merge($lang, array(
++	'EXCEPTION_FIELD_MISSING'		=> 'Campo obrigatório em falta',
++	'EXCEPTION_INVALID_ARGUMENT'	=> 'O argumento especificado para `%1$s` é inválido. Razão: %2$s',
++	'EXCEPTION_OUT_OF_BOUNDS'		=> 'O Campo `%1$s` recebeu dados além do limite',
++	'EXCEPTION_TOO_LONG'			=> 'A entrada foi maior do que o máximo permitido.',
++	'EXCEPTION_NOT_UNIQUE'			=> 'A entrada não é única.',
++	'EXCEPTION_UNEXPECTED_VALUE'	=> 'O campo `%1$s` recebeu dados não previstos. Razão: %2$s',
++	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'A entrada tem caracteres inválidos.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/info_acp_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/info_acp_pages.php"
+new file mode 100644
+index 000000000..5440a3cbe
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/info_acp_pages.php"
+@@ -0,0 +1,50 @@
++<?php
++/**
++*
++* Pages extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++// DEVELOPERS PLEASE NOTE
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
++$lang = array_merge($lang, array(
++	// ACP modules
++	'ACP_PAGES'				=> 'Páginas Personalizadas',
++	'ACP_PAGES_MANAGE'		=> 'Gerir Páginas Personalizadas',
++
++	// Logs
++	'ACP_PAGES_ADDED_LOG'	=> '<strong>Página adicionada</strong><br />» %s',
++	'ACP_PAGES_EDITED_LOG'	=> '<strong>Página Editada</strong><br />» %s',
++	'ACP_PAGES_DELETED_LOG'	=> '<strong>Página apagada</strong><br />» %s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_acp.php"
+new file mode 100644
+index 000000000..d57145a71
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_acp.php"
+@@ -0,0 +1,117 @@
++<?php
++/**
++*
++* Pages extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++// DEVELOPERS PLEASE NOTE
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
++$lang = array_merge($lang, array(
++	// Manage page
++	'ACP_PAGES_MANAGE'					=> 'Gerir Páginas Personalizadas',
++	'ACP_PAGES_MANAGE_EXPLAIN'			=> 'A partir desta página, pode adicionar, editar e excluir páginas personalizadas.',
++	'ACP_PAGES_CREATE_PAGE'				=> 'Criar páginas',
++	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Usando o formulário abaixo, pode criar uma nova página personalizada para o seu Fórum.',
++	'ACP_PAGES_EDIT_PAGE'				=> 'Editar página',
++	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Usando o formulário abaixo, pode modificar uma página personalizada existente no seu Fórum.',
++
++	// Display pages list
++	'ACP_PAGES_TITLE'					=> 'Nome',
++	'ACP_PAGES_DESCRIPTION'				=> 'Descrição',
++	'ACP_PAGES_ROUTE'					=> 'Route',
++	'ACP_PAGES_TEMPLATE'				=> 'Template',
++	'ACP_PAGES_ORDER'					=> 'Ordem',
++	'ACP_PAGES_LINK'					=> 'Link',
++	'ACP_PAGES_VIEW'					=> 'Ver página',
++	'ACP_PAGES_STATUS'					=> 'Estatuto',
++	'ACP_PAGES_PUBLISHED'				=> 'Publicada',
++	'ACP_PAGES_PUBLISHED_NO_GUEST'		=> 'Publicada (apenas membros)',
++	'ACP_PAGES_PRIVATE'					=> 'Privada',
++	'ACP_PAGES_EMPTY'					=> 'Não há páginas',
++
++	// Purge icons
++	'ACP_PAGES_PURGE_ICONS'				=> 'Limpar icons',
++	'ACP_PAGES_PURGE_ICONS_LABEL'		=> 'Limpar cache dos icones das páginas',
++	'ACP_PAGES_PURGE_ICONS_EXPLAIN'		=> 'Ao adicionar links para ícones das páginas personalizadas, tem que limpar a cache de ícones para ver os novos ícones. Coloque os ícones personalizados, usando nomes <samp>pages_route.gif</samp>, onde <samp>route</samp> é nome do caminho da página, na pasta <samp>styles/*/theme/images/</samp>.',
++
++	// Messages shown to user
++	'ACP_PAGES_DELETE_CONFIRM'			=> 'Tem a certeza que deseja eliminar esta página?',
++	'ACP_PAGES_DELETE_SUCCESS'			=> 'Página eliminada com sucesso.',
++	'ACP_PAGES_DELETE_ERRORED'			=> 'A página não pode ser eliminada.',
++	'ACP_PAGES_ADD_SUCCESS'				=> 'Página criada com sucesso.',
++	'ACP_PAGES_EDIT_SUCCESS'			=> 'Página atualizada com sucesso.',
++
++	// Add/edit page
++	'ACP_PAGES_SETTINGS'				=> 'Configurar página',
++	'ACP_PAGES_OPTIONS'					=> 'Opções da página',
++	'ACP_PAGES_FORM_TITLE'				=> 'Título da página',
++	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Este Campo é obrigatório.',
++	'ACP_PAGES_FORM_DESC'				=> 'Descrição da página',
++	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Apenas será exibido na lista de páginas no ACP.',
++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título do endereço',
++	'ACP_PAGES_FORM_ROUTE'				=> 'Caminho do URL da página',
++	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> '<strong>route</strong> é um identificador exclusivo, usado no final da URL de uma página, para definir o link para a página, por exemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Apenas letras, números, hífens e sublinhados são permitidos. Este campo é obrigatório.',
++	'ACP_PAGES_FORM_CONTENT'			=> 'Conteúdo da página',
++	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Na criação do conteúdo pode usar BBCodes phpBB, smilies e urls mágicos ou pode ativar o modo HTML. No modo HTML, os BBCodes, smilies e urls mágicos não funcionam, mas pode usar qualquer sintaxe HTML válida. Tenha em atenção que este conteúdo será mostrado no Template HTML existente, pelo que não deve incluir DOCTYPE, HTML, BODY ou tags HEAD. No entanto podem ser usadas todas as outras tags de formatação HTML, incluindo IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc.',
++	'ACP_PAGES_FORM_TEMPLATE'			=> 'Template da página',
++	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Modelos de páginas personalizadas com nomes <samp>pages_*.html</samp> podem ser adicionadas à pasta phpBB’s <samp>styles/*/template</samp>.',
++	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Selecione um template',
++	'ACP_PAGES_FORM_ORDER'				=> 'Ordem das páginas',
++	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'As páginas serão ordenadas de acordo com esta ordem, que pode ajudar a organizar a ordem em que os links aparecem. Os números mais baixos têm precedência sobre os números mais altos.',
++	'ACP_PAGES_FORM_LINKS'				=> 'Localizações do link da página',
++	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Selecione um ou mais locais onde serão visíveis links para esta página. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar/desselecionar mais do que um item.',
++	'ACP_PAGES_FORM_ICON_FONT'			=> 'Page link icon',
++	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use with the page link. Leave this field blank to use Pages’ traditional CSS/GIF image icons.',
++	'ACP_PAGES_FORM_DISPLAY'			=> 'Mostrar página',
++	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Se definido como Não, a página não será visível. (Nota: Administradores podem aceder à página, o que lhes permite pré-visualizá-la enquanto estão a desenvolvê-la.)',
++	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página aos visitantes',
++	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se definido como Não, apenas utilizadores registados poderão aceder à página.',
++	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link da página',
++	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar primeiro o título da página',
++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
++	'PARSE_HTML'						=> 'Parse HTML',
++
++	// Page link location names
++	'NAV_BAR_LINKS_BEFORE'				=> 'Antes dos Links Nav Bar',
++	'NAV_BAR_LINKS_AFTER'				=> 'Depois dos Links Nav Bar',
++	'NAV_BAR_CRUMBS_BEFORE'				=> 'Antes dos Breadcrumbs Nav Bar',
++	'NAV_BAR_CRUMBS_AFTER'				=> 'Depois dos Breadcrumbs Nav Bar',
++	'FOOTER_TIMEZONE_BEFORE'			=> 'No Rodapé antes da Time Zone',
++	'FOOTER_TIMEZONE_AFTER'				=> 'No Rodapé depois da Time Zone',
++	'FOOTER_TEAMS_BEFORE'				=> 'No Rodapé antes da Team Link',
++	'FOOTER_TEAMS_AFTER'				=> 'No Rodapé depois da Team Link',
++	'QUICK_LINK_MENU_BEFORE'			=> 'Nos Links rápidos, no inicio',
++	'QUICK_LINK_MENU_AFTER'				=> 'Nos Links rápidos, no final',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_common.php"
+new file mode 100644
+index 000000000..b6fd73f08
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_common.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* Pages extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++// DEVELOPERS PLEASE NOTE
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
++$lang = array_merge($lang, array(
++	'PAGES_VIEWONLINE'		=> 'Vendo %s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_controller.php"
+new file mode 100644
+index 000000000..3efa92007
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_controller.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* Pages extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++// DEVELOPERS PLEASE NOTE
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
++$lang = array_merge($lang, array(
++	'PAGE_NOT_AVAILABLE'		=> 'A página solicitada “%s” não está disponível.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/permissions_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/permissions_pages.php"
+new file mode 100644
+index 000000000..82cffa488
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/permissions_pages.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* Pages extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++// DEVELOPERS PLEASE NOTE
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
++$lang = array_merge($lang, array(
++	'ACL_A_PAGES'		=> 'Pode gerir a extensão Páginas Personalizadas',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page.php"
+index 7f21eb6b0..ea5beda8d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page.php"
+@@ -67,14 +67,12 @@ class page implements page_interface
+ 	}
+ 
+ 	/**
+-	 * Get all pages
+-	 *
+-	 * @param int $limit
+-	 * @param int $start
+-	 * @return array Array of page data entities
+-	 * @access public
+-	 */
+-	public function get_pages($limit = 0, $start = 0)
++	* Get all pages
++	*
++	* @return array Array of page data entities
++	* @access public
++	*/
++	public function get_pages()
+ 	{
+ 		$entities = array();
+ 
+@@ -82,7 +80,7 @@ class page implements page_interface
+ 		$sql = 'SELECT *
+ 			FROM ' . $this->pages_table . '
+ 			ORDER BY page_order ASC, page_id ASC';
+-		$result = $this->db->sql_query_limit($sql, $limit, $start);
++		$result = $this->db->sql_query($sql);
+ 
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+@@ -369,23 +367,6 @@ class page implements page_interface
+ 		return $rows;
+ 	}
+ 
+-	/**
+-	 * Get the total number of pages
+-	 *
+-	 * @return int
+-	 * @access public
+-	 */
+-	public function get_total_pages()
+-	{
+-		$sql = 'SELECT COUNT(*) AS pages
+-			FROM ' . $this->pages_table;
+-		$result = $this->db->sql_query($sql);
+-		$pages = $this->db->sql_fetchfield('pages');
+-		$this->db->sql_freeresult($result);
+-
+-		return (int) $pages;
+-	}
+-
+ 	/**
+ 	* Check if a page identifier exists in the database
+ 	*
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page_interface.php"
+index 16c611da7..634b2e638 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page_interface.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page_interface.php"
+@@ -13,19 +13,17 @@ namespace phpbb\pages\operators;
+ /**
+ * Interface for our pages operator
+ *
+-* This describes all the methods we'll have for working with a set of pages
++* This describes all of the methods we'll have for working with a set of pages
+ */
+ interface page_interface
+ {
+ 	/**
+-	 * Get all pages
+-	 *
+-	 * @param int $limit
+-	 * @param int $start
+-	 * @return array Array of page data entities
+-	 * @access public
+-	 */
+-	public function get_pages($limit = 0, $start = 0);
++	* Get all pages
++	*
++	* @return array Array of page data entities
++	* @access public
++	*/
++	public function get_pages();
+ 
+ 	/**
+ 	* Add a page
+@@ -110,12 +108,4 @@ interface page_interface
+ 	* @access public
+ 	*/
+ 	public function get_link_locations();
+-
+-	/**
+-	 * Get the total number of pages
+-	 *
+-	 * @return int
+-	 * @access public
+-	 */
+-	public function get_total_pages();
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
+new file mode 100644
+index 000000000..67282ed61
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
+@@ -0,0 +1,8 @@
++{# Note: we must use the after code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TEAMLINK_AFTER %}
++	{% for link in overall_footer_teamlink_after_links %}
++		<li>
++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html"
+new file mode 100644
+index 000000000..459e7ba73
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html"
+@@ -0,0 +1,8 @@
++{# Note: we must use the before code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TEAMLINK_BEFORE %}
++	{% for link in overall_footer_teamlink_before_links %}
++		<li>
++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html"
+new file mode 100644
+index 000000000..b07446556
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html"
+@@ -0,0 +1,8 @@
++{# Note: we must use the after code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TIMEZONE_AFTER %}
++	{% for link in overall_footer_timezone_after_links %}
++		<small>
++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
++		</small>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html"
+new file mode 100644
+index 000000000..d65f65cfa
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html"
+@@ -0,0 +1,8 @@
++{# Note: we must use the before code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TIMEZONE_BEFORE %}
++	{% for link in overall_footer_timezone_before_links %}
++		<small>
++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
++		</small>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html"
+new file mode 100644
+index 000000000..9e18f1c0b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html"
+@@ -0,0 +1,7 @@
++{% if S_OVERALL_HEADER_BREADCRUMBS_BEFORE %}
++	{% for link in overall_header_breadcrumbs_before_links %}
++		<li {$MICRODATA}>
++			<span itemprop="title"><a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a></span>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html"
+new file mode 100644
+index 000000000..cc3b078f9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html"
+@@ -0,0 +1,7 @@
++{% if S_OVERALL_HEADER_BREADCRUMBS_AFTER %}
++	{% for link in overall_header_breadcrumbs_after_links %}
++		<li {$MICRODATA}>
++			<span itemprop="title"><a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a></span>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+new file mode 100644
+index 000000000..bdaec372a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+@@ -0,0 +1,9 @@
++{% if S_OVERALL_HEADER_NAVIGATION_APPEND %}
++	{% for link in overall_header_navigation_append_links %}
++		<li>
++			<a href="{{ link.U_LINK_URL }}">
++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}"></i>{% endif %}{{ link.LINK_TITLE }}</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html"
+new file mode 100644
+index 000000000..8160ab5c1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html"
+@@ -0,0 +1,9 @@
++{% if S_OVERALL_HEADER_NAVIGATION_PREPEND %}
++	{% for link in overall_header_navigation_prepend_links %}
++		<li>
++			<a href="{{ link.U_LINK_URL }}">
++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}"></i>{% endif %}{{ link.LINK_TITLE }}</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_blank.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_blank.html"
+new file mode 100644
+index 000000000..040648506
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_blank.html"
+@@ -0,0 +1,23 @@
++{# Use the space below to include external CSS and JS files
++# Here are some example usages:
++#
++# local files relative to this template file (when stored inside phpBB's style directories):
++# {% INCLUDEJS 'script.js' %}
++# {% INCLUDECSS 'style.css' %}
++#
++# local files stored inside the Pages extension:
++# {% INCLUDEJS '@phpbb_pages/script.js' %}
++# {% INCLUDECSS '@phpbb_pages/style.cs's %}
++#
++# hosted on external sites:
++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
++#
++#}
++{% include 'overall_header.html' %}
++
++	{{ PAGE_CONTENT }}
++
++{% EVENT phpbb_pages_after_page_content %}
++
++{% include 'overall_footer.html' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_default.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_default.html"
+new file mode 100644
+index 000000000..f6ef6a6d7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_default.html"
+@@ -0,0 +1,27 @@
++{# Use the space below to include external CSS and JS files
++# Here are some example usages:
++#
++# local files relative to this template file (when stored inside phpBB's style directories):
++# {% INCLUDEJS 'script.js' %}
++# {% INCLUDECSS 'style.css' %}
++#
++# local files stored inside the Pages extension:
++# {% INCLUDEJS '@phpbb_pages/script.js' %}
++# {% INCLUDECSS '@phpbb_pages/style.cs's %}
++#
++# hosted on external sites:
++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
++#
++#}
++{% include 'overall_header.html' %}
++
++<div class="side-segment">
++	<h3>{PAGE_TITLE}</h3>
++</div>
++<div class="well">
++	{{ PAGE_CONTENT }}
++</div>
++{% EVENT phpbb_pages_after_page_content %}
++
++{% include 'overall_footer.html' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html"
+new file mode 100644
+index 000000000..093fab1c6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html"
+@@ -0,0 +1,9 @@
++{% if S_NAVBAR_HEADER_QUICK_LINKS_AFTER %}
++	{% for link in navbar_header_quick_links_after_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }}"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html"
+new file mode 100644
+index 000000000..1033526bd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html"
+@@ -0,0 +1,9 @@
++{% if S_NAVBAR_HEADER_QUICK_LINKS_BEFORE %}
++	{% for link in navbar_header_quick_links_before_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }}"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
+new file mode 100644
+index 000000000..8eaf3e550
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
+@@ -0,0 +1,10 @@
++{# Note: we must use the before code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TEAMLINK_BEFORE %}
++	{% for link in overall_footer_teamlink_before_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html"
+new file mode 100644
+index 000000000..cf298acd5
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html"
+@@ -0,0 +1,10 @@
++{# Note: we must use the after code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TEAMLINK_AFTER %}
++	{% for link in overall_footer_teamlink_after_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html"
+new file mode 100644
+index 000000000..174cb155d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html"
+@@ -0,0 +1,10 @@
++{# Note: we must use the before code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TIMEZONE_BEFORE %}
++	{% for link in overall_footer_timezone_before_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html"
+new file mode 100644
+index 000000000..c8db014d8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html"
+@@ -0,0 +1,10 @@
++{# Note: we must use the after code so the link will appear in the expected location #}
++{% if S_OVERALL_FOOTER_TIMEZONE_AFTER %}
++	{% for link in overall_footer_timezone_after_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ overall_footer_timezone_before_links.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html"
+new file mode 100644
+index 000000000..f9f099b4d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html"
+@@ -0,0 +1,7 @@
++{% if S_OVERALL_HEADER_BREADCRUMBS_AFTER %}
++	{% for link in overall_header_breadcrumbs_after_links %}
++		<li data-skip-responsive {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} breadcrumbs"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="breadcrumbs"{% endif %} itemscope itemtype="https://schema.org/BreadcrumbList">
++			<span class="crumb" {{ MICRODATA }}><a itemprop="item" href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}">{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span itemprop="name">{{ link.LINK_TITLE }}</span></a><meta itemprop="position" content="{{ navlink_position }}{% set navlink_position = navlink_position + 1 %}" /></span>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+new file mode 100644
+index 000000000..97367b56e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
+@@ -0,0 +1,7 @@
++{% if S_OVERALL_HEADER_BREADCRUMBS_BEFORE %}
++	{% for link in overall_header_breadcrumbs_before_links %}
++		<li data-skip-responsive {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} breadcrumbs"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="breadcrumbs"{% endif %} itemscope itemtype="https://schema.org/BreadcrumbList">
++			<span class="crumb" {{ MICRODATA }}><a itemprop="item" href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}">{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span itemprop="name">{{ link.LINK_TITLE }}</span></a><meta itemprop="position" content="0" /></span>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..dd7b65642
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1 @@
++{% INCLUDECSS '@phpbb_pages/pages_common.css' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+new file mode 100644
+index 000000000..70ce62e50
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+@@ -0,0 +1,9 @@
++{% if S_OVERALL_HEADER_NAVIGATION_APPEND %}
++	{% for link in overall_header_navigation_append_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} no-bulletin"{% if link.ICON_LINK %} style="background-image:url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span></a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html"
+new file mode 100644
+index 000000000..28353578b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html"
+@@ -0,0 +1,10 @@
++{% if S_OVERALL_HEADER_NAVIGATION_PREPEND %}
++	{% for link in overall_header_navigation_prepend_links %}
++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} no-bulletin"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
++			</a>
++		</li>
++	{% endfor %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html"
+new file mode 100644
+index 000000000..33b7e8024
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html"
+@@ -0,0 +1,23 @@
++{# Use the space below to include external CSS and JS files
++# Here are some example usages:
++#
++# local files relative to this template file (when stored inside phpBB's style directories):
++# {% INCLUDEJS 'script.js' %}
++# {% INCLUDECSS 'style.css' %}
++#
++# local files stored inside the Pages extension:
++# {% INCLUDEJS '@phpbb_pages/script.js' %}
++# {% INCLUDECSS '@phpbb_pages/style.css' %}
++#
++# hosted on external sites:
++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
++#
++#}
++{% include 'overall_header.html' %}
++
++	{{ PAGE_CONTENT }}
++
++{% EVENT phpbb_pages_after_page_content %}
++
++{% include 'overall_footer.html' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_default.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_default.html"
+new file mode 100644
+index 000000000..0f5a0c59f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_default.html"
+@@ -0,0 +1,27 @@
++{# Use the space below to include external CSS and JS files
++# Here are some example usages:
++#
++# local files relative to this template file (when stored inside phpBB's style directories):
++# {% INCLUDEJS 'script.js' %}
++# {% INCLUDECSS 'style.css' %}
++#
++# local files stored inside the Pages extension:
++# {% INCLUDEJS '@phpbb_pages/script.js' %}
++# {% INCLUDECSS '@phpbb_pages/style.css' %}
++#
++# hosted on external sites:
++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
++#
++#}
++{% include 'overall_header.html' %}
++
++<div class="side-segment">
++	<h3>{PAGE_TITLE}</h3>
++</div>
++<div class="well">
++	{{ PAGE_CONTENT }}
++</div>
++{% EVENT phpbb_pages_after_page_content %}
++
++{% include 'overall_footer.html' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif"
+new file mode 100644
+index 000000000..20b2fe9f8
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css"
+new file mode 100644
+index 000000000..e315eaec9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css"
+@@ -0,0 +1,17 @@
++.icon-pages {
++	background: url("./images/icon_pages.gif") no-repeat 0 50%;
++}
++
++li.breadcrumbs.icon-pages span:first-child > a {
++	display: inline-block;
++	padding-left: 17px;
++}
++
++.rtl .icon-pages {
++	background-position: 100% 50%;
++}
++
++.rtl li.breadcrumbs.icon-pages span:first-child > a {
++	padding-right: 19px;
++	padding-left: 0;
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css"
+new file mode 100644
+index 000000000..072c1adf1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css"
+@@ -0,0 +1,51 @@
++.content p,
++.content h1,
++.content h2,
++.content h3,
++.content h4 {
++	font: inherit;
++	font-size: 100%;
++	line-height: 1.3em;
++	vertical-align: baseline;
++	text-transform: none;
++	border: 0;
++	color: inherit;
++	margin: 0;
++	padding: 0;
++}
++
++.pages-content {
++	font-size: 1.25em;
++	line-height: 1.3em;
++}
++
++.pages-content h1 {
++	font-size: 2em;
++}
++
++.pages-content h2 {
++	font-size: 1.5em;
++}
++
++.pages-content h3 {
++	font-size: 1.17em;
++}
++
++.pages-content h4 {
++	font-size: 1em;
++}
++
++.pages-content h5 {
++	font-size: 0.83em;
++}
++
++.pages-content h6 {
++	font-size: 0.75em;
++}
++
++.pages-content .postimage {
++	-moz-box-sizing: border-box;
++	-webkit-box-sizing: border-box;
++	box-sizing: border-box;
++	max-width: 100%;
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/textreparser/cron_text_reparser_factory.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/textreparser/cron_text_reparser_factory.php"
+deleted file mode 100644
+index 04f166369..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/textreparser/cron_text_reparser_factory.php"
++++ /dev/null
+@@ -1,90 +0,0 @@
+-<?php
+-/**
+- *
+- * Pages extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace phpbb\pages\textreparser;
+-
+-/**
+- * Factory for creating cron text reparser task instances
+- *
+- * This factory handles the dynamic creation of text reparser tasks,
+- * ensuring compatibility with different phpBB versions by using reflection
+- * to determine and provide the correct constructor arguments.
+- */
+-class cron_text_reparser_factory
+-{
+-	/**
+-	 * Creates a new instance of the text reparser cron task
+-	 *
+-	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container Service container
+-	 * @return \phpbb\cron\task\text_reparser\reparser Configured a text reparser cron task
+-	 * @throws \ReflectionException If the reparser class cannot be reflected
+-	 */
+-	public function create($container)
+-	{
+-		$args = $this->get_constructor_arguments($container);
+-
+-		// Using ReflectionClass to instantiate with a variable number of arguments
+-		$reflection = new \ReflectionClass(\phpbb\cron\task\text_reparser\reparser::class);
+-		$reparser = $reflection->newInstanceArgs($args);
+-
+-		$reparser->set_name('cron.task.text_reparser.phpbb_pages');
+-		$reparser->set_reparser('phpbb.pages.text_reparser.page_text');
+-		return $reparser;
+-	}
+-
+-	/**
+-	 * Gets the constructor arguments for the reparser based on reflection
+-	 *
+-	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container Service container
+-	 * @return array Array of constructor arguments
+-	 * @throws \ReflectionException If the reparser class cannot be reflected
+-	 */
+-	private function get_constructor_arguments($container)
+-	{
+-		$reflection = new \ReflectionClass(\phpbb\cron\task\text_reparser\reparser::class);
+-		$constructor = $reflection->getConstructor();
+-		$params = $constructor->getParameters();
+-
+-		$arguments = array();
+-		foreach ($params as $param)
+-		{
+-			$service_name = $this->get_service_name($param->getName());
+-			if ($container->has($service_name))
+-			{
+-				$arguments[] = $container->get($service_name);
+-			}
+-			else if ($param->isOptional())
+-			{
+-				$arguments[] = $param->getDefaultValue();
+-			}
+-		}
+-
+-		return $arguments;
+-	}
+-
+-	/**
+-	 * Maps parameter names to their corresponding service IDs
+-	 *
+-	 * @param string $param_name Name of the parameter from the constructor
+-	 * @return string Service ID corresponding to the parameter
+-	 */
+-	private function get_service_name($param_name)
+-	{
+-		$serviceMap = [
+-			'config'				=> 'config',
+-			'config_text'		=> 'config_text',
+-			'reparse_lock'		=> 'text_reparser.lock',
+-			'reparser_manager'	=> 'text_reparser.manager',
+-			'reparsers'			=> 'text_reparser_collection'
+-		];
+-
+-		return $serviceMap[$param_name] ?? $param_name;
+-	}
+-}
diff --git "[FORUM_EXT]/phpbb\\pages/diff_nospace.tmp" "[FORUM_EXT]/phpbb\\pages/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/diff_nospace.tmp"
@@ -0,0 +1,1910 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
+index 1a22e5370..df78069fb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
+@@ -2,12 +2,6 @@
+ 
+ ## Version 3.x (for phpBB 3.3 and later)
+ 
+-### 3.0.1 - 2025-06-04
+-
+-- Added pagination to the Pages list in the Admin Control Panel for improved usability.
+-- Resolved potential URL path issues on Windows-based web servers.
+-- Updated version constraints to prevent installation on phpBB4, while ensuring it doesn’t cause errors if run within phpBB4.
+-
+ ### 3.0.0 - 2022-06-17
+ 
+ - Dropped support for phpBB 3.2.x (new minimum requirements: phpBB 3.3.2 and PHP 7.1.3).
+@@ -24,8 +18,8 @@
+ 
+ ### 2.0.4 - 2020-03-29
+ 
+-- New option to display page titles before the site name in browser windows.
+-- Fixed links to the FontAwesome website.
++- New option to display page's titles before the site name in browser windows.
++- Fixed links to FontAwesome website.
+ - Removed Subsilver2 style and support.
+ 
+ ### 2.0.3 - 2018-03-14
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
+index ebc2e6179..b071fd785 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
+@@ -53,14 +53,14 @@ class pages_module
+ 		$this->tpl_name = 'manage_pages';
+ 
+ 		// Set the page title for our ACP page
+-		$this->page_title = 'ACP_PAGES_MANAGE';
++		$this->page_title = $lang->lang('ACP_PAGES_MANAGE');
+ 
+ 		// Perform any actions submitted by the user
+ 		switch ($action)
+ 		{
+ 			case 'add':
+ 				// Set the page title for our ACP page
+-				$this->page_title = 'ACP_PAGES_CREATE_PAGE';
++				$this->page_title = $lang->lang('ACP_PAGES_CREATE_PAGE');
+ 
+ 				// Load the add page handle in the admin controller
+ 				$admin_controller->add_page();
+@@ -71,7 +71,7 @@ class pages_module
+ 
+ 			case 'edit':
+ 				// Set the page title for our ACP page
+-				$this->page_title = 'ACP_PAGES_EDIT_PAGE';
++				$this->page_title = $lang->lang('ACP_PAGES_EDIT_PAGE');
+ 
+ 				// Load the edit page handle in the admin controller
+ 				$admin_controller->edit_page($page_id);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
+index 33555df30..48a00baa7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
+@@ -152,12 +152,6 @@
+ 		</fieldset>
+ 	</form>
+ 
+-	{% if pagination %}
+-	<div class="pagination top-pagination">
+-		{% include 'pagination.html' %}
+-	</div>
+-	{% endif %}
+-
+ 	<table class="table1 zebra-table fixed-width-table">
+ 		<thead>
+ 			<tr>
+@@ -199,12 +193,6 @@
+ 		</tbody>
+ 	</table>
+ 
+-	{% if pagination %}
+-	<div class="pagination">
+-		{% include 'pagination.html' %}
+-	</div>
+-	{% endif %}
+-
+ 	<form id="pages_add_page" method="post" action="{{ U_ACTION }}">
+ 		<fieldset class="quick">
+ 			<input class="button2" type="submit" name="addpage" value="{{ lang('ACP_PAGES_CREATE_PAGE') }}" />
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
+index 50274d451..bfb000835 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "An extension which allows you to add static pages to your phpBB forum",
+     "homepage": "https://www.phpbb.com/customise/db/extension/pages/",
+-    "version": "3.0.1",
++    "version": "3.0.0",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -56,15 +56,15 @@
+     "require": {
+         "php": ">=7.1.3",
+         "composer/installers": "~1.0.0",
+-        "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
++        "phpbb/phpbb": ">=3.3.2"
+     },
+     "require-dev": {
+-        "phing/phing": "~2.4"
++        "phing/phing": "2.4.*"
+     },
+     "extra": {
+         "display-name": "Pages",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
++            "phpbb/phpbb": ">=3.3.2"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
+index 5dd73e6c5..4f124883b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
+@@ -81,13 +81,16 @@ services:
+         tags:
+             - { name: text_reparser.plugin }
+ 
+-    phpbb.pages.cron.task.text_reparser.factory:
+-        class: phpbb\pages\textreparser\cron_text_reparser_factory
+-
+     phpbb.pages.cron.task.text_reparser:
+         class: phpbb\cron\task\text_reparser\reparser
+-        factory: ['@phpbb.pages.cron.task.text_reparser.factory', 'create']
+         arguments:
+-            - '@service_container'
++            - '@config'
++            - '@config_text'
++            - '@text_reparser.lock'
++            - '@text_reparser.manager'
++            - '@text_reparser_collection'
++        calls:
++            - [set_name, [cron.task.text_reparser.phpbb_pages]]
++            - [set_reparser, [phpbb.pages.text_reparser.page_text]]
+         tags:
+             - { name: cron.task }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
+index 0676e26e0..ef51a2c8d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
+@@ -97,14 +97,8 @@ class admin_controller implements admin_interface
+ 	*/
+ 	public function display_pages()
+ 	{
+-		/* @var $pagination \phpbb\pagination */
+-		$pagination = $this->container->get('pagination');
+-		$start		= $this->request->variable('start', 0);
+-		$total		= $this->page_operator->get_total_pages();
+-		$limit		= 25;
+-
+ 		// Grab all the pages from the db
+-		$entities = $this->page_operator->get_pages($limit, $start);
++		$entities = $this->page_operator->get_pages();
+ 
+ 		// Process each page entity for display
+ 		/* @var $entity \phpbb\pages\entity\page */
+@@ -127,8 +121,6 @@ class admin_controller implements admin_interface
+ 			));
+ 		}
+ 
+-		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, $limit, $start);
+-
+ 		// Set output vars for display in the template
+ 		$this->template->assign_vars(array(
+ 			'U_ACTION'		=> $this->u_action,
+@@ -336,7 +328,7 @@ class admin_controller implements admin_interface
+ 		* @event phpbb.pages.acp_add_edit_page
+ 		* @since 1.0.0-RC1
+ 		*/
+-		$this->dispatcher->trigger_event('phpbb.pages.acp_add_edit_page');
++		$this->dispatcher->dispatch('phpbb.pages.acp_add_edit_page');
+ 
+ 		// Set template vars for Page Template select menu
+ 		$this->create_page_template_options($entity->get_template());
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/main_controller.php"
+index d0638b533..0ea35000d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/main_controller.php"
+@@ -90,7 +90,6 @@ class main_controller implements main_interface
+ 		));
+ 
+ 		// Send all data to the template file
+-		// We do not use @phpbb_pages to allow templates from outside the extension
+ 		return $this->helper->render($page->get_template(), $page_title);
+ 	}
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp"
+new file mode 100644
+index 000000000..276153a74
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp"
+@@ -0,0 +1,1807 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
++index 1a22e5370..df78069fb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
++@@ -2,12 +2,6 @@
++ 
++ ## Version 3.x (for phpBB 3.3 and later)
++ 
++-### 3.0.1 - 2025-06-04
++-
++-- Added pagination to the Pages list in the Admin Control Panel for improved usability.
++-- Resolved potential URL path issues on Windows-based web servers.
++-- Updated version constraints to prevent installation on phpBB4, while ensuring it doesn’t cause errors if run within phpBB4.
++-
++ ### 3.0.0 - 2022-06-17
++ 
++ - Dropped support for phpBB 3.2.x (new minimum requirements: phpBB 3.3.2 and PHP 7.1.3).
++@@ -24,8 +18,8 @@
++ 
++ ### 2.0.4 - 2020-03-29
++ 
++-- New option to display page titles before the site name in browser windows.
++-- Fixed links to the FontAwesome website.
+++- New option to display page's titles before the site name in browser windows.
+++- Fixed links to FontAwesome website.
++ - Removed Subsilver2 style and support.
++ 
++ ### 2.0.3 - 2018-03-14
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
++index ebc2e6179..b071fd785 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
++@@ -53,14 +53,14 @@ class pages_module
++ 		$this->tpl_name = 'manage_pages';
++ 
++ 		// Set the page title for our ACP page
++-		$this->page_title = 'ACP_PAGES_MANAGE';
+++		$this->page_title = $lang->lang('ACP_PAGES_MANAGE');
++ 
++ 		// Perform any actions submitted by the user
++ 		switch ($action)
++ 		{
++ 			case 'add':
++ 				// Set the page title for our ACP page
++-				$this->page_title = 'ACP_PAGES_CREATE_PAGE';
+++				$this->page_title = $lang->lang('ACP_PAGES_CREATE_PAGE');
++ 
++ 				// Load the add page handle in the admin controller
++ 				$admin_controller->add_page();
++@@ -71,7 +71,7 @@ class pages_module
++ 
++ 			case 'edit':
++ 				// Set the page title for our ACP page
++-				$this->page_title = 'ACP_PAGES_EDIT_PAGE';
+++				$this->page_title = $lang->lang('ACP_PAGES_EDIT_PAGE');
++ 
++ 				// Load the edit page handle in the admin controller
++ 				$admin_controller->edit_page($page_id);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
++index 33555df30..48a00baa7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
++@@ -152,12 +152,6 @@
++ 		</fieldset>
++ 	</form>
++ 
++-	{% if pagination %}
++-	<div class="pagination top-pagination">
++-		{% include 'pagination.html' %}
++-	</div>
++-	{% endif %}
++-
++ 	<table class="table1 zebra-table fixed-width-table">
++ 		<thead>
++ 			<tr>
++@@ -199,12 +193,6 @@
++ 		</tbody>
++ 	</table>
++ 
++-	{% if pagination %}
++-	<div class="pagination">
++-		{% include 'pagination.html' %}
++-	</div>
++-	{% endif %}
++-
++ 	<form id="pages_add_page" method="post" action="{{ U_ACTION }}">
++ 		<fieldset class="quick">
++ 			<input class="button2" type="submit" name="addpage" value="{{ lang('ACP_PAGES_CREATE_PAGE') }}" />
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
++index 50274d451..bfb000835 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "An extension which allows you to add static pages to your phpBB forum",
++     "homepage": "https://www.phpbb.com/customise/db/extension/pages/",
++-    "version": "3.0.1",
+++    "version": "3.0.0",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -56,15 +56,15 @@
++     "require": {
++         "php": ">=7.1.3",
++         "composer/installers": "~1.0.0",
++-        "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
+++        "phpbb/phpbb": ">=3.3.2"
++     },
++     "require-dev": {
++-        "phing/phing": "~2.4"
+++        "phing/phing": "2.4.*"
++     },
++     "extra": {
++         "display-name": "Pages",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
+++            "phpbb/phpbb": ">=3.3.2"
++         },
++         "version-check": {
++             "host": "www.phpbb.com",
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
++index 5dd73e6c5..4f124883b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
++@@ -81,13 +81,16 @@ services:
++         tags:
++             - { name: text_reparser.plugin }
++ 
++-    phpbb.pages.cron.task.text_reparser.factory:
++-        class: phpbb\pages\textreparser\cron_text_reparser_factory
++-
++     phpbb.pages.cron.task.text_reparser:
++         class: phpbb\cron\task\text_reparser\reparser
++-        factory: ['@phpbb.pages.cron.task.text_reparser.factory', 'create']
++         arguments:
++-            - '@service_container'
+++            - '@config'
+++            - '@config_text'
+++            - '@text_reparser.lock'
+++            - '@text_reparser.manager'
+++            - '@text_reparser_collection'
+++        calls:
+++            - [set_name, [cron.task.text_reparser.phpbb_pages]]
+++            - [set_reparser, [phpbb.pages.text_reparser.page_text]]
++         tags:
++             - { name: cron.task }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
++index 0676e26e0..ef51a2c8d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
++@@ -97,14 +97,8 @@ class admin_controller implements admin_interface
++ 	*/
++ 	public function display_pages()
++ 	{
++-		/* @var $pagination \phpbb\pagination */
++-		$pagination = $this->container->get('pagination');
++-		$start		= $this->request->variable('start', 0);
++-		$total		= $this->page_operator->get_total_pages();
++-		$limit		= 25;
++-
++ 		// Grab all the pages from the db
++-		$entities = $this->page_operator->get_pages($limit, $start);
+++		$entities = $this->page_operator->get_pages();
++ 
++ 		// Process each page entity for display
++ 		/* @var $entity \phpbb\pages\entity\page */
++@@ -127,8 +121,6 @@ class admin_controller implements admin_interface
++ 			));
++ 		}
++ 
++-		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, $limit, $start);
++-
++ 		// Set output vars for display in the template
++ 		$this->template->assign_vars(array(
++ 			'U_ACTION'		=> $this->u_action,
++@@ -336,7 +328,7 @@ class admin_controller implements admin_interface
++ 		* @event phpbb.pages.acp_add_edit_page
++ 		* @since 1.0.0-RC1
++ 		*/
++-		$this->dispatcher->trigger_event('phpbb.pages.acp_add_edit_page');
+++		$this->dispatcher->dispatch('phpbb.pages.acp_add_edit_page');
++ 
++ 		// Set template vars for Page Template select menu
++ 		$this->create_page_template_options($entity->get_template());
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/main_controller.php"
++index d0638b533..0ea35000d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/main_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/main_controller.php"
++@@ -90,7 +90,6 @@ class main_controller implements main_interface
++ 		));
++ 
++ 		// Send all data to the template file
++-		// We do not use @phpbb_pages to allow templates from outside the extension
++ 		return $this->helper->render($page->get_template(), $page_title);
++ 	}
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp"
++new file mode 100644
++index 000000000..9182ceb16
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/diff_full.tmp"
++@@ -0,0 +1,185 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
+++index 1a22e5370..df78069fb 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/CHANGELOG.md"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/CHANGELOG.md"
+++@@ -2,12 +2,6 @@
+++ 
+++ ## Version 3.x (for phpBB 3.3 and later)
+++ 
+++-### 3.0.1 - 2025-06-04
+++-
+++-- Added pagination to the Pages list in the Admin Control Panel for improved usability.
+++-- Resolved potential URL path issues on Windows-based web servers.
+++-- Updated version constraints to prevent installation on phpBB4, while ensuring it doesn’t cause errors if run within phpBB4.
+++-
+++ ### 3.0.0 - 2022-06-17
+++ 
+++ - Dropped support for phpBB 3.2.x (new minimum requirements: phpBB 3.3.2 and PHP 7.1.3).
+++@@ -24,8 +18,8 @@
+++ 
+++ ### 2.0.4 - 2020-03-29
+++ 
+++-- New option to display page titles before the site name in browser windows.
+++-- Fixed links to the FontAwesome website.
++++- New option to display page's titles before the site name in browser windows.
++++- Fixed links to FontAwesome website.
+++ - Removed Subsilver2 style and support.
+++ 
+++ ### 2.0.3 - 2018-03-14
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
+++index ebc2e6179..b071fd785 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/acp/pages_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/acp/pages_module.php"
+++@@ -53,14 +53,14 @@ class pages_module
+++ 		$this->tpl_name = 'manage_pages';
+++ 
+++ 		// Set the page title for our ACP page
+++-		$this->page_title = 'ACP_PAGES_MANAGE';
++++		$this->page_title = $lang->lang('ACP_PAGES_MANAGE');
+++ 
+++ 		// Perform any actions submitted by the user
+++ 		switch ($action)
+++ 		{
+++ 			case 'add':
+++ 				// Set the page title for our ACP page
+++-				$this->page_title = 'ACP_PAGES_CREATE_PAGE';
++++				$this->page_title = $lang->lang('ACP_PAGES_CREATE_PAGE');
+++ 
+++ 				// Load the add page handle in the admin controller
+++ 				$admin_controller->add_page();
+++@@ -71,7 +71,7 @@ class pages_module
+++ 
+++ 			case 'edit':
+++ 				// Set the page title for our ACP page
+++-				$this->page_title = 'ACP_PAGES_EDIT_PAGE';
++++				$this->page_title = $lang->lang('ACP_PAGES_EDIT_PAGE');
+++ 
+++ 				// Load the edit page handle in the admin controller
+++ 				$admin_controller->edit_page($page_id);
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
+++index 33555df30..48a00baa7 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/adm/style/manage_pages.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/adm/style/manage_pages.html"
+++@@ -152,12 +152,6 @@
+++ 		</fieldset>
+++ 	</form>
+++ 
+++-	{% if pagination %}
+++-	<div class="pagination top-pagination">
+++-		{% include 'pagination.html' %}
+++-	</div>
+++-	{% endif %}
+++-
+++ 	<table class="table1 zebra-table fixed-width-table">
+++ 		<thead>
+++ 			<tr>
+++@@ -199,12 +193,6 @@
+++ 		</tbody>
+++ 	</table>
+++ 
+++-	{% if pagination %}
+++-	<div class="pagination">
+++-		{% include 'pagination.html' %}
+++-	</div>
+++-	{% endif %}
+++-
+++ 	<form id="pages_add_page" method="post" action="{{ U_ACTION }}">
+++ 		<fieldset class="quick">
+++ 			<input class="button2" type="submit" name="addpage" value="{{ lang('ACP_PAGES_CREATE_PAGE') }}" />
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
+++index 50274d451..bfb000835 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/composer.json"
+++@@ -3,7 +3,7 @@
+++     "type": "phpbb-extension",
+++     "description": "An extension which allows you to add static pages to your phpBB forum",
+++     "homepage": "https://www.phpbb.com/customise/db/extension/pages/",
+++-    "version": "3.0.1",
++++    "version": "3.0.0",
+++     "keywords": [
+++         "phpbb",
+++         "extension",
+++@@ -56,15 +56,15 @@
+++     "require": {
+++         "php": ">=7.1.3",
+++         "composer/installers": "~1.0.0",
+++-        "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
++++        "phpbb/phpbb": ">=3.3.2"
+++     },
+++     "require-dev": {
+++-        "phing/phing": "~2.4"
++++        "phing/phing": "2.4.*"
+++     },
+++     "extra": {
+++         "display-name": "Pages",
+++         "soft-require": {
+++-            "phpbb/phpbb": ">=3.3.2,<4.0.0@dev"
++++            "phpbb/phpbb": ">=3.3.2"
+++         },
+++         "version-check": {
+++             "host": "www.phpbb.com",
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
+++index 5dd73e6c5..4f124883b 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/config/services.yml"
+++@@ -81,13 +81,16 @@ services:
+++         tags:
+++             - { name: text_reparser.plugin }
+++ 
+++-    phpbb.pages.cron.task.text_reparser.factory:
+++-        class: phpbb\pages\textreparser\cron_text_reparser_factory
+++-
+++     phpbb.pages.cron.task.text_reparser:
+++         class: phpbb\cron\task\text_reparser\reparser
+++-        factory: ['@phpbb.pages.cron.task.text_reparser.factory', 'create']
+++         arguments:
+++-            - '@service_container'
++++            - '@config'
++++            - '@config_text'
++++            - '@text_reparser.lock'
++++            - '@text_reparser.manager'
++++            - '@text_reparser_collection'
++++        calls:
++++            - [set_name, [cron.task.text_reparser.phpbb_pages]]
++++            - [set_reparser, [phpbb.pages.text_reparser.page_text]]
+++         tags:
+++             - { name: cron.task }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
+++index 0676e26e0..ef51a2c8d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller/admin_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/controller/admin_controller.php"
+++@@ -97,14 +97,8 @@ class admin_controller implements admin_interface
+++ 	*/
+++ 	public function display_pages()
+++ 	{
+++-		/* @var $pagination \phpbb\pagination */
+++-		$pagination = $this->container->get('pagination');
+++-		$start		= $this->request->variable('start', 0);
+++-		$total		= $this->page_operator->get_total_pages();
+++-		$limit		= 25;
+++-
+++ 		// Grab all the pages from the db
+++-		$entities = $this->page_operator->get_pages($limit, $start);
++++		$entities = $this->page_operator->get_pages();
+++ 
+++ 		// Process each page entity for display
+++ 		/* @var $entity \phpbb\pages\entity\page */
+++@@ -127,8 +121,6 @@ class admin_controller implements admin_interface
+++ 			));
+++ 		}
+++ 
+++-		$pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, $limit, $start);
+++-
+++ 		// Set output vars for display in the template
+++ 		$this->template->assign_vars(array(
+++ 			'U_ACTION'		=> $this->u_action,
+++@@ -336,7 +328,7 @@ class admin_controller implements admin_interface
+++ 		* @event phpbb.pages.acp_add_edit_page
+++ 		* @since 1.0.0-RC1
+++ 		*/
+++-		$this->dispatcher->trigger_event('phpbb.pages.acp_add_edit_page');
++++		$this->dispatcher->dispatch('phpbb.pages.acp_add_edit_page');
+++ 
+++ 		// Set template vars for Page Template select menu
+++ 		$this->create_page_template_options($entity->get_template());
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/controller
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/entity/page.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/entity/page.php"
++index 021c99d0c..cd077eafa 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/entity/page.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/entity/page.php"
++@@ -481,7 +481,7 @@ class page implements page_interface
++ 	*/
++ 	public function get_template()
++ 	{
++-		return !empty($this->data['page_template']) ? (string) $this->data['page_template'] : 'pages_default.html';
+++		return (!empty($this->data['page_template'])) ? (string) $this->data['page_template'] : 'pages_default.html';
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/event/listener.php"
++index a2154eb2a..bc9bc552d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/event/listener.php"
++@@ -146,7 +146,7 @@ class listener implements EventSubscriberInterface
++ 			// If any of our pages are being viewed, update the event vars with our routes and titles
++ 			foreach ($page_routes as $page_id => $page_data)
++ 			{
++-				if ($event['row']['session_page'] === 'app.' . $this->php_ext . '/' . $page_data['route'])
+++				if ($event['row']['session_page'] === 'app.' . $this->php_ext . DIRECTORY_SEPARATOR . $page_data['route'])
++ 				{
++ 					$event['location'] = $this->lang->lang('PAGES_VIEWONLINE', $page_data['title']);
++ 					$event['location_url'] = $this->helper->route('phpbb_pages_dynamic_route_' . $page_id);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/ext.php"
++index dfb75448a..f133572d6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/ext.php"
++@@ -26,14 +26,12 @@ class ext extends \phpbb\extension\base
++ 	 * the minimum version required by this extension:
++ 	 *
++ 	 * Requires phpBB 3.3.2 due to using role_exists check in permission migration.
++-	 * Not compatible with phpBB 4.0.0-dev due to using updated classes.
++ 	 *
++ 	 * @return bool
++ 	 * @access public
++ 	 */
++ 	public function is_enableable()
++ 	{
++-		return phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=')
++-			&& phpbb_version_compare(PHPBB_VERSION, '4.0.0-dev', '<');
+++		return phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=');
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/es/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/es/pages_acp.php"
++index 62df4451a..b9d7576e8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/es/pages_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/es/pages_acp.php"
++@@ -80,7 +80,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Esto es un campo requerido.',
++ 	'ACP_PAGES_FORM_DESC'				=> 'Descripción de la página',
++ 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Esto solo se mostrará en la lista de páginas del PCA.',
++-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título del enlace',
+++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
++ 	'ACP_PAGES_FORM_ROUTE'				=> 'Ruta URL de la página',
++ 	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'La <strong>ruta</strong> es un identificador único utilizado al final de la URL de una página para definir el vínculo a la página, por ejemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Sólo se admiten letras, números, guiones y guiones bajos. Este es un campo obligatorio.',
++ 	'ACP_PAGES_FORM_CONTENT'			=> 'Contenido de la página',
++@@ -99,8 +99,8 @@ $lang = array_merge($lang, array(
++ 	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página a invitados',
++ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Si se establece en no, sólo los usuarios registrados podrán acceder a la página.',
++ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Enlace de la página',
++-	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar el título de la página primero',
++-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'De forma predeterminada, los navegadores mostrarán el título de esta página después del nombre del sitio <samp style="white-space: nowrap">“Nombre del sitio - Titulo de la página”</samp>. Habilitar esta opción mostrará el título de esta página antes del nombre del sitio <samp style="white-space: nowrap">“Título de la página - Nombre del sitio”</samp>.',
+++	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
++ 	'PARSE_HTML'						=> 'Reconocer HTML',
++ 
++ 	// Page link location names
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/exceptions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/exceptions.php"
++index 829dcd100..92ebc25eb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/exceptions.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/exceptions.php"
++@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -35,7 +35,7 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ’ « » “ ” …
+++// ’ » “ ” …
++ //
++ 
++ /*
++@@ -48,7 +48,7 @@ if (empty($lang) || !is_array($lang))
++ *
++ * Translators: Feel free to not translate these language strings
++ */
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	'EXCEPTION_FIELD_MISSING'		=> 'Un champ obligatoire est manquant',
++ 	'EXCEPTION_INVALID_ARGUMENT'	=> 'Argument spécifié incorrect pour `%1$s`. Motif : %2$s',
++ 	'EXCEPTION_OUT_OF_BOUNDS'		=> 'Le champ `%1$s` a reçu une donnée incohérente',
++@@ -56,4 +56,4 @@ $lang = array_merge($lang, [
++ 	'EXCEPTION_NOT_UNIQUE'			=> 'La donnée n’était pas unique.',
++ 	'EXCEPTION_UNEXPECTED_VALUE'	=> 'Le champ `%1$s` a reçu une donnée inattendue. Motif : %2$s',
++ 	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'La donnée contenait des caractères interdits.',
++-]);
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/info_acp_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/info_acp_pages.php"
++index 68ebdd809..1d4afd1fd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/info_acp_pages.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/info_acp_pages.php"
++@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -35,10 +35,10 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ’ « » “ ” …
+++// ’ » “ ” …
++ //
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	// ACP modules
++ 	'ACP_PAGES'				=> 'Pages',
++ 	'ACP_PAGES_MANAGE'		=> 'Gestion de Pages',
++@@ -47,4 +47,4 @@ $lang = array_merge($lang, [
++ 	'ACP_PAGES_ADDED_LOG'	=> '<strong>Page ajoutée</strong><br />» %s',
++ 	'ACP_PAGES_EDITED_LOG'	=> '<strong>Page modifiée</strong><br />» %s',
++ 	'ACP_PAGES_DELETED_LOG'	=> '<strong>Page supprimée</strong><br />» %s',
++-]);
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_acp.php"
++index e52b23f80..e2c847c9d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_acp.php"
++@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -35,23 +35,23 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ’ « » “ ” …
+++// ’ » “ ” …
++ //
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	// Manage page
++ 	'ACP_PAGES_MANAGE'					=> 'Gestion des Pages',
++ 	'ACP_PAGES_MANAGE_EXPLAIN'			=> 'Depuis cette page vous pouvez ajouter, modifier et supprimer des pages personnalisées.',
++ 	'ACP_PAGES_CREATE_PAGE'				=> 'Créer une page',
++-	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez ajouter une nouvelle page personnalisée à votre forum.',
+++	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez ajouter une nouvelle page personnalisée pour votre forum.',
++ 	'ACP_PAGES_EDIT_PAGE'				=> 'Modifier une page',
++-	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez modifier une page personnalisée existante de votre forum.',
+++	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez modifier une page personnalisée existante pour votre forum.',
++ 
++ 	// Display pages list
++ 	'ACP_PAGES_TITLE'					=> 'Titre',
++ 	'ACP_PAGES_DESCRIPTION'				=> 'Description',
++ 	'ACP_PAGES_ROUTE'					=> 'Chemin',
++-	'ACP_PAGES_TEMPLATE'				=> 'Modèle',
+++	'ACP_PAGES_TEMPLATE'				=> 'Template',
++ 	'ACP_PAGES_ORDER'					=> 'Ordre',
++ 	'ACP_PAGES_LINK'					=> 'Lien',
++ 	'ACP_PAGES_VIEW'					=> 'Voir la page',
++@@ -80,28 +80,28 @@ $lang = array_merge($lang, [
++ 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Ce champ est obligatoire.',
++ 	'ACP_PAGES_FORM_DESC'				=> 'Description de la page',
++ 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Cette description ne sera affichée que dans la rubrique « Gestion des Pages » du PCA.',
++-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Utiliser comme titre de lien',
++-	'ACP_PAGES_FORM_ROUTE'				=> 'Route de l’URL de la page',
++-	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'Une version simplifiée du nom de la page, utilisée pour construire l’URL de cette dernière. Exemple : <samp>http://www.phpbb.com/<strong>nom-de-la-page</strong></samp>. Seuls sont autorisés les lettres, chiffres, traits d’union et tirets bas. Ce champ est obligatoire.',
+++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
+++	'ACP_PAGES_FORM_ROUTE'				=> 'Chemin de la page',
+++	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'Le <strong>chemin</strong> est un identifiant unique utilisé à la fin de l’adresse URL d’une page pour en définir le lien vers cette dernière. Exemple : <samp>http://www.phpbb.com/<strong>route</strong></samp>. Seuls sont autorisés les lettres, chiffres, traits d’union et tirets bas. Ce champ est obligatoire.',
++ 	'ACP_PAGES_FORM_CONTENT'			=> 'Contenu de la page',
++-	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Le contenu peut être créé en utilisant les BBCodes, les smileys et les urls magiques de phpBB ou vous pouvez activer le mode HTML. En mode HTML, les BBCodes, les smileys et les urls magiques ne fonctionneront pas, mais vous êtes libre d’utiliser n’importe quelle syntaxe HTML valide. Veuillez noter que ce contenu sera ajouté à un modèle HTML existant, vous ne devez donc pas inclure les balises DOCTYPE, HTML, BODY ou HEAD. Cependant, toutes les autres balises de formatage HTML, y compris IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc. peuvent être utilisées.',
++-	'ACP_PAGES_FORM_TEMPLATE'			=> 'Modèle de la page',
++-	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Les modèles des pages personnalisées, sont nommés <samp>pages_*.html</samp> et peuvent être ajoutés dans les répertoires <samp>./styles/*/template</samp> de phpBB.',
++-	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Sélectionner un modèle',
+++	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Le contenu peut être créé en faisant usage des BBCodes par défaut de phpBB, les smileys et les adresses URL magiques ou bien en activant le mode HTML. Avec le mode HTML, les BBCodes, smileys et adresses URL magiques ne fonctionneront pas, mais vous pouvez utiliser toute syntaxe HTML valide. Veuillez prendre note que ce contenu sera intégré dans un template HTML existant. Ainsi, nul besoin d’insérer les tags DOCTYPE, HTML, BODY ou HEAD. Néanmoins, tous les autres tags de mise en forme peuvent être utilisés, incluant IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc..',
+++	'ACP_PAGES_FORM_TEMPLATE'			=> 'Template de la page',
+++	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Les templates des pages personnalisées, sont nommés <samp>pages_*.html</samp> et peuvent être ajoutés dans les répertoires <samp>./styles/*/template</samp> de phpBB.',
+++	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Sélectionner un template',
++ 	'ACP_PAGES_FORM_ORDER'				=> 'Ordre de la page',
++ 	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'Les pages seront triées selon ce champ, permettant ainsi d’organiser l’ordre dans lequel vous souhaitez que leurs liens apparaissent. Les plus petits nombres seront affichés avant les plus grands.',
++-	'ACP_PAGES_FORM_LINKS'				=> 'Emplacements du lien de la page',
+++	'ACP_PAGES_FORM_LINKS'				=> 'Emplacements pour le lien de la page',
++ 	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Sélectionne un ou plusieurs emplacements où le lien de cette page apparaitra. Utilisez CTRL+CLICK (ou CMD + CLICK sur Mac) pour (dé)sélectionner plus d’un item.',
++ 	'ACP_PAGES_FORM_ICON_FONT'			=> 'Icône du lien de la page',
++-	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Permet de saisir le nom de l’icône provenant de la police de caractères <strong><a href="%s" target="_blank">Font Awesome</a></strong> qui sera utilisée pour le lien de cette page. Laisser ce champ vide pour utiliser l’icône par défaut CSS/GIF.',
+++	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Permet de saisir le nom de l’icône provenant de la police de caractères <strong><a href="%s" target="_blank">Font Awesome</a></strong> qui sera utilisée pour le lien de cette page. Laisser ce champ vide pour utiliser l’image icône par défaut CSS/GIF.',
++ 	'ACP_PAGES_FORM_DISPLAY'			=> 'Afficher la page',
++ 	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Si défini sur non, la page ne sera pas accessible aux utilisateurs néanmoins les administrateurs y auront accès, leur permettant d’avoir un aperçu pendant la création.',
++ 	'ACP_PAGES_FORM_GUESTS'				=> 'Afficher la page aux invités',
++ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Si défini sur non, seuls les utilisateurs enregistrés pourront accéder à la page.',
++ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Lien de la page',
++-	'ACP_PAGES_TITLE_SWITCH'			=> 'Afficher le titre de la page en premier',
++-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'Par défaut, les navigateurs affichent le titre de cette page après le nom du site <samp style="white-space : nowrap">« Nom du site - Titre de la page »</samp>. En activant cette option, le titre de cette page sera affiché avant le nom du site <samp style="white-space : nowrap">« Titre de la page - Nom du site »</samp>.',
++-	'PARSE_HTML'						=> 'Analyser le HTML',
+++	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+++	'PARSE_HTML'						=> 'Parser le HTML',
++ 
++ 	// Page link location names
++ 	'NAV_BAR_LINKS_BEFORE'				=> 'Barre de navigation avant les liens',
++@@ -114,4 +114,4 @@ $lang = array_merge($lang, [
++ 	'FOOTER_TEAMS_AFTER'				=> 'Pied de page après le lien de l’équipe',
++ 	'QUICK_LINK_MENU_BEFORE'			=> 'En haut du menu « Accès rapide »',
++ 	'QUICK_LINK_MENU_AFTER'				=> 'En bas du menu « Accès rapide »',
++-]);
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_common.php"
++index 9062924ce..2dd4877e3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_common.php"
++@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ’ « » “ ” …
+++// ’ » “ ” …
++ //
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	'PAGES_VIEWONLINE'		=> 'Consulte la page %s',
++-]);
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_controller.php"
++index ff7b66009..a5ffd7138 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/pages_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/pages_controller.php"
++@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ’ « » “ ” …
+++// ’ » “ ” …
++ //
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	'PAGE_NOT_AVAILABLE'		=> 'La page « %s » n’est pas disponible.',
++-]);
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/permissions_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/permissions_pages.php"
++index 22d8b1437..c64a00893 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/fr/permissions_pages.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/fr/permissions_pages.php"
++@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ //
++ // Some characters you may want to copy&paste:
++-// ’ « » “ ” …
+++// ’ » “ ” …
++ //
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	'ACL_A_PAGES'		=> 'Peut gérer l’extension Pages',
++-]);
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/it/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/it/pages_acp.php"
++index e074c1b1f..b881f78c2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/it/pages_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/it/pages_acp.php"
++@@ -92,15 +92,15 @@ $lang = array_merge($lang, array(
++ 	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'Le pagine verranno ordinate in base a questo campo, che può aiutare ad organizzare l´ordine in cui appaiono loro collegamenti. I numeri più bassi hanno la precedenza su numeri più alti.',
++ 	'ACP_PAGES_FORM_LINKS'				=> 'Posizione link alla pagina',
++ 	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Selezionare uno o più luoghi in cui il link a questa pagina putrà apparire. Utilizzare Ctrl + clic (o CMD + clic su Mac) per selezionare/deselezionare più di una voce.',
++-	'ACP_PAGES_FORM_ICON_FONT'			=> 'Icona del link della pagina',
++-	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Inserisci il nome di un’icona <strong><a href="%s" target="_blank">Font Awesome</a></strong> per usarla con il link della pagina. Lascia vuoto questo campo per usare le icone tradizionali CSS/GIF delle Pagine.',
+++	'ACP_PAGES_FORM_ICON_FONT'			=> 'Page link icon',
+++	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use with the page link. Leave this field blank to use Pages’ traditional CSS/GIF image icons.',
++ 	'ACP_PAGES_FORM_DISPLAY'			=> 'Visualizza pagina',
++ 	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Se impostato su no, la pagina non sarà accessibile. (Nota: Gli amministratori saranno ancora in grado di accedere alla pagina, permettendo loro di visualizzare in anteprima privatamente la pagina mentre lo sviluppo è ancora in essere.)',
++ 	'ACP_PAGES_FORM_GUESTS'				=> 'Permetti visualizzazione pagina agli ospiti',
++ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se impostato su no, solo gli utenti registrati saranno in grado di accedere alla pagina.',
++ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link alla pagina',
++-	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostra prima il titolo della pagina',
++-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'Per impostazione predefinita i browser mostreranno il titolo di questa pagina dopo il nome del sito <samp style="white-space: nowrap">“Nome del Sito - Titolo della Pagina”</samp>. Abilitare quest’opzione mostrera’ il titolo di questa pagina prima del nome del sito <samp style="white-space: nowrap">“Titolo della Pagina - Nome del Sito”</samp>.',
+++	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
++ 	'PARSE_HTML'						=> 'Analizza HTML',
++ 
++ 	// Page link location names
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/pt/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt/pages_acp.php"
++index de3e33f87..d57145a71 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/language/pt/pages_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt/pages_acp.php"
++@@ -80,7 +80,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Este Campo é obrigatório.',
++ 	'ACP_PAGES_FORM_DESC'				=> 'Descrição da página',
++ 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Apenas será exibido na lista de páginas no ACP.',
++-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
+++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título do endereço',
++ 	'ACP_PAGES_FORM_ROUTE'				=> 'Caminho do URL da página',
++ 	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> '<strong>route</strong> é um identificador exclusivo, usado no final da URL de uma página, para definir o link para a página, por exemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Apenas letras, números, hífens e sublinhados são permitidos. Este campo é obrigatório.',
++ 	'ACP_PAGES_FORM_CONTENT'			=> 'Conteúdo da página',
++@@ -99,7 +99,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página aos visitantes',
++ 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se definido como Não, apenas utilizadores registados poderão aceder à página.',
++ 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link da página',
++-	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+++	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar primeiro o título da página',
++ 	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
++ 	'PARSE_HTML'						=> 'Parse HTML',
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/exceptions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/exceptions.php"
++new file mode 100644
++index 000000000..468ce6770
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/exceptions.php"
++@@ -0,0 +1,59 @@
+++<?php
+++/**
+++*
+++* Pages extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++// DEVELOPERS PLEASE NOTE
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
+++/*
+++* These are errors which can be triggered by sending invalid data to the
+++* pages extension API.
+++*
+++* These errors will never show to a user unless they are either modifying
+++* the core pages extension code OR unless they are writing an extension
+++* which makes calls to this extension.
+++*
+++* Translators: Feel free to not translate these language strings
+++*/
+++$lang = array_merge($lang, array(
+++	'EXCEPTION_FIELD_MISSING'		=> 'Campo obrigatório em falta',
+++	'EXCEPTION_INVALID_ARGUMENT'	=> 'O argumento especificado para `%1$s` é inválido. Razão: %2$s',
+++	'EXCEPTION_OUT_OF_BOUNDS'		=> 'O Campo `%1$s` recebeu dados além do limite',
+++	'EXCEPTION_TOO_LONG'			=> 'A entrada foi maior do que o máximo permitido.',
+++	'EXCEPTION_NOT_UNIQUE'			=> 'A entrada não é única.',
+++	'EXCEPTION_UNEXPECTED_VALUE'	=> 'O campo `%1$s` recebeu dados não previstos. Razão: %2$s',
+++	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'A entrada tem caracteres inválidos.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/info_acp_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/info_acp_pages.php"
++new file mode 100644
++index 000000000..5440a3cbe
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/info_acp_pages.php"
++@@ -0,0 +1,50 @@
+++<?php
+++/**
+++*
+++* Pages extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++// DEVELOPERS PLEASE NOTE
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
+++$lang = array_merge($lang, array(
+++	// ACP modules
+++	'ACP_PAGES'				=> 'Páginas Personalizadas',
+++	'ACP_PAGES_MANAGE'		=> 'Gerir Páginas Personalizadas',
+++
+++	// Logs
+++	'ACP_PAGES_ADDED_LOG'	=> '<strong>Página adicionada</strong><br />» %s',
+++	'ACP_PAGES_EDITED_LOG'	=> '<strong>Página Editada</strong><br />» %s',
+++	'ACP_PAGES_DELETED_LOG'	=> '<strong>Página apagada</strong><br />» %s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_acp.php"
++new file mode 100644
++index 000000000..d57145a71
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_acp.php"
++@@ -0,0 +1,117 @@
+++<?php
+++/**
+++*
+++* Pages extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++// DEVELOPERS PLEASE NOTE
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
+++$lang = array_merge($lang, array(
+++	// Manage page
+++	'ACP_PAGES_MANAGE'					=> 'Gerir Páginas Personalizadas',
+++	'ACP_PAGES_MANAGE_EXPLAIN'			=> 'A partir desta página, pode adicionar, editar e excluir páginas personalizadas.',
+++	'ACP_PAGES_CREATE_PAGE'				=> 'Criar páginas',
+++	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Usando o formulário abaixo, pode criar uma nova página personalizada para o seu Fórum.',
+++	'ACP_PAGES_EDIT_PAGE'				=> 'Editar página',
+++	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Usando o formulário abaixo, pode modificar uma página personalizada existente no seu Fórum.',
+++
+++	// Display pages list
+++	'ACP_PAGES_TITLE'					=> 'Nome',
+++	'ACP_PAGES_DESCRIPTION'				=> 'Descrição',
+++	'ACP_PAGES_ROUTE'					=> 'Route',
+++	'ACP_PAGES_TEMPLATE'				=> 'Template',
+++	'ACP_PAGES_ORDER'					=> 'Ordem',
+++	'ACP_PAGES_LINK'					=> 'Link',
+++	'ACP_PAGES_VIEW'					=> 'Ver página',
+++	'ACP_PAGES_STATUS'					=> 'Estatuto',
+++	'ACP_PAGES_PUBLISHED'				=> 'Publicada',
+++	'ACP_PAGES_PUBLISHED_NO_GUEST'		=> 'Publicada (apenas membros)',
+++	'ACP_PAGES_PRIVATE'					=> 'Privada',
+++	'ACP_PAGES_EMPTY'					=> 'Não há páginas',
+++
+++	// Purge icons
+++	'ACP_PAGES_PURGE_ICONS'				=> 'Limpar icons',
+++	'ACP_PAGES_PURGE_ICONS_LABEL'		=> 'Limpar cache dos icones das páginas',
+++	'ACP_PAGES_PURGE_ICONS_EXPLAIN'		=> 'Ao adicionar links para ícones das páginas personalizadas, tem que limpar a cache de ícones para ver os novos ícones. Coloque os ícones personalizados, usando nomes <samp>pages_route.gif</samp>, onde <samp>route</samp> é nome do caminho da página, na pasta <samp>styles/*/theme/images/</samp>.',
+++
+++	// Messages shown to user
+++	'ACP_PAGES_DELETE_CONFIRM'			=> 'Tem a certeza que deseja eliminar esta página?',
+++	'ACP_PAGES_DELETE_SUCCESS'			=> 'Página eliminada com sucesso.',
+++	'ACP_PAGES_DELETE_ERRORED'			=> 'A página não pode ser eliminada.',
+++	'ACP_PAGES_ADD_SUCCESS'				=> 'Página criada com sucesso.',
+++	'ACP_PAGES_EDIT_SUCCESS'			=> 'Página atualizada com sucesso.',
+++
+++	// Add/edit page
+++	'ACP_PAGES_SETTINGS'				=> 'Configurar página',
+++	'ACP_PAGES_OPTIONS'					=> 'Opções da página',
+++	'ACP_PAGES_FORM_TITLE'				=> 'Título da página',
+++	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Este Campo é obrigatório.',
+++	'ACP_PAGES_FORM_DESC'				=> 'Descrição da página',
+++	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Apenas será exibido na lista de páginas no ACP.',
+++	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título do endereço',
+++	'ACP_PAGES_FORM_ROUTE'				=> 'Caminho do URL da página',
+++	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> '<strong>route</strong> é um identificador exclusivo, usado no final da URL de uma página, para definir o link para a página, por exemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Apenas letras, números, hífens e sublinhados são permitidos. Este campo é obrigatório.',
+++	'ACP_PAGES_FORM_CONTENT'			=> 'Conteúdo da página',
+++	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Na criação do conteúdo pode usar BBCodes phpBB, smilies e urls mágicos ou pode ativar o modo HTML. No modo HTML, os BBCodes, smilies e urls mágicos não funcionam, mas pode usar qualquer sintaxe HTML válida. Tenha em atenção que este conteúdo será mostrado no Template HTML existente, pelo que não deve incluir DOCTYPE, HTML, BODY ou tags HEAD. No entanto podem ser usadas todas as outras tags de formatação HTML, incluindo IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc.',
+++	'ACP_PAGES_FORM_TEMPLATE'			=> 'Template da página',
+++	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Modelos de páginas personalizadas com nomes <samp>pages_*.html</samp> podem ser adicionadas à pasta phpBB’s <samp>styles/*/template</samp>.',
+++	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Selecione um template',
+++	'ACP_PAGES_FORM_ORDER'				=> 'Ordem das páginas',
+++	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'As páginas serão ordenadas de acordo com esta ordem, que pode ajudar a organizar a ordem em que os links aparecem. Os números mais baixos têm precedência sobre os números mais altos.',
+++	'ACP_PAGES_FORM_LINKS'				=> 'Localizações do link da página',
+++	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Selecione um ou mais locais onde serão visíveis links para esta página. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar/desselecionar mais do que um item.',
+++	'ACP_PAGES_FORM_ICON_FONT'			=> 'Page link icon',
+++	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use with the page link. Leave this field blank to use Pages’ traditional CSS/GIF image icons.',
+++	'ACP_PAGES_FORM_DISPLAY'			=> 'Mostrar página',
+++	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Se definido como Não, a página não será visível. (Nota: Administradores podem aceder à página, o que lhes permite pré-visualizá-la enquanto estão a desenvolvê-la.)',
+++	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página aos visitantes',
+++	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se definido como Não, apenas utilizadores registados poderão aceder à página.',
+++	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link da página',
+++	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar primeiro o título da página',
+++	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+++	'PARSE_HTML'						=> 'Parse HTML',
+++
+++	// Page link location names
+++	'NAV_BAR_LINKS_BEFORE'				=> 'Antes dos Links Nav Bar',
+++	'NAV_BAR_LINKS_AFTER'				=> 'Depois dos Links Nav Bar',
+++	'NAV_BAR_CRUMBS_BEFORE'				=> 'Antes dos Breadcrumbs Nav Bar',
+++	'NAV_BAR_CRUMBS_AFTER'				=> 'Depois dos Breadcrumbs Nav Bar',
+++	'FOOTER_TIMEZONE_BEFORE'			=> 'No Rodapé antes da Time Zone',
+++	'FOOTER_TIMEZONE_AFTER'				=> 'No Rodapé depois da Time Zone',
+++	'FOOTER_TEAMS_BEFORE'				=> 'No Rodapé antes da Team Link',
+++	'FOOTER_TEAMS_AFTER'				=> 'No Rodapé depois da Team Link',
+++	'QUICK_LINK_MENU_BEFORE'			=> 'Nos Links rápidos, no inicio',
+++	'QUICK_LINK_MENU_AFTER'				=> 'Nos Links rápidos, no final',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_common.php"
++new file mode 100644
++index 000000000..b6fd73f08
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_common.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* Pages extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++// DEVELOPERS PLEASE NOTE
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
+++$lang = array_merge($lang, array(
+++	'PAGES_VIEWONLINE'		=> 'Vendo %s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_controller.php"
++new file mode 100644
++index 000000000..3efa92007
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/pages_controller.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* Pages extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++// DEVELOPERS PLEASE NOTE
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
+++$lang = array_merge($lang, array(
+++	'PAGE_NOT_AVAILABLE'		=> 'A página solicitada “%s” não está disponível.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/permissions_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/permissions_pages.php"
++new file mode 100644
++index 000000000..82cffa488
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/language/pt_preao/permissions_pages.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* Pages extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++// DEVELOPERS PLEASE NOTE
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
+++$lang = array_merge($lang, array(
+++	'ACL_A_PAGES'		=> 'Pode gerir a extensão Páginas Personalizadas',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page.php"
++index 7f21eb6b0..ea5beda8d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page.php"
++@@ -67,14 +67,12 @@ class page implements page_interface
++ 	}
++ 
++ 	/**
++-	 * Get all pages
++-	 *
++-	 * @param int $limit
++-	 * @param int $start
++-	 * @return array Array of page data entities
++-	 * @access public
++-	 */
++-	public function get_pages($limit = 0, $start = 0)
+++	* Get all pages
+++	*
+++	* @return array Array of page data entities
+++	* @access public
+++	*/
+++	public function get_pages()
++ 	{
++ 		$entities = array();
++ 
++@@ -82,7 +80,7 @@ class page implements page_interface
++ 		$sql = 'SELECT *
++ 			FROM ' . $this->pages_table . '
++ 			ORDER BY page_order ASC, page_id ASC';
++-		$result = $this->db->sql_query_limit($sql, $limit, $start);
+++		$result = $this->db->sql_query($sql);
++ 
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 		{
++@@ -369,23 +367,6 @@ class page implements page_interface
++ 		return $rows;
++ 	}
++ 
++-	/**
++-	 * Get the total number of pages
++-	 *
++-	 * @return int
++-	 * @access public
++-	 */
++-	public function get_total_pages()
++-	{
++-		$sql = 'SELECT COUNT(*) AS pages
++-			FROM ' . $this->pages_table;
++-		$result = $this->db->sql_query($sql);
++-		$pages = $this->db->sql_fetchfield('pages');
++-		$this->db->sql_freeresult($result);
++-
++-		return (int) $pages;
++-	}
++-
++ 	/**
++ 	* Check if a page identifier exists in the database
++ 	*
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page_interface.php"
++index 16c611da7..634b2e638 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\pages/operators/page_interface.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/operators/page_interface.php"
++@@ -13,19 +13,17 @@ namespace phpbb\pages\operators;
++ /**
++ * Interface for our pages operator
++ *
++-* This describes all the methods we'll have for working with a set of pages
+++* This describes all of the methods we'll have for working with a set of pages
++ */
++ interface page_interface
++ {
++ 	/**
++-	 * Get all pages
++-	 *
++-	 * @param int $limit
++-	 * @param int $start
++-	 * @return array Array of page data entities
++-	 * @access public
++-	 */
++-	public function get_pages($limit = 0, $start = 0);
+++	* Get all pages
+++	*
+++	* @return array Array of page data entities
+++	* @access public
+++	*/
+++	public function get_pages();
++ 
++ 	/**
++ 	* Add a page
++@@ -110,12 +108,4 @@ interface page_interface
++ 	* @access public
++ 	*/
++ 	public function get_link_locations();
++-
++-	/**
++-	 * Get the total number of pages
++-	 *
++-	 * @return int
++-	 * @access public
++-	 */
++-	public function get_total_pages();
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
++new file mode 100644
++index 000000000..67282ed61
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
++@@ -0,0 +1,8 @@
+++{# Note: we must use the after code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TEAMLINK_AFTER %}
+++	{% for link in overall_footer_teamlink_after_links %}
+++		<li>
+++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html"
++new file mode 100644
++index 000000000..459e7ba73
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html"
++@@ -0,0 +1,8 @@
+++{# Note: we must use the before code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TEAMLINK_BEFORE %}
+++	{% for link in overall_footer_teamlink_before_links %}
+++		<li>
+++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html"
++new file mode 100644
++index 000000000..b07446556
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html"
++@@ -0,0 +1,8 @@
+++{# Note: we must use the after code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TIMEZONE_AFTER %}
+++	{% for link in overall_footer_timezone_after_links %}
+++		<small>
+++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+++		</small>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html"
++new file mode 100644
++index 000000000..d65f65cfa
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html"
++@@ -0,0 +1,8 @@
+++{# Note: we must use the before code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TIMEZONE_BEFORE %}
+++	{% for link in overall_footer_timezone_before_links %}
+++		<small>
+++			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+++		</small>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html"
++new file mode 100644
++index 000000000..9e18f1c0b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html"
++@@ -0,0 +1,7 @@
+++{% if S_OVERALL_HEADER_BREADCRUMBS_BEFORE %}
+++	{% for link in overall_header_breadcrumbs_before_links %}
+++		<li {$MICRODATA}>
+++			<span itemprop="title"><a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a></span>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html"
++new file mode 100644
++index 000000000..cc3b078f9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html"
++@@ -0,0 +1,7 @@
+++{% if S_OVERALL_HEADER_BREADCRUMBS_AFTER %}
+++	{% for link in overall_header_breadcrumbs_after_links %}
+++		<li {$MICRODATA}>
+++			<span itemprop="title"><a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a></span>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html"
++new file mode 100644
++index 000000000..bdaec372a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html"
++@@ -0,0 +1,9 @@
+++{% if S_OVERALL_HEADER_NAVIGATION_APPEND %}
+++	{% for link in overall_header_navigation_append_links %}
+++		<li>
+++			<a href="{{ link.U_LINK_URL }}">
+++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}"></i>{% endif %}{{ link.LINK_TITLE }}</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html"
++new file mode 100644
++index 000000000..8160ab5c1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html"
++@@ -0,0 +1,9 @@
+++{% if S_OVERALL_HEADER_NAVIGATION_PREPEND %}
+++	{% for link in overall_header_navigation_prepend_links %}
+++		<li>
+++			<a href="{{ link.U_LINK_URL }}">
+++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}"></i>{% endif %}{{ link.LINK_TITLE }}</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_blank.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_blank.html"
++new file mode 100644
++index 000000000..040648506
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_blank.html"
++@@ -0,0 +1,23 @@
+++{# Use the space below to include external CSS and JS files
+++# Here are some example usages:
+++#
+++# local files relative to this template file (when stored inside phpBB's style directories):
+++# {% INCLUDEJS 'script.js' %}
+++# {% INCLUDECSS 'style.css' %}
+++#
+++# local files stored inside the Pages extension:
+++# {% INCLUDEJS '@phpbb_pages/script.js' %}
+++# {% INCLUDECSS '@phpbb_pages/style.cs's %}
+++#
+++# hosted on external sites:
+++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+++#
+++#}
+++{% include 'overall_header.html' %}
+++
+++	{{ PAGE_CONTENT }}
+++
+++{% EVENT phpbb_pages_after_page_content %}
+++
+++{% include 'overall_footer.html' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_default.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_default.html"
++new file mode 100644
++index 000000000..f6ef6a6d7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/BBOOTS/template/pages_default.html"
++@@ -0,0 +1,27 @@
+++{# Use the space below to include external CSS and JS files
+++# Here are some example usages:
+++#
+++# local files relative to this template file (when stored inside phpBB's style directories):
+++# {% INCLUDEJS 'script.js' %}
+++# {% INCLUDECSS 'style.css' %}
+++#
+++# local files stored inside the Pages extension:
+++# {% INCLUDEJS '@phpbb_pages/script.js' %}
+++# {% INCLUDECSS '@phpbb_pages/style.cs's %}
+++#
+++# hosted on external sites:
+++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+++#
+++#}
+++{% include 'overall_header.html' %}
+++
+++<div class="side-segment">
+++	<h3>{PAGE_TITLE}</h3>
+++</div>
+++<div class="well">
+++	{{ PAGE_CONTENT }}
+++</div>
+++{% EVENT phpbb_pages_after_page_content %}
+++
+++{% include 'overall_footer.html' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html"
++new file mode 100644
++index 000000000..093fab1c6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html"
++@@ -0,0 +1,9 @@
+++{% if S_NAVBAR_HEADER_QUICK_LINKS_AFTER %}
+++	{% for link in navbar_header_quick_links_after_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }}"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html"
++new file mode 100644
++index 000000000..1033526bd
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html"
++@@ -0,0 +1,9 @@
+++{% if S_NAVBAR_HEADER_QUICK_LINKS_BEFORE %}
+++	{% for link in navbar_header_quick_links_before_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }}"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
++new file mode 100644
++index 000000000..8eaf3e550
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
++@@ -0,0 +1,10 @@
+++{# Note: we must use the before code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TEAMLINK_BEFORE %}
+++	{% for link in overall_footer_teamlink_before_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html"
++new file mode 100644
++index 000000000..cf298acd5
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html"
++@@ -0,0 +1,10 @@
+++{# Note: we must use the after code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TEAMLINK_AFTER %}
+++	{% for link in overall_footer_teamlink_after_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html"
++new file mode 100644
++index 000000000..174cb155d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html"
++@@ -0,0 +1,10 @@
+++{# Note: we must use the before code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TIMEZONE_BEFORE %}
+++	{% for link in overall_footer_timezone_before_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html"
++new file mode 100644
++index 000000000..c8db014d8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html"
++@@ -0,0 +1,10 @@
+++{# Note: we must use the after code so the link will appear in the expected location #}
+++{% if S_OVERALL_FOOTER_TIMEZONE_AFTER %}
+++	{% for link in overall_footer_timezone_after_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ overall_footer_timezone_before_links.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html"
++new file mode 100644
++index 000000000..f9f099b4d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html"
++@@ -0,0 +1,7 @@
+++{% if S_OVERALL_HEADER_BREADCRUMBS_AFTER %}
+++	{% for link in overall_header_breadcrumbs_after_links %}
+++		<li data-skip-responsive {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} breadcrumbs"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="breadcrumbs"{% endif %} itemscope itemtype="https://schema.org/BreadcrumbList">
+++			<span class="crumb" {{ MICRODATA }}><a itemprop="item" href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}">{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span itemprop="name">{{ link.LINK_TITLE }}</span></a><meta itemprop="position" content="{{ navlink_position }}{% set navlink_position = navlink_position + 1 %}" /></span>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++new file mode 100644
++index 000000000..97367b56e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
++@@ -0,0 +1,7 @@
+++{% if S_OVERALL_HEADER_BREADCRUMBS_BEFORE %}
+++	{% for link in overall_header_breadcrumbs_before_links %}
+++		<li data-skip-responsive {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} breadcrumbs"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="breadcrumbs"{% endif %} itemscope itemtype="https://schema.org/BreadcrumbList">
+++			<span class="crumb" {{ MICRODATA }}><a itemprop="item" href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}">{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span itemprop="name">{{ link.LINK_TITLE }}</span></a><meta itemprop="position" content="0" /></span>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..dd7b65642
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1 @@
+++{% INCLUDECSS '@phpbb_pages/pages_common.css' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++new file mode 100644
++index 000000000..70ce62e50
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++@@ -0,0 +1,9 @@
+++{% if S_OVERALL_HEADER_NAVIGATION_APPEND %}
+++	{% for link in overall_header_navigation_append_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} no-bulletin"{% if link.ICON_LINK %} style="background-image:url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span></a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html"
++new file mode 100644
++index 000000000..28353578b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html"
++@@ -0,0 +1,10 @@
+++{% if S_OVERALL_HEADER_NAVIGATION_PREPEND %}
+++	{% for link in overall_header_navigation_prepend_links %}
+++		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} no-bulletin"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+++			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+++				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+++				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+++			</a>
+++		</li>
+++	{% endfor %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html"
++new file mode 100644
++index 000000000..33b7e8024
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html"
++@@ -0,0 +1,23 @@
+++{# Use the space below to include external CSS and JS files
+++# Here are some example usages:
+++#
+++# local files relative to this template file (when stored inside phpBB's style directories):
+++# {% INCLUDEJS 'script.js' %}
+++# {% INCLUDECSS 'style.css' %}
+++#
+++# local files stored inside the Pages extension:
+++# {% INCLUDEJS '@phpbb_pages/script.js' %}
+++# {% INCLUDECSS '@phpbb_pages/style.css' %}
+++#
+++# hosted on external sites:
+++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+++#
+++#}
+++{% include 'overall_header.html' %}
+++
+++	{{ PAGE_CONTENT }}
+++
+++{% EVENT phpbb_pages_after_page_content %}
+++
+++{% include 'overall_footer.html' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_default.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_default.html"
++new file mode 100644
++index 000000000..0f5a0c59f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/template/pages_default.html"
++@@ -0,0 +1,27 @@
+++{# Use the space below to include external CSS and JS files
+++# Here are some example usages:
+++#
+++# local files relative to this template file (when stored inside phpBB's style directories):
+++# {% INCLUDEJS 'script.js' %}
+++# {% INCLUDECSS 'style.css' %}
+++#
+++# local files stored inside the Pages extension:
+++# {% INCLUDEJS '@phpbb_pages/script.js' %}
+++# {% INCLUDECSS '@phpbb_pages/style.css' %}
+++#
+++# hosted on external sites:
+++# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+++# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+++#
+++#}
+++{% include 'overall_header.html' %}
+++
+++<div class="side-segment">
+++	<h3>{PAGE_TITLE}</h3>
+++</div>
+++<div class="well">
+++	{{ PAGE_CONTENT }}
+++</div>
+++{% EVENT phpbb_pages_after_page_content %}
+++
+++{% include 'overall_footer.html' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif"
++new file mode 100644
++index 000000000..20b2fe9f8
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css"
++new file mode 100644
++index 000000000..e315eaec9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css"
++@@ -0,0 +1,17 @@
+++.icon-pages {
+++	background: url("./images/icon_pages.gif") no-repeat 0 50%;
+++}
+++
+++li.breadcrumbs.icon-pages span:first-child > a {
+++	display: inline-block;
+++	padding-left: 17px;
+++}
+++
+++.rtl .icon-pages {
+++	background-position: 100% 50%;
+++}
+++
+++.rtl li.breadcrumbs.icon-pages span:first-child > a {
+++	padding-right: 19px;
+++	padding-left: 0;
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css"
++new file mode 100644
++index 000000000..072c1adf1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css"
++@@ -0,0 +1,51 @@
+++.content p,
+++.content h1,
+++.content h2,
+++.content h3,
+++.content h4 {
+++	font: inherit;
+++	font-size: 100%;
+++	line-height: 1.3em;
+++	vertical-align: baseline;
+++	text-transform: none;
+++	border: 0;
+++	color: inherit;
+++	margin: 0;
+++	padding: 0;
+++}
+++
+++.pages-content {
+++	font-size: 1.25em;
+++	line-height: 1.3em;
+++}
+++
+++.pages-content h1 {
+++	font-size: 2em;
+++}
+++
+++.pages-content h2 {
+++	font-size: 1.5em;
+++}
+++
+++.pages-content h3 {
+++	font-size: 1.17em;
+++}
+++
+++.pages-content h4 {
+++	font-size: 1em;
+++}
+++
+++.pages-content h5 {
+++	font-size: 0.83em;
+++}
+++
+++.pages-content h6 {
+++	font-size: 0.75em;
+++}
+++
+++.pages-content .postimage {
+++	-moz-box-sizing: border-box;
+++	-webkit-box-
\ No newline at end of file
diff --git "[ORIGINAL]/phpbb\\pages/entity/page.php" "[FORUM_EXT]/phpbb\\pages/entity/page.php"
--- "[ORIGINAL]/phpbb\\pages/entity/page.php"
+++ "[FORUM_EXT]/phpbb\\pages/entity/page.php"
@@ -481,7 +481,7 @@ class page implements page_interface
 	*/
 	public function get_template()
 	{
-		return !empty($this->data['page_template']) ? (string) $this->data['page_template'] : 'pages_default.html';
+		return (!empty($this->data['page_template'])) ? (string) $this->data['page_template'] : 'pages_default.html';
 	}
 
 	/**
diff --git "[ORIGINAL]/phpbb\\pages/event/listener.php" "[FORUM_EXT]/phpbb\\pages/event/listener.php"
--- "[ORIGINAL]/phpbb\\pages/event/listener.php"
+++ "[FORUM_EXT]/phpbb\\pages/event/listener.php"
@@ -146,7 +146,7 @@ class listener implements EventSubscriberInterface
 			// If any of our pages are being viewed, update the event vars with our routes and titles
 			foreach ($page_routes as $page_id => $page_data)
 			{
-				if ($event['row']['session_page'] === 'app.' . $this->php_ext . '/' . $page_data['route'])
+				if ($event['row']['session_page'] === 'app.' . $this->php_ext . DIRECTORY_SEPARATOR . $page_data['route'])
 				{
 					$event['location'] = $this->lang->lang('PAGES_VIEWONLINE', $page_data['title']);
 					$event['location_url'] = $this->helper->route('phpbb_pages_dynamic_route_' . $page_id);
diff --git "[ORIGINAL]/phpbb\\pages/ext.php" "[FORUM_EXT]/phpbb\\pages/ext.php"
--- "[ORIGINAL]/phpbb\\pages/ext.php"
+++ "[FORUM_EXT]/phpbb\\pages/ext.php"
@@ -26,14 +26,12 @@ class ext extends \phpbb\extension\base
 	 * the minimum version required by this extension:
 	 *
 	 * Requires phpBB 3.3.2 due to using role_exists check in permission migration.
-	 * Not compatible with phpBB 4.0.0-dev due to using updated classes.
 	 *
 	 * @return bool
 	 * @access public
 	 */
 	public function is_enableable()
 	{
-		return phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=')
-			&& phpbb_version_compare(PHPBB_VERSION, '4.0.0-dev', '<');
+		return phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=');
 	}
 }
diff --git "[ORIGINAL]/phpbb\\pages/language/es/pages_acp.php" "[FORUM_EXT]/phpbb\\pages/language/es/pages_acp.php"
--- "[ORIGINAL]/phpbb\\pages/language/es/pages_acp.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/es/pages_acp.php"
@@ -80,7 +80,7 @@ $lang = array_merge($lang, array(
 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Esto es un campo requerido.',
 	'ACP_PAGES_FORM_DESC'				=> 'Descripción de la página',
 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Esto solo se mostrará en la lista de páginas del PCA.',
-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título del enlace',
+	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
 	'ACP_PAGES_FORM_ROUTE'				=> 'Ruta URL de la página',
 	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'La <strong>ruta</strong> es un identificador único utilizado al final de la URL de una página para definir el vínculo a la página, por ejemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Sólo se admiten letras, números, guiones y guiones bajos. Este es un campo obligatorio.',
 	'ACP_PAGES_FORM_CONTENT'			=> 'Contenido de la página',
@@ -99,8 +99,8 @@ $lang = array_merge($lang, array(
 	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página a invitados',
 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Si se establece en no, sólo los usuarios registrados podrán acceder a la página.',
 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Enlace de la página',
-	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar el título de la página primero',
-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'De forma predeterminada, los navegadores mostrarán el título de esta página después del nombre del sitio <samp style="white-space: nowrap">“Nombre del sitio - Titulo de la página”</samp>. Habilitar esta opción mostrará el título de esta página antes del nombre del sitio <samp style="white-space: nowrap">“Título de la página - Nombre del sitio”</samp>.',
+	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
 	'PARSE_HTML'						=> 'Reconocer HTML',
 
 	// Page link location names
diff --git "[ORIGINAL]/phpbb\\pages/language/fr/exceptions.php" "[FORUM_EXT]/phpbb\\pages/language/fr/exceptions.php"
--- "[ORIGINAL]/phpbb\\pages/language/fr/exceptions.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/fr/exceptions.php"
@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -35,7 +35,7 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ’ « » “ ” …
+// ’ » “ ” …
 //
 
 /*
@@ -48,7 +48,7 @@ if (empty($lang) || !is_array($lang))
 *
 * Translators: Feel free to not translate these language strings
 */
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'EXCEPTION_FIELD_MISSING'		=> 'Un champ obligatoire est manquant',
 	'EXCEPTION_INVALID_ARGUMENT'	=> 'Argument spécifié incorrect pour `%1$s`. Motif : %2$s',
 	'EXCEPTION_OUT_OF_BOUNDS'		=> 'Le champ `%1$s` a reçu une donnée incohérente',
@@ -56,4 +56,4 @@ $lang = array_merge($lang, [
 	'EXCEPTION_NOT_UNIQUE'			=> 'La donnée n’était pas unique.',
 	'EXCEPTION_UNEXPECTED_VALUE'	=> 'Le champ `%1$s` a reçu une donnée inattendue. Motif : %2$s',
 	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'La donnée contenait des caractères interdits.',
-]);
+));
diff --git "[ORIGINAL]/phpbb\\pages/language/fr/info_acp_pages.php" "[FORUM_EXT]/phpbb\\pages/language/fr/info_acp_pages.php"
--- "[ORIGINAL]/phpbb\\pages/language/fr/info_acp_pages.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/fr/info_acp_pages.php"
@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -35,10 +35,10 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ’ « » “ ” …
+// ’ » “ ” …
 //
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	// ACP modules
 	'ACP_PAGES'				=> 'Pages',
 	'ACP_PAGES_MANAGE'		=> 'Gestion de Pages',
@@ -47,4 +47,4 @@ $lang = array_merge($lang, [
 	'ACP_PAGES_ADDED_LOG'	=> '<strong>Page ajoutée</strong><br />» %s',
 	'ACP_PAGES_EDITED_LOG'	=> '<strong>Page modifiée</strong><br />» %s',
 	'ACP_PAGES_DELETED_LOG'	=> '<strong>Page supprimée</strong><br />» %s',
-]);
+));
diff --git "[ORIGINAL]/phpbb\\pages/language/fr/pages_acp.php" "[FORUM_EXT]/phpbb\\pages/language/fr/pages_acp.php"
--- "[ORIGINAL]/phpbb\\pages/language/fr/pages_acp.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/fr/pages_acp.php"
@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -35,23 +35,23 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ’ « » “ ” …
+// ’ » “ ” …
 //
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	// Manage page
 	'ACP_PAGES_MANAGE'					=> 'Gestion des Pages',
 	'ACP_PAGES_MANAGE_EXPLAIN'			=> 'Depuis cette page vous pouvez ajouter, modifier et supprimer des pages personnalisées.',
 	'ACP_PAGES_CREATE_PAGE'				=> 'Créer une page',
-	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez ajouter une nouvelle page personnalisée à votre forum.',
+	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez ajouter une nouvelle page personnalisée pour votre forum.',
 	'ACP_PAGES_EDIT_PAGE'				=> 'Modifier une page',
-	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez modifier une page personnalisée existante de votre forum.',
+	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Au moyen du formulaire ci-dessous, vous pouvez modifier une page personnalisée existante pour votre forum.',
 
 	// Display pages list
 	'ACP_PAGES_TITLE'					=> 'Titre',
 	'ACP_PAGES_DESCRIPTION'				=> 'Description',
 	'ACP_PAGES_ROUTE'					=> 'Chemin',
-	'ACP_PAGES_TEMPLATE'				=> 'Modèle',
+	'ACP_PAGES_TEMPLATE'				=> 'Template',
 	'ACP_PAGES_ORDER'					=> 'Ordre',
 	'ACP_PAGES_LINK'					=> 'Lien',
 	'ACP_PAGES_VIEW'					=> 'Voir la page',
@@ -80,28 +80,28 @@ $lang = array_merge($lang, [
 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Ce champ est obligatoire.',
 	'ACP_PAGES_FORM_DESC'				=> 'Description de la page',
 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Cette description ne sera affichée que dans la rubrique « Gestion des Pages » du PCA.',
-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Utiliser comme titre de lien',
-	'ACP_PAGES_FORM_ROUTE'				=> 'Route de l’URL de la page',
-	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'Une version simplifiée du nom de la page, utilisée pour construire l’URL de cette dernière. Exemple : <samp>http://www.phpbb.com/<strong>nom-de-la-page</strong></samp>. Seuls sont autorisés les lettres, chiffres, traits d’union et tirets bas. Ce champ est obligatoire.',
+	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
+	'ACP_PAGES_FORM_ROUTE'				=> 'Chemin de la page',
+	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> 'Le <strong>chemin</strong> est un identifiant unique utilisé à la fin de l’adresse URL d’une page pour en définir le lien vers cette dernière. Exemple : <samp>http://www.phpbb.com/<strong>route</strong></samp>. Seuls sont autorisés les lettres, chiffres, traits d’union et tirets bas. Ce champ est obligatoire.',
 	'ACP_PAGES_FORM_CONTENT'			=> 'Contenu de la page',
-	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Le contenu peut être créé en utilisant les BBCodes, les smileys et les urls magiques de phpBB ou vous pouvez activer le mode HTML. En mode HTML, les BBCodes, les smileys et les urls magiques ne fonctionneront pas, mais vous êtes libre d’utiliser n’importe quelle syntaxe HTML valide. Veuillez noter que ce contenu sera ajouté à un modèle HTML existant, vous ne devez donc pas inclure les balises DOCTYPE, HTML, BODY ou HEAD. Cependant, toutes les autres balises de formatage HTML, y compris IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc. peuvent être utilisées.',
-	'ACP_PAGES_FORM_TEMPLATE'			=> 'Modèle de la page',
-	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Les modèles des pages personnalisées, sont nommés <samp>pages_*.html</samp> et peuvent être ajoutés dans les répertoires <samp>./styles/*/template</samp> de phpBB.',
-	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Sélectionner un modèle',
+	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Le contenu peut être créé en faisant usage des BBCodes par défaut de phpBB, les smileys et les adresses URL magiques ou bien en activant le mode HTML. Avec le mode HTML, les BBCodes, smileys et adresses URL magiques ne fonctionneront pas, mais vous pouvez utiliser toute syntaxe HTML valide. Veuillez prendre note que ce contenu sera intégré dans un template HTML existant. Ainsi, nul besoin d’insérer les tags DOCTYPE, HTML, BODY ou HEAD. Néanmoins, tous les autres tags de mise en forme peuvent être utilisés, incluant IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc..',
+	'ACP_PAGES_FORM_TEMPLATE'			=> 'Template de la page',
+	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Les templates des pages personnalisées, sont nommés <samp>pages_*.html</samp> et peuvent être ajoutés dans les répertoires <samp>./styles/*/template</samp> de phpBB.',
+	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Sélectionner un template',
 	'ACP_PAGES_FORM_ORDER'				=> 'Ordre de la page',
 	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'Les pages seront triées selon ce champ, permettant ainsi d’organiser l’ordre dans lequel vous souhaitez que leurs liens apparaissent. Les plus petits nombres seront affichés avant les plus grands.',
-	'ACP_PAGES_FORM_LINKS'				=> 'Emplacements du lien de la page',
+	'ACP_PAGES_FORM_LINKS'				=> 'Emplacements pour le lien de la page',
 	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Sélectionne un ou plusieurs emplacements où le lien de cette page apparaitra. Utilisez CTRL+CLICK (ou CMD + CLICK sur Mac) pour (dé)sélectionner plus d’un item.',
 	'ACP_PAGES_FORM_ICON_FONT'			=> 'Icône du lien de la page',
-	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Permet de saisir le nom de l’icône provenant de la police de caractères <strong><a href="%s" target="_blank">Font Awesome</a></strong> qui sera utilisée pour le lien de cette page. Laisser ce champ vide pour utiliser l’icône par défaut CSS/GIF.',
+	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Permet de saisir le nom de l’icône provenant de la police de caractères <strong><a href="%s" target="_blank">Font Awesome</a></strong> qui sera utilisée pour le lien de cette page. Laisser ce champ vide pour utiliser l’image icône par défaut CSS/GIF.',
 	'ACP_PAGES_FORM_DISPLAY'			=> 'Afficher la page',
 	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Si défini sur non, la page ne sera pas accessible aux utilisateurs néanmoins les administrateurs y auront accès, leur permettant d’avoir un aperçu pendant la création.',
 	'ACP_PAGES_FORM_GUESTS'				=> 'Afficher la page aux invités',
 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Si défini sur non, seuls les utilisateurs enregistrés pourront accéder à la page.',
 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Lien de la page',
-	'ACP_PAGES_TITLE_SWITCH'			=> 'Afficher le titre de la page en premier',
-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'Par défaut, les navigateurs affichent le titre de cette page après le nom du site <samp style="white-space : nowrap">« Nom du site - Titre de la page »</samp>. En activant cette option, le titre de cette page sera affiché avant le nom du site <samp style="white-space : nowrap">« Titre de la page - Nom du site »</samp>.',
-	'PARSE_HTML'						=> 'Analyser le HTML',
+	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+	'PARSE_HTML'						=> 'Parser le HTML',
 
 	// Page link location names
 	'NAV_BAR_LINKS_BEFORE'				=> 'Barre de navigation avant les liens',
@@ -114,4 +114,4 @@ $lang = array_merge($lang, [
 	'FOOTER_TEAMS_AFTER'				=> 'Pied de page après le lien de l’équipe',
 	'QUICK_LINK_MENU_BEFORE'			=> 'En haut du menu « Accès rapide »',
 	'QUICK_LINK_MENU_AFTER'				=> 'En bas du menu « Accès rapide »',
-]);
+));
diff --git "[ORIGINAL]/phpbb\\pages/language/fr/pages_common.php" "[FORUM_EXT]/phpbb\\pages/language/fr/pages_common.php"
--- "[ORIGINAL]/phpbb\\pages/language/fr/pages_common.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/fr/pages_common.php"
@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ’ « » “ ” …
+// ’ » “ ” …
 //
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'PAGES_VIEWONLINE'		=> 'Consulte la page %s',
-]);
+));
diff --git "[ORIGINAL]/phpbb\\pages/language/fr/pages_controller.php" "[FORUM_EXT]/phpbb\\pages/language/fr/pages_controller.php"
--- "[ORIGINAL]/phpbb\\pages/language/fr/pages_controller.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/fr/pages_controller.php"
@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ’ « » “ ” …
+// ’ » “ ” …
 //
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'PAGE_NOT_AVAILABLE'		=> 'La page « %s » n’est pas disponible.',
-]);
+));
diff --git "[ORIGINAL]/phpbb\\pages/language/fr/permissions_pages.php" "[FORUM_EXT]/phpbb\\pages/language/fr/permissions_pages.php"
--- "[ORIGINAL]/phpbb\\pages/language/fr/permissions_pages.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/fr/permissions_pages.php"
@@ -19,7 +19,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -35,9 +35,9 @@ if (empty($lang) || !is_array($lang))
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 //
 // Some characters you may want to copy&paste:
-// ’ « » “ ” …
+// ’ » “ ” …
 //
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	'ACL_A_PAGES'		=> 'Peut gérer l’extension Pages',
-]);
+));
diff --git "[ORIGINAL]/phpbb\\pages/language/it/pages_acp.php" "[FORUM_EXT]/phpbb\\pages/language/it/pages_acp.php"
--- "[ORIGINAL]/phpbb\\pages/language/it/pages_acp.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/it/pages_acp.php"
@@ -92,15 +92,15 @@ $lang = array_merge($lang, array(
 	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'Le pagine verranno ordinate in base a questo campo, che può aiutare ad organizzare l´ordine in cui appaiono loro collegamenti. I numeri più bassi hanno la precedenza su numeri più alti.',
 	'ACP_PAGES_FORM_LINKS'				=> 'Posizione link alla pagina',
 	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Selezionare uno o più luoghi in cui il link a questa pagina putrà apparire. Utilizzare Ctrl + clic (o CMD + clic su Mac) per selezionare/deselezionare più di una voce.',
-	'ACP_PAGES_FORM_ICON_FONT'			=> 'Icona del link della pagina',
-	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Inserisci il nome di un’icona <strong><a href="%s" target="_blank">Font Awesome</a></strong> per usarla con il link della pagina. Lascia vuoto questo campo per usare le icone tradizionali CSS/GIF delle Pagine.',
+	'ACP_PAGES_FORM_ICON_FONT'			=> 'Page link icon',
+	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use with the page link. Leave this field blank to use Pages’ traditional CSS/GIF image icons.',
 	'ACP_PAGES_FORM_DISPLAY'			=> 'Visualizza pagina',
 	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Se impostato su no, la pagina non sarà accessibile. (Nota: Gli amministratori saranno ancora in grado di accedere alla pagina, permettendo loro di visualizzare in anteprima privatamente la pagina mentre lo sviluppo è ancora in essere.)',
 	'ACP_PAGES_FORM_GUESTS'				=> 'Permetti visualizzazione pagina agli ospiti',
 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se impostato su no, solo gli utenti registrati saranno in grado di accedere alla pagina.',
 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link alla pagina',
-	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostra prima il titolo della pagina',
-	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'Per impostazione predefinita i browser mostreranno il titolo di questa pagina dopo il nome del sito <samp style="white-space: nowrap">“Nome del Sito - Titolo della Pagina”</samp>. Abilitare quest’opzione mostrera’ il titolo di questa pagina prima del nome del sito <samp style="white-space: nowrap">“Titolo della Pagina - Nome del Sito”</samp>.',
+	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
 	'PARSE_HTML'						=> 'Analizza HTML',
 
 	// Page link location names
diff --git "[ORIGINAL]/phpbb\\pages/language/pt/pages_acp.php" "[FORUM_EXT]/phpbb\\pages/language/pt/pages_acp.php"
--- "[ORIGINAL]/phpbb\\pages/language/pt/pages_acp.php"
+++ "[FORUM_EXT]/phpbb\\pages/language/pt/pages_acp.php"
@@ -80,7 +80,7 @@ $lang = array_merge($lang, array(
 	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Este Campo é obrigatório.',
 	'ACP_PAGES_FORM_DESC'				=> 'Descrição da página',
 	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Apenas será exibido na lista de páginas no ACP.',
-	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Display as link title',
+	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título do endereço',
 	'ACP_PAGES_FORM_ROUTE'				=> 'Caminho do URL da página',
 	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> '<strong>route</strong> é um identificador exclusivo, usado no final da URL de uma página, para definir o link para a página, por exemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Apenas letras, números, hífens e sublinhados são permitidos. Este campo é obrigatório.',
 	'ACP_PAGES_FORM_CONTENT'			=> 'Conteúdo da página',
@@ -99,7 +99,7 @@ $lang = array_merge($lang, array(
 	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página aos visitantes',
 	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se definido como Não, apenas utilizadores registados poderão aceder à página.',
 	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link da página',
-	'ACP_PAGES_TITLE_SWITCH'			=> 'Display page title first',
+	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar primeiro o título da página',
 	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
 	'PARSE_HTML'						=> 'Parse HTML',
 
diff --git "[FORUM_EXT]/phpbb\\pages/language/pt_preao/exceptions.php" "[FORUM_EXT]/phpbb\\pages/language/pt_preao/exceptions.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/language/pt_preao/exceptions.php"
@@ -0,0 +1,59 @@
+<?php
+/**
+*
+* Pages extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+// DEVELOPERS PLEASE NOTE
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
+/*
+* These are errors which can be triggered by sending invalid data to the
+* pages extension API.
+*
+* These errors will never show to a user unless they are either modifying
+* the core pages extension code OR unless they are writing an extension
+* which makes calls to this extension.
+*
+* Translators: Feel free to not translate these language strings
+*/
+$lang = array_merge($lang, array(
+	'EXCEPTION_FIELD_MISSING'		=> 'Campo obrigatório em falta',
+	'EXCEPTION_INVALID_ARGUMENT'	=> 'O argumento especificado para `%1$s` é inválido. Razão: %2$s',
+	'EXCEPTION_OUT_OF_BOUNDS'		=> 'O Campo `%1$s` recebeu dados além do limite',
+	'EXCEPTION_TOO_LONG'			=> 'A entrada foi maior do que o máximo permitido.',
+	'EXCEPTION_NOT_UNIQUE'			=> 'A entrada não é única.',
+	'EXCEPTION_UNEXPECTED_VALUE'	=> 'O campo `%1$s` recebeu dados não previstos. Razão: %2$s',
+	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'A entrada tem caracteres inválidos.',
+));
diff --git "[FORUM_EXT]/phpbb\\pages/language/pt_preao/info_acp_pages.php" "[FORUM_EXT]/phpbb\\pages/language/pt_preao/info_acp_pages.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/language/pt_preao/info_acp_pages.php"
@@ -0,0 +1,50 @@
+<?php
+/**
+*
+* Pages extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+// DEVELOPERS PLEASE NOTE
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
+$lang = array_merge($lang, array(
+	// ACP modules
+	'ACP_PAGES'				=> 'Páginas Personalizadas',
+	'ACP_PAGES_MANAGE'		=> 'Gerir Páginas Personalizadas',
+
+	// Logs
+	'ACP_PAGES_ADDED_LOG'	=> '<strong>Página adicionada</strong><br />» %s',
+	'ACP_PAGES_EDITED_LOG'	=> '<strong>Página Editada</strong><br />» %s',
+	'ACP_PAGES_DELETED_LOG'	=> '<strong>Página apagada</strong><br />» %s',
+));
diff --git "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_acp.php" "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_acp.php"
@@ -0,0 +1,117 @@
+<?php
+/**
+*
+* Pages extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+// DEVELOPERS PLEASE NOTE
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
+$lang = array_merge($lang, array(
+	// Manage page
+	'ACP_PAGES_MANAGE'					=> 'Gerir Páginas Personalizadas',
+	'ACP_PAGES_MANAGE_EXPLAIN'			=> 'A partir desta página, pode adicionar, editar e excluir páginas personalizadas.',
+	'ACP_PAGES_CREATE_PAGE'				=> 'Criar páginas',
+	'ACP_PAGES_CREATE_PAGE_EXPLAIN'		=> 'Usando o formulário abaixo, pode criar uma nova página personalizada para o seu Fórum.',
+	'ACP_PAGES_EDIT_PAGE'				=> 'Editar página',
+	'ACP_PAGES_EDIT_PAGE_EXPLAIN'		=> 'Usando o formulário abaixo, pode modificar uma página personalizada existente no seu Fórum.',
+
+	// Display pages list
+	'ACP_PAGES_TITLE'					=> 'Nome',
+	'ACP_PAGES_DESCRIPTION'				=> 'Descrição',
+	'ACP_PAGES_ROUTE'					=> 'Route',
+	'ACP_PAGES_TEMPLATE'				=> 'Template',
+	'ACP_PAGES_ORDER'					=> 'Ordem',
+	'ACP_PAGES_LINK'					=> 'Link',
+	'ACP_PAGES_VIEW'					=> 'Ver página',
+	'ACP_PAGES_STATUS'					=> 'Estatuto',
+	'ACP_PAGES_PUBLISHED'				=> 'Publicada',
+	'ACP_PAGES_PUBLISHED_NO_GUEST'		=> 'Publicada (apenas membros)',
+	'ACP_PAGES_PRIVATE'					=> 'Privada',
+	'ACP_PAGES_EMPTY'					=> 'Não há páginas',
+
+	// Purge icons
+	'ACP_PAGES_PURGE_ICONS'				=> 'Limpar icons',
+	'ACP_PAGES_PURGE_ICONS_LABEL'		=> 'Limpar cache dos icones das páginas',
+	'ACP_PAGES_PURGE_ICONS_EXPLAIN'		=> 'Ao adicionar links para ícones das páginas personalizadas, tem que limpar a cache de ícones para ver os novos ícones. Coloque os ícones personalizados, usando nomes <samp>pages_route.gif</samp>, onde <samp>route</samp> é nome do caminho da página, na pasta <samp>styles/*/theme/images/</samp>.',
+
+	// Messages shown to user
+	'ACP_PAGES_DELETE_CONFIRM'			=> 'Tem a certeza que deseja eliminar esta página?',
+	'ACP_PAGES_DELETE_SUCCESS'			=> 'Página eliminada com sucesso.',
+	'ACP_PAGES_DELETE_ERRORED'			=> 'A página não pode ser eliminada.',
+	'ACP_PAGES_ADD_SUCCESS'				=> 'Página criada com sucesso.',
+	'ACP_PAGES_EDIT_SUCCESS'			=> 'Página atualizada com sucesso.',
+
+	// Add/edit page
+	'ACP_PAGES_SETTINGS'				=> 'Configurar página',
+	'ACP_PAGES_OPTIONS'					=> 'Opções da página',
+	'ACP_PAGES_FORM_TITLE'				=> 'Título da página',
+	'ACP_PAGES_FORM_TITLE_EXPLAIN'		=> 'Este Campo é obrigatório.',
+	'ACP_PAGES_FORM_DESC'				=> 'Descrição da página',
+	'ACP_PAGES_FORM_DESC_EXPLAIN'		=> 'Apenas será exibido na lista de páginas no ACP.',
+	'ACP_PAGES_FORM_DESC_DISPLAY'		=> 'Mostrar como título do endereço',
+	'ACP_PAGES_FORM_ROUTE'				=> 'Caminho do URL da página',
+	'ACP_PAGES_FORM_ROUTE_EXPLAIN'		=> '<strong>route</strong> é um identificador exclusivo, usado no final da URL de uma página, para definir o link para a página, por exemplo, <samp>http://www.phpbb.com/<strong>route</strong></samp>. Apenas letras, números, hífens e sublinhados são permitidos. Este campo é obrigatório.',
+	'ACP_PAGES_FORM_CONTENT'			=> 'Conteúdo da página',
+	'ACP_PAGES_FORM_CONTENT_EXPLAIN'	=> 'Na criação do conteúdo pode usar BBCodes phpBB, smilies e urls mágicos ou pode ativar o modo HTML. No modo HTML, os BBCodes, smilies e urls mágicos não funcionam, mas pode usar qualquer sintaxe HTML válida. Tenha em atenção que este conteúdo será mostrado no Template HTML existente, pelo que não deve incluir DOCTYPE, HTML, BODY ou tags HEAD. No entanto podem ser usadas todas as outras tags de formatação HTML, incluindo IFRAME, SCRIPT, STYLE, EMBED, VIDEO, etc.',
+	'ACP_PAGES_FORM_TEMPLATE'			=> 'Template da página',
+	'ACP_PAGES_FORM_TEMPLATE_EXPLAIN'	=> 'Modelos de páginas personalizadas com nomes <samp>pages_*.html</samp> podem ser adicionadas à pasta phpBB’s <samp>styles/*/template</samp>.',
+	'ACP_PAGES_FORM_TEMPLATE_SELECT'	=> 'Selecione um template',
+	'ACP_PAGES_FORM_ORDER'				=> 'Ordem das páginas',
+	'ACP_PAGES_FORM_ORDER_EXPLAIN'		=> 'As páginas serão ordenadas de acordo com esta ordem, que pode ajudar a organizar a ordem em que os links aparecem. Os números mais baixos têm precedência sobre os números mais altos.',
+	'ACP_PAGES_FORM_LINKS'				=> 'Localizações do link da página',
+	'ACP_PAGES_FORM_LINKS_EXPLAIN'		=> 'Selecione um ou mais locais onde serão visíveis links para esta página. Use CTRL+CLICK (ou CMD+CLICK no Mac) para selecionar/desselecionar mais do que um item.',
+	'ACP_PAGES_FORM_ICON_FONT'			=> 'Page link icon',
+	'ACP_PAGES_FORM_ICON_FONT_EXPLAIN'	=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use with the page link. Leave this field blank to use Pages’ traditional CSS/GIF image icons.',
+	'ACP_PAGES_FORM_DISPLAY'			=> 'Mostrar página',
+	'ACP_PAGES_FORM_DISPLAY_EXPLAIN'	=> 'Se definido como Não, a página não será visível. (Nota: Administradores podem aceder à página, o que lhes permite pré-visualizá-la enquanto estão a desenvolvê-la.)',
+	'ACP_PAGES_FORM_GUESTS'				=> 'Mostrar página aos visitantes',
+	'ACP_PAGES_FORM_GUESTS_EXPLAIN'		=> 'Se definido como Não, apenas utilizadores registados poderão aceder à página.',
+	'ACP_PAGES_FORM_VIEW_PAGE'			=> 'Link da página',
+	'ACP_PAGES_TITLE_SWITCH'			=> 'Mostrar primeiro o título da página',
+	'ACP_PAGES_TITLE_SWITCH_EXPLAIN'	=> 'By default browsers will display this page’s title after the site name <samp style="white-space: nowrap">“Site Name - Page Title”</samp>. Enabling this option will display this page’s title before the site name <samp style="white-space: nowrap">“Page Title - Site Name”</samp>.',
+	'PARSE_HTML'						=> 'Parse HTML',
+
+	// Page link location names
+	'NAV_BAR_LINKS_BEFORE'				=> 'Antes dos Links Nav Bar',
+	'NAV_BAR_LINKS_AFTER'				=> 'Depois dos Links Nav Bar',
+	'NAV_BAR_CRUMBS_BEFORE'				=> 'Antes dos Breadcrumbs Nav Bar',
+	'NAV_BAR_CRUMBS_AFTER'				=> 'Depois dos Breadcrumbs Nav Bar',
+	'FOOTER_TIMEZONE_BEFORE'			=> 'No Rodapé antes da Time Zone',
+	'FOOTER_TIMEZONE_AFTER'				=> 'No Rodapé depois da Time Zone',
+	'FOOTER_TEAMS_BEFORE'				=> 'No Rodapé antes da Team Link',
+	'FOOTER_TEAMS_AFTER'				=> 'No Rodapé depois da Team Link',
+	'QUICK_LINK_MENU_BEFORE'			=> 'Nos Links rápidos, no inicio',
+	'QUICK_LINK_MENU_AFTER'				=> 'Nos Links rápidos, no final',
+));
diff --git "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_common.php" "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_common.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* Pages extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+// DEVELOPERS PLEASE NOTE
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
+$lang = array_merge($lang, array(
+	'PAGES_VIEWONLINE'		=> 'Vendo %s',
+));
diff --git "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_controller.php" "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_controller.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/language/pt_preao/pages_controller.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* Pages extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+// DEVELOPERS PLEASE NOTE
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
+$lang = array_merge($lang, array(
+	'PAGE_NOT_AVAILABLE'		=> 'A página solicitada “%s” não está disponível.',
+));
diff --git "[FORUM_EXT]/phpbb\\pages/language/pt_preao/permissions_pages.php" "[FORUM_EXT]/phpbb\\pages/language/pt_preao/permissions_pages.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/language/pt_preao/permissions_pages.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* Pages extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+// DEVELOPERS PLEASE NOTE
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
+$lang = array_merge($lang, array(
+	'ACL_A_PAGES'		=> 'Pode gerir a extensão Páginas Personalizadas',
+));
diff --git "[ORIGINAL]/phpbb\\pages/operators/page.php" "[FORUM_EXT]/phpbb\\pages/operators/page.php"
--- "[ORIGINAL]/phpbb\\pages/operators/page.php"
+++ "[FORUM_EXT]/phpbb\\pages/operators/page.php"
@@ -69,12 +69,10 @@ class page implements page_interface
 	/**
 	* Get all pages
 	*
-	 * @param int $limit
-	 * @param int $start
 	* @return array Array of page data entities
 	* @access public
 	*/
-	public function get_pages($limit = 0, $start = 0)
+	public function get_pages()
 	{
 		$entities = array();
 
@@ -82,7 +80,7 @@ class page implements page_interface
 		$sql = 'SELECT *
 			FROM ' . $this->pages_table . '
 			ORDER BY page_order ASC, page_id ASC';
-		$result = $this->db->sql_query_limit($sql, $limit, $start);
+		$result = $this->db->sql_query($sql);
 
 		while ($row = $this->db->sql_fetchrow($result))
 		{
@@ -369,23 +367,6 @@ class page implements page_interface
 		return $rows;
 	}
 
-	/**
-	 * Get the total number of pages
-	 *
-	 * @return int
-	 * @access public
-	 */
-	public function get_total_pages()
-	{
-		$sql = 'SELECT COUNT(*) AS pages
-			FROM ' . $this->pages_table;
-		$result = $this->db->sql_query($sql);
-		$pages = $this->db->sql_fetchfield('pages');
-		$this->db->sql_freeresult($result);
-
-		return (int) $pages;
-	}
-
 	/**
 	* Check if a page identifier exists in the database
 	*
diff --git "[ORIGINAL]/phpbb\\pages/operators/page_interface.php" "[FORUM_EXT]/phpbb\\pages/operators/page_interface.php"
--- "[ORIGINAL]/phpbb\\pages/operators/page_interface.php"
+++ "[FORUM_EXT]/phpbb\\pages/operators/page_interface.php"
@@ -13,19 +13,17 @@ namespace phpbb\pages\operators;
 /**
 * Interface for our pages operator
 *
-* This describes all the methods we'll have for working with a set of pages
+* This describes all of the methods we'll have for working with a set of pages
 */
 interface page_interface
 {
 	/**
 	* Get all pages
 	*
-	 * @param int $limit
-	 * @param int $start
 	* @return array Array of page data entities
 	* @access public
 	*/
-	public function get_pages($limit = 0, $start = 0);
+	public function get_pages();
 
 	/**
 	* Add a page
@@ -110,12 +108,4 @@ interface page_interface
 	* @access public
 	*/
 	public function get_link_locations();
-
-	/**
-	 * Get the total number of pages
-	 *
-	 * @return int
-	 * @access public
-	 */
-	public function get_total_pages();
 }
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_after.html"
@@ -0,0 +1,8 @@
+{# Note: we must use the after code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TEAMLINK_AFTER %}
+	{% for link in overall_footer_teamlink_after_links %}
+		<li>
+			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_teamlink_before.html"
@@ -0,0 +1,8 @@
+{# Note: we must use the before code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TEAMLINK_BEFORE %}
+	{% for link in overall_footer_teamlink_before_links %}
+		<li>
+			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_after.html"
@@ -0,0 +1,8 @@
+{# Note: we must use the after code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TIMEZONE_AFTER %}
+	{% for link in overall_footer_timezone_after_links %}
+		<small>
+			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+		</small>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_footer_timezone_before.html"
@@ -0,0 +1,8 @@
+{# Note: we must use the before code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TIMEZONE_BEFORE %}
+	{% for link in overall_footer_timezone_before_links %}
+		<small>
+			<a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a>
+		</small>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_after.html"
@@ -0,0 +1,7 @@
+{% if S_OVERALL_HEADER_BREADCRUMBS_BEFORE %}
+	{% for link in overall_header_breadcrumbs_before_links %}
+		<li {$MICRODATA}>
+			<span itemprop="title"><a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a></span>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_breadcrumbs_before.html"
@@ -0,0 +1,7 @@
+{% if S_OVERALL_HEADER_BREADCRUMBS_AFTER %}
+	{% for link in overall_header_breadcrumbs_after_links %}
+		<li {$MICRODATA}>
+			<span itemprop="title"><a href="{{ link.U_LINK_URL }}">{{ link.LINK_TITLE }}</a></span>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_append.html"
@@ -0,0 +1,9 @@
+{% if S_OVERALL_HEADER_NAVIGATION_APPEND %}
+	{% for link in overall_header_navigation_append_links %}
+		<li>
+			<a href="{{ link.U_LINK_URL }}">
+				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}"></i>{% endif %}{{ link.LINK_TITLE }}</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/event/overall_header_navigation_prepend.html"
@@ -0,0 +1,9 @@
+{% if S_OVERALL_HEADER_NAVIGATION_PREPEND %}
+	{% for link in overall_header_navigation_prepend_links %}
+		<li>
+			<a href="{{ link.U_LINK_URL }}">
+				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}"></i>{% endif %}{{ link.LINK_TITLE }}</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/pages_blank.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/pages_blank.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/pages_blank.html"
@@ -0,0 +1,23 @@
+{# Use the space below to include external CSS and JS files
+# Here are some example usages:
+#
+# local files relative to this template file (when stored inside phpBB's style directories):
+# {% INCLUDEJS 'script.js' %}
+# {% INCLUDECSS 'style.css' %}
+#
+# local files stored inside the Pages extension:
+# {% INCLUDEJS '@phpbb_pages/script.js' %}
+# {% INCLUDECSS '@phpbb_pages/style.cs's %}
+#
+# hosted on external sites:
+# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+#
+#}
+{% include 'overall_header.html' %}
+
+	{{ PAGE_CONTENT }}
+
+{% EVENT phpbb_pages_after_page_content %}
+
+{% include 'overall_footer.html' %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/pages_default.html" "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/pages_default.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/BBOOTS/template/pages_default.html"
@@ -0,0 +1,27 @@
+{# Use the space below to include external CSS and JS files
+# Here are some example usages:
+#
+# local files relative to this template file (when stored inside phpBB's style directories):
+# {% INCLUDEJS 'script.js' %}
+# {% INCLUDECSS 'style.css' %}
+#
+# local files stored inside the Pages extension:
+# {% INCLUDEJS '@phpbb_pages/script.js' %}
+# {% INCLUDECSS '@phpbb_pages/style.cs's %}
+#
+# hosted on external sites:
+# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+#
+#}
+{% include 'overall_header.html' %}
+
+<div class="side-segment">
+	<h3>{PAGE_TITLE}</h3>
+</div>
+<div class="well">
+	{{ PAGE_CONTENT }}
+</div>
+{% EVENT phpbb_pages_after_page_content %}
+
+{% include 'overall_footer.html' %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_after.html"
@@ -0,0 +1,9 @@
+{% if S_NAVBAR_HEADER_QUICK_LINKS_AFTER %}
+	{% for link in navbar_header_quick_links_after_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }}"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/navbar_header_quick_links_before.html"
@@ -0,0 +1,9 @@
+{% if S_NAVBAR_HEADER_QUICK_LINKS_BEFORE %}
+	{% for link in navbar_header_quick_links_before_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }}"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_after.html"
@@ -0,0 +1,10 @@
+{# Note: we must use the before code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TEAMLINK_BEFORE %}
+	{% for link in overall_footer_teamlink_before_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_teamlink_before.html"
@@ -0,0 +1,10 @@
+{# Note: we must use the after code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TEAMLINK_AFTER %}
+	{% for link in overall_footer_teamlink_after_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_after.html"
@@ -0,0 +1,10 @@
+{# Note: we must use the before code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TIMEZONE_BEFORE %}
+	{% for link in overall_footer_timezone_before_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_footer_timezone_before.html"
@@ -0,0 +1,10 @@
+{# Note: we must use the after code so the link will appear in the expected location #}
+{% if S_OVERALL_FOOTER_TIMEZONE_AFTER %}
+	{% for link in overall_footer_timezone_after_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ overall_footer_timezone_before_links.LINK_ROUTE }} rightside"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="rightside"{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_after.html"
@@ -0,0 +1,7 @@
+{% if S_OVERALL_HEADER_BREADCRUMBS_AFTER %}
+	{% for link in overall_header_breadcrumbs_after_links %}
+		<li data-skip-responsive {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} breadcrumbs"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="breadcrumbs"{% endif %} itemscope itemtype="https://schema.org/BreadcrumbList">
+			<span class="crumb" {{ MICRODATA }}><a itemprop="item" href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}">{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span itemprop="name">{{ link.LINK_TITLE }}</span></a><meta itemprop="position" content="{{ navlink_position }}{% set navlink_position = navlink_position + 1 %}" /></span>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_breadcrumbs_before.html"
@@ -0,0 +1,7 @@
+{% if S_OVERALL_HEADER_BREADCRUMBS_BEFORE %}
+	{% for link in overall_header_breadcrumbs_before_links %}
+		<li data-skip-responsive {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} breadcrumbs"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% else %}class="breadcrumbs"{% endif %} itemscope itemtype="https://schema.org/BreadcrumbList">
+			<span class="crumb" {{ MICRODATA }}><a itemprop="item" href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}">{% if link.ICON_FONT %}<i class="icon fa-{{ link.ICON_FONT }} fa-fw" aria-hidden="true"></i>{% endif %}<span itemprop="name">{{ link.LINK_TITLE }}</span></a><meta itemprop="position" content="0" /></span>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1 @@
+{% INCLUDECSS '@phpbb_pages/pages_common.css' %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
@@ -0,0 +1,9 @@
+{% if S_OVERALL_HEADER_NAVIGATION_APPEND %}
+	{% for link in overall_header_navigation_append_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} no-bulletin"{% if link.ICON_LINK %} style="background-image:url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span></a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/event/overall_header_navigation_prepend.html"
@@ -0,0 +1,10 @@
+{% if S_OVERALL_HEADER_NAVIGATION_PREPEND %}
+	{% for link in overall_header_navigation_prepend_links %}
+		<li {% if not link.ICON_FONT %}class="small-icon icon-pages icon-page-{{ link.LINK_ROUTE }} no-bulletin"{% if link.ICON_LINK %} style="background-image: url('{{ T_THEME_PATH }}/images/{{ link.ICON_LINK }}');"{% endif %}{% endif %}>
+			<a href="{{ link.U_LINK_URL }}" title="{{ link.LINK_DESC }}" role="menuitem">
+				{% if not link.ICON_FONT %}<i class="fa fa-link"></i>{% endif %}
+				{% if link.ICON_FONT %}<i class="fa fa-{{ link.ICON_FONT }}" aria-hidden="true"></i>{% endif %}<span>{{ link.LINK_TITLE }}</span>
+			</a>
+		</li>
+	{% endfor %}
+{% endif %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/pages_blank.html"
@@ -0,0 +1,23 @@
+{# Use the space below to include external CSS and JS files
+# Here are some example usages:
+#
+# local files relative to this template file (when stored inside phpBB's style directories):
+# {% INCLUDEJS 'script.js' %}
+# {% INCLUDECSS 'style.css' %}
+#
+# local files stored inside the Pages extension:
+# {% INCLUDEJS '@phpbb_pages/script.js' %}
+# {% INCLUDECSS '@phpbb_pages/style.css' %}
+#
+# hosted on external sites:
+# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+#
+#}
+{% include 'overall_header.html' %}
+
+	{{ PAGE_CONTENT }}
+
+{% EVENT phpbb_pages_after_page_content %}
+
+{% include 'overall_footer.html' %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/pages_default.html" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/pages_default.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/template/pages_default.html"
@@ -0,0 +1,27 @@
+{# Use the space below to include external CSS and JS files
+# Here are some example usages:
+#
+# local files relative to this template file (when stored inside phpBB's style directories):
+# {% INCLUDEJS 'script.js' %}
+# {% INCLUDECSS 'style.css' %}
+#
+# local files stored inside the Pages extension:
+# {% INCLUDEJS '@phpbb_pages/script.js' %}
+# {% INCLUDECSS '@phpbb_pages/style.css' %}
+#
+# hosted on external sites:
+# {% INCLUDEJS 'http://code.jquery.com/jquery-migrate-1.2.1.min.js' %}
+# {% INCLUDECSS 'https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' %}
+#
+#}
+{% include 'overall_header.html' %}
+
+<div class="side-segment">
+	<h3>{PAGE_TITLE}</h3>
+</div>
+<div class="well">
+	{{ PAGE_CONTENT }}
+</div>
+{% EVENT phpbb_pages_after_page_content %}
+
+{% include 'overall_footer.html' %}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\pages/styles/FLATBOOTS/theme/images/icon_pages.gif" differ
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/pages_common.css"
@@ -0,0 +1,17 @@
+.icon-pages {
+	background: url("./images/icon_pages.gif") no-repeat 0 50%;
+}
+
+li.breadcrumbs.icon-pages span:first-child > a {
+	display: inline-block;
+	padding-left: 17px;
+}
+
+.rtl .icon-pages {
+	background-position: 100% 50%;
+}
+
+.rtl li.breadcrumbs.icon-pages span:first-child > a {
+	padding-right: 19px;
+	padding-left: 0;
+}
diff --git "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css" "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\pages/styles/FLATBOOTS/theme/pages_controller.css"
@@ -0,0 +1,51 @@
+.content p,
+.content h1,
+.content h2,
+.content h3,
+.content h4 {
+	font: inherit;
+	font-size: 100%;
+	line-height: 1.3em;
+	vertical-align: baseline;
+	text-transform: none;
+	border: 0;
+	color: inherit;
+	margin: 0;
+	padding: 0;
+}
+
+.pages-content {
+	font-size: 1.25em;
+	line-height: 1.3em;
+}
+
+.pages-content h1 {
+	font-size: 2em;
+}
+
+.pages-content h2 {
+	font-size: 1.5em;
+}
+
+.pages-content h3 {
+	font-size: 1.17em;
+}
+
+.pages-content h4 {
+	font-size: 1em;
+}
+
+.pages-content h5 {
+	font-size: 0.83em;
+}
+
+.pages-content h6 {
+	font-size: 0.75em;
+}
+
+.pages-content .postimage {
+	-moz-box-sizing: border-box;
+	-webkit-box-sizing: border-box;
+	box-sizing: border-box;
+	max-width: 100%;
+}
diff --git "[ORIGINAL]/phpbb\\pages/textreparser/cron_text_reparser_factory.php" "[ORIGINAL]/phpbb\\pages/textreparser/cron_text_reparser_factory.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\pages/textreparser/cron_text_reparser_factory.php"
+++ /dev/null
@@ -1,90 +0,0 @@
-<?php
-/**
- *
- * Pages extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2025 phpBB Limited <https://www.phpbb.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace phpbb\pages\textreparser;
-
-/**
- * Factory for creating cron text reparser task instances
- *
- * This factory handles the dynamic creation of text reparser tasks,
- * ensuring compatibility with different phpBB versions by using reflection
- * to determine and provide the correct constructor arguments.
- */
-class cron_text_reparser_factory
-{
-	/**
-	 * Creates a new instance of the text reparser cron task
-	 *
-	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container Service container
-	 * @return \phpbb\cron\task\text_reparser\reparser Configured a text reparser cron task
-	 * @throws \ReflectionException If the reparser class cannot be reflected
-	 */
-	public function create($container)
-	{
-		$args = $this->get_constructor_arguments($container);
-
-		// Using ReflectionClass to instantiate with a variable number of arguments
-		$reflection = new \ReflectionClass(\phpbb\cron\task\text_reparser\reparser::class);
-		$reparser = $reflection->newInstanceArgs($args);
-
-		$reparser->set_name('cron.task.text_reparser.phpbb_pages');
-		$reparser->set_reparser('phpbb.pages.text_reparser.page_text');
-		return $reparser;
-	}
-
-	/**
-	 * Gets the constructor arguments for the reparser based on reflection
-	 *
-	 * @param \Symfony\Component\DependencyInjection\ContainerInterface $container Service container
-	 * @return array Array of constructor arguments
-	 * @throws \ReflectionException If the reparser class cannot be reflected
-	 */
-	private function get_constructor_arguments($container)
-	{
-		$reflection = new \ReflectionClass(\phpbb\cron\task\text_reparser\reparser::class);
-		$constructor = $reflection->getConstructor();
-		$params = $constructor->getParameters();
-
-		$arguments = array();
-		foreach ($params as $param)
-		{
-			$service_name = $this->get_service_name($param->getName());
-			if ($container->has($service_name))
-			{
-				$arguments[] = $container->get($service_name);
-			}
-			else if ($param->isOptional())
-			{
-				$arguments[] = $param->getDefaultValue();
-			}
-		}
-
-		return $arguments;
-	}
-
-	/**
-	 * Maps parameter names to their corresponding service IDs
-	 *
-	 * @param string $param_name Name of the parameter from the constructor
-	 * @return string Service ID corresponding to the parameter
-	 */
-	private function get_service_name($param_name)
-	{
-		$serviceMap = [
-			'config'				=> 'config',
-			'config_text'		=> 'config_text',
-			'reparse_lock'		=> 'text_reparser.lock',
-			'reparser_manager'	=> 'text_reparser.manager',
-			'reparsers'			=> 'text_reparser_collection'
-		];
-
-		return $serviceMap[$param_name] ?? $param_name;
-	}
-}
```
