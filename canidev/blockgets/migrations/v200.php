<?php
/*
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

namespace canidev\blockgets\migrations;

use canidev\blockgets\libraries\constants;

class v200 extends \phpbb\db\migration\migration
{
	protected $language;
	
	public function effectively_installed()
	{
		return isset($this->config['blg_version']) && version_compare($this->config['blg_version'], '2.0.0', '>=');
	}

	public function update_schema()
	{
		$this->prepare();

		return array(
			'add_tables' => array(
				$this->table_prefix . 'blockgets_blocks' => array(
					'COLUMNS' => array(
						'block_id'			=> array('UINT:3', NULL, 'auto_increment'),
						'parent_id'			=> array('UINT:3', 0),
						'block_title'		=> array('VCHAR', ''),
						'block_content'		=> array('TEXT', ''),
						'block_alias'		=> array('VCHAR', ''),
						'block_icon'		=> array('VCHAR:100', ''),
						'block_order'		=> array('UINT:3', NULL),
						'block_position'	=> array('BOOL', NULL),
						'block_page'		=> array('UINT:3', 0),
						'block_enabled' 	=> array('BOOL', 1),
						'block_groups'		=> array('VCHAR:50', 'all'),
						'block_style'		=> array('UINT:2', constants::BLOCK_STYLE_DEFAULT),
						'allow_collapse'	=> array('BOOL', 1),
						'bbcode_bitfield'	=> array('VCHAR', ''),
						'bbcode_uid'		=> array('VCHAR:8', ''),
					),
					'PRIMARY_KEY'	=> 'block_id',
				),

				$this->table_prefix . 'blockgets_data' => array(
					'COLUMNS' => array(
						'data_id'			=> array('UINT:8', NULL, 'auto_increment'),
						'user_id'			=> array('UINT:8', 0),
						'data_type'			=> array('UINT:2', 0),
						'data_title'		=> array('VCHAR', ''),
						'data_content'		=> array('MTEXT', ''),
						'data_time'			=> array('UINT:11', 0),
						'data_settings'		=> array('TEXT', ''),
						'bbcode_bitfield'	=> array('VCHAR', ''),
						'bbcode_uid'		=> array('VCHAR:8', ''),
					),
					'PRIMARY_KEY'	=> 'data_id',
				),

				$this->table_prefix . 'blockgets_pages' => array(
					'COLUMNS' => array(
						'page_id'				=> array('UINT:3', NULL, 'auto_increment'),
						'page_type'				=> array('BOOL', 2),
						'page_alias'			=> array('VCHAR', ''),
						'page_title'			=> array('VCHAR', ''),
						'page_enabled'			=> array('BOOL', 1),
						'page_data'				=> array('TEXT', ''),
						'page_groups'			=> array('VCHAR:50', 'all'),
					),
					'PRIMARY_KEY'	=> 'page_id',
				),
			),
		);
	}

	public function revert_schema()
	{
		$this->prepare();

		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'blockgets_blocks',
				$this->table_prefix . 'blockgets_data',
				$this->table_prefix . 'blockgets_pages',
			),
		);
	}

	public function update_data()
	{
		$this->prepare();

		return array(
			array('config.add', array('blg_on_board', 1)),
			array('config.add', array('blg_home_type', constants::TYPE_FORUM_HOME)),
			array('config.add', array('blg_collapse_blocks', 1)),
			array('config.add', array('blg_block_autofit', 1)),
			array('config.add', array('blg_resize_enabled', 1)),
			array('config.add', array('blg_resize_on_post', 1)),
			array('config.add', array('blg_avatar_max_width', 0)),
			array('config.add', array('blg_image_max_width', 450)),
			array('config.add', array('blg_counter_start_date', time())),
			array('config.add', array('blg_counter_visit_count', 0, 1)),
			array('config.add', array('blg_redirect_login', '')),
			array('config.add', array('blg_redirect_logout', '')),
			array('config.add', array('blg_redirect_404', '')),
			array('config.add', array('blg_rewrite', 0)),
			array('config.add', array('blg_admin_bar', 1)),
			array('config.add', array('blg_calendar_enabled', 1)),
			array('config.add', array('blg_calendar_first_day', 1)),
			array('config.add', array('blg_calendar_link', '')),
			array('config.add', array('blg_asset_check', 0)),
			array('config.add', array('blg_version', '2.0.0')),

			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_BLOCKGETS')),
			
			array('module.add', array(
				'acp',
				'ACP_BLOCKGETS',
				array(
					'module_basename'	=> '\canidev\blockgets\acp\main_module',
					'modes'				=> array('main', 'optional', 'pages'),
				),
			)),

			array('permission.add', array('a_blockgets', true)),
			array('permission.add', array('u_blockgets_calendar', true)),
			array('permission.add', array('u_blockgets_events', true)),

			array('permission.permission_set', array('ADMINISTRATORS', 'a_blockgets', 'group')),
			array('permission.permission_set', array('REGISTERED', 'u_blockgets_calendar', 'group')),
			array('permission.permission_set', array('ADMINISTRATORS', 'u_blockgets_events', 'group')),

			array('custom', array(array($this, 'add_table_data'))),
		);
	}
	
	public function prepare()
	{
		global $phpbb_container;

		if(!$this->language)
		{
			$this->language = $phpbb_container->get('language');
			$this->language->add_lang(array('installer', 'acp', 'info_acp_blockgets'), 'canidev/blockgets');
		}
	}
	
	public function add_table_data()
	{
		$default_page_data = serialize(array(
			'filters'			=> [],
			'header'			=> 1,
			'footer'			=> 1,
			'page_theme'		=> 'default',
			'background'		=> '',
			'stylesheet'		=> '',
			'style'				=> 0,
			'logo'				=> '',
			'left_column_width'	=> '200px',
			'right_column_width'=> '200px',
			'block_space'		=> '6px',
			'link_position'		=> '',
			'link_icon'			=> '',
		));

		$sql_ary = array(
			$this->table_prefix . 'blockgets_pages' => array(
				array(
					'page_type'			=> constants::PAGE_HOME,
					'page_alias'		=> 'home',
					'page_title'		=> $this->language->lang('PORTAL'),
					'page_data'			=> $default_page_data,
					'page_groups'		=> 'all',
				),
				array(
					'page_type'			=> constants::PAGE_FORUM,
					'page_alias'		=> 'index',
					'page_title'		=> '',
					'page_data'			=> $default_page_data,
					'page_groups'		=> 'all',
				),
			),

			$this->table_prefix . 'blockgets_blocks'	=> array(
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'menu_title')),
					'block_content'		=> serialize(array(
						'list'	=> array(
							array(
								'title'			=> $this->language->lang('P_MAIN'),
								'description'	=> '',
								'url'			=> '',
								'image'			=> '',
								'window'		=> 0,
								'groups'		=> 'all',
								'type'			=> constants::LIST_CAT,
							),
							array(
								'title'			=> $this->language->lang('PORTAL'),
								'description'	=> '',
								'url'			=> 'portal',
								'image'			=> 'fa-home',
								'window'		=> 0,
								'groups'		=> 'all',
								'type'			=> constants::LIST_LINK,
							),
							array(
								'title'			=> $this->language->lang('INDEX'),
								'description'	=> '',
								'url'			=> 'index.php',
								'image'			=> 'fa-comments-o',
								'window'		=> 0,
								'groups'		=> 'all',
								'type'			=> constants::LIST_LINK,
							),
							array(
								'title'			=> $this->language->lang('FAQ'),
								'description'	=> '',
								'url'			=> 'faq.php',
								'image'			=> 'fa-question-circle',
								'window'		=> 0,
								'groups'		=> 'all',
								'type'			=> constants::LIST_LINK,
							),
							array(
								'title'			=> $this->language->lang('SEARCH'),
								'description'	=> '',
								'url'			=> 'search.php',
								'image'			=> 'fa-search',
								'window'		=> 0,
								'groups'		=> '2,4,5,7',
								'type'			=> constants::LIST_LINK,
							),
							array(
								'title'			=> $this->language->lang('P_ADMIN'),
								'description'	=> '',
								'url'			=> '',
								'image'			=> '',
								'window'		=> 0,
								'groups'		=> '4,5',
								'type'			=> constants::LIST_CAT,
							),
							array(
								'title'			=> $this->language->lang('P_MCP'),
								'description'	=> '',
								'url'			=> 'mcp.php',
								'image'			=> 'fa-legal',
								'window'		=> 0,
								'groups'		=> '4,5',
								'type'			=> constants::LIST_LINK,
							),
							array(
								'title'			=> $this->language->lang('P_ACP'),
								'description'	=> '',
								'url'			=> 'adm/index.php',
								'image'			=> 'fa-cogs',
								'window'		=> 0,
								'groups'		=> '5',
								'type'			=> constants::LIST_LINK,
							)
						)
					)),
					'block_alias'		=> 'menu_block',
					'block_icon'		=> 'fa-home',
					'block_order'		=> 1,
					'block_position'	=> 1,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),

				array(
					'block_title'		=> $this->language->lang(array('blocks', 'clock_title')),
					'block_content'		=> 'tri_amber.swf',
					'block_alias'		=> 'clock_block',
					'block_icon'		=> 'fa-clock-o',
					'block_order'		=> 2,
					'block_position'	=> 1,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'link_us_title')),
					'block_content'		=> serialize(array('banner_url' => './banners/canidev-banner.png')),
					'block_alias'		=> 'link_us_block',
					'block_icon'		=> 'fa-link',
					'block_order'		=> 3,
					'block_position'	=> 1,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'welcome_title')),
					'block_content'		=> serialize(array(
						'guest_text'	=> htmlspecialchars($this->language->lang('WELCOME_GUEST'), ENT_COMPAT, 'UTF-8'),
						'member_text'	=> htmlspecialchars($this->language->lang('WELCOME_MEMBER'), ENT_COMPAT, 'UTF-8'),
					)),
					'block_alias'		=> 'welcome_block',
					'block_icon'		=> 'fa-flag',
					'block_order'		=> 1,
					'block_position'	=> 2,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'dockmenu_title')),
					'block_content'		=> serialize(array(
						'item_width'	=> 40,
						'list' => array(
							array(
								'title'			=> $this->language->lang('PORTAL'),
								'url'			=> 'portal',
								'image'			=> './icons/home.png',
								'window'		=> 0,
								'groups'		=> 'all',
							),
							array(
								'title'			=> $this->language->lang('INDEX'),
								'url'			=> 'index.php',
								'image'			=> './icons/documents.png',
								'window'		=> 0,
								'groups'		=> 'all',
							),
							array(
								'title'			=> $this->language->lang('FAQ'),
								'url'			=> 'faq.php',
								'image'			=> './icons/float.png',
								'window'		=> 0,
								'groups'		=> 'all',
							),
							array(
								'title'			=> $this->language->lang('SEARCH'),
								'url'			=> 'search.php',
								'image'			=> './icons/box.png',
								'window'		=> 0,
								'groups'		=> 'all',
							)
						)
					)),
					'block_alias'		=> 'dockmenu_block',
					'block_icon'		=> 'fa-globe',
					'block_order'		=> 2,
					'block_position'	=> 2,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'recent_topics_title')),
					'block_content'		=> serialize(array(
						'topic_limit' 	=> 5,
						'title_limit' 	=> 50,
						'forums'		=> []
					)),
					'block_alias'		=> 'recent_topics_block',
					'block_icon'		=> 'fa-comment',
					'block_order'		=> 3,
					'block_position'	=> 2,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'whos_online_title')),
					'block_content'		=> serialize(array('advanced' => 1, 'usernames' => 1)),
					'block_alias'		=> 'whos_online_block',
					'block_icon'		=> 'fa-user',
					'block_order'		=> 4,
					'block_position'	=> 2,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'login_title')),
					'block_content'		=> serialize(array('full_login' => 1, 'show_register' => 1)),
					'block_alias'		=> 'login_block',
					'block_icon'		=> 'fa-user',
					'block_order'		=> 1,
					'block_position'	=> 3,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'stats_title')),
					'block_content'		=> serialize(array('stats_inline' => 0, 'user_stats' => 1)),
					'block_alias'		=> 'stats_block',
					'block_icon'		=> 'fa-bar-chart',
					'block_order'		=> 2,
					'block_position'	=> 3,
					'block_page'		=> 1,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> 'FORUM',
					'block_content'		=> '',
					'block_alias'		=> 'forum_content',
					'block_icon'		=> '',
					'block_order'		=> 1,
					'block_position'	=> 2,
					'block_page'		=> 2,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
				array(
					'block_title'		=> $this->language->lang(array('blocks', 'most_poster_title')),
					'block_content'		=> serialize(array('poster_limit' => 5, 'poster_range' => 'none')),
					'block_alias'		=> 'most_poster_block',
					'block_icon'		=> 'fa-edit',
					'block_order'		=> 1,
					'block_position'	=> 3,
					'block_page'		=> 2,
					'block_groups'		=> 'all',
					'bbcode_bitfield'	=> '',
					'bbcode_uid'		=> '',
				),
			)
		);
		
		foreach($sql_ary as $table => $rows)
		{
			$this->db->sql_multi_insert($table, $rows);
		}
	}
}
