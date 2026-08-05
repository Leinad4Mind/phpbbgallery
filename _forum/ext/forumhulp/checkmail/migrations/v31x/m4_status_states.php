<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\checkmail\migrations\v31x;

/**
* Migration stage 4: status becomes a three-state code, email holds the raw address
*
* The email column used to store a pre-composed, already-translated sentence, which
* both overflowed its VCHAR:100 width on longer addresses and froze the wording to
* whatever language was active at check time. It now holds the raw email address and
* status distinguishes "exists" (1) from "valid but doesn't exist" (2), which used to
* collapse into the same boolean value. Existing rows are cleared since this is only a
* verification cache that the cron task repopulates on its own.
*/
class m4_status_states extends \phpbb\db\migration\migration
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
		return array('\forumhulp\checkmail\migrations\v31x\m3_initial_config');
	}

	/**
	 * @inheritdoc
	 */
	public function update_schema()
	{
		return [
			'change_columns'	=> [
				$this->table_prefix . 'checkmail'	=> [
					'status'	=> ['TINT:1', 0],
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
			'change_columns'	=> [
				$this->table_prefix . 'checkmail'	=> [
					'status'	=> ['BOOL', 1],
				],
			],
		];
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'clear_checkmail_cache'))),
		);
	}

	/**
	 * Empty the verification cache; the cron task repopulates it on its own
	 *
	 * @return void
	 * @access public
	 */
	public function clear_checkmail_cache()
	{
		$this->db->sql_query('DELETE FROM ' . $this->table_prefix . 'checkmail');
	}
}
