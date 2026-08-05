<?php
/**
 * phpBB Gallery - Azure Blob Storage settings.
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\remotestorage\migrations;

use phpbb\db\migration\migration;

final class m3_azure_blob extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\remotestorage\migrations\m2_provider_migration'];
	}

	public function update_data(): array
	{
		return [
			['config.add', ['phpbb_gallery_azure_endpoint', '']],
			['config.add', ['phpbb_gallery_azure_account', '']],
			['config.add', ['phpbb_gallery_azure_container', '']],
			['config.add', ['phpbb_gallery_azure_account_key', '']],
			['config.add', ['phpbb_gallery_azure_prefix', 'phpbbgallery']],
		];
	}

	public function revert_data(): array
	{
		return [
			['config.remove', ['phpbb_gallery_azure_endpoint']],
			['config.remove', ['phpbb_gallery_azure_account']],
			['config.remove', ['phpbb_gallery_azure_container']],
			['config.remove', ['phpbb_gallery_azure_account_key']],
			['config.remove', ['phpbb_gallery_azure_prefix']],
		];
	}
}
