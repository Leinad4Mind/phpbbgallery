<?php

namespace david63\pmmonitor\tests;

use david63\pmmonitor\core\sort_policy;
use PHPUnit\Framework\TestCase;

class sort_policy_test extends TestCase
{
	public function test_unknown_sort_key_falls_back_to_date()
	{
		$this->assertSame('d', sort_policy::key('p.message_time; DROP TABLE'));
		$this->assertStringStartsWith('p.message_time DESC', sort_policy::order_by('invalid', 'invalid'));
	}

	public function test_only_explicit_ascending_value_is_accepted()
	{
		$this->assertSame('a', sort_policy::direction('a'));
		$this->assertSame('d', sort_policy::direction('ASC'));
	}

	public function test_order_has_deterministic_tie_breakers()
	{
		$this->assertSame(
			'author.username_clean ASC, p.msg_id DESC, recipient_copy.user_id ASC',
			sort_policy::order_by('f', 'a')
		);
	}
}
