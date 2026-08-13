<?php
/**
 * phpBB Gallery - ACP environment diagnostics tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\environment;
use PHPUnit\Framework\TestCase;

final class acp_environment_test extends TestCase
{
	public function test_runtime_checks_distinguish_required_and_optional_components(): void
	{
		$diagnostics = new environment();
		$checks = $diagnostics->build_runtime_checks(80000, '8.0.30', [
			'gd' => ['available' => false, 'version' => ''],
			'mbstring' => ['available' => true, 'version' => '8.0.30'],
			'zip' => ['available' => false, 'version' => ''],
			'exif' => ['available' => true, 'version' => '8.0.30'],
		]);

		$this->assertCount(5, $checks);
		$this->assertSame(['PHP', 'gd', 'mbstring', 'zip', 'exif'], array_column($checks, 'name'));
		$this->assertFalse($checks[0]['available']);
		$this->assertTrue($checks[0]['required']);
		$this->assertFalse($checks[1]['available']);
		$this->assertTrue($checks[1]['required']);
		$this->assertFalse($checks[3]['required']);
		$this->assertSame(['PHP', 'gd'], $diagnostics->missing_required_components($checks));
	}

	public function test_tiff_package_adds_its_complete_imagick_runtime_requirement(): void
	{
		$diagnostics = new environment();
		$extensions = [
			'gd' => ['available' => true, 'version' => '2.3.3'],
			'mbstring' => ['available' => true, 'version' => '8.1.34'],
			'zip' => ['available' => true, 'version' => '1.19.5'],
			'exif' => ['available' => true, 'version' => '8.1.34'],
			'imagick' => ['available' => false, 'version' => '3.7.0'],
		];

		$enabled = $diagnostics->build_runtime_checks(80134, '8.1.34', $extensions, 'enabled');
		$disabled = $diagnostics->build_runtime_checks(80134, '8.1.34', $extensions, 'disabled');
		$imagick = $enabled[5];

		$this->assertCount(6, $enabled);
		$this->assertSame('Imagick (TIFF)', $imagick['name']);
		$this->assertSame('3.7.0', $imagick['version']);
		$this->assertFalse($imagick['available']);
		$this->assertTrue($imagick['required']);
		$this->assertSame('GALLERY_REQUIREMENT_TIFF_IMAGICK', $imagick['requirement']);
		$this->assertFalse($disabled[5]['required']);

		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$this->assertStringContainsString('$addon[\'extension\'] === \'phpbbgallery/tiff\'', $module);
		$this->assertStringContainsString('$environment->runtime_checks($tiff_status)', $module);
	}

	public function test_addon_checks_report_all_packaged_addon_states(): void
	{
		$manager = new class {
			public function is_enabled(string $extension): bool
			{
				return $extension === 'phpbbgallery/acpcleanup';
			}

			public function is_disabled(string $extension): bool
			{
				return $extension === 'phpbbgallery/acpimport';
			}

			public function is_available(string $extension): bool
			{
				return $extension === 'phpbbgallery/exif';
			}
		};

		$checks = (new environment())->addon_checks($manager);

		$this->assertSame(
			[
				'enabled',
				'disabled',
				'not_available',
				'not_installed',
				'not_available',
				'not_available',
				'not_available',
				'not_available',
				'not_available',
				'not_available',
				'not_available',
				'not_available',
				'not_available',
			],
			array_column($checks, 'status')
		);
		$this->assertSame(
			[
				'phpbbgallery/acpcleanup',
				'phpbbgallery/acpimport',
				'phpbbgallery/contest',
				'phpbbgallery/exif',
				'phpbbgallery/favorite',
				'phpbbgallery/feed',
				'phpbbgallery/tiff',
				'phpbbgallery/bbpointsimages',
				'phpbbgallery/bbtagsimages',
				'phpbbgallery/export',
				'phpbbgallery/imagefields',
				'phpbbgallery/imagerevisions',
				'phpbbgallery/remotestorage',
			],
			array_column($checks, 'extension')
		);
		$this->assertSame(
			['free', 'free', 'free', 'free', 'free', 'free', 'free', 'premium', 'premium', 'premium', 'premium', 'premium', 'premium'],
			array_column($checks, 'tier')
		);
		$this->assertSame(
			['1.4.0', '1.4.0', '1.0.0', '1.4.0', '1.0.0', '1.0.0', '1.0.0', '1.0.0', '1.0.0', '1.0.0', '1.0.0', '1.0.0', '1.0.0'],
			array_column($checks, 'version')
		);
		$this->assertSame('phpBB Gallery Add-on: ACP Cleanup', $checks[0]['name']);
		$this->assertSame('phpBB Gallery Add-on: TIFF', $checks[6]['name']);
		$this->assertSame('phpBB Gallery Add-on: Image Fields', $checks[10]['name']);
		$this->assertSame('phpBB Gallery Add-on: Image Revisions', $checks[11]['name']);
		$this->assertSame('phpBB Gallery Add-on: Remote Storage', $checks[12]['name']);
		$this->assertSame('GALLERY_ADDON_CONTEST_EXPLAIN', $checks[2]['description']);
		$this->assertSame('GALLERY_ADDON_IMAGE_FIELDS_EXPLAIN', $checks[10]['description']);
		$this->assertSame('GALLERY_ADDON_IMAGE_REVISIONS_EXPLAIN', $checks[11]['description']);
		$this->assertSame('GALLERY_ADDON_REMOTE_STORAGE_EXPLAIN', $checks[12]['description']);
	}

	public function test_overview_shows_statistics_first_and_keeps_tables_separate(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_main.html');
		$statistics = strpos($template, "lang('GALLERY_STATS')");
		$status = strpos($template, "lang('GALLERY_SYSTEM_STATUS')", $statistics);
		$addons = strpos($template, "lang('GALLERY_ADDONS')", $status);

		$this->assertNotFalse($statistics);
		$this->assertNotFalse($status);
		$this->assertNotFalse($addons);
		$this->assertLessThan($status, $statistics);
		$this->assertLessThan($addons, $status);
		$system_table = substr($template, $status, $addons - $status);
		$this->assertStringNotContainsString("<th>{{ lang('STATISTIC') }}</th>", $system_table);
		$this->assertStringContainsString(
			"<th>{{ lang('GALLERY_RUNTIME') }}</th> <th>{{ lang('VALUE') }}</th> <th>{{ lang('GALLERY_REQUIREMENT') }}</th>",
			preg_replace('/\\s+/', ' ', $system_table)
		);
		$this->assertStringContainsString('mods|default([])', $template);
		$this->assertStringContainsString('addon_groups|default([])', $template);
		$this->assertStringContainsString('group.addons|default([])', $template);
		$this->assertStringContainsString('{{ addon.VERSION }}', $template);
		$this->assertStringContainsString('{{ addon.DESCRIPTION }}', $template);
	}
}
