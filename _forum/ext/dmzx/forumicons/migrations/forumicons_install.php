<?php
/**
 *
 * @package phpBB Extension - Forum Icons
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/license/gpl-2-0 GNU General Public License v2
 *
 */

namespace dmzx\forumicons\migrations;

class forumicons_install extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v31x\v311',
		];
	}

	public function update_data()
	{
		return [
			['custom', [[$this, 'create_icon_directory']]],
		];
	}

	/**
	 * Create the directory used for forum icons.
	 *
	 * @throws \RuntimeException When the directory cannot be created
	 */
	public function create_icon_directory()
	{
		$directory = $this->phpbb_root_path . 'images/forumicons';

		if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory))
		{
			throw new \RuntimeException('Unable to create the forum icon directory: ' . $directory);
		}

		if (!is_readable($directory))
		{
			throw new \RuntimeException('The forum icon directory is not readable: ' . $directory);
		}
	}
}
