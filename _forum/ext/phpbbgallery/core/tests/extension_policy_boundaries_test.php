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
use phpbbgallery\core\policy\album_operation;
use phpbbgallery\core\policy\image_visibility;
use PHPUnit\Framework\TestCase;

final class extension_policy_boundaries_test extends TestCase
{
	public function test_services_register_the_extension_boundaries(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString('phpbbgallery.core.album.type_registry:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\album\\type_registry', $services);
		$this->assertStringContainsString('phpbbgallery.core.policy.image_visibility:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\policy\\image_visibility', $services);
		$this->assertStringContainsString('phpbbgallery.core.policy.album_operation:', $services);
		$this->assertStringContainsString('class: phpbbgallery\\core\\policy\\album_operation', $services);
		$this->assertStringNotContainsString('legacy_contest_policy_listener', $services);

		$comment_service = strstr($services, 'phpbbgallery.core.comment:');
		$comment_service = strstr($comment_service, 'phpbbgallery.core.url:', true);
		$rating_service = strstr($services, 'phpbbgallery.core.rating:');
		$rating_service = strstr($rating_service, '#### Define event', true);
		$this->assertStringContainsString("- '@phpbbgallery.core.policy.album_operation'", $comment_service);
		$this->assertStringContainsString("- '@phpbbgallery.core.policy.album_operation'", $rating_service);
		$this->assertStringContainsString("- '@phpbbgallery.core.policy.image_visibility'", $rating_service);
	}

	public function test_album_operation_combines_type_capabilities_and_addon_rules(): void
	{
		$dispatcher = $this->dispatcher(static function (string $event_name, array $data): array
		{
			if ($event_name === 'phpbbgallery.core.album.types')
			{
				$data['types'][2] = [
					'lang' => 'CONTEST',
					'accepts_images' => true,
					'can_create' => true,
				];
			}
			else if ($event_name === 'phpbbgallery.core.album_operation'
				&& (int) $data['album_data']['album_type'] === 2)
			{
				$data['allowed'] = false;
			}

			return $data;
		});
		$policy = new album_operation($dispatcher, new type_registry($dispatcher));

		$this->assertTrue($policy->allows('upload', ['album_type' => \phpbbgallery\core\block::TYPE_UPLOAD]));
		$this->assertFalse($policy->allows('upload', ['album_type' => \phpbbgallery\core\block::TYPE_CAT]));
		$this->assertTrue($policy->allows('move_in', ['album_type' => \phpbbgallery\core\block::TYPE_UPLOAD]));
		$this->assertFalse($policy->allows('move_in', ['album_type' => \phpbbgallery\core\block::TYPE_CAT]));
		$this->assertFalse($policy->allows('upload', ['album_type' => 2]));
		$this->assertFalse($policy->allows('upload', ['album_type' => 99]));
	}

	public function test_album_operation_rejects_an_empty_operation(): void
	{
		$dispatcher = $this->dispatcher(
			static fn(string $event_name, array $data): array => $data
		);
		$policy = new album_operation($dispatcher, new type_registry($dispatcher));

		$this->expectException(\InvalidArgumentException::class);
		$policy->allows(' ', ['album_type' => \phpbbgallery\core\block::TYPE_UPLOAD]);
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
				$data['covered_markers'][] = 'image_contest';
			break;

			case 'phpbbgallery.core.image_visibility.private_data_label':
				$data['label'] = 'Extension participant';
			break;

			case 'phpbbgallery.core.image_visibility.private_data_description':
				$data['description'] = 'Extension description';
			break;

			case 'phpbbgallery.core.image_visibility.hidden_results_message':
				$data['message'] = 'Extension results hidden';
			break;

			case 'phpbbgallery.core.image_visibility.restricted_sort_keys':
				$data['sort_keys'] = ['u', 'ra', 'u', ''];
			break;

			case 'phpbbgallery.core.image_visibility.award':
				$data['rank'] = 2;
				$data['label'] = 'Second place';
				$data['title'] = 'Award';
			break;

				case 'phpbbgallery.core.image_visibility.private_data_sql':
					$data['conditions'][] = 'i.private_allowed = 1';
					$data['conditions'][] = 'i.embargo_ended = 1';
					$data['covered_markers'][] = 'image_contest';
				break;

				case 'phpbbgallery.core.image_visibility.results_sql':
					$data['conditions'][] = 'i.results_visible = 1';
					$data['covered_markers'][] = 'image_contest';
				break;

				default:
				break;
			}

