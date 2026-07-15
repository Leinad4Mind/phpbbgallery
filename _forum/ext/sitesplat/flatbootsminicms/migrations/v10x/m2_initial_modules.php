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
* Migration stage 2: Initial module
*/
class m2_initial_modules extends \phpbb\db\migration\migration
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
		return array('\sitesplat\flatbootsminicms\migrations\v10x\m1_initial_schema');
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
			array('module.add', array(
				'acp', 'ACP_CAT_DOT_MODS', 'FLATBOOTS_STYLE_TITLE'
			)),
			array('module.add', array(
				'acp', 'FLATBOOTS_STYLE_TITLE', array(
					'module_basename'	=> '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
					'modes'				=> array('config'),
				),
			)),
			array('module.add', array(
				'acp', 'FLATBOOTS_STYLE_TITLE', array(
					'module_basename'	=> '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
					'modes'				=> array('menu'),
				),
			)),
			array('module.add', array(
				'acp', 'FLATBOOTS_STYLE_TITLE', array(
					'module_basename'	=> '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
					'modes'				=> array('links'),
				),
			)),
			array('module.add', array(
				'acp', 'FLATBOOTS_STYLE_TITLE', array(
					'module_basename'	=> '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
					'modes'				=> array('social'),
				),
			)),
			array('module.add', array(
				'acp', 'FLATBOOTS_STYLE_TITLE', array(
					'module_basename'	=> '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
					'modes'				=> array('upload'),
				),
			)),
			array('module.add', array(
				'acp', 'FLATBOOTS_STYLE_TITLE', array(
					'module_basename'	=> '\sitesplat\flatbootsminicms\acp\flatboots_style_module',
					'modes'				=> array('css'),
				),
			)),
		);
	}
}
