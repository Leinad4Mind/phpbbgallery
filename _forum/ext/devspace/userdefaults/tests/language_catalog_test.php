<?php

namespace devspace\userdefaults\tests;

use PHPUnit\Framework\TestCase;

class language_catalog_test extends TestCase
{
	public function test_all_translations_have_matching_keys_and_valid_utf8()
	{
		$root = dirname(__DIR__) . '/language';
		$locales = array('en', 'pt', 'pt_br', 'pt_preao');
		$catalogs = array('acp_userdefaults.php', 'ext_enable_error.php', 'info_acp_userdefaults.php');
		foreach ($catalogs as $catalog)
		{
			$expected = array_keys($this->load_catalog($root . '/en/' . $catalog));
			sort($expected);
			foreach ($locales as $locale)
			{
				$file = $root . '/' . $locale . '/' . $catalog;
				$contents = file_get_contents($file);
				$this->assertSame(1, preg_match('//u', $contents), $file);
				$keys = array_keys($this->load_catalog($file));
				sort($keys);
				$this->assertSame($expected, $keys, $file);
			}
		}
	}

	protected function load_catalog($file)
	{
		$lang = array();
		include $file;
		return $lang;
	}
}
