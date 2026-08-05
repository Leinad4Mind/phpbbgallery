<?php

namespace dmzx\forumicons\tests;

use dmzx\forumicons\event\listener;
use phpbb\event\data;
use phpbb\language\language;
use phpbb\template\template;
use PHPUnit\Framework\TestCase;

class listener_test extends TestCase
{
	/** @var string */
	private $root;

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required PHPUnit API.
	protected function setUp(): void
	{
		$this->root = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'forumicons-' . bin2hex(random_bytes(8)) . DIRECTORY_SEPARATOR;
		mkdir($this->root . 'images/forumicons', 0777, true);
	}

	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required PHPUnit API.
	protected function tearDown(): void
	{
		$expected_prefix = rtrim(sys_get_temp_dir(), '/\\') . DIRECTORY_SEPARATOR . 'forumicons-';
		if (strpos($this->root, $expected_prefix) !== 0 || !is_dir($this->root))
		{
			return;
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->root, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $item)
		{
			$item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
		}
		rmdir($this->root);
	}

	public function test_only_safe_image_files_are_listed_and_names_are_preserved()
	{
		$directory = $this->root . 'images/forumicons/';
		file_put_contents($directory . 'caraças.png', 'png');
		file_put_contents($directory . 'icon 10.gif', 'gif');
		file_put_contents($directory . 'icon 2.PNG', 'png');
		file_put_contents($directory . "payload');alert(1).png", 'png');
		file_put_contents($directory . 'not-an-image.png.php', 'php');
		file_put_contents($directory . 'notes.txt', 'text');
		mkdir($directory . 'folder.gif');

		$rows = null;
		$template = $this->createMock(template::class);
		$template->expects($this->once())->method('destroy_block_vars')->with('forum_img_file_name');
		$template->expects($this->once())
			->method('assign_block_vars_array')
			->with('forum_img_file_name', $this->callback(function ($icons) use (&$rows)
			{
				$rows = $icons;
				return true;
			}));

		$language = $this->createMock(language::class);
		$language->expects($this->once())
			->method('add_lang')
			->with('acp/info_acp_forumicons', 'dmzx/forumicons');

		$event = new data(['template_data' => []]);
		(new listener($template, $language, $this->root))->acp_manage_forums_display_form($event);

		$this->assertSame(['caraças.png', 'icon 2.PNG', 'icon 10.gif', "payload');alert(1).png"], array_column($rows, 'FORUM_IMAGE_NAME'));
		$this->assertSame('images/forumicons/caraças.png', $rows[0]['FORUM_IMAGE_PATH']);
		$this->assertStringEndsWith('images/forumicons/cara%C3%A7as.png', $rows[0]['FORUM_IMAGE_URL']);
		$this->assertStringEndsWith('images/forumicons/icon%202.PNG', $rows[1]['FORUM_IMAGE_URL']);
		$this->assertStringContainsString('payload%27%29%3Balert%281%29.png', $rows[3]['FORUM_IMAGE_URL']);
		$this->assertTrue($event['template_data']['FORUMICONS_DIRECTORY_AVAILABLE']);
		$this->assertFalse($event['template_data']['FORUMICONS_LIMIT_REACHED']);
	}

	public function test_missing_directory_does_not_raise_an_error()
	{
		rmdir($this->root . 'images/forumicons');
		rmdir($this->root . 'images');

		$template = $this->createMock(template::class);
		$template->expects($this->once())->method('destroy_block_vars');
		$template->expects($this->never())->method('assign_block_vars_array');

		$language = $this->createMock(language::class);
		$event = new data(['template_data' => []]);
		(new listener($template, $language, $this->root))->acp_manage_forums_display_form($event);

		$this->assertFalse($event['template_data']['FORUMICONS_DIRECTORY_AVAILABLE']);
		$this->assertFalse($event['template_data']['FORUMICONS_LIMIT_REACHED']);
	}

	public function test_icon_output_is_limited()
	{
		$directory = $this->root . 'images/forumicons/';
		for ($i = 0; $i <= listener::MAX_ICONS; $i++)
		{
			file_put_contents($directory . sprintf('icon-%03d.png', $i), 'png');
		}

		$rows = null;
		$template = $this->createMock(template::class);
		$template->expects($this->once())
			->method('assign_block_vars_array')
			->with('forum_img_file_name', $this->callback(function ($icons) use (&$rows)
			{
				$rows = $icons;
				return true;
			}));

		$event = new data(['template_data' => []]);
		(new listener($template, $this->createMock(language::class), $this->root))->acp_manage_forums_display_form($event);

		$this->assertCount(listener::MAX_ICONS, $rows);
		$this->assertTrue($event['template_data']['FORUMICONS_LIMIT_REACHED']);
	}
}
