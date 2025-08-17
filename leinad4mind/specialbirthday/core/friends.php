<?php
/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace leinad4mind\specialbirthday\core;

use phpbb\db\driver\driver_interface;

class friends
{
	/** @var driver_interface */
	protected $db;

	/** @var array */
	protected $friends = [];

	/**
	* @param driver_interface $db
	*/
	public function __construct(
		driver_interface $db
	)
	{
		$this->db = $db;
	}

	/**
	 * @param int $user_id
	 * @param int $zebra_id
	 * @return mixed
	 */
	public function is_friend($user_id, $zebra_id)
	{
		if (!isset($this->friends[$user_id][$zebra_id]))
		{
			$sql_array = [
				'SELECT'	=> 'z.friend',
				'FROM'		=> [ZEBRA_TABLE => 'z'],
				'WHERE'		=> implode(' AND ', [
					'z.user_id = ' . (int) $user_id,
					'z.zebra_id = ' . (int) $zebra_id,
					'z.friend = 1',
				]),
			];

			$sql = $this->db->sql_build_query('SELECT', $sql_array);
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			$this->friends[$user_id][$zebra_id] = !empty($row['friend']);
		}

		return $this->friends[$user_id][$zebra_id];
	}
}
