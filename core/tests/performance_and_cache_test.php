<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;
use phpbb\request\request_interface;
use phpbbgallery\core\file\file as file_tool;
use phpbbgallery\core\migrations\performance_indexes;

class performance_and_cache_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	protected function setUp(): void
	{
		$this->load_subjects();
	}

	public function test_performance_migration_adds_targeted_compound_indexes(): void
	{
		$migration = (new \ReflectionClass(performance_indexes::class))->newInstanceWithoutConstructor();
		$set_prefix = \Closure::bind(function (): void
		{
			$this->table_prefix = 'phpbb_';
		}, $migration, performance_indexes::class);
		$set_prefix();

		$this->assertSame(
			['\phpbbgallery\core\migrations\resumable_uploads'],
			performance_indexes::depends_on()
		);
		$this->assertSame(
			[
				'add_index' => [
					'phpbb_gallery_images' => [
						'album_status_time' => ['image_album_id', 'image_status', 'image_time'],
					],
					'phpbb_gallery_reports' => [
						'image_status' => ['report_image_id', 'report_status'],
						'album_status' => ['report_album_id', 'report_status'],
					],
				],
			],
			$migration->update_schema()
		);
		$this->assertSame(
			[
				'drop_keys' => [
					'phpbb_gallery_images' => ['album_status_time'],
					'phpbb_gallery_reports' => ['image_status', 'album_status'],
				],
			],
			$migration->revert_schema()
		);

		foreach (['album_status_time', 'image_status', 'album_status'] as $index_name)
		{
			$this->assertLessThanOrEqual(24, strlen($index_name));
		}
	}

	public function test_conditional_cache_returns_not_modified_for_a_current_validator(): void
	{
		$last_modified = 1700000000;
		$tool = $this->create_file_tool([
			'REQUEST_METHOD' => 'GET',
			'HTTP_IF_MODIFIED_SINCE' => gmdate('D, d M Y H:i:s', $last_modified) . ' GMT',
		]);
		$tool->set_last_modified($last_modified - 10);
		$tool->set_last_modified($last_modified);
		$response = $this->create_response();

		$this->assertSame($response, $tool->apply_browser_cache($response));
		$this->assertSame(304, $response->status_code);
		$this->assertSame($last_modified, $response->last_modified->getTimestamp());
		$this->assertTrue($response->headers->directives['private']);
		$this->assertTrue($response->headers->directives['must-revalidate']);
		$this->assertSame(0, $response->headers->directives['max-age']);
		$this->assertArrayNotHasKey('pragma', $response->headers->values);
	}

	public function test_conditional_cache_sends_content_when_the_validator_is_stale(): void
	{
		$last_modified = 1700000000;
		$tool = $this->create_file_tool([
			'REQUEST_METHOD' => 'GET',
			'HTTP_IF_MODIFIED_SINCE' => gmdate('D, d M Y H:i:s', $last_modified - 1) . ' GMT',
		]);
		$tool->set_last_modified($last_modified);
		$response = $this->create_response();

		$tool->apply_browser_cache($response);

		$this->assertSame(200, $response->status_code);
		$this->assertSame($last_modified, $response->last_modified->getTimestamp());
	}

	public function test_disabled_browser_cache_prevents_storage_and_conditional_reuse(): void
	{
		$last_modified = 1700000000;
		$tool = $this->create_file_tool([
			'REQUEST_METHOD' => 'GET',
			'HTTP_IF_MODIFIED_SINCE' => gmdate('D, d M Y H:i:s', $last_modified) . ' GMT',
		]);
		$tool->set_last_modified($last_modified);
		$tool->disable_browser_cache();
		$response = $this->create_response();

		$tool->apply_browser_cache($response);

		$this->assertSame(200, $response->status_code);
		$this->assertNull($response->last_modified);
		$this->assertSame('private, no-store, no-cache, must-revalidate', $response->headers->values['cache-control']);
		$this->assertSame('no-cache', $response->headers->values['pragma']);
		$this->assertSame('0', $response->headers->values['expires']);
	}

	public function test_binary_requests_do_not_increment_the_page_view_counter(): void
	{
		$file_controller = file_get_contents(dirname(__DIR__) . '/controller/file.php');
		$image_controller = file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$image_service = file_get_contents(dirname(__DIR__) . '/image/image.php');

		$this->assertStringNotContainsString('image_view_count = image_view_count + 1', $file_controller);
		$this->assertStringContainsString('image_view_count = image_view_count + 1', $image_controller);
		$this->assertStringContainsString("if (!\$this->user->data['is_bot']", $image_controller);
		$this->assertStringContainsString("\$medium_url = \$this->url->show_image(\$image_id, 'medium');", $image_service);
		$this->assertStringContainsString('modified_time($this->storage_variant', $file_controller);
		$this->assertStringContainsString('@filemtime($this->tool->image_source)', $file_controller);
		$this->assertStringContainsString('apply_browser_cache($response)', $file_controller);
		$this->assertStringNotContainsString("set('Pragma', 'public')", $file_controller);
	}

	/**
	 * @param array $server
	 * @return file_tool
	 */
	private function create_file_tool(array $server)
	{
		$tool = (new \ReflectionClass(file_tool::class))->newInstanceWithoutConstructor();
		$request = $this->createStub(request_interface::class);
		$request->method('server')->willReturnCallback(
			static fn (string $name, mixed $default = ''): mixed => $server[$name] ?? $default
		);
		(new \ReflectionProperty(file_tool::class, 'request'))->setValue($tool, $request);

		return $tool;
	}

	/**
	 * @return object
	 */
	private function create_response()
	{
		// phpcs:disable PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Test double mirrors Symfony's public API.
		$response = new class {
			/** @var object */
			public $headers;

			/** @var \DateTime|null */
			public $last_modified;

			/** @var int */
			public $status_code = 200;

			public function __construct()
			{
				$this->headers = new class {
					/** @var array */
					public $directives = [];

					/** @var array */
					public $values = [];

					public function addCacheControlDirective($name, $value = true): void
					{
						$this->directives[$name] = $value;
					}

					public function remove($name): void
					{
						unset($this->values[strtolower($name)]);
					}

					public function set($name, $value): void
					{
						$this->values[strtolower($name)] = $value;
					}
				};
			}

			public function setLastModified(\DateTime $last_modified)
			{
				$this->last_modified = $last_modified;

				return $this;
			}

			public function setMaxAge($max_age)
			{
				$this->headers->addCacheControlDirective('max-age', $max_age);

				return $this;
			}

			public function setNotModified()
			{
				$this->status_code = 304;

				return $this;
			}

			public function setPrivate()
			{
				$this->headers->addCacheControlDirective('private');

				return $this;
			}
		};
		// phpcs:enable

		return $response;
	}

	private function load_subjects(): void
	{
		if (!class_exists(file_tool::class))
		{
			require_once dirname(__DIR__) . '/file/file.php';
		}
		if (class_exists(performance_indexes::class))
		{
			return;
		}

		$phpbb_root = dirname(__DIR__, 4);
		if (!interface_exists('phpbb\db\migration\migration_interface'))
		{
			require_once $phpbb_root . '/phpbb/db/migration/migration_interface.php';
		}
		if (!class_exists('phpbb\db\migration\migration'))
		{
			require_once $phpbb_root . '/phpbb/db/migration/migration.php';
		}
		require_once dirname(__DIR__) . '/migrations/performance_indexes.php';
	}
}
