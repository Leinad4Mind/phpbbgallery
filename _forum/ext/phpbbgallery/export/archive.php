<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export;

/**
 * Turn gallery rows into a ZIP archive that carries the names the board shows.
 *
 * On disk an image is a hashed filename with no album around it; the readable name
 * lives in the database and the extension only in the hashed name. Everything here
 * puts those halves back together and writes them out under an album tree, in
 * batches small enough to survive a request timeout.
 */
class archive
{
	public const MANIFEST_CSV = 'manifest.csv';
	public const MANIFEST_JSON = 'manifest.json';

	/** Folder personal albums are grouped under inside the archive. */
	public const PERSONAL_ROOT = 'Personal Albums';

	/** Longest path segment, in bytes, that every common filesystem accepts. */
	public const MAX_SEGMENT_LENGTH = 255;

	/** Longest album slug kept in a server-side archive name. */
	private const MAX_SLUG_LENGTH = 60;

	/**
	 * Characters a path segment may not contain. Replaced rather than dropped, so
	 * "AC/DC" stays legible as "AC-DC".
	 */
	private const RESERVED_CHARACTERS = ['/', '\\', ':', '*', '?', '"', '<', '>', '|'];

	/**
	 * Enough of Latin-1 and Latin Extended-A to keep Portuguese, Spanish, French and
	 * German album names readable once an archive name is reduced to plain ASCII for
	 * the sake of FTP clients.
	 */
	private const TRANSLITERATION = [
		'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'ā' => 'a',
		'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e', 'ē' => 'e',
		'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
		'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ō' => 'o',
		'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ū' => 'u',
		'ç' => 'c', 'ñ' => 'n', 'ý' => 'y', 'ÿ' => 'y', 'ß' => 'ss', 'æ' => 'ae', 'œ' => 'oe',
	];

	/** Private local workspace for active-provider objects. */
	private \phpbbgallery\core\storage\workspace $workspace;

	/**
	 * Constructor
	 *
	 * @param \phpbbgallery\core\storage\workspace $workspace Gallery storage workspace
	 */
	public function __construct(\phpbbgallery\core\storage\workspace $workspace)
	{
		$this->workspace = $workspace;
	}

	/**
	 * Make one album or file name safe to use as a path segment.
	 *
	 * This is the write-side mirror of the extractor's path validation in the core
	 * upload service, so an archive this add-on produces is one the gallery would
	 * also accept back.
	 *
	 * @param string $segment    Raw name, as stored in the database
	 * @param string $fallback   Used when nothing usable survives
	 * @param int    $max_length Largest accepted length in bytes
	 * @return string
	 */
	public static function sanitize_segment(string $segment, string $fallback, int $max_length = self::MAX_SEGMENT_LENGTH): string
	{
		$segment = htmlspecialchars_decode($segment);

		// Anything that is not valid UTF-8 cannot be reasoned about, and a filename
		// built from it would be unusable anyway.
		if (preg_match('//u', $segment) !== 1)
		{
			return $fallback;
		}

		$segment = str_replace(self::RESERVED_CHARACTERS, '-', $segment);

		// Control characters that stand for whitespace become a space, so words do
		// not run together; the rest carry no meaning in a name and are dropped.
		$segment = (string) preg_replace('/[\t\n\v\f\r]+/u', ' ', $segment);
		$segment = (string) preg_replace('/[\x00-\x1F\x7F]+/u', '', $segment);
		$segment = (string) preg_replace('/\s+/u', ' ', $segment);
		$segment = trim($segment);

		// A name made only of directory references or of the characters that just
		// got replaced says nothing; "..", "." and "///" all end up here.
		if (trim($segment, '-. ') === '')
		{
			return $fallback;
		}

		if (strlen($segment) > $max_length)
		{
			$segment = (string) mb_strcut($segment, 0, $max_length, 'UTF-8');
		}

		// Windows silently drops trailing dots and spaces, which would turn two
		// distinct names into one.
		$segment = rtrim($segment, " \t.");

		return $segment === '' ? $fallback : $segment;
	}

