<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\storage;

/** Resolve the stable provider key used by each stored image variant. */
final class variant_key
{
	/** @var list<string> Formats whose derived files keep the source key. */
	private const NATIVE_EXTENSIONS = ['gif', 'jpeg', 'jpg', 'png', 'webp', 'avif'];

	public function resolve(string $variant, string $source_key): string
	{
		if ($variant === provider_interface::SOURCE)
		{
			return $source_key;
		}
		if (!in_array($variant, [provider_interface::MEDIUM, provider_interface::MINI], true))
		{
			throw new \InvalidArgumentException('Unknown Gallery storage variant.');
		}

		$extension = strtolower((string) pathinfo($source_key, PATHINFO_EXTENSION));
		if (in_array($extension, self::NATIVE_EXTENSIONS, true))
		{
			return $source_key;
		}

		// External processors always produce browser-safe WebP derivatives. Keeping
		// the complete source key prevents collisions between equal source basenames.
		return $source_key . '.webp';
	}
}
