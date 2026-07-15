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
	}

	/**
	 * Add tables to the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'flatboots_style_menu'	=> array(
					'COLUMNS'			     => array(
						'button_id'              => array('UINT', NULL, 'auto_increment'),
						'button_url'             => array('TEXT', ''),
						'button_name'            => array('VCHAR', ''),
						'button_desc'            => array('VCHAR', ''),
						'button_external'        => array('BOOL', '0'),
						'button_display'         => array('BOOL', '1'),
						'button_only_registered' => array('BOOL', '0'),
						'button_only_guest'		 => array('BOOL', '0'),
						'left_id' 				 => array('UINT', '0'),
						'right_id' 				 => array('UINT', '0'),
						'parent_id' 			 => array('UINT', '0'),
						'icon' 					 => array('VCHAR', ''),
					),
					'PRIMARY_KEY' => array('button_id'),
				),
				$this->table_prefix . 'flatboots_style_config'	=> array(
					'COLUMNS'			    => array(
						'config_name'		    => array('VCHAR', ''),
						'config_value'		    => array('TEXT', ''),
					),
				),
				$this->table_prefix . 'flatboots_style_links'	=> array(
					'COLUMNS'			     => array(
						'button_id'              => array('UINT', NULL, 'auto_increment'),
						'button_url'             => array('TEXT', ''),
						'button_name'            => array('VCHAR', ''),
						'button_external'        => array('BOOL', '0'),
						'button_display'         => array('BOOL', '1'),
						'button_only_registered' => array('BOOL', '0'),
						'button_only_guest'		 => array('BOOL', '0'),
						'left_id' 				 => array('UINT', '0'),
						'right_id' 				 => array('UINT', '0'),
						'icon'            		 => array('VCHAR', ''),
					),
					'PRIMARY_KEY'                => array('button_id'),
				),
				$this->table_prefix . 'flatboots_style_social'	=> array(
					'COLUMNS'			=> array(
						'button_id'              => array('UINT', NULL, 'auto_increment'),
						'button_url'             => array('TEXT', ''),
						'button_name'            => array('VCHAR', ''),
						'button_display'         => array('BOOL', '1'),
						'button_only_registered' => array('BOOL', '0'),
						'button_only_guest'		 => array('BOOL', '0'),
						'left_id' 				 => array('UINT', '0'),
						'right_id' 				 => array('UINT', '0'),
						'icon' 					 => array('VCHAR', ''),
					),
					'PRIMARY_KEY'                => array('button_id'),
				),
			),
		);
	}

	/**
	 * Drop the tables schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'flatboots_style_menu',
				$this->table_prefix . 'flatboots_style_config',
				$this->table_prefix . 'flatboots_style_links',
				$this->table_prefix . 'flatboots_style_social',
			),
		);
	}
}
