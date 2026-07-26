<?php
/**
 * phpBB Gallery - Native Twig template tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class template_syntax_test extends TestCase
{
	public function test_modernized_templates_use_only_native_twig_syntax(): void
	{
		$template_paths = $this->template_paths();
		$this->assertCount(143, $template_paths);

		foreach ($template_paths as $template_path)
		{
			$source = file_get_contents($template_path);
			$this->assertDoesNotMatchRegularExpression(
				'/<!--\s*(?:BEGIN|BEGINELSE|END|IF|ELSEIF|ELSE|ENDIF|INCLUDE|DEFINE|UNDEFINE|EVENT)\b/',
				$source,
				$template_path
			);
			$this->assertDoesNotMatchRegularExpression(
				'/(?<!\{)\{(?:L_|LA_|[A-Z][A-Z0-9_\.]*)(?:\|[^}]*)?\}(?!\})/',
				$source,
				$template_path
			);
			$this->assertDoesNotMatchRegularExpression(
				'/\{%[^%]*(?:!==|===|&&|\|\||!(?!=)|\beq\b|\bneq\b|\bmod\b)[^%]*%\}/',
				$source,
				$template_path
			);
			$this->assertStringNotContainsString(
				'{% EVENT gallery_',
				$source,
				$template_path . ' uses an unprefixed custom event'
			);
		}
	}

	public function test_style_specific_templates_have_base_counterparts(): void
	{
		$core_root = dirname(__DIR__);
		$base_directories = [
			$core_root . '/styles/prosilver/template',
			$core_root . '/styles/all/template',
		];

		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$style_root = $core_root . '/styles/' . $style . '/template';
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($style_root, \FilesystemIterator::SKIP_DOTS)
			);

			foreach ($iterator as $file)
			{
				if (!$file->isFile())
				{
					continue;
				}

				$relative_path = substr($file->getPathname(), strlen($style_root) + 1);
				$has_counterpart = false;
				foreach ($base_directories as $base_directory)
				{
					$has_counterpart = $has_counterpart || is_file($base_directory . '/' . $relative_path);
				}

				$this->assertTrue($has_counterpart, $style . '/' . $relative_path . ' has no base template counterpart');
			}
		}
	}

	public function test_optional_profile_and_upload_blocks_default_to_empty_arrays(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$view_image = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');

			$this->assertStringContainsString('custom_fields|default([])', $view_image, $style);
			$this->assertStringContainsString('commentrow.custom_fields|default([])', $view_image, $style);
			$this->assertStringContainsString('upload_image|default([])', $posting, $style);
		}
	}

	public function test_every_upload_selector_accepts_webp(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertMatchesRegularExpression('/<input[^>]+id="files"[^>]+accept="[^"]*image\/webp[^"]*"/', $posting, $style);
		}
	}

	public function test_bootstrap_moderation_empty_states_use_theme_alerts(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['moderate_approve_queue.html', 'moderate_album_overview.html'] as $template)
			{
				$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('class="alert alert-info fade in"', $source, $style . '/' . $template);
				$this->assertStringContainsString("lang('NO_WAITING_UNAPPROVED_IMAGE')", $source, $style . '/' . $template);
				$this->assertStringNotContainsString("<p> {{ lang('NO_WAITING_UNAPPROVED_IMAGE') }}", $source, $style . '/' . $template);
			}
		}
	}

	public function test_bootstrap_approval_queue_hides_an_empty_summary_alert(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/moderate_approve_queue.html');
			$this->assertStringContainsString('{% elseif TOTAL_IMAGES_WAITING %}', $source, $style);
			$this->assertStringContainsString('image_unapproved|length', $source, $style);
			$this->assertStringNotContainsString('unaproved', $source, $style);
		}
	}

	public function test_bootstrap_approval_queue_checkboxes_have_associated_labels(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/moderate_approve_queue.html');
			$this->assertStringContainsString('id="approval_{{ image_unapproved.U_IMAGE_ID }}"', $source, $style);
			$this->assertStringContainsString('for="approval_{{ image_unapproved.U_IMAGE_ID }}"', $source, $style);
		}
	}

	public function test_bootstrap_moderation_lists_use_responsive_tables(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['moderate_approve_queue.html', 'moderate_report_queue.html', 'moderate_album_overview.html'] as $template)
			{
				$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('<table class="footable table ', $source, $style . '/' . $template);
				$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $style . '/' . $template);
			}
		}
	}

	public function test_bootstrap_moderation_confirmation_uses_theme_form_controls(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/mcp_approve.html');
			$this->assertStringContainsString('class="control-group"', $source, $style);
			$this->assertStringContainsString('class="form-control"', $source, $style);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $style);
		}
	}

	public function test_bootstrap_legacy_image_edit_uses_canonical_form(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/image_edit_body.html');
			$this->assertStringContainsString("{% include 'gallery/posting_body.html' %}", $source, $style);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $style);
		}
	}

	public function test_all_bootstrap_gallery_templates_avoid_prosilver_definition_list_layout(): void
	{
		$core_root = dirname(__DIR__);
		$gallery_root = dirname($core_root);
		$directories = [
			$core_root . '/styles/BBOOTS',
			$core_root . '/styles/FLATBOOTS',
			$gallery_root . '/exif/styles/BBOOTS',
			$gallery_root . '/exif/styles/FLATBOOTS',
		];
		$templates = [];

		foreach ($directories as $directory)
		{
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS));
			foreach ($iterator as $file)
			{
				if ($file->isFile() && strtolower($file->getExtension()) === 'html')
				{
					$templates[] = $file->getPathname();
				}
			}
		}

		$this->assertCount(90, $templates);
		foreach ($templates as $template)
		{
			$source = (string) file_get_contents($template);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $template);
		}
	}

	public function test_bootstrap_gallery_forms_do_not_repeat_literal_attributes(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = $core_root . '/styles/' . $style . '/template/gallery/';
			$posting = (string) file_get_contents($root . 'posting_body.html');
			$album = (string) file_get_contents($root . 'album_body.html');
			$view_image = (string) file_get_contents($root . 'viewimage_body.html');

			$this->assertDoesNotMatchRegularExpression('/<textarea\b[^>]*\bclass="[^"]*"[^>]*\bclass="/i', $posting . $view_image, $style);
			$this->assertDoesNotMatchRegularExpression('/<button\b[^>]*\bname="[^"]*"[^>]*\bname="/i', $posting, $style);
			$this->assertStringNotContainsString('href="{{ U_RETURN_LINK }}" class=', $album . $view_image, $style);
			$this->assertStringNotContainsString('for=""', $posting, $style);
			$this->assertStringNotContainsString('for="allow_comments">Rotation', $posting, $style);
		}
	}

	public function test_bootstrap_gallery_visible_interface_strings_are_localized(): void
	{
		$core_root = dirname(__DIR__);
		$disallowed = [
			'Attention!',
			'>Preview{{',
			'>Change<',
			'>Remove<',
			'>Rotation{{',
			'data-loading-text="loading',
			'data-loading-text="Loading',
			'data-loading-text="Searching',
			'data-loading-text="Logging-in',
			'>Full URL{{',
			'>Image URL for posts{{',
			'>Cancel</button>',
		];

		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = $core_root . '/styles/' . $style;
			$source = '';
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
			foreach ($iterator as $file)
			{
				if ($file->isFile() && strtolower($file->getExtension()) === 'html')
				{
					$source .= (string) file_get_contents($file->getPathname());
				}
			}

			foreach ($disallowed as $text)
			{
				$this->assertStringNotContainsString($text, $source, $style . ': ' . $text);
			}
		}
	}

	public function test_bootstrap_gallery_form_labels_target_controls(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = $core_root . '/styles/' . $style . '/template/gallery/';
			$album = (string) file_get_contents($root . 'album_body.html');
			$comment = (string) file_get_contents($root . 'comment_body.html');
			$posting = (string) file_get_contents($root . 'posting_body.html');
			$results = (string) file_get_contents($root . 'search_results.html');
			$settings = (string) file_get_contents($root . 'ucp_gallery_personal_settings.html');
			$view_image = (string) file_get_contents($root . 'viewimage_body.html');

			$this->assertStringNotContainsString('for="bday_day"', $album . $results, $style);
			$this->assertStringContainsString('name="username" id="username"', $comment . $posting, $style);
			$this->assertStringContainsString('name="album_id" id="album_id"', $posting, $style);
			$this->assertStringContainsString('for="files"', $posting, $style);
			$this->assertStringContainsString('for="rrc_zebra1"', $settings, $style);
			$this->assertStringContainsString('name="rating" id="rating"', $view_image, $style);
			$this->assertStringNotContainsString('alert-error', $posting . $view_image, $style);
		}
	}

	public function test_bootstrap_upload_preview_uses_packaged_placeholder(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('{{ T_THEME_PATH }}/images/missing.png', $posting, $style);
			$this->assertStringNotContainsString('placehold.it', $posting, $style);
			$this->assertStringNotContainsString('http://', $posting, $style);
		}
	}

	public function test_bootstrap_search_controls_match_controller_parameters(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$search = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/search_body.html');
			$this->assertStringContainsString('name="username" id="username"', $search, $style);
			$this->assertStringNotContainsString('name="author"', $search, $style);
			$this->assertStringContainsString('name="sd" id="sa" value="a"', $search, $style);
			$this->assertStringContainsString('name="sd" id="sd" value="d"', $search, $style);
			$this->assertStringNotContainsString('Leinad4Mind', $search, $style);
		}
	}

	public function test_bootstrap_unapproved_image_actions_require_an_authorized_url(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['imageblock_body.html', 'imageblock_polaroid.html'] as $template)
			{
				$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('{% if image.S_STATUS_UNAPPROVED_ACTION %}', $source, $style . '/' . $template);
				$this->assertStringContainsString('action="{{ image.S_STATUS_UNAPPROVED_ACTION }}"', $source, $style . '/' . $template);
			}
		}
	}

	public function test_bootstrap_comment_profiles_use_the_image_controller_contract(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			foreach (['POSTER_FULL', 'U_POSTER', 'POSTER_RANK_TITLE', 'POSTER_RANK_IMG', 'S_POSTER_ONLINE', 'EDIT_INFO', 'SIGNATURE', 'contact'] as $variable)
			{
				$this->assertStringContainsString('commentrow.' . $variable, $source, $style . ': ' . $variable);
			}
			$this->assertDoesNotMatchRegularExpression('/commentrow\.(?:POST_AUTHOR_FULL|U_POST_AUTHOR|RANK_TITLE|RANK_IMG|S_ONLINE|GALLERY_IMAGES|U_(?:PM|EMAIL|WWW|MSN|ICQ|YIM|AIM|JABBER))\b/', $source, $style);
			$this->assertStringNotContainsString('<p class="author">', $source, $style);
		}
	}

	#[IgnoreDeprecations]
	public function test_modernized_templates_parse_with_packaged_twig(): void
	{
		// Twig 2.16 is the packaged version and emits PHP 8.4 deprecations from its own legacy signatures.
		$twig = $this->twig_environment();

		foreach ($this->template_paths() as $template_path)
		{
			$source = new Source(file_get_contents($template_path), $template_path);
			$twig->parse($twig->tokenize($source));
			$this->addToAssertionCount(1);
		}
	}

	private function twig_environment(): Environment
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));
		$twig->addFunction(new TwigFunction('lang_js', static fn (): string => ''));
		$twig->addFilter(new TwigFilter('subset', static fn (array $items): array => $items));
		$twig->addFilter(new TwigFilter('int', 'intval'));
		$twig->addFilter(new TwigFilter('float', 'floatval'));

		foreach (['EVENT', 'INCLUDECSS', 'INCLUDEJS'] as $tag)
		{
			$twig->addTokenParser(new template_noop_token_parser($tag));
		}

		return $twig;
	}

	private function template_paths(): array
	{
		$core_root = dirname(__DIR__);
		$gallery_root = dirname($core_root);
		$directories = [
			$core_root . '/adm/style',
			$core_root . '/styles/all',
			$core_root . '/styles/BBOOTS',
			$core_root . '/styles/FLATBOOTS',
			$core_root . '/styles/prosilver',
			$gallery_root . '/acpcleanup/adm/style',
			$gallery_root . '/acpimport/adm/style',
			$gallery_root . '/exif/styles',
		];
		$template_paths = [];

		foreach ($directories as $directory)
		{
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
			);
			foreach ($iterator as $file)
			{
				if ($file->isFile() && in_array(strtolower($file->getExtension()), ['html', 'twig'], true))
				{
					$template_paths[] = $file->getPathname();
				}
			}
		}

		sort($template_paths);
		return $template_paths;
	}
}
