<?php
/**
*
* @package BBdonations
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\donations\migrations\v31x;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	/**
	 * Add the like table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'donations'	=> array(
					'COLUMNS'	=> array(
						'id'					=> array('UINT', NULL, 'auto_increment'),
						'item_number'			=> array('VCHAR:25', ''),
						'item_name'				=> array('VCHAR:50', ''),
						'txn_id'				=> array('VCHAR:50', ''),
						'mc_gross'				=> array('DECIMAL:7', 0),
						'mc_currency'			=> array('VCHAR:50', ''),
						'payment_status'		=> array('VCHAR:25', ''),
						'user_id'				=> array('INT:11', 0),
						'payer_email'			=> array('VCHAR:50', ''),
						'custom'				=> array('VCHAR:50', ''),
						'sender'				=> array('VCHAR:100', ''),
						'address'				=> array('VCHAR:100', ''),
						'address_country_code'	=> array('VCHAR:5', ''),
						'session_ip'			=> array('VCHAR:40', ''),
						'payment_date'			=> array('INT:11', 0),
						'payment_type'			=> array('INT:1', 0)
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'	=> array(
						'user_id'		=> array('INDEX', 'user_id'),
						'payer_email'	=> array('INDEX', 'payer_email'),
					)
				),
				$this->table_prefix . 'countries'	=> array(
					'COLUMNS'	=> array(
						'id'				=> array('UINT', NULL, 'auto_increment'),
						'code'				=> array('VCHAR:3', ''),
						'flag'				=> array('VCHAR:255', ''),
						'country'			=> array('VCHAR:255', ''),
						'country_code'		=> array('VCHAR:50', NULL, '')
					),
					'PRIMARY_KEY'	=> 'id',
				),
			)
		);
	}

	/**
	 * Drop the like table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'donations',
				$this->table_prefix . 'countries',
			),
		);
	}
}
