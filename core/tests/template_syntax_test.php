<?php
/**
 * phpBB Gallery - Native Twig template tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Source;
use Twig\TwigFilter;
use Twig\TwigFunction;

final class template_syntax_test extends TestCase
{
	public function test_modernized_templates_use_only_native_twig_syntax(): void
	{
		$template_paths = $this->template_paths();
		$this->assertCount(187, $template_paths);

		foreach ($template_paths as $template_path)
		{
			$source = file_get_contents($template_path);
			$this->assertDoesNotMatchRegularExpression(
				'/<!--\s*(?:BEGIN|BEGINELSE|END|IF|ELSEIF|ELSE|ENDIF|INCLUDE|DEFINE|UNDEFINE|EVENT)\b/',
				$source,
				$template_path
			);
			$this->assertDoesNotMatchRegularExpression(
				'/(?<!\{)\{(?:L_|LA_|[A-Z][A-Z0-9_\.]*)(?:\|[^}]*)?\}(?!\})/',
				$source,
				$template_path
			);
			$this->assertDoesNotMatchRegularExpression(
				'/\{%[^%]*(?:!==|===|&&|\|\||!(?!=)|\beq\b|\bneq\b|\bmod\b)[^%]*%\}/',
				$source,
				$template_path
			);
			$this->assertStringNotContainsString(
				'{% EVENT gallery_',
				$source,
				$template_path . ' uses an unprefixed custom event'
			);
		}
	}

	public function test_style_specific_templates_have_base_counterparts(): void
	{
		$core_root = dirname(__DIR__);
		$base_directories = [
			$core_root . '/styles/prosilver/template',
			$core_root . '/styles/all/template',
		];

		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$style_root = $core_root . '/styles/' . $style . '/template';
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($style_root, \FilesystemIterator::SKIP_DOTS)
			);

			foreach ($iterator as $file)
			{
				if (!$file->isFile())
				{
					continue;
				}

				$relative_path = substr($file->getPathname(), strlen($style_root) + 1);
				if ($style === 'BBOOTS' && $relative_path === 'event' . DIRECTORY_SEPARATOR . 'ucp_pm_viewmessage_avatar_after.html')
				{
					continue;
				}
				$has_counterpart = false;
				foreach ($base_directories as $base_directory)
				{
					$has_counterpart = $has_counterpart || is_file($base_directory . '/' . $relative_path);
				}

				$this->assertTrue($has_counterpart, $style . '/' . $relative_path . ' has no base template counterpart');
			}
		}
	}

	public function test_optional_profile_and_upload_blocks_default_to_empty_arrays(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$view_image = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');

			$this->assertStringContainsString('custom_fields|default([])', $view_image, $style);
			$this->assertStringContainsString('commentrow.custom_fields|default([])', $view_image, $style);
			$this->assertStringContainsString('upload_image|default([])', $posting, $style);
		}
	}

	public function test_flatboots_image_actions_match_the_viewtopic_button_size(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/viewimage_body.html');
		$start = strpos($source, '{% EVENT phpbbgallery_core_viewimage_actions %}');
		$end = strpos($source, '</ul>', $start);
		$actions = substr($source, $start, $end - $start);

		$this->assertSame(5, substr_count($actions, 'class="btn btn-sm btn-default"'));
		$this->assertStringNotContainsString('btn-xs', $actions);
	}

	public function test_gallery_and_forum_index_statistics_have_style_appropriate_labels_and_layouts(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$index = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/index_body.html');
			$this->assertStringContainsString("lang('GALLERY_STATISTICS')", $index, $style);
			$this->assertStringNotContainsString("lang('STATISTICS')", $index, $style);
		}

		$flatboots_statistic = (string) file_get_contents(
			$core_root . '/styles/FLATBOOTS/template/event/index_body_block_stats_append.html'
		);
		$this->assertStringContainsString('id="phpbbgallery-index-total-images"', $flatboots_statistic);
		$this->assertStringContainsString("document.querySelector('.panel-stats > .panel-body > .row')", $flatboots_statistic);
		$this->assertStringContainsString('statisticsRow.appendChild(statistic)', $flatboots_statistic);
		$this->assertStringContainsString('@media (max-width: 767px)', $flatboots_statistic);
	}

	public function test_gallery_navigation_exposes_an_accessible_unread_image_badge_in_every_style(): void
	{
		$core_root = dirname(__DIR__);
		$templates = [
			'prosilver/template/event/navbar_header_username_prepend.html',
			'prosilver/template/event/overall_header_navigation_prepend.html',
			'BBOOTS/template/event/overall_header_navigation_prepend.html',
			'FLATBOOTS/template/event/overall_header_navigation_prepend.html',
		];

		foreach ($templates as $template)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $template);
			$this->assertStringContainsString('S_GALLERY_NEW_IMAGES', $source, $template);
			$this->assertStringContainsString('GALLERY_NEW_IMAGES_DISPLAY', $source, $template);
			$this->assertStringContainsString('aria-label="{{ GALLERY_NEW_IMAGES_LABEL }}"', $source, $template);
		}

		$stylesheet = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$prosilver = (string) file_get_contents(
			$core_root . '/styles/prosilver/template/event/navbar_header_username_prepend.html'
		);
		$this->assertStringContainsString('class="phpbbgallery-header-link"', $prosilver);
		$this->assertStringNotContainsString('<li', $prosilver);
		$this->assertStringContainsString('.phpbbgallery-new-images-badge', $stylesheet);
	}

	public function test_all_rating_selectors_use_the_defined_do_not_rate_language_key(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['comment_body.html', 'viewimage_body.html'] as $template)
			{
				$source = (string) file_get_contents(
					$core_root . '/styles/' . $style . '/template/gallery/' . $template
				);
				$this->assertStringContainsString("lang('DO_NOT_RATE_IMAGE')", $source, $style . '/' . $template);
				$this->assertStringNotContainsString("lang('DONT_RATE_IMAGE')", $source, $style . '/' . $template);
			}
		}
	}

	public function test_optional_acp_blocks_default_to_empty_arrays(): void
	{
		$core_root = dirname(__DIR__);
		$overview = (string) file_get_contents($core_root . '/adm/style/gallery_main.html');
		$permissions = (string) file_get_contents($core_root . '/adm/style/gallery_permissions.html');

		$this->assertStringContainsString('mods|default([])', $overview);
		$this->assertStringContainsString('c_rows|default([])', $permissions);
	}

	public function test_every_upload_selector_uses_the_configured_extension_filter(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertMatchesRegularExpression('/<input[^>]+id="files"[^>]+accept="{{ S_ALLOWED_FILETYPES_ACCEPT }}"/', $posting, $style);
			$this->assertStringContainsString('{% if not S_UPLOAD_FILETYPES_AVAILABLE %} disabled{% endif %}', $posting, $style);
			$this->assertStringNotContainsString('image/jpeg,image/png,image/gif,image/webp,application/zip', $posting, $style);
		}
	}

	public function test_image_edit_forms_accept_addon_file_fields(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertMatchesRegularExpression('/<form[^>]+enctype="multipart\/form-data"/', $posting, $style);
		}
	}

	public function test_image_navigation_is_progressive_and_replaces_the_complete_view(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$view_image = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$this->assertStringContainsString('data-gallery-image-page', $view_image, $style);
			$this->assertStringContainsString('data-ajax-navigation=', $view_image, $style);
			$this->assertStringContainsString('data-gallery-image-navigation="previous"', $view_image, $style);
			$this->assertStringContainsString('data-gallery-image-navigation="next"', $view_image, $style);
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/image_navigation.js'", $view_image, $style);
			$this->assertLessThan(strpos($view_image, "include 'gallery/gallery_header.html'"), strpos($view_image, 'data-gallery-image-page'), $style);
			$this->assertGreaterThan(strpos($view_image, "include 'gallery/gallery_footer.html'"), strrpos($view_image, '</div>'), $style);
		}

		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/image_navigation.js');
		$this->assertStringContainsString('fetch(url, {', $javascript);
		$this->assertStringContainsString("credentials: 'same-origin'", $javascript);
		$this->assertStringContainsString('history.pushState', $javascript);
		$this->assertStringContainsString("window.addEventListener('popstate'", $javascript);
		$this->assertStringContainsString('window.scrollTo(0, scrollPosition)', $javascript);
		$this->assertStringContainsString('window.location.assign(url)', $javascript);
		$this->assertStringContainsString('phpbbgallery:imagechange', $javascript);
		$this->assertStringContainsString('requestId !== requestSequence', $javascript);
	}

	public function test_comment_forms_have_a_configured_unicode_aware_live_counter(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['comment_body.html', 'viewimage_body.html'] as $template_name)
			{
				$template = (string) file_get_contents(
					$core_root . '/styles/' . $style . '/template/gallery/' . $template_name
				);
				$this->assertStringContainsString('data-gallery-comment-counter', $template, $style . '/' . $template_name);
				$this->assertStringContainsString('data-comment-max-length="{{ COMMENT_MAX_LENGTH }}"', $template, $style . '/' . $template_name);
				$this->assertStringContainsString('data-gallery-comment-counter-output', $template, $style . '/' . $template_name);
				$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/comment_counter.js'", $template, $style . '/' . $template_name);
			}
		}

		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/comment_counter.js');
		$this->assertStringContainsString('Array.from(value).length', $javascript);
		$this->assertStringContainsString("textarea.addEventListener('input'", $javascript);
		$this->assertStringContainsString('output.hidden = current === 0', $javascript);
		$this->assertStringContainsString("document.addEventListener('phpbbgallery:imagechange'", $javascript);
		$this->assertStringContainsString("textarea.setAttribute('aria-invalid', 'true')", $javascript);

		$comment_controller = (string) file_get_contents($core_root . '/controller/comment.php');
		$image_controller = (string) file_get_contents($core_root . '/controller/image.php');
		$this->assertSame(3, substr_count($comment_controller, "'COMMENT_MAX_LENGTH'"));
		$this->assertSame(1, substr_count($image_controller, "'COMMENT_MAX_LENGTH'"));

		$stylesheet = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('.gallery-comment-guidance', $stylesheet);
		$this->assertStringContainsString('.gallery-comment-counter-exceeded', $stylesheet);
	}

	public function test_viewimage_statistics_event_follows_the_view_counter(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$views = strpos($template, '{{ IMAGE_VIEW }}');
			$statistics = strpos($template, '{% EVENT phpbbgallery_core_viewimage_statistics %}');

			$this->assertNotFalse($views, $style);
			$this->assertNotFalse($statistics, $style);
			$this->assertGreaterThan($views, $statistics, $style);
		}
	}

	public function test_quick_upload_uses_the_native_shared_client_and_server_configuration(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['all', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$footer = (string) file_get_contents($core_root . '/styles/' . $style . '/template/event/overall_footer_after.html');
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/quick_upload.js'", $footer, $style);
			$this->assertStringNotContainsString('jquery.fileupload', $footer, $style);
		}

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('data-gallery-quick-upload', $posting, $style);
			$this->assertStringContainsString('data-allowed-extensions="{{ S_ALLOWED_FILETYPES_ACCEPT }}"', $posting, $style);
			$this->assertStringContainsString('data-max-file-size="{{ S_QUICK_MAX_FILESIZE }}"', $posting, $style);
			$this->assertStringContainsString('data-upload-limit="{{ S_UPLOAD_LIMIT }}"', $posting, $style);
			$this->assertStringContainsString('id="outputTarget"', $posting, $style);
		}

		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/quick_upload.js');
		$this->assertStringContainsString("split(',')", $javascript);
		$this->assertStringContainsString('allowedExtensions.indexOf(extensionOf(file.name))', $javascript);
		$this->assertStringContainsString('file.size > maximumFileSize', $javascript);
		$this->assertStringContainsString('accepted >= uploadLimit', $javascript);
		$this->assertStringContainsString('response.files.forEach', $javascript);
		$this->assertStringNotContainsString('innerHTML', $javascript);
	}

	public function test_bootstrap_moderation_empty_states_use_theme_alerts(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['moderate_approve_queue.html', 'moderate_album_overview.html'] as $template)
			{
				$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('class="alert alert-info fade in"', $source, $style . '/' . $template);
				$this->assertStringContainsString("lang('NO_WAITING_UNAPPROVED_IMAGE')", $source, $style . '/' . $template);
				$this->assertStringNotContainsString("<p> {{ lang('NO_WAITING_UNAPPROVED_IMAGE') }}", $source, $style . '/' . $template);
			}
		}
	}

	public function test_bootstrap_approval_queue_hides_an_empty_summary_alert(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/moderate_approve_queue.html');
			$this->assertStringContainsString('{% elseif TOTAL_IMAGES_WAITING %}', $source, $style);
			$this->assertStringContainsString('image_unapproved|length', $source, $style);
			$this->assertStringNotContainsString('unaproved', $source, $style);
		}
	}

	public function test_all_styles_expose_the_separate_deletion_request_queue(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/moderate_approve_queue.html');
			$queue = strstr($source, '<form id="gallery_delete_requests"');
			$this->assertIsString($queue, $style);
			$this->assertStringContainsString('image_delete_requested', $queue, $style);
			$this->assertStringContainsString('name="action[restore]"', $queue, $style);
			$this->assertStringContainsString('name="action[delete_request]"', $queue, $style);
			$this->assertStringContainsString('deletion[{{ image_delete_requested.IMAGE_ALBUM_ID }}][]', $queue, $style);
		}
	}

	public function test_bootstrap_approval_queue_checkboxes_have_associated_labels(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/moderate_approve_queue.html');
			$this->assertStringContainsString('id="approval_{{ image_unapproved.U_IMAGE_ID }}"', $source, $style);
			$this->assertStringContainsString('for="approval_{{ image_unapproved.U_IMAGE_ID }}"', $source, $style);
		}
	}

	public function test_bootstrap_moderation_lists_use_responsive_tables(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['moderate_approve_queue.html', 'moderate_report_queue.html', 'moderate_album_overview.html'] as $template)
			{
				$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('<table class="footable table ', $source, $style . '/' . $template);
				$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $style . '/' . $template);
			}
		}
	}

	public function test_bootstrap_moderation_confirmation_uses_theme_form_controls(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/mcp_approve.html');
			$this->assertStringContainsString('class="control-group"', $source, $style);
			$this->assertStringContainsString('class="form-control"', $source, $style);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $style);
		}
	}

	public function test_bootstrap_legacy_image_edit_uses_canonical_form(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/image_edit_body.html');
			$this->assertStringContainsString("{% include 'gallery/posting_body.html' %}", $source, $style);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $style);
		}
	}

	public function test_all_bootstrap_gallery_templates_avoid_prosilver_definition_list_layout(): void
	{
		$core_root = dirname(__DIR__);
		$gallery_root = dirname($core_root);
		$directories = [
			$core_root . '/styles/BBOOTS',
			$core_root . '/styles/FLATBOOTS',
			$gallery_root . '/exif/styles/BBOOTS',
			$gallery_root . '/exif/styles/FLATBOOTS',
		];
		$templates = [];

		foreach ($directories as $directory)
		{
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS));
			foreach ($iterator as $file)
			{
				if ($file->isFile() && strtolower($file->getExtension()) === 'html')
				{
					$templates[] = $file->getPathname();
				}
			}
		}

		$this->assertCount(92, $templates);
		foreach ($templates as $template)
		{
			$source = (string) file_get_contents($template);
			$this->assertDoesNotMatchRegularExpression('/<\/?(?:dl|dt|dd)\b/i', $source, $template);
		}
	}

	public function test_bootstrap_gallery_forms_do_not_repeat_literal_attributes(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = $core_root . '/styles/' . $style . '/template/gallery/';
			$posting = (string) file_get_contents($root . 'posting_body.html');
			$album = (string) file_get_contents($root . 'album_body.html');
			$view_image = (string) file_get_contents($root . 'viewimage_body.html');

			$this->assertDoesNotMatchRegularExpression('/<textarea\b[^>]*\bclass="[^"]*"[^>]*\bclass="/i', $posting . $view_image, $style);
			$this->assertDoesNotMatchRegularExpression('/<button\b[^>]*\bname="[^"]*"[^>]*\bname="/i', $posting, $style);
			$this->assertStringNotContainsString('href="{{ U_RETURN_LINK }}" class=', $album . $view_image, $style);
			$this->assertStringNotContainsString('for=""', $posting, $style);
			$this->assertStringNotContainsString('for="allow_comments">Rotation', $posting, $style);
		}
	}

	public function test_bootstrap_gallery_visible_interface_strings_are_localized(): void
	{
		$core_root = dirname(__DIR__);
		$disallowed = [
			'Attention!',
			'>Preview{{',
			'>Change<',
			'>Remove<',
			'>Rotation{{',
			'data-loading-text="loading',
			'data-loading-text="Loading',
			'data-loading-text="Searching',
			'data-loading-text="Logging-in',
			'>Full URL{{',
			'>Image URL for posts{{',
			'>Cancel</button>',
		];

		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = $core_root . '/styles/' . $style;
			$source = '';
			$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
			foreach ($iterator as $file)
			{
				if ($file->isFile() && strtolower($file->getExtension()) === 'html')
				{
					$source .= (string) file_get_contents($file->getPathname());
				}
			}

			foreach ($disallowed as $text)
			{
				$this->assertStringNotContainsString($text, $source, $style . ': ' . $text);
			}
		}
	}

	public function test_bootstrap_gallery_form_labels_target_controls(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$root = $core_root . '/styles/' . $style . '/template/gallery/';
			$album = (string) file_get_contents($root . 'album_body.html');
			$comment = (string) file_get_contents($root . 'comment_body.html');
			$posting = (string) file_get_contents($root . 'posting_body.html');
			$results = (string) file_get_contents($root . 'search_results.html');
			$settings = (string) file_get_contents($root . 'ucp_gallery_personal_settings.html');
			$view_image = (string) file_get_contents($root . 'viewimage_body.html');

			$this->assertStringNotContainsString('for="bday_day"', $album . $results, $style);
			$this->assertStringContainsString('name="username" id="username"', $comment . $posting, $style);
			$this->assertStringContainsString('name="album_id" id="album_id"', $posting, $style);
			$this->assertStringContainsString('for="files"', $posting, $style);
			$this->assertStringContainsString('for="rrc_zebra1"', $settings, $style);
			$this->assertStringContainsString('name="rating" id="rating"', $view_image, $style);
			$this->assertStringNotContainsString('alert-error', $posting . $view_image, $style);
		}
	}

	public function test_bootstrap_upload_preview_uses_packaged_placeholder(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$posting = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/posting_body.html');
			$this->assertStringContainsString('{{ T_THEME_PATH }}/images/missing.png', $posting, $style);
			$this->assertStringNotContainsString('placehold.it', $posting, $style);
			$this->assertStringNotContainsString('http://', $posting, $style);
		}
	}

	public function test_bootstrap_album_pagination_uses_the_native_list_contract(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$pagination = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/total_images.html');
			$this->assertStringContainsString('<ul class="pagination pagination-sm">', $pagination, $style);
			$this->assertStringContainsString("{% include 'pagination.html' %}", $pagination, $style);
			$this->assertStringNotContainsString('<div class="pagination pagination-sm">', $pagination, $style);
		}
	}

	public function test_forum_index_images_use_native_events_in_every_supported_style(): void
	{
		$core_root = dirname(__DIR__);
		$board_root = dirname(__DIR__, 4);
		$prosilver_event = (string) file_get_contents($core_root . '/styles/prosilver/template/event/index_body_markforums_before.html');
		$shared_event = (string) file_get_contents($core_root . '/styles/all/template/event/index_body_forumlist_body_before.html');

		foreach ([$prosilver_event, $shared_event] as $template)
		{
			$this->assertStringContainsString('{% if PHPBBGALLERY_FORUM_INDEX_IMAGES %}', $template);
			$this->assertStringContainsString("{% include 'gallery/imageblock_polaroid.html' %}", $template);
		}

		$prosilver_index = (string) file_get_contents($board_root . '/styles/prosilver/template/index_body.html');
		$this->assertStringContainsString('EVENT index_body_markforums_before', $prosilver_index);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$index = (string) file_get_contents($board_root . '/styles/' . $style . '/template/index_body.html');
			$this->assertStringContainsString('EVENT index_body_forumlist_body_before', $index, $style);
		}
	}

	public function test_profile_image_blocks_are_safe_when_the_feature_is_disabled(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$event = (string) file_get_contents($core_root . '/styles/' . $style . '/template/event/memberlist_view_content_append.html');
			$polaroid = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/imageblock_polaroid.html');

			$this->assertStringContainsString('{% if imageblock|default([])|length %}', $event, $style);
			$this->assertStringContainsString('{% for imageblock in imageblock|default([]) %}', $polaroid, $style);
		}
	}

	public function test_topic_and_private_message_profiles_use_style_appropriate_events(): void
	{
		$core_root = dirname(__DIR__);
		$events = [
			'prosilver' => 'ucp_pm_viewmessage_custom_fields_after.html',
			'BBOOTS' => 'ucp_pm_viewmessage_avatar_after.html',
			'FLATBOOTS' => 'ucp_pm_viewmessage_custom_fields_after.html',
		];
		foreach ($events as $style => $pm_event)
		{
			$topic = (string) file_get_contents($core_root . '/styles/' . $style . '/template/event/viewtopic_body_postrow_custom_fields_after.html');
			$pm = (string) file_get_contents($core_root . '/styles/' . $style . '/template/event/' . $pm_event);

			$this->assertStringContainsString('postrow.S_GALLERY_IMAGE_COUNT|default(false)', $topic, $style);
			$this->assertStringContainsString('postrow.U_POSTER_PERSONAL_ALBUM', $topic, $style);
			$this->assertStringContainsString('S_GALLERY_IMAGE_COUNT|default(false)', $pm, $style);
			$this->assertStringContainsString('U_POSTER_PERSONAL_ALBUM', $pm, $style);
		}
	}

	public function test_bootstrap_online_block_uses_the_phpbb_page_header_contract(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$index = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/index_body.html');
			$this->assertStringContainsString('{% if S_DISPLAY_ONLINE_LIST %}', $index, $style);
			$this->assertStringNotContainsString('S_DISP_WHOISONLINE', $index, $style);
		}

		$controller = (string) file_get_contents($core_root . '/controller/index.php');
		$this->assertStringContainsString("\$this->gallery_config->get('disp_whoisonline')", $controller);
	}

	public function test_bootstrap_search_controls_match_controller_parameters(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$search = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/search_body.html');
			$this->assertStringContainsString('name="username" id="username"', $search, $style);
			$this->assertStringNotContainsString('name="author"', $search, $style);
			$this->assertStringContainsString('name="sd" id="sa" value="a"', $search, $style);
			$this->assertStringContainsString('name="sd" id="sd" value="d"', $search, $style);
			$this->assertStringNotContainsString('Leinad4Mind', $search, $style);
		}
	}

	public function test_bootstrap_unapproved_image_actions_require_an_authorized_url(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['imageblock_body.html', 'imageblock_polaroid.html'] as $template)
			{
				$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('{% if image.S_STATUS_UNAPPROVED_ACTION %}', $source, $style . '/' . $template);
				$this->assertStringContainsString('action="{{ image.S_STATUS_UNAPPROVED_ACTION }}"', $source, $style . '/' . $template);
			}
		}
	}

	public function test_bootstrap_comment_profiles_use_the_image_controller_contract(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			foreach (['POSTER_FULL', 'U_POSTER', 'POSTER_RANK_TITLE', 'POSTER_RANK_IMG', 'S_POSTER_ONLINE', 'EDIT_INFO', 'SIGNATURE', 'contact'] as $variable)
			{
				$this->assertStringContainsString('commentrow.' . $variable, $source, $style . ': ' . $variable);
			}
			$this->assertDoesNotMatchRegularExpression('/commentrow\.(?:POST_AUTHOR_FULL|U_POST_AUTHOR|RANK_TITLE|RANK_IMG|S_ONLINE|GALLERY_IMAGES|U_(?:PM|EMAIL|WWW|MSN|ICQ|YIM|AIM|JABBER))\b/', $source, $style);
			$this->assertStringNotContainsString('<p class="author">', $source, $style);
		}
	}

	public function test_flatboots_comments_reuse_viewtopic_actions_and_contacts(): void
	{
		$gallery = (string) file_get_contents(dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/viewimage_body.html');
		$viewtopic = (string) file_get_contents(dirname(__DIR__, 4) . '/styles/FLATBOOTS/template/viewtopic_body.html');

		foreach (['class="btn-group btn-group-sm"', 'class="btn btn-default dropdown-toggle"', 'class="dropdown-menu dropdown-menu-right"', 'class="btn btn-default btn-sm"', 'class="default-contact"', 'mini-profile-contact mini-profile-control list-unstyled text-center'] as $markup)
		{
			$this->assertStringContainsString($markup, $gallery);
			$this->assertStringContainsString($markup === 'class="dropdown-menu dropdown-menu-right"' ? 'dropdown-menu' : $markup, $viewtopic);
		}

		$this->assertStringNotContainsString('class="btn btn-xs btn-default" href="{{ commentrow.', $gallery);
	}

	public function test_bootstrap_subscription_items_use_a_responsive_media_grid(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/ucp_gallery_manage_subscriptions.html');
			$this->assertStringContainsString('class="row gallery-subscription-media"', $source, $style);
			$this->assertStringContainsString('class="row gallery-subscription-details"', $source, $style);
			$this->assertSame(7, substr_count($source, 'col-xs-12 col-sm-6'), $style);
			$this->assertStringContainsString('class="gallery-subscription-comment"', $source, $style);
			$this->assertStringContainsString('{{ image_row.LAST_COMMENT }}', $source, $style);
			$this->assertStringContainsString("marklist('ucp_gallery', 'album_id_ary', true)", $source, $style);
			$this->assertStringContainsString('for="album_subscription_{{ album_row.ALBUM_ID }}"', $source, $style);
			$this->assertStringContainsString('for="image_subscription_{{ image_row.IMAGE_ID }}"', $source, $style);
			$this->assertSame(1, substr_count($source, 'name="action"'), $style);
		}
	}

	public function test_bootstrap_subalbum_manager_uses_responsive_controls_and_empty_state(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/ucp_gallery_manage_subalbuns.html');
			$this->assertStringContainsString('class="form-control" type="text" id="album_name"', $source, $style);
			$this->assertStringContainsString('class="form-control" rows="5" id="album_desc"', $source, $style);
			$this->assertSame(2, substr_count($source, 'class="form-control selectpicker"'), $style);
			$this->assertSame(3, substr_count($source, 'class="col-xs-12 col-sm-4"'), $style);
			$this->assertStringContainsString('{% if album_row|length %}', $source, $style);
			$this->assertStringContainsString('class="alert alert-info fade in" role="alert"', $source, $style);
			$this->assertStringNotContainsString('span12', $source, $style);
			$this->assertStringNotContainsString('>Tools<', $source, $style);
			$this->assertStringNotContainsString('placeholder="', $source, $style);
		}
	}

	#[IgnoreDeprecations]
	public function test_modernized_templates_parse_with_packaged_twig(): void
	{
		// Twig 2.16 is the packaged version and emits PHP 8.4 deprecations from its own legacy signatures.
		$twig = $this->twig_environment();

		foreach ($this->template_paths() as $template_path)
		{
			$source = new Source(file_get_contents($template_path), $template_path);
			$twig->parse($twig->tokenize($source));
			$this->addToAssertionCount(1);
		}
	}

	private function twig_environment(): Environment
	{
		$twig = new Environment(new ArrayLoader());
		$twig->addFunction(new TwigFunction('lang', static fn (): string => ''));
		$twig->addFunction(new TwigFunction('lang_js', static fn (): string => ''));
		$twig->addFilter(new TwigFilter('subset', static fn (array $items): array => $items));
		$twig->addFilter(new TwigFilter('int', 'intval'));
		$twig->addFilter(new TwigFilter('float', 'floatval'));

		foreach (['EVENT', 'INCLUDECSS', 'INCLUDEJS'] as $tag)
		{
			$twig->addTokenParser(new template_noop_token_parser($tag));
		}

		return $twig;
	}

	private function template_paths(): array
	{
		$core_root = dirname(__DIR__);
		$gallery_root = dirname($core_root);
		$directories = [
			$core_root . '/adm/style',
			$core_root . '/styles/all',
			$core_root . '/styles/BBOOTS',
			$core_root . '/styles/FLATBOOTS',
			$core_root . '/styles/prosilver',
			$gallery_root . '/acpcleanup/adm/style',
			$gallery_root . '/acpimport/adm/style',
			$gallery_root . '/bbpointsimages/styles',
			$gallery_root . '/bbtagsimages/adm/style',
			$gallery_root . '/bbtagsimages/styles',
			$gallery_root . '/exif/adm/style',
			$gallery_root . '/exif/styles',
			$gallery_root . '/favorite/styles',
		];
		$template_paths = [];

		foreach ($directories as $directory)
		{
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS)
			);
			foreach ($iterator as $file)
			{
				if ($file->isFile() && in_array(strtolower($file->getExtension()), ['html', 'twig'], true))
				{
					$template_paths[] = $file->getPathname();
				}
			}
		}

		sort($template_paths);
		return $template_paths;
	}
}
