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
		$this->assertCount(10, $template_paths);

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
				'/\{%\s*(?:if|elseif)\b[^%]*(?:&&|\|\||\beq\b|\bneq\b|\bmod\b)/',
				$source,
				$template_path
			);
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
