<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\tests;

use dmzx\whovisitedthistopic\event\listener;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class package_test extends TestCase
{
	private $root;

	protected function setUp(): void
	{
		$this->root = dirname(__DIR__);
	}

	public function test_metadata_targets_supported_phpbb()
	{
		$composer = json_decode(file_get_contents($this->root . '/composer.json'), true);
		self::assertSame(JSON_ERROR_NONE, json_last_error());
		self::assertSame('dmzx/whovisitedthistopic', $composer['name']);
		self::assertSame('1.1.0', $composer['version']);
		self::assertSame('>=7.2.0', $composer['require']['php']);
		self::assertSame('>=3.3.0,<4.0.0@dev', $composer['extra']['soft-require']['phpbb/phpbb']);
		self::assertArrayNotHasKey('version-check', $composer['extra']);
	}

	public function test_service_arguments_match_listener_constructor()
	{
		$services = Yaml::parseFile($this->root . '/config/services.yml')['services'];
		$arguments = $services['dmzx.whovisitedthistopic.listener']['arguments'];
		$constructor = (new ReflectionClass(listener::class))->getConstructor();

		self::assertCount($constructor->getNumberOfParameters(), $arguments);
		self::assertSame('@dmzx.whovisitedthistopic.core.profile_view', end($arguments));
	}

	public function test_templates_parse_and_do_not_accept_prebuilt_attributes()
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static function () {
			return '';
		}));
		$twig->addTokenParser(new template_noop_token_parser('INCLUDECSS'));

		$templates = glob($this->root . '/styles/*/template/event/*.html');
		$templates[] = $this->root . '/adm/style/acp_whovisitedthistopic.html';
		foreach ($templates as $template)
		{
			$content = file_get_contents($template);
			$twig->parse($twig->tokenize(new Source($content, $template)));
			self::assertStringNotContainsString('USERNAME_COLOUR', $content, $template);
			self::assertStringNotContainsString('visitor.DATE', $content, $template);
			self::assertStringNotContainsString('{forumrow.', $content, $template);
		}
	}

	public function test_runtime_code_is_database_portable()
	{
		$runtime = file_get_contents($this->root . '/core/visit_repository.php')
			. file_get_contents($this->root . '/event/listener.php')
			. file_get_contents($this->root . '/core/profile_view.php');
		self::assertStringNotContainsString('ON DUPLICATE KEY', $runtime);
		self::assertStringNotContainsString('similar_topics_cache', $runtime);
	}

	public function test_audit_language_catalogues_are_complete_utf8()
	{
		$required = [
			'WHOVISITEDTHISTOPIC_TITLE_NO_COUNT',
			'WHOVISITEDTHISTOPIC_RETENTION_DAYS',
			'WHOVISITEDTHISTOPIC_RETENTION_DAYS_EXPLAIN',
			'WHOVISITEDTHISTOPIC_USERS_NOT_FOUND',
			'WHOVISITEDTHISTOPIC_TOO_MANY_USERS',
		];

		foreach (glob($this->root . '/language/*/audit.php') as $path)
		{
			$content = file_get_contents($path);
			self::assertSame(1, preg_match('//u', $content), $path);
			$lang = [];
			include $path;
			self::assertSame([], array_diff($required, array_keys($lang)), $path);
		}
	}
}
