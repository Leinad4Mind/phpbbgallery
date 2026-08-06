<?php
/**
 *
 * Advanced Polls tests
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\tests;

use PHPUnit\Framework\TestCase;

class language_catalog_test extends TestCase
{
	public function test_every_translation_matches_english_language_key_order()
	{
		$root = dirname(__DIR__) . '/language';
		$files = array(
			'advancedpolls.php',
			'advancedpolls_common.php',
			'info_acp_advancedpolls.php',
			'permissions_advancedpolls.php',
		);

		foreach ($files as $file)
		{
			$reference = $this->load_language($root . '/en/' . $file);
			foreach (glob($root . '/*', GLOB_ONLYDIR) as $directory)
			{
				$locale = basename($directory);
				$target_file = $directory . '/' . $file;
				$this->assertFileExists($target_file, $locale . '/' . $file);
				$translation = $this->load_language($target_file);
				$this->assertSame(
					array_keys($reference),
					array_keys($translation),
					$locale . '/' . $file . ' language keys do not match the English order'
				);
			}
		}
	}

	public function test_enable_notice_is_translated_and_preserves_every_placeholder()
	{
		$root = dirname(__DIR__) . '/language';
		$english = $this->load_language($root . '/en/info_acp_advancedpolls.php');

		foreach (glob($root . '/*', GLOB_ONLYDIR) as $directory)
		{
			$locale = basename($directory);
			$translation = $this->load_language($directory . '/info_acp_advancedpolls.php');
			$notice = $translation['AP_ENABLE_NOTICE'];

			for ($placeholder = 1; $placeholder <= 9; $placeholder++)
			{
				$this->assertStringContainsString('%' . $placeholder . '$s', $notice, $locale);
			}
			if ($locale !== 'en')
			{
				$this->assertNotSame($english['AP_ENABLE_NOTICE'], $notice, $locale . ' still uses the English notice');
			}
		}
	}

	public function test_every_translation_preserves_format_placeholders()
	{
		$root = dirname(__DIR__) . '/language';
		$files = array(
			'advancedpolls.php',
			'advancedpolls_common.php',
			'info_acp_advancedpolls.php',
			'permissions_advancedpolls.php',
		);

		foreach ($files as $file)
		{
			$reference = $this->load_language($root . '/en/' . $file);
			foreach (glob($root . '/*', GLOB_ONLYDIR) as $directory)
			{
				$locale = basename($directory);
				$translation = $this->load_language($directory . '/' . $file);
				foreach ($reference as $key => $value)
				{
					$this->assert_placeholder_compatibility(
						$value,
						$translation[$key],
						$locale . '/' . $file . ': ' . $key
					);
				}
			}
		}
	}

	private function load_language($file)
	{
		return (static function ($file) {
			$lang = array();
			include $file;
			return $lang;
		})($file);
	}

	private function assert_placeholder_compatibility($reference, $translation, $message)
	{
		if (is_array($reference))
		{
			$this->assertIsArray($translation, $message);
			foreach ($reference as $key => $plural_value)
			{
				$this->assertArrayHasKey($key, $translation, $message);
				$this->assert_placeholder_compatibility($plural_value, $translation[$key], $message . '[' . $key . ']');
			}
			return;
		}

		$this->assertSame($this->placeholder_signature($reference), $this->placeholder_signature($translation), $message);
	}

	private function placeholder_signature($value)
	{
		preg_match_all('/%(?:(\d+)\$)?([bcdeEfFgGosuxX])/', $value, $matches, PREG_SET_ORDER);
		$signature = array();
		$automatic_position = 1;
		foreach ($matches as $match)
		{
			$position = $match[1] !== '' ? (int) $match[1] : $automatic_position++;
			$signature[] = $position . ':' . strtolower($match[2]);
		}
		sort($signature);
		return $signature;
	}
}
