<?php

namespace devspace\userdefaults\tests;

use PHPUnit\Framework\TestCase;

class source_deployment_parity_test extends TestCase
{
	public function test_source_and_deployed_trees_are_identical()
	{
		$root = __DIR__;
		while (dirname($root) !== $root && !is_dir($root . '/.git'))
		{
			$root = dirname($root);
		}

		$source = $root . '/devspace/userdefaults';
		$deployed = $root . '/_forum/ext/devspace/userdefaults';
		if (!is_dir($source) || !is_dir($deployed))
		{
			$this->markTestSkipped('Repository deployment tree is not available.');
		}

		$this->assertSame($this->hashes($source), $this->hashes($deployed));
	}

	protected function hashes($directory)
	{
		$hashes = array();
		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS));
		foreach ($iterator as $file)
		{
			if ($file->isFile())
			{
				$relative = str_replace('\\', '/', substr($file->getPathname(), strlen($directory) + 1));
				$hashes[$relative] = hash_file('sha256', $file->getPathname());
			}
		}
		ksort($hashes);

		return $hashes;
	}
}
