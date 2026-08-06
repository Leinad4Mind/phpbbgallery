<?php

namespace forumhulp\uploadimage\tests;

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class template_syntax_test extends TestCase
{
	#[IgnoreDeprecations]
	public function test_acp_templates_use_valid_modern_twig(): void
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));
		$twig->addTokenParser(new template_noop_token_parser('INCLUDECSS'));
		$twig->addTokenParser(new template_noop_token_parser('INCLUDEJS'));

		foreach ([
			'/adm/style/acp_uploadimage.html',
			'/adm/style/acp_ext_details.html',
			'/adm/style/event/acp_overall_footer_after.html',
		] as $relative_path)
		{
			$path = dirname(__DIR__) . $relative_path;
			$content = (string) file_get_contents($path);
			$twig->parse($twig->tokenize(new Source($content, $path)));

			$this->assertDoesNotMatchRegularExpression(
				'/<!--\s*(?:BEGIN|END|IF|ELSE|ENDIF|INCLUDE|INCLUDEJS|INCLUDECSS|EVENT)\b/i',
				$content,
				$path
			);
			$this->assertStringNotContainsString('onclick=', strtolower($content), $path);
			$this->assertStringNotContainsString('{L_', $content, $path);
		}
	}

	public function test_management_template_preserves_csrf_and_safe_rendering(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/acp_uploadimage.html');

		$this->assertGreaterThanOrEqual(2, substr_count($template, '{{ S_FORM_TOKEN }}'));
		$this->assertStringContainsString('{{ image.IMAGE_URL }}', $template);
		$this->assertStringContainsString('{{ image.DELETE_URL }}', $template);
		$this->assertStringNotContainsString('|raw }}"', $template);
	}
}
