<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class search_extension_events_test extends TestCase
{
	public function test_search_events_receive_the_registered_dispatcher(): void
	{
		$reflection = new \ReflectionClass(\phpbbgallery\core\controller\search::class);
		$parameter = $reflection->getConstructor()->getParameters()[3];

		$this->assertSame('dispatcher', $parameter->getName());
		$this->assertSame('phpbb\\event\\dispatcher_interface', (string) $parameter->getType());

		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$this->assertStringContainsString('$this->dispatcher = $dispatcher;', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$search_service = strstr($services, 'phpbbgallery.core.controller.search:');
		$search_service = strstr($search_service, 'phpbbgallery.core.controller.comment:', true);
		$this->assertStringContainsString("- '@dispatcher'", $search_service);
	}

	public function test_addon_search_conditions_keep_core_permission_and_visibility_filters(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$event = strpos($controller, "trigger_event('phpbbgallery.core.search.configure'");
		$album_boundary = strpos($controller, "sql_in_set('i.image_album_id', \$search_album)", $event ?: 0);
		$visibility_boundary = strpos($controller, 'get_image_visibility_sql()', $album_boundary ?: 0);
		$addon_merge = strpos($controller, 'array_filter($additional_search_where', $visibility_boundary ?: 0);

		$this->assertNotFalse($event);
		$this->assertNotFalse($album_boundary);
		$this->assertNotFalse($visibility_boundary);
		$this->assertNotFalse($addon_merge);
		$this->assertLessThan($album_boundary, $event);
		$this->assertLessThan($visibility_boundary, $album_boundary);
		$this->assertLessThan($addon_merge, $visibility_boundary);
		$this->assertStringContainsString('&& !$additional_search_active', $controller);
	}

	public function test_addon_search_parameters_are_retained_by_pagination(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$merge = strpos($controller, '], $additional_search_params);');
		$pagination = strpos($controller, "'params' => \$pagination_params", $merge ?: 0);

		$this->assertNotFalse($merge);
		$this->assertNotFalse($pagination);
		$this->assertLessThan($pagination, $merge);
	}

	public function test_final_permission_boundaries_are_exposed_to_result_facets(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$where = strpos($controller, "\$search_where = (string) \$sql_array['WHERE']");
		$event = strpos($controller, "trigger_event('phpbbgallery.core.search.results'", $where ?: 0);
		$pagination = strpos($controller, 'generate_template_pagination([', $event ?: 0);

		$this->assertNotFalse($where);
		$this->assertNotFalse($event);
		$this->assertNotFalse($pagination);
		$this->assertLessThan($event, $where);
		$this->assertLessThan($pagination, $event);
		$this->assertStringContainsString("['search_where', 'search_count', 'search_params']", $controller);
	}

	public function test_every_style_exposes_the_tag_neutral_search_field_event(): void
	{
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/search_body.html');
			$this->assertSame(1, substr_count($template, '{% EVENT phpbbgallery_core_search_fields %}'), $style);
			$results = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/search_results.html');
			$this->assertSame(1, substr_count($results, '{% EVENT phpbbgallery_core_search_results_facets %}'), $style);
		}
	}

	public function test_search_breadcrumb_includes_gallery_before_search(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');
		$gallery = strpos($controller, "route('phpbbgallery_core_index')");
		$search = strpos($controller, "route('phpbbgallery_core_search')", ($gallery ?: 0) + 1);
		$permission = strpos($controller, "acl_get('u_search')", $search ?: 0);

		$this->assertNotFalse($gallery);
		$this->assertNotFalse($search);
		$this->assertNotFalse($permission);
		$this->assertLessThan($search, $gallery);
		$this->assertLessThan($permission, $search);
		$this->assertStringContainsString('$this->gallery_config->get_title($this->language)', $controller);
	}

	public function test_search_forms_use_get_and_offer_author_autocomplete(): void
	{
		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$root = dirname(__DIR__) . '/styles/' . $style . '/template/gallery/';
			$form = (string) file_get_contents($root . 'search_body.html');
			$results = (string) file_get_contents($root . 'search_results.html');

			$this->assertStringContainsString('<form method="get"', $form, $style);
			$this->assertStringContainsString('data-gallery-author-autocomplete', $form, $style);
			$this->assertStringContainsString('U_SEARCH_AUTHOR_AUTOCOMPLETE', $form, $style);
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/author_autocomplete.js'", $form, $style);
			$this->assertGreaterThanOrEqual(2, substr_count($results, '<form method="get"'), $style);
			$this->assertStringContainsString('SEARCH_KEYWORDS_VALUE', $results, $style);
			$this->assertStringContainsString('S_SEARCH_RESULT_HIDDEN_FIELDS', $results, $style);
			$this->assertStringContainsString('S_SEARCH_SORT_HIDDEN_FIELDS', $results, $style);
		}
	}

	public function test_bootstrap_search_results_use_a_compact_flex_toolbar_and_valid_pagination(): void
	{
		foreach (\gallery_test_existing_styles(dirname(__DIR__), ['BBOOTS', 'FLATBOOTS'], $this) as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/search_results.html');

			$this->assertStringContainsString('class="gallery-search-results-toolbar"', $template, $style);
			$this->assertStringContainsString('class="gallery-search-results-refine"', $template, $style);
			$this->assertStringContainsString('input-group input-group-sm', $template, $style);
			$this->assertSame(2, substr_count($template, '<li class="active"><a>{{ PAGE_NUMBER }}</a></li>'), $style);
			$this->assertStringNotContainsString("{% else %}\n\t\t\t\t{{ PAGE_NUMBER }}", $template, $style);
			$this->assertStringContainsString('class="gallery-search-results-footer-toolbar"', $template, $style);
			$this->assertStringContainsString('class="gallery-search-results-sort"', $template, $style);
			$this->assertStringContainsString('class="gallery-search-results-sort-controls"', $template, $style);
			$this->assertStringNotContainsString('imagerow|length', $template, $style);
		}

		$css = (string) file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('.gallery-search-results-toolbar', $css);
		$this->assertStringContainsString('max-width: 360px;', $css);
		$this->assertStringContainsString('.gallery-search-results-footer-toolbar', $css);
		$this->assertStringContainsString('max-width: 560px;', $css);
	}

	public function test_prosilver_search_results_reuse_the_native_search_toolbar(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/styles/prosilver/template/gallery/search_results.html');

		$this->assertStringContainsString('class="action-bar bar-top"', $template);
		$this->assertStringContainsString('class="search-box" role="search"', $template);
		$this->assertStringContainsString('class="inputbox search tiny" type="search"', $template);
		$this->assertStringContainsString('class="button button-search"', $template);
		$this->assertStringContainsString('name="submit" value="1"', $template);
		$this->assertStringContainsString('class="button button-search-end"', $template);
		$this->assertStringContainsString('icon fa-search fa-fw', $template);
		$this->assertStringContainsString('icon fa-cog fa-fw', $template);
		$this->assertStringNotContainsString('class="topic-actions"', $template);
		$this->assertStringNotContainsString('<label for="add_keywords">', $template);
	}

	public function test_search_exposes_bounded_sort_and_result_enrichment_events(): void
	{
		$controller = (string) file_get_contents(dirname(__DIR__) . '/controller/search.php');

		$this->assertStringContainsString("trigger_event(\n\t\t\t'phpbbgallery.core.search.sort_options'", $controller);
		$this->assertStringContainsString("['sort_key', 'sort_by_text', 'sort_by_sql', 'search_sort_joins']", $controller);
		$this->assertStringContainsString("trigger_event(\n\t\t\t\t'phpbbgallery.core.search.image_template_vars'", $controller);
		$this->assertStringContainsString("['images', 'image_template_vars']", $controller);
		$this->assertStringContainsString("'SEARCH_IN_RESULTS'            => true", $controller);
		$this->assertStringContainsString("'S_SELECT_SORT_KEY'            => \$s_sort_key", $controller);
	}
}
