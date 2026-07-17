Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/tatiana5\\popuppm/.travis.yml" "[ORIGINAL]/tatiana5\\popuppm/.travis.yml"
deleted file mode 100644
--- "[ORIGINAL]/tatiana5\\popuppm/.travis.yml"
+++ /dev/null
@@ -1,65 +0,0 @@
-language: php
-dist: xenial
-
-matrix:
-  include:
-    - php: 7.1
-      env: DB=none;NOTESTS=1
-    - php: 7.1
-      env: DB=mariadb
-    - php: 7.1
-      env: DB=postgres
-    - php: 7.1
-      env: DB=sqlite3
-    - php: 7.1
-      env: DB=mysqli # MyISAM
-    - php: 7.2
-      env: DB=mysqli
-    - php: 7.3
-      env: DB=mysqli
-    - php: 7.4
-      env: DB=mysqli
-    - php: nightly
-      env: DB=mysqli
-  allow_failures:
-    - php: nightly
-  fast_finish: true
-
-env:
-  global:
-    - EXTNAME="Tatiana5/popuppm"  # CHANGE name of the extension HERE
-    - SNIFF="1"            # Should we run code sniffer on your code?
-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
-    - PHPBB_BRANCH="3.3.x"
-
-services:
-  - postgresql
-  - mysql
-
-branches:
-  only:
-    - master
-
-before_install:
-  - sudo mkdir travis
-  - git clone "https://github.com/phpbb/phpbb-ext-acme-demo.git"
-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
-  - sudo rm -rf phpbb-ext-acme-demo
-
-install:
-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
-  - cd ../../phpBB3
-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
-  - sh -c "if [ '$EPV' = '1' -a '$NOTESTS' = '1' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --no-interaction; composer require phpbb/epv:dev-master --no-interaction --ignore-platform-reqs; cd ../; fi"
-
-before_script:
-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
-
-script:
-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
-  - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
diff --git "[ORIGINAL]/tatiana5\\popuppm/composer.json" "[FORUM_EXT]/tatiana5\\popuppm/composer.json"
--- "[ORIGINAL]/tatiana5\\popuppm/composer.json"
+++ "[FORUM_EXT]/tatiana5\\popuppm/composer.json"
@@ -1,7 +1,7 @@
 {
 	"name": "tatiana5/popuppm",
 	"type": "phpbb-extension",
-    "description": "Popup on new PM and blink title",
+	"description": "Popup on new PM and blink title (User Disable By Default)",
 	"homepage": "http://www.phpbbguru.net/community/",
 	"version": "0.0.2",
 	"time": "2016-12-03",
diff --git "[FORUM_EXT]/tatiana5\\popuppm/diff_full.tmp" "[FORUM_EXT]/tatiana5\\popuppm/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/diff_full.tmp"
@@ -0,0 +1,763 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
+deleted file mode 100644
+index 06d26c89a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
++++ /dev/null
+@@ -1,65 +0,0 @@
+-language: php
+-dist: xenial
+-
+-matrix:
+-  include:
+-    - php: 7.1
+-      env: DB=none;NOTESTS=1
+-    - php: 7.1
+-      env: DB=mariadb
+-    - php: 7.1
+-      env: DB=postgres
+-    - php: 7.1
+-      env: DB=sqlite3
+-    - php: 7.1
+-      env: DB=mysqli # MyISAM
+-    - php: 7.2
+-      env: DB=mysqli
+-    - php: 7.3
+-      env: DB=mysqli
+-    - php: 7.4
+-      env: DB=mysqli
+-    - php: nightly
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: nightly
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="Tatiana5/popuppm"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.3.x"
+-
+-services:
+-  - postgresql
+-  - mysql
+-
+-branches:
+-  only:
+-    - master
+-
+-before_install:
+-  - sudo mkdir travis
+-  - git clone "https://github.com/phpbb/phpbb-ext-acme-demo.git"
+-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
+-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
+-  - sudo rm -rf phpbb-ext-acme-demo
+-
+-install:
+-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
+-  - sh -c "if [ '$EPV' = '1' -a '$NOTESTS' = '1' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --no-interaction; composer require phpbb/epv:dev-master --no-interaction --ignore-platform-reqs; cd ../; fi"
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
+-  - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
+index 02e970753..692d70716 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
+@@ -1,28 +1,28 @@
+ {
+-    "name": "tatiana5/popuppm",
+-    "type": "phpbb-extension",
+-    "description": "Popup on new PM and blink title",
+-    "homepage": "http://www.phpbbguru.net/community/",
+-    "version": "0.0.2",
+-    "time": "2016-12-03",
+-    "license": "GPL-2.0",
+-    "authors": [
+-        {
+-            "name": "Татьяна5",
+-            "homepage": "http://www.phpbbguru.net/community/",
+-            "role": "developer"
+-        }
+-    ],
+-    "require": {
+-        "php": ">=7.1.3"
+-    },
+-    "require-dev": {
+-      "phpbb/epv": "dev-master"
+-    },
+-    "extra": {
+-        "display-name": "Popup PM",
+-        "soft-require": {
+-            "phpbb/phpbb": "3.3"
+-        }
+-    }
++	"name": "tatiana5/popuppm",
++	"type": "phpbb-extension",
++	"description": "Popup on new PM and blink title (User Disable By Default)",
++	"homepage": "http://www.phpbbguru.net/community/",
++	"version": "0.0.2",
++	"time": "2016-12-03",
++	"license": "GPL-2.0",
++	"authors": [
++		{
++			"name": "Татьяна5",
++			"homepage": "http://www.phpbbguru.net/community/",
++			"role": "developer"
++		}
++	],
++	"require": {
++		"php": ">=7.1.3"
++	},
++	"require-dev": {
++		"phpbb/epv": "dev-master"
++	},
++	"extra": {
++		"display-name": "Popup PM",
++		"soft-require": {
++			"phpbb/phpbb": "3.3"
++		}
++	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp"
+new file mode 100644
+index 000000000..4c35f1026
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp"
+@@ -0,0 +1,114 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
++deleted file mode 100644
++index 06d26c89a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
+++++ /dev/null
++@@ -1,65 +0,0 @@
++-language: php
++-dist: xenial
++-
++-matrix:
++-  include:
++-    - php: 7.1
++-      env: DB=none;NOTESTS=1
++-    - php: 7.1
++-      env: DB=mariadb
++-    - php: 7.1
++-      env: DB=postgres
++-    - php: 7.1
++-      env: DB=sqlite3
++-    - php: 7.1
++-      env: DB=mysqli # MyISAM
++-    - php: 7.2
++-      env: DB=mysqli
++-    - php: 7.3
++-      env: DB=mysqli
++-    - php: 7.4
++-      env: DB=mysqli
++-    - php: nightly
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: nightly
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="Tatiana5/popuppm"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.3.x"
++-
++-services:
++-  - postgresql
++-  - mysql
++-
++-branches:
++-  only:
++-    - master
++-
++-before_install:
++-  - sudo mkdir travis
++-  - git clone "https://github.com/phpbb/phpbb-ext-acme-demo.git"
++-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
++-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
++-  - sudo rm -rf phpbb-ext-acme-demo
++-
++-install:
++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
++-  - sh -c "if [ '$EPV' = '1' -a '$NOTESTS' = '1' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --no-interaction; composer require phpbb/epv:dev-master --no-interaction --ignore-platform-reqs; cd ../; fi"
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
++-  - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
++index 02e970753..692d70716 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
++@@ -1,28 +1,28 @@
++ {
++-    "name": "tatiana5/popuppm",
++-    "type": "phpbb-extension",
++-    "description": "Popup on new PM and blink title",
++-    "homepage": "http://www.phpbbguru.net/community/",
++-    "version": "0.0.2",
++-    "time": "2016-12-03",
++-    "license": "GPL-2.0",
++-    "authors": [
++-        {
++-            "name": "Татьяна5",
++-            "homepage": "http://www.phpbbguru.net/community/",
++-            "role": "developer"
++-        }
++-    ],
++-    "require": {
++-        "php": ">=7.1.3"
++-    },
++-    "require-dev": {
++-      "phpbb/epv": "dev-master"
++-    },
++-    "extra": {
++-        "display-name": "Popup PM",
++-        "soft-require": {
++-            "phpbb/phpbb": "3.3"
++-        }
++-    }
+++	"name": "tatiana5/popuppm",
+++	"type": "phpbb-extension",
+++	"description": "Popup on new PM and blink title (User Disable By Default)",
+++	"homepage": "http://www.phpbbguru.net/community/",
+++	"version": "0.0.2",
+++	"time": "2016-12-03",
+++	"license": "GPL-2.0",
+++	"authors": [
+++		{
+++			"name": "Татьяна5",
+++			"homepage": "http
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/event/listener.php"
+index 1b426ed47..2d523bcef 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/event/listener.php"
+@@ -126,13 +126,18 @@ class listener implements EventSubscriberInterface
+ 			$row = $this->db->sql_fetchrow($result);
+ 			if (is_array($row) && !empty($row['msg_id']))
+ 			{
+-				if ($row['user_avatar'])
+-				{
++				if ($row['user_avatar']) {
+ 					$this->config['popuppm_avatar_dimentions'] = 50;
+-					$row['user_avatar_width'] = ($row['user_avatar_width'] > $row['user_avatar_height']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_height']) * $row['user_avatar_width'];
+-					$row['user_avatar_height'] = ($row['user_avatar_height'] > $row['user_avatar_width']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_width']) * $row['user_avatar_height'];
++
++					// Avoid division by zero using max function
++					$avatar_height = max($row['user_avatar_height'], 1); // Prevent division by zero
++					$avatar_width = max($row['user_avatar_width'], 1); // Prevent division by zero
++
++					$row['user_avatar_width'] = ($avatar_width > $avatar_height) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $avatar_height) * $avatar_width;
++					$row['user_avatar_height'] = ($avatar_height > $avatar_width) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $avatar_width) * $avatar_height;
+ 				}
+ 
++
+ 				if ($row['folder_id'] == PRIVMSGS_NO_BOX)
+ 				{
+ 					$row['folder_id'] = PRIVMSGS_INBOX;
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/language/en/popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/en/popuppm.php"
+index 3412d1f21..6106499a4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/language/en/popuppm.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/en/popuppm.php"
+@@ -23,10 +23,10 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, [
+ 	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
+ 		1 => '<<<! You have a new private message !>>>',
+-		2 => '<<<! You have the %s new private messages !>>>',
++		2 => '<<<! You have %s new private messages !>>>',
+ 	],
+ 	'POPUPPM_YOU_NEW_PM'			=> [
+ 		1 => 'You have a new private message',
+-		2 => 'You have the %s new private messages',
++		2 => 'You have %s new private messages',
+ 	],
+ ]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/info_acp_popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/info_acp_popuppm.php"
+new file mode 100644
+index 000000000..65f1aa2ca
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/info_acp_popuppm.php"
+@@ -0,0 +1,30 @@
++<?php
++/**
++ *
++ * @package       Popup PM
++ * @copyright (c) Татьяна5
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++$lang = array_merge($lang, [
++	'ACP_POPUPPM'                       => 'Popup MP',
++	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
++	'ACP_POPUPPM_TITLE'                 => 'Popup MP',
++
++	'ACP_POPUPPM_ENABLE_POPUP'             => 'Activar Popup em Novas MPs',
++	'ACP_POPUPPM_ENABLE_BLINK'             => 'Activar Título a Piscar',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/popuppm.php"
+new file mode 100644
+index 000000000..ce649cf7e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/popuppm.php"
+@@ -0,0 +1,32 @@
++<?php
++/**
++ *
++ * @package       Popup PM
++ * @copyright (c) Татьяна5
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++$lang = array_merge($lang, [
++	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
++		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
++		2 => '<<<! Tens %s novas mensagens privadas !>>>',
++	],
++	'POPUPPM_YOU_NEW_PM'			=> [
++		1 => 'Tens uma nova mensagem privada',
++		2 => 'Tens %s novas mensagens privadas',
++	],
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php"
+new file mode 100644
+index 000000000..2bbf7d6fb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php"
+@@ -0,0 +1,30 @@
++<?php
++/**
++ *
++ * @package       Popup PM
++ * @copyright (c) Татьяна5
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++$lang = array_merge($lang, [
++	'ACP_POPUPPM'                       => 'Popup MP',
++	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
++	'ACP_POPUPPM_TITLE'                 => 'Popup MP',
++
++	'ACP_POPUPPM_ENABLE_POPUP'             => 'Ativar Popup em Novas MPs',
++	'ACP_POPUPPM_ENABLE_BLINK'             => 'Ativar Título a Piscar',
++]);
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/popuppm.php"
+new file mode 100644
+index 000000000..02485b0f0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/popuppm.php"
+@@ -0,0 +1,33 @@
++<?php
++/**
++ *
++ * @package       Popup PM
++ * @copyright (c) Татьяна5
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++$lang = array_merge($lang, [
++	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
++		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
++		2 => '<<<! Tens %s novas mensagens privadas !>>>',
++	],
++	'POPUPPM_YOU_NEW_PM'			=> [
++		1 => 'Tens uma nova mensagem privada',
++		2 => 'Tens %s novas mensagens privadas',
++	],
++]);
++
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
+index 2ea96aacd..6dbac25ac 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
+@@ -25,8 +25,8 @@ class popuppm_0_0_1 extends \phpbb\db\migration\migration
+ 		return [
+ 			'add_columns' => [
+ 				$this->table_prefix . 'users' => [
+-					'popuppm_user_popup'    => ['BOOL', 1],
+-					'popuppm_user_blink'    => ['BOOL', 1],
++					'popuppm_user_popup'    => ['BOOL', 0],
++					'popuppm_user_blink'    => ['BOOL', 0],
+ 				],
+ 			],
+ 		];
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html"
+new file mode 100644
+index 000000000..2a64987c4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html"
+@@ -0,0 +1,57 @@
++{% if POPUPPM_ENABLE_BLINK and (S_USER_UNREAD_PRIVMSG > 0) %}
++<script>
++	head.ready(function () {
++		var newTxt = "{{ POPUPPM_YOU_NEW_PM_BLINK }}";
++		var oldTxt = document.title;
++
++		function migalka() {
++			if (document.title == oldTxt) {
++				document.title = newTxt;
++			} else {
++				document.title = oldTxt;
++			}
++		}
++
++		var timer = setInterval(migalka, 1000);
++	})
++</script>
++{% endif %}
++
++{% if POPUPPM_ENABLE_POPUP and S_NEW_PM %}
++<script>
++	head.ready(function () {
++		$(document).ready(function () {
++			$('#form_popuppm').show(1000);
++		});
++
++		$(document).on('click', '#form_popuppm .close', function (e) {
++			e.preventDefault();
++			$('#form_popuppm').hide();
++		})
++	})
++</script>
++
++<div id="form_popuppm">
++	<div class="jq_popuppm">
++		<p class="close_win">
++			<a href="#" class="close" title="{{ lang('CLOSE_WINDOW') }}">[x]</a>
++		</p>
++		<p class="new_message">
++			{{ POPUPPM_YOU_NEW_PM }}
++		</p>
++		{% if POPUPPM_INFO %}
++		<p class="pm_info">
++			{% if POPUPPM_AVATAR %}
++			<span class="pm_avatar">{{ POPUPPM_AVATAR }}</span>
++			{% endif %}
++			<span>{{ POPUPPM_SENDER }}</span>
++			<span><a href="{{ POPUPPM_SUBJECT_URL }}" class="topictitle">{{ POPUPPM_SUBJECT }}</a></span>
++			<span>{{ POPUPPM_DATE }}</span>
++		</p>
++		{% endif %}
++		<p class="click_view">
++			<a href="{{ U_PRIVATEMSGS }}" class="view" title="{{ lang('GO') }}">{{ lang('GO') }}</a>
++		</p>
++	</div>
++</div>
++{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_header_head_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+new file mode 100644
+index 000000000..318b42b9e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+@@ -0,0 +1,18 @@
++{% if POPUPPM_UCP_ENABLE_POPUP %}
++<div class="control-group">
++	<label class="control-label">{{ lang('ACP_POPUPPM_ENABLE_POPUP') }}{{ lang('COLON') }}</label>
++	<div class="controls controls-row">
++		<div class="radio"><input type="radio" name="popuppm_user_popup" id="popuppm_user_popup1" value="1" <!-- IF S_PM_ENABLE_POPUP --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_popup1">{{ lang('YES') }}</label></div>
++		<div class="radio"><input type="radio" name="popuppm_user_popup" id="popuppm_user_popup0" value="0" <!-- IF not S_PM_ENABLE_POPUP --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_popup0">{{ lang('NO') }}</label></div>
++	</div>
++</div>
++{% endif %}
++{% if POPUPPM_UCP_ENABLE_BLINK %}
++<div class="control-group">
++	<label class="control-label">{{ lang('ACP_POPUPPM_ENABLE_BLINK') }}{{ lang('COLON') }}</label>
++	<div class="controls controls-row">
++		<div class="radio"><input type="radio" name="popuppm_user_blink" id="popuppm_user_blink1" value="1" <!-- IF S_PM_ENABLE_BLINK --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_blink1">{{ lang('YES') }}</label></div>
++		<div class="radio"><input type="radio" name="popuppm_user_blink" id="popuppm_user_blink0" value="0" <!-- IF not S_PM_ENABLE_BLINK --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_blink0">{{ lang('NO') }}</label></div>
++	</div>
++</div>
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png"
+new file mode 100644
+index 000000000..64f33c84d
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png"
+new file mode 100644
+index 000000000..3de42aada
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png" differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-letter_bg.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-letter_bg.png"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-letter_bg.png"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-letter_bg.png"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css"
+new file mode 100644
+index 000000000..06b333577
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css"
+@@ -0,0 +1,159 @@
++/* Popup PM */
++#form_popuppm {
++	overflow: hidden;
++	width: 530px;
++	height: 446px;
++	position: fixed;
++	top: 0;
++	top: calc(50% - 223px);
++	left: 0;
++	left: calc(50% - 265px);
++	-webkit-transition: all 1s ease-in-out 0.3s;
++	-moz-transition: all 1s ease-in-out 0.3s;
++	-o-transition: all 1s ease-in-out 0.3s;
++	transition: all 1s ease-in-out 0.3s;
++	z-index: 3;
++}
++
++#form_popuppm:before {
++	content: '';
++	position: absolute;
++	bottom: 128px;
++	left: 0px;
++	left: calc(50% - 265px);
++	background: url('./images/popuppm-before.png');
++	background-size: cover;
++	width: 530px;
++	height: 316px;
++}
++
++#form_popuppm:after {
++	content: '';
++	position: absolute;
++	bottom: 0px;
++	left: 0;
++	left: calc(50% - 265px);
++	background: url('./images/popuppm-after.png');
++	background-size: cover;
++	width: 530px;
++	height: 260px;
++	pointer-events: none;
++}
++
++#form_popuppm.hide:after,
++#form_popuppm.hide:before {
++	display: none;
++}
++
++#form_popuppm:hover {
++	height: 576px;
++	top: -100px;
++	top: calc(50% - 323px);
++}
++
++.jq_popuppm {
++	background: url('./images/popuppm-letter_bg.png') repeat 0 0 #f7f2ec;
++	position: relative;
++	top: 200px;
++	overflow: hidden;
++	height: 200px;
++	width: 400px;
++	margin: 0px auto;
++	padding: 20px;
++	border: 1px solid #ffffff;
++	border-radius: 3px;
++	-moz-border-radius: 3px;
++	-webkit-border-radius: 3px;
++	box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #ffffff;
++	-moz-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 14px #ffffff;
++	-webkit-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #ffffff;
++	-webkit-transition: all 1s ease-in-out 0.3s;
++	-moz-transition: all 1s ease-in-out 0.3s;
++	-o-transition: all 1s ease-in-out 0.3s;
++	transition: all 1s ease-in-out 0.3s;
++}
++
++#form_popuppm:hover .jq_popuppm {
++	height: 330px;
++}
++
++.jq_popuppm p.close_win {
++	text-align: right;
++}
++
++.jq_popuppm a.close {
++	font-size: 10px;
++	color: #343434;
++}
++
++.jq_popuppm p.click_view {
++	text-align: center;
++	clear: both;
++}
++
++.jq_popuppm a.view {
++	font-size: 13px;
++	color: #343434;
++}
++
++.jq_popuppm p.new_message {
++	margin-top: 20px;
++	text-align: center;
++	font-size: 1.3em;
++}
++
++.pm_info span {
++	display: block;
++	margin-bottom: 0.4em;
++	overflow: hidden;
++	text-overflow: ellipsis;
++	white-space: nowrap;
++}
++
++.pm_info span.pm_avatar {
++	float: left;
++	margin-right: 10px;
++	width: 100px;
++	margin-bottom: 0;
++}
++
++@media only screen and (max-width: 550px), only screen and (max-device-width: 550px) {
++	#form_popuppm {
++		width: 330px;
++		height: 277px;
++		top: calc(50% - 138px);
++		left: calc(50% - 165px);
++	}
++
++	#form_popuppm:before {
++		bottom: 79px;
++		left: 0px;
++		left: calc(50% - 165px);
++		width: 330px;
++		height: 196px;
++	}
++
++	#form_popuppm:after {
++		left: calc(50% - 165px);
++		width: 330px;
++		height: 161px;
++	}
++
++	#form_popuppm:hover {
++		height: 376px;
++		top: -50px;
++		top: calc(50% - 188px);
++	}
++
++	.jq_popuppm {
++		height: 200px;
++		width: 260px;
++		top: 123px;
++		padding: 5px;
++	}
++
++	.jq_popuppm p.new_message {
++		margin-top: -10px;
++		font-size: 1em;
++	}
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_footer_after.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_footer_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_footer_after.html"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..d9d8ba8cc
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html"
+@@ -0,0 +1,3 @@
++{% if POPUPPM_ENABLE_POPUP %}
++	{% INCLUDECSS '@tatiana5_popuppm/popuppm.css' %}
++{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/ucp_prefs_view_radio_buttons_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-after.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-after.png"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-after.png"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-after.png"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-before.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-before.png"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-before.png"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-before.png"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-letter_bg.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-letter_bg.png"
+new file mode 100644
+index 000000000..ed5b8d682
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-letter_bg.png" differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/popuppm.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/popuppm.css"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/popuppm.css"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/popuppm.css"
diff --git "[FORUM_EXT]/tatiana5\\popuppm/diff_nospace.tmp" "[FORUM_EXT]/tatiana5\\popuppm/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/diff_nospace.tmp"
@@ -0,0 +1,829 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
+deleted file mode 100644
+index 06d26c89a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
++++ /dev/null
+@@ -1,65 +0,0 @@
+-language: php
+-dist: xenial
+-
+-matrix:
+-  include:
+-    - php: 7.1
+-      env: DB=none;NOTESTS=1
+-    - php: 7.1
+-      env: DB=mariadb
+-    - php: 7.1
+-      env: DB=postgres
+-    - php: 7.1
+-      env: DB=sqlite3
+-    - php: 7.1
+-      env: DB=mysqli # MyISAM
+-    - php: 7.2
+-      env: DB=mysqli
+-    - php: 7.3
+-      env: DB=mysqli
+-    - php: 7.4
+-      env: DB=mysqli
+-    - php: nightly
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: nightly
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="Tatiana5/popuppm"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.3.x"
+-
+-services:
+-  - postgresql
+-  - mysql
+-
+-branches:
+-  only:
+-    - master
+-
+-before_install:
+-  - sudo mkdir travis
+-  - git clone "https://github.com/phpbb/phpbb-ext-acme-demo.git"
+-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
+-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
+-  - sudo rm -rf phpbb-ext-acme-demo
+-
+-install:
+-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
+-  - sh -c "if [ '$EPV' = '1' -a '$NOTESTS' = '1' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --no-interaction; composer require phpbb/epv:dev-master --no-interaction --ignore-platform-reqs; cd ../; fi"
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
+-  - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
+index 02e970753..692d70716 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
+@@ -1,7 +1,7 @@
+ {
+ 	"name": "tatiana5/popuppm",
+ 	"type": "phpbb-extension",
+-    "description": "Popup on new PM and blink title",
++	"description": "Popup on new PM and blink title (User Disable By Default)",
+ 	"homepage": "http://www.phpbbguru.net/community/",
+ 	"version": "0.0.2",
+ 	"time": "2016-12-03",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp"
+new file mode 100644
+index 000000000..912700c97
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp"
+@@ -0,0 +1,763 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
++deleted file mode 100644
++index 06d26c89a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
+++++ /dev/null
++@@ -1,65 +0,0 @@
++-language: php
++-dist: xenial
++-
++-matrix:
++-  include:
++-    - php: 7.1
++-      env: DB=none;NOTESTS=1
++-    - php: 7.1
++-      env: DB=mariadb
++-    - php: 7.1
++-      env: DB=postgres
++-    - php: 7.1
++-      env: DB=sqlite3
++-    - php: 7.1
++-      env: DB=mysqli # MyISAM
++-    - php: 7.2
++-      env: DB=mysqli
++-    - php: 7.3
++-      env: DB=mysqli
++-    - php: 7.4
++-      env: DB=mysqli
++-    - php: nightly
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: nightly
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="Tatiana5/popuppm"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.3.x"
++-
++-services:
++-  - postgresql
++-  - mysql
++-
++-branches:
++-  only:
++-    - master
++-
++-before_install:
++-  - sudo mkdir travis
++-  - git clone "https://github.com/phpbb/phpbb-ext-acme-demo.git"
++-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
++-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
++-  - sudo rm -rf phpbb-ext-acme-demo
++-
++-install:
++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
++-  - sh -c "if [ '$EPV' = '1' -a '$NOTESTS' = '1' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --no-interaction; composer require phpbb/epv:dev-master --no-interaction --ignore-platform-reqs; cd ../; fi"
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
++-  - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
++index 02e970753..692d70716 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
++@@ -1,28 +1,28 @@
++ {
++-    "name": "tatiana5/popuppm",
++-    "type": "phpbb-extension",
++-    "description": "Popup on new PM and blink title",
++-    "homepage": "http://www.phpbbguru.net/community/",
++-    "version": "0.0.2",
++-    "time": "2016-12-03",
++-    "license": "GPL-2.0",
++-    "authors": [
++-        {
++-            "name": "Татьяна5",
++-            "homepage": "http://www.phpbbguru.net/community/",
++-            "role": "developer"
++-        }
++-    ],
++-    "require": {
++-        "php": ">=7.1.3"
++-    },
++-    "require-dev": {
++-      "phpbb/epv": "dev-master"
++-    },
++-    "extra": {
++-        "display-name": "Popup PM",
++-        "soft-require": {
++-            "phpbb/phpbb": "3.3"
++-        }
++-    }
+++	"name": "tatiana5/popuppm",
+++	"type": "phpbb-extension",
+++	"description": "Popup on new PM and blink title (User Disable By Default)",
+++	"homepage": "http://www.phpbbguru.net/community/",
+++	"version": "0.0.2",
+++	"time": "2016-12-03",
+++	"license": "GPL-2.0",
+++	"authors": [
+++		{
+++			"name": "Татьяна5",
+++			"homepage": "http://www.phpbbguru.net/community/",
+++			"role": "developer"
+++		}
+++	],
+++	"require": {
+++		"php": ">=7.1.3"
+++	},
+++	"require-dev": {
+++		"phpbb/epv": "dev-master"
+++	},
+++	"extra": {
+++		"display-name": "Popup PM",
+++		"soft-require": {
+++			"phpbb/phpbb": "3.3"
+++		}
+++	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp"
++new file mode 100644
++index 000000000..4c35f1026
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/diff_full.tmp"
++@@ -0,0 +1,114 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
+++deleted file mode 100644
+++index 06d26c89a..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/.travis.yml"
++++++ /dev/null
+++@@ -1,65 +0,0 @@
+++-language: php
+++-dist: xenial
+++-
+++-matrix:
+++-  include:
+++-    - php: 7.1
+++-      env: DB=none;NOTESTS=1
+++-    - php: 7.1
+++-      env: DB=mariadb
+++-    - php: 7.1
+++-      env: DB=postgres
+++-    - php: 7.1
+++-      env: DB=sqlite3
+++-    - php: 7.1
+++-      env: DB=mysqli # MyISAM
+++-    - php: 7.2
+++-      env: DB=mysqli
+++-    - php: 7.3
+++-      env: DB=mysqli
+++-    - php: 7.4
+++-      env: DB=mysqli
+++-    - php: nightly
+++-      env: DB=mysqli
+++-  allow_failures:
+++-    - php: nightly
+++-  fast_finish: true
+++-
+++-env:
+++-  global:
+++-    - EXTNAME="Tatiana5/popuppm"  # CHANGE name of the extension HERE
+++-    - SNIFF="1"            # Should we run code sniffer on your code?
+++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+++-    - PHPBB_BRANCH="3.3.x"
+++-
+++-services:
+++-  - postgresql
+++-  - mysql
+++-
+++-branches:
+++-  only:
+++-    - master
+++-
+++-before_install:
+++-  - sudo mkdir travis
+++-  - git clone "https://github.com/phpbb/phpbb-ext-acme-demo.git"
+++-  - sudo cp phpbb-ext-acme-demo/phpunit.xml.dist ./
+++-  - sudo cp phpbb-ext-acme-demo/travis/prepare-phpbb.sh travis
+++-  - sudo rm -rf phpbb-ext-acme-demo
+++-
+++-install:
+++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+++-  - cd ../../phpBB3
+++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
+++-  - sh -c "if [ '$EPV' = '1' -a '$NOTESTS' = '1' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --no-interaction; composer require phpbb/epv:dev-master --no-interaction --ignore-platform-reqs; cd ../; fi"
+++-
+++-before_script:
+++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION $NOTESTS
+++-
+++-script:
+++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME $NOTESTS; fi"
+++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION $NOTESTS; fi"
+++-  - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+++-  - sh -c "if [ '$NOTESTS' != '1' ]; then phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php; fi"
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
+++index 02e970753..692d70716 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/composer.json"
+++@@ -1,28 +1,28 @@
+++ {
+++-    "name": "tatiana5/popuppm",
+++-    "type": "phpbb-extension",
+++-    "description": "Popup on new PM and blink title",
+++-    "homepage": "http://www.phpbbguru.net/community/",
+++-    "version": "0.0.2",
+++-    "time": "2016-12-03",
+++-    "license": "GPL-2.0",
+++-    "authors": [
+++-        {
+++-            "name": "Татьяна5",
+++-            "homepage": "http://www.phpbbguru.net/community/",
+++-            "role": "developer"
+++-        }
+++-    ],
+++-    "require": {
+++-        "php": ">=7.1.3"
+++-    },
+++-    "require-dev": {
+++-      "phpbb/epv": "dev-master"
+++-    },
+++-    "extra": {
+++-        "display-name": "Popup PM",
+++-        "soft-require": {
+++-            "phpbb/phpbb": "3.3"
+++-        }
+++-    }
++++	"name": "tatiana5/popuppm",
++++	"type": "phpbb-extension",
++++	"description": "Popup on new PM and blink title (User Disable By Default)",
++++	"homepage": "http://www.phpbbguru.net/community/",
++++	"version": "0.0.2",
++++	"time": "2016-12-03",
++++	"license": "GPL-2.0",
++++	"authors": [
++++		{
++++			"name": "Татьяна5",
++++			"homepage": "http
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/event/listener.php"
++index 1b426ed47..2d523bcef 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/event/listener.php"
++@@ -126,13 +126,18 @@ class listener implements EventSubscriberInterface
++ 			$row = $this->db->sql_fetchrow($result);
++ 			if (is_array($row) && !empty($row['msg_id']))
++ 			{
++-				if ($row['user_avatar'])
++-				{
+++				if ($row['user_avatar']) {
++ 					$this->config['popuppm_avatar_dimentions'] = 50;
++-					$row['user_avatar_width'] = ($row['user_avatar_width'] > $row['user_avatar_height']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_height']) * $row['user_avatar_width'];
++-					$row['user_avatar_height'] = ($row['user_avatar_height'] > $row['user_avatar_width']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_width']) * $row['user_avatar_height'];
+++
+++					// Avoid division by zero using max function
+++					$avatar_height = max($row['user_avatar_height'], 1); // Prevent division by zero
+++					$avatar_width = max($row['user_avatar_width'], 1); // Prevent division by zero
+++
+++					$row['user_avatar_width'] = ($avatar_width > $avatar_height) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $avatar_height) * $avatar_width;
+++					$row['user_avatar_height'] = ($avatar_height > $avatar_width) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $avatar_width) * $avatar_height;
++ 				}
++ 
+++
++ 				if ($row['folder_id'] == PRIVMSGS_NO_BOX)
++ 				{
++ 					$row['folder_id'] = PRIVMSGS_INBOX;
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/language/en/popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/en/popuppm.php"
++index 3412d1f21..6106499a4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/language/en/popuppm.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/en/popuppm.php"
++@@ -23,10 +23,10 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, [
++ 	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
++ 		1 => '<<<! You have a new private message !>>>',
++-		2 => '<<<! You have the %s new private messages !>>>',
+++		2 => '<<<! You have %s new private messages !>>>',
++ 	],
++ 	'POPUPPM_YOU_NEW_PM'			=> [
++ 		1 => 'You have a new private message',
++-		2 => 'You have the %s new private messages',
+++		2 => 'You have %s new private messages',
++ 	],
++ ]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/info_acp_popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/info_acp_popuppm.php"
++new file mode 100644
++index 000000000..65f1aa2ca
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/info_acp_popuppm.php"
++@@ -0,0 +1,30 @@
+++<?php
+++/**
+++ *
+++ * @package       Popup PM
+++ * @copyright (c) Татьяна5
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++	'ACP_POPUPPM'                       => 'Popup MP',
+++	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
+++	'ACP_POPUPPM_TITLE'                 => 'Popup MP',
+++
+++	'ACP_POPUPPM_ENABLE_POPUP'             => 'Activar Popup em Novas MPs',
+++	'ACP_POPUPPM_ENABLE_BLINK'             => 'Activar Título a Piscar',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/popuppm.php"
++new file mode 100644
++index 000000000..ce649cf7e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt/popuppm.php"
++@@ -0,0 +1,32 @@
+++<?php
+++/**
+++ *
+++ * @package       Popup PM
+++ * @copyright (c) Татьяна5
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
+++		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
+++		2 => '<<<! Tens %s novas mensagens privadas !>>>',
+++	],
+++	'POPUPPM_YOU_NEW_PM'			=> [
+++		1 => 'Tens uma nova mensagem privada',
+++		2 => 'Tens %s novas mensagens privadas',
+++	],
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php"
++new file mode 100644
++index 000000000..2bbf7d6fb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php"
++@@ -0,0 +1,30 @@
+++<?php
+++/**
+++ *
+++ * @package       Popup PM
+++ * @copyright (c) Татьяна5
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++	'ACP_POPUPPM'                       => 'Popup MP',
+++	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
+++	'ACP_POPUPPM_TITLE'                 => 'Popup MP',
+++
+++	'ACP_POPUPPM_ENABLE_POPUP'             => 'Ativar Popup em Novas MPs',
+++	'ACP_POPUPPM_ENABLE_BLINK'             => 'Ativar Título a Piscar',
+++]);
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/popuppm.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/popuppm.php"
++new file mode 100644
++index 000000000..02485b0f0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/language/pt-preao/popuppm.php"
++@@ -0,0 +1,33 @@
+++<?php
+++/**
+++ *
+++ * @package       Popup PM
+++ * @copyright (c) Татьяна5
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
+++		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
+++		2 => '<<<! Tens %s novas mensagens privadas !>>>',
+++	],
+++	'POPUPPM_YOU_NEW_PM'			=> [
+++		1 => 'Tens uma nova mensagem privada',
+++		2 => 'Tens %s novas mensagens privadas',
+++	],
+++]);
+++
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
++index 2ea96aacd..6dbac25ac 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
++@@ -25,8 +25,8 @@ class popuppm_0_0_1 extends \phpbb\db\migration\migration
++ 		return [
++ 			'add_columns' => [
++ 				$this->table_prefix . 'users' => [
++-					'popuppm_user_popup'    => ['BOOL', 1],
++-					'popuppm_user_blink'    => ['BOOL', 1],
+++					'popuppm_user_popup'    => ['BOOL', 0],
+++					'popuppm_user_blink'    => ['BOOL', 0],
++ 				],
++ 			],
++ 		];
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html"
++new file mode 100644
++index 000000000..2a64987c4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html"
++@@ -0,0 +1,57 @@
+++{% if POPUPPM_ENABLE_BLINK and (S_USER_UNREAD_PRIVMSG > 0) %}
+++<script>
+++	head.ready(function () {
+++		var newTxt = "{{ POPUPPM_YOU_NEW_PM_BLINK }}";
+++		var oldTxt = document.title;
+++
+++		function migalka() {
+++			if (document.title == oldTxt) {
+++				document.title = newTxt;
+++			} else {
+++				document.title = oldTxt;
+++			}
+++		}
+++
+++		var timer = setInterval(migalka, 1000);
+++	})
+++</script>
+++{% endif %}
+++
+++{% if POPUPPM_ENABLE_POPUP and S_NEW_PM %}
+++<script>
+++	head.ready(function () {
+++		$(document).ready(function () {
+++			$('#form_popuppm').show(1000);
+++		});
+++
+++		$(document).on('click', '#form_popuppm .close', function (e) {
+++			e.preventDefault();
+++			$('#form_popuppm').hide();
+++		})
+++	})
+++</script>
+++
+++<div id="form_popuppm">
+++	<div class="jq_popuppm">
+++		<p class="close_win">
+++			<a href="#" class="close" title="{{ lang('CLOSE_WINDOW') }}">[x]</a>
+++		</p>
+++		<p class="new_message">
+++			{{ POPUPPM_YOU_NEW_PM }}
+++		</p>
+++		{% if POPUPPM_INFO %}
+++		<p class="pm_info">
+++			{% if POPUPPM_AVATAR %}
+++			<span class="pm_avatar">{{ POPUPPM_AVATAR }}</span>
+++			{% endif %}
+++			<span>{{ POPUPPM_SENDER }}</span>
+++			<span><a href="{{ POPUPPM_SUBJECT_URL }}" class="topictitle">{{ POPUPPM_SUBJECT }}</a></span>
+++			<span>{{ POPUPPM_DATE }}</span>
+++		</p>
+++		{% endif %}
+++		<p class="click_view">
+++			<a href="{{ U_PRIVATEMSGS }}" class="view" title="{{ lang('GO') }}">{{ lang('GO') }}</a>
+++		</p>
+++	</div>
+++</div>
+++{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_header_head_append.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++new file mode 100644
++index 000000000..318b42b9e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++@@ -0,0 +1,18 @@
+++{% if POPUPPM_UCP_ENABLE_POPUP %}
+++<div class="control-group">
+++	<label class="control-label">{{ lang('ACP_POPUPPM_ENABLE_POPUP') }}{{ lang('COLON') }}</label>
+++	<div class="controls controls-row">
+++		<div class="radio"><input type="radio" name="popuppm_user_popup" id="popuppm_user_popup1" value="1" <!-- IF S_PM_ENABLE_POPUP --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_popup1">{{ lang('YES') }}</label></div>
+++		<div class="radio"><input type="radio" name="popuppm_user_popup" id="popuppm_user_popup0" value="0" <!-- IF not S_PM_ENABLE_POPUP --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_popup0">{{ lang('NO') }}</label></div>
+++	</div>
+++</div>
+++{% endif %}
+++{% if POPUPPM_UCP_ENABLE_BLINK %}
+++<div class="control-group">
+++	<label class="control-label">{{ lang('ACP_POPUPPM_ENABLE_BLINK') }}{{ lang('COLON') }}</label>
+++	<div class="controls controls-row">
+++		<div class="radio"><input type="radio" name="popuppm_user_blink" id="popuppm_user_blink1" value="1" <!-- IF S_PM_ENABLE_BLINK --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_blink1">{{ lang('YES') }}</label></div>
+++		<div class="radio"><input type="radio" name="popuppm_user_blink" id="popuppm_user_blink0" value="0" <!-- IF not S_PM_ENABLE_BLINK --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_blink0">{{ lang('NO') }}</label></div>
+++	</div>
+++</div>
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png"
++new file mode 100644
++index 000000000..64f33c84d
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png"
++new file mode 100644
++index 000000000..3de42aada
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png" differ
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-letter_bg.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-letter_bg.png"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-letter_bg.png"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-letter_bg.png"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css"
++new file mode 100644
++index 000000000..06b333577
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css"
++@@ -0,0 +1,159 @@
+++/* Popup PM */
+++#form_popuppm {
+++	overflow: hidden;
+++	width: 530px;
+++	height: 446px;
+++	position: fixed;
+++	top: 0;
+++	top: calc(50% - 223px);
+++	left: 0;
+++	left: calc(50% - 265px);
+++	-webkit-transition: all 1s ease-in-out 0.3s;
+++	-moz-transition: all 1s ease-in-out 0.3s;
+++	-o-transition: all 1s ease-in-out 0.3s;
+++	transition: all 1s ease-in-out 0.3s;
+++	z-index: 3;
+++}
+++
+++#form_popuppm:before {
+++	content: '';
+++	position: absolute;
+++	bottom: 128px;
+++	left: 0px;
+++	left: calc(50% - 265px);
+++	background: url('./images/popuppm-before.png');
+++	background-size: cover;
+++	width: 530px;
+++	height: 316px;
+++}
+++
+++#form_popuppm:after {
+++	content: '';
+++	position: absolute;
+++	bottom: 0px;
+++	left: 0;
+++	left: calc(50% - 265px);
+++	background: url('./images/popuppm-after.png');
+++	background-size: cover;
+++	width: 530px;
+++	height: 260px;
+++	pointer-events: none;
+++}
+++
+++#form_popuppm.hide:after,
+++#form_popuppm.hide:before {
+++	display: none;
+++}
+++
+++#form_popuppm:hover {
+++	height: 576px;
+++	top: -100px;
+++	top: calc(50% - 323px);
+++}
+++
+++.jq_popuppm {
+++	background: url('./images/popuppm-letter_bg.png') repeat 0 0 #f7f2ec;
+++	position: relative;
+++	top: 200px;
+++	overflow: hidden;
+++	height: 200px;
+++	width: 400px;
+++	margin: 0px auto;
+++	padding: 20px;
+++	border: 1px solid #ffffff;
+++	border-radius: 3px;
+++	-moz-border-radius: 3px;
+++	-webkit-border-radius: 3px;
+++	box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #ffffff;
+++	-moz-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 14px #ffffff;
+++	-webkit-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #ffffff;
+++	-webkit-transition: all 1s ease-in-out 0.3s;
+++	-moz-transition: all 1s ease-in-out 0.3s;
+++	-o-transition: all 1s ease-in-out 0.3s;
+++	transition: all 1s ease-in-out 0.3s;
+++}
+++
+++#form_popuppm:hover .jq_popuppm {
+++	height: 330px;
+++}
+++
+++.jq_popuppm p.close_win {
+++	text-align: right;
+++}
+++
+++.jq_popuppm a.close {
+++	font-size: 10px;
+++	color: #343434;
+++}
+++
+++.jq_popuppm p.click_view {
+++	text-align: center;
+++	clear: both;
+++}
+++
+++.jq_popuppm a.view {
+++	font-size: 13px;
+++	color: #343434;
+++}
+++
+++.jq_popuppm p.new_message {
+++	margin-top: 20px;
+++	text-align: center;
+++	font-size: 1.3em;
+++}
+++
+++.pm_info span {
+++	display: block;
+++	margin-bottom: 0.4em;
+++	overflow: hidden;
+++	text-overflow: ellipsis;
+++	white-space: nowrap;
+++}
+++
+++.pm_info span.pm_avatar {
+++	float: left;
+++	margin-right: 10px;
+++	width: 100px;
+++	margin-bottom: 0;
+++}
+++
+++@media only screen and (max-width: 550px), only screen and (max-device-width: 550px) {
+++	#form_popuppm {
+++		width: 330px;
+++		height: 277px;
+++		top: calc(50% - 138px);
+++		left: calc(50% - 165px);
+++	}
+++
+++	#form_popuppm:before {
+++		bottom: 79px;
+++		left: 0px;
+++		left: calc(50% - 165px);
+++		width: 330px;
+++		height: 196px;
+++	}
+++
+++	#form_popuppm:after {
+++		left: calc(50% - 165px);
+++		width: 330px;
+++		height: 161px;
+++	}
+++
+++	#form_popuppm:hover {
+++		height: 376px;
+++		top: -50px;
+++		top: calc(50% - 188px);
+++	}
+++
+++	.jq_popuppm {
+++		height: 200px;
+++		width: 260px;
+++		top: 123px;
+++		padding: 5px;
+++	}
+++
+++	.jq_popuppm p.new_message {
+++		margin-top: -10px;
+++		font-size: 1em;
+++	}
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_footer_after.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_footer_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_footer_after.html"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..d9d8ba8cc
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\
\ No newline at end of file
diff --git "[ORIGINAL]/tatiana5\\popuppm/event/listener.php" "[FORUM_EXT]/tatiana5\\popuppm/event/listener.php"
--- "[ORIGINAL]/tatiana5\\popuppm/event/listener.php"
+++ "[FORUM_EXT]/tatiana5\\popuppm/event/listener.php"
@@ -126,13 +126,18 @@ class listener implements EventSubscriberInterface
 			$row = $this->db->sql_fetchrow($result);
 			if (is_array($row) && !empty($row['msg_id']))
 			{
-				if ($row['user_avatar'])
-				{
+				if ($row['user_avatar']) {
 					$this->config['popuppm_avatar_dimentions'] = 50;
-					$row['user_avatar_width'] = ($row['user_avatar_width'] > $row['user_avatar_height']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_height']) * $row['user_avatar_width'];
-					$row['user_avatar_height'] = ($row['user_avatar_height'] > $row['user_avatar_width']) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $row['user_avatar_width']) * $row['user_avatar_height'];
+
+					// Avoid division by zero using max function
+					$avatar_height = max($row['user_avatar_height'], 1); // Prevent division by zero
+					$avatar_width = max($row['user_avatar_width'], 1); // Prevent division by zero
+
+					$row['user_avatar_width'] = ($avatar_width > $avatar_height) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $avatar_height) * $avatar_width;
+					$row['user_avatar_height'] = ($avatar_height > $avatar_width) ? $this->config['popuppm_avatar_dimentions'] : ($this->config['popuppm_avatar_dimentions'] / $avatar_width) * $avatar_height;
 				}
 
+
 				if ($row['folder_id'] == PRIVMSGS_NO_BOX)
 				{
 					$row['folder_id'] = PRIVMSGS_INBOX;
diff --git "[ORIGINAL]/tatiana5\\popuppm/language/en/popuppm.php" "[FORUM_EXT]/tatiana5\\popuppm/language/en/popuppm.php"
--- "[ORIGINAL]/tatiana5\\popuppm/language/en/popuppm.php"
+++ "[FORUM_EXT]/tatiana5\\popuppm/language/en/popuppm.php"
@@ -23,10 +23,10 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, [
 	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
 		1 => '<<<! You have a new private message !>>>',
-		2 => '<<<! You have the %s new private messages !>>>',
+		2 => '<<<! You have %s new private messages !>>>',
 	],
 	'POPUPPM_YOU_NEW_PM'			=> [
 		1 => 'You have a new private message',
-		2 => 'You have the %s new private messages',
+		2 => 'You have %s new private messages',
 	],
 ]);
