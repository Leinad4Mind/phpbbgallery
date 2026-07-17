Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/anavaro\\pmsearch/.travis.yml" "[ORIGINAL]/anavaro\\pmsearch/.travis.yml"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/.travis.yml"
+++ /dev/null
@@ -1,68 +0,0 @@
-language: php
-dist: xenial
-
-matrix:
-    include:
-        - php: 7.1
-          env: DB=none;NOTESTS=1
-        - php: 7.1
-          env: DB=mariadb
-        - php: 7.1
-          env: DB=postgres
-#        - php: 7.1
-#          env: DB=sqlite3
-        - php: 7.1
-          env: DB=mysqli # MyISAM
-        - php: 7.2
-          env: DB=mysqli;COVER=1
-        - php: 7.3
-          env: DB=mysqli
-        - php: 7.4snapshot
-          env: DB=mysqli
-        - php: nightly
-          env: DB=mysqli
-    allow_failures:
-        - php: nightly
-    fast_finish: true
-env:
-    global:
-        - EXTNAME="anavaro/pmsearch"  # CHANGE name of the extension HERE
-        - GITREPO="satanasov/pmsearch" # CHANGE name of the repository HERE
-        - SNIFF="1"            # Should we run code sniffer on your code?
-        - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
-        - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
-        - COVERAGE="1"     # Should we send code coverage?
-        - PHPBB_BRANCH="3.3.x"
-
-branches:
-    only:
-        - master
-        - develop
-        - /^develop-.*$/
-
-services:
-    - postgresql
-    - mysql
-    - memcached
-
-install:
-    - composer install --dev --no-interaction --prefer-source
-    - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
-    - cd ../../phpBB3
-    - sh -c "if [ '$COVER' != '0' ]; then sed -i '/phpenv/d' travis/setup-php-extensions.sh; fi"
-    - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
-    - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
-    - sh -c "if [ '$COVERAGE' != '0' ] && [ '$COVER' != '0' ]; then phpBB/ext/$EXTNAME/travis/prepare-covarage.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
-    - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/ext/$EXTNAME/travis/prepare-epv.sh $EPV $NOTESTS; fi"
-
-before_script:
-    - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
-
-script:
-    - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
-    - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
-    - sh -c "if [ '$DB' != 'none' ]; then phpBB/ext/$EXTNAME/travis/run-tests.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
-    - sh -c "if [ '$EPV' != '0' -a '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
-
-after_script:
-    - sh -c "if [ '$COVERAGE' != '0' ]; then phpBB/ext/$EXTNAME/travis/send-coverage.sh $DB $TRAVIS_PHP_VERSION $GITREPO; fi"
diff --git "[ORIGINAL]/anavaro\\pmsearch/README.md" "[ORIGINAL]/anavaro\\pmsearch/README.md"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/README.md"
+++ /dev/null
@@ -1,39 +0,0 @@
-PM Search
-===========
-
-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch) [![Code Coverage](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master)
-
-PM search is phpBB 3.2 extension that allows users to search trough the PM archive in the board.
-
-Features
---
-
-  ACP
-  
-    - Enable PM Indexing
-    - GLobaly allow PM search
-    - Individual user permissions to allow PM Search
-    - Indexing statistics
-    - Build/delete Indexing statistics
-  
-  UCP
-  
-    - New UCP module for search
-	
-  Events
-  
-    - Register every PM for indexing
-	- Remove PM removes index
-    
-    
-
-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch)
-
-
-##Donate
-If you like my code - buy me a beer/coffee/license for PhpStorm :D
-
-- BTC: 12afvCTp1dRrQdHaavzthZ1dNWMoi8eyc8
-- ETH: 0x363abc8edf41ac89906b20e90cf7fdc71fe78cd5
-
-[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XQ6USSXCSUM5W)
diff --git "[ORIGINAL]/anavaro\\pmsearch/acp/acp_pmsearch_module.php" "[FORUM_EXT]/anavaro\\pmsearch/acp/acp_pmsearch_module.php"
--- "[ORIGINAL]/anavaro\\pmsearch/acp/acp_pmsearch_module.php"
+++ "[FORUM_EXT]/anavaro\\pmsearch/acp/acp_pmsearch_module.php"
@@ -195,7 +195,7 @@ class acp_pmsearch_module
 
 					if ($this->search_helper->init_search($search_types[0], $search, $error) || !method_exists($search, 'index_created'))
 					{
-						break;
+						continue;
 					}
 
 					//Let's build normal
