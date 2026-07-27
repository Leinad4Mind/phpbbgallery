<?php
/**
 * BBTags public controller security contract tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;

class controller_security_test extends TestCase
{
	public function test_topic_results_use_phpbb_visibility_and_forum_boundaries()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertStringContainsString("acl_getf('!f_read', true)", $controller);
		$this->assertStringContainsString("acl_getf('!f_search', true)", $controller);
		$this->assertStringContainsString("get_global_visibility_sql('topic'", $controller);
		$this->assertStringContainsString('FORUMS_ACCESS_TABLE', $controller);
		$this->assertStringContainsString('topics.topic_moved_id = 0', $controller);
	}

	public function test_tag_lookup_uses_the_database_query_builder()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertStringContainsString("sql_build_array('SELECT', array('route' => \$route))", $controller);
		$this->assertStringNotContainsString('WHERE t.route = "', $controller);
	}

	public function test_empty_results_are_initialized_before_queries()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertStringContainsString('$tag_id = 0;', $controller);
		$this->assertStringContainsString("\$where_sql = '1 = 0';", $controller);
		$this->assertStringContainsString('$topics_count = (int)', $controller);
	}

	public function test_autocomplete_does_not_build_a_regular_expression_from_input()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertStringNotContainsString('preg_grep(', $controller);
		$this->assertStringContainsString('$this->manager->get_predefined_tags($term, 20, $forum_id)', $controller);
		$this->assertStringNotContainsString("get('bbtags_pre_tags')", $controller);
	}

	public function test_ajax_endpoints_require_tagging_permission()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertSame(2, substr_count($controller, "!\$this->auth->acl_get('u_bbtags')"));
	}

	public function test_autocomplete_sends_the_forum_scope_and_configured_length()
	{
		foreach (array('BBOOTS', 'FLATBOOTS') as $style)
		{
			$javascript = file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/js/bbtags.js');
			$template = file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/event/posting_editor_subject_after.html');

			$this->assertStringContainsString('maxLength: maxLength', $javascript, $style);
			$this->assertStringContainsString('forum_id: bbTagsForumId', $javascript, $style);
			$this->assertStringContainsString('var bbTagsForumId = {BBTAGS_FORUM_ID};', $template, $style);
		}
	}

	public function test_controller_does_not_use_legacy_unscoped_runtime_objects()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertDoesNotMatchRegularExpression('/(?<!->)\\$auth->/', $controller);
		$this->assertDoesNotMatchRegularExpression('/(?<!->)\\$user->/', $controller);
	}
}
