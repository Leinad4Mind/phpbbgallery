<?php
/**
 * phpBB Gallery - Core comment domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\comment;
use PHPUnit\Framework\TestCase;

final class domain_comment_types_test extends TestCase
{
	public function test_comment_domain_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(comment::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === comment::class)
			{
				$this->assertNotNull($property->getType(), comment::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== comment::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), comment::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), comment::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_comment_domain_return_contracts_are_explicit(): void
	{
		$this->assertSame('bool', (string) (new \ReflectionMethod(comment::class, 'is_allowed'))->getReturnType());
		$this->assertSame('int|false', (string) (new \ReflectionMethod(comment::class, 'add'))->getReturnType());
		$this->assertSame('bool', (string) (new \ReflectionMethod(comment::class, 'edit'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(comment::class, 'sync_image_comments'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(comment::class, 'delete_comments'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(comment::class, 'delete_images'))->getReturnType());
		$this->assertSame('array', (string) (new \ReflectionMethod(comment::class, 'cast_mixed_int2array'))->getReturnType());
	}

	public function test_invalid_comment_mutations_return_false_before_using_dependencies(): void
	{
		$comment = (new \ReflectionClass(comment::class))->newInstanceWithoutConstructor();

		$this->assertFalse($comment->add([]));
		$this->assertFalse($comment->add(['comment_image_id' => 10]));
		$this->assertFalse($comment->edit(3, []));
	}

	public function test_identifier_normalization_preserves_order_and_casts_values(): void
	{
		$comment = (new \ReflectionClass(comment::class))->newInstanceWithoutConstructor();

		$this->assertSame([12], $comment->cast_mixed_int2array(12));
		$this->assertSame([4, 9, 0], $comment->cast_mixed_int2array(['4', 9, 'invalid']));
	}

	public function test_deleting_image_comments_resets_both_statistics_with_valid_sql(): void
	{
		$reflection = new \ReflectionClass(comment::class);
		$comment = $reflection->newInstanceWithoutConstructor();
		$queries = [];
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(2))
			->method('sql_in_set')
			->willReturnCallback(static fn (string $field, array $ids): string => $field . ' IN (' . implode(', ', $ids) . ')');
		$db->expects($this->exactly(2))
			->method('sql_query')
			->willReturnCallback(static function (string $sql) use (&$queries): bool
			{
				$queries[] = $sql;
				return true;
			});

		$reflection->getProperty('db')->setValue($comment, $db);
		$reflection->getProperty('comments_table')->setValue($comment, 'gallery_comments');
		$reflection->getProperty('images_table')->setValue($comment, 'gallery_images');

		$comment->delete_images([4, 7], true);

		$this->assertStringContainsString('DELETE FROM gallery_comments', $queries[0]);
		$this->assertStringContainsString('comment_image_id IN (4, 7)', $queries[0]);
		$this->assertStringContainsString('UPDATE gallery_images', $queries[1]);
		$this->assertMatchesRegularExpression('/SET image_comments = 0,\s+image_last_comment = 0/', $queries[1]);
		$this->assertStringContainsString('image_id IN (4, 7)', $queries[1]);
	}
}
