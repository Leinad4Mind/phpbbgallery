<?php
/**
*
* BBopengraph
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\opengraph\migrations\v31x;

/**
* Migration stage 1: Initial config
*/
class m1_initial_config extends \phpbb\db\migration\migration
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
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('opengraph_fb_id', '')),
			array('config.add', array('opengraph_fb_app_id', '')),
			array('config.add', array('opengraph_tw_id', '')),
			array('config.add', array('opengraph_imagepath', 'ext/sitesplat/opengraph/styles/images/bbopengraph_image.png')),
		);
	}
}
