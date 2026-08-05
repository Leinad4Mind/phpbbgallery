<?php
/**
 * phpBB Gallery - EXIF capture-date synchronization
 *
 * @package   phpbbgallery/exif
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\exif;

use phpbb\db\driver\driver_interface;
use phpbbgallery\core\storage\provider_interface;
use phpbbgallery\core\storage\workspace;

/** Rebuild capture metadata from cached EXIF or verified source objects. */
final class capture_sync
{
	private const BATCH_SIZE = 25;

	public function __construct(
		private driver_interface $db,
		private capture_index $index,
		private workspace $workspace,
		private string $images_table
	)
	{
	}

	public function refresh_image(int $image_id, string $filename): ?bool
	{
		if (!in_array(strtolower(pathinfo($filename, PATHINFO_EXTENSION)), ['jpg', 'jpeg'], true))
		{
			$this->persist($image_id, exif::UNAVAILABLE, '');
			$this->index->delete([$image_id]);

			return false;
		}

		$source = null;
		try
		{
			$source = $this->workspace->materialize(provider_interface::SOURCE, $filename);
			$exif = new exif($source->get_path());
			$exif->read();
			$this->persist($image_id, $exif->status, $exif->serialized);

			return $this->index->replace($image_id, $exif->serialized);
		}
		catch (\RuntimeException)
		{
			return null;
		}
		finally
		{
			if ($source !== null)
			{
				$source->release();
			}
		}
	}

	/** @return array{scanned: int, indexed: int, unavailable: int, last_id: int, has_more: bool} */
	public function run_batch(int $after_image_id): array
	{
		$sql = 'SELECT image_id, image_filename, image_exif_data
			FROM ' . $this->images_table . '
			WHERE image_id > ' . max(0, $after_image_id) . '
			ORDER BY image_id ASC';
		$result = $this->db->sql_query_limit($sql, self::BATCH_SIZE + 1);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		$has_more = count($rows) > self::BATCH_SIZE;
		if ($has_more)
		{
			array_pop($rows);
		}

		$indexed = 0;
		$unavailable = 0;
		$last_id = $after_image_id;
		foreach ($rows as $row)
		{
			$image_id = (int) $row['image_id'];
			$last_id = $image_id;
			$serialized = (string) ($row['image_exif_data'] ?? '');
			if (capture_index::serialized_is_valid($serialized))
			{
				$indexed += $this->index->replace($image_id, $serialized) ? 1 : 0;
				continue;
			}

			$refreshed = $this->refresh_image($image_id, (string) $row['image_filename']);
			if ($refreshed === true)
			{
				$indexed++;
			}
			else if ($refreshed === null)
			{
				$unavailable++;
			}
		}

		return [
			'scanned' => count($rows),
			'indexed' => $indexed,
			'unavailable' => $unavailable,
			'last_id' => $last_id,
			'has_more' => $has_more,
		];
	}

	private function persist(int $image_id, int $status, string $serialized): void
	{
		$sql = 'UPDATE ' . $this->images_table . '
			SET ' . $this->db->sql_build_array('UPDATE', [
				'image_has_exif' => $status,
				'image_exif_data' => $serialized,
			]) . '
			WHERE image_id = ' . (int) $image_id;
		$this->db->sql_query($sql);
	}
}
