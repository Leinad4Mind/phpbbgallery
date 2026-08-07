<?php
/**
 * phpBB Gallery - Message editor selector close behaviour test
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class editor_selector_close_test extends TestCase
{
	public function test_full_editor_launcher_moves_to_the_end_of_the_bbcode_toolbar(): void
	{
		$template = file_get_contents(dirname(__DIR__) . '/styles/all/template/event/posting_editor_buttons_after.html');
		$javascript = file_get_contents(dirname(__DIR__) . '/styles/all/template/js/editor_selector.js');
		$stylesheet = file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');
		$this->assertIsString($template);
		$this->assertIsString($javascript);
		$this->assertIsString($stylesheet);

		$this->assertStringContainsString('data-gallery-selector-toolbar', $template);
		$this->assertStringContainsString("form.querySelector('#format-buttons, .posting-btns')", $javascript);
		$this->assertStringContainsString('toolbar.appendChild(trigger)', $javascript);
		$this->assertStringContainsString('#format-buttons > .phpbbgallery-selector-launch', $stylesheet);
		$this->assertStringContainsString('.posting-btns > .phpbbgallery-selector-launch', $stylesheet);
	}

	public function test_successful_image_insertion_closes_the_selector_dialog(): void
	{
		$javascript = file_get_contents(dirname(__DIR__) . '/styles/all/template/js/editor_selector.js');
		$this->assertIsString($javascript);

		$this->assertMatchesRegularExpression(
			'/textarea\.dispatchEvent\([^;]+;\s*setStatus\([^;]+;\s*closeDialog\(\);/',
			$javascript
		);
	}
}