diff --git "[FORUM_EXT]/tatiana5\\popuppm/language/pt/info_acp_popuppm.php" "[FORUM_EXT]/tatiana5\\popuppm/language/pt/info_acp_popuppm.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/language/pt/info_acp_popuppm.php"
@@ -0,0 +1,30 @@
+<?php
+/**
+ *
+ * @package       Popup PM
+ * @copyright (c) Татьяна5
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+$lang = array_merge($lang, [
+	'ACP_POPUPPM'                       => 'Popup MP',
+	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
+	'ACP_POPUPPM_TITLE'                 => 'Popup MP',
+
+	'ACP_POPUPPM_ENABLE_POPUP'             => 'Activar Popup em Novas MPs',
+	'ACP_POPUPPM_ENABLE_BLINK'             => 'Activar Título a Piscar',
+]);
diff --git "[FORUM_EXT]/tatiana5\\popuppm/language/pt/popuppm.php" "[FORUM_EXT]/tatiana5\\popuppm/language/pt/popuppm.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/language/pt/popuppm.php"
@@ -0,0 +1,32 @@
+<?php
+/**
+ *
+ * @package       Popup PM
+ * @copyright (c) Татьяна5
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+$lang = array_merge($lang, [
+	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
+		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
+		2 => '<<<! Tens %s novas mensagens privadas !>>>',
+	],
+	'POPUPPM_YOU_NEW_PM'			=> [
+		1 => 'Tens uma nova mensagem privada',
+		2 => 'Tens %s novas mensagens privadas',
+	],
+]);
diff --git "[FORUM_EXT]/tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php" "[FORUM_EXT]/tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/language/pt-preao/info_acp_popuppm.php"
@@ -0,0 +1,30 @@
+<?php
+/**
+ *
+ * @package       Popup PM
+ * @copyright (c) Татьяна5
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+$lang = array_merge($lang, [
+	'ACP_POPUPPM'                       => 'Popup MP',
+	'ACP_POPUPPM_EXPLAIN'               => 'Configurações Popup MP',
+	'ACP_POPUPPM_TITLE'                 => 'Popup MP',
+
+	'ACP_POPUPPM_ENABLE_POPUP'             => 'Ativar Popup em Novas MPs',
+	'ACP_POPUPPM_ENABLE_BLINK'             => 'Ativar Título a Piscar',
+]);
\ No newline at end of file
diff --git "[FORUM_EXT]/tatiana5\\popuppm/language/pt-preao/popuppm.php" "[FORUM_EXT]/tatiana5\\popuppm/language/pt-preao/popuppm.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/language/pt-preao/popuppm.php"
@@ -0,0 +1,33 @@
+<?php
+/**
+ *
+ * @package       Popup PM
+ * @copyright (c) Татьяна5
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+$lang = array_merge($lang, [
+	'POPUPPM_YOU_NEW_PM_BLINK'		=> [
+		1 => '<<<! Recebeste uma nova mensagem privada !>>>',
+		2 => '<<<! Tens %s novas mensagens privadas !>>>',
+	],
+	'POPUPPM_YOU_NEW_PM'			=> [
+		1 => 'Tens uma nova mensagem privada',
+		2 => 'Tens %s novas mensagens privadas',
+	],
+]);
+
diff --git "[ORIGINAL]/tatiana5\\popuppm/migrations/popuppm_0_0_1.php" "[FORUM_EXT]/tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
--- "[ORIGINAL]/tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
+++ "[FORUM_EXT]/tatiana5\\popuppm/migrations/popuppm_0_0_1.php"
@@ -25,8 +25,8 @@ class popuppm_0_0_1 extends \phpbb\db\migration\migration
 		return [
 			'add_columns' => [
 				$this->table_prefix . 'users' => [
-					'popuppm_user_popup'    => ['BOOL', 1],
-					'popuppm_user_blink'    => ['BOOL', 1],
+					'popuppm_user_popup'    => ['BOOL', 0],
+					'popuppm_user_blink'    => ['BOOL', 0],
 				],
 			],
 		];
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_footer_after.html"
@@ -0,0 +1,57 @@
+{% if POPUPPM_ENABLE_BLINK and (S_USER_UNREAD_PRIVMSG > 0) %}
+<script>
+	head.ready(function () {
+		var newTxt = "{{ POPUPPM_YOU_NEW_PM_BLINK }}";
+		var oldTxt = document.title;
+
+		function migalka() {
+			if (document.title == oldTxt) {
+				document.title = newTxt;
+			} else {
+				document.title = oldTxt;
+			}
+		}
+
+		var timer = setInterval(migalka, 1000);
+	})
+</script>
+{% endif %}
+
+{% if POPUPPM_ENABLE_POPUP and S_NEW_PM %}
+<script>
+	head.ready(function () {
+		$(document).ready(function () {
+			$('#form_popuppm').show(1000);
+		});
+
+		$(document).on('click', '#form_popuppm .close', function (e) {
+			e.preventDefault();
+			$('#form_popuppm').hide();
+		})
+	})
+</script>
+
+<div id="form_popuppm">
+	<div class="jq_popuppm">
+		<p class="close_win">
+			<a href="#" class="close" title="{{ lang('CLOSE_WINDOW') }}">[x]</a>
+		</p>
+		<p class="new_message">
+			{{ POPUPPM_YOU_NEW_PM }}
+		</p>
+		{% if POPUPPM_INFO %}
+		<p class="pm_info">
+			{% if POPUPPM_AVATAR %}
+			<span class="pm_avatar">{{ POPUPPM_AVATAR }}</span>
+			{% endif %}
+			<span>{{ POPUPPM_SENDER }}</span>
+			<span><a href="{{ POPUPPM_SUBJECT_URL }}" class="topictitle">{{ POPUPPM_SUBJECT }}</a></span>
+			<span>{{ POPUPPM_DATE }}</span>
+		</p>
+		{% endif %}
+		<p class="click_view">
+			<a href="{{ U_PRIVATEMSGS }}" class="view" title="{{ lang('GO') }}">{{ lang('GO') }}</a>
+		</p>
+	</div>
+</div>
+{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/template/event/overall_header_head_append.html" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_header_head_append.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_header_head_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/template/event/overall_header_head_append.html"
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
@@ -0,0 +1,18 @@
+{% if POPUPPM_UCP_ENABLE_POPUP %}
+<div class="control-group">
+	<label class="control-label">{{ lang('ACP_POPUPPM_ENABLE_POPUP') }}{{ lang('COLON') }}</label>
+	<div class="controls controls-row">
+		<div class="radio"><input type="radio" name="popuppm_user_popup" id="popuppm_user_popup1" value="1" <!-- IF S_PM_ENABLE_POPUP --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_popup1">{{ lang('YES') }}</label></div>
+		<div class="radio"><input type="radio" name="popuppm_user_popup" id="popuppm_user_popup0" value="0" <!-- IF not S_PM_ENABLE_POPUP --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_popup0">{{ lang('NO') }}</label></div>
+	</div>
+</div>
+{% endif %}
+{% if POPUPPM_UCP_ENABLE_BLINK %}
+<div class="control-group">
+	<label class="control-label">{{ lang('ACP_POPUPPM_ENABLE_BLINK') }}{{ lang('COLON') }}</label>
+	<div class="controls controls-row">
+		<div class="radio"><input type="radio" name="popuppm_user_blink" id="popuppm_user_blink1" value="1" <!-- IF S_PM_ENABLE_BLINK --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_blink1">{{ lang('YES') }}</label></div>
+		<div class="radio"><input type="radio" name="popuppm_user_blink" id="popuppm_user_blink0" value="0" <!-- IF not S_PM_ENABLE_BLINK --> checked="checked"<!-- ENDIF --> /><label for="popuppm_user_blink0">{{ lang('NO') }}</label></div>
+	</div>
+</div>
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-after.png" differ
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-before.png" differ
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/theme/images/popuppm-letter_bg.png" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-letter_bg.png"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-letter_bg.png"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/FLATBOOTS/theme/images/popuppm-letter_bg.png"
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css" "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/styles/FLATBOOTS/theme/popuppm.css"
@@ -0,0 +1,159 @@
+/* Popup PM */
+#form_popuppm {
+	overflow: hidden;
+	width: 530px;
+	height: 446px;
+	position: fixed;
+	top: 0;
+	top: calc(50% - 223px);
+	left: 0;
+	left: calc(50% - 265px);
+	-webkit-transition: all 1s ease-in-out 0.3s;
+	-moz-transition: all 1s ease-in-out 0.3s;
+	-o-transition: all 1s ease-in-out 0.3s;
+	transition: all 1s ease-in-out 0.3s;
+	z-index: 3;
+}
+
+#form_popuppm:before {
+	content: '';
+	position: absolute;
+	bottom: 128px;
+	left: 0px;
+	left: calc(50% - 265px);
+	background: url('./images/popuppm-before.png');
+	background-size: cover;
+	width: 530px;
+	height: 316px;
+}
+
+#form_popuppm:after {
+	content: '';
+	position: absolute;
+	bottom: 0px;
+	left: 0;
+	left: calc(50% - 265px);
+	background: url('./images/popuppm-after.png');
+	background-size: cover;
+	width: 530px;
+	height: 260px;
+	pointer-events: none;
+}
+
+#form_popuppm.hide:after,
+#form_popuppm.hide:before {
+	display: none;
+}
+
+#form_popuppm:hover {
+	height: 576px;
+	top: -100px;
+	top: calc(50% - 323px);
+}
+
+.jq_popuppm {
+	background: url('./images/popuppm-letter_bg.png') repeat 0 0 #f7f2ec;
+	position: relative;
+	top: 200px;
+	overflow: hidden;
+	height: 200px;
+	width: 400px;
+	margin: 0px auto;
+	padding: 20px;
+	border: 1px solid #ffffff;
+	border-radius: 3px;
+	-moz-border-radius: 3px;
+	-webkit-border-radius: 3px;
+	box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #ffffff;
+	-moz-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 14px #ffffff;
+	-webkit-box-shadow: 0px 0px 3px #9d9d9d, inset 0px 0px 27px #ffffff;
+	-webkit-transition: all 1s ease-in-out 0.3s;
+	-moz-transition: all 1s ease-in-out 0.3s;
+	-o-transition: all 1s ease-in-out 0.3s;
+	transition: all 1s ease-in-out 0.3s;
+}
+
+#form_popuppm:hover .jq_popuppm {
+	height: 330px;
+}
+
+.jq_popuppm p.close_win {
+	text-align: right;
+}
+
+.jq_popuppm a.close {
+	font-size: 10px;
+	color: #343434;
+}
+
+.jq_popuppm p.click_view {
+	text-align: center;
+	clear: both;
+}
+
+.jq_popuppm a.view {
+	font-size: 13px;
+	color: #343434;
+}
+
+.jq_popuppm p.new_message {
+	margin-top: 20px;
+	text-align: center;
+	font-size: 1.3em;
+}
+
+.pm_info span {
+	display: block;
+	margin-bottom: 0.4em;
+	overflow: hidden;
+	text-overflow: ellipsis;
+	white-space: nowrap;
+}
+
+.pm_info span.pm_avatar {
+	float: left;
+	margin-right: 10px;
+	width: 100px;
+	margin-bottom: 0;
+}
+
+@media only screen and (max-width: 550px), only screen and (max-device-width: 550px) {
+	#form_popuppm {
+		width: 330px;
+		height: 277px;
+		top: calc(50% - 138px);
+		left: calc(50% - 165px);
+	}
+
+	#form_popuppm:before {
+		bottom: 79px;
+		left: 0px;
+		left: calc(50% - 165px);
+		width: 330px;
+		height: 196px;
+	}
+
+	#form_popuppm:after {
+		left: calc(50% - 165px);
+		width: 330px;
+		height: 161px;
+	}
+
+	#form_popuppm:hover {
+		height: 376px;
+		top: -50px;
+		top: calc(50% - 188px);
+	}
+
+	.jq_popuppm {
+		height: 200px;
+		width: 260px;
+		top: 123px;
+		padding: 5px;
+	}
+
+	.jq_popuppm p.new_message {
+		margin-top: -10px;
+		font-size: 1em;
+	}
+}
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/template/event/overall_footer_after.html" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/template/event/overall_footer_after.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/overall_footer_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/overall_footer_after.html"
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/template/event/overall_header_head_append.html"
@@ -0,0 +1,3 @@
+{% if POPUPPM_ENABLE_POPUP %}
+	{% INCLUDECSS '@tatiana5_popuppm/popuppm.css' %}
+{% endif %}
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/template/event/ucp_prefs_view_radio_buttons_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/theme/images/popuppm-after.png" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-after.png"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-after.png"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-after.png"
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/theme/images/popuppm-before.png" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-before.png"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/images/popuppm-before.png"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-before.png"
diff --git "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-letter_bg.png" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-letter_bg.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/images/popuppm-letter_bg.png" differ
diff --git "[ORIGINAL]/tatiana5\\popuppm/styles/all/theme/popuppm.css" "[FORUM_EXT]/tatiana5\\popuppm/styles/prosilver/theme/popuppm.css"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\tatiana5\\popuppm/styles/all/theme/popuppm.css"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\tatiana5\\popuppm/styles/prosilver/theme/popuppm.css"
```
