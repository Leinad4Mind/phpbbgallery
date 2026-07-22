<?php
/**
 * phpBB Gallery - Core infrastructure tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbbgallery\core\auth\set as auth_set;
use phpbbgallery\core\block;
use phpbbgallery\core\cache as gallery_cache;
use phpbbgallery\core\config as gallery_config;
use phpbbgallery\core\url;

final class infrastructure_types_test extends TestCase
{
	public function test_configuration_defaults_and_mutations(): void
	{
		$config = new \phpbb\config\config([
			'phpbb_gallery_items_per_page' => 25,
			'phpbb_gallery_num_images' => 5,
		]);
		$gallery_config = new gallery_config($config);

		$this->assertSame(25, $gallery_config->get('items_per_page'));
		$this->assertFalse($gallery_config->get('allow_zip'));
		$this->assertSame(25, $gallery_config->get_all()['items_per_page']);

		$gallery_config->set('allow_zip', true);
		$gallery_config->inc('num_images', 2);
		$gallery_config->dec('num_images', 3);

		$this->assertTrue($gallery_config->get('allow_zip'));
		$this->assertSame(4, $gallery_config->get('num_images'));
	}

	public function test_auth_set_and_block_values_remain_stable(): void
	{
		$auth = new auth_set(0, 3, 4);
		$auth->set_bit(2, true);
		$this->assertTrue($auth->get_bit(2));
		$this->assertSame(4, $auth->get_bits());
		$auth->set_bit(2, false);
		$this->assertFalse($auth->get_bit(2));
		$auth->set_count('i_count', 9);
		$this->assertSame(9, $auth->get_count('i_count'));
		$this->assertSame(4, $auth->get_count('a_count'));

		$block = new block();
		$this->assertSame(block::ALBUM_LOCKED, $block->get_album_status_locked());
		$this->assertSame(block::PUBLIC_ALBUM, block::get_album_public());
		$this->assertSame(block::TYPE_UPLOAD, block::get_album_type_upload());
		$this->assertSame(block::STATUS_UNAPPROVED, $block->get_image_status_unapproved());
		$this->assertSame(block::STATUS_APPROVED, $block->get_image_status_approved());
		$this->assertSame(block::STATUS_LOCKED, $block->get_image_status_locked());
		$this->assertSame(block::STATUS_ORPHAN, $block->get_image_status_orphan());
		$this->assertSame(block::NO_CONTEST, $block->get_no_contest());
		$this->assertSame(block::IN_CONTEST, $block->get_in_contest());
	}

	public function test_image_cache_merges_missing_ids_and_returns_only_requested_rows(): void
	{
		$cached_row = $this->image_row(1, 'cached.jpg');
		$database_row = $this->image_row(2, 'database.png');
		$cache = new infrastructure_cache_service(['_images' => [1 => $cached_row]]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('image_id', [2])
			->willReturn('image_id IN (2)');
		$db->expects($this->once())
			->method('sql_build_query')
			->willReturn('SELECT images');
		$db->expects($this->once())
			->method('sql_query')
			->with('SELECT images')
			->willReturn('result');
		$db->expects($this->exactly(2))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls($database_row, false);
		$db->expects($this->once())
			->method('sql_freeresult')
			->with('result');

		$gallery_cache = new gallery_cache($cache, $db, 'gallery_albums', 'gallery_images');
		$images = $gallery_cache->get_images([1, 2]);

		$this->assertSame([1, 2], array_keys($images));
		$this->assertSame('cached.jpg', $images[1]['image_filename']);
		$this->assertSame('database.png', $images[2]['image_filename']);
		$this->assertSame([1, 2], array_keys($cache->values['_images']));
		$this->assertSame([2], array_keys($gallery_cache->get_images([2])));

		$gallery_cache->destroy_images();
		$this->assertSame([['_images']], $cache->destroyed);
	}

	public function test_album_cache_hit_and_invalidation_are_request_local(): void
	{
		$albums = [3 => ['album_id' => 3, 'album_name' => 'Cached album']];
		$cache = new infrastructure_cache_service(['_albums' => $albums]);
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$gallery_cache = new gallery_cache($cache, $db, 'gallery_albums', 'gallery_images');

		$this->assertSame($albums, $gallery_cache->get_albums());
		$this->assertSame($albums, $gallery_cache->get_albums());
		$gallery_cache->destroy_albums();
		$this->assertSame([['_albums']], $cache->destroyed);
	}

	public function test_infrastructure_contracts_and_path_normalization(): void
	{
		$expected_properties = [
			gallery_config::class => ['config' => 'phpbb\\config\\config', 'configs_array' => 'array'],
			gallery_cache::class => ['phpbb_cache' => 'phpbb\\cache\\service', 'phpbb_db' => 'phpbb\\db\\driver\\driver_interface', 'albums' => '?array', 'images' => 'array'],
			url::class => ['template' => 'phpbb\\template\\template', 'request' => 'phpbb\\request\\request', 'config' => 'phpbb\\config\\config'],
			\phpbbgallery\core\auth\level::class => ['auth' => 'phpbbgallery\\core\\auth\\auth', 'config' => 'phpbb\\config\\config', 'template' => 'phpbb\\template\\template', 'user' => 'phpbb\\user', 'lang' => 'phpbb\\language\\language'],
		];

		foreach ($expected_properties as $class => $properties)
		{
			$reflection = new \ReflectionClass($class);
			foreach ($properties as $property_name => $expected_type)
			{
				$this->assertSame($expected_type, (string) $reflection->getProperty($property_name)->getType());
			}
		}

		$this->assertSame('../gallery/', url::beautiful_path('../community/../gallery/'));
		$this->assertSame('https://example.com/gallery/', url::beautiful_path('https://example.com/community/../gallery/', true));
		$this->assertSame('string|false', (string) (new \ReflectionMethod(url::class, 'path'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(\phpbbgallery\core\auth\level::class, 'display'))->getReturnType());
	}

	private function image_row(int $image_id, string $filename): array
	{
		$row = array_fill_keys([
			'image_id', 'image_filename', 'image_name', 'image_name_clean', 'image_desc', 'image_desc_uid', 'image_desc_bitfield',
			'image_user_id', 'image_username', 'image_username_clean', 'image_user_colour', 'image_user_ip', 'image_time', 'image_album_id',
			'image_view_count', 'image_status', 'image_filemissing', 'image_rates', 'image_rate_points', 'image_rate_avg', 'image_comments',
			'image_last_comment', 'image_allow_comments', 'image_favorited', 'image_reported', 'filesize_upload', 'filesize_medium',
			'filesize_cache', 'album_name',
		], '');
		$row['image_id'] = $image_id;
		$row['image_filename'] = $filename;

		return $row;
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Cache test double belongs to this isolated infrastructure test.
final class infrastructure_cache_service extends \phpbb\cache\service
{
	public array $values;
	public array $destroyed = [];

	public function __construct(array $values = [])
	{
		$this->values = $values;
	}

	public function get(string $key): mixed
	{
		return $this->values[$key] ?? false;
	}

	public function put(string $key, mixed $value): void
	{
		$this->values[$key] = $value;
	}

	public function destroy(string $key, string $table = ''): void
	{
		$this->destroyed[] = $table === '' ? [$key] : [$key, $table];
		unset($this->values[$key]);
	}
}
