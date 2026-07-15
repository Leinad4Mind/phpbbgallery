<?php
/**
*
* BBmembership extension for the phpBB Forum Software package.
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbmembership\migrations\v10x;

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
		return array('\phpbb\db\migration\data\v31x\v315');
		//return array('\sitesplat\BBCore\migrations\v32x\m1_initial_file');
	}

	/**
	 * Add the donations_transactions table schema to the database:
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'bbmembership'	=> array(
					'COLUMNS'			=> array(
						'id'					=> array('UINT', NULL, 'auto_increment'),
						'item_number'			=> array('VCHAR:25', ''),
						'item_name'				=> array('VCHAR:50', ''),
						'txn_id'				=> array('VCHAR:20', ''),
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
						'payment_date'			=> array('INT:11', 0)
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'	=> array(
						'user_id'		=> array('INDEX', 'user_id'),
						'payer_email'	=> array('INDEX', 'payer_email'),
					)
				),
			),
		);
	}

	/**
	 * Drop the subscribers table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'bbmembership',
			),
		);
	}
}
