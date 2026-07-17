Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/forumhulp\\htmlemail/README.md" "[ORIGINAL]/forumhulp\\htmlemail/README.md"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\htmlemail/README.md"
+++ /dev/null
@@ -1,41 +0,0 @@
-﻿HTML Email
-===========
-
-HTML Email changes your phpBB forum so it can send html emails to your members.
-
-## Requirements
-* phpBB 3.3.0-dev or higher
-* PHP 7.0.0 or higher
-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
-
-=======
-* phpBB 3.1.0-dev or higher
-* PHP 5.3.3 or higher
-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
-
-## Installation
-You can install this extension on the latest copy of the develop branch ([phpBB 3.3-dev](https://github.com/phpbb/phpbb3)) by doing the following:
-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
-
-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/htmlemail/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
-3. Click HTML Email => `Enable`.
-4. Don't forget to change your email templates and clear your server cache.
-
-## Update
-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/htmlemail/archive/master.zip).
-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
-3. Copy the contents of `htmlemail-master` folder to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Enable`.
-5. Click `Details` or `Re-Check all versions` link to follow updates.
-6. Or use our Upload Extensions extension
-
-## Uninstallation
-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
-
-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/htmlemail/` folder or use our Upload Extensions extension to delet all files and folders.
-
-## License
-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
-
-© 2015 - John Peskens (ForumHulp.com)
diff --git "[ORIGINAL]/forumhulp\\htmlemail/composer.json" "[FORUM_EXT]/forumhulp\\htmlemail/composer.json"
--- "[ORIGINAL]/forumhulp\\htmlemail/composer.json"
+++ "[FORUM_EXT]/forumhulp\\htmlemail/composer.json"
@@ -3,7 +3,7 @@
 	"type": "phpbb-extension",
 	"description": "Core change for html email.",
 	"homepage": "http://forumhulp.com",
-	"version": "3.3.0",
+	"version": "3.1.7",
 	"keywords": ["phpbb", "extension", "HTML", "Email"],
 	"license": "GPL-2.0",
 	"authors": [
@@ -15,18 +15,18 @@
 		}
 	],
 	"require": {
-		"php": ">=7.0.0",
+		"php": ">=5.3.3",
 		"composer/installers": "~1.0"
 	},
 	"extra": {
 		"display-name": "HTML email",
 		"soft-require": {
-			"phpbb/phpbb": ">=3.3.0,<3.3.*@dev"
+			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
 		},
 		"version-check": {
             "host": "forumhulp.com",
-            "directory": "/versioncheck",
-            "filename": "htmlemail"
+            "directory": "/ext",
+            "filename": "index.php?id=66"
 		}
 
 	}
