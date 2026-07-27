<?php
/**
 * BBTags content provider API tests.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\provider\forum_provider;
use sitesplat\bbtags\provider\provider_interface;
use sitesplat\bbtags\provider\provider_registry;
use sitesplat\bbtags\tags\manager;

class provider_api_test extends TestCase
{
	public function test_registry_resolves_a_provider_by_its_stable_name(): void
	{
		$provider = $this->createMock(provider_interface::class);
		$provider->method('get_name')->willReturn(manager::FORUM_PROVIDER);
		$registry = new provider_registry([$provider]);

		$this->assertTrue($registry->has(manager::FORUM_PROVIDER));
		$this->assertSame($provider, $registry->get(manager::FORUM_PROVIDER));
		$this->assertSame([manager::FORUM_PROVIDER => $provider], $registry->all());
		$this->assertNull($registry->get('gallery_images'));
	}

	public function test_registry_rejects_duplicate_provider_names(): void
	{
		$first = $this->createMock(provider_interface::class);
		$first->method('get_name')->willReturn(manager::FORUM_PROVIDER);
		$second = $this->createMock(provider_interface::class);
		$second->method('get_name')->willReturn(manager::FORUM_PROVIDER);

		$this->expectException(\LogicException::class);
		$this->expectExceptionMessage('Duplicate BBTags provider name');
		(new provider_registry([$first, $second]))->all();
	}

	public function test_registry_rejects_invalid_provider_contracts_and_names(): void
	{
		$this->expectException(\LogicException::class);
		(new provider_registry([new \stdClass()]))->all();
	}

	public function test_registry_rejects_an_invalid_provider_name(): void
	{
		$provider = $this->createMock(provider_interface::class);
		$provider->method('get_name')->willReturn('../gallery');

		$this->expectException(\LogicException::class);
		$this->expectExceptionMessage('Invalid BBTags provider name');
		(new provider_registry([$provider]))->all();
	}

	public function test_forum_provider_delegates_validation_and_approval_to_the_manager(): void
	{
		$manager = $this->createMock(manager::class);
		$manager->expects($this->once())->method('topic_matches_scope')->with(34, 12)->willReturn(true);
		$manager->expects($this->once())->method('attach_tag_to_topic')->with(7, 34, 12)->willReturn(true);
		$provider = new forum_provider($manager, './', 'php');

		$this->assertSame(manager::FORUM_PROVIDER, $provider->get_name());
		$this->assertSame('BBTAGS_PROVIDER_FORUM_TOPICS', $provider->get_language_key());
		$this->assertTrue($provider->validate_subject(12, 34));
		$this->assertTrue($provider->apply_approved_tag(12, 34, 7));
		$this->assertSame('./viewtopic.php?t=34', $provider->get_item_url(12, 34));
		$this->assertSame('', $provider->get_item_url(12, 0));
	}

	public function test_services_expose_an_extensible_tagged_provider_collection(): void
	{
		$root = dirname(__DIR__);
		$services = (string) file_get_contents($root . '/config/services.yml');
		$moderation = (string) file_get_contents($root . '/tags/moderation.php');
		$listener = (string) file_get_contents($root . '/event/listener.php');

		$this->assertStringContainsString('tag: sitesplat.bbtags.provider', $services);
		$this->assertStringContainsString('sitesplat.bbtags.provider_registry', $services);
		$this->assertStringContainsString('sitesplat.bbtags.provider.forum_topics', $services);
		$this->assertStringNotContainsString('sitesplat.bbtags.moderation.validate_subject', $moderation . $listener);
		$this->assertStringNotContainsString('sitesplat.bbtags.moderation.apply_approval', $moderation . $listener);
	}
}
