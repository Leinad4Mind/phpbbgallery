<?php
/**
 * phpBB Gallery - legacy BBCode migration tests
 *
 * @package   phpbbgallery/acpcleanup
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\acpcleanup\tests;

use phpbbgallery\acpcleanup\bbcode\legacy_migrator;
use PHPUnit\Framework\TestCase;

final class legacy_bbcode_migrator_test extends TestCase
{
	public function test_classic_and_xml_storage_are_rewritten_to_the_active_fallback(): void
	{
		$result = $this->migrator()->rewrite_stored_text(
			'Before [album:abc123]12[/album:abc123] and <ALBUM content="34"><s>[album]</s>34<e>[/album]</e></ALBUM> after.',
			'galleryimage'
		);

		$this->assertSame(
			'Before [galleryimage:abc123]12[/galleryimage:abc123] and <GALLERYIMAGE content="34"><s>[galleryimage]</s>34<e>[/galleryimage]</e></GALLERYIMAGE> after.',
			$result['text']
		);
		$this->assertSame(1, $result['classic_replacements']);
		$this->assertSame(1, $result['xml_replacements']);
	}

	public function test_unrelated_album_forms_and_existing_image_tags_are_preserved(): void
	{
		$text = '[album:%]%[/album:%]% [album:uid]not-a-number[/album:uid] [image:uid]9[/image:uid]';
		$result = $this->migrator()->rewrite_stored_text($text, 'image');

		$this->assertSame($text, $result['text']);
		$this->assertSame(0, $result['classic_replacements']);
		$this->assertSame(0, $result['xml_replacements']);
	}

	public function test_invalid_destination_fails_closed_to_the_canonical_image_tag(): void
	{
		$result = $this->migrator()->rewrite_stored_text('[album:uid]7[/album:uid]', 'album');

		$this->assertSame('[image:uid]7[/image:uid]', $result['text']);
		$this->assertSame(1, $result['classic_replacements']);
	}

	public function test_counter_queries_only_numeric_parsed_album_tags(): void
	{
		$db = new legacy_migrator_db();

		$this->assertSame(0, $this->migrator($db)->count_remaining());
		$this->assertCount(3, $db->queries);
		foreach ($db->queries as $sql)
		{
			$this->assertStringContainsString("LIKE '%[album:%]0%[/album:%]%' ", $sql);
			$this->assertStringContainsString("LIKE '%<ALBUM content=\"9%[/album]%'", $sql);
		}
	}

	public function test_classic_batch_moves_the_bbcode_bit_without_reparsing_other_content(): void
	{
		$db = new legacy_migrator_db();
		$db->bbcode_rows = [
			['bbcode_id' => 10, 'bbcode_tag' => 'album'],
			['bbcode_id' => 12, 'bbcode_tag' => 'image'],
		];
		$db->record_sets = [[
			[
				'record_id' => 5,
				'record_text' => 'Keep [b:uid]this[/b:uid] [album:uid]7[/album:uid]',
				'record_bitfield' => base64_encode(chr(32) . chr(32)),
			],
		], [], []];
		$config = new \phpbbgallery\core\config();
		$config->values['bbcode_tag'] = 'image';

		$result = $this->migrator($db, $config)->migrate_batch(10);

		$this->assertSame('Keep [b:uid]this[/b:uid] [image:uid]7[/image:uid]', $db->updates[0]['post_text']);
		$this->assertSame(base64_encode(chr(32) . chr(8)), $db->updates[0]['bbcode_bitfield']);
		$this->assertSame(['migrated' => 1, 'failed' => 0, 'remaining' => 0], $result);
	}

	public function test_known_remaining_avoids_a_second_full_count_after_the_batch(): void
	{
		$db = new legacy_migrator_db();
		$db->bbcode_rows = [
			['bbcode_id' => 10, 'bbcode_tag' => 'album'],
			['bbcode_id' => 12, 'bbcode_tag' => 'image'],
		];
		$db->record_sets = [[[
			'record_id' => 5,
			'record_text' => '[album:uid]7[/album:uid]',
			'record_bitfield' => '',
		]], [], []];
		$config = new \phpbbgallery\core\config();
		$config->values['bbcode_tag'] = 'image';

		$result = $this->migrator($db, $config)->migrate_batch(legacy_migrator::BATCH_SIZE, 8185);

		$this->assertSame(25, legacy_migrator::BATCH_SIZE);
		$this->assertSame(['migrated' => 1, 'failed' => 0, 'remaining' => 8184], $result);
		$this->assertCount(5, $db->queries);
		$this->assertStringNotContainsString('COUNT(', implode(chr(10), $db->queries));
	}

	public function test_action_is_confirmed_batched_and_owned_by_acp_cleanup(): void
	{
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_cleanup.html');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString("if (\$action === 'migrate_legacy_bbcodes')", $module);
		$this->assertStringContainsString("'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM'", $module);
		$this->assertStringContainsString('legacy_migrator::BATCH_SIZE', $module);
		$this->assertStringContainsString("\$result['remaining'] > 0 && \$result['migrated'] > 0", $module);
		$this->assertStringContainsString("'&amp;legacy_remaining=' . \$result['remaining']", $module);
		$this->assertMatchesRegularExpression(
			'/redirect\(\$this->u_action[\s\S]+?legacy_remaining/',
			$module
		);
		$this->assertStringContainsString("lang('GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN', LEGACY_BBCODE_BATCH_SIZE, ACTIVE_BBCODE_TAG)", $template);
		$this->assertStringContainsString('phpbbgallery.acpcleanup.bbcode.legacy_migrator:', $services);
		$this->assertStringNotContainsString('generate_text_for_', (string) file_get_contents(dirname(__DIR__) . '/bbcode/legacy_migrator.php'));

		$core_root = dirname(__DIR__, 2) . '/core';
		$this->assertStringNotContainsString('migrate_legacy_bbcodes', (string) file_get_contents($core_root . '/acp/main_module.php'));
		$this->assertStringNotContainsString('legacy_migrator', (string) file_get_contents($core_root . '/config/services.yml'));
	}

	private function migrator(
		?\phpbb\db\driver\driver_interface $db = null,
		?\phpbbgallery\core\config $config = null
	): legacy_migrator
	{
		return new legacy_migrator(
			$db ?? new legacy_migrator_db(),
			$config ?? new \phpbbgallery\core\config(),
			dirname(__DIR__, 4) . '/',
			'php',
			'phpbb_bbcodes',
			'phpbb_posts',
			'phpbb_privmsgs',
			'phpbb_users'
		);
	}
}

// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound -- Database test double belongs to this isolated service test.
final class legacy_migrator_db implements \phpbb\db\driver\driver_interface
{
	public array $queries = [];
	public array $updates = [];
	public array $bbcode_rows = [];
	public array $record_sets = [];
	private array $current_rows = [];

	public function sql_query(string $sql): bool
	{
		$this->queries[] = $sql;
		if (str_contains($sql, 'SELECT bbcode_id, bbcode_tag'))
		{
			$this->current_rows = $this->bbcode_rows;
		}

		return true;
	}

	public function sql_query_limit(string $sql, int $limit): object
	{
		$this->queries[] = $sql;

		return (object) ['rows' => array_shift($this->record_sets) ?? []];
	}

	public function sql_fetchrow(bool $result): array|false
	{
		return array_shift($this->current_rows) ?: false;
	}

	/** @return array<int, array<string, mixed>> */
	public function sql_fetchrowset(object $result): array
	{
		return $result->rows;
	}

	public function sql_fetchfield(string $field): int
	{
		return 0;
	}

	public function sql_freeresult(mixed $result): void
	{
	}

	public function sql_in_set(string $field, array $values): string
	{
		return $field . " IN ('" . implode("', '", $values) . "')";
	}

	public function sql_build_array(string $query, array $values): string
	{
		$this->updates[] = $values;

		return 'updated-values';
	}
}
