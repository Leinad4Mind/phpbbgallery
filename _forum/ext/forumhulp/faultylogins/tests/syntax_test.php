<?php

namespace forumhulp\faultylogins\tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class syntax_test extends TestCase
{
	public function test_yaml_files_parse()
	{
		$root = dirname(__DIR__);
		self::assertIsArray(Yaml::parseFile($root . '/config/services.yml'));
		self::assertIsArray(Yaml::parseFile($root . '/config/tables.yml'));
	}

	public function test_twig_templates_parse()
	{
		$root = dirname(__DIR__);
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', function ($key) {
			return $key;
		}));
		foreach (['acp_faultylogins_logs.html', 'acp_faultylogins_security.html'] as $template)
		{
			$contents = file_get_contents($root . '/adm/style/' . $template);
			$twig->parse($twig->tokenize(new Source($contents, $template)));
			self::addToAssertionCount(1);
		}
	}
}
