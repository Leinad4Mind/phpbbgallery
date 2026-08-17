<?php
/**
 * phpBB Gallery - ACP overview module tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\acp\main_module;
use PHPUnit\Framework\TestCase;

final class acp_main_types_test extends TestCase
{
	public function test_properties_parameters_and_returns_are_fully_typed(): void
	{
		$reflection = new \ReflectionClass(main_module::class);

		foreach ($reflection->getProperties() as $property)
		{
			if ($property->getDeclaringClass()->getName() === main_module::class)
			{
				$this->assertNotNull($property->getType(), main_module::class . '::$' . $property->getName());
			}
		}

		foreach ($reflection->getMethods() as $method)
		{
			if ($method->getDeclaringClass()->getName() !== main_module::class)
			{
				continue;
			}

			foreach ($method->getParameters() as $parameter)
			{
				$this->assertNotNull($parameter->getType(), main_module::class . '::' . $method->getName() . '($' . $parameter->getName() . ')');
			}

			$this->assertNotNull($method->getReturnType(), main_module::class . '::' . $method->getName() . '()');
		}
	}

	public function test_overview_actions_are_explicit_commands(): void
	{
		$this->assertSame('void', (string) (new \ReflectionMethod(main_module::class, 'main'))->getReturnType());
		$this->assertSame('void', (string) (new \ReflectionMethod(main_module::class, 'overview'))->getReturnType());
	}

	public function test_overview_reads_the_gallery_version_from_extension_metadata(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$quote = chr(39);

		$this->assertStringContainsString('create_extension_metadata_manager(' . $quote . 'phpbbgallery/core' . $quote . ')', $source);
		$this->assertStringContainsString('get_metadata(' . $quote . 'version' . $quote . ')', $source);
		$this->assertStringContainsString(chr(36) . 'gallery_version', $source);
		$this->assertStringNotContainsString(chr(36) . 'config[' . $quote . 'phpbb_gallery_version' . $quote . ']', $source);
	}

	public function test_cache_purge_uses_the_active_storage_file_tool(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');

		$this->assertStringNotContainsString('opendir(', $source);
		$this->assertStringNotContainsString('readdir(', $source);
		$this->assertStringNotContainsString('@unlink(', $source);
		$this->assertStringContainsString('$file_tool->delete_cache($filenames);', $source);
		$this->assertStringContainsString('$active_storage->size(', $source);
	}

	public function test_empty_user_resync_still_passes_an_initialized_list(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$initialization = strpos($source, '$sync_users = [];');
		$query = strpos($source, 'SELECT user_id FROM ', $initialization);
		$sync = strpos($source, 'set_personal_albums($sync_users)', $query);

		$this->assertNotFalse($initialization);
		$this->assertNotFalse($query);
		$this->assertNotFalse($sync);
		$this->assertLessThan($query, $initialization);
		$this->assertLessThan($sync, $query);
	}

	public function test_storage_migration_requires_confirmation_authorization_and_csrf_on_resume(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_main.html');
		$quote = chr(39);

		$this->assertStringContainsString('case ' . $quote . 'storage_migrate' . $quote . ':', $source);
		$this->assertStringContainsString('$confirm_lang = ' . $quote . 'STORAGE_MIGRATION_CONFIRM' . $quote . ';', $source);
		$this->assertStringContainsString('is_set_post(' . $quote . 'storage_migration_continue' . $quote . ')', $source);
		$this->assertStringContainsString('check_form_key(' . $quote . 'acp_gallery' . $quote . ')', $source);
		$this->assertStringContainsString('acl_get(' . $quote . 'a_board' . $quote . ')', $source);
		$this->assertStringContainsString('name=' . $quote . 'storage_migration_continue' . $quote, $template);
		$this->assertStringContainsString('method=' . $quote . 'post' . $quote, $template);
		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template);
		$this->assertSame(2, substr_count($template, '}, 1250);'));
		$this->assertStringNotContainsString('}, 250);', $template);
		$this->assertSame(2, substr_count($template, 'continueButton.disabled = true;'));
		$this->assertSame(2, substr_count($template, 'continueButton.disabled = false;'));
	}

	public function test_storage_migration_separates_missing_sources_and_links_optional_cleanup(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_main.html');
		$quote = chr(39);

		$this->assertStringContainsString('$storage_status[' . $quote . 'migratable' . $quote . ']', $source);
		$this->assertStringContainsString('$storage_status[' . $quote . 'missing_source' . $quote . ']', $source);
		$this->assertStringContainsString('is_enabled(' . $quote . 'phpbbgallery/acpcleanup' . $quote . ')', $source);
		$this->assertStringContainsString('acl_get(' . $quote . 'a_gallery_cleanup' . $quote . ')', $source);
		$this->assertStringContainsString('check_mode=source', $source);
		$this->assertStringContainsString('STORAGE_MIGRATION_MISSING_SOURCE_EXPLAIN', $template);
		$this->assertStringContainsString('S_STORAGE_CLEANUP_AVAILABLE', $template);
		$this->assertStringContainsString('gallery-storage-cleanup-link', $template);
		$stylesheet = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_acp_operation_help.css');
		$this->assertStringContainsString('.errorbox a.gallery-storage-cleanup-link', $stylesheet);
		$this->assertStringContainsString('color: #000;', $stylesheet);
		$this->assertStringNotContainsString('S_STORAGE_MIGRATION_PENDING', $template);
	}

	public function test_dimension_resync_is_confirmed_authorized_and_bounded(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_main.html');

		$this->assertStringContainsString("case 'image_dimensions':", $source);
		$this->assertStringContainsString("'RESYNC_IMAGE_DIMENSIONS_CONFIRM'", $source);
		$this->assertStringContainsString("is_set_post('dimension_sync_continue')", $source);
		$this->assertStringContainsString("check_form_key('acp_gallery')", $source);
		$this->assertStringContainsString("acl_get('a_board')", $source);
		$this->assertStringContainsString('$batch_size = 25;', $source);
		$this->assertStringContainsString('$db->sql_query_limit($sql, $batch_size + 1)', $source);
		$this->assertStringContainsString('name="dimension_sync_continue"', $template);
		$this->assertStringContainsString('dimension_sync_continue_form', $template);
		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $template);
	}

	public function test_overview_operations_offer_accessible_contextual_help(): void
	{
		$root = dirname(__DIR__);
		$source = (string) file_get_contents($root . '/acp/main_module.php');
		$template = (string) file_get_contents($root . '/adm/style/gallery_main.html');
		$event = (string) file_get_contents($root . '/adm/style/event/acp_overall_header_head_append.html');
		$javascript = (string) file_get_contents($root . '/adm/style/gallery_acp_operation_help.js');
		$stylesheet = (string) file_get_contents($root . '/adm/style/gallery_acp_operation_help.css');

		$this->assertStringContainsString("'S_GALLERY_ACP_OPERATION_HELP'", $source);
		$this->assertSame(7, substr_count($template, 'data-gallery-operation-help-open='));
		$this->assertSame(7, substr_count($template, 'class="gallery-operation-help-actions"'));
		$this->assertSame(7, substr_count($template, '<dialog class="gallery-operation-help-dialog"'));
		$this->assertSame(7, substr_count($template, 'aria-haspopup="dialog"'));
		$this->assertStringContainsString('GALLERY_PURGE_CACHE_HELP', $template);
		$this->assertStringContainsString('GALLERY_RESYNC_ALBUMS_TO_CPF_HELP', $template);
		$this->assertStringContainsString('S_GALLERY_ACP_OPERATION_HELP', $event);
		$this->assertStringContainsString('gallery_acp_operation_help.css', $event);
		$this->assertStringContainsString('gallery_acp_operation_help.js', $event);
		$this->assertStringContainsString('showModal', $javascript);
		$this->assertStringContainsString("event.key !== 'Escape'", $javascript);
		$this->assertStringContainsString('previousFocus.focus()', $javascript);
		$this->assertStringContainsString('::backdrop', $stylesheet);
		$this->assertStringContainsString('position: fixed;', $stylesheet);
		$this->assertStringContainsString('inset: 0;', $stylesheet);
		$this->assertStringContainsString('margin: auto;', $stylesheet);
	}
}
