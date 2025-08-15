<?php
/**
*
* Badge Award extension for the phpBB Forum Software package.
*
* @copyright (c) 2019 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\badge\migrations\v20x;

class m2_fix_indexes extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\badge\migrations\v20x\m1_config_data');
	}

	public function update_schema()
	{
		return array(
			'add_index' => array(
				$this->table_prefix . 'badge_events' => array(
					'uid' => array('INDEX', 'user_id'),
					'rid' => array('INDEX', 'rule_id'),
					'didx' => array('INDEX', 'date'),
				),
				$this->table_prefix . 'badge_rules' => array(
					'rtid' => array('INDEX', 'rule_type_id'),
					'bid' => array('INDEX', 'badge_id'),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_keys' => array(
				$this->table_prefix . 'badge_events' => array(
					'uid',
					'rid',
					'didx',
				),
				$this->table_prefix . 'badge_rules' => array(
					'rtid',
					'bid',
				),
			),
		);
	}
}
