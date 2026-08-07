<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;

class package_validation_test extends TestCase
{
	public function test_composer_runtime_contract_matches_compatibility_policy()
	{
		$composer = json_decode(file_get_contents($this->extension_root() . '/composer.json'), true);

		$this->assertSame(JSON_ERROR_NONE, json_last_error());
		$this->assertSame('phpbb-extension', $composer['type']);
		$this->assertSame('1.6.0', $composer['version']);
		$this->assertSame('>=7.1.3', $composer['require']['php']);
		$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb']);
	}

	public function test_services_register_listener_core_controller_cron_and_notification()
	{
		$services = file_get_contents($this->extension_root() . '/config/services.yml');
		$routing = file_get_contents($this->extension_root() . '/config/routing.yml');
		$parsed_services = \Symfony\Component\Yaml\Yaml::parse($services);
		$parsed_routing = \Symfony\Component\Yaml\Yaml::parse($routing);

		$this->assertArrayHasKey('wolfsblvt.advancedpolls.controller.infopoll', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.controller.multi_question', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.controller.poll_list', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.multi_question_manager', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.poll_option_appender', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt.advancedpolls.notification.type.optionsadded', $parsed_services['services']);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_infopoll', $parsed_routing);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_multi_question_vote', $parsed_routing);
		$this->assertArrayHasKey('wolfsblvt_advancedpolls_poll_list', $parsed_routing);
		$this->assertSame(array('POST'), $parsed_routing['wolfsblvt_advancedpolls_multi_question_vote']['methods']);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.listener:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.advancedpolls:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.controller.infopoll:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.vote_user_lifecycle:', $services);
		$this->assertStringContainsString("- '@controller.helper'", $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.notification.type.pollended:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.cron.task.pollend:', $services);
		$this->assertStringContainsString('{name: event.listener}', $services);
		$this->assertStringContainsString('{name: notification.type}', $services);
		$this->assertStringContainsString('{name: cron.task}', $services);
		$this->assertStringContainsString('wolfsblvt_advancedpolls_infopoll:', $routing);
		$this->assertStringContainsString('/advancedpolls/infopoll/{topic_id}', $routing);
		$this->assertStringContainsString('/advancedpolls/polls', $routing);
		$this->assertStringContainsString('methods: [GET]', $routing);
	}

	public function test_english_and_portuguese_have_all_new_feature_language_keys()
	{
		$catalogues = array('en', 'pt');
		$poll_keys = array(
			'AP_ABSTAINERS',
			'AP_DELETE_VOTE',
			'AP_VISIBILITY_PUBLIC',
			'AP_VISIBILITY_DEFAULT',
			'AP_VISIBILITY_VOTE_COMPLETED',
			'AP_VISIBILITY_PRIVATE',
			'AP_VOTE_MODE_NO_CHANGE',
			'AP_VOTE_MODE_INCREMENTAL',
			'AP_VOTE_MODE_CHANGE',
			'AP_SCORE_TOTAL',
			'AP_SCORE_POINTS_TOTAL',
			'AP_SCORE_AVERAGE',
			'AP_SCORE_RATINGS',
			'AP_SCORE_OVERALL_AVERAGE',
			'AP_SCORE_BREAKDOWN',
			'AP_SCORE_DISTRIBUTION_ENTRY',
			'AP_POLL_LIST',
			'AP_SCORE_RESULT',
			'AP_RANK_SELECT_EXACTLY',
			'AP_RANK_TOTAL',
			'AP_RANK_BREAKDOWN',
			'AP_RANK_DISTRIBUTION_ENTRY',
			'AP_POLL_TYPE',
			'AP_POLL_TYPE_RANKING',
			'AP_RANK_POINTS',
			'AP_RANK_SELECTION_INCOMPLETE',
			'AP_ADDITIONAL_QUESTIONS',
			'AP_REQUIRED_QUESTION_MISSING',
			'AP_POLL_MIN_VALUE',
			'AP_VOTE_OUTSIDE_RANGE',
			'AP_POLL_COLLAPSIBLE',
			'AP_COLLAPSE_POLL',
			'AP_EXPAND_POLL',
			'AP_APPEND_OPTIONS',
			'AP_APPEND_OPTIONS_WARNING',
			'AP_APPEND_REQUIRES_CHANGES',
			'AP_APPEND_STRUCTURE_CHANGED',
		);
		$acp_keys = array(
			'AP_DEFAULT_POLL_VISIBILITY',
			'AP_DEFAULT_POLL_VOTE_MODE',
			'AP_ACT_SHOW_ABSTAINERS',
			'AP_ACT_VOTE_DELETE',
			'AP_ACT_POLL_NOTIFICATIONS',
			'AP_ACT_POLL_COLLAPSIBLE',
			'AP_ENABLE_NOTICE',
			'AP_DEFAULT_SCORE_RESULT',
			'AP_DEFAULT_SHOW_PERCENT',
			'AP_SHOW_POLL_LIST_NAVBAR',
		);

		foreach ($catalogues as $catalogue)
		{
			$poll = $this->load_language($catalogue . '/advancedpolls.php');
			$acp = $this->load_language($catalogue . '/info_acp_advancedpolls.php');
			$common = $this->load_language($catalogue . '/advancedpolls_common.php');
			foreach ($poll_keys as $key)
			{
				$this->assertArrayHasKey($key, $poll, $catalogue . ': ' . $key);
			}
			foreach ($acp_keys as $key)
			{
				$this->assertArrayHasKey($key, $acp, $catalogue . ': ' . $key);
			}
			$this->assertArrayHasKey('NOTIFICATION_AP_POLL_ENDED', $common);
			$this->assertArrayHasKey('NOTIFICATION_TYPE_AP_POLL_ENDED', $common);
			$this->assertArrayHasKey('NOTIFICATION_AP_POLL_OPTIONS_ADDED', $common);
			$this->assertArrayHasKey('NOTIFICATION_TYPE_AP_POLL_OPTIONS_ADDED', $common);
			$this->assertArrayHasKey('LOG_AP_POLL_OPTIONS_ADDED', $common);
		}
	}

	public function test_phpbb_poll_title_limit_is_100_characters()
	{
		$parser = file_get_contents(dirname($this->extension_root(), 3) . '/includes/message_parser.php');

		$this->assertMatchesRegularExpression(
			"/utf8_strlen\\(preg_replace\\([^\\r\\n]+\\)\\) > 100\\)/",
			$parser
		);
	}

	public function test_all_three_themes_expose_each_interactive_feature_safely()
	{
		$styles = array('prosilver', 'FLATBOOTS', 'BBOOTS');
		$required = array(
			'template/event/overall_header_head_append.html',
			'template/event/posting_editor_subject_before.html',
			'template/event/posting_poll_body_options_after.html',
			'template/event/viewtopic_body_poll_option_after.html',
			'template/event/viewtopic_body_poll_after.html',
			'template/event/viewtopic_body_poll_question_append.html',
			'template/js/functions.js',
			'template/js/onload.js',
			'template/js/poll_length_posting.js',
			'template/js/poll_length_reposition.js',
			'template/js/scoring_preview.js',
			'template/js/scoring_topic.js',
			'template/js/poll_type_posting.js',
			'template/js/multi_question_posting.js',
			'template/js/multi_question_vote.js',
			'template/js/poll_collapsible.js',
			'template/lib/jxtools.js',
			'theme/advancedpolls.css',
		);

		foreach ($styles as $style)
		{
			$root = $this->extension_root() . '/styles/' . $style . '/';
			foreach ($required as $file)
			{
				$this->assertFileExists($root . $file, $style . ': ' . $file);
			}

			$posting = file_get_contents($root . 'template/event/posting_poll_body_options_after.html');
			$this->assertStringContainsString('name="wolfsblvt_poll_visibility"', $posting);
			$this->assertStringContainsString('{AP_POLL_VISIBILITY_OPTIONS}', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_vote_mode"', $posting);
			$this->assertStringContainsString('{AP_POLL_VOTE_MODE_OPTIONS}', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_type"', $posting);
			$this->assertStringContainsString('{AP_POLL_TYPE_OPTIONS}', $posting);
			$this->assertStringContainsString('{AP_RANK_POINT_INPUTS}', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_min_value"', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_required"', $posting);
			$this->assertStringContainsString('WOLFSBLVT_POLL_COLLAPSIBLE', $posting);
			$this->assertStringContainsString('name="wolfsblvt_poll_collapsible"', $posting);
			$this->assertStringContainsString('name="ap_multi_questions"', $posting);
			$this->assertStringContainsString('name="ap_append_poll_options"', $posting);
			$this->assertStringContainsString('AP_CAN_APPEND_OPTIONS', $posting);
			if ($style !== 'prosilver')
			{
				$this->assertStringContainsString('form-control input-sm ap-config-select', $posting);
			}

			$option = file_get_contents($root . 'template/event/viewtopic_body_poll_option_after.html');
			$this->assertStringContainsString('AP_CAN_DELETE_VOTE', $option);
			$this->assertStringContainsString('AP_DELETE_VOTE', $option);
			$this->assertStringContainsString('AP_SCORE_BREAKDOWN', $option);
			$this->assertStringContainsString('aria-expanded="false"', $option);
			$this->assertStringContainsString('class="ap-rank-choice"', $option);
			$this->assertStringContainsString('data-current-value=', $option);
			if ($style !== 'prosilver')
			{
				$this->assertStringContainsString('form-control input-sm ap-score-select', $option);
			}

			$info_file = $style === 'prosilver'
				? 'template/event/viewtopic_body_poll_question_prepend.html'
				: 'template/event/viewtopic_topic_tools_before.html';
			$info = file_get_contents($root . $info_file);
			$this->assertStringContainsString('class="', $info);
			$this->assertStringContainsString('ap-infopoll-button', $info);
			$this->assertStringContainsString('data-infopoll-url="{U_AP_POLL_INFO_AJAX}"', $info);

			$onload = file_get_contents($root . 'template/js/onload.js');
			$this->assertStringContainsString('res.results_hidden', $onload);
			$this->assertMatchesRegularExpression('/no_vote:\s*true/', $onload);
			$this->assertMatchesRegularExpression('/delete_vote:\s*true/', $onload);
			$this->assertSame(2, substr_count($onload, 'form_token:'));
			$this->assertStringContainsString('installScoreBreakdowns', $onload);
			$this->assertStringContainsString('res.score_breakdowns', $onload);
			$this->assertStringContainsString("$('.topic_poll [data-poll-option-id=\"' + optionId + '\"]').first()", $onload);
			$this->assertStringContainsString("\$option.find('.progress-bar').first().empty()", $onload);
			$this->assertStringNotContainsString("\$source.closest('dl[data-poll-option-id]')", $onload);
			$this->assertStringContainsString("$(document).on('click', '.ap-infopoll-button'", $onload);
			$this->assertStringContainsString("type: 'GET'", $onload);
			$this->assertStringContainsString('phpbb.alert(', $onload);
			$this->assertStringContainsString('event.preventDefault()', $onload);
			$this->assertStringContainsString('installRanking', $onload);
			$this->assertStringContainsString("'vote_id[' + optionId + ']'", $onload);

			$date = file_get_contents($root . 'template/js/poll_length_posting.js');
			$this->assertStringContainsString('apPollEnd.getHours()).slice(-2)', $date);
			$this->assertStringContainsString('apPollEnd.getMinutes()).slice(-2)', $date);

			$multi_template = file_get_contents($root . 'template/event/viewtopic_body_poll_after.html');
			$this->assertStringContainsString('data-vote-url="{AP_MULTI_VOTE_URL}"', $multi_template);
			$this->assertStringContainsString('ap-poll-previous', $multi_template);
			$this->assertStringContainsString('ap-poll-next', $multi_template);
			$multi_vote = file_get_contents($root . 'template/js/multi_question_vote.js');
			$this->assertStringContainsString("method: 'POST'", $multi_vote);
			$this->assertStringContainsString('JSON.stringify(collectBallot())', $multi_vote);
			$this->assertStringContainsString('updateBreakdowns', $multi_vote);
			$this->assertStringContainsString('updateVoters', $multi_vote);
			$this->assertStringContainsString("removeAttr('data-ajax').off('submit')", $multi_vote);
			$this->assertStringNotContainsString('window.location.reload', $multi_vote);

			$collapse_template = file_get_contents($root . 'template/event/viewtopic_body_poll_question_append.html');
			$this->assertStringContainsString('AP_POLL_COLLAPSIBLE', $collapse_template);
			$this->assertStringContainsString('aria-expanded="true"', $collapse_template);
			$this->assertStringContainsString('data-topic-id="{AP_POLL_TOPIC_ID}"', $collapse_template);
			$collapse = file_get_contents($root . 'template/js/poll_collapsible.js');
			$this->assertStringContainsString('window.localStorage', $collapse);
			$this->assertStringContainsString("window.jQuery(document).on('ajaxComplete', initialise)", $collapse);
			$this->assertStringContainsString("document.getElementById('ap-multi-poll')", $collapse);
		}
	}

	public function test_security_regressions_and_excluded_ordering_feature_stay_enforced()
	{
		$core = file_get_contents($this->extension_root() . '/core/advancedpolls.php');
		$notification = file_get_contents($this->extension_root() . '/notification/pollended.php');
		$schema = file_get_contents($this->extension_root() . '/migrations/v1_4_0_schema.php');
		$infopoll = file_get_contents($this->extension_root() . '/controller/infopoll.php');
		$lifecycle = file_get_contents($this->extension_root() . '/core/vote_user_lifecycle.php');
		$listener = file_get_contents($this->extension_root() . '/event/listener.php');
		$multi_controller = file_get_contents($this->extension_root() . '/controller/multi_question.php');
		$appender = file_get_contents($this->extension_root() . '/core/poll_option_appender.php');
		$options_notification = file_get_contents($this->extension_root() . '/notification/optionsadded.php');
		$poll_list = file_get_contents($this->extension_root() . '/controller/poll_list.php');

		$this->assertStringContainsString("is_set_post('delete_vote')", $core);
		$this->assertStringContainsString("check_form_key('posting')", $core);
		$this->assertStringContainsString("sql_transaction('rollback')", $core);
		$this->assertStringContainsString("is_set_post('no_vote')", $core);
		$this->assertStringContainsString('vote_user_id <> ' . "' . ANONYMOUS", $notification);
		$this->assertStringContainsString("acl_get('f_read'", $infopoll);
		$this->assertStringContainsString("acl_get('m_seevoters'", $infopoll);
		$this->assertStringContainsString('is_ajax()', $infopoll);
		$this->assertStringContainsString("'Cache-Control', 'private, no-store'", $infopoll);
		$this->assertStringContainsString('LEFT JOIN ' . "' . USERS_TABLE", $infopoll);
		$this->assertStringContainsString('$mode === \'retain\'', $lifecycle);
		$this->assertStringContainsString('$mode === \'remove\'', $lifecycle);
		$this->assertStringContainsString('SUM(wolfsblvt_poll_option_value)', $lifecycle);
		$this->assertStringContainsString("htmlspecialchars(\$json ?: '[]', ENT_COMPAT, 'UTF-8')", $listener);
		$this->assertStringContainsString("htmlspecialchars(censor_text(\$question['text']), ENT_QUOTES, 'UTF-8')", $listener);
		$this->assertSame(2, substr_count($listener, "raw_variable('ap_multi_questions'"));
		$this->assertStringContainsString("raw_variable('answers'", $multi_controller);
		$this->assertStringContainsString('AP_POLL_COLLAPSIBLE', $core);
		$this->assertStringContainsString('activate_poll_collapsible', $core);
		$this->assertStringContainsString('get_authorised_recipients($users', $options_notification);
		$this->assertStringContainsString("vote_user_id <> ' . ANONYMOUS", $options_notification);
		$this->assertStringContainsString("sql_transaction('rollback')", $appender);
		$this->assertStringContainsString('poll_options::VOTE_MODE_CHANGE', $appender);
		$this->assertStringContainsString("'poll_option_total' => 0", $appender);
		$this->assertStringContainsString("'option_total' => 0", $appender);
		$this->assertStringContainsString("acl_getf('f_read', true)", $poll_list);
		$this->assertStringContainsString('t.topic_visibility = ' . "' . ITEM_APPROVED", $poll_list);
		$this->assertStringContainsString("f.forum_password = ''", $poll_list);
		$this->assertStringContainsString('poll_options::VISIBILITY_PUBLIC', $poll_list);
		$this->assertStringContainsString('if ($ended || ', $poll_list);
		$this->assertStringNotContainsString('order_items', $schema);
		$this->assertStringNotContainsString('purchase', strtolower($schema));
	}

	public function test_removed_ap_copyright_key_does_not_return()
	{
		$removed_key = 'AP_' . 'COPYRIGHT';
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->extension_root()));
		foreach ($iterator as $file)
		{
			if (!$file->isFile())
			{
				continue;
			}
			$this->assertStringNotContainsString($removed_key, file_get_contents($file->getPathname()), $file->getPathname());
		}
	}

	private function load_language($relative_file)
	{
		$file = $this->extension_root() . '/language/' . $relative_file;
		return (static function ($file) {
			$lang = array();
			include $file;
			return $lang;
		})($file);
	}

	private function extension_root()
	{
		return dirname(__DIR__);
	}
}
