<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

use PHPUnit\Framework\TestCase;
use phpbbgallery\export\archive;

require_once __DIR__ . '/fake_export.php';

class album_segments_test extends TestCase
{
	private fake_export $export;

	protected function setUp(): void
	{
		$this->export = new fake_export();
	}

	private function albums(): array
	{
		return [
			1 => ['album_id' => 1, 'parent_id' => 0, 'album_name' => 'Capas de Animação Oriental', 'album_user_id' => 0],
			2 => ['album_id' => 2, 'parent_id' => 1, 'album_name' => 'Subalbum', 'album_user_id' => 0],
			3 => ['album_id' => 3, 'parent_id' => 2, 'album_name' => 'Deeper', 'album_user_id' => 0],
			9 => ['album_id' => 9, 'parent_id' => 0, 'album_name' => 'My album', 'album_user_id' => 5],
		];
	}

	public function test_a_root_album_is_one_segment(): void
	{
		self::assertSame(['Capas de Animação Oriental'], $this->export->album_segments(1, $this->albums()));
	}

	public function test_a_subalbum_carries_its_parents(): void
	{
		self::assertSame(['Capas de Animação Oriental', 'Subalbum'], $this->export->album_segments(2, $this->albums()));
		self::assertSame(['Capas de Animação Oriental', 'Subalbum', 'Deeper'], $this->export->album_segments(3, $this->albums()));
	}

	public function test_personal_albums_are_grouped_under_their_owner(): void
	{
		self::assertSame(
			[archive::PERSONAL_ROOT, 'Leinad4Mind', 'My album'],
			$this->export->album_segments(9, $this->albums(), 'Leinad4Mind')
		);
	}

	public function test_a_personal_album_without_a_known_owner_falls_back_to_the_user_id(): void
	{
		self::assertSame(
			[archive::PERSONAL_ROOT, 'user_5', 'My album'],
			$this->export->album_segments(9, $this->albums())
		);
	}

	public function test_an_unknown_album_still_produces_a_folder(): void
	{
		self::assertSame(['album_404'], $this->export->album_segments(404, $this->albums()));
	}

	public function test_a_broken_parent_chain_does_not_loop_forever(): void
	{
		$albums = [
			1 => ['album_id' => 1, 'parent_id' => 2, 'album_name' => 'One', 'album_user_id' => 0],
			2 => ['album_id' => 2, 'parent_id' => 1, 'album_name' => 'Two', 'album_user_id' => 0],
		];

		self::assertSame(['Two', 'One'], $this->export->album_segments(1, $albums));
	}
}
