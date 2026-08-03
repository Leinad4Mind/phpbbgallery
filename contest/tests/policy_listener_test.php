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

	public function test_listener_enriches_only_contest_album_rows(): void
	{
		$manager = $this->createMock(manager::class);
		$manager->expects($this->once())
			->method('get_contest')
			->with(7, 'album', false)
			->willReturn([
				'contest_id' => 11,
				'contest_album_id' => 7,
				'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
			]);
		$listener = new policy_listener($manager);
		$contest = new \phpbb\event\data(['album_data' => [
			'album_id' => 7,
			'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
			'album_name' => 'Contest',
		]]);
		$regular = new \phpbb\event\data(['album_data' => [
			'album_id' => 8,
			'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
		]]);

		$listener->enrich_album_data($contest);
		$listener->enrich_album_data($regular);

		$this->assertSame(11, $contest['album_data']['contest_id']);
		$this->assertSame('Contest', $contest['album_data']['album_name']);
		$this->assertArrayNotHasKey('contest_id', $regular['album_data']);
	}

	public function test_listener_finalizes_only_expired_active_contests(): void
	{
		$manager = $this->createMock(manager::class);
		$manager->expects($this->once())
			->method('end')
			->with(7, 11, 1_300, 1_400)
			->willReturn(true);
		$listener = new policy_listener($manager);
		$expired = new \phpbb\event\data([
			'album_id' => 7,
			'now' => 1_400,
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_id' => 11,
				'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
				'contest_start' => 1_000,
				'contest_end' => 300,
			],
		]);
		$future = new \phpbb\event\data([
			'album_id' => 8,
			'now' => 1_400,
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_id' => 12,
				'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
				'contest_start' => 1_300,
				'contest_end' => 300,
			],
		]);

		$listener->finalize_expired_contest($expired);
		$listener->finalize_expired_contest($future);

		$this->assertSame(\phpbbgallery\core\block::NO_CONTEST, $expired['album_data']['contest_marked']);
		$this->assertSame(\phpbbgallery\core\block::IN_CONTEST, $future['album_data']['contest_marked']);
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

	public function test_listener_restricts_contest_operations_to_their_active_phase(): void
	{
		$listener = new policy_listener($this->manager(true));
		$album_data = [
			'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
			'contest_id' => 7,
			'contest_start' => time() - 100,
			'contest_rating' => 200,
			'contest_end' => 300,
		];
		$upload_event = new \phpbb\event\data([
			'operation' => 'upload',
			'album_data' => $album_data,
			'allowed' => true,
		]);
		$comment_event = new \phpbb\event\data([
			'operation' => 'comment',
			'album_data' => $album_data,
			'allowed' => true,
		]);

		$listener->restrict_album_operation($upload_event);
		$listener->restrict_album_operation($comment_event);

		$this->assertTrue($upload_event['allowed']);
		$this->assertFalse($comment_event['allowed']);
	}

	public function test_listener_marks_only_valid_contest_uploads(): void
	{
		$listener = new policy_listener($this->manager(true));
		$contest_event = new \phpbb\event\data([
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_id' => 7,
			],
			'additional_sql_data' => [],
		]);
		$regular_event = new \phpbb\event\data([
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_UPLOAD,
				'contest_id' => 7,
			],
			'additional_sql_data' => [],
		]);

		$listener->mark_contest_upload($contest_event);
		$listener->mark_contest_upload($regular_event);

		$this->assertSame(
			\phpbbgallery\core\block::IN_CONTEST,
			$contest_event['additional_sql_data']['image_contest']
		);
		$this->assertSame([], $regular_event['additional_sql_data']);
	}

	public function test_listener_preserves_completed_contest_move_semantics(): void
	{
		$listener = new policy_listener($this->manager(true));
		$completed = new \phpbb\event\data([
			'operation' => 'move_in',
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_id' => 7,
				'contest_marked' => \phpbbgallery\core\block::NO_CONTEST,
				'contest_start' => 100,
				'contest_rating' => 20,
				'contest_end' => 50,
			],
			'allowed' => true,
		]);
		$active_rating_phase = new \phpbb\event\data([
			'operation' => 'move_in',
			'album_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_id' => 8,
				'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
				'contest_start' => time() - 30,
				'contest_rating' => 20,
				'contest_end' => 100,
			],
			'allowed' => true,
		]);

		$listener->restrict_album_operation($completed);
		$listener->restrict_album_operation($active_rating_phase);

		$this->assertTrue($completed['allowed']);
		$this->assertFalse($active_rating_phase['allowed']);
	}

	public function test_listener_marks_moves_only_for_active_contests(): void
	{
		$listener = new policy_listener($this->manager(true));
		$active = new \phpbb\event\data([
			'target_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_marked' => \phpbbgallery\core\block::IN_CONTEST,
			],
			'image_move_data' => ['image_contest' => \phpbbgallery\core\block::NO_CONTEST],
		]);
		$completed = new \phpbb\event\data([
			'target_data' => [
				'album_type' => \phpbbgallery\core\block::TYPE_CONTEST,
				'contest_marked' => \phpbbgallery\core\block::NO_CONTEST,
			],
			'image_move_data' => ['image_contest' => \phpbbgallery\core\block::NO_CONTEST],
		]);

		$listener->prepare_image_move($active);
		$listener->prepare_image_move($completed);

		$this->assertSame(
			\phpbbgallery\core\block::IN_CONTEST,
			$active['image_move_data']['image_contest']
		);
		$this->assertSame(
			\phpbbgallery\core\block::NO_CONTEST,
			$completed['image_move_data']['image_contest']
		);
		$this->assertSame(0, $completed['image_move_data']['image_contest_end']);
		$this->assertSame(0, $completed['image_move_data']['image_contest_rank']);
	}

	public function test_listener_resyncs_results_only_for_relevant_image_changes(): void
	{
		$manager = $this->createMock(manager::class);
		$manager->expects($this->exactly(2))
			->method('resync_albums')
			->with([7]);
		$listener = new policy_listener($manager);

		$listener->resync_contest_results(new \phpbb\event\data([
			'operation' => 'approve',
			'image_rows' => [['image_contest_end' => 1_500]],
			'album_ids' => [7],
		]));
		$listener->resync_contest_results(new \phpbb\event\data([
			'operation' => 'delete',
			'image_rows' => [['image_contest_rank' => 1]],
			'album_ids' => [7],
		]));
		$listener->resync_contest_results(new \phpbb\event\data([
			'operation' => 'lock',
			'image_rows' => [['image_contest_end' => 0]],
			'album_ids' => [7],
		]));
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
