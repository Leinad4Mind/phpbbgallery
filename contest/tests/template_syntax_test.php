<?php
/**
 * phpBB Gallery Contest template syntax tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

final class template_syntax_test extends TestCase
{
	#[IgnoreDeprecations]
	public function test_acp_event_fragments_parse_with_packaged_twig(): void
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));
		$directory = dirname(__DIR__) . '/adm/style/event';

		foreach ([
			'phpbbgallery_core_adm_album_display_options.html',
			'phpbbgallery_core_adm_album_type_options.html',
			'phpbbgallery_core_adm_album_type_warnings.html',
		] as $file)
		{
			$path = $directory . '/' . $file;
			$source = new Source((string) file_get_contents($path), $path);
			$twig->parse($twig->tokenize($source));
			$this->addToAssertionCount(1);
		}
	}

	#[IgnoreDeprecations]
	public function test_frontend_event_fragments_parse_with_packaged_twig(): void
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));

		foreach (\gallery_test_existing_styles(dirname(__DIR__)) as $style)
		{
			$directory = dirname(__DIR__) . '/styles/' . $style . '/template/event';
			foreach ([
				'phpbbgallery_core_album_type_details.html',
				'phpbbgallery_core_index_search_links_after.html',
			] as $file)
			{
				$path = $directory . '/' . $file;
				$source = new Source((string) file_get_contents($path), $path);
				$twig->parse($twig->tokenize($source));
				$this->addToAssertionCount(1);
			}
		}
	}
}
