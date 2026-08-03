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

	public function test_tag_lookup_uses_the_database_in_set_builder()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertStringContainsString('$this->db->sql_in_set($field, array_keys($lookup))', $controller);
		$this->assertStringNotContainsString('WHERE t.route = "', $controller);
	}

	public function test_empty_results_are_initialized_before_queries()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');

		$this->assertStringContainsString("? '1 = 0'", $controller);
		$this->assertStringContainsString('empty($resolved_tags)', $controller);
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

	public function test_multi_tag_search_uses_scoped_query_builder_and_dedicated_route()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');
		$routing = file_get_contents(dirname(__DIR__) . '/config/routing.yml');

		$this->assertStringContainsString('public function search()', $controller);
		$this->assertStringContainsString('get_allowed_forum_ids_by_tag($tag_ids)', $controller);
		$this->assertStringContainsString('$this->search_query->build(', $controller);
		$this->assertStringContainsString('sitesplat_bbtags_search_controller:', $routing);
		$this->assertStringContainsString('methods:  [GET]', $routing);
	}

	public function test_cumulative_links_use_persisted_routes_without_reslugging_names()
	{
		$controller = file_get_contents(dirname(__DIR__) . '/controller/main.php');
		$listener = file_get_contents(dirname(__DIR__) . '/event/listener.php');

		$this->assertStringContainsString("\$this->request->variable('routes', '', true)", $controller);
		$this->assertStringContainsString('$this->filter_url->build($active_routes, $operator)', $controller);
		$this->assertStringContainsString('$this->filter_url->toggle($active_routes, $tag[\'route\'], $operator)', $controller);
		$this->assertStringContainsString('$this->manager->get_tag_rows(', $listener);
		$this->assertStringNotContainsString('slug(utf8_normalize_nfc($value)', $controller);
	}

	public function test_standard_search_templates_link_tags_independently_from_topics()
	{
		foreach (array('topiclist_row_topic_title_after', 'search_results_topic_title_after') as $event)
		{
			$template = file_get_contents(
				dirname(__DIR__) . '/styles/all/template/event/' . $event . '.html'
			);

			$this->assertStringContainsString('href="{{ tag.URL }}"', $template, $event);
			$this->assertStringNotContainsString('U_VIEW_TOPIC', $template, $event);
		}
	}
}
