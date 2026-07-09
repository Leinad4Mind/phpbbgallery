<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\migrations\v32x;

class m1_initial_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbfront\migrations\v31x\m3_initial_config');
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'update_config'))),
		);
	}

	/**
	 * Add setting to the database
	 *
	 * @return null
	 * @access public
	 */
	public function update_config()
	{
		$bbfront_settings = json_decode($this->config['bbfront_settings'], true);
		$bbfront_settings += array('per_page' => 5);
		$this->config->set('bbfront_settings', json_encode($bbfront_settings));
	}
}
