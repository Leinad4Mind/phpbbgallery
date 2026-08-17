<?php
/**
 * phpBB Gallery - Workflow regression tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class workflow_regression_test extends TestCase
{
	public function test_array_requests_declare_an_element_type(): void
	{
		$gallery_root = dirname(__DIR__, 2);
		$import = (string) file_get_contents($gallery_root . '/acpimport/acp/main_module.php');
		$logs = (string) file_get_contents(dirname(__DIR__) . '/acp/gallery_logs_module.php');

		$this->assertStringContainsString('$request->variable(\'images\', [\'\'], true)', $import);
		$this->assertStringContainsString('$request->variable(\'mark\', [0])', $logs);
	}

	public function test_subscription_images_use_a_limited_query(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString('sql_query_limit($sql, $images_per_page, $start)', $source);
		$this->assertStringNotContainsString('sql_query($sql, $images_per_page, $start)', $source);
	}

	public function test_exif_details_respect_the_user_expansion_setting(): void
	{
		$gallery_root = dirname(__DIR__, 2);
		$templates = \gallery_test_existing_files([
			$gallery_root . '/exif/styles/prosilver/template/event/phpbbgallery_core_viewimage_details_after.html',
			$gallery_root . '/exif/styles/BBOOTS/template/event/phpbbgallery_core_viewimage_details_after.html',
			$gallery_root . '/exif/styles/FLATBOOTS/template/event/phpbbgallery_core_viewimage_details_after.html',
		]);

		foreach ($templates as $template_path)
		{
			$template = (string) file_get_contents($template_path);

			$this->assertStringContainsString('{% if not S_VIEWEXIF %}', $template, $template_path);
			$this->assertStringContainsString('dE(\'exif_data_fieldset\')', $template, $template_path);
			$this->assertStringContainsString('lang(\'SHOW_EXIF\')', $template, $template_path);
			$this->assertStringContainsString('display: none;', $template, $template_path);
		}
	}

	public function test_phpbb_entrypoints_use_configured_url_helpers(): void
	{
		$gallery_root = dirname(__DIR__);
		$image = (string) file_get_contents($gallery_root . '/controller/image.php');
		$upload = (string) file_get_contents($gallery_root . '/controller/upload.php');
		$log = (string) file_get_contents($gallery_root . '/log.php');

		$this->assertStringNotContainsString('./ucp.php', $image);
		$this->assertStringNotContainsString('ucp.php?mode=login', $upload);
		$this->assertStringNotContainsString('append_sid(\'index.php?', $log);
		$this->assertStringContainsString('$this->url->append_sid(\'phpbb\', \'ucp\'', $image);
		$this->assertStringContainsString('$this->url->append_sid(\'phpbb\', \'ucp\'', $upload);
	}

	public function test_user_visible_controller_text_uses_language_catalogues(): void
	{
		$gallery_root = dirname(__DIR__);
		$file = (string) file_get_contents($gallery_root . '/controller/file.php');
		$upload = (string) file_get_contents($gallery_root . '/controller/upload.php');
		$report = (string) file_get_contents($gallery_root . '/report.php');

		$this->assertStringNotContainsString('Image is missing!', $file);
		$this->assertStringNotContainsString('You are not authorized!', $file);
		$this->assertStringNotContainsString('Hot linking not allowed', $file);
		$this->assertStringNotContainsString('Upload to', $upload);
		$this->assertStringNotContainsString('Closed', $report);
	}

	public function test_core_does_not_call_native_htmlspecialchars_directly(): void
	{
		foreach ([
			dirname(__DIR__) . '/acp/config_module.php',
			dirname(__DIR__) . '/file/file.php',
		] as $path)
		{
			$source = (string) file_get_contents($path);

			$this->assertSame(0, preg_match('/(?<![a-zA-Z0-9_])htmlspecialchars\s*\(/', $source), $path);
		}
	}

	public function test_functional_ci_covers_sqlite_mysql_and_mariadb(): void
	{
		$workflow = (string) file_get_contents(dirname(__DIR__, 5) . '/.github/workflows/phpbbgallery.yml');

		foreach (['database: sqlite3', 'database: mysql', 'database: mariadb'] as $database)
		{
			$this->assertStringContainsString($database, $workflow);
		}
		$this->assertStringContainsString('phpunit-${{ matrix.database }}-github.xml', $workflow);
		$this->assertStringContainsString('setup-database.sh $DB 0', $workflow);
		$this->assertStringContainsString('--health-cmd="mysqladmin ping --silent"', $workflow);
		$this->assertStringNotContainsString("--health-cmd='mysqladmin ping --silent'", $workflow);
		$this->assertStringNotContainsString('phpunit-sqlite3-github.xml', $workflow);
	}
}
