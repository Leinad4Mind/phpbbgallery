<?php
/**
 * phpBB Gallery album-data extension boundary tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\data_enricher;
use PHPUnit\Framework\TestCase;

final class album_data_enricher_test extends TestCase
{
	public function test_enricher_returns_data_from_optional_provider(): void
	{
		$dispatcher = new class implements \phpbb\event\dispatcher_interface
		{
			public string $event_name = '';

			public function trigger_event($event_name, $data = [])
			{
				$this->event_name = $event_name;
				$data['album_data']['provider_value'] = 42;

				return $data;
			}
		};
		$enricher = new data_enricher($dispatcher);

		$result = $enricher->enrich(['album_id' => 7, 'album_name' => 'Base']);

		$this->assertSame('phpbbgallery.core.album.enrich_data', $dispatcher->event_name);
		$this->assertSame('Base', $result['album_name']);
		$this->assertSame(42, $result['provider_value']);
	}

	public function test_album_readers_do_not_depend_on_contest_storage_or_service(): void
	{
		$album = (string) file_get_contents(dirname(__DIR__) . '/album/album.php');
		$loader = (string) file_get_contents(dirname(__DIR__) . '/album/loader.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$album_service = strstr($services, 'phpbbgallery.core.album:');
		$album_service = strstr($album_service, 'phpbbgallery.core.album.display:', true);
		$loader_service = strstr($services, 'phpbbgallery.core.album.loader:');
		$loader_service = strstr($loader_service, 'phpbbgallery.core.album.data_enricher:', true);

		$this->assertStringNotContainsString('contests_table', $album);
		$this->assertStringNotContainsString('core\\contest', $loader);
		$this->assertStringNotContainsString('gallery_contests', $album_service);
		$this->assertStringNotContainsString('core.contest', $loader_service);
	}

	public function test_enricher_supports_bulk_rows_without_dispatching_empty_batches(): void
	{
		$dispatcher = new class implements \phpbb\event\dispatcher_interface
		{
			public int $calls = 0;

			public function trigger_event($event_name, $data = [])
			{
				$this->calls++;
				$data['album_rows'][0]['provider_value'] = 42;

				return $data;
			}
		};
		$enricher = new data_enricher($dispatcher);

		$this->assertSame([], $enricher->enrich_many([]));
		$this->assertSame(0, $dispatcher->calls);
		$this->assertSame(42, $enricher->enrich_many([['album_id' => 7]])[0]['provider_value']);
		$this->assertSame(1, $dispatcher->calls);
	}

	public function test_album_listing_does_not_query_contest_storage_directly(): void
	{
		$display = (string) file_get_contents(dirname(__DIR__) . '/album/display.php');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');
		$display_service = strstr($services, 'phpbbgallery.core.album.display:');
		$display_service = strstr($display_service, 'phpbbgallery.core.album.loader:', true);

		$this->assertStringContainsString('$this->data_enricher->enrich_many($rows)', $display);
		$this->assertStringNotContainsString('table_contests', $display);
		$this->assertStringNotContainsString('gallery_contests', $display_service);
	}
}
