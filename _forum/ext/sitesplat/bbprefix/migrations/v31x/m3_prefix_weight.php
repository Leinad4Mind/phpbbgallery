<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

class m3_prefix_weight extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\sitesplat\bbprefix\migrations\v31x\m2_initial_schema',
			'\sitesplat\bbprefix\migrations\v31x\m2_initial_data',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'bbprefix' => [
					'weight' => ['UINT', 0],
				],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'bbprefix' => ['weight'],
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return [
			['custom', [[$this, 'backfill_weight']]],
		];
	}

	/**
	 * Give every existing prefix a weight matching its current id order, so
	 * the new ORDER BY does not shuffle anything until an admin drags a row.
	 */
	public function backfill_weight()
	{
		$weight = 1;
		$sql = 'SELECT id FROM ' . $this->table_prefix . 'bbprefix ORDER BY id ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->db->sql_query('UPDATE ' . $this->table_prefix . 'bbprefix SET weight = ' . $weight . ' WHERE id = ' . (int) $row['id']);
			$weight++;
		}
		$this->db->sql_freeresult($result);
	}
}
