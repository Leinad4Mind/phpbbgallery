<?php
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- display filter test doubles intentionally share this fixture.
/**
 * phpBB Gallery - Exif Extension tests
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\exif\exif;
use phpbbgallery\exif\event\exif_listener;
use phpbbgallery\exif\listing_options;

class exif_display_filter_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		global $template, $user;

		$template = new filter_test_template();
		$user = new filter_test_user();
	}

	/**
	 * Three fields chosen because prepare_data() derives them without needing any
	 * language string of its own, keeping the fixture small.
	 */
	private function new_handler(): exif
	{
		$handler = new exif('/missing/image.jpg');
		$handler->data = [
			'EXIF' => [
				'FNumber' => '28/10',
				'ISOSpeedRatings' => 400,
			],
			'IFD0' => [
				'Model' => 'canon eos',
			],
		];

		return $handler;
	}

	public function test_an_empty_filter_keeps_every_field(): void
	{
		global $template;

		// Backwards compatible: callers that pass nothing still get the full block.
		$this->new_handler()->send_to_template();

		$this->assertSame(
			['EXIF_APERTURE', 'EXIF_ISO', 'EXIF_CAM_MODEL'],
			$template->assigned_names()
		);
		$this->assertTrue($template->vars['S_EXIF_DATA']);
	}

	public function test_only_the_enabled_fields_reach_the_template(): void
	{
		global $template;

		$this->new_handler()->send_to_template(true, 'exif_value', ['exif_aperture', 'exif_cam_model']);

		$this->assertSame(['EXIF_APERTURE', 'EXIF_CAM_MODEL'], $template->assigned_names());
	}

	public function test_prepared_data_can_be_reused_without_assigning_a_template(): void
	{
		global $template;

		$fields = $this->new_handler()->get_prepared_data(['exif_iso', 'exif_cam_model']);
		$this->assertSame(['exif_iso' => 400, 'exif_cam_model' => 'Canon Eos'], $fields);
		$this->assertSame([], $template->blocks);
	}

	public function test_resolution_density_is_presented_from_ifd0_without_a_photographic_exif_group(): void
	{
		global $template;

		$handler = new exif('/missing/image.jpg');
		$handler->data = [
			'IFD0' => [
				'XResolution' => '72/1',
				'YResolution' => '72/1',
				'ResolutionUnit' => 2,
			],
		];
		$handler->send_to_template(true, 'exif_value', ['exif_resolution']);

		$this->assertSame(['EXIF_RESOLUTION'], $template->assigned_names());
		$this->assertSame('72 dpi', $template->blocks['exif_value'][0]['EXIF_VALUE']);
		$this->assertTrue($template->vars['S_EXIF_DATA']);
	}

	public function test_disabling_every_field_hides_the_block_entirely(): void
	{
		global $template;

		$this->new_handler()->send_to_template(true, 'exif_value', ['exif_focal']);

		$this->assertSame([], $template->assigned_names());
		// Without this the template would render an empty Exif fieldset.
		$this->assertArrayNotHasKey('S_EXIF_DATA', $template->vars);
	}

	public function test_the_expand_preference_still_reaches_the_template(): void
	{
		global $template;

		$this->new_handler()->send_to_template(false, 'exif_value', ['exif_iso']);

		$this->assertFalse($template->vars['S_VIEWEXIF']);
	}

	public function test_every_display_field_maps_to_a_distinct_config_name(): void
	{
		$names = array_map(
			static fn (string $field): string => exif_listener::display_config_name($field),
			exif_listener::DISPLAY_FIELDS
		);

		$this->assertSame($names, array_unique($names));
		$this->assertSame('exif_show_cam_model', exif_listener::display_config_name('exif_cam_model'));
		$this->assertSame('exif_show_date', exif_listener::display_config_name('exif_date'));
	}

	public function test_every_exif_listing_field_has_a_unique_reserved_bit(): void
	{
		$this->assertSame(exif_listener::DISPLAY_FIELDS, array_keys(listing_options::FIELDS));
		$this->assertSame(count(listing_options::FIELDS), count(array_unique(listing_options::FIELDS)));
		$this->assertSame(2048, min(listing_options::FIELDS));
		$this->assertSame(4194304, max(listing_options::FIELDS));
		$this->assertLessThan(8388608, max(listing_options::FIELDS));
	}

	public function test_listing_fields_are_selected_independently(): void
	{
		$selected = listing_options::EXIF_DATE | listing_options::EXIF_ISO | listing_options::EXIF_RESOLUTION;

		$this->assertSame(
			['exif_date', 'exif_iso', 'exif_resolution'],
			listing_options::selected_fields($selected)
		);
		$this->assertSame([], listing_options::selected_fields(0));
	}

	public function test_the_display_fields_match_what_prepare_data_can_produce(): void
	{
		// A field listed but never produced would show a dead switch in the ACP; one
		// produced but not listed could never be turned off.
		$source = (string) file_get_contents(dirname(__DIR__) . '/exif.php');
		preg_match_all("/prepared_data\['([a-z_]+)'\]/", $source, $matches);

		$produced = array_values(array_unique($matches[1]));
		sort($produced);

		$listed = exif_listener::DISPLAY_FIELDS;
		sort($listed);

		$this->assertSame($produced, $listed);
	}

	public function test_every_display_field_has_an_acp_label_in_every_language(): void
	{
		$directories = glob(dirname(__DIR__) . '/language/*', GLOB_ONLYDIR);
		$this->assertNotEmpty($directories);

		foreach ($directories as $directory)
		{
			$lang = [];
			include $directory . '/info_exif.php';
			$this->assertFileExists($directory . '/info_acp_exif.php');
			include $directory . '/info_acp_exif.php';

			$required = [
				'ACP_GALLERY_EXIF',
				'ACP_GALLERY_EXIF_EXPLAIN',
				'ACP_EXIF_CAPTURE_INDEX',
				'ACP_EXIF_INDEXED_IMAGES',
				'ACP_EXIF_SYNC_EXPLAIN',
				'ACP_EXIF_SYNC_CONFIRM',
				'ACP_EXIF_SYNC_PROGRESS',
				'ACP_EXIF_SYNC_COMPLETE',
				'EXIF_RESOLUTION',
				'DISP_EXIF_DATA_EXPLAIN',
				'EXIF_IMAGE_PAGE_FIELD_EXPLAIN',
			];
			foreach (exif_listener::DISPLAY_FIELDS as $field)
			{
				$required[] = 'DISP_' . strtoupper($field);
			}
			foreach ($required as $key)
			{
				$this->assertArrayHasKey($key, $lang, $key . ' missing for ' . basename($directory));
				$this->assertNotSame('', $lang[$key]);
			}
		}
	}

	public function test_resolution_density_migration_enables_the_new_field_for_existing_boards(): void
	{
		$migration = (string) file_get_contents(dirname(__DIR__) . '/migrations/m5_resolution_density.php');

		$this->assertStringContainsString('m4_capture_sort', $migration);
		$this->assertStringContainsString("'phpbb_gallery_exif_show_resolution', 1", $migration);
	}

	public function test_acp_field_switches_follow_the_master_exif_option(): void
	{
		$template_path = dirname(__DIR__) . '/adm/style/event/acp_overall_header_head_append.html';
		$template = (string) file_get_contents($template_path);
		$listener = (string) file_get_contents(dirname(__DIR__) . '/event/exif_listener.php');

		$this->assertFileExists($template_path);
		$this->assertStringContainsString("assign_var('S_GALLERY_EXIF_CONFIG', true)", $listener);
		$this->assertStringContainsString("'id' => 'exif'", $listener);
		$this->assertStringContainsString("'accent' => '#0f766e'", $listener);
		$this->assertGreaterThanOrEqual(2, substr_count($listener, "'addon'"));
		$this->assertStringContainsString("'explain_lang' => 'DISP_EXIF_DATA'", $listener);
		$this->assertStringContainsString("'explain_lang' => 'EXIF_IMAGE_PAGE_FIELD'", $listener);
		$this->assertStringContainsString('{% if S_GALLERY_EXIF_CONFIG %}', $template);
		$this->assertStringContainsString("'config[disp_exifdata]'", $template);
		$this->assertStringContainsString("'config[exif_show_'", $template);
		$this->assertStringContainsString("closest('dl')", $template);
		$this->assertStringContainsString('row.hidden = !visible', $template);
		$this->assertStringContainsString("addEventListener('change', updateExifOptions)", $template);
		$this->assertStringContainsString("addEventListener('reset'", $template);
		$this->assertStringNotContainsString('.disabled', $template);
	}
}

class filter_test_template
{
	public array $blocks = [];
	public array $vars = [];

	public function assign_block_vars(string $block, array $values): void
	{
		$this->blocks[$block][] = $values;
	}

	public function assign_vars(array $values): void
	{
		$this->vars = array_merge($this->vars, $values);
	}

	/**
	 * @return array The EXIF_NAME of every assigned row, in order
	 */
	public function assigned_names(): array
	{
		return array_column($this->blocks['exif_value'] ?? [], 'EXIF_NAME');
	}
}

class filter_test_user
{
	public array $lang = [
		'EXIF_APERTURE' => 'EXIF_APERTURE',
		'EXIF_ISO' => 'EXIF_ISO',
		'EXIF_CAM_MODEL' => 'EXIF_CAM_MODEL',
		'EXIF_FOCAL' => 'EXIF_FOCAL',
		'EXIF_RESOLUTION' => 'EXIF_RESOLUTION',
	];

	public function add_lang_ext(string $extension, string $file): void
	{
	}
}
