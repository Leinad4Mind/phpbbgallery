<?php
/**
 * phpBB Gallery - personal album nested-set regression tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\ucp
{
	/**
	 * Isolated form-key stub for exercising the UCP method in unit tests.
	 */
	function check_form_key(string $form_name, int|false $timespan = false): bool
	{
		return $form_name === 'ucp_gallery';
	}

	/**
	 * Isolated text-storage stub for the album description fields.
	 */
	function generate_text_for_storage(
		mixed &$text,
		mixed &$uid,
		mixed &$bitfield,
		mixed &$flags,
		bool $allow_bbcode = false,
		bool $allow_urls = false,
		bool $allow_smilies = false
	): void
	{
		$uid = '';
		$bitfield = '';
	}

	/**
	 * Convert the UCP success message into a catchable test boundary.
	 */
	function trigger_error(mixed $message, int $error_level = E_USER_NOTICE): never
	{
		throw new \RuntimeException((string) $message, $error_level);
	}
}

namespace phpbbgallery\core\tests
{
	use PDO;
	use phpbbgallery\core\album\album;
	use phpbbgallery\core\album\display;
	use phpbbgallery\core\album\manage;
	use phpbbgallery\core\auth\auth;
	use phpbbgallery\core\ucp\main_module;
	use phpbbgallery\core\user as gallery_user;
	use PHPUnit\Framework\TestCase;

	final class personal_album_reparenting_test extends TestCase
	{
		private PDO $pdo;

