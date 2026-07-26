<?php
/**
 * phpBB Gallery - Core rating domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

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

	public function test_submit_rating_contract_reports_success_and_rejection_explicitly(): void
	{
		$method = new \ReflectionMethod(rating::class, 'submit_rating');

		$this->assertSame('bool', (string) $method->getReturnType());
		$this->assertSame('int|false', (string) $method->getParameters()[0]->getType());
		$this->assertSame('int|false', (string) $method->getParameters()[1]->getType());
		$this->assertSame('string|false', (string) $method->getParameters()[2]->getType());
	}
}
