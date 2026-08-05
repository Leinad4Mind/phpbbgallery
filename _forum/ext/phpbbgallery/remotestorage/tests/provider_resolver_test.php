<?php
/**
 * phpBB Gallery - Remote Storage provider catalogue tests
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\tests;

use phpbbgallery\core\storage\local_provider;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\remotestorage\configured_provider_factory_interface;
use phpbbgallery\remotestorage\migration\provider_resolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class provider_resolver_test extends TestCase
{
	public function test_catalogue_resolves_local_and_registered_remote_providers(): void
	{
		$local = $this->local_provider();
		$remote = $this->createMock(provider_interface::class);
		$factory = $this->createMock(configured_provider_factory_interface::class);
		$factory->method('get_id')->willReturn('s3');
		$factory->expects($this->once())->method('create')->willReturn($remote);

		$container = $this->createMock(ContainerInterface::class);
		$container->expects($this->once())->method('has')
			->with('phpbbgallery.remotestorage.provider_factory.s3')->willReturn(true);
		$container->expects($this->once())->method('get')
			->with('phpbbgallery.remotestorage.provider_factory.s3')->willReturn($factory);

		$resolver = new provider_resolver($local, $container, ['s3']);
		$this->assertSame(['s3'], $resolver->remote_provider_ids());
		$this->assertSame($local, $resolver->resolve(' LOCAL '));
		$this->assertSame($remote, $resolver->resolve(' S3 '));
	}

	public function test_unregistered_provider_is_rejected_before_container_lookup(): void
	{
		$resolver = new provider_resolver(
			$this->local_provider(),
			$this->createMock(ContainerInterface::class),
			['s3']
		);

		$this->expectException(\InvalidArgumentException::class);
		$resolver->resolve('azure');
	}

	/** @dataProvider invalid_catalogue_provider */
	public function test_invalid_catalogue_is_rejected(array $provider_ids): void
	{
		$this->expectException(\InvalidArgumentException::class);
		new provider_resolver(
			$this->local_provider(),
			$this->createMock(ContainerInterface::class),
			$provider_ids
		);
	}

	public static function invalid_catalogue_provider(): array
	{
		return [
			'reserved local identifier' => [['local']],
			'duplicate identifier' => [['s3', 'S3']],
			'unsafe identifier' => [['../s3']],
			'empty identifier' => [['']],
		];
	}

	public function test_missing_or_incompatible_factory_fails_closed(): void
	{
		$missing = $this->createMock(ContainerInterface::class);
		$missing->method('has')->willReturn(false);
		$resolver = new provider_resolver($this->local_provider(), $missing, ['s3']);

		try
		{
			$resolver->resolve('s3');
			$this->fail('The missing factory should have been rejected.');
		}
		catch (\RuntimeException $exception)
		{
			$this->assertStringContainsString('not available', $exception->getMessage());
		}

		$incompatible = $this->createMock(ContainerInterface::class);
		$incompatible->method('has')->willReturn(true);
		$incompatible->method('get')->willReturn(new \stdClass());
		$resolver = new provider_resolver($this->local_provider(), $incompatible, ['s3']);

		$this->expectException(\RuntimeException::class);
		$this->expectExceptionMessage('incompatible');
		$resolver->resolve('s3');
	}

	private function local_provider(): local_provider
	{
		return new local_provider(sys_get_temp_dir(), sys_get_temp_dir(), sys_get_temp_dir());
	}
}
