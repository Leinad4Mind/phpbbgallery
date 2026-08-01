<?php

namespace leinad4mind\loginredirect\tests;

use leinad4mind\loginredirect\core\redirect_policy;
use PHPUnit\Framework\TestCase;

class redirect_policy_test extends TestCase
{
	public function test_only_newer_topic_is_unseen()
	{
		$this->assertTrue(redirect_policy::is_unseen(array('topic_time' => 101), 100));
		$this->assertFalse(redirect_policy::is_unseen(array('topic_time' => 100), 100));
		$this->assertFalse(redirect_policy::is_unseen(null, 100));
	}

	public function test_priority_has_safe_fallback()
	{
		$latest = array('topic_id' => 1);
		$selected = array('topic_id' => 2);
		$this->assertSame($latest, redirect_policy::choose_announcement($latest, $selected, true));
		$this->assertSame($selected, redirect_policy::choose_announcement($latest, $selected, false));
		$this->assertSame($selected, redirect_policy::choose_announcement(null, $selected, true));
		$this->assertSame($latest, redirect_policy::choose_announcement($latest, null, false));
	}
}
