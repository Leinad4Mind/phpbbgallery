<?php
/**
 * phpBB Gallery - Batch image metadata editor
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\image;

final class batch_editor
{
	public const MAX_SEQUENCE = 999999999;

	/**
	 * Replace every explicit sequence token without altering other braces or BBCode.
	 */
	public static function apply_sequence(string $value, int $number): string
	{
		$number = min(self::MAX_SEQUENCE, max(0, $number));

		return str_replace('{NUM}', (string) $number, $value);
	}
}
