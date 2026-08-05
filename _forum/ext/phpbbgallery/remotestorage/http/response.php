<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\http;

/** Immutable HTTP response boundary used by remote providers. */
final class response
{
	private int $status;
	/** @var array<string, list<string>> */
	private array $headers;
	/** @var resource|null */
	private mixed $body;

	/**
	 * @param array<string, string|list<string>> $headers
	 * @param resource|null $body
	 */
	public function __construct(int $status, array $headers = [], mixed $body = null)
	{
		if ($status < 100 || $status > 599 || ($body !== null && !is_resource($body)))
		{
			throw new \InvalidArgumentException('The remote storage HTTP response is invalid.');
		}
		$this->status = $status;
		$this->headers = [];
		foreach ($headers as $name => $values)
		{
			$name = strtolower(trim((string) $name));
			if ($name === '' || preg_match('/^[a-z0-9-]+$/D', $name) !== 1)
			{
				throw new \InvalidArgumentException('A remote storage response header is invalid.');
			}
			$this->headers[$name] = array_map('strval', is_array($values) ? $values : [$values]);
		}
		$this->body = $body;
	}

	public function status(): int
	{
		return $this->status;
	}

	public function header(string $name): ?string
	{
		$values = $this->headers[strtolower($name)] ?? [];

		return $values === [] ? null : implode(',', $values);
	}

	/** Detach the body stream; the caller becomes responsible for closing it. */
	public function detach_body(): mixed
	{
		$body = $this->body;
		$this->body = null;

		return $body;
	}

	public function __destruct()
	{
		if (is_resource($this->body))
		{
			fclose($this->body);
		}
	}
}
