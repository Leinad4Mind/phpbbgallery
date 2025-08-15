<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

/**
 * Initial schema changes needed for Extension installation
 */
class m2_initial_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbprefix\migrations\v31x\m1_initial_schema');
	}

	/**
	 * @inheritdoc
	 */
	public function update_data() 
 	{ 
 		return array( 
 			array('custom', array(array($this, 'update_table_data'))), 
 		); 
 	} 

	/**
	 * @inheritdoc
	 */
	public function update_table_data()
	{
		$sql = 'ALTER TABLE ' . $this->table_prefix . 'bbprefix MODIFY forums VARCHAR(500)'; 
		$this->db->sql_query($sql); 
	}
}
