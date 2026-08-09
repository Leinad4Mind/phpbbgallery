<?php
/**
 * phpBB Gallery - Message editor listener tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\event\editor_listener;
use phpbbgallery\core\image\selector;
use PHPUnit\Framework\TestCase;

final class editor_listener_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- PHPUnit lifecycle API.
	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();
		$phpbb_root = dirname(__DIR__, 4);
		if (!interface_exists(\Symfony\Component\Routing\RequestContextAwareInterface::class, false))
		{
			require_once $phpbb_root . '/vendor/symfony/routing/RequestContextAwareInterface.php';
		}
		if (!interface_exists(\Symfony\Component\Routing\Generator\UrlGeneratorInterface::class, false))
		{
			require_once $phpbb_root . '/vendor/symfony/routing/Generator/UrlGeneratorInterface.php';
		}
		if (!class_exists(\phpbb\controller\helper::class, false))
		{
			require_once $phpbb_root . '/phpbb/controller/helper.php';
		}
		if (!class_exists(selector::class, false))
		{
			require_once dirname(__DIR__) . '/image/selector.php';
		}
		if (!class_exists(editor_listener::class, false))
		{
			require_once dirname(__DIR__) . '/event/editor_listener.php';
		}
	}

	public function test_subscribes_to_full_post_private_message_and_quick_reply_editors(): void
	{
		$this->assertSame([
			'core.posting_modify_template_vars' => 'posting_editor',
			'core.ucp_pm_compose_template' => 'private_message_editor',
			'core.ucp_profile_modify_signature' => 'signature_editor',
			'core.viewtopic_modify_quick_reply_template_vars' => 'quick_reply_editor',
		], editor_listener::getSubscribedEvents());
	}

	/**
	 * @dataProvider available_editor_provider
	 */
	public function test_available_registered_user_receives_selector_variables(string $method, string $container,
		array $event_data): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->once())->method('has_images')->with(7)->willReturn(true);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->exactly(2))
			->method('route')
			->willReturnCallback(static fn (string $route): string => '/' . $route);
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		if ($method === 'quick_reply_editor')
		{
			$phpbb_auth->expects($this->once())->method('acl_get')->with('f_bbcode', 42)->willReturn(true);
		}
		else
		{
			$phpbb_auth->expects($this->never())->method('acl_get');
		}
		$event = new \phpbb\event\data($event_data);

		$this->listener($selector, $helper, true, true, false, true, $phpbb_auth)->{$method}($event);

		$variables = $event[$container];
		$this->assertSame('preserved', $variables['ORIGINAL']);
		$this->assertTrue($variables['S_GALLERY_SELECTOR']);
		$this->assertSame('/phpbbgallery_core_editor_images', $variables['U_GALLERY_SELECTOR']);
		$this->assertSame('/phpbbgallery_core_search_egosearch', $variables['U_GALLERY_SELECTOR_FALLBACK']);
		$this->assertSame('message', $variables['GALLERY_SELECTOR_TEXT_NAME']);
	}

	public static function available_editor_provider(): array
	{
		return [
			'new topic' => ['posting_editor', 'page_data', [
				'mode' => 'post',
				'page_data' => ['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'],
			]],
			'reply' => ['posting_editor', 'page_data', [
				'mode' => 'reply',
				'page_data' => ['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'],
			]],
			'private message' => ['private_message_editor', 'template_ary', [
				'template_ary' => ['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'],
			]],
			'quick reply' => ['quick_reply_editor', 'tpl_ary', [
				'tpl_ary' => ['ORIGINAL' => 'preserved'],
				'topic_data' => ['forum_id' => 42],
			]],
		];
	}

	public function test_unrelated_posting_mode_never_checks_gallery_permissions(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$event = new \phpbb\event\data([
			'mode' => 'delete',
			'page_data' => ['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'],
		]);

		$this->listener($selector, $helper)->posting_editor($event);

		$this->assertSame(['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'], $event['page_data']);
	}

	public function test_disabled_bbcode_never_exposes_selector(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$event = new \phpbb\event\data([
			'template_ary' => ['S_BBCODE_ALLOWED' => 0, 'ORIGINAL' => 'preserved'],
		]);

		$this->listener($selector, $helper)->private_message_editor($event);

		$this->assertArrayNotHasKey('S_GALLERY_SELECTOR', $event['template_ary']);
	}

	public function test_available_signature_editor_targets_the_signature_textarea(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->once())->method('has_images')->with(7)->willReturn(true);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->exactly(2))
			->method('route')
			->willReturnCallback(static fn (string $route): string => '/' . $route);
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$phpbb_auth->expects($this->once())->method('acl_get')->with('u_sig')->willReturn(true);
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->once())->method('assign_vars')->with([
			'S_GALLERY_SELECTOR' => true,
			'U_GALLERY_SELECTOR' => '/phpbbgallery_core_editor_images',
			'U_GALLERY_SELECTOR_FALLBACK' => '/phpbbgallery_core_search_egosearch',
			'GALLERY_SELECTOR_TEXT_NAME' => 'signature',
		]);

		$event = new \phpbb\event\data(['enable_bbcode' => true]);
		$this->listener(
			$selector,
			$helper,
			phpbb_auth: $phpbb_auth,
			template: $template
		)->signature_editor($event);
	}

	/** @dataProvider unavailable_signature_policy_provider */
	public function test_signature_editor_respects_bbcode_image_and_user_permissions(
		bool $allow_sig_bbcode,
		bool $allow_sig_img,
		bool $allow_signature
	): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$acl_calls = $allow_sig_bbcode && $allow_sig_img ? 1 : 0;
		$phpbb_auth->expects($this->exactly($acl_calls))
			->method('acl_get')
			->with('u_sig')
			->willReturn($allow_signature);
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->never())->method('assign_vars');

		$event = new \phpbb\event\data(['enable_bbcode' => true]);
		$this->listener(
			$selector,
			$helper,
			phpbb_auth: $phpbb_auth,
			template: $template,
			allow_sig_bbcode: $allow_sig_bbcode,
			allow_sig_img: $allow_sig_img
		)->signature_editor($event);
	}

	public static function unavailable_signature_policy_provider(): array
	{
		return [
			'signature BBCode disabled' => [false, true, true],
			'signature images disabled' => [true, false, true],
			'user cannot edit a signature' => [true, true, false],
		];
	}

	public function test_selector_is_hidden_until_the_image_bbcode_is_ready(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$event = new \phpbb\event\data([
			'mode' => 'reply',
			'page_data' => ['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'],
		]);

		$this->listener($selector, $helper, true, true, false, true, null, false)->posting_editor($event);

		$this->assertSame(['S_BBCODE_ALLOWED' => 1, 'ORIGINAL' => 'preserved'], $event['page_data']);
	}

	/**
	 * @dataProvider unavailable_user_provider
	 */
	public function test_guest_or_bot_never_exposes_selector(bool $registered, bool $bot): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$event = new \phpbb\event\data([
			'mode' => 'reply',
			'page_data' => ['S_BBCODE_ALLOWED' => 1],
		]);

		$this->listener($selector, $helper, true, $registered, $bot)->posting_editor($event);

		$this->assertArrayNotHasKey('S_GALLERY_SELECTOR', $event['page_data']);
	}

	public static function unavailable_user_provider(): array
	{
		return [
			'guest' => [false, false],
			'bot' => [true, true],
		];
	}

	public function test_user_without_selectable_images_never_exposes_selector(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->once())->method('has_images')->with(7)->willReturn(false);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->never())->method('route');
		$event = new \phpbb\event\data([
			'mode' => 'edit',
			'page_data' => ['S_BBCODE_ALLOWED' => 1],
		]);

		$this->listener($selector, $helper)->posting_editor($event);

		$this->assertArrayNotHasKey('S_GALLERY_SELECTOR', $event['page_data']);
	}

	public function test_quick_reply_respects_global_bbcode_configuration(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$phpbb_auth->expects($this->never())->method('acl_get');
		$event = new \phpbb\event\data([
			'tpl_ary' => ['ORIGINAL' => 'preserved'],
			'topic_data' => ['forum_id' => 42],
		]);

		$this->listener($selector, $helper, false, true, false, true, $phpbb_auth)->quick_reply_editor($event);

		$this->assertSame(['ORIGINAL' => 'preserved'], $event['tpl_ary']);
	}

	public function test_quick_reply_respects_user_bbcode_preference(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$phpbb_auth->expects($this->never())->method('acl_get');
		$event = new \phpbb\event\data([
			'tpl_ary' => ['ORIGINAL' => 'preserved'],
			'topic_data' => ['forum_id' => 42],
		]);

		$this->listener($selector, $helper, true, true, false, false, $phpbb_auth)->quick_reply_editor($event);

		$this->assertSame(['ORIGINAL' => 'preserved'], $event['tpl_ary']);
	}

	public function test_quick_reply_respects_forum_bbcode_permission(): void
	{
		$selector = $this->createMock(selector::class);
		$selector->expects($this->never())->method('has_images');
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$phpbb_auth = $this->createMock(\phpbb\auth\auth::class);
		$phpbb_auth->expects($this->once())->method('acl_get')->with('f_bbcode', 42)->willReturn(false);
		$event = new \phpbb\event\data([
			'tpl_ary' => ['ORIGINAL' => 'preserved'],
			'topic_data' => ['forum_id' => 42],
		]);

		$this->listener($selector, $helper, true, true, false, true, $phpbb_auth)->quick_reply_editor($event);

		$this->assertSame(['ORIGINAL' => 'preserved'], $event['tpl_ary']);
	}

	public function test_listener_contract_is_fully_typed(): void
	{
		$reflection = new \ReflectionClass(editor_listener::class);

		foreach ($reflection->getProperties() as $property)
		{
			$this->assertNotNull($property->getType(), editor_listener::class . '::$' . $property->getName());
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== editor_listener::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), editor_listener::class . '::' . $method->getName());
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), editor_listener::class . '::' . $method->getName());
			}
		}
	}

	private function listener(selector $selector, \phpbb\controller\helper $helper, bool $allow_bbcode = true,
		bool $registered = true, bool $bot = false, bool $user_bbcode = true,
		?\phpbb\auth\auth $phpbb_auth = null, bool $gallery_bbcode_ready = true,
		?\phpbb\template\template $template = null, bool $allow_sig_bbcode = true,
		bool $allow_sig_img = true): editor_listener
	{
		$user = new class($user_bbcode) extends \phpbb\user
		{
			private bool $bbcode_enabled;

			public function __construct(bool $bbcode_enabled)
			{
				$this->bbcode_enabled = $bbcode_enabled;
			}

			public function optionget($key, $data = false): bool
			{
				return $key === 'bbcode' && $this->bbcode_enabled;
			}
		};
		$user->data = [
			'user_id' => 7,
			'is_registered' => $registered,
			'is_bot' => $bot,
		];

		return new editor_listener(
			$helper,
			$user,
			new \phpbb\config\config([
				'allow_bbcode' => $allow_bbcode,
				'allow_sig_bbcode' => $allow_sig_bbcode,
				'allow_sig_img' => $allow_sig_img,
				'phpbb_gallery_bbcode_ready' => $gallery_bbcode_ready,
			]),
			$phpbb_auth ?? $this->createMock(\phpbb\auth\auth::class),
			$selector,
			$template ?? $this->createMock(\phpbb\template\template::class)
		);
	}
}
