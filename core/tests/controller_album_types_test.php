<?php
/**
 * phpBB Gallery - Album controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\album;
use PHPUnit\Framework\TestCase;

final class controller_album_types_test extends TestCase
{
	public function test_album_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(album::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === album::class)
			{
				$this->assertNotNull($property->getType(), album::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== album::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), album::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), album::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_album_routes_use_integer_identifiers_and_explicit_responses(): void
	{
		$reflection = new \ReflectionClass(album::class);
		$base = $reflection->getMethod('base');
		$watch = $reflection->getMethod('watch');

		$this->assertSame('int', (string) $base->getParameters()[0]->getType());
		$this->assertSame('int', (string) $base->getParameters()[1]->getType());
		$this->assertSame(1, $base->getParameters()[1]->getDefaultValue());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $base->getReturnType());
		$this->assertSame('int', (string) $watch->getParameters()[0]->getType());
		$this->assertSame('?Symfony\\Component\\HttpFoundation\\Response', (string) $watch->getReturnType());
	}

	public function test_invalid_sort_keys_fall_back_to_time(): void
	{
		$reflection = new \ReflectionClass(album::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_sort_key');
		$sort_columns = ['t' => 'image_time', 'n' => 'image_name_clean'];

		$this->assertSame('t', $normalizer->invoke($controller, 'invalid', $sort_columns));
		$this->assertSame('n', $normalizer->invoke($controller, 'n', $sort_columns));
	}

	public function test_album_pages_are_clamped_to_the_first_page(): void
	{
		$reflection = new \ReflectionClass(album::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_page');

		$this->assertSame(1, $normalizer->invoke($controller, -3));
		$this->assertSame(1, $normalizer->invoke($controller, 0));
		$this->assertSame(4, $normalizer->invoke($controller, 4));
	}

	public function test_album_display_flags_remain_stable(): void
	{
		$this->assertSame(128, album::ALBUM_SHOW_IP);
		$this->assertSame(64, album::ALBUM_SHOW_RATINGS);
		$this->assertSame(32, album::ALBUM_SHOW_USERNAME);
		$this->assertSame(16, album::ALBUM_SHOW_VIEWS);
		$this->assertSame(8, album::ALBUM_SHOW_TIME);
		$this->assertSame(4, album::ALBUM_SHOW_IMAGENAME);
		$this->assertSame(2, album::ALBUM_SHOW_COMMENTS);
		$this->assertSame(1, album::ALBUM_SHOW_ALBUM);
	}
}
