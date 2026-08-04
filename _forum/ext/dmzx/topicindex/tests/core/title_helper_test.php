<?php

namespace dmzx\topicindex\tests\core;

use dmzx\topicindex\core\title_helper;
use PHPUnit\Framework\TestCase;

class title_helper_test extends TestCase
{
	public function test_removes_two_balanced_leading_tags()
	{
		$helper = new title_helper();

		$this->assertSame('Árvore', $helper->strip_leading_tags('[PHP] {Guia} Árvore'));
	}

	public function test_leaves_unbalanced_tag_untouched()
	{
		$helper = new title_helper();

		$this->assertSame('[PHP title', $helper->strip_leading_tags('[PHP title'));
	}

	public function test_removes_at_most_two_tags()
	{
		$helper = new title_helper();

		$this->assertSame('(Third) Topic', $helper->strip_leading_tags('[First] {Second} (Third) Topic'));
	}

	/**
	 * @dataProvider key_provider
	 */
	public function test_builds_expected_filter_key($title, $strip_tags, $expected)
	{
		$helper = new title_helper();

		$this->assertSame($expected, $helper->get_keys($title, $strip_tags)['group']);
	}

	public static function key_provider()
	{
		return [
			'letter' => ['Caracas', false, 'c'],
			'accented letter' => ['Caraças', false, 'c'],
			'digit' => ['7 topics', false, '09'],
			'symbol' => ['# topic', false, '_'],
			'two tags' => ['[PHP] [Help] Árvore', true, 'a'],
		];
	}
}