	/**
	 * Build the path an image takes inside the archive.
	 *
	 * Image and author identifiers make the exported filename stable and unique;
	 * the extension comes from the generated storage key.
	 *
	 * @param array  $album_segments Album names from the root down to the image's album
	 * @param string $image_name     Display name, as stored
	 * @param string $image_filename Hashed filename on disk
	 * @param int    $image_id       Image identifier
	 * @param int    $author_id      Final image author identifier
	 * @return string
	 */
	public static function entry_path(array $album_segments, string $image_name, string $image_filename, int $image_id, int $author_id): string
	{
		$segments = [];
		foreach ($album_segments as $album_segment)
		{
			$segments[] = self::sanitize_segment((string) $album_segment, 'album');
		}

		$extension = \phpbbgallery\core\file\file::extension_by_filename($image_filename);
		$prefix = max(0, $image_id) . '_' . max(0, $author_id) . '_';
		$suffix = $extension !== '' ? '.' . $extension : '';

		$name = self::sanitize_segment($image_name, 'image', self::MAX_SEGMENT_LENGTH - strlen($prefix) - strlen($suffix));
		$segments[] = $prefix . $name . $suffix;

		return implode('/', $segments);
	}

	/**
	 * Reduce a name to a lowercase ASCII slug, for use in a filename that has to
	 * survive being listed by an FTP client.
	 *
	 * @param string $text Raw name
	 * @return string
	 */
	public static function slug(string $text): string
	{
		$text = htmlspecialchars_decode($text);
		if (preg_match('//u', $text) !== 1)
		{
			return '';
		}

		$text = strtr(mb_strtolower($text, 'UTF-8'), self::TRANSLITERATION);
		$text = (string) preg_replace('/[^a-z0-9]+/', '-', $text);
		$text = trim($text, '-');

		if (strlen($text) > self::MAX_SLUG_LENGTH)
		{
			$text = rtrim(substr($text, 0, self::MAX_SLUG_LENGTH), '-');
		}

		return $text;
	}

	/**
	 * Name a server-side archive so an admin can recognise it over FTP.
	 *
	 * @param string $label     Album name when a single album was picked, otherwise empty
	 * @param int    $timestamp Creation time
	 * @return string
	 */
	public static function server_archive_name(string $label, int $timestamp): string
	{
		$slug = self::slug($label);

		return 'gallery-export' . ($slug !== '' ? '-' . $slug : '') . '-' . gmdate('Y-m-d-Hi', $timestamp) . '.zip';
	}

	/**
	 * Name a downloadable archive. It is never shown, so it stays opaque.
	 *
	 * @param string $job_id Job identifier
	 * @return string
	 */
	public static function download_archive_name(string $job_id): string
	{
		return $job_id . '.zip';
	}

	/**
	 * Add one batch of images to the archive.
	 *
	 * A source file that has gone missing is recorded and skipped: an export of a
	 * thousand images must not die because one of them was deleted from disk.
	 *
	 * @param string $archive_path Archive being filled
	 * @param array  $rows         Image rows for this batch
	 * @param bool   $create       True on the first batch, which starts a fresh archive
	 * @return array Result with 'added', 'bytes' and 'errors'
	 */
	public function append(string $archive_path, array $rows, bool $create): array
	{
		$result = ['added' => 0, 'bytes' => 0, 'errors' => []];

		$zip = new \ZipArchive();
		$flags = $create ? (\ZipArchive::CREATE | \ZipArchive::OVERWRITE) : \ZipArchive::CREATE;
		if ($zip->open($archive_path, $flags) !== true)
		{
			$result['errors'][] = ['type' => 'archive', 'file' => basename($archive_path)];
			return $result;
		}

		$objects = [];
		foreach ($rows as $row)
		{
			$object = $this->resolve_source((string) $row['image_filename']);
			if ($object === false)
			{
				$result['errors'][] = ['type' => 'missing', 'image_id' => (int) $row['image_id'], 'file' => (string) $row['image_filename']];
				continue;
			}
			$objects[] = $object;
			$source = $object->get_path();

			$entry = self::entry_path($row['album_segments'], (string) $row['image_name'], (string) $row['image_filename'], (int) $row['image_id'], (int) $row['author_id']);
			if (!$zip->addFile($source, $entry))
			{
				$result['errors'][] = ['type' => 'unreadable', 'image_id' => (int) $row['image_id'], 'file' => (string) $row['image_filename']];
				continue;
			}

			$result['added']++;
			$result['bytes'] += (int) @filesize($source);
		}

		$closed = $zip->close();
		foreach ($objects as $object)
		{
			$object->release();
		}
		if (!$closed)
		{
			$result['errors'][] = ['type' => 'archive', 'file' => basename($archive_path)];
		}

		return $result;
	}

