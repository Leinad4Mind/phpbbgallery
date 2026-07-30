<?php
/**
 * BBPoints cache test double.
 *
 * @package sitesplat/bbpoints
 * @copyright (c) 2015-2026 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace sitesplat\bbpoints\tests;

final class fake_cache implements \phpbb\cache\driver\driver_interface
{
	public array $destroyed = [];

	public function destroy($var_name, $table = ''): void
	{
		$this->destroyed[] = [$var_name, $table];
	}
}
