<?php
/**
 * phpBB Gallery - Remote Storage template tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

final class template_syntax_test extends TestCase
{
	#[IgnoreDeprecations]
	public function test_remote_storage_acp_template_parses_with_packaged_twig(): void
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));
		$path = dirname(__DIR__) . '/adm/style/remotestorage_settings.html';
		$source = new Source((string) file_get_contents($path), $path);

		$twig->parse($twig->tokenize($source));
		$this->addToAssertionCount(1);
	}
}