	/**
	 * Write the sidecar manifest into a finished archive.
	 *
	 * @param string $archive_path Archive to complete
	 * @param array  $rows         Every image row the export covers
	 * @param array  $meta         Export metadata for the JSON manifest
	 * @return bool
	 */
	public function write_manifest(string $archive_path, array $rows, array $meta): bool
	{
		$zip = new \ZipArchive();
		if ($zip->open($archive_path, \ZipArchive::CREATE) !== true)
		{
			return false;
		}

		$manifest_rows = self::manifest_rows($rows);
		$zip->addFromString(self::MANIFEST_CSV, self::manifest_csv($manifest_rows));
		$zip->addFromString(self::MANIFEST_JSON, self::manifest_json($manifest_rows, $meta));

		return $zip->close();
	}

	/**
	 * Flatten image rows into the columns the manifest publishes.
	 *
	 * @param array $rows Image rows
	 * @return array
	 */
	public static function manifest_rows(array $rows): array
	{
		$manifest = [];
		foreach ($rows as $row)
		{
			$manifest[] = [
				'image_id' => (int) $row['image_id'],
				'album_id' => (int) $row['album_id'],
				'album_name' => htmlspecialchars_decode((string) $row['album_name']),
				'zip_path' => self::entry_path($row['album_segments'], (string) $row['image_name'], (string) $row['image_filename'], (int) $row['image_id'], (int) $row['author_id']),
				'image_name' => htmlspecialchars_decode((string) $row['image_name']),
				'original_filename' => (string) $row['image_filename'],
				'uploader' => htmlspecialchars_decode((string) $row['uploader']),
				'uploaded_at' => gmdate('c', (int) $row['image_time']),
				'views' => (int) $row['image_view_count'],
				'filesize' => (int) $row['filesize_upload'],
				'description' => (string) $row['description'],
			];
		}

		return $manifest;
	}

	/**
	 * Serialise the manifest as CSV.
	 *
	 * A byte-order mark is written first so spreadsheets open accented album names
	 * as UTF-8 instead of guessing.
	 *
	 * @param array $manifest_rows Rows from manifest_rows()
	 * @return string
	 */
	public static function manifest_csv(array $manifest_rows): string
	{
		$handle = fopen('php://temp', 'r+b');
		if ($handle === false)
		{
			return '';
		}

		fwrite($handle, "\xEF\xBB\xBF");
		fputcsv($handle, ['image_id', 'album_id', 'album_name', 'zip_path', 'image_name', 'original_filename', 'uploader', 'uploaded_at', 'views', 'filesize', 'description'], ',', '"', '');
		foreach ($manifest_rows as $row)
		{
			fputcsv($handle, array_values($row), ',', '"', '');
		}

		rewind($handle);
		$csv = (string) stream_get_contents($handle);
		fclose($handle);

		return $csv;
	}

	/**
	 * Serialise the manifest as JSON, with the export metadata around it.
	 *
	 * @param array $manifest_rows Rows from manifest_rows()
	 * @param array $meta          Export metadata
	 * @return string
	 */
	public static function manifest_json(array $manifest_rows, array $meta): string
	{
		return (string) json_encode([
			'export' => $meta,
			'images' => $manifest_rows,
		], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	}

	/**
	 * Resolve a stored filename to a readable file inside the source directory.
	 *
	 * The filename comes from the database and is generated by the gallery itself,
	 * but it is still confined to the source directory before anything is read.
	 *
	 * @param string $filename Stored filename
	 * @return \phpbbgallery\core\storage\local_object|false Local lease, or false when unavailable
	 */
	private function resolve_source(string $filename): \phpbbgallery\core\storage\local_object|false
	{
		try
		{
			return $this->workspace->materialize(\phpbbgallery\core\storage\provider_interface::SOURCE, $filename);
		}
		catch (\RuntimeException)
		{
			return false;
		}
	}
}
