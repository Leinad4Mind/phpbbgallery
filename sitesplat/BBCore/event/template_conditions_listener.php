<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\event;

class template_conditions_listener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface 
{
	protected $helper;
	public function __construct(\phpbb\template\template $template)
	{
		$this->template = $template;
	}
	
	static public function getSubscribedEvents()
	{
		return array(
			'core.index_modify_page_title'				=> 'in_index',
			'core.modify_mcp_modules_display_option'	=> 'in_mcp',
			'core.modify_mcp_modules_display_option'	=> 'in_memberlist',
			'core.posting_modify_template_vars'			=> 'in_posting',
			'core.search_modify_forum_select_list'		=> 'in_search',
			'core.ucp_display_module_before'			=> 'in_ucp',
			'core.viewforum_generate_page_after'		=> 'in_viewforum',
			'core.viewonline_modify_sql'				=> 'in_viewonline',
			'core.viewtopic_modify_page_title'			=> 'in_viewtopic',
		);
	}

	public function in_index()
	{
		$this->template->assign_var('BB_LOAD_IN_INDEX', true);
	}

	public function in_mcp()
	{
		$this->template->assign_var('BB_LOAD_IN_MCP', true);
	}

	public function in_memberlist()
	{
		$this->template->assign_var('BB_LOAD_IN_MEMBERLIST', true);
	}

	public function in_posting()
	{
		$this->template->assign_var('BB_LOAD_IN_POSTING', true);
	}

	public function in_search()
	{
		$this->template->assign_var('BB_LOAD_IN_SEARCH', true);
	}

	public function in_ucp()
	{
		$this->template->assign_var('BB_LOAD_IN_UCP', true);
	}

	public function in_viewforum()
	{
		$this->template->assign_var('BB_LOAD_IN_VIEWFORUM', true);
	}

	public function in_viewonline()
	{
		$this->template->assign_var('BB_LOAD_IN_VIEWONLINE', true);
	}

	public function in_viewtopic()
	{
		$this->template->assign_var('BB_LOAD_IN_VIEWTOPIC', true);
	}
}
