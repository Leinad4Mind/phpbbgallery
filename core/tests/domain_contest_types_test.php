<?php
/**
 * phpBB Gallery - Core contest domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\config as gallery_config;
use phpbbgallery\core\contest;
use PHPUnit\Framework\TestCase;

final class domain_contest_types_test extends TestCase
{
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

	public function test_contest_steps_use_explicit_time_windows_and_reject_unknown_modes(): void
	{
		$contest = $this->contest($this->createStub(\phpbb\db\driver\driver_interface::class));
		$current_time = time();

		$this->assertTrue($contest->is_step('upload', [
			'contest_id' => 1,
			'contest_start' => $current_time - 10,
			'contest_rating' => 60,
			'contest_end' => 120,
		]));
		$this->assertTrue($contest->is_step('rate', [
			'contest_id' => 1,
			'contest_start' => $current_time - 100,
			'contest_rating' => 10,
			'contest_end' => 200,
		]));
		$this->assertTrue($contest->is_step('comment', [
			'contest_id' => 1,
			'contest_start' => $current_time - 300,
			'contest_rating' => 10,
			'contest_end' => 200,
		]));
		$this->assertFalse($contest->is_step('unknown', [
			'contest_id' => 0,
			'contest_start' => 0,
			'contest_rating' => 0,
			'contest_end' => 0,
		]));
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
