<?php
/**
 *
 * Topic Index Bridge. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kasimi\topicindexbridge;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$extension_manager = $this->container->get('ext.manager');
		if (!$extension_manager->is_enabled('dmzx/topicindex'))
		{
			return false;
		}

		try
		{
			$metadata = $extension_manager->create_extension_metadata_manager('dmzx/topicindex')->get_metadata();

			return version_compare($metadata['version'], '2.0.0', '>=');
		}
		catch (\Throwable $exception)
		{
			return false;
		}
	}
}
