<?php

namespace forumhulp\searchresults\tests;

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

		foreach (['/adm/style/acp_searchresults.html', '/adm/style/acp_ext_details.html'] as $relative_path)
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

	public function test_management_template_keeps_csrf_and_safe_urls(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/acp_searchresults.html');
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/searchresults_module.php');

		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template);
		$this->assertStringContainsString('{{ result.U_SEARCH }}', $template);
		$this->assertStringContainsString("htmlspecialchars(\$row['search_keywords'], ENT_QUOTES, 'UTF-8')", $module);
		$this->assertStringContainsString("'keywords=' . urlencode(\$row['search_keywords'])", $module);
	}
}
