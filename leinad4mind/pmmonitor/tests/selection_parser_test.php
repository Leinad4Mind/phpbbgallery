<?php

namespace leinad4mind\pmmonitor\tests;

use leinad4mind\pmmonitor\core\selection_parser;
use PHPUnit\Framework\TestCase;

class selection_parser_test extends TestCase
{
	public function test_valid_composite_selection_is_normalized()
	{
		$this->assertSame(array(array(
			'msg_id' => 10,
			'user_id' => 20,
			'folder_id' => -2,
		)), selection_parser::parse(array('10:20:-2')));
	}

	public function test_duplicates_are_removed()
	{
		$this->assertCount(1, selection_parser::parse(array('10:20:0', '10:20:0')));
	}

	public function test_malformed_or_out_of_range_values_are_rejected()
	{
		$this->assertFalse(selection_parser::parse(array('10:20:0 extra')));
		$this->assertFalse(selection_parser::parse(array('10:20:-5')));
		$this->assertFalse(selection_parser::parse(array('0:20:0')));
		$this->assertFalse(selection_parser::parse(array()));
	}

	public function test_oversized_post_is_rejected()
	{
		$this->assertFalse(selection_parser::parse(array_fill(0, selection_parser::MAX_SELECTIONS + 1, '10:20:0')));
	}
}
