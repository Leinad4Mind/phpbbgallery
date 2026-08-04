<?php

namespace dmzx\topicindex\tests;

use PHPUnit\Framework\TestCase;

class language_catalog_test extends TestCase
{
	// phpcs:ignore PhpbbCodingStandard.NamingConventions.LowercaseUnderscoredFunctions.NotAllowed -- Required PHPUnit API.
	public static function setUpBeforeClass(): void
	{
		if (!defined('IN_PHPBB'))
		{
			define('IN_PHPBB', true);
		}
	}

	public function test_translated_catalogs_match_english_keys()
	{
		$topicindex_root = dirname(__DIR__) . '/language';
		$bridge_root = dirname(__DIR__, 3) . '/kasimi/topicindexbridge/language';
		foreach ([
			[$topicindex_root, ['acp_topicindex.php', 'common.php', 'info_acp_topicindex.php', 'permissions_topicindex.php']],
			[$bridge_root, ['acp.php', 'common.php']],
		] as $catalogue)
		{
			foreach ($catalogue[1] as $file_name)
			{
				$english_keys = array_keys($this->load_language($catalogue[0] . '/en/' . $file_name));
				sort($english_keys);
				foreach (['pt', 'pt_br', 'pt_preao'] as $language)
				{
					$translated_keys = array_keys($this->load_language($catalogue[0] . '/' . $language . '/' . $file_name));
					sort($translated_keys);
					$this->assertSame($english_keys, $translated_keys, $language . '/' . $file_name);
				}
			}
		}
	}

	private function load_language($path)
	{
		$lang = [];
		include $path;

		return $lang;
	}
}
