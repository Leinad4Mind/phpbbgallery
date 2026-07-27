<?php
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- The focused database test double is loaded beside this test case.
/**
 * Shared BBTags input parser tests.
 *
 * @package   phpbbgallery/bbtagsbridge
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\bbtagsbridge\tests;

use phpbb\auth\auth;
use phpbb\config\config;
use phpbbgallery\bbtagsbridge\input_parser;
use PHPUnit\Framework\TestCase;
use sitesplat\bbtags\tags\manager;

require_once __DIR__ . '/fake_db.php';

final class input_parser_test extends TestCase
{
	public function test_parser_uses_shared_normalization_and_preserves_multiword_tags(): void
	{
		$parser = $this->create_parser();

		$this->assertSame(['três irmãs', 'manhwa'], $parser->parse('#Três Irmãs, MANHWA, manhwa'));
		$this->assertSame('três irmãs, manhwa', $parser->format(['três irmãs', ['tag' => 'manhwa']]));
		$this->assertSame([], $parser->parse(''));
	}

	public function test_parser_enforces_shared_count_and_length_limits(): void
	{
		$parser = $this->create_parser();
		foreach ([
			'a' => 'BBTAGSBRIDGE_TAG_TOO_SHORT',
			'12345678901234567' => 'BBTAGSBRIDGE_TAG_TOO_LONG',
			'one, two, three, four' => 'BBTAGSBRIDGE_TAG_LIMIT',
		] as $input => $message)
		{
			try
			{
				$parser->parse($input);
				$this->fail('Invalid tag input was accepted: ' . $input);
			}
			catch (\InvalidArgumentException $exception)
			{
				$this->assertSame($message, $exception->getMessage());
			}
		}
	}

	private function create_parser(): input_parser
	{
		$config = new config([
			'bbtags_min_length' => 2,
			'bbtags_max_length' => 16,
			'bbtags_max_tags' => 3,
		]);
		$tags = new manager(
			new fake_db(),
			$config,
			new auth(),
			'bbtags',
			'bbtags_context',
			'bbtags_scope',
			'bbtags_topic'
		);

		return new input_parser($config, $tags);
	}
}
