<?php
/**
 * phpBB Gallery ACP Cleanup functional tests.
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests\functional;

require_once dirname(__DIR__, 3) . '/core/tests/functional/addon_workflow_test_case.php';

class acpcleanup_workflow extends \phpbbgallery\core\tests\functional\addon_workflow_test_case
{
	protected static function setup_extensions(): array
	{
		return ['phpbbgallery/core', 'phpbbgallery/acpcleanup'];
	}

	public function test_missing_source_diagnostic_through_acp(): void
	{
		$this->add_lang_ext('phpbbgallery/acpcleanup', 'info_acp_gallery_cleanup');
		$album_id = $this->insert_album('Cleanup diagnostic album');
		$image_id = $this->insert_image($album_id, 'functional-source-is-missing.png', 'Missing functional source');

		$this->login();
		$this->admin_login();
		$module = $this->module_id('acp', '\\phpbbgallery\\acpcleanup\\acp\\main_module', 'cleanup');
		$crawler = self::request('GET', $this->acp_url($module, 'cleanup'));
		$link = $crawler->filter('a[href*="check_mode=source"]');
		$this->assertSame(1, $link->count(), $crawler->filter('body')->text());

		$crawler = self::request('GET', $this->relative_url((string) $link->attr('href')));
		for ($step = 0; $step < 10; $step++)
		{
			$meta = $crawler->filter('meta[http-equiv="refresh"]');
			if (!$meta->count())
			{
				break;
			}
			preg_match('/url=(.+)$/i', (string) $meta->attr('content'), $matches);
			$this->assertArrayHasKey(1, $matches);
			$crawler = self::request('GET', $this->relative_url($matches[1]));
		}

		$this->assertStringContainsString('Missing functional source', $crawler->filter('body')->text());
		$this->assertSame(1, $crawler->filter('input[name="source[]"][value="' . $image_id . '"]')->count());
		$result = $this->get_db()->sql_query('SELECT image_filemissing FROM phpbb_gallery_images WHERE image_id = ' . $image_id);
		$this->assertSame(1, (int) $this->get_db()->sql_fetchfield('image_filemissing'));
		$this->get_db()->sql_freeresult($result);
		$this->logout();
	}
}
