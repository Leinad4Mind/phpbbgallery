<?php
/**
 * phpBB Gallery TIFF functional tests.
 *
 * @package   phpbbgallery/tiff
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\tiff\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class tiff_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/tiff'];
	}

	public function test_acp_enables_tiff_and_processor_creates_webp_derivative(): void
	{
		$this->add_lang_ext('phpbbgallery/tiff', 'info_acp_tiff');

		if (!\phpbbgallery\tiff\processor::is_supported())
		{
			$this->markTestSkipped('Imagick with TIFF and WebP support is required.');
		}

		$this->login();
		$this->admin_login();
		$module = $this->module_id('acp', '\\phpbbgallery\\tiff\\acp\\main_module', 'settings');
		$crawler = self::request('GET', $this->acp_url($module, 'settings'));
		$form = $crawler->selectButton('submit')->form();
		$crawler = self::submit($form, ['enabled' => 1, 'webp_quality' => 73]);
		$this->assertStringContainsString($this->lang('ACP_GALLERY_TIFF_UPDATED'), $crawler->filter('body')->text());

		$db = $this->get_db();
		$result = $db->sql_query("SELECT config_value FROM phpbb_config WHERE config_name = 'phpbb_gallery_tiff_webp_quality'");
		$this->assertSame('73', (string) $db->sql_fetchfield('config_value'));
		$db->sql_freeresult($result);

		$source = tempnam(sys_get_temp_dir(), 'gallery-tiff-functional-') . '.tiff';
		$derivative = tempnam(sys_get_temp_dir(), 'gallery-tiff-functional-') . '.webp';
		$image = new \Imagick();
		$image->newImage(24, 12, new \ImagickPixel('#336699'));
		$image->setImageFormat('TIFF');
		$this->assertTrue($image->writeImage($source));
		$image->clear();

		$processor = new \phpbbgallery\tiff\processor(new \phpbb\config\config([
			'phpbb_gallery_tiff_webp_quality' => 73,
		]));
		$this->assertSame('image/tiff', $processor->inspect($source)['mime']);
		$metadata = $processor->create_derivative($source, $derivative, 12, 12, 99);
		$this->assertIsArray($metadata);
		$this->assertSame('image/webp', $metadata['mime']);
		$this->assertLessThanOrEqual(12, $metadata['width']);
		@unlink($source);
		@unlink($derivative);
		$this->logout();
	}
}
