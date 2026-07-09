<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\tfa\migrations\v31x;

class m1_initial_schema extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'tfa_registration'	=> array(
					'COLUMNS'	=> array(
						'registration_id'		=> array('UINT', null, 'auto_increment'),
						'user_id'				=> array('UINT', 0),
						'secret'				=> array('VCHAR:255', ''),
						'last_used'				=> array('TIMESTAMP', 0),
						'registered'			=> array('TIMESTAMP', 0),
						'ip_address'			=> array('VCHAR:40', ''),
					),
					'PRIMARY_KEY'	=> 'registration_id',
					'KEYS'			=> array(
						'user_id'		=> array('INDEX', array('user_id')),
					),
				),
			),
			'add_columns'        => array(
				$this->table_prefix . 'sessions'        => array(
					'tfa_random'    => array('TEXT', null),
					'tfa_uid'		=> array('UINT', 0),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'tfa_registration',
			),
			'drop_columns'       => array(
				$this->table_prefix . 'sessions'	=> array(
					'tfa_random', 'tfa_uid'
				),
			),
		);
	}
}
