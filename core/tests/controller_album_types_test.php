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
		$this->assertSame('t', $normalizer->invoke($controller, 't../../../../../../windows/system32/config/sam', $sort_columns));
		$this->assertSame('n', $normalizer->invoke($controller, 'n', $sort_columns));
	}

	public function test_album_images_use_the_neutral_privacy_policy(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');

		$this->assertStringContainsString('$this->image_visibility->hides_private_data(', $source);
		$this->assertStringContainsString('$this->image_visibility->hides_results(', $source);
		$this->assertStringContainsString('$this->image_visibility->restricted_sort_keys(', $source);
		$this->assertStringContainsString('$this->image_visibility->award(', $source);
		$this->assertStringNotContainsString('core\\contest::', $source);
		$this->assertStringNotContainsString("album_data['contest_marked']", $source);
		$this->assertStringNotContainsString("image_data['image_contest_rank']", $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$album_service = strstr($services, 'phpbbgallery.core.controller.album:');
		$album_service = strstr($album_service, 'phpbbgallery.core.controller.file:', true);
		$this->assertStringContainsString(
			"- '@phpbbgallery.core.policy.image_visibility'",
			$album_service
		);
	}

	public function test_album_addons_enrich_only_the_bounded_visible_image_page(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');
		$event = strpos($source, 'phpbbgallery.core.album.image_template_vars');
		$fetch = strrpos(substr($source, 0, (int) $event), 'while ($row = $this->db->sql_fetchrow($result))');
		$free = strrpos(substr($source, 0, (int) $event), '$this->db->sql_freeresult($result)');
		$display = strpos($source, 'foreach ($images as $row)', (int) $event);
		$merge = strpos($source, 'array_merge($template_vars, $image_template_vars[$image_id])', (int) $display);

		$this->assertNotFalse($event);
		$this->assertNotFalse($fetch);
		$this->assertNotFalse($free);
		$this->assertNotFalse($display);
		$this->assertNotFalse($merge);
		$this->assertTrue($fetch < $free && $free < $event && $event < $display && $display < $merge);
		$this->assertStringContainsString('$image_template_vars = []', $source);
		$this->assertStringContainsString('isset($image_template_vars[$image_id])', $source);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(
				dirname(__DIR__) . '/styles/' . $style . '/template/gallery/imageblock_polaroid.html'
			);
			$this->assertStringContainsString('gallery-image-card', $template, $style);
			$this->assertStringContainsString('{% EVENT phpbbgallery_core_album_image_actions %}', $template, $style);
			$this->assertStringContainsString('{% EVENT phpbbgallery_core_album_image_metadata %}', $template, $style);
			$this->assertStringContainsString('image.IMAGE_RESOLUTION', $template, $style);
		}
	}

	public function test_album_cards_offer_ajax_rating_only_to_eligible_users(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');
		$batch_lookup = strpos($source, '$this->gallery_rating->get_user_ratings(');
		$image_loop = strpos($source, 'foreach ($images as $row)', (int) $batch_lookup);

		$this->assertNotFalse($batch_lookup);
		$this->assertNotFalse($image_loop);
		$this->assertTrue($batch_lookup < $image_loop);
		$this->assertStringContainsString('array_key_exists($image_id, $user_ratings)', $source);
		$this->assertStringContainsString('$this->gallery_rating->is_able()', $source);
		$this->assertStringContainsString("'S_CAN_RATE'", $source);
		$this->assertStringContainsString("'U_RATE_ACTION'", $source);
		$this->assertStringContainsString("add_form_key('gallery')", $source);
		$this->assertStringNotContainsString("'#rating'", $source);
		$this->assertStringNotContainsString("'U_RATINGS'", $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$album_service = strstr($services, 'phpbbgallery.core.controller.album:');
		$album_service = strstr($album_service, 'phpbbgallery.core.controller.file:', true);
		$this->assertStringContainsString("- '@phpbbgallery.core.rating'", $album_service);

		$partial = (string) file_get_contents(dirname(__DIR__) . '/styles/all/template/gallery/album_rating_stars.html');
		$this->assertStringContainsString('data-gallery-rating-remove-after-submit', $partial);
		$this->assertStringContainsString('data-gallery-rating-trigger', $partial);
		$this->assertStringContainsString('data-gallery-rating-form hidden', $partial);
		$this->assertStringContainsString('aria-controls="gallery-album-rating-{{ image.IMAGE_ID }}"', $partial);
		$this->assertStringContainsString('image.U_RATE_ACTION', $partial);
		$this->assertStringContainsString('type="button"', $partial);
		$this->assertStringNotContainsString('<a ', $partial);

		$script = (string) file_get_contents(dirname(__DIR__) . '/styles/all/template/js/rating.js');
		$this->assertStringContainsString('data-gallery-rating-remove-after-submit', $script);
		$this->assertStringContainsString("closest('[data-gallery-rating-trigger]')", $script);
		$this->assertStringContainsString('form.hidden = !opening', $script);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$card = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/imageblock_polaroid.html');
			$album = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/album_body.html');
			$this->assertStringContainsString('@phpbbgallery_core/gallery/album_rating_stars.html', $card, $style);
			$this->assertStringNotContainsString('image.U_RATINGS', $card, $style);
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/rating.js'", $album, $style);
		}
	}

	public function test_contest_finalization_runs_only_after_album_access_checks(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');
		$permissions = strpos($source, '$this->check_permissions(');
		$display = strpos($source, '$this->auth_level->display(', (int) $permissions);
		$prepare = strpos($source, 'phpbbgallery.core.album.prepare_display', (int) $display);

		$this->assertNotFalse($permissions);
		$this->assertNotFalse($display);
		$this->assertNotFalse($prepare);
		$this->assertTrue($permissions < $display && $display < $prepare);
		$this->assertStringNotContainsString('$this->contest->', $source);
	}

	public function test_upload_link_uses_the_neutral_album_operation_policy(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/controller/album.php');
		$this->assertStringContainsString('$this->album_operation->allows(\'upload\', $album_data)', $source);
		$this->assertStringNotContainsString('array_key_exists(\'contest_start\'', $source);

		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services_controller.yml');
		$album_service = strstr($services, 'phpbbgallery.core.controller.album:');
		$album_service = strstr($album_service, 'phpbbgallery.core.controller.file:', true);
		$this->assertStringContainsString(
			"- '@phpbbgallery.core.policy.album_operation'",
			$album_service
		);
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

	public function test_invalid_sort_directions_fall_back_to_descending(): void
	{
		$reflection = new \ReflectionClass(album::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$normalizer = $reflection->getMethod('normalize_sort_direction');

		$this->assertSame('a', $normalizer->invoke($controller, 'a'));
		$this->assertSame('d', $normalizer->invoke($controller, 'd'));
		$this->assertSame('d', $normalizer->invoke($controller, 'd../../../../tmp'));
	}

	public function test_album_display_flags_remain_stable(): void
	{
		$this->assertSame(256, album::ALBUM_SHOW_RESOLUTION);
		$this->assertSame(128, album::ALBUM_SHOW_IP);
		$this->assertSame(64, album::ALBUM_SHOW_RATINGS);
		$this->assertSame(32, album::ALBUM_SHOW_USERNAME);
		$this->assertSame(16, album::ALBUM_SHOW_VIEWS);
		$this->assertSame(8, album::ALBUM_SHOW_TIME);
		$this->assertSame(4, album::ALBUM_SHOW_IMAGENAME);
		$this->assertSame(2, album::ALBUM_SHOW_COMMENTS);
		$this->assertSame(1, album::ALBUM_SHOW_ALBUM);
	}

	public function test_only_registered_non_bot_users_can_watch_albums(): void
	{
		$reflection = new \ReflectionClass(album::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$user = new \phpbb\user();
		$reflection->getProperty('user')->setValue($controller, $user);
		$can_watch = $reflection->getMethod('can_watch_album');

		$user->data = ['is_registered' => true, 'is_bot' => false];
		$this->assertTrue($can_watch->invoke($controller));
		$user->data = ['is_registered' => false, 'is_bot' => false];
		$this->assertFalse($can_watch->invoke($controller));
		$user->data = ['is_registered' => true, 'is_bot' => true];
		$this->assertFalse($can_watch->invoke($controller));
	}

	public function test_album_search_requires_phpbb_search_and_user_permission(): void
	{
		$reflection = new \ReflectionClass(album::class);
		$controller = $reflection->newInstanceWithoutConstructor();
		$config = new \phpbb\config\config(['load_search' => true]);
		$auth = $this->getMockBuilder(\phpbb\auth\auth::class)
			->onlyMethods(['acl_get'])
			->getMock();
		$auth->expects($this->exactly(2))
			->method('acl_get')
			->with('u_search')
			->willReturnOnConsecutiveCalls(true, false);
		$reflection->getProperty('config')->setValue($controller, $config);
		$reflection->getProperty('phpbb_auth')->setValue($controller, $auth);
		$can_search = $reflection->getMethod('can_search_album');

		$this->assertTrue($can_search->invoke($controller));
		$this->assertFalse($can_search->invoke($controller));

		$config['load_search'] = false;
		$this->assertFalse($can_search->invoke($controller));
	}

	public function test_album_search_forms_keep_the_album_scope_in_every_style(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/album_body.html');
			$this->assertStringContainsString('method="get" id="album-search"', $template, $style);
			$this->assertStringContainsString('name="aid[]"', $template, $style);
			$this->assertStringContainsString('name="sc"', $template, $style);
			$this->assertSame(1, substr_count($template, 'id="search_keywords"'), $style);
		}
	}

	public function test_watch_action_is_not_coupled_to_upload_permission_in_any_style(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/album_body.html');
			$this->assertStringContainsString('{% if not S_IN_GALLERY_POPUP and U_WATCH_TOGGLE %}', $template, $style);
			$this->assertStringNotContainsString('U_WATCH_TOGLE', $template, $style);
		}
	}

	public function test_album_information_uses_native_responsive_panels_and_accepts_addon_rules(): void
	{
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/album_body.html');
			$this->assertStringContainsString('class="row gallery-album-information"', $template, $style);
			$this->assertStringContainsString('class="panel panel-forum panel-whois"', $template, $style);
			$this->assertStringContainsString("lang('ALBUM_PERMISSIONS')", $template, $style);
			$this->assertStringContainsString('{% for information in gallery_album_information|default([]) %}', $template, $style);
			$this->assertStringContainsString('{% for rule in information.rules %}', $template, $style);
			$this->assertStringNotContainsString('<div class="side-segment"><h3>{{ lang(\'ALBUM_PERMISSIONS\') }}</h3></div>', $template, $style);
		}

		$prosilver = (string) file_get_contents(dirname(__DIR__) . '/styles/prosilver/template/gallery/album_body.html');
		$this->assertStringContainsString('{% for information in gallery_album_information|default([]) %}', $prosilver);
		$this->assertStringContainsString('{{ information.TITLE }}', $prosilver);
	}
}
