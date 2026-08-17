<?php
/**
 * Helpers for tests that cover optional style packages.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace
{
	/**
	 * Return only styles shipped by the component under test.
	 *
	 * @param string       $component_root Component directory containing styles/
	 * @param list<string> $candidates     Style names requested by the test
	 *
	 * @return list<string>
	 */
	function gallery_test_existing_styles(string $component_root, array $candidates = ['prosilver', 'BBOOTS', 'FLATBOOTS'], ?object $test = null): array
	{
		$styles = array_values(array_filter($candidates, static function (string $style) use ($component_root): bool
		{
			return is_dir($component_root . '/styles/' . $style);
		}));
		if ($styles === [] && $test !== null)
		{
			$test->markTestSkipped('This test covers an optional style package that is not distributed here.');
		}

		return $styles;
	}

	/**
	 * Return only fixture files included in the current distribution.
	 *
	 * @param list<string> $files
	 *
	 * @return list<string>
	 */
	function gallery_test_existing_files(array $files, ?object $test = null): array
	{
		$existing = array_values(array_filter($files, static function (string $file): bool
		{
			return is_file($file);
		}));
		if ($existing === [] && $test !== null)
		{
			$test->markTestSkipped('This test covers optional style fixtures that are not distributed here.');
		}

		return $existing;
	}

	/**
	 * Require one optional fixture or skip its style-specific test.
	 */
	function gallery_test_existing_file(string $file, object $test): string
	{
		if (!is_file($file))
		{
			$test->markTestSkipped('This test covers an optional style fixture that is not distributed here.');
		}

		return $file;
	}
}
