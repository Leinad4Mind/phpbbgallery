<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\http;

interface client_interface
{
	/**
	 * @param array<string, string> $headers
	 * @param resource|null $body
	 */
	public function request(string $method, string $url, array $headers = [], mixed $body = null): response;
}
