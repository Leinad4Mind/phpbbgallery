<?php
/**
*
* BBOOTS Mini CMS extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
* @license SiteSplat 2015 all rights reserved
*
*/

namespace sitesplat\bbootsminicms\migrations\v10x;

/**
* Migration stage 2: Initial module
*/
class m3_initial_data extends \phpbb\db\migration\migration
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
		return array('\sitesplat\bbootsminicms\migrations\v10x\m2_initial_modules');
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
			array('custom', array(array($this, 'insert_sample_config_data'))),
			array('custom', array(array($this, 'insert_sample_link_data'))),
			array('custom', array(array($this, 'insert_sample_social_data'))),
		);
	}

	/**
	 * Custom function to install sample rule data
	 *
	 * @return null
	 * @access public
	 */
	public function insert_sample_menu_data()
	{
		$sample_menu_data = array(
			array(
				'button_id'  			  => '1',
				'button_url'  			  => '{U_SEARCH}',
				'button_name'  			  => '{L_SEARCH}',
				'button_desc' 			  => 'Search it up',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '1',
				'right_id'  			  => '10',
				'parent_id'  			  => '0',
				'icon'  				  => 'fa fa-search',
			),
			array(
				'button_id'  			  => '2',
				'button_url'  			  => '{U_SEARCH}',
				'button_name'  			  => '{L_SEARCH_ADV}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '2',
				'right_id'  			  => '3',
				'parent_id'  			  => '1',
				'icon'  				  => 'fa fa-search',
			),
			array(
				'button_id'  			  => '3',
				'button_url'  			  => '{U_SEARCH_SELF}',
				'button_name'  			  => '{L_SEARCH_SELF}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '4',
				'right_id'  			  => '5',
				'parent_id'  			  => '1',
				'icon'  				  => 'fa fa-sort-numeric-asc',
			),
			array(
				'button_id'  			  => '4',
				'button_url'  			  => '{SITESPLAT_SEARCH_LAST_DAY}',
				'button_name'  			  => '{L_SITESPLAT_SEARCH_LAST_DAY}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '6',
				'right_id'  			  => '7',
				'parent_id'  			  => '1',
				'icon'  				  => 'fa fa-comments',
			),
			array(
				'button_id'  			  => '5',
				'button_url'  			  => '{SITESPLAT_SEARCH_WEEK}',
				'button_name'  			  => '{L_SITESPLAT_SEARCH_WEEK}',
				'button_desc' 			  => '',
				'button_external' 		  => '0',
				'button_display'          => '1',
				'button_only_registered'  => '1',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '8',
				'right_id'  			  => '9',
				'parent_id'  			  => '1',
				'icon'  				  => 'fa fa-sort-alpha-asc',
			),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'bboots_style_menu', $sample_menu_data);
	}

	/**
	 * Custom function to install sample config data
	 *
	 * @return null
	 * @access public
	 */
	public function insert_sample_config_data()
	{
		$sample_config_data = array(
			array('config_name'  => 'about_us_title', 'config_value'  => 'About us'),
			array('config_name'  => 'about_us', 'config_value'  => '<p>BBOOTS&trade; Is The First And Only Fully Responsive PhpBB&reg; Unofficial HTML5/CSS3 Theme. It’s Clean And Crisp Design Looks AWESOME Across All Browsers And Devices.</p><p>It Utilizes A Bootstrap Based Layout Which Has Been Long Waited For And That Is Sure To AMAZE The phpBB Fan Club.</p><blockquote><p><span>B</span>BOOTS</p><small><cite title="Source Title">The Unofficial Responsive Theme <i class="fa fa-map-marker"></i></cite></small></blockquote>'),
			array('config_name'  => 'google_analytics', 'config_value'  => ''),
			array('config_name'  => 'twitter_id', 'config_value'  => '391407906655965184'),
			array('config_name'  => 'adsense_header', 'config_value'  => ''),
			array('config_name'  => 'adsense_footer', 'config_value'  => ''),
			array('config_name'  => 'adsense_topic', 'config_value'  => ''),
			array('config_name'  => 'logo_text', 'config_value'  => 'BBOOTS'),
			array('config_name'  => 'hide_header', 'config_value'  => '0'),
			array('config_name'  => 'hide_footer', 'config_value'  => '0'),
			array('config_name'  => 'enable_popup_login', 'config_value'  => '0'),
			array('config_name'  => 'mini_profile_position', 'config_value'  => 'right'),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'bboots_style_config', $sample_config_data);
	}

	/**
	 * Custom function to install sample link data
	 *
	 * @return null
	 * @access public
	 */
	public function insert_sample_link_data()
	{
		$sample_link_data = array(
			array(
				'button_id' 			  => '1',
				'button_url' 			  => '#',
				'button_name'  			  => 'Advertise',
				'button_external'  		  => '0',
				'button_display'  		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id' 				  => '1',
				'right_id'  			  => '2',
				'icon'      			  => 'fa fa-group',
			),
			array(
				'button_id' 			  => '2',
				'button_url'  			  => '{U_PRIVACY}',
				'button_name'  			  => 'Privacy',
				'button_external'  		  => '0',
				'button_display' 		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest' 	  => '0',
				'left_id' 				  => '3',
				'right_id' 				  => '4',
				'icon'      			  => 'fa fa-bug',
			),
			array(
				'button_id'  			  => '3',
				'button_url' 			  => '#',
				'button_name'  			  => 'DMCA',
				'button_external'         => '0',
				'button_display'  		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'       => '0',
				'left_id' 				  => '5',
				'right_id' 				  => '6',
				'icon'      			  => 'fa fa-comments',
			),
			array(
				'button_id'  			  => '4',
				'button_url' 			  => '{U_TERMS_USE}',
				'button_name'  			  => 'Terms',
				'button_external' 		  => '0',
				'button_display' 		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id'  				  => '7',
				'right_id'  			  => '8',
				'icon'     				  => 'fa fa-star',
			),
			array(
				'button_id'  			  => '5',
				'button_url' 			  => '{U_CONTACT_US}',
				'button_name'  			  => 'Contact',
				'button_external'  		  => '0',
				'button_display'  		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id'                 => '9',
				'right_id'  			  => '10',
				'icon'      			  => 'fa fa-edit',
			),
			array(
				'button_id'  			  => '6',
				'button_url' 			  => '{U_DELETE_COOKIES}',
				'button_name'  			  => 'Delete Cookie',
				'button_external'  		  => '0',
				'button_display'  		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id'                 => '11',
				'right_id'  			  => '12',
				'icon'      			  => 'fa fa-trash-o',
			),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'bboots_style_links', $sample_link_data);
	}

	/**
	 * Custom function to install sample social data
	 *
	 * @return null
	 * @access public
	 */
	public function insert_sample_social_data()
	{
		$sample_social_data = array(
			array(
				'button_id'  			  => '1',
				'button_url'  			  => '#1',
				'button_name' 			  => 'Google+',
				'button_display'          => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id' 				  => '1',
				'right_id' 				  => '2',
				'icon'  				  => 'fa fa-google-plus-square google-plus-color',
			),
			array(
				'button_id'  			  => '2',
				'button_url'  			  => '#2',
				'button_name' 			  => 'Github',
				'button_display' 		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id' 				  => '3',
				'right_id'  			  => '4',
				'icon'  				  => 'fa fa-github-square github-color',
			),
			array(
				'button_id'  			  => '3',
				'button_url'  			  => '#4',
				'button_name' 			  => 'Pinterest',
				'button_display' 		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id' 				  => '5',
				'right_id'  			  => '6',
				'icon'  				  => 'fa fa-pinterest-square pinterest-color',
			),
			array(
				'button_id'  			  => '4',
				'button_url' 			  => '#5',
				'button_name' 			  => 'Facebook',
				'button_display' 		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest' 	  => '0',
				'left_id'  			      => '7',
				'right_id' 				  => '8',
				'icon'  				  => 'fa fa-facebook-square facebook-color',
			),
			array(
				'button_id' 			  => '5',
				'button_url'  			  => '#6',
				'button_name'  			  => 'Twitter',
				'button_display'  		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id'  			      => '9',
				'right_id'  			  => '10',
				'icon'  				  => 'fa fa-twitter-square twitter-color',
			),
			array(
				'button_id' 			  => '6',
				'button_url'  			  => '#7',
				'button_name'  			  => 'Bitbucket',
				'button_display'  		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id'  			      => '11',
				'right_id'  			  => '12',
				'icon'  				  => 'fa fa-bitbucket-square facebook-color',
			),
			array(
				'button_id' 			  => '7',
				'button_url' 			  => '{U_FEED}',
				'button_name'  			  => 'rss',
				'button_display' 		  => '1',
				'button_only_registered'  => '0',
				'button_only_guest'  	  => '0',
				'left_id' 				  => '13',
				'right_id' 				  => '14',
				'icon' 					  => 'fa fa-rss-square rss-color',
			),
		);

		$this->db->sql_multi_insert($this->table_prefix . 'bboots_style_social', $sample_social_data);
	}
}
