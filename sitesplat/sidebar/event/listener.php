<?php
/**
*
* @package BBSidebar
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\sidebar\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Detection\MobileDetect;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	protected $manager;
	protected $user;
	protected $request;
	protected $config_text;
	protected $helper;
	protected $template;
	protected $config;
	protected $root_path;
	protected $php_ext;

	public function __construct(\sitesplat\sidebar\types\manager $manager, \phpbb\user $user, \phpbb\request\request $request, \phpbb\config\db_text $config_text, \phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\config\config $config, $phpbb_root_path, $php_ext)
	{
		$this->manager = $manager;
		$this->user = $user;
		$this->request = $request;
		$this->config_text = $config_text;
		$this->helper = $helper;
		$this->template = $template;
		$this->config = $config;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header' => 'common_setup',
		);
	}

	public function common_setup($event)
	{
		$sidebar_config = json_decode($this->config['sidebar_settings'], true);
				
		$page = str_replace('.' . $this->php_ext, '', $this->user->page['page_name']);

		$show_page = (!$sidebar_config['all_pages']) ? (($sidebar_config['panel_pages']) ? !in_array($page, array('ucp', 'mcp')): true) : $page == 'index';
		$in_no_pages = (strpos($page, 'classifieds') === false && strpos($page, 'bbfront') === false && strpos($page, 'privacy') === false && strpos($page, 'bbchat') === false && strpos($page, 'galleries') === false && strpos($page, 'downloads') === false) ? false : true;
		
		if ($show_page && !$in_no_pages)
		{
			$this->request->enable_super_globals();
			$detect = new MobileDetect($_SERVER);
			$this->request->disable_super_globals();
			$isMobile = $detect->isMobile(); 
			$isTablet = $detect->isTablet(); 
	
			$this->user->add_lang_ext('sitesplat/sidebar', 'sidebar');
			$slot = array();
			for($i = 1; $i <= $sidebar_config['slots']; $i++)
			{
				$type_name = $this->manager->get_sidebar_type_name($this->config['sidebar_slot' . $i . '_active']);
				$type_name = !empty($type_name) ? $this->manager->get_sidebar_type_id($type_name) : null; 
				if (
					$type_name === null ||
					!$isTablet && !$isMobile && !empty($type_name) || 
					$isMobile && !substr($type_name['options'], 0, 1) || 
					$isTablet && !substr($type_name['options'], 1, 1)
					)
				{
					$slot[] = array('id' => $this->config['sidebar_slot' . $i . '_active'], 'pos' => $i);
				}
			}
			($sidebar_config['shuffle']) ? null : shuffle($slot);

			for ($i = 1; $i <= sizeof($slot); $i++)
			{
				$type_name = $this->manager->get_sidebar_type_name($slot[$i-1]['id']);
				$this->template->assign_block_vars('slot', array(
					'SIDEBAR_ID'	=> $i,
					'SIDEBAR_SLOT'	=> ($slot[$i-1]['id'] < 2) ? $slot[$i-1]['id'] :
										(($this->manager->is_enabled($type_name)) ? $this->manager->get_template($type_name) : ''),
					'SIDEBAR_TITLE'	=> ($slot[$i-1]['id'] == 1) ? $this->config['sidebar_slot' . ($slot[$i-1]['pos']) . '_title'] : '',
					'SIDEBAR_TEXT'	=> ($slot[$i-1]['id'] == 1) ? htmlspecialchars_decode($this->config_text->get('sidebar_slot' . ($slot[$i-1]['pos']) . '_text')) : '',
				));
				
				($this->manager->is_enabled($type_name) && $this->manager->is_enabled($type_name) && $slot[$i-1]['id'] > 1) ? 
					$this->manager->check_condition($type_name) : null;
			}
			
			$this->template->assign_vars(array(
				'S_SIDEBAR_TYPE'			=> !$sidebar_config['type'],
				'S_SIDEBAR_ALL_PAGES'		=> !$sidebar_config['all_pages'],
				'S_SIDEBAR_WIDTH'			=> !$sidebar_config['width'],
				'S_SIDEBAR_DYNAMIC'			=> !$sidebar_config['height'],
			));
		}
	} 
}
