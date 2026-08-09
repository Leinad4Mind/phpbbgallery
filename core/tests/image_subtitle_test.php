<?php
/**
 * phpBB Gallery - image subtitle tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\image as image_controller;
use phpbbgallery\core\image\image as image_service;
use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class image_subtitle_test extends TestCase
{
	public function test_upload_subtitles_are_plain_text_normalized_and_follow_same_name_numbering(): void
	{
		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();
		$upload->set_names(['Image {NUM}', 'Other']);
		$upload->set_descriptions(['Description {NUM}', 'Other']);
		$upload->set_subtitles(['  Dragon Ball ({NUM})  ', 'Other']);
		$upload->set_image_num(5);
		$upload->use_same_name(true);

		$file_count = new \ReflectionProperty(upload::class, 'file_count');
		$file_count->setValue($upload, 1);

		$this->assertSame('Dragon Ball (6)', $upload->get_subtitle());
		$this->assertSame(255, upload::IMAGE_SUBTITLE_MAX_LENGTH);
	}

	public function test_subtitle_search_terms_remove_parentheses_only_at_request_time(): void
	{
		$controller = (new \ReflectionClass(image_controller::class))->newInstanceWithoutConstructor();
		$method = new \ReflectionMethod(image_controller::class, 'normalize_subtitle_search_terms');

		$this->assertSame('Dragon Ball 1985', $method->invoke($controller, '  Dragon   Ball (1985)  '));
		$this->assertSame('Title - 2026', $method->invoke($controller, 'Title - (2026)'));
		$this->assertSame('', $method->invoke($controller, ' ( ) '));
	}

	public function test_core_persists_edits_and_searches_the_subtitle_without_a_clean_column(): void
	{
		$root = dirname(__DIR__);
		$upload = (string) file_get_contents($root . '/upload.php');
		$upload_controller = (string) file_get_contents($root . '/controller/upload.php');
		$image_controller = (string) file_get_contents($root . '/controller/image.php');
		$search_controller = (string) file_get_contents($root . '/controller/search.php');
		$migration = (string) file_get_contents($root . '/migrations/image_subtitle.php');

		$this->assertStringContainsString("'image_subtitle'", $upload);
		$this->assertStringContainsString('get_subtitle()', $upload);
		$this->assertStringContainsString("variable('image_subtitle', [''], true", $upload_controller);
		$this->assertStringContainsString('set_subtitles($image_subtitles)', $upload_controller);
		$this->assertStringContainsString("'image_subtitle'       =>", $image_controller);
		$this->assertStringContainsString('$image_subtitle,', $image_controller);
		$this->assertStringContainsString('LOWER(i.image_subtitle)', $search_controller);
		$this->assertStringContainsString("'terms' => 'all'", $image_controller);
		$this->assertStringContainsString("'submit' => 1", $image_controller);
		$this->assertStringNotContainsString('image_subtitle_clean', $upload . $upload_controller . $image_controller . $search_controller . $migration);
	}

	public function test_every_style_exposes_editing_and_searchable_presentation(): void
	{
		$root = dirname(__DIR__) . '/styles';
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_body.html');
			$view = (string) file_get_contents($root . '/' . $style . '/template/gallery/viewimage_body.html');
			$card = (string) file_get_contents($root . '/' . $style . '/template/gallery/imageblock_polaroid.html');
			$javascript = (string) file_get_contents($root . '/' . $style . '/template/gallery/posting_javascript.html');

			$this->assertStringContainsString('name="image_subtitle[{{ image.S_ROW_COUNT }}]"', $posting, $style);
			$this->assertStringContainsString('maxlength="255"', $posting, $style);
			$this->assertStringContainsString('U_IMAGE_SUBTITLE_SEARCH', $view, $style);
			$this->assertStringContainsString('gallery-image-card-subtitle', $card, $style);
			$this->assertStringContainsString("update_all('image_subtitle')", $javascript, $style);
		}
	}

	public function test_optional_subtitles_do_not_break_card_row_alignment(): void
	{
		$root = dirname(__DIR__);
		$styles = $root . '/styles';

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$card = (string) file_get_contents($styles . '/' . $style . '/template/gallery/imageblock_polaroid.html');

			$this->assertStringContainsString('gallery-image-card-grid', $card, $style);
			$this->assertStringNotContainsString('image.S_LAST_ROW', $card, $style);
		}

		$css = (string) file_get_contents($styles . '/all/theme/gallery.css');
		$this->assertStringContainsString('.gallery-image-card-grid', $css);
		$this->assertStringContainsString('align-items: stretch;', $css);
		$this->assertStringContainsString('flex-wrap: wrap;', $css);
		$this->assertStringContainsString('.gallery-image-card-grid--bootstrap > [class*="col-"]', $css);
		$this->assertStringContainsString('width: 100%;', $css);
	}

	public function test_prosilver_upload_guidance_follows_the_related_fields(): void
	{
		$template = (string) file_get_contents(
			dirname(__DIR__) . '/styles/prosilver/template/gallery/posting_body.html'
		);
		$number_label = strpos($template, '<label for="image_num">');
		$number_input = strpos($template, 'id="image_num"', (int) $number_label);
		$subtitle_input = strpos($template, 'id="image_subtitle_{{ image.S_ROW_COUNT }}"');
		$subtitle_explain = strpos($template, "{{ lang('IMAGE_SUBTITLE_EXPLAIN') }}", (int) $subtitle_input);
		$description = strpos($template, '<textarea name="message[{{ image.S_ROW_COUNT }}]"');
		$description_guidance = strpos($template, 'id="desc_length_{{ image.S_ROW_COUNT }}"', (int) $description);

		foreach ([$number_label, $number_input, $subtitle_input, $subtitle_explain, $description, $description_guidance] as $position)
		{
			$this->assertNotFalse($position);
		}
		$this->assertTrue($number_label < $number_input);
		$this->assertTrue($subtitle_input < $subtitle_explain);
		$this->assertTrue($description < $description_guidance);
	}

	public function test_reusable_thumbnail_blocks_only_expose_enabled_subtitles(): void
	{
		$this->assertSame(
			'Dragon Ball (1985)',
			$this->assign_image_block_subtitle(image_service::IMAGE_SHOW_SUBTITLE)
		);
		$this->assertFalse($this->assign_image_block_subtitle(0));
	}

	public function test_every_language_defines_the_subtitle_messages(): void
	{
		$language_root = dirname(__DIR__) . '/language';
		foreach (glob($language_root . '/*', GLOB_ONLYDIR) as $directory)
		{
			$lang = [];
			include $directory . '/gallery.php';
			include $directory . '/gallery_acp.php';

			$this->assertNotSame('', $lang['IMAGE_SUBTITLE'] ?? '', basename($directory));
			$this->assertNotSame('', $lang['IMAGE_SUBTITLE_EXPLAIN'] ?? '', basename($directory));
			$this->assertStringContainsString('%d', $lang['IMAGE_SUBTITLE_TOO_LONG'] ?? '', basename($directory));
			$this->assertNotSame('', $lang['RRC_DISPLAY_SUBTITLE'] ?? '', basename($directory));
		}
	}

	private function assign_image_block_subtitle(int $display_options): mixed
	{
		$reflection = new \ReflectionClass(image_service::class);
		$service = $reflection->newInstanceWithoutConstructor();
		$assigned = [];
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())
			->method('assign_block_vars')
			->with('images', $this->callback(function (array $row) use (&$assigned): bool
			{
				$assigned = $row;
				return true;
			}));

		$gallery_auth = $this->createStub(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->method('acl_check')->willReturn(false);
		$helper = $this->createStub(\phpbb\controller\helper::class);
		$helper->method('route')->willReturnArgument(0);
		$gallery_config = $this->createStub(\phpbbgallery\core\config::class);
		$gallery_config->method('get')->willReturn(false);
		$image_visibility = $this->createStub(\phpbbgallery\core\policy\image_visibility::class);
		$image_visibility->method('hides_private_data')->willReturn(false);
		$image_visibility->method('hides_results')->willReturn(false);
		$image_visibility->method('award')->willReturn(['rank' => 0, 'label' => '', 'title' => '']);
		$language = $this->createStub(\phpbb\language\language::class);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 2];

		foreach ([
			'template' => $template,
			'gallery_auth' => $gallery_auth,
			'helper' => $helper,
			'gallery_config' => $gallery_config,
			'image_visibility' => $image_visibility,
			'language' => $language,
			'user' => $user,
		] as $property => $value)
		{
			$reflection->getProperty($property)->setValue($service, $value);
		}

		$service->assign_block('images', [
			'image_id' => 12,
			'image_album_id' => 4,
			'album_id' => 4,
			'album_user_id' => 0,
			'album_name' => 'Anime',
			'image_name' => 'Cover',
			'image_subtitle' => '  Dragon Ball (1985)  ',
			'image_view_count' => 10,
			'image_status' => \phpbbgallery\core\block::STATUS_APPROVED,
			'image_reported' => 0,
			'image_user_id' => 2,
			'image_username' => 'Author',
			'image_user_colour' => '',
			'image_time' => 100,
			'image_rates' => 0,
			'image_rate_avg' => 0,
			'image_comments' => 0,
			'image_user_ip' => '192.0.2.1',
		], $display_options);

		return $assigned['IMAGE_SUBTITLE'];
	}
}
