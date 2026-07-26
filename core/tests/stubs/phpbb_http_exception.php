<?php
/**
 * Minimal phpBB HTTP exception stub for isolated Gallery tests.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\exception;

class http_exception extends \RuntimeException
{
	private int $status_code;

	public function __construct(int $status_code, string $message = '')
	{
		$this->status_code = $status_code;
		parent::__construct($message);
	}

	// phpcs:ignore -- Mirrors Symfony's HttpExceptionInterface method name.
	public function getStatusCode(): int
	{
		return $this->status_code;
	}
}
