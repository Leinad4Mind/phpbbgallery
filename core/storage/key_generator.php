<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/**
 * Generates storage keys without changing the stored basename.
 */
class key_generator
{
	public const LAYOUT_FLAT = 'flat';
	public const LAYOUT_DISTRIBUTED = 'distributed';

	private \phpbbgallery\core\config $config;

	public function __construct(\phpbbgallery\core\config $config)
	{
		$this->config = $config;
	}

	/**
	 * Build the key for a newly generated basename.
	 *
	 * @throws \InvalidArgumentException When the basename is unsafe.
	 */
	public function create(string $filename): string
	{
		if (!$this->is_safe_basename($filename))
		{
			throw new \InvalidArgumentException('Invalid Gallery storage filename.');
		}

		if ($this->get_layout() === self::LAYOUT_FLAT)
		{
			return $filename;
		}

		$prefix = preg_match('/^[a-f0-9]{2}/i', $filename)
			? strtolower(substr($filename, 0, 2))
			: substr(hash('sha256', $filename), 0, 2);

		return $prefix[0] . '/' . $prefix . '/' . $filename;
	}

	public function get_layout(): string
	{
		$layout = strtolower((string) $this->config->get('storage_layout'));

		return $layout === self::LAYOUT_DISTRIBUTED ? self::LAYOUT_DISTRIBUTED : self::LAYOUT_FLAT;
	}

	private function is_safe_basename(string $filename): bool
	{
		return $filename !== ''
			&& strlen($filename) <= 255
			&& strpos($filename, "\0") === false
			&& preg_match('/^[a-z0-9][a-z0-9._-]*$/iD', $filename) === 1
			&& !in_array($filename, ['.', '..'], true);
	}
}
