<?php
/**
 * phpBB Gallery - ACP configuration module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\config_module;
use PHPUnit\Framework\TestCase;

final class acp_config_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(config_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === config_module::class)
			{
				$this->assertNotNull($property->getType(), config_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== config_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), config_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), config_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_display_configuration_is_flattened_for_phpbb(): void
	{
		global $phpbb_dispatcher;

		$had_dispatcher = isset($phpbb_dispatcher);
		$previous_dispatcher = $phpbb_dispatcher ?? null;
		$phpbb_dispatcher = new class
		{
			public function trigger_event(string $event_name, array $data): array
			{
				return $data;
			}
		};

		try
		{
			$display = (new config_module())->get_display_vars('main');
		}
		finally
		{
			if ($had_dispatcher)
			{
				$phpbb_dispatcher = $previous_dispatcher;
			}
			else
			{
				unset($phpbb_dispatcher);
			}
		}

		$this->assertSame('GALLERY_CONFIG', $display['title']);
		$this->assertSame('', $display['vars']['legend1']);
		$this->assertSame('GALLERY_CONFIG', $display['vars']['legend2']);
		$this->assertArrayHasKey('title', $display['vars']);
		$this->assertArrayHasKey('items_per_page', $display['vars']);
		$this->assertTrue($display['vars']['items_per_page']['explain']);
		$this->assertArrayHasKey('allow_comments', $display['vars']);
		$this->assertSame('COMMENT_SYSTEM', $display['vars']['allow_comments']['lang']);
		$this->assertTrue($display['vars']['allow_comments']['explain']);
		$this->assertArrayHasKey('allow_hotlinking', $display['vars']);
		$this->assertTrue($display['vars']['allow_hotlinking']['explain']);
		$this->assertArrayHasKey('hotlinking_domains', $display['vars']);
		$this->assertTrue($display['vars']['hotlinking_domains']['explain']);
		$this->assertArrayHasKey('watermark_enabled', $display['vars']);
		$this->assertArrayNotHasKey('gdlib_version', $display['vars']);
		$this->assertSame('int:1:600', $display['vars']['mini_thumbnail_size']['validate']);
		$this->assertSame('number:1:600', $display['vars']['mini_thumbnail_size']['type']);
		$this->assertSame('int:0:100', $display['vars']['jpg_quality']['validate']);
		$this->assertSame('number:0:100', $display['vars']['jpg_quality']['type']);
		$this->assertSame('int:0:100', $display['vars']['webp_quality']['validate']);
		$this->assertSame('number:0:100', $display['vars']['webp_quality']['type']);
		$this->assertSame('int:0:100', $display['vars']['avif_quality']['validate']);
		$this->assertSame('number:0:100', $display['vars']['avif_quality']['type']);
		$this->assertSame('AVIF_ALLOWED', $display['vars']['allow_avif']['lang']);
		$this->assertTrue($display['vars']['allow_avif']['explain']);
		$config_keys = array_keys($display['vars']);
		$this->assertSame(
			array_search('jpg_quality', $config_keys, true) + 1,
			array_search('webp_quality', $config_keys, true),
			'WebP quality must immediately follow JPEG quality.'
		);
		$this->assertSame(
			array_search('webp_quality', $config_keys, true) + 1,
			array_search('avif_quality', $config_keys, true),
			'AVIF quality must immediately follow WebP quality.'
		);
		$this->assertSame('BMP_ALLOWED', $display['vars']['allow_bmp']['lang']);
		$this->assertTrue($display['vars']['allow_bmp']['explain']);
		$this->assertArrayHasKey('viewtopic_icon', $display['vars']);
		$this->assertArrayHasKey('viewtopic_images', $display['vars']);
		$this->assertArrayHasKey('viewtopic_link', $display['vars']);
		$this->assertTrue($display['vars']['viewtopic_link']['explain']);
		$this->assertArrayHasKey('forum_index_mode', $display['vars']);
		$this->assertSame('FORUM_INDEX_BLOCKS', $display['vars']['forum_index_mode']['lang']);
		$this->assertArrayHasKey('forum_index_recent_count', $display['vars']);
		$this->assertArrayHasKey('forum_index_random_count', $display['vars']);
		$this->assertArrayHasKey('forum_index_personal_count', $display['vars']);
		$this->assertSame('int:1:12', $display['vars']['forum_index_personal_count']['validate']);
		$this->assertArrayHasKey('forum_index_display', $display['vars']);
		$this->assertSame('FORUM_INDEX_DISPLAY_OPTIONS', $display['vars']['forum_index_display']['lang']);
		$this->assertSame('RRC_PROFILE_DISPLAY_OPTIONS', $display['vars']['rrc_profile_display']['lang']);
		$this->assertArrayHasKey('forum_index_personal', $display['vars']);
		$this->assertSame('FORUM_INDEX_INCLUDE_PERSONAL', $display['vars']['forum_index_personal']['lang']);
		$this->assertTrue($display['vars']['forum_index_personal']['explain']);
		$this->assertArrayHasKey('storage_layout', $display['vars']);
		$this->assertSame('custom', $display['vars']['storage_layout']['type']);
		$this->assertSame('storage_layout_select', $display['vars']['storage_layout']['method']);
		$this->assertArrayHasKey('index_album_layout', $display['vars']);
		$this->assertSame('custom', $display['vars']['index_album_layout']['type']);
		$this->assertSame('index_album_layout_select', $display['vars']['index_album_layout']['method']);
		$this->assertArrayNotHasKey('disp_subalbum_icons', $display['vars']);
		$this->assertArrayHasKey('disp_image_id', $display['vars']);
		$this->assertSame('radio:yes_no', $display['vars']['disp_image_id']['type']);
		$this->assertTrue($display['vars']['disp_image_id']['explain']);
		$this->assertArrayHasKey('rrc_gindex_mode', $display['vars']);
		$this->assertArrayHasKey('pegas_index_viewed_count', $display['vars']);
		$this->assertArrayHasKey('pegas_index_rated_count', $display['vars']);
		$this->assertArrayNotHasKey('allow_contests', $display['vars']);
		$config_keys = array_keys($display['vars']);
		$this->assertGreaterThan(
			array_search('disp_nextprev_thumbnail', $config_keys, true),
			array_search('disp_image_url', $config_keys, true)
		);
		$this->assertSame(
			array_search('disp_image_url', $config_keys, true) + 1,
			array_search('ajax_navigation', $config_keys, true),
			'The image URL setting must immediately precede AJAX navigation.'
		);
		$display_vars = $display['vars'];
		$this->assertSame('', end($display_vars));
	}

	public function test_gallery_index_options_are_grouped_by_context(): void
	{
		$property = new \ReflectionProperty(config_module::class, 'display_vars');
		$property->setAccessible(true);
		$sections = $property->getValue(new config_module())['main']['vars'];

		$gallery_index_sections = array_values(array_filter(
			array_keys($sections),
			static fn(string $section): bool => in_array($section, ['INDEX_SETTINGS', 'RRC_GINDEX', 'FORUM_INDEX_IMAGES'], true)
		));
		$this->assertSame(['INDEX_SETTINGS', 'RRC_GINDEX', 'FORUM_INDEX_IMAGES'], $gallery_index_sections);
		$this->assertSame([
			'index_album_layout',
			'pegas_index_album',
			'disp_image_id',
			'disp_login',
			'disp_whoisonline',
			'disp_birthdays',
			'disp_statistic',
		], array_keys($sections['INDEX_SETTINGS']));
		$this->assertSame([
			'rrc_gindex_mode',
			'pegas_index_rct_count',
			'pegas_index_rnd_count',
			'pegas_index_viewed_count',
			'pegas_index_rated_count',
			'rrc_gindex_display',
			'rrc_gindex_pegas',
			'rrc_gindex_comments',
		], array_keys($sections['RRC_GINDEX']));
	}

	public function test_storage_layout_selector_marks_the_current_layout(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$module = new config_module();
		$module->language = $language;

		$html = $module->storage_layout_select('distributed', 'storage_layout');
		$filename = '7127abfe9cf6b6d3eb0a523e6158e896.jpeg';

		$this->assertStringContainsString('value=' . chr(34) . 'flat' . chr(34), $html);
		$this->assertStringContainsString('value=' . chr(34) . 'distributed' . chr(34) . ' selected=' . chr(34) . 'selected' . chr(34), $html);
		$this->assertStringContainsString('STORAGE_LAYOUT_DISTRIBUTED', $html);
		$this->assertStringContainsString('data-gallery-storage-layout-help-open', $html);
		$this->assertStringContainsString('<dialog', $html);
		$this->assertStringContainsString('source/' . $filename, $html);
		$this->assertStringContainsString('source/7/71/' . $filename, $html);
		$this->assertStringContainsString('STORAGE_LAYOUT_HELP_CHANGE', $html);
	}

	public function test_index_album_layout_selector_exposes_all_four_layouts(): void
	{
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$module = new config_module();
		$module->language = $language;

		$html = $module->index_album_layout_select('modern', 'index_album_layout');

		$this->assertStringContainsString('value="classic"', $html);
		$this->assertStringContainsString('value="modern" selected="selected"', $html);
		$this->assertStringContainsString('value="cards"', $html);
		$this->assertStringContainsString('value="futuristic"', $html);
		$this->assertStringContainsString('INDEX_ALBUM_LAYOUT_CLASSIC', $html);
		$this->assertStringContainsString('INDEX_ALBUM_LAYOUT_MODERN', $html);
		$this->assertStringContainsString('INDEX_ALBUM_LAYOUT_CARDS', $html);
		$this->assertStringContainsString('INDEX_ALBUM_LAYOUT_FUTURISTIC', $html);
	}

	public function test_gallery_index_mode_selector_supports_ranked_and_add_on_modes(): void
	{
		global $phpbb_container, $phpbb_dispatcher;
		$had_container = isset($phpbb_container);
		$previous_container = $phpbb_container ?? null;
		$had_dispatcher = isset($phpbb_dispatcher);
		$previous_dispatcher = $phpbb_dispatcher ?? null;

		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$block = new \phpbbgallery\core\block();
		$phpbb_container = new class($language, $block)
		{
			public function __construct(private object $language, private object $block)
			{
			}

			public function get(string $service): object
			{
				return $service === 'language' ? $this->language : $this->block;
			}
		};
		$phpbb_dispatcher = new class
		{
			public function trigger_event(string $event_name, array $data): array
			{
				if ($event_name === 'phpbbgallery.core.acp.config.rrc_mode_options')
				{
					$data['rrc_mode_options'] .= '<option value="32">ADD_ON_MODE</option>';
				}
				return $data;
			}
		};

		try
		{
			$html = (new config_module())->rrc_modes(
				\phpbbgallery\core\block::MODE_MOST_VIEWED | \phpbbgallery\core\block::MODE_TOP_RATED,
				'rrc_gindex_mode'
			);
			$forum_html = (new config_module())->rrc_modes(
				\phpbbgallery\core\block::MODE_PERSONAL,
				'forum_index_mode'
			);

			$this->assertStringContainsString('RRC_MODE_MOST_VIEWED', $html);
			$this->assertStringContainsString('RRC_MODE_TOP_RATED', $html);
			$this->assertStringContainsString('ADD_ON_MODE', $html);
			$this->assertStringNotContainsString('RRC_MODE_PERSONAL', $html);
			$this->assertStringContainsString('RRC_MODE_PERSONAL', $forum_html);
			$this->assertStringContainsString('value=' . chr(39) . '32' . chr(39), $forum_html);
		}
		finally
		{
			if ($had_container)
			{
				$phpbb_container = $previous_container;
			}
			else
			{
				unset($phpbb_container);
			}
			if ($had_dispatcher)
			{
				$phpbb_dispatcher = $previous_dispatcher;
			}
			else
			{
				unset($phpbb_dispatcher);
			}
		}
	}

	public function test_storage_layout_help_assets_are_accessible_and_modal(): void
	{
		$root = dirname(__DIR__);
		$event = (string) file_get_contents($root . '/adm/style/event/acp_overall_header_head_append.html');
		$javascript = (string) file_get_contents($root . '/adm/style/gallery_acp_storage_layout_help.js');
		$stylesheet = (string) file_get_contents($root . '/adm/style/gallery_acp_storage_layout_help.css');

		$this->assertStringContainsString('S_GALLERY_ACP_STORAGE_LAYOUT_HELP', $event);
		$this->assertStringContainsString('gallery_acp_storage_layout_help.css', $event);
		$this->assertStringContainsString('gallery_acp_storage_layout_help.js', $event);
		$this->assertStringContainsString('showModal', $javascript);
		$this->assertStringContainsString("event.key !== 'Escape'", $javascript);
		$this->assertStringContainsString('previousFocus.focus()', $javascript);
		$this->assertStringContainsString('::backdrop', $stylesheet);
		$this->assertStringContainsString('position: fixed;', $stylesheet);
		$this->assertStringContainsString('inset: 0;', $stylesheet);
		$this->assertStringContainsString('margin: auto;', $stylesheet);
	}

	public function test_personal_album_gallery_index_blocks_have_contextual_explanation(): void
	{
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/gallery_acp.php');

		$this->assertMatchesRegularExpression("/'rrc_gindex_pegas'.*'explain' => true/", $module);
		$this->assertStringContainsString("'RRC_GINDEX_PGALLERIES_EXPLAIN'", $language);
		$this->assertStringContainsString('Only images the current visitor is allowed to view are included.', $language);
	}

	public function test_random_gallery_block_warning_describes_query_cost(): void
	{
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/gallery_acp.php');

		$this->assertStringContainsString('Selecting random images may increase page-loading time on galleries with a large number of images.', $language);
		$this->assertStringNotContainsString('may take some time to load, on large databases', $language);
	}

	public function test_linked_image_count_has_contextual_explanation(): void
	{
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/gallery_acp.php');

		$this->assertStringContainsString("'DISP_VIEWTOPIC_LINK_EXP'", $language);
		$this->assertStringContainsString('topics and private messages', $language);
		$this->assertStringContainsString('visible to the current visitor', $language);
		$this->assertStringContainsString('permission to search', $language);
	}

	public function test_profile_image_selector_is_named_as_blocks(): void
	{
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/gallery_acp.php');

		$this->assertStringContainsString("'RRC_PROFILE_MODE'", $language);
		$this->assertStringContainsString("'RRC_PROFILE_MODE'       => 'Profile image blocks'", $language);
		$this->assertStringContainsString("'RRC_PROFILE_ITEMS'      => 'Images per enabled profile block'", $language);
		$this->assertStringContainsString('members with a very large number of Gallery images', $language);
		$this->assertStringNotContainsString('Mode of “Recent-', $language);
	}

	public function test_total_images_label_names_the_forum_index(): void
	{
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/gallery_acp.php');

		$this->assertStringContainsString("'DISP_TOTAL_IMAGES'", $language);
		$this->assertStringContainsString('Show “Total images” in the forum-index statistics', $language);
		$this->assertStringNotContainsString('Show “Total images“ on index.php', $language);
	}

	public function test_forum_index_image_section_names_its_host_context_first(): void
	{
		$language = (string) file_get_contents(dirname(__DIR__) . '/language/en/gallery_acp.php');

		$this->assertStringContainsString('Forum index — Gallery image blocks', $language);
	}

	public function test_dependent_settings_follow_their_global_switches(): void
	{
		$root = dirname(__DIR__);
		$module = (string) file_get_contents($root . '/acp/config_module.php');
		$event = (string) file_get_contents($root . '/adm/style/event/acp_overall_header_head_append.html');
		$javascript = (string) file_get_contents($root . '/adm/style/gallery_acp_dependencies.js');

		$this->assertStringContainsString("'S_GALLERY_ACP_DEPENDENT_SETTINGS'", $module);
		$this->assertStringContainsString('S_GALLERY_ACP_DEPENDENT_SETTINGS', $event);
		$this->assertStringContainsString('gallery_acp_dependencies.js', $event);
		$this->assertStringContainsString("bindBooleanDependency(form, 'allow_hotlinking', 'hotlinking_domains', '0')", $javascript);
		$this->assertStringContainsString("bindBooleanDependency(form, 'allow_rates', 'max_rating', '1')", $javascript);
		$this->assertStringNotContainsString("bindBooleanDependency(form, 'allow_webp', 'webp_quality', '1')", $javascript);
		$this->assertStringNotContainsString("bindBooleanDependency(form, 'allow_avif', 'avif_quality', '1')", $javascript);
		$this->assertStringContainsString('selected.value !== visibleValue', $javascript);
		$this->assertStringContainsString("field.addEventListener('change'", $javascript);
	}

	public function test_bbcode_templates_keep_the_selected_link_target_without_a_session_id(): void
	{
		global $phpbb_container;

		$had_container = isset($phpbb_container);
		$previous_container = $phpbb_container ?? null;
		$helper = new class
		{
			public function route(string $name, array $parameters): string
			{
				$base = '/gallery/image/' . $parameters['image_id'];
				if ($name === 'phpbbgallery_core_image_file_source')
				{
					return $base . '/source?sid=private-session';
				}
				if ($name === 'phpbbgallery_core_image_file_mini')
				{
					return $base . '/mini?sid=private-session';
				}

				return $base . '?sid=private-session';
			}
		};
		$gallery_url = $this->getMockBuilder(\phpbbgallery\core\url::class)
			->disableOriginalConstructor()
			->onlyMethods(['get_uri'])
			->getMock();
		$strip_share_context = (new \ReflectionClass(\phpbbgallery\core\url::class))->getMethod('strip_share_context');
		$gallery_url->method('get_uri')->willReturnCallback(
			static fn(string $route): string => 'https://example.test' . $strip_share_context->invoke($gallery_url, $route)
		);
		$phpbb_container = new class($helper, $gallery_url)
		{
			public function __construct(private object $helper, private object $gallery_url)
			{
			}

			public function get(string $service): object
			{
				return $service === 'controller.helper' ? $this->helper : $this->gallery_url;
			}
		};

		try
		{
			$module = new config_module();
			$image_page = $module->bbcode_tpl('image_page');
			$image = $module->bbcode_tpl('image');
			$none = $module->bbcode_tpl('none');
			$image_page_repeat = $module->bbcode_tpl('image_page');
		}
		finally
		{
			if ($had_container)
			{
				$phpbb_container = $previous_container;
			}
			else
			{
				unset($phpbb_container);
			}
		}

		$this->assertStringContainsString('image/{NUMBER}"><img', $image_page);
		$this->assertStringContainsString('image/{NUMBER}/source"><img', $image);
		$this->assertStringNotContainsString('<a href=', $none);
		$this->assertSame($image_page, $image_page_repeat);
		$this->assertStringNotContainsString('sid=', $image_page . $image . $none);

		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');
		$this->assertSame(1, substr_count($source, '$phpbb_container->get(\'text_formatter.cache\')->invalidate();'));
	}

	public function test_request_and_directory_access_are_php8_safe(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');

		$this->assertStringNotContainsString('$' . '_POST', $source);
		$this->assertStringNotContainsString('$' . '_REQUEST', $source);
		$this->assertStringNotContainsString('opendir(', $source);
		$this->assertStringNotContainsString('readdir(', $source);
		$this->assertStringContainsString('$file_tool->delete_wm($filenames);', $source);
		$this->assertStringContainsString('$vars[\'default\'] ?? null', $source);
	}

	public function test_image_summary_options_support_resolution_and_add_on_choices(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/config_module.php');

		$this->assertStringContainsString('DISPLAY_RESOLUTION', $source);
		$this->assertStringContainsString('RRC_DISPLAY_RESOLUTION', $source);
		$this->assertStringContainsString('DISPLAY_SUBTITLE', $source);
		$this->assertStringContainsString('RRC_DISPLAY_SUBTITLE', $source);
		$this->assertStringContainsString(
			'phpbbgallery.core.acp.config.rrc_display_options',
			$source
		);
	}
}
