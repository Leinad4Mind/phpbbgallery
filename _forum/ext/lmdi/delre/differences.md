Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/lmdi\\delre/README.md" "[FORUM_EXT]/lmdi\\delre/README.md"
--- "[ORIGINAL]/lmdi\\delre/README.md"
+++ "[FORUM_EXT]/lmdi\\delre/README.md"
@@ -5,7 +5,7 @@
 1. Download the latest release.
 2. Unzip the downloaded release, and change the name of the folder to `delre`.
 3. In the `ext` directory of your phpBB board, create a new directory named `lmdi` (if it does not already exist).
-4. Copy the `delre` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/lmdi/delre/composer.json).
+4. Copy the `prevnext` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/dmzx/prevnext/composer.json).
 5. Navigate in the ACP to `Customise -> Manage extensions`.
 6. Look for `Delete Re:` under the Disabled Extensions list, and click its `Enable` link.
 
diff --git "[ORIGINAL]/lmdi\\delre/composer.json" "[FORUM_EXT]/lmdi\\delre/composer.json"
--- "[ORIGINAL]/lmdi\\delre/composer.json"
+++ "[FORUM_EXT]/lmdi\\delre/composer.json"
@@ -2,15 +2,15 @@
     "name": "lmdi/delre",
     "type": "phpbb-extension",
     "description": "Deletes the 'Re:' prefix in subject lines",
-	"homepage": "https://www.insecte.org/ext/readme.txt",
-	"version": "1.0.11",
-	"time": "2022-11-30",
-	"license": "GPL-2.0-only",
+    "homepage": "http://www.insecte.org/ext/readme.txt",
+    "version": "1.0.7",
+    "time": "2016-7-22",
+    "license": "GPL-2.0",
     "authors": [
         {
             "name": "Pierre Duhem",
             "email": "pierre@duhem.com",
-		"homepage": "https://www.insecte.org/ext/readme.txt",
+            "homepage": "http://www.insecte.org/ext/readme.txt",
             "role": "Extension Developer"
         },
         {
@@ -20,13 +20,19 @@
         }
     ],
     "require": {
-		"php": ">=7.1.3",
-		"composer/installers": "~1.0"
+        "php": ">=5.3.3",
+        "composer/installers": "~1.0",
+        "phpbb/phpbb": ">=3.1.0"
     },
     "extra": {
         "display-name": "LMDI Delete Re:",
         "soft-require": {
-			"phpbb/phpbb": ">=3.3.0"
+            "phpbb/phpbb": ">=3.1.0"
+        },
+        "version-check": {
+            "host": "www.phpbb.com",
+            "directory": "/customise/db/extension/delre",
+            "filename": "version_check"
         }
     }
 }
