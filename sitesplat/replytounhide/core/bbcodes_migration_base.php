<?php
/**
 *
 * @package ReplyToUnhide
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide\core;

use \phpbb\db\migration\container_aware_migration;

/**
 * Class wrapper for installing/updating bbcodes in migrations.
 * This class must be kept outside of the migrations directory
 * since this is not a migration file. It's just a wrapper that
 * can be extended by multiple migration files.
 */
abstract class bbcodes_migration_base extends container_aware_migration
{
	/**
	 * @var array An array of bbcodes data to install
	 */
	protected static $bbcode_data;

	/**
	 * Wrapper for installing bbcodes in migrations
	 */
	public function install_replytounhide_bbcodes()
	{
		$request = $this->container->get('request');
		$user = $this->container->get('user');

		$bbcodes_installer = new \sitesplat\replytounhide\core\bbcodes_installer($this->db, $request, $user, $this->phpbb_root_path, $this->php_ext);
		$bbcodes_installer->install_bbcodes(static::$bbcode_data);
	}
}
