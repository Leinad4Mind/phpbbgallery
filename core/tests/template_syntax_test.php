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
