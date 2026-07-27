<?php
/**
 * BBTags MCP moderation architecture tests.
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbtags\tests;

use PHPUnit\Framework\TestCase;

class mcp_moderation_test extends TestCase
{
	public function test_queue_is_in_mcp_and_not_acp(): void
	{
		$root = dirname(__DIR__);
		$module = (string) file_get_contents($root . '/mcp/bbtags_module.php');
		$info = (string) file_get_contents($root . '/mcp/bbtags_info.php');
		$acp = (string) file_get_contents($root . '/acp/bbtags_module.php');

		$this->assertStringContainsString('acl_m_bbtags_moderate', $info);
		$this->assertStringContainsString('check_form_key(self::FORM_KEY)', $module);
		$this->assertStringContainsString("is_set_post('action')", $module);
		$this->assertStringContainsString("['approve', 'reject']", $module);
		$this->assertStringContainsString('sitesplat.bbtags.provider_registry', $module);
		$this->assertStringNotContainsString("provider === 'forum_topics'", $module);
		$this->assertStringNotContainsString('approve_suggestion', $acp);
		$this->assertStringNotContainsString('reject_suggestion', $acp);
	}

	public function test_all_supported_styles_have_a_moderation_queue(): void
	{
		$root = dirname(__DIR__);
		foreach (['prosilver', 'BBOOTS', 'FLATBOOTS'] as $style)
		{
			$template = (string) file_get_contents($root . '/styles/' . $style . '/template/mcp_bbtags.html');
			$this->assertStringContainsString('mcp_header.html', $template, $style);
			$this->assertStringContainsString('mcp_footer.html', $template, $style);
		}
	}

	public function test_mcp_language_catalogs_share_the_same_keys(): void
	{
		$root = dirname(__DIR__);
		$expected = $this->language_keys($root . '/language/en/info_mcp_bbtags.php');
		foreach (['pt', 'pt_br', 'pt_preao'] as $language)
		{
			$this->assertSame($expected, $this->language_keys($root . '/language/' . $language . '/info_mcp_bbtags.php'));
		}
	}

	private function language_keys(string $path): array
	{
		preg_match_all("/^\\s*'([A-Z0-9_]+)'\\s*=>/m", (string) file_get_contents($path), $matches);
		$keys = array_values(array_unique($matches[1]));
		sort($keys);

		return $keys;
	}
}