diff --git "[FORUM_EXT]/anavaro\\pmsearch/diff_full.tmp" "[FORUM_EXT]/anavaro\\pmsearch/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/diff_full.tmp"
@@ -0,0 +1,1527 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
+deleted file mode 100644
+index 8dc8afdd7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
++++ /dev/null
+@@ -1,68 +0,0 @@
+-language: php
+-dist: xenial
+-
+-matrix:
+-    include:
+-        - php: 7.1
+-          env: DB=none;NOTESTS=1
+-        - php: 7.1
+-          env: DB=mariadb
+-        - php: 7.1
+-          env: DB=postgres
+-#        - php: 7.1
+-#          env: DB=sqlite3
+-        - php: 7.1
+-          env: DB=mysqli # MyISAM
+-        - php: 7.2
+-          env: DB=mysqli;COVER=1
+-        - php: 7.3
+-          env: DB=mysqli
+-        - php: 7.4snapshot
+-          env: DB=mysqli
+-        - php: nightly
+-          env: DB=mysqli
+-    allow_failures:
+-        - php: nightly
+-    fast_finish: true
+-env:
+-    global:
+-        - EXTNAME="anavaro/pmsearch"  # CHANGE name of the extension HERE
+-        - GITREPO="satanasov/pmsearch" # CHANGE name of the repository HERE
+-        - SNIFF="1"            # Should we run code sniffer on your code?
+-        - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-        - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-        - COVERAGE="1"     # Should we send code coverage?
+-        - PHPBB_BRANCH="3.3.x"
+-
+-branches:
+-    only:
+-        - master
+-        - develop
+-        - /^develop-.*$/
+-
+-services:
+-    - postgresql
+-    - mysql
+-    - memcached
+-
+-install:
+-    - composer install --dev --no-interaction --prefer-source
+-    - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-    - cd ../../phpBB3
+-    - sh -c "if [ '$COVER' != '0' ]; then sed -i '/phpenv/d' travis/setup-php-extensions.sh; fi"
+-    - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-    - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-    - sh -c "if [ '$COVERAGE' != '0' ] && [ '$COVER' != '0' ]; then phpBB/ext/$EXTNAME/travis/prepare-covarage.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-    - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/ext/$EXTNAME/travis/prepare-epv.sh $EPV $NOTESTS; fi"
+-
+-before_script:
+-    - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-    - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-    - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-    - sh -c "if [ '$DB' != 'none' ]; then phpBB/ext/$EXTNAME/travis/run-tests.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-    - sh -c "if [ '$EPV' != '0' -a '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+-
+-after_script:
+-    - sh -c "if [ '$COVERAGE' != '0' ]; then phpBB/ext/$EXTNAME/travis/send-coverage.sh $DB $TRAVIS_PHP_VERSION $GITREPO; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
+deleted file mode 100644
+index 52b32b105..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
++++ /dev/null
+@@ -1,39 +0,0 @@
+-PM Search
+-===========
+-
+-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch) [![Code Coverage](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master)
+-
+-PM search is phpBB 3.2 extension that allows users to search trough the PM archive in the board.
+-
+-Features
+---
+-
+-  ACP
+-  
+-    - Enable PM Indexing
+-    - GLobaly allow PM search
+-    - Individual user permissions to allow PM Search
+-    - Indexing statistics
+-    - Build/delete Indexing statistics
+-  
+-  UCP
+-  
+-    - New UCP module for search
+-	
+-  Events
+-  
+-    - Register every PM for indexing
+-	- Remove PM removes index
+-    
+-    
+-
+-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch)
+-
+-
+-##Donate
+-If you like my code - buy me a beer/coffee/license for PhpStorm :D
+-
+-- BTC: 12afvCTp1dRrQdHaavzthZ1dNWMoi8eyc8
+-- ETH: 0x363abc8edf41ac89906b20e90cf7fdc71fe78cd5
+-
+-[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XQ6USSXCSUM5W)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
+index 2d118856c..61348e4a5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
+@@ -195,7 +195,7 @@ class acp_pmsearch_module
+ 
+ 					if ($this->search_helper->init_search($search_types[0], $search, $error) || !method_exists($search, 'index_created'))
+ 					{
+-						break;
++						continue;
+ 					}
+ 
+ 					//Let's build normal
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp"
+new file mode 100644
+index 000000000..96dfe78b7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp"
+@@ -0,0 +1,97 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
++deleted file mode 100644
++index 8dc8afdd7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
+++++ /dev/null
++@@ -1,68 +0,0 @@
++-language: php
++-dist: xenial
++-
++-matrix:
++-    include:
++-        - php: 7.1
++-          env: DB=none;NOTESTS=1
++-        - php: 7.1
++-          env: DB=mariadb
++-        - php: 7.1
++-          env: DB=postgres
++-#        - php: 7.1
++-#          env: DB=sqlite3
++-        - php: 7.1
++-          env: DB=mysqli # MyISAM
++-        - php: 7.2
++-          env: DB=mysqli;COVER=1
++-        - php: 7.3
++-          env: DB=mysqli
++-        - php: 7.4snapshot
++-          env: DB=mysqli
++-        - php: nightly
++-          env: DB=mysqli
++-    allow_failures:
++-        - php: nightly
++-    fast_finish: true
++-env:
++-    global:
++-        - EXTNAME="anavaro/pmsearch"  # CHANGE name of the extension HERE
++-        - GITREPO="satanasov/pmsearch" # CHANGE name of the repository HERE
++-        - SNIFF="1"            # Should we run code sniffer on your code?
++-        - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-        - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-        - COVERAGE="1"     # Should we send code coverage?
++-        - PHPBB_BRANCH="3.3.x"
++-
++-branches:
++-    only:
++-        - master
++-        - develop
++-        - /^develop-.*$/
++-
++-services:
++-    - postgresql
++-    - mysql
++-    - memcached
++-
++-install:
++-    - composer install --dev --no-interaction --prefer-source
++-    - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-    - cd ../../phpBB3
++-    - sh -c "if [ '$COVER' != '0' ]; then sed -i '/phpenv/d' travis/setup-php-extensions.sh; fi"
++-    - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-    - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-    - sh -c "if [ '$COVERAGE' != '0' ] && [ '$COVER' != '0' ]; then phpBB/ext/$EXTNAME/travis/prepare-covarage.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-    - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/ext/$EXTNAME/travis/prepare-epv.sh $EPV $NOTESTS; fi"
++-
++-before_script:
++-    - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-    - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-    - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-    - sh -c "if [ '$DB' != 'none' ]; then phpBB/ext/$EXTNAME/travis/run-tests.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-    - sh -c "if [ '$EPV' != '0' -a '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++-
++-after_script:
++-    - sh -c "if [ '$COVERAGE' != '0' ]; then phpBB/ext/$EXTNAME/travis/send-coverage.sh $DB $TRAVIS_PHP_VERSION $GITREPO; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
++deleted file mode 100644
++index 52b32b105..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
+++++ /dev/null
++@@ -1,39 +0,0 @@
++-PM Search
++-===========
++-
++-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch) [![Code Coverage](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master)
++-
++-PM search is phpBB 3.2 extension that allows users to search trough the PM archive in the board.
++-
++-Features
++---
++-
++-  ACP
++-  
++-    - Enable PM Indexing
++-    - GLobaly allow PM search
++-    - Individual user permissions to allow PM Search
++-    - Indexing statistics
++-    - Build/delete Indexing sta
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/event/main_listener.php"
+index 5961a8b96..792a65da8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/event/main_listener.php"
+@@ -20,10 +20,10 @@ class main_listener implements EventSubscriberInterface
+ 	static public function getSubscribedEvents()
+ 	{
+ 		return array(
+-			'core.permissions'	       => 'acl_perms_add',
+-			'core.submit_pm_after'	       => 'pm_search_main',
+-			'core.delete_pm_before'	=> 'pm_delete_index',
+-			'core.memberlist_view_profile'	       => 'pm_search_with_user',
++			'core.permissions'				=> 'acl_perms_add',
++			'core.submit_pm_after'			=> 'pm_search_main',
++			'core.delete_pm_before'			=> 'pm_delete_index',
++			'core.memberlist_view_profile'	=> 'pm_search_with_user',
+ 		);
+ 	}
+ 
+@@ -133,7 +133,7 @@ class main_listener implements EventSubscriberInterface
+ 	public function pm_search_with_user($event)
+ 	{
+ 		$target = $event['member']['user_id'];
+-		$url = generate_board_url() . '/ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search&terms=nick&keywords=' . $target;
++		$url = generate_board_url() . '/ucp.php?i=-anavaro-pmsearch-ucp-ucp_pmsearch_module&mode=search&terms=nick&keywords=' . $target;
+ 		$this->template->assign_vars(array(
+ 			'S_SEARCH_WITH_USER'	=> true,
+ 			'U_SEARCH_WITH_USER'	=> $url
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_acp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_acp_pmsearch.php"
+new file mode 100644
+index 000000000..ee3642dfa
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_acp_pmsearch.php"
+@@ -0,0 +1,70 @@
++<?php
++/**
++*
++* PM Search extension for the phpBB Forum Software package.
++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
++*
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
++	// ACP general langauge
++	'ACP_PMSEARCH_GRP'	=> 'Pesquisa em MPs',
++	'ACP_PRVOPT'	=> 'Configurações',
++
++	//ACP PM Admin Settings page
++	'PMSEARCH_ADMIN'	=> 'Pesquisa em MPs',
++	'PMSEARCH_ADMIN_EXPLAIN'	=> 'A partir daqui, podes definir algumas das opções relacionadas à pesquisa de utilizadores em MPs.',
++	'PMSEARCH_SETTINGS'	=> 'Opções',
++	'PMSEARCH_PM_INDEX'	=> 'Índice de MP',
++	'PMSEARCH_PM_INDEX_EXPLAIN'	=> 'A partir daqui, podes permitir a indexação<br /><b>(Aviso! A pesquisa não funcionará se não tiveres indexação)</b>.',
++	'PMSEARCH_PM_SEARCH'	=>	'Permitir pesquisa',
++	'PMSEARCH_PM_SEARCH_EXPLAIN'	=> 'Permitir globalmente (ou negar) pesquisa em MPs.',
++	'DELETE_INDEX'	=> 'Apagar índices',
++	'CREATE_INDEX'	=> 'Criar índices',
++
++	//ACP ACL
++	'ACL_U_PMSEARCH'	=> 'O utilizador pode pesquisar em MPs',
++
++	//Other ACP
++	'LOG_PMSEARCH_INDEX_REMOVED'	=> '<strong>Índice de pesquisa removido por </strong><br />» %s',
++	'LOG_PMSEARCH_INDEX_CREATED'	=> '<strong>Índice de pesquisa criado por </strong><br />» %s',
++	'TOTAL_WORDS'							=> 'Total de palavras indexadas',
++	'TOTAL_MATCHES'							=> 'Contagem total de relações de palavras',
++	'SEARCH_INDEX_CREATE_REDIRECT'			=> array(
++		2	=> 'Todas as mensagens até à mensagem com id %2$d foram indexadas, das quais %1$d mensagens estavam dentro desta etapa.<br />',
++	),
++	'SEARCH_INDEX_CREATE_REDIRECT_RATE'		=> array(
++		2	=> 'A taxa atual de indexação é aproximadamente %1$.1f mensagens por segundo.<br />Indexação em andamento...',
++	),
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php"
+new file mode 100644
+index 000000000..ff0109826
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php"
+@@ -0,0 +1,53 @@
++<?php
++/**
++*
++* PM Search extension for the phpBB Forum Software package.
++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
++*
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
++	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
++	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
++	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
++	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
++	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
++	'SEARCH_PMS'	=> 'Pesquisar MPs',
++	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',
++
++	// Added in version 1.0.1
++	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
++	'SEARCH_WITH_USER'	=> 'Mensagens Privadas',
++	'SEARCH_WITH_USER_LANG'	=> 'Ver MPs com este utilizador',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php"
+new file mode 100644
+index 000000000..4c2974865
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php"
+@@ -0,0 +1,70 @@
++<?php
++/**
++*
++* PM Search extension for the phpBB Forum Software package.
++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
++*
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
++	// ACP general langauge
++	'ACP_PMSEARCH_GRP'	=> 'Pesquisa em MPs',
++	'ACP_PRVOPT'	=> 'Configurações',
++
++	//ACP PM Admin Settings page
++	'PMSEARCH_ADMIN'	=> 'Pesquisa em MPs',
++	'PMSEARCH_ADMIN_EXPLAIN'	=> 'A partir daqui, podes definir algumas das opções relacionadas à pesquisa de utilizadores em MPs.',
++	'PMSEARCH_SETTINGS'	=> 'Opções',
++	'PMSEARCH_PM_INDEX'	=> 'Índice de MP',
++	'PMSEARCH_PM_INDEX_EXPLAIN'	=> 'A partir daqui, podes permitir a indexação<br /><b>(Aviso! A pesquisa não funcionará se não tiveres indexação)</b>.',
++	'PMSEARCH_PM_SEARCH'	=>	'Permitir pesquisa',
++	'PMSEARCH_PM_SEARCH_EXPLAIN'	=> 'Permitir globalmente (ou negar) pesquisa em MPs.',
++	'DELETE_INDEX'	=> 'Apagar índices',
++	'CREATE_INDEX'	=> 'Criar índices',
++
++	//ACP ACL
++	'ACL_U_PMSEARCH'	=> 'O utilizador pode pesquisar em MPs',
++
++	//Other ACP
++	'LOG_PMSEARCH_INDEX_REMOVED'	=> '<strong>Índice de pesquisa removido por </strong><br />» %s',
++	'LOG_PMSEARCH_INDEX_CREATED'	=> '<strong>Índice de pesquisa criado por </strong><br />» %s',
++	'TOTAL_WORDS'							=> 'Total de palavras indexadas',
++	'TOTAL_MATCHES'							=> 'Contagem total de relações de palavras',
++	'SEARCH_INDEX_CREATE_REDIRECT'			=> array(
++		2	=> 'Todas as mensagens até à mensagem com id %2$d foram indexadas, das quais %1$d mensagens estavam dentro desta etapa.<br />',
++	),
++	'SEARCH_INDEX_CREATE_REDIRECT_RATE'		=> array(
++		2	=> 'A taxa actual de indexação é aproximadamente %1$.1f mensagens por segundo.<br />Indexação em andamento...',
++	),
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php"
+new file mode 100644
+index 000000000..7d419b386
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php"
+@@ -0,0 +1,53 @@
++<?php
++/**
++*
++* PM Search extension for the phpBB Forum Software package.
++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
++*
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
++	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
++	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
++	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
++	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
++	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
++	'SEARCH_PMS'	=> 'Pesquisar MPs',
++	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',
++
++	// Added in version 1.0.1
++	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
++	'SEARCH_WITH_USER'	=> 'Pesquisar',
++	'SEARCH_WITH_USER_LANG'	=> 'Mostrar conversas com este utilizador',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/phpunit.xml.dist" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/phpunit.xml.dist"
+deleted file mode 100644
+index d2a644126..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/phpunit.xml.dist"
++++ /dev/null
+@@ -1,34 +0,0 @@
+-<?xml version="1.0" encoding="UTF-8"?>
+-
+-<phpunit backupGlobals="true"
+-		 backupStaticAttributes="true"
+-		 colors="true"
+-		 convertErrorsToExceptions="true"
+-		 convertNoticesToExceptions="true"
+-		 convertWarningsToExceptions="true"
+-		 processIsolation="false"
+-		 stopOnFailure="false"
+-		 verbose="true"
+-		 bootstrap="../../../../tests/bootstrap.php"
+->
+-	<testsuites>
+-		<testsuite name="Extension Test Suite">
+-			<directory suffix="_test.php">./tests</directory>
+-			<exclude>./tests/functional</exclude>
+-		</testsuite>
+-		<testsuite name="Extension Functional Tests">
+-			<directory suffix="_test.php">./tests/functional/</directory>
+-		</testsuite>
+-	</testsuites>
+-
+-	<filter>
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
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php"
+index a5f410446..57586ed1c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php"
+@@ -644,7 +644,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
+ 					$sql = (!$sql) ? $this->db->sql_build_query('SELECT', $sql_array_count) : $sql;
+ 
+ 					$result = $this->db->sql_query($sql);
+-					$total_results = (int) $this->db->sql_fetchfield('total_results');
++					$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
+ 					$this->db->sql_freeresult($result);
+ 
+ 					if (!$total_results)
+@@ -691,7 +691,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
+ 			// Get the number of results as calculated by MySQL
+ 			$sql_count = 'SELECT FOUND_ROWS() as total_results';
+ 			$result = $this->db->sql_query($sql_count);
+-			$total_results = (int) $this->db->sql_fetchfield('total_results');
++			$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
+ 			$this->db->sql_freeresult($result);
+ 			if (!$total_results)
+ 			{
+@@ -1141,7 +1141,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
+ 					$sql = (!$sql) ? $this->db->sql_build_query('SELECT', $sql_array_count) : $sql;
+ 
+ 					$result = $this->db->sql_query($sql);
+-					$total_results = (int) $this->db->sql_fetchfield('total_results');
++					$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
+ 					$this->db->sql_freeresult($result);
+ 
+ 					if (!$total_results)
+@@ -1177,7 +1177,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
+ 			// Get the number of results as calculated by MySQL
+ 			$sql_count = 'SELECT FOUND_ROWS() as total_results';
+ 			$result = $this->db->sql_query($sql_count);
+-			$total_results = (int) $this->db->sql_fetchfield('total_results');
++			$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
+ 			$this->db->sql_freeresult($result);
+ 
+ 			if (!$total_results)
+@@ -1214,4 +1214,4 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
+ 		return $total_results;
+ 
+ 	}
+-}
++}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html"
+new file mode 100644
+index 000000000..99366d4eb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html"
+@@ -0,0 +1,98 @@
++<!-- INCLUDE ucp_header.html -->
++<form id="ucp" method="post" action="{S_UCP_ACTION}"{S_FORM_ENCTYPE}>
++<div class="well">
++	<h3>{L_PMSEARCH_TITLE}</h3>
++	<fieldset>
++		<div class="form-group">
++			 <label class="control-label" for="keywords">{L_SEARCH_KEYWORDS}{L_COLON}</label><span class="help-block">{L_PMSEARCH_KEYWORDS_EXPLAIN}</span>
++			  <div class="input-group">
++				<span class="input-group-addon"><i class="fa fa-search"></i></span>
++				<input class="form-control input-sm" type="text" placeholder="{L_SEARCH_USR_PLACEHOLDER}" name="keywords" id="keywords" title="{L_SEARCH_KEYWORDS}" value="{S_KEYWORDS}"/>
++			  </div> 
++		</div>
++		<div class="form-group">
++			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 1 -->checked="checked" <!-- ENDIF -->name="terms" id="terms1" value="all"><label class="checkbox-inline" for="terms1">{L_SEARCH_ALL_TERMS}</label>
++			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 2 -->checked="checked" <!-- ENDIF -->name="terms" id="terms2" value="any"><label class="checkbox-inline" for="terms2">{L_SEARCH_ANY_TERMS}</label>
++			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 3 -->checked="checked" <!-- ENDIF -->name="terms" id="terms3" value="nick"><label class="checkbox-inline" for="terms3">{L_SEARCH_FOR_NICK}</label>
++			<div class="control-group"></div>
++		</div>
++	</fieldset>
++	<fieldset class="submit-buttons">
++		{S_HIDDEN_FIELDS}<input type="reset" value="{L_RESET}" name="reset" class="btn btn-default" />&nbsp;
++		<input type="submit" name="submit" value="{L_SEARCH_PMS}" class="btn btn-default" />
++	</fieldset>
++</div>
++</form>
++<!-- IF HAS_RESULTS -->
++<div class="panel">
++	<div class="inner">
++		<div class="row">
++			<div class="col-md-12 text-right">
++				<div class="clearfix"> 
++					<div class="pagination">
++							<li class="active"><a>{TOTAL_MESSAGES}</a></li>
++							<!-- IF .pagination -->
++								<!-- INCLUDE pagination.html -->
++							<!-- ELSE -->
++								 <li class="active"><a>{PAGE_NUMBER}</a></li>
++							<!-- ENDIF -->
++					</div>
++				</div>
++			</div>
++		</div>
++		<div class="panel panel-forum">
++			<div class="panel-heading">
++				<i class="fa fa-bolt"></i>&nbsp;{L_MESSAGE}
++			</div>
++			<div class="panel-inner">
++				<table class="footable table table-striped table-primary table-hover">
++					<thead>
++						<tr>
++							<th data-class="expand">{L_TITLE}</th>
++							<th class="large10" data-hide="phone">{L_LAST_POST}</th>
++						</tr>
++					</thead>
++					<tbody>
++						<!--<ul class="topiclist cplist pmlist responsive-show-all <!-- IF S_SHOW_RECIPIENTS -->missing-column<!-- ELSE -->two-columns<!-- ENDIF -->">-->
++						<!-- BEGIN pm_results -->
++						<tr>
++							<td>
++							<span class="desc-wrapper">
++								<div class="row<!-- IF pm_results.S_ROW_COUNT is odd --> bg1<!-- ELSE --> bg2<!-- ENDIF --><!-- IF pm_results.PM_CLASS --> {pm_results.PM_CLASS}<!-- ENDIF -->">
++									<div class="row-item {pm_results.FOLDER_IMG_STYLE}">
++										<div<!-- IF pm_results.PM_ICON_URL and S_PM_ICONS --> style="background-image: url({pm_results.PM_ICON_URL}); background-repeat: no-repeat;"<!-- ENDIF -->>
++											<!-- IF pm_results.S_PM_UNREAD --><a href="{pm_results.U_VIEW_PM}" class="icon-link"></a><!-- ENDIF -->
++											<div class="list-inner">
++												<a href="{pm_results.U_VIEW_PM}" class="topictitle">{pm_results.SUBJECT}</a><br />
++												
++											</div>
++										</div>
++									</div>
++								</div>
++							</td>
++							<td class="center">{L_MESSAGE_BY_AUTHOR} {pm_results.MESSAGE_AUTHOR_FULL} &raquo; {pm_results.SENT_TIME}</td>
++						</tr>
++						<!-- END pm_results -->
++					</tbody>
++				</table>
++			</div>
++		</div>
++		<div class="row">
++			<div class="col-md-12 text-right">
++				<div class="clearfix"> 
++					<div class="pagination">
++						<li class="active"><a>{TOTAL_MESSAGES}</a></li>
++						<!-- IF .pagination -->
++							<!-- INCLUDE pagination.html -->
++						<!-- ELSE -->
++							 <li class="active"><a>{PAGE_NUMBER}</a></li>
++						<!-- ENDIF -->
++					</div>
++				</div>
++			</div>
++		</div>
++	</div>
++</div>
++
++<!-- ENDIF -->
++<!-- INCLUDE ucp_footer.html -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
+index b38184c78..1a5827a3c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
+@@ -1 +1,5 @@
+-<dt>{L_SEARCH_WITH_USER}{L_COLON}</dt> <dd><strong><a href="{U_SEARCH_WITH_USER}" target="_blank">{L_SEARCH_WITH_USER_LANG}</a></strong></dd>
++<li>
++<span class="fa fa-envelope"></span>
++<label>{L_SEARCH_WITH_USER}</label>
++<a href="{U_SEARCH_WITH_USER}" target="_blank">{L_SEARCH_WITH_USER_LANG}</a>
++</li>
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php"
+deleted file mode 100644
+index c69c71606..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php"
++++ /dev/null
+@@ -1,315 +0,0 @@
+-<?php
+-/**
+-*
+-* PM Search
+-*
+-* @copyright (c) 2014 Stanislav Atanasov
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-namespace anavaro\pmsearch\tests\functional;
+-
+-/**
+-* @group functional
+-*/
+-class pmsearch_acp_test extends pmsearch_base
+-{
+-	public function test_install()
+-	{
+-		//add users so we can send messages and search
+-		$this->create_user('testuser1');
+-		$this->add_user_group('REGISTERED', array('testuser1'));
+-		
+-		$this->login();
+-		$this->admin_login();
+-		
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$this->assertContainsLang('PMSEARCH_ADMIN', $crawler->text());
+-		
+-		$this->logout();
+-	}
+-	public function test_event_auto_index()
+-	{
+-		$this->login();
+-		$message_id = $this->create_private_message('Test private message', 'This test private message sent testing framework. need check event indexing.', array($this->get_user_id('testuser1')));
+-		
+-		$this->admin_login();
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$this->assertContains('11', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
+-		
+-		$this->logout();
+-	}
+-	
+-	public function test_acp_delete_index()
+-	{
+-		$this->login();
+-		$this->admin_login();
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$form = $crawler->selectButton($this->lang('DELETE_INDEX'))->form();
+-		$crawler = self::submit($form);
+-		
+-		//test step 3 begins
+-		$this->assertContains('0', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('0', $crawler->filter('#relative_indexes')->text());
+-		
+-		$this->logout();
+-	}
+-	public function test_acp_build_index()
+-	{
+-		$this->login();
+-		$this->admin_login();
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$form = $crawler->selectButton($this->lang('CREATE_INDEX'))->form();
+-		$crawler = self::submit($form);
+-		
+-		//test step 3 begins
+-		$this->assertContains('11', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
+-		
+-		$this->logout();
+-	}
+-	public function test_search()
+-	{
+-		$this->login();
+-		$message_id = $this->create_private_message('Test PM', 'This test PM will not contain words that stand for pm, so we can search for them.', array($this->get_user_id('testuser1')));
+-		$message_id = $this->create_private_message('Test PM 1', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the second pm', array($this->get_user_id('testuser1')));
+-		$message_id = $this->create_private_message('Test PM 3', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the third pm', array($this->get_user_id('testuser1')));
+-		$message_id = $this->create_private_message('Test PM 4', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the fourth pm', array($this->get_user_id('testuser1')));
+-		
+-		$this->logout();
+-		
+-		//get user to log in
+-		$this->login('testuser1');
+-		
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
+-		$form['keywords'] = 'Test';
+-		
+-		
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContains('5', $crawler->filter('.pagination')->text());
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
+-		$form['keywords'] = 'private';
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContains('1', $crawler->filter('.pagination')->text());
+-		//$this->assertContains('alalaalalalalala', $crawler->text());
+-		$this->logout();
+-	}
+-	public function test_remove_pm_one_way()
+-	{
+-		// Log in as user and delete some mssages
+-		$this->login('testuser1');
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&folder=inbox');
+-		
+-		$this->add_lang('ucp');
+-		$this->add_lang('mcp');
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=5');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=4');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=3');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=2');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$this->logout();
+-		
+-		// Login as admin - indexes should be as follows
+-		$this->login();
+-		
+-		$this->admin_login();
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$this->assertContains('26', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('75', $crawler->filter('#relative_indexes')->text());
+-		//$this->assertContains('alalaalalalalala', $crawler->text());
+-		
+-		$this->logout();
+-	}
+-	public function test_search_one_sided_there()
+-	{
+-		$this->login();
+-		
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
+-		$form['keywords'] = 'second';
+-		
+-		
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContains('1', $crawler->filter('.pagination')->text());
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
+-		$form['keywords'] = 'private';
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContains('1', $crawler->filter('.pagination')->text());
+-		//$this->assertContains('alalaalalalalala', $crawler->text());
+-		$this->logout();
+-	}
+-	public function test_search_one_sided_gone()
+-	{
+-		$this->login('testuser1');
+-		
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
+-		$form['keywords'] = 'second';
+-		
+-		
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContainsLang('NO_RESULTS_FOUND', $crawler->text());
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
+-		$form['keywords'] = 'private';
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContains('1', $crawler->filter('.pagination')->text());
+-		//$this->assertContains('alalaalalalalala', $crawler->text());
+-		$this->logout();
+-	}
+-	public function test_delete_second_side_and_index()
+-	{
+-		$this->login();
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&folder=sentbox');
+-		
+-		$this->add_lang('ucp');
+-		$this->add_lang('mcp');
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=5');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=4');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=3');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=2');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$this->admin_login();
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		//test step 3 begins
+-		$this->assertContains('26', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
+-		
+-		$this->logout();
+-	}
+-	
+-	public function test_delete_indexes_of_unread_messages()
+-	{
+-		$this->login();
+-		
+-		$message_id = $this->create_private_message('Test private message 6', 'This should delete indexes of unread messages.', array($this->get_user_id('testuser1')));
+-		
+-		$this->admin_login();
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$this->assertContains('31', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('23', $crawler->filter('#relative_indexes')->text());
+-		
+-		$this->add_lang('ucp');
+-		$this->add_lang('mcp');
+-		
+-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-2&p=6');
+-		$form = $crawler->selectButton('Yes')->form();
+-		$crawler = self::submit($form);
+-		
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
+-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
+-		
+-		$this->assertContains('31', $crawler->filter('#indexed_words')->text());
+-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
+-		
+-		
+-		$this->logout();
+-	}
+-	/*public function test_permission()
+-	{
+-		$this->login();
+-		$this->admin_login();
+-		$this->add_lang('acp/permissions');
+-		
+-		// User permissions
+-		$crawler = self::request('GET', 'adm/index.php?i=acp_permissions&icat=16&mode=setting_user_global&sid=' . $this->sid);
+-		$this->assertContains($this->lang('ACP_USERS_PERMISSIONS_EXPLAIN'), $this->get_content());
+-
+-		// Select testuser1
+-		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
+-		$data = array('username[0]' => 'testuser1');
+-		$form->setValues($data);
+-		$crawler = self::submit($form);
+-		$this->assertContains($this->lang('ACL_SET'), $crawler->filter('h1')->eq(1)->text());
+-		
+-		$form = $crawler->selectButton($this->lang('APPLY_PERMISSIONS'))->form();
+-		$data = array(
+-			'setting'	=> array(
+-				$this->get_user_id('testuser1')	=> array(
+-					0	=> array(
+-						'u_pmsearch' => '0'
+-					)
+-				),
+-			),
+-		);
+-		$form->setValues($data);
+-		$crawler = self::submit($form);
+-		
+-		$this->assertContainsLang('AUTH_UPDATED', $crawler->filter('html')->text());
+-		
+-		$this->logout();
+-		
+-		$this->login('testuser1');
+-		
+-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
+-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
+-		
+-		$this->assertContainsLang('ACCESS_DENIED', $crawler->filter('html')->text());
+-		
+-		$this->logout();
+-	}*/
+-}
+-?>
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_base.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_base.php"
+deleted file mode 100644
+index 2da19b90b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_base.php"
++++ /dev/null
+@@ -1,37 +0,0 @@
+-<?php
+-/**
+-*
+-* PM Search
+-*
+-* @copyright (c) 2014 Stanislav Atanasov
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-namespace anavaro\pmsearch\tests\functional;
+-
+-/**
+-* @group functional
+-*/
+-class pmsearch_base extends \phpbb_functional_test_case
+-{
+-	static protected function setup_extensions()
+-	{
+-		return array('anavaro/pmsearch');
+-	}
+-
+-	public function setUp() : void
+-	{
+-		parent::setUp();
+-	}
+-
+-	public function get_user_id($username)
+-	{
+-		$sql = 'SELECT user_id, username
+-				FROM ' . USERS_TABLE . '
+-				WHERE username_clean = \''.$this->db->sql_escape(utf8_clean_string($username)).'\'';
+-		$result = $this->db->sql_query($sql);
+-		$row = $this->db->sql_fetchrow($result);
+-		return $row['user_id'];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/fixtures/fixture.xml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/fixtures/fixture.xml"
+deleted file mode 100644
+index 83fed2fec..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/fixtures/fixture.xml"
++++ /dev/null
+@@ -1,75 +0,0 @@
+-<?xml version="1.0" encoding="UTF-8" ?>
+-<dataset>
+-    <table name="phpbb_config">
+-        <column>config_name</column>
+-        <column>config_value</column>
+-        <column>is_dynamic</column>
+-        <row>
+-            <value>phpbb_gallery_description_length</value>
+-            <value>2000</value>
+-            <value>0</value>
+-        </row>
+-        <row>
+-            <value>phpbb_gallery_allow_resize</value>
+-            <value>1</value>
+-            <value>0</value>
+-        </row>
+-        <row>
+-            <value>phpbb_gallery_link_thumbnail</value>
+-            <value>image_page</value>
+-            <value>0</value>
+-        </row>
+-    </table>
+-    <table name="phpbb_privmsgs">
+-        <column>msg_id</column>
+-        <column>author_id</column>
+-        <column>message_text</column>
+-        <column>to_address</column>
+-        <column>bcc_address</column>
+-        <row>
+-            <value>1</value>
+-            <value>2</value>
+-            <value>hahahhahahahaha</value>
+-            <value>u_5</value>
+-            <value>null</value>
+-        </row>
+-        <row>
+-            <value>2</value>
+-            <value>2</value>
+-            <value>hahahhahahahaha</value>
+-            <value>u_10</value>
+-            <value>null</value>
+-        </row>
+-        <row>
+-            <value>3</value>
+-            <value>10</value>
+-            <value>hahahhahahahaha</value>
+-            <value>u_2</value>
+-            <value>null</value>
+-        </row>
+-    </table>
+-    <table name="phpbb_privmsgs_to">
+-        <column>msg_id</column>
+-        <column>user_id</column>
+-        <row>
+-            <value>1</value>
+-            <value>2</value>
+-        </row>
+-        <row>
+-            <value>2</value>
+-            <value>2</value>
+-        </row>
+-        <row>
+-            <value>2</value>
+-            <value>10</value>
+-        </row>
+-        <row>
+-            <value>3</value>
+-            <value>10</value>
+-        </row>
+-        <row>
+-            <value>3</value>
+-            <value>2</value>
+-        </row>
+-    </table>
+-</dataset>
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/main_listener_test.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/main_listener_test.php"
+deleted file mode 100644
+index 2764b0e03..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/main_listener_test.php"
++++ /dev/null
+@@ -1,102 +0,0 @@
+-<?php
+-/**
+- *
+- * phpBB PM Search events test
+- *
+- * @copyright (c) 2015 Lucifer <https://www.anavaro.com>
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-namespace anavaro\pmsearch\tests\search;
+-/**
+- * @group event
+- */
+-class main_event_test extends \phpbb_database_test_case
+-{
+-	protected $listener;
+-
+-	/**
+-	 * Define the extensions to be tested
+-	 *
+-	 * @return array vendor/name of extension(s) to test
+-	 */
+-	static protected function setup_extensions()
+-	{
+-		return array('anavaro/pmsearch');
+-	}
+-
+-	protected $db;
+-
+-	/**
+-	 * Get data set fixtures
+-	 */
+-	public function getDataSet()
+-	{
+-		return $this->createXMLDataSet(dirname(__FILE__) . '/fixtures/fixture.xml');
+-	}
+-
+-	/**
+-	 * Setup test environment
+-	 */
+-	public function setUp() : void
+-	{
+-		parent::setUp();
+-
+-		$this->template = $this->getMockBuilder('\phpbb\template\template')
+-			->getMock()
+-		;
+-		$this->config = new \phpbb\config\config(array());
+-		$this->db = $this->new_dbal();
+-		$this->search_helper = $this->getMockBuilder('\anavaro\pmsearch\helper')
+-			->disableOriginalConstructor()
+-			->getMock();
+-	}
+-
+-	/**
+-	 * Create our controller
+-	 */
+-	protected function set_listener()
+-	{
+-		$this->listener = new \anavaro\pmsearch\event\main_listener(
+-			$this->config,
+-			$this->db,
+-			$this->template,
+-			$this->search_helper
+-		);
+-	}
+-
+-	/**
+-	 * Test the event listener is subscribing events
+-	 */
+-	public function test_getSubscribedEvents()
+-	{
+-		$this->assertEquals(array(
+-			'core.permissions',
+-			'core.submit_pm_after',
+-			'core.delete_pm_before',
+-			'core.memberlist_view_profile'
+-		), array_keys(\anavaro\pmsearch\event\main_listener::getSubscribedEvents()));
+-	}
+-
+-	/**
+-	 * Test user_profile_galleries
+-	 */
+-	public function test_user_profile_galleries()
+-	{
+-		$member = array('user_id' => 2);
+-		$event_data = array('member');
+-		$event = new \phpbb\event\data(compact($event_data));
+-		$this->set_listener();
+-
+-		$this->template->expects($this->once())
+-			->method('assign_vars')
+-			->with(array(
+-				'S_SEARCH_WITH_USER'	=> true,
+-				'U_SEARCH_WITH_USER'	=> 'http://ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search&terms=nick&keywords=2'
+-			));
+-
+-		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
+-		$dispatcher->addListener('core.memberlist_view_profile', array($this->listener, 'pm_search_with_user'));
+-		$dispatcher->dispatch('core.memberlist_view_profile', $event);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/native_test.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/native_test.php"
+deleted file mode 100644
+index f68cc3c4d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/native_test.php"
++++ /dev/null
+@@ -1,79 +0,0 @@
+-<?php
+-/**
+- * native_test.php
+- * part of pmsearch
+- * Created by Stanislav Atanasov.
+- * Date: 8/5/19
+- * Time: 3:51 PM
+- *
+- * File description:
+- *
+- *
+- */
+-
+-namespace anavaro\pmsearch\tests\search;
+-
+-
+-require_once dirname(__FILE__) . '/../../../../../../tests/test_framework/phpbb_search_test_case.php';
+-/**
+- * @group search
+- */
+-
+-
+-class native_test extends \phpbb_search_test_case
+-{
+-	protected $db;
+-	protected $search;
+-	protected $user;
+-	/**
+-	 * Define the extensions to be tested
+-	 *
+-	 * @return array vendor/name of extension(s) to test
+-	 */
+-	static protected function setup_extensions()
+-	{
+-		return array('anavaro/pmsearch');
+-	}
+-	/**
+-	 * Get data set fixtures
+-	 */
+-	public function getDataSet()
+-	{
+-		return $this->createXMLDataSet(dirname(__FILE__) . '/fixtures/fixture.xml');
+-	}
+-
+-	protected function setUp() : void
+-	{
+-		global $phpbb_root_path, $phpEx, $config, $user, $cache;
+-		parent::setUp();
+-		// dbal uses cache
+-		$cache = new \phpbb_mock_cache();
+-		$this->db = $this->new_dbal();
+-		$phpbb_dispatcher = new \phpbb_mock_event_dispatcher();
+-		$error = null;
+-		$class = self::get_search_wrapper('\anavaro\pmsearch\search\pm_search_fulltext_native');
+-		if (PHP_VERSION_ID > 70399)
+-		{
+-			$errorlevel=error_reporting();
+-			error_reporting(0);
+-		}
+-		$user->data['user_id'] = 2;
+-		if (PHP_VERSION_ID > 70399)
+-		{
+-			error_reporting($errorlevel);
+-		}
+-		$this->search = new $class($error, $phpbb_root_path, $phpEx, null, $config, $this->db, $user, $phpbb_dispatcher);
+-	}
+-
+-	public function test_user_search()
+-	{
+-		$count = 0;
+-		$test_ary = array();
+-		$all_ids = $this->search->user_search('test', $test_ary, $count, 5);
+-		$this->assertEquals(false, $all_ids);
+-		$all_ids = $this->search->user_search(5, $test_ary, $count, 5);
+-		$this->assertEquals(1, $all_ids);
+-		$all_ids = $this->search->user_search(10, $test_ary, $count, 5);
+-		$this->assertEquals(2, $all_ids);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-covarage.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-covarage.sh"
+deleted file mode 100644
+index e3d22c36c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-covarage.sh"
++++ /dev/null
+@@ -1,19 +0,0 @@
+-#!/bin/bash
+-#
+-# Collapsible Categories extension for the phpBB Forum Software package.
+-#
+-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
+-# @license GNU General Public License, version 2 (GPL-2.0)
+-#
+-set -e
+-set -x
+-
+-DB=$1
+-TRAVIS_PHP_VERSION=$2
+-EXTNAME=$3
+-
+-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
+-then
+-	sed -n '1h;1!H;${;g;s/<\/php>/<\/php>\n\t<filter>\n\t\t<whitelist>\n\t\t\t<directory>..\/<\/directory>\n\t\t\t<exclude>\n\t\t\t\t<directory>..\/tests\/<\/directory>\n\t\t\t\t<directory>..\/language\/<\/directory>\n\t\t\t\t<directory>..\/migrations\/<\/directory>\n\t\t\t<\/exclude>\n\t\t<\/whitelist>\n\t<\/filter>/g;p;}' phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml &> phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml.bak
+-	cp phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml.bak phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml
+-fi
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-epv.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-epv.sh"
+deleted file mode 100644
+index 51e91a8a5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-epv.sh"
++++ /dev/null
+@@ -1,23 +0,0 @@
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
+-EPV=$1
+-NOTESTS=$2
+-
+-if [ "$EPV" == "1" -a "$NOTESTS" == "1" ]
+-then
+-	cd phpBB
+-	composer remove sami/sami --update-with-dependencies --dev --no-interaction
+-	composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs
+-	cd ../
+-fi
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-phpbb.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-phpbb.sh"
+deleted file mode 100644
+index 01770ad6e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-phpbb.sh"
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
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/run-tests.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/run-tests.sh"
+deleted file mode 100644
+index 89eaaf468..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/run-tests.sh"
++++ /dev/null
+@@ -1,20 +0,0 @@
+-#!/bin/bash
+-#
+-# Collapsible Categories extension for the phpBB Forum Software package.
+-#
+-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
+-# @license GNU General Public License, version 2 (GPL-2.0)
+-#
+-set -e
+-set -x
+-
+-DB=$1
+-TRAVIS_PHP_VERSION=$2
+-EXTNAME=$3
+-
+-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
+-then
+-	phpBB/vendor/bin/phpunit --configuration phpBB/ext/"$EXTNAME"/travis/phpunit-"$DB"-travis.xml --bootstrap ./tests/bootstrap.php --coverage-clover build/logs/clover.xml
+-else
+-	phpBB/vendor/bin/phpunit --configuration phpBB/ext/"$EXTNAME"/travis/phpunit-"$DB"-travis.xml --bootstrap ./tests/bootstrap.php
+-fi
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/send-coverage.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/send-coverage.sh"
+deleted file mode 100644
+index 7631ea44e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/send-coverage.sh"
++++ /dev/null
+@@ -1,20 +0,0 @@
+-#!/bin/bash
+-#
+-# Collapsible Categories extension for the phpBB Forum Software package.
+-#
+-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
+-# @license GNU General Public License, version 2 (GPL-2.0)
+-#
+-set -e
+-set -x
+-
+-DB=$1
+-TRAVIS_PHP_VERSION=$2
+-GITREPO=$3
+-
+-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
+-then
+-    cd ../"$GITREPO"
+-    wget https://scrutinizer-ci.com/ocular.phar
+-    php ocular.phar code-coverage:upload --format=php-clover ../../phpBB3/build/logs/clover.xml
+-fi
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/ucp/ucp_pmsearch_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/ucp/ucp_pmsearch_module.php"
+index b8f3c0288..2fe3dc21c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/ucp/ucp_pmsearch_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/ucp/ucp_pmsearch_module.php"
+@@ -81,7 +81,7 @@ class ucp_pmsearch_module
+ 						$search_count = $this->search->user_search($keywords, $id_ary, $startFrom, $this->config['search_block_size']);
+ 					}
+ 
+-					if ($search_count > 0 )
++					if ($search_count > 0 && $id_ary)
+ 					{
+ 						// Let's get additional info
+ 						$page_array = array();
diff --git "[FORUM_EXT]/anavaro\\pmsearch/diff_nospace.tmp" "[FORUM_EXT]/anavaro\\pmsearch/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/diff_nospace.tmp"
@@ -0,0 +1,1627 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
+deleted file mode 100644
+index 8dc8afdd7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
++++ /dev/null
+@@ -1,68 +0,0 @@
+-language: php
+-dist: xenial
+-
+-matrix:
+-    include:
+-        - php: 7.1
+-          env: DB=none;NOTESTS=1
+-        - php: 7.1
+-          env: DB=mariadb
+-        - php: 7.1
+-          env: DB=postgres
+-#        - php: 7.1
+-#          env: DB=sqlite3
+-        - php: 7.1
+-          env: DB=mysqli # MyISAM
+-        - php: 7.2
+-          env: DB=mysqli;COVER=1
+-        - php: 7.3
+-          env: DB=mysqli
+-        - php: 7.4snapshot
+-          env: DB=mysqli
+-        - php: nightly
+-          env: DB=mysqli
+-    allow_failures:
+-        - php: nightly
+-    fast_finish: true
+-env:
+-    global:
+-        - EXTNAME="anavaro/pmsearch"  # CHANGE name of the extension HERE
+-        - GITREPO="satanasov/pmsearch" # CHANGE name of the repository HERE
+-        - SNIFF="1"            # Should we run code sniffer on your code?
+-        - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+-        - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+-        - COVERAGE="1"     # Should we send code coverage?
+-        - PHPBB_BRANCH="3.3.x"
+-
+-branches:
+-    only:
+-        - master
+-        - develop
+-        - /^develop-.*$/
+-
+-services:
+-    - postgresql
+-    - mysql
+-    - memcached
+-
+-install:
+-    - composer install --dev --no-interaction --prefer-source
+-    - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+-    - cd ../../phpBB3
+-    - sh -c "if [ '$COVER' != '0' ]; then sed -i '/phpenv/d' travis/setup-php-extensions.sh; fi"
+-    - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+-    - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+-    - sh -c "if [ '$COVERAGE' != '0' ] && [ '$COVER' != '0' ]; then phpBB/ext/$EXTNAME/travis/prepare-covarage.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-    - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/ext/$EXTNAME/travis/prepare-epv.sh $EPV $NOTESTS; fi"
+-
+-before_script:
+-    - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+-
+-script:
+-    - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-    - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+-    - sh -c "if [ '$DB' != 'none' ]; then phpBB/ext/$EXTNAME/travis/run-tests.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+-    - sh -c "if [ '$EPV' != '0' -a '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+-
+-after_script:
+-    - sh -c "if [ '$COVERAGE' != '0' ]; then phpBB/ext/$EXTNAME/travis/send-coverage.sh $DB $TRAVIS_PHP_VERSION $GITREPO; fi"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
+deleted file mode 100644
+index 52b32b105..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
++++ /dev/null
+@@ -1,39 +0,0 @@
+-PM Search
+-===========
+-
+-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch) [![Code Coverage](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master)
+-
+-PM search is phpBB 3.2 extension that allows users to search trough the PM archive in the board.
+-
+-Features
+---
+-
+-  ACP
+-  
+-    - Enable PM Indexing
+-    - GLobaly allow PM search
+-    - Individual user permissions to allow PM Search
+-    - Indexing statistics
+-    - Build/delete Indexing statistics
+-  
+-  UCP
+-  
+-    - New UCP module for search
+-	
+-  Events
+-  
+-    - Register every PM for indexing
+-	- Remove PM removes index
+-    
+-    
+-
+-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch)
+-
+-
+-##Donate
+-If you like my code - buy me a beer/coffee/license for PhpStorm :D
+-
+-- BTC: 12afvCTp1dRrQdHaavzthZ1dNWMoi8eyc8
+-- ETH: 0x363abc8edf41ac89906b20e90cf7fdc71fe78cd5
+-
+-[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XQ6USSXCSUM5W)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
+index 2d118856c..61348e4a5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
+@@ -195,7 +195,7 @@ class acp_pmsearch_module
+ 
+ 					if ($this->search_helper->init_search($search_types[0], $search, $error) || !method_exists($search, 'index_created'))
+ 					{
+-						break;
++						continue;
+ 					}
+ 
+ 					//Let's build normal
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp"
+new file mode 100644
+index 000000000..7b63d5756
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp"
+@@ -0,0 +1,1527 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
++deleted file mode 100644
++index 8dc8afdd7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
+++++ /dev/null
++@@ -1,68 +0,0 @@
++-language: php
++-dist: xenial
++-
++-matrix:
++-    include:
++-        - php: 7.1
++-          env: DB=none;NOTESTS=1
++-        - php: 7.1
++-          env: DB=mariadb
++-        - php: 7.1
++-          env: DB=postgres
++-#        - php: 7.1
++-#          env: DB=sqlite3
++-        - php: 7.1
++-          env: DB=mysqli # MyISAM
++-        - php: 7.2
++-          env: DB=mysqli;COVER=1
++-        - php: 7.3
++-          env: DB=mysqli
++-        - php: 7.4snapshot
++-          env: DB=mysqli
++-        - php: nightly
++-          env: DB=mysqli
++-    allow_failures:
++-        - php: nightly
++-    fast_finish: true
++-env:
++-    global:
++-        - EXTNAME="anavaro/pmsearch"  # CHANGE name of the extension HERE
++-        - GITREPO="satanasov/pmsearch" # CHANGE name of the repository HERE
++-        - SNIFF="1"            # Should we run code sniffer on your code?
++-        - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
++-        - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
++-        - COVERAGE="1"     # Should we send code coverage?
++-        - PHPBB_BRANCH="3.3.x"
++-
++-branches:
++-    only:
++-        - master
++-        - develop
++-        - /^develop-.*$/
++-
++-services:
++-    - postgresql
++-    - mysql
++-    - memcached
++-
++-install:
++-    - composer install --dev --no-interaction --prefer-source
++-    - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
++-    - cd ../../phpBB3
++-    - sh -c "if [ '$COVER' != '0' ]; then sed -i '/phpenv/d' travis/setup-php-extensions.sh; fi"
++-    - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
++-    - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
++-    - sh -c "if [ '$COVERAGE' != '0' ] && [ '$COVER' != '0' ]; then phpBB/ext/$EXTNAME/travis/prepare-covarage.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-    - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/ext/$EXTNAME/travis/prepare-epv.sh $EPV $NOTESTS; fi"
++-
++-before_script:
++-    - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
++-
++-script:
++-    - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-    - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
++-    - sh -c "if [ '$DB' != 'none' ]; then phpBB/ext/$EXTNAME/travis/run-tests.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
++-    - sh -c "if [ '$EPV' != '0' -a '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
++-
++-after_script:
++-    - sh -c "if [ '$COVERAGE' != '0' ]; then phpBB/ext/$EXTNAME/travis/send-coverage.sh $DB $TRAVIS_PHP_VERSION $GITREPO; fi"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
++deleted file mode 100644
++index 52b32b105..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
+++++ /dev/null
++@@ -1,39 +0,0 @@
++-PM Search
++-===========
++-
++-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch) [![Code Coverage](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master)
++-
++-PM search is phpBB 3.2 extension that allows users to search trough the PM archive in the board.
++-
++-Features
++---
++-
++-  ACP
++-  
++-    - Enable PM Indexing
++-    - GLobaly allow PM search
++-    - Individual user permissions to allow PM Search
++-    - Indexing statistics
++-    - Build/delete Indexing statistics
++-  
++-  UCP
++-  
++-    - New UCP module for search
++-	
++-  Events
++-  
++-    - Register every PM for indexing
++-	- Remove PM removes index
++-    
++-    
++-
++-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch)
++-
++-
++-##Donate
++-If you like my code - buy me a beer/coffee/license for PhpStorm :D
++-
++-- BTC: 12afvCTp1dRrQdHaavzthZ1dNWMoi8eyc8
++-- ETH: 0x363abc8edf41ac89906b20e90cf7fdc71fe78cd5
++-
++-[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=XQ6USSXCSUM5W)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
++index 2d118856c..61348e4a5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/acp/acp_pmsearch_module.php"
++@@ -195,7 +195,7 @@ class acp_pmsearch_module
++ 
++ 					if ($this->search_helper->init_search($search_types[0], $search, $error) || !method_exists($search, 'index_created'))
++ 					{
++-						break;
+++						continue;
++ 					}
++ 
++ 					//Let's build normal
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp"
++new file mode 100644
++index 000000000..96dfe78b7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/diff_full.tmp"
++@@ -0,0 +1,97 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
+++deleted file mode 100644
+++index 8dc8afdd7..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/.travis.yml"
++++++ /dev/null
+++@@ -1,68 +0,0 @@
+++-language: php
+++-dist: xenial
+++-
+++-matrix:
+++-    include:
+++-        - php: 7.1
+++-          env: DB=none;NOTESTS=1
+++-        - php: 7.1
+++-          env: DB=mariadb
+++-        - php: 7.1
+++-          env: DB=postgres
+++-#        - php: 7.1
+++-#          env: DB=sqlite3
+++-        - php: 7.1
+++-          env: DB=mysqli # MyISAM
+++-        - php: 7.2
+++-          env: DB=mysqli;COVER=1
+++-        - php: 7.3
+++-          env: DB=mysqli
+++-        - php: 7.4snapshot
+++-          env: DB=mysqli
+++-        - php: nightly
+++-          env: DB=mysqli
+++-    allow_failures:
+++-        - php: nightly
+++-    fast_finish: true
+++-env:
+++-    global:
+++-        - EXTNAME="anavaro/pmsearch"  # CHANGE name of the extension HERE
+++-        - GITREPO="satanasov/pmsearch" # CHANGE name of the repository HERE
+++-        - SNIFF="1"            # Should we run code sniffer on your code?
+++-        - IMAGE_ICC="1"        # Should we run icc profile sniffer on your images?
+++-        - EPV="1"              # Should we run EPV (Extension Pre Validator) on your code?
+++-        - COVERAGE="1"     # Should we send code coverage?
+++-        - PHPBB_BRANCH="3.3.x"
+++-
+++-branches:
+++-    only:
+++-        - master
+++-        - develop
+++-        - /^develop-.*$/
+++-
+++-services:
+++-    - postgresql
+++-    - mysql
+++-    - memcached
+++-
+++-install:
+++-    - composer install --dev --no-interaction --prefer-source
+++-    - travis/prepare-phpbb.sh $EXTNAME $PHPBB_BRANCH
+++-    - cd ../../phpBB3
+++-    - sh -c "if [ '$COVER' != '0' ]; then sed -i '/phpenv/d' travis/setup-php-extensions.sh; fi"
+++-    - travis/prepare-extension.sh $EXTNAME $PHPBB_BRANCH
+++-    - travis/setup-phpbb.sh $DB $TRAVIS_PHP_VERSION
+++-    - sh -c "if [ '$COVERAGE' != '0' ] && [ '$COVER' != '0' ]; then phpBB/ext/$EXTNAME/travis/prepare-covarage.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+++-    - sh -c "if [ '$EPV' != '0' ] && [ '$NOTESTS' = '1' ]; then phpBB/ext/$EXTNAME/travis/prepare-epv.sh $EPV $NOTESTS; fi"
+++-
+++-before_script:
+++-    - travis/setup-database.sh $DB $TRAVIS_PHP_VERSION
+++-
+++-script:
+++-    - sh -c "if [ '$SNIFF' != '0' ]; then travis/ext-sniff.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+++-    - sh -c "if [ '$IMAGE_ICC' != '0' ]; then travis/check-image-icc-profiles.sh $DB $TRAVIS_PHP_VERSION; fi"
+++-    - sh -c "if [ '$DB' != 'none' ]; then phpBB/ext/$EXTNAME/travis/run-tests.sh $DB $TRAVIS_PHP_VERSION $EXTNAME; fi"
+++-    - sh -c "if [ '$EPV' != '0' -a '$NOTESTS' = '1' ]; then phpBB/vendor/bin/EPV.php run --dir='phpBB/ext/$EXTNAME/'; fi"
+++-
+++-after_script:
+++-    - sh -c "if [ '$COVERAGE' != '0' ]; then phpBB/ext/$EXTNAME/travis/send-coverage.sh $DB $TRAVIS_PHP_VERSION $GITREPO; fi"
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
+++deleted file mode 100644
+++index 52b32b105..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/README.md"
++++++ /dev/null
+++@@ -1,39 +0,0 @@
+++-PM Search
+++-===========
+++-
+++-[![Build Status](https://travis-ci.org/satanasov/pmsearch.svg?branch=master)](https://travis-ci.org/satanasov/pmsearch) [![Code Coverage](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/satanasov/pmsearch/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/satanasov/pmsearch/?branch=master)
+++-
+++-PM search is phpBB 3.2 extension that allows users to search trough the PM archive in the board.
+++-
+++-Features
+++---
+++-
+++-  ACP
+++-  
+++-    - Enable PM Indexing
+++-    - GLobaly allow PM search
+++-    - Individual user permissions to allow PM Search
+++-    - Indexing statistics
+++-    - Build/delete Indexing sta
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/event/main_listener.php"
++index 5961a8b96..792a65da8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/event/main_listener.php"
++@@ -20,10 +20,10 @@ class main_listener implements EventSubscriberInterface
++ 	static public function getSubscribedEvents()
++ 	{
++ 		return array(
++-			'core.permissions'	       => 'acl_perms_add',
++-			'core.submit_pm_after'	       => 'pm_search_main',
++-			'core.delete_pm_before'	=> 'pm_delete_index',
++-			'core.memberlist_view_profile'	       => 'pm_search_with_user',
+++			'core.permissions'				=> 'acl_perms_add',
+++			'core.submit_pm_after'			=> 'pm_search_main',
+++			'core.delete_pm_before'			=> 'pm_delete_index',
+++			'core.memberlist_view_profile'	=> 'pm_search_with_user',
++ 		);
++ 	}
++ 
++@@ -133,7 +133,7 @@ class main_listener implements EventSubscriberInterface
++ 	public function pm_search_with_user($event)
++ 	{
++ 		$target = $event['member']['user_id'];
++-		$url = generate_board_url() . '/ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search&terms=nick&keywords=' . $target;
+++		$url = generate_board_url() . '/ucp.php?i=-anavaro-pmsearch-ucp-ucp_pmsearch_module&mode=search&terms=nick&keywords=' . $target;
++ 		$this->template->assign_vars(array(
++ 			'S_SEARCH_WITH_USER'	=> true,
++ 			'U_SEARCH_WITH_USER'	=> $url
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_acp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_acp_pmsearch.php"
++new file mode 100644
++index 000000000..ee3642dfa
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_acp_pmsearch.php"
++@@ -0,0 +1,70 @@
+++<?php
+++/**
+++*
+++* PM Search extension for the phpBB Forum Software package.
+++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+++*
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
+++	// ACP general langauge
+++	'ACP_PMSEARCH_GRP'	=> 'Pesquisa em MPs',
+++	'ACP_PRVOPT'	=> 'Configurações',
+++
+++	//ACP PM Admin Settings page
+++	'PMSEARCH_ADMIN'	=> 'Pesquisa em MPs',
+++	'PMSEARCH_ADMIN_EXPLAIN'	=> 'A partir daqui, podes definir algumas das opções relacionadas à pesquisa de utilizadores em MPs.',
+++	'PMSEARCH_SETTINGS'	=> 'Opções',
+++	'PMSEARCH_PM_INDEX'	=> 'Índice de MP',
+++	'PMSEARCH_PM_INDEX_EXPLAIN'	=> 'A partir daqui, podes permitir a indexação<br /><b>(Aviso! A pesquisa não funcionará se não tiveres indexação)</b>.',
+++	'PMSEARCH_PM_SEARCH'	=>	'Permitir pesquisa',
+++	'PMSEARCH_PM_SEARCH_EXPLAIN'	=> 'Permitir globalmente (ou negar) pesquisa em MPs.',
+++	'DELETE_INDEX'	=> 'Apagar índices',
+++	'CREATE_INDEX'	=> 'Criar índices',
+++
+++	//ACP ACL
+++	'ACL_U_PMSEARCH'	=> 'O utilizador pode pesquisar em MPs',
+++
+++	//Other ACP
+++	'LOG_PMSEARCH_INDEX_REMOVED'	=> '<strong>Índice de pesquisa removido por </strong><br />» %s',
+++	'LOG_PMSEARCH_INDEX_CREATED'	=> '<strong>Índice de pesquisa criado por </strong><br />» %s',
+++	'TOTAL_WORDS'							=> 'Total de palavras indexadas',
+++	'TOTAL_MATCHES'							=> 'Contagem total de relações de palavras',
+++	'SEARCH_INDEX_CREATE_REDIRECT'			=> array(
+++		2	=> 'Todas as mensagens até à mensagem com id %2$d foram indexadas, das quais %1$d mensagens estavam dentro desta etapa.<br />',
+++	),
+++	'SEARCH_INDEX_CREATE_REDIRECT_RATE'		=> array(
+++		2	=> 'A taxa atual de indexação é aproximadamente %1$.1f mensagens por segundo.<br />Indexação em andamento...',
+++	),
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php"
++new file mode 100644
++index 000000000..ff0109826
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php"
++@@ -0,0 +1,53 @@
+++<?php
+++/**
+++*
+++* PM Search extension for the phpBB Forum Software package.
+++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+++*
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
+++	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
+++	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
+++	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
+++	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
+++	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
+++	'SEARCH_PMS'	=> 'Pesquisar MPs',
+++	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',
+++
+++	// Added in version 1.0.1
+++	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
+++	'SEARCH_WITH_USER'	=> 'Mensagens Privadas',
+++	'SEARCH_WITH_USER_LANG'	=> 'Ver MPs com este utilizador',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php"
++new file mode 100644
++index 000000000..4c2974865
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php"
++@@ -0,0 +1,70 @@
+++<?php
+++/**
+++*
+++* PM Search extension for the phpBB Forum Software package.
+++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+++*
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
+++	// ACP general langauge
+++	'ACP_PMSEARCH_GRP'	=> 'Pesquisa em MPs',
+++	'ACP_PRVOPT'	=> 'Configurações',
+++
+++	//ACP PM Admin Settings page
+++	'PMSEARCH_ADMIN'	=> 'Pesquisa em MPs',
+++	'PMSEARCH_ADMIN_EXPLAIN'	=> 'A partir daqui, podes definir algumas das opções relacionadas à pesquisa de utilizadores em MPs.',
+++	'PMSEARCH_SETTINGS'	=> 'Opções',
+++	'PMSEARCH_PM_INDEX'	=> 'Índice de MP',
+++	'PMSEARCH_PM_INDEX_EXPLAIN'	=> 'A partir daqui, podes permitir a indexação<br /><b>(Aviso! A pesquisa não funcionará se não tiveres indexação)</b>.',
+++	'PMSEARCH_PM_SEARCH'	=>	'Permitir pesquisa',
+++	'PMSEARCH_PM_SEARCH_EXPLAIN'	=> 'Permitir globalmente (ou negar) pesquisa em MPs.',
+++	'DELETE_INDEX'	=> 'Apagar índices',
+++	'CREATE_INDEX'	=> 'Criar índices',
+++
+++	//ACP ACL
+++	'ACL_U_PMSEARCH'	=> 'O utilizador pode pesquisar em MPs',
+++
+++	//Other ACP
+++	'LOG_PMSEARCH_INDEX_REMOVED'	=> '<strong>Índice de pesquisa removido por </strong><br />» %s',
+++	'LOG_PMSEARCH_INDEX_CREATED'	=> '<strong>Índice de pesquisa criado por </strong><br />» %s',
+++	'TOTAL_WORDS'							=> 'Total de palavras indexadas',
+++	'TOTAL_MATCHES'							=> 'Contagem total de relações de palavras',
+++	'SEARCH_INDEX_CREATE_REDIRECT'			=> array(
+++		2	=> 'Todas as mensagens até à mensagem com id %2$d foram indexadas, das quais %1$d mensagens estavam dentro desta etapa.<br />',
+++	),
+++	'SEARCH_INDEX_CREATE_REDIRECT_RATE'		=> array(
+++		2	=> 'A taxa actual de indexação é aproximadamente %1$.1f mensagens por segundo.<br />Indexação em andamento...',
+++	),
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php"
++new file mode 100644
++index 000000000..7d419b386
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php"
++@@ -0,0 +1,53 @@
+++<?php
+++/**
+++*
+++* PM Search extension for the phpBB Forum Software package.
+++* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+++*
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
+++	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
+++	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
+++	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
+++	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
+++	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
+++	'SEARCH_PMS'	=> 'Pesquisar MPs',
+++	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',
+++
+++	// Added in version 1.0.1
+++	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
+++	'SEARCH_WITH_USER'	=> 'Pesquisar',
+++	'SEARCH_WITH_USER_LANG'	=> 'Mostrar conversas com este utilizador',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/phpunit.xml.dist" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/phpunit.xml.dist"
++deleted file mode 100644
++index d2a644126..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/phpunit.xml.dist"
+++++ /dev/null
++@@ -1,34 +0,0 @@
++-<?xml version="1.0" encoding="UTF-8"?>
++-
++-<phpunit backupGlobals="true"
++-		 backupStaticAttributes="true"
++-		 colors="true"
++-		 convertErrorsToExceptions="true"
++-		 convertNoticesToExceptions="true"
++-		 convertWarningsToExceptions="true"
++-		 processIsolation="false"
++-		 stopOnFailure="false"
++-		 verbose="true"
++-		 bootstrap="../../../../tests/bootstrap.php"
++->
++-	<testsuites>
++-		<testsuite name="Extension Test Suite">
++-			<directory suffix="_test.php">./tests</directory>
++-			<exclude>./tests/functional</exclude>
++-		</testsuite>
++-		<testsuite name="Extension Functional Tests">
++-			<directory suffix="_test.php">./tests/functional/</directory>
++-		</testsuite>
++-	</testsuites>
++-
++-	<filter>
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
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php"
++index a5f410446..57586ed1c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/search/pm_search_fulltext_native.php"
++@@ -644,7 +644,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
++ 					$sql = (!$sql) ? $this->db->sql_build_query('SELECT', $sql_array_count) : $sql;
++ 
++ 					$result = $this->db->sql_query($sql);
++-					$total_results = (int) $this->db->sql_fetchfield('total_results');
+++					$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
++ 					$this->db->sql_freeresult($result);
++ 
++ 					if (!$total_results)
++@@ -691,7 +691,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
++ 			// Get the number of results as calculated by MySQL
++ 			$sql_count = 'SELECT FOUND_ROWS() as total_results';
++ 			$result = $this->db->sql_query($sql_count);
++-			$total_results = (int) $this->db->sql_fetchfield('total_results');
+++			$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
++ 			$this->db->sql_freeresult($result);
++ 			if (!$total_results)
++ 			{
++@@ -1141,7 +1141,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
++ 					$sql = (!$sql) ? $this->db->sql_build_query('SELECT', $sql_array_count) : $sql;
++ 
++ 					$result = $this->db->sql_query($sql);
++-					$total_results = (int) $this->db->sql_fetchfield('total_results');
+++					$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
++ 					$this->db->sql_freeresult($result);
++ 
++ 					if (!$total_results)
++@@ -1177,7 +1177,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
++ 			// Get the number of results as calculated by MySQL
++ 			$sql_count = 'SELECT FOUND_ROWS() as total_results';
++ 			$result = $this->db->sql_query($sql_count);
++-			$total_results = (int) $this->db->sql_fetchfield('total_results');
+++			$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
++ 			$this->db->sql_freeresult($result);
++ 
++ 			if (!$total_results)
++@@ -1214,4 +1214,4 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
++ 		return $total_results;
++ 
++ 	}
++-}
+++}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html"
++new file mode 100644
++index 000000000..99366d4eb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html"
++@@ -0,0 +1,98 @@
+++<!-- INCLUDE ucp_header.html -->
+++<form id="ucp" method="post" action="{S_UCP_ACTION}"{S_FORM_ENCTYPE}>
+++<div class="well">
+++	<h3>{L_PMSEARCH_TITLE}</h3>
+++	<fieldset>
+++		<div class="form-group">
+++			 <label class="control-label" for="keywords">{L_SEARCH_KEYWORDS}{L_COLON}</label><span class="help-block">{L_PMSEARCH_KEYWORDS_EXPLAIN}</span>
+++			  <div class="input-group">
+++				<span class="input-group-addon"><i class="fa fa-search"></i></span>
+++				<input class="form-control input-sm" type="text" placeholder="{L_SEARCH_USR_PLACEHOLDER}" name="keywords" id="keywords" title="{L_SEARCH_KEYWORDS}" value="{S_KEYWORDS}"/>
+++			  </div> 
+++		</div>
+++		<div class="form-group">
+++			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 1 -->checked="checked" <!-- ENDIF -->name="terms" id="terms1" value="all"><label class="checkbox-inline" for="terms1">{L_SEARCH_ALL_TERMS}</label>
+++			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 2 -->checked="checked" <!-- ENDIF -->name="terms" id="terms2" value="any"><label class="checkbox-inline" for="terms2">{L_SEARCH_ANY_TERMS}</label>
+++			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 3 -->checked="checked" <!-- ENDIF -->name="terms" id="terms3" value="nick"><label class="checkbox-inline" for="terms3">{L_SEARCH_FOR_NICK}</label>
+++			<div class="control-group"></div>
+++		</div>
+++	</fieldset>
+++	<fieldset class="submit-buttons">
+++		{S_HIDDEN_FIELDS}<input type="reset" value="{L_RESET}" name="reset" class="btn btn-default" />&nbsp;
+++		<input type="submit" name="submit" value="{L_SEARCH_PMS}" class="btn btn-default" />
+++	</fieldset>
+++</div>
+++</form>
+++<!-- IF HAS_RESULTS -->
+++<div class="panel">
+++	<div class="inner">
+++		<div class="row">
+++			<div class="col-md-12 text-right">
+++				<div class="clearfix"> 
+++					<div class="pagination">
+++							<li class="active"><a>{TOTAL_MESSAGES}</a></li>
+++							<!-- IF .pagination -->
+++								<!-- INCLUDE pagination.html -->
+++							<!-- ELSE -->
+++								 <li class="active"><a>{PAGE_NUMBER}</a></li>
+++							<!-- ENDIF -->
+++					</div>
+++				</div>
+++			</div>
+++		</div>
+++		<div class="panel panel-forum">
+++			<div class="panel-heading">
+++				<i class="fa fa-bolt"></i>&nbsp;{L_MESSAGE}
+++			</div>
+++			<div class="panel-inner">
+++				<table class="footable table table-striped table-primary table-hover">
+++					<thead>
+++						<tr>
+++							<th data-class="expand">{L_TITLE}</th>
+++							<th class="large10" data-hide="phone">{L_LAST_POST}</th>
+++						</tr>
+++					</thead>
+++					<tbody>
+++						<!--<ul class="topiclist cplist pmlist responsive-show-all <!-- IF S_SHOW_RECIPIENTS -->missing-column<!-- ELSE -->two-columns<!-- ENDIF -->">-->
+++						<!-- BEGIN pm_results -->
+++						<tr>
+++							<td>
+++							<span class="desc-wrapper">
+++								<div class="row<!-- IF pm_results.S_ROW_COUNT is odd --> bg1<!-- ELSE --> bg2<!-- ENDIF --><!-- IF pm_results.PM_CLASS --> {pm_results.PM_CLASS}<!-- ENDIF -->">
+++									<div class="row-item {pm_results.FOLDER_IMG_STYLE}">
+++										<div<!-- IF pm_results.PM_ICON_URL and S_PM_ICONS --> style="background-image: url({pm_results.PM_ICON_URL}); background-repeat: no-repeat;"<!-- ENDIF -->>
+++											<!-- IF pm_results.S_PM_UNREAD --><a href="{pm_results.U_VIEW_PM}" class="icon-link"></a><!-- ENDIF -->
+++											<div class="list-inner">
+++												<a href="{pm_results.U_VIEW_PM}" class="topictitle">{pm_results.SUBJECT}</a><br />
+++												
+++											</div>
+++										</div>
+++									</div>
+++								</div>
+++							</td>
+++							<td class="center">{L_MESSAGE_BY_AUTHOR} {pm_results.MESSAGE_AUTHOR_FULL} &raquo; {pm_results.SENT_TIME}</td>
+++						</tr>
+++						<!-- END pm_results -->
+++					</tbody>
+++				</table>
+++			</div>
+++		</div>
+++		<div class="row">
+++			<div class="col-md-12 text-right">
+++				<div class="clearfix"> 
+++					<div class="pagination">
+++						<li class="active"><a>{TOTAL_MESSAGES}</a></li>
+++						<!-- IF .pagination -->
+++							<!-- INCLUDE pagination.html -->
+++						<!-- ELSE -->
+++							 <li class="active"><a>{PAGE_NUMBER}</a></li>
+++						<!-- ENDIF -->
+++					</div>
+++				</div>
+++			</div>
+++		</div>
+++	</div>
+++</div>
+++
+++<!-- ENDIF -->
+++<!-- INCLUDE ucp_footer.html -->
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
++index b38184c78..1a5827a3c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
++@@ -1 +1,5 @@
++-<dt>{L_SEARCH_WITH_USER}{L_COLON}</dt> <dd><strong><a href="{U_SEARCH_WITH_USER}" target="_blank">{L_SEARCH_WITH_USER_LANG}</a></strong></dd>
+++<li>
+++<span class="fa fa-envelope"></span>
+++<label>{L_SEARCH_WITH_USER}</label>
+++<a href="{U_SEARCH_WITH_USER}" target="_blank">{L_SEARCH_WITH_USER_LANG}</a>
+++</li>
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php"
++deleted file mode 100644
++index c69c71606..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php"
+++++ /dev/null
++@@ -1,315 +0,0 @@
++-<?php
++-/**
++-*
++-* PM Search
++-*
++-* @copyright (c) 2014 Stanislav Atanasov
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-namespace anavaro\pmsearch\tests\functional;
++-
++-/**
++-* @group functional
++-*/
++-class pmsearch_acp_test extends pmsearch_base
++-{
++-	public function test_install()
++-	{
++-		//add users so we can send messages and search
++-		$this->create_user('testuser1');
++-		$this->add_user_group('REGISTERED', array('testuser1'));
++-		
++-		$this->login();
++-		$this->admin_login();
++-		
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$this->assertContainsLang('PMSEARCH_ADMIN', $crawler->text());
++-		
++-		$this->logout();
++-	}
++-	public function test_event_auto_index()
++-	{
++-		$this->login();
++-		$message_id = $this->create_private_message('Test private message', 'This test private message sent testing framework. need check event indexing.', array($this->get_user_id('testuser1')));
++-		
++-		$this->admin_login();
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$this->assertContains('11', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
++-		
++-		$this->logout();
++-	}
++-	
++-	public function test_acp_delete_index()
++-	{
++-		$this->login();
++-		$this->admin_login();
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$form = $crawler->selectButton($this->lang('DELETE_INDEX'))->form();
++-		$crawler = self::submit($form);
++-		
++-		//test step 3 begins
++-		$this->assertContains('0', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('0', $crawler->filter('#relative_indexes')->text());
++-		
++-		$this->logout();
++-	}
++-	public function test_acp_build_index()
++-	{
++-		$this->login();
++-		$this->admin_login();
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$form = $crawler->selectButton($this->lang('CREATE_INDEX'))->form();
++-		$crawler = self::submit($form);
++-		
++-		//test step 3 begins
++-		$this->assertContains('11', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
++-		
++-		$this->logout();
++-	}
++-	public function test_search()
++-	{
++-		$this->login();
++-		$message_id = $this->create_private_message('Test PM', 'This test PM will not contain words that stand for pm, so we can search for them.', array($this->get_user_id('testuser1')));
++-		$message_id = $this->create_private_message('Test PM 1', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the second pm', array($this->get_user_id('testuser1')));
++-		$message_id = $this->create_private_message('Test PM 3', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the third pm', array($this->get_user_id('testuser1')));
++-		$message_id = $this->create_private_message('Test PM 4', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the fourth pm', array($this->get_user_id('testuser1')));
++-		
++-		$this->logout();
++-		
++-		//get user to log in
++-		$this->login('testuser1');
++-		
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
++-		$form['keywords'] = 'Test';
++-		
++-		
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContains('5', $crawler->filter('.pagination')->text());
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
++-		$form['keywords'] = 'private';
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContains('1', $crawler->filter('.pagination')->text());
++-		//$this->assertContains('alalaalalalalala', $crawler->text());
++-		$this->logout();
++-	}
++-	public function test_remove_pm_one_way()
++-	{
++-		// Log in as user and delete some mssages
++-		$this->login('testuser1');
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&folder=inbox');
++-		
++-		$this->add_lang('ucp');
++-		$this->add_lang('mcp');
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=5');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=4');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=3');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=2');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$this->logout();
++-		
++-		// Login as admin - indexes should be as follows
++-		$this->login();
++-		
++-		$this->admin_login();
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$this->assertContains('26', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('75', $crawler->filter('#relative_indexes')->text());
++-		//$this->assertContains('alalaalalalalala', $crawler->text());
++-		
++-		$this->logout();
++-	}
++-	public function test_search_one_sided_there()
++-	{
++-		$this->login();
++-		
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
++-		$form['keywords'] = 'second';
++-		
++-		
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContains('1', $crawler->filter('.pagination')->text());
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
++-		$form['keywords'] = 'private';
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContains('1', $crawler->filter('.pagination')->text());
++-		//$this->assertContains('alalaalalalalala', $crawler->text());
++-		$this->logout();
++-	}
++-	public function test_search_one_sided_gone()
++-	{
++-		$this->login('testuser1');
++-		
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
++-		$form['keywords'] = 'second';
++-		
++-		
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContainsLang('NO_RESULTS_FOUND', $crawler->text());
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
++-		$form['keywords'] = 'private';
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContains('1', $crawler->filter('.pagination')->text());
++-		//$this->assertContains('alalaalalalalala', $crawler->text());
++-		$this->logout();
++-	}
++-	public function test_delete_second_side_and_index()
++-	{
++-		$this->login();
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&folder=sentbox');
++-		
++-		$this->add_lang('ucp');
++-		$this->add_lang('mcp');
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=5');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=4');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=3');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=2');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$this->admin_login();
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		//test step 3 begins
++-		$this->assertContains('26', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
++-		
++-		$this->logout();
++-	}
++-	
++-	public function test_delete_indexes_of_unread_messages()
++-	{
++-		$this->login();
++-		
++-		$message_id = $this->create_private_message('Test private message 6', 'This should delete indexes of unread messages.', array($this->get_user_id('testuser1')));
++-		
++-		$this->admin_login();
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$this->assertContains('31', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('23', $crawler->filter('#relative_indexes')->text());
++-		
++-		$this->add_lang('ucp');
++-		$this->add_lang('mcp');
++-		
++-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-2&p=6');
++-		$form = $crawler->selectButton('Yes')->form();
++-		$crawler = self::submit($form);
++-		
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
++-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
++-		
++-		$this->assertContains('31', $crawler->filter('#indexed_words')->text());
++-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
++-		
++-		
++-		$this->logout();
++-	}
++-	/*public function test_permission()
++-	{
++-		$this->login();
++-		$this->admin_login();
++-		$this->add_lang('acp/permissions');
++-		
++-		// User permissions
++-		$crawler = self::request('GET', 'adm/index.php?i=acp_permissions&icat=16&mode=setting_user_global&sid=' . $this->sid);
++-		$this->assertContains($this->lang('ACP_USERS_PERMISSIONS_EXPLAIN'), $this->get_content());
++-
++-		// Select testuser1
++-		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
++-		$data = array('username[0]' => 'testuser1');
++-		$form->setValues($data);
++-		$crawler = self::submit($form);
++-		$this->assertContains($this->lang('ACL_SET'), $crawler->filter('h1')->eq(1)->text());
++-		
++-		$form = $crawler->selectButton($this->lang('APPLY_PERMISSIONS'))->form();
++-		$data = array(
++-			'setting'	=> array(
++-				$this->get_user_id('testuser1')	=> array(
++-					0	=> array(
++-						'u_pmsearch' => '0'
++-					)
++-				),
++-			),
++-		);
++-		$form->setValues($data);
++-		$crawler = self::submit($form);
++-		
++-		$this->assertContainsLang('AUTH_UPDATED', $crawler->filter('html')->text());
++-		
++-		$this->logout();
++-		
++-		$this->login('testuser1');
++-		
++-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
++-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
++-		
++-		$this->assertContainsLang('ACCESS_DENIED', $crawler->filter('html')->text());
++-		
++-		$this->logout();
++-	}*/
++-}
++-?>
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_base.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_base.php"
++deleted file mode 100644
++index 2da19b90b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/functional/pmsearch_base.php"
+++++ /dev/null
++@@ -1,37 +0,0 @@
++-<?php
++-/**
++-*
++-* PM Search
++-*
++-* @copyright (c) 2014 Stanislav Atanasov
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-namespace anavaro\pmsearch\tests\functional;
++-
++-/**
++-* @group functional
++-*/
++-class pmsearch_base extends \phpbb_functional_test_case
++-{
++-	static protected function setup_extensions()
++-	{
++-		return array('anavaro/pmsearch');
++-	}
++-
++-	public function setUp() : void
++-	{
++-		parent::setUp();
++-	}
++-
++-	public function get_user_id($username)
++-	{
++-		$sql = 'SELECT user_id, username
++-				FROM ' . USERS_TABLE . '
++-				WHERE username_clean = \''.$this->db->sql_escape(utf8_clean_string($username)).'\'';
++-		$result = $this->db->sql_query($sql);
++-		$row = $this->db->sql_fetchrow($result);
++-		return $row['user_id'];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/fixtures/fixture.xml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/fixtures/fixture.xml"
++deleted file mode 100644
++index 83fed2fec..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/fixtures/fixture.xml"
+++++ /dev/null
++@@ -1,75 +0,0 @@
++-<?xml version="1.0" encoding="UTF-8" ?>
++-<dataset>
++-    <table name="phpbb_config">
++-        <column>config_name</column>
++-        <column>config_value</column>
++-        <column>is_dynamic</column>
++-        <row>
++-            <value>phpbb_gallery_description_length</value>
++-            <value>2000</value>
++-            <value>0</value>
++-        </row>
++-        <row>
++-            <value>phpbb_gallery_allow_resize</value>
++-            <value>1</value>
++-            <value>0</value>
++-        </row>
++-        <row>
++-            <value>phpbb_gallery_link_thumbnail</value>
++-            <value>image_page</value>
++-            <value>0</value>
++-        </row>
++-    </table>
++-    <table name="phpbb_privmsgs">
++-        <column>msg_id</column>
++-        <column>author_id</column>
++-        <column>message_text</column>
++-        <column>to_address</column>
++-        <column>bcc_address</column>
++-        <row>
++-            <value>1</value>
++-            <value>2</value>
++-            <value>hahahhahahahaha</value>
++-            <value>u_5</value>
++-            <value>null</value>
++-        </row>
++-        <row>
++-            <value>2</value>
++-            <value>2</value>
++-            <value>hahahhahahahaha</value>
++-            <value>u_10</value>
++-            <value>null</value>
++-        </row>
++-        <row>
++-            <value>3</value>
++-            <value>10</value>
++-            <value>hahahhahahahaha</value>
++-            <value>u_2</value>
++-            <value>null</value>
++-        </row>
++-    </table>
++-    <table name="phpbb_privmsgs_to">
++-        <column>msg_id</column>
++-        <column>user_id</column>
++-        <row>
++-            <value>1</value>
++-            <value>2</value>
++-        </row>
++-        <row>
++-            <value>2</value>
++-            <value>2</value>
++-        </row>
++-        <row>
++-            <value>2</value>
++-            <value>10</value>
++-        </row>
++-        <row>
++-            <value>3</value>
++-            <value>10</value>
++-        </row>
++-        <row>
++-            <value>3</value>
++-            <value>2</value>
++-        </row>
++-    </table>
++-</dataset>
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/main_listener_test.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/main_listener_test.php"
++deleted file mode 100644
++index 2764b0e03..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/main_listener_test.php"
+++++ /dev/null
++@@ -1,102 +0,0 @@
++-<?php
++-/**
++- *
++- * phpBB PM Search events test
++- *
++- * @copyright (c) 2015 Lucifer <https://www.anavaro.com>
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-namespace anavaro\pmsearch\tests\search;
++-/**
++- * @group event
++- */
++-class main_event_test extends \phpbb_database_test_case
++-{
++-	protected $listener;
++-
++-	/**
++-	 * Define the extensions to be tested
++-	 *
++-	 * @return array vendor/name of extension(s) to test
++-	 */
++-	static protected function setup_extensions()
++-	{
++-		return array('anavaro/pmsearch');
++-	}
++-
++-	protected $db;
++-
++-	/**
++-	 * Get data set fixtures
++-	 */
++-	public function getDataSet()
++-	{
++-		return $this->createXMLDataSet(dirname(__FILE__) . '/fixtures/fixture.xml');
++-	}
++-
++-	/**
++-	 * Setup test environment
++-	 */
++-	public function setUp() : void
++-	{
++-		parent::setUp();
++-
++-		$this->template = $this->getMockBuilder('\phpbb\template\template')
++-			->getMock()
++-		;
++-		$this->config = new \phpbb\config\config(array());
++-		$this->db = $this->new_dbal();
++-		$this->search_helper = $this->getMockBuilder('\anavaro\pmsearch\helper')
++-			->disableOriginalConstructor()
++-			->getMock();
++-	}
++-
++-	/**
++-	 * Create our controller
++-	 */
++-	protected function set_listener()
++-	{
++-		$this->listener = new \anavaro\pmsearch\event\main_listener(
++-			$this->config,
++-			$this->db,
++-			$this->template,
++-			$this->search_helper
++-		);
++-	}
++-
++-	/**
++-	 * Test the event listener is subscribing events
++-	 */
++-	public function test_getSubscribedEvents()
++-	{
++-		$this->assertEquals(array(
++-			'core.permissions',
++-			'core.submit_pm_after',
++-			'core.delete_pm_before',
++-			'core.memberlist_view_profile'
++-		), array_keys(\anavaro\pmsearch\event\main_listener::getSubscribedEvents()));
++-	}
++-
++-	/**
++-	 * Test user_profile_galleries
++-	 */
++-	public function test_user_profile_galleries()
++-	{
++-		$member = array('user_id' => 2);
++-		$event_data = array('member');
++-		$event = new \phpbb\event\data(compact($event_data));
++-		$this->set_listener();
++-
++-		$this->template->expects($this->once())
++-			->method('assign_vars')
++-			->with(array(
++-				'S_SEARCH_WITH_USER'	=> true,
++-				'U_SEARCH_WITH_USER'	=> 'http://ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search&terms=nick&keywords=2'
++-			));
++-
++-		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
++-		$dispatcher->addListener('core.memberlist_view_profile', array($this->listener, 'pm_search_with_user'));
++-		$dispatcher->dispatch('core.memberlist_view_profile', $event);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/native_test.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/native_test.php"
++deleted file mode 100644
++index f68cc3c4d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/tests/search/native_test.php"
+++++ /dev/null
++@@ -1,79 +0,0 @@
++-<?php
++-/**
++- * native_test.php
++- * part of pmsearch
++- * Created by Stanislav Atanasov.
++- * Date: 8/5/19
++- * Time: 3:51 PM
++- *
++- * File description:
++- *
++- *
++- */
++-
++-namespace anavaro\pmsearch\tests\search;
++-
++-
++-require_once dirname(__FILE__) . '/../../../../../../tests/test_framework/phpbb_search_test_case.php';
++-/**
++- * @group search
++- */
++-
++-
++-class native_test extends \phpbb_search_test_case
++-{
++-	protected $db;
++-	protected $search;
++-	protected $user;
++-	/**
++-	 * Define the extensions to be tested
++-	 *
++-	 * @return array vendor/name of extension(s) to test
++-	 */
++-	static protected function setup_extensions()
++-	{
++-		return array('anavaro/pmsearch');
++-	}
++-	/**
++-	 * Get data set fixtures
++-	 */
++-	public function getDataSet()
++-	{
++-		return $this->createXMLDataSet(dirname(__FILE__) . '/fixtures/fixture.xml');
++-	}
++-
++-	protected function setUp() : void
++-	{
++-		global $phpbb_root_path, $phpEx, $config, $user, $cache;
++-		parent::setUp();
++-		// dbal uses cache
++-		$cache = new \phpbb_mock_cache();
++-		$this->db = $this->new_dbal();
++-		$phpbb_dispatcher = new \phpbb_mock_event_dispatcher();
++-		$error = null;
++-		$class = self::get_search_wrapper('\anavaro\pmsearch\search\pm_search_fulltext_native');
++-		if (PHP_VERSION_ID > 70399)
++-		{
++-			$errorlevel=error_reporting();
++-			error_reporting(0);
++-		}
++-		$user->data['user_id'] = 2;
++-		if (PHP_VERSION_ID > 70399)
++-		{
++-			error_reporting($errorlevel);
++-		}
++-		$this->search = new $class($error, $phpbb_root_path, $phpEx, null, $config, $this->db, $user, $phpbb_dispatcher);
++-	}
++-
++-	public function test_user_search()
++-	{
++-		$count = 0;
++-		$test_ary = array();
++-		$all_ids = $this->search->user_search('test', $test_ary, $count, 5);
++-		$this->assertEquals(false, $all_ids);
++-		$all_ids = $this->search->user_search(5, $test_ary, $count, 5);
++-		$this->assertEquals(1, $all_ids);
++-		$all_ids = $this->search->user_search(10, $test_ary, $count, 5);
++-		$this->assertEquals(2, $all_ids);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-covarage.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-covarage.sh"
++deleted file mode 100644
++index e3d22c36c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-covarage.sh"
+++++ /dev/null
++@@ -1,19 +0,0 @@
++-#!/bin/bash
++-#
++-# Collapsible Categories extension for the phpBB Forum Software package.
++-#
++-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
++-# @license GNU General Public License, version 2 (GPL-2.0)
++-#
++-set -e
++-set -x
++-
++-DB=$1
++-TRAVIS_PHP_VERSION=$2
++-EXTNAME=$3
++-
++-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
++-then
++-	sed -n '1h;1!H;${;g;s/<\/php>/<\/php>\n\t<filter>\n\t\t<whitelist>\n\t\t\t<directory>..\/<\/directory>\n\t\t\t<exclude>\n\t\t\t\t<directory>..\/tests\/<\/directory>\n\t\t\t\t<directory>..\/language\/<\/directory>\n\t\t\t\t<directory>..\/migrations\/<\/directory>\n\t\t\t<\/exclude>\n\t\t<\/whitelist>\n\t<\/filter>/g;p;}' phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml &> phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml.bak
++-	cp phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml.bak phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml
++-fi
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-epv.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-epv.sh"
++deleted file mode 100644
++index 51e91a8a5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-epv.sh"
+++++ /dev/null
++@@ -1,23 +0,0 @@
++-#!/bin/bash
++-#
++-# This file is part of the phpBB Forum Software package.
++-#
++-# @copyright (c) phpBB Limited <https://www.phpbb.com>
++-# @license GNU General Public License, version 2 (GPL-2.0)
++-#
++-# For full copyright and license information, please see
++-# the docs/CREDITS.txt file.
++-#
++-set -e
++-set -x
++-
++-EPV=$1
++-NOTESTS=$2
++-
++-if [ "$EPV" == "1" -a "$NOTESTS" == "1" ]
++-then
++-	cd phpBB
++-	composer remove sami/sami --update-with-dependencies --dev --no-interaction
++-	composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs
++-	cd ../
++-fi
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-phpbb.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-phpbb.sh"
++deleted file mode 100644
++index 01770ad6e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/prepare-phpbb.sh"
+++++ /dev/null
++@@ -1,24 +0,0 @@
++-#!/bin/bash
++-#
++-# This file is part of the phpBB Forum Software package.
++-#
++-# @copyright (c) phpBB Limited <https://www.phpbb.com>
++-# @license GNU General Public License, version 2 (GPL-2.0)
++-#
++-# For full copyright and license information, please see
++-# the docs/CREDITS.txt file.
++-#
++-set -e
++-set -x
++-
++-EXTNAME=$1
++-BRANCH=$2
++-EXTPATH_TEMP=$3
++-
++-# Copy extension to a temp folder
++-mkdir ../../tmp
++-cp -R . ../../tmp
++-cd ../../
++-
++-# Clone phpBB
++-git clone --depth=1 "git://github.com/phpbb/phpbb.git" "phpBB3" --branch=$BRANCH
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/run-tests.sh" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/run-tests.sh"
++deleted file mode 100644
++index 89eaaf468..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\anavaro\\pmsearch/travis/run-tests.sh"
+++++ /dev/null
++@@ -1,20 +0,0 @@
++-#!/bin/bash
++-#
++-# Collapsible Categories extension for the phpBB Forum Software package.
++-#
++-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
++-# @license GNU General Public License, version 2 (GPL-2.0)
++-#
++-set -e
++-set -x
++-
++-DB=$1
++-TRAVIS_PHP_VERSION=$2
++-EXTNAME=$3
++-
++-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
++-then
++-	phpBB/vendor/bin/phpunit --configuration phpBB/ext/"$EXTNAME"/travis/phpunit-"$DB"-travis.xml --bootstrap ./tests/bootstrap.php --coverage-clover build/logs/clover.xml
++-else
++-	phpBB/vendor/bin/phpunit --configuration phpBB/ext/"$EXTNAME"/travis/phpunit-"$DB"-travis.xml --bootstrap ./tests/bootstrap.php
++-fi
++
\ No newline at end of file
diff --git "[ORIGINAL]/anavaro\\pmsearch/event/main_listener.php" "[FORUM_EXT]/anavaro\\pmsearch/event/main_listener.php"
--- "[ORIGINAL]/anavaro\\pmsearch/event/main_listener.php"
+++ "[FORUM_EXT]/anavaro\\pmsearch/event/main_listener.php"
@@ -133,7 +133,7 @@ class main_listener implements EventSubscriberInterface
 	public function pm_search_with_user($event)
 	{
 		$target = $event['member']['user_id'];
-		$url = generate_board_url() . '/ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search&terms=nick&keywords=' . $target;
+		$url = generate_board_url() . '/ucp.php?i=-anavaro-pmsearch-ucp-ucp_pmsearch_module&mode=search&terms=nick&keywords=' . $target;
 		$this->template->assign_vars(array(
 			'S_SEARCH_WITH_USER'	=> true,
 			'U_SEARCH_WITH_USER'	=> $url
diff --git "[FORUM_EXT]/anavaro\\pmsearch/language/pt/info_acp_pmsearch.php" "[FORUM_EXT]/anavaro\\pmsearch/language/pt/info_acp_pmsearch.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/language/pt/info_acp_pmsearch.php"
@@ -0,0 +1,70 @@
+<?php
+/**
+*
+* PM Search extension for the phpBB Forum Software package.
+* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+*
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
+	// ACP general langauge
+	'ACP_PMSEARCH_GRP'	=> 'Pesquisa em MPs',
+	'ACP_PRVOPT'	=> 'Configurações',
+
+	//ACP PM Admin Settings page
+	'PMSEARCH_ADMIN'	=> 'Pesquisa em MPs',
+	'PMSEARCH_ADMIN_EXPLAIN'	=> 'A partir daqui, podes definir algumas das opções relacionadas à pesquisa de utilizadores em MPs.',
+	'PMSEARCH_SETTINGS'	=> 'Opções',
+	'PMSEARCH_PM_INDEX'	=> 'Índice de MP',
+	'PMSEARCH_PM_INDEX_EXPLAIN'	=> 'A partir daqui, podes permitir a indexação<br /><b>(Aviso! A pesquisa não funcionará se não tiveres indexação)</b>.',
+	'PMSEARCH_PM_SEARCH'	=>	'Permitir pesquisa',
+	'PMSEARCH_PM_SEARCH_EXPLAIN'	=> 'Permitir globalmente (ou negar) pesquisa em MPs.',
+	'DELETE_INDEX'	=> 'Apagar índices',
+	'CREATE_INDEX'	=> 'Criar índices',
+
+	//ACP ACL
+	'ACL_U_PMSEARCH'	=> 'O utilizador pode pesquisar em MPs',
+
+	//Other ACP
+	'LOG_PMSEARCH_INDEX_REMOVED'	=> '<strong>Índice de pesquisa removido por </strong><br />» %s',
+	'LOG_PMSEARCH_INDEX_CREATED'	=> '<strong>Índice de pesquisa criado por </strong><br />» %s',
+	'TOTAL_WORDS'							=> 'Total de palavras indexadas',
+	'TOTAL_MATCHES'							=> 'Contagem total de relações de palavras',
+	'SEARCH_INDEX_CREATE_REDIRECT'			=> array(
+		2	=> 'Todas as mensagens até à mensagem com id %2$d foram indexadas, das quais %1$d mensagens estavam dentro desta etapa.<br />',
+	),
+	'SEARCH_INDEX_CREATE_REDIRECT_RATE'		=> array(
+		2	=> 'A taxa atual de indexação é aproximadamente %1$.1f mensagens por segundo.<br />Indexação em andamento...',
+	),
+));
diff --git "[FORUM_EXT]/anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php" "[FORUM_EXT]/anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/language/pt/info_ucp_pmsearch.php"
@@ -0,0 +1,53 @@
+<?php
+/**
+*
+* PM Search extension for the phpBB Forum Software package.
+* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+*
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
+	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
+	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
+	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
+	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
+	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
+	'SEARCH_PMS'	=> 'Pesquisar MPs',
+	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',
+
+	// Added in version 1.0.1
+	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
+	'SEARCH_WITH_USER'	=> 'Mensagens Privadas',
+	'SEARCH_WITH_USER_LANG'	=> 'Ver MPs com este utilizador',
+));
diff --git "[FORUM_EXT]/anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php" "[FORUM_EXT]/anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/language/pt_preao/info_acp_pmsearch.php"
@@ -0,0 +1,70 @@
+<?php
+/**
+*
+* PM Search extension for the phpBB Forum Software package.
+* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+*
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
+	// ACP general langauge
+	'ACP_PMSEARCH_GRP'	=> 'Pesquisa em MPs',
+	'ACP_PRVOPT'	=> 'Configurações',
+
+	//ACP PM Admin Settings page
+	'PMSEARCH_ADMIN'	=> 'Pesquisa em MPs',
+	'PMSEARCH_ADMIN_EXPLAIN'	=> 'A partir daqui, podes definir algumas das opções relacionadas à pesquisa de utilizadores em MPs.',
+	'PMSEARCH_SETTINGS'	=> 'Opções',
+	'PMSEARCH_PM_INDEX'	=> 'Índice de MP',
+	'PMSEARCH_PM_INDEX_EXPLAIN'	=> 'A partir daqui, podes permitir a indexação<br /><b>(Aviso! A pesquisa não funcionará se não tiveres indexação)</b>.',
+	'PMSEARCH_PM_SEARCH'	=>	'Permitir pesquisa',
+	'PMSEARCH_PM_SEARCH_EXPLAIN'	=> 'Permitir globalmente (ou negar) pesquisa em MPs.',
+	'DELETE_INDEX'	=> 'Apagar índices',
+	'CREATE_INDEX'	=> 'Criar índices',
+
+	//ACP ACL
+	'ACL_U_PMSEARCH'	=> 'O utilizador pode pesquisar em MPs',
+
+	//Other ACP
+	'LOG_PMSEARCH_INDEX_REMOVED'	=> '<strong>Índice de pesquisa removido por </strong><br />» %s',
+	'LOG_PMSEARCH_INDEX_CREATED'	=> '<strong>Índice de pesquisa criado por </strong><br />» %s',
+	'TOTAL_WORDS'							=> 'Total de palavras indexadas',
+	'TOTAL_MATCHES'							=> 'Contagem total de relações de palavras',
+	'SEARCH_INDEX_CREATE_REDIRECT'			=> array(
+		2	=> 'Todas as mensagens até à mensagem com id %2$d foram indexadas, das quais %1$d mensagens estavam dentro desta etapa.<br />',
+	),
+	'SEARCH_INDEX_CREATE_REDIRECT_RATE'		=> array(
+		2	=> 'A taxa actual de indexação é aproximadamente %1$.1f mensagens por segundo.<br />Indexação em andamento...',
+	),
+));
diff --git "[FORUM_EXT]/anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php" "[FORUM_EXT]/anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/language/pt_preao/info_ucp_pmsearch.php"
@@ -0,0 +1,53 @@
+<?php
+/**
+*
+* PM Search extension for the phpBB Forum Software package.
+* Brazilian Portuguese translation by eunaumtenhoid (c) 2017 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+*
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
+	'PMSEARCH_TITLE'	=> 'Pesquise em MPs',
+	'PMSEARCH_KEYWORDS_EXPLAIN'	=>	'Coloque + em frente da palavra que deve ser encontrada e - em frente da palavra que não deve ser encontrada. Coloca uma lista de palavras separadas por | entre parênteses se apenas uma dessas deve ser encontrada. Use * para pesquisas parciais.',
+	'SEARCH_ALL_TERMS'	=>	' Procura todos os termos ou usa a consulta como inserida',
+	'SEARCH_ANY_TERMS'	=>	'Procura por quaisquer termos',
+	'NO_RESULTS_FOUND'	=> 'Nenhum resultado encontrado.',
+	'SEARCH_PMS'	=> 'Pesquisar MPs',
+	'ACCESS_DENIED'	=> 'Não tem permissões para pesquisar em MPs',
+
+	// Added in version 1.0.1
+	'SEARCH_FOR_NICK'	=> 'Pesquisar com nome de utilizador',
+	'SEARCH_WITH_USER'	=> 'Pesquisar',
+	'SEARCH_WITH_USER_LANG'	=> 'Mostrar conversas com este utilizador',
+));
diff --git "[ORIGINAL]/anavaro\\pmsearch/phpunit.xml.dist" "[ORIGINAL]/anavaro\\pmsearch/phpunit.xml.dist"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/phpunit.xml.dist"
+++ /dev/null
@@ -1,34 +0,0 @@
-<?xml version="1.0" encoding="UTF-8"?>
-
-<phpunit backupGlobals="true"
-		 backupStaticAttributes="true"
-		 colors="true"
-		 convertErrorsToExceptions="true"
-		 convertNoticesToExceptions="true"
-		 convertWarningsToExceptions="true"
-		 processIsolation="false"
-		 stopOnFailure="false"
-		 verbose="true"
-		 bootstrap="../../../../tests/bootstrap.php"
->
-	<testsuites>
-		<testsuite name="Extension Test Suite">
-			<directory suffix="_test.php">./tests</directory>
-			<exclude>./tests/functional</exclude>
-		</testsuite>
-		<testsuite name="Extension Functional Tests">
-			<directory suffix="_test.php">./tests/functional/</directory>
-		</testsuite>
-	</testsuites>
-
-	<filter>
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
diff --git "[ORIGINAL]/anavaro\\pmsearch/search/pm_search_fulltext_native.php" "[FORUM_EXT]/anavaro\\pmsearch/search/pm_search_fulltext_native.php"
--- "[ORIGINAL]/anavaro\\pmsearch/search/pm_search_fulltext_native.php"
+++ "[FORUM_EXT]/anavaro\\pmsearch/search/pm_search_fulltext_native.php"
@@ -644,7 +644,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
 					$sql = (!$sql) ? $this->db->sql_build_query('SELECT', $sql_array_count) : $sql;
 
 					$result = $this->db->sql_query($sql);
-					$total_results = (int) $this->db->sql_fetchfield('total_results');
+					$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
 					$this->db->sql_freeresult($result);
 
 					if (!$total_results)
@@ -691,7 +691,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
 			// Get the number of results as calculated by MySQL
 			$sql_count = 'SELECT FOUND_ROWS() as total_results';
 			$result = $this->db->sql_query($sql_count);
-			$total_results = (int) $this->db->sql_fetchfield('total_results');
+			$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
 			$this->db->sql_freeresult($result);
 			if (!$total_results)
 			{
@@ -1141,7 +1141,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
 					$sql = (!$sql) ? $this->db->sql_build_query('SELECT', $sql_array_count) : $sql;
 
 					$result = $this->db->sql_query($sql);
-					$total_results = (int) $this->db->sql_fetchfield('total_results');
+					$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
 					$this->db->sql_freeresult($result);
 
 					if (!$total_results)
@@ -1177,7 +1177,7 @@ class pm_search_fulltext_native extends \phpbb\search\fulltext_native
 			// Get the number of results as calculated by MySQL
 			$sql_count = 'SELECT FOUND_ROWS() as total_results';
 			$result = $this->db->sql_query($sql_count);
-			$total_results = (int) $this->db->sql_fetchfield('total_results');
+			$total_results = (int) $this->db->sql_fetchfield('total_results')+1;
 			$this->db->sql_freeresult($result);
 
 			if (!$total_results)
diff --git "[FORUM_EXT]/anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html" "[FORUM_EXT]/anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/anavaro\\pmsearch/styles/FLATBOOTS/template/ucp_pmsearch.html"
@@ -0,0 +1,98 @@
+<!-- INCLUDE ucp_header.html -->
+<form id="ucp" method="post" action="{S_UCP_ACTION}"{S_FORM_ENCTYPE}>
+<div class="well">
+	<h3>{L_PMSEARCH_TITLE}</h3>
+	<fieldset>
+		<div class="form-group">
+			 <label class="control-label" for="keywords">{L_SEARCH_KEYWORDS}{L_COLON}</label><span class="help-block">{L_PMSEARCH_KEYWORDS_EXPLAIN}</span>
+			  <div class="input-group">
+				<span class="input-group-addon"><i class="fa fa-search"></i></span>
+				<input class="form-control input-sm" type="text" placeholder="{L_SEARCH_USR_PLACEHOLDER}" name="keywords" id="keywords" title="{L_SEARCH_KEYWORDS}" value="{S_KEYWORDS}"/>
+			  </div> 
+		</div>
+		<div class="form-group">
+			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 1 -->checked="checked" <!-- ENDIF -->name="terms" id="terms1" value="all"><label class="checkbox-inline" for="terms1">{L_SEARCH_ALL_TERMS}</label>
+			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 2 -->checked="checked" <!-- ENDIF -->name="terms" id="terms2" value="any"><label class="checkbox-inline" for="terms2">{L_SEARCH_ANY_TERMS}</label>
+			<input type="radio" <!-- IF SEARCH_TEARM_TYPE == 3 -->checked="checked" <!-- ENDIF -->name="terms" id="terms3" value="nick"><label class="checkbox-inline" for="terms3">{L_SEARCH_FOR_NICK}</label>
+			<div class="control-group"></div>
+		</div>
+	</fieldset>
+	<fieldset class="submit-buttons">
+		{S_HIDDEN_FIELDS}<input type="reset" value="{L_RESET}" name="reset" class="btn btn-default" />&nbsp;
+		<input type="submit" name="submit" value="{L_SEARCH_PMS}" class="btn btn-default" />
+	</fieldset>
+</div>
+</form>
+<!-- IF HAS_RESULTS -->
+<div class="panel">
+	<div class="inner">
+		<div class="row">
+			<div class="col-md-12 text-right">
+				<div class="clearfix"> 
+					<div class="pagination">
+							<li class="active"><a>{TOTAL_MESSAGES}</a></li>
+							<!-- IF .pagination -->
+								<!-- INCLUDE pagination.html -->
+							<!-- ELSE -->
+								 <li class="active"><a>{PAGE_NUMBER}</a></li>
+							<!-- ENDIF -->
+					</div>
+				</div>
+			</div>
+		</div>
+		<div class="panel panel-forum">
+			<div class="panel-heading">
+				<i class="fa fa-bolt"></i>&nbsp;{L_MESSAGE}
+			</div>
+			<div class="panel-inner">
+				<table class="footable table table-striped table-primary table-hover">
+					<thead>
+						<tr>
+							<th data-class="expand">{L_TITLE}</th>
+							<th class="large10" data-hide="phone">{L_LAST_POST}</th>
+						</tr>
+					</thead>
+					<tbody>
+						<!--<ul class="topiclist cplist pmlist responsive-show-all <!-- IF S_SHOW_RECIPIENTS -->missing-column<!-- ELSE -->two-columns<!-- ENDIF -->">-->
+						<!-- BEGIN pm_results -->
+						<tr>
+							<td>
+							<span class="desc-wrapper">
+								<div class="row<!-- IF pm_results.S_ROW_COUNT is odd --> bg1<!-- ELSE --> bg2<!-- ENDIF --><!-- IF pm_results.PM_CLASS --> {pm_results.PM_CLASS}<!-- ENDIF -->">
+									<div class="row-item {pm_results.FOLDER_IMG_STYLE}">
+										<div<!-- IF pm_results.PM_ICON_URL and S_PM_ICONS --> style="background-image: url({pm_results.PM_ICON_URL}); background-repeat: no-repeat;"<!-- ENDIF -->>
+											<!-- IF pm_results.S_PM_UNREAD --><a href="{pm_results.U_VIEW_PM}" class="icon-link"></a><!-- ENDIF -->
+											<div class="list-inner">
+												<a href="{pm_results.U_VIEW_PM}" class="topictitle">{pm_results.SUBJECT}</a><br />
+												
+											</div>
+										</div>
+									</div>
+								</div>
+							</td>
+							<td class="center">{L_MESSAGE_BY_AUTHOR} {pm_results.MESSAGE_AUTHOR_FULL} &raquo; {pm_results.SENT_TIME}</td>
+						</tr>
+						<!-- END pm_results -->
+					</tbody>
+				</table>
+			</div>
+		</div>
+		<div class="row">
+			<div class="col-md-12 text-right">
+				<div class="clearfix"> 
+					<div class="pagination">
+						<li class="active"><a>{TOTAL_MESSAGES}</a></li>
+						<!-- IF .pagination -->
+							<!-- INCLUDE pagination.html -->
+						<!-- ELSE -->
+							 <li class="active"><a>{PAGE_NUMBER}</a></li>
+						<!-- ENDIF -->
+					</div>
+				</div>
+			</div>
+		</div>
+	</div>
+</div>
+
+<!-- ENDIF -->
+<!-- INCLUDE ucp_footer.html -->
\ No newline at end of file
diff --git "[ORIGINAL]/anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html" "[FORUM_EXT]/anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
--- "[ORIGINAL]/anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
+++ "[FORUM_EXT]/anavaro\\pmsearch/styles/all/template/event/memberlist_view_user_statistics_after.html"
@@ -1 +1,5 @@
-<dt>{L_SEARCH_WITH_USER}{L_COLON}</dt> <dd><strong><a href="{U_SEARCH_WITH_USER}" target="_blank">{L_SEARCH_WITH_USER_LANG}</a></strong></dd>
+<li>
+<span class="fa fa-envelope"></span>
+<label>{L_SEARCH_WITH_USER}</label>
+<a href="{U_SEARCH_WITH_USER}" target="_blank">{L_SEARCH_WITH_USER_LANG}</a>
+</li>
\ No newline at end of file
diff --git "[ORIGINAL]/anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php" "[ORIGINAL]/anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/tests/functional/pmsearch_acp_test.php"
+++ /dev/null
@@ -1,315 +0,0 @@
-<?php
-/**
-*
-* PM Search
-*
-* @copyright (c) 2014 Stanislav Atanasov
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-namespace anavaro\pmsearch\tests\functional;
-
-/**
-* @group functional
-*/
-class pmsearch_acp_test extends pmsearch_base
-{
-	public function test_install()
-	{
-		//add users so we can send messages and search
-		$this->create_user('testuser1');
-		$this->add_user_group('REGISTERED', array('testuser1'));
-		
-		$this->login();
-		$this->admin_login();
-		
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$this->assertContainsLang('PMSEARCH_ADMIN', $crawler->text());
-		
-		$this->logout();
-	}
-	public function test_event_auto_index()
-	{
-		$this->login();
-		$message_id = $this->create_private_message('Test private message', 'This test private message sent testing framework. need check event indexing.', array($this->get_user_id('testuser1')));
-		
-		$this->admin_login();
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$this->assertContains('11', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
-		
-		$this->logout();
-	}
-	
-	public function test_acp_delete_index()
-	{
-		$this->login();
-		$this->admin_login();
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$form = $crawler->selectButton($this->lang('DELETE_INDEX'))->form();
-		$crawler = self::submit($form);
-		
-		//test step 3 begins
-		$this->assertContains('0', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('0', $crawler->filter('#relative_indexes')->text());
-		
-		$this->logout();
-	}
-	public function test_acp_build_index()
-	{
-		$this->login();
-		$this->admin_login();
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$form = $crawler->selectButton($this->lang('CREATE_INDEX'))->form();
-		$crawler = self::submit($form);
-		
-		//test step 3 begins
-		$this->assertContains('11', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
-		
-		$this->logout();
-	}
-	public function test_search()
-	{
-		$this->login();
-		$message_id = $this->create_private_message('Test PM', 'This test PM will not contain words that stand for pm, so we can search for them.', array($this->get_user_id('testuser1')));
-		$message_id = $this->create_private_message('Test PM 1', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the second pm', array($this->get_user_id('testuser1')));
-		$message_id = $this->create_private_message('Test PM 3', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the third pm', array($this->get_user_id('testuser1')));
-		$message_id = $this->create_private_message('Test PM 4', 'This test PM will not contain words that stand for pm, so we can search for them. And it is the fourth pm', array($this->get_user_id('testuser1')));
-		
-		$this->logout();
-		
-		//get user to log in
-		$this->login('testuser1');
-		
-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
-		$form['keywords'] = 'Test';
-		
-		
-		$crawler = self::submit($form);
-		
-		$this->assertContains('5', $crawler->filter('.pagination')->text());
-		
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
-		$form['keywords'] = 'private';
-		$crawler = self::submit($form);
-		
-		$this->assertContains('1', $crawler->filter('.pagination')->text());
-		//$this->assertContains('alalaalalalalala', $crawler->text());
-		$this->logout();
-	}
-	public function test_remove_pm_one_way()
-	{
-		// Log in as user and delete some mssages
-		$this->login('testuser1');
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&folder=inbox');
-		
-		$this->add_lang('ucp');
-		$this->add_lang('mcp');
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=5');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=4');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=3');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=0&p=2');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$this->logout();
-		
-		// Login as admin - indexes should be as follows
-		$this->login();
-		
-		$this->admin_login();
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$this->assertContains('26', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('75', $crawler->filter('#relative_indexes')->text());
-		//$this->assertContains('alalaalalalalala', $crawler->text());
-		
-		$this->logout();
-	}
-	public function test_search_one_sided_there()
-	{
-		$this->login();
-		
-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
-		$form['keywords'] = 'second';
-		
-		
-		$crawler = self::submit($form);
-		
-		$this->assertContains('1', $crawler->filter('.pagination')->text());
-		
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
-		$form['keywords'] = 'private';
-		$crawler = self::submit($form);
-		
-		$this->assertContains('1', $crawler->filter('.pagination')->text());
-		//$this->assertContains('alalaalalalalala', $crawler->text());
-		$this->logout();
-	}
-	public function test_search_one_sided_gone()
-	{
-		$this->login('testuser1');
-		
-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
-		$form['keywords'] = 'second';
-		
-		
-		$crawler = self::submit($form);
-		
-		$this->assertContainsLang('NO_RESULTS_FOUND', $crawler->text());
-		
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$form = $crawler->selectButton($this->lang('SEARCH_PMS'))->form();
-		$form['keywords'] = 'private';
-		$crawler = self::submit($form);
-		
-		$this->assertContains('1', $crawler->filter('.pagination')->text());
-		//$this->assertContains('alalaalalalalala', $crawler->text());
-		$this->logout();
-	}
-	public function test_delete_second_side_and_index()
-	{
-		$this->login();
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&folder=sentbox');
-		
-		$this->add_lang('ucp');
-		$this->add_lang('mcp');
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=5');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=4');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=3');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-1&p=2');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$this->admin_login();
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		//test step 3 begins
-		$this->assertContains('26', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
-		
-		$this->logout();
-	}
-	
-	public function test_delete_indexes_of_unread_messages()
-	{
-		$this->login();
-		
-		$message_id = $this->create_private_message('Test private message 6', 'This should delete indexes of unread messages.', array($this->get_user_id('testuser1')));
-		
-		$this->admin_login();
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$this->assertContains('31', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('23', $crawler->filter('#relative_indexes')->text());
-		
-		$this->add_lang('ucp');
-		$this->add_lang('mcp');
-		
-		$crawler = self::request('GET', 'ucp.php?i=pm&mode=compose&action=delete&f=-2&p=6');
-		$form = $crawler->selectButton('Yes')->form();
-		$crawler = self::submit($form);
-		
-		$this->add_lang_ext('anavaro/pmsearch', 'info_acp_pmsearch');
-		$crawler = self::request('GET', 'adm/index.php?i=-anavaro-pmsearch-acp-acp_pmsearch_module&mode=main&sid=' . $this->sid);
-		
-		$this->assertContains('31', $crawler->filter('#indexed_words')->text());
-		$this->assertContains('14', $crawler->filter('#relative_indexes')->text());
-		
-		
-		$this->logout();
-	}
-	/*public function test_permission()
-	{
-		$this->login();
-		$this->admin_login();
-		$this->add_lang('acp/permissions');
-		
-		// User permissions
-		$crawler = self::request('GET', 'adm/index.php?i=acp_permissions&icat=16&mode=setting_user_global&sid=' . $this->sid);
-		$this->assertContains($this->lang('ACP_USERS_PERMISSIONS_EXPLAIN'), $this->get_content());
-
-		// Select testuser1
-		$form = $crawler->selectButton($this->lang('SUBMIT'))->form();
-		$data = array('username[0]' => 'testuser1');
-		$form->setValues($data);
-		$crawler = self::submit($form);
-		$this->assertContains($this->lang('ACL_SET'), $crawler->filter('h1')->eq(1)->text());
-		
-		$form = $crawler->selectButton($this->lang('APPLY_PERMISSIONS'))->form();
-		$data = array(
-			'setting'	=> array(
-				$this->get_user_id('testuser1')	=> array(
-					0	=> array(
-						'u_pmsearch' => '0'
-					)
-				),
-			),
-		);
-		$form->setValues($data);
-		$crawler = self::submit($form);
-		
-		$this->assertContainsLang('AUTH_UPDATED', $crawler->filter('html')->text());
-		
-		$this->logout();
-		
-		$this->login('testuser1');
-		
-		$this->add_lang_ext('anavaro/pmsearch', 'info_ucp_pmsearch');
-		$crawler = self::request('GET', 'ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search');
-		
-		$this->assertContainsLang('ACCESS_DENIED', $crawler->filter('html')->text());
-		
-		$this->logout();
-	}*/
-}
-?>
\ No newline at end of file
diff --git "[ORIGINAL]/anavaro\\pmsearch/tests/functional/pmsearch_base.php" "[ORIGINAL]/anavaro\\pmsearch/tests/functional/pmsearch_base.php"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/tests/functional/pmsearch_base.php"
+++ /dev/null
@@ -1,37 +0,0 @@
-<?php
-/**
-*
-* PM Search
-*
-* @copyright (c) 2014 Stanislav Atanasov
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-namespace anavaro\pmsearch\tests\functional;
-
-/**
-* @group functional
-*/
-class pmsearch_base extends \phpbb_functional_test_case
-{
-	static protected function setup_extensions()
-	{
-		return array('anavaro/pmsearch');
-	}
-
-	public function setUp() : void
-	{
-		parent::setUp();
-	}
-
-	public function get_user_id($username)
-	{
-		$sql = 'SELECT user_id, username
-				FROM ' . USERS_TABLE . '
-				WHERE username_clean = \''.$this->db->sql_escape(utf8_clean_string($username)).'\'';
-		$result = $this->db->sql_query($sql);
-		$row = $this->db->sql_fetchrow($result);
-		return $row['user_id'];
-	}
-}
diff --git "[ORIGINAL]/anavaro\\pmsearch/tests/search/fixtures/fixture.xml" "[ORIGINAL]/anavaro\\pmsearch/tests/search/fixtures/fixture.xml"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/tests/search/fixtures/fixture.xml"
+++ /dev/null
@@ -1,75 +0,0 @@
-<?xml version="1.0" encoding="UTF-8" ?>
-<dataset>
-    <table name="phpbb_config">
-        <column>config_name</column>
-        <column>config_value</column>
-        <column>is_dynamic</column>
-        <row>
-            <value>phpbb_gallery_description_length</value>
-            <value>2000</value>
-            <value>0</value>
-        </row>
-        <row>
-            <value>phpbb_gallery_allow_resize</value>
-            <value>1</value>
-            <value>0</value>
-        </row>
-        <row>
-            <value>phpbb_gallery_link_thumbnail</value>
-            <value>image_page</value>
-            <value>0</value>
-        </row>
-    </table>
-    <table name="phpbb_privmsgs">
-        <column>msg_id</column>
-        <column>author_id</column>
-        <column>message_text</column>
-        <column>to_address</column>
-        <column>bcc_address</column>
-        <row>
-            <value>1</value>
-            <value>2</value>
-            <value>hahahhahahahaha</value>
-            <value>u_5</value>
-            <value>null</value>
-        </row>
-        <row>
-            <value>2</value>
-            <value>2</value>
-            <value>hahahhahahahaha</value>
-            <value>u_10</value>
-            <value>null</value>
-        </row>
-        <row>
-            <value>3</value>
-            <value>10</value>
-            <value>hahahhahahahaha</value>
-            <value>u_2</value>
-            <value>null</value>
-        </row>
-    </table>
-    <table name="phpbb_privmsgs_to">
-        <column>msg_id</column>
-        <column>user_id</column>
-        <row>
-            <value>1</value>
-            <value>2</value>
-        </row>
-        <row>
-            <value>2</value>
-            <value>2</value>
-        </row>
-        <row>
-            <value>2</value>
-            <value>10</value>
-        </row>
-        <row>
-            <value>3</value>
-            <value>10</value>
-        </row>
-        <row>
-            <value>3</value>
-            <value>2</value>
-        </row>
-    </table>
-</dataset>
\ No newline at end of file
diff --git "[ORIGINAL]/anavaro\\pmsearch/tests/search/main_listener_test.php" "[ORIGINAL]/anavaro\\pmsearch/tests/search/main_listener_test.php"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/tests/search/main_listener_test.php"
+++ /dev/null
@@ -1,102 +0,0 @@
-<?php
-/**
- *
- * phpBB PM Search events test
- *
- * @copyright (c) 2015 Lucifer <https://www.anavaro.com>
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-namespace anavaro\pmsearch\tests\search;
-/**
- * @group event
- */
-class main_event_test extends \phpbb_database_test_case
-{
-	protected $listener;
-
-	/**
-	 * Define the extensions to be tested
-	 *
-	 * @return array vendor/name of extension(s) to test
-	 */
-	static protected function setup_extensions()
-	{
-		return array('anavaro/pmsearch');
-	}
-
-	protected $db;
-
-	/**
-	 * Get data set fixtures
-	 */
-	public function getDataSet()
-	{
-		return $this->createXMLDataSet(dirname(__FILE__) . '/fixtures/fixture.xml');
-	}
-
-	/**
-	 * Setup test environment
-	 */
-	public function setUp() : void
-	{
-		parent::setUp();
-
-		$this->template = $this->getMockBuilder('\phpbb\template\template')
-			->getMock()
-		;
-		$this->config = new \phpbb\config\config(array());
-		$this->db = $this->new_dbal();
-		$this->search_helper = $this->getMockBuilder('\anavaro\pmsearch\helper')
-			->disableOriginalConstructor()
-			->getMock();
-	}
-
-	/**
-	 * Create our controller
-	 */
-	protected function set_listener()
-	{
-		$this->listener = new \anavaro\pmsearch\event\main_listener(
-			$this->config,
-			$this->db,
-			$this->template,
-			$this->search_helper
-		);
-	}
-
-	/**
-	 * Test the event listener is subscribing events
-	 */
-	public function test_getSubscribedEvents()
-	{
-		$this->assertEquals(array(
-			'core.permissions',
-			'core.submit_pm_after',
-			'core.delete_pm_before',
-			'core.memberlist_view_profile'
-		), array_keys(\anavaro\pmsearch\event\main_listener::getSubscribedEvents()));
-	}
-
-	/**
-	 * Test user_profile_galleries
-	 */
-	public function test_user_profile_galleries()
-	{
-		$member = array('user_id' => 2);
-		$event_data = array('member');
-		$event = new \phpbb\event\data(compact($event_data));
-		$this->set_listener();
-
-		$this->template->expects($this->once())
-			->method('assign_vars')
-			->with(array(
-				'S_SEARCH_WITH_USER'	=> true,
-				'U_SEARCH_WITH_USER'	=> 'http://ucp.php?i=\anavaro\pmsearch\ucp\ucp_pmsearch_module&mode=search&terms=nick&keywords=2'
-			));
-
-		$dispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
-		$dispatcher->addListener('core.memberlist_view_profile', array($this->listener, 'pm_search_with_user'));
-		$dispatcher->dispatch('core.memberlist_view_profile', $event);
-	}
-}
diff --git "[ORIGINAL]/anavaro\\pmsearch/tests/search/native_test.php" "[ORIGINAL]/anavaro\\pmsearch/tests/search/native_test.php"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/tests/search/native_test.php"
+++ /dev/null
@@ -1,79 +0,0 @@
-<?php
-/**
- * native_test.php
- * part of pmsearch
- * Created by Stanislav Atanasov.
- * Date: 8/5/19
- * Time: 3:51 PM
- *
- * File description:
- *
- *
- */
-
-namespace anavaro\pmsearch\tests\search;
-
-
-require_once dirname(__FILE__) . '/../../../../../../tests/test_framework/phpbb_search_test_case.php';
-/**
- * @group search
- */
-
-
-class native_test extends \phpbb_search_test_case
-{
-	protected $db;
-	protected $search;
-	protected $user;
-	/**
-	 * Define the extensions to be tested
-	 *
-	 * @return array vendor/name of extension(s) to test
-	 */
-	static protected function setup_extensions()
-	{
-		return array('anavaro/pmsearch');
-	}
-	/**
-	 * Get data set fixtures
-	 */
-	public function getDataSet()
-	{
-		return $this->createXMLDataSet(dirname(__FILE__) . '/fixtures/fixture.xml');
-	}
-
-	protected function setUp() : void
-	{
-		global $phpbb_root_path, $phpEx, $config, $user, $cache;
-		parent::setUp();
-		// dbal uses cache
-		$cache = new \phpbb_mock_cache();
-		$this->db = $this->new_dbal();
-		$phpbb_dispatcher = new \phpbb_mock_event_dispatcher();
-		$error = null;
-		$class = self::get_search_wrapper('\anavaro\pmsearch\search\pm_search_fulltext_native');
-		if (PHP_VERSION_ID > 70399)
-		{
-			$errorlevel=error_reporting();
-			error_reporting(0);
-		}
-		$user->data['user_id'] = 2;
-		if (PHP_VERSION_ID > 70399)
-		{
-			error_reporting($errorlevel);
-		}
-		$this->search = new $class($error, $phpbb_root_path, $phpEx, null, $config, $this->db, $user, $phpbb_dispatcher);
-	}
-
-	public function test_user_search()
-	{
-		$count = 0;
-		$test_ary = array();
-		$all_ids = $this->search->user_search('test', $test_ary, $count, 5);
-		$this->assertEquals(false, $all_ids);
-		$all_ids = $this->search->user_search(5, $test_ary, $count, 5);
-		$this->assertEquals(1, $all_ids);
-		$all_ids = $this->search->user_search(10, $test_ary, $count, 5);
-		$this->assertEquals(2, $all_ids);
-	}
-}
diff --git "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-covarage.sh" "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-covarage.sh"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-covarage.sh"
+++ /dev/null
@@ -1,19 +0,0 @@
-#!/bin/bash
-#
-# Collapsible Categories extension for the phpBB Forum Software package.
-#
-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
-# @license GNU General Public License, version 2 (GPL-2.0)
-#
-set -e
-set -x
-
-DB=$1
-TRAVIS_PHP_VERSION=$2
-EXTNAME=$3
-
-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
-then
-	sed -n '1h;1!H;${;g;s/<\/php>/<\/php>\n\t<filter>\n\t\t<whitelist>\n\t\t\t<directory>..\/<\/directory>\n\t\t\t<exclude>\n\t\t\t\t<directory>..\/tests\/<\/directory>\n\t\t\t\t<directory>..\/language\/<\/directory>\n\t\t\t\t<directory>..\/migrations\/<\/directory>\n\t\t\t<\/exclude>\n\t\t<\/whitelist>\n\t<\/filter>/g;p;}' phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml &> phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml.bak
-	cp phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml.bak phpBB/ext/"$EXTNAME"/travis/phpunit-mysqli-travis.xml
-fi
diff --git "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-epv.sh" "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-epv.sh"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-epv.sh"
+++ /dev/null
@@ -1,23 +0,0 @@
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
-EPV=$1
-NOTESTS=$2
-
-if [ "$EPV" == "1" -a "$NOTESTS" == "1" ]
-then
-	cd phpBB
-	composer remove sami/sami --update-with-dependencies --dev --no-interaction
-	composer require phpbb/epv:dev-master --dev --no-interaction --ignore-platform-reqs
-	cd ../
-fi
diff --git "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-phpbb.sh" "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-phpbb.sh"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/travis/prepare-phpbb.sh"
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
diff --git "[ORIGINAL]/anavaro\\pmsearch/travis/run-tests.sh" "[ORIGINAL]/anavaro\\pmsearch/travis/run-tests.sh"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/travis/run-tests.sh"
+++ /dev/null
@@ -1,20 +0,0 @@
-#!/bin/bash
-#
-# Collapsible Categories extension for the phpBB Forum Software package.
-#
-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
-# @license GNU General Public License, version 2 (GPL-2.0)
-#
-set -e
-set -x
-
-DB=$1
-TRAVIS_PHP_VERSION=$2
-EXTNAME=$3
-
-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
-then
-	phpBB/vendor/bin/phpunit --configuration phpBB/ext/"$EXTNAME"/travis/phpunit-"$DB"-travis.xml --bootstrap ./tests/bootstrap.php --coverage-clover build/logs/clover.xml
-else
-	phpBB/vendor/bin/phpunit --configuration phpBB/ext/"$EXTNAME"/travis/phpunit-"$DB"-travis.xml --bootstrap ./tests/bootstrap.php
-fi
diff --git "[ORIGINAL]/anavaro\\pmsearch/travis/send-coverage.sh" "[ORIGINAL]/anavaro\\pmsearch/travis/send-coverage.sh"
deleted file mode 100644
--- "[ORIGINAL]/anavaro\\pmsearch/travis/send-coverage.sh"
+++ /dev/null
@@ -1,20 +0,0 @@
-#!/bin/bash
-#
-# Collapsible Categories extension for the phpBB Forum Software package.
-#
-# @copyright (c) 2015 phpBB Limited <https://www.phpbb.com>
-# @license GNU General Public License, version 2 (GPL-2.0)
-#
-set -e
-set -x
-
-DB=$1
-TRAVIS_PHP_VERSION=$2
-GITREPO=$3
-
-if [ "$TRAVIS_PHP_VERSION" == "7.2" ] && [ "$DB" == "mysqli" ]
-then
-    cd ../"$GITREPO"
-    wget https://scrutinizer-ci.com/ocular.phar
-    php ocular.phar code-coverage:upload --format=php-clover ../../phpBB3/build/logs/clover.xml
-fi
diff --git "[ORIGINAL]/anavaro\\pmsearch/ucp/ucp_pmsearch_module.php" "[FORUM_EXT]/anavaro\\pmsearch/ucp/ucp_pmsearch_module.php"
--- "[ORIGINAL]/anavaro\\pmsearch/ucp/ucp_pmsearch_module.php"
+++ "[FORUM_EXT]/anavaro\\pmsearch/ucp/ucp_pmsearch_module.php"
@@ -81,7 +81,7 @@ class ucp_pmsearch_module
 						$search_count = $this->search->user_search($keywords, $id_ary, $startFrom, $this->config['search_block_size']);
 					}
 
-					if ($search_count > 0 )
+					if ($search_count > 0 && $id_ary)
 					{
 						// Let's get additional info
 						$page_array = array();
```
