<?php
/**
 * phpBB Gallery Contest policy listener tests.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\contest\event\policy_listener;
use phpbbgallery\contest\manager;
use PHPUnit\Framework\TestCase;

final class policy_listener_test extends TestCase
{
	public function test_listener_registers_contest_album_type(): void
	{
		$listener = new policy_listener($this->manager(false));
		$event = new \phpbb\event\data(['types' => [], 'context' => []]);

		$listener->register_album_type($event);

		$types = (array) $event['types'];
		$type = $types[\phpbbgallery\core\block::TYPE_CONTEST];
		$this->assertSame('CONTEST', $type['lang']);
		$this->assertTrue($type['accepts_images']);
		$this->assertFalse($type['can_create']);
	}

	public function test_listener_applies_private_data_and_result_boundaries(): void
	{
		$listener = new policy_listener($this->manager(true));
		$image_data = [
			'image_contest' => \phpbbgallery\core\block::IN_CONTEST,
			'image_user_id' => 7,
		];
		$privacy_event = new \phpbb\event\data([
			'image_data' => $image_data,
			'viewer_id' => 8,
			'can_moderate' => false,
			'hidden' => false,
			'covered_markers' => [],
		]);
		$result_event = new \phpbb\event\data([
			'image_data' => $image_data,
			'can_moderate' => false,
			'hidden' => false,
			'covered_markers' => [],
		]);

		$listener->hide_private_data($privacy_event);
		$listener->hide_results($result_event);

		$this->assertTrue($privacy_event['hidden']);
		$this->assertTrue($result_event['hidden']);
	}

	public function test_listener_appends_parameterized_visibility_conditions(): void
	{
		$listener = new policy_listener($this->manager(true));
		$privacy_event = new \phpbb\event\data([
			'alias' => 'i',
			'viewer_id' => 8,
			'moderated_album_ids' => [5],
			'conditions' => ['i.image_status = 1'],
			'covered_markers' => [],
		]);
		$result_event = new \phpbb\event\data([
			'alias' => 'i',
			'moderated_album_ids' => [5],
			'conditions' => [],
			'covered_markers' => [],
		]);

		$listener->restrict_private_data_sql($privacy_event);
		$listener->restrict_results_sql($result_event);

		$this->assertSame('i.image_status = 1', $privacy_event['conditions'][0]);
		$this->assertStringContainsString('i.image_contest = 0', $privacy_event['conditions'][1]);
		$this->assertStringContainsString('i.image_user_id = 8', $privacy_event['conditions'][1]);
		$this->assertStringContainsString('i.image_album_id IN (5)', $privacy_event['conditions'][1]);
		$this->assertStringContainsString('i.image_contest = 0', $result_event['conditions'][0]);
		$this->assertStringNotContainsString('image_user_id', $result_event['conditions'][0]);
	}

	private function manager(bool $can_create): manager
	{
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->method('get')->with('allow_contests')->willReturn($can_create);

		return new manager(
			$this->createStub(\phpbb\db\driver\driver_interface::class),
			$config,
			'gallery_images',
			'gallery_contests'
		);
	}
}
