<?php
/**
 * phpBB Gallery - Core rating domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\block;
use phpbbgallery\core\rating;
use PHPUnit\Framework\TestCase;

final class domain_rating_types_test extends TestCase
{
	public function test_rating_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(rating::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === rating::class)
			{
				$this->assertNotNull($property->getType(), rating::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== rating::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), rating::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), rating::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_loader_resets_all_request_local_rating_state(): void
	{
		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('image_data')->setValue($rating, ['image_id' => 3]);
		$reflection->getProperty('album_data')->setValue($rating, ['album_id' => 4]);
		$rating->user_rating = [7 => 5];
		$rating->rating_enabled = true;

		$rating->loader(19);

		$this->assertSame(19, $rating->image_id);
		$this->assertNull($reflection->getProperty('image_data')->getValue($rating));
		$this->assertNull($reflection->getProperty('album_data')->getValue($rating));
		$this->assertSame([], $rating->user_rating);
		$this->assertFalse($rating->rating_enabled);
	}

	public function test_cached_user_rating_is_returned_without_a_database_lookup(): void
	{
		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$rating->user_rating = [12 => 4];

		$this->assertSame(4, $rating->get_user_rating(12));
	}

	public function test_user_ratings_for_an_album_page_are_loaded_in_one_bounded_query(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_in_set')
			->with('rate_image_id', [4, 7])
			->willReturn('rate_image_id IN (4, 7)');
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static fn (string $sql): bool =>
				str_contains($sql, 'FROM gallery_rates') &&
				str_contains($sql, 'rate_user_id = 2') &&
				str_contains($sql, 'rate_image_id IN (4, 7)')
			))
			->willReturn('result');
		$db->expects($this->exactly(3))
			->method('sql_fetchrow')
			->with('result')
			->willReturnOnConsecutiveCalls(
				['rate_image_id' => 4, 'rate_point' => 8],
				['rate_image_id' => 7, 'rate_point' => 3],
				false
			);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($rating, $db);
		$reflection->getProperty('rates_table')->setValue($rating, 'gallery_rates');

		$this->assertSame([4 => 8, 7 => 3], $rating->get_user_ratings([4, 0, 7, 4, -2], 2));
	}

	public function test_album_rating_lookup_skips_guests_and_empty_pages(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->never())->method('sql_query');
		$db->expects($this->never())->method('sql_in_set');
		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($rating, $db);

		$this->assertSame([], $rating->get_user_ratings([4, 7], ANONYMOUS));
		$this->assertSame([], $rating->get_user_ratings([], 2));
	}

	public function test_rating_permission_rejects_the_owner_and_guest_but_accepts_an_authorized_peer(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->exactly(3))
			->method('acl_check')
			->with('i_rate', 4, 0)
			->willReturn(true);
		$user = new \phpbb\user();
		$reflection->getProperty('gallery_auth')->setValue($rating, $gallery_auth);
		$reflection->getProperty('user')->setValue($rating, $user);
		$rating->loader(12, [
			'image_user_id' => 2,
			'image_status' => block::STATUS_APPROVED,
		], [
			'album_id' => 4,
			'album_user_id' => 0,
			'album_status' => block::ALBUM_OPEN,
		]);

		$user->data = ['user_id' => 2];
		$this->assertFalse($rating->is_allowed());
		$user->data = ['user_id' => ANONYMOUS];
		$this->assertFalse($rating->is_allowed());
		$user->data = ['user_id' => 7];
		$this->assertTrue($rating->is_allowed());
	}

	public function test_rating_ability_respects_the_album_operation_policy(): void
	{
		$rating = $this->getMockBuilder(rating::class)
			->disableOriginalConstructor()
			->onlyMethods(['is_allowed'])
			->getMock();
		$rating->expects($this->exactly(2))->method('is_allowed')->willReturn(true);
		$operation = $this->createMock(\phpbbgallery\core\policy\album_operation::class);
		$operation->expects($this->exactly(2))
			->method('allows')
			->with('rate', $this->isType('array'))
			->willReturnOnConsecutiveCalls(false, true);
		$reflection = new \ReflectionClass(rating::class);
		$reflection->getProperty('album_operation')->setValue($rating, $operation);
		$album_data = [
			'album_type' => block::TYPE_UPLOAD,
		];
		$reflection->getProperty('album_data')->setValue($rating, $album_data);

		$this->assertFalse($rating->is_able());
		$this->assertTrue($rating->is_able());
	}

	public function test_hidden_rating_presentation_is_delegated_to_the_visibility_policy(): void
	{
		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->exactly(2))
			->method('acl_check')
			->with('m_status', 4, 0)
			->willReturnOnConsecutiveCalls(false, true);
		$language = $this->createStub(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static function (string $key): string
		{
			return $key;
		});
		$reflection->getProperty('gallery_auth')->setValue($rating, $gallery_auth);
		$image_visibility = $this->createMock(\phpbbgallery\core\policy\image_visibility::class);
		$image_visibility->expects($this->exactly(2))
			->method('hides_results')
			->willReturnCallback(static fn (array $image_data, bool $can_moderate): bool => !$can_moderate);
		$image_visibility->expects($this->once())
			->method('hidden_results_message')
			->with(
				$this->isType('array'),
				$this->isType('array'),
				false,
				false,
				'GALLERY_RESULTS_HIDDEN'
			)
			->willReturn('ADDON_RESULTS_HIDDEN');
		$reflection->getProperty('image_visibility')->setValue($rating, $image_visibility);
		$reflection->getProperty('language')->setValue($rating, $language);
		$reflection->getProperty('template')->setValue($rating, $this->createStub(\phpbb\template\template::class));
		$rating->loader(12, [
			'provider_marker' => 1,
			'image_rates' => 3,
			'image_rate_avg' => 450,
		], [
			'album_id' => 4,
			'album_user_id' => 0,
		]);

		$this->assertSame('ADDON_RESULTS_HIDDEN', $rating->get_image_rating(false, false));
		$this->assertSame('RATING_STRINGS', $rating->get_image_rating(false, false));
		$source = (string) file_get_contents(dirname(__DIR__) . '/rating.php');
		$this->assertStringNotContainsString('CONTEST_', $source);
		$this->assertStringNotContainsString("image_data('image_contest')", $source);
	}

	public function test_submit_rating_rechecks_ability_before_writing(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$rating = $this->getMockBuilder(rating::class)
			->disableOriginalConstructor()
			->onlyMethods(['is_able'])
			->getMock();
		$rating->expects($this->once())->method('is_able')->willReturn(false);
		$user = $this->createStub(\phpbb\user::class);
		$user->data = ['user_id' => 2];
		$reflection = new \ReflectionClass(rating::class);
		$reflection->getProperty('user')->setValue($rating, $user);
		$reflection->getProperty('gallery_config')->setValue(
			$rating,
			new \phpbbgallery\core\config(new \phpbb\config\config([]))
		);

		$this->assertFalse($rating->submit_rating(false, 5));
	}

	public function test_album_loader_uses_the_image_album_identifier(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->once())
			->method('sql_query')
			->with($this->callback(static fn (string $sql): bool => str_contains($sql, 'FROM gallery_albums') && str_contains($sql, 'WHERE album_id = 27')))
			->willReturn('result');
		$db->expects($this->once())->method('sql_fetchrow')->with('result')->willReturn(['album_id' => 27]);
		$db->expects($this->once())->method('sql_freeresult')->with('result');

		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('db')->setValue($rating, $db);
		$reflection->getProperty('albums_table')->setValue($rating, 'gallery_albums');
		$rating->loader(4, ['image_album_id' => 27]);

		$this->assertSame(27, $reflection->getMethod('album_data')->invoke($rating, 'album_id'));
	}

	public function test_rating_statistics_are_updated_in_one_query(): void
	{
		$reflection = new \ReflectionClass(rating::class);
		$rating = $reflection->newInstanceWithoutConstructor();
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static fn (string $field, array|int $ids): string => $field . ' IN (' . implode(', ', (array) $ids) . ')');
		$db->expects($this->exactly(2))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): string|bool
			{
				$queries[] = $sql;
				return count($queries) === 1 ? 'rating_result' : true;
			});
		$db->expects($this->exactly(3))
			->method('sql_fetchrow')
			->with('rating_result')
			->willReturnOnConsecutiveCalls(
				['rate_image_id' => 4, 'image_rates' => 2, 'image_rate_points' => 9, 'image_rate_avg' => 4.5],
				['rate_image_id' => 7, 'image_rates' => 3, 'image_rate_points' => 11, 'image_rate_avg' => 3.666],
				false
			);
		$db->expects($this->once())->method('sql_freeresult')->with('rating_result');

		$reflection->getProperty('db')->setValue($rating, $db);
		$reflection->getProperty('rates_table')->setValue($rating, 'gallery_rates');
		$reflection->getProperty('images_table')->setValue($rating, 'gallery_images');

		$rating->recalc_image_rating([4, 7]);

		$this->assertCount(2, $queries);
		$this->assertStringContainsString('image_rates = CASE image_id WHEN 4 THEN 2 WHEN 7 THEN 3 END', $queries[1]);
		$this->assertStringContainsString('image_rate_points = CASE image_id WHEN 4 THEN 9 WHEN 7 THEN 11 END', $queries[1]);
		$this->assertStringContainsString('image_rate_avg = CASE image_id WHEN 4 THEN 450 WHEN 7 THEN 367 END', $queries[1]);
	}

	public function test_submit_rating_contract_reports_success_and_rejection_explicitly(): void
	{
		$method = new \ReflectionMethod(rating::class, 'submit_rating');

		$this->assertSame('bool', (string) $method->getReturnType());
		$this->assertSame('int|false', (string) $method->getParameters()[0]->getType());
		$this->assertSame('int|false', (string) $method->getParameters()[1]->getType());
		$this->assertSame('string|false', (string) $method->getParameters()[2]->getType());
	}
}
