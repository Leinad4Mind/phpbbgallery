<?php
/**
 * phpBB Gallery - Remote Storage Add-on
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\azure;

use phpbbgallery\remotestorage\http\client_interface;

/** Build an Azure Blob provider from process-level settings. */
final class factory
{
	/** @param array<string, string> $environment */
	public function __construct(private client_interface $client, private array $environment)
	{
	}

	public function create(): provider
	{
		$account = $this->value('PHPBBGALLERY_AZURE_ACCOUNT');

		return new provider(
			new configuration(
				$this->value('PHPBBGALLERY_AZURE_ENDPOINT', 'https://' . $account . '.blob.core.windows.net'),
				$account,
				$this->value('PHPBBGALLERY_AZURE_CONTAINER'),
				$this->value('PHPBBGALLERY_AZURE_PREFIX', 'phpbbgallery')
			),
			new signer($account, $this->value('PHPBBGALLERY_AZURE_ACCOUNT_KEY')),
			$this->client
		);
	}

	private function value(string $name, string $default = ''): string
	{
		return trim((string) ($this->environment[$name] ?? $default));
	}
}
