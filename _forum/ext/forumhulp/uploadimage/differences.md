Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/forumhulp\\uploadimage/.travis.yml" "[FORUM_EXT]/forumhulp\\uploadimage/.travis.yml"
--- "[ORIGINAL]/forumhulp\\uploadimage/.travis.yml"
+++ "[FORUM_EXT]/forumhulp\\uploadimage/.travis.yml"
@@ -8,21 +8,15 @@ matrix:
   include:
     - php: 5.5
       env: DB=none;NOTESTS=1
-    - php: 5.3
-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
     - php: 5.4
-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
-    - php: 5.5
-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
-    - php: 5.5
       env: DB=mysqli #myisam
-    - php: 5.5
+    - php: 5.4
       env: DB=mysql
-    - php: 5.5
+    - php: 5.4
       env: DB=mariadb
-    - php: 5.5
+    - php: 5.4
       env: DB=postgres
-    - php: 5.5
+    - php: 5.4
       env: DB=sqlite3
     - php: 5.5
       env: DB=mysqli
@@ -32,14 +26,13 @@ matrix:
       env: DB=mysqli
     - php: 7.1
       env: DB=mysqli
-    - php: 7.2
-      env: DB=mysqli
-    - php: 7.2
-      env: PHPBB_BRANCH="master";DB=mysqli
     - php: nightly
-      env: PHPBB_BRANCH="master";DB=mysqli
+      env: DB=mysqli
+    - php: hhvm
+      env: DB=mysqli
   allow_failures:
-    - env: PHPBB_BRANCH="master";DB=mysqli
+    - php: nightly
+    - php: hhvm
   fast_finish: true
 
 env:
@@ -55,8 +48,6 @@ branches:
     - master
     - develop
     - /^develop-.*$/
-    - /^.*_prep$/
-    - /^\d+(\.\d+)?\.x$/
 
 before_install:
   - sudo mkdir travis
diff --git "[ORIGINAL]/forumhulp\\uploadimage/composer.json" "[FORUM_EXT]/forumhulp\\uploadimage/composer.json"
--- "[ORIGINAL]/forumhulp\\uploadimage/composer.json"
+++ "[FORUM_EXT]/forumhulp\\uploadimage/composer.json"
@@ -25,8 +25,8 @@
         },
         "version-check": {
             "host": "forumhulp.com",
-            "directory": "/versioncheck",
-            "filename": "upload-image"
+            "directory": "/ext",
+            "filename": "index.php?id=40"
         }
     }
 }
diff --git "[ORIGINAL]/forumhulp\\uploadimage/config/services.yml" "[FORUM_EXT]/forumhulp\\uploadimage/config/services.yml"
--- "[ORIGINAL]/forumhulp\\uploadimage/config/services.yml"
+++ "[FORUM_EXT]/forumhulp\\uploadimage/config/services.yml"
@@ -2,15 +2,15 @@ services:
     forumhulp.uploadimage.admin.controller:
         class: forumhulp\uploadimage\controller\admin_controller
         arguments:
-            - @config
-            - @request
-            - @user
-            - @service_container
-            - @template
-            - @path_helper
-            - @cache
-            - @pagination
-            - @log
-            - @plupload
-            - %core.root_path%
-            - %core.php_ext%
+            - '@config'
+            - '@request'
+            - '@user'
+            - '@service_container'
+            - '@template'
+            - '@path_helper'
+            - '@cache'
+            - '@pagination'
+            - '@log'
+            - '@plupload'
+            - '%core.root_path%'
+            - '%core.php_ext%'
diff --git "[ORIGINAL]/forumhulp\\uploadimage/controller/admin_controller.php" "[FORUM_EXT]/forumhulp\\uploadimage/controller/admin_controller.php"
--- "[ORIGINAL]/forumhulp\\uploadimage/controller/admin_controller.php"
+++ "[FORUM_EXT]/forumhulp\\uploadimage/controller/admin_controller.php"
@@ -117,7 +117,7 @@ class admin_controller
 
 		$image_list = array();
 		$image_count = $dir_size = 0;
