<?php

namespace devspace\userdefaults\tests;

use devspace\userdefaults\core\settings_policy;
use PHPUnit\Framework\TestCase;

class settings_policy_test extends TestCase
{
	public function test_defaults_cover_every_runtime_setting()
	{
		$defaults = $this->policy()->defaults();
		$this->assertCount(15, $defaults);
		$this->assertSame('d M Y H:i', $defaults['ud_date_format']);
		$this->assertSame(230271, $defaults['ud_options']);
		$this->assertSame('d', $defaults['ud_topic_sd']);
		$this->assertSame(1, $defaults['ud_allow_viewonline']);
		$this->assertSame(0, $defaults['ud_notify_type']);
	}

	public function test_submission_rejects_invalid_sorting_and_date_values()
	{
		$settings = $this->policy()->normalise_submission(array(
			'current_date_format' => 'Y-m-d',
			'ud_date_format' => '<script>',
			'post_sd' => 'DROP TABLE',
			'post_sk' => 'z',
			'post_st' => 999,
			'topic_sd' => 'x',
			'topic_sk' => 'x',
			'topic_st' => -1,
		), array('d M Y H:i', 'Y-m-d'), 0);

		$this->assertSame('Y-m-d', $settings['ud_date_format']);
		$this->assertSame('a', $settings['ud_post_sd']);
		$this->assertSame('t', $settings['ud_post_sk']);
		$this->assertSame(0, $settings['ud_post_st']);
		$this->assertSame('d', $settings['ud_topic_sd']);
		$this->assertSame('t', $settings['ud_topic_sk']);
		$this->assertSame(0, $settings['ud_topic_st']);
	}

	public function test_submission_normalises_booleans_and_preserves_unmanaged_option_bits()
	{
		$high_bit = 1 << 20;
		$settings = $this->policy()->normalise_submission(array(
			'current_date_format' => 'd M Y H:i',
			'ud_date_format' => 'd M Y H:i',
			'ud_allow_pm' => 1,
			'ud_allow_massemail' => 7,
			'ud_images' => 1,
			'ud_bbcode' => 1,
			'ud_sig_links' => 1,
		), array('d M Y H:i'), $high_bit | (1 << 1));

		$this->assertSame(1, $settings['ud_allow_pm']);
		$this->assertSame(0, $settings['ud_allow_massemail']);
		$this->assertNotSame(0, $settings['ud_options'] & $high_bit);
		$this->assertNotSame(0, $settings['ud_options'] & (1 << 0));
		$this->assertNotSame(0, $settings['ud_options'] & (1 << 8));
		$this->assertNotSame(0, $settings['ud_options'] & (1 << 17));
		$this->assertSame(0, $settings['ud_options'] & (1 << 1));
	}

	public function test_stored_values_are_defensively_normalised()
	{
		$settings = $this->policy()->normalise_stored(array(
			'ud_allow_pm' => 42,
			'ud_post_sd' => 'invalid',
			'ud_topic_st' => '30',
			'ud_options' => -1,
			'ud_notify_type' => 99,
		));

		$this->assertSame(0, $settings['ud_allow_pm']);
		$this->assertSame('a', $settings['ud_post_sd']);
		$this->assertSame(30, $settings['ud_topic_st']);
		$this->assertSame(0, $settings['ud_options']);
		$this->assertSame(0, $settings['ud_notify_type']);
	}

	public function test_user_values_keep_field_mapping_and_unmanaged_bits()
	{
		$policy = $this->policy();
		$settings = $policy->defaults();
		$settings['ud_notify_pm'] = 0;
		$settings['ud_notify_type'] = 2;
		$settings['ud_allow_viewonline'] = 0;
		$unmanaged = 1 << 20;
		$values = $policy->user_values($settings, $unmanaged);

		$this->assertSame(0, $values['user_notify_pm']);
		$this->assertSame(2, $values['user_notify_type']);
		$this->assertSame(0, $values['user_allow_viewonline']);
		$this->assertNotSame(0, $values['user_options'] & $unmanaged);
	}

	protected function policy()
	{
		return new settings_policy();
	}
}
