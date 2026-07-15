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
* Migration stage 7: Add menu links
*/
class m7_add_sample_menu_data extends \phpbb\db\migration\migration
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
		return array('\sitesplat\flatbootsminicms\migrations\v10x\m6_add_teaser_config');
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
			array('custom', array(array($this, 'insert_sample_menu_data'))),
		);
	}

	/**
	 * Custom function to add new menu links
	 *
	 * @return null
	 * @access public
	 */
	public function insert_sample_menu_data()
	{
		$sample_menu_data = array(
			array(
				'button_id'  			  => '6',
				'button_url'  			  => '',
				'button_name'  			  => '{L_MAIN_FORUM}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '3',
				'right_id'  			  => '20',
				'parent_id'  			  => '0',
				'icon'  				  => '',
			),
			array(
				'button_id'  			  => '7',
				'button_url'  			  => '{U_SEARCH_UNANSWERED}',
				'button_name'  			  => '{L_SEARCH_UNANSWERED}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '4',
				'right_id'  			  => '5',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-search',
			),
			array(
				'button_id'  			  => '8',
				'button_url'  			  => '{U_SEARCH_UNREAD}',
				'button_name'  			  => '{L_SEARCH_UNREAD}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '6',
				'right_id'  			  => '7',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-comment',
			),
			array(
				'button_id'  			  => '9',
				'button_url'  			  => '{U_SEARCH_NEW}',
				'button_name'  			  => '{L_SEARCH_NEW}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '8',
				'right_id'  			  => '9',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-thumbs-up',
			),
			array(
				'button_id'  			  => '10',
				'button_url'  			  => '{U_SEARCH_ACTIVE_TOPICS}',
				'button_name'  			  => '{L_SEARCH_ACTIVE_TOPICS}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '10',
				'right_id'  			  => '11',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-star',
			),
	// Mark Forum read below needs to be fixed - debug 
	// [phpBB Debug] PHP Notice: in file [ROOT]/ext/sitesplat/flatbootsminicms/event/listener.php on line 161: Undefined index: U_MARK_FORUMS
	//		array(
	//			'button_id'  			  => '15',
	//			'button_url'  			  => '{U_MARK_FORUMS}',
	//			'button_name'  			  => '{L_MARK_FORUMS_READ}',
	//			'button_desc' 			  => '',
	//			'button_external' 		  => '0',
	//			'button_display'          => '1',
	//			'button_only_registered'  => '1',
	//			'button_only_guest'  	  => '0',
	//			'left_id'  				  => '18',
	//			'right_id'  			  => '19',
	//			'parent_id'  			  => '6',
	//			'icon'  				  => 'fa fa-check',
	//		),
			array(
				'button_id'  			  => '11',
				'button_url'  			  => '{U_FAQ}',
				'button_name'  			  => '{L_FAQ}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '12',
				'right_id'  			  => '13',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-question-circle',
			),
			array(
				'button_id'  			  => '12',
				'button_url'  			  => '{U_MEMBERLIST}',
				'button_name'  			  => '{L_MEMBERLIST}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '14',
				'right_id'  			  => '15',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-group',
			),
			array(
				'button_id'  			  => '13',
				'button_url'  			  => '{U_TEAM}',
				'button_name'  			  => '{L_THE_TEAM}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '16',
				'right_id'  			  => '17',
				'parent_id'  			  => '6',
				'icon'  				  => 'fa fa-trophy',
			),
			array(
				'button_id'  			  => '14',
				'button_url'  			  => '{U_INDEX}',
				'button_name'  			  => '{L_HOME}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '1',
				'right_id'  			  => '2',
				'parent_id'  			  => '0',
				'icon'  				  => '',
			),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'flatboots_style_menu', $sample_menu_data);
	}
}
