<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\controller;

use Symfony\Component\DependencyInjection\Container;

/**
 * Admin controller
 */
class admin_controller implements admin_interface
{
	protected $config;
	protected $config_text;
	protected $db;
	protected $phpbb_container;
	protected $manager;
	protected $request;
	protected $template;
	protected $user;
	protected $cache;
	protected $phpbb_root_path;
	protected $u_action;
	protected $sidebar_table;

	public function __construct(\phpbb\config\config $config, \phpbb\config\db_text $config_text, \phpbb\db\driver\driver_interface $db, Container $phpbb_container, \sitesplat\sidebar\types\manager $manager, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, \phpbb\cache\driver\driver_interface $cache, $phpbb_root_path, $sidebar_table)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->db = $db;
		$this->phpbb_container = $phpbb_container;
		$this->manager = $manager;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->cache = $cache;
		$this->root_path = $phpbb_root_path;
		$this->sidebar_table = $sidebar_table;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function check_ext()
	{
		$ext_manager = $this->phpbb_container->get('ext.manager');
		$cookie = $this->request->variable($this->config['cookie_name'] . '_sidebar', '', true, \phpbb\request\request_interface::COOKIE);
		$this->template->assign_vars(array(
			'S_NOTICE_LIKEDD'		=> (!$ext_manager->is_enabled('sitesplat/likedd') && !$cookie) ? $this->user->lang['NOTICE_LIKEDD'] : '',
			'S_NOTICE_BBREACTION'	=> (!$ext_manager->is_enabled('sitesplat/bbreaction') && !$cookie) ? $this->user->lang['NOTICE_BBREACTION'] : '',
			'S_NOTICE_BBDONATION'	=> (!$ext_manager->is_enabled('sitesplat/donations') && !$cookie) ? $this->user->lang['NOTICE_BBDONATION'] : '',
			'S_NOTICE_BBMEMBERSHIP'	=> (!$ext_manager->is_enabled('sitesplat/bbmembership') && !$cookie) ? $this->user->lang['NOTICE_BBMEMBERSHIP'] : '',
			'S_NOTICE_BADGE'	    => (!$ext_manager->is_enabled('sitesplat/badge') && !$cookie) ? $this->user->lang['NOTICE_BADGE'] : '',
			'S_NOTICE_BBPOINTS'	    => (!$ext_manager->is_enabled('sitesplat/bbpoints') && !$cookie) ? $this->user->lang['NOTICE_BBPOINTS'] : '',
			'S_NOTICE_NEWSLETTER'	=> (!$ext_manager->is_enabled('sitesplat/exportemailsandsubscribers') && !$cookie) ? $this->user->lang['NOTICE_NEWSLETTER'] : '',
			'S_NOTICE_BBDOWNLOAD'	=> (!$ext_manager->is_enabled('sitesplat/bbdownloads') && !$cookie) ? $this->user->lang['NOTICE_BBDOWNLOAD'] : '',
			
			'U_BADGE_NOTICE_CLOSE'	=> "{$this->u_action}&amp;hash=" . generate_link_hash('close_notice')
		));
	}

	/**
	* Dynamic Sidebar Close Notice
	*
	* @return null
	* @access public
	*/
	public function close_notice()
	{
		$response = $this->set_close_notice_cookie();

		// Send a JSON response if an AJAX request was used
		if ($this->request->is_ajax())
		{
			$json_response = new \phpbb\json_response;
			$json_response->send(array(
				'success' => $response,
			));
		}
		exit();
	}

