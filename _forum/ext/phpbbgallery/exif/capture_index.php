<?php
/**
 * phpBB Gallery - EXIF capture-date index
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif;

use phpbb\db\driver\driver_interface;

/** Indexed projection of DateTimeOriginal used by album sorting. */
final class capture_index
{
	public function __construct(
		private driver_interface $db,
		private string $table
	)
	{
	}

	public static function serialized_is_valid(string $serialized): bool
	{
		if ($serialized === '')
		{
			return false;
		}

		try
		{
			return is_array(json_decode($serialized, true, 512, JSON_THROW_ON_ERROR));
		}
		catch (\JsonException)
		{
			return false;
		}
	}

	public static function timestamp_from_serialized(string $serialized): ?int
	{
		try
		{
			$data = json_decode($serialized, true, 512, JSON_THROW_ON_ERROR);
		}
		catch (\JsonException)
		{
			return null;
		}

		return is_array($data) ? self::timestamp_from_data($data) : null;
	}

	public static function timestamp_from_data(array $data): ?int
	{
		$exif = $data['EXIF'] ?? null;
		if (!is_array($exif) || !isset($exif['DateTimeOriginal']) || is_array($exif['DateTimeOriginal']))
		{
			return null;
		}

		$date = trim((string) $exif['DateTimeOriginal']);
		if (preg_match('/^\d{4}:\d{2}:\d{2} \d{2}:\d{2}:\d{2}$/D', $date) !== 1)
		{
			return null;
		}

		$offset = '+00:00';
		if (isset($exif['OffsetTimeOriginal']) && !is_array($exif['OffsetTimeOriginal']))
		{
			$candidate = trim((string) $exif['OffsetTimeOriginal']);
			if (preg_match('/^[+-](?:[01]\d|2[0-3]):[0-5]\d$/D', $candidate) === 1)
			{
				$offset = $candidate;
			}
		}

		$captured = \DateTimeImmutable::createFromFormat('!Y:m:d H:i:sP', $date . $offset);
		$errors = \DateTimeImmutable::getLastErrors();
		if ($captured === false
			|| (is_array($errors) && ((int) $errors['warning_count'] > 0 || (int) $errors['error_count'] > 0))
			|| $captured->format('Y:m:d H:i:s') !== $date)
		{
			return null;
		}

		return $captured->getTimestamp() + exif::TIME_OFFSET;
	}

	/** Replace one derived index row; missing dates deliberately have no row. */
	public function replace(int $image_id, string $serialized): bool
	{
		$this->delete([$image_id]);
		$timestamp = self::timestamp_from_serialized($serialized);
		if ($timestamp === null)
		{
			return false;
		}

		$sql = 'INSERT INTO ' . $this->table . ' ' . $this->db->sql_build_array('INSERT', [
			'exif_image_id' => $image_id,
			'exif_taken_time' => $timestamp,
		]);
		$this->db->sql_query($sql);

		return true;
	}

	public function delete(array $image_ids): void
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids))));
		if (!$image_ids)
		{
			return;
		}

		$sql = 'DELETE FROM ' . $this->table . '
			WHERE ' . $this->db->sql_in_set('exif_image_id', $image_ids);
		$this->db->sql_query($sql);
	}

	public function count(): int
	{
		$result = $this->db->sql_query('SELECT COUNT(exif_image_id) AS total FROM ' . $this->table);
		$total = (int) $this->db->sql_fetchfield('total');
		$this->db->sql_freeresult($result);

		return $total;
	}
}
