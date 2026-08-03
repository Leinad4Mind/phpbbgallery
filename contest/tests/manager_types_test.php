<?php
/**
 * phpBB Gallery - Core contest domain tests
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\contest\tests;

use phpbbgallery\core\block;
use phpbbgallery\core\config as gallery_config;
use phpbbgallery\contest\manager as contest;
use PHPUnit\Framework\TestCase;

final class manager_types_test extends TestCase
{
	public function test_owned_persisted_values_match_legacy_core_aliases(): void
	{
		$this->assertSame(2, contest::ALBUM_TYPE);
		$this->assertSame(0, contest::STATE_INACTIVE);
		$this->assertSame(1, contest::STATE_ACTIVE);
		$this->assertSame(block::TYPE_CONTEST, contest::ALBUM_TYPE);
		$this->assertSame(block::NO_CONTEST, contest::STATE_INACTIVE);
		$this->assertSame(block::IN_CONTEST, contest::STATE_ACTIVE);
	}

	public function test_contest_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(contest::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === contest::class)
			{
				$this->assertNotNull($property->getType(), contest::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== contest::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), contest::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), contest::class . '::' . $method->getName() . '()');
			}
		}

		$this->assertSame(contest::MODE_AVERAGE, contest::$mode);
	}

	public function test_contest_creation_switch_does_not_disable_existing_runtime_rules(): void
	{
		$config = $this->createMock(gallery_config::class);
		$config->expects($this->once())->method('get')->with('allow_contests')->willReturn(false);
		$contest = new contest(
			$this->createStub(\phpbb\db\driver\driver_interface::class),
			$config,
			'gallery_images',
			'gallery_contests'
		);

		$this->assertFalse($contest->can_create());
		$this->assertTrue(contest::is_step('upload', ['album_type' => block::TYPE_UPLOAD], 100));
	}

	public function test_regular_albums_are_not_restricted_by_contest_phases(): void
	{
		$album_data = ['album_type' => block::TYPE_UPLOAD, 'contest_id' => 0];

		$this->assertTrue(contest::is_step('upload', $album_data, 100));
		$this->assertTrue(contest::is_step('rate', $album_data, 100));
		$this->assertTrue(contest::is_step('comment', $album_data, 100));
		$this->assertFalse(contest::is_step('unknown', $album_data, 100));
	}

	public function test_contest_phase_boundaries_are_explicit_and_contiguous(): void
	{
		$album_data = [
			'album_type' => contest::ALBUM_TYPE,
			'contest_id' => 7,
			'contest_start' => 100,
			'contest_rating' => 20,
			'contest_end' => 50,
		];

		$this->assertFalse(contest::is_step('upload', $album_data, 99));
		$this->assertTrue(contest::is_step('upload', $album_data, 100));
		$this->assertTrue(contest::is_step('upload', $album_data, 119));
		$this->assertFalse(contest::is_step('upload', $album_data, 120));

		$this->assertFalse(contest::is_step('rate', $album_data, 119));
		$this->assertTrue(contest::is_step('rate', $album_data, 120));
		$this->assertTrue(contest::is_step('rate', $album_data, 149));
		$this->assertFalse(contest::is_step('rate', $album_data, 150));

		$this->assertFalse(contest::is_step('comment', $album_data, 149));
		$this->assertTrue(contest::is_step('comment', $album_data, 150));
	}

	public function test_broken_contest_configuration_fails_closed(): void
	{
		$missing_row = ['album_type' => contest::ALBUM_TYPE, 'contest_id' => 0];
		$incomplete_row = ['album_type' => contest::ALBUM_TYPE, 'contest_id' => 7];
		$invalid_window = [
			'album_type' => contest::ALBUM_TYPE,
			'contest_id' => 7,
			'contest_start' => 100,
			'contest_rating' => 60,
			'contest_end' => 50,
		];

		foreach (['upload', 'rate', 'comment'] as $mode)
		{
			$this->assertFalse(contest::is_step($mode, $missing_row, 100));
			$this->assertFalse(contest::is_step($mode, $incomplete_row, 100));
			$this->assertFalse(contest::is_step($mode, $invalid_window, 100));
		}
	}

	public function test_active_contest_privacy_preserves_only_registered_owner_and_moderator_exceptions(): void
	{
		$active = [
			'image_contest' => contest::STATE_ACTIVE,
			'image_user_id' => 7,
		];

		$this->assertTrue(contest::is_active_image($active));
		$this->assertTrue(contest::hides_private_data($active, 8, false));
		$this->assertFalse(contest::hides_private_data($active, 7, false));
		$this->assertFalse(contest::hides_private_data($active, 8, true));
		$this->assertFalse(contest::hides_private_data([
			'image_contest' => contest::STATE_INACTIVE,
			'image_user_id' => 7,
		], 8, false));
	}

	public function test_anonymous_contest_entry_never_receives_owner_exception(): void
	{
		$anonymous_id = defined('ANONYMOUS') ? (int) constant('ANONYMOUS') : 1;

		$this->assertTrue(contest::hides_private_data([
			'image_contest' => contest::STATE_ACTIVE,
			'image_user_id' => $anonymous_id,
		], $anonymous_id, false));
	}

	public function test_active_contest_results_are_visible_only_to_moderators(): void
	{
		$active = ['image_contest' => contest::STATE_ACTIVE];

		$this->assertTrue(contest::hides_results($active, false));
		$this->assertFalse(contest::hides_results($active, true));
		$this->assertFalse(contest::hides_results(['image_contest' => contest::STATE_INACTIVE], false));
		$this->assertFalse(contest::is_active_image([]));
	}

	public function test_sql_privacy_boundaries_match_identity_and_result_exceptions(): void
	{
		$this->assertSame(
			'(i.image_contest = 0 OR i.image_user_id = 7 OR i.image_album_id IN (9, 4))',
			contest::private_data_visibility_sql('i', 7, [0, 9, 4, 9, -1])
		);
		$this->assertSame(
			'(i.image_contest = 0 OR i.image_album_id IN (9, 4))',
			contest::results_visibility_sql('i', [0, 9, 4, 9, -1])
		);
	}

	public function test_anonymous_sql_privacy_has_no_owner_exception(): void
	{
		$anonymous_id = defined('ANONYMOUS') ? (int) constant('ANONYMOUS') : 1;

		$this->assertSame(
			'(image_contest = 0)',
			contest::private_data_visibility_sql('', $anonymous_id, [])
		);
		$this->assertSame('(image_contest = 0)', contest::results_visibility_sql('', []));
	}

	public function test_sql_privacy_rejects_untrusted_aliases(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		contest::private_data_visibility_sql('i; DROP TABLE gallery_images', 7, []);
	}

	public function test_missing_contest_returns_false_and_releases_the_result(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query_limit')
			->with($this->stringContains('contest_album_id = 17'), 1)
			->willReturn('result');
		$db->expects($this->once())
			->method('sql_fetchrow')
			->with('result')
			->willReturn(false);
		$db->expects($this->once())
			->method('sql_freeresult')
			->with('result');

		$this->assertFalse($this->contest($db)->get_contest(17, 'album', false));
	}

	public function test_invalid_tabulation_mode_falls_back_to_average_order(): void
	{
		$contest = $this->contest($this->createStub(\phpbb\db\driver\driver_interface::class));
		$method = new \ReflectionMethod(contest::class, 'get_tabulation');
		$previous_mode = contest::$mode;

		try
		{
			contest::$mode = 999;
			$this->assertSame(
				'image_rate_avg DESC, image_rate_points DESC, image_id ASC',
				$method->invoke($contest)
			);
		}
		finally
		{
			contest::$mode = $previous_mode;
		}
	}

	private function contest(\phpbb\db\driver\driver_interface $db): contest
	{
		return new contest(
			$db,
			new gallery_config(new \phpbb\config\config([])),
			'gallery_images',
			'gallery_contests'
		);
	}
}
