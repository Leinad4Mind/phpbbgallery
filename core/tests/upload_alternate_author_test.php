<?php
/**
 * phpBB Gallery - Alternate upload author tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\upload;
use PHPUnit\Framework\TestCase;

final class upload_alternate_author_test extends TestCase
{
	public function test_trusted_author_identity_can_be_set_and_cleared(): void
	{
		$upload = (new \ReflectionClass(upload::class))->newInstanceWithoutConstructor();

		$upload->set_author(42, 'Target user', 'A1B2C3');
		$this->assertSame(42, $this->property($upload, 'author_user_id'));
		$this->assertSame('Target user', $this->property($upload, 'author_username'));
		$this->assertSame('A1B2C3', $this->property($upload, 'author_user_colour'));

		$upload->set_author(0, '', 'FFFFFF');
		$this->assertSame(0, $this->property($upload, 'author_user_id'));
		$this->assertSame('', $this->property($upload, 'author_username'));
		$this->assertSame('', $this->property($upload, 'author_user_colour'));
	}

	public function test_draft_owner_is_changed_only_during_finalization(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/upload.php');
		$insert = $this->section($source, "\n\tpublic function file_to_database(", "\n\t/**\n\t * Delete unfinished");
		$update = $this->section($source, "\n\tpublic function update_image(", "\n\t/**\n\t* Prepare file on upload");

		$this->assertStringContainsString("'image_user_id'\t\t\t=> \$this->user->data['user_id']", $insert);
		$this->assertStringNotContainsString('author_user_id', $insert);
		$this->assertStringContainsString("'image_user_id'        => \$this->author_user_id", $update);
		$this->assertStringContainsString("'image_username_clean' => utf8_clean_string(\$this->author_username)", $update);
		$this->assertStringContainsString('array_merge($this->image_data[$image_id], $sql_ary)', $update);
	}

	public function test_controller_accepts_author_only_with_album_moderator_permission(): void
	{
		$source = $this->controller_source();

		$this->assertStringContainsString("\$can_change_author = (bool) \$this->auth->acl_check('m_edit', \$album_id, \$album_data['album_user_id'])", $source);
		$this->assertStringContainsString("\$change_author = (\$can_change_author && \$mode === 'upload_edit') ? \$this->request->variable('change_author', '', true, request_interface::POST) : ''", $source);
		$this->assertStringContainsString("'S_CHANGE_AUTHOR'", $source);
		$this->assertStringContainsString('=> $can_change_author', $source);
		$this->assertStringContainsString("'CHANGE_AUTHOR'", $source);
		$this->assertStringContainsString('=> $change_author', $source);
		$this->assertStringContainsString("'U_CHANGE_AUTHOR_AUTOCOMPLETE'", $source);
	}

	public function test_invalid_ajax_author_is_rejected_before_upload(): void
	{
		$source = $this->controller_source();
		$ajax = strpos($source, "if (\$mode == 'upload' && \$is_ajax");
		$invalid = strpos($source, 'if ($invalid_author)', $ajax);
		$upload = strpos($source, '$process->upload_file(1)', $ajax);

		$this->assertNotFalse($ajax);
		$this->assertNotFalse($invalid);
		$this->assertNotFalse($upload);
		$this->assertLessThan($upload, $invalid);
		$this->assertStringContainsString("return \$this->ajax_error(\$this->language->lang('INVALID_USERNAME'))", substr($source, $invalid, $upload - $invalid));
	}

	public function test_target_author_drives_quota_finalization_and_notifications(): void
	{
		$source = $this->controller_source();

		$this->assertSame(3, substr_count($source, "WHERE image_user_id = ' . (int) \$upload_author_id"));
		$this->assertSame(1, substr_count($source, '$process->set_author('));
		$this->assertSame(1, substr_count($source, "'targets'    => [\$upload_author_id]"));
		$this->assertSame(1, substr_count($source, "'uploader'   => \$upload_author_id"));
		$this->assertSame(1, substr_count($source, '!$is_alternate_author && $this->gallery_user->get_data(\'watch_own\')'));
	}

	public function test_author_and_comments_are_present_only_during_upload_review(): void
	{
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/posting_body.html');
			$upload_start = strpos($template, '{% elseif S_UPLOAD %}');
			$review_start = strpos($template, '{% else %}', $upload_start);
			$this->assertNotFalse($upload_start, $style);
			$this->assertNotFalse($review_start, $style);

			$upload_form = substr($template, $upload_start, $review_start - $upload_start);
			$review_form = substr($template, $review_start);

			$this->assertStringNotContainsString('name="change_author"', $upload_form, $style);
			$this->assertStringNotContainsString('name="allow_comments"', $upload_form, $style);
			$this->assertStringContainsString('name="change_author"', $review_form, $style);
			$this->assertStringContainsString('name="allow_comments"', $review_form, $style);
			$this->assertStringContainsString('value="{{ CHANGE_AUTHOR }}"', $review_form, $style);
			$this->assertStringContainsString('data-gallery-author-autocomplete', $review_form, $style);
			$this->assertStringContainsString('U_CHANGE_AUTHOR_AUTOCOMPLETE', $review_form, $style);
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/author_autocomplete.js'", $template, $style);
			if ($style !== 'prosilver')
			{
				$this->assertStringContainsString('class="gallery-checkbox-label"', $review_form, $style);
			}
		}
	}

	public function test_first_step_cannot_set_review_only_metadata(): void
	{
		$source = $this->controller_source();

		$this->assertStringContainsString("\$allow_comments_default = \$mode !== 'upload_edit'", $source);
		$this->assertStringContainsString("(\$mode === 'upload_edit') ? \$this->request->variable('allow_comments'", $source);
		$this->assertStringContainsString('$process->set_allow_comments($allow_comments);', $source);
		$this->assertStringNotContainsString("\$process->set_allow_comments(\$this->request->variable('allow_comments'", $source);
	}

	public function test_author_suggestions_are_layered_above_the_upload_form(): void
	{
		$root = dirname(__DIR__);
		$stylesheet = (string) file_get_contents($root . '/styles/all/theme/gallery.css');
		$javascript = (string) file_get_contents($root . '/styles/all/template/js/author_autocomplete.js');

		$this->assertMatchesRegularExpression(
			'/\.gallery-author-autocomplete\s*\{[^}]*overflow:\s*visible;[^}]*position:\s*relative;[^}]*\}/s',
			$stylesheet
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-author-autocomplete\.is-open\s*\{[^}]*z-index:\s*10050;[^}]*\}/s',
			$stylesheet
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-author-suggestions\s*\{[^}]*z-index:\s*10060;[^}]*\}/s',
			$stylesheet
		);
		$this->assertStringContainsString("container.classList.add('is-open')", $javascript);
		$this->assertStringContainsString("container.classList.remove('is-open')", $javascript);
	}

	private function property(upload $upload, string $name): mixed
	{
		return (new \ReflectionProperty(upload::class, $name))->getValue($upload);
	}

	private function controller_source(): string
	{
		return (string) file_get_contents(dirname(__DIR__) . '/controller/upload.php');
	}

	private function section(string $source, string $start, string $end): string
	{
		$start_position = strpos($source, $start);
		$this->assertNotFalse($start_position);
		$end_position = strpos($source, $end, $start_position + strlen($start));
		$this->assertNotFalse($end_position);

		return substr($source, $start_position, $end_position - $start_position);
	}
}
