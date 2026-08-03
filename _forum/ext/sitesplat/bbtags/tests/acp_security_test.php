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
		$this->assertStringContainsString("array('delete', 'gaUpdate', 'merge', 'save_config', 'save_policy')", $module);
	}

	public function test_acp_template_posts_delete_and_form_tokens()
	{
		$template = file_get_contents(dirname(__DIR__) . '/adm/style/acp_bbtags.html');

		$this->assertSame(3, substr_count($template, '{S_FORM_TOKEN}'));
		$this->assertStringContainsString('name="delete_id"', $template);
		$this->assertStringContainsString('name="source_tag_id"', $template);
		$this->assertStringContainsString('name="destination_tag_id"', $template);
		$this->assertStringNotContainsString('action=delete&amp;id=', $template);
	}

	public function test_acp_module_delegates_mutations_to_manager()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/bbtags_module.php');

		$this->assertStringContainsString('$this->manager->delete_tag($delete_id)', $module);
		$this->assertStringContainsString('$this->manager->rename_tag(', $module);
		$this->assertStringContainsString('$this->manager->merge_tags(', $module);
		$this->assertStringContainsString('$this->manager->get_merge_blocking_providers(', $module);
		$this->assertStringContainsString('$this->manager->replace_predefined_tags(', $module);
		$this->assertStringContainsString('$this->manager->get_predefined_tags()', $module);
		$this->assertStringNotContainsString('GROUP_CONCAT(', $module);
	}

	public function test_acp_version_comes_only_from_composer_metadata()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/bbtags_module.php');
		$template = file_get_contents(dirname(__DIR__) . '/adm/style/acp_bbtags.html');
		$composer = json_decode(file_get_contents(dirname(__DIR__) . '/composer.json'), true);

		$this->assertSame('1.3.0', $composer['version']);
		$this->assertStringContainsString("get_metadata('version')", $module);
		$this->assertStringContainsString('{BBTAGS_VERSION}', $template);
		$this->assertStringNotContainsString('L_ACP_BBTAGS_VERSION', $template);
	}

	public function test_forum_policy_editor_uses_scoped_provider_api()
	{
		$module = file_get_contents(dirname(__DIR__) . '/acp/bbtags_module.php');
		$list_template = file_get_contents(dirname(__DIR__) . '/adm/style/acp_bbtags.html');
		$policy_template = file_get_contents(dirname(__DIR__) . '/adm/style/acp_bbtags_policy.html');

		$this->assertStringContainsString('manager::FORUM_PROVIDER', $module);
		$this->assertStringContainsString('get_provider_policies(', $module);
		$this->assertStringContainsString('get_forum_tree()', $module);
		$this->assertStringContainsString('get_scope_rules(', $module);
		$this->assertStringContainsString('save_provider_policy(', $module);
		$this->assertStringContainsString("array('inherit', 'allow', 'deny')", $module);
		$this->assertStringContainsString('{records.U_POLICY}', $list_template);
		$this->assertStringContainsString('name="action" value="save_policy"', $policy_template);
		$this->assertStringContainsString('name="rules[{{ forum.ID }}]"', $policy_template);
		$this->assertStringContainsString('{{ S_FORM_TOKEN }}', $policy_template);
	}

	public function test_listener_declares_the_assigned_manager_property()
	{
		$listener = file_get_contents(dirname(__DIR__) . '/event/listener.php');

		$this->assertStringContainsString('protected $manager;', $listener);
		$this->assertStringNotContainsString('protected $tag_manager;', $listener);
		$this->assertStringContainsString("htmlspecialchars(\$tags, ENT_QUOTES, 'UTF-8')", $listener);
		$this->assertStringContainsString('sync_item_suggestions(', $listener);
		$this->assertStringContainsString('manager::FORUM_PROVIDER', $listener);
		$this->assertStringContainsString("'core.search_modify_rowset'", $listener);
		$this->assertStringContainsString("'core.search_modify_tpl_ary'", $listener);
		$this->assertStringContainsString('$this->manager->get_topic_tags(', $listener);
		$this->assertStringNotContainsString('$this->manager->slug(', $listener);
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
