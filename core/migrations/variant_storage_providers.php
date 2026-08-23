<?php
/**
 * phpBB Gallery - per-variant storage provider routing.
 *
 * @package   phpbbgallery/core
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\migrations;

use phpbb\db\migration\migration;

/** Preserve the existing provider while allowing source, medium and mini to diverge. */
class variant_storage_providers extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\storage_provider'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_storage_provider_source', 'local']],
			['config.add', ['phpbb_gallery_storage_provider_medium', 'local']],
			['config.add', ['phpbb_gallery_storage_provider_mini', 'local']],
			['custom', [[$this, 'inherit_active_provider']]],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_storage_provider_mini']],
			['config.remove', ['phpbb_gallery_storage_provider_medium']],
			['config.remove', ['phpbb_gallery_storage_provider_source']],
		];
	}

	/** Copy the former global assignment so upgrades never lose remote objects. */
	public function inherit_active_provider(): bool
	{
		$provider = strtolower(trim((string) ($this->config['phpbb_gallery_storage_provider'] ?? 'local')));
		if (preg_match('/^[a-z][a-z0-9_.-]{0,63}$/D', $provider) !== 1)
		{
			$provider = 'local';
		}
		foreach (['source', 'medium', 'mini'] as $variant)
		{
			$this->config->set('phpbb_gallery_storage_provider_' . $variant, $provider);
		}

		return true;
	}
}
