<?php
/**
 * phpBB Gallery - ACP Cleanup module tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use phpbbgallery\acpcleanup\acp\main_module;
use PHPUnit\Framework\TestCase;

final class main_module_test extends TestCase
{
	public function test_module_contract_is_fully_typed(): void
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

	public function test_prune_and_cancel_flags_use_the_phpbb_request_service(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$fields = [
			'cancel',
			'prune_username_check',
			'prune_anonymous',
			'prune_time_check',
			'prune_comments_check',
			'prune_ratings_check',
			'prune_rating_avg_check',
		];

		$this->assertStringNotContainsString('$' . '_POST', $source);
		foreach ($fields as $field)
		{
			$this->assertStringContainsString('$request->is_set_post(\'' . $field . '\')', $source, $field);
		}
	}

	public function test_upload_directory_scan_handles_open_and_encoding_failures(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringContainsString('$handle !== false && ($file = readdir($handle)) !== false', $source);
		$this->assertStringContainsString('if ($handle !== false)', $source);
		$this->assertStringContainsString('$encoding ?: \'Windows-1252\'', $source);
	}
}
