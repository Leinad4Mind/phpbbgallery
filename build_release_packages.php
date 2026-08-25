<?php
// phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols -- This file intentionally combines the reusable builder with its CLI entrypoint.
/**
 * Build deterministic phpBB Gallery release packages from a committed Git ref.
 *
 * @package   phpbbgallery/release
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

declare(strict_types=1);

namespace phpbbgallery\release;

final class package_builder
{
	public const COMPONENTS = [
		'core',
		'acpcleanup',
		'acpimport',
		'bbpointsimages',
		'bbtagsimages',
		'contest',
		'exif',
		'export',
		'favorite',
		'feed',
		'imagefields',
		'imagerevisions',
		'remotestorage',
		'tiff',
	];

	private string $repository_root;
	private string $suite_path;

	public function __construct(string $repository_root, string $suite_path)
	{
		$resolved_root = realpath($repository_root);
		if ($resolved_root === false || !file_exists($resolved_root . DIRECTORY_SEPARATOR . '.git'))
		{
			throw new \RuntimeException('The repository root is invalid.');
		}

		$this->repository_root = $resolved_root;
		$this->suite_path = trim(str_replace('\\', '/', $suite_path), '/');
	}

	/**
	 * @return array{commit: string, packages: list<array{component: string, version: string, filename: string, sha256: string, bytes: int}>}
	 */
	public function build(string $output_directory, string $ref = 'HEAD'): array
	{
		if (!class_exists('ZipArchive'))
		{
			throw new \RuntimeException('The ZIP extension is required to build release packages.');
		}

		$output_directory = $this->prepare_output_directory($output_directory);
		$commit = trim($this->run_git(['rev-parse', '--verify', $ref . '^{commit}']));
		$timestamp = (int) trim($this->run_git(['show', '-s', '--format=%ct', $commit]));
		if ($timestamp <= 0)
		{
			throw new \RuntimeException('Git returned an invalid commit timestamp.');
		}

		$temp_root = $this->create_temp_directory();
		try
		{
			$archive_path = $temp_root . DIRECTORY_SEPARATOR . 'phpbbgallery.tar';
			$tree = $this->suite_path === '' ? $commit : $commit . ':' . $this->suite_path;
			$this->run_git(['archive', '--format=tar', '--output=' . $archive_path, $tree]);

			$source_root = $temp_root . DIRECTORY_SEPARATOR . 'source';
			if (!mkdir($source_root, 0777, true) && !is_dir($source_root))
			{
				throw new \RuntimeException('Unable to create the temporary extraction directory.');
			}

			$archive = new \PharData($archive_path);
			$archive->extractTo($source_root, null, true);
			unset($archive);

			$packages = [];
			foreach (self::COMPONENTS as $component)
			{
				if (!is_file($source_root . DIRECTORY_SEPARATOR . $component . DIRECTORY_SEPARATOR . 'composer.json'))
				{
					continue;
				}

				$packages[] = $this->build_component($source_root, $output_directory, $component, $timestamp);
			}

			$manifest = [
				'commit' => $commit,
				'packages' => $packages,
			];
			$this->write_metadata($output_directory, $manifest);

			return $manifest;
		}
		finally
		{
			$this->remove_temp_directory($temp_root);
		}
	}

	/**
	 * @return array{component: string, version: string, filename: string, sha256: string, bytes: int}
	 */
	private function build_component(string $source_root, string $output_directory, string $component, int $timestamp): array
	{
		$component_root = $source_root . DIRECTORY_SEPARATOR . $component;
		$composer_path = $component_root . DIRECTORY_SEPARATOR . 'composer.json';
		if (!is_file($composer_path))
		{
			throw new \RuntimeException('Missing composer.json for ' . $component . '.');
		}

		$composer = json_decode((string) file_get_contents($composer_path), true, 512, JSON_THROW_ON_ERROR);
		$expected_name = 'phpbbgallery/' . $component;
		if (($composer['name'] ?? null) !== $expected_name)
		{
			throw new \RuntimeException($component . ' has an unexpected Composer package name.');
		}

		$version = (string) ($composer['version'] ?? '');
		if ($version === '' || preg_match('/^[0-9A-Za-z.-]+$/D', $version) !== 1)
		{
			throw new \RuntimeException($component . ' has an invalid release version.');
		}

		$filename = 'phpbbgallery-' . $component . '-' . $version . '.zip';
		$package_path = $output_directory . DIRECTORY_SEPARATOR . $filename;
		$zip = new \ZipArchive();
		$result = $zip->open($package_path, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
		if ($result !== true)
		{
			throw new \RuntimeException('Unable to create ' . $filename . ' (ZIP error ' . $result . ').');
		}

		try
		{
			$this->add_directory_entry($zip, 'phpbbgallery/', $timestamp);
			$prefix = 'phpbbgallery/' . $component . '/';
			$this->add_directory_entry($zip, $prefix, $timestamp);

			$entries = $this->component_entries($component_root);
			foreach ($entries as $relative_path => $entry)
			{
				$archive_name = $prefix . $relative_path . ($entry['directory'] ? '/' : '');
				if ($entry['directory'])
				{
					$this->add_directory_entry($zip, $archive_name, $timestamp);
					continue;
				}

				if (!$zip->addFile($entry['path'], $archive_name) ||
					!$zip->setMtimeName($archive_name, $timestamp) ||
					!$zip->setCompressionName($archive_name, \ZipArchive::CM_DEFLATE, 9) ||
					!$zip->setExternalAttributesName($archive_name, \ZipArchive::OPSYS_UNIX, 0100644 << 16))
				{
					throw new \RuntimeException('Unable to add ' . $archive_name . ' to ' . $filename . '.');
				}
			}
		}
		finally
		{
			$zip->close();
		}

		$this->validate_package($package_path, $component, $version);
		$hash = hash_file('sha256', $package_path);
		$size = filesize($package_path);
		if ($hash === false || $size === false)
		{
			throw new \RuntimeException('Unable to inspect the completed package ' . $filename . '.');
		}

		return [
			'component' => $component,
			'version' => $version,
			'filename' => $filename,
			'sha256' => $hash,
			'bytes' => $size,
		];
	}

	/**
	 * @return array<string, array{path: string, directory: bool}>
	 */
	private function component_entries(string $component_root): array
	{
		$entries = [];
		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($component_root, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::SELF_FIRST
		);
		$prefix_length = strlen($component_root) + 1;

		foreach ($iterator as $file)
		{
			if ($file->isLink())
			{
				throw new \RuntimeException('Release packages may not contain symbolic links.');
			}

			$relative_path = str_replace('\\', '/', substr($file->getPathname(), $prefix_length));
			if ($relative_path === '' || str_contains($relative_path, '../'))
			{
				throw new \RuntimeException('An unsafe release path was detected.');
			}

			$entries[$relative_path] = [
				'path' => $file->getPathname(),
				'directory' => $file->isDir(),
			];
		}

		ksort($entries, SORT_STRING);
		return $entries;
	}

	private function add_directory_entry(\ZipArchive $zip, string $name, int $timestamp): void
	{
		if (!$zip->addEmptyDir($name) ||
			!$zip->setMtimeName($name, $timestamp) ||
			!$zip->setExternalAttributesName($name, \ZipArchive::OPSYS_UNIX, (040755 << 16) | 0x10))
		{
			throw new \RuntimeException('Unable to add the release directory ' . $name . '.');
		}
	}

	private function validate_package(string $package_path, string $component, string $version): void
	{
		$zip = new \ZipArchive();
		if ($zip->open($package_path) !== true)
		{
			throw new \RuntimeException('The completed package cannot be opened.');
		}

		$prefix = 'phpbbgallery/' . $component . '/';
		$entries = [];
		try
		{
			for ($index = 0; $index < $zip->numFiles; $index++)
			{
				$name = (string) $zip->getNameIndex($index);
				if ($name === '' || str_contains($name, '\\') || str_contains($name, "\0") ||
					preg_match('#(?:^|/)\.\.(?:/|$)#D', $name) === 1)
				{
					throw new \RuntimeException('The package contains an unsafe path.');
				}

				if ($name !== 'phpbbgallery/' && !str_starts_with($name, $prefix))
				{
					throw new \RuntimeException('The package contains a path outside its component root: ' . $name);
				}

				if (preg_match('#/(?:tests|vendor)(?:/|$)|/(?:phpunit\.xml\.dist|composer\.lock)$|/\.git#D', $name) === 1)
				{
					throw new \RuntimeException('The package contains a development-only entry: ' . $name);
				}
				$entries[$name] = true;
			}

			foreach (['composer.json', 'ext.php', 'license.txt'] as $required_file)
			{
				if (!isset($entries[$prefix . $required_file]))
				{
					throw new \RuntimeException($component . ' is missing ' . $required_file . ' in its package.');
				}
			}

			$composer = json_decode((string) $zip->getFromName($prefix . 'composer.json'), true, 512, JSON_THROW_ON_ERROR);
			if (($composer['name'] ?? null) !== 'phpbbgallery/' . $component || ($composer['version'] ?? null) !== $version)
			{
				throw new \RuntimeException('The packaged Composer metadata does not match the package filename.');
			}
		}
		finally
		{
			$zip->close();
		}
	}

	/**
	 * @param array{commit: string, packages: list<array{component: string, version: string, filename: string, sha256: string, bytes: int}>} $manifest
	 */
	private function write_metadata(string $output_directory, array $manifest): void
	{
		$manifest_json = json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL;
		if (file_put_contents($output_directory . DIRECTORY_SEPARATOR . 'release-manifest.json', $manifest_json) === false)
		{
			throw new \RuntimeException('Unable to write release-manifest.json.');
		}

		$checksums = '';
		foreach ($manifest['packages'] as $package)
		{
			$checksums .= $package['sha256'] . '  ' . $package['filename'] . PHP_EOL;
		}
		if (file_put_contents($output_directory . DIRECTORY_SEPARATOR . 'SHA256SUMS', $checksums) === false)
		{
			throw new \RuntimeException('Unable to write SHA256SUMS.');
		}
	}

	private function prepare_output_directory(string $output_directory): string
	{
		if (!is_dir($output_directory) && !mkdir($output_directory, 0777, true) && !is_dir($output_directory))
		{
			throw new \RuntimeException('Unable to create the release output directory.');
		}

		$resolved = realpath($output_directory);
		if ($resolved === false || !is_writable($resolved))
		{
			throw new \RuntimeException('The release output directory is not writable.');
		}
		return $resolved;
	}

	private function create_temp_directory(): string
	{
		$temp_root = rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR .
			'phpbbgallery-release-' . bin2hex(random_bytes(12));
		if (!mkdir($temp_root, 0700, true))
		{
			throw new \RuntimeException('Unable to create the temporary release directory.');
		}
		return $temp_root;
	}

	private function remove_temp_directory(string $temp_root): void
	{
		$resolved_temp = realpath($temp_root);
		$resolved_base = realpath(sys_get_temp_dir());
		if ($resolved_temp === false || $resolved_base === false ||
			!str_starts_with($resolved_temp, rtrim($resolved_base, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'phpbbgallery-release-'))
		{
			throw new \RuntimeException('Refusing to remove an unexpected temporary directory.');
		}

		$iterator = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($resolved_temp, \FilesystemIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::CHILD_FIRST
		);
		foreach ($iterator as $file)
		{
			$file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
		}
		rmdir($resolved_temp);
	}

	/**
	 * @param list<string> $arguments
	 */
	private function run_git(array $arguments): string
	{
		$command = array_merge(['git'], $arguments);
		$process = proc_open(
			$command,
			[1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
			$pipes,
			$this->repository_root
		);
		if (!is_resource($process))
		{
			throw new \RuntimeException('Unable to start Git.');
		}

		$output = stream_get_contents($pipes[1]);
		$error = stream_get_contents($pipes[2]);
		fclose($pipes[1]);
		fclose($pipes[2]);
		$exit_code = proc_close($process);
		if ($exit_code !== 0)
		{
			throw new \RuntimeException('Git failed: ' . trim((string) $error));
		}
		return (string) $output;
	}
}

function find_repository_root(string $start_directory): string
{
	$directory = realpath($start_directory);
	while ($directory !== false)
	{
		if (file_exists($directory . DIRECTORY_SEPARATOR . '.git'))
		{
			return $directory;
		}
		$parent = dirname($directory);
		if ($parent === $directory)
		{
			break;
		}
		$directory = $parent;
	}
	throw new \RuntimeException('Unable to locate the Git repository root.');
}

if (PHP_SAPI === 'cli' && isset($argv[0]) && realpath((string) $argv[0]) === __FILE__)
{
	try
	{
		$options = getopt('', ['output:', 'ref::']);
		if (!isset($options['output']) || !is_string($options['output']) || $options['output'] === '')
		{
			fwrite(STDERR, 'Usage: php build_release_packages.php --output=<directory> [--ref=<git-ref>]' . PHP_EOL);
			exit(2);
		}

		$repository_root = find_repository_root(__DIR__);
		$suite_root = realpath(__DIR__);
		$suite_path = $suite_root === $repository_root ? '' : substr((string) $suite_root, strlen($repository_root) + 1);
		$builder = new package_builder($repository_root, $suite_path);
		$manifest = $builder->build($options['output'], is_string($options['ref'] ?? null) ? $options['ref'] : 'HEAD');

		foreach ($manifest['packages'] as $package)
		{
			fwrite(STDOUT, $package['filename'] . '  ' . $package['sha256'] . PHP_EOL);
		}
	}
	catch (\Throwable $exception)
	{
		fwrite(STDERR, 'Release build failed: ' . $exception->getMessage() . PHP_EOL);
		exit(1);
	}
}
