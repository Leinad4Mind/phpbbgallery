<?php

namespace forumhulp\notification_manager\tests;

require_once __DIR__ . '/template_noop_token_parser.php';

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class template_syntax_test extends TestCase
{
	#[IgnoreDeprecations]
	public function test_templates_use_valid_modern_twig_without_inline_javascript(): void
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));
		$twig->addTokenParser(new template_noop_token_parser('INCLUDECSS'));
		$twig->addTokenParser(new template_noop_token_parser('INCLUDEJS'));

		foreach ($this->template_paths() as $path)
		{
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

	public function test_javascript_uses_delegated_whitelisted_actions(): void
	{
		$all_script = (string) file_get_contents($this->root() . '/styles/all/template/js/noties.js');
		$flatboots_script = (string) file_get_contents($this->root() . '/styles/FLATBOOTS/template/js/noties.js');

		$this->assertSame($all_script, $flatboots_script);
		$this->assertStringContainsString("var validTargets = ['mark', 'unmark', 'delete']", $all_script);
		$this->assertStringContainsString("document.addEventListener('click'", $all_script);
		$this->assertStringContainsString('data-notification-exclusive', $all_script);
		$this->assertStringNotContainsString('eval(', $all_script);
		$this->assertStringNotContainsString('innerHTML', $all_script);
	}

	private function template_paths(): array
	{
		return [
			$this->root() . '/styles/all/template/ucp_noties.html',
			$this->root() . '/styles/all/template/event/overall_header_head_append.html',
			$this->root() . '/styles/FLATBOOTS/template/ucp_noties.html',
			$this->root() . '/styles/FLATBOOTS/template/event/overall_header_head_append.html',
		];
	}

	private function root(): string
	{
		return dirname(__DIR__);
	}
}
