<?php

namespace forumhulp\searchresults\tests;

use PHPUnit\Framework\TestCase;

class security_policy_test extends TestCase
{
	public function test_public_keyword_update_uses_an_integer_primary_key(): void
	{
		$listener = $this->source('/event/listener.php');

		$this->assertStringContainsString("WHERE search_key = ' . (int) \$canonical['search_key']", $listener);
		$this->assertStringNotContainsString('WHERE search_keywords = "', $listener);
		$this->assertStringContainsString('sql_escape($keyword)', $listener);
		$this->assertStringContainsString('hits = hits + 1', $listener);
	}

	public function test_malicious_sql_syntax_is_split_into_safe_words(): void
	{
		$reflection = new \ReflectionClass(\forumhulp\searchresults\event\listener::class);
		$listener = $reflection->newInstanceWithoutConstructor();
		$normalise = $reflection->getMethod('normalise_keywords');

		$this->assertSame(
			['alpha', 'sleep', 'omega'],
			$normalise->invoke($listener, 'alpha"OR(SLEEP(5))OR"omega', 2, 30)
		);
		$this->assertSame(
			['ação', "d'ouro"],
			$normalise->invoke($listener, "AÇÃO d'OURO", 4, 30)
		);
	}

	public function test_destructive_actions_require_post_acl_form_key_and_confirmation(): void
	{
		$module = $this->source('/acp/searchresults_module.php');

		$this->assertSame(3, substr_count($module, 'request_interface::POST'));
		$this->assertStringContainsString("acl_get('a_clearlogs')", $module);
		$this->assertStringContainsString('check_form_key(self::FORM_KEY)', $module);
		$this->assertStringContainsString('confirm_box(true)', $module);
		$this->assertStringContainsString('redirect($this->u_action)', $module);
		$this->assertStringNotContainsString('TRUNCATE TABLE', $module);
	}

	public function test_sorting_has_a_safe_fallback_and_count_is_portable(): void
	{
		$module = $this->source('/acp/searchresults_module.php');

		$this->assertStringContainsString('if (!isset($sort_columns[$sort_key]))', $module);
		$this->assertStringContainsString("\$sort_key = 'v';", $module);
		$this->assertDoesNotMatchRegularExpression('/COUNT\([^)]*\).*ORDER BY/s', $module);
	}

	public function test_pruning_is_called_and_uses_portable_limited_queries(): void
	{
		$listener = $this->source('/event/listener.php');

		$this->assertSame(2, substr_count($listener, '$this->prune_searchresults();'));
		$this->assertStringContainsString('sql_query_limit($sql, self::PRUNE_BATCH_SIZE, $maximum_records)', $listener);
		$this->assertStringNotContainsString(' LIMIT ', $listener);
	}

	public function test_ids_are_normalised_before_deletion(): void
	{
		$reflection = new \ReflectionClass(\forumhulp\searchresults\acp\searchresults_module::class);
		$module = $reflection->newInstanceWithoutConstructor();
		$normalise = $reflection->getMethod('normalise_ids');

		$this->assertSame([], $normalise->invoke($module, [0, -1, 'invalid']));
		$this->assertSame([2, 3], $normalise->invoke($module, [2, '2', 3, 2]));
	}

	private function source(string $path): string
	{
		return (string) file_get_contents(dirname(__DIR__) . $path);
	}
}
