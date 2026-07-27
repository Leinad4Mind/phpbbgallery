<?php
/**
 * BBTags multi-tag query tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\tags\search_query;

class search_query_test extends TestCase
{
	public function test_and_requires_an_available_relation_for_every_tag()
	{
		$sql = (new search_query())->build(
			'phpbb_bbtags_topic',
			array(4 => array(2, 3), 7 => array(3)),
			'and'
		);

		$this->assertSame(2, substr_count($sql, 'EXISTS ('));
		$this->assertStringContainsString('tag_match.tag_id = 4', $sql);
		$this->assertStringContainsString('topics.forum_id IN (2, 3)', $sql);
		$this->assertStringContainsString('tag_match.tag_id = 7', $sql);
	}

	public function test_or_uses_one_exists_with_individually_scoped_tags()
	{
		$sql = (new search_query())->build(
			'phpbb_bbtags_topic',
			array(4 => array(2), 7 => array(3)),
			'or'
		);

		$this->assertSame(1, substr_count($sql, 'EXISTS ('));
		$this->assertStringContainsString(') OR (', $sql);
		$this->assertStringContainsString('topics.forum_id IN (2)', $sql);
		$this->assertStringContainsString('topics.forum_id IN (3)', $sql);
	}

	public function test_empty_or_unavailable_requirements_cannot_match()
	{
		$query = new search_query();

		$this->assertSame('1 = 0', $query->build('phpbb_bbtags_topic', array(), 'or'));
		$this->assertSame('1 = 0', $query->build('phpbb_bbtags_topic', array(4 => array()), 'and'));
	}
}
