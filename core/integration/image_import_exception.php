<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\integration;

/** Stable machine-readable failure returned by the integration import port. */
final class image_import_exception extends \RuntimeException
{
	public const ACTOR_NOT_FOUND = 'actor_not_found';
	public const ALBUM_NOT_FOUND = 'album_not_found';
	public const NOT_AUTHORISED = 'not_authorised';
	public const QUOTA_REACHED = 'quota_reached';
	public const VALIDATION_FAILED = 'validation_failed';
	public const UPLOAD_FAILED = 'upload_failed';
	public const FINALIZATION_FAILED = 'finalization_failed';
	public const POST_PROCESSING_FAILED = 'post_processing_failed';

	public function __construct(
		private string $reason,
		private array $errors = [],
		?\Throwable $previous = null,
		private ?image_import_result $import_result = null
	)
	{
		parent::__construct($reason, 0, $previous);
	}

	public function get_reason(): string
	{
		return $this->reason;
	}

	public function get_errors(): array
	{
		return $this->errors;
	}

	/**
	 * Return the durable Gallery reference when creation succeeded before a
	 * later listener, counter or album synchronization step failed.
	 */
	public function get_import_result(): ?image_import_result
	{
		return $this->import_result;
	}
}
