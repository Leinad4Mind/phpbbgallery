<?php
/**
 * phpBB Gallery extension policy boundary tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\type_registry;
use phpbbgallery\core\event\legacy_contest_policy_listener;
use phpbbgallery\core\policy\image_visibility;
use PHPUnit\Framework\TestCase;

final class extension_policy_boundaries_test extends TestCase
{
	public function test_services_register_the_boundaries_and_legacy_provider(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.album.type_registry:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\album\\type_registry', $services);
		$this->assertStringContainsString('phpbbgallery.core.policy.image_visibility:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\policy\\image_visibility', $services);
		$this->assertStringContainsString('phpbbgallery.core.legacy_contest_policy_listener:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\event\\legacy_contest_policy_listener', $services);
		$this->assertStringContainsString('- { name: event.listener }', $services);
	}

	public function test_album_registry_keeps_core_types_and_normalizes_extensions(): void
	{
		$dispatcher = $this->dispatcher(static function (string $event_name, array $data): array
		{
			if ($event_name === 'phpbbgallery.core.album.types')
			{
				$data['types'][2] = [
					'lang' => 'CONTEST',
					'accepts_images' => true,
					'can_create' => false,
				];
				$data['types']['invalid'] = ['lang' => 'INVALID'];
			}

			return $data;
		});
		$registry = new type_registry($dispatcher);
		$types = $registry->get_types();

		$this->assertSame([0, 1, 2], array_keys($types));
		$this->assertFalse($types[0]['accepts_images']);
		$this->assertTrue($types[1]['accepts_images']);
		$this->assertSame('CONTEST', $types[2]['lang']);
		$this->assertFalse($types[2]['can_create']);
		$this->assertTrue($registry->is_available(2));
		$this->assertTrue($registry->accepts_images(2));
		$this->assertFalse($registry->is_available(99));
	}

	public function test_visibility_policy_combines_independent_restrictions(): void
	{
		$dispatcher = $this->dispatcher(static function (string $event_name, array $data): array
		{
			switch ($event_name)
			{
				case 'phpbbgallery.core.image_visibility.private_data':
				case 'phpbbgallery.core.image_visibility.results':
					$data['hidden'] = true;
				break;

				case 'phpbbgallery.core.image_visibility.private_data_sql':
					$data['conditions'][] = 'i.private_allowed = 1';
					$data['conditions'][] = 'i.embargo_ended = 1';
				break;

				case 'phpbbgallery.core.image_visibility.results_sql':
					$data['conditions'][] = 'i.results_visible = 1';
				break;

				default:
				break;
			}

			return $data;
		});
		$policy = new image_visibility($dispatcher);

		$this->assertTrue($policy->hides_private_data(['image_id' => 7], 2, false));
		$this->assertTrue($policy->hides_results(['image_id' => 7], false));
		$this->assertSame(
			'(i.private_allowed = 1) AND (i.embargo_ended = 1)',
			$policy->private_data_sql('i', 2, [3])
		);
		$this->assertSame('(i.results_visible = 1)', $policy->results_sql('i', [3]));
	}

	public function test_visibility_policy_is_open_without_providers_and_rejects_invalid_aliases(): void
	{
		$policy = new image_visibility($this->dispatcher(
			static fn(string $event_name, array $data): array => $data
		));

		$this->assertFalse($policy->hides_private_data([], 2, false));
		$this->assertFalse($policy->hides_results([], false));
		$this->assertSame('1 = 1', $policy->private_data_sql('', 2, []));
		$this->assertSame('1 = 1', $policy->results_sql('image_alias', []));

		$this->expectException(\InvalidArgumentException::class);
		$policy->private_data_sql('i; DROP TABLE images', 2, []);
	}

	public function test_legacy_bridge_preserves_contest_registration_and_privacy(): void
	{
		$config = new \phpbb\config\config(['phpbb_gallery_allow_contests' => 0]);
		$gallery_config = new \phpbbgallery\core\config($config);
		$contest = new \phpbbgallery\core\contest(
			$this->createStub(\phpbb\db\driver\driver_interface::class),
			$gallery_config,
			'gallery_images',
			'gallery_contests'
		);
		$listener = new legacy_contest_policy_listener($contest);

		$type_event = new \phpbb\event\data(['types' => [], 'context' => []]);
		$listener->register_album_type($type_event);
		$types = (array) $type_event['types'];
		$this->assertSame('CONTEST', $types[\phpbbgallery\core\block::TYPE_CONTEST]['lang']);
		$this->assertTrue($types[\phpbbgallery\core\block::TYPE_CONTEST]['accepts_images']);
		$this->assertFalse($types[\phpbbgallery\core\block::TYPE_CONTEST]['can_create']);

		$privacy_event = new \phpbb\event\data([
			'image_data' => [
				'image_contest' => \phpbbgallery\core\block::IN_CONTEST,
				'image_user_id' => 7,
			],
			'viewer_id' => 8,
			'can_moderate' => false,
			'hidden' => false,
		]);
		$listener->hide_private_data($privacy_event);
		$this->assertTrue($privacy_event['hidden']);

		$sql_event = new \phpbb\event\data([
			'alias' => 'i',
			'viewer_id' => 8,
			'moderated_album_ids' => [5],
			'conditions' => [],
		]);
		$listener->restrict_private_data_sql($sql_event);
		$this->assertStringContainsString('i.image_contest = 0', $sql_event['conditions'][0]);
		$this->assertStringContainsString('i.image_album_id IN (5)', $sql_event['conditions'][0]);
	}

	private function dispatcher(callable $callback): \phpbb\event\dispatcher_interface
	{
		return new class($callback) implements \phpbb\event\dispatcher_interface
		{
			private $callback;

			public function __construct(callable $callback)
			{
				$this->callback = $callback;
			}

			public function trigger_event($event_name, $data = [])
			{
				return ($this->callback)((string) $event_name, (array) $data);
			}
		};
	}
}
