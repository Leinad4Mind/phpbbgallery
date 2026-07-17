Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/acp/activitystats_info.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/acp/activitystats_module.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/adm/style/activitystats.html" "[FORUM_EXT]/leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/composer.json" "[FORUM_EXT]/leinad4mind\\specialactivitystats/composer.json"
--- "[ORIGINAL]/leinad4mind\\specialactivitystats/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\specialactivitystats/composer.json"
@@ -23,7 +23,7 @@
         "composer/installers": "~1.0.0"
     },
 	"extra": {
-		"display-name": "Activity Stats",
+		"display-name": "Special Activity Stats",
 		"soft-require": {
 			"phpbb/phpbb": ">=3.2.0,<3.3.0"
 		},
diff --git "[FORUM_EXT]/leinad4mind\\specialactivitystats/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\specialactivitystats/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialactivitystats/diff_full.tmp"
@@ -0,0 +1,185 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/composer.json"
+index 611bbf6a1..0551fe8c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/composer.json"
+@@ -23,7 +23,7 @@
+         "composer/installers": "~1.0.0"
+     },
+ 	"extra": {
+-		"display-name": "Activity Stats",
++		"display-name": "Special Activity Stats",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.2.0,<3.3.0"
+ 		},
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/ext.php"
+index 1a5d55466..82ab4a157 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/ext.php"
+@@ -9,7 +9,7 @@
+  *
+  */
+ 
+-namespace robertheim\activitystats;
++namespace leinad4mind\specialactivitystats;
+ 
+ /**
+  * @ignore
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/permissions_specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/permissions_activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/permissions_specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/specialactivitystats.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/activitystats.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/specialactivitystats.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/specialactivitystats_acp.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/activitystats_acp.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/specialactivitystats_acp.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/MODES.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/modes.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/MODES.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/modes.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/PERMISSIONS.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/permissions.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/PERMISSIONS.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/permissions.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/PREFIXES.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/prefixes.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/PREFIXES.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/prefixes.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/TABLES.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/tables.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/TABLES.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/tables.php"
diff --git "[FORUM_EXT]/leinad4mind\\specialactivitystats/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\specialactivitystats/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialactivitystats/diff_nospace.tmp"
@@ -0,0 +1,188 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/composer.json"
+index 611bbf6a1..0551fe8c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/composer.json"
+@@ -23,7 +23,7 @@
+         "composer/installers": "~1.0.0"
+     },
+ 	"extra": {
+-		"display-name": "Activity Stats",
++		"display-name": "Special Activity Stats",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.2.0,<3.3.0"
+ 		},
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp"
+new file mode 100644
+index 000000000..cb69542d9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp"
+@@ -0,0 +1,185 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_info.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_info.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/acp/activitystats_module.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/acp/specialactivitystats_module.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/adm/style/activitystats.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/adm/style/specialactivitystats.html"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/composer.json"
++index 611bbf6a1..0551fe8c7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/composer.json"
++@@ -23,7 +23,7 @@
++         "composer/installers": "~1.0.0"
++     },
++ 	"extra": {
++-		"display-name": "Activity Stats",
+++		"display-name": "Special Activity Stats",
++ 		"soft-require": {
++ 			"phpbb/phpbb": ">=3.2.0,<3.3.0"
++ 		},
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/ext.php"
++index 1a5d55466..82ab4a157 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/ext.php"
++@@ -9,7 +9,7 @@
++  *
++  */
++ 
++-namespace robertheim\activitystats;
+++namespace leinad4mind\specialactivitystats;
++ 
++ /**
++  * @ignore
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/permissions_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/permissions_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/permissions_activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/permissions_specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats_acp.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats_acp.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats_acp.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_activitystats.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_specialactivitystats.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_activitystats.php"
++rename to "C:\\Users\\Lei
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/ext.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/ext.php"
--- "[ORIGINAL]/leinad4mind\\specialactivitystats/ext.php"
+++ "[FORUM_EXT]/leinad4mind\\specialactivitystats/ext.php"
@@ -9,7 +9,7 @@
  *
  */
 
-namespace robertheim\activitystats;
+namespace leinad4mind\specialactivitystats;
 
 /**
  * @ignore
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/ar/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/ar/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/ar/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/ar/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/ar/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/ar/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/ar/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/ar/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/ar/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/ar/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/de/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/de/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/de/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/de/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/de/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/de/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/de/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/de/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/de/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/de/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/en/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/en/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/en/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/en/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/en/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/en/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/en/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/en/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/en/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/en/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/es/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/es/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/es/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/es/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/es/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/es/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/es/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/es/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/es/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/es/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/fr/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/fr/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/fr/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/fr/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/fr/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/fr/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/fr/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/fr/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/fr/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/fr/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/it/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/it/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/it/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/it/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/it/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/it/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/it/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/it/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/it/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/it/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/nl/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/nl/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/nl/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/nl/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/nl/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/nl/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/nl/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/nl/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/nl/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/nl/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/pl/info_acp_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/pl/info_acp_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/info_acp_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/pl/permissions_activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/pl/permissions_specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/permissions_activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/permissions_specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/pl/activitystats.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/pl/specialactivitystats.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/activitystats.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/specialactivitystats.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/language/pl/activitystats_acp.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/language/pl/specialactivitystats_acp.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/language/pl/activitystats_acp.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/language/pl/specialactivitystats_acp.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/MODES.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/modes.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/MODES.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/modes.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/PERMISSIONS.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/permissions.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/PERMISSIONS.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/permissions.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/PREFIXES.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/prefixes.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/PREFIXES.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/prefixes.php"
diff --git "[ORIGINAL]/leinad4mind\\specialactivitystats/TABLES.php" "[FORUM_EXT]/leinad4mind\\specialactivitystats/tables.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialactivitystats/TABLES.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialactivitystats/tables.php"
```