		private function set_up_database(): void
		{
			$this->pdo = new PDO('sqlite::memory:');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->pdo->exec('CREATE TABLE gallery_albums (
				album_id INTEGER PRIMARY KEY,
				parent_id INTEGER NOT NULL,
				left_id INTEGER NOT NULL,
				right_id INTEGER NOT NULL,
				album_user_id INTEGER NOT NULL,
				album_name TEXT NOT NULL,
				album_desc TEXT NOT NULL DEFAULT \'\',
				album_desc_uid TEXT NOT NULL DEFAULT \'\',
				album_desc_bitfield TEXT NOT NULL DEFAULT \'\',
				album_desc_options INTEGER NOT NULL DEFAULT 7,
				album_type INTEGER NOT NULL DEFAULT 1,
				album_auth_access INTEGER NOT NULL DEFAULT 0,
				album_parents TEXT NOT NULL DEFAULT \'\'
			)');

			foreach ([
				[1, 0, 1, 10, 7, 'Owner root'],
				[2, 1, 2, 7, 7, 'Parent album'],
				[3, 2, 3, 6, 7, 'Album moved back to root'],
				[4, 3, 4, 5, 7, 'Moved descendant'],
				[5, 1, 8, 9, 7, 'Root sibling'],
				[10, 0, 1, 4, 8, 'Other owner root'],
				[11, 10, 2, 3, 8, 'Other owner child'],
			] as $row)
			{
				$statement = $this->pdo->prepare('INSERT INTO gallery_albums
					(album_id, parent_id, left_id, right_id, album_user_id, album_name)
					VALUES (?, ?, ?, ?, ?, ?)');
				$statement->execute($row);
			}
		}

		public function test_personal_subsubalbum_can_return_to_personal_root_without_breaking_nested_sets(): void
		{
			$this->set_up_database();
			$before_owner_seven = $this->owner_tree(7);
			$before_owner_eight = $this->owner_tree(8);
			$this->assert_valid_nested_set($before_owner_seven);
			$this->assert_valid_nested_set($before_owner_eight);

			$this->run_ucp_edit(3, 1, 7);

			$after_owner_seven = $this->owner_tree(7);
			$after_owner_eight = $this->owner_tree(8);
			$this->assert_valid_nested_set($after_owner_seven);
			$this->assert_valid_nested_set($after_owner_eight);
			$this->assertSame($before_owner_eight, $after_owner_eight);
			$this->assertSame([
				['album_id' => 1, 'parent_id' => 0, 'left_id' => 1, 'right_id' => 10],
				['album_id' => 2, 'parent_id' => 1, 'left_id' => 2, 'right_id' => 3],
				['album_id' => 5, 'parent_id' => 1, 'left_id' => 4, 'right_id' => 5],
				['album_id' => 3, 'parent_id' => 1, 'left_id' => 6, 'right_id' => 9],
				['album_id' => 4, 'parent_id' => 3, 'left_id' => 7, 'right_id' => 8],
			], $after_owner_seven);
		}

		public function test_personal_subsubalbum_can_move_below_another_subalbum(): void
		{
			$this->set_up_database();
			$other_owner = $this->owner_tree(8);

			$this->run_ucp_edit(3, 5, 7);

			$tree = $this->owner_tree(7);
			$this->assert_valid_nested_set($tree);
			$this->assertSame($other_owner, $this->owner_tree(8));
			$this->assertSame([
				['album_id' => 1, 'parent_id' => 0, 'left_id' => 1, 'right_id' => 10],
				['album_id' => 2, 'parent_id' => 1, 'left_id' => 2, 'right_id' => 3],
				['album_id' => 5, 'parent_id' => 1, 'left_id' => 4, 'right_id' => 9],
				['album_id' => 3, 'parent_id' => 5, 'left_id' => 5, 'right_id' => 8],
				['album_id' => 4, 'parent_id' => 3, 'left_id' => 6, 'right_id' => 7],
			], $tree);
		}

		public function test_manipulated_zero_parent_cannot_create_a_second_personal_root(): void
		{
			$this->set_up_database();
			$before = $this->all_trees();

			$this->run_ucp_edit(3, 0, 7);

			$this->assertSame($before, $this->all_trees());
			$this->assert_valid_nested_set($this->owner_tree(7));
		}

		public function test_descendant_cannot_be_selected_as_the_new_parent(): void
		{
			$this->set_up_database();
			$before = $this->all_trees();

			$this->run_ucp_edit(3, 4, 7);

			$this->assertSame($before, $this->all_trees());
			$this->assert_valid_nested_set($this->owner_tree(7));
		}

		public function test_album_owned_by_another_user_is_rejected_before_any_tree_change(): void
		{
			$this->set_up_database();
			$before = $this->all_trees();

			try
			{
				$this->run_ucp_edit(3, 10, 7);
				$this->fail('A foreign personal album must not be accepted as parent.');
			}
			catch (\phpbb\exception\http_exception $exception)
			{
				$this->assertSame(403, $exception->getStatusCode());
			}

			$this->assertSame($before, $this->all_trees());
			$this->assert_valid_nested_set($this->owner_tree(7));
			$this->assert_valid_nested_set($this->owner_tree(8));
		}

		public function test_no_parent_option_and_nested_set_updates_remain_owner_scoped(): void
		{
			$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');
			$method_start = strpos($source, 'public function edit_album(): void');
			$method_end = strpos($source, 'public function delete_album(): void', $method_start);
			$method = substr($source, $method_start, $method_end - $method_start);

			$this->assertStringContainsString(
				'$phpbb_ext_gallery_user->get_data(\'personal_album_id\')',
				$method
			);
			$this->assertStringContainsString('$invalid_parent_ids = [0, $album_id];', $method);
			$this->assertStringContainsString('$phpbb_ext_gallery_core_album->check_user($requested_parent_id, $owner_id);', $method);
			$this->assertStringContainsString('$phpbb_container->get(\'phpbbgallery.core.album.manage\')', $method);
			$this->assertStringContainsString('$album_manage->move_album($album_id, $parent_id);', $method);
			$this->assertStringNotContainsString('$moving_distance', $method);
			$this->assertStringNotContainsString('$stop_updating', $method);
		}

		private function run_ucp_edit(int $album_id, int $new_parent_id, int $owner_id): void
		{
			global $config, $cache, $db, $template, $user, $phpbb_gallery_url;
			global $phpbb_ext_gallery_core_album, $phpbb_ext_gallery_core_auth, $albums_table;
			global $phpbb_ext_gallery_core_album_display, $request, $phpbb_container;
			global $phpbb_ext_gallery_user, $users_table;

			$current_result = null;
			$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
			$db->method('sql_query')
				->willReturnCallback(function (string $sql) use (&$current_result): mixed
				{
					$current_result = $this->pdo->query($sql);

					return $current_result;
				});
			$db->method('sql_fetchrow')
				->willReturnCallback(static fn (mixed $result): array|false => $result->fetch(PDO::FETCH_ASSOC));
			$db->method('sql_freeresult');
			$db->method('sql_build_array')
				->willReturnCallback(function (string $mode, array $data): string
				{
					$assignments = [];
					foreach ($data as $column => $value)
					{
						$assignments[] = $column . ' = ' . (is_int($value) ? $value : $this->pdo->quote((string) $value));
					}

					return implode(', ', $assignments);
				});
			$db->method('sql_in_set')
				->willReturnCallback(static function (string $field, array $values, bool $negate = false): string
				{
					return $field . ($negate ? ' NOT IN (' : ' IN (') . implode(', ', array_map('intval', $values)) . ')';
				});
			$albums_table = 'gallery_albums';
			$users_table = 'gallery_users';
			$config = [];
			$template = null;
			$user = new class($owner_id)
			{
				public array $data;

				public function __construct(int $user_id)
				{
					$this->data = ['user_id' => $user_id, 'username' => 'Owner'];
				}
			};
			$cache = new class
			{
				public function destroy(string $type, string $table = ''): void
				{
				}
			};
			$phpbb_gallery_url = new class
			{
				public function _include(array|string $files, string $location): void
				{
				}

				public function append_sid(string $location, string $params = ''): string
				{
					return $location . '?' . $params;
				}
			};

			$phpbb_ext_gallery_core_album = $this->createMock(album::class);
			$phpbb_ext_gallery_core_album->method('check_user')
				->willReturnCallback(function (int $checked_id, int|false $checked_owner_id = false) use ($owner_id): bool
				{
					$row = $this->album($checked_id);
					$expected_owner_id = $checked_owner_id === false ? $owner_id : $checked_owner_id;
					if ((int) $row['album_user_id'] !== $expected_owner_id)
					{
						throw new \phpbb\exception\http_exception(403, 'NO_ALBUM_STEALING');
					}

					return true;
				});
			$phpbb_ext_gallery_core_album->method('get_info')
				->willReturnCallback(fn (int $requested_id): array => $this->album($requested_id));

			$phpbb_ext_gallery_core_album_display = $this->createMock(display::class);
			$phpbb_ext_gallery_core_album_display->method('get_branch')
				->willReturnCallback(function (int $branch_owner_id, int $branch_id): array
				{
					$root = $this->album($branch_id);
					$statement = $this->pdo->prepare('SELECT * FROM gallery_albums
						WHERE album_user_id = ? AND left_id BETWEEN ? AND ? ORDER BY left_id');
					$statement->execute([$branch_owner_id, $root['left_id'], $root['right_id']]);

					return $statement->fetchAll(PDO::FETCH_ASSOC);
				});

			$phpbb_ext_gallery_core_auth = $this->createMock(auth::class);
			$phpbb_ext_gallery_core_auth->method('acl_check')->willReturn(false);
			$phpbb_ext_gallery_user = $this->createMock(gallery_user::class);
			$phpbb_ext_gallery_user->method('get_data')
				->willReturnCallback(static fn (string $key): int => $key === 'personal_album_id' ? 1 : 0);

			$request = $this->createMock(\phpbb\request\request_interface::class);
			$values = [
				'album_id' => $album_id,
				'parent_id' => $new_parent_id,
				'album_name' => 'Album moved back to root',
				'album_desc' => '',
				'redirect' => '',
			];
			$request->method('variable')
				->willReturnCallback(static fn (string $name, mixed $default): mixed => $values[$name] ?? $default);
			$request->method('is_set_post')
				->willReturnCallback(static fn (string $name): bool => $name === 'submit');

			$language = $this->createMock(\phpbb\language\language::class);
			$language->method('lang')
				->willReturnCallback(static fn (string $key): string => $key);
			$album_manage = (new \ReflectionClass(manage::class))->newInstanceWithoutConstructor();
			$initialize_manager = \Closure::bind(
				function ($database, $album_service, $display_service, $language_service): void
				{
					$this->db = $database;
					$this->gallery_album = $album_service;
					$this->gallery_display = $display_service;
					$this->language = $language_service;
					$this->albums_table = 'gallery_albums';
				},
				$album_manage,
				manage::class
			);
			$initialize_manager($db, $phpbb_ext_gallery_core_album, $phpbb_ext_gallery_core_album_display, $language);

			$phpbb_container = new class($language, $album_manage)
			{
				private \phpbb\language\language $language;
				private manage $album_manage;

				public function __construct(\phpbb\language\language $language, manage $album_manage)
				{
					$this->language = $language;
					$this->album_manage = $album_manage;
				}

				public function get(string $service): mixed
				{
					return $service === 'phpbbgallery.core.album.manage'
						? $this->album_manage
						: $this->language;
				}
			};

			$module = new main_module();
			try
			{
				$module->edit_album();
				$this->fail('The UCP completion boundary was not reached.');
			}
			catch (\RuntimeException $exception)
			{
				if (!str_contains($exception->getMessage(), 'EDITED_SUBALBUM'))
				{
					throw $exception;
				}
				$this->assertStringContainsString('EDITED_SUBALBUM', $exception->getMessage());
			}
		}

		private function album(int $album_id): array
		{
			$statement = $this->pdo->prepare('SELECT * FROM gallery_albums WHERE album_id = ?');
			$statement->execute([$album_id]);
			$row = $statement->fetch(PDO::FETCH_ASSOC);
			$this->assertIsArray($row);

			return $row;
		}

		private function owner_tree(int $owner_id): array
		{
			$statement = $this->pdo->prepare('SELECT album_id, parent_id, left_id, right_id
				FROM gallery_albums WHERE album_user_id = ? ORDER BY left_id');
			$statement->execute([$owner_id]);

			return array_map(
				static fn (array $row): array => array_map('intval', $row),
				$statement->fetchAll(PDO::FETCH_ASSOC)
			);
		}

		private function all_trees(): array
		{
			return [
				7 => $this->owner_tree(7),
				8 => $this->owner_tree(8),
			];
		}

		private function assert_valid_nested_set(array $tree): void
		{
			$positions = [];
			$albums = [];
			foreach ($tree as $album)
			{
				$this->assertLessThan($album['right_id'], $album['left_id']);
				$positions[] = $album['left_id'];
				$positions[] = $album['right_id'];
				$albums[$album['album_id']] = $album;
			}

			sort($positions);
			$this->assertSame(range(1, count($tree) * 2), $positions);
			foreach ($tree as $album)
			{
				if ($album['parent_id'] === 0)
				{
					continue;
				}

				$this->assertArrayHasKey($album['parent_id'], $albums);
				$parent = $albums[$album['parent_id']];
				$this->assertGreaterThan($parent['left_id'], $album['left_id']);
				$this->assertLessThan($parent['right_id'], $album['right_id']);
			}
		}
	}
}
