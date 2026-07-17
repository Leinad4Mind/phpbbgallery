Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/brunoais\\readOthersTopics/.travis.yml" "[ORIGINAL]/brunoais\\readOthersTopics/.travis.yml"
deleted file mode 100644
--- "[ORIGINAL]/brunoais\\readOthersTopics/.travis.yml"
+++ /dev/null
@@ -1,56 +0,0 @@
-language: php
-
-matrix:
-  include:
-    - php: 5.3.3
-      env: DB=mysqli
-    - php: 5.3
-      env: DB=mysqli # MyISAM
-    - php: 5.4
-      env: DB=mysqli
-    - php: 5.4
-      env: DB=mysql
-    - php: 5.4
-      env: DB=mariadb
-    - php: 5.4
-      env: DB=postgres
-    - php: 5.4
-      env: DB=sqlite3
-    - php: 5.5
-      env: DB=mysqli
-    - php: 5.6
-      env: DB=mysqli
-    - php: hhvm
-      env: DB=mysqli
-  allow_failures:
-    - php: hhvm
-  fast_finish: true
-
-env:
-  global:
-    - EXTNAME="acme/demo"  # CHANGE name of the extension HERE
-    - SNIFF="1"            # Should we run code sniffer on your code?
-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
-    - PHPBB_BRANCH="3.1.x"
-
-branches:
-  only:
-    - master
-    - /^(3\.[1-9]|[4-9]\.\d)\.x$/
-
-install:
-  - composer install --dev --no-interaction --prefer-source
-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
-  - cd ../../phpBB3
-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
-
-before_script:
-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
-
-script:
-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
-  - sh -c "if [ '$EPV' != '0' ] && [ '$TRAVIS_PHP_VERSION' = '5.3.3' ] && [ '$DB' = 'mysqli' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
diff --git "[FORUM_EXT]/brunoais\\readOthersTopics/diff_full.tmp" "[FORUM_EXT]/brunoais\\readOthersTopics/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/brunoais\\readOthersTopics/diff_full.tmp"
@@ -0,0 +1,297 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml"
+deleted file mode 100644
+index 0af81ea6c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml"
++++ /dev/null
+@@ -1,56 +0,0 @@
+-language: php
+-
+-matrix:
+-  include:
+-    - php: 5.3.3
+-      env: DB=mysqli
+-    - php: 5.3
+-      env: DB=mysqli # MyISAM
+-    - php: 5.4
+-      env: DB=mysqli
+-    - php: 5.4
+-      env: DB=mysql
+-    - php: 5.4
+-      env: DB=mariadb
+-    - php: 5.4
+-      env: DB=postgres
+-    - php: 5.4
+-      env: DB=sqlite3
+-    - php: 5.5
+-      env: DB=mysqli
+-    - php: 5.6
+-      env: DB=mysqli
+-    - php: hhvm
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: hhvm
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="acme/demo"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.1.x"
+-
+-branches:
+-  only:
+-    - master
+-    - /^(3\.[1-9]|[4-9]\.\d)\.x$/
+-
+-install:
+-  - composer install --dev --no-interaction --prefer-source
+-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+-  - sh -c "if [ '$EPV' != '0' ] && [ '$TRAVIS_PHP_VERSION' = '5.3.3' ] && [ '$DB' = 'mysqli' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php"
+new file mode 100644
+index 000000000..30371b377
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php"
+@@ -0,0 +1,33 @@
++<?php
++/**
++*
++* @package phpBB Extension - brunoais readOthersTopics
++* @copyright (c) 2015 phpBB Group
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
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
++
++$lang = array_merge($lang, array(
++
++	'ACL_F_READ_OTHERS_TOPICS' => 'Pode ler tópicos iniciados por terceiros',
++	'BRUNOAIS_ROLE_READ_OTHERS_TOPICS' => 'Acesso padrão sem tópicos criados por terceiros',
++	'BRUNOAIS_ROLE_DESCRIPTION_READ_OTHERS_TOPICS' => 'Pode usar a maioria dos recursos do fórum como o acesso padrão, exceto a exibição de tópicos iniciados por outros usuários.',
++
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/common.php"
+new file mode 100644
+index 000000000..9423bf88e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/common.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++*
++* This file is part of the phpBB Forum Software package.
++*
++* @copyright (c) phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
++* For full copyright and license information, please see
++* the docs/CREDITS.txt file.
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
++
++$lang = array_merge($lang, array(
++	'SORRY_AUTH_READ_OTHER'			=> 'Você não está autorizado a ler este tópico.',
++	'SORRY_CLASSIFIED_INFORMATION'	=> 'Informação confidencial',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php"
+new file mode 100644
+index 000000000..30371b377
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php"
+@@ -0,0 +1,33 @@
++<?php
++/**
++*
++* @package phpBB Extension - brunoais readOthersTopics
++* @copyright (c) 2015 phpBB Group
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
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
++
++$lang = array_merge($lang, array(
++
++	'ACL_F_READ_OTHERS_TOPICS' => 'Pode ler tópicos iniciados por terceiros',
++	'BRUNOAIS_ROLE_READ_OTHERS_TOPICS' => 'Acesso padrão sem tópicos criados por terceiros',
++	'BRUNOAIS_ROLE_DESCRIPTION_READ_OTHERS_TOPICS' => 'Pode usar a maioria dos recursos do fórum como o acesso padrão, exceto a exibição de tópicos iniciados por outros usuários.',
++
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..9423bf88e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/common.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++*
++* This file is part of the phpBB Forum Software package.
++*
++* @copyright (c) phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
++* For full copyright and license information, please see
++* the docs/CREDITS.txt file.
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
++
++$lang = array_merge($lang, array(
++	'SORRY_AUTH_READ_OTHER'			=> 'Você não está autorizado a ler este tópico.',
++	'SORRY_CLASSIFIED_INFORMATION'	=> 'Informação confidencial',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/phpunit.xml.dist" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/phpunit.xml.dist"
+deleted file mode 100644
+index 289449d49..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/phpunit.xml.dist"
++++ /dev/null
+@@ -1,38 +0,0 @@
+-<?xml version="1.0" encoding="UTF-8"?>
+-
+-<phpunit backupGlobals="true"
+-         backupStaticAttributes="true"
+-         colors="true"
+-         convertErrorsToExceptions="true"
+-         convertNoticesToExceptions="true"
+-         convertWarningsToExceptions="true"
+-         processIsolation="false"
+-         stopOnFailure="false"
+-         syntaxCheck="false"
+-         verbose="true"
+-         bootstrap="../../../../tests/bootstrap.php"
+->
+-	<testsuites>
+-		<testsuite name="Extension Test Suite">
+-			<directory suffix="_test.php">./tests</directory>
+-			<exclude>./tests/functional</exclude>
+-		</testsuite>
+-		<testsuite name="Extension Functional Tests">
+-			<directory suffix="_test.php" phpVersion="5.3.19" phpVersionOperator=">=">./tests/functional/</directory>
+-		</testsuite>
+-	</testsuites>
+-
+-	<filter>
+-		<blacklist>
+-			<directory>./tests/</directory>
+-		</blacklist>
+-		<whitelist processUncoveredFilesFromWhitelist="true">
+-			<directory suffix=".php">./</directory>
+-			<exclude>
+-				<directory suffix=".php">./language/</directory>
+-				<directory suffix=".php">./migrations/</directory>
+-				<directory suffix=".php">./tests/</directory>
+-			</exclude>
+-		</whitelist>
+-	</filter>
+-</phpunit>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/travis/prepare-phpbb.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/travis/prepare-phpbb.sh"
+deleted file mode 100644
+index 01770ad6e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/travis/prepare-phpbb.sh"
++++ /dev/null
+@@ -1,24 +0,0 @@
+-#!/bin/bash
+-#
+-# This file is part of the phpBB Forum Software package.
+-#
+-# @copyright (c) phpBB Limited <https://www.phpbb.com>
+-# @license GNU General Public License, version 2 (GPL-2.0)
+-#
+-# For full copyright and license information, please see
+-# the docs/CREDITS.txt file.
+-#
+-set -e
+-set -x
+-
+-EXTNAME=$1
+-BRANCH=$2
+-EXTPATH_TEMP=$3
+-
+-# Copy extension to a temp folder
+-mkdir ../../tmp
+-cp -R . ../../tmp
+-cd ../../
+-
+-# Clone phpBB
+-git clone --depth=1 "git://github.com/phpbb/phpbb.git" "phpBB3" --branch=$BRANCH
diff --git "[FORUM_EXT]/brunoais\\readOthersTopics/diff_nospace.tmp" "[FORUM_EXT]/brunoais\\readOthersTopics/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/brunoais\\readOthersTopics/diff_nospace.tmp"
@@ -0,0 +1,325 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml"
+deleted file mode 100644
+index 0af81ea6c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml"
++++ /dev/null
+@@ -1,56 +0,0 @@
+-language: php
+-
+-matrix:
+-  include:
+-    - php: 5.3.3
+-      env: DB=mysqli
+-    - php: 5.3
+-      env: DB=mysqli # MyISAM
+-    - php: 5.4
+-      env: DB=mysqli
+-    - php: 5.4
+-      env: DB=mysql
+-    - php: 5.4
+-      env: DB=mariadb
+-    - php: 5.4
+-      env: DB=postgres
+-    - php: 5.4
+-      env: DB=sqlite3
+-    - php: 5.5
+-      env: DB=mysqli
+-    - php: 5.6
+-      env: DB=mysqli
+-    - php: hhvm
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: hhvm
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="acme/demo"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.1.x"
+-
+-branches:
+-  only:
+-    - master
+-    - /^(3\.[1-9]|[4-9]\.\d)\.x$/
+-
+-install:
+-  - composer install --dev --no-interaction --prefer-source
+-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+-  - sh -c "if [ '$EPV' != '0' ] && [ '$TRAVIS_PHP_VERSION' = '5.3.3' ] && [ '$DB' = 'mysqli' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp"
+new file mode 100644
+index 000000000..e57095f8c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp"
+@@ -0,0 +1,297 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml"
++deleted file mode 100644
++index 0af81ea6c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/.travis.yml"
+++++ /dev/null
++@@ -1,56 +0,0 @@
++-language: php
++-
++-matrix:
++-  include:
++-    - php: 5.3.3
++-      env: DB=mysqli
++-    - php: 5.3
++-      env: DB=mysqli # MyISAM
++-    - php: 5.4
++-      env: DB=mysqli
++-    - php: 5.4
++-      env: DB=mysql
++-    - php: 5.4
++-      env: DB=mariadb
++-    - php: 5.4
++-      env: DB=postgres
++-    - php: 5.4
++-      env: DB=sqlite3
++-    - php: 5.5
++-      env: DB=mysqli
++-    - php: 5.6
++-      env: DB=mysqli
++-    - php: hhvm
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: hhvm
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="acme/demo"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.1.x"
++-
++-branches:
++-  only:
++-    - master
++-    - /^(3\.[1-9]|[4-9]\.\d)\.x$/
++-
++-install:
++-  - composer install --dev --no-interaction --prefer-source
++-  - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
++-  - sh -c "if [ '$EPV' != '0' ] && [ '$TRAVIS_PHP_VERSION' = '5.3.3' ] && [ '$DB' = 'mysqli' ]; then phpBB/ext/$EXTNAME/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php"
++new file mode 100644
++index 000000000..30371b377
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php"
++@@ -0,0 +1,33 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - brunoais readOthersTopics
+++* @copyright (c) 2015 phpBB Group
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
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
+++
+++$lang = array_merge($lang, array(
+++
+++	'ACL_F_READ_OTHERS_TOPICS' => 'Pode ler tópicos iniciados por terceiros',
+++	'BRUNOAIS_ROLE_READ_OTHERS_TOPICS' => 'Acesso padrão sem tópicos criados por terceiros',
+++	'BRUNOAIS_ROLE_DESCRIPTION_READ_OTHERS_TOPICS' => 'Pode usar a maioria dos recursos do fórum como o acesso padrão, exceto a exibição de tópicos iniciados por outros usuários.',
+++
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/common.php"
++new file mode 100644
++index 000000000..9423bf88e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt/common.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++*
+++* This file is part of the phpBB Forum Software package.
+++*
+++* @copyright (c) phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
+++* For full copyright and license information, please see
+++* the docs/CREDITS.txt file.
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
+++
+++$lang = array_merge($lang, array(
+++	'SORRY_AUTH_READ_OTHER'			=> 'Você não está autorizado a ler este tópico.',
+++	'SORRY_CLASSIFIED_INFORMATION'	=> 'Informação confidencial',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php"
++new file mode 100644
++index 000000000..30371b377
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php"
++@@ -0,0 +1,33 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - brunoais readOthersTopics
+++* @copyright (c) 2015 phpBB Group
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
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
+++
+++$lang = array_merge($lang, array(
+++
+++	'ACL_F_READ_OTHERS_TOPICS' => 'Pode ler tópicos iniciados por terceiros',
+++	'BRUNOAIS_ROLE_READ_OTHERS_TOPICS' => 'Acesso padrão sem tópicos criados por terceiros',
+++	'BRUNOAIS_ROLE_DESCRIPTION_READ_OTHERS_TOPICS' => 'Pode usar a maioria dos recursos do fórum como o acesso padrão, exceto a exibição de tópicos iniciados por outros usuários.',
+++
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..9423bf88e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\brunoais\\readOthersTopics/language/pt_preao/common.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++*
+++* This file is part of the phpBB Forum Software package.
+++*
+++* @copyright (c) phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
+++* For full copyright and license information, please see
+++* the docs/CREDITS.txt file.
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
+++
+++$lang = array_merge($lang, array(
+++	'SORRY_AUTH_READ_OTHER'			=> 'Você não está autorizado a ler este tópico.',
+++	'SORRY_CLASSIFIED_INFORMATION'	=> 'Informação confidencial',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/phpunit.xml.dist" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/phpunit.xml.dist"
++deleted file mode 100644
++index 289449d49..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\brunoais\\readOthersTopics/phpunit.xml.dist"
+++++ /dev/null
++@@ -1,38 +0,0 @@
++-<?xml version="1.0" encoding="UTF-8"?>
++-
++-<phpunit backupGlobals="true"
++-         backupStaticAttributes="true"
++-         colors="true"
++-         convertErrorsToExceptions="true"
++-         convertNoticesToExceptions="true"
++-         convertWarningsToExceptions="true"
++-         processIsolation="false"
++-         stopOnFailure="false"
++-         syntaxCheck="false"
++-         verbose="true"
++-         bootstrap="../../../../tests/bootstrap.php"
++->
++-	<testsuites>
++-		<testsuite name="Extension Test Suite">
++-			<directory suffix="_test.php">./tests</directory>
++-			<exclude>./tests/functional</exclude>
++-		</testsuite>
++-		<testsuite name="Extension Functional Tests">
++-			<directory suffix="_test.php" phpVersion="5.3.19" phpVersionOperator=">=">./tests/functional/</directory>
++-		</testsuite>
++-	</testsuites>
++-
++-	<filter>
++-		<blacklist>
++-			<directory>./tests/</directory>
++-		</blacklist>
diff --git "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php" "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt/acp/permissions_strings.php"
@@ -0,0 +1,33 @@
+<?php
+/**
+*
+* @package phpBB Extension - brunoais readOthersTopics
+* @copyright (c) 2015 phpBB Group
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
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
+
+$lang = array_merge($lang, array(
+
+	'ACL_F_READ_OTHERS_TOPICS' => 'Pode ler tópicos iniciados por terceiros',
+	'BRUNOAIS_ROLE_READ_OTHERS_TOPICS' => 'Acesso padrão sem tópicos criados por terceiros',
+	'BRUNOAIS_ROLE_DESCRIPTION_READ_OTHERS_TOPICS' => 'Pode usar a maioria dos recursos do fórum como o acesso padrão, exceto a exibição de tópicos iniciados por outros usuários.',
+
+));
diff --git "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt/common.php" "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt/common.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+*
+* This file is part of the phpBB Forum Software package.
+*
+* @copyright (c) phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
+* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
+* For full copyright and license information, please see
+* the docs/CREDITS.txt file.
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
+
+$lang = array_merge($lang, array(
+	'SORRY_AUTH_READ_OTHER'			=> 'Você não está autorizado a ler este tópico.',
+	'SORRY_CLASSIFIED_INFORMATION'	=> 'Informação confidencial',
+));
diff --git "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php" "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt_preao/acp/permissions_strings.php"
@@ -0,0 +1,33 @@
+<?php
+/**
+*
+* @package phpBB Extension - brunoais readOthersTopics
+* @copyright (c) 2015 phpBB Group
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
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
+
+$lang = array_merge($lang, array(
+
+	'ACL_F_READ_OTHERS_TOPICS' => 'Pode ler tópicos iniciados por terceiros',
+	'BRUNOAIS_ROLE_READ_OTHERS_TOPICS' => 'Acesso padrão sem tópicos criados por terceiros',
+	'BRUNOAIS_ROLE_DESCRIPTION_READ_OTHERS_TOPICS' => 'Pode usar a maioria dos recursos do fórum como o acesso padrão, exceto a exibição de tópicos iniciados por outros usuários.',
+
+));
diff --git "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt_preao/common.php" "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/brunoais\\readOthersTopics/language/pt_preao/common.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+*
+* This file is part of the phpBB Forum Software package.
+*
+* @copyright (c) phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
+* Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.1.0] (https://github.com/phpBBTraducoes)
+* For full copyright and license information, please see
+* the docs/CREDITS.txt file.
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
+
+$lang = array_merge($lang, array(
+	'SORRY_AUTH_READ_OTHER'			=> 'Você não está autorizado a ler este tópico.',
+	'SORRY_CLASSIFIED_INFORMATION'	=> 'Informação confidencial',
+));
diff --git "[ORIGINAL]/brunoais\\readOthersTopics/phpunit.xml.dist" "[ORIGINAL]/brunoais\\readOthersTopics/phpunit.xml.dist"
deleted file mode 100644
--- "[ORIGINAL]/brunoais\\readOthersTopics/phpunit.xml.dist"
+++ /dev/null
@@ -1,38 +0,0 @@
-<?xml version="1.0" encoding="UTF-8"?>
-
-<phpunit backupGlobals="true"
-         backupStaticAttributes="true"
-         colors="true"
-         convertErrorsToExceptions="true"
-         convertNoticesToExceptions="true"
-         convertWarningsToExceptions="true"
-         processIsolation="false"
-         stopOnFailure="false"
-         syntaxCheck="false"
-         verbose="true"
-         bootstrap="../../../../tests/bootstrap.php"
->
-	<testsuites>
-		<testsuite name="Extension Test Suite">
-			<directory suffix="_test.php">./tests</directory>
-			<exclude>./tests/functional</exclude>
-		</testsuite>
-		<testsuite name="Extension Functional Tests">
-			<directory suffix="_test.php" phpVersion="5.3.19" phpVersionOperator=">=">./tests/functional/</directory>
-		</testsuite>
-	</testsuites>
-
-	<filter>
-		<blacklist>
-			<directory>./tests/</directory>
-		</blacklist>
-		<whitelist processUncoveredFilesFromWhitelist="true">
-			<directory suffix=".php">./</directory>
-			<exclude>
-				<directory suffix=".php">./language/</directory>
-				<directory suffix=".php">./migrations/</directory>
-				<directory suffix=".php">./tests/</directory>
-			</exclude>
-		</whitelist>
-	</filter>
-</phpunit>
diff --git "[ORIGINAL]/brunoais\\readOthersTopics/travis/prepare-phpbb.sh" "[ORIGINAL]/brunoais\\readOthersTopics/travis/prepare-phpbb.sh"
deleted file mode 100644
--- "[ORIGINAL]/brunoais\\readOthersTopics/travis/prepare-phpbb.sh"
+++ /dev/null
@@ -1,24 +0,0 @@
-#!/bin/bash
-#
-# This file is part of the phpBB Forum Software package.
-#
-# @copyright (c) phpBB Limited <https://www.phpbb.com>
-# @license GNU General Public License, version 2 (GPL-2.0)
-#
-# For full copyright and license information, please see
-# the docs/CREDITS.txt file.
-#
-set -e
-set -x
-
-EXTNAME=$1
-BRANCH=$2
-EXTPATH_TEMP=$3
-
-# Copy extension to a temp folder
-mkdir ../../tmp
-cp -R . ../../tmp
-cd ../../
-
-# Clone phpBB
-git clone --depth=1 "git://github.com/phpbb/phpbb.git" "phpBB3" --branch=$BRANCH
```
