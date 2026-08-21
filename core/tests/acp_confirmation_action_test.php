<?php
/**
 * phpBB Gallery - ACP confirmation action tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use PHPUnit\Framework\TestCase;

final class acp_confirmation_action_test extends TestCase
{
	/**
	 * @dataProvider acp_module_provider
	 */
	public function test_gallery_acp_confirmations_use_the_canonical_module_action(string $relative_file, int $expected_confirmations): void
	{
		$source = (string) file_get_contents(dirname(__DIR__, 2) . '/' . $relative_file);
		$confirmation_calls = array_filter(
			$this->extract_function_calls($source, 'confirm_box'),
			static fn(string $call): bool => str_starts_with($call, 'confirm_box(false,')
		);

		$this->assertCount($expected_confirmations, $confirmation_calls);
		foreach ($confirmation_calls as $confirmation_call)
		{
			$this->assertStringContainsString("'confirm_body.html', \$this->u_action)", $confirmation_call);
		}
	}

	public static function acp_module_provider(): array
	{
		return [
			['core/acp/main_module.php', 1],
			['core/acp/albums_module.php', 1],
			['core/acp/gallery_logs_module.php', 1],
			['core/acp/permissions_module.php', 1],
			['acpcleanup/acp/main_module.php', 2],
		];
	}

	public function test_log_confirmation_does_not_submit_a_url_as_an_action_command(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/gallery_logs_module.php');

		$this->assertStringNotContainsString("'action'\t\t=> \$this->u_action", $source);
	}

	public function test_album_reordering_is_immediate_but_link_hash_protected(): void
	{
		$source = (string) file_get_contents(dirname(__DIR__) . '/acp/albums_module.php');
		$move_start = strpos($source, "case 'move_up':");
		$sync_start = strpos($source, "case 'sync':", $move_start);
		$move_block = substr($source, $move_start, $sync_start - $move_start);

		$this->assertStringNotContainsString('confirm_box(', $move_block);
		$this->assertStringContainsString("check_link_hash(\$request->variable('hash', ''), \$move_hash_name)", $move_block);
		$this->assertStringContainsString("generate_link_hash('gallery_album_move_up_' . \$row['album_id'])", $source);
		$this->assertStringContainsString("generate_link_hash('gallery_album_move_down_' . \$row['album_id'])", $source);

		$sync_end = strpos($source, "case 'add':", $sync_start);
		$sync_block = substr($source, $sync_start, $sync_end - $sync_start);
		$this->assertStringContainsString('confirm_box(false,', $sync_block);
		$this->assertStringContainsString("case 'delete':", $source);
		$this->assertStringContainsString("'S_DELETE_ALBUM'", $source);
	}

	/**
	 * Extract complete function calls while ignoring parentheses inside PHP tokens.
	 *
	 * @return string[]
	 */
	private function extract_function_calls(string $source, string $function_name): array
	{
		$tokens = token_get_all($source);
		$calls = [];
		$token_count = count($tokens);

		for ($index = 0; $index < $token_count; $index++)
		{
			$token = $tokens[$index];
			if (!is_array($token) || $token[0] !== T_STRING || strcasecmp($token[1], $function_name) !== 0)
			{
				continue;
			}

			$call = $token[1];
			$depth = 0;
			$started = false;
			for ($call_index = $index + 1; $call_index < $token_count; $call_index++)
			{
				$call_token = $tokens[$call_index];
				$token_text = is_array($call_token) ? $call_token[1] : $call_token;
				$call .= $token_text;

				if (!is_array($call_token) && $call_token === '(')
				{
					$depth++;
					$started = true;
				}
				else if (!is_array($call_token) && $call_token === ')')
				{
					$depth--;
					if ($started && $depth === 0)
					{
						$calls[] = preg_replace('/\s+/', ' ', $call);
						$index = $call_index;
						break;
					}
				}
			}
		}

		return $calls;
	}
}
