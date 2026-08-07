<?php
/**
 *
 * Advanced Polls [Japanese]
 * Japanese translation by tk6904 (https://www.phpbb.com/community/memberlist.php?mode=viewprofile&u=1658156)*
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ADVANCEDPOLLS_EXT_NAME'			=> 'Advanced Polls',

// Viewtopic
	'AP_VOTES_HIDDEN'				=> '結果は表示されません',
	'AP_POLL_RUN_TILL_APPEND'			=> '。終了まで投票結果は非表示となります。',
	'AP_VOTERS'					=> '投票者',
	'AP_NONE'					=> 'なし',
	'AP_DELETED_USER'			=> '削除されたユーザー',

	'AP_POLL_CANT_VOTE'				=> 'この投票には参加できません。理由：',
	'AP_POLL_REASON_NOT_POSTED'			=> 'まだこのトピックで投稿を行っていません。',
	'AP_POLL_VOTES_ARE_VISIBLE'			=> '投票後にあなたの投票が見えるようになります。',
	'AP_POLL_DONT_VOTE_SHOW_RESULTS'		=> '投票せずに結果を表示する',
	'AP_POLL_RESULTS_ARE_ORDERED'			=> '投票結果は得票数の多い順に並びます',
	'AP_POLL_TYPE_MISMATCH'				=> '一貫性のない投票データのため内部エラーが発生しました',
	'AP_VOTE_CHANGED'				=> '投票内容を変更する権限がありません。',
	'AP_TOO_MANY_VOTES'				=> '投票オプション数が多すぎます。',
	'AP_ABSTAINERS' => '投票しないことを選択',
	'AP_DELETE_VOTE' => '自分の投票を削除',

	'AP_MAX_VOTES_SELECT'					=> [
		1	=> '<strong>%1$d</strong> オプションに最大 <strong>%2$d</strong> 票を投じることができます',
		2	=> '<strong>%1$d</strong> オプションの中から最大 <strong>%2$d</strong> 票を投じることができます',
	],
	'AP_GUEST_VOTES'						=> [
		1	=> 'ゲスト票：%d 票', // %d vote from guest
		2	=> 'ゲスト票：%d 票', // %d votes from guests
	],
	'AP_SCORE_TOTAL' => [
		1 => '%d 票',
		2 => '%d 票',
	],
	'AP_SCORE_BREAKDOWN' => '得点別の投票内訳',
	'AP_SCORE_DISTRIBUTION_ENTRY' => [
		1 => '%2$d 点：%1$d 票',
		2 => '%2$d 点：%1$d 票',
	],
	'AP_RANK_TOTAL' => [1 => '%d 点', 2 => '%d 点'],
	'AP_RANK_BREAKDOWN' => '順位の内訳',
	'AP_RANK_DISTRIBUTION_ENTRY' => [1 => '%2$d 位が %1$d 票', 2 => '%2$d 位が %1$d 票'],
	'AP_RANK_SELECT_EXACTLY' => [
		1 => '希望順に正確に %d 個の選択肢を選んでください。',
		2 => '希望順に正確に %d 個の選択肢を選んでください。',
	],
// Posting
	'AP_POLL_TYPE' => 'アンケート形式',
	'AP_POLL_TYPE_EXPLAIN' => 'ユーザーが票または点数を割り当てる方法を選択します。',
	'AP_POLL_TYPE_CHOICE' => '選択',
	'AP_POLL_TYPE_SCORING' => '数値評価',
	'AP_POLL_TYPE_RANKING' => '順位付け',
	'AP_POLL_VISIBILITY' => '結果の表示タイミング',
	'AP_POLL_VISIBILITY_EXPLAIN' => '投票結果の集計をいつ表示するか選択します。',
	'AP_VISIBILITY_PUBLIC' => '公開 — 常に結果を表示',
	'AP_VISIBILITY_DEFAULT' => '最初の投票後',
	'AP_VISIBILITY_VOTE_COMPLETED' => '利用可能な票をすべて使用した後',
	'AP_VISIBILITY_PRIVATE' => '非公開 — 投票終了後のみ表示',
	'AP_POLL_VOTE_MODE' => '投票の変更',
	'AP_POLL_VOTE_MODE_EXPLAIN' => '投票を確定とするか、段階的に送信できるか、投票受付中に変更できるかを選択します。',
	'AP_VOTE_MODE_NO_CHANGE' => '変更不可',
	'AP_VOTE_MODE_INCREMENTAL' => '段階的な投票',
	'AP_VOTE_MODE_CHANGE' => '変更を許可',
	'AP_POLL_VOTES_HIDE'				=> '投票結果を非表示にする',
	'AP_POLL_VOTES_HIDE_EXPLAIN'			=> 'これを有効にすると、投票結果は投票が終了するまで非表示になります。この項目は特定の期限設定を持つ場合のみ動作します。',
	'AP_POLL_VOTERS_SHOW'				=> '投票者を表示する',
	'AP_POLL_VOTERS_SHOW_EXPLAIN'			=> 'これを有効にすると、閲覧権限を持つユーザーにのみ投票者が表示されます。投票結果を非表示にしている場合は投票者も非表示になります。',
	'AP_POLL_VOTERS_LIMIT'				=> '投票対象者を制限する',
	'AP_POLL_VOTERS_LIMIT_EXPLAIN'			=> 'これを有効にすると、このトピックに記事を投稿した人だけが投票できます',
	'AP_POLL_SHOW_ORDERED'				=> '得票順に表示する',
	'AP_POLL_SHOW_ORDERED_EXPLAIN'			=> '投票結果が表示されるとき、得票数の降順に並びます（得票数の高いもの順）。未選択の場合は投票オプションの順序が使用されます。',
	'AP_POLL_COLLAPSIBLE'					=> '折りたたみ可能な投票',
	'AP_POLL_COLLAPSIBLE_EXPLAIN'			=> 'ユーザーがこの投票を折りたたんだり展開したりできるようにします。',
	'AP_COLLAPSE_POLL'						=> '投票を折りたたむ',
	'AP_EXPAND_POLL'						=> '投票を展開する',
	'AP_RUN_POLL'					=> '投票期間',
	'AP_RUN_POLL_FOR'				=> '日数指定',
	'AP_RUN_POLL_UNTIL'				=> '終了日指定',
	'AP_RUN_POLL_INDEFINITELY'			=> '無期限',
	'AP_POLL_END'					=> '投票終了',
	'AP_POLL_END_EXPLAIN'				=> '投票終了日時を指定してください。これらのフィールドのいずれかが指定されている場合、投票の期間を上書きします。日付フィールドは空のままで、デフォルトは現在の投票終了日です。時間フィールドは空のままで、デフォルトは0です。投票期間を使用するために戻す場合は、これらすべてのフィールドを消去する必要があります。',

	'AP_YYYY_MM_DD'					=> 'YYYY-MM-DD',
	'AP_HH_MM'					=> 'HH:MM',
	'AP_POLL_END_INVALID'				=> '指定した日/時に誤りがあります',
	'AP_POLL_TOTAL_LOWER_MAX_VOTES'			=> '1つのオプションの投票数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',
	'AP_POLL_TOTAL_LOWER_MAX_OPTS'			=> '投票可能なオプション数の上限は、すべてのオプションに分配する合計投票数を超えることはできません',

	'AP_POLL_MAX_VALUE'				=> '最大投票数',
	'AP_POLL_MAX_VALUE_EXPLAIN'			=> '投票者が1つのオプションに付与できる最大投票数です',
	'AP_POLL_TOTAL_VALUE'				=> '投票者数',
	'AP_POLL_TOTAL_VALUE_EXPLAIN'			=> '投票者がすべてのオプションに分配する可能性のある投票の総数です',

	'AP_RANK_POINTS' => '順位ごとの点数',
	'AP_RANK_POINTS_EXPLAIN' => '各順位に正の値を高い順で設定します。順位数はユーザーごとの最大選択肢数で決まります。',
	'AP_RANK_POSITION' => '順位 %d',

	'AP_VOTE_GREATER_THAN_MAXVALUE'			=> '許可されている最大値を超える投票数を割り当てることはできません',
	'AP_POLL_VALUES_INVALID' => '最小点数は最大点数以下でなければなりません。また、最大選択肢数、最大点数、合計点数はゼロより大きい必要があります。',
	'AP_RANK_POSITIONS_INVALID' => '順位数は 1 以上、アンケートの選択肢数以下でなければなりません。',
	'AP_RANK_POINTS_INCOMPLETE' => '各順位の点数を設定してください。',
	'AP_RANK_POINTS_INVALID' => '各順位の点数は 1 から 999 の範囲でなければなりません。',
	'AP_RANK_POINTS_ORDER' => '点数は第1位から最下位まで厳密に減少させる必要があります。',
	'AP_RANK_INCREMENTAL_UNSUPPORTED' => '順位付けでは追加投票を使用できません。',
	'AP_RANK_SELECTION_INCOMPLETE' => '設定された数の選択肢を希望順に正確に選んでください。',
	'AP_QUESTION' => '質問',
	'AP_QUESTION_REQUIRED' => '必須の質問',
	'AP_PRIMARY_QUESTION_REQUIRED_EXPLAIN' => '投票全体を送信する前に、最初の質問への回答を必須にします。',
	'AP_APPEND_OPTIONS' => '投票をリセットせずに選択肢を追加',
	'AP_APPEND_OPTIONS_EXPLAIN' => '既存の投票をすべて保持し、質問の選択肢一覧の末尾に新しい選択肢だけを追加します。',
	'AP_APPEND_OPTIONS_WARNING' => '既存の質問や選択肢の名前変更、削除、並べ替えはできません。投票の変更を許可する必要があります。対象となる以前の登録投票者には、ACP設定と各自の通知設定に従って通知されます。',
	'AP_APPEND_INVALID' => 'この投票には安全に選択肢を追加できません。',
	'AP_APPEND_REQUIRES_CHANGES' => '既存の投票をリセットせずに選択肢を追加するには、投票の変更を許可してください。',
	'AP_APPEND_POLL_ENDED' => '投票終了後は、投票をリセットせずに選択肢を追加できません。',
	'AP_APPEND_STRUCTURE_CHANGED' => '既存の質問または選択肢が変更されました。元の定義に戻し、新しい選択肢は末尾にだけ追加してください。',
	'AP_APPEND_TOO_MANY' => '追加した選択肢が、設定されている投票選択肢の上限を超えています。',
	'AP_APPEND_NONE' => '新しい投票選択肢は追加されていません。',
	'AP_ADDITIONAL_QUESTIONS' => '追加の質問ページ',
	'AP_ADDITIONAL_QUESTIONS_EXPLAIN' => '各ページでは、投票形式、制限、ポイント、結果の公開範囲、投票変更について同じルールを使用します。選択肢は1行に1つ入力してください。',
	'AP_ADD_QUESTION' => '質問を追加',
	'AP_MULTI_INVALID' => '追加質問のデータが無効です。',
	'AP_MULTI_TOO_MANY' => '投票に追加できる質問は最大20件です。',
	'AP_MULTI_CONTENT_INVALID' => '各追加質問には、タイトルと全体の投票制限を満たす十分な数の有効な選択肢が必要です。',
	'AP_REQUIRED_QUESTION_MISSING' => '続行する前に、この必須の質問に回答してください。',
	'AP_POLL_NAVIGATION' => '投票質問のナビゲーション',
	'AP_POLL_MIN_VALUE' => '最小スコア',
	'AP_POLL_MIN_VALUE_EXPLAIN' => '選択した項目に投票者が割り当てられる最小スコアです。',
	'AP_VOTE_OUTSIDE_RANGE' => '割り当てるスコアは、設定された最小値と最大値の範囲内でなければなりません。',
]);
