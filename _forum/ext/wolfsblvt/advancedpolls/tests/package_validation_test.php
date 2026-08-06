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
		$this->assertSame('>=7.1.3', $composer['require']['php']);
		$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb']);
	}

	public function test_services_register_listener_core_cron_and_notification()
	{
		$services = file_get_contents($this->extension_root() . '/config/services.yml');

		$this->assertStringContainsString('wolfsblvt.advancedpolls.listener:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.advancedpolls:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.notification.type.pollended:', $services);
		$this->assertStringContainsString('wolfsblvt.advancedpolls.cron.task.pollend:', $services);
		$this->assertStringContainsString('{name: event.listener}', $services);
		$this->assertStringContainsString('{name: notification.type}', $services);
		$this->assertStringContainsString('{name: cron.task}', $services);
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
		);
		$acp_keys = array(
			'AP_DEFAULT_POLL_VISIBILITY',
			'AP_DEFAULT_POLL_VOTE_MODE',
			'AP_ACT_SHOW_ABSTAINERS',
			'AP_ACT_VOTE_DELETE',
			'AP_ACT_POLL_NOTIFICATIONS',
			'AP_ENABLE_NOTICE',
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
		}
	}

	public function test_all_three_themes_expose_each_interactive_feature_safely()
	{
		$styles = array('prosilver', 'FLATBOOTS', 'BBOOTS');
		$required = array(
			'template/event/overall_header_head_append.html',
			'template/event/posting_editor_subject_before.html',
			'template/event/posting_poll_body_options_after.html',
			'template/event/viewtopic_body_poll_option_after.html',
			'template/js/functions.js',
			'template/js/onload.js',
			'template/js/poll_length_posting.js',
			'template/js/poll_length_reposition.js',
			'template/js/scoring_preview.js',
			'template/js/scoring_topic.js',
			'template/lib/jxtools.js',
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

			$option = file_get_contents($root . 'template/event/viewtopic_body_poll_option_after.html');
			$this->assertStringContainsString('AP_CAN_DELETE_VOTE', $option);
			$this->assertStringContainsString('AP_DELETE_VOTE', $option);

			$onload = file_get_contents($root . 'template/js/onload.js');
			$this->assertStringContainsString('res.results_hidden', $onload);
			$this->assertMatchesRegularExpression('/no_vote:\s*true/', $onload);
			$this->assertMatchesRegularExpression('/delete_vote:\s*true/', $onload);
			$this->assertSame(2, substr_count($onload, 'form_token:'));

			$date = file_get_contents($root . 'template/js/poll_length_posting.js');
			$this->assertStringContainsString('apPollEnd.getHours()).slice(-2)', $date);
			$this->assertStringContainsString('apPollEnd.getMinutes()).slice(-2)', $date);
		}
	}

	public function test_security_regressions_and_excluded_ordering_feature_stay_enforced()
	{
		$core = file_get_contents($this->extension_root() . '/core/advancedpolls.php');
		$notification = file_get_contents($this->extension_root() . '/notification/pollended.php');
		$schema = file_get_contents($this->extension_root() . '/migrations/v1_3_0_schema.php');

		$this->assertStringContainsString("is_set_post('delete_vote')", $core);
		$this->assertStringContainsString("check_form_key('posting')", $core);
		$this->assertStringContainsString("sql_transaction('rollback')", $core);
		$this->assertStringContainsString("is_set_post('no_vote')", $core);
		$this->assertStringContainsString('vote_user_id <> ' . "' . ANONYMOUS", $notification);
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
