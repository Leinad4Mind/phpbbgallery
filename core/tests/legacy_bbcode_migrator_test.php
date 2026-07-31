<?php
/**
 * phpBB Gallery - legacy BBCode migration tests
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\tests;

use phpbbgallery\core\bbcode\legacy_migrator;
use PHPUnit\Framework\TestCase;

final class legacy_bbcode_migrator_test extends TestCase
{
	public function test_classic_and_xml_storage_are_rewritten_to_the_active_fallback(): void
	{
		$migrator = $this->migrator();
		$result = $migrator->rewrite_stored_text(
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
		$migrator = $this->migrator();
		$text = '[album:%]%[/album:%]% [album:uid]not-a-number[/album:uid] [image:uid]9[/image:uid]';
		$result = $migrator->rewrite_stored_text($text, 'image');

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
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->expects($this->exactly(3))
			->method('sql_query')
			->with($this->callback(static function (string $sql): bool
			{
				return str_contains($sql, "LIKE '%[album:%]0%[/album:%]%' ")
					&& str_contains($sql, "LIKE '%<ALBUM content=\"9%[/album]%'");
			}))
			->willReturn(true);
		$db->expects($this->exactly(3))->method('sql_fetchfield')->with('legacy_count')->willReturn(0);
		$db->expects($this->exactly(3))->method('sql_freeresult')->with(true);

		$this->assertSame(0, $this->migrator($db)->count_remaining());
	}

	public function test_classic_batch_moves_the_bbcode_bit_without_reparsing_other_content(): void
	{
		$db = $this->createMock(\phpbb\db\driver\driver_interface::class);
		$db->method('sql_in_set')->willReturn("LOWER(bbcode_tag) IN ('album', 'image')");
		$query_number = 0;
		$db->method('sql_query')->willReturnCallback(static function (string $sql) use (&$query_number)
		{
			$query_number++;

			return $query_number;
		});
		$bbcode_rows = [
			['bbcode_id' => 10, 'bbcode_tag' => 'album'],
			['bbcode_id' => 12, 'bbcode_tag' => 'image'],
			false,
		];
		$db->method('sql_fetchrow')->willReturnCallback(static function () use (&$bbcode_rows)
		{
			return array_shift($bbcode_rows);
		});
		$db->method('sql_query_limit')->willReturnOnConsecutiveCalls(20, 21, 22);
		$db->method('sql_fetchrowset')->willReturnOnConsecutiveCalls([
			[
				'record_id' => 5,
				'record_text' => 'Keep [b:uid]this[/b:uid] [album:uid]7[/album:uid]',
				'record_bitfield' => base64_encode(chr(32) . chr(32)),
			],
		], [], []);
		$db->method('sql_fetchfield')->willReturn(0);
		$updated = [];
		$db->expects($this->once())
			->method('sql_build_array')
			->with('UPDATE', $this->callback(static function (array $values) use (&$updated): bool
			{
				$updated = $values;

				return true;
			}))
			->willReturn('updated-values');

		$gallery_config = new \phpbbgallery\core\config(new \phpbb\config\config([
			'phpbb_gallery_bbcode_tag' => 'image',
		]));
		$migrator = new legacy_migrator(
			$db,
			$gallery_config,
			dirname(__DIR__, 4) . '/',
			'php',
			'phpbb_bbcodes',
			'phpbb_posts',
			'phpbb_privmsgs',
			'phpbb_users'
		);
		$result = $migrator->migrate_batch(10);

		$this->assertSame('Keep [b:uid]this[/b:uid] [image:uid]7[/image:uid]', $updated['post_text']);
		$this->assertSame(base64_encode(chr(32) . chr(8)), $updated['bbcode_bitfield']);
		$this->assertSame(['migrated' => 1, 'failed' => 0, 'remaining' => 0], $result);
	}

	public function test_acp_action_is_confirmed_batched_and_visible_in_the_overview(): void
	{
		$module = (string) file_get_contents(dirname(__DIR__) . '/acp/main_module.php');
		$template = (string) file_get_contents(dirname(__DIR__) . '/adm/style/gallery_main.html');
		$services = (string) file_get_contents(dirname(__DIR__) . '/config/services.yml');

		$this->assertStringContainsString("case 'migrate_legacy_bbcodes':", $module);
		$this->assertStringContainsString("'GALLERY_LEGACY_BBCODE_MIGRATE_CONFIRM'", $module);
		$this->assertStringContainsString('$legacy_bbcode_migrator->migrate_batch()', $module);
		$this->assertStringContainsString("lang('GALLERY_LEGACY_BBCODE_MIGRATE_EXPLAIN', ACTIVE_BBCODE_TAG)", $template);
		$this->assertStringContainsString("if (\$action === 'migrate_legacy_bbcodes')", $module);
		$this->assertStringContainsString('phpbbgallery.core.bbcode.legacy_migrator:', $services);
		$migrator = (string) file_get_contents(dirname(__DIR__) . '/bbcode/legacy_migrator.php');
		$this->assertStringNotContainsString('generate_text_for_', $migrator);
	}

	private function migrator(?\phpbb\db\driver\driver_interface $db = null): legacy_migrator
	{
		return new legacy_migrator(
			$db ?? $this->createMock(\phpbb\db\driver\driver_interface::class),
			new \phpbbgallery\core\config(new \phpbb\config\config([])),
			dirname(__DIR__, 4) . '/',
			'php',
			'phpbb_bbcodes',
			'phpbb_posts',
			'phpbb_privmsgs',
			'phpbb_users'
		);
	}
}
