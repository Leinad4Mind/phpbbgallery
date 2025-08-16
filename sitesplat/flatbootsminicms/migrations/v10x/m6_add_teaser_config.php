<?php
/**
*
* FLATBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\flatbootsminicms\migrations\v10x;

/**
* Migration stage 6: Add teaser config
*/
class m6_add_teaser_config extends \phpbb\db\migration\migration
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
		return array('\sitesplat\flatbootsminicms\migrations\v10x\m5_add_twitter_screen_name_config');
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
			array('custom', array(array($this, 'insert_teaser_config'))),
		);
	}

	/**
	 * Custom function to add new config data
	 *
	 * @return null
	 * @access public
	 */
	public function insert_teaser_config()
	{
		$sample_config_data = array(
			array('config_name'  => 'teaser_title', 'config_value'  => ''),
			array('config_name'  => 'teaser_text', 'config_value'  => ''),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'flatboots_style_config', $sample_config_data);
	}
}
