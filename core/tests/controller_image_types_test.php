<?php
/**
 * phpBB Gallery - Image controller tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\controller\image;
use PHPUnit\Framework\TestCase;

final class controller_image_types_test extends TestCase
{
	public function test_image_controller_properties_and_methods_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(image::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === image::class)
			{
				$this->assertNotNull($property->getType(), image::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== image::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), image::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			if (!$method->isConstructor())
			{
				$this->assertNotNull($method->getReturnType(), image::class . '::' . $method->getName() . '()');
			}
		}
	}

	public function test_image_routes_use_integer_identifiers_and_explicit_responses(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$base = $reflection->getMethod('base');

		$this->assertSame('int', (string) $base->getParameters()[0]->getType());
		$this->assertSame('int', (string) $base->getParameters()[1]->getType());
		$this->assertSame(1, $base->getParameters()[1]->getDefaultValue());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $base->getReturnType());

		foreach (['edit', 'delete'] as $method_name)
		{
			$method = $reflection->getMethod($method_name);
			$this->assertSame('int', (string) $method->getParameters()[0]->getType());
			$this->assertSame('?Symfony\\Component\\HttpFoundation\\Response', (string) $method->getReturnType());
		}

		$report = $reflection->getMethod('report');
		$this->assertSame('int', (string) $report->getParameters()[0]->getType());
		$this->assertSame('Symfony\\Component\\HttpFoundation\\Response', (string) $report->getReturnType());
	}

	public function test_request_local_state_is_reset_before_image_rendering(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		foreach (['data', 'users_id_array', 'users_data_array', 'profile_fields_data', 'can_receive_pm_list'] as $property_name)
		{
			$reflection->getProperty($property_name)->setValue($controller, ['stale' => true]);
		}

		$reflection->getMethod('reset_request_state')->invoke($controller);

		foreach (['data', 'users_id_array', 'users_data_array', 'profile_fields_data', 'can_receive_pm_list'] as $property_name)
		{
			$this->assertSame([], $reflection->getProperty($property_name)->getValue($controller));
		}
	}

	public function test_invalid_sort_keys_fall_back_to_time(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_sort_key');
		$sort_columns = ['t' => 'image_time', 'n' => 'image_name_clean'];

		$this->assertSame('t', $normalizer->invoke($controller, 'invalid', $sort_columns));
		$this->assertSame('n', $normalizer->invoke($controller, 'n', $sort_columns));
	}

	public function test_image_click_action_is_deterministic_for_every_configuration(): void
	{
		require_once dirname(__DIR__, 4) . '/vendor/symfony/routing/RequestContextAwareInterface.php';
		require_once dirname(__DIR__, 4) . '/vendor/symfony/routing/Generator/UrlGeneratorInterface.php';
		require_once dirname(__DIR__, 4) . '/phpbb/controller/helper.php';
		$cases = [
			['none', ['image_id' => 88], true, ''],
			['image', ['image_id' => 88], true, 'phpbbgallery_core_image_file_source:77'],
			['image', ['image_id' => 88], false, ''],
			['next', ['image_id' => 88], false, 'phpbbgallery_core_image:88'],
			['next', false, true, ''],
			['highslide', ['image_id' => 88], true, 'phpbbgallery_core_image_file_source:77'],
			['highslide', ['image_id' => 88], false, ''],
		];

		foreach ($cases as [$mode, $next, $can_download_source, $expected])
		{
			$reflection = new \ReflectionClass(image::class);
			$controller = $reflection->newInstanceWithoutConstructor();
			$gallery_config = $this->createStub(\phpbbgallery\core\config::class);
			$gallery_config->method('get')->with('link_imagepage')->willReturn($mode);
			$helper = $this->createStub(\phpbb\controller\helper::class);
			$helper->method('route')->willReturnCallback(static function (string $route, array $parameters): string
			{
				return $route . ':' . $parameters['image_id'];
			});
			$reflection->getProperty('gallery_config')->setValue($controller, $gallery_config);
			$reflection->getProperty('helper')->setValue($controller, $helper);

			$this->assertSame($expected, $reflection->getMethod('get_image_action')->invoke($controller, 77, $next, $can_download_source), $mode);
		}
	}

	public function test_image_templates_keep_the_current_image_centred_at_navigation_edges(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$this->assertStringContainsString('<ul class="gallery-image-navigation">', $template, $style);
			$this->assertStringContainsString('gallery-image-navigation-previous">{% if U_PREV_IMAGE %}', $template, $style);
			$this->assertStringContainsString('gallery-image-navigation-current">{% if UC_IMAGE_ACTION %}<a', $template, $style);
			$this->assertStringContainsString('gallery-image-navigation-next">{% if U_NEXT_IMAGE %}', $template, $style);
			$this->assertSame(2, substr_count($template, 'gallery-image-navigation-placeholder'), $style);
			$this->assertStringContainsString('{% if UC_IMAGE_ACTION %}</a>{% endif %}</li>', $template, $style);
		}
	}

	public function test_image_navigation_keeps_the_current_image_larger_than_side_previews(): void
	{
		$css = (string) file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1fr) minmax(260px, 1.6fr) minmax(0, 1fr);', $css);
		$this->assertStringContainsString('object-fit: contain;', $css);

		$this->assertSame(1, preg_match('/\.gallery-image-navigation-side img\s*\{[^}]*width:\s*auto;[^}]*max-width:\s*min\(100%,\s*(\d+)px\);/s', $css, $side_sizes));
		$this->assertSame(1, preg_match('/\.gallery-image-navigation-current img\s*\{[^}]*width:\s*auto;[^}]*max-width:\s*min\(100%,\s*(\d+)px\);/s', $css, $current_sizes));
		$this->assertGreaterThan((int) $side_sizes[1], (int) $current_sizes[1]);
		$this->assertStringNotContainsString('width: clamp(', $css);
	}

	public function test_legacy_navigation_links_escape_stored_image_names(): void
	{
		require_once dirname(__DIR__, 4) . '/vendor/symfony/routing/RequestContextAwareInterface.php';
		require_once dirname(__DIR__, 4) . '/vendor/symfony/routing/Generator/UrlGeneratorInterface.php';
		require_once dirname(__DIR__, 4) . '/phpbb/controller/helper.php';
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$helper = $this->createStub(\phpbb\controller\helper::class);
		$helper->method('route')->willReturnCallback(static function (string $route, array $parameters): string
		{
			return '/' . $route . '/' . $parameters['image_id'];
		});
		$reflection->getProperty('helper')->setValue($controller, $helper);
		$build = $reflection->getMethod('build_legacy_navigation_link');
		$image_data = ['image_id' => 9, 'image_name' => '"><script>alert(1)</script>'];

		$link = $build->invoke($controller, $image_data, false, false);
		$thumbnail = $build->invoke($controller, $image_data, true, true);

		$this->assertStringNotContainsString('<script>', $link);
		$this->assertStringContainsString('&lt;script&gt;', $link);
		$this->assertStringNotContainsString('<script>', $thumbnail);
		$this->assertStringContainsString('alt="&quot;&gt;&lt;script&gt;', $thumbnail);
		$this->assertSame('', $build->invoke($controller, false, false, false));
	}

	public function test_navigation_visibility_conditions_respect_moderation_access(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->exactly(2))
			->method('acl_check')
			->with('m_status', 7, 0)
			->willReturnOnConsecutiveCalls(true, false);
		$user = new \phpbb\user();
		$user->data = ['user_id' => 42];
		$reflection->getProperty('gallery_auth')->setValue($controller, $gallery_auth);
		$reflection->getProperty('user')->setValue($controller, $user);
		$conditions = $reflection->getMethod('get_image_visibility_conditions');

		$this->assertSame([
			'image_album_id = 7',
			'image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN,
			'image_status <> ' . \phpbbgallery\core\block::STATUS_DELETE_REQUESTED,
		], $conditions->invoke($controller, 7, 0));
		$this->assertSame([
			'image_album_id = 7',
			'image_status <> ' . \phpbbgallery\core\block::STATUS_ORPHAN,
			'image_status <> ' . \phpbbgallery\core\block::STATUS_DELETE_REQUESTED,
			'(image_status = ' . \phpbbgallery\core\block::STATUS_APPROVED . ' OR image_user_id = 42)',
		], $conditions->invoke($controller, 7, 0));
	}

	public function test_direct_moderator_deletion_preserves_the_pending_request_race_guard(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString('STATUS_DELETE_REQUESTED', $source);
		$this->assertStringContainsString('delete_requested_images([$image_id]) !== 1', $source);
	}

	public function test_image_poster_profile_fields_are_assigned_to_safe_root_blocks(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$profile_data = ['favourite_camera' => ['value' => 'Camera']];
		$profile_manager = $this->createMock(\phpbb\profilefields\manager::class);
		$profile_manager->expects($this->once())
			->method('generate_profile_fields_template_data')
			->with($profile_data)
			->willReturn([
				'row' => ['PROFILE_CAMERA_VALUE' => 'Camera'],
				'blockrow' => [
					[
						'S_PROFILE_CONTACT' => false,
						'PROFILE_FIELD_IDENT' => 'camera',
						'PROFILE_FIELD_NAME' => 'Camera',
						'PROFILE_FIELD_VALUE' => 'Camera',
					],
					[
						'S_PROFILE_CONTACT' => true,
						'PROFILE_FIELD_IDENT' => 'website',
						'PROFILE_FIELD_NAME' => 'Website',
						'PROFILE_FIELD_CONTACT' => 'https://example.test',
					],
				],
			]);
		$assigned_vars = [];
		$assigned_blocks = [];
		$template = $this->createMock(\phpbb\template\template::class);
		$template->method('assign_vars')->willReturnCallback(function (array $vars) use (&$assigned_vars): void
		{
			$assigned_vars = $vars;
		});
		$template->method('assign_block_vars')->willReturnCallback(function (string $block, array $vars) use (&$assigned_blocks): void
		{
			$assigned_blocks[$block][] = $vars;
		});
		$reflection->getProperty('config')->setValue($controller, new \phpbb\config\config(['load_cpf_viewtopic' => true]));
		$reflection->getProperty('cpf_manager')->setValue($controller, $profile_manager);
		$reflection->getProperty('template')->setValue($controller, $template);
		$reflection->getProperty('profile_fields_data')->setValue($controller, [42 => $profile_data]);

		$reflection->getMethod('assign_image_poster_profile_fields')->invoke($controller, 42);

		$this->assertSame(['PROFILE_CAMERA_VALUE' => 'Camera'], $assigned_vars);
		$this->assertSame('camera', $assigned_blocks['custom_fields'][0]['PROFILE_FIELD_IDENT']);
		$this->assertSame('https://example.test', $assigned_blocks['contact'][0]['U_CONTACT']);
	}

	public function test_hidden_poster_clears_every_profile_surface(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$assigned_vars = [];
		$template = $this->createMock(\phpbb\template\template::class);
		$template->expects($this->exactly(2))
			->method('destroy_block_vars')
			->with($this->logicalOr('contact', 'custom_fields'));
		$template->expects($this->once())
			->method('assign_vars')
			->willReturnCallback(function (array $vars) use (&$assigned_vars): void
			{
				$assigned_vars = $vars;
			});
		$reflection->getProperty('template')->setValue($controller, $template);

		$reflection->getMethod('assign_hidden_poster')->invoke($controller, '<strong>Private</strong>');

		$this->assertSame('<strong>Private</strong>', $assigned_vars['POSTER_FULL']);
		$this->assertSame('<strong>Private</strong>', $assigned_vars['POSTER_USERNAME']);
		$this->assertTrue($assigned_vars['S_PRIVATE_IDENTITY_HIDDEN']);
		$this->assertFalse($assigned_vars['S_POSTER_ONLINE']);
		$this->assertFalse($assigned_vars['S_CUSTOM_FIELDS']);
		foreach (['POSTER_AVATAR', 'POSTER_SIGNATURE', 'POSTER_IP', 'U_POSTER', 'U_POSTER_EMAIL',
			'U_POSTER_JABBER', 'U_POSTER_PM', 'U_POSTER_SEARCH'] as $private_variable)
		{
			$this->assertSame('', $assigned_vars[$private_variable], $private_variable);
		}
	}

	public function test_direct_image_page_reasserts_contest_privacy_after_extension_event(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$event_position = strpos($source, 'trigger_event(\'phpbbgallery.core.viewimage\'');
		$privacy_reassertion = strpos($source, '$hide_private_data = $hide_private_data ||', (int) $event_position);

		$this->assertNotFalse($event_position);
		$this->assertNotFalse($privacy_reassertion);
		$this->assertGreaterThan($event_position, $privacy_reassertion);
		$this->assertStringContainsString('$this->image_visibility->private_data_description(', $source);
		$this->assertStringContainsString('$this->image_visibility->award(', $source);
		$this->assertStringNotContainsString('lang(\'CONTEST_IMAGE_DESC\'', $source);
		$this->assertStringNotContainsString("['image_contest_rank']", $source);
		$this->assertStringContainsString('$this->album_operation_message(', $source);
		$this->assertStringNotContainsString('CONTEST_COMMENTS_STARTS', $source);
		$this->assertStringContainsString('if (!$hide_results && $this->gallery_config->get', $source);
		$this->assertStringContainsString('$this->image_visibility->hides_private_data(', $source);
		$this->assertStringContainsString('$this->image_visibility->hides_results(', $source);
		$this->assertStringNotContainsString('core\\contest::', $source);
	}

	public function test_comment_operation_message_uses_extension_boundary_and_safe_fallback(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$dispatcher = new class implements \phpbb\event\dispatcher_interface
		{
			public function trigger_event($event_name, $data = [])
			{
				if ((string) $event_name !== 'phpbbgallery.core.album_operation.message')
				{
					throw new \UnexpectedValueException((string) $event_name);
				}
				$data['message'] = '';
				return $data;
			}
		};
		$reflection->getProperty('dispatcher')->setValue($controller, $dispatcher);

		$message = $reflection->getMethod('album_operation_message')->invoke(
			$controller,
			'comment',
			['album_id' => 3],
			['image_id' => 7],
			'Comments unavailable'
		);

		$this->assertSame('Comments unavailable', $message);
	}

	public function test_image_controller_receives_the_neutral_visibility_policy(): void
	{
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$image_service = strstr($services, 'phpbbgallery.core.controller.image:');
		$image_service = strstr($image_service, 'phpbbgallery.core.controller.index:', true);

		$this->assertStringContainsString(
			"- '@phpbbgallery.core.policy.image_visibility'",
			$image_service
		);
	}

	public function test_view_counter_remains_page_owned_and_sort_order_has_no_duplicate_suffix(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString('SET image_view_count = image_view_count + 1', $source);
		$this->assertStringContainsString("->inc('num_views', 1, false)", $source);
		$this->assertStringContainsString("ORDER BY ' . \$sql_sort_order;", $source);
		$this->assertStringNotContainsString("ORDER BY ' . \$sql_sort_order . \$sql_help_sort", $source);
	}

	public function test_deleted_comment_users_keep_their_stored_identity_without_a_profile_link(): void
	{
		if (!defined('ANONYMOUS'))
		{
			define('ANONYMOUS', 1);
		}

		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$prepare = $reflection->getMethod('prepare_comment_poster');
		$comment = [
			'comment_user_id' => 55,
			'comment_username' => 'Former member',
			'comment_user_colour' => 'abcdef',
		];

		$this->assertSame([
			'user_deleted' => true,
			'poster_id' => ANONYMOUS,
			'username' => 'Former member',
			'user_colour' => 'abcdef',
		], $prepare->invoke($controller, $comment, []));

		$this->assertSame([
			'user_deleted' => false,
			'poster_id' => 55,
			'username' => 'Current member',
			'user_colour' => '123456',
		], $prepare->invoke($controller, $comment, ['username' => 'Current member', 'user_colour' => '123456']));
	}

	public function test_comment_display_does_not_use_an_undefined_user_cache(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringNotContainsString('$user_cache', $source);
		$this->assertStringContainsString('$can_receive_pm = !$user_deleted &&', $source);
		$this->assertStringContainsString('$user_data[\'email\'] ?? \'\'', $source);
	}

	public function test_comment_rows_expose_the_signature_expected_by_all_styles(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$start = strpos($source, '$comment_row = [');
		$end = strpos($source, '];', $start);
		$comment_row = substr($source, $start, $end - $start);

		$this->assertStringContainsString("'SIGNATURE'", $comment_row);
		$this->assertStringNotContainsString("'POSTER_SIGNATURE'", $comment_row);
	}
}
