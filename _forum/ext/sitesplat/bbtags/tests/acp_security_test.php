<?php
/**
 * BBTags ACP security contract tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;

class acp_security_test extends TestCase
{
	public function test_mutating_actions_require_form_key()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/bbtags_module.php');

		$this->assertStringContainsString('add_form_key(self::FORM_KEY)', $module);
		$this->assertStringContainsString('check_form_key(self::FORM_KEY)', $module);
		$this->assertStringContainsString("array('delete', 'gaUpdate', 'save_config')", $module);
	}

	public function test_acp_template_posts_delete_and_form_tokens()
	{
		$template = file_get_contents(dirname(__DIR__) . '/adm/style/acp_bbtags.html');

		$this->assertSame(2, substr_count($template, '{S_FORM_TOKEN}'));
		$this->assertStringContainsString('name="delete_id"', $template);
		$this->assertStringNotContainsString('action=delete&amp;id=', $template);
	}

	public function test_acp_module_delegates_mutations_to_manager()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/bbtags_module.php');

		$this->assertStringContainsString('$this->manager->delete_tag($delete_id)', $module);
		$this->assertStringContainsString('$this->manager->rename_tag(', $module);
		$this->assertStringContainsString('$this->manager->replace_predefined_tags(', $module);
		$this->assertStringContainsString('$this->manager->get_predefined_tags()', $module);
		$this->assertStringNotContainsString('GROUP_CONCAT(', $module);
	}

	public function test_listener_declares_the_assigned_manager_property()
	{
		$listener = file_get_contents(dirname(__DIR__) . '/event/listener.php');

		$this->assertStringContainsString('protected $manager;', $listener);
		$this->assertStringNotContainsString('protected $tag_manager;', $listener);
		$this->assertStringContainsString("htmlspecialchars(\$tags, ENT_QUOTES, 'UTF-8')", $listener);
		$this->assertStringContainsString('sync_item_suggestions(', $listener);
		$this->assertStringContainsString('manager::FORUM_PROVIDER', $listener);
	}

	public function test_acp_language_catalogs_share_the_same_keys()
	{
		$expected_keys = $this->load_language_keys('en');
		foreach (array('pt', 'pt_br', 'pt_preao') as $language)
		{
			$this->assertSame($expected_keys, $this->load_language_keys($language), $language);
		}
	}

	public function test_public_language_catalogs_share_the_same_keys()
	{
		$expected_keys = $this->load_language_keys('en', 'bbtags');
		foreach (array('pt', 'pt_br', 'pt_preao') as $language)
		{
			$this->assertSame($expected_keys, $this->load_language_keys($language, 'bbtags'), $language);
		}
	}

	private function load_language_keys($language, $file = 'info_acp_bbtags')
	{
		$lang = array();
		include dirname(__DIR__) . '/language/' . $language . '/' . $file . '.php';
		$keys = array_keys($lang);
		sort($keys);

		return $keys;
	}
}
