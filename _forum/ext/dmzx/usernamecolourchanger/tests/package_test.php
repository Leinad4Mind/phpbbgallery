<?php

namespace dmzx\usernamecolourchanger\tests;

use dmzx\usernamecolourchanger\event\listener;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class package_test extends TestCase
{
	public function test_metadata_targets_phpbb_33_and_has_no_remote_version_check()
	{
		$composer = json_decode(file_get_contents(dirname(__DIR__) . '/composer.json'), true);

		$this->assertSame(JSON_ERROR_NONE, json_last_error());
		$this->assertSame('1.1.0', $composer['version']);
		$this->assertSame('>=7.2.0', $composer['require']['php']);
		$this->assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb']);
		$this->assertArrayNotHasKey('version-check', $composer['extra']);
	}

	public function test_services_parse_and_match_listener_constructor()
	{
		$services = Yaml::parseFile(dirname(__DIR__) . '/config/services.yml')['services'];
		$arguments = $services['dmzx.usernamecolourchanger.listener']['arguments'];
		$constructor = (new ReflectionClass(listener::class))->getConstructor();

		$this->assertCount($constructor->getNumberOfParameters(), $arguments);
		$this->assertSame([
			'@request',
			'@template',
			'@user',
			'@auth',
			'@dbal.conn',
			'@config',
			'@language',
			'@dmzx.usernamecolourchanger.colour_helper',
		], $arguments);
	}

	public function test_templates_parse_and_old_javascript_is_removed()
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static function ()
		{
			return '';
		}));

		$paths = [
			dirname(__DIR__) . '/adm/style/event/acp_users_profile_after.html',
			dirname(__DIR__) . '/styles/all/template/event/ucp_profile_profile_info_before.html',
		];
		foreach ($paths as $path)
		{
			$contents = file_get_contents($path);
			$twig->parse($twig->tokenize(new Source($contents, $path)));
			$this->assertStringNotContainsString('onclick=', strtolower($contents));
		}

		$this->assertDirectoryDoesNotExist(dirname(__DIR__) . '/adm/style/jscolor');
		$this->assertFileDoesNotExist(dirname(__DIR__) . '/styles/prosilver/template/event/ucp_profile_profile_info_before.html');
	}

	public function test_all_languages_are_utf8_and_have_the_validation_message()
	{
		if (!defined('IN_PHPBB'))
		{
			define('IN_PHPBB', true);
		}

		foreach (glob(dirname(__DIR__) . '/language/*/common.php') as $path)
		{
			$contents = file_get_contents($path);
			$this->assertSame(1, preg_match('//u', $contents), $path);
			$lang = [];
			include $path;
			$this->assertArrayHasKey('COLOUR', $lang, $path);
			$this->assertArrayHasKey('USERNAMECOLOURCHANGER_INVALID_COLOUR', $lang, $path);
		}
	}

	public function test_version_is_not_stored_in_phpbb_config()
	{
		$migration = file_get_contents(dirname(__DIR__) . '/migrations/usernamecolourchanger_schema.php');

		$this->assertStringNotContainsString('config.add', $migration);
		$this->assertStringNotContainsString('config.update', $migration);
	}
}
