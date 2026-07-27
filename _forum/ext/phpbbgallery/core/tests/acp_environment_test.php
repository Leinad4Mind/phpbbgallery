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
			['enabled', 'disabled', 'not_installed', 'not_available', 'not_available', 'not_available'],
			array_column($checks, 'status')
		);
		$this->assertSame(
			[
				'phpbbgallery/acpcleanup',
				'phpbbgallery/acpimport',
				'phpbbgallery/exif',
				'phpbbgallery/export',
				'phpbbgallery/favorite',
				'phpbbgallery/feed',
			],
			array_column($checks, 'extension')
		);
	}

	public function test_overview_keeps_status_and_statistics_in_separate_tables(): void
	{
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_main.html');
		$status = strpos($template, "lang('GALLERY_SYSTEM_STATUS')");
		$addons = strpos($template, "lang('GALLERY_ADDONS')", $status);
		$statistics = strpos($template, "lang('GALLERY_STATS')", $addons);

		$this->assertNotFalse($status);
		$this->assertNotFalse($addons);
		$this->assertNotFalse($statistics);
		$this->assertLessThan($addons, $status);
		$this->assertLessThan($statistics, $addons);
		$system_table = substr($template, $status, $addons - $status);
		$this->assertStringNotContainsString("<th>{{ lang('STATISTIC') }}</th>", $system_table);
		$this->assertStringContainsString(
			"<th>{{ lang('GALLERY_RUNTIME') }}</th> <th>{{ lang('VALUE') }}</th> <th>{{ lang('GALLERY_REQUIREMENT') }}</th>",
			preg_replace('/\\s+/', ' ', $system_table)
		);
		$this->assertStringContainsString('mods|default([])', $template);
	}
}
