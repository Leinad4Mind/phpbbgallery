Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/.gitignore" "[ORIGINAL]/marttiphpbb\\postingtemplate/.gitignore"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/.gitignore"
+++ /dev/null
@@ -1,3 +0,0 @@
-composer.phar
-/vendor/*
-.dist
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/.travis.yml" "[ORIGINAL]/marttiphpbb\\postingtemplate/.travis.yml"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/.travis.yml"
+++ /dev/null
@@ -1,59 +0,0 @@
-sudo: required
-dist: precise
-
-language: php
-
-matrix:
-  include:
-    - php: 7.0
-      env: DB=mysql
-    - php: 7.0
-      env: DB=mariadb
-    - php: 7.0
-      env: DB=postgres
-    - php: 7.0
-      env: DB=sqlite3
-    - php: 7.0
-      env: DB=mysqli
-    - php: 7.1
-      env: DB=mysqli
-    - php: 7.2
-      env: DB=mysqli
-    - php: hhvm
-      env: DB=mysqli
-    - php: nightly
-      env: DB=mysqli
-  allow_failures:
-    - php: hhvm
-    - php: nightly
-  fast_finish: true
-
-env:
-  global:
-    - EXTNAME="marttiphpbb/postingtemplate"  # CHANGE name of the extension HERE
-    - SNIFF="1"            # Should we run code sniffer on your code?
-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
-    - PHPBB_BRANCH="3.2.x"
-
-branches:
-  only:
-    - master
-    - develop
-    - /^develop-.*$/
-
-install:
-  - sh -c "mkdir --parents ../../tmp/travis; cp -R . ../../tmp; cd ../../; git clone --depth=1 \"git://github.com/phpbb/phpbb.git\" \"phpBB3\" --branch=$PHPBB_BRANCH"
-  - cd ../../phpBB3
-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --dev --no-interaction; composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs; cd ../; fi"
-
-before_script:
-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
-
-script:
-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/' --debug; fi"
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/README.md" "[FORUM_EXT]/marttiphpbb\\postingtemplate/README.md"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/README.md"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/README.md"
@@ -1,10 +1,6 @@
-# phpBB 3.1 Extension - marttiphpbb Posting Template
+### phpBB 3.1 PhpBB Extension - marttiphpbb Posting Template
 
-[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951)
-
-For the phpBB 3.2+ version of this extension see the [Topic Template extension](https://github.com/marttiphpbb/phpbb-ext-topictemplate)
-
-## Quick Install
+#### Quick Install
 
 You can install this on the latest release of phpBB 3.1 by following the steps below:
 
@@ -13,15 +9,17 @@ You can install this on the latest release of phpBB 3.1 by following the steps b
 * Enable `Posting Template` in the ACP at `Customise -> Manage extensions`.
 * You can start editing the Posting Template in the Forum ACP for each Forum.
 
-## Uninstall
+#### Uninstall
 
 * Disable `Posting Template` in the ACP at `Customise -> Extension Management -> Extensions`.
 * To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/postingtemplate` directory.
 
-## Support
+#### Support
 
-* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-postingtemplate/issues).
+* **Important: Only official release versions validated by the phpBB Extensions Team should be installed on a live forum. Pre-release (beta, RC) versions downloaded from this repository are only to be used for testing on offline/development forums and are not officially supported.**
+* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/postingtemplate/issues).
+* Support requests should be posted and discussed in the [Posting Template topic at phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951).
 
-## License
+### License
 
 [GPL-2.0](license.txt)
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/composer.json" "[FORUM_EXT]/marttiphpbb\\postingtemplate/composer.json"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/composer.json"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/composer.json"
@@ -4,14 +4,16 @@
     "description": "Posting Template Extension for phpBB 3.1",
     "homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
     "version": "1.0.0",
-	"time": "2018-07-01",
+    "time": "2015-12-30",
     "license": "GPL-2.0",
-	"authors": [{
+    "authors": [
+        {
             "name": "martti",
             "email": "info@martti.be",
             "homepage": "https://github.com/marttiphpbb/",
             "role": "Developer"
-		}],
+        }
+    ],
     "require": {
         "php": ">=5.3.3"
     },
@@ -21,12 +23,12 @@
     "extra": {
         "display-name": "Posting Template",
         "soft-require": {
-			"phpbb/phpbb": ">=3.2,<3.3"
+            "phpbb/phpbb": ">=3.1.0-RC2,<3.2.*@dev"
         },
         "version-check": {
-			"host": "marttiphpbb.github.io",
-			"directory": "/version",
-			"filename": "postingtemplate.json"
+            "host": "www.phpbb.com",
+            "directory": "/customise/db/extension/posting_template_4",
+            "filename": "version_check"
         }
     }
 }
\ No newline at end of file
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/composer.lock" "[ORIGINAL]/marttiphpbb\\postingtemplate/composer.lock"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/composer.lock"
+++ /dev/null
@@ -1,409 +0,0 @@
-{
-    "_readme": [
-        "This file locks the dependencies of your project to a known state",
-        "Read more about it at http://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
-        "This file is @generated automatically"
-    ],
-    "hash": "b015e820f6b051bbb2f2b52c09c47749",
-    "packages": [],
-    "packages-dev": [
-        {
-            "name": "gitonomy/gitlib",
-            "version": "v0.1.7",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/gitonomy/gitlib.git",
-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/gitonomy/gitlib/zipball/7a46107cfb8552b312101e0d5906e95d54d7ddc6",
-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6",
-                "shasum": ""
-            },
-            "require": {
-                "symfony/process": "~2.4"
-            },
-            "require-dev": {
-                "psr/log": "~1"
-            },
-            "suggest": {
-                "psr/log": "Add some log"
-            },
-            "type": "library",
-            "autoload": {
-                "psr-0": {
-                    "Gitonomy\\Git": [
-                        "src/",
-                        "tests/"
-                    ]
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "MIT"
-            ],
-            "authors": [
-                {
-                    "name": "Alexandre Salomé",
-                    "email": "alexandre.salome@gmail.com",
-                    "homepage": "http://alexandre-salome.fr"
-                },
-                {
-                    "name": "Julien DIDIER",
-                    "email": "genzo.wm@gmail.com",
-                    "homepage": "http://www.jdidier.net"
-                }
-            ],
-            "description": "Library for accessing git",
-            "homepage": "http://gitonomy.com",
-            "time": "2015-07-13 19:02:31"
-        },
-        {
-            "name": "nikic/php-parser",
-            "version": "v0.9.5",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/nikic/PHP-Parser.git",
-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/nikic/PHP-Parser/zipball/ef70767475434bdb3615b43c327e2cae17ef12eb",
-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb",
-                "shasum": ""
-            },
-            "require": {
-                "ext-tokenizer": "*",
-                "php": ">=5.2"
-            },
-            "type": "library",
-            "extra": {
-                "branch-alias": {
-                    "dev-master": "0.9-dev"
-                }
-            },
-            "autoload": {
-                "psr-0": {
-                    "PHPParser": "lib/"
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "BSD-3-Clause"
-            ],
-            "authors": [
-                {
-                    "name": "Nikita Popov"
-                }
-            ],
-            "description": "A PHP parser written in PHP",
-            "keywords": [
-                "parser",
-                "php"
-            ],
-            "time": "2015-07-23 18:24:17"
-        },
-        {
-            "name": "phpbb/epv",
-            "version": "dev-master",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/phpbb/epv.git",
-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/phpbb/epv/zipball/07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
-                "shasum": ""
-            },
-            "require": {
-                "gitonomy/gitlib": "0.1.*@dev",
-                "nikic/php-parser": "0.9.*@dev",
-                "php": ">=5.3.3",
-                "sensiolabs/ansi-to-html": "~1.1",
-                "symfony/console": ">=2.3.0",
-                "symfony/finder": ">=2.3.0",
-                "symfony/yaml": ">=2.3.0|>=2.4.0|>=2.5.0"
-            },
-            "require-dev": {
-                "phpunit/phpunit": "4.0.*"
-            },
-            "bin": [
-                "src/EPV.php"
-            ],
-            "type": "library",
-            "autoload": {
-                "psr-4": {
-                    "Phpbb\\Epv\\": "src/"
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "GPL-2.0"
-            ],
-            "authors": [
-                {
-                    "name": "Paul Sohier",
-                    "email": "paul@phpbb.com"
-                }
-            ],
-            "description": "A extension validator for phpBB extensions. Extensions are required to pass the validator when submitted to the extension database.",
-            "time": "2015-12-13 10:15:27"
-        },
-        {
-            "name": "sensiolabs/ansi-to-html",
-            "version": "v1.1.0",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/sensiolabs/ansi-to-html.git",
-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/sensiolabs/ansi-to-html/zipball/92d2ef7ffba5418be060d8ba8adaf7223d741f93",
-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93",
-                "shasum": ""
-            },
-            "require": {
-                "php": ">=5.3.0"
-            },
-            "suggest": {
-                "twig/twig": "Provides nice templating features"
-            },
-            "type": "library",
-            "extra": {
-                "branch-alias": {
-                    "dev-master": "1.1-dev"
-                }
-            },
-            "autoload": {
-                "psr-0": {
-                    "SensioLabs\\AnsiConverter": "."
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "MIT"
-            ],
-            "authors": [
-                {
-                    "name": "Fabien Potencier",
-                    "email": "fabien@symfony.com"
-                }
-            ],
-            "description": "A library to convert a text with ANSI codes to HTML",
-            "time": "2015-08-01 14:02:39"
-        },
-        {
-            "name": "symfony/console",
-            "version": "v2.6.1",
-            "target-dir": "Symfony/Component/Console",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/symfony/Console.git",
-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/symfony/Console/zipball/ef825fd9f809d275926547c9e57cbf14968793e8",
-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8",
-                "shasum": ""
-            },
-            "require": {
-                "php": ">=5.3.3"
-            },
-            "require-dev": {
-                "psr/log": "~1.0",
-                "symfony/event-dispatcher": "~2.1",
-                "symfony/process": "~2.1"
-            },
-            "suggest": {
-                "psr/log": "For using the console logger",
-                "symfony/event-dispatcher": "",
-                "symfony/process": ""
-            },
-            "type": "library",
-            "extra": {
-                "branch-alias": {
-                    "dev-master": "2.6-dev"
-                }
-            },
-            "autoload": {
-                "psr-0": {
-                    "Symfony\\Component\\Console\\": ""
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "MIT"
-            ],
-            "authors": [
-                {
-                    "name": "Symfony Community",
-                    "homepage": "http://symfony.com/contributors"
-                },
-                {
-                    "name": "Fabien Potencier",
-                    "email": "fabien@symfony.com"
-                }
-            ],
-            "description": "Symfony Console Component",
-            "homepage": "http://symfony.com",
-            "time": "2015-12-02 20:19:20"
-        },
-        {
-            "name": "symfony/finder",
-            "version": "v2.6.1",
-            "target-dir": "Symfony/Component/Finder",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/symfony/Finder.git",
-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/symfony/Finder/zipball/0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
-                "shasum": ""
-            },
-            "require": {
-                "php": ">=5.3.3"
-            },
-            "type": "library",
-            "extra": {
-                "branch-alias": {
-                    "dev-master": "2.6-dev"
-                }
-            },
-            "autoload": {
-                "psr-0": {
-                    "Symfony\\Component\\Finder\\": ""
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "MIT"
-            ],
-            "authors": [
-                {
-                    "name": "Symfony Community",
-                    "homepage": "http://symfony.com/contributors"
-                },
-                {
-                    "name": "Fabien Potencier",
-                    "email": "fabien@symfony.com"
-                }
-            ],
-            "description": "Symfony Finder Component",
-            "homepage": "http://symfony.com",
-            "time": "2015-12-02 20:19:20"
-        },
-        {
-            "name": "symfony/process",
-            "version": "v2.6.1",
-            "target-dir": "Symfony/Component/Process",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/symfony/Process.git",
-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/symfony/Process/zipball/bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
-                "shasum": ""
-            },
-            "require": {
-                "php": ">=5.3.3"
-            },
-            "type": "library",
-            "extra": {
-                "branch-alias": {
-                    "dev-master": "2.6-dev"
-                }
-            },
-            "autoload": {
-                "psr-0": {
-                    "Symfony\\Component\\Process\\": ""
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "MIT"
-            ],
-            "authors": [
-                {
-                    "name": "Symfony Community",
-                    "homepage": "http://symfony.com/contributors"
-                },
-                {
-                    "name": "Fabien Potencier",
-                    "email": "fabien@symfony.com"
-                }
-            ],
-            "description": "Symfony Process Component",
-            "homepage": "http://symfony.com",
-            "time": "2015-12-02 20:19:20"
-        },
-        {
-            "name": "symfony/yaml",
-            "version": "v2.6.1",
-            "target-dir": "Symfony/Component/Yaml",
-            "source": {
-                "type": "git",
-                "url": "https://github.com/symfony/Yaml.git",
-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20"
-            },
-            "dist": {
-                "type": "zip",
-                "url": "https://api.github.com/repos/symfony/Yaml/zipball/3346fc090a3eb6b53d408db2903b241af51dcb20",
-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20",
-                "shasum": ""
-            },
-            "require": {
-                "php": ">=5.3.3"
-            },
-            "type": "library",
-            "extra": {
-                "branch-alias": {
-                    "dev-master": "2.6-dev"
-                }
-            },
-            "autoload": {
-                "psr-0": {
-                    "Symfony\\Component\\Yaml\\": ""
-                }
-            },
-            "notification-url": "https://packagist.org/downloads/",
-            "license": [
-                "MIT"
-            ],
-            "authors": [
-                {
-                    "name": "Symfony Community",
-                    "homepage": "http://symfony.com/contributors"
-                },
-                {
-                    "name": "Fabien Potencier",
-                    "email": "fabien@symfony.com"
-                }
-            ],
-            "description": "Symfony Yaml Component",
-            "homepage": "http://symfony.com",
-            "time": "2015-12-02 20:19:20"
-        }
-    ],
-    "aliases": [],
-    "minimum-stability": "stable",
-    "stability-flags": {
-        "phpbb/epv": 20
-    },
-    "prefer-stable": false,
-    "prefer-lowest": false,
-    "platform": {
-        "php": ">=5.3.3"
-    },
-    "platform-dev": []
-}
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/config/services.yml" "[FORUM_EXT]/marttiphpbb\\postingtemplate/config/services.yml"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/config/services.yml"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/config/services.yml"
@@ -2,11 +2,11 @@ services:
     marttiphpbb.postingtemplate.listener:
         class: marttiphpbb\postingtemplate\event\listener
         arguments:
-            - @config_text
-            - @dbal.conn
-            - @request
-            - @user
-            - %tables.config_text%
-            - %tables.forums%
+            - '@config_text'
+            - '@dbal.conn'
+            - '@request'
+            - '@user'
+            - '%tables.config_text%'
+            - '%tables.forums%'
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/marttiphpbb\\postingtemplate/diff_full.tmp" "[FORUM_EXT]/marttiphpbb\\postingtemplate/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/diff_full.tmp"
@@ -0,0 +1,1469 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
+deleted file mode 100644
+index 914ac394f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-composer.phar
+-/vendor/*
+-.dist
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
+deleted file mode 100644
+index 6a26819dd..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
++++ /dev/null
+@@ -1,59 +0,0 @@
+-sudo: required
+-dist: precise
+-
+-language: php
+-
+-matrix:
+-  include:
+-    - php: 7.0
+-      env: DB=mysql
+-    - php: 7.0
+-      env: DB=mariadb
+-    - php: 7.0
+-      env: DB=postgres
+-    - php: 7.0
+-      env: DB=sqlite3
+-    - php: 7.0
+-      env: DB=mysqli
+-    - php: 7.1
+-      env: DB=mysqli
+-    - php: 7.2
+-      env: DB=mysqli
+-    - php: hhvm
+-      env: DB=mysqli
+-    - php: nightly
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: hhvm
+-    - php: nightly
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="marttiphpbb/postingtemplate"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.2.x"
+-
+-branches:
+-  only:
+-    - master
+-    - develop
+-    - /^develop-.*$/
+-
+-install:
+-  - sh -c "mkdir --parents ../../tmp/travis; cp -R . ../../tmp; cd ../../; git clone --depth=1 \"git://github.com/phpbb/phpbb.git\" \"phpBB3\" --branch=$PHPBB_BRANCH"
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --dev --no-interaction; composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs; cd ../; fi"
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/' --debug; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
+index f53bdc176..3cfb9450d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
+@@ -1,10 +1,6 @@
+-# phpBB 3.1 Extension - marttiphpbb Posting Template
++### phpBB 3.1 PhpBB Extension - marttiphpbb Posting Template
+ 
+-[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951)
+-
+-For the phpBB 3.2+ version of this extension see the [Topic Template extension](https://github.com/marttiphpbb/phpbb-ext-topictemplate)
+-
+-## Quick Install
++#### Quick Install
+ 
+ You can install this on the latest release of phpBB 3.1 by following the steps below:
+ 
+@@ -13,15 +9,17 @@ You can install this on the latest release of phpBB 3.1 by following the steps b
+ * Enable `Posting Template` in the ACP at `Customise -> Manage extensions`.
+ * You can start editing the Posting Template in the Forum ACP for each Forum.
+ 
+-## Uninstall
++#### Uninstall
+ 
+ * Disable `Posting Template` in the ACP at `Customise -> Extension Management -> Extensions`.
+ * To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/postingtemplate` directory.
+ 
+-## Support
++#### Support
+ 
+-* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-postingtemplate/issues).
++* **Important: Only official release versions validated by the phpBB Extensions Team should be installed on a live forum. Pre-release (beta, RC) versions downloaded from this repository are only to be used for testing on offline/development forums and are not officially supported.**
++* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/postingtemplate/issues).
++* Support requests should be posted and discussed in the [Posting Template topic at phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951).
+ 
+-## License
++### License
+ 
+ [GPL-2.0](license.txt)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
+index d32193276..454bba89b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
+@@ -1,32 +1,34 @@
+ {
+-	"name": "marttiphpbb/postingtemplate",
+-	"type": "phpbb-extension",
+-	"description": "Posting Template Extension for phpBB 3.1",
+-	"homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
+-	"version": "1.0.0",
+-	"time": "2018-07-01",
+-	"license": "GPL-2.0",
+-	"authors": [{
+-			"name": "martti",
+-			"email": "info@martti.be",
+-			"homepage": "https://github.com/marttiphpbb/",
+-			"role": "Developer"
+-		}],
+-	"require": {
+-		"php": ">=5.3.3"
+-	},
+-	"require-dev": {
+-		"phpbb/epv": "dev-master"
+-	},
+-	"extra": {
+-		"display-name": "Posting Template",
+-		"soft-require": {
+-			"phpbb/phpbb": ">=3.2,<3.3"
+-		},
+-		"version-check": {
+-			"host": "marttiphpbb.github.io",
+-			"directory": "/version",
+-			"filename": "postingtemplate.json"
+-		}
+-	}
+-}
++    "name": "marttiphpbb/postingtemplate",
++    "type": "phpbb-extension",
++    "description": "Posting Template Extension for phpBB 3.1",
++    "homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
++    "version": "1.0.0",
++    "time": "2015-12-30",
++    "license": "GPL-2.0",
++    "authors": [
++        {
++            "name": "martti",
++            "email": "info@martti.be",
++            "homepage": "https://github.com/marttiphpbb/",
++            "role": "Developer"
++        }
++    ],
++    "require": {
++        "php": ">=5.3.3"
++    },
++    "require-dev": {
++        "phpbb/epv": "dev-master"
++    },
++    "extra": {
++        "display-name": "Posting Template",
++        "soft-require": {
++            "phpbb/phpbb": ">=3.1.0-RC2,<3.2.*@dev"
++        },
++        "version-check": {
++            "host": "www.phpbb.com",
++            "directory": "/customise/db/extension/posting_template_4",
++            "filename": "version_check"
++        }
++    }
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
+deleted file mode 100644
+index 5f1821f6e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
++++ /dev/null
+@@ -1,409 +0,0 @@
+-{
+-    "_readme": [
+-        "This file locks the dependencies of your project to a known state",
+-        "Read more about it at http://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
+-        "This file is @generated automatically"
+-    ],
+-    "hash": "b015e820f6b051bbb2f2b52c09c47749",
+-    "packages": [],
+-    "packages-dev": [
+-        {
+-            "name": "gitonomy/gitlib",
+-            "version": "v0.1.7",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/gitonomy/gitlib.git",
+-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/gitonomy/gitlib/zipball/7a46107cfb8552b312101e0d5906e95d54d7ddc6",
+-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "symfony/process": "~2.4"
+-            },
+-            "require-dev": {
+-                "psr/log": "~1"
+-            },
+-            "suggest": {
+-                "psr/log": "Add some log"
+-            },
+-            "type": "library",
+-            "autoload": {
+-                "psr-0": {
+-                    "Gitonomy\\Git": [
+-                        "src/",
+-                        "tests/"
+-                    ]
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Alexandre Salomé",
+-                    "email": "alexandre.salome@gmail.com",
+-                    "homepage": "http://alexandre-salome.fr"
+-                },
+-                {
+-                    "name": "Julien DIDIER",
+-                    "email": "genzo.wm@gmail.com",
+-                    "homepage": "http://www.jdidier.net"
+-                }
+-            ],
+-            "description": "Library for accessing git",
+-            "homepage": "http://gitonomy.com",
+-            "time": "2015-07-13 19:02:31"
+-        },
+-        {
+-            "name": "nikic/php-parser",
+-            "version": "v0.9.5",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/nikic/PHP-Parser.git",
+-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/nikic/PHP-Parser/zipball/ef70767475434bdb3615b43c327e2cae17ef12eb",
+-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "ext-tokenizer": "*",
+-                "php": ">=5.2"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "0.9-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "PHPParser": "lib/"
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "BSD-3-Clause"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Nikita Popov"
+-                }
+-            ],
+-            "description": "A PHP parser written in PHP",
+-            "keywords": [
+-                "parser",
+-                "php"
+-            ],
+-            "time": "2015-07-23 18:24:17"
+-        },
+-        {
+-            "name": "phpbb/epv",
+-            "version": "dev-master",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/phpbb/epv.git",
+-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/phpbb/epv/zipball/07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
+-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "gitonomy/gitlib": "0.1.*@dev",
+-                "nikic/php-parser": "0.9.*@dev",
+-                "php": ">=5.3.3",
+-                "sensiolabs/ansi-to-html": "~1.1",
+-                "symfony/console": ">=2.3.0",
+-                "symfony/finder": ">=2.3.0",
+-                "symfony/yaml": ">=2.3.0|>=2.4.0|>=2.5.0"
+-            },
+-            "require-dev": {
+-                "phpunit/phpunit": "4.0.*"
+-            },
+-            "bin": [
+-                "src/EPV.php"
+-            ],
+-            "type": "library",
+-            "autoload": {
+-                "psr-4": {
+-                    "Phpbb\\Epv\\": "src/"
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "GPL-2.0"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Paul Sohier",
+-                    "email": "paul@phpbb.com"
+-                }
+-            ],
+-            "description": "A extension validator for phpBB extensions. Extensions are required to pass the validator when submitted to the extension database.",
+-            "time": "2015-12-13 10:15:27"
+-        },
+-        {
+-            "name": "sensiolabs/ansi-to-html",
+-            "version": "v1.1.0",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/sensiolabs/ansi-to-html.git",
+-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/sensiolabs/ansi-to-html/zipball/92d2ef7ffba5418be060d8ba8adaf7223d741f93",
+-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.0"
+-            },
+-            "suggest": {
+-                "twig/twig": "Provides nice templating features"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "1.1-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "SensioLabs\\AnsiConverter": "."
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "A library to convert a text with ANSI codes to HTML",
+-            "time": "2015-08-01 14:02:39"
+-        },
+-        {
+-            "name": "symfony/console",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Console",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Console.git",
+-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Console/zipball/ef825fd9f809d275926547c9e57cbf14968793e8",
+-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "require-dev": {
+-                "psr/log": "~1.0",
+-                "symfony/event-dispatcher": "~2.1",
+-                "symfony/process": "~2.1"
+-            },
+-            "suggest": {
+-                "psr/log": "For using the console logger",
+-                "symfony/event-dispatcher": "",
+-                "symfony/process": ""
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Console\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Console Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        },
+-        {
+-            "name": "symfony/finder",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Finder",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Finder.git",
+-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Finder/zipball/0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
+-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Finder\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Finder Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        },
+-        {
+-            "name": "symfony/process",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Process",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Process.git",
+-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Process/zipball/bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
+-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Process\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Process Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        },
+-        {
+-            "name": "symfony/yaml",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Yaml",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Yaml.git",
+-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Yaml/zipball/3346fc090a3eb6b53d408db2903b241af51dcb20",
+-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Yaml\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Yaml Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        }
+-    ],
+-    "aliases": [],
+-    "minimum-stability": "stable",
+-    "stability-flags": {
+-        "phpbb/epv": 20
+-    },
+-    "prefer-stable": false,
+-    "prefer-lowest": false,
+-    "platform": {
+-        "php": ">=5.3.3"
+-    },
+-    "platform-dev": []
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/config/services.yml"
+index e1cceaa4e..00ec4485c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/config/services.yml"
+@@ -2,11 +2,11 @@ services:
+     marttiphpbb.postingtemplate.listener:
+         class: marttiphpbb\postingtemplate\event\listener
+         arguments:
+-            - @config_text
+-            - @dbal.conn
+-            - @request
+-            - @user
+-            - %tables.config_text%
+-            - %tables.forums%
++            - '@config_text'
++            - '@dbal.conn'
++            - '@request'
++            - '@user'
++            - '%tables.config_text%'
++            - '%tables.forums%'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp"
+new file mode 100644
+index 000000000..e4d72354e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp"
+@@ -0,0 +1,544 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
++deleted file mode 100644
++index 914ac394f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-composer.phar
++-/vendor/*
++-.dist
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
++deleted file mode 100644
++index 6a26819dd..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
+++++ /dev/null
++@@ -1,59 +0,0 @@
++-sudo: required
++-dist: precise
++-
++-language: php
++-
++-matrix:
++-  include:
++-    - php: 7.0
++-      env: DB=mysql
++-    - php: 7.0
++-      env: DB=mariadb
++-    - php: 7.0
++-      env: DB=postgres
++-    - php: 7.0
++-      env: DB=sqlite3
++-    - php: 7.0
++-      env: DB=mysqli
++-    - php: 7.1
++-      env: DB=mysqli
++-    - php: 7.2
++-      env: DB=mysqli
++-    - php: hhvm
++-      env: DB=mysqli
++-    - php: nightly
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: hhvm
++-    - php: nightly
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="marttiphpbb/postingtemplate"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.2.x"
++-
++-branches:
++-  only:
++-    - master
++-    - develop
++-    - /^develop-.*$/
++-
++-install:
++-  - sh -c "mkdir --parents ../../tmp/travis; cp -R . ../../tmp; cd ../../; git clone --depth=1 \"git://github.com/phpbb/phpbb.git\" \"phpBB3\" --branch=$PHPBB_BRANCH"
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --dev --no-interaction; composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs; cd ../; fi"
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
++-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/' --debug; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
++index f53bdc176..3cfb9450d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
++@@ -1,10 +1,6 @@
++-# phpBB 3.1 Extension - marttiphpbb Posting Template
+++### phpBB 3.1 PhpBB Extension - marttiphpbb Posting Template
++ 
++-[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951)
++-
++-For the phpBB 3.2+ version of this extension see the [Topic Template extension](https://github.com/marttiphpbb/phpbb-ext-topictemplate)
++-
++-## Quick Install
+++#### Quick Install
++ 
++ You can install this on the latest release of phpBB 3.1 by following the steps below:
++ 
++@@ -13,15 +9,17 @@ You can install this on the latest release of phpBB 3.1 by following the steps b
++ * Enable `Posting Template` in the ACP at `Customise -> Manage extensions`.
++ * You can start editing the Posting Template in the Forum ACP for each Forum.
++ 
++-## Uninstall
+++#### Uninstall
++ 
++ * Disable `Posting Template` in the ACP at `Customise -> Extension Management -> Extensions`.
++ * To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/postingtemplate` directory.
++ 
++-## Support
+++#### Support
++ 
++-* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-postingtemplate/issues).
+++* **Important: Only official release versions validated by the phpBB Extensions Team should be installed on a live forum. Pre-release (beta, RC) versions downloaded from this repository are only to be used for testing on offline/development forums and are not officially supported.**
+++* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/postingtemplate/issues).
+++* Support requests should be posted and discussed in the [Posting Template topic at phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951).
++ 
++-## License
+++### License
++ 
++ [GPL-2.0](license.txt)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
++index d32193276..454bba89b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
++@@ -1,32 +1,34 @@
++ {
++-	"name": "marttiphpbb/postingtemplate",
++-	"type": "phpbb-extension",
++-	"description": "Posting Template Extension for phpBB 3.1",
++-	"homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
++-	"version": "1.0.0",
++-	"time": "2018-07-01",
++-	"license": "GPL-2.0",
++-	"authors": [{
++-			"name": "martti",
++-			"email": "info@martti.be",
++-			"homepage": "https://github.com/marttiphpbb/",
++-			"role": "Developer"
++-		}],
++-	"require": {
++-		"php": ">=5.3.3"
++-	},
++-	"require-dev": {
++-		"phpbb/epv": "dev-master"
++-	},
++-	"extra": {
++-		"display-name": "Posting Template",
++-		"soft-require": {
++-			"phpbb/phpbb": ">=3.2,<3.3"
++-		},
++-		"version-check": {
++-			"host": "marttiphpbb.github.io",
++-			"directory": "/version",
++-			"filename": "postingtemplate.json"
++-		}
++-	}
++-}
+++    "name": "marttiphpbb/postingtemplate",
+++    "type": "phpbb-extension",
+++    "description": "Posting Template Extension for phpBB 3.1",
+++    "homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
+++    "version": "1.0.0",
+++    "time": "2015-12-30",
+++    "license": "GPL-2.0",
+++    "authors": [
+++        {
+++            "name": "martti",
+++            "email": "info@martti.be",
+++            "homepage": "https://github.com/marttiphpbb/",
+++            "role": "Developer"
+++        }
+++    ],
+++    "require": {
+++        "php": ">=5.3.3"
+++    },
+++    "require-dev": {
+++        "phpbb/epv": "dev-master"
+++    },
+++    "extra": {
+++        "display-name": "Posting Template",
+++        "soft-require": {
+++            "phpbb/phpbb": ">=3.1.0-RC2,<3.2.*@dev"
+++        },
+++        "version-check": {
+++            "host": "www.phpbb.com",
+++            "directory": "/customise/db/extension/posting_template_4",
+++            "filename": "version_check"
+++        }
+++    }
+++}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
++deleted file mode 100644
++index 5f1821f6e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
+++++ /dev/null
++@@ -1,409 +0,0 @@
++-{
++-    "_readme": [
++-        "This file locks the dependencies of your project to a known state",
++-        "Read more about it at http://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
++-        "This file is @generated automatically"
++-    ],
++-    "hash": "b015e820f6b051bbb2f2b52c09c47749",
++-    "packages": [],
++-    "packages-dev": [
++-        {
++-            "name": "gitonomy/gitlib",
++-            "version": "v0.1.7",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/gitonomy/gitlib.git",
++-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/gitonomy/gitlib/zipball/7a46107cfb8552b312101e0d5906e95d54d7ddc6",
++-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "symfony/process": "~2.4"
++-            },
++-            "require-dev": {
++-                "psr/log": "~1"
++-            },
++-            "suggest": {
++-                "psr/log": "Add some log"
++-            },
++-            "type": "library",
++-            "autoload": {
++-                "psr-0": {
++-                    "Gitonomy\\Git": [
++-                        "src/",
++-                        "tests/"
++-                    ]
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Alexandre Salomé",
++-                    "email": "alexandre.salome@gmail.com",
++-                    "homepage": "http://alexandre-salome.fr"
++-                },
++-                {
++-                    "name": "Julien DIDIER",
++-                    "email": "genzo.wm@gmail.com",
++-                    "homepage": "http://www.jdidier.net"
++-                }
++-            ],
++-            "description": "Library for accessing git",
++-            "homepage": "http://gitonomy.com",
++-            "time": "2015-07-13 19:02:31"
++-        },
++-        {
++-            "name": "nikic/php-parser",
++-            "version": "v0.9.5",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/nikic/PHP-Parser.git",
++-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/nikic/PHP-Parser/zipball/ef70767475434bdb3615b43c327e2cae17ef12eb",
++-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "ext-tokenizer": "*",
++-                "php": ">=5.2"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "0.9-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "PHPParser": "lib/"
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "BSD-3-Clause"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Nikita Popov"
++-                }
++-            ],
++-            "description": "A PHP parser written in PHP",
++-            "keywords": [
++-                "parser",
++-                "php"
++-            ],
++-            "time": "2015-07-23 18:24:17"
++-        },
++-        {
++-            "name": "phpbb/epv",
++-            "version": "dev-master",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/phpbb/epv.git",
++-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/phpbb/epv/zipball/07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
++-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "gitonomy/gitlib": "0.1.*@dev",
++-                "nikic/php-parser": "0.9.*@dev",
++-                "php": ">=5.3.3",
++-                "sensiolabs/ansi-to-html": "~1.1",
++-                "symfony/console": ">=2.3.0",
++-                "symfony/finder": ">=2.3.0",
++-                "symfony/yaml": ">=2.3.0|>=2.4.0|>=2.5.0"
++-            },
++-            "require-dev": {
++-                "phpunit/phpunit": "4.0.*"
++-            },
++-            "bin": [
++-                "src/EPV.php"
++-            ],
++-            "type": "library",
++-            "autoload": {
++-                "psr-4": {
++-                    "Phpbb\\Epv\\": "src/"
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "GPL-2.0"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Paul Sohier",
++-                    "email": "paul@phpbb.com"
++-                }
++-            ],
++-            "description": "A extension validator for phpBB extensions. Extensions are required to pass the validator when submitted to the extension database.",
++-            "time": "2015-12-13 10:15:27"
++-        },
++-        {
++-            "name": "sensiolabs/ansi-to-html",
++-            "version": "v1.1.0",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/sensiolabs/ansi-to-html.git",
++-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/sensiolabs/ansi-to-html/zipball/92d2ef7ffba5418be060d8ba8adaf7223d741f93",
++-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.0"
++-            },
++-            "suggest": {
++-                "twig/twig": "Provides nice templating features"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "1.1-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "SensioLabs\\AnsiConverter": "."
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "A library to convert a text with ANSI codes to HTML",
++-            "time": "2015-08-01 14:02:39"
++-        },
++-        {
++-            "name": "symfony/console",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Console",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Console.git",
++-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Console/zipball/ef825fd9f809d275926547c9e57cbf14968793e8",
++-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "require-dev": {
++-                "psr/log": "~1.0",
++-                "symfony/event-dispatcher": "~2.1",
++-                "symfony/process": "~2.1"
++-            },
++-            "suggest": {
++-                "psr/log": "For using the console logger",
++-                "symfony/event-dispatcher": "",
++-                "symfony/process": ""
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Console\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Console Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        },
++-        {
++-            "name": "symfony/finder",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Finder",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Finder.git",
++-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Finder/zipball/0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
++-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Finder\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Finder Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        },
++-        {
++-            "name": "symfony/process",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Process",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Process.git",
++-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Process/zipball/bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
++-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Process\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Process Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        },
++-        {
++-            "name": "symfony/yaml",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Yaml",
++- 
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/event/listener.php"
+index 68e2d4c9a..3a76813d6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/event/listener.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+ * phpBB Extension - marttiphpbb posting template
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/ext.php"
+index eea4c0172..c37bd447d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/ext.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+ * phpBB Extension - marttiphpbb postingtemplate
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/ar/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/ar/acp.php"
+index eb1568736..bcd7190fa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/ar/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/ar/acp.php"
+@@ -2,7 +2,7 @@
+ 
+ /**
+ * phpBB Extension - marttiphpbb posting template
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ * Translated By : Basil Taha Alhitary - www.alhitary.net
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/en/acp.php"
+index a72f64470..80c7b1c82 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/en/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/en/acp.php"
+@@ -2,7 +2,7 @@
+ 
+ /**
+ * phpBB Extension - marttiphpbb posting template
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/es/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/es/acp.php"
+index cb8a0b18d..79e1fd324 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/es/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/es/acp.php"
+@@ -2,7 +2,7 @@
+ 
+ /**
+ * phpBB Extension - marttiphpbb posting template
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/fr/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/fr/acp.php"
+deleted file mode 100644
+index 626c41fae..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/fr/acp.php"
++++ /dev/null
+@@ -1,38 +0,0 @@
+-<?php
+-
+-/**
+-* phpBB Extension - marttiphpbb posting template
+-* French translation by Galixte (http://www.galixte.com)
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*/
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-
+-$lang = array_merge($lang, array(
+-	'ACP_POSTINGTEMPLATE'			=> 'Modèle de message',
+-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'Lors de la création d’un sujet, l’éditeur de texte sera pré-rempli selon le modèle de message. Laissez ce champ vide lorsque vous ne souhaitez pas l’utiliser.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/nl/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/nl/acp.php"
+index 6cc0bae23..11882ebf2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/nl/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/nl/acp.php"
+@@ -2,7 +2,7 @@
+ 
+ /**
+ * phpBB Extension - marttiphpbb 
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ * [Dutch] translated by Dutch Translators (https://github.com/dutch-translators)
+ */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/pt_br/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/pt_br/acp.php"
+deleted file mode 100644
+index 591feff41..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/pt_br/acp.php"
++++ /dev/null
+@@ -1,38 +0,0 @@
+-<?php
+-
+-/**
+-* phpBB Extension - marttiphpbb posting template
+-* Brazilian Portuguese translation by eunaumtenhoid (c) 2018 [ver 1.0.0] (https://github.com/phpBBTraducoes) 
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*/
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-
+-$lang = array_merge($lang, array(
+-	'ACP_POSTINGTEMPLATE'			=> 'Posting template',
+-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'Ao iniciar um tópico, o editor de texto será pré-preenchido com este modelo de postagem. Deixe em branco quando você não desejar usar isso.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/sv/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/sv/acp.php"
+deleted file mode 100644
+index fbf1b09fb..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/sv/acp.php"
++++ /dev/null
+@@ -1,38 +0,0 @@
+-<?php
+-
+-/**
+-* phpBB Extension - marttiphpbb posting template
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+-* Swedish translation by Holger (http://www.maskinisten.net)
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*/
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-
+-$lang = array_merge($lang, array(
+-	'ACP_POSTINGTEMPLATE'			=> 'Inläggsmall',
+-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'När ett nytt ämne skapas så kommer fältet för meddelande att innehålla dessa inläggsmallens text. Lämna tomt om du ej vill använda detta.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/tr/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/tr/acp.php"
+index 5a910eca5..8443768e6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/tr/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/tr/acp.php"
+@@ -2,7 +2,7 @@
+ 
+ /**
+ * phpBB Extension - marttiphpbb posting template
+-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++* @copyright (c) 2015 marttiphpbb <info@martti.be>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/phpunit.xml.dist" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/phpunit.xml.dist"
+deleted file mode 100644
+index 289449d49..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/phpunit.xml.dist"
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
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/travis/prepare-phpbb.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/travis/prepare-phpbb.sh"
+deleted file mode 100644
+index 01770ad6e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/travis/prepare-phpbb.sh"
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
diff --git "[FORUM_EXT]/marttiphpbb\\postingtemplate/diff_nospace.tmp" "[FORUM_EXT]/marttiphpbb\\postingtemplate/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/diff_nospace.tmp"
@@ -0,0 +1,2038 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
+deleted file mode 100644
+index 914ac394f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-composer.phar
+-/vendor/*
+-.dist
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
+deleted file mode 100644
+index 6a26819dd..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
++++ /dev/null
+@@ -1,59 +0,0 @@
+-sudo: required
+-dist: precise
+-
+-language: php
+-
+-matrix:
+-  include:
+-    - php: 7.0
+-      env: DB=mysql
+-    - php: 7.0
+-      env: DB=mariadb
+-    - php: 7.0
+-      env: DB=postgres
+-    - php: 7.0
+-      env: DB=sqlite3
+-    - php: 7.0
+-      env: DB=mysqli
+-    - php: 7.1
+-      env: DB=mysqli
+-    - php: 7.2
+-      env: DB=mysqli
+-    - php: hhvm
+-      env: DB=mysqli
+-    - php: nightly
+-      env: DB=mysqli
+-  allow_failures:
+-    - php: hhvm
+-    - php: nightly
+-  fast_finish: true
+-
+-env:
+-  global:
+-    - EXTNAME="marttiphpbb/postingtemplate"  # CHANGE name of the extension HERE
+-    - SNIFF="1"            # Should we run code sniffer on your code?
+-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-    - PHPBB_BRANCH="3.2.x"
+-
+-branches:
+-  only:
+-    - master
+-    - develop
+-    - /^develop-.*$/
+-
+-install:
+-  - sh -c "mkdir --parents ../../tmp/travis; cp -R . ../../tmp; cd ../../; git clone --depth=1 \"git://github.com/phpbb/phpbb.git\" \"phpBB3\" --branch=$PHPBB_BRANCH"
+-  - cd ../../phpBB3
+-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --dev --no-interaction; composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs; cd ../; fi"
+-
+-before_script:
+-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/' --debug; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
+index f53bdc176..3cfb9450d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
+@@ -1,10 +1,6 @@
+-# phpBB 3.1 Extension - marttiphpbb Posting Template
++### phpBB 3.1 PhpBB Extension - marttiphpbb Posting Template
+ 
+-[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951)
+-
+-For the phpBB 3.2+ version of this extension see the [Topic Template extension](https://github.com/marttiphpbb/phpbb-ext-topictemplate)
+-
+-## Quick Install
++#### Quick Install
+ 
+ You can install this on the latest release of phpBB 3.1 by following the steps below:
+ 
+@@ -13,15 +9,17 @@ You can install this on the latest release of phpBB 3.1 by following the steps b
+ * Enable `Posting Template` in the ACP at `Customise -> Manage extensions`.
+ * You can start editing the Posting Template in the Forum ACP for each Forum.
+ 
+-## Uninstall
++#### Uninstall
+ 
+ * Disable `Posting Template` in the ACP at `Customise -> Extension Management -> Extensions`.
+ * To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/postingtemplate` directory.
+ 
+-## Support
++#### Support
+ 
+-* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-postingtemplate/issues).
++* **Important: Only official release versions validated by the phpBB Extensions Team should be installed on a live forum. Pre-release (beta, RC) versions downloaded from this repository are only to be used for testing on offline/development forums and are not officially supported.**
++* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/postingtemplate/issues).
++* Support requests should be posted and discussed in the [Posting Template topic at phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951).
+ 
+-## License
++### License
+ 
+ [GPL-2.0](license.txt)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
+index d32193276..454bba89b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
+@@ -4,14 +4,16 @@
+     "description": "Posting Template Extension for phpBB 3.1",
+     "homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
+     "version": "1.0.0",
+-	"time": "2018-07-01",
++    "time": "2015-12-30",
+     "license": "GPL-2.0",
+-	"authors": [{
++    "authors": [
++        {
+             "name": "martti",
+             "email": "info@martti.be",
+             "homepage": "https://github.com/marttiphpbb/",
+             "role": "Developer"
+-		}],
++        }
++    ],
+     "require": {
+         "php": ">=5.3.3"
+     },
+@@ -21,12 +23,12 @@
+     "extra": {
+         "display-name": "Posting Template",
+         "soft-require": {
+-			"phpbb/phpbb": ">=3.2,<3.3"
++            "phpbb/phpbb": ">=3.1.0-RC2,<3.2.*@dev"
+         },
+         "version-check": {
+-			"host": "marttiphpbb.github.io",
+-			"directory": "/version",
+-			"filename": "postingtemplate.json"
++            "host": "www.phpbb.com",
++            "directory": "/customise/db/extension/posting_template_4",
++            "filename": "version_check"
+         }
+     }
+ }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
+deleted file mode 100644
+index 5f1821f6e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
++++ /dev/null
+@@ -1,409 +0,0 @@
+-{
+-    "_readme": [
+-        "This file locks the dependencies of your project to a known state",
+-        "Read more about it at http://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
+-        "This file is @generated automatically"
+-    ],
+-    "hash": "b015e820f6b051bbb2f2b52c09c47749",
+-    "packages": [],
+-    "packages-dev": [
+-        {
+-            "name": "gitonomy/gitlib",
+-            "version": "v0.1.7",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/gitonomy/gitlib.git",
+-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/gitonomy/gitlib/zipball/7a46107cfb8552b312101e0d5906e95d54d7ddc6",
+-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "symfony/process": "~2.4"
+-            },
+-            "require-dev": {
+-                "psr/log": "~1"
+-            },
+-            "suggest": {
+-                "psr/log": "Add some log"
+-            },
+-            "type": "library",
+-            "autoload": {
+-                "psr-0": {
+-                    "Gitonomy\\Git": [
+-                        "src/",
+-                        "tests/"
+-                    ]
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Alexandre Salomé",
+-                    "email": "alexandre.salome@gmail.com",
+-                    "homepage": "http://alexandre-salome.fr"
+-                },
+-                {
+-                    "name": "Julien DIDIER",
+-                    "email": "genzo.wm@gmail.com",
+-                    "homepage": "http://www.jdidier.net"
+-                }
+-            ],
+-            "description": "Library for accessing git",
+-            "homepage": "http://gitonomy.com",
+-            "time": "2015-07-13 19:02:31"
+-        },
+-        {
+-            "name": "nikic/php-parser",
+-            "version": "v0.9.5",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/nikic/PHP-Parser.git",
+-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/nikic/PHP-Parser/zipball/ef70767475434bdb3615b43c327e2cae17ef12eb",
+-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "ext-tokenizer": "*",
+-                "php": ">=5.2"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "0.9-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "PHPParser": "lib/"
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "BSD-3-Clause"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Nikita Popov"
+-                }
+-            ],
+-            "description": "A PHP parser written in PHP",
+-            "keywords": [
+-                "parser",
+-                "php"
+-            ],
+-            "time": "2015-07-23 18:24:17"
+-        },
+-        {
+-            "name": "phpbb/epv",
+-            "version": "dev-master",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/phpbb/epv.git",
+-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/phpbb/epv/zipball/07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
+-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "gitonomy/gitlib": "0.1.*@dev",
+-                "nikic/php-parser": "0.9.*@dev",
+-                "php": ">=5.3.3",
+-                "sensiolabs/ansi-to-html": "~1.1",
+-                "symfony/console": ">=2.3.0",
+-                "symfony/finder": ">=2.3.0",
+-                "symfony/yaml": ">=2.3.0|>=2.4.0|>=2.5.0"
+-            },
+-            "require-dev": {
+-                "phpunit/phpunit": "4.0.*"
+-            },
+-            "bin": [
+-                "src/EPV.php"
+-            ],
+-            "type": "library",
+-            "autoload": {
+-                "psr-4": {
+-                    "Phpbb\\Epv\\": "src/"
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "GPL-2.0"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Paul Sohier",
+-                    "email": "paul@phpbb.com"
+-                }
+-            ],
+-            "description": "A extension validator for phpBB extensions. Extensions are required to pass the validator when submitted to the extension database.",
+-            "time": "2015-12-13 10:15:27"
+-        },
+-        {
+-            "name": "sensiolabs/ansi-to-html",
+-            "version": "v1.1.0",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/sensiolabs/ansi-to-html.git",
+-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/sensiolabs/ansi-to-html/zipball/92d2ef7ffba5418be060d8ba8adaf7223d741f93",
+-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.0"
+-            },
+-            "suggest": {
+-                "twig/twig": "Provides nice templating features"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "1.1-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "SensioLabs\\AnsiConverter": "."
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "A library to convert a text with ANSI codes to HTML",
+-            "time": "2015-08-01 14:02:39"
+-        },
+-        {
+-            "name": "symfony/console",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Console",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Console.git",
+-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Console/zipball/ef825fd9f809d275926547c9e57cbf14968793e8",
+-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "require-dev": {
+-                "psr/log": "~1.0",
+-                "symfony/event-dispatcher": "~2.1",
+-                "symfony/process": "~2.1"
+-            },
+-            "suggest": {
+-                "psr/log": "For using the console logger",
+-                "symfony/event-dispatcher": "",
+-                "symfony/process": ""
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Console\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Console Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        },
+-        {
+-            "name": "symfony/finder",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Finder",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Finder.git",
+-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Finder/zipball/0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
+-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Finder\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Finder Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        },
+-        {
+-            "name": "symfony/process",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Process",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Process.git",
+-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Process/zipball/bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
+-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Process\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Process Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        },
+-        {
+-            "name": "symfony/yaml",
+-            "version": "v2.6.1",
+-            "target-dir": "Symfony/Component/Yaml",
+-            "source": {
+-                "type": "git",
+-                "url": "https://github.com/symfony/Yaml.git",
+-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20"
+-            },
+-            "dist": {
+-                "type": "zip",
+-                "url": "https://api.github.com/repos/symfony/Yaml/zipball/3346fc090a3eb6b53d408db2903b241af51dcb20",
+-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20",
+-                "shasum": ""
+-            },
+-            "require": {
+-                "php": ">=5.3.3"
+-            },
+-            "type": "library",
+-            "extra": {
+-                "branch-alias": {
+-                    "dev-master": "2.6-dev"
+-                }
+-            },
+-            "autoload": {
+-                "psr-0": {
+-                    "Symfony\\Component\\Yaml\\": ""
+-                }
+-            },
+-            "notification-url": "https://packagist.org/downloads/",
+-            "license": [
+-                "MIT"
+-            ],
+-            "authors": [
+-                {
+-                    "name": "Symfony Community",
+-                    "homepage": "http://symfony.com/contributors"
+-                },
+-                {
+-                    "name": "Fabien Potencier",
+-                    "email": "fabien@symfony.com"
+-                }
+-            ],
+-            "description": "Symfony Yaml Component",
+-            "homepage": "http://symfony.com",
+-            "time": "2015-12-02 20:19:20"
+-        }
+-    ],
+-    "aliases": [],
+-    "minimum-stability": "stable",
+-    "stability-flags": {
+-        "phpbb/epv": 20
+-    },
+-    "prefer-stable": false,
+-    "prefer-lowest": false,
+-    "platform": {
+-        "php": ">=5.3.3"
+-    },
+-    "platform-dev": []
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/config/services.yml"
+index e1cceaa4e..00ec4485c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/config/services.yml"
+@@ -2,11 +2,11 @@ services:
+     marttiphpbb.postingtemplate.listener:
+         class: marttiphpbb\postingtemplate\event\listener
+         arguments:
+-            - @config_text
+-            - @dbal.conn
+-            - @request
+-            - @user
+-            - %tables.config_text%
+-            - %tables.forums%
++            - '@config_text'
++            - '@dbal.conn'
++            - '@request'
++            - '@user'
++            - '%tables.config_text%'
++            - '%tables.forums%'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp"
+new file mode 100644
+index 000000000..8dfb1308e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp"
+@@ -0,0 +1,1469 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
++deleted file mode 100644
++index 914ac394f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-composer.phar
++-/vendor/*
++-.dist
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
++deleted file mode 100644
++index 6a26819dd..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
+++++ /dev/null
++@@ -1,59 +0,0 @@
++-sudo: required
++-dist: precise
++-
++-language: php
++-
++-matrix:
++-  include:
++-    - php: 7.0
++-      env: DB=mysql
++-    - php: 7.0
++-      env: DB=mariadb
++-    - php: 7.0
++-      env: DB=postgres
++-    - php: 7.0
++-      env: DB=sqlite3
++-    - php: 7.0
++-      env: DB=mysqli
++-    - php: 7.1
++-      env: DB=mysqli
++-    - php: 7.2
++-      env: DB=mysqli
++-    - php: hhvm
++-      env: DB=mysqli
++-    - php: nightly
++-      env: DB=mysqli
++-  allow_failures:
++-    - php: hhvm
++-    - php: nightly
++-  fast_finish: true
++-
++-env:
++-  global:
++-    - EXTNAME="marttiphpbb/postingtemplate"  # CHANGE name of the extension HERE
++-    - SNIFF="1"            # Should we run code sniffer on your code?
++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-    - PHPBB_BRANCH="3.2.x"
++-
++-branches:
++-  only:
++-    - master
++-    - develop
++-    - /^develop-.*$/
++-
++-install:
++-  - sh -c "mkdir --parents ../../tmp/travis; cp -R . ../../tmp; cd ../../; git clone --depth=1 \"git://github.com/phpbb/phpbb.git\" \"phpBB3\" --branch=$PHPBB_BRANCH"
++-  - cd ../../phpBB3
++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --dev --no-interaction; composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs; cd ../; fi"
++-
++-before_script:
++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
++-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/' --debug; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
++index f53bdc176..3cfb9450d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
++@@ -1,10 +1,6 @@
++-# phpBB 3.1 Extension - marttiphpbb Posting Template
+++### phpBB 3.1 PhpBB Extension - marttiphpbb Posting Template
++ 
++-[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951)
++-
++-For the phpBB 3.2+ version of this extension see the [Topic Template extension](https://github.com/marttiphpbb/phpbb-ext-topictemplate)
++-
++-## Quick Install
+++#### Quick Install
++ 
++ You can install this on the latest release of phpBB 3.1 by following the steps below:
++ 
++@@ -13,15 +9,17 @@ You can install this on the latest release of phpBB 3.1 by following the steps b
++ * Enable `Posting Template` in the ACP at `Customise -> Manage extensions`.
++ * You can start editing the Posting Template in the Forum ACP for each Forum.
++ 
++-## Uninstall
+++#### Uninstall
++ 
++ * Disable `Posting Template` in the ACP at `Customise -> Extension Management -> Extensions`.
++ * To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/postingtemplate` directory.
++ 
++-## Support
+++#### Support
++ 
++-* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-postingtemplate/issues).
+++* **Important: Only official release versions validated by the phpBB Extensions Team should be installed on a live forum. Pre-release (beta, RC) versions downloaded from this repository are only to be used for testing on offline/development forums and are not officially supported.**
+++* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/postingtemplate/issues).
+++* Support requests should be posted and discussed in the [Posting Template topic at phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951).
++ 
++-## License
+++### License
++ 
++ [GPL-2.0](license.txt)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
++index d32193276..454bba89b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
++@@ -1,32 +1,34 @@
++ {
++-	"name": "marttiphpbb/postingtemplate",
++-	"type": "phpbb-extension",
++-	"description": "Posting Template Extension for phpBB 3.1",
++-	"homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
++-	"version": "1.0.0",
++-	"time": "2018-07-01",
++-	"license": "GPL-2.0",
++-	"authors": [{
++-			"name": "martti",
++-			"email": "info@martti.be",
++-			"homepage": "https://github.com/marttiphpbb/",
++-			"role": "Developer"
++-		}],
++-	"require": {
++-		"php": ">=5.3.3"
++-	},
++-	"require-dev": {
++-		"phpbb/epv": "dev-master"
++-	},
++-	"extra": {
++-		"display-name": "Posting Template",
++-		"soft-require": {
++-			"phpbb/phpbb": ">=3.2,<3.3"
++-		},
++-		"version-check": {
++-			"host": "marttiphpbb.github.io",
++-			"directory": "/version",
++-			"filename": "postingtemplate.json"
++-		}
++-	}
++-}
+++    "name": "marttiphpbb/postingtemplate",
+++    "type": "phpbb-extension",
+++    "description": "Posting Template Extension for phpBB 3.1",
+++    "homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
+++    "version": "1.0.0",
+++    "time": "2015-12-30",
+++    "license": "GPL-2.0",
+++    "authors": [
+++        {
+++            "name": "martti",
+++            "email": "info@martti.be",
+++            "homepage": "https://github.com/marttiphpbb/",
+++            "role": "Developer"
+++        }
+++    ],
+++    "require": {
+++        "php": ">=5.3.3"
+++    },
+++    "require-dev": {
+++        "phpbb/epv": "dev-master"
+++    },
+++    "extra": {
+++        "display-name": "Posting Template",
+++        "soft-require": {
+++            "phpbb/phpbb": ">=3.1.0-RC2,<3.2.*@dev"
+++        },
+++        "version-check": {
+++            "host": "www.phpbb.com",
+++            "directory": "/customise/db/extension/posting_template_4",
+++            "filename": "version_check"
+++        }
+++    }
+++}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
++deleted file mode 100644
++index 5f1821f6e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
+++++ /dev/null
++@@ -1,409 +0,0 @@
++-{
++-    "_readme": [
++-        "This file locks the dependencies of your project to a known state",
++-        "Read more about it at http://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
++-        "This file is @generated automatically"
++-    ],
++-    "hash": "b015e820f6b051bbb2f2b52c09c47749",
++-    "packages": [],
++-    "packages-dev": [
++-        {
++-            "name": "gitonomy/gitlib",
++-            "version": "v0.1.7",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/gitonomy/gitlib.git",
++-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/gitonomy/gitlib/zipball/7a46107cfb8552b312101e0d5906e95d54d7ddc6",
++-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "symfony/process": "~2.4"
++-            },
++-            "require-dev": {
++-                "psr/log": "~1"
++-            },
++-            "suggest": {
++-                "psr/log": "Add some log"
++-            },
++-            "type": "library",
++-            "autoload": {
++-                "psr-0": {
++-                    "Gitonomy\\Git": [
++-                        "src/",
++-                        "tests/"
++-                    ]
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Alexandre Salomé",
++-                    "email": "alexandre.salome@gmail.com",
++-                    "homepage": "http://alexandre-salome.fr"
++-                },
++-                {
++-                    "name": "Julien DIDIER",
++-                    "email": "genzo.wm@gmail.com",
++-                    "homepage": "http://www.jdidier.net"
++-                }
++-            ],
++-            "description": "Library for accessing git",
++-            "homepage": "http://gitonomy.com",
++-            "time": "2015-07-13 19:02:31"
++-        },
++-        {
++-            "name": "nikic/php-parser",
++-            "version": "v0.9.5",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/nikic/PHP-Parser.git",
++-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/nikic/PHP-Parser/zipball/ef70767475434bdb3615b43c327e2cae17ef12eb",
++-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "ext-tokenizer": "*",
++-                "php": ">=5.2"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "0.9-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "PHPParser": "lib/"
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "BSD-3-Clause"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Nikita Popov"
++-                }
++-            ],
++-            "description": "A PHP parser written in PHP",
++-            "keywords": [
++-                "parser",
++-                "php"
++-            ],
++-            "time": "2015-07-23 18:24:17"
++-        },
++-        {
++-            "name": "phpbb/epv",
++-            "version": "dev-master",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/phpbb/epv.git",
++-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/phpbb/epv/zipball/07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
++-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "gitonomy/gitlib": "0.1.*@dev",
++-                "nikic/php-parser": "0.9.*@dev",
++-                "php": ">=5.3.3",
++-                "sensiolabs/ansi-to-html": "~1.1",
++-                "symfony/console": ">=2.3.0",
++-                "symfony/finder": ">=2.3.0",
++-                "symfony/yaml": ">=2.3.0|>=2.4.0|>=2.5.0"
++-            },
++-            "require-dev": {
++-                "phpunit/phpunit": "4.0.*"
++-            },
++-            "bin": [
++-                "src/EPV.php"
++-            ],
++-            "type": "library",
++-            "autoload": {
++-                "psr-4": {
++-                    "Phpbb\\Epv\\": "src/"
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "GPL-2.0"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Paul Sohier",
++-                    "email": "paul@phpbb.com"
++-                }
++-            ],
++-            "description": "A extension validator for phpBB extensions. Extensions are required to pass the validator when submitted to the extension database.",
++-            "time": "2015-12-13 10:15:27"
++-        },
++-        {
++-            "name": "sensiolabs/ansi-to-html",
++-            "version": "v1.1.0",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/sensiolabs/ansi-to-html.git",
++-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/sensiolabs/ansi-to-html/zipball/92d2ef7ffba5418be060d8ba8adaf7223d741f93",
++-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.0"
++-            },
++-            "suggest": {
++-                "twig/twig": "Provides nice templating features"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "1.1-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "SensioLabs\\AnsiConverter": "."
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "A library to convert a text with ANSI codes to HTML",
++-            "time": "2015-08-01 14:02:39"
++-        },
++-        {
++-            "name": "symfony/console",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Console",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Console.git",
++-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Console/zipball/ef825fd9f809d275926547c9e57cbf14968793e8",
++-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "require-dev": {
++-                "psr/log": "~1.0",
++-                "symfony/event-dispatcher": "~2.1",
++-                "symfony/process": "~2.1"
++-            },
++-            "suggest": {
++-                "psr/log": "For using the console logger",
++-                "symfony/event-dispatcher": "",
++-                "symfony/process": ""
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Console\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Console Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        },
++-        {
++-            "name": "symfony/finder",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Finder",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Finder.git",
++-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Finder/zipball/0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
++-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Finder\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Finder Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        },
++-        {
++-            "name": "symfony/process",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Process",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Process.git",
++-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Process/zipball/bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
++-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Process\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Process Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        },
++-        {
++-            "name": "symfony/yaml",
++-            "version": "v2.6.1",
++-            "target-dir": "Symfony/Component/Yaml",
++-            "source": {
++-                "type": "git",
++-                "url": "https://github.com/symfony/Yaml.git",
++-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20"
++-            },
++-            "dist": {
++-                "type": "zip",
++-                "url": "https://api.github.com/repos/symfony/Yaml/zipball/3346fc090a3eb6b53d408db2903b241af51dcb20",
++-                "reference": "3346fc090a3eb6b53d408db2903b241af51dcb20",
++-                "shasum": ""
++-            },
++-            "require": {
++-                "php": ">=5.3.3"
++-            },
++-            "type": "library",
++-            "extra": {
++-                "branch-alias": {
++-                    "dev-master": "2.6-dev"
++-                }
++-            },
++-            "autoload": {
++-                "psr-0": {
++-                    "Symfony\\Component\\Yaml\\": ""
++-                }
++-            },
++-            "notification-url": "https://packagist.org/downloads/",
++-            "license": [
++-                "MIT"
++-            ],
++-            "authors": [
++-                {
++-                    "name": "Symfony Community",
++-                    "homepage": "http://symfony.com/contributors"
++-                },
++-                {
++-                    "name": "Fabien Potencier",
++-                    "email": "fabien@symfony.com"
++-                }
++-            ],
++-            "description": "Symfony Yaml Component",
++-            "homepage": "http://symfony.com",
++-            "time": "2015-12-02 20:19:20"
++-        }
++-    ],
++-    "aliases": [],
++-    "minimum-stability": "stable",
++-    "stability-flags": {
++-        "phpbb/epv": 20
++-    },
++-    "prefer-stable": false,
++-    "prefer-lowest": false,
++-    "platform": {
++-        "php": ">=5.3.3"
++-    },
++-    "platform-dev": []
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/config/services.yml"
++index e1cceaa4e..00ec4485c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/config/services.yml"
++@@ -2,11 +2,11 @@ services:
++     marttiphpbb.postingtemplate.listener:
++         class: marttiphpbb\postingtemplate\event\listener
++         arguments:
++-            - @config_text
++-            - @dbal.conn
++-            - @request
++-            - @user
++-            - %tables.config_text%
++-            - %tables.forums%
+++            - '@config_text'
+++            - '@dbal.conn'
+++            - '@request'
+++            - '@user'
+++            - '%tables.config_text%'
+++            - '%tables.forums%'
++         tags:
++             - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp"
++new file mode 100644
++index 000000000..e4d72354e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/diff_full.tmp"
++@@ -0,0 +1,544 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
+++deleted file mode 100644
+++index 914ac394f..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.gitignore"
++++++ /dev/null
+++@@ -1,3 +0,0 @@
+++-composer.phar
+++-/vendor/*
+++-.dist
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
+++deleted file mode 100644
+++index 6a26819dd..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/.travis.yml"
++++++ /dev/null
+++@@ -1,59 +0,0 @@
+++-sudo: required
+++-dist: precise
+++-
+++-language: php
+++-
+++-matrix:
+++-  include:
+++-    - php: 7.0
+++-      env: DB=mysql
+++-    - php: 7.0
+++-      env: DB=mariadb
+++-    - php: 7.0
+++-      env: DB=postgres
+++-    - php: 7.0
+++-      env: DB=sqlite3
+++-    - php: 7.0
+++-      env: DB=mysqli
+++-    - php: 7.1
+++-      env: DB=mysqli
+++-    - php: 7.2
+++-      env: DB=mysqli
+++-    - php: hhvm
+++-      env: DB=mysqli
+++-    - php: nightly
+++-      env: DB=mysqli
+++-  allow_failures:
+++-    - php: hhvm
+++-    - php: nightly
+++-  fast_finish: true
+++-
+++-env:
+++-  global:
+++-    - EXTNAME="marttiphpbb/postingtemplate"  # CHANGE name of the extension HERE
+++-    - SNIFF="1"            # Should we run code sniffer on your code?
+++-    - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+++-    - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+++-    - PHPBB_BRANCH="3.2.x"
+++-
+++-branches:
+++-  only:
+++-    - master
+++-    - develop
+++-    - /^develop-.*$/
+++-
+++-install:
+++-  - sh -c "mkdir --parents ../../tmp/travis; cp -R . ../../tmp; cd ../../; git clone --depth=1 \"git://github.com/phpbb/phpbb.git\" \"phpBB3\" --branch=$PHPBB_BRANCH"
+++-  - cd ../../phpBB3
+++-  - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+++-  - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+++-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then cd phpBB; composer remove sami/sami --update-with-dependencies --dev --no-interaction; composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs; cd ../; fi"
+++-
+++-before_script:
+++-  - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+++-
+++-script:
+++-  - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+++-  - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+++-  - phpBB/vendor/bin/phpunit --configuration phpBB/ext/$EXTNAME/travis/phpunit-$DB-travis.xml --bootstrap ./tests/bootstrap.php
+++-  - sh -c "if [ '$EPV' != '0' -a '$TRAVIS_PHP_VERSION' = '5.5' -a '$DB' = 'mysqli' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/' --debug; fi"
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
+++index f53bdc176..3cfb9450d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/README.md"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/README.md"
+++@@ -1,10 +1,6 @@
+++-# phpBB 3.1 Extension - marttiphpbb Posting Template
++++### phpBB 3.1 PhpBB Extension - marttiphpbb Posting Template
+++ 
+++-[Topic on phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951)
+++-
+++-For the phpBB 3.2+ version of this extension see the [Topic Template extension](https://github.com/marttiphpbb/phpbb-ext-topictemplate)
+++-
+++-## Quick Install
++++#### Quick Install
+++ 
+++ You can install this on the latest release of phpBB 3.1 by following the steps below:
+++ 
+++@@ -13,15 +9,17 @@ You can install this on the latest release of phpBB 3.1 by following the steps b
+++ * Enable `Posting Template` in the ACP at `Customise -> Manage extensions`.
+++ * You can start editing the Posting Template in the Forum ACP for each Forum.
+++ 
+++-## Uninstall
++++#### Uninstall
+++ 
+++ * Disable `Posting Template` in the ACP at `Customise -> Extension Management -> Extensions`.
+++ * To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/postingtemplate` directory.
+++ 
+++-## Support
++++#### Support
+++ 
+++-* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-postingtemplate/issues).
++++* **Important: Only official release versions validated by the phpBB Extensions Team should be installed on a live forum. Pre-release (beta, RC) versions downloaded from this repository are only to be used for testing on offline/development forums and are not officially supported.**
++++* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/postingtemplate/issues).
++++* Support requests should be posted and discussed in the [Posting Template topic at phpBB.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2284951).
+++ 
+++-## License
++++### License
+++ 
+++ [GPL-2.0](license.txt)
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
+++index d32193276..454bba89b 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/composer.json"
+++@@ -1,32 +1,34 @@
+++ {
+++-	"name": "marttiphpbb/postingtemplate",
+++-	"type": "phpbb-extension",
+++-	"description": "Posting Template Extension for phpBB 3.1",
+++-	"homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
+++-	"version": "1.0.0",
+++-	"time": "2018-07-01",
+++-	"license": "GPL-2.0",
+++-	"authors": [{
+++-			"name": "martti",
+++-			"email": "info@martti.be",
+++-			"homepage": "https://github.com/marttiphpbb/",
+++-			"role": "Developer"
+++-		}],
+++-	"require": {
+++-		"php": ">=5.3.3"
+++-	},
+++-	"require-dev": {
+++-		"phpbb/epv": "dev-master"
+++-	},
+++-	"extra": {
+++-		"display-name": "Posting Template",
+++-		"soft-require": {
+++-			"phpbb/phpbb": ">=3.2,<3.3"
+++-		},
+++-		"version-check": {
+++-			"host": "marttiphpbb.github.io",
+++-			"directory": "/version",
+++-			"filename": "postingtemplate.json"
+++-		}
+++-	}
+++-}
++++    "name": "marttiphpbb/postingtemplate",
++++    "type": "phpbb-extension",
++++    "description": "Posting Template Extension for phpBB 3.1",
++++    "homepage": "https://github.com/marttiphpbb/phpbb-ext-postingtemplate",
++++    "version": "1.0.0",
++++    "time": "2015-12-30",
++++    "license": "GPL-2.0",
++++    "authors": [
++++        {
++++            "name": "martti",
++++            "email": "info@martti.be",
++++            "homepage": "https://github.com/marttiphpbb/",
++++            "role": "Developer"
++++        }
++++    ],
++++    "require": {
++++        "php": ">=5.3.3"
++++    },
++++    "require-dev": {
++++        "phpbb/epv": "dev-master"
++++    },
++++    "extra": {
++++        "display-name": "Posting Template",
++++        "soft-require": {
++++            "phpbb/phpbb": ">=3.1.0-RC2,<3.2.*@dev"
++++        },
++++        "version-check": {
++++            "host": "www.phpbb.com",
++++            "directory": "/customise/db/extension/posting_template_4",
++++            "filename": "version_check"
++++        }
++++    }
++++}
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
+++deleted file mode 100644
+++index 5f1821f6e..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/composer.lock"
++++++ /dev/null
+++@@ -1,409 +0,0 @@
+++-{
+++-    "_readme": [
+++-        "This file locks the dependencies of your project to a known state",
+++-        "Read more about it at http://getcomposer.org/doc/01-basic-usage.md#composer-lock-the-lock-file",
+++-        "This file is @generated automatically"
+++-    ],
+++-    "hash": "b015e820f6b051bbb2f2b52c09c47749",
+++-    "packages": [],
+++-    "packages-dev": [
+++-        {
+++-            "name": "gitonomy/gitlib",
+++-            "version": "v0.1.7",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/gitonomy/gitlib.git",
+++-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/gitonomy/gitlib/zipball/7a46107cfb8552b312101e0d5906e95d54d7ddc6",
+++-                "reference": "7a46107cfb8552b312101e0d5906e95d54d7ddc6",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "symfony/process": "~2.4"
+++-            },
+++-            "require-dev": {
+++-                "psr/log": "~1"
+++-            },
+++-            "suggest": {
+++-                "psr/log": "Add some log"
+++-            },
+++-            "type": "library",
+++-            "autoload": {
+++-                "psr-0": {
+++-                    "Gitonomy\\Git": [
+++-                        "src/",
+++-                        "tests/"
+++-                    ]
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "MIT"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Alexandre Salomé",
+++-                    "email": "alexandre.salome@gmail.com",
+++-                    "homepage": "http://alexandre-salome.fr"
+++-                },
+++-                {
+++-                    "name": "Julien DIDIER",
+++-                    "email": "genzo.wm@gmail.com",
+++-                    "homepage": "http://www.jdidier.net"
+++-                }
+++-            ],
+++-            "description": "Library for accessing git",
+++-            "homepage": "http://gitonomy.com",
+++-            "time": "2015-07-13 19:02:31"
+++-        },
+++-        {
+++-            "name": "nikic/php-parser",
+++-            "version": "v0.9.5",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/nikic/PHP-Parser.git",
+++-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/nikic/PHP-Parser/zipball/ef70767475434bdb3615b43c327e2cae17ef12eb",
+++-                "reference": "ef70767475434bdb3615b43c327e2cae17ef12eb",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "ext-tokenizer": "*",
+++-                "php": ">=5.2"
+++-            },
+++-            "type": "library",
+++-            "extra": {
+++-                "branch-alias": {
+++-                    "dev-master": "0.9-dev"
+++-                }
+++-            },
+++-            "autoload": {
+++-                "psr-0": {
+++-                    "PHPParser": "lib/"
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "BSD-3-Clause"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Nikita Popov"
+++-                }
+++-            ],
+++-            "description": "A PHP parser written in PHP",
+++-            "keywords": [
+++-                "parser",
+++-                "php"
+++-            ],
+++-            "time": "2015-07-23 18:24:17"
+++-        },
+++-        {
+++-            "name": "phpbb/epv",
+++-            "version": "dev-master",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/phpbb/epv.git",
+++-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/phpbb/epv/zipball/07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
+++-                "reference": "07e017ea9d92581d5b83066469eb33b4b2a8f6ed",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "gitonomy/gitlib": "0.1.*@dev",
+++-                "nikic/php-parser": "0.9.*@dev",
+++-                "php": ">=5.3.3",
+++-                "sensiolabs/ansi-to-html": "~1.1",
+++-                "symfony/console": ">=2.3.0",
+++-                "symfony/finder": ">=2.3.0",
+++-                "symfony/yaml": ">=2.3.0|>=2.4.0|>=2.5.0"
+++-            },
+++-            "require-dev": {
+++-                "phpunit/phpunit": "4.0.*"
+++-            },
+++-            "bin": [
+++-                "src/EPV.php"
+++-            ],
+++-            "type": "library",
+++-            "autoload": {
+++-                "psr-4": {
+++-                    "Phpbb\\Epv\\": "src/"
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "GPL-2.0"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Paul Sohier",
+++-                    "email": "paul@phpbb.com"
+++-                }
+++-            ],
+++-            "description": "A extension validator for phpBB extensions. Extensions are required to pass the validator when submitted to the extension database.",
+++-            "time": "2015-12-13 10:15:27"
+++-        },
+++-        {
+++-            "name": "sensiolabs/ansi-to-html",
+++-            "version": "v1.1.0",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/sensiolabs/ansi-to-html.git",
+++-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/sensiolabs/ansi-to-html/zipball/92d2ef7ffba5418be060d8ba8adaf7223d741f93",
+++-                "reference": "92d2ef7ffba5418be060d8ba8adaf7223d741f93",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "php": ">=5.3.0"
+++-            },
+++-            "suggest": {
+++-                "twig/twig": "Provides nice templating features"
+++-            },
+++-            "type": "library",
+++-            "extra": {
+++-                "branch-alias": {
+++-                    "dev-master": "1.1-dev"
+++-                }
+++-            },
+++-            "autoload": {
+++-                "psr-0": {
+++-                    "SensioLabs\\AnsiConverter": "."
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "MIT"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Fabien Potencier",
+++-                    "email": "fabien@symfony.com"
+++-                }
+++-            ],
+++-            "description": "A library to convert a text with ANSI codes to HTML",
+++-            "time": "2015-08-01 14:02:39"
+++-        },
+++-        {
+++-            "name": "symfony/console",
+++-            "version": "v2.6.1",
+++-            "target-dir": "Symfony/Component/Console",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/symfony/Console.git",
+++-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/symfony/Console/zipball/ef825fd9f809d275926547c9e57cbf14968793e8",
+++-                "reference": "ef825fd9f809d275926547c9e57cbf14968793e8",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "php": ">=5.3.3"
+++-            },
+++-            "require-dev": {
+++-                "psr/log": "~1.0",
+++-                "symfony/event-dispatcher": "~2.1",
+++-                "symfony/process": "~2.1"
+++-            },
+++-            "suggest": {
+++-                "psr/log": "For using the console logger",
+++-                "symfony/event-dispatcher": "",
+++-                "symfony/process": ""
+++-            },
+++-            "type": "library",
+++-            "extra": {
+++-                "branch-alias": {
+++-                    "dev-master": "2.6-dev"
+++-                }
+++-            },
+++-            "autoload": {
+++-                "psr-0": {
+++-                    "Symfony\\Component\\Console\\": ""
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "MIT"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Symfony Community",
+++-                    "homepage": "http://symfony.com/contributors"
+++-                },
+++-                {
+++-                    "name": "Fabien Potencier",
+++-                    "email": "fabien@symfony.com"
+++-                }
+++-            ],
+++-            "description": "Symfony Console Component",
+++-            "homepage": "http://symfony.com",
+++-            "time": "2015-12-02 20:19:20"
+++-        },
+++-        {
+++-            "name": "symfony/finder",
+++-            "version": "v2.6.1",
+++-            "target-dir": "Symfony/Component/Finder",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/symfony/Finder.git",
+++-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/symfony/Finder/zipball/0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
+++-                "reference": "0d3ef7f6ec55a7af5eca7914eaa0dacc04ccc721",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "php": ">=5.3.3"
+++-            },
+++-            "type": "library",
+++-            "extra": {
+++-                "branch-alias": {
+++-                    "dev-master": "2.6-dev"
+++-                }
+++-            },
+++-            "autoload": {
+++-                "psr-0": {
+++-                    "Symfony\\Component\\Finder\\": ""
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "MIT"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Symfony Community",
+++-                    "homepage": "http://symfony.com/contributors"
+++-                },
+++-                {
+++-                    "name": "Fabien Potencier",
+++-                    "email": "fabien@symfony.com"
+++-                }
+++-            ],
+++-            "description": "Symfony Finder Component",
+++-            "homepage": "http://symfony.com",
+++-            "time": "2015-12-02 20:19:20"
+++-        },
+++-        {
+++-            "name": "symfony/process",
+++-            "version": "v2.6.1",
+++-            "target-dir": "Symfony/Component/Process",
+++-            "source": {
+++-                "type": "git",
+++-                "url": "https://github.com/symfony/Process.git",
+++-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a"
+++-            },
+++-            "dist": {
+++-                "type": "zip",
+++-                "url": "https://api.github.com/repos/symfony/Process/zipball/bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
+++-                "reference": "bf0c9bd625f13b0b0bbe39919225cf145dfb935a",
+++-                "shasum": ""
+++-            },
+++-            "require": {
+++-                "php": ">=5.3.3"
+++-            },
+++-            "type": "library",
+++-            "extra": {
+++-                "branch-alias": {
+++-                    "dev-master": "2.6-dev"
+++-                }
+++-            },
+++-            "autoload": {
+++-                "psr-0": {
+++-                    "Symfony\\Component\\Process\\": ""
+++-                }
+++-            },
+++-            "notification-url": "https://packagist.org/downloads/",
+++-            "license": [
+++-                "MIT"
+++-            ],
+++-            "authors": [
+++-                {
+++-                    "name": "Symfony Community",
+++-                    "homepage": "http://symfony.com/contributors"
+++-                },
+++-                {
+++-                    "name": "Fabien Potencier",
+++-                    "email": "fabien@symfony.com"
+++-                }
+++-            ],
+++-            "description": "Symfony Process Component",
+++-            "homepage": "http://symfony.com",
+++-            "time": "2015-12-02 20:19:20"
+++-        },
+++-        {
+++-            "name": "symfony/yaml",
+++-            "version": "v2.6.1",
+++-            "target-dir": "Symfony/Component/Yaml",
+++- 
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/event/listener.php"
++index 68e2d4c9a..3a76813d6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/event/listener.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++ * phpBB Extension - marttiphpbb posting template
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/ext.php"
++index eea4c0172..c37bd447d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/ext.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++ * phpBB Extension - marttiphpbb postingtemplate
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/ar/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/ar/acp.php"
++index eb1568736..bcd7190fa 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/ar/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/ar/acp.php"
++@@ -2,7 +2,7 @@
++ 
++ /**
++ * phpBB Extension - marttiphpbb posting template
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ * Translated By : Basil Taha Alhitary - www.alhitary.net
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/en/acp.php"
++index a72f64470..80c7b1c82 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/en/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/en/acp.php"
++@@ -2,7 +2,7 @@
++ 
++ /**
++ * phpBB Extension - marttiphpbb posting template
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/es/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/es/acp.php"
++index cb8a0b18d..79e1fd324 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/es/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/es/acp.php"
++@@ -2,7 +2,7 @@
++ 
++ /**
++ * phpBB Extension - marttiphpbb posting template
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/fr/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/fr/acp.php"
++deleted file mode 100644
++index 626c41fae..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/fr/acp.php"
+++++ /dev/null
++@@ -1,38 +0,0 @@
++-<?php
++-
++-/**
++-* phpBB Extension - marttiphpbb posting template
++-* French translation by Galixte (http://www.galixte.com)
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*/
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-
++-$lang = array_merge($lang, array(
++-	'ACP_POSTINGTEMPLATE'			=> 'Modèle de message',
++-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'Lors de la création d’un sujet, l’éditeur de texte sera pré-rempli selon le modèle de message. Laissez ce champ vide lorsque vous ne souhaitez pas l’utiliser.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/nl/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/nl/acp.php"
++index 6cc0bae23..11882ebf2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/nl/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/nl/acp.php"
++@@ -2,7 +2,7 @@
++ 
++ /**
++ * phpBB Extension - marttiphpbb 
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ * [Dutch] translated by Dutch Translators (https://github.com/dutch-translators)
++ */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/pt_br/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/pt_br/acp.php"
++deleted file mode 100644
++index 591feff41..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/pt_br/acp.php"
+++++ /dev/null
++@@ -1,38 +0,0 @@
++-<?php
++-
++-/**
++-* phpBB Extension - marttiphpbb posting template
++-* Brazilian Portuguese translation by eunaumtenhoid (c) 2018 [ver 1.0.0] (https://github.com/phpBBTraducoes) 
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*/
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-
++-$lang = array_merge($lang, array(
++-	'ACP_POSTINGTEMPLATE'			=> 'Posting template',
++-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'Ao iniciar um tópico, o editor de texto será pré-preenchido com este modelo de postagem. Deixe em branco quando você não desejar usar isso.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/sv/acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/sv/acp.php"
++deleted file mode 100644
++index fbf1b09fb..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/sv/acp.php"
+++++ /dev/null
++@@ -1,38 +0,0 @@
++-<?php
++-
++-/**
++-* phpBB Extension - marttiphpbb posting template
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
++-* Swedish translation by Holger (http://www.maskinisten.net)
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*/
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-
++-$lang = array_merge($lang, array(
++-	'ACP_POSTINGTEMPLATE'			=> 'Inläggsmall',
++-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'När ett nytt ämne skapas så kommer fältet för meddelande att innehålla dessa inläggsmallens text. Lämna tomt om du ej vill använda detta.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/tr/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/tr/acp.php"
++index 5a910eca5..8443768e6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/language/tr/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\marttiphpbb\\postingtemplate/language/tr/acp.php"
++@@ -2,7 +2,7 @@
++ 
++ /**
++ * phpBB Extension - marttiphpbb posting template
++-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+++* @copyright (c) 2015 marttiphpbb <info@martti.be>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/phpunit.xml.dist" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/phpunit.xml.dist"
++deleted file mode 100644
++index 289449d49..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\marttiphpbb\\postingtemplate/phpunit.xml.dist"
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
++-		<whitelist processUncoveredFilesFromWhitelist="true">
++-			<directory suffix=".php">./</directory>
++-			<exclude>
++-				<directory suffix=".php">./language/</directory>
++-				<directory suffix=".php">./migrations/</directory>
++-				<directory suffix=".php">./tests/</directory>
++-			</exclude>
++-		</whitelist>
++-	</filter>
++-</phpunit>
++diff --git "a/c:\\Users\\Lein
\ No newline at end of file
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/event/listener.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/event/listener.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/event/listener.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/event/listener.php"
@@ -1,7 +1,7 @@
 <?php
 /**
 * phpBB Extension - marttiphpbb posting template
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */
 
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/ext.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/ext.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/ext.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/ext.php"
@@ -1,7 +1,7 @@
 <?php
 /**
 * phpBB Extension - marttiphpbb postingtemplate
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */
 
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/ar/acp.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/ar/acp.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/ar/acp.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/ar/acp.php"
@@ -2,7 +2,7 @@
 
 /**
 * phpBB Extension - marttiphpbb posting template
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * Translated By : Basil Taha Alhitary - www.alhitary.net
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/en/acp.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/en/acp.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/en/acp.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/en/acp.php"
@@ -2,7 +2,7 @@
 
 /**
 * phpBB Extension - marttiphpbb posting template
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */
 
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/es/acp.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/es/acp.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/es/acp.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/es/acp.php"
@@ -2,7 +2,7 @@
 
 /**
 * phpBB Extension - marttiphpbb posting template
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */
 
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/fr/acp.php" "[ORIGINAL]/marttiphpbb\\postingtemplate/language/fr/acp.php"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/fr/acp.php"
+++ /dev/null
@@ -1,38 +0,0 @@
-<?php
-
-/**
-* phpBB Extension - marttiphpbb posting template
-* French translation by Galixte (http://www.galixte.com)
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*/
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-
-$lang = array_merge($lang, array(
-	'ACP_POSTINGTEMPLATE'			=> 'Modèle de message',
-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'Lors de la création d’un sujet, l’éditeur de texte sera pré-rempli selon le modèle de message. Laissez ce champ vide lorsque vous ne souhaitez pas l’utiliser.',
-));
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/nl/acp.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/nl/acp.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/nl/acp.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/nl/acp.php"
@@ -2,7 +2,7 @@
 
 /**
 * phpBB Extension - marttiphpbb 
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * [Dutch] translated by Dutch Translators (https://github.com/dutch-translators)
 */
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/pt_br/acp.php" "[ORIGINAL]/marttiphpbb\\postingtemplate/language/pt_br/acp.php"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/pt_br/acp.php"
+++ /dev/null
@@ -1,38 +0,0 @@
-<?php
-
-/**
-* phpBB Extension - marttiphpbb posting template
-* Brazilian Portuguese translation by eunaumtenhoid (c) 2018 [ver 1.0.0] (https://github.com/phpBBTraducoes) 
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*/
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-
-$lang = array_merge($lang, array(
-	'ACP_POSTINGTEMPLATE'			=> 'Posting template',
-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'Ao iniciar um tópico, o editor de texto será pré-preenchido com este modelo de postagem. Deixe em branco quando você não desejar usar isso.',
-));
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/sv/acp.php" "[ORIGINAL]/marttiphpbb\\postingtemplate/language/sv/acp.php"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/sv/acp.php"
+++ /dev/null
@@ -1,38 +0,0 @@
-<?php
-
-/**
-* phpBB Extension - marttiphpbb posting template
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
-* Swedish translation by Holger (http://www.maskinisten.net)
-* @license GNU General Public License, version 2 (GPL-2.0)
-*/
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-
-$lang = array_merge($lang, array(
-	'ACP_POSTINGTEMPLATE'			=> 'Inläggsmall',
-	'ACP_POSTINGTEMPLATE_EXPLAIN'	=> 'När ett nytt ämne skapas så kommer fältet för meddelande att innehålla dessa inläggsmallens text. Lämna tomt om du ej vill använda detta.',
-));
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/language/tr/acp.php" "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/tr/acp.php"
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/language/tr/acp.php"
+++ "[FORUM_EXT]/marttiphpbb\\postingtemplate/language/tr/acp.php"
@@ -2,7 +2,7 @@
 
 /**
 * phpBB Extension - marttiphpbb posting template
-* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
+* @copyright (c) 2015 marttiphpbb <info@martti.be>
 * @license GNU General Public License, version 2 (GPL-2.0)
 */
 
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/phpunit.xml.dist" "[ORIGINAL]/marttiphpbb\\postingtemplate/phpunit.xml.dist"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/phpunit.xml.dist"
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
diff --git "[ORIGINAL]/marttiphpbb\\postingtemplate/travis/prepare-phpbb.sh" "[ORIGINAL]/marttiphpbb\\postingtemplate/travis/prepare-phpbb.sh"
deleted file mode 100644
--- "[ORIGINAL]/marttiphpbb\\postingtemplate/travis/prepare-phpbb.sh"
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