			return $data;
		});
		$policy = new image_visibility($dispatcher);

		$this->assertTrue($policy->hides_private_data(['image_id' => 7], 2, false));
		$this->assertSame('Extension participant', $policy->private_data_label(['image_id' => 7], 2, false, 'Hidden user'));
		$this->assertSame('Extension description', $policy->private_data_description(['image_id' => 7], ['album_id' => 3], 2, false, 'Hidden description'));
		$this->assertTrue($policy->hides_results(['image_id' => 7], false));
		$this->assertSame('Extension results hidden', $policy->hidden_results_message(['image_id' => 7], ['album_id' => 3], false, true, 'Results hidden'));
		$this->assertSame(['u', 'ra'], $policy->restricted_sort_keys(['album_id' => 3], false));
		$this->assertSame([
			'rank' => 2,
			'label' => 'Second place',
			'title' => 'Award',
		], $policy->award(['image_id' => 7]));
		$this->assertSame(
			'(i.private_allowed = 1) AND (i.embargo_ended = 1)',
			$policy->private_data_sql('i', 2, [3])
		);
		$this->assertSame('(i.results_visible = 1)', $policy->results_sql('i', [3]));
		$this->assertSame('li.image_contest AS last_image_visibility_marker', $policy->projection_sql('li', 'last_image_visibility_marker'));
		$this->assertSame([
			'image_user_id' => 7,
			'image_contest' => 1,
		], $policy->projected_data(['last_image_visibility_marker' => 1], 'last_image_visibility_marker', ['image_user_id' => 7]));
	}

	public function test_visibility_policy_is_open_without_providers_and_rejects_invalid_aliases(): void
	{
		$policy = new image_visibility($this->dispatcher(
			static fn(string $event_name, array $data): array => $data
		));

		$this->assertFalse($policy->hides_private_data([], 2, false));
		$this->assertFalse($policy->hides_results([], false));
		$this->assertSame([], $policy->restricted_sort_keys([], false));
		$this->assertSame(['rank' => 0, 'label' => '', 'title' => ''], $policy->award([]));
		$this->assertSame('Hidden user', $policy->private_data_label([], 2, false, 'Hidden user'));
		$this->assertSame('Hidden description', $policy->private_data_description([], [], 2, false, 'Hidden description'));
		$this->assertSame('Results hidden', $policy->hidden_results_message([], [], false, true, 'Results hidden'));
		$this->assertSame('(image_contest = 0)', $policy->private_data_sql('', 2, []));
		$this->assertSame('(image_alias.image_contest = 0)', $policy->results_sql('image_alias', []));

		$this->expectException(\InvalidArgumentException::class);
		$policy->private_data_sql('i; DROP TABLE images', 2, []);
	}

	public function test_visibility_policy_requires_a_safe_projection_alias(): void
	{
		$policy = new image_visibility($this->dispatcher(
			static fn(string $event_name, array $data): array => $data
		));

		$this->expectException(\InvalidArgumentException::class);
		$policy->projection_sql('i', '');
	}

	public function test_visibility_policy_fails_closed_for_unowned_persisted_markers(): void
	{
		$policy = new image_visibility($this->dispatcher(
			static fn(string $event_name, array $data): array => $data
		));
		$active = ['image_contest' => \phpbbgallery\core\block::IN_CONTEST];

		$this->assertTrue($policy->hides_private_data($active, 7, true));
		$this->assertTrue($policy->hides_results($active, true));
		$this->assertFalse($policy->hides_private_data(['image_contest' => 0], 7, false));
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