	/**
	* Set a cookie to keep an notice closed
	*
	* @return bool True
	* @access protected
	*/
	protected function set_close_notice_cookie()
	{
		// Store the close_notice in a cookie with a 1 year expiration
		$this->user->set_cookie('sidebar', 'sidebar_notice_closed', time() + 31536000);

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function display_sidebars()
	{
		if (check_link_hash($this->request->variable('hash', ''), 'close_notice'))
		{
			$this->close_notice();
		}

		$sidebar_config = json_decode($this->config['sidebar_settings'], true);
		if ($this->request->is_set_post('update'))
		{
			if (!check_form_key('acp_sidebar'))
			{
				trigger_error('FORM_INVALID');
			} else
			{
				 $this->submit_sidebar_options();
			}
		}
		
		$ext_manager = $this->phpbb_container->get('ext.manager');
		($ext_manager->is_enabled('sitesplat/BBCore')) ? $this->check_ext() : null;
		$types  = $type_ids = $this->manager->get_sidebar_type_ids();
		
		array_walk($type_ids, function(&$value, $key, $return) {
			$value = $value[$return];
		}, 'id');

		$this->user->add_lang_ext('sitesplat/sidebar', 'info_acp_sidebar');
		$this->page_title = $this->user->lang['ACP_SIDEBAR_TITLE'];
		add_form_key('acp_sidebar');

		for ($i = 1; $i <= $sidebar_config['slots']; $i++)
		{
			$sidebar_select[] = $this->config['sidebar_slot' . $i . '_active'];
		}
		$sidebar_select = array_unique($sidebar_select);
		$active_slots = array(0 => '-----',  1 => 'Custom');
		$active_slots = $active_slots + array_flip($type_ids);
		for ($i = 1; $i <= $sidebar_config['slots']; $i++)
		{
			${"active_slot$i"} = '';
			foreach($active_slots as $key => $value)
			{
				$selected = ($key == $this->config['sidebar_slot' . $i . '_active']) ? ' selected="selected"' : '';
				$disabled = ($key > 1 && in_array($key, $sidebar_select)) ? ' disabled="disabled"' : '';
				${"active_slot$i"} .= '<option value="' . $key . '"' . $selected .  (($key > 1) ? $disabled : ''). '>'. $value . '</option>';
				
				($key == $this->config['sidebar_slot' . $i . '_active']) ? (${"option$i"} = (isset($types[$value])) ? $types[$value]['options']: '00') : null;
				$options[$key] = (isset($types[$value])) ? $types[$value]['options']: '00';
			}
		}

		$this->template->assign_vars(array(
			'SIDEBAR_TYPE'			=> ($sidebar_config['type']) ? ' checked="checked"' : '',
			'SIDEBAR_WIDTH'			=> ($sidebar_config['width']) ? ' checked="checked"' : '',
			'SIDEBAR_HEIGHT'		=> ($sidebar_config['height']) ? ' checked="checked"' : '',
			'SIDEBAR_ALL_PAGES'		=> ($sidebar_config['all_pages']) ? ' checked="checked"' : '',
			'SIDEBAR_PANEL_PAGES'	=> ($sidebar_config['panel_pages']) ? ' checked="checked"' : '',
			'SIDEBAR_SHUFFLE'		=> ($sidebar_config['shuffle']) ? ' checked="checked"' : '',
			'SLOTS'					=> $sidebar_config['slots'],
			'HOWMANY'				=> $sidebar_config['how_many'],
			'IGNORE_INACTIVE'		=> ($sidebar_config['ignore_inactive_users']) ? ' checked="checked"' : '',
			'IGNORE_FOUNDER'		=> ($sidebar_config['ignore_founder']) ? ' checked="checked"' : '',
			'IGNORE_ADMINS_MODS'	=> ($sidebar_config['ignore_admins_mods']) ? ' checked="checked"' : '',
			'OPTION_ARY'			=> json_encode($options),
			'U_ACTION'				=> $this->u_action
		));
			
		for ($i = 1; $i <= $sidebar_config['slots']; $i++)
		{
			$this->template->assign_block_vars('slots', array(
				'ID'				=> $i,
				'ACTIVE_SLOT'		=> ${"active_slot$i"},
				'SHOW_MOBILE'		=> (isset(${"option$i"}) && substr(${"option$i"}, 0,1)) ? ' checked="checked"' : '',
				'SHOW_TABLET'		=> (isset(${"option$i"}) && substr(${"option$i"}, 1,1)) ? ' checked="checked"' : '',
				'VISIBILTY_SLOT'	=> ($this->config['sidebar_slot' . $i . '_active'] && $this->config['sidebar_slot' . $i . '_active'] < 2) ? 'block' : 'none',
				'OPTION_SLOT'		=> (isset($options[$this->config['sidebar_slot' . $i . '_active']]) && $this->config['sidebar_slot' . $i . '_active'] > 1) ? 'block' : 'none',
				'SIDEBAR_TITLE'		=> $this->config['sidebar_slot' . $i . '_title'],
				'SIDEBAR_TEXT'		=> $this->config_text->get('sidebar_slot' . $i . '_text')
			));
		}
	}

	/**
	 * Submit sidebar form data
	 *
	 * @return null
	 * @access protected
	 */
	protected function submit_sidebar_options($update_slots = 0)
	{
		$this->config->set('sidebar_settings', json_encode(array(
			'type'					=> $this->request->variable('type', 0),
			'width'					=> $this->request->variable('width', 0),
			'height'				=> $this->request->variable('height', 0),
			'all_pages'				=> $this->request->variable('all_pages', 0),
			'panel_pages'			=> $this->request->variable('panel_pages', 0),
			'shuffle'				=> $this->request->variable('shuffle', 0),
		
			'slots'					=> $this->request->variable('slots', 1),
			'how_many'				=> $this->request->variable('how_many', 10),
			'ignore_inactive_users'	=> $this->request->variable('ignore_inactive_users', 0),
			'ignore_founder'		=> $this->request->variable('ignore_founder', 0),
			'ignore_admins_mods'	=> $this->request->variable('ignore_admins_mods', 0),
		)));

		$sidebar = $this->request->variable('sidebar', array('' => array('' => '')),true);
		$options = $this->request->variable('options', array('' => array('' => '')));
		foreach($sidebar as $key => $value)
		{
			$this->config->set('sidebar_' . $key . '_active', $value['_active']);
			$this->config->set('sidebar_' . $key . '_title', $value['_title']);
			$this->config_text->set('sidebar_' . $key . '_text', $value['_text']);
			$option = (isset($options[$key]['_mobile']) ? $options[$key]['_mobile'] : 0) .  (isset($options[$key]['_tablet']) ? $options[$key]['_tablet'] : 0);
			
			$sql = 'UPDATE ' . $this->sidebar_table . ' SET sidebar_options = "' . $option . '" WHERE sidebar_type_id = ' . $value['_active'];
			$this->db->sql_query($sql);
		}
		$this->cache->destroy('_sidebar_type_ids');
		meta_refresh(3, $this->u_action);
		trigger_error($this->user->lang['ACP_SIDEBAR_SAVED'] . adm_back_link($this->u_action));
	}

	/**
	 * {@inheritdoc}
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