-		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($image_path, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
+		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(  str_replace('\\', '/', realpath($image_path)), \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
 		foreach ($iterator as $file_info)
 		{
 			$file_path = $file_info->getPath();
diff --git "[FORUM_EXT]/forumhulp\\uploadimage/diff_full.tmp" "[FORUM_EXT]/forumhulp\\uploadimage/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\uploadimage/diff_full.tmp"
@@ -0,0 +1,234 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
+index efe2d3f47..1cbdc4a30 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
+@@ -8,21 +8,15 @@ matrix:
+   include:
+     - php: 5.5
+       env: DB=none;NOTESTS=1
+-    - php: 5.3
+-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+     - php: 5.4
+-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+-    - php: 5.5
+-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+-    - php: 5.5
+       env: DB=mysqli #myisam
+-    - php: 5.5
++    - php: 5.4
+       env: DB=mysql
+-    - php: 5.5
++    - php: 5.4
+       env: DB=mariadb
+-    - php: 5.5
++    - php: 5.4
+       env: DB=postgres
+-    - php: 5.5
++    - php: 5.4
+       env: DB=sqlite3
+     - php: 5.5
+       env: DB=mysqli
+@@ -32,14 +26,13 @@ matrix:
+       env: DB=mysqli
+     - php: 7.1
+       env: DB=mysqli
+-    - php: 7.2
+-      env: DB=mysqli
+-    - php: 7.2
+-      env: PHPBB_BRANCH="master";DB=mysqli
+     - php: nightly
+-      env: PHPBB_BRANCH="master";DB=mysqli
++      env: DB=mysqli
++    - php: hhvm
++      env: DB=mysqli
+   allow_failures:
+-    - env: PHPBB_BRANCH="master";DB=mysqli
++    - php: nightly
++    - php: hhvm
+   fast_finish: true
+ 
+ env:
+@@ -55,8 +48,6 @@ branches:
+     - master
+     - develop
+     - /^develop-.*$/
+-    - /^.*_prep$/
+-    - /^\d+(\.\d+)?\.x$/
+ 
+ before_install:
+   - sudo mkdir travis
+@@ -79,4 +70,4 @@ script:
+   - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
+   - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
+   - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
+\ No newline at end of file
++  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
+index 6e57e8b8f..b8a6884e0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
+@@ -25,8 +25,8 @@
+         },
+         "version-check": {
+             "host": "forumhulp.com",
+-            "directory": "/versioncheck",
+-            "filename": "upload-image"
++            "directory": "/ext",
++            "filename": "index.php?id=40"
+         }
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
+index 77bb3e7ef..d8d44810c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
+@@ -2,15 +2,15 @@ services:
+     forumhulp.uploadimage.admin.controller:
+         class: forumhulp\uploadimage\controller\admin_controller
+         arguments:
+-            - @config
+-            - @request
+-            - @user
+-            - @service_container
+-            - @template
+-            - @path_helper
+-            - @cache
+-            - @pagination
+-            - @log
+-            - @plupload
+-            - %core.root_path%
+-            - %core.php_ext%
++            - '@config'
++            - '@request'
++            - '@user'
++            - '@service_container'
++            - '@template'
++            - '@path_helper'
++            - '@cache'
++            - '@pagination'
++            - '@log'
++            - '@plupload'
++            - '%core.root_path%'
++            - '%core.php_ext%'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/controller/admin_controller.php"
+index dd34dd031..8b0df2593 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/controller/admin_controller.php"
+@@ -117,7 +117,7 @@ class admin_controller
+ 
+ 		$image_list = array();
+ 		$image_count = $dir_size = 0;
+-		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($image_path, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
++		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(  str_replace('\\', '/', realpath($image_path)), \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
+ 		foreach ($iterator as $file_info)
+ 		{
+ 			$file_path = $file_info->getPath();
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp"
+new file mode 100644
+index 000000000..4bdec0d10
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp"
+@@ -0,0 +1,101 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
++index efe2d3f47..1cbdc4a30 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
++@@ -8,21 +8,15 @@ matrix:
++   include:
++     - php: 5.5
++       env: DB=none;NOTESTS=1
++-    - php: 5.3
++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
++     - php: 5.4
++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
++-    - php: 5.5
++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
++-    - php: 5.5
++       env: DB=mysqli #myisam
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=mysql
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=mariadb
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=postgres
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=sqlite3
++     - php: 5.5
++       env: DB=mysqli
++@@ -32,14 +26,13 @@ matrix:
++       env: DB=mysqli
++     - php: 7.1
++       env: DB=mysqli
++-    - php: 7.2
++-      env: DB=mysqli
++-    - php: 7.2
++-      env: PHPBB_BRANCH="master";DB=mysqli
++     - php: nightly
++-      env: PHPBB_BRANCH="master";DB=mysqli
+++      env: DB=mysqli
+++    - php: hhvm
+++      env: DB=mysqli
++   allow_failures:
++-    - env: PHPBB_BRANCH="master";DB=mysqli
+++    - php: nightly
+++    - php: hhvm
++   fast_finish: true
++ 
++ env:
++@@ -55,8 +48,6 @@ branches:
++     - master
++     - develop
++     - /^develop-.*$/
++-    - /^.*_prep$/
++-    - /^\d+(\.\d+)?\.x$/
++ 
++ before_install:
++   - sudo mkdir travis
++@@ -79,4 +70,4 @@ script:
++   - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
++   - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
++   - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
++\ No newline at end of file
+++  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
++index 6e57e8b8f..b8a6884e0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
++@@ -25,8 +25,8 @@
++         },
++         "version-check": {
++             "host": "forumhulp.com",
++-            "directory": "/versioncheck",
++-            "filename": "upload-image"
+++            "directory": "/ext",
+++            "filename": "index.php?id=40"
++         }
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
++index 77bb3e7ef..d8d44810c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
++@@ -2,15 +2,15 @@ services:
++     forumhulp.uploadimage.admin.controller:
++         class: forumhulp\uploadimage\controller\admin_controller
++         arguments:
++-            - @config
++-            - @request
++-            - @user
++-            - @service_container
++-            - @template
++-            - @path_helper
++-            - @cache
++-            - @pagination
++-            - @log
++-            - @plupload
++-            - %core.root_path%
++-      
+\ No newline at end of file
diff --git "[FORUM_EXT]/forumhulp\\uploadimage/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\uploadimage/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\uploadimage/diff_nospace.tmp"
@@ -0,0 +1,273 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
+index efe2d3f47..1cbdc4a30 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
+@@ -8,21 +8,15 @@ matrix:
+   include:
+     - php: 5.5
+       env: DB=none;NOTESTS=1
+-    - php: 5.3
+-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+     - php: 5.4
+-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+-    - php: 5.5
+-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+-    - php: 5.5
+       env: DB=mysqli #myisam
+-    - php: 5.5
++    - php: 5.4
+       env: DB=mysql
+-    - php: 5.5
++    - php: 5.4
+       env: DB=mariadb
+-    - php: 5.5
++    - php: 5.4
+       env: DB=postgres
+-    - php: 5.5
++    - php: 5.4
+       env: DB=sqlite3
+     - php: 5.5
+       env: DB=mysqli
+@@ -32,14 +26,13 @@ matrix:
+       env: DB=mysqli
+     - php: 7.1
+       env: DB=mysqli
+-    - php: 7.2
+-      env: DB=mysqli
+-    - php: 7.2
+-      env: PHPBB_BRANCH="master";DB=mysqli
+     - php: nightly
+-      env: PHPBB_BRANCH="master";DB=mysqli
++      env: DB=mysqli
++    - php: hhvm
++      env: DB=mysqli
+   allow_failures:
+-    - env: PHPBB_BRANCH="master";DB=mysqli
++    - php: nightly
++    - php: hhvm
+   fast_finish: true
+ 
+ env:
+@@ -55,8 +48,6 @@ branches:
+     - master
+     - develop
+     - /^develop-.*$/
+-    - /^.*_prep$/
+-    - /^\d+(\.\d+)?\.x$/
+ 
+ before_install:
+   - sudo mkdir travis
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
+index 6e57e8b8f..b8a6884e0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
+@@ -25,8 +25,8 @@
+         },
+         "version-check": {
+             "host": "forumhulp.com",
+-            "directory": "/versioncheck",
+-            "filename": "upload-image"
++            "directory": "/ext",
++            "filename": "index.php?id=40"
+         }
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
+index 77bb3e7ef..d8d44810c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
+@@ -2,15 +2,15 @@ services:
+     forumhulp.uploadimage.admin.controller:
+         class: forumhulp\uploadimage\controller\admin_controller
+         arguments:
+-            - @config
+-            - @request
+-            - @user
+-            - @service_container
+-            - @template
+-            - @path_helper
+-            - @cache
+-            - @pagination
+-            - @log
+-            - @plupload
+-            - %core.root_path%
+-            - %core.php_ext%
++            - '@config'
++            - '@request'
++            - '@user'
++            - '@service_container'
++            - '@template'
++            - '@path_helper'
++            - '@cache'
++            - '@pagination'
++            - '@log'
++            - '@plupload'
++            - '%core.root_path%'
++            - '%core.php_ext%'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/controller/admin_controller.php"
+index dd34dd031..8b0df2593 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/controller/admin_controller.php"
+@@ -117,7 +117,7 @@ class admin_controller
+ 
+ 		$image_list = array();
+ 		$image_count = $dir_size = 0;
+-		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($image_path, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
++		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(  str_replace('\\', '/', realpath($image_path)), \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
+ 		foreach ($iterator as $file_info)
+ 		{
+ 			$file_path = $file_info->getPath();
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp"
+new file mode 100644
+index 000000000..06be09005
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp"
+@@ -0,0 +1,234 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
++index efe2d3f47..1cbdc4a30 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
++@@ -8,21 +8,15 @@ matrix:
++   include:
++     - php: 5.5
++       env: DB=none;NOTESTS=1
++-    - php: 5.3
++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
++     - php: 5.4
++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
++-    - php: 5.5
++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
++-    - php: 5.5
++       env: DB=mysqli #myisam
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=mysql
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=mariadb
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=postgres
++-    - php: 5.5
+++    - php: 5.4
++       env: DB=sqlite3
++     - php: 5.5
++       env: DB=mysqli
++@@ -32,14 +26,13 @@ matrix:
++       env: DB=mysqli
++     - php: 7.1
++       env: DB=mysqli
++-    - php: 7.2
++-      env: DB=mysqli
++-    - php: 7.2
++-      env: PHPBB_BRANCH="master";DB=mysqli
++     - php: nightly
++-      env: PHPBB_BRANCH="master";DB=mysqli
+++      env: DB=mysqli
+++    - php: hhvm
+++      env: DB=mysqli
++   allow_failures:
++-    - env: PHPBB_BRANCH="master";DB=mysqli
+++    - php: nightly
+++    - php: hhvm
++   fast_finish: true
++ 
++ env:
++@@ -55,8 +48,6 @@ branches:
++     - master
++     - develop
++     - /^develop-.*$/
++-    - /^.*_prep$/
++-    - /^\d+(\.\d+)?\.x$/
++ 
++ before_install:
++   - sudo mkdir travis
++@@ -79,4 +70,4 @@ script:
++   - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
++   - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
++   - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
++\ No newline at end of file
+++  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
++index 6e57e8b8f..b8a6884e0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/composer.json"
++@@ -25,8 +25,8 @@
++         },
++         "version-check": {
++             "host": "forumhulp.com",
++-            "directory": "/versioncheck",
++-            "filename": "upload-image"
+++            "directory": "/ext",
+++            "filename": "index.php?id=40"
++         }
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
++index 77bb3e7ef..d8d44810c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/config/services.yml"
++@@ -2,15 +2,15 @@ services:
++     forumhulp.uploadimage.admin.controller:
++         class: forumhulp\uploadimage\controller\admin_controller
++         arguments:
++-            - @config
++-            - @request
++-            - @user
++-            - @service_container
++-            - @template
++-            - @path_helper
++-            - @cache
++-            - @pagination
++-            - @log
++-            - @plupload
++-            - %core.root_path%
++-            - %core.php_ext%
+++            - '@config'
+++            - '@request'
+++            - '@user'
+++            - '@service_container'
+++            - '@template'
+++            - '@path_helper'
+++            - '@cache'
+++            - '@pagination'
+++            - '@log'
+++            - '@plupload'
+++            - '%core.root_path%'
+++            - '%core.php_ext%'
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/controller/admin_controller.php"
++index dd34dd031..8b0df2593 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/controller/admin_controller.php"
++@@ -117,7 +117,7 @@ class admin_controller
++ 
++ 		$image_list = array();
++ 		$image_count = $dir_size = 0;
++-		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($image_path, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
+++		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(  str_replace('\\', '/', realpath($image_path)), \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::UNIX_PATHS), \RecursiveIteratorIterator::SELF_FIRST);
++ 		foreach ($iterator as $file_info)
++ 		{
++ 			$file_path = $file_info->getPath();
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp"
++new file mode 100644
++index 000000000..4bdec0d10
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/diff_full.tmp"
++@@ -0,0 +1,101 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
+++index efe2d3f47..1cbdc4a30 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\uploadimage/.travis.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\uploadimage/.travis.yml"
+++@@ -8,21 +8,15 @@ matrix:
+++   include:
+++     - php: 5.5
+++       env: DB=none;NOTESTS=1
+++-    - php: 5.3
+++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+++     - php: 5.4
+++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+++-    - php: 5.5
+++-      env: PHPBB_BRANCH="3.1.x";DB=mysqli
+++-    - php: 5.5
+++       
\ No newline at end of file
```