\ No newline at end of file
diff --git "[FORUM_EXT]/lmdi\\delre/diff_full.tmp" "[FORUM_EXT]/lmdi\\delre/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lmdi\\delre/diff_full.tmp"
@@ -0,0 +1,177 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/README.md"
+index c5c8a2e32..da411bcf8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/README.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/README.md"
+@@ -5,7 +5,7 @@
+ 1. Download the latest release.
+ 2. Unzip the downloaded release, and change the name of the folder to `delre`.
+ 3. In the `ext` directory of your phpBB board, create a new directory named `lmdi` (if it does not already exist).
+-4. Copy the `delre` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/lmdi/delre/composer.json).
++4. Copy the `prevnext` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/dmzx/prevnext/composer.json).
+ 5. Navigate in the ACP to `Customise -> Manage extensions`.
+ 6. Look for `Delete Re:` under the Disabled Extensions list, and click its `Enable` link.
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/composer.json"
+index adc660fbb..da75438dd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/composer.json"
+@@ -1,32 +1,38 @@
+ {
+-	"name": "lmdi/delre",
+-	"type": "phpbb-extension",
+-	"description": "Deletes the 'Re:' prefix in subject lines",
+-	"homepage": "https://www.insecte.org/ext/readme.txt",
+-	"version": "1.0.11",
+-	"time": "2022-11-30",
+-	"license": "GPL-2.0-only",
+-	"authors": [
+-		{
+-		"name": "Pierre Duhem",
+-		"email": "pierre@duhem.com",
+-		"homepage": "https://www.insecte.org/ext/readme.txt",
+-		"role": "Extension Developer"
+-		},
+-		{
+-		"name": "kasimi",
+-		"homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
+-		"role": "Solution for managing the quick reply editor"
+-		}
+-	],
+-	"require": {
+-		"php": ">=7.1.3",
+-		"composer/installers": "~1.0"
+-	},
+-	"extra": {
+-		"display-name": "LMDI Delete Re:",
+-		"soft-require": {
+-			"phpbb/phpbb": ">=3.3.0"
+-		}
+-	}
+-}
++    "name": "lmdi/delre",
++    "type": "phpbb-extension",
++    "description": "Deletes the 'Re:' prefix in subject lines",
++    "homepage": "http://www.insecte.org/ext/readme.txt",
++    "version": "1.0.7",
++    "time": "2016-7-22",
++    "license": "GPL-2.0",
++    "authors": [
++        {
++            "name": "Pierre Duhem",
++            "email": "pierre@duhem.com",
++            "homepage": "http://www.insecte.org/ext/readme.txt",
++            "role": "Extension Developer"
++        },
++        {
++            "name": "kasimi",
++            "homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
++            "role": "Solution for managing the quick reply editor"
++        }
++    ],
++    "require": {
++        "php": ">=5.3.3",
++        "composer/installers": "~1.0",
++        "phpbb/phpbb": ">=3.1.0"
++    },
++    "extra": {
++        "display-name": "LMDI Delete Re:",
++        "soft-require": {
++            "phpbb/phpbb": ">=3.1.0"
++        },
++        "version-check": {
++            "host": "www.phpbb.com",
++            "directory": "/customise/db/extension/delre",
++            "filename": "version_check"
++        }
++    }
++}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/event/listener.php"
+index 97abcbd6c..c49a7f1ee 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/event/listener.php"
+@@ -1,23 +1,22 @@
+ <?php
+ /**
+- *
+- * @package phpBB Extension - LMDI Delete Re:
+- * @copyright (c) 2015-2022 LMDI - Pierre Duhem
+- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+- *
+- */
++*
++* @package phpBB Extension - LMDI Delete Re:
++* @copyright (c) 2015-2016 LMDI - Pierre Duhem
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
+ 
+ namespace lmdi\delre\event;
+ 
+ /**
+- * @ignore
+- */
+-
++* @ignore
++*/
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ 
+ /**
+- * Event listener
+- */
++* Event listener
++*/
+ class listener implements EventSubscriberInterface
+ {
+ 
+@@ -29,19 +28,15 @@ class listener implements EventSubscriberInterface
+ 		$this->template = $template;
+ 	}
+ 
+-
+-	static public function getSubscribedEvents()
++	static public function getSubscribedEvents ()
+ 	{
+ 	return array(
+-		'core.posting_modify_template_vars'	=> 'delete_re',
+-		'core.viewtopic_modify_page_title'	=> 'delete_re_2',
+-		'core.pm_modify_message_subject'	=> 'delete_re_pm',
++		'core.posting_modify_template_vars' => 'delete_re',
++		'core.viewtopic_modify_page_title' => 'delete_re_2',
+ 	);
+ 	}
+ 
+-
+-	// Normal reply
+-	public function delete_re($event)
++	public function delete_re ($event)
+ 	{
+ 		$page_data = $event['page_data'];
+ 		$titre = $page_data['SUBJECT'];
+@@ -50,22 +45,10 @@ class listener implements EventSubscriberInterface
+ 		$event['page_data'] = $page_data;
+ 	}
+ 
+-
+-	// Quick reply
+-	public function delete_re_2($event)
++	public function delete_re_2 ($event)
+ 	{
+ 		$topic_data = $event['topic_data'];
+ 		$this->template->assign_var('SUBJECT', censor_text($topic_data['topic_title']));
+ 	}
+ 
+-
+-	// PM reply
+-	public function delete_re_pm($event)
+-	{
+-		$titre = $event['message_subject'];
+-		$titre = preg_replace('/^Re: /', '', $titre);
+-		$event['message_subject'] = $titre;
+-	}
+-
+-
+ }
diff --git "[FORUM_EXT]/lmdi\\delre/diff_nospace.tmp" "[FORUM_EXT]/lmdi\\delre/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lmdi\\delre/diff_nospace.tmp"
@@ -0,0 +1,186 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/README.md"
+index c5c8a2e32..da411bcf8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/README.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/README.md"
+@@ -5,7 +5,7 @@
+ 1. Download the latest release.
+ 2. Unzip the downloaded release, and change the name of the folder to `delre`.
+ 3. In the `ext` directory of your phpBB board, create a new directory named `lmdi` (if it does not already exist).
+-4. Copy the `delre` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/lmdi/delre/composer.json).
++4. Copy the `prevnext` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/dmzx/prevnext/composer.json).
+ 5. Navigate in the ACP to `Customise -> Manage extensions`.
+ 6. Look for `Delete Re:` under the Disabled Extensions list, and click its `Enable` link.
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/composer.json"
+index adc660fbb..da75438dd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/composer.json"
+@@ -2,15 +2,15 @@
+     "name": "lmdi/delre",
+     "type": "phpbb-extension",
+     "description": "Deletes the 'Re:' prefix in subject lines",
+-	"homepage": "https://www.insecte.org/ext/readme.txt",
+-	"version": "1.0.11",
+-	"time": "2022-11-30",
+-	"license": "GPL-2.0-only",
++    "homepage": "http://www.insecte.org/ext/readme.txt",
++    "version": "1.0.7",
++    "time": "2016-7-22",
++    "license": "GPL-2.0",
+     "authors": [
+         {
+             "name": "Pierre Duhem",
+             "email": "pierre@duhem.com",
+-		"homepage": "https://www.insecte.org/ext/readme.txt",
++            "homepage": "http://www.insecte.org/ext/readme.txt",
+             "role": "Extension Developer"
+         },
+         {
+@@ -20,13 +20,19 @@
+         }
+     ],
+     "require": {
+-		"php": ">=7.1.3",
+-		"composer/installers": "~1.0"
++        "php": ">=5.3.3",
++        "composer/installers": "~1.0",
++        "phpbb/phpbb": ">=3.1.0"
+     },
+     "extra": {
+         "display-name": "LMDI Delete Re:",
+         "soft-require": {
+-			"phpbb/phpbb": ">=3.3.0"
++            "phpbb/phpbb": ">=3.1.0"
++        },
++        "version-check": {
++            "host": "www.phpbb.com",
++            "directory": "/customise/db/extension/delre",
++            "filename": "version_check"
+         }
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp"
+new file mode 100644
+index 000000000..2dfe8cb6d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp"
+@@ -0,0 +1,177 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/README.md"
++index c5c8a2e32..da411bcf8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/README.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/README.md"
++@@ -5,7 +5,7 @@
++ 1. Download the latest release.
++ 2. Unzip the downloaded release, and change the name of the folder to `delre`.
++ 3. In the `ext` directory of your phpBB board, create a new directory named `lmdi` (if it does not already exist).
++-4. Copy the `delre` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/lmdi/delre/composer.json).
+++4. Copy the `prevnext` folder to `phpBB/ext/lmdi/` (if done correctly, you'll have the main extension class at (your forum root)/ext/dmzx/prevnext/composer.json).
++ 5. Navigate in the ACP to `Customise -> Manage extensions`.
++ 6. Look for `Delete Re:` under the Disabled Extensions list, and click its `Enable` link.
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/composer.json"
++index adc660fbb..da75438dd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/composer.json"
++@@ -1,32 +1,38 @@
++ {
++-	"name": "lmdi/delre",
++-	"type": "phpbb-extension",
++-	"description": "Deletes the 'Re:' prefix in subject lines",
++-	"homepage": "https://www.insecte.org/ext/readme.txt",
++-	"version": "1.0.11",
++-	"time": "2022-11-30",
++-	"license": "GPL-2.0-only",
++-	"authors": [
++-		{
++-		"name": "Pierre Duhem",
++-		"email": "pierre@duhem.com",
++-		"homepage": "https://www.insecte.org/ext/readme.txt",
++-		"role": "Extension Developer"
++-		},
++-		{
++-		"name": "kasimi",
++-		"homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
++-		"role": "Solution for managing the quick reply editor"
++-		}
++-	],
++-	"require": {
++-		"php": ">=7.1.3",
++-		"composer/installers": "~1.0"
++-	},
++-	"extra": {
++-		"display-name": "LMDI Delete Re:",
++-		"soft-require": {
++-			"phpbb/phpbb": ">=3.3.0"
++-		}
++-	}
++-}
+++    "name": "lmdi/delre",
+++    "type": "phpbb-extension",
+++    "description": "Deletes the 'Re:' prefix in subject lines",
+++    "homepage": "http://www.insecte.org/ext/readme.txt",
+++    "version": "1.0.7",
+++    "time": "2016-7-22",
+++    "license": "GPL-2.0",
+++    "authors": [
+++        {
+++            "name": "Pierre Duhem",
+++            "email": "pierre@duhem.com",
+++            "homepage": "http://www.insecte.org/ext/readme.txt",
+++            "role": "Extension Developer"
+++        },
+++        {
+++            "name": "kasimi",
+++            "homepage": "https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1330603",
+++            "role": "Solution for managing the quick reply editor"
+++        }
+++    ],
+++    "require": {
+++        "php": ">=5.3.3",
+++        "composer/installers": "~1.0",
+++        "phpbb/phpbb": ">=3.1.0"
+++    },
+++    "extra": {
+++        "display-name": "LMDI Delete Re:",
+++        "soft-require": {
+++            "phpbb/phpbb": ">=3.1.0"
+++        },
+++        "version-check": {
+++            "host": "www.phpbb.com",
+++            "directory": "/customise/db/extension/delre",
+++            "filename": "version_check"
+++        }
+++    }
+++}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/event/listener.php"
++index 97abcbd6c..c49a7f1ee 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\delre/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\delre/event/listener.php"
++@@ -1,23 +1,22 @@
++ <?php
++ /**
++- *
++- * @package phpBB Extension - LMDI Delete Re:
++- * @copyright (c) 2015-2022 LMDI - Pierre Duhem
++- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++- *
++- */
+++*
+++* @package phpBB Extension - LMDI Delete Re:
+++* @copyright (c) 2015-2016 LMDI - Pierre Duhem
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
++ 
++ namespace lmdi\delre\event;
++ 
++ /**
++- * @ignore
++- */
++-
+++* @ignore
diff --git "[ORIGINAL]/lmdi\\delre/event/listener.php" "[FORUM_EXT]/lmdi\\delre/event/listener.php"
--- "[ORIGINAL]/lmdi\\delre/event/listener.php"
+++ "[FORUM_EXT]/lmdi\\delre/event/listener.php"
@@ -2,7 +2,7 @@
 /**
 *
 * @package phpBB Extension - LMDI Delete Re:
- * @copyright (c) 2015-2022 LMDI - Pierre Duhem
+* @copyright (c) 2015-2016 LMDI - Pierre Duhem
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */
@@ -12,7 +12,6 @@ namespace lmdi\delre\event;
 /**
 * @ignore
 */
-
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 
 /**
@@ -29,18 +28,14 @@ class listener implements EventSubscriberInterface
 		$this->template = $template;
 	}
 
-
 	static public function getSubscribedEvents ()
 	{
 	return array(
 		'core.posting_modify_template_vars' => 'delete_re',
 		'core.viewtopic_modify_page_title' => 'delete_re_2',
-		'core.pm_modify_message_subject'	=> 'delete_re_pm',
 	);
 	}
 
-
-	// Normal reply
 	public function delete_re ($event)
 	{
 		$page_data = $event['page_data'];
@@ -50,22 +45,10 @@ class listener implements EventSubscriberInterface
 		$event['page_data'] = $page_data;
 	}
 
-
-	// Quick reply
 	public function delete_re_2 ($event)
 	{
 		$topic_data = $event['topic_data'];
 		$this->template->assign_var('SUBJECT', censor_text($topic_data['topic_title']));
 	}
 
-
-	// PM reply
-	public function delete_re_pm($event)
-	{
-		$titre = $event['message_subject'];
-		$titre = preg_replace('/^Re: /', '', $titre);
-		$event['message_subject'] = $titre;
-	}
-
-
 }
```
