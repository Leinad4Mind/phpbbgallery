<?php

namespace dmzx\forumicons\tests;

use dmzx\forumicons\event\listener;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class package_test extends TestCase
{
	public function test_composer_targets_phpbb_33_without_an_insecure_version_check()
	{
		$composer = json_decode(file_get_contents(dirname(__DIR__) . '/composer.json'), true);

		$this->assertSame(JSON_ERROR_NONE, json_last_error());
		$this->assertSame('1.1.0', $composer['version']);
		$this->assertSame('>=7.2', $composer['require']['php']);
		$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['require']['phpbb/phpbb']);
		$this->assertArrayNotHasKey('version-check', $composer['extra']);
	}

	public function test_service_arguments_match_the_listener_constructor()
	{
		$services = Yaml::parseFile(dirname(__DIR__) . '/config/services.yml')['services'];
		$arguments = $services['dmzx.forumicons.listener']['arguments'];
		$constructor = (new ReflectionClass(listener::class))->getConstructor();

		$this->assertCount($constructor->getNumberOfParameters(), $arguments);
		$this->assertSame(['@template', '@language', '%core.root_path%'], $arguments);
	}

	public function test_templates_parse_and_do_not_contain_inline_event_handlers()
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static function ()
		{
			return '';
		}));
		foreach (['INCLUDECSS', 'INCLUDEJS'] as $tag)
		{
			$twig->addTokenParser(new template_noop_token_parser($tag));
		}

		$directory = dirname(__DIR__) . '/adm/style/event';
		foreach (glob($directory . '/*.html') as $path)
		{
			$contents = file_get_contents($path);
			$twig->parse($twig->tokenize(new Source($contents, $path)));
			$this->assertStringNotContainsString('onclick=', strtolower($contents));
			$this->assertStringNotContainsString('innerhtml', strtolower($contents));
		}
	}

	public function test_all_languages_are_utf8_and_have_the_complete_catalogue()
	{
		$required_keys = [
			'AVAILABLE_FORUM_IMAGE',
			'AVAILABLE_FORUM_IMAGE_EXPLAIN',
			'SELECTED_FORUM_IMAGE',
			'CLEAR_BUTTON',
			'FORUMICONS_DIRECTORY_UNAVAILABLE',
			'FORUMICONS_NO_IMAGES',
			'FORUMICONS_LIMIT_REACHED',
		];

		if (!defined('IN_PHPBB'))
		{
			define('IN_PHPBB', true);
		}

		foreach (glob(dirname(__DIR__) . '/language/*/acp/info_acp_forumicons.php') as $path)
		{
			$contents = file_get_contents($path);
			$this->assertSame(1, preg_match('//u', $contents), $path);
			$lang = [];
			include $path;
			$this->assertSame([], array_diff($required_keys, array_keys($lang)), $path);
		}
	}

	public function test_version_is_not_stored_in_phpbb_config()
	{
		$install = file_get_contents(dirname(__DIR__) . '/migrations/forumicons_install.php');
		$upgrade = file_get_contents(dirname(__DIR__) . '/migrations/forumicons_1_1_0.php');

		$this->assertStringNotContainsString('forumicons_version', $install);
		$this->assertStringContainsString("'config.remove', ['forumicons_version']", $upgrade);
		$this->assertStringNotContainsString('config.update', $upgrade);
	}
}
