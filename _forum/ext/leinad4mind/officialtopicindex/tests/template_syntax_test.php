<?php

namespace leinad4mind\officialtopicindex\tests;

use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class template_syntax_test extends TestCase
{
	public function test_topicindex_and_bridge_templates_parse()
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static function ()
		{
			return '';
		}));
		foreach (['EVENT', 'INCLUDE', 'INCLUDECSS', 'INCLUDEJS'] as $tag)
		{
			$twig->addTokenParser(new template_noop_token_parser($tag));
		}

		foreach ($this->template_paths() as $template_path)
		{
			$source = new Source(file_get_contents($template_path), $template_path);
			$twig->parse($twig->tokenize($source));
			$this->addToAssertionCount(1);
		}
	}

	private function template_paths()
	{
		$extension_root = dirname(__DIR__);
		$bridge_root = dirname($extension_root, 2) . '/kasimi/topicindexbridge';
		$paths = [];
		foreach ([$extension_root . '/adm/style', $extension_root . '/styles', $bridge_root . '/adm/style', $bridge_root . '/styles'] as $directory)
		{
			$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS));
			/** @var SplFileInfo $file */
			foreach ($iterator as $file)
			{
				if ($file->isFile() && strtolower($file->getExtension()) === 'html')
				{
					$paths[] = $file->getPathname();
				}
			}
		}

		sort($paths);

		return $paths;
	}
}
