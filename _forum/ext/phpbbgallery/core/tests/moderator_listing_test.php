<?php
/**
 * phpBB Gallery - Moderator listing tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\album
{
	function get_username_string(string $mode, int $user_id, string $username, string $colour): string
	{
		return $mode . ':' . $user_id . ':' . $username . ':' . $colour;
	}
}

namespace phpbbgallery\core\tests
{
	use phpbbgallery\core\album\display;
	use PHPUnit\Framework\TestCase;

	final class moderator_listing_test extends TestCase
	{
		public function test_listing_uses_live_joined_names_and_false_selects_all_albums(): void
		{
			foreach ([
				'ANONYMOUS' => 1,
				'USERS_TABLE' => 'phpbb_users',
				'GROUPS_TABLE' => 'phpbb_groups',
				'GROUP_SPECIAL' => 3,
			] as $constant => $value)
			{
				if (!defined($constant))
				{
					define($constant, $value);
				}
			}

			$rows = [
				[
					'album_id' => 2,
					'user_id' => 7,
					'current_username' => 'Current user',
					'user_colour' => 'AABBCC',
					'group_id' => 0,
				],
				[
					'album_id' => 3,
					'user_id' => 0,
					'group_id' => 5,
					'current_group_name' => 'Current group',
					'group_colour' => '112233',
					'group_type' => 0,
				],
				[
					'album_id' => 4,
					'user_id' => 8,
					'current_username' => null,
					'user_colour' => '',
					'group_id' => 0,
				],
			];
			$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
			$db->expects($this->once())
				->method('sql_build_query')
				->with('SELECT', $this->callback(static function (array $query): bool
				{
					return str_contains($query['SELECT'], 'u.username AS current_username')
						&& str_contains($query['SELECT'], 'g.group_name AS current_group_name');
				}))
				->willReturn('SELECT moderators');
			$db->expects($this->once())->method('sql_query')->with('SELECT moderators', 3600)->willReturn('result');
			$db->expects($this->exactly(4))
				->method('sql_fetchrow')
				->with('result')
				->willReturnCallback(static function () use (&$rows): array|false
				{
					return array_shift($rows) ?: false;
				});
			$db->expects($this->once())->method('sql_freeresult')->with('result');
			$user = new \phpbb\user();
			$user->data = ['user_id' => 99];
			$auth = $this->createMock(\phpbb\auth\auth::class);
			$auth->expects($this->once())->method('acl_get')->with('u_viewprofile')->willReturn(false);

			$display = (new \ReflectionClass(display::class))->newInstanceWithoutConstructor();
			$this->set_property($display, 'db', $db);
			$this->set_property($display, 'table_moderators', 'gallery_modscache');
			$this->set_property($display, 'language', $this->createStub(\phpbb\language\language::class));
			$this->set_property($display, 'user', $user);
			$this->set_property($display, 'auth', $auth);
			$this->set_property($display, 'root_path', './');
			$this->set_property($display, 'php_ext', 'php');

			$moderators = $display->get_moderators(false);

			$this->assertSame('full:7:Current user:AABBCC', $moderators[2][0]);
			$this->assertStringContainsString('Current group', $moderators[3][0]);
			$this->assertStringContainsString('#112233', $moderators[3][0]);
			$this->assertArrayNotHasKey(4, $moderators);
		}

		private function set_property(object $object, string $property, mixed $value): void
		{
			$reflection = new \ReflectionProperty($object, $property);
			$reflection->setValue($object, $value);
		}
	}
}
