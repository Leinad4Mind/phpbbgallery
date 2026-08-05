<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFunction;

class package_test extends TestCase
{

	public function test_composer_metadata_is_current_and_has_no_insecure_update_channel()
	{
		$metadata = json_decode(file_get_contents($this->get_root() . '/composer.json'), true);

		self::assertSame(JSON_ERROR_NONE, json_last_error());
		self::assertSame('forumhulp/errorpages', $metadata['name']);
		self::assertSame('3.2.0', $metadata['version']);
		self::assertSame('GPL-2.0-only', $metadata['license']);
		self::assertSame('>=7.2.0', $metadata['require']['php']);
		self::assertSame('>=3.3.0,<4.0.0@dev', $metadata['extra']['soft-require']['phpbb/phpbb']);
		self::assertArrayNotHasKey('version-check', $metadata['extra']);
		self::assertSame('Leinad4Mind', $metadata['authors'][0]['name']);
		self::assertSame('Extension Developer', $metadata['authors'][0]['role']);
		self::assertSame('Original Developer', $metadata['authors'][1]['role']);
	}

	public function test_runtime_has_no_helper_or_deprecated_language_dependency()
	{
		$runtime = file_get_contents($this->get_root() . '/event/listener.php')
			. file_get_contents($this->get_root() . '/event/acp_listener.php')
			. file_get_contents($this->get_root() . '/config/services.yml');

		self::assertStringNotContainsString('forumhulp/helper', $runtime);
		self::assertStringNotContainsString('add_lang_ext', $runtime);
		self::assertStringContainsString('priority: 10', $runtime);
		self::assertStringContainsString('HttpExceptionInterface', $runtime);
	}

	public function test_all_status_keys_have_titles_and_explanations()
	{
		$english = $this->load_language($this->get_root() . '/language/en/common.php');

		foreach (\forumhulp\errorpages\event\listener::STATUS_LANGUAGE_KEYS as $key)
		{
			self::assertArrayHasKey($key, $english);
			self::assertArrayHasKey($key . '_EXPLAIN', $english);
		}

		foreach (['pt', 'pt_br', 'pt_preao'] as $locale)
		{
			$translated = $this->load_language($this->get_root() . '/language/' . $locale . '/common.php');
			self::assertSame(array_keys($english), array_keys($translated), $locale);
		}
	}

	public function test_service_configuration_is_valid_and_prioritized()
	{
		$services = Yaml::parse(file_get_contents($this->get_root() . '/config/services.yml'));
		$listener = $services['services']['forumhulp.errorpages.listener'];

		self::assertSame('%debug.exceptions%', $listener['arguments'][5]);
		self::assertSame(10, $listener['tags'][0]['priority']);
		self::assertSame('on_kernel_exception', $listener['tags'][0]['method']);
	}

	public function test_template_uses_twig_and_relative_phpbb_index_url()
	{
		$template = file_get_contents($this->get_root() . '/styles/all/template/error_page.html');

		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', function () {
			return '';
		}));
		$twig->parse($twig->tokenize(new Source($template, 'error_page.html')));

		self::assertStringContainsString("{% include 'overall_header.html' %}", $template);
		self::assertStringContainsString("{{ U_INDEX|e('html_attr') }}", $template);
		self::assertStringContainsString('{{ ERRORPAGES_TITLE|e }}', $template);
		self::assertStringNotContainsString('generate_board_url', $template);
		self::assertStringNotContainsString('<!-- IF', $template);
	}

	public function test_generated_difference_file_is_not_distributed()
	{
		self::assertFileDoesNotExist($this->get_root() . '/differences.md');
		self::assertFileExists($this->get_root() . '/LICENSE.txt');
		self::assertFileExists($this->get_root() . '/README.md');
	}

	private function get_root()
	{
		return dirname(__DIR__);
	}

	private function load_language($file)
	{
		$content = file_get_contents($file);
		self::assertSame(1, preg_match('//u', $content), $file);
		$lang = [];
		require $file;

		return $lang;
	}
}
