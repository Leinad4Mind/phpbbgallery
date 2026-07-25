<?php
/**
*
* @package phpBB Extension - Basic Stats
* @copyright (c) 2025 Stoker
* @copyright (c) 2015 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

declare(strict_types=1);

namespace stoker\basicstats\migrations;

class stoker_basicstats_migrations extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}
	
	public function update_data()
	{
		return [
			['permission.add', ['u_basicstats_view']],
			['permission.permission_set', ['ADMINISTRATORS', 'u_basicstats_view', 'group']],
		];
	}

	public function revert_data()
	{
		return [
			['permission.remove', ['u_basicstats_view']],
		];
	}
}