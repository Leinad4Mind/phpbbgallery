<?php
/**
 * phpBB Gallery - Message editor selector frontend contract tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class editor_selector_frontend_test extends TestCase
{
	public function test_full_and_quick_editors_expose_only_the_accessible_fallback_launcher(): void
	{
		foreach (['posting_editor_buttons_after.html', 'quickreply_editor_message_before.html'] as $template_name)
		{
			$template = $this->read('styles/all/template/event/' . $template_name);

			$this->assertStringContainsString('{% if S_GALLERY_SELECTOR %}', $template, $template_name);
			$this->assertStringContainsString('href="{{ U_GALLERY_SELECTOR_FALLBACK }}"', $template, $template_name);
			$this->assertStringContainsString('data-gallery-selector-open', $template, $template_name);
			$this->assertStringContainsString('aria-haspopup="dialog"', $template, $template_name);
			$this->assertStringContainsString('aria-controls="phpbbgallery-selector-dialog"', $template, $template_name);
			$this->assertStringNotContainsString('window.open', $template, $template_name);
		}
	}

	public function test_dialog_has_accessible_status_filter_and_pagination_controls(): void
	{
		$template = $this->read('styles/all/template/event/overall_footer_after.html');

		$this->assertStringContainsString('{% if S_GALLERY_SELECTOR %}', $template);
		$this->assertStringContainsString('<dialog id="phpbbgallery-selector-dialog"', $template);
		$this->assertStringContainsString('data-endpoint="{{ U_GALLERY_SELECTOR }}"', $template);
		$this->assertStringContainsString('aria-labelledby="phpbbgallery-selector-title"', $template);
		$this->assertStringContainsString('role="status" aria-live="polite"', $template);
		$this->assertStringContainsString('data-gallery-selector-album', $template);
		$this->assertStringContainsString('data-gallery-selector-previous disabled', $template);
		$this->assertStringContainsString('data-gallery-selector-next disabled', $template);
		$this->assertStringContainsString('type="button"', $template);
		$this->assertStringContainsString("{% INCLUDEJS '@phpbbgallery_core/js/editor_selector.js' %}", $template);
	}

	public function test_javascript_inserts_only_numeric_image_bbcode_at_the_active_editor_cursor(): void
	{
		$javascript = $this->read('styles/all/template/js/editor_selector.js');

		$this->assertStringContainsString('Number.isInteger(imageId)', $javascript);
		$this->assertStringContainsString("var bbcode = '[image]' + imageId + '[/image]'", $javascript);
		$this->assertStringContainsString("activeTrigger.closest('form')", $javascript);
		$this->assertStringContainsString("form.querySelector('textarea[name=\"message\"]')", $javascript);
		$this->assertStringContainsString('window.insert_text(bbcode, true)', $javascript);
		$this->assertStringContainsString('textarea.setRangeText(', $javascript);
		$this->assertStringContainsString("textarea.dispatchEvent(new Event('input', { bubbles: true }))", $javascript);
		$this->assertStringNotContainsString('[album]', $javascript);
		$this->assertStringNotContainsString('window.opener', $javascript);
		$this->assertStringNotContainsString('window.open(', $javascript);
	}

	public function test_javascript_uses_same_origin_json_and_escapes_database_text_through_dom_properties(): void
	{
		$javascript = $this->read('styles/all/template/js/editor_selector.js');

		$this->assertStringContainsString("credentials: 'same-origin'", $javascript);
		$this->assertStringContainsString("headers: { Accept: 'application/json' }", $javascript);
		$this->assertStringContainsString("url.searchParams.set('album_id'", $javascript);
		$this->assertStringContainsString("url.searchParams.set('page'", $javascript);
		$this->assertStringContainsString('Number(album.album_depth) || 0', $javascript);
		$this->assertStringContainsString('Math.max(0, Math.min(20,', $javascript);
		$this->assertStringContainsString('Array(depth + 1).join(', $javascript);
		$this->assertStringContainsString('u2014', $javascript);
		$this->assertStringContainsString('+ album.album_name', $javascript);
		$this->assertStringContainsString('thumbnail.alt = image.image_name', $javascript);
		$this->assertStringContainsString('name.textContent = image.image_name', $javascript);
		$this->assertStringNotContainsString('.innerHTML', $javascript);
	}

	public function test_javascript_restores_focus_and_supports_escape_and_keyboard_focus_containment(): void
	{
		$javascript = $this->read('styles/all/template/js/editor_selector.js');

		$this->assertStringContainsString('activeTrigger.focus()', $javascript);
		$this->assertStringContainsString("event.key === 'Escape'", $javascript);
		$this->assertStringContainsString("event.key !== 'Tab'", $javascript);
		$this->assertStringContainsString('event.shiftKey && document.activeElement === first', $javascript);
		$this->assertStringContainsString('document.activeElement === last', $javascript);
		$this->assertStringContainsString('closeButton.focus()', $javascript);
	}

	public function test_read_only_json_route_and_services_are_registered(): void
	{
		$routing = $this->read('config/routing.yml');
		$services = $this->read('config/services.yml');
		$controllers = $this->read('config/services_controller.yml');

		$this->assertStringContainsString('phpbbgallery_core_editor_images:', $routing);
		$this->assertStringContainsString('path: /gallery/editor/images', $routing);
		$this->assertStringContainsString('methods: [GET]', $routing);
		$this->assertStringContainsString('phpbbgallery.core.image.selector:', $services);
		$this->assertStringContainsString("- '@phpbbgallery.core.auth'", $services);
		$this->assertStringContainsString('phpbbgallery.core.editor_listener:', $services);
		$this->assertStringContainsString('- { name: event.listener }', $services);
		$this->assertStringContainsString('phpbbgallery.core.controller.editor:', $controllers);
		$this->assertStringContainsString("- '@phpbbgallery.core.image.selector'", $controllers);
	}

	private function read(string $relative_path): string
	{
		$content = file_get_contents(dirname(__DIR__) . '/' . $relative_path);
		$this->assertIsString($content, $relative_path);

		return $content;
	}
}
