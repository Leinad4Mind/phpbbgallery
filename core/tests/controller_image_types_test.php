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
		$reflection->getProperty('excluded_personal_album_ids')->setValue($controller, [9]);

		$reflection->getMethod('reset_request_state')->invoke($controller);

		foreach (['data', 'users_id_array', 'users_data_array', 'profile_fields_data', 'can_receive_pm_list'] as $property_name)
		{
			$this->assertSame([], $reflection->getProperty($property_name)->getValue($controller));
		}
		$this->assertNull($reflection->getProperty('excluded_personal_album_ids')->getValue($controller));
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

	public function test_open_graph_description_is_plain_bounded_and_uses_safe_fallbacks(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$builder = $reflection->getMethod('build_open_graph_description');

		$this->assertSame(
			'Gallery description & details',
			$builder->invoke($controller, '<strong>Gallery</strong>  description &amp; details', '', 'Image name', 'Album')
		);
		$this->assertSame(
			'Private image name',
			$builder->invoke($controller, '', '', 'Private image name', 'Private album')
		);
		$this->assertSame(
			'Album fallback',
			$builder->invoke($controller, '', '', '', 'Album fallback')
		);

		$bounded = $builder->invoke($controller, str_repeat("\u{00E1}", 400), '', '', '');
		$this->assertSame(300, mb_strlen($bounded, 'UTF-8'));
		$this->assertStringEndsWith('...', $bounded);
	}

	public function test_image_pages_assign_share_safe_open_graph_metadata_after_privacy_checks(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$privacy_position = strpos($source, '$hide_private_data = $hide_private_data ||');
		$metadata_position = strpos($source, "'S_GALLERY_OPEN_GRAPH' => true");

		$this->assertNotFalse($privacy_position);
		$this->assertNotFalse($metadata_position);
		$this->assertGreaterThan($privacy_position, $metadata_position);
		$this->assertStringContainsString("'U_CANONICAL' => \$canonical_url", $source);
		$this->assertStringContainsString("'phpbbgallery_core_image_file_medium'", $source);
		$this->assertStringContainsString("\$hide_private_data ? '' : \$image_desc", $source);
		$this->assertStringContainsString("\$hide_private_data ? '' : \$image_subtitle", $source);
	}

	public function test_gallery_open_graph_template_declares_required_social_metadata(): void
	{
		$template = (string) file_get_contents(
			dirname(__DIR__) . '/styles/all/template/event/overall_header_head_append.html'
		);

		$this->assertStringContainsString('{% if S_GALLERY_OPEN_GRAPH %}', $template);
		foreach (['og:url', 'og:title', 'og:description', 'og:image', 'og:image:alt'] as $property)
		{
			$this->assertStringContainsString('property="' . $property . '"', $template, $property);
		}
		foreach (['twitter:card', 'twitter:title', 'twitter:description', 'twitter:image'] as $name)
		{
			$this->assertStringContainsString('name="' . $name . '"', $template, $name);
		}
		$this->assertGreaterThanOrEqual(8, substr_count($template, "|e('html_attr')"));
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
			$this->assertSame(2, substr_count($template, 'gallery-image-navigation-icon-link'), $style);
			$this->assertStringContainsString('fa-chevron-left', $template, $style);
			$this->assertStringContainsString('fa-chevron-right', $template, $style);
			$this->assertStringContainsString('<span class="sr-only">{{ PREV_IMAGE_NAME }}</span>', $template, $style);
			$this->assertStringContainsString('<span class="sr-only">{{ NEXT_IMAGE_NAME }}</span>', $template, $style);
			$this->assertStringContainsString('{% if UC_IMAGE_ACTION %}</a>{% endif %}</li>', $template, $style);
		}
	}

	public function test_image_navigation_keeps_the_current_image_larger_than_side_previews(): void
	{
		$css = (string) file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('grid-template-columns: minmax(0, 1fr) minmax(260px, 1.6fr) minmax(0, 1fr);', $css);
		$this->assertStringContainsString('object-fit: contain;', $css);
		$this->assertStringContainsString('.gallery-image-navigation-icon-link {', $css);
		$this->assertStringContainsString(".gallery-image-navigation-previous,\n.gallery-image-navigation-next {\n\tjustify-content: center;", $css);
		$this->assertStringContainsString('.gallery-image-navigation-chevron {', $css);
		$this->assertSame(1, preg_match('/\.gallery-image-navigation-icon-link\s*\{([^}]*)\}/s', $css, $icon_link_styles));
		$this->assertStringNotContainsString('border', $icon_link_styles[1]);
		$this->assertStringNotContainsString('border-radius', $icon_link_styles[1]);
		$this->assertStringNotContainsString('box-shadow', $icon_link_styles[1]);
		$this->assertStringNotContainsString('aspect-ratio', $icon_link_styles[1]);

		$this->assertSame(1, preg_match('/\.gallery-image-navigation-side img\s*\{[^}]*width:\s*auto;[^}]*max-width:\s*min\(100%,\s*(\d+)px\);/s', $css, $side_sizes));
		$this->assertSame(1, preg_match('/\.gallery-image-navigation-current img\s*\{[^}]*width:\s*auto;[^}]*max-width:\s*min\(100%,\s*(\d+)px\);/s', $css, $current_sizes));
		$this->assertGreaterThan((int) $side_sizes[1], (int) $current_sizes[1]);
		$this->assertStringNotContainsString('width: clamp(', $side_sizes[0]);
		$this->assertStringNotContainsString('width: clamp(', $current_sizes[0]);
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
					[
						'S_PROFILE_CONTACT' => true,
						'PROFILE_FIELD_IDENT' => 'gallery_palbum',
						'PROFILE_FIELD_NAME' => 'Gallery',
						'PROFILE_FIELD_CONTACT' => 'https://example.test/gallery/album/7',
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
		$this->assertCount(1, $assigned_blocks['contact']);
		$this->assertSame('https://example.test', $assigned_blocks['contact'][0]['U_CONTACT']);
	}

	public function test_personal_album_link_is_permission_filtered_and_zebra_list_is_loaded_once(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$gallery_auth = $this->createMock(\phpbbgallery\core\auth\auth::class);
		$gallery_auth->expects($this->once())->method('get_exclude_zebra')->willReturn([99]);
		$gallery_auth->expects($this->exactly(2))->method('acl_check')->willReturn(true);
		$helper = $this->createMock(\phpbb\controller\helper::class);
		$helper->expects($this->once())
			->method('route')
			->with('phpbbgallery_core_album', ['album_id' => 12])
			->willReturn('/gallery/album/12');
		$reflection->getProperty('gallery_auth')->setValue($controller, $gallery_auth);
		$reflection->getProperty('helper')->setValue($controller, $helper);

		$method = $reflection->getMethod('visible_personal_album_url');
		$this->assertSame('/gallery/album/12', $method->invoke($controller, ['user_id' => 42, 'personal_album_id' => 12]));
		$this->assertSame('', $method->invoke($controller, ['user_id' => 43, 'personal_album_id' => 99]));
		$this->assertSame('', $method->invoke($controller, ['user_id' => 44, 'personal_album_id' => 0]));
	}

	public function test_personal_album_is_presented_separately_from_contacts_in_every_style(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$this->assertStringContainsString('=== self::PERSONAL_ALBUM_PROFILE_FIELD', $source);
		$this->assertStringContainsString("'U_POSTER_PERSONAL_ALBUM' => \$this->visible_personal_album_url(\$user_data)", $source);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$this->assertStringContainsString('U_POSTER_PERSONAL_ALBUM', $template, $style);
			$this->assertStringContainsString('commentrow.U_POSTER_PERSONAL_ALBUM', $template, $style);
			$this->assertStringContainsString("lang('PERSONAL_ALBUM')", $template, $style);
		}
	}

	public function test_standard_contacts_are_filtered_and_support_root_and_comment_blocks(): void
	{
		$reflection = new \ReflectionClass(image::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$assigned_blocks = [];
		$template = $this->createMock(\phpbb\template\template::class);
		$template->method('assign_block_vars')->willReturnCallback(function (string $block, array $vars) use (&$assigned_blocks): void
		{
			$assigned_blocks[$block][] = $vars;
		});
		$language = $this->createMock(\phpbb\language\language::class);
		$language->method('lang')->willReturnCallback(static fn(string $key): string => $key);
		$reflection->getProperty('template')->setValue($controller, $template);
		$reflection->getProperty('language')->setValue($controller, $language);

		$assign_contacts = $reflection->getMethod('assign_standard_contact_fields');
		$assign_contacts->invoke($controller, 'contact', '/ucp.php?i=pm&amp;u=42', '/memberlist.php?mode=email&amp;u=42', '');
		$assign_contacts->invoke($controller, 'commentrow.contact', '', '', '/memberlist.php?mode=contact&amp;u=42');

		$this->assertSame([
			[
				'ID' => 'pm',
				'NAME' => 'SEND_PRIVATE_MESSAGE',
				'U_CONTACT' => '/ucp.php?i=pm&amp;u=42',
			],
			[
				'ID' => 'email',
				'NAME' => 'SEND_EMAIL',
				'U_CONTACT' => '/memberlist.php?mode=email&amp;u=42',
			],
		], $assigned_blocks['contact']);
		$this->assertSame([
			[
				'ID' => 'jabber',
				'NAME' => 'JABBER',
				'U_CONTACT' => '/memberlist.php?mode=contact&amp;u=42',
			],
		], $assigned_blocks['commentrow.contact']);

		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');
		$this->assertStringContainsString('assign_standard_contact_fields(\'contact\'', $source);
		$this->assertStringContainsString('\'commentrow.contact\'', $source);
		$this->assertStringContainsString('\'i=pm&amp;mode=compose&amp;u=\' . $display_poster_id', $source);
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

	public function test_rating_result_visibility_is_independent_from_permission_to_vote(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/image.php');

		$this->assertStringContainsString("'S_RATING_VISIBLE'  => !\$hide_results", $source);
		$this->assertStringContainsString('$can_rate = !$user_rating && $rating->is_able()', $source);
		$this->assertStringContainsString("'S_ALLOWED_TO_RATE' => \$can_rate", $source);
		$this->assertStringContainsString("'S_VIEW_RATE'       => !\$hide_results", $source);
		$this->assertStringNotContainsString("'S_VIEW_RATE'       => (\$this->gallery_auth->acl_check('i_rate'", $source);
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
