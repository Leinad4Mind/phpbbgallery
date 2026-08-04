<?php
/**
 * phpBB Gallery - UCP main module type tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\ucp\main_module;
use PHPUnit\Framework\TestCase;

final class ucp_main_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(main_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === main_module::class)
			{
				$this->assertNotNull($property->getType(), main_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== main_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), main_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), main_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_ucp_actions_are_explicit_commands(): void
	{
		$actions = [
			'main',
			'info',
			'initialise_album',
			'manage_albums',
			'create_album',
			'edit_album',
			'delete_album',
			'manage_subscriptions',
			'subscribe_pegas',
		];

		foreach ($actions as $action)
		{
			$this->assertSame('void', (string) (new \ReflectionMethod(main_module::class, $action))->getReturnType(), $action);
		}

		$album_parameter = (new \ReflectionMethod(main_module::class, 'subscribe_pegas'))->getParameters()[0];
		$this->assertSame('int', (string) $album_parameter->getType());
		$this->assertSame('bool', (string) (new \ReflectionMethod(main_module::class, 'move_album'))->getReturnType());
	}

	public function test_missing_newest_personal_gallery_resets_stale_config(): void
	{
		$sets = [];
		$config = $this->createMock(\phpbbgallery\core\config::class);
		$config->expects($this->exactly(5))
			->method('set')
			->willReturnCallback(static function (string $key, mixed $value) use (&$sets): void
			{
				$sets[$key] = $value;
			});

		$module = new main_module();
		$update = new \ReflectionMethod(main_module::class, 'update_newest_personal_gallery_config');
		$update->invoke($module, $config, false);

		$this->assertSame([
			'newest_pega_user_id' => 0,
			'newest_pega_username' => '',
			'newest_pega_user_colour' => '',
			'newest_pega_album_id' => 0,
			'num_pegas' => 0,
		], $sets);
	}

	public function test_album_tree_queries_use_normalized_integer_boundaries(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString('$moving_parent_id = (int) $moving[\'parent_id\'];', $source);
		$this->assertStringContainsString('$target_left_id = (int) $target[\'left_id\'];', $source);
		$this->assertStringContainsString('$user_id = (int) $user->data[\'user_id\'];', $source);
		$this->assertStringNotContainsString('sizeof($target)', $source);
	}

	public function test_subscriptions_apply_the_neutral_privacy_policy(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString(
			'$phpbb_container->get(\'phpbbgallery.core.policy.image_visibility\')',
			$source
		);
		$this->assertGreaterThanOrEqual(2, substr_count($source, '$image_visibility->hides_private_data('));
		$this->assertGreaterThanOrEqual(2, substr_count($source, '$image_visibility->private_data_label('));
		$this->assertStringContainsString('$image_visibility->hides_results(', $source);
		$this->assertStringNotContainsString('core\\contest::', $source);
		$this->assertStringNotContainsString('block::TYPE_CONTEST', $source);
		$this->assertStringContainsString("projection_sql('li', \$last_image_projection)", $source);
		$this->assertStringContainsString('projected_data($row, $last_image_projection', $source);
		$this->assertStringNotContainsString('last_image_contest', $source);
		$this->assertStringContainsString('li.image_id = a.album_last_image_id', $source);
		$this->assertStringContainsString('$hide_results ? 0', $source);
		$this->assertStringContainsString('$album_data_enricher->enrich_many($album_rows)', $source);
		$this->assertStringNotContainsString('$contests_table', $source);
		$this->assertStringContainsString("show_image(\$row['album_last_image_id'])", $source);
	}

	public function test_subscription_rows_render_the_last_comment_body(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString("'LAST_COMMENT'", $source);
		$this->assertStringContainsString("generate_text_for_display(\$row['comment'], \$row['comment_uid'], \$row['comment_bitfield'], 7)", $source);
	}

	public function test_personal_album_deletion_cannot_bypass_recoverable_image_deletion(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/ucp/main_module.php');

		$this->assertStringContainsString('SELECT image_id, image_filename, image_status', $source);
		$this->assertStringContainsString('block::STATUS_ORPHAN', $source);
		$this->assertStringContainsString('$contains_protected_images = true', $source);
		$this->assertStringContainsString('DELETE_ALBUM_REQUIRES_EMPTY', $source);
		$this->assertStringNotContainsString('$num_images = sizeof($deleted_images)', $source);
	}
}
