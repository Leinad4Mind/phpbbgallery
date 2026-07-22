<?php
/**
 * phpBB Gallery - Core album domain tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\album\album;
use phpbbgallery\core\album\display;
use phpbbgallery\core\album\loader;
use phpbbgallery\core\album\manage;
use PHPUnit\Framework\TestCase;

final class domain_album_types_test extends TestCase
{
	public function test_album_domain_properties_and_methods_are_fully_typed(): void
	{
		foreach ([album::class, display::class, loader::class, manage::class] as $class)
		{
			$reflection = new \ReflectionClass($class);

			foreach ($reflection->getProperties() as $property)
			{
				if ($property->getDeclaringClass()->getName() === $class)
				{
					$this->assertNotNull($property->getType(), $class . '::$' . $property->getName());
				}
			}

			foreach ($reflection->getMethods() as $method)
			{
				if ($method->getDeclaringClass()->getName() !== $class)
				{
					continue;
				}

				foreach ($method->getParameters() as $parameter)
				{
					$this->assertNotNull($parameter->getType(), $class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
				}

				if (!$method->isConstructor() && !$method->isDestructor())
				{
					$this->assertNotNull($method->getReturnType(), $class . '::' . $method->getName() . '()');
				}
			}
		}
	}

	public function test_album_domain_return_contracts_are_explicit(): void
	{
		$this->assertSame('array', (string) (new \ReflectionMethod(album::class, 'get_info'))->getReturnType());
		$this->assertSame('array|false', (string) (new \ReflectionMethod(album::class, 'update_info'))->getReturnType());
		$this->assertSame('int', (string) (new \ReflectionMethod(album::class, 'generate_personal_album'))->getReturnType());
		$this->assertSame('array', (string) (new \ReflectionMethod(display::class, 'display_albums'))->getReturnType());
		$this->assertSame('mixed', (string) (new \ReflectionMethod(loader::class, 'get'))->getReturnType());
		$this->assertSame('string|false', (string) (new \ReflectionMethod(manage::class, 'move_album_by'))->getReturnType());
	}

	public function test_loader_initializes_and_reuses_loaded_album_data(): void
	{
		$reflection = new \ReflectionClass(loader::class);
		$loader = $reflection->newInstanceWithoutConstructor();
		$data = $reflection->getProperty('data');

		$this->assertSame([], $data->getValue($loader));

		$data->setValue($loader, [
			7 => [
				'album_id' => 7,
				'album_name' => 'Typed album',
				'album_user_id' => 42,
			],
		]);

		$this->assertSame('Typed album', $loader->get(7, 'album_name'));
		$this->assertSame(7, $loader->get(7)['album_id']);
		$this->assertTrue($loader->validate_owner(7, 42));
	}

	public function test_loader_rejects_unknown_columns_and_wrong_owners(): void
	{
		$reflection = new \ReflectionClass(loader::class);
		$loader = $reflection->newInstanceWithoutConstructor();
		$reflection->getProperty('data')->setValue($loader, [
			8 => [
				'album_id' => 8,
				'album_user_id' => 9,
			],
		]);

		try
		{
			$loader->get(8, 'missing_column');
			$this->fail('An unknown album column must be rejected.');
		}
		catch (\OutOfRangeException $exception)
		{
			$this->assertSame('INVALID_ALBUM_COLUMN', $exception->getMessage());
		}

		$this->expectException(\DomainException::class);
		$this->expectExceptionMessage('INVALID_ALBUM');
		$loader->validate_owner(8, 10);
	}

	public function test_parent_cache_accepts_arrays_without_instantiating_objects(): void
	{
		$display = (new \ReflectionClass(display::class))->newInstanceWithoutConstructor();
		$parents = [
			3 => ['Parent album', 1],
		];

		$this->assertSame($parents, $display->get_parents([
			'parent_id' => 3,
			'album_parents' => serialize($parents),
		]));

		domain_album_unserialize_probe::$wakeups = 0;
		$this->assertSame([], $display->get_parents([
			'parent_id' => 3,
			'album_parents' => serialize(new domain_album_unserialize_probe()),
		]));
		$this->assertSame(0, domain_album_unserialize_probe::$wakeups);
	}

	public function test_album_display_and_manager_state_has_safe_defaults(): void
	{
		$display = (new \ReflectionClass(display::class))->newInstanceWithoutConstructor();
		$this->assertSame(0, $display->album_start);
		$this->assertSame(0, $display->album_limit);
		$this->assertSame(0, $display->albums_total);
		$this->assertSame('', $display->album_mode);

		$manage_reflection = new \ReflectionClass(manage::class);
		$manager = $manage_reflection->newInstanceWithoutConstructor();
		$manager->set_user(21);
		$manager->set_parent(5);
		$manager->set_u_action('adm/index.php');

		$this->assertSame(21, $manager->user_id);
		$this->assertSame(5, $manager->parent_id);
		$this->assertSame('adm/index.php', $manage_reflection->getProperty('u_action')->getValue($manager));
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Serialization probe belongs to this isolated test.
final class domain_album_unserialize_probe
{
	public static int $wakeups = 0;

	public function __wakeup(): void
	{
		self::$wakeups++;
	}
}
