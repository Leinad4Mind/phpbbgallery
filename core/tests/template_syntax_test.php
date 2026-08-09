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
		$this->assertCount(203, $template_paths);

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

		$this->assertSame(6, substr_count($actions, 'class="btn btn-sm btn-default"'));
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
		foreach ([
			'navbar_header_username_prepend.html',
			'overall_header_navigation_prepend.html',
		] as $template)
		{
			$source = (string) file_get_contents($core_root . '/styles/prosilver/template/event/' . $template);
			$this->assertStringContainsString('<strong class="badge"', $source, $template);
			$this->assertStringNotContainsString('phpbbgallery-new-images-badge', $source, $template);
		}
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents(
				$core_root . '/styles/' . $style . '/template/event/overall_header_navigation_prepend.html'
			);
			$this->assertStringContainsString('phpbbgallery-new-images-badge', $source, $style);
		}
		$this->assertStringContainsString('.phpbbgallery-new-images-badge', $stylesheet);
	}

	public function test_all_rating_selectors_use_the_shared_star_controls(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['comment_body.html', 'viewimage_body.html'] as $template)
			{
				$source = (string) file_get_contents(
					$core_root . '/styles/' . $style . '/template/gallery/' . $template
				);
				$this->assertStringNotContainsString("lang('DONT_RATE_IMAGE')", $source, $style . '/' . $template);
				$partial = (($style === 'FLATBOOTS' || $style === 'prosilver') && $template === 'viewimage_body.html')
					? 'rating_stars_ajax.html'
					: 'rating_stars.html';
				$this->assertStringContainsString($partial, $source, $style . '/' . $template);
			}
		}
	}

	public function test_image_rating_results_do_not_require_the_vote_permission_in_templates(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(
				$core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html'
			);
			$this->assertStringContainsString('{% if S_RATING_VISIBLE %}', $template, $style);
			$this->assertStringNotContainsString('{% if S_VIEW_RATE %}', $template, $style);
		}
	}

	public function test_flatboots_and_prosilver_rating_is_a_star_only_csrf_protected_ajax_control(): void
	{
		$core_root = dirname(__DIR__);
		$templates = [
			'FLATBOOTS' => (string) file_get_contents($core_root . '/styles/FLATBOOTS/template/gallery/viewimage_body.html'),
			'prosilver' => (string) file_get_contents($core_root . '/styles/prosilver/template/gallery/viewimage_body.html'),
		];
		$stars = (string) file_get_contents($core_root . '/styles/all/template/gallery/rating_stars_ajax.html');
		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/rating.js');
		$controller = (string) file_get_contents($core_root . '/controller/comment.php');
		$routing = (string) file_get_contents($core_root . '/config/routing.yml');

		foreach ($templates as $style => $template)
		{
			$this->assertStringContainsString("include '@phpbbgallery_core/gallery/rating_stars_ajax.html'", $template, $style);
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/rating.js'", $template, $style);
			$this->assertStringNotContainsString('RATING_AUTO_SUBMIT', $template, $style);
		}
		$this->assertStringContainsString('data-gallery-rating', $stars);
		$this->assertStringContainsString('data-rating-value=', $stars);
		$this->assertStringNotContainsString('type="radio"', $stars);
		$this->assertStringContainsString('input[name="creation_time"], input[name="form_token"]', $javascript);
		$this->assertStringContainsString("headers: {'X-Requested-With': 'XMLHttpRequest'}", $javascript);
		$this->assertStringContainsString('updateRatingSummary(container, data.rating_summary || data.rating)', $javascript);
		$this->assertStringContainsString('window.phpbb.alert(data.MESSAGE_TITLE || message, message)', $javascript);
		$this->assertStringNotContainsString('status.textContent = data.message', $javascript);
		$this->assertStringContainsString("check_form_key('gallery')", $controller);
		$this->assertMatchesRegularExpression("~'rating'\\s*=>\\s*\\\$rate_point~", $controller);
		$this->assertStringContainsString("'rating_summary' => \$rating->get_image_rating(\$rate_point)", $controller);
		$this->assertStringContainsString("'MESSAGE_TITLE'  => \$this->language->lang('INFORMATION')", $controller);
		$this->assertStringContainsString('data-gallery-rating-summary', $templates['FLATBOOTS']);
		$this->assertStringContainsString('data-gallery-rating-summary', $templates['prosilver']);
		$this->assertMatchesRegularExpression('~phpbbgallery_core_image_rate:.*?methods: \\[POST\\]~s', $routing);
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
			$this->assertGreaterThan(strpos($view_image, "include 'gallery/gallery_header.html'"), strpos($view_image, 'data-gallery-image-page'), $style);
			$this->assertLessThan(strpos($view_image, "include 'gallery/gallery_footer.html'"), strrpos($view_image, '</div>'), $style);
		}

		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/image_navigation.js');
		$this->assertStringContainsString('fetch(url, {', $javascript);
		$this->assertStringContainsString("credentials: 'same-origin'", $javascript);
		$this->assertStringContainsString('history.pushState', $javascript);
		$this->assertStringContainsString("window.addEventListener('popstate'", $javascript);
		$this->assertStringContainsString('window.scrollTo(0, scrollPosition)', $javascript);
		$this->assertStringContainsString('window.location.assign(url)', $javascript);
		$this->assertStringContainsString('phpbbgallery:imagechange', $javascript);
		$this->assertStringContainsString('activateAjaxControls(importedRoot)', $javascript);
		$this->assertStringContainsString('window.phpbb.ajaxify({', $javascript);
		$this->assertStringContainsString('pageReplaced = true', $javascript);
		$this->assertStringContainsString('if (!pageReplaced)', $javascript);
		$this->assertStringContainsString("root.classList.add('is-entering')", $javascript);
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
				if ($style !== 'prosilver')
				{
					$this->assertStringContainsString('data-gallery-comment-guidance-text', $template, $style . '/' . $template_name);
					if ($template_name === 'viewimage_body.html')
					{
						$actions = strpos($template, 'class="gallery-comment-actions"');
						$submit = strpos($template, 'name="submit"', $actions);
						$guidance = strpos($template, 'class="gallery-comment-guidance"', $submit);
						$this->assertNotFalse($actions, $style);
						$this->assertNotFalse($submit, $style);
						$this->assertNotFalse($guidance, $style);
						$this->assertGreaterThan($actions, $submit, $style);
						$this->assertGreaterThan($submit, $guidance, $style);
					}
					else
					{
						$submit = strpos($template, 'name="submit"');
						$guidance = strpos($template, 'gallery-comment-submit-guidance');
						$this->assertNotFalse($submit, $style);
						$this->assertNotFalse($guidance, $style);
						$this->assertGreaterThan($submit, $guidance, $style);
					}
				}
			}
		}

		$javascript = (string) file_get_contents($core_root . '/styles/all/template/js/comment_counter.js');
		$this->assertStringContainsString('Array.from(value).length', $javascript);
		$this->assertStringContainsString("textarea.addEventListener('input'", $javascript);
		$this->assertStringContainsString('output.hidden = current === 0', $javascript);
		$this->assertStringContainsString('guidanceText.hidden = current > 0', $javascript);
		$this->assertStringContainsString("document.addEventListener('phpbbgallery:imagechange'", $javascript);
		$this->assertStringContainsString("textarea.setAttribute('aria-invalid', 'true')", $javascript);

		$comment_controller = (string) file_get_contents($core_root . '/controller/comment.php');
		$image_controller = (string) file_get_contents($core_root . '/controller/image.php');
		$this->assertSame(3, substr_count($comment_controller, "'COMMENT_MAX_LENGTH'"));
		$this->assertSame(1, substr_count($image_controller, "'COMMENT_MAX_LENGTH'"));

		$stylesheet = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('.gallery-comment-guidance', $stylesheet);
		$this->assertStringContainsString('.gallery-comment-submit-guidance', $stylesheet);
		$this->assertStringContainsString('.gallery-signature-option', $stylesheet);
		$this->assertStringContainsString('gap: 8px;', $stylesheet);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['comment_body.html', 'viewimage_body.html'] as $template_name)
			{
				$template = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/' . $template_name);
				$this->assertSame(1, substr_count($template, 'class="gallery-signature-option"'), $style . '/' . $template_name);
			}
		}
		$this->assertMatchesRegularExpression(
			'/\.gallery-comment-actions\s*\{[^}]*display:\s*flex;[^}]*justify-content:\s*space-between;[^}]*width:\s*100%;/s',
			$stylesheet
		);
		$this->assertMatchesRegularExpression(
			'/\.gallery-comment-actions \.gallery-comment-guidance\s*\{[^}]*margin-inline-start:\s*auto;[^}]*text-align:\s*end;/s',
			$stylesheet
		);
		$this->assertStringContainsString('.gallery-comment-counter-exceeded', $stylesheet);
		$button_rule_start = strpos($stylesheet, '#postingbox .posting-btns .btn-group > button.btn');
		$this->assertNotFalse($button_rule_start);
		$button_rule_end = strpos($stylesheet, '}', $button_rule_start);
		$this->assertNotFalse($button_rule_end);
		$button_rule = substr($stylesheet, $button_rule_start, $button_rule_end - $button_rule_start);
		$this->assertStringContainsString('height: 34px', $button_rule);
		$this->assertStringNotContainsString('width:', $button_rule);
		$this->assertStringNotContainsString('padding-inline:', $button_rule);
	}

	public function test_image_descriptions_share_the_unicode_aware_live_counter(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents(
				$core_root . '/styles/' . $style . '/template/gallery/posting_body.html'
			);
			$this->assertStringContainsString('data-gallery-character-counter', $template, $style);
			$this->assertStringContainsString('data-gallery-counter-output-id="description-counter-{{ image.S_ROW_COUNT }}"', $template, $style);
			$this->assertStringContainsString('data-gallery-max-length="{{ DESCRIPTION_MAX_LENGTH }}"', $template, $style);
			$this->assertStringContainsString('data-gallery-comment-guidance-text', $template, $style);
			$this->assertStringContainsString('data-gallery-character-counter-output', $template, $style);
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/comment_counter.js'", $template, $style);
			$javascript = (string) file_get_contents(
				$core_root . '/styles/' . $style . '/template/gallery/posting_javascript.html'
			);
			$this->assertStringContainsString("dispatchEvent(new Event('input'", $javascript, $style);
		}

		$counter_javascript = (string) file_get_contents($core_root . '/styles/all/template/js/comment_counter.js');
		$this->assertStringContainsString("textarea.getAttribute('data-gallery-counter-output-id')", $counter_javascript);
		$this->assertStringContainsString('document.getElementById(outputId)', $counter_javascript);
		$this->assertStringContainsString("output.removeAttribute('hidden')", $counter_javascript);

		$upload = (string) file_get_contents($core_root . '/controller/upload.php');
		$image = (string) file_get_contents($core_root . '/controller/image.php');
		$this->assertStringContainsString("'DESCRIPTION_MAX_LENGTH'", $upload);
		$this->assertStringContainsString("'DESCRIPTION_MAX_LENGTH'", $image);
		$this->assertStringContainsString('utf8_strlen($var)', $upload);
		$this->assertStringContainsString('utf8_strlen($image_desc)', $image);
	}

	public function test_bootstrap_comment_profiles_keep_online_status_with_the_avatar(): void
	{
		$bboots = (string) file_get_contents(dirname(__DIR__) . '/styles/BBOOTS/template/gallery/viewimage_body.html');
		$comments = strpos($bboots, '{% for commentrow in commentrow %}');
		$avatar = strpos($bboots, '<div class="user-profile-avatar">', $comments);
		$online_anchor = strpos($bboots, '<div class="gallery-avatar-online">', $avatar);
		$ribbon = strpos($bboots, '<div class="ribbon-wrapper small hidden-xs">', $avatar);
		$image_frame = strpos($bboots, '<div class="imageframe ', $avatar);
		$this->assertNotFalse($comments);
		$this->assertNotFalse($avatar);
		$this->assertNotFalse($online_anchor);
		$this->assertNotFalse($ribbon);
		$this->assertNotFalse($image_frame);
		$this->assertLessThan($ribbon, $online_anchor);
		$this->assertLessThan($image_frame, $ribbon);
		$this->assertStringNotContainsString('commentrow.S_POSTER_ONLINE', substr($bboots, 0, $comments));

		$flatboots = (string) file_get_contents(dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/viewimage_body.html');
		$flat_comments = strpos($flatboots, '{% for commentrow in commentrow %}');
		$flat_avatar = strpos($flatboots, '<div class="avatar-over avatar-viewtopic">', $flat_comments);
		$flat_status = strpos($flatboots, '<span class="status"', $flat_avatar);
		$this->assertNotFalse($flat_comments);
		$this->assertNotFalse($flat_avatar);
		$this->assertNotFalse($flat_status);
		$this->assertGreaterThan($flat_avatar, $flat_status);
		$this->assertStringNotContainsString('ribbon-wrapper', substr($flatboots, $flat_comments));
		$this->assertStringContainsString('data-gallery-comment-profile', substr($flatboots, $flat_comments));

		$stylesheet = (string) file_get_contents(dirname(__DIR__) . '/styles/all/theme/gallery.css');
		$this->assertStringContainsString('.phpbbgallery-image-page .gallery-avatar-online', $stylesheet);
		$this->assertMatchesRegularExpression(
			'/\.phpbbgallery-image-page \.gallery-avatar-online\s*\{[^}]*display:\s*inline-block;[^}]*position:\s*relative;/s',
			$stylesheet
		);
		$this->assertMatchesRegularExpression(
			'/\.phpbbgallery-image-page \.gallery-avatar-online > \.ribbon-wrapper\s*\{[^}]*left:\s*auto;[^}]*right:\s*-3px;/s',
			$stylesheet
		);
		$this->assertStringContainsString('.gallery-sep .fa', $stylesheet);
		$this->assertMatchesRegularExpression(
			'/\.gallery-sep\s*\{[^}]*margin-top:\s*24px;[^}]*margin-bottom:\s*24px;/s',
			$stylesheet
		);
		$this->assertMatchesRegularExpression(
			'/\[data-gallery-comment-profile\] \.panel-body\.user-profile-sep\s*\{[^}]*border-left:\s*2px dashed #eee;[^}]*border-right:\s*0;/s',
			$stylesheet
		);
		$this->assertStringContainsString('.gallery-checkbox-label', $stylesheet);
		$this->assertMatchesRegularExpression(
			'/\.gallery-signature-option\s*\{[^}]*align-items:\s*center;[^}]*display:\s*flex;[^}]*gap:\s*8px;/s',
			$stylesheet
		);
		foreach (['BBOOTS', 'FLATBOOTS'] as $style)
		{
			foreach (['comment_body.html', 'viewimage_body.html'] as $template)
			{
				$source = (string) file_get_contents(dirname(__DIR__) . '/styles/' . $style . '/template/gallery/' . $template);
				$this->assertStringContainsString('class="gallery-checkbox-label" for="attach_sig"', $source, $style . '/' . $template);
			}
		}
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

		$this->assertCount(93, $templates);
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
			$this->assertStringContainsString('for="rating"', $view_image, $style);
			$this->assertStringNotContainsString('alert-error', $posting . $view_image, $style);
		}

		$rating_partials = (string) file_get_contents($core_root . '/styles/all/template/gallery/rating_stars.html')
			. (string) file_get_contents($core_root . '/styles/all/template/gallery/rating_stars_ajax.html');
		$this->assertSame(2, substr_count(str_replace("'", '"', $rating_partials), 'id="rating"'));
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

	public function test_profile_image_count_links_to_search_and_flatboots_uses_the_timeline(): void
	{
		$core_root = dirname(__DIR__);
		$profile_card = (string) file_get_contents($core_root . '/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html');
		$flatboots = (string) file_get_contents($core_root . '/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html');

		$this->assertStringNotContainsString('{{ U_GALLERY_IMAGES }}', $profile_card);
		$this->assertStringContainsString("{{ lang('TOTAL_IMAGES') }}", $flatboots);
		$this->assertStringContainsString('{{ U_GALLERY_IMAGES }}', $flatboots);
		$this->assertStringContainsString('U_GALLERY_IMAGES_SEARCH', $flatboots);
		$this->assertStringNotContainsString('<strong>{{ U_GALLERY_IMAGES }}</strong>', $flatboots);

		foreach (['prosilver', 'BBOOTS'] as $style)
		{
			$event = (string) file_get_contents($core_root . '/styles/' . $style . '/template/event/memberlist_view_user_statistics_after.html');
			$this->assertStringContainsString("lang('TOTAL_IMAGES')", $event, $style);
			$this->assertStringContainsString('U_GALLERY_IMAGES_SEARCH', $event, $style);
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

	public function test_viewimage_contacts_use_the_modern_phpbb_contract_in_every_style(): void
	{
		$core_root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$source = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/viewimage_body.html');
			$this->assertStringContainsString('{% for contact in contact %}', $source, $style);
			$this->assertStringContainsString('contact.U_CONTACT', $source, $style);
			$this->assertStringContainsString('{{ U_POSTER }}', $source, $style);
			$this->assertStringContainsString('{% for contact in commentrow.contact %}', $source, $style);
			$this->assertStringContainsString('{{ commentrow.U_POSTER }}', $source, $style);
			$this->assertDoesNotMatchRegularExpression('/\bU_POSTER_(?:PM|EMAIL|WWW|MSN|ICQ|YIM|AIM|JABBER)\b/', $source, $style);
			$this->assertStringNotContainsString('postrow.U_WWW', $source, $style);
			$this->assertStringNotContainsString('U_POST_AUTHOR', $source, $style);
			$this->assertStringNotContainsString('>POSTER_USERNAME}</span>', $source, $style);
		}
	}

	public function test_flatboots_comments_reuse_viewtopic_actions_and_contacts(): void
	{
		$gallery = (string) file_get_contents(dirname(__DIR__) . '/styles/FLATBOOTS/template/gallery/viewimage_body.html');
		$viewtopic = (string) file_get_contents(dirname(__DIR__, 4) . '/styles/FLATBOOTS/template/viewtopic_body.html');

		foreach (['class="btn btn-default dropdown-toggle"', 'class="dropdown-menu dropdown-menu-right"', 'class="btn btn-default btn-sm"', 'class="default-contact"', 'mini-profile-contact mini-profile-control list-unstyled text-center', 'text-center hidden-xs hidden-sm nightpanel', 'class="panel-body user-profile-sep"', 'class="avatar-over avatar-viewtopic"', 'class="profile-rank text-center"', 'class="icon-list list-unstyled"'] as $markup)
		{
			$this->assertStringContainsString($markup, $gallery);
			$this->assertStringContainsString($markup === 'class="dropdown-menu dropdown-menu-right"' ? 'dropdown-menu' : $markup, $viewtopic);
		}

		$this->assertStringContainsString('class="btn-group btn-group-sm visible-xs"', $gallery);
		$desktop_start = strpos($gallery, 'class="btn-group btn-group-sm hidden-xs"');
		$this->assertNotFalse($desktop_start);
		$desktop_end = strpos($gallery, '</div>', $desktop_start);
		$this->assertNotFalse($desktop_end);
		$desktop_actions = substr($gallery, $desktop_start, $desktop_end - $desktop_start);
		$this->assertSame(4, substr_count($desktop_actions, 'class="btn btn-default btn-sm"'));
		$this->assertStringContainsString("lang('WHOIS')", $desktop_actions);
		$this->assertStringContainsString('class="fa fa-info-circle"', $desktop_actions);
		$this->assertStringNotContainsString("lang('IP')", $desktop_actions);
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

	public function test_privileged_ip_values_are_blurred_and_share_a_persistent_toggle(): void
	{
		$core_root = dirname(__DIR__);
		$partial = (string) file_get_contents($core_root . '/styles/all/template/gallery/ip_privacy_toggle.html');
		$script = (string) file_get_contents($core_root . '/styles/all/template/js/ip_privacy.js');
		$css = (string) file_get_contents($core_root . '/styles/all/theme/gallery.css');

		$this->assertStringContainsString('data-gallery-ip-toggle', $partial);
		$this->assertStringContainsString('class="gallery-sensitive-ip"', $partial);
		$this->assertStringContainsString('aria-pressed="false"', $partial);
		$this->assertStringContainsString("'phpbbgallery.ipVisibility'", $script);
		$this->assertStringContainsString('window.localStorage.getItem(storageKey)', $script);
		$this->assertStringContainsString('window.localStorage.setItem(storageKey', $script);
		$this->assertStringContainsString('document.documentElement.classList.toggle(visibleClass, visible)', $script);
		$this->assertStringContainsString("document.addEventListener('phpbbgallery:imagechange'", $script);
		$this->assertStringContainsString('filter: blur(4px)', $css);
		$this->assertStringContainsString('.gallery-ip-visible .gallery-sensitive-ip', $css);

		$ip_templates = [
			'prosilver/template/gallery/imageblock_polaroid.html',
			'prosilver/template/gallery/imageblock_body.html',
			'prosilver/template/gallery/search_results.html',
			'prosilver/template/gallery/viewimage_body.html',
			'prosilver/template/gallery/moderate_actions_queue.html',
			'BBOOTS/template/gallery/imageblock_polaroid.html',
			'BBOOTS/template/gallery/imageblock_body.html',
			'BBOOTS/template/gallery/viewimage_body.html',
			'BBOOTS/template/gallery/moderate_actions_queue.html',
			'FLATBOOTS/template/gallery/imageblock_polaroid.html',
			'FLATBOOTS/template/gallery/imageblock_body.html',
			'FLATBOOTS/template/gallery/viewimage_body.html',
			'FLATBOOTS/template/gallery/moderate_actions_queue.html',
		];
		$include_count = 0;
		foreach ($ip_templates as $template_path)
		{
			$template = (string) file_get_contents($core_root . '/styles/' . $template_path);
			$this->assertStringContainsString('@phpbbgallery_core/gallery/ip_privacy_toggle.html', $template, $template_path);
			$include_count += substr_count($template, '@phpbbgallery_core/gallery/ip_privacy_toggle.html');
		}
		$this->assertSame(14, $include_count);

		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$footer = (string) file_get_contents($core_root . '/styles/' . $style . '/template/gallery/gallery_footer.html');
			$this->assertStringContainsString("INCLUDEJS '@phpbbgallery_core/js/ip_privacy.js'", $footer, $style);
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
