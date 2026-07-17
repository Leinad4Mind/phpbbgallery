Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/composer.json" "[FORUM_EXT]/wolfsblvt\\advancedpolls/composer.json"
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/composer.json"
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/composer.json"
@@ -3,8 +3,8 @@
 	"type": "phpbb-extension",
 	"description": "Advances the core poll system of phpBB with new features like hiding votes till end, showing poll voters, limiting the votes and more.",
 	"homepage": "https://github.com/jasoloz/advancedpolls",
-	"version": "1.2.4.3",
-	"time": "2022-11-29",
+	"version": "1.2.4.1",
+	"time": "2020-02-20",
 	"keywords": ["phpbb", "extension", "advancedpolls", "advanced", "poll"],
 	"license": "GPL-2.0",
 	"authors": [
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/diff_full.tmp" "[FORUM_EXT]/wolfsblvt\\advancedpolls/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/diff_full.tmp"
@@ -0,0 +1,1606 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/composer.json"
+index 971cad836..d15f03668 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/composer.json"
+@@ -3,8 +3,8 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Advances the core poll system of phpBB with new features like hiding votes till end, showing poll voters, limiting the votes and more.",
+ 	"homepage": "https://github.com/jasoloz/advancedpolls",
+-	"version": "1.2.4.3",
+-	"time": "2022-11-29",
++	"version": "1.2.4.1",
++	"time": "2020-02-20",
+ 	"keywords": ["phpbb", "extension", "advancedpolls", "advanced", "poll"],
+ 	"license": "GPL-2.0",
+ 	"authors": [
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls.php"
+deleted file mode 100644
+index 651efe50d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls.php"
++++ /dev/null
+@@ -1,92 +0,0 @@
+-<?php
+-/**
+- *
+- * Advanced Polls [Japanese]
+- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
+- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+- * @author Clemens Husung (Wolfsblvt)
+- */
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
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ADVANCEDPOLLS_EXT_NAME'			=> 'Advanced Polls',
+-
+-// Viewtopic
+-	'AP_VOTES_HIDDEN'				=> '結果は表示されません',
+-	'AP_POLL_RUN_TILL_APPEND'			=> '。終了まで投票結果は非表示となります。',
+-	'AP_VOTERS'					=> '投票者',
+-	'AP_NONE'					=> 'なし',
+-
+-	'AP_POLL_CANT_VOTE'				=> 'この投票には参加できません。理由：',
+-	'AP_POLL_REASON_NOT_POSTED'			=> 'まだこのトピックで投稿を行っていません。',
+-	'AP_POLL_VOTES_ARE_VISIBLE'			=> '投票後にあなたの投票が見えるようになります。',
+-	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> '投票せずに結果を表示する',
+-	'AP_POLL_RESULTS_ARE_ORDERED'			=> '投票結果は得票数の多い順に並びます',
+-	'AP_POLL_TYPE_MISMATCH'				=> '一貫性のない投票データのため内部エラーが発生しました',
+-	'AP_VOTE_CHANGED'				=> '投票内容を変更する権限がありません。',
+-	'AP_TOO_MANY_VOTES'				=> '投票オプション数が多すぎます。', // You have tried to assign too many votes.
+-
+-	'AP_MAX_VOTES_SELECT'					=> array(
+-		1	=> '<strong>%1$d</strong> オプションに最大 <strong>%2$d</strong> 票を投じることができます',
+-		2	=> '<strong>%1$d</strong> オプションの中から最大 <strong>%2$d</strong> 票を投じることができます',
+-	),
+-	'AP_GUEST_VOTES'						=> array(
+-		1	=> 'ゲスト票：%d 票', // %d vote from guest
+-		2	=> 'ゲスト票：%d 票', // %d votes from guests
+-	),
+-
+-// Posting
+-	'AP_POLL_VOTES_HIDE'				=> '投票結果を非表示にする',
+-	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'これを有効にすると、投票結果は投票が終了するまで非表示になります。この項目は特定の期限設定を持つ場合のみ動作します。',
+-	'AP_POLL_VOTERS_SHOW'				=> '投票者を表示する',
+-	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'これを有効にすると、閲覧権限を持つユーザーにのみ投票者が表示されます。投票結果を非表示にしている場合は投票者も非表示になります。',
+-	'AP_POLL_VOTERS_LIMIT'				=> '投票対象者を制限する',
+-	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'これを有効にすると、このトピックに記事を投稿した人だけが投票できます',
+-	'AP_POLL_SHOW_ORDERED'				=> '得票順に表示する',
+-	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> '投票結果が表示されるとき、得票数の降順に並びます（得票数の高いもの順）。未選択の場合は投票オプションの順序が使用されます。',
+-	'AP_RUN_POLL'					=> '投票期間',
+-	'AP_RUN_POLL_FOR'				=> '日数指定',
+-	'AP_RUN_POLL_UNTIL'				=> '終了日指定',
+-	'AP_RUN_POLL_INDEFINITELY'			=> '無期限',
+-	'AP_POLL_END'					=> '投票終了',
+-	'AP_POLL_END_EXPLAIN'				=> '投票終了日時を指定してください。これらのフィールドのいずれかが指定されている場合、投票の期間を上書きします。日付フィールドは空のままで、デフォルトは現在の投票終了日です。時間フィールドは空のままで、デフォルトは0です。投票期間を使用するために戻す場合は、これらすべてのフィールドを消去する必要があります。',
+-
+-	'AP_YYYY_MM_DD'					=> 'YYYY-MM-DD',
+-	'AP_HH_MM'					=> 'HH:MM',
+-	'AP_POLL_END_INVALID'				=> '指定した日/時に誤りがあります',
+-	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> '1つのオプションの投票数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
+-	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> '投票可能なオプション数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
+-
+-	'AP_POLL_MAX_VALUE'				=> '最大投票数',
+-	'AP_POLL_MAX_VALUE_EXPLAIN'			=> '投票者が1つのオプションに付与できる最大投票数です',
+-	'AP_POLL_TOTAL_VALUE'				=> '投票者数',
+-	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> '投票者がすべてのオプションに分配する可能性のある投票の総数です',
+-
+-	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> '許可されている最大値を超える投票数を割り当てることはできません',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php"
+deleted file mode 100644
+index d5632802d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php"
++++ /dev/null
+@@ -1,75 +0,0 @@
+-<?php
+-/**
+- *
+- * Advanced Polls [Japanese]
+- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
+- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+- * @author Clemens Husung (Wolfsblvt)
+- */
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
+-//
+-
+-$lang = array_merge($lang, array(
+-	'AP_TITLE_ACP'				=> 'Advanced Polls',
+-	'AP_SETTINGS_ACP'			=> '設定',
+-
+-	'AP_TITLE'				=> 'Advanced Polls',
+-	'AP_TITLE_EXPLAIN'			=> 'phpBBのコア投票システムを、投票終了まで結果を非表示にする、投票したユーザーを表示する、投票可能ユーザーを制限するなどの新機能を使用して進化向上します。',
+-	'AP_COPYRIGHT'				=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Wolfsblvt が提供するその他の拡張モジュール</a>]',
+-
+-	'AP_SETTINGS'				=> 'Advanced Polls の設定',
+-	'AP_GLOBAL_SETTINGS'			=> 'Advanced Polls のグローバル設定（全ての投票に適用されます）',
+-	'AP_PER_POLL_SETTINGS'			=> 'Advanced Polls の投票ごとの設定（投票ごとに選択可能、デフォルト値はここで設定）',
+-
+-	'AP_ACT_VOTES_HIDE'			=> '投票結果非表示を有効にする',
+-	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> '投票が終了するまで投票結果を非表示にすることを選択するオプションを有効化します。',
+-	'AP_ACT_VOTERS_SHOW'			=> '投票者表示を有効にする',
+-	'AP_ACT_VOTERS_SHOW_EXPLAIN'		=> '各投票オプションに対して投票投票者を表示することを選択するオプションを有効化します。',
+-	'AP_ACT_VOTERS_LIMIT'			=> '投票者制限を有効にする',
+-	'AP_ACT_VOTERS_LIMIT_EXPLAIN'		=> 'このトピックで既に投稿したユーザーにのみ投票を制限することを選択するオプションを有効化します。',
+-	'AP_ACT_POLL_NO_VOTE'			=> '無投票を有効にする',
+-	'AP_ACT_POLL_NO_VOTE_EXPLAIN'		=> '標準の「結果を表示する」リンクから「投票せずに結果を表示する」リンクに変更します。「投票を変更する」を選択しない限り、結果を表示した後に投票できません。',
+-	'AP_ACT_SHOW_ORDERED'			=> '得票順表示を有効にする',
+-	'AP_ACT_SHOW_ORDERED_EXPLAIN'		=> '得票の降順（得票数の高いもの順）で結果を表示することを選択するオプションを有効化します。',
+-	'AP_ACT_POLL_SCORING'			=> '投票スコアリングを有効にする',
+-	'AP_ACT_POLL_SCORING_EXPLAIN'		=> '投票オプションに異なるスコアを割り当てる可能性を有効化します。',
+-	'AP_ACT_INCREMENTAL_VOTES'		=> '段階投票を有効にする', // Activate incremental voting
+-	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> '利用可能な投票機能を使い果たしていない間、段階的に投票する可能性を有効化します。',
+-	'AP_ACT_CLOSED_VOTING'			=> '閉鎖トピックの投票を有効にする', // Activate closed voting
+-	'AP_ACT_CLOSED_VOTING_EXPLAIN'		=> '対応するトピックが閉鎖されている場合でも、公開投票に投票する可能性を有効化します。',
+-	'AP_ACT_POLL_END'			=> '投票終了設定を有効にする',
+-	'AP_ACT_POLL_END_EXPLAIN'		=> '投票が開始されてから投票期間を指定するだけでなく、日付/時刻で投票が終了するタイミングを指定できます。',
+-	'AP_ACT_POLL_NOTIFICATIONS'		=> '投票通知を有効にする',
+-	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'	=> '投票結果を非表示にした投票が終了したときに全ての投票者に通知を送る機能を有効にします。それに従い、投票結果が見えるようになります。',
+-
+-	'AP_DEFAULT_VOTES_CHANGE'		=> '再投票許可の設定をデフォルトにする',
+-	'AP_DEFAULT_VOTES_HIDE'			=> '投票結果非表示の設定をデフォルトにする',
+-	'AP_DEFAULT_VOTERS_SHOW'		=> '投票者表示の設定をデフォルトにする',
+-	'AP_DEFAULT_VOTERS_LIMIT'		=> '投票者制限の設定をデフォルトにする',
+-	'AP_DEFAULT_SHOW_ORDERED'		=> '得票順表示をデフォルトにする',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls.php"
+deleted file mode 100644
+index b0a3b7e23..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls.php"
++++ /dev/null
+@@ -1,92 +0,0 @@
+-<?php
+-/**
+- *
+- * Advanced Polls [Polish]
+- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
+- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+- * @author Clemens Husung (Wolfsblvt)
+- */
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
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ADVANCEDPOLLS_EXT_NAME'				=> 'Zaawansowane głosowanie',
+-
+-// Viewtopic
+-	'AP_VOTES_HIDDEN'						=> 'Ukryte głosy',
+-	'AP_POLL_RUN_TILL_APPEND'				=> ', do tej pory wszystkie głosy będą ukryte.',
+-	'AP_VOTERS'								=> 'Głosujący',
+-	'AP_NONE'								=> 'Brak',
+-
+-	'AP_POLL_CANT_VOTE'						=> 'Nie możesz głosować w tej ankiecie. Powód',
+-	'AP_POLL_REASON_NOT_POSTED'				=> 'nie pisałeś w tym wątku.',
+-	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Jeśli głosujesz, Twój głos będzie widoczny.',
+-	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Nie głosuj, zobacz wyniki, ale stracisz prawo do głosowania',
+-	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Wyniki są ułożone według malejącej ilości otrzymanych głosów.',
+-	'AP_POLL_TYPE_MISMATCH'					=> 'Niespójne dane ankiety, błąd wewnętrzny.',
+-	'AP_VOTE_CHANGED'						=> 'Nie masz uprawnień do zmiany oddanych głosów.',
+-	'AP_TOO_MANY_VOTES'						=> 'Próbowałeś oddać zbyt wiele głosów.',
+-
+-	'AP_MAX_VOTES_SELECT'					=> array(
+-		1	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głos na <strong>%1$d</strong> opcję',
+-		2	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głosów wśród <strong>%1$d</strong> opcji',
+-	),
+-	'AP_GUEST_VOTES'						=> array(
+-		1	=> '%d głos od Gościa',
+-		2	=> '%d głosy od Gości',
+-	),
+-
+-// Posting
+-	'AP_POLL_VOTES_HIDE'					=> 'Ukryj głosy',
+-	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Jeśli włączone, głosy będą ukryte do końca głosowania. Ta opcja działa jeśli jest wyznaczony koniec ankiety.',
+-	'AP_POLL_VOTERS_SHOW'					=> 'Pokaż głosy głosujących',
+-	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Jeśli włączone, głosujący będą pokazani tym użytkownikom, którzy mają uprawnienia. Głosujący pozostaną ukryci jeśli głosy są ukryte.',
+-	'AP_POLL_VOTERS_LIMIT'					=> 'Ograniczenie głosów',
+-	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Jeśli włączone, użytkownicy mogą głosować tylko wtedy gdy pisali w tym wątku.',
+-	'AP_POLL_SHOW_ORDERED'					=> 'Pokaż kolejność wyników',
+-	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Wyświetlane wyniki są uporządkowane według malejącej liczby otrzymanych głosów (najpierw najwięcej głosów). W przeciwnym razie używana jest kolejność opcji ankiety.',
+-	'AP_RUN_POLL'							=> 'Uruchom ankietę',
+-	'AP_RUN_POLL_FOR'						=> 'przez',
+-	'AP_RUN_POLL_UNTIL'						=> 'aż do',
+-	'AP_RUN_POLL_INDEFINITELY'				=> 'bez końca',
+-	'AP_POLL_END'							=> 'koniec ankiety',
+-	'AP_POLL_END_EXPLAIN'					=> 'Określ datę i godzinę zakończenia ankiety. Jeśli którekolwiek z tych pól jest określone, zastępuje ono długość ankiety. Pola daty domyślnie pozostawiono puste, domyślnie bieżąca data zakończenia ankiety; pola godzin pozostawione puste, domyślnie ustawione na 0. Jeśli chcesz powrócić do korzystania z długości ankiety, będziesz musiał wyczyścić wszystkie te pola.',
+-
+-	'AP_YYYY_MM_DD'							=> 'YYYY-MM-DD',
+-	'AP_HH_MM'								=> 'HH:MM',
+-	'AP_POLL_END_INVALID'					=> 'Określona data/czas są niewłaściwe',
+-	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'Maksymalna liczba głosów przypadająca na jedną opcję nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
+-	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'Maksymalna liczba opcji głosowania nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
+-
+-	'AP_POLL_MAX_VALUE'						=> 'Maksymalna liczba głosów',
+-	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'To jest maksymalna liczba głosów, jaką głosujący może oddać na jedną opcję.',
+-	'AP_POLL_TOTAL_VALUE'					=> 'Razem głosów',
+-	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'To jest całkowita liczba głosów, jaką głosujący może rozdzielić na wszystkie opcje.',
+-
+-	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Nie możesz przydzielić liczby głosów większej niż maksymalna dozwolona wartość.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php"
+deleted file mode 100644
+index 500071750..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php"
++++ /dev/null
+@@ -1,75 +0,0 @@
+-<?php
+-/**
+- *
+- * Advanced Polls [Polish]
+- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
+- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+- * @author Clemens Husung (Wolfsblvt)
+- */
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
+-//
+-
+-$lang = array_merge($lang, array(
+-	'AP_TITLE_ACP'					=> 'Zaawansowane głosowanie',
+-	'AP_SETTINGS_ACP'				=> 'Ustawienia',
+-
+-	'AP_TITLE'						=> 'Zaawansowane głosowanie',
+-	'AP_TITLE_EXPLAIN'				=> 'Zaawansowane głosowanie to podstawowy system ankiet phpBB z nowymi funkcjami, takimi jak ukrywanie głosów do końca, pokazywanie wyborców, ograniczanie głosów i nie tylko.',
+-	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Więcej rozszerzeń od Wolfsblvt</a>]',
+-
+-	'AP_SETTINGS'					=> 'Zaawansowane głosowanie - Ustawienia',
+-	'AP_GLOBAL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia ogólne (zastosowanie do wszystkich ankiet)',
+-	'AP_PER_POLL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia poszczególnych ankiet (do wyboru w każdej ankiecie, z ustawioną tutaj wartością domyślną)',
+-
+-	'AP_ACT_VOTES_HIDE'				=> 'Pokazuj głosy',
+-	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Wybierz tę opcję, żeby ukryć oddane głosy do końca głosowania.',
+-	'AP_ACT_VOTERS_SHOW'			=> 'Pokazuj głosujących',
+-	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Wybierz tę opcję, żeby pokazać głosujących przy każdej opcji głosowania.',
+-	'AP_ACT_VOTERS_LIMIT'			=> 'Ogranicz liczkę głosujących',
+-	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Wybierz tę opcję, żeby ograniczyć głosujących do użytkowników piszących w tym wątku.',
+-	'AP_ACT_POLL_NO_VOTE'			=> 'Pokazuj Brak głosu',
+-	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Zmienia standardowy link „Wyświetl wyniki” na link „Nie głosuj, wyświetl wyniki”, który nie zezwala na głosowanie po wyświetleniu wyników, chyba że wybrano opcję „Zmień głosy”.',
+-	'AP_ACT_SHOW_ORDERED'			=> 'Pokazuj kolejność',
+-	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Aktywuje opcję pokazania wyników w kolejności malejącej liczby otrzymanych głosów (najpierw głosowano najwyżej).',
+-	'AP_ACT_POLL_SCORING'			=> 'Pokazuj przewijanie głosowania',
+-	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Aktywuje możliwość przypisywania różnych wyników do opcji ankiety.',
+-	'AP_ACT_INCREMENTAL_VOTES'		=> 'Pokazuj stopniowanie głosów',
+-	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Aktywuje możliwość głosowania stopniowego, gdy nie wyczerpałeś dostępnych możliwości głosowania.',
+-	'AP_ACT_CLOSED_VOTING'			=> 'Pozwalaj na głosowanie zamknięte',
+-	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Włącza możliwość głosowania w otwartej ankiecie, nawet jeśli odpowiedni temat jest zablokowany.',
+-	'AP_ACT_POLL_END'				=> 'Pokazuj dokładny koniec ankiety',
+-	'AP_ACT_POLL_END_EXPLAIN'		=> 'Pozwala określić, kiedy ankieta kończy się według daty / godziny, zamiast tylko określać czas trwania ankiety od jej rozpoczęcia.',
+-	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Pokazuj powiadomienia ankiety',
+-	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Aktywuje wysyłanie powiadomień do wszystkich wyborców o ukrytej ankiecie po zakończeniu ankiety, dzięki czemu wyniki są widoczne.',
+-
+-	'AP_DEFAULT_VOTES_CHANGE'		=> 'Wybierz domyślne ustawienia zmiany oddanego głosu',
+-	'AP_DEFAULT_VOTES_HIDE'			=> 'Wybierz domyślne ustawienia ukrytych głosujących',
+-	'AP_DEFAULT_VOTERS_SHOW'		=> 'Wybierz domyślne ustawienia ilości głosujących',
+-	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Wybierz domyślne ustawienia limitu głosujących',
+-	'AP_DEFAULT_SHOW_ORDERED'		=> 'Wybierz domyślne dla pokazania kolejności',
+-));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls.php"
+new file mode 100644
+index 000000000..0cecb9792
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls.php"
+@@ -0,0 +1,94 @@
++<?php
++/**
++ *
++ * Advanced Polls [Spanish]
++ *
++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Clemens Husung (Wolfsblvt)
++ * @author Initial translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++ * @author Continued translation by javiexin (http://www.exincastillos.es)
++ * @author Continued translation by jasolo (https://github.com/jasoloz)
++ */
++
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
++	'ADVANCEDPOLLS_EXT_NAME'				=> 'Votações Avançadas',
++
++// Viewtopic
++	'AP_VOTES_HIDDEN'						=> 'Votos ocultos',
++	'AP_POLL_RUN_TILL_APPEND'				=> ', até que todos os votos estarão ocultos.',
++	'AP_VOTERS'								=> 'Votantes',
++	'AP_NONE'								=> 'Ninguém',
++
++	'AP_POLL_CANT_VOTE'						=> 'Não podes votar nesta votação. Razão',
++	'AP_POLL_REASON_NOT_POSTED'				=> 'Não escreveu neste tema.',
++	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Tem em conta que se votares, o teu voto será visível.',
++	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Não quero votar, quero ver os resultados',
++	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Os resultados estão ordenados por número decrescente de votos recebidos.',
++	'AP_POLL_TYPE_MISMATCH'					=> 'Dados inconsistentes na votação, erro interno.',
++	'AP_VOTE_CHANGED'						=> 'Não tem permissão para alterar os votos já emitidos.',
++	'AP_TOO_MANY_VOTES'						=> 'Tentou adicionar demasiados votos.',
++
++	'AP_MAX_VOTES_SELECT'					=> array(
++		1	=> 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
++		2	=> 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
++	),
++	'AP_GUEST_VOTES'						=> array(
++		1	=> '%d voto de convidado',
++		2	=> '%d votos de convidados',
++	),
++
++// Posting
++	'AP_POLL_VOTES_HIDE'					=> 'Ocultar votos',
++	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
++	'AP_POLL_VOTERS_SHOW'					=> 'Mostrar votantes da votação',
++	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Se estiver ativado, os votantes serão mostrados à quem tenha permissões. Tem em conta que os os votantes estarão ocultos caso os votos estejam ocultos.',
++	'AP_POLL_VOTERS_LIMIT'					=> 'Limite de votos',
++	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
++	'AP_POLL_SHOW_ORDERED'					=> 'Ordenar resultados',
++	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (ou mais votado primeiro). Em caso contrario, usa-se a ordem de opções na votação.',
++	'AP_RUN_POLL'							=> 'Realizar votação',
++	'AP_RUN_POLL_FOR'						=> 'durante',
++	'AP_RUN_POLL_UNTIL'						=> 'até',
++	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinidamente',
++	'AP_POLL_END'							=> 'Fim da votação',
++	'AP_POLL_END_EXPLAIN'					=> 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',
++
++	'AP_YYYY_MM_DD'							=> 'AAAA-MM-DD',
++	'AP_HH_MM'								=> 'HH:MM',
++	'AP_POLL_END_INVALID'					=> 'A data/hora especificada não é válida',
++	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
++	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',
++
++	'AP_POLL_MAX_VALUE'						=> 'Votos máximos',
++	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
++	'AP_POLL_TOTAL_VALUE'					=> 'Votos totais',
++	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',
++	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Não pode escolher um número de votos superior ao máximo permitido.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
+similarity index 75%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
+index 49e2fccb9..c325f2638 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
+@@ -1,11 +1,12 @@
+ <?php
+ /**
+  *
+- * Advanced Polls [Polish]
+- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
++ * Advanced Polls [Spanish]
++ *
+  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+  * @author Clemens Husung (Wolfsblvt)
++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+  */
+ 
+ if (!defined('IN_PHPBB'))
+@@ -35,6 +36,6 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Wyniki będą widoczne w ankiecie</strong>:',
+-	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Wyniki są teraz widoczne dla ankiety, w której głosowałeś',
++	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Resultados visíveis para a votação</strong>:',
++	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Já podes ver os resultados de uma votação em que participaste',
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php"
+new file mode 100644
+index 000000000..1ff897e6e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php"
+@@ -0,0 +1,76 @@
++<?php
++/**
++ *
++ * Advanced Polls [Spanish]
++ *
++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Clemens Husung (Wolfsblvt)
++ * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++ */
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($ang) || !is_array($ang))
++{
++	$ang = array();
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
++//
++// Paceholders can now comtain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// transators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
++// equally where a string comtains only two paceholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$ang = array_merge($ang, array(
++	'AP_TITLE_ACP'					=> 'Votações Avançadas',
++	'AP_SETTINGS_ACP'				=> 'Configuração',
++
++	'AP_TITLE'						=> 'Votações Avançadas',
++	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
++	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',
++
++	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
++	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
++	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',
++
++	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
++	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
++	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
++	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
++	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
++	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
++	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
++	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
++	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
++	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
++	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
++	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
++	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
++	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
++	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
++	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
++	'AP_ACT_POLL_END'				=> 'Activar final de votação',
++	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
++	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
++	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',
++
++	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
++	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
++	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
++	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
++	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
+similarity index 83%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
+index a4c7c0399..4f7db7f66 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
+@@ -1,11 +1,12 @@
+ <?php
+ /**
+  *
+- * Advanced Polls [Japanese]
+- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
++ * Advanced Polls [Spanish]
++ *
+  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+  * @author Clemens Husung (Wolfsblvt)
++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+  */
+ 
+ if (!defined('IN_PHPBB'))
+@@ -43,6 +44,6 @@ if (empty($lang) || !is_array($lang))
+ 
+ // User Permissions
+ $lang = array_merge($lang, array(
+-	'ACL_F_SEEVOTERS'			=> '投票者を見る', // Can see poll voters
+-	'ACL_M_SEEVOTERS'			=> '投票者情報を閲覧する', // Can view poll voters
++	'ACL_F_SEEVOTERS'			=> 'Pode ver os votantes da votação',
++	'ACL_M_SEEVOTERS'			=> 'Pode ver os votantes da votação',
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php"
+new file mode 100644
+index 000000000..0cecb9792
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php"
+@@ -0,0 +1,94 @@
++<?php
++/**
++ *
++ * Advanced Polls [Spanish]
++ *
++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Clemens Husung (Wolfsblvt)
++ * @author Initial translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++ * @author Continued translation by javiexin (http://www.exincastillos.es)
++ * @author Continued translation by jasolo (https://github.com/jasoloz)
++ */
++
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
++	'ADVANCEDPOLLS_EXT_NAME'				=> 'Votações Avançadas',
++
++// Viewtopic
++	'AP_VOTES_HIDDEN'						=> 'Votos ocultos',
++	'AP_POLL_RUN_TILL_APPEND'				=> ', até que todos os votos estarão ocultos.',
++	'AP_VOTERS'								=> 'Votantes',
++	'AP_NONE'								=> 'Ninguém',
++
++	'AP_POLL_CANT_VOTE'						=> 'Não podes votar nesta votação. Razão',
++	'AP_POLL_REASON_NOT_POSTED'				=> 'Não escreveu neste tema.',
++	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Tem em conta que se votares, o teu voto será visível.',
++	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Não quero votar, quero ver os resultados',
++	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Os resultados estão ordenados por número decrescente de votos recebidos.',
++	'AP_POLL_TYPE_MISMATCH'					=> 'Dados inconsistentes na votação, erro interno.',
++	'AP_VOTE_CHANGED'						=> 'Não tem permissão para alterar os votos já emitidos.',
++	'AP_TOO_MANY_VOTES'						=> 'Tentou adicionar demasiados votos.',
++
++	'AP_MAX_VOTES_SELECT'					=> array(
++		1	=> 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
++		2	=> 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
++	),
++	'AP_GUEST_VOTES'						=> array(
++		1	=> '%d voto de convidado',
++		2	=> '%d votos de convidados',
++	),
++
++// Posting
++	'AP_POLL_VOTES_HIDE'					=> 'Ocultar votos',
++	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
++	'AP_POLL_VOTERS_SHOW'					=> 'Mostrar votantes da votação',
++	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Se estiver ativado, os votantes serão mostrados à quem tenha permissões. Tem em conta que os os votantes estarão ocultos caso os votos estejam ocultos.',
++	'AP_POLL_VOTERS_LIMIT'					=> 'Limite de votos',
++	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
++	'AP_POLL_SHOW_ORDERED'					=> 'Ordenar resultados',
++	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (ou mais votado primeiro). Em caso contrario, usa-se a ordem de opções na votação.',
++	'AP_RUN_POLL'							=> 'Realizar votação',
++	'AP_RUN_POLL_FOR'						=> 'durante',
++	'AP_RUN_POLL_UNTIL'						=> 'até',
++	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinidamente',
++	'AP_POLL_END'							=> 'Fim da votação',
++	'AP_POLL_END_EXPLAIN'					=> 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',
++
++	'AP_YYYY_MM_DD'							=> 'AAAA-MM-DD',
++	'AP_HH_MM'								=> 'HH:MM',
++	'AP_POLL_END_INVALID'					=> 'A data/hora especificada não é válida',
++	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
++	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',
++
++	'AP_POLL_MAX_VALUE'						=> 'Votos máximos',
++	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
++	'AP_POLL_TOTAL_VALUE'					=> 'Votos totais',
++	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',
++	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Não pode escolher um número de votos superior ao máximo permitido.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
+similarity index 75%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
+index 8a90662d6..c325f2638 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
+@@ -1,11 +1,12 @@
+ <?php
+ /**
+  *
+- * Advanced Polls [Japanese]
+- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
++ * Advanced Polls [Spanish]
++ *
+  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+  * @author Clemens Husung (Wolfsblvt)
++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+  */
+ 
+ if (!defined('IN_PHPBB'))
+@@ -35,6 +36,6 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>投票結果が表示されます</strong>:',
+-	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> '投票した結果が表示されるようになりました',
++	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Resultados visíveis para a votação</strong>:',
++	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Já podes ver os resultados de uma votação em que participaste',
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php"
+new file mode 100644
+index 000000000..1ff897e6e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php"
+@@ -0,0 +1,76 @@
++<?php
++/**
++ *
++ * Advanced Polls [Spanish]
++ *
++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Clemens Husung (Wolfsblvt)
++ * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++ */
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($ang) || !is_array($ang))
++{
++	$ang = array();
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
++//
++// Paceholders can now comtain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// transators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
++// equally where a string comtains only two paceholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$ang = array_merge($ang, array(
++	'AP_TITLE_ACP'					=> 'Votações Avançadas',
++	'AP_SETTINGS_ACP'				=> 'Configuração',
++
++	'AP_TITLE'						=> 'Votações Avançadas',
++	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
++	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',
++
++	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
++	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
++	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',
++
++	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
++	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
++	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
++	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
++	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
++	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
++	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
++	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
++	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
++	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
++	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
++	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
++	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
++	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
++	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
++	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
++	'AP_ACT_POLL_END'				=> 'Activar final de votação',
++	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
++	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
++	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',
++
++	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
++	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
++	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
++	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
++	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
+similarity index 57%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
+index e03192a8c..4f7db7f66 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
+@@ -1,11 +1,12 @@
+ <?php
+ /**
+  *
+- * Advanced Polls [Polish]
+- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
++ * Advanced Polls [Spanish]
++ *
+  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+  * @author Clemens Husung (Wolfsblvt)
++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+  */
+ 
+ if (!defined('IN_PHPBB'))
+@@ -31,18 +32,18 @@ if (empty($lang) || !is_array($lang))
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ 
+ /**
+-*	EXTENSION-DEVELOPERS PLEASE NOTE
+-*
+-*	You are able to put your permission sets into your extension.
+-*	The permissions logic should be added via the 'core.permissions' event.
+-*	You can easily add new permission categories, types and permissions, by
+-*	simply merging them into the respective arrays.
+-*	The respective language strings should be added into a language file, that
+-*	start with 'permissions_', so they are automatically loaded within the ACP.
+-*/
++ * EXTENSION-DEVELOPERS PLEASE NOTE
++ *
++ * You are able to put your permission sets into your extension.
++ * The permissions logic should be added via the 'core.permissions' event.
++ * You can easily add new permission categories, types and permissions, by
++ * simply merging them into the respective arrays.
++ * The respective language strings should be added into a language file, that
++ * start with 'permissions_', so they are automatically loaded within the ACP.
++ */
+ 
+ // User Permissions
+ $lang = array_merge($lang, array(
+-	'ACL_F_SEEVOTERS'			=> 'Możesz zobaczyć głosujących.',
+-	'ACL_M_SEEVOTERS'			=> 'Możesz wyświetlać głosujących w ankiecie.',
++	'ACL_F_SEEVOTERS'			=> 'Pode ver os votantes da votação',
++	'ACL_M_SEEVOTERS'			=> 'Pode ver os votantes da votação',
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store"
+new file mode 100644
+index 000000000..8ed203817
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..52c53ea7d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,5 @@
++<!-- IF AP_JSON_DATA -->
++	<script>
++		{AP_JSON_DATA}
++	</script>
++<!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
+new file mode 100644
+index 000000000..31401bef2
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
+@@ -0,0 +1,27 @@
++<!-- IF S_DISPLAY_PREVIEW and WOLFSBLVT_POLL_SCORING -->
++<!-- IF not $INCLUDED_JXTOOLSJS -->
++    <!-- INCLUDEJS lib/jxtools.js -->
++	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
++<!-- ENDIF -->
++<div id="ap_poll_preview_hidden_container" style="display:none;" jxdom-target="#preview fieldset.polls" jxdom-action="replace">
++	<fieldset>
++		<div class="panel panel-default panel-poll">
++			<div class="panel-heading">
++				<!-- BEGIN poll_option -->
++					<div class="pull-left">
++						<label for="vote_{poll_option.POLL_OPTION_ID}">{poll_option.POLL_OPTION_CAPTION}</label>
++						<div class="poll_option_select pull-left">
++							
++							<!-- IF AP_IS_SCORING -->
++								<select name="vote_id[{poll_option.POLL_OPTION_ID}]" id="vote_{poll_option.POLL_OPTION_ID}">{poll_option.AP_POLL_OPTION_OPTS}</select>
++							<!-- ELSE -->
++								<input type="<!-- IF S_IS_MULTI_CHOICE -->checkbox<!-- ELSE -->radio<!-- ENDIF -->" name="vote_id[]" id="vote_{poll_option.POLL_OPTION_ID}" value="{poll_option.POLL_OPTION_ID}" />
++							<!-- ENDIF -->
++						</div>
++					</div>
++				<!-- END poll_option -->
++			</div>
++		</div>
++	</fieldset>
++</div>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html"
+new file mode 100644
+index 000000000..de6bd61f8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html"
+@@ -0,0 +1,115 @@
++<!-- IF S_SHOW_POLL_BOX -->
++<!-- IF WOLFSBLVT_POLL_END or WOLFSBLVT_POLL_SCORING -->
++<!-- IF not $INCLUDED_JXTOOLSJS -->
++    <!-- INCLUDEJS lib/jxtools.js -->
++	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
++<!-- ENDIF -->
++<!-- ENDIF -->
++
++<!-- IF WOLFSBLVT_POLL_END -->
++<!-- INCLUDEJS js/poll_length_posting.js -->
++<div id="ap_poll_length_container" style="display:none;" jxdom-target="label > #poll_length" jxdom-closest="div" jxdom-action="replace">
++	<!-- Replace the div ancestor of a #poll_length element directly under a label with the contents of this element -->
++	<div class="control-group">
++		<label for="wolfsblvt_poll_duration">{L_AP_RUN_POLL}{L_COLON}</label>
++		<div class="controls controls-row">
++			<select name="wolfsblvt_poll_duration" id="wolfsblvt_poll_duration" onchange="apChangeDuration(this.value);">
++				<option value="" selected="selected">{L_AP_RUN_POLL_INDEFINITELY}</option>
++				<option value="wolfsblvt_poll_length">{L_AP_RUN_POLL_FOR}</option>
++				<option value="wolfsblvt_poll_end">{L_AP_RUN_POLL_UNTIL}</option>
++			</select>
++			<span id="wolfsblvt_poll_length" style="display: none; margin: 0px 10px;">
++				<input style="width: 4em !important;" id="poll_length" name="poll_length" size="3" maxlength="3" min="0" max="999" value="{POLL_LENGTH}" class="inputbox autowidth" type="number" onchange="apAdjustLength(this.value);">
++				<select name="wolfsblvt_poll_length_scale" onchange="apAdjustLengthScale(this.value);">
++					<option value="1">{L_HOURS}</option>
++					<option value="24" selected="selected">{L_DAYS}</option>
++				</select>
++				&nbsp;
++				<strong id="wolfsblvt_poll_end_label"></strong>
++			</span>
++			<span id="wolfsblvt_poll_end" style="display: none; margin: 0px 10px;">
++				<input style="width: 5em !important;" size="4" maxlength="4" id="wolfsblvt_poll_end_year" name="wolfsblvt_poll_end_year" value="{WOLFSBLVT_POLL_END_YEAR}" type="number" onchange="apAdjustEnd('year',this.value);">
++				<input style="width: 3em !important;" size="2" maxlength="2" min="1" max="12" id="wolfsblvt_poll_end_mon" name="wolfsblvt_poll_end_mon" value="{WOLFSBLVT_POLL_END_MON}" type="number" onchange="apAdjustEnd('mon',this.value);">
++				<input style="width: 3em !important;" size="2" maxlength="2" min="1" max="31" id="wolfsblvt_poll_end_mday" name="wolfsblvt_poll_end_mday" value="{WOLFSBLVT_POLL_END_MDAY}" type="number" onchange="apAdjustEnd('mday',this.value);">
++				&nbsp;
++				<input style="width: 3em !important;" size="2" maxlength="2" min="0" max="23" id="wolfsblvt_poll_end_hours" name="wolfsblvt_poll_end_hours" value="{WOLFSBLVT_POLL_END_HOURS}" type="number" onchange="apAdjustEnd('hours',this.value);">
++				<input style="width: 3em !important;" size="2" maxlength="2" min="0" max="59" id="wolfsblvt_poll_end_minutes" name="wolfsblvt_poll_end_minutes" value="{WOLFSBLVT_POLL_END_MINUTES}" type="number" onchange="apAdjustEnd('minutes',this.value);">
++				&nbsp;
++				{L_AP_YYYY_MM_DD} {L_AP_HH_MM}
++			</span>
++		</div>
++	</div>
++	<hr class="dashed" />
++</div>
++<!-- ENDIF -->
++
++<!-- IF WOLFSBLVT_POLL_SCORING -->
++<span style="display:none;" jxdom-target="#poll_max_options" jxdom-closest=".col-md-4" jxdom-action="remove">
++<!-- Remove the #poll_max_options div ancestor, to be replaced by the following div block (in a different position in the DOM, closer to other similar options) -->
++</span>
++<div class="control-group">
++	<label class="control-label" for="poll_max_options">{L_POLL_MAX_OPTIONS}{L_COLON}</label><span class="help-block">{L_POLL_MAX_OPTIONS_EXPLAIN}</span>
++	<div class="input-group col-xs-8 col-sm-2 col-md-2">
++		<input type="number" min="0" max="999" name="poll_max_options" id="wolfsblvt_poll_max_options" size="3" maxlength="3" value="{POLL_MAX_OPTIONS}" class="form-control input-sm">
++	</div>
++</div>
++<div class="control-group">
++	<label class="control-label" for="wolfsblvt_poll_max_value">{L_AP_POLL_MAX_VALUE}{L_COLON}</label><span class="help-block">{L_AP_POLL_MAX_VALUE_EXPLAIN}</span>
++	<div class="input-group col-xs-8 col-sm-2 col-md-2">
++		<input type="number" min="0" max="999" name="wolfsblvt_poll_max_value" id="wolfsblvt_poll_max_value" size="3" maxlength="3" value="{WOLFSBLVT_POLL_MAX_VALUE}" class="form-control input-sm">
++	</div>
++</div>
++<div class="control-group">
++	<label class="control-label" for="wolfsblvt_poll_total_value">{L_AP_POLL_TOTAL_VALUE}{L_COLON}</label><span class="help-block">{L_AP_POLL_TOTAL_VALUE_EXPLAIN}</span>
++	<div class="input-group col-xs-8 col-sm-2 col-md-2">
++		<input type="number" min="0" max="999" name="wolfsblvt_poll_total_value" id="wolfsblvt_poll_total_value" size="3" maxlength="3" value="{WOLFSBLVT_POLL_TOTAL_VALUE}" class="form-control input-sm">
++	</div>
++</div>
++<!-- ENDIF -->
++
++<!-- IF not WOLFSBLVT_POLL_END and not WOLFSBLVT_POLL_SCORING -->
++	<hr class="dashed" />
++<!-- ENDIF -->
++
++<!-- IF S_AP_POLL_VOTE_CHANGE -->
++<div class="control-group">
++	<label class="control-label" for="poll_vote_change">{L_POLL_VOTE_CHANGE}{L_COLON}</label>
++	<div class="controls controls-row"> 
++		<input type="checkbox" id="poll_vote_change" name="poll_vote_change"{VOTE_CHANGE_CHECKED} /> {L_POLL_VOTE_CHANGE_EXPLAIN}
++	</div>
++</div>
++<!-- ENDIF -->
++
++<!-- IF WOLFSBLVT_POLL_VOTES_HIDE -->
++<div class="control-group">
++	<label class="control-label" for="wolfsblvt_poll_votes_hide">{L_AP_POLL_VOTES_HIDE}{L_COLON}</label>
++	<div class="controls controls-row"> 
++		<input type="checkbox" id="wolfsblvt_poll_votes_hide" name="wolfsblvt_poll_votes_hide"{WOLFSBLVT_POLL_VOTES_HIDE_CHECKED} /> {L_AP_POLL_VOTES_HIDE_EXPLAIN}
++	</div>
++</div>
++<!-- ENDIF -->
++<!-- IF WOLFSBLVT_POLL_VOTERS_LIMIT -->
++<div class="control-group">
++	<label class="control-label" for="wolfsblvt_poll_voters_limit">{L_AP_POLL_VOTERS_LIMIT}{L_COLON}</label>
++	<div class="controls controls-row"> 
++		<input type="checkbox" id="wolfsblvt_poll_voters_limit" name="wolfsblvt_poll_voters_limit"{WOLFSBLVT_POLL_VOTERS_LIMIT_CHECKED} /> {L_AP_POLL_VOTERS_LIMIT_EXPLAIN}
++	</div>
++</div>
++<!-- ENDIF -->
++<!-- IF WOLFSBLVT_POLL_VOTERS_SHOW -->
++<div class="control-group">
++	<label class="control-label" for="wolfsblvt_poll_voters_show">{L_AP_POLL_VOTERS_SHOW}{L_COLON}</label>
++	<div class="controls controls-row"> 
++		<input type="checkbox" id="wolfsblvt_poll_voters_show" name="wolfsblvt_poll_voters_show"{WOLFSBLVT_POLL_VOTERS_SHOW_CHECKED} /> {L_AP_POLL_VOTERS_SHOW_EXPLAIN}
++	</div>
++</div>
++<!-- ENDIF -->
++<!-- IF WOLFSBLVT_POLL_SHOW_ORDERED -->
++<div class="control-group">
++	<label class="control-label" for="wolfsblvt_poll_show_ordered">{L_AP_POLL_SHOW_ORDERED}{L_COLON}</label>
++	<div class="controls controls-row"> 
++		<input type="checkbox" id="wolfsblvt_poll_show_ordered" name="wolfsblvt_poll_show_ordered"{WOLFSBLVT_POLL_SHOW_ORDERED_CHECKED} /> {L_AP_POLL_SHOW_ORDERED_EXPLAIN}
++	</div>
++</div>
++<!-- ENDIF -->
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html"
+new file mode 100644
+index 000000000..78adf66b4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html"
+@@ -0,0 +1,30 @@
++<!-- IF not $INCLUDED_WOLFSBLVTADVANCEDPOLLSJS -->
++	<!-- INCLUDEJS js/functions.js -->
++	<!-- INCLUDEJS js/onload.js -->
++    <!-- DEFINE $INCLUDED_WOLFSBLVTADVANCEDPOLLSJS = true -->
++<!-- ENDIF -->
++<!-- IF WOLFSBLVT_POLL_SCORING -->
++<!-- IF not $INCLUDED_JXTOOLSJS -->
++    <!-- INCLUDEJS lib/jxtools.js -->
++	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
++<!-- ENDIF -->
++<!-- ENDIF -->
++
++<!-- IF AP_POLL_SHOW_VOTERS -->
++	<div class="poll_voters_box poll_total_votes<!-- IF not S_DISPLAY_RESULTS --> hidden<!-- ENDIF -->">
++		<div class="resultbar">{L_AP_VOTERS}{poll_option.AP_VOTERS}{L_COLON} <span class="poll_voters"><!-- IF poll_option.AP_VOTER_LIST -->{poll_option.AP_VOTER_LIST}<!-- ELSE --><span name="none">{L_AP_NONE}</span><!-- ENDIF --></span></div>
++		<div class="space10"></div>
++	</div>
++<!-- ENDIF -->
++<!-- IF WOLFSBLVT_POLL_SCORING -->
++	<span class="hidden" jxdom-target="[data-poll-option-id={poll_option.POLL_OPTION_ID}]" jxdom-find="div.poll_option_select" jxdom-action="remove"></span>
++	<div class="hidden" jxdom-target="[data-poll-option-id={poll_option.POLL_OPTION_ID}]" jxdom-find="> :first-child" jxdom-action="before">
++		<div class="poll_option_select pull-left">
++		<!-- IF AP_IS_SCORING -->
++			<select name="vote_id[{poll_option.POLL_OPTION_ID}]" id="vote_{poll_option.POLL_OPTION_ID}"<!-- IF not S_CAN_VOTE --> disabled="disabled"<!-- ENDIF -->>{poll_option.AP_POLL_OPTION_OPTS}</select>
++		<!-- ELSE -->
++			<input type="<!-- IF S_IS_MULTI_CHOICE -->checkbox<!-- ELSE -->radio<!-- ENDIF -->" name="vote_id[]" id="vote_{poll_option.POLL_OPTION_ID}" value="{poll_option.POLL_OPTION_ID}"<!-- IF poll_option.POLL_OPTION_VOTED --> checked="checked"<!-- ENDIF --><!-- IF not S_CAN_VOTE --> disabled="disabled"<!-- ENDIF --> />
++		<!-- ENDIF -->
++		</div>
++	</div>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html"
+new file mode 100644
+index 000000000..ce566920d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html"
+@@ -0,0 +1,5 @@
++<!-- IF U_AP_POLL_INFO -->
++<div class="btn-group hidden-xs">
++	<a href="{U_AP_POLL_INFO}" title="{L_INFORMATION}" class="btn btn-success"><i class="fa fa-info"></i></a>
++</div>
++<!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js"
+new file mode 100644
+index 000000000..de5a8bc5e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js"
+@@ -0,0 +1,176 @@
++/**
++ *
++ * Advanced Polls
++ *
++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Clemens Husung (Wolfsblvt)
++ */
++
++// namespacing
++head.ready(function(){
++$.wolfsblvt = $.extend({}, $.wolfsblvt, {
++
++	/// <field name="cookie_advancedsearchbox_name" type="string">The Cookie Name for advanced searchbox pin setting.</field>
++	advancedpoll_json_data: wolfsblvt_ap_json_data,
++
++	override_callback_advancedpolls_vote_poll_hidden: function (res) {
++		/// <summary>
++		///		Overrides the ajax callback function for poll votes
++		/// </summary>
++		/// <param name="res" type="object">(object) The results of the poll.</param>
++
++		if (typeof res.success !== 'undefined') {
++			var poll = $('.topic_poll');
++			var panel = poll.find('.panel');
++			var resultsVisible = poll.find('dl:first-child .resultbar').is(':visible');
++
++			// Define functions we need inside of that function here
++			var updatePanelHeight = function (height) {
++				height = (typeof height === 'undefined') ? panel.find('.inner').outerHeight() : height;
++				panel.css('min-height', height);
++			};
++			var resizePanel = function (time) {
++				var panelHeight = panel.height();
++				var innerHeight = panel.find('.inner').outerHeight();
++
++				if (panelHeight !== innerHeight) {
++					panel.css({ 'min-height': '', 'height': panelHeight })
++						.animate({ height: innerHeight }, time, function () {
++							panel.css({ 'min-height': innerHeight, 'height': '' });
++						});
++				}
++			};
++
++			// Set min-height to prevent the page from jumping when the content changes
++			updatePanelHeight();
++
++			// Remove the View results link
++			if (!resultsVisible) {
++				poll.find('.poll_view_results').hide(500);
++			}
++
++			if (!res.can_vote) {
++				poll.find('.polls, .poll_max_votes, .poll_vote, .poll_option_select').fadeOut(500, function () {
++					poll.find('.resultbar, .poll_option_percent, .poll_total_votes').show();
++				});
++			} else {
++				// If the user can still vote, simply slide down the results
++				poll.find('.resultbar, .poll_option_percent, .poll_total_votes').show(500);
++			}
++
++			// Get the votes count of the highest poll option
++			// no
++
++			// Update the total votes count
++			poll.find('.poll_total_vote_cnt').html("??");
++
++			// Update each option
++			poll.find('[data-poll-option-id]').each(function () {
++				var $this = $(this);
++				var optionId = $this.attr('data-poll-option-id');
++				var voted = (typeof res.user_votes[optionId] !== 'undefined');
++				var altText;
++
++				altText = $this.attr('data-alt-text');
++				if (voted) {
++					$this.attr('title', $.trim(altText));
++				} else {
++					$this.attr('title', '');
++				};
++
++				$this.toggleClass('voted', voted);
++			});
++
++			if (!res.can_vote) {
++				poll.find('.polls').delay(400).fadeIn(500);
++			}
++
++			// Display "Your vote has been cast." message. Disappears after 5 seconds.
++			var confirmationDelay = (res.can_vote) ? 300 : 900;
++			poll.find('.vote-submitted').delay(confirmationDelay).slideDown(200, function () {
++				if (resultsVisible) {
++					updatePanelHeight();
++				}
++
++				$(this).delay(5000).fadeOut(500, function () {
++					resizePanel(300);
++				});
++			});
++
++			// Remove the gap resulting from removing options
++			setTimeout(function () {
++				resizePanel(500);
++			}, 1500);
++		}
++	},
++	extend_callback_advancedpolls_vote_poll_show_voters: function (res) {
++		/// <summary>
++		///		Extends the ajax callback function to show poll voters
++		/// </summary>
++		/// <param name="res" type="object">(object) The results of the poll.</param>
++
++		if (typeof res.success !== 'undefined') {
++			var poll = $('.topic_poll');
++			var scoring = (typeof res.scoring !== 'undefined');
++			var spanname = 'name="' + $.wolfsblvt.advancedpoll_json_data.username_clean + '"';
++			var spanval_begin = "<span " + spanname + ">" + $.wolfsblvt.advancedpoll_json_data.username_string;
++			var spanval_end = "</span>";
++
++			console.log("running the extended callback code");
++
++			// Update each option
++			poll.find('[data-poll-option-id]').each(function () {
++				var $this = $(this);
++				var $votersbox_voters = $this.next(".poll_voters_box").find(".poll_voters");
++				var optionId = $this.attr('data-poll-option-id');
++				var voted = (typeof res.user_votes[optionId] !== 'undefined');
++				var spanval = spanval_begin + ((scoring) ? "(" + res.user_vote_counts[optionId] + ")" : "") + spanval_end;
++
++				var $voter_user = $votersbox_voters.children("span[" + spanname + "]");
++
++				if (voted) {
++					if ($voter_user.length === 0) {
++						if (res.vote_counts[optionId] > ((scoring) ? res.user_vote_counts[optionId] : 1)) {
++							// If there are more voters than just the current user, add seperator after last element
++							$votersbox_voters.children(":last-child").after($.wolfsblvt.advancedpoll_json_data.l_seperator);
++						}
++						else {
++							// Remove the "No voters" notice
++							$votersbox_voters.children('span[name="none"]').hide(500, function () { $(this).remove(); });
++						}
++						$(spanval).hide().appendTo($votersbox_voters).show(500);
++					}
++					else {
++						if (scoring) {
++							$(spanval).hide().replaceAll($voter_user).show(500);
++						}
++					}
++				}
++				else {
++					if ($voter_user.length > 0) {
++						var callback = function () {
++							if (res.vote_counts[optionId] > 0) {
++								if (this.nextSibling !== null) {
++									this.nextSibling.remove();
++								}
++								else {
++									if (this.previousSibling !== null) {
++										this.previousSibling.remove();
++									}
++								}
++							}
++							else {
++								var $none_voter = $('<span name="none">' + $.wolfsblvt.advancedpoll_json_data.l_none + "</span>").hide();
++								$none_voter.appendTo($votersbox_voters).show(500);
++							}
++							$(this).remove();
++						};
++						$voter_user.hide(500, callback);
++					}
++				}
++			});
++		}
++	},
++});
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js"
+new file mode 100644
+index 000000000..4de79edf7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js"
+@@ -0,0 +1,44 @@
++/**
++ *
++ * Advanced Polls
++ *
++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Clemens Husung (Wolfsblvt)
++ */
++
++head.ready(function(){
++$(document).ready(function () {
++	// replace the ajax callback for poll votes if votes are hidden
++	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
++		phpbb.addAjaxCallback('vote_poll', $.wolfsblvt.override_callback_advancedpolls_vote_poll_hidden);
++	}
++
++	// extend the ajax callback for poll votes if voters should be shown
++	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_voters_show_topic && !$.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
++		var old_function = phpbb.ajaxCallbacks['vote_poll'];
++		//phpbb.addAjaxCallback('vote_poll', function (res) { old_function(res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
++		phpbb.addAjaxCallback('vote_poll', function (res) { old_function.call(this, res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
++	}
++
++	// Modify the "view results" link to set the "don't want to vote"
++	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_no_vote) {
++		$('.poll_view_results a').click(function () {
++			var $poll = $(this).parents('.topic_poll');
++
++			if (!$.wolfsblvt.advancedpoll_json_data.can_change_vote) {
++				// Remove vote possibilitys
++				$poll.find('.poll_max_votes, .poll_vote, .poll_option_select').hide(500);
++			}
++
++			// Set it in the database
++			$.ajax({
++				url:	location.href,
++				data: {
++					no_vote:	true,
++				},
++			});
++		});
++	}
++});
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js"
+new file mode 100644
+index 000000000..f5c7c325f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js"
+@@ -0,0 +1,102 @@
++/**
++ *
++ * Advanced Polls - Poll Length Posting aids
++ *
++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Javier Lopez (javiexin)
++ */
++
++var apPollStartInitial = new Date();
++var apPollStart  = new Date();
++var apPollEnd    = new Date();
++var apPollLength = 0; // seconds
++var apPollLengthScale = 24; // days by default
++
++apInitPollLength();
++
++function apInitPollLength()
++{
++	var year = document.getElementById('wolfsblvt_poll_end_year').value;
++	if (year != "") apPollEnd.setFullYear(year);
++	var mon = document.getElementById('wolfsblvt_poll_end_mon').value;
++	if (mon != "") apPollEnd.setMonth(mon - 1);
++	var mday = document.getElementById('wolfsblvt_poll_end_mday').value;
++	if (mday != "") apPollEnd.setDate(mday);
++	var hours = document.getElementById('wolfsblvt_poll_end_hours').value;
++	if (hours != "") apPollEnd.setHours(hours);
++	var minutes = document.getElementById('wolfsblvt_poll_end_minutes').value;
++	if (minutes != "") apPollEnd.setMinutes(minutes);
++
++	var length = document.getElementById('poll_length').value;
++	if (length > 0) apPollLength = length * apPollLengthScale * 3600;
++
++	apPollStart.setTime(apPollEnd.getTime() - apPollLength * 1000);
++	apPollStartInitial = apPollStart;
++
++	var duration = (length > 0) ? 1 : 0;
++	document.getElementById('wolfsblvt_poll_duration').selectedIndex = duration;
++	apChangeDuration(document.getElementById('wolfsblvt_poll_duration').value);
++}
++
++function apChangeDuration(val)
++{
++	apUpdatePollEnd(val != '');
++	document.getElementById('wolfsblvt_poll_length').style.display='none';
++	document.getElementById('wolfsblvt_poll_end').style.display='none';
++	if (val != '') document.getElementById(val).style.display='inline-block';
++}
++
++function apAdjustLengthScale(newScale)
++{
++	apPollLengthScale = newScale;
++	apUpdatePollEnd(true);
++}
++
++function apAdjustLength(val)
++{
++	apPollLength = val * apPollLengthScale * 3600;
++	apPollEnd.setTime(apPollStart.getTime() + apPollLength * 1000);
++	apUpdatePollEnd(true);
++}
++
++function apAdjustEnd(what, val)
++{
++	if (what == "year")	{
++		apPollEnd.setFullYear(val);
++	} else if (what == "mon") {
++		apPollEnd.setMonth(val - 1);
++	} else if (what == "mday") {
++		apPollEnd.setDate(val);
++	} else if (what == "hours") {
++		apPollEnd.setHours(val);
++	} else if (what == "minutes") {
++		apPollEnd.setMinutes(val);
++	}
++	apUpdatePollEnd(true);
++}
++
++function apUpdatePollEnd(fill)
++{
++	var pollLengthValue =  Math.ceil((apPollEnd.getTime() - apPollStartInitial.getTime()) / 1000 / 3600 / apPollLengthScale);
++	apPollLength = pollLengthValue * apPollLengthScale * 3600;
++	apPollStart.setTime(apPollEnd.getTime() - apPollLength * 1000);
++
++	if (fill) {
++		document.getElementById('wolfsblvt_poll_end_label').innerHTML = apPollEnd.getFullYear() + "/" + (apPollEnd.getMonth() + 1) + "/" + apPollEnd.getDate() + "&nbsp;" + apPollEnd.getHours() + ":" + apPollEnd.getMinutes();
++		document.getElementById('wolfsblvt_poll_end_year').value = apPollEnd.getFullYear();
++		document.getElementById('wolfsblvt_poll_end_mon').value = apPollEnd.getMonth() + 1;
++		document.getElementById('wolfsblvt_poll_end_mday').value = apPollEnd.getDate();
++		document.getElementById('wolfsblvt_poll_end_hours').value = apPollEnd.getHours();
++		document.getElementById('wolfsblvt_poll_end_minutes').value = apPollEnd.getMinutes();
++		document.getElementById('poll_length').value = pollLengthValue;
++	} else {
++		document.getElementById('wolfsblvt_poll_end_label').innerHTML = "";
++		document.getElementById('wolfsblvt_poll_end_year').value = "";
++		document.getElementById('wolfsblvt_poll_end_mon').value = "";
++		document.getElementById('wolfsblvt_poll_end_mday').value = "";
++		document.getElementById('wolfsblvt_poll_end_hours').value = "";
++		document.getElementById('wolfsblvt_poll_end_minutes').value = "";
++		document.getElementById('poll_length').value = 0;
++	}
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js"
+new file mode 100644
+index 000000000..43d97eb7c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js"
+@@ -0,0 +1,18 @@
++/**
++ *
++ * Advanced Polls - Poll Length Reposition
++ *
++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Javier Lopez (javiexin)
++ */
++
++$(document).ready(function () {
++	var $pollLengthDl = $('label > #poll_length').closest('div');
++	var $container = $("#ap_poll_length_container");
++	var $content = $container.contents();
++
++	$pollLengthDl.prev('div').remove();
++	$pollLengthDl.replaceWith($content);
++	$container.remove();
++});
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js"
+new file mode 100644
+index 000000000..217f96c78
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js"
+@@ -0,0 +1,18 @@
++/**
++ *
++ * Advanced Polls - Scoring Polls
++ *
++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Javier Lopez (javiexin)
++ */
++
++$(document).ready(function () {
++	var $poll = $('#preview fieldset.polls');
++	var $container = $("#ap_poll_preview_hidden_container");
++	var $content = $container.contents();
++
++	$poll.children().remove();
++	$poll.append($content);
++	$container.remove();
++});
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js"
+new file mode 100644
+index 000000000..a1109ca14
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js"
+@@ -0,0 +1,21 @@
++/**
++ *
++ * Advanced Polls - Scoring Polls
++ *
++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Javier Lopez (javiexin)
++ */
++
++$(document).ready(function () {
++	var $poll = $('.topic_poll');
++
++	$poll.find('[data-poll-option-id]').each(function () {
++		var $this = $(this);
++		var optionId = $this.attr('data-poll-option-id');
++		var $container = $poll.find('#poll_option_hidden_container_' + optionId);
++		$this.find('div.poll_option_select').remove();
++		$this.children(':first-child').after($container.contents());
++		$container.remove();
++	});
++});
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/lib/jxtools.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/lib/jxtools.js"
+new file mode 100644
+index 000000000..f8c0f4f48
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/lib/jxtools.js"
+@@ -0,0 +1,68 @@
++/*
++ * JxTools - JavaScript utility library
++ *
++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @author Javier Lopez (javiexin)
++ */
++head.ready(function(){
++
++var jxtools = {};
++
++(function($) { // Avoid conflicts with other libraries
++
++'use strict';
++
++/*
++ * JxTools - Perform actions on the DOM
++ *
++ * If the JxDom set of attributes is present in a DOM element, it is processed by this function, in the following order
++ * [jxdom-target]  Attribute that specifies (with a DOM selector) the DOM object that is the initial target of this operation; optional, defaults to $(this)
++ * [jxdom-closest] DOM selector to apply to the target, to find the appropriate ancestor (starting with $(this)), that becomes the new target; optional
++ * [jxdom-find]    DOM selector to apply to the current target, to find the appropriate descendant, that becomes the new target; optional
++ * [jxdom-action]  Action to perform on the final target, using the contents of $(this) as parameter (if appropriate); mandatory
++ *                 Actions may be: remove|replace|before|after|prepend|append
++ * Each step should yield a single element as result, otherwise, the results are undefined
++ * When these operations are completed, this object is discarded (removed from the DOM)
++ */
++$('[jxdom-action]').each(function() {
++	var $this = $(this);
++	var $contents = $this.contents();
++	var domTarget = $this.attr('jxdom-target'),
++		domClosest = $this.attr('jxdom-closest'),
++		domFind = $this.attr('jxdom-find'),
++		domAction = $this.attr('jxdom-action');
++	var $target;
++
++	$target = (domTarget !== undefined) ? $(domTarget) : $this;
++	$target = (domClosest !== undefined) ? $target.closest(domClosest) : $target;
++	$target = (domFind !== undefined) ? $target.find(domFind) : $target;
++
++	switch (domAction) {
++		case 'replace':
++			$target.replaceWith($contents);
++			break;
++		case 'remove':
++			$target.remove();
++			break;
++		case 'before':
++			$target.before($contents);
++			break;
++		case 'after':
++			$target.after($contents);
++			break;
++		case 'append':
++			$target.append($contents);
++			break;
++		case 'prepend':
++			$target.prepend($contents);
++			break;
++		default:
++			break;
++	}
++	$this.remove();
++});
++
++})(jQuery); // Avoid conflicts with other libraries
++
++});
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html"
+index 3288d202a..e7ae3496c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html"
+@@ -1,5 +1,5 @@
+ <!-- IF S_VIEWTOPIC or S_IN_POSTING -->
+-	<!-- INCLUDECSS @wolfsblvt_advancedpolls/advancedpolls.css -->
++	<!-- INCLUDECSS advancedpolls.css -->
+ <!-- ENDIF -->
+ 
+ <!-- IF AP_JSON_DATA -->
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/diff_nospace.tmp" "[FORUM_EXT]/wolfsblvt\\advancedpolls/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/diff_nospace.tmp"
@@ -0,0 +1,1536 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/composer.json"
+index 971cad836..d15f03668 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/composer.json"
+@@ -3,8 +3,8 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Advances the core poll system of phpBB with new features like hiding votes till end, showing poll voters, limiting the votes and more.",
+ 	"homepage": "https://github.com/jasoloz/advancedpolls",
+-	"version": "1.2.4.3",
+-	"time": "2022-11-29",
++	"version": "1.2.4.1",
++	"time": "2020-02-20",
+ 	"keywords": ["phpbb", "extension", "advancedpolls", "advanced", "poll"],
+ 	"license": "GPL-2.0",
+ 	"authors": [
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp"
+new file mode 100644
+index 000000000..75f3cf454
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp"
+@@ -0,0 +1,1606 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/composer.json"
++index 971cad836..d15f03668 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/composer.json"
++@@ -3,8 +3,8 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Advances the core poll system of phpBB with new features like hiding votes till end, showing poll voters, limiting the votes and more.",
++ 	"homepage": "https://github.com/jasoloz/advancedpolls",
++-	"version": "1.2.4.3",
++-	"time": "2022-11-29",
+++	"version": "1.2.4.1",
+++	"time": "2020-02-20",
++ 	"keywords": ["phpbb", "extension", "advancedpolls", "advanced", "poll"],
++ 	"license": "GPL-2.0",
++ 	"authors": [
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls.php"
++deleted file mode 100644
++index 651efe50d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls.php"
+++++ /dev/null
++@@ -1,92 +0,0 @@
++-<?php
++-/**
++- *
++- * Advanced Polls [Japanese]
++- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
++- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++- * @author Clemens Husung (Wolfsblvt)
++- */
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
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ADVANCEDPOLLS_EXT_NAME'			=> 'Advanced Polls',
++-
++-// Viewtopic
++-	'AP_VOTES_HIDDEN'				=> '結果は表示されません',
++-	'AP_POLL_RUN_TILL_APPEND'			=> '。終了まで投票結果は非表示となります。',
++-	'AP_VOTERS'					=> '投票者',
++-	'AP_NONE'					=> 'なし',
++-
++-	'AP_POLL_CANT_VOTE'				=> 'この投票には参加できません。理由：',
++-	'AP_POLL_REASON_NOT_POSTED'			=> 'まだこのトピックで投稿を行っていません。',
++-	'AP_POLL_VOTES_ARE_VISIBLE'			=> '投票後にあなたの投票が見えるようになります。',
++-	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> '投票せずに結果を表示する',
++-	'AP_POLL_RESULTS_ARE_ORDERED'			=> '投票結果は得票数の多い順に並びます',
++-	'AP_POLL_TYPE_MISMATCH'				=> '一貫性のない投票データのため内部エラーが発生しました',
++-	'AP_VOTE_CHANGED'				=> '投票内容を変更する権限がありません。',
++-	'AP_TOO_MANY_VOTES'				=> '投票オプション数が多すぎます。', // You have tried to assign too many votes.
++-
++-	'AP_MAX_VOTES_SELECT'					=> array(
++-		1	=> '<strong>%1$d</strong> オプションに最大 <strong>%2$d</strong> 票を投じることができます',
++-		2	=> '<strong>%1$d</strong> オプションの中から最大 <strong>%2$d</strong> 票を投じることができます',
++-	),
++-	'AP_GUEST_VOTES'						=> array(
++-		1	=> 'ゲスト票：%d 票', // %d vote from guest
++-		2	=> 'ゲスト票：%d 票', // %d votes from guests
++-	),
++-
++-// Posting
++-	'AP_POLL_VOTES_HIDE'				=> '投票結果を非表示にする',
++-	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'これを有効にすると、投票結果は投票が終了するまで非表示になります。この項目は特定の期限設定を持つ場合のみ動作します。',
++-	'AP_POLL_VOTERS_SHOW'				=> '投票者を表示する',
++-	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'これを有効にすると、閲覧権限を持つユーザーにのみ投票者が表示されます。投票結果を非表示にしている場合は投票者も非表示になります。',
++-	'AP_POLL_VOTERS_LIMIT'				=> '投票対象者を制限する',
++-	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'これを有効にすると、このトピックに記事を投稿した人だけが投票できます',
++-	'AP_POLL_SHOW_ORDERED'				=> '得票順に表示する',
++-	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> '投票結果が表示されるとき、得票数の降順に並びます（得票数の高いもの順）。未選択の場合は投票オプションの順序が使用されます。',
++-	'AP_RUN_POLL'					=> '投票期間',
++-	'AP_RUN_POLL_FOR'				=> '日数指定',
++-	'AP_RUN_POLL_UNTIL'				=> '終了日指定',
++-	'AP_RUN_POLL_INDEFINITELY'			=> '無期限',
++-	'AP_POLL_END'					=> '投票終了',
++-	'AP_POLL_END_EXPLAIN'				=> '投票終了日時を指定してください。これらのフィールドのいずれかが指定されている場合、投票の期間を上書きします。日付フィールドは空のままで、デフォルトは現在の投票終了日です。時間フィールドは空のままで、デフォルトは0です。投票期間を使用するために戻す場合は、これらすべてのフィールドを消去する必要があります。',
++-
++-	'AP_YYYY_MM_DD'					=> 'YYYY-MM-DD',
++-	'AP_HH_MM'					=> 'HH:MM',
++-	'AP_POLL_END_INVALID'				=> '指定した日/時に誤りがあります',
++-	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> '1つのオプションの投票数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
++-	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> '投票可能なオプション数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
++-
++-	'AP_POLL_MAX_VALUE'				=> '最大投票数',
++-	'AP_POLL_MAX_VALUE_EXPLAIN'			=> '投票者が1つのオプションに付与できる最大投票数です',
++-	'AP_POLL_TOTAL_VALUE'				=> '投票者数',
++-	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> '投票者がすべてのオプションに分配する可能性のある投票の総数です',
++-
++-	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> '許可されている最大値を超える投票数を割り当てることはできません',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php"
++deleted file mode 100644
++index d5632802d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php"
+++++ /dev/null
++@@ -1,75 +0,0 @@
++-<?php
++-/**
++- *
++- * Advanced Polls [Japanese]
++- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
++- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++- * @author Clemens Husung (Wolfsblvt)
++- */
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
++-//
++-
++-$lang = array_merge($lang, array(
++-	'AP_TITLE_ACP'				=> 'Advanced Polls',
++-	'AP_SETTINGS_ACP'			=> '設定',
++-
++-	'AP_TITLE'				=> 'Advanced Polls',
++-	'AP_TITLE_EXPLAIN'			=> 'phpBBのコア投票システムを、投票終了まで結果を非表示にする、投票したユーザーを表示する、投票可能ユーザーを制限するなどの新機能を使用して進化向上します。',
++-	'AP_COPYRIGHT'				=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Wolfsblvt が提供するその他の拡張モジュール</a>]',
++-
++-	'AP_SETTINGS'				=> 'Advanced Polls の設定',
++-	'AP_GLOBAL_SETTINGS'			=> 'Advanced Polls のグローバル設定（全ての投票に適用されます）',
++-	'AP_PER_POLL_SETTINGS'			=> 'Advanced Polls の投票ごとの設定（投票ごとに選択可能、デフォルト値はここで設定）',
++-
++-	'AP_ACT_VOTES_HIDE'			=> '投票結果非表示を有効にする',
++-	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> '投票が終了するまで投票結果を非表示にすることを選択するオプションを有効化します。',
++-	'AP_ACT_VOTERS_SHOW'			=> '投票者表示を有効にする',
++-	'AP_ACT_VOTERS_SHOW_EXPLAIN'		=> '各投票オプションに対して投票投票者を表示することを選択するオプションを有効化します。',
++-	'AP_ACT_VOTERS_LIMIT'			=> '投票者制限を有効にする',
++-	'AP_ACT_VOTERS_LIMIT_EXPLAIN'		=> 'このトピックで既に投稿したユーザーにのみ投票を制限することを選択するオプションを有効化します。',
++-	'AP_ACT_POLL_NO_VOTE'			=> '無投票を有効にする',
++-	'AP_ACT_POLL_NO_VOTE_EXPLAIN'		=> '標準の「結果を表示する」リンクから「投票せずに結果を表示する」リンクに変更します。「投票を変更する」を選択しない限り、結果を表示した後に投票できません。',
++-	'AP_ACT_SHOW_ORDERED'			=> '得票順表示を有効にする',
++-	'AP_ACT_SHOW_ORDERED_EXPLAIN'		=> '得票の降順（得票数の高いもの順）で結果を表示することを選択するオプションを有効化します。',
++-	'AP_ACT_POLL_SCORING'			=> '投票スコアリングを有効にする',
++-	'AP_ACT_POLL_SCORING_EXPLAIN'		=> '投票オプションに異なるスコアを割り当てる可能性を有効化します。',
++-	'AP_ACT_INCREMENTAL_VOTES'		=> '段階投票を有効にする', // Activate incremental voting
++-	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> '利用可能な投票機能を使い果たしていない間、段階的に投票する可能性を有効化します。',
++-	'AP_ACT_CLOSED_VOTING'			=> '閉鎖トピックの投票を有効にする', // Activate closed voting
++-	'AP_ACT_CLOSED_VOTING_EXPLAIN'		=> '対応するトピックが閉鎖されている場合でも、公開投票に投票する可能性を有効化します。',
++-	'AP_ACT_POLL_END'			=> '投票終了設定を有効にする',
++-	'AP_ACT_POLL_END_EXPLAIN'		=> '投票が開始されてから投票期間を指定するだけでなく、日付/時刻で投票が終了するタイミングを指定できます。',
++-	'AP_ACT_POLL_NOTIFICATIONS'		=> '投票通知を有効にする',
++-	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'	=> '投票結果を非表示にした投票が終了したときに全ての投票者に通知を送る機能を有効にします。それに従い、投票結果が見えるようになります。',
++-
++-	'AP_DEFAULT_VOTES_CHANGE'		=> '再投票許可の設定をデフォルトにする',
++-	'AP_DEFAULT_VOTES_HIDE'			=> '投票結果非表示の設定をデフォルトにする',
++-	'AP_DEFAULT_VOTERS_SHOW'		=> '投票者表示の設定をデフォルトにする',
++-	'AP_DEFAULT_VOTERS_LIMIT'		=> '投票者制限の設定をデフォルトにする',
++-	'AP_DEFAULT_SHOW_ORDERED'		=> '得票順表示をデフォルトにする',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls.php"
++deleted file mode 100644
++index b0a3b7e23..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls.php"
+++++ /dev/null
++@@ -1,92 +0,0 @@
++-<?php
++-/**
++- *
++- * Advanced Polls [Polish]
++- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
++- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++- * @author Clemens Husung (Wolfsblvt)
++- */
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
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ADVANCEDPOLLS_EXT_NAME'				=> 'Zaawansowane głosowanie',
++-
++-// Viewtopic
++-	'AP_VOTES_HIDDEN'						=> 'Ukryte głosy',
++-	'AP_POLL_RUN_TILL_APPEND'				=> ', do tej pory wszystkie głosy będą ukryte.',
++-	'AP_VOTERS'								=> 'Głosujący',
++-	'AP_NONE'								=> 'Brak',
++-
++-	'AP_POLL_CANT_VOTE'						=> 'Nie możesz głosować w tej ankiecie. Powód',
++-	'AP_POLL_REASON_NOT_POSTED'				=> 'nie pisałeś w tym wątku.',
++-	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Jeśli głosujesz, Twój głos będzie widoczny.',
++-	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Nie głosuj, zobacz wyniki, ale stracisz prawo do głosowania',
++-	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Wyniki są ułożone według malejącej ilości otrzymanych głosów.',
++-	'AP_POLL_TYPE_MISMATCH'					=> 'Niespójne dane ankiety, błąd wewnętrzny.',
++-	'AP_VOTE_CHANGED'						=> 'Nie masz uprawnień do zmiany oddanych głosów.',
++-	'AP_TOO_MANY_VOTES'						=> 'Próbowałeś oddać zbyt wiele głosów.',
++-
++-	'AP_MAX_VOTES_SELECT'					=> array(
++-		1	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głos na <strong>%1$d</strong> opcję',
++-		2	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głosów wśród <strong>%1$d</strong> opcji',
++-	),
++-	'AP_GUEST_VOTES'						=> array(
++-		1	=> '%d głos od Gościa',
++-		2	=> '%d głosy od Gości',
++-	),
++-
++-// Posting
++-	'AP_POLL_VOTES_HIDE'					=> 'Ukryj głosy',
++-	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Jeśli włączone, głosy będą ukryte do końca głosowania. Ta opcja działa jeśli jest wyznaczony koniec ankiety.',
++-	'AP_POLL_VOTERS_SHOW'					=> 'Pokaż głosy głosujących',
++-	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Jeśli włączone, głosujący będą pokazani tym użytkownikom, którzy mają uprawnienia. Głosujący pozostaną ukryci jeśli głosy są ukryte.',
++-	'AP_POLL_VOTERS_LIMIT'					=> 'Ograniczenie głosów',
++-	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Jeśli włączone, użytkownicy mogą głosować tylko wtedy gdy pisali w tym wątku.',
++-	'AP_POLL_SHOW_ORDERED'					=> 'Pokaż kolejność wyników',
++-	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Wyświetlane wyniki są uporządkowane według malejącej liczby otrzymanych głosów (najpierw najwięcej głosów). W przeciwnym razie używana jest kolejność opcji ankiety.',
++-	'AP_RUN_POLL'							=> 'Uruchom ankietę',
++-	'AP_RUN_POLL_FOR'						=> 'przez',
++-	'AP_RUN_POLL_UNTIL'						=> 'aż do',
++-	'AP_RUN_POLL_INDEFINITELY'				=> 'bez końca',
++-	'AP_POLL_END'							=> 'koniec ankiety',
++-	'AP_POLL_END_EXPLAIN'					=> 'Określ datę i godzinę zakończenia ankiety. Jeśli którekolwiek z tych pól jest określone, zastępuje ono długość ankiety. Pola daty domyślnie pozostawiono puste, domyślnie bieżąca data zakończenia ankiety; pola godzin pozostawione puste, domyślnie ustawione na 0. Jeśli chcesz powrócić do korzystania z długości ankiety, będziesz musiał wyczyścić wszystkie te pola.',
++-
++-	'AP_YYYY_MM_DD'							=> 'YYYY-MM-DD',
++-	'AP_HH_MM'								=> 'HH:MM',
++-	'AP_POLL_END_INVALID'					=> 'Określona data/czas są niewłaściwe',
++-	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'Maksymalna liczba głosów przypadająca na jedną opcję nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
++-	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'Maksymalna liczba opcji głosowania nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
++-
++-	'AP_POLL_MAX_VALUE'						=> 'Maksymalna liczba głosów',
++-	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'To jest maksymalna liczba głosów, jaką głosujący może oddać na jedną opcję.',
++-	'AP_POLL_TOTAL_VALUE'					=> 'Razem głosów',
++-	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'To jest całkowita liczba głosów, jaką głosujący może rozdzielić na wszystkie opcje.',
++-
++-	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Nie możesz przydzielić liczby głosów większej niż maksymalna dozwolona wartość.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php"
++deleted file mode 100644
++index 500071750..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php"
+++++ /dev/null
++@@ -1,75 +0,0 @@
++-<?php
++-/**
++- *
++- * Advanced Polls [Polish]
++- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
++- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++- * @author Clemens Husung (Wolfsblvt)
++- */
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
++-//
++-
++-$lang = array_merge($lang, array(
++-	'AP_TITLE_ACP'					=> 'Zaawansowane głosowanie',
++-	'AP_SETTINGS_ACP'				=> 'Ustawienia',
++-
++-	'AP_TITLE'						=> 'Zaawansowane głosowanie',
++-	'AP_TITLE_EXPLAIN'				=> 'Zaawansowane głosowanie to podstawowy system ankiet phpBB z nowymi funkcjami, takimi jak ukrywanie głosów do końca, pokazywanie wyborców, ograniczanie głosów i nie tylko.',
++-	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Więcej rozszerzeń od Wolfsblvt</a>]',
++-
++-	'AP_SETTINGS'					=> 'Zaawansowane głosowanie - Ustawienia',
++-	'AP_GLOBAL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia ogólne (zastosowanie do wszystkich ankiet)',
++-	'AP_PER_POLL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia poszczególnych ankiet (do wyboru w każdej ankiecie, z ustawioną tutaj wartością domyślną)',
++-
++-	'AP_ACT_VOTES_HIDE'				=> 'Pokazuj głosy',
++-	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Wybierz tę opcję, żeby ukryć oddane głosy do końca głosowania.',
++-	'AP_ACT_VOTERS_SHOW'			=> 'Pokazuj głosujących',
++-	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Wybierz tę opcję, żeby pokazać głosujących przy każdej opcji głosowania.',
++-	'AP_ACT_VOTERS_LIMIT'			=> 'Ogranicz liczkę głosujących',
++-	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Wybierz tę opcję, żeby ograniczyć głosujących do użytkowników piszących w tym wątku.',
++-	'AP_ACT_POLL_NO_VOTE'			=> 'Pokazuj Brak głosu',
++-	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Zmienia standardowy link „Wyświetl wyniki” na link „Nie głosuj, wyświetl wyniki”, który nie zezwala na głosowanie po wyświetleniu wyników, chyba że wybrano opcję „Zmień głosy”.',
++-	'AP_ACT_SHOW_ORDERED'			=> 'Pokazuj kolejność',
++-	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Aktywuje opcję pokazania wyników w kolejności malejącej liczby otrzymanych głosów (najpierw głosowano najwyżej).',
++-	'AP_ACT_POLL_SCORING'			=> 'Pokazuj przewijanie głosowania',
++-	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Aktywuje możliwość przypisywania różnych wyników do opcji ankiety.',
++-	'AP_ACT_INCREMENTAL_VOTES'		=> 'Pokazuj stopniowanie głosów',
++-	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Aktywuje możliwość głosowania stopniowego, gdy nie wyczerpałeś dostępnych możliwości głosowania.',
++-	'AP_ACT_CLOSED_VOTING'			=> 'Pozwalaj na głosowanie zamknięte',
++-	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Włącza możliwość głosowania w otwartej ankiecie, nawet jeśli odpowiedni temat jest zablokowany.',
++-	'AP_ACT_POLL_END'				=> 'Pokazuj dokładny koniec ankiety',
++-	'AP_ACT_POLL_END_EXPLAIN'		=> 'Pozwala określić, kiedy ankieta kończy się według daty / godziny, zamiast tylko określać czas trwania ankiety od jej rozpoczęcia.',
++-	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Pokazuj powiadomienia ankiety',
++-	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Aktywuje wysyłanie powiadomień do wszystkich wyborców o ukrytej ankiecie po zakończeniu ankiety, dzięki czemu wyniki są widoczne.',
++-
++-	'AP_DEFAULT_VOTES_CHANGE'		=> 'Wybierz domyślne ustawienia zmiany oddanego głosu',
++-	'AP_DEFAULT_VOTES_HIDE'			=> 'Wybierz domyślne ustawienia ukrytych głosujących',
++-	'AP_DEFAULT_VOTERS_SHOW'		=> 'Wybierz domyślne ustawienia ilości głosujących',
++-	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Wybierz domyślne ustawienia limitu głosujących',
++-	'AP_DEFAULT_SHOW_ORDERED'		=> 'Wybierz domyślne dla pokazania kolejności',
++-));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls.php"
++new file mode 100644
++index 000000000..0cecb9792
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls.php"
++@@ -0,0 +1,94 @@
+++<?php
+++/**
+++ *
+++ * Advanced Polls [Spanish]
+++ *
+++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Clemens Husung (Wolfsblvt)
+++ * @author Initial translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+++ * @author Continued translation by javiexin (http://www.exincastillos.es)
+++ * @author Continued translation by jasolo (https://github.com/jasoloz)
+++ */
+++
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
+++	'ADVANCEDPOLLS_EXT_NAME'				=> 'Votações Avançadas',
+++
+++// Viewtopic
+++	'AP_VOTES_HIDDEN'						=> 'Votos ocultos',
+++	'AP_POLL_RUN_TILL_APPEND'				=> ', até que todos os votos estarão ocultos.',
+++	'AP_VOTERS'								=> 'Votantes',
+++	'AP_NONE'								=> 'Ninguém',
+++
+++	'AP_POLL_CANT_VOTE'						=> 'Não podes votar nesta votação. Razão',
+++	'AP_POLL_REASON_NOT_POSTED'				=> 'Não escreveu neste tema.',
+++	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Tem em conta que se votares, o teu voto será visível.',
+++	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Não quero votar, quero ver os resultados',
+++	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Os resultados estão ordenados por número decrescente de votos recebidos.',
+++	'AP_POLL_TYPE_MISMATCH'					=> 'Dados inconsistentes na votação, erro interno.',
+++	'AP_VOTE_CHANGED'						=> 'Não tem permissão para alterar os votos já emitidos.',
+++	'AP_TOO_MANY_VOTES'						=> 'Tentou adicionar demasiados votos.',
+++
+++	'AP_MAX_VOTES_SELECT'					=> array(
+++		1	=> 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
+++		2	=> 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
+++	),
+++	'AP_GUEST_VOTES'						=> array(
+++		1	=> '%d voto de convidado',
+++		2	=> '%d votos de convidados',
+++	),
+++
+++// Posting
+++	'AP_POLL_VOTES_HIDE'					=> 'Ocultar votos',
+++	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
+++	'AP_POLL_VOTERS_SHOW'					=> 'Mostrar votantes da votação',
+++	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Se estiver ativado, os votantes serão mostrados à quem tenha permissões. Tem em conta que os os votantes estarão ocultos caso os votos estejam ocultos.',
+++	'AP_POLL_VOTERS_LIMIT'					=> 'Limite de votos',
+++	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
+++	'AP_POLL_SHOW_ORDERED'					=> 'Ordenar resultados',
+++	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (ou mais votado primeiro). Em caso contrario, usa-se a ordem de opções na votação.',
+++	'AP_RUN_POLL'							=> 'Realizar votação',
+++	'AP_RUN_POLL_FOR'						=> 'durante',
+++	'AP_RUN_POLL_UNTIL'						=> 'até',
+++	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinidamente',
+++	'AP_POLL_END'							=> 'Fim da votação',
+++	'AP_POLL_END_EXPLAIN'					=> 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',
+++
+++	'AP_YYYY_MM_DD'							=> 'AAAA-MM-DD',
+++	'AP_HH_MM'								=> 'HH:MM',
+++	'AP_POLL_END_INVALID'					=> 'A data/hora especificada não é válida',
+++	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
+++	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',
+++
+++	'AP_POLL_MAX_VALUE'						=> 'Votos máximos',
+++	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
+++	'AP_POLL_TOTAL_VALUE'					=> 'Votos totais',
+++	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',
+++	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Não pode escolher um número de votos superior ao máximo permitido.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
++similarity index 75%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
++index 49e2fccb9..c325f2638 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
++@@ -1,11 +1,12 @@
++ <?php
++ /**
++  *
++- * Advanced Polls [Polish]
++- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
+++ * Advanced Polls [Spanish]
+++ *
++  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++  * @author Clemens Husung (Wolfsblvt)
+++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++  */
++ 
++ if (!defined('IN_PHPBB'))
++@@ -35,6 +36,6 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Wyniki będą widoczne w ankiecie</strong>:',
++-	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Wyniki są teraz widoczne dla ankiety, w której głosowałeś',
+++	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Resultados visíveis para a votação</strong>:',
+++	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Já podes ver os resultados de uma votação em que participaste',
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php"
++new file mode 100644
++index 000000000..1ff897e6e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php"
++@@ -0,0 +1,76 @@
+++<?php
+++/**
+++ *
+++ * Advanced Polls [Spanish]
+++ *
+++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Clemens Husung (Wolfsblvt)
+++ * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+++ */
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($ang) || !is_array($ang))
+++{
+++	$ang = array();
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
+++//
+++// Paceholders can now comtain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// transators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
+++// equally where a string comtains only two paceholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$ang = array_merge($ang, array(
+++	'AP_TITLE_ACP'					=> 'Votações Avançadas',
+++	'AP_SETTINGS_ACP'				=> 'Configuração',
+++
+++	'AP_TITLE'						=> 'Votações Avançadas',
+++	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
+++	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',
+++
+++	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
+++	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
+++	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',
+++
+++	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
+++	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
+++	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
+++	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
+++	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
+++	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
+++	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
+++	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
+++	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
+++	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
+++	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
+++	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
+++	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
+++	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
+++	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
+++	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
+++	'AP_ACT_POLL_END'				=> 'Activar final de votação',
+++	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
+++	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
+++	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',
+++
+++	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
+++	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
+++	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
+++	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
+++	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
++similarity index 83%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
++index a4c7c0399..4f7db7f66 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
++@@ -1,11 +1,12 @@
++ <?php
++ /**
++  *
++- * Advanced Polls [Japanese]
++- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
+++ * Advanced Polls [Spanish]
+++ *
++  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++  * @author Clemens Husung (Wolfsblvt)
+++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++  */
++ 
++ if (!defined('IN_PHPBB'))
++@@ -43,6 +44,6 @@ if (empty($lang) || !is_array($lang))
++ 
++ // User Permissions
++ $lang = array_merge($lang, array(
++-	'ACL_F_SEEVOTERS'			=> '投票者を見る', // Can see poll voters
++-	'ACL_M_SEEVOTERS'			=> '投票者情報を閲覧する', // Can view poll voters
+++	'ACL_F_SEEVOTERS'			=> 'Pode ver os votantes da votação',
+++	'ACL_M_SEEVOTERS'			=> 'Pode ver os votantes da votação',
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php"
++new file mode 100644
++index 000000000..0cecb9792
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php"
++@@ -0,0 +1,94 @@
+++<?php
+++/**
+++ *
+++ * Advanced Polls [Spanish]
+++ *
+++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Clemens Husung (Wolfsblvt)
+++ * @author Initial translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+++ * @author Continued translation by javiexin (http://www.exincastillos.es)
+++ * @author Continued translation by jasolo (https://github.com/jasoloz)
+++ */
+++
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
+++	'ADVANCEDPOLLS_EXT_NAME'				=> 'Votações Avançadas',
+++
+++// Viewtopic
+++	'AP_VOTES_HIDDEN'						=> 'Votos ocultos',
+++	'AP_POLL_RUN_TILL_APPEND'				=> ', até que todos os votos estarão ocultos.',
+++	'AP_VOTERS'								=> 'Votantes',
+++	'AP_NONE'								=> 'Ninguém',
+++
+++	'AP_POLL_CANT_VOTE'						=> 'Não podes votar nesta votação. Razão',
+++	'AP_POLL_REASON_NOT_POSTED'				=> 'Não escreveu neste tema.',
+++	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Tem em conta que se votares, o teu voto será visível.',
+++	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Não quero votar, quero ver os resultados',
+++	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Os resultados estão ordenados por número decrescente de votos recebidos.',
+++	'AP_POLL_TYPE_MISMATCH'					=> 'Dados inconsistentes na votação, erro interno.',
+++	'AP_VOTE_CHANGED'						=> 'Não tem permissão para alterar os votos já emitidos.',
+++	'AP_TOO_MANY_VOTES'						=> 'Tentou adicionar demasiados votos.',
+++
+++	'AP_MAX_VOTES_SELECT'					=> array(
+++		1	=> 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
+++		2	=> 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
+++	),
+++	'AP_GUEST_VOTES'						=> array(
+++		1	=> '%d voto de convidado',
+++		2	=> '%d votos de convidados',
+++	),
+++
+++// Posting
+++	'AP_POLL_VOTES_HIDE'					=> 'Ocultar votos',
+++	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
+++	'AP_POLL_VOTERS_SHOW'					=> 'Mostrar votantes da votação',
+++	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Se estiver ativado, os votantes serão mostrados à quem tenha permissões. Tem em conta que os os votantes estarão ocultos caso os votos estejam ocultos.',
+++	'AP_POLL_VOTERS_LIMIT'					=> 'Limite de votos',
+++	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
+++	'AP_POLL_SHOW_ORDERED'					=> 'Ordenar resultados',
+++	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (ou mais votado primeiro). Em caso contrario, usa-se a ordem de opções na votação.',
+++	'AP_RUN_POLL'							=> 'Realizar votação',
+++	'AP_RUN_POLL_FOR'						=> 'durante',
+++	'AP_RUN_POLL_UNTIL'						=> 'até',
+++	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinidamente',
+++	'AP_POLL_END'							=> 'Fim da votação',
+++	'AP_POLL_END_EXPLAIN'					=> 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',
+++
+++	'AP_YYYY_MM_DD'							=> 'AAAA-MM-DD',
+++	'AP_HH_MM'								=> 'HH:MM',
+++	'AP_POLL_END_INVALID'					=> 'A data/hora especificada não é válida',
+++	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
+++	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',
+++
+++	'AP_POLL_MAX_VALUE'						=> 'Votos máximos',
+++	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
+++	'AP_POLL_TOTAL_VALUE'					=> 'Votos totais',
+++	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',
+++	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Não pode escolher um número de votos superior ao máximo permitido.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
++similarity index 75%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
++index 8a90662d6..c325f2638 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
++@@ -1,11 +1,12 @@
++ <?php
++ /**
++  *
++- * Advanced Polls [Japanese]
++- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
+++ * Advanced Polls [Spanish]
+++ *
++  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++  * @author Clemens Husung (Wolfsblvt)
+++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++  */
++ 
++ if (!defined('IN_PHPBB'))
++@@ -35,6 +36,6 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>投票結果が表示されます</strong>:',
++-	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> '投票した結果が表示されるようになりました',
+++	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Resultados visíveis para a votação</strong>:',
+++	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Já podes ver os resultados de uma votação em que participaste',
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php"
++new file mode 100644
++index 000000000..1ff897e6e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php"
++@@ -0,0 +1,76 @@
+++<?php
+++/**
+++ *
+++ * Advanced Polls [Spanish]
+++ *
+++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Clemens Husung (Wolfsblvt)
+++ * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+++ */
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($ang) || !is_array($ang))
+++{
+++	$ang = array();
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
+++//
+++// Paceholders can now comtain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// transators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
+++// equally where a string comtains only two paceholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$ang = array_merge($ang, array(
+++	'AP_TITLE_ACP'					=> 'Votações Avançadas',
+++	'AP_SETTINGS_ACP'				=> 'Configuração',
+++
+++	'AP_TITLE'						=> 'Votações Avançadas',
+++	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
+++	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',
+++
+++	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
+++	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
+++	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',
+++
+++	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
+++	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
+++	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
+++	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
+++	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
+++	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
+++	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
+++	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
+++	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
+++	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
+++	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
+++	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
+++	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
+++	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
+++	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
+++	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
+++	'AP_ACT_POLL_END'				=> 'Activar final de votação',
+++	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
+++	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
+++	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',
+++
+++	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
+++	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
+++	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
+++	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
+++	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
++similarity index 57%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
++index e03192a8c..4f7db7f66 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
++@@ -1,11 +1,12 @@
++ <?php
++ /**
++  *
++- * Advanced Polls [Polish]
++- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
+++ * Advanced Polls [Spanish]
+++ *
++  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
++  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++  * @author Clemens Husung (Wolfsblvt)
+++ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
++  */
++ 
++ if (!defined('IN_PHPBB'))
++@@ -31,18 +32,18 @@ if (empty($lang) || !is_array($lang))
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ 
++ /**
++-*	EXTENSION-DEVELOPERS PLEASE NOTE
++-*
++-*	You are able to put your permission sets into your extension.
++-*	The permissions logic should be added via the 'core.permissions' event.
++-*	You can easily add new permission categories, types and permissions, by
++-*	simply merging them into the respective arrays.
++-*	The respective language strings should be added into a language file, that
++-*	start with 'permissions_', so they are automatically loaded within the ACP.
++-*/
+++ * EXTENSION-DEVELOPERS PLEASE NOTE
+++ *
+++ * You are able to put your permission sets into your extension.
+++ * The permissions logic should be added via the 'core.permissions' event.
+++ * You can easily add new permission categories, types and permissions, by
+++ * simply merging them into the respective arrays.
+++ * The respective language strings should be added into a language file, that
+++ * start with 'permissions_', so they are automatically loaded within the ACP.
+++ */
++ 
++ // User Permissions
++ $lang = array_merge($lang, array(
++-	'ACL_F_SEEVOTERS'			=> 'Możesz zobaczyć głosujących.',
++-	'ACL_M_SEEVOTERS'			=> 'Możesz wyświetlać głosujących w ankiecie.',
+++	'ACL_F_SEEVOTERS'			=> 'Pode ver os votantes da votação',
+++	'ACL_M_SEEVOTERS'			=> 'Pode ver os votantes da votação',
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store"
++new file mode 100644
++index 000000000..8ed203817
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..52c53ea7d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,5 @@
+++<!-- IF AP_JSON_DATA -->
+++	<script>
+++		{AP_JSON_DATA}
+++	</script>
+++<!-- ENDIF -->
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
++new file mode 100644
++index 000000000..31401bef2
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
++@@ -0,0 +1,27 @@
+++<!-- IF S_DISPLAY_PREVIEW and WOLFSBLVT_POLL_SCORING -->
+++<!-- IF not $INCLUDED_JXTOOLSJS -->
+++    <!-- INCLUDEJS lib/jxtools.js -->
+++	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
+++<!-- ENDIF -->
+++<div id="ap_poll_preview_hidden_container" style="display:none;" jxdom-target="#preview fieldset.polls" jxdom-action="replace">
+++	<fieldset>
+++		<div class="panel panel-default panel-poll">
+++			<div class="panel-heading">
+++				<!-- BEGIN poll_option -->
+++					<div class="pull-left">
+++						<label for="vote_{poll_option.POLL_OPTION_ID}">{poll_option.POLL_OPTION_CAPTION}</label>
+++						<div class="poll_option_select pull-left">
+++							
+++							<!-- IF AP_IS_SCORING -->
+++								<select name="vote_id[{poll_option.POLL_OPTION_ID}]" id="vote_{poll_option.POLL_OPTION_ID}">{poll_option.AP_POLL_OPTION_OPTS}</select>
+++							<!-- ELSE -->
+++								<input type="<!-- IF S_IS_MULTI_CHOICE -->checkbox<!-- ELSE -->radio<!-- ENDIF -->" name="vote_id[]" id="vote_{poll_option.POLL_OPTION_ID}" value="{poll_option.POLL_OPTION_ID}" />
+++							<!-- ENDIF -->
+++						</div>
+++					</div>
+++				<!-- END poll_option -->
+++			</div>
+++		</div>
+++	</fieldset>
+++</div>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html"
++new file mode 100644
++index 000000000..de6bd61f8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html"
++@@ -0,0 +1,115 @@
+++<!-- IF S_SHOW_POLL_BOX -->
+++<!-- IF WOLFSBLVT_POLL_END or WOLFSBLVT_POLL_SCORING -->
+++<!-- IF not $INCLUDED_JXTOOLSJS -->
+++    <!-- INCLUDEJS lib/jxtools.js -->
+++	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
+++<!-- ENDIF -->
+++<!-- ENDIF -->
+++
+++<!-- IF WOLFSBLVT_POLL_END -->
+++<!-- INCLUDEJS js/poll_length_posting.js -->
+++<div id="ap_poll_length_container" style="display:none;" jxdom-target="label > #poll_length" jxdom-closest="div" jxdom-action="replace">
+++	<!-- Replace the div ancestor of a #poll_length element directly under a label with the contents of this element -->
+++	<div class="control-group">
+++		<label for="wolfsblvt_poll_duration">{L_AP_RUN_POLL}{L_COLON}</label>
+++		<div class="controls controls-row">
+++			<select name="wolfsblvt_poll_duration" id="wolfsblvt_poll_duration" onchange="apChangeDuration(this.value);">
+++				<option value="" selected="selected">{L_AP_RUN_POLL_INDEFINITELY}</option>
+++				<option value="wolfsblvt_poll_length">{L_AP_RUN_POLL_FOR}</option>
+++				<option value="wolfsblvt_poll_end">{L_AP_RUN_POLL_UNTIL}</option>
+++			</select>
+++			<span id="wolfsblvt_poll_length" style="display: none; margin: 0px 10px;">
+++				<input style="width: 4em !important;" id="poll_length" name="poll_length" size="3" maxlength="3" min="0" max="999" value="{POLL_LENGTH}" class="inputbox autowidth" type="number" onchange="apAdjustLength(this.value);">
+++				<select name="wolfsblvt_poll_length_scale" onchange="apAdjustLengthScale(this.value);">
+++					<option value="1">{L_HOURS}</option>
+++					<option value="24" selected="selected">{L_DAYS}</option>
+++				</select>
+++				&nbsp;
+++				<strong id="wolfsblvt_poll_end_label"></strong>
+++			</span>
+++			<span id="wolfsblvt_poll_end" style="display: none; margin: 0px 10px;">
+++				<input style="width: 5em !important;" size="4" maxlength="4" id="wolfsblvt_poll_end_year" name="wolfsblvt_poll_end_year" value="{WOLFSBLVT_POLL_END_YEAR}" type="number" onchange="apAdjustEnd('year',this.value);">
+++				<input style="width: 3em !important;" size="2" maxlength="2" min="1" max="12" id="wolfsblvt_poll_end_mon" name="wolfsblvt_poll_end_mon" value="{WOLFSBLVT_POLL_END_MON}" type="number" onchange="apAdjustEnd('mon',this.value);">
+++				<input style="width: 3em !important;" size="2" maxlength="2" min="1" max="31" id="wolfsblvt_poll_end_mday" name="wolfsblvt_poll_end_mday" value="{WOLFSBLVT_POLL_END_MDAY}" type="number" onchange="apAdjustEnd('mday',this.value);">
+++				&nbsp;
+++				<input style="width: 3em !important;" size="2" maxlength="2" min="0" max="23" id="wolfsblvt_poll_end_hours" name="wolfsblvt_poll_end_hours" value="{WOLFSBLVT_POLL_END_HOURS}" type="number" onchange="apAdjustEnd('hours',this.value);">
+++				<input style="width: 3em !important;" size="2" maxlength="2" min="0" max="59" id="wolfsblvt_poll_end_minutes" name="wolfsblvt_poll_end_minutes" value="{WOLFSBLVT_POLL_END_MINUTES}" type="number" onchange="apAdjustEnd('minutes',this.value);">
+++				&nbsp;
+++				{L_AP_YYYY_MM_DD} {L_AP_HH_MM}
+++			</span>
+++		</div>
+++	</div>
+++	<hr class="dashed" />
+++</div>
+++<!-- ENDIF -->
+++
+++<!-- IF WOLFSBLVT_POLL_SCORING -->
+++<span style="display:none;" jxdom-target="#poll_max_options" jxdom-closest=".col-md-4" jxdom-action="remove">
+++<!-- Remove the #poll_max_options div ancestor, to be replaced by the following div block (in a different position in the DOM, closer to other similar options) -->
+++</span>
+++<div class="control-group">
+++	<label class="control-label" for="poll_max_options">{L_POLL_MAX_OPTIONS}{L_COLON}</label><span class="help-block">{L_POLL_MAX_OPTIONS_EXPLAIN}</span>
+++	<div class="input-group col-xs-8 col-sm-2 col-md-2">
+++		<input type="number" min="0" max="999" name="poll_max_options" id="wolfsblvt_poll_max_options" size="3" maxlength="3" value="{POLL_MAX_OPTIONS}" class="form-control input-sm">
+++	</div>
+++</div>
+++<div class="control-group">
+++	<label class="control-label" for="wolfsblvt_poll_max_value">{L_AP_POLL_MAX_VALUE}{L_COLON}</label><span class="help-block">{L_AP_POLL_MAX_VALUE_EXPLAIN}</span>
+++	<div class="input-group col-xs-8 col-sm-2 col-md-2">
+++		<input type="number" min="0" max="999" name="wolfsblvt_poll_max_value" id="wolfsblvt_poll_max_value" size="3" maxlength="3" value="{WOLFSBLVT_POLL_MAX_VALUE}" class="form-control input-sm">
+++	</div>
+++</div>
+++<div class="control-group">
+++	<label class="control-label" for="wolfsblvt_poll_total_value">{L_AP_POLL_TOTAL_VALUE}{L_COLON}</label><span class="help-block">{L_AP_POLL_TOTAL_VALUE_EXPLAIN}</span>
+++	<div class="input-group col-xs-8 col-sm-2 col-md-2">
+++		<input type="number" min="0" max="999" name="wolfsblvt_poll_total_value" id="wolfsblvt_poll_total_value" size="3" maxlength="3" value="{WOLFSBLVT_POLL_TOTAL_VALUE}" class="form-control input-sm">
+++	</div>
+++</div>
+++<!-- ENDIF -->
+++
+++<!-- IF not WOLFSBLVT_POLL_END and not WOLFSBLVT_POLL_SCORING -->
+++	<hr class="dashed" />
+++<!-- ENDIF -->
+++
+++<!-- IF S_AP_POLL_VOTE_CHANGE -->
+++<div class="control-group">
+++	<label class="control-label" for="poll_vote_change">{L_POLL_VOTE_CHANGE}{L_COLON}</label>
+++	<div class="controls controls-row"> 
+++		<input type="checkbox" id="poll_vote_change" name="poll_vote_change"{VOTE_CHANGE_CHECKED} /> {L_POLL_VOTE_CHANGE_EXPLAIN}
+++	</div>
+++</div>
+++<!-- ENDIF -->
+++
+++<!-- IF WOLFSBLVT_POLL_VOTES_HIDE -->
+++<div class="control-group">
+++	<label class="control-label" for="wolfsblvt_poll_votes_hide">{L_AP_POLL_VOTES_HIDE}{L_COLON}</label>
+++	<div class="controls controls-row"> 
+++		<input type="checkbox" id="wolfsblvt_poll_votes_hide" name="wolfsblvt_poll_votes_hide"{WOLFSBLVT_POLL_VOTES_HIDE_CHECKED} /> {L_AP_POLL_VOTES_HIDE_EXPLAIN}
+++	</div>
+++</div>
+++<!-- ENDIF -->
+++<!-- IF WOLFSBLVT_POLL_VOTERS_LIMIT -->
+++<div class="control-group">
+++	<label class="control-label" for="wolfsblvt_poll_voters_limit">{L_AP_POLL_VOTERS_LIMIT}{L_COLON}</label>
+++	<div class="controls controls-row"> 
+++		<input type="checkbox" id="wolfsblvt_poll_voters_limit" name="wolfsblvt_poll_voters_limit"{WOLFSBLVT_POLL_VOTERS_LIMIT_CHECKED} /> {L_AP_POLL_VOTERS_LIMIT_EXPLAIN}
+++	</div>
+++</div>
+++<!-- ENDIF -->
+++<!-- IF WOLFSBLVT_POLL_VOTERS_SHOW -->
+++<div class="control-group">
+++	<label class="control-label" for="wolfsblvt_poll_voters_show">{L_AP_POLL_VOTERS_SHOW}{L_COLON}</label>
+++	<div class="controls controls-row"> 
+++		<input type="checkbox" id="wolfsblvt_poll_voters_show" name="wolfsblvt_poll_voters_show"{WOLFSBLVT_POLL_VOTERS_SHOW_CHECKED} /> {L_AP_POLL_VOTERS_SHOW_EXPLAIN}
+++	</div>
+++</div>
+++<!-- ENDIF -->
+++<!-- IF WOLFSBLVT_POLL_SHOW_ORDERED -->
+++<div class="control-group">
+++	<label class="control-label" for="wolfsblvt_poll_show_ordered">{L_AP_POLL_SHOW_ORDERED}{L_COLON}</label>
+++	<div class="controls controls-row"> 
+++		<input type="checkbox" id="wolfsblvt_poll_show_ordered" name="wolfsblvt_poll_show_ordered"{WOLFSBLVT_POLL_SHOW_ORDERED_CHECKED} /> {L_AP_POLL_SHOW_ORDERED_EXPLAIN}
+++	</div>
+++</div>
+++<!-- ENDIF -->
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html"
++new file mode 100644
++index 000000000..78adf66b4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html"
++@@ -0,0 +1,30 @@
+++<!-- IF not $INCLUDED_WOLFSBLVTADVANCEDPOLLSJS -->
+++	<!-- INCLUDEJS js/functions.js -->
+++	<!-- INCLUDEJS js/onload.js -->
+++    <!-- DEFINE $INCLUDED_WOLFSBLVTADVANCEDPOLLSJS = true -->
+++<!-- ENDIF -->
+++<!-- IF WOLFSBLVT_POLL_SCORING -->
+++<!-- IF not $INCLUDED_JXTOOLSJS -->
+++    <!-- INCLUDEJS lib/jxtools.js -->
+++	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
+++<!-- ENDIF -->
+++<!-- ENDIF -->
+++
+++<!-- IF AP_POLL_SHOW_VOTERS -->
+++	<div class="poll_voters_box poll_total_votes<!-- IF not S_DISPLAY_RESULTS --> hidden<!-- ENDIF -->">
+++		<div class="resultbar">{L_AP_VOTERS}{poll_option.AP_VOTERS}{L_COLON} <span class="poll_voters"><!-- IF poll_option.AP_VOTER_LIST -->{poll_option.AP_VOTER_LIST}<!-- ELSE --><span name="none">{L_AP_NONE}</span><!-- ENDIF --></span></div>
+++		<div class="space10"></div>
+++	</div>
+++<!-- ENDIF -->
+++<!-- IF WOLFSBLVT_POLL_SCORING -->
+++	<span class="hidden" jxdom-target="[data-poll-option-id={poll_option.POLL_OPTION_ID}]" jxdom-find="div.poll_option_select" jxdom-action="remove"></span>
+++	<div class="hidden" jxdom-target="[data-poll-option-id={poll_option.POLL_OPTION_ID}]" jxdom-find="> :first-child" jxdom-action="before">
+++		<div class="poll_option_select pull-left">
+++		<!-- IF AP_IS_SCORING -->
+++			<select name="vote_id[{poll_option.POLL_OPTION_ID}]" id="vote_{poll_option.POLL_OPTION_ID}"<!-- IF not S_CAN_VOTE --> disabled="disabled"<!-- ENDIF -->>{poll_option.AP_POLL_OPTION_OPTS}</select>
+++		<!-- ELSE -->
+++			<input type="<!-- IF S_IS_MULTI_CHOICE -->checkbox<!-- ELSE -->radio<!-- ENDIF -->" name="vote_id[]" id="vote_{poll_option.POLL_OPTION_ID}" value="{poll_option.POLL_OPTION_ID}"<!-- IF poll_option.POLL_OPTION_VOTED --> checked="checked"<!-- ENDIF --><!-- IF not S_CAN_VOTE --> disabled="disabled"<!-- ENDIF --> />
+++		<!-- ENDIF -->
+++		</div>
+++	</div>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html"
++new file mode 100644
++index 000000000..ce566920d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html"
++@@ -0,0 +1,5 @@
+++<!-- IF U_AP_POLL_INFO -->
+++<div class="btn-group hidden-xs">
+++	<a href="{U_AP_POLL_INFO}" title="{L_INFORMATION}" class="btn btn-success"><i class="fa fa-info"></i></a>
+++</div>
+++<!-- ENDIF -->
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js"
++new file mode 100644
++index 000000000..de5a8bc5e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js"
++@@ -0,0 +1,176 @@
+++/**
+++ *
+++ * Advanced Polls
+++ *
+++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Clemens Husung (Wolfsblvt)
+++ */
+++
+++// namespacing
+++head.ready(function(){
+++$.wolfsblvt = $.extend({}, $.wolfsblvt, {
+++
+++	/// <field name="cookie_advancedsearchbox_name" type="string">The Cookie Name for advanced searchbox pin setting.</field>
+++	advancedpoll_json_data: wolfsblvt_ap_json_data,
+++
+++	override_callback_advancedpolls_vote_poll_hidden: function (res) {
+++		/// <summary>
+++		///		Overrides the ajax callback function for poll votes
+++		/// </summary>
+++		/// <param name="res" type="object">(object) The results of the poll.</param>
+++
+++		if (typeof res.success !== 'undefined') {
+++			var poll = $('.topic_poll');
+++			var panel = poll.find('.panel');
+++			var resultsVisible = poll.find('dl:first-child .resultbar').is(':visible');
+++
+++			// Define functions we need inside of that function here
+++			var updatePanelHeight = function (height) {
+++				height = (typeof height === 'undefined') ? panel.find('.inner').outerHeight() : height;
+++				panel.css('min-height', height);
+++			};
+++			var resizePanel = function (time) {
+++				var panelHeight = panel.height();
+++				var innerHeight = panel.find('.inner').outerHeight();
+++
+++				if (panelHeight !== innerHeight) {
+++					panel.css({ 'min-height': '', 'height': panelHeight })
+++						.animate({ height: innerHeight }, time, function () {
+++							panel.css({ 'min-height': innerHeight, 'height': '' });
+++						});
+++				}
+++			};
+++
+++			// Set min-height to prevent the page from jumping when the content changes
+++			updatePanelHeight();
+++
+++			// Remove the View results link
+++			if (!resultsVisible) {
+++				poll.find('.poll_view_results').hide(500);
+++			}
+++
+++			if (!res.can_vote) {
+++				poll.find('.polls, .poll_max_votes, .poll_vote, .poll_option_select').fadeOut(500, function () {
+++					poll.find('.resultbar, .poll_option_percent, .poll_total_votes').show();
+++				});
+++			} else {
+++				// If the user can still vote, simply slide down the results
+++				poll.find('.resultbar, .poll_option_percent, .poll_total_votes').show(500);
+++			}
+++
+++			// Get the votes count of the highest poll option
+++			// no
+++
+++			// Update the total votes count
+++			poll.find('.poll_total_vote_cnt').html("??");
+++
+++			// Update each option
+++			poll.find('[data-poll-option-id]').each(function () {
+++				var $this = $(this);
+++				var optionId = $this.attr('data-poll-option-id');
+++				var voted = (typeof res.user_votes[optionId] !== 'undefined');
+++				var altText;
+++
+++				altText = $this.attr('data-alt-text');
+++				if (voted) {
+++					$this.attr('title', $.trim(altText));
+++				} else {
+++					$this.attr('title', '');
+++				};
+++
+++				$this.toggleClass('voted', voted);
+++			});
+++
+++			if (!res.can_vote) {
+++				poll.find('.polls').delay(400).fadeIn(500);
+++			}
+++
+++			// Display "Your vote has been cast." message. Disappears after 5 seconds.
+++			var confirmationDelay = (res.can_vote) ? 300 : 900;
+++			poll.find('.vote-submitted').delay(confirmationDelay).slideDown(200, function () {
+++				if (resultsVisible) {
+++					updatePanelHeight();
+++				}
+++
+++				$(this).delay(5000).fadeOut(500, function () {
+++					resizePanel(300);
+++				});
+++			});
+++
+++			// Remove the gap resulting from removing options
+++			setTimeout(function () {
+++				resizePanel(500);
+++			}, 1500);
+++		}
+++	},
+++	extend_callback_advancedpolls_vote_poll_show_voters: function (res) {
+++		/// <summary>
+++		///		Extends the ajax callback function to show poll voters
+++		/// </summary>
+++		/// <param name="res" type="object">(object) The results of the poll.</param>
+++
+++		if (typeof res.success !== 'undefined') {
+++			var poll = $('.topic_poll');
+++			var scoring = (typeof res.scoring !== 'undefined');
+++			var spanname = 'name="' + $.wolfsblvt.advancedpoll_json_data.username_clean + '"';
+++			var spanval_begin = "<span " + spanname + ">" + $.wolfsblvt.advancedpoll_json_data.username_string;
+++			var spanval_end = "</span>";
+++
+++			console.log("running the extended callback code");
+++
+++			// Update each option
+++			poll.find('[data-poll-option-id]').each(function () {
+++				var $this = $(this);
+++				var $votersbox_voters = $this.next(".poll_voters_box").find(".poll_voters");
+++				var optionId = $this.attr('data-poll-option-id');
+++				var voted = (typeof res.user_votes[optionId] !== 'undefined');
+++				var spanval = spanval_begin + ((scoring) ? "(" + res.user_vote_counts[optionId] + ")" : "") + spanval_end;
+++
+++				var $voter_user = $votersbox_voters.children("span[" + spanname + "]");
+++
+++				if (voted) {
+++					if ($voter_user.length === 0) {
+++						if (res.vote_counts[optionId] > ((scoring) ? res.user_vote_counts[optionId] : 1)) {
+++							// If there are more voters than just the current user, add seperator after last element
+++							$votersbox_voters.children(":last-child").after($.wolfsblvt.advancedpoll_json_data.l_seperator);
+++						}
+++						else {
+++							// Remove the "No voters" notice
+++							$votersbox_voters.children('span[name="none"]').hide(500, function () { $(this).remove(); });
+++						}
+++						$(spanval).hide().appendTo($votersbox_voters).show(500);
+++					}
+++					else {
+++						if (scoring) {
+++							$(spanval).hide().replaceAll($voter_user).show(500);
+++						}
+++					}
+++				}
+++				else {
+++					if ($voter_user.length > 0) {
+++						var callback = function () {
+++							if (res.vote_counts[optionId] > 0) {
+++								if (this.nextSibling !== null) {
+++									this.nextSibling.remove();
+++								}
+++								else {
+++									if (this.previousSibling !== null) {
+++										this.previousSibling.remove();
+++									}
+++								}
+++							}
+++							else {
+++								var $none_voter = $('<span name="none">' + $.wolfsblvt.advancedpoll_json_data.l_none + "</span>").hide();
+++								$none_voter.appendTo($votersbox_voters).show(500);
+++							}
+++							$(this).remove();
+++						};
+++						$voter_user.hide(500, callback);
+++					}
+++				}
+++			});
+++		}
+++	},
+++});
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js"
++new file mode 100644
++index 000000000..4de79edf7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js"
++@@ -0,0 +1,44 @@
+++/**
+++ *
+++ * Advanced Polls
+++ *
+++ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Clemens Husung (Wolfsblvt)
+++ */
+++
+++head.ready(function(){
+++$(document).ready(function () {
+++	// replace the ajax callback for poll votes if votes are hidden
+++	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
+++		phpbb.addAjaxCallback('vote_poll', $.wolfsblvt.override_callback_advancedpolls_vote_poll_hidden);
+++	}
+++
+++	// extend the ajax callback for poll votes if voters should be shown
+++	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_voters_show_topic && !$.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
+++		var old_function = phpbb.ajaxCallbacks['vote_poll'];
+++		//phpbb.addAjaxCallback('vote_poll', function (res) { old_function(res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
+++		phpbb.addAjaxCallback('vote_poll', function (res) { old_function.call(this, res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
+++	}
+++
+++	// Modify the "view results" link to set the "don't want to vote"
+++	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_no_vote) {
+++		$('.poll_view_results a').click(function () {
+++			var $poll = $(this).parents('.topic_poll');
+++
+++			if (!$.wolfsblvt.advancedpoll_json_data.can_change_vote) {
+++				// Remove vote possibilitys
+++				$poll.find('.poll_max_votes, .poll_vote, .poll_option_select').hide(500);
+++			}
+++
+++			// Set it in the database
+++			$.ajax({
+++				url:	location.href,
+++				data: {
+++					no_vote:	true,
+++				},
+++			});
+++		});
+++	}
+++});
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js"
++new file mode 100644
++index 000000000..f5c7c325f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js"
++@@ -0,0 +1,102 @@
+++/**
+++ *
+++ * Advanced Polls - Poll Length Posting aids
+++ *
+++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Javier Lopez (javiexin)
+++ */
+++
+++var apPollStartInitial = new Date();
+++var apPollStart  = new Date();
+++var apPollEnd    = new Date();
+++var apPollLength = 0; // seconds
+++var apPollLengthScale = 24; // days by default
+++
+++apInitPollLength();
+++
+++function apInitPollLength()
+++{
+++	var year = document.getElementById('wolfsblvt_poll_end_year').value;
+++	if (year != "") apPollEnd.setFullYear(year);
+++	var mon = document.getElementById('wolfsblvt_poll_end_mon').value;
+++	if (mon != "") apPollEnd.setMonth(mon - 1);
+++	var mday = document.getElementById('wolfsblvt_poll_end_mday').value;
+++	if (mday != "") apPollEnd.setDate(mday);
+++	var hours = document.getElementById('wolfsblvt_poll_end_hours').value;
+++	if (hours != "") apPollEnd.setHours(hours);
+++	var minutes = document.getElementById('wolfsblvt_poll_end_minutes').value;
+++	if (minutes != "") apPollEnd.setMinutes(minutes);
+++
+++	var length = document.getElementById('poll_length').value;
+++	if (length > 0) apPollLength = length * apPollLengthScale * 3600;
+++
+++	apPollStart.setTime(apPollEnd.getTime() - apPollLength * 1000);
+++	apPollStartInitial = apPollStart;
+++
+++	var duration = (length > 0) ? 1 : 0;
+++	document.getElementById('wolfsblvt_poll_duration').selectedIndex = duration;
+++	apChangeDuration(document.getElementById('wolfsblvt_poll_duration').value);
+++}
+++
+++function apChangeDuration(val)
+++{
+++	apUpdatePollEnd(val != '');
+++	document.getElementById('wolfsblvt_poll_length').style.display='none';
+++	document.getElementById('wolfsblvt_poll_end').style.display='none';
+++	if (val != '') document.getElementById(val).style.display='inline-block';
+++}
+++
+++function apAdjustLengthScale(newScale)
+++{
+++	apPollLengthScale = newScale;
+++	apUpdatePollEnd(true);
+++}
+++
+++function apAdjustLength(val)
+++{
+++	apPollLength = val * apPollLengthScale * 3600;
+++	apPollEnd.setTime(apPollStart.getTime() + apPollLength * 1000);
+++	apUpdatePollEnd(true);
+++}
+++
+++function apAdjustEnd(what, val)
+++{
+++	if (what == "year")	{
+++		apPollEnd.setFullYear(val);
+++	} else if (what == "mon") {
+++		apPollEnd.setMonth(val - 1);
+++	} else if (what == "mday") {
+++		apPollEnd.setDate(val);
+++	} else if (what == "hours") {
+++		apPollEnd.setHours(val);
+++	} else if (what == "minutes") {
+++		apPollEnd.setMinutes(val);
+++	}
+++	apUpdatePollEnd(true);
+++}
+++
+++function apUpdatePollEnd(fill)
+++{
+++	var pollLengthValue =  Math.ceil((apPollEnd.getTime() - apPollStartInitial.getTime()) / 1000 / 3600 / apPollLengthScale);
+++	apPollLength = pollLengthValue * apPollLengthScale * 3600;
+++	apPollStart.setTime(apPollEnd.getTime() - apPollLength * 1000);
+++
+++	if (fill) {
+++		document.getElementById('wolfsblvt_poll_end_label').innerHTML = apPollEnd.getFullYear() + "/" + (apPollEnd.getMonth() + 1) + "/" + apPollEnd.getDate() + "&nbsp;" + apPollEnd.getHours() + ":" + apPollEnd.getMinutes();
+++		document.getElementById('wolfsblvt_poll_end_year').value = apPollEnd.getFullYear();
+++		document.getElementById('wolfsblvt_poll_end_mon').value = apPollEnd.getMonth() + 1;
+++		document.getElementById('wolfsblvt_poll_end_mday').value = apPollEnd.getDate();
+++		document.getElementById('wolfsblvt_poll_end_hours').value = apPollEnd.getHours();
+++		document.getElementById('wolfsblvt_poll_end_minutes').value = apPollEnd.getMinutes();
+++		document.getElementById('poll_length').value = pollLengthValue;
+++	} else {
+++		document.getElementById('wolfsblvt_poll_end_label').innerHTML = "";
+++		document.getElementById('wolfsblvt_poll_end_year').value = "";
+++		document.getElementById('wolfsblvt_poll_end_mon').value = "";
+++		document.getElementById('wolfsblvt_poll_end_mday').value = "";
+++		document.getElementById('wolfsblvt_poll_end_hours').value = "";
+++		document.getElementById('wolfsblvt_poll_end_minutes').value = "";
+++		document.getElementById('poll_length').value = 0;
+++	}
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js"
++new file mode 100644
++index 000000000..43d97eb7c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js"
++@@ -0,0 +1,18 @@
+++/**
+++ *
+++ * Advanced Polls - Poll Length Reposition
+++ *
+++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Javier Lopez (javiexin)
+++ */
+++
+++$(document).ready(function () {
+++	var $pollLengthDl = $('label > #poll_length').closest('div');
+++	var $container = $("#ap_poll_length_container");
+++	var $content = $container.contents();
+++
+++	$pollLengthDl.prev('div').remove();
+++	$pollLengthDl.replaceWith($content);
+++	$container.remove();
+++});
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js"
++new file mode 100644
++index 000000000..217f96c78
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js"
++@@ -0,0 +1,18 @@
+++/**
+++ *
+++ * Advanced Polls - Scoring Polls
+++ *
+++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Javier Lopez (javiexin)
+++ */
+++
+++$(document).ready(function () {
+++	var $poll = $('#preview fieldset.polls');
+++	var $container = $("#ap_poll_preview_hidden_container");
+++	var $content = $container.contents();
+++
+++	$poll.children().remove();
+++	$poll.append($content);
+++	$container.remove();
+++});
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js"
++new file mode 100644
++index 000000000..a1109ca14
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js"
++@@ -0,0 +1,21 @@
+++/**
+++ *
+++ * Advanced Polls - Scoring Polls
+++ *
+++ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @author Javier Lopez (javiexin)
+++ */
+++
+++$(document).ready(function () {
+++	var $poll = $('.topic_poll');
+++
+++	$poll.find('[data-poll-option-id]').each(function () {
+++		var $this = $(this);
+++		var optionId = $this.attr('data-poll-option-id');
+++		var $container = $poll.find('#poll_option_hidden_container_' + optionId)
\ No newline at end of file
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/advancedpolls.php" "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/advancedpolls.php"
deleted file mode 100644
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/advancedpolls.php"
+++ /dev/null
@@ -1,92 +0,0 @@
-<?php
-/**
- *
- * Advanced Polls [Japanese]
- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
- * @author Clemens Husung (Wolfsblvt)
- */
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
-//
-
-$lang = array_merge($lang, array(
-	'ADVANCEDPOLLS_EXT_NAME'			=> 'Advanced Polls',
-
-// Viewtopic
-	'AP_VOTES_HIDDEN'				=> '結果は表示されません',
-	'AP_POLL_RUN_TILL_APPEND'			=> '。終了まで投票結果は非表示となります。',
-	'AP_VOTERS'					=> '投票者',
-	'AP_NONE'					=> 'なし',
-
-	'AP_POLL_CANT_VOTE'				=> 'この投票には参加できません。理由：',
-	'AP_POLL_REASON_NOT_POSTED'			=> 'まだこのトピックで投稿を行っていません。',
-	'AP_POLL_VOTES_ARE_VISIBLE'			=> '投票後にあなたの投票が見えるようになります。',
-	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> '投票せずに結果を表示する',
-	'AP_POLL_RESULTS_ARE_ORDERED'			=> '投票結果は得票数の多い順に並びます',
-	'AP_POLL_TYPE_MISMATCH'				=> '一貫性のない投票データのため内部エラーが発生しました',
-	'AP_VOTE_CHANGED'				=> '投票内容を変更する権限がありません。',
-	'AP_TOO_MANY_VOTES'				=> '投票オプション数が多すぎます。', // You have tried to assign too many votes.
-
-	'AP_MAX_VOTES_SELECT'					=> array(
-		1	=> '<strong>%1$d</strong> オプションに最大 <strong>%2$d</strong> 票を投じることができます',
-		2	=> '<strong>%1$d</strong> オプションの中から最大 <strong>%2$d</strong> 票を投じることができます',
-	),
-	'AP_GUEST_VOTES'						=> array(
-		1	=> 'ゲスト票：%d 票', // %d vote from guest
-		2	=> 'ゲスト票：%d 票', // %d votes from guests
-	),
-
-// Posting
-	'AP_POLL_VOTES_HIDE'				=> '投票結果を非表示にする',
-	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'これを有効にすると、投票結果は投票が終了するまで非表示になります。この項目は特定の期限設定を持つ場合のみ動作します。',
-	'AP_POLL_VOTERS_SHOW'				=> '投票者を表示する',
-	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'これを有効にすると、閲覧権限を持つユーザーにのみ投票者が表示されます。投票結果を非表示にしている場合は投票者も非表示になります。',
-	'AP_POLL_VOTERS_LIMIT'				=> '投票対象者を制限する',
-	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'これを有効にすると、このトピックに記事を投稿した人だけが投票できます',
-	'AP_POLL_SHOW_ORDERED'				=> '得票順に表示する',
-	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> '投票結果が表示されるとき、得票数の降順に並びます（得票数の高いもの順）。未選択の場合は投票オプションの順序が使用されます。',
-	'AP_RUN_POLL'					=> '投票期間',
-	'AP_RUN_POLL_FOR'				=> '日数指定',
-	'AP_RUN_POLL_UNTIL'				=> '終了日指定',
-	'AP_RUN_POLL_INDEFINITELY'			=> '無期限',
-	'AP_POLL_END'					=> '投票終了',
-	'AP_POLL_END_EXPLAIN'				=> '投票終了日時を指定してください。これらのフィールドのいずれかが指定されている場合、投票の期間を上書きします。日付フィールドは空のままで、デフォルトは現在の投票終了日です。時間フィールドは空のままで、デフォルトは0です。投票期間を使用するために戻す場合は、これらすべてのフィールドを消去する必要があります。',
-
-	'AP_YYYY_MM_DD'					=> 'YYYY-MM-DD',
-	'AP_HH_MM'					=> 'HH:MM',
-	'AP_POLL_END_INVALID'				=> '指定した日/時に誤りがあります',
-	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> '1つのオプションの投票数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
-	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> '投票可能なオプション数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
-
-	'AP_POLL_MAX_VALUE'				=> '最大投票数',
-	'AP_POLL_MAX_VALUE_EXPLAIN'			=> '投票者が1つのオプションに付与できる最大投票数です',
-	'AP_POLL_TOTAL_VALUE'				=> '投票者数',
-	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> '投票者がすべてのオプションに分配する可能性のある投票の総数です',
-
-	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> '許可されている最大値を超える投票数を割り当てることはできません',
-));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php" "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php"
deleted file mode 100644
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/info_acp_advancedpolls.php"
+++ /dev/null
@@ -1,75 +0,0 @@
-<?php
-/**
- *
- * Advanced Polls [Japanese]
- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
- * @author Clemens Husung (Wolfsblvt)
- */
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
-//
-
-$lang = array_merge($lang, array(
-	'AP_TITLE_ACP'				=> 'Advanced Polls',
-	'AP_SETTINGS_ACP'			=> '設定',
-
-	'AP_TITLE'				=> 'Advanced Polls',
-	'AP_TITLE_EXPLAIN'			=> 'phpBBのコア投票システムを、投票終了まで結果を非表示にする、投票したユーザーを表示する、投票可能ユーザーを制限するなどの新機能を使用して進化向上します。',
-	'AP_COPYRIGHT'				=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Wolfsblvt が提供するその他の拡張モジュール</a>]',
-
-	'AP_SETTINGS'				=> 'Advanced Polls の設定',
-	'AP_GLOBAL_SETTINGS'			=> 'Advanced Polls のグローバル設定（全ての投票に適用されます）',
-	'AP_PER_POLL_SETTINGS'			=> 'Advanced Polls の投票ごとの設定（投票ごとに選択可能、デフォルト値はここで設定）',
-
-	'AP_ACT_VOTES_HIDE'			=> '投票結果非表示を有効にする',
-	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> '投票が終了するまで投票結果を非表示にすることを選択するオプションを有効化します。',
-	'AP_ACT_VOTERS_SHOW'			=> '投票者表示を有効にする',
-	'AP_ACT_VOTERS_SHOW_EXPLAIN'		=> '各投票オプションに対して投票投票者を表示することを選択するオプションを有効化します。',
-	'AP_ACT_VOTERS_LIMIT'			=> '投票者制限を有効にする',
-	'AP_ACT_VOTERS_LIMIT_EXPLAIN'		=> 'このトピックで既に投稿したユーザーにのみ投票を制限することを選択するオプションを有効化します。',
-	'AP_ACT_POLL_NO_VOTE'			=> '無投票を有効にする',
-	'AP_ACT_POLL_NO_VOTE_EXPLAIN'		=> '標準の「結果を表示する」リンクから「投票せずに結果を表示する」リンクに変更します。「投票を変更する」を選択しない限り、結果を表示した後に投票できません。',
-	'AP_ACT_SHOW_ORDERED'			=> '得票順表示を有効にする',
-	'AP_ACT_SHOW_ORDERED_EXPLAIN'		=> '得票の降順（得票数の高いもの順）で結果を表示することを選択するオプションを有効化します。',
-	'AP_ACT_POLL_SCORING'			=> '投票スコアリングを有効にする',
-	'AP_ACT_POLL_SCORING_EXPLAIN'		=> '投票オプションに異なるスコアを割り当てる可能性を有効化します。',
-	'AP_ACT_INCREMENTAL_VOTES'		=> '段階投票を有効にする', // Activate incremental voting
-	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> '利用可能な投票機能を使い果たしていない間、段階的に投票する可能性を有効化します。',
-	'AP_ACT_CLOSED_VOTING'			=> '閉鎖トピックの投票を有効にする', // Activate closed voting
-	'AP_ACT_CLOSED_VOTING_EXPLAIN'		=> '対応するトピックが閉鎖されている場合でも、公開投票に投票する可能性を有効化します。',
-	'AP_ACT_POLL_END'			=> '投票終了設定を有効にする',
-	'AP_ACT_POLL_END_EXPLAIN'		=> '投票が開始されてから投票期間を指定するだけでなく、日付/時刻で投票が終了するタイミングを指定できます。',
-	'AP_ACT_POLL_NOTIFICATIONS'		=> '投票通知を有効にする',
-	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'	=> '投票結果を非表示にした投票が終了したときに全ての投票者に通知を送る機能を有効にします。それに従い、投票結果が見えるようになります。',
-
-	'AP_DEFAULT_VOTES_CHANGE'		=> '再投票許可の設定をデフォルトにする',
-	'AP_DEFAULT_VOTES_HIDE'			=> '投票結果非表示の設定をデフォルトにする',
-	'AP_DEFAULT_VOTERS_SHOW'		=> '投票者表示の設定をデフォルトにする',
-	'AP_DEFAULT_VOTERS_LIMIT'		=> '投票者制限の設定をデフォルトにする',
-	'AP_DEFAULT_SHOW_ORDERED'		=> '得票順表示をデフォルトにする',
-));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/advancedpolls.php" "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/advancedpolls.php"
deleted file mode 100644
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/advancedpolls.php"
+++ /dev/null
@@ -1,92 +0,0 @@
-<?php
-/**
- *
- * Advanced Polls [Polish]
- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
- * @author Clemens Husung (Wolfsblvt)
- */
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
-//
-
-$lang = array_merge($lang, array(
-	'ADVANCEDPOLLS_EXT_NAME'				=> 'Zaawansowane głosowanie',
-
-// Viewtopic
-	'AP_VOTES_HIDDEN'						=> 'Ukryte głosy',
-	'AP_POLL_RUN_TILL_APPEND'				=> ', do tej pory wszystkie głosy będą ukryte.',
-	'AP_VOTERS'								=> 'Głosujący',
-	'AP_NONE'								=> 'Brak',
-
-	'AP_POLL_CANT_VOTE'						=> 'Nie możesz głosować w tej ankiecie. Powód',
-	'AP_POLL_REASON_NOT_POSTED'				=> 'nie pisałeś w tym wątku.',
-	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Jeśli głosujesz, Twój głos będzie widoczny.',
-	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Nie głosuj, zobacz wyniki, ale stracisz prawo do głosowania',
-	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Wyniki są ułożone według malejącej ilości otrzymanych głosów.',
-	'AP_POLL_TYPE_MISMATCH'					=> 'Niespójne dane ankiety, błąd wewnętrzny.',
-	'AP_VOTE_CHANGED'						=> 'Nie masz uprawnień do zmiany oddanych głosów.',
-	'AP_TOO_MANY_VOTES'						=> 'Próbowałeś oddać zbyt wiele głosów.',
-
-	'AP_MAX_VOTES_SELECT'					=> array(
-		1	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głos na <strong>%1$d</strong> opcję',
-		2	=> 'Możesz oddać maksymalnie do <strong>%2$d</strong> głosów wśród <strong>%1$d</strong> opcji',
-	),
-	'AP_GUEST_VOTES'						=> array(
-		1	=> '%d głos od Gościa',
-		2	=> '%d głosy od Gości',
-	),
-
-// Posting
-	'AP_POLL_VOTES_HIDE'					=> 'Ukryj głosy',
-	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Jeśli włączone, głosy będą ukryte do końca głosowania. Ta opcja działa jeśli jest wyznaczony koniec ankiety.',
-	'AP_POLL_VOTERS_SHOW'					=> 'Pokaż głosy głosujących',
-	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Jeśli włączone, głosujący będą pokazani tym użytkownikom, którzy mają uprawnienia. Głosujący pozostaną ukryci jeśli głosy są ukryte.',
-	'AP_POLL_VOTERS_LIMIT'					=> 'Ograniczenie głosów',
-	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Jeśli włączone, użytkownicy mogą głosować tylko wtedy gdy pisali w tym wątku.',
-	'AP_POLL_SHOW_ORDERED'					=> 'Pokaż kolejność wyników',
-	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Wyświetlane wyniki są uporządkowane według malejącej liczby otrzymanych głosów (najpierw najwięcej głosów). W przeciwnym razie używana jest kolejność opcji ankiety.',
-	'AP_RUN_POLL'							=> 'Uruchom ankietę',
-	'AP_RUN_POLL_FOR'						=> 'przez',
-	'AP_RUN_POLL_UNTIL'						=> 'aż do',
-	'AP_RUN_POLL_INDEFINITELY'				=> 'bez końca',
-	'AP_POLL_END'							=> 'koniec ankiety',
-	'AP_POLL_END_EXPLAIN'					=> 'Określ datę i godzinę zakończenia ankiety. Jeśli którekolwiek z tych pól jest określone, zastępuje ono długość ankiety. Pola daty domyślnie pozostawiono puste, domyślnie bieżąca data zakończenia ankiety; pola godzin pozostawione puste, domyślnie ustawione na 0. Jeśli chcesz powrócić do korzystania z długości ankiety, będziesz musiał wyczyścić wszystkie te pola.',
-
-	'AP_YYYY_MM_DD'							=> 'YYYY-MM-DD',
-	'AP_HH_MM'								=> 'HH:MM',
-	'AP_POLL_END_INVALID'					=> 'Określona data/czas są niewłaściwe',
-	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'Maksymalna liczba głosów przypadająca na jedną opcję nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
-	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'Maksymalna liczba opcji głosowania nie może przekraczać łącznej liczby głosów do podziału na wszystkie opcje',
-
-	'AP_POLL_MAX_VALUE'						=> 'Maksymalna liczba głosów',
-	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'To jest maksymalna liczba głosów, jaką głosujący może oddać na jedną opcję.',
-	'AP_POLL_TOTAL_VALUE'					=> 'Razem głosów',
-	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'To jest całkowita liczba głosów, jaką głosujący może rozdzielić na wszystkie opcje.',
-
-	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Nie możesz przydzielić liczby głosów większej niż maksymalna dozwolona wartość.',
-));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php" "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php"
deleted file mode 100644
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/info_acp_advancedpolls.php"
+++ /dev/null
@@ -1,75 +0,0 @@
-<?php
-/**
- *
- * Advanced Polls [Polish]
- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
- * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
- * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
- * @author Clemens Husung (Wolfsblvt)
- */
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
-//
-
-$lang = array_merge($lang, array(
-	'AP_TITLE_ACP'					=> 'Zaawansowane głosowanie',
-	'AP_SETTINGS_ACP'				=> 'Ustawienia',
-
-	'AP_TITLE'						=> 'Zaawansowane głosowanie',
-	'AP_TITLE_EXPLAIN'				=> 'Zaawansowane głosowanie to podstawowy system ankiet phpBB z nowymi funkcjami, takimi jak ukrywanie głosów do końca, pokazywanie wyborców, ograniczanie głosów i nie tylko.',
-	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Więcej rozszerzeń od Wolfsblvt</a>]',
-
-	'AP_SETTINGS'					=> 'Zaawansowane głosowanie - Ustawienia',
-	'AP_GLOBAL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia ogólne (zastosowanie do wszystkich ankiet)',
-	'AP_PER_POLL_SETTINGS'			=> 'Zaawansowane głosowanie - ustawienia poszczególnych ankiet (do wyboru w każdej ankiecie, z ustawioną tutaj wartością domyślną)',
-
-	'AP_ACT_VOTES_HIDE'				=> 'Pokazuj głosy',
-	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Wybierz tę opcję, żeby ukryć oddane głosy do końca głosowania.',
-	'AP_ACT_VOTERS_SHOW'			=> 'Pokazuj głosujących',
-	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Wybierz tę opcję, żeby pokazać głosujących przy każdej opcji głosowania.',
-	'AP_ACT_VOTERS_LIMIT'			=> 'Ogranicz liczkę głosujących',
-	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Wybierz tę opcję, żeby ograniczyć głosujących do użytkowników piszących w tym wątku.',
-	'AP_ACT_POLL_NO_VOTE'			=> 'Pokazuj Brak głosu',
-	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Zmienia standardowy link „Wyświetl wyniki” na link „Nie głosuj, wyświetl wyniki”, który nie zezwala na głosowanie po wyświetleniu wyników, chyba że wybrano opcję „Zmień głosy”.',
-	'AP_ACT_SHOW_ORDERED'			=> 'Pokazuj kolejność',
-	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Aktywuje opcję pokazania wyników w kolejności malejącej liczby otrzymanych głosów (najpierw głosowano najwyżej).',
-	'AP_ACT_POLL_SCORING'			=> 'Pokazuj przewijanie głosowania',
-	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Aktywuje możliwość przypisywania różnych wyników do opcji ankiety.',
-	'AP_ACT_INCREMENTAL_VOTES'		=> 'Pokazuj stopniowanie głosów',
-	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Aktywuje możliwość głosowania stopniowego, gdy nie wyczerpałeś dostępnych możliwości głosowania.',
-	'AP_ACT_CLOSED_VOTING'			=> 'Pozwalaj na głosowanie zamknięte',
-	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Włącza możliwość głosowania w otwartej ankiecie, nawet jeśli odpowiedni temat jest zablokowany.',
-	'AP_ACT_POLL_END'				=> 'Pokazuj dokładny koniec ankiety',
-	'AP_ACT_POLL_END_EXPLAIN'		=> 'Pozwala określić, kiedy ankieta kończy się według daty / godziny, zamiast tylko określać czas trwania ankiety od jej rozpoczęcia.',
-	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Pokazuj powiadomienia ankiety',
-	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Aktywuje wysyłanie powiadomień do wszystkich wyborców o ukrytej ankiecie po zakończeniu ankiety, dzięki czemu wyniki są widoczne.',
-
-	'AP_DEFAULT_VOTES_CHANGE'		=> 'Wybierz domyślne ustawienia zmiany oddanego głosu',
-	'AP_DEFAULT_VOTES_HIDE'			=> 'Wybierz domyślne ustawienia ukrytych głosujących',
-	'AP_DEFAULT_VOTERS_SHOW'		=> 'Wybierz domyślne ustawienia ilości głosujących',
-	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Wybierz domyślne ustawienia limitu głosujących',
-	'AP_DEFAULT_SHOW_ORDERED'		=> 'Wybierz domyślne dla pokazania kolejności',
-));
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/advancedpolls.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/advancedpolls.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/advancedpolls.php"
@@ -0,0 +1,94 @@
+<?php
+/**
+ *
+ * Advanced Polls [Spanish]
+ *
+ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Clemens Husung (Wolfsblvt)
+ * @author Initial translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+ * @author Continued translation by javiexin (http://www.exincastillos.es)
+ * @author Continued translation by jasolo (https://github.com/jasoloz)
+ */
+
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
+	'ADVANCEDPOLLS_EXT_NAME'				=> 'Votações Avançadas',
+
+// Viewtopic
+	'AP_VOTES_HIDDEN'						=> 'Votos ocultos',
+	'AP_POLL_RUN_TILL_APPEND'				=> ', até que todos os votos estarão ocultos.',
+	'AP_VOTERS'								=> 'Votantes',
+	'AP_NONE'								=> 'Ninguém',
+
+	'AP_POLL_CANT_VOTE'						=> 'Não podes votar nesta votação. Razão',
+	'AP_POLL_REASON_NOT_POSTED'				=> 'Não escreveu neste tema.',
+	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Tem em conta que se votares, o teu voto será visível.',
+	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Não quero votar, quero ver os resultados',
+	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Os resultados estão ordenados por número decrescente de votos recebidos.',
+	'AP_POLL_TYPE_MISMATCH'					=> 'Dados inconsistentes na votação, erro interno.',
+	'AP_VOTE_CHANGED'						=> 'Não tem permissão para alterar os votos já emitidos.',
+	'AP_TOO_MANY_VOTES'						=> 'Tentou adicionar demasiados votos.',
+
+	'AP_MAX_VOTES_SELECT'					=> array(
+		1	=> 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
+		2	=> 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
+	),
+	'AP_GUEST_VOTES'						=> array(
+		1	=> '%d voto de convidado',
+		2	=> '%d votos de convidados',
+	),
+
+// Posting
+	'AP_POLL_VOTES_HIDE'					=> 'Ocultar votos',
+	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
+	'AP_POLL_VOTERS_SHOW'					=> 'Mostrar votantes da votação',
+	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Se estiver ativado, os votantes serão mostrados à quem tenha permissões. Tem em conta que os os votantes estarão ocultos caso os votos estejam ocultos.',
+	'AP_POLL_VOTERS_LIMIT'					=> 'Limite de votos',
+	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
+	'AP_POLL_SHOW_ORDERED'					=> 'Ordenar resultados',
+	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (ou mais votado primeiro). Em caso contrario, usa-se a ordem de opções na votação.',
+	'AP_RUN_POLL'							=> 'Realizar votação',
+	'AP_RUN_POLL_FOR'						=> 'durante',
+	'AP_RUN_POLL_UNTIL'						=> 'até',
+	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinidamente',
+	'AP_POLL_END'							=> 'Fim da votação',
+	'AP_POLL_END_EXPLAIN'					=> 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',
+
+	'AP_YYYY_MM_DD'							=> 'AAAA-MM-DD',
+	'AP_HH_MM'								=> 'HH:MM',
+	'AP_POLL_END_INVALID'					=> 'A data/hora especificada não é válida',
+	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
+	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',
+
+	'AP_POLL_MAX_VALUE'						=> 'Votos máximos',
+	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
+	'AP_POLL_TOTAL_VALUE'					=> 'Votos totais',
+	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',
+	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Não pode escolher um número de votos superior ao máximo permitido.',
+));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
similarity index 75%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/advancedpolls_common.php"
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/advancedpolls_common.php"
@@ -1,11 +1,12 @@
 <?php
 /**
  *
- * Advanced Polls [Polish]
- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
+ * Advanced Polls [Spanish]
+ *
  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
  * @author Clemens Husung (Wolfsblvt)
+ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
  */
 
 if (!defined('IN_PHPBB'))
@@ -35,6 +36,6 @@ if (empty($lang) || !is_array($lang))
 //
 
 $lang = array_merge($lang, array(
-	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Wyniki będą widoczne w ankiecie</strong>:',
-	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Wyniki są teraz widoczne dla ankiety, w której głosowałeś',
+	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Resultados visíveis para a votação</strong>:',
+	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Já podes ver os resultados de uma votação em que participaste',
 ));
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/info_acp_advancedpolls.php"
@@ -0,0 +1,76 @@
+<?php
+/**
+ *
+ * Advanced Polls [Spanish]
+ *
+ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Clemens Husung (Wolfsblvt)
+ * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+ */
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($ang) || !is_array($ang))
+{
+	$ang = array();
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
+//
+// Paceholders can now comtain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// transators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
+// equally where a string comtains only two paceholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$ang = array_merge($ang, array(
+	'AP_TITLE_ACP'					=> 'Votações Avançadas',
+	'AP_SETTINGS_ACP'				=> 'Configuração',
+
+	'AP_TITLE'						=> 'Votações Avançadas',
+	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
+	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',
+
+	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
+	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
+	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',
+
+	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
+	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
+	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
+	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
+	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
+	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
+	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
+	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
+	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
+	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
+	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
+	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
+	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
+	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
+	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
+	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
+	'AP_ACT_POLL_END'				=> 'Activar final de votação',
+	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
+	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
+	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',
+
+	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
+	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
+	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
+	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
+	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
+));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
similarity index 83%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/permissions_advancedpolls.php"
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt/permissions_advancedpolls.php"
@@ -1,11 +1,12 @@
 <?php
 /**
  *
- * Advanced Polls [Japanese]
- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
+ * Advanced Polls [Spanish]
+ *
  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
  * @author Clemens Husung (Wolfsblvt)
+ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
  */
 
 if (!defined('IN_PHPBB'))
@@ -43,6 +44,6 @@ if (empty($lang) || !is_array($lang))
 
 // User Permissions
 $lang = array_merge($lang, array(
-	'ACL_F_SEEVOTERS'			=> '投票者を見る', // Can see poll voters
-	'ACL_M_SEEVOTERS'			=> '投票者情報を閲覧する', // Can view poll voters
+	'ACL_F_SEEVOTERS'			=> 'Pode ver os votantes da votação',
+	'ACL_M_SEEVOTERS'			=> 'Pode ver os votantes da votação',
 ));
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls.php"
@@ -0,0 +1,94 @@
+<?php
+/**
+ *
+ * Advanced Polls [Spanish]
+ *
+ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Clemens Husung (Wolfsblvt)
+ * @author Initial translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+ * @author Continued translation by javiexin (http://www.exincastillos.es)
+ * @author Continued translation by jasolo (https://github.com/jasoloz)
+ */
+
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
+	'ADVANCEDPOLLS_EXT_NAME'				=> 'Votações Avançadas',
+
+// Viewtopic
+	'AP_VOTES_HIDDEN'						=> 'Votos ocultos',
+	'AP_POLL_RUN_TILL_APPEND'				=> ', até que todos os votos estarão ocultos.',
+	'AP_VOTERS'								=> 'Votantes',
+	'AP_NONE'								=> 'Ninguém',
+
+	'AP_POLL_CANT_VOTE'						=> 'Não podes votar nesta votação. Razão',
+	'AP_POLL_REASON_NOT_POSTED'				=> 'Não escreveu neste tema.',
+	'AP_POLL_VOTES_ARE_VISIBLE'				=> 'Tem em conta que se votares, o teu voto será visível.',
+	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> 'Não quero votar, quero ver os resultados',
+	'AP_POLL_RESULTS_ARE_ORDERED'			=> 'Os resultados estão ordenados por número decrescente de votos recebidos.',
+	'AP_POLL_TYPE_MISMATCH'					=> 'Dados inconsistentes na votação, erro interno.',
+	'AP_VOTE_CHANGED'						=> 'Não tem permissão para alterar os votos já emitidos.',
+	'AP_TOO_MANY_VOTES'						=> 'Tentou adicionar demasiados votos.',
+
+	'AP_MAX_VOTES_SELECT'					=> array(
+		1	=> 'Podes enviar até <strong>%2$d</strong> votos a <strong>%1$d</strong> opção',
+		2	=> 'Podes enviar até <strong>%2$d</strong> votos entre <strong>%1$d</strong> opções',
+	),
+	'AP_GUEST_VOTES'						=> array(
+		1	=> '%d voto de convidado',
+		2	=> '%d votos de convidados',
+	),
+
+// Posting
+	'AP_POLL_VOTES_HIDE'					=> 'Ocultar votos',
+	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'Se estiver ativado, os votos estarão ocultos até que a votação termine. Esta opção só funciona se a votação tiver um final determinado.',
+	'AP_POLL_VOTERS_SHOW'					=> 'Mostrar votantes da votação',
+	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'Se estiver ativado, os votantes serão mostrados à quem tenha permissões. Tem em conta que os os votantes estarão ocultos caso os votos estejam ocultos.',
+	'AP_POLL_VOTERS_LIMIT'					=> 'Limite de votos',
+	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'Se estiver ativado, os utilizadores habilitados só podem votar se escreveram neste tópico.',
+	'AP_POLL_SHOW_ORDERED'					=> 'Ordenar resultados',
+	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> 'Quando se mostram os resultados, estes se ordenam por número decrescente de votos recebidos (ou mais votado primeiro). Em caso contrario, usa-se a ordem de opções na votação.',
+	'AP_RUN_POLL'							=> 'Realizar votação',
+	'AP_RUN_POLL_FOR'						=> 'durante',
+	'AP_RUN_POLL_UNTIL'						=> 'até',
+	'AP_RUN_POLL_INDEFINITELY'				=> 'indefinidamente',
+	'AP_POLL_END'							=> 'Fim da votação',
+	'AP_POLL_END_EXPLAIN'					=> 'Especifica a data e hora do término da votação. Caso se especifique um destes campos, não teremos em conta a duração da votação. Os campos de data não especificados ficam com o valor do dia de hoje; os campos de hora não especificados ficam com o valor 0. Caso se queira voltar a utilizar a duração, terás de apagar o conteúdo de todos estes campos.',
+
+	'AP_YYYY_MM_DD'							=> 'AAAA-MM-DD',
+	'AP_HH_MM'								=> 'HH:MM',
+	'AP_POLL_END_INVALID'					=> 'A data/hora especificada não é válida',
+	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> 'O número máximo de votos a uma opção não pode ser superior ao total de votos a repartir entre as opções possíveis',
+	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> 'O número máximo de opções que se pode votar não pode ser superior ao total de votos a repartir entre as opções possíveis',
+
+	'AP_POLL_MAX_VALUE'						=> 'Votos máximos',
+	'AP_POLL_MAX_VALUE_EXPLAIN'				=> 'Este é o número máximo de votos que um votante pode escolher numa mesma opção.',
+	'AP_POLL_TOTAL_VALUE'					=> 'Votos totais',
+	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> 'Este é o número total de votos que um votante pode escolher, repartidos entre as opções possíveis.',
+	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> 'Não pode escolher um número de votos superior ao máximo permitido.',
+));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
similarity index 75%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/ja/advancedpolls_common.php"
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/advancedpolls_common.php"
@@ -1,11 +1,12 @@
 <?php
 /**
  *
- * Advanced Polls [Japanese]
- * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
+ * Advanced Polls [Spanish]
+ *
  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
  * @author Clemens Husung (Wolfsblvt)
+ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
  */
 
 if (!defined('IN_PHPBB'))
@@ -35,6 +36,6 @@ if (empty($lang) || !is_array($lang))
 //
 
 $lang = array_merge($lang, array(
-	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>投票結果が表示されます</strong>:',
-	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> '投票した結果が表示されるようになりました',
+	'NOTIFICATION_AP_POLL_ENDED'		=> '<strong>Resultados visíveis para a votação</strong>:',
+	'NOTIFICATION_TYPE_AP_POLL_ENDED'	=> 'Já podes ver os resultados de uma votação em que participaste',
 ));
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/info_acp_advancedpolls.php"
@@ -0,0 +1,76 @@
+<?php
+/**
+ *
+ * Advanced Polls [Spanish]
+ *
+ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Clemens Husung (Wolfsblvt)
+ * @author Transation by Raul [ThE KuKa] (https://github.com/phpbb-es)
+ */
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($ang) || !is_array($ang))
+{
+	$ang = array();
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All anguage files should use UTF-8 as their encoding and the files must not comtain a BOM.
+//
+// Paceholders can now comtain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// transators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single paceholders are used, e.g. 'Message %d' is fine
+// equally where a string comtains only two paceholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$ang = array_merge($ang, array(
+	'AP_TITLE_ACP'					=> 'Votações Avançadas',
+	'AP_SETTINGS_ACP'				=> 'Configuração',
+
+	'AP_TITLE'						=> 'Votações Avançadas',
+	'AP_TITLE_EXPLAIN'				=> 'Melhora o sistema de votações nativo de phpBB com novas possibilidades como ocultar votos até ao final, mostrar os votantes da votação, limitar os possíveis votantes e mais.',
+	'AP_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Mais Extensões de Wolfsblvt</a>]',
+
+	'AP_SETTINGS'					=> 'Configuração de Votações Avançadas',
+	'AP_GLOBAL_SETTINGS'			=> 'Configuração Global de Votações Avançadas (aplicável a todas as votações)',
+	'AP_PER_POLL_SETTINGS'			=> 'Configuração Por Votação de Votações Avançadas (selecionáveis por votação, com os valores por defeito indicados aqui)',
+
+	'AP_ACT_VOTES_HIDE'				=> 'Activar votos ocultos',
+	'AP_ACT_VOTES_HIDE_EXPLAIN'		=> 'Activa a opção de que os votos da votação estão ocultos hasta que termine a votação.',
+	'AP_ACT_VOTERS_SHOW'			=> 'Activar mostrar votantes',
+	'AP_ACT_VOTERS_SHOW_EXPLAIN'	=> 'Activa a opção de que se mostram os votantes de cada opção da votação.',
+	'AP_ACT_VOTERS_LIMIT'			=> 'Activar limitar votos',
+	'AP_ACT_VOTERS_LIMIT_EXPLAIN'	=> 'Activa a opção de limitar os votantes para una votação aos utilizadores que tenham escrito nesse tópico.',
+	'AP_ACT_POLL_NO_VOTE'			=> 'Activar não votar',
+	'AP_ACT_POLL_NO_VOTE_EXPLAIN'	=> 'Altera o link "Mostrar resultados" por link "Não quero votar", que não permite votar depois de ver os resultados a menos que "Altere o voto" que está seleccionado.',
+	'AP_ACT_SHOW_ORDERED'			=> 'Activar ordenação',
+	'AP_ACT_SHOW_ORDERED_EXPLAIN'	=> 'Activa a opção de mostrar os resultados por ordem descendente de votos recebidos (o mais votado primeiro).',
+	'AP_ACT_POLL_SCORING'			=> 'Activar votações pontuáveis',
+	'AP_ACT_POLL_SCORING_EXPLAIN'	=> 'Activa a possibilidade de escolher diferentes pontuações nas opções da votação.',
+	'AP_ACT_INCREMENTAL_VOTES'		=> 'Activar voto incremental',
+	'AP_ACT_INCREMENTAL_VOTES_EXPLAIN'	=> 'Activa a possibilidade de votar incrementalmente, caso ainda não se tenha emitido todos os votos disponíveis.',
+	'AP_ACT_CLOSED_VOTING'			=> 'Activar voto em tópicos fechados',
+	'AP_ACT_CLOSED_VOTING_EXPLAIN'	=> 'Activa a possibilidade de votar em votações abertas inclusive quando o tópico correspondente está fechado.',
+	'AP_ACT_POLL_END'				=> 'Activar final de votação',
+	'AP_ACT_POLL_END_EXPLAIN'		=> 'Permite especificar quando termina uma votação em determinado dia e hora, caso se especifique uma duração a partir do início da votação.',
+	'AP_ACT_POLL_NOTIFICATIONS'				=> 'Activar notificações de votações',
+	'AP_ACT_POLL_NOTIFICATIONS_EXPLAIN'		=> 'Activa o envio de notificações a todos os votantes em votações ocultas quando a votação finalizar, e aí os resultados serão visíveis.',
+
+	'AP_DEFAULT_VOTES_CHANGE'		=> 'Valor por defeito para alterar o voto',
+	'AP_DEFAULT_VOTES_HIDE'			=> 'Valor por defeito para votos ocultos',
+	'AP_DEFAULT_VOTERS_SHOW'		=> 'Valor por defeito para mostrar votantes',
+	'AP_DEFAULT_VOTERS_LIMIT'		=> 'Valor por defeito para limitar votos',
+	'AP_DEFAULT_SHOW_ORDERED'		=> 'Valor por defeito para ordenação',
+));
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php" "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
similarity index 57%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/language/pl/permissions_advancedpolls.php"
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/language/pt_preao/permissions_advancedpolls.php"
@@ -1,11 +1,12 @@
 <?php
 /**
  *
- * Advanced Polls [Polish]
- * Polish translation by Lech-u (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1616616)*
+ * Advanced Polls [Spanish]
+ *
  * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
  * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
  * @author Clemens Husung (Wolfsblvt)
+ * @author Translation by Raul [ThE KuKa] (https://github.com/phpbb-es)
  */
 
 if (!defined('IN_PHPBB'))
@@ -43,6 +44,6 @@ if (empty($lang) || !is_array($lang))
 
 // User Permissions
 $lang = array_merge($lang, array(
-	'ACL_F_SEEVOTERS'			=> 'Możesz zobaczyć głosujących.',
-	'ACL_M_SEEVOTERS'			=> 'Możesz wyświetlać głosujących w ankiecie.',
+	'ACL_F_SEEVOTERS'			=> 'Pode ver os votantes da votação',
+	'ACL_M_SEEVOTERS'			=> 'Pode ver os votantes da votação',
 ));
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/.DS_Store" differ
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,5 @@
+<!-- IF AP_JSON_DATA -->
+	<script>
+		{AP_JSON_DATA}
+	</script>
+<!-- ENDIF -->
\ No newline at end of file
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
@@ -0,0 +1,27 @@
+<!-- IF S_DISPLAY_PREVIEW and WOLFSBLVT_POLL_SCORING -->
+<!-- IF not $INCLUDED_JXTOOLSJS -->
+    <!-- INCLUDEJS lib/jxtools.js -->
+	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
+<!-- ENDIF -->
+<div id="ap_poll_preview_hidden_container" style="display:none;" jxdom-target="#preview fieldset.polls" jxdom-action="replace">
+	<fieldset>
+		<div class="panel panel-default panel-poll">
+			<div class="panel-heading">
+				<!-- BEGIN poll_option -->
+					<div class="pull-left">
+						<label for="vote_{poll_option.POLL_OPTION_ID}">{poll_option.POLL_OPTION_CAPTION}</label>
+						<div class="poll_option_select pull-left">
+							
+							<!-- IF AP_IS_SCORING -->
+								<select name="vote_id[{poll_option.POLL_OPTION_ID}]" id="vote_{poll_option.POLL_OPTION_ID}">{poll_option.AP_POLL_OPTION_OPTS}</select>
+							<!-- ELSE -->
+								<input type="<!-- IF S_IS_MULTI_CHOICE -->checkbox<!-- ELSE -->radio<!-- ENDIF -->" name="vote_id[]" id="vote_{poll_option.POLL_OPTION_ID}" value="{poll_option.POLL_OPTION_ID}" />
+							<!-- ENDIF -->
+						</div>
+					</div>
+				<!-- END poll_option -->
+			</div>
+		</div>
+	</fieldset>
+</div>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/posting_poll_body_options_after.html"
@@ -0,0 +1,115 @@
+<!-- IF S_SHOW_POLL_BOX -->
+<!-- IF WOLFSBLVT_POLL_END or WOLFSBLVT_POLL_SCORING -->
+<!-- IF not $INCLUDED_JXTOOLSJS -->
+    <!-- INCLUDEJS lib/jxtools.js -->
+	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
+<!-- ENDIF -->
+<!-- ENDIF -->
+
+<!-- IF WOLFSBLVT_POLL_END -->
+<!-- INCLUDEJS js/poll_length_posting.js -->
+<div id="ap_poll_length_container" style="display:none;" jxdom-target="label > #poll_length" jxdom-closest="div" jxdom-action="replace">
+	<!-- Replace the div ancestor of a #poll_length element directly under a label with the contents of this element -->
+	<div class="control-group">
+		<label for="wolfsblvt_poll_duration">{L_AP_RUN_POLL}{L_COLON}</label>
+		<div class="controls controls-row">
+			<select name="wolfsblvt_poll_duration" id="wolfsblvt_poll_duration" onchange="apChangeDuration(this.value);">
+				<option value="" selected="selected">{L_AP_RUN_POLL_INDEFINITELY}</option>
+				<option value="wolfsblvt_poll_length">{L_AP_RUN_POLL_FOR}</option>
+				<option value="wolfsblvt_poll_end">{L_AP_RUN_POLL_UNTIL}</option>
+			</select>
+			<span id="wolfsblvt_poll_length" style="display: none; margin: 0px 10px;">
+				<input style="width: 4em !important;" id="poll_length" name="poll_length" size="3" maxlength="3" min="0" max="999" value="{POLL_LENGTH}" class="inputbox autowidth" type="number" onchange="apAdjustLength(this.value);">
+				<select name="wolfsblvt_poll_length_scale" onchange="apAdjustLengthScale(this.value);">
+					<option value="1">{L_HOURS}</option>
+					<option value="24" selected="selected">{L_DAYS}</option>
+				</select>
+				&nbsp;
+				<strong id="wolfsblvt_poll_end_label"></strong>
+			</span>
+			<span id="wolfsblvt_poll_end" style="display: none; margin: 0px 10px;">
+				<input style="width: 5em !important;" size="4" maxlength="4" id="wolfsblvt_poll_end_year" name="wolfsblvt_poll_end_year" value="{WOLFSBLVT_POLL_END_YEAR}" type="number" onchange="apAdjustEnd('year',this.value);">
+				<input style="width: 3em !important;" size="2" maxlength="2" min="1" max="12" id="wolfsblvt_poll_end_mon" name="wolfsblvt_poll_end_mon" value="{WOLFSBLVT_POLL_END_MON}" type="number" onchange="apAdjustEnd('mon',this.value);">
+				<input style="width: 3em !important;" size="2" maxlength="2" min="1" max="31" id="wolfsblvt_poll_end_mday" name="wolfsblvt_poll_end_mday" value="{WOLFSBLVT_POLL_END_MDAY}" type="number" onchange="apAdjustEnd('mday',this.value);">
+				&nbsp;
+				<input style="width: 3em !important;" size="2" maxlength="2" min="0" max="23" id="wolfsblvt_poll_end_hours" name="wolfsblvt_poll_end_hours" value="{WOLFSBLVT_POLL_END_HOURS}" type="number" onchange="apAdjustEnd('hours',this.value);">
+				<input style="width: 3em !important;" size="2" maxlength="2" min="0" max="59" id="wolfsblvt_poll_end_minutes" name="wolfsblvt_poll_end_minutes" value="{WOLFSBLVT_POLL_END_MINUTES}" type="number" onchange="apAdjustEnd('minutes',this.value);">
+				&nbsp;
+				{L_AP_YYYY_MM_DD} {L_AP_HH_MM}
+			</span>
+		</div>
+	</div>
+	<hr class="dashed" />
+</div>
+<!-- ENDIF -->
+
+<!-- IF WOLFSBLVT_POLL_SCORING -->
+<span style="display:none;" jxdom-target="#poll_max_options" jxdom-closest=".col-md-4" jxdom-action="remove">
+<!-- Remove the #poll_max_options div ancestor, to be replaced by the following div block (in a different position in the DOM, closer to other similar options) -->
+</span>
+<div class="control-group">
+	<label class="control-label" for="poll_max_options">{L_POLL_MAX_OPTIONS}{L_COLON}</label><span class="help-block">{L_POLL_MAX_OPTIONS_EXPLAIN}</span>
+	<div class="input-group col-xs-8 col-sm-2 col-md-2">
+		<input type="number" min="0" max="999" name="poll_max_options" id="wolfsblvt_poll_max_options" size="3" maxlength="3" value="{POLL_MAX_OPTIONS}" class="form-control input-sm">
+	</div>
+</div>
+<div class="control-group">
+	<label class="control-label" for="wolfsblvt_poll_max_value">{L_AP_POLL_MAX_VALUE}{L_COLON}</label><span class="help-block">{L_AP_POLL_MAX_VALUE_EXPLAIN}</span>
+	<div class="input-group col-xs-8 col-sm-2 col-md-2">
+		<input type="number" min="0" max="999" name="wolfsblvt_poll_max_value" id="wolfsblvt_poll_max_value" size="3" maxlength="3" value="{WOLFSBLVT_POLL_MAX_VALUE}" class="form-control input-sm">
+	</div>
+</div>
+<div class="control-group">
+	<label class="control-label" for="wolfsblvt_poll_total_value">{L_AP_POLL_TOTAL_VALUE}{L_COLON}</label><span class="help-block">{L_AP_POLL_TOTAL_VALUE_EXPLAIN}</span>
+	<div class="input-group col-xs-8 col-sm-2 col-md-2">
+		<input type="number" min="0" max="999" name="wolfsblvt_poll_total_value" id="wolfsblvt_poll_total_value" size="3" maxlength="3" value="{WOLFSBLVT_POLL_TOTAL_VALUE}" class="form-control input-sm">
+	</div>
+</div>
+<!-- ENDIF -->
+
+<!-- IF not WOLFSBLVT_POLL_END and not WOLFSBLVT_POLL_SCORING -->
+	<hr class="dashed" />
+<!-- ENDIF -->
+
+<!-- IF S_AP_POLL_VOTE_CHANGE -->
+<div class="control-group">
+	<label class="control-label" for="poll_vote_change">{L_POLL_VOTE_CHANGE}{L_COLON}</label>
+	<div class="controls controls-row"> 
+		<input type="checkbox" id="poll_vote_change" name="poll_vote_change"{VOTE_CHANGE_CHECKED} /> {L_POLL_VOTE_CHANGE_EXPLAIN}
+	</div>
+</div>
+<!-- ENDIF -->
+
+<!-- IF WOLFSBLVT_POLL_VOTES_HIDE -->
+<div class="control-group">
+	<label class="control-label" for="wolfsblvt_poll_votes_hide">{L_AP_POLL_VOTES_HIDE}{L_COLON}</label>
+	<div class="controls controls-row"> 
+		<input type="checkbox" id="wolfsblvt_poll_votes_hide" name="wolfsblvt_poll_votes_hide"{WOLFSBLVT_POLL_VOTES_HIDE_CHECKED} /> {L_AP_POLL_VOTES_HIDE_EXPLAIN}
+	</div>
+</div>
+<!-- ENDIF -->
+<!-- IF WOLFSBLVT_POLL_VOTERS_LIMIT -->
+<div class="control-group">
+	<label class="control-label" for="wolfsblvt_poll_voters_limit">{L_AP_POLL_VOTERS_LIMIT}{L_COLON}</label>
+	<div class="controls controls-row"> 
+		<input type="checkbox" id="wolfsblvt_poll_voters_limit" name="wolfsblvt_poll_voters_limit"{WOLFSBLVT_POLL_VOTERS_LIMIT_CHECKED} /> {L_AP_POLL_VOTERS_LIMIT_EXPLAIN}
+	</div>
+</div>
+<!-- ENDIF -->
+<!-- IF WOLFSBLVT_POLL_VOTERS_SHOW -->
+<div class="control-group">
+	<label class="control-label" for="wolfsblvt_poll_voters_show">{L_AP_POLL_VOTERS_SHOW}{L_COLON}</label>
+	<div class="controls controls-row"> 
+		<input type="checkbox" id="wolfsblvt_poll_voters_show" name="wolfsblvt_poll_voters_show"{WOLFSBLVT_POLL_VOTERS_SHOW_CHECKED} /> {L_AP_POLL_VOTERS_SHOW_EXPLAIN}
+	</div>
+</div>
+<!-- ENDIF -->
+<!-- IF WOLFSBLVT_POLL_SHOW_ORDERED -->
+<div class="control-group">
+	<label class="control-label" for="wolfsblvt_poll_show_ordered">{L_AP_POLL_SHOW_ORDERED}{L_COLON}</label>
+	<div class="controls controls-row"> 
+		<input type="checkbox" id="wolfsblvt_poll_show_ordered" name="wolfsblvt_poll_show_ordered"{WOLFSBLVT_POLL_SHOW_ORDERED_CHECKED} /> {L_AP_POLL_SHOW_ORDERED_EXPLAIN}
+	</div>
+</div>
+<!-- ENDIF -->
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_body_poll_option_after.html"
@@ -0,0 +1,30 @@
+<!-- IF not $INCLUDED_WOLFSBLVTADVANCEDPOLLSJS -->
+	<!-- INCLUDEJS js/functions.js -->
+	<!-- INCLUDEJS js/onload.js -->
+    <!-- DEFINE $INCLUDED_WOLFSBLVTADVANCEDPOLLSJS = true -->
+<!-- ENDIF -->
+<!-- IF WOLFSBLVT_POLL_SCORING -->
+<!-- IF not $INCLUDED_JXTOOLSJS -->
+    <!-- INCLUDEJS lib/jxtools.js -->
+	<!-- DEFINE $INCLUDED_JXTOOLSJS = true -->
+<!-- ENDIF -->
+<!-- ENDIF -->
+
+<!-- IF AP_POLL_SHOW_VOTERS -->
+	<div class="poll_voters_box poll_total_votes<!-- IF not S_DISPLAY_RESULTS --> hidden<!-- ENDIF -->">
+		<div class="resultbar">{L_AP_VOTERS}{poll_option.AP_VOTERS}{L_COLON} <span class="poll_voters"><!-- IF poll_option.AP_VOTER_LIST -->{poll_option.AP_VOTER_LIST}<!-- ELSE --><span name="none">{L_AP_NONE}</span><!-- ENDIF --></span></div>
+		<div class="space10"></div>
+	</div>
+<!-- ENDIF -->
+<!-- IF WOLFSBLVT_POLL_SCORING -->
+	<span class="hidden" jxdom-target="[data-poll-option-id={poll_option.POLL_OPTION_ID}]" jxdom-find="div.poll_option_select" jxdom-action="remove"></span>
+	<div class="hidden" jxdom-target="[data-poll-option-id={poll_option.POLL_OPTION_ID}]" jxdom-find="> :first-child" jxdom-action="before">
+		<div class="poll_option_select pull-left">
+		<!-- IF AP_IS_SCORING -->
+			<select name="vote_id[{poll_option.POLL_OPTION_ID}]" id="vote_{poll_option.POLL_OPTION_ID}"<!-- IF not S_CAN_VOTE --> disabled="disabled"<!-- ENDIF -->>{poll_option.AP_POLL_OPTION_OPTS}</select>
+		<!-- ELSE -->
+			<input type="<!-- IF S_IS_MULTI_CHOICE -->checkbox<!-- ELSE -->radio<!-- ENDIF -->" name="vote_id[]" id="vote_{poll_option.POLL_OPTION_ID}" value="{poll_option.POLL_OPTION_ID}"<!-- IF poll_option.POLL_OPTION_VOTED --> checked="checked"<!-- ENDIF --><!-- IF not S_CAN_VOTE --> disabled="disabled"<!-- ENDIF --> />
+		<!-- ENDIF -->
+		</div>
+	</div>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/event/viewtopic_topic_tools_before.html"
@@ -0,0 +1,5 @@
+<!-- IF U_AP_POLL_INFO -->
+<div class="btn-group hidden-xs">
+	<a href="{U_AP_POLL_INFO}" title="{L_INFORMATION}" class="btn btn-success"><i class="fa fa-info"></i></a>
+</div>
+<!-- ENDIF -->
\ No newline at end of file
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/functions.js"
@@ -0,0 +1,176 @@
+/**
+ *
+ * Advanced Polls
+ *
+ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Clemens Husung (Wolfsblvt)
+ */
+
+// namespacing
+head.ready(function(){
+$.wolfsblvt = $.extend({}, $.wolfsblvt, {
+
+	/// <field name="cookie_advancedsearchbox_name" type="string">The Cookie Name for advanced searchbox pin setting.</field>
+	advancedpoll_json_data: wolfsblvt_ap_json_data,
+
+	override_callback_advancedpolls_vote_poll_hidden: function (res) {
+		/// <summary>
+		///		Overrides the ajax callback function for poll votes
+		/// </summary>
+		/// <param name="res" type="object">(object) The results of the poll.</param>
+
+		if (typeof res.success !== 'undefined') {
+			var poll = $('.topic_poll');
+			var panel = poll.find('.panel');
+			var resultsVisible = poll.find('dl:first-child .resultbar').is(':visible');
+
+			// Define functions we need inside of that function here
+			var updatePanelHeight = function (height) {
+				height = (typeof height === 'undefined') ? panel.find('.inner').outerHeight() : height;
+				panel.css('min-height', height);
+			};
+			var resizePanel = function (time) {
+				var panelHeight = panel.height();
+				var innerHeight = panel.find('.inner').outerHeight();
+
+				if (panelHeight !== innerHeight) {
+					panel.css({ 'min-height': '', 'height': panelHeight })
+						.animate({ height: innerHeight }, time, function () {
+							panel.css({ 'min-height': innerHeight, 'height': '' });
+						});
+				}
+			};
+
+			// Set min-height to prevent the page from jumping when the content changes
+			updatePanelHeight();
+
+			// Remove the View results link
+			if (!resultsVisible) {
+				poll.find('.poll_view_results').hide(500);
+			}
+
+			if (!res.can_vote) {
+				poll.find('.polls, .poll_max_votes, .poll_vote, .poll_option_select').fadeOut(500, function () {
+					poll.find('.resultbar, .poll_option_percent, .poll_total_votes').show();
+				});
+			} else {
+				// If the user can still vote, simply slide down the results
+				poll.find('.resultbar, .poll_option_percent, .poll_total_votes').show(500);
+			}
+
+			// Get the votes count of the highest poll option
+			// no
+
+			// Update the total votes count
+			poll.find('.poll_total_vote_cnt').html("??");
+
+			// Update each option
+			poll.find('[data-poll-option-id]').each(function () {
+				var $this = $(this);
+				var optionId = $this.attr('data-poll-option-id');
+				var voted = (typeof res.user_votes[optionId] !== 'undefined');
+				var altText;
+
+				altText = $this.attr('data-alt-text');
+				if (voted) {
+					$this.attr('title', $.trim(altText));
+				} else {
+					$this.attr('title', '');
+				};
+
+				$this.toggleClass('voted', voted);
+			});
+
+			if (!res.can_vote) {
+				poll.find('.polls').delay(400).fadeIn(500);
+			}
+
+			// Display "Your vote has been cast." message. Disappears after 5 seconds.
+			var confirmationDelay = (res.can_vote) ? 300 : 900;
+			poll.find('.vote-submitted').delay(confirmationDelay).slideDown(200, function () {
+				if (resultsVisible) {
+					updatePanelHeight();
+				}
+
+				$(this).delay(5000).fadeOut(500, function () {
+					resizePanel(300);
+				});
+			});
+
+			// Remove the gap resulting from removing options
+			setTimeout(function () {
+				resizePanel(500);
+			}, 1500);
+		}
+	},
+	extend_callback_advancedpolls_vote_poll_show_voters: function (res) {
+		/// <summary>
+		///		Extends the ajax callback function to show poll voters
+		/// </summary>
+		/// <param name="res" type="object">(object) The results of the poll.</param>
+
+		if (typeof res.success !== 'undefined') {
+			var poll = $('.topic_poll');
+			var scoring = (typeof res.scoring !== 'undefined');
+			var spanname = 'name="' + $.wolfsblvt.advancedpoll_json_data.username_clean + '"';
+			var spanval_begin = "<span " + spanname + ">" + $.wolfsblvt.advancedpoll_json_data.username_string;
+			var spanval_end = "</span>";
+
+			console.log("running the extended callback code");
+
+			// Update each option
+			poll.find('[data-poll-option-id]').each(function () {
+				var $this = $(this);
+				var $votersbox_voters = $this.next(".poll_voters_box").find(".poll_voters");
+				var optionId = $this.attr('data-poll-option-id');
+				var voted = (typeof res.user_votes[optionId] !== 'undefined');
+				var spanval = spanval_begin + ((scoring) ? "(" + res.user_vote_counts[optionId] + ")" : "") + spanval_end;
+
+				var $voter_user = $votersbox_voters.children("span[" + spanname + "]");
+
+				if (voted) {
+					if ($voter_user.length === 0) {
+						if (res.vote_counts[optionId] > ((scoring) ? res.user_vote_counts[optionId] : 1)) {
+							// If there are more voters than just the current user, add seperator after last element
+							$votersbox_voters.children(":last-child").after($.wolfsblvt.advancedpoll_json_data.l_seperator);
+						}
+						else {
+							// Remove the "No voters" notice
+							$votersbox_voters.children('span[name="none"]').hide(500, function () { $(this).remove(); });
+						}
+						$(spanval).hide().appendTo($votersbox_voters).show(500);
+					}
+					else {
+						if (scoring) {
+							$(spanval).hide().replaceAll($voter_user).show(500);
+						}
+					}
+				}
+				else {
+					if ($voter_user.length > 0) {
+						var callback = function () {
+							if (res.vote_counts[optionId] > 0) {
+								if (this.nextSibling !== null) {
+									this.nextSibling.remove();
+								}
+								else {
+									if (this.previousSibling !== null) {
+										this.previousSibling.remove();
+									}
+								}
+							}
+							else {
+								var $none_voter = $('<span name="none">' + $.wolfsblvt.advancedpoll_json_data.l_none + "</span>").hide();
+								$none_voter.appendTo($votersbox_voters).show(500);
+							}
+							$(this).remove();
+						};
+						$voter_user.hide(500, callback);
+					}
+				}
+			});
+		}
+	},
+});
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/onload.js"
@@ -0,0 +1,44 @@
+/**
+ *
+ * Advanced Polls
+ *
+ * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Clemens Husung (Wolfsblvt)
+ */
+
+head.ready(function(){
+$(document).ready(function () {
+	// replace the ajax callback for poll votes if votes are hidden
+	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
+		phpbb.addAjaxCallback('vote_poll', $.wolfsblvt.override_callback_advancedpolls_vote_poll_hidden);
+	}
+
+	// extend the ajax callback for poll votes if voters should be shown
+	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_voters_show_topic && !$.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_votes_hide_topic) {
+		var old_function = phpbb.ajaxCallbacks['vote_poll'];
+		//phpbb.addAjaxCallback('vote_poll', function (res) { old_function(res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
+		phpbb.addAjaxCallback('vote_poll', function (res) { old_function.call(this, res); $.wolfsblvt.extend_callback_advancedpolls_vote_poll_show_voters(res); });
+	}
+
+	// Modify the "view results" link to set the "don't want to vote"
+	if ($.wolfsblvt.advancedpoll_json_data.wolfsblvt_poll_no_vote) {
+		$('.poll_view_results a').click(function () {
+			var $poll = $(this).parents('.topic_poll');
+
+			if (!$.wolfsblvt.advancedpoll_json_data.can_change_vote) {
+				// Remove vote possibilitys
+				$poll.find('.poll_max_votes, .poll_vote, .poll_option_select').hide(500);
+			}
+
+			// Set it in the database
+			$.ajax({
+				url:	location.href,
+				data: {
+					no_vote:	true,
+				},
+			});
+		});
+	}
+});
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_posting.js"
@@ -0,0 +1,102 @@
+/**
+ *
+ * Advanced Polls - Poll Length Posting aids
+ *
+ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Javier Lopez (javiexin)
+ */
+
+var apPollStartInitial = new Date();
+var apPollStart  = new Date();
+var apPollEnd    = new Date();
+var apPollLength = 0; // seconds
+var apPollLengthScale = 24; // days by default
+
+apInitPollLength();
+
+function apInitPollLength()
+{
+	var year = document.getElementById('wolfsblvt_poll_end_year').value;
+	if (year != "") apPollEnd.setFullYear(year);
+	var mon = document.getElementById('wolfsblvt_poll_end_mon').value;
+	if (mon != "") apPollEnd.setMonth(mon - 1);
+	var mday = document.getElementById('wolfsblvt_poll_end_mday').value;
+	if (mday != "") apPollEnd.setDate(mday);
+	var hours = document.getElementById('wolfsblvt_poll_end_hours').value;
+	if (hours != "") apPollEnd.setHours(hours);
+	var minutes = document.getElementById('wolfsblvt_poll_end_minutes').value;
+	if (minutes != "") apPollEnd.setMinutes(minutes);
+
+	var length = document.getElementById('poll_length').value;
+	if (length > 0) apPollLength = length * apPollLengthScale * 3600;
+
+	apPollStart.setTime(apPollEnd.getTime() - apPollLength * 1000);
+	apPollStartInitial = apPollStart;
+
+	var duration = (length > 0) ? 1 : 0;
+	document.getElementById('wolfsblvt_poll_duration').selectedIndex = duration;
+	apChangeDuration(document.getElementById('wolfsblvt_poll_duration').value);
+}
+
+function apChangeDuration(val)
+{
+	apUpdatePollEnd(val != '');
+	document.getElementById('wolfsblvt_poll_length').style.display='none';
+	document.getElementById('wolfsblvt_poll_end').style.display='none';
+	if (val != '') document.getElementById(val).style.display='inline-block';
+}
+
+function apAdjustLengthScale(newScale)
+{
+	apPollLengthScale = newScale;
+	apUpdatePollEnd(true);
+}
+
+function apAdjustLength(val)
+{
+	apPollLength = val * apPollLengthScale * 3600;
+	apPollEnd.setTime(apPollStart.getTime() + apPollLength * 1000);
+	apUpdatePollEnd(true);
+}
+
+function apAdjustEnd(what, val)
+{
+	if (what == "year")	{
+		apPollEnd.setFullYear(val);
+	} else if (what == "mon") {
+		apPollEnd.setMonth(val - 1);
+	} else if (what == "mday") {
+		apPollEnd.setDate(val);
+	} else if (what == "hours") {
+		apPollEnd.setHours(val);
+	} else if (what == "minutes") {
+		apPollEnd.setMinutes(val);
+	}
+	apUpdatePollEnd(true);
+}
+
+function apUpdatePollEnd(fill)
+{
+	var pollLengthValue =  Math.ceil((apPollEnd.getTime() - apPollStartInitial.getTime()) / 1000 / 3600 / apPollLengthScale);
+	apPollLength = pollLengthValue * apPollLengthScale * 3600;
+	apPollStart.setTime(apPollEnd.getTime() - apPollLength * 1000);
+
+	if (fill) {
+		document.getElementById('wolfsblvt_poll_end_label').innerHTML = apPollEnd.getFullYear() + "/" + (apPollEnd.getMonth() + 1) + "/" + apPollEnd.getDate() + "&nbsp;" + apPollEnd.getHours() + ":" + apPollEnd.getMinutes();
+		document.getElementById('wolfsblvt_poll_end_year').value = apPollEnd.getFullYear();
+		document.getElementById('wolfsblvt_poll_end_mon').value = apPollEnd.getMonth() + 1;
+		document.getElementById('wolfsblvt_poll_end_mday').value = apPollEnd.getDate();
+		document.getElementById('wolfsblvt_poll_end_hours').value = apPollEnd.getHours();
+		document.getElementById('wolfsblvt_poll_end_minutes').value = apPollEnd.getMinutes();
+		document.getElementById('poll_length').value = pollLengthValue;
+	} else {
+		document.getElementById('wolfsblvt_poll_end_label').innerHTML = "";
+		document.getElementById('wolfsblvt_poll_end_year').value = "";
+		document.getElementById('wolfsblvt_poll_end_mon').value = "";
+		document.getElementById('wolfsblvt_poll_end_mday').value = "";
+		document.getElementById('wolfsblvt_poll_end_hours').value = "";
+		document.getElementById('wolfsblvt_poll_end_minutes').value = "";
+		document.getElementById('poll_length').value = 0;
+	}
+}
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/poll_length_reposition.js"
@@ -0,0 +1,18 @@
+/**
+ *
+ * Advanced Polls - Poll Length Reposition
+ *
+ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Javier Lopez (javiexin)
+ */
+
+$(document).ready(function () {
+	var $pollLengthDl = $('label > #poll_length').closest('div');
+	var $container = $("#ap_poll_length_container");
+	var $content = $container.contents();
+
+	$pollLengthDl.prev('div').remove();
+	$pollLengthDl.replaceWith($content);
+	$container.remove();
+});
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_preview.js"
@@ -0,0 +1,18 @@
+/**
+ *
+ * Advanced Polls - Scoring Polls
+ *
+ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Javier Lopez (javiexin)
+ */
+
+$(document).ready(function () {
+	var $poll = $('#preview fieldset.polls');
+	var $container = $("#ap_poll_preview_hidden_container");
+	var $content = $container.contents();
+
+	$poll.children().remove();
+	$poll.append($content);
+	$container.remove();
+});
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/js/scoring_topic.js"
@@ -0,0 +1,21 @@
+/**
+ *
+ * Advanced Polls - Scoring Polls
+ *
+ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Javier Lopez (javiexin)
+ */
+
+$(document).ready(function () {
+	var $poll = $('.topic_poll');
+
+	$poll.find('[data-poll-option-id]').each(function () {
+		var $this = $(this);
+		var optionId = $this.attr('data-poll-option-id');
+		var $container = $poll.find('#poll_option_hidden_container_' + optionId);
+		$this.find('div.poll_option_select').remove();
+		$this.children(':first-child').after($container.contents());
+		$container.remove();
+	});
+});
diff --git "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/lib/jxtools.js" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/lib/jxtools.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/FLATBOOTS/template/lib/jxtools.js"
@@ -0,0 +1,68 @@
+/*
+ * JxTools - JavaScript utility library
+ *
+ * @copyright (c) 2015 javiexin ( www.exincastillos.es )
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ * @author Javier Lopez (javiexin)
+ */
+head.ready(function(){
+
+var jxtools = {};
+
+(function($) { // Avoid conflicts with other libraries
+
+'use strict';
+
+/*
+ * JxTools - Perform actions on the DOM
+ *
+ * If the JxDom set of attributes is present in a DOM element, it is processed by this function, in the following order
+ * [jxdom-target]  Attribute that specifies (with a DOM selector) the DOM object that is the initial target of this operation; optional, defaults to $(this)
+ * [jxdom-closest] DOM selector to apply to the target, to find the appropriate ancestor (starting with $(this)), that becomes the new target; optional
+ * [jxdom-find]    DOM selector to apply to the current target, to find the appropriate descendant, that becomes the new target; optional
+ * [jxdom-action]  Action to perform on the final target, using the contents of $(this) as parameter (if appropriate); mandatory
+ *                 Actions may be: remove|replace|before|after|prepend|append
+ * Each step should yield a single element as result, otherwise, the results are undefined
+ * When these operations are completed, this object is discarded (removed from the DOM)
+ */
+$('[jxdom-action]').each(function() {
+	var $this = $(this);
+	var $contents = $this.contents();
+	var domTarget = $this.attr('jxdom-target'),
+		domClosest = $this.attr('jxdom-closest'),
+		domFind = $this.attr('jxdom-find'),
+		domAction = $this.attr('jxdom-action');
+	var $target;
+
+	$target = (domTarget !== undefined) ? $(domTarget) : $this;
+	$target = (domClosest !== undefined) ? $target.closest(domClosest) : $target;
+	$target = (domFind !== undefined) ? $target.find(domFind) : $target;
+
+	switch (domAction) {
+		case 'replace':
+			$target.replaceWith($contents);
+			break;
+		case 'remove':
+			$target.remove();
+			break;
+		case 'before':
+			$target.before($contents);
+			break;
+		case 'after':
+			$target.after($contents);
+			break;
+		case 'append':
+			$target.append($contents);
+			break;
+		case 'prepend':
+			$target.prepend($contents);
+			break;
+		default:
+			break;
+	}
+	$this.remove();
+});
+
+})(jQuery); // Avoid conflicts with other libraries
+
+});
\ No newline at end of file
diff --git "[ORIGINAL]/wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html" "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/wolfsblvt\\advancedpolls/styles/prosilver/template/event/overall_header_head_append.html"
@@ -1,5 +1,5 @@
 <!-- IF S_VIEWTOPIC or S_IN_POSTING -->
-	<!-- INCLUDECSS @wolfsblvt_advancedpolls/advancedpolls.css -->
+	<!-- INCLUDECSS advancedpolls.css -->
 <!-- ENDIF -->
 
 <!-- IF AP_JSON_DATA -->
```