diff --git "[ORIGINAL]/forumhulp\\htmlemail/config/services.yml" "[ORIGINAL]/forumhulp\\htmlemail/config/services.yml"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\htmlemail/config/services.yml"
+++ /dev/null
@@ -1,8 +0,0 @@
-services:
-    forumhulp.htmlemail.listener:
-        class: forumhulp\htmlemail\event\listener
-        arguments:
-            - '@config'
-            - '@dispatcher'
-        tags:
-            - { name: event.listener }
diff --git "[FORUM_EXT]/forumhulp\\htmlemail/diff_full.tmp" "[FORUM_EXT]/forumhulp\\htmlemail/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\htmlemail/diff_full.tmp"
@@ -0,0 +1,610 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
+deleted file mode 100644
+index 64b2143bd..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
++++ /dev/null
+@@ -1,41 +0,0 @@
+-﻿HTML Email
+-===========
+-
+-HTML Email changes your phpBB forum so it can send html emails to your members.
+-
+-## Requirements
+-* phpBB 3.3.0-dev or higher
+-* PHP 7.0.0 or higher
+-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
+-
+-=======
+-* phpBB 3.1.0-dev or higher
+-* PHP 5.3.3 or higher
+-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
+-
+-## Installation
+-You can install this extension on the latest copy of the develop branch ([phpBB 3.3-dev](https://github.com/phpbb/phpbb3)) by doing the following:
+-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
+-
+-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/htmlemail/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
+-3. Click HTML Email => `Enable`.
+-4. Don't forget to change your email templates and clear your server cache.
+-
+-## Update
+-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/htmlemail/archive/master.zip).
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
+-3. Copy the contents of `htmlemail-master` folder to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
+-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Enable`.
+-5. Click `Details` or `Re-Check all versions` link to follow updates.
+-6. Or use our Upload Extensions extension
+-
+-## Uninstallation
+-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
+-
+-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/htmlemail/` folder or use our Upload Extensions extension to delet all files and folders.
+-
+-## License
+-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
+-
+-© 2015 - John Peskens (ForumHulp.com)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
+index 37133d352..abb05657a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Core change for html email.",
+ 	"homepage": "http://forumhulp.com",
+-	"version": "3.3.0",
++	"version": "3.1.7",
+ 	"keywords": ["phpbb", "extension", "HTML", "Email"],
+ 	"license": "GPL-2.0",
+ 	"authors": [
+@@ -15,18 +15,18 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=7.0.0",
++		"php": ">=5.3.3",
+ 		"composer/installers": "~1.0"
+ 	},
+ 	"extra": {
+ 		"display-name": "HTML email",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.3.0,<3.3.*@dev"
++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
+ 		},
+ 		"version-check": {
+             "host": "forumhulp.com",
+-            "directory": "/versioncheck",
+-            "filename": "htmlemail"
++            "directory": "/ext",
++            "filename": "index.php?id=66"
+ 		}
+ 
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
+deleted file mode 100644
+index d29e987f9..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
++++ /dev/null
+@@ -1,8 +0,0 @@
+-services:
+-    forumhulp.htmlemail.listener:
+-        class: forumhulp\htmlemail\event\listener
+-        arguments:
+-            - '@config'
+-            - '@dispatcher'
+-        tags:
+-            - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp"
+new file mode 100644
+index 000000000..0bb7d9c02
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp"
+@@ -0,0 +1,90 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
++deleted file mode 100644
++index 64b2143bd..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
+++++ /dev/null
++@@ -1,41 +0,0 @@
++-﻿HTML Email
++-===========
++-
++-HTML Email changes your phpBB forum so it can send html emails to your members.
++-
++-## Requirements
++-* phpBB 3.3.0-dev or higher
++-* PHP 7.0.0 or higher
++-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
++-
++-=======
++-* phpBB 3.1.0-dev or higher
++-* PHP 5.3.3 or higher
++-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
++-
++-## Installation
++-You can install this extension on the latest copy of the develop branch ([phpBB 3.3-dev](https://github.com/phpbb/phpbb3)) by doing the following:
++-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
++-
++-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/htmlemail/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
++-3. Click HTML Email => `Enable`.
++-4. Don't forget to change your email templates and clear your server cache.
++-
++-## Update
++-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/htmlemail/archive/master.zip).
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
++-3. Copy the contents of `htmlemail-master` folder to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
++-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Enable`.
++-5. Click `Details` or `Re-Check all versions` link to follow updates.
++-6. Or use our Upload Extensions extension
++-
++-## Uninstallation
++-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
++-
++-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/htmlemail/` folder or use our Upload Extensions extension to delet all files and folders.
++-
++-## License
++-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
++-
++-© 2015 - John Peskens (ForumHulp.com)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
++index 37133d352..abb05657a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
++@@ -3,7 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Core change for html email.",
++ 	"homepage": "http://forumhulp.com",
++-	"version": "3.3.0",
+++	"version": "3.1.7",
++ 	"keywords": ["phpbb", "extension", "HTML", "Email"],
++ 	"license": "GPL-2.0",
++ 	"authors": [
++@@ -15,18 +15,18 @@
++ 		}
++ 	],
++ 	"require": {
++-		"php": ">=7.0.0",
+++		"php": ">=5.3.3",
++ 		"composer/installers": "~1.0"
++ 	},
++ 	"extra": {
++ 		"display-name": "HTML email",
++ 		"soft-require": {
++-			"phpbb/phpbb": ">=3.3.0,<3.3.*@dev"
+++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
++ 		},
++ 		"version-check": {
++             "host": "forumhulp.com",
++-            "directory": "/versioncheck",
++-            "filename": "htmlemail"
+++            "directory": "/ext",
+++            "filename": "index.php?id=66"
++ 		}
++ 
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
++deleted file mode 100644
++index d29e987f9..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
+++++ /dev/null
++@@ -1,8 +0,0 @@
++-services:
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/event/listener.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/event/listener.php"
+deleted file mode 100644
+index f2cfed2d0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/event/listener.php"
++++ /dev/null
+@@ -1,67 +0,0 @@
+-<?php
+-/**
+-*
+-* @package htmlemail
+-* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace forumhulp\htmlemail\event;
+-
+-/**
+-* @ignore
+-*/
+-use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+-
+-/**
+-* Event listener
+-*/
+-class listener implements EventSubscriberInterface
+-{
+-	protected $config;
+-	protected $phpbb_dispatcher;
+-
+-	/**
+-	* Constructor
+-	*
+-	* @param \phpbb\event\dispatcher           $phpbb_dispatcher Event dispatcher object
+-	*/
+-	public function __construct(\phpbb\config\config $config, \phpbb\event\dispatcher $phpbb_dispatcher)
+-	{
+-		$this->config = $config;
+-		$this->phpbb_dispatcher = $phpbb_dispatcher;
+-	}
+-
+-	static public function getSubscribedEvents()
+-	{
+-		return array(
+-			'core.modify_email_headers'	=> 'set_html_headers',
+-		);
+-	}
+-
+-	public function set_html_headers($event)
+-	{
+-		$headers = $event['headers'];
+-		$headers = $this->array_find('Content-Type', $headers);
+-
+-		$event['headers'] = $headers;
+-	}
+-
+-	// array_search with partial matches
+-	public function array_find($needle, $haystack)
+-	{
+-		if (!is_array($haystack))
+-		{
+-			return false;
+-		}
+-		foreach ($haystack as $key => $item)
+-		{
+-			if (strpos($item, $needle) !== false)
+-			{
+-				$haystack[$key] = 'Content-Type: text/html; charset=UTF-8'; // format=flowed';
+-			}
+-		}
+-		return $haystack;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/ext.php"
+index cd2ed7f55..52ca8e9a6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/ext.php"
+@@ -47,4 +47,4 @@ class ext extends \phpbb\extension\base
+ 		// Run parent enable step method
+ 		return parent::enable_step($old_state);
+ 	}
+-}
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php"
+index 7fac49938..2e1aeb418 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php"
+@@ -39,8 +39,8 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
+-	'HTML_EMAIL_NOTICE'		=> '<div class="phpinfo"><p class="entry">Config setting of this extension are not necessary.<br />You can use it for email on birthday extension by switching on "use html in email" in Board features. Do you want to use html in other mails you have to let know messenger it should send html emails by configure messenger with $messenger->set_mail_html(true). Update your mail-templates to whatever you like.</p></div>',
+-	'DELETE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Not all files are replaced ! Please replace by hand the file(s) mentioned in the Admin log</p></div>',
+-	'ENABLE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />However not all updates are done properly because of file permissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions !</p></div>'
++	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Config setting of this extension are not necessary.<br />You can use it for email on birthday extension by switching on "use html in email" in Boardfeatures. Do you want to use html in other mails you have to let know messenger it should send html emails by configure messenger with $messenger->set_mail_html(true). Update your mail-templates to whatever you like.</p></div>',
++	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Not all files are replaced ! Please replace by hand the file(s) mentioned in the Admin log</p></div>',
++	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />However not all updates are done properly because of file permissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions !</p></div>'
+ ));
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
+index e49d21d38..05cfd2c10 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
+@@ -1,17 +1,17 @@
+ <?php
+ /**
+- *
+- * HTML email. An extension for the phpBB Forum Software package.
+- * French translation by Galixte (http://www.galixte.com)
+- *
+- * @copyright (c) 2018 ForumHulp.com <http://forumhulp.com>
+- * @license GNU General Public License, version 2 (GPL-2.0-only)
+- *
+- */
++*
++* HTML email extension for the phpBB Forum Software package.
++* French translation by Galixte (http://www.galixte.com)
++*
++* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
+ 
+ /**
+- * DO NOT CHANGE
+- */
++* DO NOT CHANGE
++*/
+ if (!defined('IN_PHPBB'))
+ {
+ 	exit;
+@@ -39,8 +39,8 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	'FH_HELPER_NOTICE'		=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
+-	'HTML_EMAIL_NOTICE'		=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) », aussi voir <a href="https://github.com/ForumHulp/htmlemail/issues/11">cette page</a>. Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
+-	'DELETE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Tous les fichiers n’ont pas été remplacés ! Merci de remplacer les fichiers mentionnés dans le « Journal d’administration ».</p></div>',
+-	'ENABLE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Cependant, toutes les mises à jour n’ont pas été correctement exécutées en raison des permissions sur les fichiers ou en raison de fichiers manquants. Pour davantage d’informations merci de consulter le « Journal d’administration ».<br /><br />Merci de mettre à jour les fichiers manuellement pour accéder à toutes les fonctionnalités !</p></div>'
++	'FH_HELPER_NOTICE'			=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
++	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) ». Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
++	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Tous les fichiers n’ont pas été remplacés ! Merci de remplacer les fichiers mentionnés dans le « Journal d’administration ».</p></div>',
++	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Cependant, toutes les mises à jour n’ont pas été correctement exécutées en raison des permissions sur les fichiers ou en raison de fichiers manquants. Pour davantage d’informations merci de consulter le « Journal d’administration ».<br /><br />Merci de mettre à jour les fichiers manuellement pour accéder à toutes les fonctionnalités !</p></div>'
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php"
+new file mode 100644
+index 000000000..9ef5520a7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php"
+@@ -0,0 +1,120 @@
++<?php
++/**
++*
++* HTML email extension for the phpBB Forum Software package.
++*
++* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
++
++namespace forumhulp\htmlemail\migrations\v31x;
++
++use phpbb\db\migration\container_aware_migration;
++
++/**
++ * Migration stage 1: Initial schema
++ */
++class m1_initial_file extends container_aware_migration
++{
++	/**
++	 * Assign migration file dependencies for this migration
++	 *
++	 * @return array Array of migration files
++	 * @static
++	 * @access public
++	 */
++	static public function depends_on()
++	{
++		return array('\phpbb\db\migration\data\v310\gold');
++	}
++
++	/**
++	* Add core change to the files.
++	*
++	* @return array Array of files
++	* @access public
++	*/
++	public function update_data()
++	{
++		$this->revert = false;
++		return array(
++			array('custom', array(array($this, 'update_files'))),
++		);
++	}
++
++	public function revert_data()
++	{
++		$this->revert = true;
++		return array(
++			array('custom', array(array($this, 'update_files'))),
++		);
++	}
++
++	public function update_files()
++	{
++		if (class_exists('forumhulp\helper\helper'))
++		{
++			if (!$this->container->has('forumhulp.helper'))
++			{
++				$forumhulp_helper = new \forumhulp\helper\helper(
++					$this->container->get('dbal.conn'),
++					$this->config,
++					$this->container->get('ext.manager'),
++					$this->container->get('template'),
++					$this->container->get('user'),
++					$this->container->get('request'),
++					$this->container->get('log'),
++					$this->container->get('cache'),
++					$this->phpbb_root_path			
++				);
++				$this->container->set('forumhulp.helper', $forumhulp_helper);
++			}
++			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
++		} else
++		{
++			$this->container->get('user')->add_lang_ext('forumhulp/htmlemail', 'info_acp_htmlemail');
++			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
++		}
++	}
++
++	public function data()
++	{
++		$replacements = array(
++			'files' => array(
++				0 => '/includes/functions_messenger.' . $this->php_ext,
++				),
++			'searches' => array(
++				0 => array(
++					0 => '	var $use_queue = true;',
++					1 => '		$this->subject = \'\';',
++					2 => '		$this->mail_priority = $priority;',
++					3 => '$headers[] = \'Content-Type: text/plain; charset=UTF-8\';',
++					4 => '\'EMAIL_SIG\'	=> str_replace(\'<br />\', "\n", "-- \n" . htmlspecialchars_decode($config[\'board_email_sig\'])),',
++					5 => '\'SITENAME\'	=> htmlspecialchars_decode($config[\'sitename\']),',
++					),
++				),
++			'replaces' => array(
++				0 => array(
++					0 => '	var $use_queue = true;
++	var $use_html = false;',
++					1 => '		$this->subject = \'\';
++		$this->use_html = false;',
++					2 => '		$this->mail_priority = $priority;
++	}
++	
++	/**
++	* Set the email html
++	*/
++	function set_mail_html($html = false)
++	{
++		$this->use_html = $html;',
++					3 => '$headers[] = \'Content-Type: \' . (($this->use_html) ? \'text/html;\' : \'text/plain;\')  . \' charset=UTF-8\';',
++					4 => '\'EMAIL_SIG\'	=> "-- \n" . $config[\'board_email_sig\'],',
++					5 => '\'SITENAME\'	=> $config[\'sitename\'],',
++					),
++				)
++			);
++		return $replacements;
++	}
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php"
+new file mode 100644
+index 000000000..081ee8696
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php"
+@@ -0,0 +1,103 @@
++<?php
++/**
++*
++* HTML email extension for the phpBB Forum Software package.
++*
++* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
++
++namespace forumhulp\htmlemail\migrations\v32x;
++
++use phpbb\db\migration\container_aware_migration;
++
++/**
++ * Migration stage 1: Initial schema
++ */
++class m1_initial_file extends container_aware_migration
++{
++	/**
++	 * Assign migration file dependencies for this migration
++	 *
++	 * @return array Array of migration files
++	 * @static
++	 * @access public
++	 */
++	static public function depends_on()
++	{
++		return array('\forumhulp\htmlemail\migrations\v31x\m1_initial_file');
++	}
++
++	/**
++	* Add core change to the files.
++	*
++	* @return array Array of files
++	* @access public
++	*/
++	public function update_data()
++	{
++		$this->revert = false;
++		return array(
++			array('custom', array(array($this, 'update_files'))),
++		);
++	}
++
++	public function revert_data()
++	{
++		$this->revert = true;
++		return array(
++			array('custom', array(array($this, 'update_files'))),
++		);
++	}
++
++	public function update_files()
++	{
++		if (class_exists('forumhulp\helper\helper'))
++		{
++			if (!$this->container->has('forumhulp.helper'))
++			{
++				$forumhulp_helper = new \forumhulp\helper\helper(
++					$this->container->get('dbal.conn'),
++					$this->config,
++					$this->container->get('ext.manager'),
++					$this->container->get('template'),
++					$this->container->get('user'),
++					$this->container->get('request'),
++					$this->container->get('log'),
++					$this->container->get('cache'),
++					$this->phpbb_root_path			
++				);
++				$this->container->set('forumhulp.helper', $forumhulp_helper);
++			}
++			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
++		} else
++		{
++			$this->container->get('user')->add_lang_ext('forumhulp/htmlemail', 'info_acp_htmlemail');
++			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
++		}
++	}
++
++	public function data()
++	{
++		$replacements = array(
++			'files' => array(
++				0 => '/phpbb/notification/method/messenger_base.' . $this->php_ext,
++				),
++			'searches' => array(
++				0 => array(
++					0 => '$messenger = new \messenger();'
++					)
++				),
++			'replaces' => array(
++				0 => array(
++					0 => '$messenger = new \messenger();
++
++		$use_html = method_exists($messenger, \'set_mail_html\');
++		($use_html) ? $messenger->set_mail_html($this->config[\'html_email_on_birthday\']) : null;'
++					)
++				)
++			);
++		return $replacements;
++	}
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/migrations/v33x/m1_initial_file.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/migrations/v33x/m1_initial_file.php"
+deleted file mode 100644
+index 4dd34d09c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/migrations/v33x/m1_initial_file.php"
++++ /dev/null
+@@ -1,31 +0,0 @@
+-<?php
+-/**
+-*
+-* HTML email extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-namespace forumhulp\htmlemail\migrations\v33x;
+-
+-use phpbb\db\migration\container_aware_migration;
+-
+-/**
+- * Migration stage 1: Initial schema
+- */
+-class m1_initial_file extends container_aware_migration
+-{
+-	/**
+-	 * Assign migration file dependencies for this migration
+-	 *
+-	 * @return array Array of migration files
+-	 * @static
+-	 * @access public
+-	 */
+-	static public function depends_on()
+-	{
+-		return array('\phpbb\db\migration\data\v330\v330');
+-	}
+-}
diff --git "[FORUM_EXT]/forumhulp\\htmlemail/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\htmlemail/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\htmlemail/diff_nospace.tmp"
@@ -0,0 +1,586 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
+deleted file mode 100644
+index 64b2143bd..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
++++ /dev/null
+@@ -1,41 +0,0 @@
+-﻿HTML Email
+-===========
+-
+-HTML Email changes your phpBB forum so it can send html emails to your members.
+-
+-## Requirements
+-* phpBB 3.3.0-dev or higher
+-* PHP 7.0.0 or higher
+-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
+-
+-=======
+-* phpBB 3.1.0-dev or higher
+-* PHP 5.3.3 or higher
+-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
+-
+-## Installation
+-You can install this extension on the latest copy of the develop branch ([phpBB 3.3-dev](https://github.com/phpbb/phpbb3)) by doing the following:
+-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
+-
+-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/htmlemail/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
+-3. Click HTML Email => `Enable`.
+-4. Don't forget to change your email templates and clear your server cache.
+-
+-## Update
+-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/htmlemail/archive/master.zip).
+-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
+-3. Copy the contents of `htmlemail-master` folder to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
+-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Enable`.
+-5. Click `Details` or `Re-Check all versions` link to follow updates.
+-6. Or use our Upload Extensions extension
+-
+-## Uninstallation
+-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
+-
+-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/htmlemail/` folder or use our Upload Extensions extension to delet all files and folders.
+-
+-## License
+-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
+-
+-© 2015 - John Peskens (ForumHulp.com)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
+index 37133d352..abb05657a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Core change for html email.",
+ 	"homepage": "http://forumhulp.com",
+-	"version": "3.3.0",
++	"version": "3.1.7",
+ 	"keywords": ["phpbb", "extension", "HTML", "Email"],
+ 	"license": "GPL-2.0",
+ 	"authors": [
+@@ -15,18 +15,18 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=7.0.0",
++		"php": ">=5.3.3",
+ 		"composer/installers": "~1.0"
+ 	},
+ 	"extra": {
+ 		"display-name": "HTML email",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.3.0,<3.3.*@dev"
++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
+ 		},
+ 		"version-check": {
+             "host": "forumhulp.com",
+-            "directory": "/versioncheck",
+-            "filename": "htmlemail"
++            "directory": "/ext",
++            "filename": "index.php?id=66"
+ 		}
+ 
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
+deleted file mode 100644
+index d29e987f9..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
++++ /dev/null
+@@ -1,8 +0,0 @@
+-services:
+-    forumhulp.htmlemail.listener:
+-        class: forumhulp\htmlemail\event\listener
+-        arguments:
+-            - '@config'
+-            - '@dispatcher'
+-        tags:
+-            - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp"
+new file mode 100644
+index 000000000..eb6b0e305
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp"
+@@ -0,0 +1,610 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
++deleted file mode 100644
++index 64b2143bd..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
+++++ /dev/null
++@@ -1,41 +0,0 @@
++-﻿HTML Email
++-===========
++-
++-HTML Email changes your phpBB forum so it can send html emails to your members.
++-
++-## Requirements
++-* phpBB 3.3.0-dev or higher
++-* PHP 7.0.0 or higher
++-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
++-
++-=======
++-* phpBB 3.1.0-dev or higher
++-* PHP 5.3.3 or higher
++-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
++-
++-## Installation
++-You can install this extension on the latest copy of the develop branch ([phpBB 3.3-dev](https://github.com/phpbb/phpbb3)) by doing the following:
++-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
++-
++-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/htmlemail/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
++-3. Click HTML Email => `Enable`.
++-4. Don't forget to change your email templates and clear your server cache.
++-
++-## Update
++-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/htmlemail/archive/master.zip).
++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
++-3. Copy the contents of `htmlemail-master` folder to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
++-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Enable`.
++-5. Click `Details` or `Re-Check all versions` link to follow updates.
++-6. Or use our Upload Extensions extension
++-
++-## Uninstallation
++-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
++-
++-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/htmlemail/` folder or use our Upload Extensions extension to delet all files and folders.
++-
++-## License
++-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
++-
++-© 2015 - John Peskens (ForumHulp.com)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
++index 37133d352..abb05657a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
++@@ -3,7 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Core change for html email.",
++ 	"homepage": "http://forumhulp.com",
++-	"version": "3.3.0",
+++	"version": "3.1.7",
++ 	"keywords": ["phpbb", "extension", "HTML", "Email"],
++ 	"license": "GPL-2.0",
++ 	"authors": [
++@@ -15,18 +15,18 @@
++ 		}
++ 	],
++ 	"require": {
++-		"php": ">=7.0.0",
+++		"php": ">=5.3.3",
++ 		"composer/installers": "~1.0"
++ 	},
++ 	"extra": {
++ 		"display-name": "HTML email",
++ 		"soft-require": {
++-			"phpbb/phpbb": ">=3.3.0,<3.3.*@dev"
+++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
++ 		},
++ 		"version-check": {
++             "host": "forumhulp.com",
++-            "directory": "/versioncheck",
++-            "filename": "htmlemail"
+++            "directory": "/ext",
+++            "filename": "index.php?id=66"
++ 		}
++ 
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
++deleted file mode 100644
++index d29e987f9..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
+++++ /dev/null
++@@ -1,8 +0,0 @@
++-services:
++-    forumhulp.htmlemail.listener:
++-        class: forumhulp\htmlemail\event\listener
++-        arguments:
++-            - '@config'
++-            - '@dispatcher'
++-        tags:
++-            - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp"
++new file mode 100644
++index 000000000..0bb7d9c02
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/diff_full.tmp"
++@@ -0,0 +1,90 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
+++deleted file mode 100644
+++index 64b2143bd..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/README.md"
++++++ /dev/null
+++@@ -1,41 +0,0 @@
+++-﻿HTML Email
+++-===========
+++-
+++-HTML Email changes your phpBB forum so it can send html emails to your members.
+++-
+++-## Requirements
+++-* phpBB 3.3.0-dev or higher
+++-* PHP 7.0.0 or higher
+++-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
+++-
+++-=======
+++-* phpBB 3.1.0-dev or higher
+++-* PHP 5.3.3 or higher
+++-* The Forumhulp helper plugin (https://github.com/ForumHulp/helper)
+++-
+++-## Installation
+++-You can install this extension on the latest copy of the develop branch ([phpBB 3.3-dev](https://github.com/phpbb/phpbb3)) by doing the following:
+++-We feel sorry as our answers on phpbb sites are removed, so use github or our forum for answers.
+++-
+++-1. Copy the [entire contents of this repo](https://github.com/ForumHulp/htmlemail/archive/master.zip) to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
+++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions`.
+++-3. Click HTML Email => `Enable`.
+++-4. Don't forget to change your email templates and clear your server cache.
+++-
+++-## Update
+++-1. Download the [latest ZIP-archive of `master` branch of this repository](https://github.com/ForumHulp/htmlemail/archive/master.zip).
+++-2. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
+++-3. Copy the contents of `htmlemail-master` folder to `FORUM_DIRECTORY/ext/forumhulp/htmlemail/`.
+++-4. Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Enable`.
+++-5. Click `Details` or `Re-Check all versions` link to follow updates.
+++-6. Or use our Upload Extensions extension
+++-
+++-## Uninstallation
+++-Navigate in the ACP to `Customise -> Extension Management -> Manage extensions` and click HTML Email => `Disable`.
+++-
+++-To permanently uninstall, click `Delete Data` and then you can safely delete the `/ext/forumhulp/htmlemail/` folder or use our Upload Extensions extension to delet all files and folders.
+++-
+++-## License
+++-[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
+++-
+++-© 2015 - John Peskens (ForumHulp.com)
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
+++index 37133d352..abb05657a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/composer.json"
+++@@ -3,7 +3,7 @@
+++ 	"type": "phpbb-extension",
+++ 	"description": "Core change for html email.",
+++ 	"homepage": "http://forumhulp.com",
+++-	"version": "3.3.0",
++++	"version": "3.1.7",
+++ 	"keywords": ["phpbb", "extension", "HTML", "Email"],
+++ 	"license": "GPL-2.0",
+++ 	"authors": [
+++@@ -15,18 +15,18 @@
+++ 		}
+++ 	],
+++ 	"require": {
+++-		"php": ">=7.0.0",
++++		"php": ">=5.3.3",
+++ 		"composer/installers": "~1.0"
+++ 	},
+++ 	"extra": {
+++ 		"display-name": "HTML email",
+++ 		"soft-require": {
+++-			"phpbb/phpbb": ">=3.3.0,<3.3.*@dev"
++++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
+++ 		},
+++ 		"version-check": {
+++             "host": "forumhulp.com",
+++-            "directory": "/versioncheck",
+++-            "filename": "htmlemail"
++++            "directory": "/ext",
++++            "filename": "index.php?id=66"
+++ 		}
+++ 
+++ 	}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
+++deleted file mode 100644
+++index d29e987f9..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/config/services.yml"
++++++ /dev/null
+++@@ -1,8 +0,0 @@
+++-services:
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/event/listener.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/event/listener.php"
++deleted file mode 100644
++index f2cfed2d0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/event/listener.php"
+++++ /dev/null
++@@ -1,67 +0,0 @@
++-<?php
++-/**
++-*
++-* @package htmlemail
++-* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace forumhulp\htmlemail\event;
++-
++-/**
++-* @ignore
++-*/
++-use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++-
++-/**
++-* Event listener
++-*/
++-class listener implements EventSubscriberInterface
++-{
++-	protected $config;
++-	protected $phpbb_dispatcher;
++-
++-	/**
++-	* Constructor
++-	*
++-	* @param \phpbb\event\dispatcher           $phpbb_dispatcher Event dispatcher object
++-	*/
++-	public function __construct(\phpbb\config\config $config, \phpbb\event\dispatcher $phpbb_dispatcher)
++-	{
++-		$this->config = $config;
++-		$this->phpbb_dispatcher = $phpbb_dispatcher;
++-	}
++-
++-	static public function getSubscribedEvents()
++-	{
++-		return array(
++-			'core.modify_email_headers'	=> 'set_html_headers',
++-		);
++-	}
++-
++-	public function set_html_headers($event)
++-	{
++-		$headers = $event['headers'];
++-		$headers = $this->array_find('Content-Type', $headers);
++-
++-		$event['headers'] = $headers;
++-	}
++-
++-	// array_search with partial matches
++-	public function array_find($needle, $haystack)
++-	{
++-		if (!is_array($haystack))
++-		{
++-			return false;
++-		}
++-		foreach ($haystack as $key => $item)
++-		{
++-			if (strpos($item, $needle) !== false)
++-			{
++-				$haystack[$key] = 'Content-Type: text/html; charset=UTF-8'; // format=flowed';
++-			}
++-		}
++-		return $haystack;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/ext.php"
++index cd2ed7f55..52ca8e9a6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/ext.php"
++@@ -47,4 +47,4 @@ class ext extends \phpbb\extension\base
++ 		// Run parent enable step method
++ 		return parent::enable_step($old_state);
++ 	}
++-}
+++}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php"
++index 7fac49938..2e1aeb418 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/en/info_acp_htmlemail.php"
++@@ -39,8 +39,8 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, array(
++ 	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
++-	'HTML_EMAIL_NOTICE'		=> '<div class="phpinfo"><p class="entry">Config setting of this extension are not necessary.<br />You can use it for email on birthday extension by switching on "use html in email" in Board features. Do you want to use html in other mails you have to let know messenger it should send html emails by configure messenger with $messenger->set_mail_html(true). Update your mail-templates to whatever you like.</p></div>',
++-	'DELETE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Not all files are replaced ! Please replace by hand the file(s) mentioned in the Admin log</p></div>',
++-	'ENABLE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />However not all updates are done properly because of file permissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions !</p></div>'
+++	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Config setting of this extension are not necessary.<br />You can use it for email on birthday extension by switching on "use html in email" in Boardfeatures. Do you want to use html in other mails you have to let know messenger it should send html emails by configure messenger with $messenger->set_mail_html(true). Update your mail-templates to whatever you like.</p></div>',
+++	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Not all files are replaced ! Please replace by hand the file(s) mentioned in the Admin log</p></div>',
+++	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />However not all updates are done properly because of file permissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions !</p></div>'
++ ));
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
++index e49d21d38..05cfd2c10 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
++@@ -1,17 +1,17 @@
++ <?php
++ /**
++- *
++- * HTML email. An extension for the phpBB Forum Software package.
++- * French translation by Galixte (http://www.galixte.com)
++- *
++- * @copyright (c) 2018 ForumHulp.com <http://forumhulp.com>
++- * @license GNU General Public License, version 2 (GPL-2.0-only)
++- *
++- */
+++*
+++* HTML email extension for the phpBB Forum Software package.
+++* French translation by Galixte (http://www.galixte.com)
+++*
+++* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
++ 
++ /**
++- * DO NOT CHANGE
++- */
+++* DO NOT CHANGE
+++*/
++ if (!defined('IN_PHPBB'))
++ {
++ 	exit;
++@@ -39,8 +39,8 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	'FH_HELPER_NOTICE'		=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
++-	'HTML_EMAIL_NOTICE'		=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) », aussi voir <a href="https://github.com/ForumHulp/htmlemail/issues/11">cette page</a>. Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
++-	'DELETE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Tous les fichiers n’ont pas été remplacés ! Merci de remplacer les fichiers mentionnés dans le « Journal d’administration ».</p></div>',
++-	'ENABLE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Cependant, toutes les mises à jour n’ont pas été correctement exécutées en raison des permissions sur les fichiers ou en raison de fichiers manquants. Pour davantage d’informations merci de consulter le « Journal d’administration ».<br /><br />Merci de mettre à jour les fichiers manuellement pour accéder à toutes les fonctionnalités !</p></div>'
+++	'FH_HELPER_NOTICE'			=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
+++	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) ». Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
+++	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Tous les fichiers n’ont pas été remplacés ! Merci de remplacer les fichiers mentionnés dans le « Journal d’administration ».</p></div>',
+++	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Cependant, toutes les mises à jour n’ont pas été correctement exécutées en raison des permissions sur les fichiers ou en raison de fichiers manquants. Pour davantage d’informations merci de consulter le « Journal d’administration ».<br /><br />Merci de mettre à jour les fichiers manuellement pour accéder à toutes les fonctionnalités !</p></div>'
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php"
++new file mode 100644
++index 000000000..9ef5520a7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php"
++@@ -0,0 +1,120 @@
+++<?php
+++/**
+++*
+++* HTML email extension for the phpBB Forum Software package.
+++*
+++* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
+++
+++namespace forumhulp\htmlemail\migrations\v31x;
+++
+++use phpbb\db\migration\container_aware_migration;
+++
+++/**
+++ * Migration stage 1: Initial schema
+++ */
+++class m1_initial_file extends container_aware_migration
+++{
+++	/**
+++	 * Assign migration file dependencies for this migration
+++	 *
+++	 * @return array Array of migration files
+++	 * @static
+++	 * @access public
+++	 */
+++	static public function depends_on()
+++	{
+++		return array('\phpbb\db\migration\data\v310\gold');
+++	}
+++
+++	/**
+++	* Add core change to the files.
+++	*
+++	* @return array Array of files
+++	* @access public
+++	*/
+++	public function update_data()
+++	{
+++		$this->revert = false;
+++		return array(
+++			array('custom', array(array($this, 'update_files'))),
+++		);
+++	}
+++
+++	public function revert_data()
+++	{
+++		$this->revert = true;
+++		return array(
+++			array('custom', array(array($this, 'update_files'))),
+++		);
+++	}
+++
+++	public function update_files()
+++	{
+++		if (class_exists('forumhulp\helper\helper'))
+++		{
+++			if (!$this->container->has('forumhulp.helper'))
+++			{
+++				$forumhulp_helper = new \forumhulp\helper\helper(
+++					$this->container->get('dbal.conn'),
+++					$this->config,
+++					$this->container->get('ext.manager'),
+++					$this->container->get('template'),
+++					$this->container->get('user'),
+++					$this->container->get('request'),
+++					$this->container->get('log'),
+++					$this->container->get('cache'),
+++					$this->phpbb_root_path			
+++				);
+++				$this->container->set('forumhulp.helper', $forumhulp_helper);
+++			}
+++			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
+++		} else
+++		{
+++			$this->container->get('user')->add_lang_ext('forumhulp/htmlemail', 'info_acp_htmlemail');
+++			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
+++		}
+++	}
+++
+++	public function data()
+++	{
+++		$replacements = array(
+++			'files' => array(
+++				0 => '/includes/functions_messenger.' . $this->php_ext,
+++				),
+++			'searches' => array(
+++				0 => array(
+++					0 => '	var $use_queue = true;',
+++					1 => '		$this->subject = \'\';',
+++					2 => '		$this->mail_priority = $priority;',
+++					3 => '$headers[] = \'Content-Type: text/plain; charset=UTF-8\';',
+++					4 => '\'EMAIL_SIG\'	=> str_replace(\'<br />\', "\n", "-- \n" . htmlspecialchars_decode($config[\'board_email_sig\'])),',
+++					5 => '\'SITENAME\'	=> htmlspecialchars_decode($config[\'sitename\']),',
+++					),
+++				),
+++			'replaces' => array(
+++				0 => array(
+++					0 => '	var $use_queue = true;
+++	var $use_html = false;',
+++					1 => '		$this->subject = \'\';
+++		$this->use_html = false;',
+++					2 => '		$this->mail_priority = $priority;
+++	}
+++	
+++	/**
+++	* Set the email html
+++	*/
+++	function set_mail_html($html = false)
+++	{
+++		$this->use_html = $html;',
+++					3 => '$headers[] = \'Content-Type: \' . (($this->use_html) ? \'text/html;\' : \'text/plain;\')  . \' charset=UTF-8\';',
+++					4 => '\'EMAIL_SIG\'	=> "-- \n" . $config[\'board_email_sig\'],',
+++					5 => '\'SITENAME\'	=> $config[\'sitename\'],',
+++					),
+++				)
+++			);
+++		return $replacements;
+++	}
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php"
++new file mode 100644
++index 000000000..081ee8696
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php"
++@@ -0,0 +1,103 @@
+++<?php
+++/**
+++*
+++* HTML email extension for the phpBB Forum Software package.
+++*
+++* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
+++
+++namespace forumhulp\htmlemail\migrations\v32x;
+++
+++use phpbb\db\migration\containe
\ No newline at end of file
diff --git "[ORIGINAL]/forumhulp\\htmlemail/event/listener.php" "[ORIGINAL]/forumhulp\\htmlemail/event/listener.php"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\htmlemail/event/listener.php"
+++ /dev/null
@@ -1,67 +0,0 @@
-<?php
-/**
-*
-* @package htmlemail
-* @copyright (c) 2014 John Peskens (http://ForumHulp.com) and Igor Lavrov (https://github.com/LavIgor)
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace forumhulp\htmlemail\event;
-
-/**
-* @ignore
-*/
-use Symfony\Component\EventDispatcher\EventSubscriberInterface;
-
-/**
-* Event listener
-*/
-class listener implements EventSubscriberInterface
-{
-	protected $config;
-	protected $phpbb_dispatcher;
-
-	/**
-	* Constructor
-	*
-	* @param \phpbb\event\dispatcher           $phpbb_dispatcher Event dispatcher object
-	*/
-	public function __construct(\phpbb\config\config $config, \phpbb\event\dispatcher $phpbb_dispatcher)
-	{
-		$this->config = $config;
-		$this->phpbb_dispatcher = $phpbb_dispatcher;
-	}
-
-	static public function getSubscribedEvents()
-	{
-		return array(
-			'core.modify_email_headers'	=> 'set_html_headers',
-		);
-	}
-
-	public function set_html_headers($event)
-	{
-		$headers = $event['headers'];
-		$headers = $this->array_find('Content-Type', $headers);
-
-		$event['headers'] = $headers;
-	}
-
-	// array_search with partial matches
-	public function array_find($needle, $haystack)
-	{
-		if (!is_array($haystack))
-		{
-			return false;
-		}
-		foreach ($haystack as $key => $item)
-		{
-			if (strpos($item, $needle) !== false)
-			{
-				$haystack[$key] = 'Content-Type: text/html; charset=UTF-8'; // format=flowed';
-			}
-		}
-		return $haystack;
-	}
-}
diff --git "[ORIGINAL]/forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php" "[FORUM_EXT]/forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
--- "[ORIGINAL]/forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
+++ "[FORUM_EXT]/forumhulp\\htmlemail/language/fr/info_acp_htmlemail.php"
@@ -1,11 +1,11 @@
 <?php
 /**
 *
- * HTML email. An extension for the phpBB Forum Software package.
+* HTML email extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
- * @copyright (c) 2018 ForumHulp.com <http://forumhulp.com>
- * @license GNU General Public License, version 2 (GPL-2.0-only)
+* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
 
@@ -40,7 +40,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'FH_HELPER_NOTICE'			=> 'L’extension : « Forumhulp Helper » n’est pas installée !<br />Il est nécessaire de télécharger son archive disponible sur cette page : <a href="https://github.com/ForumHulp/helper" target="_blank">Forumhulp Helper</a>, puis de l’envoyer sur son espace FTP et de l’activer.',
-	'HTML_EMAIL_NOTICE'		=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) », aussi voir <a href="https://github.com/ForumHulp/htmlemail/issues/11">cette page</a>. Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
+	'HTML_EMAIL_NOTICE'			=> '<div class="phpinfo"><p class="entry">Aucun paramètre n’est disponible pour cette extension.<br />Cette extension est utile pour l’extension « E-mail on birthday » en activant l’option : « E-mail d’anniversaire en HTML », dans l’onglet « GÉNÉRAL », rubrique « Fonctionnalités du forum ». Pour utiliser le language HTML dans d’autres e-mails, la fonction « messenger » doit envoyer les e-mails en HTML via la fonction « $messenger->set_mail_html(true) ». Enfin, saisir le contenu en langage HTML de son fichier e-mail (*.txt) par ce que l’on souhaite.</p></div>',
 	'DELETE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Tous les fichiers n’ont pas été remplacés ! Merci de remplacer les fichiers mentionnés dans le « Journal d’administration ».</p></div>',
 	'ENABLE_DATA_NOTICE'		=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />Cependant, toutes les mises à jour n’ont pas été correctement exécutées en raison des permissions sur les fichiers ou en raison de fichiers manquants. Pour davantage d’informations merci de consulter le « Journal d’administration ».<br /><br />Merci de mettre à jour les fichiers manuellement pour accéder à toutes les fonctionnalités !</p></div>'
 ));
diff --git "[FORUM_EXT]/forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php" "[FORUM_EXT]/forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\htmlemail/migrations/v31x/m1_initial_file.php"
@@ -0,0 +1,120 @@
+<?php
+/**
+*
+* HTML email extension for the phpBB Forum Software package.
+*
+* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
+*
+*/
+
+namespace forumhulp\htmlemail\migrations\v31x;
+
+use phpbb\db\migration\container_aware_migration;
+
+/**
+ * Migration stage 1: Initial schema
+ */
+class m1_initial_file extends container_aware_migration
+{
+	/**
+	 * Assign migration file dependencies for this migration
+	 *
+	 * @return array Array of migration files
+	 * @static
+	 * @access public
+	 */
+	static public function depends_on()
+	{
+		return array('\phpbb\db\migration\data\v310\gold');
+	}
+
+	/**
+	* Add core change to the files.
+	*
+	* @return array Array of files
+	* @access public
+	*/
+	public function update_data()
+	{
+		$this->revert = false;
+		return array(
+			array('custom', array(array($this, 'update_files'))),
+		);
+	}
+
+	public function revert_data()
+	{
+		$this->revert = true;
+		return array(
+			array('custom', array(array($this, 'update_files'))),
+		);
+	}
+
+	public function update_files()
+	{
+		if (class_exists('forumhulp\helper\helper'))
+		{
+			if (!$this->container->has('forumhulp.helper'))
+			{
+				$forumhulp_helper = new \forumhulp\helper\helper(
+					$this->container->get('dbal.conn'),
+					$this->config,
+					$this->container->get('ext.manager'),
+					$this->container->get('template'),
+					$this->container->get('user'),
+					$this->container->get('request'),
+					$this->container->get('log'),
+					$this->container->get('cache'),
+					$this->phpbb_root_path			
+				);
+				$this->container->set('forumhulp.helper', $forumhulp_helper);
+			}
+			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
+		} else
+		{
+			$this->container->get('user')->add_lang_ext('forumhulp/htmlemail', 'info_acp_htmlemail');
+			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
+		}
+	}
+
+	public function data()
+	{
+		$replacements = array(
+			'files' => array(
+				0 => '/includes/functions_messenger.' . $this->php_ext,
+				),
+			'searches' => array(
+				0 => array(
+					0 => '	var $use_queue = true;',
+					1 => '		$this->subject = \'\';',
+					2 => '		$this->mail_priority = $priority;',
+					3 => '$headers[] = \'Content-Type: text/plain; charset=UTF-8\';',
+					4 => '\'EMAIL_SIG\'	=> str_replace(\'<br />\', "\n", "-- \n" . htmlspecialchars_decode($config[\'board_email_sig\'])),',
+					5 => '\'SITENAME\'	=> htmlspecialchars_decode($config[\'sitename\']),',
+					),
+				),
+			'replaces' => array(
+				0 => array(
+					0 => '	var $use_queue = true;
+	var $use_html = false;',
+					1 => '		$this->subject = \'\';
+		$this->use_html = false;',
+					2 => '		$this->mail_priority = $priority;
+	}
+	
+	/**
+	* Set the email html
+	*/
+	function set_mail_html($html = false)
+	{
+		$this->use_html = $html;',
+					3 => '$headers[] = \'Content-Type: \' . (($this->use_html) ? \'text/html;\' : \'text/plain;\')  . \' charset=UTF-8\';',
+					4 => '\'EMAIL_SIG\'	=> "-- \n" . $config[\'board_email_sig\'],',
+					5 => '\'SITENAME\'	=> $config[\'sitename\'],',
+					),
+				)
+			);
+		return $replacements;
+	}
+}
diff --git "[FORUM_EXT]/forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php" "[FORUM_EXT]/forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\htmlemail/migrations/v32x/m1_initial_file.php"
@@ -0,0 +1,103 @@
+<?php
+/**
+*
+* HTML email extension for the phpBB Forum Software package.
+*
+* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
+*
+*/
+
+namespace forumhulp\htmlemail\migrations\v32x;
+
+use phpbb\db\migration\container_aware_migration;
+
+/**
+ * Migration stage 1: Initial schema
+ */
+class m1_initial_file extends container_aware_migration
+{
+	/**
+	 * Assign migration file dependencies for this migration
+	 *
+	 * @return array Array of migration files
+	 * @static
+	 * @access public
+	 */
+	static public function depends_on()
+	{
+		return array('\forumhulp\htmlemail\migrations\v31x\m1_initial_file');
+	}
+
+	/**
+	* Add core change to the files.
+	*
+	* @return array Array of files
+	* @access public
+	*/
+	public function update_data()
+	{
+		$this->revert = false;
+		return array(
+			array('custom', array(array($this, 'update_files'))),
+		);
+	}
+
+	public function revert_data()
+	{
+		$this->revert = true;
+		return array(
+			array('custom', array(array($this, 'update_files'))),
+		);
+	}
+
+	public function update_files()
+	{
+		if (class_exists('forumhulp\helper\helper'))
+		{
+			if (!$this->container->has('forumhulp.helper'))
+			{
+				$forumhulp_helper = new \forumhulp\helper\helper(
+					$this->container->get('dbal.conn'),
+					$this->config,
+					$this->container->get('ext.manager'),
+					$this->container->get('template'),
+					$this->container->get('user'),
+					$this->container->get('request'),
+					$this->container->get('log'),
+					$this->container->get('cache'),
+					$this->phpbb_root_path			
+				);
+				$this->container->set('forumhulp.helper', $forumhulp_helper);
+			}
+			$this->container->get('forumhulp.helper')->update_files($this->data(), $this->revert);
+		} else
+		{
+			$this->container->get('user')->add_lang_ext('forumhulp/htmlemail', 'info_acp_htmlemail');
+			trigger_error($this->container->get('user')->lang['FH_HELPER_NOTICE'], E_USER_WARNING);	
+		}
+	}
+
+	public function data()
+	{
+		$replacements = array(
+			'files' => array(
+				0 => '/phpbb/notification/method/messenger_base.' . $this->php_ext,
+				),
+			'searches' => array(
+				0 => array(
+					0 => '$messenger = new \messenger();'
+					)
+				),
+			'replaces' => array(
+				0 => array(
+					0 => '$messenger = new \messenger();
+
+		$use_html = method_exists($messenger, \'set_mail_html\');
+		($use_html) ? $messenger->set_mail_html($this->config[\'html_email_on_birthday\']) : null;'
+					)
+				)
+			);
+		return $replacements;
+	}
+}
diff --git "[ORIGINAL]/forumhulp\\htmlemail/migrations/v33x/m1_initial_file.php" "[ORIGINAL]/forumhulp\\htmlemail/migrations/v33x/m1_initial_file.php"
deleted file mode 100644
--- "[ORIGINAL]/forumhulp\\htmlemail/migrations/v33x/m1_initial_file.php"
+++ /dev/null
@@ -1,31 +0,0 @@
-<?php
-/**
-*
-* HTML email extension for the phpBB Forum Software package.
-*
-* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-namespace forumhulp\htmlemail\migrations\v33x;
-
-use phpbb\db\migration\container_aware_migration;
-
-/**
- * Migration stage 1: Initial schema
- */
-class m1_initial_file extends container_aware_migration
-{
-	/**
-	 * Assign migration file dependencies for this migration
-	 *
-	 * @return array Array of migration files
-	 * @static
-	 * @access public
-	 */
-	static public function depends_on()
-	{
-		return array('\phpbb\db\migration\data\v330\v330');
-	}
-}
```
